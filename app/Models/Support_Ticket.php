<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support_Ticket extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'subject',
        'message',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function replies()
{
    return $this->hasMany(Support_Ticket_Replie::class, 'ticket_id');
}

}
