<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OffersCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this->offer_products->pluck('id'));
       return [
        'id'=>$this->id,
        'title'=>$this->title,
        'small_des'=>$this->small_des,
        'des'=>$this->des,
        'image_path'=>asset('/uploads/images/offers/'),
        'image'=>$this->image,
        'price'=>$this->price,
        'old_price'=>$this->old_price,
        'offer_products'=>ProductResource::collection(Product::whereIn('id' , $this->offer_products->pluck('id'))->get())
       ];
    }
}
