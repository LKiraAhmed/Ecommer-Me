<?php

namespace App\Http\Controllers\Wishlist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Wishlist;
use Exception;
class ShowWishlistController extends Controller
{
    //
    public function show(){
        try{
            $wishlist = Wishlist::with('product')->where('user_id', auth()->id())->get();
            return response()->json(['wishlist' => $wishlist]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
