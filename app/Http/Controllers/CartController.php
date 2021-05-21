<?php

namespace App\Http\Controllers;
use App\Filter;
use App\Countries;
use App\Regions;
use App\States;
use App\Hotels;
use App\Accommodations;
use App\Species;
use App\Inspirations;
use App\Experiences;
use App\HotelAccommodationRelation;
use App\HotelSpeciesRelation;
use App\HotelInspirationsRelation;
use App\HotelExperiencesRelation;
use App\HotelContact;
use App\HotelGallery;
use App\HotelAddress;
use App\KeyFeature;
use App\ServiceFacility;
use App\RoomFacility;
use App\Recreation;
use App\HotelFeaturesRelation;
use App\ServiceFacilitiesTranslation;
use App\RoomFacilitiesTranslation;
use App\RecreationTranslation;
use App\HotelAward;
use App\Rooms;
use App\RoomAvailability;
use App\FoodDrink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $config = new \Braintree_Configuration([
            'environment' => 'sandbox',
            'merchantId' => 'kp8tw949t876r8gv',
            'publicKey' => 'qh72yshrh9jzd8zh',
            'privateKey' => '36ce8b294f9d0d4ec81df1fe67d11dce'
        ]);
        $gateway = new \Braintree\Gateway($config);
        $clientToken = $gateway->clientToken()->generate();
        $user = auth('web')->user();
        $user_id =get_loggedin_id();
        $start = $request["start_date"];
        $sdate=date_create($request["start_date"]);
        $startdate=date_format($sdate,"D, d M Y");
        $end = $request["end_date"];
        $edate=date_create($request["end_date"]);
        $enddate=date_format($edate,"D, d M Y");
        $hotel_id=$request["hotel_id"];
        $nights = dateDiff($start, $end);
        $hotels = Hotels::where('id', '=' , $request["hotel_id"])->get()->first();
        $result = Rooms::leftJoin('room_availabilities', function ($join) use($request){
                    $from = $request["start_date"];
                    $to = $request["end_date"];
                    $hotel_id = $request["hotel_id"];
                    $join->on('rooms.id', '=', 'room_availabilities.room_id')
                     ->whereBetween('room_availabilities.date', array($from, $to))
                     ->where('room_availabilities.availability', '=', 1)
                     ->where('room_availabilities.availabe_rooms', '>=', 1)
                     ->where('rooms.hotel_id', '=', $request["hotel_id"])
                     ->groupBy('room_availabilities.room_id');
        })->get();
        //var_dump($result->all());
         $rooms = array();
         $rooms_ids = array();
         foreach ($result->all() as $key => $value) {
            if(in_array($value['room_id'], $rooms_ids )){
                $rooms[$value['room_id']][] =$value;
            }else{
                $rooms_ids[]=$value['room_id'];
            }
        }
        // echo "<pre>";
        // print_r($rooms);
        // die;
        //array_unique($rooms, SORT_REGULAR);
        return view('frontend.hotels.cart', compact('nights', 'startdate','enddate','rooms','hotels','hotel_id','clientToken'));
    }
}
