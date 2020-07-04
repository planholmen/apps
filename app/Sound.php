<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWebPathAttribute()
    {
        return str_replace('public/', 'storage/', $this->path);
    }

}
