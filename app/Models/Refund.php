<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $fillable = [
     'order_id',
     'user_id', 
     'refund_amount',
      'status',
       'reason'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
