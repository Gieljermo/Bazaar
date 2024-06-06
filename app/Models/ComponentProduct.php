<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentProduct extends Model
{
    use HasFactory;

    protected $fillable = ['listing_id', 'component_id'];

    protected $table = 'component_products';

    public $timestamps = false;

}
