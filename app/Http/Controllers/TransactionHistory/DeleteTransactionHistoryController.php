<?php

namespace App\Http\Controllers\TransactionHistory;

use App\Http\Controllers\Controller;
use App\Models\Transaction_History;
use Exception;
use Illuminate\Http\Request;

class DeleteTransactionHistoryController extends Controller
{
    //
    public function destroy($id){
        try{
            $transaction=Transaction_History::findOrFail($id);
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted successfully.'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
