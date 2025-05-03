<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Exception;

class DeleteProductController extends Controller
{
    //
    public function destroy($id){
        try{
          $product=Product::find($id);
          if(!$product){
            return response()->json(['error' => 'Product not found'], 404);
          }  
          $product->delete();
          return response()->json(['message' => 'Product deleted successfully'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
