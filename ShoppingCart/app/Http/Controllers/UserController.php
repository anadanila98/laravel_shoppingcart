<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getSignup(){
        return view('user.signup');
    }

    public function postSignup(Request $request){
        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4'
        ]);

        $user = new User([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'isAdmin'=>$request->input('isAdmin')
        ]);

        $user->save(); //save user to the database

        //loghez utilizatorul chiar dupa signup (dupa ce a fost creat)
        //pot testa asta mergand in url la /user/profile pentru a vedea ca pot accesa acea pagina
        //Auth::login($user);

//        //dupa ce utilizatorul isi creeaza cont vrem sa il lasam sa continue cu checkout
//        if (Session::has('oldUrl')) {
//            $oldUrl = Session::get('oldUrl');
//            Session::forget('oldUrl');
//            return redirect()->to($oldUrl);
//        }


        return redirect()->route('user.signin');
    }


    public function getSignin(){
        return view('user.signin');
    }


    public function postSignin(Request $request){


        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){

//            if (Session::has('oldUrl')) {
//
//                $oldUrl = Session::get('oldUrl');
//                Session::forget('oldUrl');
//                return redirect()->to($oldUrl);
//            }
            $userdata=Auth::user()->toArray();
            Session::put('email', $userdata['email']);
            Session::put('id', $userdata['id']);
            if($userdata['isAdmin']==1){
                return redirect()->route('admin_home');
            }
            else{
                return redirect()->route('product.index');
            }


        }

        return redirect()->back();


    }


    public function getProfile(){
        return view('user.profile');
    }


    public function getLogout(){
        Auth::logout();
        return redirect()->route('user.signin');
    }

}


//email|required|unique:users  is a Laravel validation style, it checks the email to actually be an email, not to be empty and to be unique in users table

//required|min:4  => password should be required and have a minimum length of 4

//bcrypt este o metoda Laravel pentru a cripta parolele
