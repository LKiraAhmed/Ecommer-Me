<?php

namespace App\Http\Controllers\StockManagement;

use App\Http\Controllers\Controller;
use App\Models\Stock_Management;
use Exception;
use Illuminate\Http\Request;

class DeleteStockManagementController extends Controller
{
    //
    public function destroy($id){
        try{
            $stock = Stock_Management::findOrFail($id);
            $stock->delete();
            return response()->json(['message' => 'Stock deleted successfully']);   
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
