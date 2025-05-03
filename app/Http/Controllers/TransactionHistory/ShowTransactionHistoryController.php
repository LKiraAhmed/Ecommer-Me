<?php

namespace App\Http\Controllers\TransactionHistory;

use App\Http\Controllers\Controller;
use App\Models\Transaction_History;
use Illuminate\Http\Request;

class ShowTransactionHistoryController extends Controller
{
    //
    public function index(){
        $transactions=Transaction_History::with([['user', 'order']])->latest()->get();
        return response()->json($transactions);
    }
    public function show($id){
        $transaction=Transaction_History::with(['user','order'])->findOrFail($id);
        return response()->json($transaction);
    }
}
