<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SearchController extends Controller
{
    //
    public function searchProduct(Request $request){
        try{
            $search = $request->input('search');
            $productsJson= Redis::get('products_add');
            if(!$productsJson ){
                $products = Product::all();
                Redis::setex('products_add', 3600, $products->toJson());
            }else{
                $productsArray = json_decode($productsJson, true);
                $products = collect($productsArray);
            }
            $results =$products->filter(function ($product) use ($search){
                return stripos($product['name'], $search) !== false;
            });
            if($results->isEmpty()){
                $results = Product::where('name', 'like', "%$search%")->get();
            }
            return response()->json($results->values(), 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500); 
        }
    }

}
