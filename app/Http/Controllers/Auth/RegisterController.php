<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    //
    public function create(Request $request){
      $validate=  Validator::make($request->all(),[
            'name'=>'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'email'=>'required|string|email',
            'password' =>'required|string'
        ]);
        $emailExists = User::where('email', $request->email)->first();
        if($emailExists){
            return response()->json(['message' => 'Email is required','Email'=>$emailExists->email], 400);
        }
        if($validate->fails()){
            return response()->json($validate->errors()->toJson(), 400);
        }
        $imageRequest=null;
        if($request->has('image')){
            $imageRequest=$request->file('image');
            $imageName=time().'-'.uniqid().'-'.$imageRequest->getClientOriginalExtension();
            $imagePath = $imageRequest->storeAs('public/images/users', $imageName);
            $imageUrl=Storage::url($imagePath);
        }
        $user= new User;
        $user->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'image'=>$imageUrl,
            'password'=>Hash::make($request->password),
        ]);
        return response()->json([
            'message'=>'User Create successfully.',
            'userName'=>$request->name
        ],200);
    }
}
