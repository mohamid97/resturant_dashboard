<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\citiy;
use App\Models\Front\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    // get all orders of users
    public function get(){
        $orders = Order::with(['user' , 'items.product'])->latest()->paginate(10);
        return view('admin.orders.index' , ['orders' => $orders]);
    }


    // order must be in pending to can delete it 
    public function delete($id){
        try{
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            if($order->status == 'pending'){
                $order->delete();
                DB::commit();
                Alert::success('Success', 'Order Created Successfully ! !');
                return redirect()->route('admin.orders.index');
            }
            Alert::success('Error', 'Can not Delete This Order Now !');
            return redirect()->route('admin.orders.index');
        }catch(\Exception $e){
            DB::rollBack();
            Alert::success('Error', $e->getMessage() , $e->getCode());
            return redirect()->route('admin.orders.index');
            
        }



    } // end function delete order 


    public function show_details($id){
        $order = Order::with(['user' , 'items.product.gallery'])->findOrFail($id);

        $totalPrice = $order->items->sum(function ($item) {
            return $item->quantity *  $item->product->price;
          });


          $totla_quantity = $order->items->sum(function ($item) {
            return $item->quantity;
          });

          $order_city_price = citiy::with('price')->findOrFail($order->shipping_city_id); 

          return view('admin.orders.details' , ['order'=>$order , 'total_price'=>$totalPrice , 'total_quantity'=>$totla_quantity , 'order_city_price'=>$order_city_price]);


    }


    //edit status view
    public function edit_status($id){
        $order = Order::findOrFail($id);
        return view('admin.orders.edit_status' , ['order'=>$order]);

    }

    // update status 
    public function update_status($id , Request $request){
        
        try{
            $request->validate([
                 'status' => 'required|in:pending,proceed,on way,finshed,canceled',
                 'payment_status'=>'required|in:unpaid,paid'
            ]);
            $order = Order::findOrFail($id);
            DB::beginTransaction();
            $order->status = $request->status;
            $order->payment_status = $request->payment_status;
            $order->save();
            DB::commit();
            Alert::success('Success', 'Order Status Updated Successfully ! !');
            return redirect()->route('admin.orders.index');
        }catch(\Exception $e){
            DB::rollBack();
            Alert::success('Error', $e->getMessage() , $e->getCode());
            return redirect()->route('admin.orders.index');
            
        }

    } // end edit status

}
