<?php

namespace App\Http\Controllers\Refund;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Exception;
use Illuminate\Http\Request;

class DeleteRefundController extends Controller
{
    //
    public function destroy($id){
        try{
            $refund=Refund::find($id);
            if(!$refund){
                return response()->json(['error' => 'Refund not found'], 404);
            }
            $refund->delete();
            return response()->json(['message' => 'Refund deleted successfully'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500); 
        }
    }
}
