<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'listing_id', 'from', 'until'];

    protected $casts = [
        'from' => 'datetime',
        'until' => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
