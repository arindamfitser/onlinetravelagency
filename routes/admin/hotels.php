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
	Route::get('/send-invitation', 'Admin\HotelsControllerNew@sendInvitation')->name('admin.send.invitation');
	Route::post('/save-invitation', 'Admin\HotelsControllerNew@saveInvitation')->name('admin.save.invitation');
	Route::get('/invitation-list', 'Admin\HotelsControllerNew@invitationList')->name('admin.invitation.list');
	Route::get('/invitation-received/{type}', 'Admin\HotelsControllerNew@invitationReceived')->name('admin.invitation.received');
	Route::get('/invitation-details/{code}', 'Admin\HotelsControllerNew@invitationDetails')->name('admin.invitation.details');
	Route::get('/invite-hotel-details/{token}', 'Admin\HotelsControllerNew@invitedHotelDetails')->name('admin.invited.hotel.details');
	Route::post('/change-hotel-status', 'Admin\HotelsControllerNew@changeHotelStatus')->name('admin.change.hotel.status');
	Route::post('/hotels/update/new/{id}', 'Admin\HotelsControllerNew@hotelsUpdate')->name('admin.hotels.update.new');
	Route::get('/hotels', 'Admin\HotelsControllerNew@index')->name('admin.hotels');

	Route::get('/invited-hotel-rooms/{code}', 'Admin\HotelsControllerNew@invitedHotelRooms')->name('admin.invited.hotel.rooms');
	Route::get('/invited-hotel-rooms/add/{code}', 'Admin\HotelsControllerNew@roomsAdd')->name('admin.invited.hotel.rooms.add');
	Route::post('/invited-hotel-rooms/doAdd/{code}', 'Admin\HotelsControllerNew@roomsDoAdd')->name('admin.invited.hotel.rooms.doadd');
	Route::get('/invited-hotel-rooms/edit/{id}', 'Admin\HotelsControllerNew@roomsEdit')->name('admin.invited.hotel.rooms.edit');
	Route::post('/invited-hotel-rooms/update/{id}', 'Admin\HotelsControllerNew@updateRoom')->name('admin.invited.hotel.rooms.update');


	Route::post('/hotels/uploadcsv', 'Admin\HotelsController@uploadcsv')->name('admin.hotels.uploadcsv');
	Route::delete('/hotels/del/{lang}/{id}', 'Admin\HotelsController@doDelete')->name('admin.hotels.del');
	Route::get('/hotels/edit/{lang}/{id}', 'Admin\HotelsController@edit')->name('admin.hotels.edit');
	Route::post('/hotels/update/{lang}/{id}', 'Admin\HotelsController@update')->name('admin.hotels.update');
	Route::post('/hotels/del/image/{lang}', 'Admin\HotelsController@delHotelgallery')->name('admin.hotels.del.image');
	Route::get('/hotels/rooms/{lang}/{id}', 'Admin\RoomsController@rooms_list')->name('admin.hotels.rooms');
	Route::get('/hotels/rooms/add/{lang}/{id}', 'Admin\RoomsController@rooms_add')->name('admin.hotels.rooms.add');
	Route::post('/hotels/rooms/doadd/{lang}/{id}', 'Admin\RoomsController@rooms_doadd')->name('admin.hotels.rooms.doadd');
	Route::get('/hotels/rooms/edit/{lang}/{id}', 'Admin\RoomsController@rooms_edit')->name('admin.hotels.rooms.edit');
	Route::post('/hotels/rooms/adddetails/{lang}', 'Admin\RoomsController@rooms_details_add')->name('admin.hotels.rooms.adddetails');
	Route::post('/hotels/rooms/adddetails/{lang}', 'Admin\RoomsController@rooms_details_add')->name('admin.hotels.rooms.adddetails');
	Route::post('/hotels/rooms/addgallery/{lang}', 'Admin\RoomsController@rooms_gallery_add')->name('admin.hotels.rooms.addgallery');
	Route::post('/hotels/rooms/updateroom/{lang}/{id}', 'Admin\RoomsController@updateroom')->name('admin.hotels.rooms.updateroom');
	Route::post('/hotels/rooms/editetails/{lang}/{id}', 'Admin\RoomsController@editetails')->name('admin.hotels.rooms.editetails');
	Route::post('/hotels/rooms/editgallery/{lang}/{id}', 'Admin\RoomsController@editgallery')->name('admin.hotels.rooms.editgallery');
	Route::post('/hotels/rooms/del/gallery/{lang}', 'Admin\RoomsController@delGalleryImage')->name('admin.hotels.rooms.del.gallery');
    Route::get('/hotels/rooms/price/{lang}/{id}', 'Admin\RoomsController@price_rack')->name('admin.hotels.rooms.price');
    Route::get('/hotels/rooms/price_edit/{lang}/{id}', 'Admin\RoomsController@price_edit')->name('admin.hotels.rooms.price_edit');
    Route::post('/hotels/rooms/addprice/{lang}/{id}', 'Admin\RoomsController@addprice')->name('admin.hotels.rooms.addprice');
    Route::get('/hotels/rooms/delprice/{lang}/{id}', 'Admin\RoomsController@delprice')->name('admin.hotels.rooms.delprice');
    Route::get('/hotels/rooms/delprice/{lang}/{id}', 'Admin\RoomsController@delroom')->name('admin.hotels.rooms.delroom');
    Route::get('/direct_contact', 'Admin\HotelsController@direct_contact')->name('admin.direct_contact');
    Route::post('/edit/direct/contact', 'Admin\HotelsController@editDirectContact')->name('admin.edit.direct.contact');
    Route::post('get/state', 'Admin\HotelsController@getState')->name('admin.get.state');

    Route::get('/hotels/packages/{id}', 'Admin\PackageController@index')->name('admin.hotels.packages');
    Route::get('/hotels/packages/add/{id}', 'Admin\PackageController@create')->name('admin.hotels.packages.add');
    Route::post('/hotels/packages/do_add/{id}', 'Admin\PackageController@do_add')->name('admin.hotels.packages.do_add');
    Route::get('/hotels/packages/edit/{id}', 'Admin\PackageController@edit')->name('admin.hotels.packages.edit');
    Route::post('/hotels/packages/update/{id}', 'Admin\PackageController@update')->name('admin.hotels.packages.update');
    Route::delete('/hotels/packages/del/{id}', 'Admin\PackageController@del')->name('admin.hotels.packages.del');

    Route::get('/commissions', 'Admin\CommissionController@index')->name('admin.commissions');
    Route::post('/commissions/add', 'Admin\CommissionController@add')->name('admin.commissions.add');
    Route::post('/getstate', 'Ajax\AjaxController@get_state')->name('admin.get_state');
    Route::get('/reviews', 'Admin\HotelsController@reviews')->name('admin.reviews');
    Route::delete('/reviews/del/{id}', 'Admin\HotelsController@del_reviews')->name('admin.reviews.del');
    Route::post('/reviews/status/{id}', 'Admin\HotelsController@change_status')->name('admin.reviews.status');

