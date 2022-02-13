<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopcart extends Model
{
    protected $fillable = [
        'user_id', 'status'
    ];
    public function add($user_id){
        $shopcart = new Shopcart();
        $shopcart->user_id = $user_id;
        $shopcart->status='activ';
        $shopcart->save();
    }
    public function update_shopcart_status($id){
        $shopcarts = Shopcart::select('*')
            ->where('id', '=', $id)
            ->get();
        foreach($shopcarts as $shopcart){
            $shopcart->status = 'inactive';
            $data['status']=$shopcart->status;
            Shopcart::where("id", $id)->update($data);
        }
    }

}
