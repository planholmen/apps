<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomOption extends Model
{
    protected $fillable = [
        'key', 'value'
    ];
}
