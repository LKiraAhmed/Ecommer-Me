<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EditReviewController extends Controller
{
    //

    public function edit(Request $request, $id)
    {
        try {
            $review = Review::find($id);
    
            if (!$review) {
                return response()->json(['error' => 'Review not found'], 404);
            }
    
            if ($review->user_id !== Auth::id()) {
                return response()->json(['error' => 'You are not authorized to edit this review'], 403);
            }
    
            $validate = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'rating' => 'required|numeric|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);
    
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
    
            // تحديث التقييم
            $review->update([
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
    
            return response()->json(['message' => 'Review updated successfully', 'data' => $review], 200);
    
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
