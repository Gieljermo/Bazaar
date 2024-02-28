<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Listing extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['product_id', 'user_id', 'type', 'purchase_id', 'price', 'price_from', 'amount'];

    public function product()
    {
        return $this->belongsTo(Product::class);
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
}
