<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\citiy;
use App\Models\Admin\CitiyPrice;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Government extends Controller
{
    //
    public function get(){

        $locale = app()->getLocale();

        $cities = citiy::with(['price', 'gov' => function ($query) use ($locale) {
                $query->whereHas('translations', function ($subQuery) use ($locale) {
                    $subQuery->where('locale', '=', $locale);
                });
            }])
            ->whereHas('translations', function ($query) use ($locale) {
                $query->where('locale', '=', $locale);
            })
            ->latest()
            ->paginate(10);

        return view('admin.city_price.index', ['cities'=>$cities]);
    }

    // edit price of city
    public function edit_price($id){
       $city = citiy::with('price')->findOrFail($id);
       return view('admin.city_price.edit', ['city'=>$city]);
    }

    // update price 
    public function update_price($id , Request $request){
       
        $request->validate([
            'price'=>'required'
        ]);
        try{
            $city = citiy::with(['gov' , 'price'])->findOrFail($id);
            $city_price = CitiyPrice::where('citiy_id' , $city->id)->first();
    
            if(isset($city_price)){
                $city_price->price = $request->price;
            }else{
                $city_price = new CitiyPrice();
                $city_price->governorate_id = $city->gov->id;
                $city_price->citiy_id       = $city->id;
                $city_price->price          =  $request->price;
                
            }
            $city_price->save();
            Alert::success('Success', 'Price Added Successfully !');
            return redirect()->route('admin.city_price.index');
        }catch(\Exception $e){
            Alert::success('error', 'Canot Update Price !');
            return redirect()->route('admin.city_price.index');
        }



    }




}
