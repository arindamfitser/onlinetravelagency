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
Route::get('/accommodations', 'Admin\AccommodationsController@index')->name('admin.accommodations');
	Route::get('/accommodations/add', 'Admin\AccommodationsController@create')->name('admin.accommodations.add');
	Route::post('/accommodations/doadd', 'Admin\AccommodationsController@doadd')->name('admin.accommodations.doadd');
	Route::get('/accommodations/edit/{lang}/{id}', 'Admin\AccommodationsController@edit')->name('admin.accommodations.edit');
	Route::post('/accommodations/update/{lang}/{id}', 'Admin\AccommodationsController@update')->name('admin.accommodations.update');
	Route::delete('/accommodations/del/{lang}/{id}', 'Admin\AccommodationsController@doDelete')->name('admin.accommodations.del');
	Route::get('/accommodations/status/{id}', 'Admin\AccommodationsController@change_status')->name('admin.accommodations.status');
	