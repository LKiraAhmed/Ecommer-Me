<?php

namespace App\Http\Controllers\Refund;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddRefundController extends Controller
{
    //
    public function add(Request $request){
        try{
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
        $refund =Refund::create([
            'order_id' => $request->order_id,
            'user_id' => $request->user_id,
            'refund_amount' => $request->refund_amount,
            'status' => $request->status,
            'reason' => $request->reason,
        ]);
        return response()->json(['message' => 'Refund added successfully', 'data' => $refund], 201);

        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
