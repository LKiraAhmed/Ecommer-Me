<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'stock',
        'status',
        'views',
        'rating',
        'discount_price',
        'category_id'
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'status' => 'boolean',
    ];
    public function cart()
    {
        return $this->hasMany(Cart::class,'product_id');
    }
    public function order_item()
    {
        return $this->hasMany(Order_Item::class,'product_id');
    }
    public function product_commet()
    {
        return $this->hasMany(Product_Comment::class,'product_id');
    }
    public function review()
    {
        return $this->hasMany(Review::class,'product_id');
    }
    public function stock_managent()
    {
        return $this->hasMany(Stock_Management::class,'product_id');
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class,'product_id');
    }
    public function categorie()
{
    return $this->belongsTo(Categorie::class, 'category_id');
}

}
