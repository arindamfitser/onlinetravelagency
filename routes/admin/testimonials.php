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
Route::get('/testimonials', 'Admin\TestimonialsController@index')->name('admin.testimonials');
	Route::get('/testimonials/add', 'Admin\TestimonialsController@create')->name('admin.testimonials.add');
	Route::post('/testimonials/doadd', 'Admin\TestimonialsController@doadd')->name('admin.testimonials.doadd');
	Route::get('/testimonials/edit/{lang}/{id}', 'Admin\TestimonialsController@edit')->name('admin.testimonials.edit');
	Route::post('/testimonials/update/{lang}/{id}', 'Admin\TestimonialsController@update')->name('admin.testimonials.update');
	Route::delete('/testimonials/del/{lang}/{id}', 'Admin\TestimonialsController@doDelete')->name('admin.testimonials.del');
	Route::post('/testimonials/status/{lang}/{id}', 'Admin\TestimonialsController@change_status')->name('admin.testimonials.status');

	