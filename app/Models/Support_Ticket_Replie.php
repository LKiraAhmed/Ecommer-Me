<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support_Ticket_Replie extends Model
{
    use HasFactory;
    protected $fillable=[
        'ticket_id',
        'user_id',
        'message', 
    ];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function ticket()
{
    return $this->belongsTo(Support_Ticket::class, 'ticket_id');
}

}
