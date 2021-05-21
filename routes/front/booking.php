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


Route::post('/booking/process', 'Ajax\BookingController@bookingProcess')->name('hotel.booking.process');
Route::get('/payment/checkout/', 'PaymentController@checkout')->name('booking.payment.checkout');
//Route::post('/payment/checkout/process', 'PaymentController@checkoutProcessBraintree')->name('payment.checkout.process');
Route::post('/payment/checkout/process', 'PaymentController@checkoutProcessPaypalPro')->name('payment.checkout.process');

Route::post('/payment/checkout/cash', 'PaymentController@checkoutProcessCashon')->name('payment.checkout.cashon');
Route::get('/payment/checkout/cash', 'PaymentController@checkoutProcessCashon')->name('payment.checkout.cashon');
Route::post('/xmlbooking/{id}', 'XmlController@getBookingReq')->name('xmlbooking');
Route::post('/hotel/bookingsummery', 'XmlController@getBookingSummery')->name('bookingconfirm');
Route::post('/hotel/bookingconfirm', 'XmlController@bookingConfirm')->name('bookingconfirmpay');
Route::post('/hotelier/booking/process', 'Ajax\BookingController@hotelierBookingProcess')->name('hotelier.booking.process');
Route::post('/hotelier/payment/checkout/process', 'PaymentController@hotelierCheckoutProcessBraintree')->name('hotelier.payment.process');
Route::post('/hotelier/payment/checkout/cash', 'PaymentController@hotelierCheckoutProcessCashon')->name('hotelier.payment.cashon');

Route::post('/booking/confirm', 'Ajax\BookingController@bookingConfirmProcess')->name('hotel.booking.confirm');