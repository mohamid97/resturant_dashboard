<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AllOffersReource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->name,
            'small_des'=>$this->small_des,
            'des'=>$this->des,
            'old_price'=>$this->old_price,
            'price'=>$this->price,
            'image'=>$this->image,
            'image_path'=>asset('uploads/images/offers'),
            
        ];
    }
}
