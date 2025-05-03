<?php

namespace App\Http\Controllers\Shipment;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;

class DeleteShipmentController extends Controller
{
    //
    public function destroy($id){
        try{
            $shipment=Shipment::findOrFail($id);
            $shipment->delete();
            return response()->json(['message' => 'Shipment deleted']);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
