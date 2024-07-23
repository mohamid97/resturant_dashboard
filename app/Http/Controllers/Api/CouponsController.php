<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CouponsResource;
use App\Models\admin\Coupon;
use App\Models\admin\CouponUser;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    use ResponseTrait;


    //get all coupons
   public function get(){
        $coupons = Coupon::whereHas('translations', function ($query) {
            $query->where('locale', '=', app()->getLocale());
        })->get();
        return  $this->res(true ,'All Coupons ' , 200 ,CouponsResource::collection($coupons));
   }

   public function coupon_details(Request $request){
     try{
      $request->validate([
         'coupon_code'=>'required|string'
      ]);
        $user = $request->user();
        $coupon = Coupon::where('code', $request->coupon_code)->firstOrFail();
        $coupon_user = CouponUser::where('coupon_id' , $coupon->id)->where('user_id' , $user->id)->first();
        if(isset($coupon_user)){
          return  $this->res(true ,'Used Before' , 400);
        }

        return  $this->res(true ,'coupon details' , 200 ,new CouponsResource($coupon));

     }catch(\Exception $e){
        return  $this->res(false ,$e->getMessage() , $e->getCode());
     }

   } // end coupon details





}
