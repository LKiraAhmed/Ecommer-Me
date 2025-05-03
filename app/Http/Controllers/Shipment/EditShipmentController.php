<?php

namespace App\Http\Controllers\Shipment;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditShipmentController extends Controller
{
    //
    public function update(Request $request,$id){
      try{
            $shipment=Shipment::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
                'tracking_number' => 'nullable|string',
                'courier_name' => 'required|string',
                'status' => 'required|string',
                'shipped_at' => 'nullable|date',
                'delivered_at' => 'nullable|date',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $shipment->update([
                'order_id'=>$request->order_id,
                'tracking_number'=>$request->tracking_number,
                'courier_name'=>$request->shipping_company,
                'status'=>$request->status,
                'shipped_at'=>$request->shipped_at,
                'delivered_at'=>$request->delivered_at
            ]);
            return response()->json(['message' => 'Shipment updated', 'data' => $shipment]);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    }

