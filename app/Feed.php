<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'title', 'body','image', 'source', 'publisher'
    ];

    protected $hidden = ['image'];
}
