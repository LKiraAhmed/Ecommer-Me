<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteReviewController extends Controller
{
    //
    public function destroy($id){
        try{
            $review=Review::find($id);
            if(!$review){
                return response()->json(['error' => 'Review not found'], 404);
            }
            if($review->user_id !== Auth::id()){
                return response()->json(['error' => 'You are not authorized to delete this review'], 403);
            }
            $review->delete();
            return response()->json(['message' => 'Review deleted successfully'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
