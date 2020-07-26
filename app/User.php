<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];
    public function isAdmin()
    {
        return $this->admin; // this looks for an admin column in your users table
    }
    public function rates()
    {
        return $this->hasMany(Rating::Class);
    }
    public function Orders()
    {
        return $this->hasMany(Order::Class);
    }
    public function Addresses()
    {
        return $this->hasMany(Address::Class);
    }
}
