<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    use HasFactory;

    protected $table = 'PageSettings';

    protected $fillable = ['user_id', 'url'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
