<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    use HasFactory;

    protected $table = 'page_components';

    protected $fillable = ['user_id', 'header', 'text'];

    public $timestamps = false;

    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'component_products', 'component_id', 'listing_id');
    }
}
