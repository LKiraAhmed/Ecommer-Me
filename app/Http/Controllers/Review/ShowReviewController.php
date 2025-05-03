<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;

class ShowReviewController extends Controller
{
    //
    public function showAll(){
        try{
            $reviews = Review::with('user', 'product')->latest()->get();
            return response()->json(['reviews' => $reviews], 200);

        }catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    public function show($id){
        try{
            $review=Review::with('user','product')->find($id);
            if(!$review){
                return response()->json(['error' => 'Review not found'], 404);
            }
            return response()->json(['review' => $review], 200);

        }catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    public function productReviews($product_id){
        try{
            $reviews = Review::where('product_id', $product_id)->with('user')->latest()->get();
            return response()->json(['reviews' => $reviews], 200);
        }catch(Exception $e) {
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
