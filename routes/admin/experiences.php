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
    Route::get('/experiences', 'Admin\ExperiencesController@index')->name('admin.experiences');
	Route::get('/experiences/add', 'Admin\ExperiencesController@create')->name('admin.experiences.add');
	Route::post('/experiences/doadd', 'Admin\ExperiencesController@doadd')->name('admin.experiences.doadd');
	Route::get('/experiences/edit/{lang}/{id}', 'Admin\ExperiencesController@edit')->name('admin.experiences.edit');
	Route::post('/experiences/update/{lang}/{id}', 'Admin\ExperiencesController@update')->name('admin.experiences.update');
	Route::delete('/experiences/del/{lang}/{id}', 'Admin\ExperiencesController@doDelete')->name('admin.experiences.del');

	
