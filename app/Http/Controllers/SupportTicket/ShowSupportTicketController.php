<?php

namespace App\Http\Controllers\SupportTicket;

use App\Http\Controllers\Controller;
use App\Models\Support_Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Redis;

class ShowSupportTicketController extends Controller
{
    //
    public function index(){
        try{
            $userId = Auth::id();
            $redis = Redis::connection();
            $cacheKey = 'support_tickets_user_' . $userId;
            $cachedTickets = $redis->get($cacheKey);
            if ($cachedTickets) {
                $tickets = json_decode($cachedTickets, true);
            } else {
                $tickets = Support_Ticket::where('user_id', $userId)
                            ->with('replies')
                            ->get();
                            $redis->setex($cacheKey, 600, json_encode($tickets));
            }
            return response()->json($tickets);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
    public function show($id){
        try{
            $userId = Auth::id();
            $redis = Redis::connection();
            $cacheKey = 'support_tickets_user_' . $userId .'id'.$id;
            $cachedTickets = $redis->get($cacheKey);
            if ($cachedTickets) {
                $tickets = json_decode($cachedTickets, true);
            } else {
                $ticket=Support_Ticket::where('user_id',Auth::id())->where('id',$id)->with('replies')->get();
                            $redis->setex($cacheKey, 600, json_encode($ticket));
            }
            return response()->json($ticket);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500); 
        }
    }
}
