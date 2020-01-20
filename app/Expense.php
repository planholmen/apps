<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['user_id', 'department', 'activity', 'amount', 'creditor', 'uploaded'];

    protected $dates = ['approved_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
