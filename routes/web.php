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


Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
	
	require(base_path() . '/routes/front/front_base.php');

});


Route::prefix('admin')->group(function()
{
	require(base_path() . '/routes/admin/admin_base.php');

});

Route::get('/clear/cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return "Cache is cleared";
});

