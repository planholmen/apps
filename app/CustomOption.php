<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomOption extends Model
{

    public $primaryKey = 'key';
    public $keyType = 'string';

    protected $fillable = [
        'key', 'value'
    ];


    /**
     * Get value for specified custom option key
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        if (CustomOption::find($key) != null)
            return CustomOption::find($key)->value;


        return false;
    }
}
