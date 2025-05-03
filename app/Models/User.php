<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function vendor(){
        return $this->hasMany(Vendor::class,'user_id');
    }
    public function addresse()
    {
        return $this->hasMany(Addresse::class,'user_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class,'receiver');
    }
    public function refund()
    {
        return $this->hasMany(Refund::class,'user_id');
    }
    public function order_item()
    {
        return $this->hasMany(Order_Item::class,'user_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class,'user_id');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class,'user_id');
    }
    public function chat()
    {
        return $this->hasMany(Chat::class,'user_id');
    }
    public function message()
    {
        return $this->hasMany(Message::class,'user_id');
    }
    public function payment()
    {
        return $this->hasMany(Payment::class,'user_id');
    }
    public function product_comment()
    {
        return $this->hasMany(Product_Comment::class,'user_id');
    }
    public function review()
    {
        return $this->hasMany(Review::class,'user_id');
    }
    public function support_ticket_replie()
    {
        return $this->hasMany(Support_Ticket_Replie::class,'user_id');
    }
    public function support_ticket()
    {
        return $this->hasMany(Support_Ticket::class,'user_id');
    }
    public function transaction_history()
    {
        return $this->hasMany(Transaction_History::class,'user_id');
    }
    public function wislist()
    {
        return $this->hasMany(Wishlist::class,'user_id');
    }
    public function admin_premission()
    {
        return $this->hasMany(Admin_Permission::class,'user_id');
    }
}
