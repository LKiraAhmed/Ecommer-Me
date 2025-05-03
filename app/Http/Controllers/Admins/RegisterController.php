<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;

class RegisterController extends Controller
{
    //
    public function create(Request $request){
        try{
            $validate=  Validator::make($request->all(),[
                'name'=>'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'email'=>'required|string|email',
                'password' =>'required|string'
            ]);
            if($validate->fails()){
                return response()->json($validate->errors()->toJson(), 400);
            }
            $emailExists = Admin::where('email', $request->email)->first();
            if($emailExists){
                return response()->json(['message' => 'Email is required','Email'=>$emailExists->email], 400);
            }
            $imageRequest=null;
            if($request->has('image')){
                $imageRequest=$request->file('image');
                $imageName = time().'-'.uniqid() .'-'. $imageRequest->getClientOriginalExtension();
                $imagePath = $imageRequest->storeAs('public/images/admins', $imageName);
                $imageUrl=Storage::url($imagePath);
            }
            $admin=new Admin;
            $admin->create([
                'name'=>$request->name,
                'email'=>$request->email,
                'image'=>$imageUrl,
                'password'=>Hash::make($request->password),
            ]);
            return response()->json([
                'message'=>'Admin Create successfully.',
                'userName'=>$admin->name
            ],200);
        }catch(Exception $e){
            return response()->json([
                'error' => 'Admin creation failed',
                'message'=>$e->getMessage()
            ],500);
        }
    }
}
