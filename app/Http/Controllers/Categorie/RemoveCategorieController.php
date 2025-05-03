<?php

namespace App\Http\Controllers\Categorie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RemoveCategorieController extends Controller
{
    //
    public function destroy($id){
        try{
            $categorie=Categorie::find($id);
            if(!$categorie){
                return response()->json(['error' => 'Categorie not found'], 404);
            }
            if (!empty($categorie->image)) {
                $imagePath = str_replace('/storage/', 'public/', $categorie->image);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
            $categorie->delete();
            return response()->json(['message' => 'Categorie deleted successfully'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
