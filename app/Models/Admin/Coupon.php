<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory , Translatable , SoftDeletes;
    protected $fillable = ['image' , 'code' , 'start_date' , 'end_date' , 'percentage'];
    public $translatedAttributes = ['des', 'name' , 'small_des'];
    public $translationForeignKey = 'coupon_id';
    public $translationModel = 'App\Models\Admin\CouponTranslation';
}
