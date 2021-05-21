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
    Route::get('/classification', 'Admin\ClassificationController@index')->name('admin.classification');
	Route::get('/classification/add', 'Admin\ClassificationController@create')->name('admin.classification.add');
	Route::post('/classification/doadd', 'Admin\ClassificationController@doadd')->name('admin.classification.doadd');
	Route::get('/classification/edit/{id}', 'Admin\ClassificationController@edit')->name('admin.classification.edit');
	Route::post('/classification/update/{id}', 'Admin\ClassificationController@update')->name('admin.classification.update');
	Route::delete('/classification/del/{id}', 'Admin\ClassificationController@doDelete')->name('admin.classification.del');

	