<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopcartitem extends Model
{
    protected $fillable = [
        'cart_id', 'product_id', 'quantity'
    ];
    public function add($cart_id, $product_id){
        $shopcartitems = new Shopcartitem();
        $shopcartitems->cart_id = $cart_id;
        $shopcartitems->product_id = $product_id;
        $shopcartitems->quantity = 1;
        $shopcartitems->save();
    }
    public function increaseQuantity($cart_id, $product_id)
    {
        $cartitems = Shopcartitem::select('*')
            ->where('cart_id', '=', $cart_id)
            ->where('product_id', '=', $product_id)
            ->get();
        if ($cartitems != '') {
            foreach ($cartitems as $cart) {

                $id_shopitems = $cart->id;
                $cart->quantity = $cart->quantity + 1;
            }

            $data['quantity'] = $cart->quantity;
            Shopcartitem::where("id", $id_shopitems)->update($data);

        }
    }
    public function reduceQuantity($cart_id, $product_id)
    {
        $cartitems = Shopcartitem::select('*')
            ->where('cart_id', '=', $cart_id)
            ->where('product_id', '=', $product_id)
            ->get();
        if ($cartitems != '') {
            foreach ($cartitems as $cart) {

                $id_shopitems = $cart->id;
                if($cart->quantity==1){
                   $this->removeItem($cart_id, $product_id);
                }
                else{
                    $cart->quantity = $cart->quantity - 1;
                }

            }

            $data['quantity'] = $cart->quantity;
            Shopcartitem::where("id", $id_shopitems)->update($data);

        }
    }
    public function removeItem($cart_id, $product_id)
    {
        $cartitems = Shopcartitem::select('*')
            ->where('cart_id', '=', $cart_id)
            ->where('product_id', '=', $product_id)
            ->get();
        if ($cartitems != '') {
            foreach ($cartitems as $cart) {

                $id_shopitems = $cart->id;


            }
            Shopcartitem::find($id_shopitems)->delete();

        }
    }
    public function removeAll($cart_id){
        Shopcartitem::where("cart_id",$cart_id)->delete();
    }
}
