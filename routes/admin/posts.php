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

	Route::get('/posts', 'Admin\PostsController@index')->name('admin.posts');
	Route::get('/posts/add', 'Admin\PostsController@create')->name('admin.posts.add');
	Route::post('/posts/doadd', 'Admin\PostsController@doCreate')->name('admin.posts.doadd');
	Route::get('/posts/edit/{lang}/{id}', 'Admin\PostsController@postEdit')->name('admin.posts.edit');
	Route::post('/posts/update', 'Admin\PostsController@doUpdate')->name('admin.posts.update');
	Route::get('/posts/change/{lang}/{id}/{st}', 'Admin\PostsController@doChange')->name('admin.posts.change');
	Route::get('/posts/del/{lang}/{id}', 'Admin\PostsController@doDelete')->name('admin.posts.del');

	