<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Model  implements JWTSubject
{
    use HasFactory;
    protected $fillable=[
        'name',
        'image',
        'email',
        'password',
        'role',
        'phone',
        'address'
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function chat()
    {
        return $this->hasMany(Chat::class,'admin_id');
    }
    public function notifications()
{
    return $this->morphMany(Notification::class, 'receiver');
}

}
