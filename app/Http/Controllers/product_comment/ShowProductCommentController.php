<?php

namespace App\Http\Controllers\product_comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_Comment;

class ShowProductCommentController extends Controller
{
    //
    public function index(){
        $comments = Product_Comment::with('user', 'product')->get();
        return response()->json(['comments' => $comments]);
    }
    public function show($id){
        $comment=Product_Comment::with( 'user', 'product')->get();
        if (!$comment) {
            return response()->json(['error' => 'Product comment not found'], 404);
        }
        return response()->json(['comment' => $comment]);
    }
}
