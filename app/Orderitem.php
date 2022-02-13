<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    protected $fillable = ['order_item', 'product_id'];
}
