<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable=[
        'chat_id',
        'sender_id',
        'message',
        'is_read',
        'sender_type'
    ];
    public function chat()
    {
        return $this->belongsTo(Chat::class,'chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

}
