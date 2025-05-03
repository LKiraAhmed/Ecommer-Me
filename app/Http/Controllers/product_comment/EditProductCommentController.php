<?php

namespace App\Http\Controllers\product_comment;

use App\Http\Controllers\Controller;
use App\Models\Product_Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditProductCommentController extends Controller
{
    //
    public function update(Request $request,$id){
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
            $product_comment=Product_Comment::find($id);
            if(!$product_comment){
                return response()->json(['error' => 'Product comment not found'], 404);
            }   
            $product_comment->update([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'commemt' => $request->commemt,
                'rating' => $request->rating
            ]);
            return response()->json(['message' => 'Product comment updated successfully', 'comment' => $product_comment]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
