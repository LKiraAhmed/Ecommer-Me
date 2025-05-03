<?php

namespace App\Http\Controllers\Refund;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class ShowRefundController extends Controller
{
    //
    public function show(){
        try {
            $refunds = Refund::paginate(20);    
            return response()->json(['data' => $refunds], 200);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    public function showOne($id)
{
    try {
        $refund = Refund::find($id);

        if (!$refund) {
            return response()->json(['error' => 'Refund not found'], 404);
        }

        return response()->json(['data' => $refund], 200);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
    }
}

}
