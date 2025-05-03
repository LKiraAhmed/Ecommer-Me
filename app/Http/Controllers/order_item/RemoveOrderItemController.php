<?php

namespace App\Http\Controllers\order_item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order_Item;
use Exception;
class RemoveOrderItemController extends Controller
{
    //
    public function destroy($id){
        try{
            $item = Order_Item::find($id);
            if (!$item) {
                return response()->json(['error' => 'Order item not found'], 404);
            }

            $item->delete();
            return response()->json(['message' => 'Order item removed']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
