<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ShowCartController extends Controller
{
    //
    public function show(){
        try{
            $userId = auth()->id();
            $redis = Redis::connection();
            $cacheKey = 'cart_items_user_' . $userId;
            $cachedCart=Redis::get($cacheKey);
            if(!$cachedCart){
                $cachedCart=json_decode($cachedCart,true);
            }else{
                $cartItems =Cart::with('product')->where('user_id', auth()->id())->get();
                $redis->setex($cacheKey, 600, json_encode($cartItems));
            }
            return response()->json(['cart' => $cartItems]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
