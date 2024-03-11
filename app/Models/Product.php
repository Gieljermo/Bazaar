<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'products';

    protected $fillable = ['product_name', 'description', 'price', 'amount'];

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }


    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
