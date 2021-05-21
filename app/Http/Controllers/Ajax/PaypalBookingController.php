<?php
namespace App\Http\Controllers\Ajax;
use App\Hotels;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\RoomAvailability;
use App\Cart;
use App\Booking;
use App\BookingItem;
use App\User;
use App\TourGuide;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class PaypalBookingController extends Controller
{
  public function __construct()
  {
            //$this->middleware('auth');
  }

   
 }