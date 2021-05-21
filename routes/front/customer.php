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
Route::get('/customer/booking', 'CustomerController@CustomerBooking')->name('customer.booking');
Route::get('/customer/membership', 'CustomerController@CustomerMembership')->name('customer.membership');
Route::get('/customer/offer', 'CustomerController@CustomerOffer')->name('customer.offer');
Route::get('/customer/wishlist', 'CustomerController@CustomerWishlist')->name('customer.wishlist');
Route::get('/customer/testimonial', 'CustomerController@CustomerTestimonial')->name('customer.testimonial');
Route::get('/customer/transactions', 'CustomerController@CustomerTransactions')->name('customer.transactions');
Route::delete('/customer/wishlist/del/{id}', 'CustomerController@delWhislist')->name('customer.wishlist.del');
Route::get('/customer/booking/{id}', 'CustomerController@show_booking')->name('customer.booking.details');
Route::post('/customer/testimonial/add', 'CustomerController@add_testimonial')->name('customer.testimonial.add');
Route::delete('/customer/testimonial/del/{id}', 'CustomerController@del_testimonial')->name('customer.testimonial.del');
