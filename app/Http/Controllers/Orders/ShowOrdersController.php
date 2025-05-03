<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class ShowOrdersController extends Controller
{
    //
    public function show($id){
        try{
            $order=Order::with('orderItems.product')->find($id);     
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return response()->json(['order' => $order], 200);
        }catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
