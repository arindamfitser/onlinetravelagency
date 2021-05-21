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

	Route::get('/packages/{id}', 'Admin\PackageController@index')->name('admin.packages');
/*	Route::get('/regions/add', 'Admin\RegionsController@create')->name('admin.regions.add');
	Route::post('/regions/doadd', 'Admin\RegionsController@doadd')->name('admin.regions.doadd');
	Route::get('/regions/edit/{lang}/{id}', 'Admin\RegionsController@edit')->name('admin.regions.edit');
	Route::post('/regions/update/{lang}/{id}', 'Admin\RegionsController@update')->name('admin.regions.update');
	Route::delete('/regions/del/{lang}/{id}', 'Admin\RegionsController@doDelete')->name('admin.regions.del');*/
	
	