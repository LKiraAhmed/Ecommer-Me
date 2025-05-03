<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Exception;

class RemoveOrdersController extends Controller
{
    //
    public function destroy($id){
        try{
            $order=Order::find($id);      
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $order->delete();
            return response()->json(['message' => 'Order item removed successfully']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
