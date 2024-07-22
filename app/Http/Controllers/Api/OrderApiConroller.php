<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\OrdersResource;
use App\Models\Admin\OfferCard;
use App\Models\Admin\Offers;
use App\Models\Admin\Product;
use App\Models\Front\Card;
use App\Models\Front\Order;
use App\Models\Front\OrderItem;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderApiConroller extends Controller
{

    use ResponseTrait;
    //
    public function store(Request $request){
        try{
           $request->validate([
            'city_shpping_id'=>'required|integer'
           ]);
            DB::beginTransaction();
            $user = $request->user();  
            $cart = Card::with('items')->where('user_id' , $user->id)->first(); 
            $offer_card = OfferCard::where('user_id' , $user->id)->get();
            $total_price = 0;

            // check if is set card
            if(isset($cart) && $cart != null){
               // loop card to get products total price    
               foreach($cart->items as $items){
                $product = Product::findOrFail($items->product_id);
                $total_price += $product->price * $items->quantity;
               }


            } // end check





            // check if is set card offer
            if(isset($offer_card) && $offer_card != null){

                // loop offer card to get products total price    
                foreach($offer_card as $of_cart){
                    $offer = Offers::findOrFail($of_cart->offer_id);
                    $total_price += $offer->price;
                  
                }
                
                
             } // end check

            $order = New  Order();
            $order->user_id = $user->id;
            $order->total_price = $total_price;
            $order->shipping_city_id = $request->city_shpping_id;
            $order->status = 'pending';
            $order->save();

            if($this->store_cart_to_order_details($order, $cart) && $this->store_offer_cart_to_order_detsils($order ,$offer_card)){
                $cart->delete();
                foreach($offer_card as $of_card){
                    $of_card->delete();
                }
            
                DB::commit();
                return  $this->res(true ,'Order Created Successfully! ' , 200);
            }





            DB::rollBack();
            return  $this->res(false ,'Has No Cart Or Error Happend When Trying To Create Order' , 404);

                 

        }catch(\Exception $e){
            DB::rollBack();
            return  $this->res(false ,$e->getMessage() , $e->getCode() , $e->getMessage());
        }
    }// end store function 




    // store card at order details 

    public function store_cart_to_order_details($order, $cart){

                // loop card to get products total price    
                foreach($cart->items as $items){
                    $product = Product::findOrFail($items->product_id);
                    // add order details data
                    $order_details = new OrderItem();
                    $order_details->order_id = $order->id;
                    $order_details->product_id = $items->product_id;
                    $order_details->quantity = $items->quantity;
                    $order_details->price    =    $product->price * $items->quantity;
                    $order_details->type     = 'normal';
                    $order_details->save();

                }

                return true;

    } // end store cart at order details



    // store offer cart to order details 
    public function store_offer_cart_to_order_detsils($order,$offer_carts ){

        foreach($offer_carts as $of_cart){
            $offer = Offers::findOrFail($of_cart->offer_id);
            $order_details = new OrderItem();
            $order_details->order_id = $order->id;
            $order_details->quantity = 0;
            $order_details->price    =    $offer->price;
            $order_details->type     = 'offer';
            $order_details->offer_id = $offer->id;
            $order_details->save();
            
          
        }


        return true;

    }// end store offer cart to order details 







    // get orders of sepecial users
    public function get(Request $request){

        $user = $request->user();
        $orders = Order::with(['items' , 'user'])->where('user_id' ,  $user->id)->get();
        return  $this->res(true ,'Get Order Details!' , 200 , OrdersResource::collection($orders));
        
   
    }




 }
