<?php

namespace App\Http\Controllers\StockManagement;

use App\Http\Controllers\Controller;
use App\Models\Stock_Management;
use Illuminate\Http\Request;

class ShowStockManagementController extends Controller
{
    //
    public function show()
    {
        $stocks = StockManagement::with('product')->get();
        return response()->json($stocks);
    }
}
