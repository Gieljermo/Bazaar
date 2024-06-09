<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    public $timestamps = false;

    protected $table = 'products';

    protected $fillable = ['product_name', 'description'];

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }


    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'product_name' => $this->product_name
        ];
    }
}
