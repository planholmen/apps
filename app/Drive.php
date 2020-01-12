<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{

    // Attributes to be casted to a carbon instace
    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'date', 'from', 'to', 'purpose', 'distance', 'user_id'
    ];

    protected $casts = [
        'posted' => 'boolean',
        'transferred' => 'boolean'
    ];

    // Get the associated user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
