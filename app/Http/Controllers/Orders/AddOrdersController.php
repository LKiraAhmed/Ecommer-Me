<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_Item;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddOrdersController extends Controller
{
    //
    public function addorder(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|integer|min:1',
                'payment_method' => 'required|in:cash_on_delivery,credit_card'
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $cartItem=Cart::with('product')->where('user_id',$request->user_id)->get();
            if($cartItem->isEmpty()){
                return response()->json(['error'=>'Cart is empty'],400);
            }
            DB::beginTransaction();
            $order=Order::create([
                'user_id'=>$request->user_id,
                'total_price'=>$request->total_price,
                'status'=>$request->status,
                'payment_method' => $request->payment_method,
            ]);
            foreach($cartItem as $item){
                Order_Item::create([  
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
