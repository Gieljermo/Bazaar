<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'header', 'text'];

    public $timestamps = false;

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
