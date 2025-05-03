<?php

namespace App\Http\Controllers\order_item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order_Item;

class ShowOrderItemController extends Controller
{
    //
    public function index(){
        $orderItems=Order_Item::with('product', 'order')->get();
        return response()->json(['items' => $orderItems]);
    }
    public function show($id){
        $orderItem=Order_Item::with('product', 'order')->find($id);
        if(!$orderItem){
            return response()->json(['error' => 'Order item not found'], 404);
        }
        return response()->json(['item' => $orderItem]);
    }
}
