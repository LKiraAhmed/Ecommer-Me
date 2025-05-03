<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
class ResetPasswordController extends Controller
{
    //
    public function index(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'password' => 'required|confirmed',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
    
            $admin = JWTAuth::setToken($request->token)->authenticate();
    
            if (!$admin) {
                return response()->json(['error' => 'Invalid token'], 400);
            }
    
            if ($admin->role !== 'admin') {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
    
            $admin->password = Hash::make($request->password);
            $admin->save();
    
            return response()->json(['message' => 'Admin password has been reset successfully.']);
    
        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid token or expired'], 400);
        }
    }
}    

