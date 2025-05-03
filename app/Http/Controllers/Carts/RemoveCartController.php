<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;

class RemoveCartController extends Controller
{
    //
    public function destroy($id){
        try{
            $cart = Cart::where('id', $id)->where('user_id', auth()->id())->first();
            if (!$cart) {
                return response()->json(['error' => 'Cart item not found'], 404);
            }
            $cart->delete();
            return response()->json(['message' => 'Cart item removed successfully']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
