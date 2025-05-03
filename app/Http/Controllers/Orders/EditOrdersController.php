<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditOrdersController extends Controller
{
    //
    public function update(Request $request,$id){
        try{
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|integer|min:1',
                'payment_method' => 'required|in:cash_on_delivery,credit_card'
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $order=Order::find($id);
            
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $order->user_id =$request->user_id ;
            $order->total_price =$request->total_price ;
            $order->payment_method = $request->payment_method;
            if($request->has('status')){
                $order->status = $request->status;
            }
            
            $order->save();

            return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
