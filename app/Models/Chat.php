<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'admin_id',
        'is_active',
        'topic',
        'last_message_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
