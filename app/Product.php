<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $fillable = ['imagePath', 'title', 'description', 'price', 'stock'];
    public function removefromStock($product_id, $quantity){
        $products = Product::select('*')
            ->where('id', '=', $product_id)
            ->get();
        foreach($products as $product){
           $product->stock = $product->stock-$quantity;
            $data['stock']=$product->stock;
            Product::where("id", $product_id)->update($data);
        }


    }

}
