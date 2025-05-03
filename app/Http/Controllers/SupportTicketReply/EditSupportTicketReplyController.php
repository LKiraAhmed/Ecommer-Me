<?php

namespace App\Http\Controllers\SupportTicketReply;

use App\Http\Controllers\Controller;
use App\Models\Support_Ticket_Replie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EditSupportTicketReplyController extends Controller
{
    //
    public function update(Request $request,$id){
        try{
            $validator = Validator::make($request->all(), [
                'message' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $ticket =Support_Ticket_Replie::where('id',$id)->where('user_id',Auth::id())->findOrFail($id);
            $ticket->update([
                'user_id'=>Auth::id(),
                'ticket_id'=>$id,
                'message'=>$request->message
            ]);
            return response()->json(['message' => 'Ticket Replie  updated', 'ticket' => $ticket]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
