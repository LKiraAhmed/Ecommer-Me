<?php

namespace App\Http\Controllers\Categorie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EditCategorieController extends Controller
{
    //
    public function update(Request $request,$id){
        try{
            DB::beginTransaction();
            $categorie=Categorie::find($id);
            if(!$categorie){
                return response()->json(['error' => 'Categorie not found'], 404);
            }
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', 
            ]);
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            if($request->hasFile('image')){
                if(!empty($categorie->image)){
                    $oldImagePath = str_replace('/storage/', 'public/', $categorie->image);
                    if(Storage::exists($oldImagePath)){
                        Storage::delete($oldImagePath);
                    }
                    $imageRequest=$request->file('image');
                    $imageName = time() . '-' . uniqid() . '.' . $imageRequest->getClientOriginalExtension();
                    $imagePath = $imageRequest->storeAs('public/images/products', $imageName);
                    $imageUrl = Storage::url($imagePath);
                }
            }else{
                $imageUrl=$categorie->image;
            }
            $categorie->update([
                'name' => $request->name,
                'image' => $imageUrl, 
            ]);
            DB::commit();
            return response()->json(['message' => 'Category updated successfully'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);  
        }
    }
}
