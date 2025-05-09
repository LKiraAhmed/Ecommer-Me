<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'product_id',
        'comment',
        'rating'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
