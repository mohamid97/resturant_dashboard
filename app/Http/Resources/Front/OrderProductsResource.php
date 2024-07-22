<?php

namespace App\Http\Resources\Front;

use App\Models\Admin\Offers;
use App\Models\Admin\Product;
use App\Models\Front\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
     
        if($this->type == 'normal' && !isset($this->offer_id)){

            $pro = Product::whereHas('translations', function ($query)  {
                $query->where('locale', '=', app()->getLocale());
            })->where('id' , $this->product_id)->first();
       
                return [
                    'product_name'=> $pro->name,
                    'quantity'=>$this->quantity,
                    'price'=>$this->price,
                    'type'=>'normal',
                    'slug'=>$pro->slug
                ];

        }else{

                $offer = Offers::with('offer_products')->findOrFail($this->offer_id);
                $productIds = $offer->offer_products->pluck('product_id');
                $products = Product::whereIn('id', $productIds)->get();
               
                return [
                    'type'=>'offer',
                    'offer_name'=>$offer->title,
                    'small_des'=>$offer->small_des,
                    'des'=>$offer->small_des,
                    'products'=>$products

                ];
            
            
            

        }








    }









}
