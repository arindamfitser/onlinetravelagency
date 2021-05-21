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


	Route::get('/banners', 'Admin\BannersController@index')->name('admin.banners');
	Route::get('/banners/add', 'Admin\BannersController@create')->name('admin.banners.add');
	Route::post('/banners/doadd', 'Admin\BannersController@doCreate')->name('admin.banners.doadd');
	Route::get('/banners/edit/{lang}/{id}', 'Admin\BannersController@edit')->name('admin.banners.edit');
	Route::post('/banners/update/{lang}/{id}', 'Admin\BannersController@update')->name('admin.banners.update');
	Route::delete('/banners/del/{lang}/{id}', 'Admin\BannersController@doDelete')->name('admin.banners.del');


	