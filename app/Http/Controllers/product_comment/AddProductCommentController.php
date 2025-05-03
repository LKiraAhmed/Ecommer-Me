<?php

namespace App\Http\Controllers\product_comment;

use App\Http\Controllers\Controller;
use App\Models\Product_Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddProductCommentController extends Controller
{
    //
    public function add(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'product_id' => 'required|exists:products,id',
                'commemt'=>'required|string',
                'rating'=>'required'
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            
            $product_comment=Product_Comment::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'comment' => $request->comment,
                'rating' => $request->rating,
            ]);
            return response()->json([
                'message' => 'Comment added successfully',
                'comment' => $product_comment
            ]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
