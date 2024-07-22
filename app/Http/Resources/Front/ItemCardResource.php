<?php

namespace App\Http\Resources\Front;

use App\Models\Admin\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = Product::findOrFail($this->product_id);
       return[
            'product_name'=>$product->name,
            'quantity'=> $this->quantity,
             'total_price'=>$this->quantity * $product->price,
       ];
    }
}
