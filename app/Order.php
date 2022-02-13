<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //setam relatia cu utilizatorul
    //fiecare order are un singur utilizator, dar un utilizator poate avea mai multe orders
    //one to many din partea utilizatorului
    public function user() {
        return $this->belongsTo('App\User');
    }
}
