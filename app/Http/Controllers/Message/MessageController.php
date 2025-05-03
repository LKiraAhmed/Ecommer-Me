<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Message;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\UserMessageNotification;

class MessageController extends Controller
{
    //
    public function sender(){
        return $this->morphTo();
    }
    public function sendMessage(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'message' => 'required|string',
            ]);
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            if (!$request->chat_id) {
                $chat = Chat::firstOrCreate(['user_id' => Auth::id()]);
                $request->merge(['chat_id' => $chat->id]);
            }
            $senderType = Auth::guard('admin')->check() ? Admin::class : User::class;

            $message = Message::create([
                'chat_id' => $request->chat_id,
                'sender_id' => Auth::id(),
                'sender_type' => $senderType,
                'message' => $request->message,
                'is_read' => false,
            ]);
            if ($request->receiver_type === 'user') {
                $receiver = User::find($request->receiver_id);
            } else {
                $receiver = Admin::find($request->receiver_id);
            }
    
            if ($receiver) {
                $receiver->notify(new UserMessageNotification($request->message, $request->receiver_type));
            }
    
            return response()->json($message);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    public function chatMessages($chat_id){
        try{
            $messages = Message::where('chat_id', $chat_id)
            ->with('sender')
            ->get();
            return response()->json($messages);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);     
        }
    }
    public function markAsRead($chat_id){
        try{
            Message::where('chat_id',$chat_id)->where('is_read',false)
            ->where('sender_id','!=',Auth::id())->update(['is_read' => true]);
            return response()->json(['message' => 'Messages marked as read']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);    
        }
    }
}
