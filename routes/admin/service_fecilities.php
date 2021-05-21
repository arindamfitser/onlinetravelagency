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
    Route::get('/service_facilities', 'Admin\ServiceFacilities@index')->name('admin.service_facilities');
    Route::get('/service_facilities/add', 'Admin\ServiceFacilities@create')->name('admin.service_facilities.add');
    Route::post('/service_facilities/doadd', 'Admin\ServiceFacilities@doadd')->name('admin.service_facilities.doadd');
    Route::get('/service_facilities/edit/{id}', 'Admin\ServiceFacilities@edit')->name('admin.service_facilities.edit');
    Route::post('/service_facilities/update/{id}', 'Admin\ServiceFacilities@update')->name('admin.service_facilities.update');
    Route::delete('/service_facilities/del/{id}', 'Admin\ServiceFacilities@doDelete')->name('admin.service_facilities.del');

	
