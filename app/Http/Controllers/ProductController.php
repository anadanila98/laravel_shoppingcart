<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use Auth;
use Session;
use App\Cart;

class ProductController extends Controller
{
    public function getIndex()
    {
        $products = Product::all();  //fetch all the products
        return view('shop.index', ['products' => $products]);  //returneaza view-ul shop.index.php si creaza o variabila noua 'products' care primeste toate produsele
    }



}
