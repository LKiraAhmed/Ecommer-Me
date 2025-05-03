<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    //
    public function adminChats(){
        try{
            $chats = Chat::with(['user', 'message' => function($q){
                $q->latest()->limit(1);
            }])->latest()->get(); 
            return response()->json($chats);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    public function startChat(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'admin_id' => Auth::guard('admin')->id(),
            ]);
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $chat=Chat::firstOrCreate([
                'user_id' => $request->user_id 
            ]);
            return response()->json($chat);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
