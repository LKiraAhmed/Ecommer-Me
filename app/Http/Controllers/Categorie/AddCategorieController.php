<?php

namespace App\Http\Controllers\Categorie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AddCategorieController extends Controller
{
    //
    public function add(Request $request){
        try{
            $validate =Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', 
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }

            $imageUrl = null;
            if ($request->hasFile('image')) {
                $imageRequest = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $imageRequest->getClientOriginalExtension();
                $imagePath = $imageRequest->storeAs('public/images/categories', $imageName);
                $imageUrl = Storage::url($imagePath);
            }
            $categorie = Categorie::create([
                'name' => $request->name,
                'image' => $imageUrl
            ]);
            return response()->json(['message' => 'Category added successfully', 'category' => $categorie]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
