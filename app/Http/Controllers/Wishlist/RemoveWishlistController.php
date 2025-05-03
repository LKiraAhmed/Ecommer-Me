<?php

namespace App\Http\Controllers\Wishlist;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;

class RemoveWishlistController extends Controller
{
    //
    public function destroy($id){
        try{
            $item=Wishlist::where('id',$id)->where('user_id',auth()->id())->first();
            if(!$item){
                return response()->json(['error' => 'Item not found'], 404);
            }
            $item->delete();
            return response()->json(['message' => 'Item removed from wishlist']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
