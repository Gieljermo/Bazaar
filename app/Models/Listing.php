<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'listings';
    protected $fillable = ['product_id', 'user_id', 'type', 'purchase_id'];


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
        return $this->belongsTo(User::class, 'user_id');
    }
}
