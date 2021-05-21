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

	Route::get('/pages', 'Admin\PagesController@index')->name('admin.pages');
	Route::get('/pages/add', 'Admin\PagesController@create')->name('admin.pages.add');
	Route::post('/pages/doadd', 'Admin\PagesController@doCreate')->name('admin.pages.doadd');
	Route::get('/pages/edit/{lang}/{id}', 'Admin\PagesController@PageComposer')->name('admin.pages.edit');
	Route::get('/pages/builder/{lang}/{id}', 'Admin\PagesController@PageEdit')->name('admin.pages.builder');
	Route::post('/pages/update', 'Admin\PagesController@doDpdate')->name('admin.pages.update');
	Route::get('/pages/change/{lang}/{id}/{st}', 'Admin\PagesController@doChange')->name('admin.pages.change');
    Route::get('/pages/del/{lang}/{id}', 'Admin\PagesController@doDelete')->name('admin.pages.del');
    Route::post('/pages/preview', 'Admin\PagesController@doPreview')->name('admin.pages.preview');

	