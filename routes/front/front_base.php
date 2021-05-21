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
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
	Route::get('/', 'FrontController@index');
    Route::get('load/hotel/from/xml', 'LoadXmlController@hotel')->name('load.hotel');
    Route::get('load/address/from/xml', 'LoadXmlController@address')->name('load.address');
    Route::get('load/aminity/from/xml', 'LoadXmlController@aminity')->name('load.aminity');
    Route::get('load/description/from/xml', 'LoadXmlController@description')->name('load.description');
    Route::get('load/image/from/xml', 'LoadXmlController@image')->name('load.image');



    Route::get('test/email', 'LoadXmlController@testEmail')->name('test.email');
    Route::get('register-for-direct-contract/{code}', 'Admin\HotelsControllerNew@registerDirectContract')->name('register.ditect.contract');
    Route::post('register-new-direct-contract-hotel', 'Admin\HotelsControllerNew@registerNewDirectContractHotel')->name('register.new.direct.contract.hotel');


    Route::post('common/change/status', 'RoomsController@commonChangeStatus')->name('common.change.status');
    Route::post('hotelier/delete/gallery/image', 'RoomsController@hotelierDeleteGalleryImage')->name('hotelier.delete.gallery.image');
    Route::post('hotelier/delete/hotel/image', 'HotelsController@hotelierDeleteHotelImage')->name('hotelier.delete.hotel.image');
    
    Route::get('choose-type', 'NewLoginPartController@index')->name('choose.user.type');
    Route::get('verify-hotel-code', 'NewLoginPartController@verifyHotelCode')->name('verify.hotel.code');
    Route::post('verify-code', 'NewLoginPartController@verifyCode')->name('verify.code');
    Route::post('save-user-type', 'NewLoginPartController@saveUserType')->name('save.user.type');
    
    
    
    
    Auth::routes();
	  Route::get('/home', function () {
      $user = auth('web')->user();
      return redirect('/users/dashboard');
    })->name('home');
   Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
   Route::post('/users/register', 'Auth\RegisterController@doCreate')->name('user.register');
   // Social Auth
   Route::get('auth/social', 'Auth\SocialAuthController@show')->name('social.login');
   Route::get('oauth/{driver}', 'Auth\SocialAuthController@redirectToProvider')->name('social.oauth');
   Route::get('oauth/{driver}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('social.callback');
   
   require(base_path() . '/routes/front/user.php');
   require(base_path() . '/routes/front/customer.php');
   require(base_path() . '/routes/front/hotels.php');
   require(base_path() . '/routes/front/pages.php');
   require(base_path() . '/routes/front/journal.php');
   require(base_path() . '/routes/front/cart.php');
   require(base_path() . '/routes/front/booking.php');
   require(base_path() . '/routes/front/ajax.php');
