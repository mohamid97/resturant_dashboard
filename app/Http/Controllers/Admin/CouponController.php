<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Coupon;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CouponController extends Controller
{
    public $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
        
    }
    // add new coupon
    public function add(){
        return view('admin.coupon.add' , ['langs'=> $this->langs]);
    } // end add function redirect to add blade coupon

    public function edit(){
      $mohamed = 1;
    }

    public function store(Request $request){



    } // end store function 


    public function update(Request $request){

    } // end update function 


    public function destroy($id)
    {
        $Coupon = Coupon::findOrFail($id);
        $Coupon->forceDelete();
        Alert::success('success', 'Coupon Deleted Successfully !');
        return redirect()->route('admin.coupons.index');
    }

    public function soft_delete($id)
    {
        $Coupon = Coupon::findOrFail($id);
        $Coupon->delete();
        Alert::success('success', 'Coupon Soft Deleted Successfully !');
        return redirect()->route('admin.coupons.index');

    }

    public function restore($id)
    {
        $Coupon = Coupon::withTrashed()->findOrFail($id);
        $Coupon->restore();
        Alert::success('success', 'Coupon Restored Successfully !');
        return redirect()->route('admin.coupons.index');

    }



}
