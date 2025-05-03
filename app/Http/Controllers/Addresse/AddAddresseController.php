<?php

namespace App\Http\Controllers\Addresse;

use App\Http\Controllers\Controller;
use App\Models\Addresse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddAddresseController extends Controller
{
    //
    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'nullable|string|max:255',
                'zip_code' => 'required|string|max:10',
                'country' => 'required|string|max:255',
                'is_default' => 'boolean',
            ]);
        
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $address=Addresse::create([
                'user_id' => Auth::id(),
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'is_default' => $request->is_default ?? false,
            ]);
            return response()->json($address);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
