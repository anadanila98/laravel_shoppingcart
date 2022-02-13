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
    
    public function getAddToCart(Request $request, $id)
    {
        //laravel prima data ne da requestul primit si is-ul rpdusului care este trimis impreuna cu requestul
        //facem un fetch al produsului pe care vrem sa il adaugam in cos
        
        $product = Product::find($id);
        //apoi vrem sa creem un cart in sesiunea noastra curenta
        //folosim o instanta a modelului Cart
        
        //vom obtine cartul vechi, daca avem unul (daca sesiunea curenta are o cheie numita cart, iar daca are atunci il vom obtine, altfel il initializam pe oldCart cu null
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        /*if (!session()->has('cart')) {
            $oldCart = Session::get('cart');
        }
        else {
            $oldCart = null;
        }*/
        
        //creez si un nou cart si adaug produsul selectat in el
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        
        //apoi creez un request ca sesiune in care pun cartul curent si il serializez?
        $request->session()->put('cart', $cart);
        //pentru a vedea daca functionalitatea asta merge voi face temporar un ddump (pt testing purposes) care practic opreste programul si afiseaza un mesaj
        //dd($request->session()->get('cart'));
        return redirect()->route('product.index');
    }
    
    
    public function getReduceByOne($id) 
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        }
        else {
            Session::forget('cart');
            //deletes the cart
        }
    
        return redirect()->route('product.shoppingCart');
    }
    
    public function getIncreaseByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->increaseByOne($id);
        Session::put('cart', $cart);
        return redirect()->route('product.shoppingCart');
    }
    
    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        }
        else {
            Session::forget('cart');
            //deletes the cart
        }
       
        return redirect()->route('product.shoppingCart');
    }
    
    public function getRemoveAll()
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeAll();
        Session::forget('cart');
        return redirect()->route('product.shoppingCart');
    }
    
    public function getCart()
    {
        // vrem sa facem fetch la cart daca exista unul deja in sesiune
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }
    
    
    public function getCheckout()
    {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart'); //ne asiguram ca nu se poate ajunge la pagina de checkout daca nu ai produse in cos
        }
        
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout', ['total' => $total]); //ii trimitem si parametrul total
        
    }
    
    public function postCheckout(Request $request)
    {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        
        $order = new Order();
        $order->cart = serialize($cart);
        $order->address = $request->input('address');
        $order->name = $request->input('name');

        //utilizatorul trebuie sa fie logat
        //salvam orderul utilizatorului in baza de date
        Auth::user()->orders()->save($order);
        
        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Successfully purchased products!');
    }
    
}
