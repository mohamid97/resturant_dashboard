<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferCard extends Model
{
    use HasFactory;

    public function offer(){
        return  $this->belongsTo(Offers::class , 'offer_id');
    }
}
