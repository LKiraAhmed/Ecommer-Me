<?php

namespace App\Http\Controllers\Addresse;

use App\Http\Controllers\Controller;
use App\Models\Addresse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowAddresseController extends Controller
{
    //
    public function index(){
        try{
            $addresses=Addresse::where('user_id',Auth::id())->get();
            return response()->json($addresses);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
