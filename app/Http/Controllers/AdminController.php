<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Product;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function homee()
    {
        return view('admin.admin_home');
    }

    public function all_products()
    {
        $products = Product::all();  //fetch all the products
        return view('admin.products_list', ['products' => $products]);
    }

    public function add_product()
    {
        return view('admin.add_product');
    }

    public function insert_product(Request $request)
    {
        $product = new Product();
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->stock = $request->input('stock');
        $file = $request->file('image');
        $name = date("Y-m-d") . $file->getClientOriginalName();;
        $file = $file->move('uploads/', $name);
        $product->imagePath = '/uploads/' . $name;
        $product->save();
        return redirect()->action('AdminController@all_products');
    }

    public function product_details($id = false)
    {
        $product = DB::select('SELECT * from products where id=' . $id);
        $product = $product['0'];
        $product = (array)$product;
        return view('admin/product_details', ['product' => $product]);
    }

    public function update_delete_product(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $id = $data['id'];
            //UPDATE
            if ($data['action'] == 'update') {
                $file = $request->file('image');
                $name = date("Y-m-d") . $file->getClientOriginalName();;
                $file = $file->move('uploads/', $name);
                $data['imagePath'] = '/uploads/' . $name;
                unset($data['_token']);
                unset($data['image']);
                unset($data['action']);
                unset($data['id']);
                Product::where("id", $id)->update($data);
            } //DELETE
            else {
                Product::find($id)->delete();
            }
        }
        return redirect()->action('AdminController@all_products');
    }
    public function all_users()
    {
        $users = User::all();
        return view('admin.users_list', ['users' => $users]);
    }
    public function give_remove_right(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->all();
            $id = $data['user_id'];
            //UPDATE
            if ($data['action_u'] == 'approve') {
                unset($data);
                $data['isAdmin']=1;
                User::where("id", $id)->update($data);
            } //DELETE
            else {
                unset($data);
                $data['isAdmin']=0;
                User::where("id", $id)->update($data);
            }
        }
        return redirect()->action('AdminController@all_users');
    }

}



