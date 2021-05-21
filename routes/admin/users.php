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

  Route::get('/customers', 'Admin\UsersController@index')->name('admin.users');
  Route::get('/hoteliers', 'Admin\UsersController@hoteliers')->name('admin.hoteliers');
  Route::get('/users/{user}', 'Admin\UsersController@edit')->name('admin.user.edit');
  Route::post('/users/update', 'Admin\UsersController@update')->name('admin.user.update');
  Route::post('/users/updatepass', 'Admin\UsersController@updatePassword')->name('admin.user.updatepass');
  Route::delete('/users/del/{id}', 'Admin\UsersController@del')->name('admin.user.del');
	
