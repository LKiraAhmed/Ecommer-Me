<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;

class EditCartController extends Controller
{
    //
    public function update(Request $request, $id){
        try{
            $validate = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1'
            ]);
    
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $cart=Cart::where('id',$id)->where('user_id',auth()->id())->first();
            if(!$cart){
                return response()->json(['error' => 'Cart item not found'], 404);
            }else{
                $cart->quantity = $request->quantity;
                $cart->save();
                return response()->json(['message' => 'Cart item updated', 'cart' => $cart]);
            }
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
