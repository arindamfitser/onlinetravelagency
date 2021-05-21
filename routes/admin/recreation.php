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
    Route::get('/recreation', 'Admin\RecreationController@index')->name('admin.recreation');
    Route::get('/recreation/add', 'Admin\RecreationController@create')->name('admin.recreation.add');
    Route::post('/recreation/doadd', 'Admin\RecreationController@doadd')->name('admin.recreation.doadd');
    Route::get('/recreation/edit/{id}', 'Admin\RecreationController@edit')->name('admin.recreation.edit');
    Route::post('/recreation/update/{id}', 'Admin\RecreationController@update')->name('admin.recreation.update');
    Route::delete('/recreation/del/{id}', 'Admin\RecreationController@doDelete')->name('admin.recreation.del');

	
