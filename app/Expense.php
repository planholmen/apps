<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['user_id', 'department', 'activity', 'amount', 'creditor', 'uploaded'];

    protected $dates = ['approved_at'];

    public function getAmountAttribute($amount)
    {
        return number_format((double)$amount, 2, ',', '.');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
