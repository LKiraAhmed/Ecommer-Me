<?php

namespace App\Http\Controllers\order_item;

use App\Http\Controllers\Controller;
use App\Models\Order_Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddOrderItemController extends Controller
{
    //
    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0'
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $item=Order_Item::create([
                'order_id'=>$request->order_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'price'=>$request->price,
            ]);
            return response()->json(['message' => 'Order item added', 'item' => $item]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
