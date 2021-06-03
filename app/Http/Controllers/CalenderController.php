<?php

namespace App\Http\Controllers;
use App\Hotels;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\Booking;

use Illuminate\Http\Request;

class CalenderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('web')->user();
        if($user->role=='1'){
            $hotels = Hotels::where('user_id', '=', $user->id)->get();
            $room = new \StdClass();
            $room->hotel_id = Hotels::where('user_id', '=', $user->id)->get()->first()->id;
            $room->rooms = Rooms::where('hotel_id', '=',Hotels::where('user_id', '=', $user->id)->get()->first()->id)->get();
            return view('frontend.hotelier.calender', compact('room', 'hotels'));
        }else{
            return view('frontend.customer.calender');
        }
        
    }
}
