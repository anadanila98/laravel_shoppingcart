<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use Auth;
use phpDocumentor\Reflection\Types\False_;
use Session;
use App\Shopcart;
use App\Shopcartitem;
use App\Orderdetails;
use App\Orderitem;
use Illuminate\Support\Facades\DB;

class ShopcartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {
        //user.signin
        if (Session::get('id') == '') {
            return redirect()->route('user.signin');

        } else {


            //verificam daca mai avem vreun cart cu acest user_id si statusul cart-ului este activ
            $user_id = Session::get('id');
            $cart = DB::select('SELECT * from shopcarts where status="activ" AND user_id=' . $user_id);
            $product = Product::find($id);
            //daca e activ atunci adaugam doar in shopcartitems
            if (count($cart)>0) {
                $cartt_id=(array)$cart[0]->id;
                $cartt_id=$cartt_id[0];

                    //daca in shopcartitems mai gasim acelasi produs incrementam cantitatea
                    $cartitems = Shopcartitem::select('*')
                        ->where('cart_id', '=', $cartt_id)
                        ->where('product_id', '=', $id)
                        ->get();
                    if (count($cartitems) > 0) {
                        foreach ($cartitems as $cart) {

                            $id_shopitems = $cart->id;
                            $cart->quantity = $cart->quantity + 1;
                            $data['quantity'] = $cart->quantity;
                        }


                        Shopcartitem::where("id", $id_shopitems)->update($data);

                    } else {
                        $shopcartitems = new Shopcartitem();
                        $shopcartitems->add($cartt_id, $product->id);
                    }


            } else {
//                dd('inca nu am cart'.$user_id);
                $shopcart = new Shopcart();
                $shopcart->add($user_id);
                $shopcartitems = new Shopcartitem();
//                $cart = DB::table('shopcarts')->where('user_id', $user_id)->first();
                $cart = DB::select('SELECT * from shopcarts where status="activ" AND user_id=' . $user_id);
                $cart_id=(array)$cart[0]->id;
                $cart_id=$cart_id[0];
                $shopcartitems->add($cart_id, $product->id);
            }
            $cart_quantity = $this->sendCartQuantity();
            //return redirect()->route('product.index', ['quantity' => $cart_quantity]);
            $products = Product::all();  //fetch all the products
            //return view('shop.index', ['products' => $products])
            return view('shop.index', ['quantity' => $cart_quantity, 'products' => $products]);
        }
    }

    public function sendCartQuantity()
    {
        $user_id = Session::get('id');
        $products_quantity = DB::select('SELECT sum(quantity) as number_products from shopcartitems i INNER join shopcarts s where s.id=i.cart_id and s.status="activ" and user_id=' . $user_id);
        $number_products = (array)$products_quantity[0];
        return $number_products['number_products'];

    }

    public function getShopcart(Request $request)
    {
        $user_id = Session::get('id');

        $userShopcart = DB::select('SELECT *  from shopcarts where status="activ" AND user_id=' . $user_id);
        $cart_id = (array)$userShopcart[0]->id;
        $userShopitems = DB::select('SELECT *  from shopcartitems i INNER join products p where i.product_id=p.id and i.cart_id=' . $cart_id[0]);
        $productsTosend = [];
        $totalPrice = 0;
        foreach ($userShopitems as $key => $iteminCart) {
//            dd($iteminCart);
            $productsTosend[$iteminCart->product_id]['product_id'] = $iteminCart->product_id;
            $productsTosend[$iteminCart->product_id]['title'] = $iteminCart->title;
            $productsTosend[$iteminCart->product_id]['description'] = $iteminCart->description;
            $productsTosend[$iteminCart->product_id]['stock'] = $iteminCart->stock;
            $productsTosend[$iteminCart->product_id]['quantity'] = $iteminCart->quantity;
            $productsTosend[$iteminCart->product_id]['price'] = $iteminCart->price * $iteminCart->quantity;
            $productsTosend[$iteminCart->product_id]['cart_id'] = $cart_id[0];
            $totalPrice = $totalPrice + $productsTosend[$iteminCart->product_id]['price'];
        }
//        dd($cart_id[0]);
        return view('shop.shopping-cart', ['products' => $productsTosend, 'totalPrice' => $totalPrice, 'cart_id' => $cart_id[0]]);
    }

    public function increaseByOne(Request $request, $id, $cart_id)
    {
        $shopcartitem = new Shopcartitem();
        $shopcartitem->increaseQuantity($cart_id, $id);
        return redirect()->route('shopcart.shoppingCart');
    }

    public function reduceByOne(Request $request, $id, $cart_id)
    {
        $shopcartitem = new Shopcartitem();
        $shopcartitem->reduceQuantity($cart_id, $id);
        return redirect()->route('shopcart.shoppingCart');
    }

    public function removeItem(Request $request, $id, $cart_id)
    {
        $shopcartitem = new Shopcartitem();
        $shopcartitem->removeItem($cart_id, $id);
        return redirect()->route('shopcart.shoppingCart');
    }

    public function removeAll(Request $request, $cart_id)
    {
        $shopcartitem = new Shopcartitem();
        $shopcartitem->removeAll($cart_id);
        return redirect()->route('shopcart.shoppingCart');
    }

    public function check_product($product_id, $quantity)
    {
        $products = Product::select('*')
            ->where('id', '=', $product_id)
            ->get();
        $without_stock = [];
        foreach ($products as $product) {

            if ($product->stock < $quantity) {
                $without_stock[$product->id] = $product->title;
            } else {
                continue;
            }
        }
        return $without_stock;
    }

    public function check_stock($cart_id)
    {
        $no_stock = [];
        $cartitems = Shopcartitem::select('*')
            ->where('cart_id', '=', $cart_id)
            ->get();
        foreach ($cartitems as $cart) {
            $product_id = $cart->product_id;
            //$this->check_product($product_id, $cart->quantity);
            if (count($this->check_product($product_id, $cart->quantity)) > 0) {
                $no_stock[] = $this->check_product($product_id, $cart->quantity);
            }

        }
        if (count($no_stock) > 0) {
            return false;
        } else {
            return true;
        }

    }

    public function getCheckout(Request $request, $cart_id, $totalPrice)
    {
        if (!$this->check_stock($cart_id)) {
            return redirect()->route('shopcart.shoppingCart')->with('error', 'No stock!');;
        } else {
            return view('shop.checkout', ['totalPrice' => $totalPrice, 'cart_id' => $cart_id]); //ii trimitem si parametrul total
        }


    }

    public function postCheckout(Request $request)
    {
        $data = $request->all();
        if ($request->isMethod('post')) {
            $orderDetails = new Orderdetails();
            $orderDetails->user_id = Session::get('id');
            $orderDetails->total = $data['total'];
            $orderDetails->address = $data['address'];
            $orderDetails->save();
            $order_id = $orderDetails->id;
            $cartitems = Shopcartitem::select('*')
                ->where('cart_id', '=', $data['cart_id'])
                ->get();
            $orderItem = new Orderitem();
            foreach ($cartitems as $cart) {
                $orderItem->order_id = $order_id;
                $orderItem->product_id = $cart->product_id;
                $product_stock = new Product();
                $product_stock->removefromStock($orderItem->product_id, $cart->quantity);

                $orderItem->save();

            }
            $shopcart=new Shopcart();
            $shopcart->update_shopcart_status($data['cart_id']);
            return redirect()->route('product.index')->with('success', 'Successfully purchased products!');
        }

    }


}

?>
