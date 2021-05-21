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
    Route::get('/species', 'Admin\SpeciesController@index')->name('admin.species');
	Route::get('/species/add', 'Admin\SpeciesController@create')->name('admin.species.add');
	Route::post('/species/doadd', 'Admin\SpeciesController@doadd')->name('admin.species.doadd');
	Route::get('/species/edit/{lang}/{id}', 'Admin\SpeciesController@edit')->name('admin.species.edit');
	Route::post('/species/update/{lang}/{id}', 'Admin\SpeciesController@update')->name('admin.species.update');
	Route::delete('/species/del/{lang}/{id}', 'Admin\SpeciesController@doDelete')->name('admin.species.del');
	Route::get('/species/status/{id}', 'Admin\SpeciesController@change_status')->name('admin.species.status');

	