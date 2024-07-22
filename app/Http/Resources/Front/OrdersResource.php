<?php

namespace App\Http\Resources\Front;

use App\Models\Admin\CitiyPrice;
use App\Models\Admin\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        $city = CitiyPrice::where('citiy_id' , $this->shipping_city_id)->first();
   

        return [
            'status'=>$this->status,
            'total_price'=>$this->total_price,
            'shipping_cost'=>isset($city->price) ? $city->price : null,
            'products'=> OrderProductsResource::collection($this->items)
        ];
    }
}
