<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'name',
        'description',
        'release_date',
        'rating',
        'ticket_price',
        'slug',
        'country',
        'genre',
        'photo'
    ];
}
