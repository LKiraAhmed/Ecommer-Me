<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Permission extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'manage_products',
        'manage_orders',
        'manage_users',
        'manage_payments'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
