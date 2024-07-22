<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OffersCardResource;
use App\Http\Resources\Front\CartResource;
use App\Models\Admin\OfferCard;
use App\Models\Admin\Offers;
use App\Models\Admin\Product;
use App\Models\Front\Card;
use App\Models\Front\CardItem;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    use ResponseTrait;
    // store cart

    public function store(Request $request){
       
        try{
           
            // transaction
            DB::beginTransaction();

            // validate product want to add to cart
            $request->validate([
                'product_id'=>"required|integer",
               
            ]);

            // get user data from request 
            $user = $request->user();  
             // chec if user has already cart before or not and get product object from id  
            $cart = Card::where('user_id' , $user->id)->first();   
            $product = Product::findOrFail($request->product_id); 
            
            // check if has cart or not  
            if(is_null($cart)){
                // create new cart 
              $cart = new Card();
              $cart->user_id = $user->id;
              $cart->save();
              // store item or product to cart item
              $this->storeCartItem($cart , $product);
              
            }else{
                  // if has cart check if has product in cart_item
                $this->checkItemProduct($cart , $product);
            }

            DB::commit();
            return  $this->res(true ,'Added To Cart ' , 200);
                 

        }catch(\Exception $e){
            DB::rollBack();
            return  $this->res(false ,$e->getMessage() , $e->getCode());
        }

    } // end function add cart


    // add cart item 
    public function storeCartItem($cart , $product){
        $card_item = new CardItem();
        $card_item->card_id = $cart->id;
        $card_item->product_id = $product->id;
        $card_item->quantity   = 1;
        $card_item->total_price = $product->price;
        $card_item->save();
        return true;
    }


    // check if product in cart item 
    public function checkItemProduct($cart , $product){
        $card_item = CardItem::where('card_id' , $cart->id)->where('product_id' , $product->id)->first();
        
        if(isset($card_item) && $card_item != null){
         
            $card_item->quantity    = $card_item->quantity  + 1;
            $card_item->total_price = ( $card_item->quantity  + 1 ) * $product->price;
            $card_item->save();
            
        }else{
            $this->storeCartItem($cart , $product);
        }
        return true;

    }




    // update cart
    public function update(Request $request){


        try{
            $request->validate([
                'product_id'=>'required|integer',
                'type'=>'required|in:increase,decrease',
                'quantity'=>'required|integer'
            ]);
            DB::beginTransaction();
            $user = $request->user();  
            $cart = Card::where('user_id' , $user->id)->first();   
            $cartItem = CardItem::where('card_id' , $cart->id)->where('product_id' , $request->product_id)->first();
            $product = Product::findOrFail($request->product_id);
            if(isset($cart) && isset($cartItem)){
                if($request->type == 'increase'){
                    $cartItem->quantity     = $cartItem->quantity + $request->quantity;
                    $cartItem->total_price =  $cartItem->total_price +  ($cartItem->quantity * $product->price);
                    $cartItem->save();
                    DB::commit();
                    return  $this->res(true ,'Cart Updated Succeffuly !' , 200);

                }else{
                    
                    if($cartItem->quantity >= $request->quantity){
                    
                        $cartItem->quantity     = $cartItem->quantity - $request->quantity;
                        $cartItem->total_price  =  $cartItem->total_price -  ($request->quantity * $product->price);
                        $cartItem->save();
                        if($cartItem->quantity <= 0){
                            $cartItem->delete();
                        }
                        DB::commit();
                        return  $this->res(true ,'Cart Updated Succeffuly !' , 200);
                    }
                
                    return  $this->res(false ,'More Than Quantity' , 402);
                }

            }
            return  $this->res(false ,'Has Not Cart' , 404);
           

        }catch(\Exception $e){
            DB::rollBack();
            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());
        }




    }


    // deelte cart 
    public function delete(Request $request){
        try{ 
            DB::beginTransaction();
            $user = $request->user();
            $cart = Card::where('user_id' , $user->id)->first();
            if(isset($cart)){
                $cart->delete();
                DB::commit();
            }

            return  $this->res(true ,'Cart Deleted Succeffuly !' , 200);     

          }catch(\Exception $e){
            DB::rollBack();
            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());
        }
    }


    public function delete_item(Request $request){
        $request->validate([
            'product_id'=>'required|integer'
        ]);
        try{ 
            DB::beginTransaction();
            $user = $request->user();
            $cart = Card::where('user_id' , $user->id)->first();
            $cartItem = CardItem::where('card_id' , $cart->id)->where('product_id' , $request->product_id)->first();
            if(isset($cartItem)){
                $cartItem->delete();
                DB::commit();
            }
            return  $this->res(true ,'Cart Item Deleted Succeffuly !' , 200);     

          }catch(\Exception $e){
            DB::rollBack();
            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());
        }
    } // end function delete item 





    // get cart with token of special user
    public function get(Request $request) {
        try{
            $user = $request->user();
            $cart = Card::with('items')->where('user_id' , $user->id)->first(); 
            return  $this->res(true ,'Added To Cart ' , 200 , new CartResource($cart));

        }catch(\Exception $e){

            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());

        }
    }


    // add offer to cart offer 
    public function add_card_offer(Request $request){
       
        $request->validate([
            'offer_id'=>'required|integer',
        ]);
      

        try{
            $user = $request->user();
            $offer = Offers::findOrFail($request->offer_id);
            DB::beginTransaction();
            $offer_card = OfferCard::where('user_id' , $user->id)->where('offer_id' , $request->offer_id)->first();
            if(isset($offer_card) && $offer_card != null){
                return  $this->res(false ,'Already Take Offer' , 400);
            }

            $offer_card = new OfferCard();
            $offer_card->user_id = $user->id;
            $offer_card->offer_id = $request->offer_id;
            $offer_card->save();
            DB::commit();
            return  $this->res(true ,'Offer Added Successfully !' , 200);
        
        }catch(\Exception $e){

            DB::rollBack();
            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());

        }


    } // end add offer to cart

    // delete offer cart

    public function offer_cart_delete(Request $request){

      

        try{
            $request->validate([
                'offer_id'=>'required|integer',
            ]);
            $user = $request->user();
            $offer = Offers::findOrFail($request->offer_id);
            DB::beginTransaction();
            $offer_card = OfferCard::where('user_id' , $user->id)->where('offer_id' , $request->offer_id)->first();
            if(isset($offer_card) && $offer_card != null){
               $offer_card->delete();
               DB::commit();
               return  $this->res(true ,'Offer Deleted Successfully !' , 200);

            }
            return  $this->res(false ,'No Offer To Deleted' , 404);
        
        }catch(\Exception $e){

            DB::rollBack();
            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());

        }
    }


    // get offer cart 

    public function offer_cart_get(Request $request)
    {

        try{

            $user = $request->user();
            $offer_card = OfferCard::with('offer.offer_products')->where('user_id' , $user->id)->get();
            $offers = $offer_card->pluck(['offer']);
           // dd($offers);
            return  $this->res(true ,'Offer Carts ' , 200 ,  OffersCardResource::collection($offers));


        }catch(\Exception $e){

           
            return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());

        }

    } // end get cart offer 




    







}
