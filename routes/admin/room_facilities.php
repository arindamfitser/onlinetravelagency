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
    Route::get('/room_facilities', 'Admin\RoomFacilitiesController@index')->name('admin.room_facilities');
    Route::get('/room_facilities/add', 'Admin\RoomFacilitiesController@create')->name('admin.room_facilities.add');
    Route::post('/room_facilities/doadd', 'Admin\RoomFacilitiesController@doadd')->name('admin.room_facilities.doadd');
    Route::get('/room_facilities/edit/{id}', 'Admin\RoomFacilitiesController@edit')->name('admin.room_facilities.edit');
    Route::post('/room_facilities/update/{id}', 'Admin\RoomFacilitiesController@update')->name('admin.room_facilities.update');
    Route::delete('/room_facilities/del/{id}', 'Admin\RoomFacilitiesController@doDelete')->name('admin.room_facilities.del');

	
