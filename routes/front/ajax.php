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
Route::post('/ajax/profile/update', 'Ajax\ProfileController@DoUpdateProfile')->name('ajax.profile.update');
Route::post('/ajax/hotelier/profile/update', 'Ajax\ProfileController@DoUpdateProfileHotelier')->name('ajax.hotelier.profile.update');
Route::post('/ajax/profile/change_pass', 'Ajax\ProfileController@DoChangePassword')->name('ajax.profile.changepass');
Route::post('/ajax/profile/change_pass/hotelier', 'Ajax\ProfileController@DoChangePasswordHotelier')->name('ajax.profile.changepass.hotelier');
Route::get('/ajax/checkemail', 'Ajax\AjaxController@checkUserEmail')->name('ajax.email.check');
Route::post('/ajax/send/contact', 'Ajax\AjaxController@doSendcontact')->name('ajax.send.contact');
Route::get('/ajax/suggest/region', 'Ajax\AjaxController@suggestRegion')->name('ajax.get.region');
Route::post('/ajax/booking/paypal/process', 'Ajax\BookingController@rxmlBookingProcess')->name('ajax.booking.paypal.process');
Route::post('/stuba/booking/cancel/prepare', 'Ajax\BookingController@stubaCancelPrepare')->name('stuba.booking.cancel.prepare');
Route::post('/stuba/booking/cancel/confirm', 'Ajax\BookingController@stubaCancelConfirm')->name('stuba.booking.cancel.confirm');
Route::post('/search/image/carousel', 'Ajax\AjaxController@searchImageCarousel')->name('search.image.carousel');
Route::post('/fetch/search/hotel/image', 'Ajax\AjaxController@fetchSearchHotelImage')->name('fetch.search.hotel.image');