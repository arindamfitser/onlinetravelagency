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

Route::post('/booking/cart', 'CartController@index')->name('hotel.cart');
Route::post('/booking/addtocart', 'Ajax\CartController@index')->name('hotel.addtocart');
Route::post('/booking/getcartdata', 'Ajax\CartController@getCartdata')->name('hotel.getcart');
Route::post('/booking/delcartitem', 'Ajax\CartController@doDeleteCartItem')->name('hotel.cart.item');
Route::post('/booking/paynow', 'Ajax\CartController@booking_paynow')->name('hotel.paynow');
