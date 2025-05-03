<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ResetPasswordController extends Controller
{
    //
    public function index(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'password' => 'required|confirmed',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $user=JWTAuth::setToken($request->token)->authenticate();
            if(!$user){
                return response()->json(['error' => 'Invalid token'], 400);
            }
            
            if ($user->role !== 'user') {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            $user->password=Hash::make($request->password);
            $user->save();
            return response()->json(['message' => 'Password has been reset successfully.']);
        }catch(Exception $e){
            return response()->json(['error' => 'Invalid token or expired'], 400);
        }
    }
}
