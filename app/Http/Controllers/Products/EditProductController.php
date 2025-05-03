<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EditProductController extends Controller
{
    //
    public function update(Request $request, $id){
        try{
            DB::beginTransaction();
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', 
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
            if ($request->hasFile('image')) {
                if (!empty($product->image)) {
                    $oldImagePath = str_replace('/storage/', 'public/', $product->image);
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                $imageRequest = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $imageRequest->getClientOriginalExtension();
                $imagePath = $imageRequest->storeAs('public/images/products', $imageName);
                $product->image = Storage::url($imagePath);
            }else{
                $imageUrl = $product->image; 
            }
            $product->update([
                'name' => $request->name,
                'image' => $imageUrl, 
                'description' => $request->description ?? $product->description, 
                'price' => $request->price,
                'stock' => $request->stock,
                'status' => $request->status,
                'views' => $request->has('views') ? $request->views : $product->views,
                'rating' => $request->has('rating') ? $request->rating : $product->rating,
                'discount_price' => $request->has('discount_price') ? $request->discount_price : $product->discount_price,
            ]);
            DB::commit();
            return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
        }catch(Exception $e){
            DB::rollBack(); 
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
