<?php

namespace App\Http\Controllers\SupportTicket;

use App\Http\Controllers\Controller;
use App\Models\Support_Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;

class AddSupportTicketController extends Controller
{
    //
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $ticket=Support_Ticket::create([
                'user_id'=>Auth::id(),
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
            $redis=Redis::connection();
            $userId = Auth::id(); 
            $supportTicetData=[
                'id' => $ticket->id,
                'user_id'=>$userId,
                'subject' => $request->subject,
                'message' => $request->message,
            ];
            $key='supports_ticets_user_'.$userId;
            $exictsSupportTicet = json_decode($redis->get($key), true);
            if(!$exictsSupportTicet){
                $exictsSupportTicet =[];
            }
            $exictsSupportTicet[]=$supportTicetData;
            $redis->set($key, json_encode($exictsSupportTicet));

      
            return response()->json(['message' => 'Ticket created', 'ticket' => $ticket]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
