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
	Route::get('/settings/general', 'Admin\SettingsController@general_settings')->name('admin.settings.general');
	Route::post('/settings/general/save/{lang}', 'Admin\SettingsController@save_general_settings')->name('admin.settings.general.save');
