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
    Route::get('/category', 'Admin\RoomCategories@index')->name('admin.category');
    Route::get('/category/add', 'Admin\RoomCategories@create')->name('admin.category.add');
    Route::post('/category/doadd', 'Admin\RoomCategories@doadd')->name('admin.category.doadd');
    Route::get('/category/edit/{id}', 'Admin\RoomCategories@edit')->name('admin.category.edit');
    Route::post('/category/update/{id}', 'Admin\RoomCategories@update')->name('admin.category.update');
    Route::delete('/category/del/{id}', 'Admin\RoomCategories@doDelete')->name('admin.category.del');

	
