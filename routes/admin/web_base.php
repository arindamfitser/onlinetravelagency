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
	Route::post('/setlang', 'Admin\AdminController@setlang')->name('admin.setlang');
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

	Route::get('/users', 'Admin\UsersController@index')->name('admin.users');
	Route::get('/users/{username}', 'Admin\UsersController@edit')->name('admin.user.edit');
	Route::post('/users/{user}', 'Admin\UsersController@update')->name('admin.user.update');
	
	Route::get('/pages', 'Admin\PagesController@index')->name('admin.pages');
	Route::get('/pages/add', 'Admin\PagesController@create')->name('admin.pages.add');
	Route::post('/pages/doadd', 'Admin\PagesController@doCreate')->name('admin.pages.doadd');
	Route::get('/pages/edit/{lang}/{id}', 'Admin\PagesController@PageComposer')->name('admin.pages.edit');
	Route::get('/pages/builder/{lang}/{id}', 'Admin\PagesController@PageEdit')->name('admin.pages.builder');
	Route::post('/pages/update', 'Admin\PagesController@doDpdate')->name('admin.pages.update');
	Route::post('/pages/change/status', 'Admin\PagesController@doChange')->name('admin.pages.change.status');
    Route::post('/pages/del/{lang}/{id}', 'Admin\PagesController@doDelete')->name('admin.pages.del');

	Route::get('/posts', 'Admin\PostsController@index')->name('admin.posts');
	Route::get('/posts/add', 'Admin\PostsController@create')->name('admin.posts.add');
	Route::post('/posts/doadd', 'Admin\PostsController@doCreate')->name('admin.posts.doadd');
	Route::get('/posts/edit/{lang}/{id}', 'Admin\PostsController@postEdit')->name('admin.posts.edit');
	Route::post('/posts/update', 'Admin\PostsController@doDpdate')->name('admin.posts.update');
	Route::post('/posts/change/status', 'Admin\PostsController@doChange')->name('admin.posts.change.status');
	Route::post('/posts/del/{lang}/{id}', 'Admin\PostsController@doDelete')->name('admin.posts.del');

	Route::get('/banners', 'Admin\BannersController@index')->name('admin.banners');
	Route::get('/banners/add', 'Admin\BannersController@create')->name('admin.banners.add');
	Route::post('/banners/doadd', 'Admin\BannersController@doCreate')->name('admin.banners.doadd');
	Route::get('/banners/edit/{lang}/{id}', 'Admin\BannersController@edit')->name('admin.banners.edit');
	Route::post('/banners/update/{lang}/{id}', 'Admin\BannersController@update')->name('admin.banners.update');
	Route::delete('/banners/del/{lang}/{id}', 'Admin\BannersController@doDelete')->name('admin.banners.del');

	Route::get('/countries', 'Admin\CountriesController@index')->name('admin.countries');
	Route::get('/countries/add', 'Admin\CountriesController@create')->name('admin.countries.add');
	Route::post('/countries/doadd', 'Admin\CountriesController@doadd')->name('admin.countries.doadd');
	Route::get('/countries/edit/{lang}/{id}', 'Admin\CountriesController@edit')->name('admin.countries.edit');
	Route::post('/countries/update/{lang}/{id}', 'Admin\CountriesController@update')->name('admin.countries.update');
	Route::delete('/countries/del/{lang}/{id}', 'Admin\CountriesController@doDelete')->name('admin.countries.del');

	Route::get('/states', 'Admin\StatesController@index')->name('admin.states');
	Route::get('/states/add', 'Admin\StatesController@create')->name('admin.states.add');
	Route::post('/states/doadd', 'Admin\StatesController@doadd')->name('admin.states.doadd');
	Route::get('/states/edit/{lang}/{id}', 'Admin\StatesController@edit')->name('admin.states.edit');
	Route::post('/states/update/{lang}/{id}', 'Admin\StatesController@update')->name('admin.states.update');
	Route::delete('/states/del/{lang}/{id}', 'Admin\StatesController@doDelete')->name('admin.states.del');

	Route::get('/testimonials', 'Admin\TestimonialsController@index')->name('admin.testimonials');
	Route::get('/testimonials/add', 'Admin\TestimonialsController@create')->name('admin.testimonials.add');
	Route::post('/testimonials/doadd', 'Admin\TestimonialsController@doadd')->name('admin.testimonials.doadd');
	Route::get('/testimonials/edit/{lang}/{id}', 'Admin\TestimonialsController@edit')->name('admin.testimonials.edit');
	Route::post('/testimonials/update/{lang}/{id}', 'Admin\TestimonialsController@update')->name('admin.testimonials.update');
	Route::delete('/testimonials/del/{lang}/{id}', 'Admin\TestimonialsController@doDelete')->name('admin.testimonials.del');

	Route::get('/accommodations', 'Admin\AccommodationsController@index')->name('admin.accommodations');
	Route::get('/accommodations/add', 'Admin\AccommodationsController@create')->name('admin.accommodations.add');
	Route::post('/accommodations/doadd', 'Admin\AccommodationsController@doadd')->name('admin.accommodations.doadd');
	Route::get('/accommodations/edit/{lang}/{id}', 'Admin\AccommodationsController@edit')->name('admin.accommodations.edit');
	Route::post('/accommodations/update/{lang}/{id}', 'Admin\AccommodationsController@update')->name('admin.accommodations.update');
	Route::delete('/accommodations/del/{lang}/{id}', 'Admin\AccommodationsController@doDelete')->name('admin.accommodations.del');

	Route::get('/species', 'Admin\SpeciesController@index')->name('admin.species');
	Route::get('/species/add', 'Admin\SpeciesController@create')->name('admin.species.add');
	Route::post('/species/doadd', 'Admin\SpeciesController@doadd')->name('admin.species.doadd');
	Route::get('/species/edit/{lang}/{id}', 'Admin\SpeciesController@edit')->name('admin.species.edit');
	Route::post('/species/update/{lang}/{id}', 'Admin\SpeciesController@update')->name('admin.species.update');
	Route::delete('/species/del/{lang}/{id}', 'Admin\SpeciesController@doDelete')->name('admin.species.del');

	Route::get('/inspirations', 'Admin\InspirationsController@index')->name('admin.inspirations');
	Route::get('/inspirations/add', 'Admin\InspirationsController@create')->name('admin.inspirations.add');
	Route::post('/inspirations/doadd', 'Admin\InspirationsController@doadd')->name('admin.inspirations.doadd');
	Route::get('/inspirations/edit/{lang}/{id}', 'Admin\InspirationsController@edit')->name('admin.inspirations.edit');
	Route::post('/inspirations/update/{lang}/{id}', 'Admin\InspirationsController@update')->name('admin.inspirations.update');
	Route::delete('/inspirations/del/{lang}/{id}', 'Admin\InspirationsController@doDelete')->name('admin.inspirations.del');

	Route::get('/experiences', 'Admin\ExperiencesController@index')->name('admin.experiences');
	Route::get('/experiences/add', 'Admin\ExperiencesController@create')->name('admin.experiences.add');
	Route::post('/experiences/doadd', 'Admin\ExperiencesController@doadd')->name('admin.experiences.doadd');
	Route::get('/experiences/edit/{lang}/{id}', 'Admin\ExperiencesController@edit')->name('admin.experiences.edit');
	Route::post('/experiences/update/{lang}/{id}', 'Admin\ExperiencesController@update')->name('admin.experiences.update');
	Route::delete('/experiences/del/{lang}/{id}', 'Admin\ExperiencesController@doDelete')->name('admin.experiences.del');

	Route::get('/hotels', 'Admin\HotelsController@index')->name('admin.hotels');
	Route::post('/hotels/uploadcsv', 'Admin\HotelsController@uploadcsv')->name('admin.hotels.uploadcsv');

	Route::get('/regions', 'Admin\RegionsController@index')->name('admin.regions');
	Route::get('/regions/add', 'Admin\RegionsController@create')->name('admin.regions.add');
	Route::post('/regions/doadd', 'Admin\RegionsController@doadd')->name('admin.regions.doadd');
	Route::get('/regions/edit/{lang}/{id}', 'Admin\RegionsController@edit')->name('admin.regions.edit');
	Route::post('/regions/update/{lang}/{id}', 'Admin\RegionsController@update')->name('admin.regions.update');
	Route::delete('/regions/del/{lang}/{id}', 'Admin\RegionsController@doDelete')->name('admin.regions.del');


