<?php

namespace App\Http\Controllers\SupportTicketReply;

use App\Http\Controllers\Controller;
use App\Models\Support_Ticket_Replie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteSupportTicketReplyController extends Controller
{
    //
    public function destroy($id){
        try{
            $ticket =Support_Ticket_Replie::where('user_id',Auth::id())->findOrFail($id);
            $ticket->delete();
            return response()->json(['message' => 'Ticket deleted']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}


