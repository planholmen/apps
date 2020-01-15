<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function drives()
    {
        return $this->hasMany(Drive::class);
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        $role = (array) $role;

        $check = false;
        $roles = explode(',', $this->role);

        foreach ($roles as $userRole) {
            if (in_array($userRole, $role))
                $check = true;
        }

        return $check;
    }

}
