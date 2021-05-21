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
Route::get('/partners', 'Admin\PartnersController@index')->name('admin.partners');
	Route::get('/partners/add', 'Admin\PartnersController@create')->name('admin.partners.add');
	Route::post('/partners/doadd', 'Admin\PartnersController@doadd')->name('admin.partners.doadd');
	Route::get('/partners/edit/{id}', 'Admin\PartnersController@edit')->name('admin.partners.edit');
	Route::post('/partners/update/{id}', 'Admin\PartnersController@update')->name('admin.partners.update');
	Route::delete('/partners/del/{id}', 'Admin\PartnersController@doDelete')->name('admin.partners.del');
	Route::get('/partners/status/{id}', 'Admin\PartnersController@change_status')->name('admin.partners.status');
	