<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderdetails extends Model
{
    protected $fillable = ['user_id', 'total', 'address'];
}
