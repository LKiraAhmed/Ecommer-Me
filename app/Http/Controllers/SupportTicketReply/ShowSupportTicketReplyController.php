<?php

namespace App\Http\Controllers\SupportTicketReply;

use App\Http\Controllers\Controller;
use App\Models\Support_Ticket_Replie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Exception;

class ShowSupportTicketReplyController extends Controller
{
    //
    public function index(){
        
        try {
            $userId = Auth::id();
            $redis = Redis::connection();
            $cacheKey = 'support_ticket_replies_user_' . $userId;

            $cachedReplies = $redis->get($cacheKey);

            if ($cachedReplies) {
                $replies = json_decode($cachedReplies, true);
            } else {
                $replies = Support_Ticket_Replie::where('user_id', $userId)
                            ->with('ticket')
                            ->get();

                $redis->setex($cacheKey, 600, json_encode($replies));
            }

            return response()->json($replies);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
    public function show($id){
        try{
            $userId = Auth::id();
            $redis = Redis::connection();
            $cacheKey = 'support_ticket_replies_user_' . $userId .'id'.$id;
            $cachedReplies = $redis->get($cacheKey);
            if($cachedReplies){
                $ticketReply = json_decode($cachedReplies, true);
            }else{
                $ticketReply = Support_Ticket_Replie::findOrFail($id);
                $redis->setex($cacheKey, 600, json_encode($ticketReply));
            }
            return response()->json($ticketReply);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500); 
        }
    }
}
