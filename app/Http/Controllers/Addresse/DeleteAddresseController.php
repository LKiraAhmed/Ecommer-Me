<?php

namespace App\Http\Controllers\Addresse;

use App\Http\Controllers\Controller;
use App\Models\Addresse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteAddresseController extends Controller
{
    //
    public function destroy($id){
        try{
            $address=Addresse::where('user_id',Auth::id())->findOrFail($id);
            $address->delete();
            return response()->json(['message' => 'Address deleted successfully']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
