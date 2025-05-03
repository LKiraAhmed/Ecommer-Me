<?php

namespace App\Http\Controllers\Shipment;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShowShipmentController extends Controller
{
    //
    public function index(){
        $shipments=Shipment::all();
        return response()->json($shipments);
    }
    public function show($id){
        $shipment =Shipment::findOrFail($id);
        return response()->json($shipment);
    }
}
