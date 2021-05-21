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

	Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
	Route::get('/dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
	Route::post('/setlang', 'Admin\AdminController@setlang')->name('admin.setlang');
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
	
	Route::get('/destination/image', 'Admin\DestinationImageController@index')->name('admin.destination.image');
	Route::get('/destination/image/edit/{id}', 'Admin\DestinationImageController@edit')->name('admin.destination.image.edit');
	Route::post('/destination/image/do/edit/{id}', 'Admin\DestinationImageController@doEdit')->name('admin.destination.image.do.edit');
	
	Route::get('/hotel/image', 'Admin\StubaHotelImageController@index')->name('admin.hotel.image');
	Route::post('/fetch/hotel/image', 'Admin\StubaHotelImageController@fetchImage')->name('admin.fetch.hotel.image');
	Route::get('/hotel/image/edit/{id}', 'Admin\StubaHotelImageController@edit')->name('admin.hotel.image.edit');
	Route::post('/hotel/image/do/edit/{id}', 'Admin\StubaHotelImageController@doEdit')->name('admin.hotel.image.do.edit');
	
	

    require(base_path() . '/routes/admin/users.php');
    require(base_path() . '/routes/admin/pages.php');
    require(base_path() . '/routes/admin/posts.php');
	require(base_path() . '/routes/admin/banners.php');
	require(base_path() . '/routes/admin/countries.php');
	require(base_path() . '/routes/admin/states.php');
	require(base_path() . '/routes/admin/testimonials.php');
	require(base_path() . '/routes/admin/accommodations.php');
	require(base_path() . '/routes/admin/species.php');
	require(base_path() . '/routes/admin/inspirations.php');
	require(base_path() . '/routes/admin/experiences.php');
	require(base_path() . '/routes/admin/hotels.php');
	require(base_path() . '/routes/admin/regions.php');
	require(base_path() . '/routes/admin/settings.php');
	require(base_path() . '/routes/admin/amenities.php');
	require(base_path() . '/routes/admin/classification.php');
	require(base_path() . '/routes/admin/room_category.php');
	require(base_path() . '/routes/admin/features.php');
	require(base_path() . '/routes/admin/service_fecilities.php');
	require(base_path() . '/routes/admin/room_facilities.php');
	require(base_path() . '/routes/admin/recreation.php');
	require(base_path() . '/routes/admin/partners.php');
	require(base_path() . '/routes/admin/booking.php');


