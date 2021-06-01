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

Route::get('/users/calender', 'CalenderController@index')->name('user.calender');

Route::get('/users/hotels/rooms/allrooms', 'Ajax\RoomsController@getRooms')->name('user.hotels.allrooms');
Route::get('/users/hotels/rooms/roomtype', 'Ajax\RoomsController@getRoomtype')->name('user.hotels.roomtype');
Route::get('/users/profile', 'ProfileController@Profile')->name('user.profile');
Route::get('/users/hotels', 'HotelsController@hotels_list')->name('user.hotels');
Route::post('/users/hotels/del/image', 'HotelsController@delHotelgallery')->name('user.hotels.del.image');
Route::get('/users/hotels/edit/{id}', 'HotelsController@hotels_edit')->name('user.hotels.edit');
Route::post('/users/hotels/add', 'HotelsController@hotels_add')->name('user.hotels.add');
Route::delete('/users/hotels/del/{id}', 'HotelsController@hotels_del')->name('user.hotels.del');
Route::post('/users/hotels/update/{id}', 'HotelsController@hotels_update')->name('user.hotels.update');

Route::post('/users/hotels/update/new/{id}', 'HotelsController@hotels_update_new')->name('user.hotels.update.new');
Route::get('/users/hotels/rooms/{id}', 'RoomsController@rooms_list')->name('user.hotels.rooms');


Route::get('/users/hotels/rooms/add/{id}', 'RoomsController@rooms_add')->name('user.hotels.rooms.add');
Route::post('/users/hotels/rooms/doadd/{id}', 'RoomsController@rooms_doadd')->name('user.hotels.rooms.doadd');
Route::get('/users/hotels/rooms/edit/{id}', 'RoomsController@rooms_edit')->name('user.hotels.rooms.edit');
Route::post('/users/hotels/rooms/adddetails', 'RoomsController@rooms_details_add')->name('user.hotels.rooms.adddetails');
Route::post('/users/hotels/rooms/adddetails', 'RoomsController@rooms_details_add')->name('user.hotels.rooms.adddetails');
Route::post('/users/hotels/rooms/addgallery', 'RoomsController@rooms_gallery_add')->name('user.hotels.rooms.addgallery');
Route::post('/users/hotels/rooms/updateroom/{id}', 'RoomsController@updateroom')->name('user.hotels.rooms.updateroom');
Route::post('/users/hotels/rooms/editetails/{id}', 'RoomsController@editetails')->name('user.hotels.rooms.editetails');
Route::post('/users/hotels/rooms/editgallery/{id}', 'RoomsController@editgallery')->name('user.hotels.rooms.editgallery');
Route::post('/users/hotels/rooms/del/gallery', 'RoomsController@delGalleryImage')->name('user.hotels.rooms.del.gallery');
Route::get('/users/hotels/rooms/price/{id}', 'RoomsController@price_rack')->name('user.hotels.rooms.price');
Route::get('/users/hotels/rooms/price_edit/{id}', 'RoomsController@price_edit')->name('user.hotels.rooms.price_edit');
Route::post('/users/hotels/rooms/addprice/{id}', 'RoomsController@addprice')->name('user.hotels.rooms.addprice');
Route::delete('/users/hotels/rooms/delprice/{id}', 'RoomsController@delprice')->name('user.hotels.rooms.delprice');
Route::delete('/users/hotels/rooms/delroom/{id}', 'RoomsController@delroom')->name('user.hotels.rooms.delroom');
Route::post('/users/hotels/rooms/adddate', 'RoomsController@addroomdate')->name('user.hotels.rooms.adddate');
Route::get('/users/hotels/room/roomdate', 'RoomsController@fetchRoomsdate')->name('user.hotels.room.fecthdate');
Route::get('users/reviews', 'ReviewController@index')->name('users.hotels.reviews');
Route::post('users/hotels/reviews/status/{id}', 'ReviewController@review_status_change')->name('users.hotels.reviews.status');
Route::delete('users/hotels/reviews/delete/{id}', 'ReviewController@delete')->name('users.hotels.reviews.delete');



Route::get('users/bookings', 'BookingController@index')->name('users.bookings');
Route::get('users/booking/add', 'BookingController@newBooking')->name('user.booking.add');
Route::post('users/check-room-available', 'BookingController@checkRoomAvailable')->name('user.check.room.available');
Route::post('users/get-room-price', 'BookingController@getRoomPrice')->name('user.get.room.price');
Route::post('users/hotelier-book-hotel', 'BookingController@hotelierBookHotel')->name('user.hotelier.book.hotel');
Route::get('users/bookings/{id}', 'BookingController@showBooking')->name('users.view.booking');
Route::post('users/booking/cancelation', 'BookingController@bookingCancelation')->name('user.booking.cancelation');

Route::get('/users/dashboard', 'ProfileController@index')->name('user.dashboard');
Route::post('/hotel/get/available/rooms', 'ProfileController@getAvailableRooms')->name('hotel.get.available.rooms');
Route::post('/hotel/update/available/rooms', 'ProfileController@updateAvailableRooms')->name('hotel.update.available.rooms');
Route::post('/users/hotels/rooms/available', 'ProfileController@calenderCallRoomAvailable')->name('user.hotels.available');
Route::post('/calendar/date/details', 'ProfileController@calendarDateDetails')->name('calendar.date.details');
//Route::get('/users/hotels/rooms/available', 'Ajax\RoomsController@roomAvailable')->name('user.hotels.available');




Route::get('/users/service-tickets', function () {
      $user = auth('web')->user();
      return view('frontend.hotelier.service_tickets');
    })->name('user.service_tickets');

Route::match(['get', 'post'], 'ajax-image-upload', 'Ajax\ProfileController@ajaxImage');
Route::post('ajax-remove-image/', 'Ajax\ProfileController@deleteImage')->name('users.ajax.remove.image');
Route::post('users/booking/add/check_user', 'BookingController@email_check')->name('user.booking.add.check_user');
Route::post('users/booking/add/add_user', 'BookingController@add_user')->name('user.booking.add.add_user');
Route::post('users/booking/add/room_availability', 'BookingController@room_availability')->name('user.booking.add.room_availability');
Route::post('users/booking/add/room_add', 'BookingController@room_add')->name('user.booking.add.room_add');
Route::post('users/booking/add/room_del', 'BookingController@room_del')->name('user.booking.add.room_del');
Route::post('users/booking/add/payment_process', 'BookingController@booking_payment_process')->name('user.booking.add.booking_add');
Route::get('users/invoice/', 'BookingController@invoice_list')->name('user.invoice.invoice_list');
Route::get('users/invoice/{id}', 'BookingController@invoice_generate')->name('user.invoice.invoice_generate');


Route::post('/users/hotelier/rooms/update', 'Ajax\RoomsController@addUpdateRoomAbility')->name('user.hotelier.room.adddate');
Route::get('users/transactions/', 'TransactionController@index')->name('user.transactions');
Route::post('/users/hotel/status/{id}', 'HotelsController@statusChange')->name('user.hotel.status');
Route::get('users/booking/confirm', 'PaymentController@bookingConfirm')->name('user.booking.confirm');