<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'total_price',
        'status',
        'payment_method'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function order_item()
    {
        return $this->hasMany(Order_Item::class,'product_id');
    }

    public function refund()
    {
        return $this->hasMany(Refund::class,'product_id');
    }
    public function shipment()
    {
        return $this->hasMany(Shipment::class,'product_id');
    }
    public function transaction_history()
    {
        return $this->hasMany(Transaction_History::class,'product_id');
    }
    
}
