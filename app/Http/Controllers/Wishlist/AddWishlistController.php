<?php

namespace App\Http\Controllers\Wishlist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Wishlist;
use Exception;
class AddWishlistController extends Controller
{
    //
    public function addToWishlist(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
                'product_id' => 'required|exists:products,id',
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }

            $exists=Wishlist::where('user_id',auth()->id())->where('product_id',$request->product_id)->exists();
            if(!$exists){
                return response()->json(['message' => 'Product already in wishlist']);
            }
            $wishlist=Wishlist::create([
                'user_id'=>auth()->id(),
                'product_id'=>$request->product_id
            ]);
            return response()->json(['message' => 'Product added to wishlist', 'wishlist' => $wishlist]);    
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
