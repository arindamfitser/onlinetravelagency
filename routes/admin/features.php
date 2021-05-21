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
    Route::get('/features', 'Admin\FeaturesController@index')->name('admin.features');
    Route::get('/features/add', 'Admin\FeaturesController@create')->name('admin.features.add');
    Route::post('/features/doadd', 'Admin\FeaturesController@doadd')->name('admin.features.doadd');
    Route::get('/features/edit/{id}', 'Admin\FeaturesController@edit')->name('admin.features.edit');
    Route::post('/features/update/{id}', 'Admin\FeaturesController@update')->name('admin.features.update');
    Route::delete('/features/del/{id}', 'Admin\FeaturesController@doDelete')->name('admin.features.del');

	
