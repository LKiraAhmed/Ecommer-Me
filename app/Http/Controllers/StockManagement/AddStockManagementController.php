<?php

namespace App\Http\Controllers\StockManagement;

use App\Http\Controllers\Controller;
use App\Models\Stock_Management;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddStockManagementController extends Controller
{
    //
    public function add(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:0',
                'reserved_quantity' => 'nullable|integer|min:0',
                'sold_quantity' => 'nullable|integer|min:0',    
            ]);
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $stock=Stock_Management::create([
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'reserved_quantity'=>$request->reserved_quantity,
                'sold_quantity'=>$request->sold_quantity
            ]);
            return response()->json(['message' => 'Stock added successfully', 'data' => $stock]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
