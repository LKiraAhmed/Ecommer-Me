<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'receiver_type',
        'receiver_id',
        'title',
        'message',
        'is_read'
    ];
    

    public function receiver()
    {
        return $this->morphTo();
    }
}
