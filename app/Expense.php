<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['department', 'activity', 'amount', 'creditor', 'uploaded'];
}
