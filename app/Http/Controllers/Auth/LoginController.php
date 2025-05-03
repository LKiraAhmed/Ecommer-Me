<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        
     try{
        $validate=  Validator::make($request->all(),[
            'email'=>'required|string|email',
            'password' =>'required|string'
        ]);
        if($validate->fails()){
            return response()->json(['error'=>$validate->errors()]);
        }
        $credentials = $request->only('email', 'password');

  
        if (!$token = Auth::guard('user')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);

     }catch(Exception $e){
        return response()->json([
            'error'=>'Something went wrong',
            'message'=>$e->getMessage()
        ],500);
     }
    }
}
