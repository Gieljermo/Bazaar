<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Listing extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'listings';

    protected $fillable = ['product_id', 'user_id', 'type', 'purchase_id', 'price', 'price_from', 'amount'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function bids()
    {
        return $this->hasMany(Bid::class)->orderBy('price', 'desc');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function highestBid()
    {
        return $this->bids()->first();
    }

    public function reviews(){
        $this->hasMany(Review::class);
    }

    public function getImageUrl(){
        return url('storage/'. $this->image);
    }
}
