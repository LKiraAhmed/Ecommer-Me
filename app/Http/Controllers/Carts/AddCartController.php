<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;

class AddCartController extends Controller
{
    //
    public function addcart(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }         
            $cart=Cart::where('user_id',auth()->id())->where('product_id',$request->product_id);
            if($cart){
                $cart->quantity += $request->quantity;
                $cart->save();
            }else{
                $cart=Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $request->product_id,
                    'quantity' => DB::raw("quantity + {$request->quantity}")
    
                ]);
            }
            $redis=Redis::connection();
            $userId=Auth::id();
            $cartsData=[
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'user_id'=>$userId
            ];
            $key='carts_adds_users'.$userId;
            $exitsCarts=json_decode($redis->get($key),true);
            if(!$exitsCarts){
                $exitsCarts=[];
            }
            $exitsCarts[] = $cartsData;
            $redis->set($key, json_encode($exitsCarts));

            return response()->json(['message' => 'Product added to cart', 'cart' => $cart]);

        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
