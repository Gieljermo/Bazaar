<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'advertiser_id',
        'text',
        'reviewer_id',
        'rating'
    ];

    public function reviewer(){
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function advertiser(){
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function listing(){
        return $this->belongsTo(Listing::class, 'listing_id');
    }
}
