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
}
