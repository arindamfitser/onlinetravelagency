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
Route::get('/hotels/search', 'SearchController@index')->name('hotels.search');
Route::get('/hotel/{slug}', 'SearchController@hotelDetails')->name('hotel.details');
Route::post('/hoteldetails/{id}', 'SearchController@xmlhotelDetails')->name('hotel.hoteldetails');
Route::get('/destinations/search', 'SearchController@byDestination')->name('destinations.search');
Route::post('/destinations/en-route/search', 'SearchController@destinationsEnroute')->name('enroute.search');
Route::post('/destinations/en-route/fetch/result', 'SearchController@destinationsEnrouteFetchResult')->name('enroute.fetch.result');
Route::post('/destinations/en-route/fetch/result/load/more', 'SearchController@destinationsEnrouteFetchResultLoadMore')->name('enroute.fetch.result.load.more');
Route::post('/destination/fetch/room', 'Ajax\AjaxController@destinationFetchRoom')->name('destination.fetch.room');
Route::post('hotel/add_review/{id}', 'ReviewController@add_review')->name('hotel.add_review');
Route::post('hotel/add/wishlist', 'Ajax\AjaxController@addWishlist')->name('hotel.add.wishlist');
Route::post('hotel/wishlist/get', 'Ajax\AjaxController@getWihlistbyUser')->name('hotel.get.wishlist');
Route::post('hotel/getmap', 'Ajax\AjaxController@getmap')->name('hotel.get.map');
Route::post('hotel/region', 'Ajax\AjaxController@get_region_data')->name('hotel.get.region');
Route::post('/region/{type}', 'SearchController@get_rg_type_data')->name('region.type_data');
Route::post('hotel/region/{type}', 'Ajax\AjaxController@get_region_type_data')->name('hotel.type.region');
Route::post('hotel/sort/order', 'Ajax\AjaxController@hotelSortOrder')->name('hotel.sort.order');
Route::post('/stuba/fetch/room', 'Ajax\AjaxController@stubaFetchRoom')->name('stuba.fetch.room');