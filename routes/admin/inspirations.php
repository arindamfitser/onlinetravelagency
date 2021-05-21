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
    Route::get('/inspirations', 'Admin\InspirationsController@index')->name('admin.inspirations');
	Route::get('/inspirations/add', 'Admin\InspirationsController@create')->name('admin.inspirations.add');
	Route::post('/inspirations/doadd', 'Admin\InspirationsController@doadd')->name('admin.inspirations.doadd');
	Route::get('/inspirations/edit/{lang}/{id}', 'Admin\InspirationsController@edit')->name('admin.inspirations.edit');
	Route::post('/inspirations/update/{lang}/{id}', 'Admin\InspirationsController@update')->name('admin.inspirations.update');
	Route::delete('/inspirations/del/{lang}/{id}', 'Admin\InspirationsController@doDelete')->name('admin.inspirations.del');
	Route::get('/inspirations/status/{id}', 'Admin\InspirationsController@change_status')->name('admin.inspirations.status');

	