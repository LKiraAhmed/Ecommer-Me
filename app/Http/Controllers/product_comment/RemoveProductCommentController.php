<?php

namespace App\Http\Controllers\product_comment;

use App\Http\Controllers\Controller;
use App\Models\Product_Comment;
use Exception;
use Illuminate\Http\Request;

class RemoveProductCommentController extends Controller
{
    //
    public function destroy($id){
        try{
            $product_comment=Product_Comment::find($id);
            if(!$product_comment){
                return response()->json(['error' => 'Product_Comment not found'], 404);
            }
            $product_comment->delete();
            return response()->json(['message' => 'Product comment deleted successfully']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
