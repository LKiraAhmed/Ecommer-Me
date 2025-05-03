<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Redis;

class AddProductController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', 
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'status' => 'required|in:available,out_of_stock',
                'views' => 'nullable|integer|min:0',
                'rating' => 'nullable|numeric|min:0|max:5',
                'discount_price' => 'nullable|numeric|min:0',
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }

            $imageUrl = null;
            if ($request->hasFile('image')) {
                $imageRequest = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $imageRequest->getClientOriginalExtension();
                $imagePath = $imageRequest->storeAs('public/images/products', $imageName);
                $imageUrl = Storage::url($imagePath);
            }
            $productData = [
                'name' => $request->input('name'),
                'image' => $imageUrl,
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'status' => $request->input('status'),
                'views' => $request->input('views', 0),
                'rating' => $request->input('rating', 0),
                'discount_price' => $request->input('discount_price', 0),
            ];
            $redis=Redis::connection();
            $existingProducts = json_decode($redis->get('products_add'),true);
            if(!$existingProducts){
                $existingProducts=[];
            }
            $existingProducts[] = $productData;
            $redis->set('products_add', json_encode($existingProducts));

            $product = Product::create([
                'name' => $request->name,
                'image' => $imageUrl, 
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'status' => $request->status,
                'views' => $request->views ?? 0,
                'rating' => $request->rating ?? 0,
                'discount_price' => $request->discount_price ?? 0,
            ]);

            return response()->json(['message' => 'Product added successfully', 'product' => $product], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
