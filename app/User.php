<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //$fillable email and password are passed to the constructor of user whenever a new user is created
    protected $fillable = [
        'email', 'password', 'isAdmin'
    ];

    //the hidden field is important when retrieving a user from the database
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders() {
        return $this->hasMany('App\Order');
    }
}
