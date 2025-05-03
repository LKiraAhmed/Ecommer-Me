<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddReviewController extends Controller
{
    //
    public function add(Request $request){
        try{
            $validate=Validator::make($request->all(),[
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'rating' => 'required|numeric|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);            
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        
        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return response()->json(['message' => 'Review added successfully', 'data' => $review], 201);


        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
