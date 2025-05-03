<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_History extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'order_id', 'payment_method', 'amount', 'transaction_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
