<?php
namespace App\Http\Controllers\Admin;
use App\Booking;
use App\Hotels;
use App\Testimonials;
use App\BookingItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$bookings = Booking::select('*', 'bookings.status as booked_status', 'bookings.user_id as booked_user', 'bookings.id as booked_id')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->get()->all();
        $bookings1 = Booking::select('*', 'bookings.status as booked_status', 'bookings.id as booking_id', 'bookings.created_at as created_at')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->where('bookings.type', '=', 'site')->get()->all();
        $bookings2 = Booking::select('*', 'bookings.status as booked_status', 'bookings.id as booking_id')->where('bookings.type', '=', 'stuba')->get()->all();
        $bookings = (object)array_merge((array)$bookings1, (array)$bookings2);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$bookings = Booking::select('*', 'bookings.status as booked_status', 'bookings.user_id as booked_user')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->where('bookings.id', $id)->get()->first();
        $booking = Booking::find($id);
        return view('admin.bookings.details', compact('booking'));
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
