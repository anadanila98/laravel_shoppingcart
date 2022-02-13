<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', [
    'uses' => 'ProductController@getIndex',
    'as' => 'product.index'
]);
///old version
//Route::get('/add-to-cart/{id}', [
//    'uses' => 'ProductController@getAddToCart',
//    'as' => 'product.addToCart'
//]);
//new version
Route::get('/add-to-cart/{id}', [
    'uses' => 'ShopcartController@AddToCart',
    'as' => 'shopcart.addToCart'
]);
//old version
//Route::get('/shopping-cart', [
//    'uses' => 'ProductController@getCart',
//    'as' => 'product.shoppingCart'
//]);
//new version
Route::get('/shopping-cart', [
    'uses' => 'ShopcartController@getShopcart',
    'as' => 'shopcart.shoppingCart'
]);
//old version
//Route::get('/increase/{id}', [
//    'uses' => 'ProductController@getIncreaseByOne',
//    'as' => 'product.increaseByOne'
//]);
Route::get('/increase/{id}/{cart_id}', [
    'uses' => 'ShopcartController@increaseByOne',
    'as' => 'shopcart.increaseByOne'
]);
//old version
//Route::get('/reduce/{id}', [
//    'uses' => 'ProductController@getReduceByOne',
//    'as' => 'product.reduceByOne'
//]);

Route::get('/reduce/{id}/{cart_id}', [
    'uses' => 'ShopcartController@reduceByOne',
    'as' => 'shopcart.reduceByOne'
]);
//old version
//Route::get('/remove/{id}', [
//    'uses' => 'ProductController@getRemoveItem',
//    'as' => 'product.removeItem'
//]);
Route::get('/remove/{id}/{cart_id}', [
    'uses' => 'ShopcartController@removeItem',
    'as' => 'shopcart.removeItem'
]);
//old version
//Route::get('/removeAll', [
//   'uses' => 'ProductController@getRemoveAll',
//    'as' => 'product.removeAll'
//]);
Route::get('/removeAll/{cart_id}', [
    'uses' => 'ShopcartController@removeAll',
    'as' => 'shopcart.removeAll'
]);
//old version


Route::post('/checkout', [
    'uses' => 'ShopcartController@postCheckout',
    'as' => 'checkout',
    'middleware' => 'auth'
]);

Route::group(['prefix' => 'user'], function () {

    Route::group(['middleware' => 'guest'], function () {

        Route::get('/signup', [
            'uses' => 'UserController@getSignup',
            'as' => 'user.signup'

        ]);

        Route::post('/signup', [
            'uses' => 'UserController@postSignup',
            'as' => 'user.signup'
        ]);

        Route::get('/signin', [
            'uses' => 'UserController@getSignin',
            'as' => 'user.signin'
        ]);

        Route::post('/signin', [
            'uses' => 'UserController@postSignin',
            'as' => 'user.signin'
        ]);

    });

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/logout', [
            'uses' => 'UserController@getLogout',
            'as' => 'user.logout'
        ]);

    });

});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/checkoutform/{cart_id}/{totalPrice}', "ShopcartController@getCheckout")->name('checkoutform');
    Route::get('/admin', "AdminController@homee")->name('admin_home');
    Route::get('/admin/products_list', "AdminController@all_products")->name('products_list');
    Route::get('/admin/add_product', "AdminController@add_product")->name('add_product');
    Route::post('/admin/update_delete_product', "AdminController@update_delete_product")->name('update_delete_product');
    Route::get('/admin/product_details/{id}', "AdminController@product_details")->name('product_details');
    Route::post('/admin/insert_product', "AdminController@insert_product")->name('insert_product');
    Route::get('/admin/users_list', "AdminController@all_users")->name('users_list');
    Route::post('/admin/give_remove_right', "AdminController@give_remove_right")->name('give_remove_right');
});

