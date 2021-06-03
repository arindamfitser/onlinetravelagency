<?php

namespace App\Http\Controllers;
use App\Hotels;
use App\HotelNewEntry;
use App\Booking;
use App\User;
use App\Rooms;
use App\RoomAllocation;
use App\Cart;
use App\RoomDetail;
use App\BookingItem;
use App\Cancelation;
use App\RoomAvailability;
use App\RoomCount;
use App\Testimonials;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class CustomerController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function CustomerBooking(){
        $user = auth('web')->user();
        // $bookings1 = Booking::select('*', 'bookings.status as booked_status', 'bookings.id as booking_id', 'bookings.created_at as created_at')
        // ->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')
        // ->join('rooms', 'booking_items.room_id', '=', 'rooms.id')
        // ->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')
        // ->where('bookings.status', '!=', 4)
        // ->where('bookings.type', '=', 'site')
        // ->where('bookings.user_id', '=', $user->id)->get();
        // $bookings2 = Booking::select('*', 'bookings.status as booked_status', 'bookings.id as booking_id')
        // ->where('bookings.status', '!=', 4)
        // ->where('bookings.type', '=', 'stuba')
        // ->where('bookings.user_id', '=', $user->id)->get();

        $bookings   = Booking::select('bookings.*', 'hotels_translations.hotels_name', 'rooms.name')
                  ->join('hotels', 'bookings.hotel_token', '=', 'hotels.hotel_token')
                  ->join('hotels_translations', 'hotels_translations.hotels_id', '=', 'hotels.id')
                  ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                  ->where('bookings.status', '!=', 4)
                  ->where('bookings.user_id', $user->id)
                  ->orderBy('bookings.id', 'DESC')->get();



        //$merged = $bookings->merge($bookings2);
        //$bookings = $bookings1->union($bookings2);
        //$bookings = $bookings->all();
        //$bookings = (object)array_merge((array)$bookings1, (array)$bookings2);
        return view('frontend.customer.booking', compact('bookings'));
    }
    public function show_booking($id){      
        return view('frontend.customer.bookingdetails', compact('id'));   
    }
    public function CustomerTestimonial(){
      $user         = auth('web')->user();
      $testimonials = Testimonials::where('user_id', $user->id)->where('status', '!=', 3)->orderBy('id', 'DESC')->get();
      return view('frontend.customer.testimonial', compact('testimonials'));
    }
    public function add_testimonial(Request $request){
        $user = auth('web')->user();
        $this->validate($request, [
            'testimonials_content' => 'required'
        ]);
        $Info           =   Testimonials::create(array(
                                'user_id'               => $request->user_id,    
                                'testimonials_name'     => $request->testimonials_name,    
                                'testimonials_content'  => $request->testimonials_content  
                            ));
        $data           = Testimonials::find($Info->id);
        $data->user_id  = $user->id;
        return redirect()->back()->with('message', 'Thank you for your feedback !!!');
    }
    public function del_testimonial($id){
        $t          = Testimonials::find($id);
        $t->status  = 3;
        $t->save();
        //Testimonials::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Testimonial deleted successfully !!!');
    }


    public function CustomerMembership(){
        return view('frontend.customer.booking');
    }
    public function CustomerOffer(){
        return view('frontend.customer.booking');
    }
    public function CustomerWishlist(){
        $user = auth('web')->user();
        $wishlists = DB::table('wishlist')->select('*', 'wishlist.id as wish_id')->join('hotels', 'wishlist.hotel_id', '=', 'hotels.id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('wishlist.user_id', '=', $user->id)
              ->get();

        return view('frontend.customer.wishlist', compact('wishlists'));
    }
    public function CustomerTransactions(){
        return view('frontend.customer.booking');
    }
    public function delWhislist($id){
      DB::table('wishlist')->where('id', $id)->delete();
      return redirect()->back()->with('message', 'Wishlist deleted successfully!');
    }
    
    
}
