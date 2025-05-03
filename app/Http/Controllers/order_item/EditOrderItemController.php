<?php

namespace App\Http\Controllers\order_item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order_Item;
use Illuminate\Support\Facades\Validator;
use Exception;
class EditOrderItemController extends Controller
{
    //
    public function update($id,Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1',
                'price' => 'nullable|numeric|min:0'
            ]);
            
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $item=Order_Item::find($id);
            if(!$item){
                return response()->json(['error' => 'Order item not found'], 404);
            }
            $item->quantity=$request->quantity;
            if ($request->has('price')) {
                $item->price = $request->price;
            }
            $item->save();

            return response()->json(['message' => 'Order item updated', 'item' => $item]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
