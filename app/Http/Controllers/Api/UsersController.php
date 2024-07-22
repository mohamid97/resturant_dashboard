<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserDetailsResource;
use App\Http\Resources\Admin\UsersResource;
use App\Models\User;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use ResponseTrait;
    public function get()
    {
        $users = User::all();
        return  $this->res(true ,'All Users' , 200 ,UsersResource::collection($users));
    }


    // login from api 

    public function Api_login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['false']);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    // get user details 
    public function user_details(Request $request){
        try{
            $request->validate([
                'user_id'=>'required|integer'
            ]);
            $user = User::findOrFail($request->user_id);
            if($user->type == 'admin'){
                return $this->res(false , 'Canot Get This User ( Un Authorized )' , 401 );
            }
            return  $this->res(true ,'user details' , 200 ,new UserDetailsResource($user));
        }catch(\Exception $e){
            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());

        }

    }  // end function get user details

    public function store(Request $request){
        try{
                $request->validate([
                    'first_name'=>'required|string|max:255',
                    'last_name'=>'required|string|max:255',
                    'avatar'=>'nullable|image',
                    'password'=>'required|string|min:6',
                    'email'=>'required|email|unique:users,email',
                ]);


                if($request->has('avatar')){
                    $image_name = $request->avatar->getClientOriginalName();
                    $request->avatar->move(public_path('uploads/images/users'), $image_name);    
                }

                DB::beginTransaction();
                    $user = new User();
                    $user->first_name = $request->first_name;
                    $user->last_name  = $request->last_name;
                    $user->password   = Hash::make($request->password);
                    $user->email      = $request->email;
                    $user->type       = 'user';
                    (isset($image_name) && $image_name != null) ? $user->avatar = $image_name : $user->avatar = null;
                    $user->save();              
                DB::commit();
                return  $this->res(true ,'All Users' , 200 ,new UserDetailsResource($user));

        }catch(\Exception $e){
            
                DB::rollBack();
                return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());

        }

    }
}
