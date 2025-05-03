<?php

namespace App\Http\Controllers\TransactionHistory;

use App\Http\Controllers\Controller;
use App\Models\Transaction_History;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EditTransactionHistoryController extends Controller
{
    //
    public function update(Request $request,$id){
        try{
            $transaction=Transaction_History::findOrFail($id);
            $validate = Validator::make($request->all(), [
                'order_id' => 'nullable|exists:orders,id',
                'payment_method' => 'required|string',
                'amount' => 'required|numeric',
                'transaction_id' => 'nullable|string',
                'status' => 'required|string',  
            ]);
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $transaction->update([
                'user_id'=>Auth::id(),
                'order_id'=>$request->order_id,
                'payment_method'=>$request->payment_method,
                'amount'=>$request->amount,
                'transaction_id'=>$request->transaction_id,
                'status'=>$request->status,
            ]);
            
            return response()->json(['message' => 'Transaction updated successfully.','data' => $transaction], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
