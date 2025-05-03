<?php

namespace App\Http\Controllers\Refund;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditRefundController extends Controller
{
    //
    public function edit(Request $request, $id){
        try{
            $refund=Refund::find($id);
            if(!$refund){
                return response()->json(['error' => 'Refund not found'], 404);
            }
            $validate= Validator::make($request->all(),[
                'order_id' => 'required|exists:orders,id',
                'user_id' => 'required|exists:users,id',
                'refund_amount' => 'required|numeric|min:0',
                'status' => 'required|string',
                'reason' => 'nullable|string',
               ]);
               if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $refund->update([
                'order_id' => $request->order_id,
                'user_id' => $request->user_id,
                'refund_amount' => $request->refund_amount,
                'status' => $request->status,
                'reason' => $request->reason,
            ]);
            return response()->json(['message' => 'Refund updated successfully', 'data' => $refund], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500); 
        }
    }
}
