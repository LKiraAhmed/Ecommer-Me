<?php

namespace App\Http\Controllers\SupportTicket;

use App\Http\Controllers\Controller;
use App\Models\Support_Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EditSupportTicketController extends Controller
{
    //
    public function update(Request $request,$id){
        try{
            $validator = Validator::make($request->all(), [
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $ticket =Support_Ticket::where('id',$id)->where('user_id',Auth::id())->findOrFail($id);
            $ticket->update([
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
            return response()->json(['message' => 'Ticket updated', 'ticket' => $ticket]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
