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

	Route::get('/countries', 'Admin\CountriesController@index')->name('admin.countries');
	Route::get('/countries/add', 'Admin\CountriesController@create')->name('admin.countries.add');
	Route::post('/countries/doadd', 'Admin\CountriesController@doadd')->name('admin.countries.doadd');
	Route::get('/countries/edit/{lang}/{id}', 'Admin\CountriesController@edit')->name('admin.countries.edit');
	Route::post('/countries/update/{lang}/{id}', 'Admin\CountriesController@update')->name('admin.countries.update');
	Route::delete('/countries/del/{lang}/{id}', 'Admin\CountriesController@doDelete')->name('admin.countries.del');
	Route::get('/countries/status/{id}', 'Admin\CountriesController@change_status')->name('admin.countries.status');

	

	