<?php

namespace App\Http\Controllers\Categorie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ShowCategorieController extends Controller
{
    //
    public function index(){
        $categories=Categorie::all();
        return response()->json(['categories' => $categories], 200);
    }
    public function show($id){
        $categorie=Categorie::find($id);
        if (!$categorie) {
            return response()->json(['error' => 'Categorie not found'], 404);
        }
        return response()->json(['categorie' => $categorie], 200);
    }
}
