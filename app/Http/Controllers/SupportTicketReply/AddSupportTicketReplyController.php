<?php

namespace App\Http\Controllers\SupportTicketReply;

use App\Http\Controllers\Controller;
use App\Models\Support_Ticket_Replie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;

class AddSupportTicketReplyController extends Controller
{
    //
    public function store(Request $request,$ticket_id){
        try{
            $ticket=Support_Ticket_Replie::findOrFail($ticket_id);
            $validate = Validator::make($request->all(), [
                'message' => 'required|string',
            ]);
    
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $ticket->create([
                'user_id'=>Auth::id(),
                'ticket_id'=>$ticket_id,
                'message'=>$request->message
            ]);
            $redis=Redis::connection();
            $userId = Auth::id(); 
            $supportTicetReply=[
                'user_id'=>$userId,
                'ticket_id'=>$ticket_id,
                'message'=>$request->message
            ];
            $key='supports_tickets_replys_users'.$userId;
            $exictsSupportTicet = json_decode($redis->get($key), true);
            if(!$exictsSupportTicet){
                $exictsSupportTicet =[];
            }
            $exictsSupportTicet[]=$supportTicetReply;
            $redis->set($key, json_encode($exictsSupportTicet));

            return response()->json(['message' => 'Reply added successfully.'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
