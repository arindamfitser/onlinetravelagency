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

Route::get('/bookings', 'Admin\BookingController@index')->name('admin.bookings');
Route::get('/bookings/{id}', 'Admin\BookingController@show')->name('admin.bookings.details');