<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_id',
        'tracking_number',
        'courier_name',
        'status',
        'shipped_at',
        'delivered_at'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

}
