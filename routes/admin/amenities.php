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
    Route::get('/amenities', 'Admin\AmenitiesController@index')->name('admin.amenities');
	Route::get('/amenities/add', 'Admin\AmenitiesController@create')->name('admin.amenities.add');
	Route::post('/amenities/doadd', 'Admin\AmenitiesController@doadd')->name('admin.amenities.doadd');
	Route::get('/amenities/edit/{lang}/{id}', 'Admin\AmenitiesController@edit')->name('admin.amenities.edit');
	Route::post('/amenities/update/{lang}/{id}', 'Admin\AmenitiesController@update')->name('admin.amenities.update');
	Route::delete('/amenities/del/{lang}/{id}', 'Admin\AmenitiesController@doDelete')->name('admin.amenities.del');

	
