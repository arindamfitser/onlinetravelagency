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
Route::get('/states', 'Admin\StatesController@index')->name('admin.states');
	Route::get('/states/add', 'Admin\StatesController@create')->name('admin.states.add');
	Route::post('/states/doadd', 'Admin\StatesController@doadd')->name('admin.states.doadd');
	Route::get('/states/edit/{lang}/{id}', 'Admin\StatesController@edit')->name('admin.states.edit');
	Route::post('/states/update/{lang}/{id}', 'Admin\StatesController@update')->name('admin.states.update');
	Route::delete('/states/del/{lang}/{id}', 'Admin\StatesController@doDelete')->name('admin.states.del');

	