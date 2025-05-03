<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ShowProductController extends Controller
{
    //
    public function show(Request $request){
        try{
            $page =$request->query('page',1);
            $perPage=10;
            $cacheKey="products_page_{$page}";
            $cachedProducts=Redis::get($cacheKey);
            if($cachedProducts){
                $products=json_decode($cachedProducts,true);
            }else{
                $products = Product::paginate($perPage);
                Redis::setex($cacheKey,600,json_encode($products));
            }
            return response()->json(['products' => $products], 200);
        }catch(Exception $e){
            return response()->json([
                'error' => 'Something went wrong!',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
