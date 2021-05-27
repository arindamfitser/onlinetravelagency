<?php

namespace App\Http\Controllers\admin;
use App\User;
use Mail;
use App\Hotels;
use App\Species;
use App\Accommodations;
use App\Inspirations;
use App\Experiences;
use App\HotelContact;
use App\HotelSpeciesRelation;
use App\HotelAccommodationRelation;
use App\HotelExperiencesRelation;
use App\HotelInspirationsRelation;
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
use App\FoodDrink;
use App\Fisherman;
use App\TourGuide;
use App\Review;
use App\HotelsTranslation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotelsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin'); 
    }

    public function index()
    {  
        $hotels = Hotels::all();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function uploadcsv(Request $request){
        $this->validate($request,[
            'upload_csv' => 'required|mimes:csv,txt',

        ]);
        if($request->file('upload_csv')){
            $path = $request->file('upload_csv')->getRealPath();
            $file = fopen($path, "r");
            $getData = fgetcsv($file, 0, ",");
            $row = 0;
            do { 
                if($row > 1){
                    if(!empty(array_filter($getData))){ 
                        $hotel_name = trim($getData[4]); //PROPERTY NAME
                        $hotel_slug = createSlug($hotel_name);
                        if(hotelSlugExists($hotel_slug) == false){
                            /*=============Destinations============*/
                            $region_id = getRegionID($getData[0]); //REGION
                            $country_id = getCountryID($getData[1]); //COUNTRY
                            $state_id = getStateID($getData[2], $country_id); //STATE / DISTRICT
                            $location = $getData[3]; //LOCATION
                            if($getData[5] != ""){
                               $contact_status = 'R'; //STUBA / ROOMSXML
                            }
                            if($getData[6] != ""){
                               $contact_status = 'D'; //DIRECT CONTRACT
                            }
                            $curator_rating = $getData[13]; //CURATOR RATING
                            $brief_descp = $getData[14]; //BRIEF DESCRIPTION  FOR INCLUSION ON SEARCH RESULTS PAGE
                            $full_descp = $getData[15]; //FULL DESCRIPTION    FOR INCLUSION ON HOTEL PAGE

                            /*==============PROPERTY DETAILS===========*/
                            $physical_addrress = $getData[27]; //PHYSICAL ADDRESS
                            $website = $getData[28]; //WEBSITE
                            $email = $getData[29]; //EMAIL
                            $phone = $getData[30]; //PHONE

                            /*=============PROPERTY FEATURES==========*/
                            $amenities = $getData[31]; //AMENITIES SERVICES & FEATURES
                            $activities = $getData[32]; //ACTIVITIES
                            $tours = $getData[33]; //TOURS
                            $pool = $getData[34]; //POOL
                            if($pool !=""){
                              $pool = 'yes';
                            }else{
                              $pool = 'no';
                            }
                            $diving = $getData[35]; //DIVING
                            if($diving !=""){
                              $diving = 'yes';
                            }else{
                              $diving = 'no';
                            }
                            $water_sports = $getData[36]; //WATERSPORTS
                            if($water_sports !=""){
                              $water_sports = 'yes';
                            }else{
                              $water_sports = 'no';
                            }

                            /*=============GETTING THERE=============*/
                            $nearest_airport = $getData[37]; //NEAREST AIRPORT
                            $distance = $getData[38]; //DISTANCE
                            $transfers = $getData[39]; //TRANSFERS

                            $more_info = $getData[40]; //MORE INFO

                            $species = $getData[83]; //SPECIES
                            $fishing = $getData[49]; //FISHING
                            $fishing_season = $getData[50]; //FISHING SEASON

                            /*=============Hotels Data insert function=====*/
                            $hotel = new Hotels;
                            $lang =  \App::getLocale();
                            $hotel->locale = $lang;
                            $hotel->hotels_name = $hotel_name;
                            $hotel->hotels_slug = $hotel_slug;
                            $hotel->hotels_desc = utf8_encode($full_descp);
                            $hotel->region_id = $region_id;
                            $hotel->country_id = $country_id;
                            $hotel->state_id = $state_id;
                            $hotel->town = $location;
                            $hotel->brief_descp = $brief_descp;
                            $hotel->contact_status = $contact_status;
                            $hotel->curator_rating = $curator_rating;
                            $hotel->services_amenities = $amenities;
                            $hotel->activities = $activities;
                            $hotel->tours = $tours;
                            $hotel->pool = $pool;
                            $hotel->diving = $diving;
                            $hotel->water_sports = $water_sports;
                            $hotel->nearest_airport = $nearest_airport;
                            $hotel->distance_airport = $distance;
                            $hotel->transfers_mode = $transfers;
                            $hotel->additional_information = $more_info;
                            $hotel->species = $species;
                            $hotel->email_id = $email;
                            $hotel->phone = $phone;
                            $hotel->fishing = utf8_encode($fishing);
                            $hotel->activity_season = $fishing_season;
                            $hotel->save();
                            $hotel_id = $hotel->id; //GET HOTEL ID
                            /*============get address data from google api==========*/
                            $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&address=".urlencode($physical_addrress);
                            $json = @file_get_contents($url);
                            $json = json_decode($json, TRUE);  
                            $tot_json = @count($json['results'][0]['address_components']); 
                            $componentForm = array('street_number' => 'long_name', 'route' => 'long_name', 'locality' => 'long_name', 'administrative_area_level_1' => 'long_name', 'country' => 'long_name', 'postal_code' => 'short_name');
                            $loc_arry = array();
                            for ($i=0; $i < $tot_json; $i++) { 
                             $addressType = $json['results'][0]['address_components'][$i]['types'][0];
                             if(@$componentForm[$addressType]){
                                $val = $json['results'][0]['address_components'][$i][$componentForm[$addressType]];
                                $loc_arry[$addressType] = $val;
                             }
                            }
                            
                           
                            if(!empty($loc_arry)){
                              $loc_arry['latitude'] = $json['results'][0]['geometry']['location']['lat'];
                              $loc_arry['longitude'] = $json['results'][0]['geometry']['location']['lng'];
                            //    print_r($loc_arry);
                            // exit();
                              /*===========hotel address insert function=====*/
                              $hoteladdress = new HotelAddress;
                              $hoteladdress->hotel_id = $hotel_id;
                              $hoteladdress->location = utf8_encode($physical_addrress);
                              $hoteladdress->street_number = @$loc_arry['street_number'];
                              $hoteladdress->route = @$loc_arry['route'];
                              $hoteladdress->country = @$loc_arry['country'];
                              $hoteladdress->city = @$loc_arry['locality'];
                              $hoteladdress->state = @$loc_arry['administrative_area_level_1'];
                              $hoteladdress->zip_code = @$loc_arry['postal_code'];
                              $hoteladdress->latitude = @$loc_arry['latitude'];
                              $hoteladdress->longitude = @$loc_arry['longitude'];
                              $hoteladdress->save();
                            }

                           /*=======accommodation data insert==========*/
                            $acc_type_arr = array('Castles & Manors', 'Private Islands', 'Resorts', 'Lodges', 'Hotels', 'Live-aboard Vessels');
                            if(!empty($acc_type_arr)){
                                $type_1 = $getData[7]; //CASTLES & MANORS
                                $type_2 = $getData[8]; //PRIVATE ISLANDS
                                $type_3 = $getData[9]; //RESORTS
                                $type_4 = $getData[10]; //LODGES
                                $type_5 = $getData[11]; //HOTELS
                                $type_6 = $getData[12]; //LIVE-ABOARD VESSELS
                                for ($i=0; $i < count($acc_type_arr) ; $i++) {
                                    $var_type = ${ 'type_' .($i+1)};
                                    if($var_type == 1){
                                        accommodationSave($acc_type_arr[$i], $hotel_id);
                                    }
                                }
                            }
                            /*========Inspiration data insert=========*/
                              $insp_type_arr  = array('Our Gold Award Winners', 'Our Top Saltwater Destinations', 'Our Top Freshwater Destinations', 'Off The Beaten Track', 'Quirky Favourites', 'Catch & Cook', 'Tournament Trail');
                              if(!empty($insp_type_arr)){
                                  $insp_type_1 = $getData[16]; //OUR GOLD AWARD WINNERS
                                  $insp_type_2 = $getData[17]; //OUR TOP SALTWATER DESTINATIONS
                                  $insp_type_3 = $getData[18]; //OUR TOP FRESHWATER DESTINATIONS
                                  $insp_type_4 = $getData[19]; //OFF THE BEATEN TRACK
                                  $insp_type_5 = $getData[20]; //QUIRKY  FAVOURITES
                                  $insp_type_6 = $getData[21]; //CATCH & COOK
                                  $insp_type_7 = $getData[22]; //TOURNAMENT TRAIL
                                  for ($i=0; $i < count($insp_type_arr) ; $i++) { 
                                      $var_type = ${ 'insp_type_' .($i+1)};
                                      if($var_type == 1){
                                          inspirationSave($insp_type_arr[$i], $hotel_id);
                                      }
                                  }
                              }
                            /*===========SERVICE FOR THE FISHERMAN=========*/
                            $booking_conf_txt = $getData[23]; //TEXT FOR INCLUSION ON BOOKING CONFIRMATION VOUCHER

                            //Bespoke fishing experiences provided on site or nearby
                            if($getData[24] != ""){
                              $provide_on_site = 'yes';
                            }else{
                              $provide_on_site = 'no';
                            }
                            //Property Name concierge staff can arrange fishing nearby
                            if($getData[25] != ""){
                               $arrange_fishing_nearby = 'yes';
                            }else{
                              $arrange_fishing_nearby = 'no';
                            }
                            //We provide our curated "best guide or charter" selections
                            if($getData[26] != ""){
                               $provide_our_curated = 'yes';
                            }else{
                              $provide_our_curated = 'no';
                            }
                            /*=============fisherman data insert function========*/
                            $fisherman = new Fisherman;
                            $fisherman->hotel_id = $hotel_id;
                            $fisherman->booking_cnf = $booking_conf_txt;
                            $fisherman->provide_on_site = $provide_on_site;
                            $fisherman->arrange_fishing_nearby = $arrange_fishing_nearby;
                            $fisherman->provide_our_curated = $provide_our_curated;
                            $fisherman->save();

                          /*==========Experinces data insert========*/
                          $exp_type_arr  = array('Fresh Water Fishing', 'Salt Water Fishing', 'Action', 'Purity & Tranquility', 'Helicopter Or Float Plane Fishing', 'Fine Dining', 'Spa Resorts', 'Beach Resorts');
                          if(!empty($exp_type_arr)){
                              $exp_type_1 = $getData[41]; //FRESH WATER FISHING
                              $exp_type_2 = $getData[42]; //SALT WATER FISHING
                              $exp_type_3 = $getData[43]; //ACTION
                              $exp_type_4 = $getData[44]; //PURITY & TRANQUILITY
                              $exp_type_5 = $getData[45]; //HELICOPTER OR  FLOAT PLANE FISHING
                              $exp_type_6 = $getData[46]; //FINE DINING
                              $exp_type_7 = $getData[47]; //SPA RESORTS
                              $exp_type_8 = $getData[48]; //BEACH RESORTS
                              for ($i=0; $i < count($exp_type_arr) ; $i++) { 
                                  $var_type = ${ 'exp_type_' .($i+1)};
                                  if($var_type == 1){
                                      experiencesSave($exp_type_arr[$i], $hotel_id);
                                  }
                              }
                          }
                          
                          /*============Species data insert===========*/
                          $spec_type_arr = array("Billfish", "Tuna", "Mahi-mahi", "Wahoo", "Kingfish", "Queenfish", "Gt's", "Trevally", "Pelagics", "Reef Fish", "Snapper", "Estuary Fish", "Bonefish", "Barramundi", "Permit", "Tarpon", "Sea Trout", "Trout", "Salmon", "Pike", "Grayling", "Steelhead", "Char", "Bass", "Peacock Bass", "Perch", "Halibut", "Sturgeon", "Cod", "Golden Dorado", "Roosterfish", "Tigerfish");
                          if(!empty($spec_type_arr)){
                              $spec_type_1 = $getData[51];  //BILLFISH
                              $spec_type_2 = $getData[52];  //TUNA
                              $spec_type_3 = $getData[53];  //MAHI-MAHI
                              $spec_type_4 = $getData[54];  //WAHOO
                              $spec_type_5 = $getData[55];  //KINGFISH
                              $spec_type_6 = $getData[56];  //QUEENFISH
                              $spec_type_7 = $getData[57];  //GT'S
                              $spec_type_8 = $getData[58];  //TREVALLY
                              $spec_type_9 = $getData[59];  //PELAGICS
                              $spec_type_10 = $getData[60]; //REEF FISH
                              $spec_type_11 = $getData[61]; //SNAPPER
                              $spec_type_12 = $getData[62]; //ESTUARY FISH
                              $spec_type_13 = $getData[63]; //BONEFISH
                              $spec_type_14 = $getData[64]; //BARRAMUNDI
                              $spec_type_15 = $getData[65]; //PERMIT
                              $spec_type_16 = $getData[66]; //TARPON
                              $spec_type_17 = $getData[67]; //SEA TROUT
                              $spec_type_18 = $getData[68]; //TROUT
                              $spec_type_19 = $getData[69]; //SALMON
                              $spec_type_20 = $getData[70]; //PIKE
                              $spec_type_21 = $getData[71]; //GRAYLING
                              $spec_type_22 = $getData[72]; //STEELHEAD
                              $spec_type_23 = $getData[73]; //CHAR
                              $spec_type_24 = $getData[74]; //BASS
                              $spec_type_25 = $getData[75]; //PEACOCK BASS
                              $spec_type_26 = $getData[76]; //PERCH
                              $spec_type_27 = $getData[77]; //HALIBUT
                              $spec_type_28 = $getData[78]; //STURGEON
                              $spec_type_29 = $getData[79]; //COD
                              $spec_type_30 = $getData[80]; //GOLDEN DORADO
                              $spec_type_31 = $getData[81]; //ROOSTERFISH
                              $spec_type_32 = $getData[82]; //TIGERFISH
                              for ($i=0; $i < count($spec_type_arr) ; $i++) { 
                                  $var_type = ${ 'spec_type_' .($i+1)};
                                  if ($var_type == 1) {
                                      speciesSave($spec_type_arr[$i], $hotel_id);
                                  }
                              }
                          }
                          
                          /*================GUIDE 1==================*/
                          $business_name_1 = $getData[84]; //BUSINESS NAME
                          $website_1 = $getData[85]; //WEBSITE
                          $email_1 = $getData[86]; //EMAIL
                          $phone_1 = $getData[87]; //PHONE / SKYPE ID
                          $contact_name_1 = $getData[88]; //CONTACT NAME

                          /*================GUIDE 2===================*/
                          $business_name_2 = $getData[89]; //BUSINESS NAME
                          $website_2 = $getData[90]; //WEBSITE
                          $email_2 = $getData[91]; //EMAIL
                          $phone_2 = $getData[92]; //PHONE / SKYPE ID
                          $contact_name_2 = $getData[93]; //CONTACT NAME

                          /*================GUIDE 3==================*/
                          $business_name_3 = $getData[94]; //BUSINESS NAME
                          $website_3 = $getData[95]; //WEBSITE
                          $email_3 = $getData[96]; //EMAIL
                          $phone_3 = $getData[97]; //PHONE / SKYPE ID
                          $contact_name_3 = $getData[98]; //CONTACT NAME

                          /*===============GUIDE 4===================*/
                          $business_name_4 = $getData[99]; //BUSINESS NAME
                          $website_4 = $getData[100]; //WEBSITE
                          $email_4 = $getData[101]; //EMAIL
                          $phone_4 = $getData[102]; //PHONE / SKYPE ID
                          $contact_name_4 = $getData[103]; //CONTACT NAME

                          /*===============GUIDE 5==================*/
                          $business_name_5 = $getData[104]; //BUSINESS NAME
                          $website_5 = $getData[105]; //WEBSITE
                          $email_5 = $getData[106]; //EMAIL
                          $phone_5 = $getData[107]; //PHONE / SKYPE ID
                          $contact_name_5 = $getData[108]; //CONTACT NAME

                          /*===============GUIDE 6==================*/
                          $business_name_6 = $getData[109]; //BUSINESS NAME
                          $website_6 = $getData[110]; //WEBSITE
                          $email_6 = $getData[111]; //EMAIL
                          $phone_6 = $getData[112]; //PHONE / SKYPE ID
                          $contact_name_6 = $getData[113]; //CONTACT NAME

                          /*================guide data insert function=========*/
                          for ($i=0; $i < 6 ; $i++) {
                            $business_name =  ${ 'business_name_'.($i+1)};
                            $website =  ${ 'website_'.($i+1)};
                            $email =  ${ 'email_'.($i+1)};
                            $phone =  ${ 'phone_'.($i+1)};
                            $contact_name =  ${ 'contact_name_'.($i+1)};
                            $type =  'guide_'.($i+1);
                              if($business_name !=""){
                                 $TourGuide = new TourGuide;
                                 $TourGuide->business_name = $business_name;
                                 $TourGuide->website = $website;
                                 $TourGuide->email = $email;
                                 $TourGuide->phone = $phone;
                                 $TourGuide->contact_name = $contact_name;
                                 $TourGuide->type = $type;
                                 $TourGuide->hotel_id = $hotel_id;
                                 $TourGuide->save();
                              } 
                          }

                         /*============== ADMINISTRATORS CONTACT WITH PROPERTY===========*/
                         $name = $getData[114]; //NAME
                         $title = $getData[115]; //TITLE
                         $phone = $getData[116]; //PHONE
                         $email = $getData[117]; //EMAIL
                         $skype_id = $getData[118]; //SKYPE ID
                         if($email !=""){
                          $prev_user_id = emailExists($email);
                          if($prev_user_id != ""){
                            $user_id = $prev_user_id;
                           }else{
                            $user = new User;
                            $username = strstr($email,'@',true);
                            $user->username = $username;
                            $user->email = $email;
                            $user->country_code = $country_id;
                            $user->role = 1;
                            $user->password = bcrypt('1234');
                            if($name != ""){
                              $user->first_name = split_name($name)[0];
                              $user->last_name = split_name($name)[1];
                            }
                            $user->save();
                            $user_id = $user->id;
                            if($user_id > 0){
                              if (is_live()){
                                $e_data = [
                                  'first_name' => $user->first_name,
                                  'last_name' => $user->last_name,
                                  'email' => $email,
                                  'password' => 1234,
                                ];
                                Mail::send('emails.welcome', ['e_data' => $e_data], function ($m) use ($e_data) {
                                  $m->from('no-reply@fitser.com', get_option('blogname'));

                                  $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to OTA');
                                });
                              }
                              $hotel = Hotels::find($hotel_id);
                              $hotel->user_id = $user_id;
                              $hotel->save();
                           }
                         }
                          /*============hotel contact data insert========*/
                          $HotelContact = new HotelContact;
                          $HotelContact->website = $website;
                          $HotelContact->address = utf8_encode($physical_addrress);
                          $HotelContact->hotel_id = $hotel_id;
                          $HotelContact->contact_person_name = $name;
                          $HotelContact->contact_person_email = utf8_encode($email);
                          $HotelContact->contact_person_phone = $phone;
                          $HotelContact->title = $title;
                          $HotelContact->save();
                        } 
                    }else{
                          /*=============Destinations============*/
                          $region_id = getRegionID($getData[0]); //REGION
                          $country_id = getCountryID($getData[1]); //COUNTRY
                          $state_id = getStateID($getData[2], $country_id); //STATE / DISTRICT
                          $location = $getData[3]; //LOCATION
                          if($getData[5] != ""){
                             $contact_status = 'R'; //STUBA / ROOMSXML
                           }
                           if($getData[6] != ""){
                             $contact_status = 'D'; //DIRECT CONTRACT
                           }
                          $curator_rating = $getData[13]; //CURATOR RATING
                          $brief_descp = $getData[14]; //BRIEF DESCRIPTION  FOR INCLUSION ON SEARCH RESULTS PAGE
                          $full_descp = $getData[15]; //FULL DESCRIPTION    FOR INCLUSION ON HOTEL PAGE

                          /*==============PROPERTY DETAILS===========*/
                          $physical_addrress = $getData[27]; //PHYSICAL ADDRESS
                          $website = $getData[28]; //WEBSITE
                          $email = $getData[29]; //EMAIL
                          $phone = $getData[30]; //PHONE

                          /*=============PROPERTY FEATURES==========*/
                          $amenities = $getData[31]; //AMENITIES SERVICES & FEATURES
                          $activities = $getData[32]; //ACTIVITIES
                          $tours = $getData[33]; //TOURS
                          $pool = $getData[34]; //POOL
                          if($pool !=""){
                            $pool = 'yes';
                          }else{
                            $pool = 'no';
                          }
                          $diving = $getData[35]; //DIVING
                          if($diving !=""){
                            $diving = 'yes';
                          }else{
                            $diving = 'no';
                          }
                          $water_sports = $getData[36]; //WATERSPORTS
                          if($water_sports !=""){
                            $water_sports = 'yes';
                          }else{
                            $water_sports = 'no';
                          }

                          /*=============GETTING THERE=============*/
                          $nearest_airport = $getData[37]; //NEAREST AIRPORT
                          $distance = $getData[38]; //DISTANCE
                          $transfers = $getData[39]; //TRANSFERS

                          $more_info = $getData[40]; //MORE INFO

                          $species = $getData[83]; //SPECIES
                          $fishing = $getData[49]; //FISHING
                          $fishing_season = $getData[50]; //FISHING SEASON

                          /*=============Hotels Data insert function=====*/
                            $hotelTData = HotelsTranslation::where('hotels_slug', '=' ,$hotel_slug)->get()->first();
                            $hotel = Hotels::where('id', '=', $hotelTData['hotels_id'])->get()->first();
                            $hotel->hotels_desc = utf8_encode($full_descp);
                            $hotel->region_id = $region_id;
                            $hotel->country_id = $country_id;
                            $hotel->state_id = $state_id;
                            $hotel->town = $location;
                            $hotel->brief_descp = $brief_descp;
                            $hotel->contact_status = $contact_status;
                            $hotel->curator_rating = $curator_rating;
                            $hotel->services_amenities = $amenities;
                            $hotel->activities = $activities;
                            $hotel->tours = $tours;
                            $hotel->pool = $pool;
                            $hotel->diving = $diving;
                            $hotel->water_sports = $water_sports;
                            $hotel->nearest_airport = $nearest_airport;
                            $hotel->distance_airport = $distance;
                            $hotel->transfers_mode = $transfers;
                            $hotel->additional_information = $more_info;
                            $hotel->species = $species;
                            $hotel->email_id = $email;
                            $hotel->phone = $phone;
                            $hotel->fishing = utf8_encode($fishing);
                            $hotel->activity_season = $fishing_season;
                            $hotel->save();
                            $hotel_id = $hotel->id; //GET HOTEL ID
                            /*============get address data from google api==========*/
                            $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&address=".urlencode($physical_addrress);
                            $json = @file_get_contents($url);
                            $json = json_decode($json, TRUE);  
                            $tot_json = @count($json['results'][0]['address_components']); 
                            $componentForm = array('street_number' => 'long_name', 'route' => 'long_name', 'locality' => 'long_name', 'administrative_area_level_1' => 'long_name', 'country' => 'long_name', 'postal_code' => 'short_name');
                            $loc_arry = array();
                            for ($i=0; $i < $tot_json; $i++) { 
                             $addressType = $json['results'][0]['address_components'][$i]['types'][0];
                             if(@$componentForm[$addressType]){
                                $val = $json['results'][0]['address_components'][$i][$componentForm[$addressType]];
                                $loc_arry[$addressType] = $val;
                             }
                            }
                            if(!empty($loc_arry)){
                              $loc_arry['latitude'] = $json['results'][0]['geometry']['location']['lat'];
                              $loc_arry['longitude'] = $json['results'][0]['geometry']['location']['lng'];
                              /*===========hotel address insert function=====*/
                              $hoteladdress = HotelAddress::where('hotel_id', '=', $hotel_id)->get()->first();
                              if(!empty($hoteladdress)){
                                  HotelAddress::where('hotel_id', '=', $hotel_id)->delete();
                              }
                              $hoteladdress = new HotelAddress;
                              $hoteladdress->hotel_id = $hotel_id;
                              $hoteladdress->location = utf8_encode($physical_addrress);
                              $hoteladdress->street_number = @$loc_arry['street_number'];
                              $hoteladdress->route = @$loc_arry['route'];
                              $hoteladdress->country = @$loc_arry['country'];
                              $hoteladdress->city = @$loc_arry['locality'];
                              $hoteladdress->state = @$loc_arry['administrative_area_level_1'];
                              $hoteladdress->zip_code = @$loc_arry['postal_code'];
                              $hoteladdress->latitude = @$loc_arry['latitude'];
                              $hoteladdress->longitude = @$loc_arry['longitude'];
                              $hoteladdress->save();
                            }

                              /*=======accommodation data insert==========*/
                            $acc_type_arr = array('Castles & Manors', 'Private Islands', 'Resorts', 'Lodges', 'Hotels', 'Live-aboard Vessels');
                            if(!empty($acc_type_arr)){
                                $type_1 = $getData[7]; //CASTLES & MANORS
                                $type_2 = $getData[8]; //PRIVATE ISLANDS
                                $type_3 = $getData[9]; //RESORTS
                                $type_4 = $getData[10]; //LODGES
                                $type_5 = $getData[11]; //HOTELS
                                $type_6 = $getData[12]; //LIVE-ABOARD VESSELS
                                HotelAccommodationRelation::where('hotel_id', '=', $hotel_id)->delete();
                                for ($i=0; $i < count($acc_type_arr) ; $i++) {
                                    $var_type = ${ 'type_' .($i+1)};
                                    if($var_type == 1){
                                        accommodationSave($acc_type_arr[$i], $hotel_id);
                                    }
                                }
                            }
                            /*========Inspiration data insert=========*/
                              $insp_type_arr  = array('Our Gold Award Winners', 'Our Top Saltwater Destinations', 'Our Top Freshwater Destinations', 'Off The Beaten Track', 'Quirky Favourites', 'Catch & Cook', 'Tournament Trail');
                              if(!empty($insp_type_arr)){
                                  $insp_type_1 = $getData[16]; //OUR GOLD AWARD WINNERS
                                  $insp_type_2 = $getData[17]; //OUR TOP SALTWATER DESTINATIONS
                                  $insp_type_3 = $getData[18]; //OUR TOP FRESHWATER DESTINATIONS
                                  $insp_type_4 = $getData[19]; //OFF THE BEATEN TRACK
                                  $insp_type_5 = $getData[20]; //QUIRKY  FAVOURITES
                                  $insp_type_6 = $getData[21]; //CATCH & COOK
                                  $insp_type_7 = $getData[22]; //TOURNAMENT TRAIL
                                  HotelInspirationsRelation::where('hotel_id', '=', $hotel_id)->delete();
                                  for ($i=0; $i < count($insp_type_arr) ; $i++) { 
                                      $var_type = ${ 'insp_type_' .($i+1)};
                                      if($var_type == 1){
                                          inspirationSave($insp_type_arr[$i], $hotel_id);
                                      }
                                  }
                              }
                            /*===========SERVICE FOR THE FISHERMAN=========*/
                            $booking_conf_txt = $getData[23]; //TEXT FOR INCLUSION ON BOOKING CONFIRMATION VOUCHER

                            //Bespoke fishing experiences provided on site or nearby
                            if($getData[24] != ""){
                              $provide_on_site = 'yes';
                            }else{
                              $provide_on_site = 'no';
                            }
                            //Property Name concierge staff can arrange fishing nearby
                            if($getData[25] != ""){
                               $arrange_fishing_nearby = 'yes';
                            }else{
                              $arrange_fishing_nearby = 'no';
                            }
                            //We provide our curated "best guide or charter" selections
                            if($getData[26] != ""){
                               $provide_our_curated = 'yes';
                            }else{
                              $provide_our_curated = 'no';
                            }
                            /*=============fisherman data insert function========*/
                            $fisherPrevData = Fisherman::where('hotel_id', '=', $hotel_id)->get()->first();
                            if(!empty($fisherPrevData)){
                                Fisherman::where('hotel_id', '=', $hotel_id)->delete();
                            }
                            $fisherman = new Fisherman;
                            $fisherman->hotel_id = $hotel_id;
                            $fisherman->booking_cnf = $booking_conf_txt;
                            $fisherman->provide_on_site = $provide_on_site;
                            $fisherman->arrange_fishing_nearby = $arrange_fishing_nearby;
                            $fisherman->provide_our_curated = $provide_our_curated;
                            $fisherman->save();

                            /*==========Experinces data insert========*/
                            $exp_type_arr  = array('Fresh Water Fishing', 'Salt Water Fishing', 'Action', 'Purity & Tranquility', 'Helicopter Or Float Plane Fishing', 'Fine Dining', 'Spa Resorts', 'Beach Resorts');
                          if(!empty($exp_type_arr)){
                              $exp_type_1 = $getData[41]; //FRESH WATER FISHING
                              $exp_type_2 = $getData[42]; //SALT WATER FISHING
                              $exp_type_3 = $getData[43]; //ACTION
                              $exp_type_4 = $getData[44]; //PURITY & TRANQUILITY
                              $exp_type_5 = $getData[45]; //HELICOPTER OR  FLOAT PLANE FISHING
                              $exp_type_6 = $getData[46]; //FINE DINING
                              $exp_type_7 = $getData[47]; //SPA RESORTS
                              $exp_type_8 = $getData[48]; //BEACH RESORTS
                              HotelExperiencesRelation::where('hotel_id', '=', $hotel_id)->delete();
                              for ($i=0; $i < count($exp_type_arr) ; $i++) { 
                                  $var_type = ${ 'exp_type_' .($i+1)};
                                  if($var_type == 1){
                                      experiencesSave($exp_type_arr[$i], $hotel_id);
                                  }
                              }
                          }
                          
                          /*============Species data insert===========*/
                          $spec_type_arr = array("Billfish", "Tuna", "Mahi-mahi", "Wahoo", "Kingfish", "Queenfish", "Gt's", "Trevally", "Pelagics", "Reef Fish", "Snapper", "Estuary Fish", "Bonefish", "Barramundi", "Permit", "Tarpon", "Sea Trout", "Trout", "Salmon", "Pike", "Grayling", "Steelhead", "Char", "Bass", "Peacock Bass", "Perch", "Halibut", "Sturgeon", "Cod", "Golden Dorado", "Roosterfish", "Tigerfish");
                          if(!empty($spec_type_arr)){
                              $spec_type_1 = $getData[51];  //BILLFISH
                              $spec_type_2 = $getData[52];  //TUNA
                              $spec_type_3 = $getData[53];  //MAHI-MAHI
                              $spec_type_4 = $getData[54];  //WAHOO
                              $spec_type_5 = $getData[55];  //KINGFISH
                              $spec_type_6 = $getData[56];  //QUEENFISH
                              $spec_type_7 = $getData[57];  //GT'S
                              $spec_type_8 = $getData[58];  //TREVALLY
                              $spec_type_9 = $getData[59];  //PELAGICS
                              $spec_type_10 = $getData[60]; //REEF FISH
                              $spec_type_11 = $getData[61]; //SNAPPER
                              $spec_type_12 = $getData[62]; //ESTUARY FISH
                              $spec_type_13 = $getData[63]; //BONEFISH
                              $spec_type_14 = $getData[64]; //BARRAMUNDI
                              $spec_type_15 = $getData[65]; //PERMIT
                              $spec_type_16 = $getData[66]; //TARPON
                              $spec_type_17 = $getData[67]; //SEA TROUT
                              $spec_type_18 = $getData[68]; //TROUT
                              $spec_type_19 = $getData[69]; //SALMON
                              $spec_type_20 = $getData[70]; //PIKE
                              $spec_type_21 = $getData[71]; //GRAYLING
                              $spec_type_22 = $getData[72]; //STEELHEAD
                              $spec_type_23 = $getData[73]; //CHAR
                              $spec_type_24 = $getData[74]; //BASS
                              $spec_type_25 = $getData[75]; //PEACOCK BASS
                              $spec_type_26 = $getData[76]; //PERCH
                              $spec_type_27 = $getData[77]; //HALIBUT
                              $spec_type_28 = $getData[78]; //STURGEON
                              $spec_type_29 = $getData[79]; //COD
                              $spec_type_30 = $getData[80]; //GOLDEN DORADO
                              $spec_type_31 = $getData[81]; //ROOSTERFISH
                              $spec_type_32 = $getData[82]; //TIGERFISH
                              HotelSpeciesRelation::where('hotel_id', '=', $hotel_id)->delete();
                              for ($i=0; $i < count($spec_type_arr) ; $i++) { 
                                  $var_type = ${ 'spec_type_' .($i+1)};
                                  if ($var_type == 1) {
                                      speciesSave($spec_type_arr[$i], $hotel_id);
                                  }
                              }
                          }

                          /*================GUIDE 1==================*/
                          $business_name_1 = $getData[84]; //BUSINESS NAME
                          $website_1 = $getData[85]; //WEBSITE
                          $email_1 = $getData[86]; //EMAIL
                          $phone_1 = $getData[87]; //PHONE / SKYPE ID
                          $contact_name_1 = $getData[88]; //CONTACT NAME

                          /*================GUIDE 2===================*/
                          $business_name_2 = $getData[89]; //BUSINESS NAME
                          $website_2 = $getData[90]; //WEBSITE
                          $email_2 = $getData[91]; //EMAIL
                          $phone_2 = $getData[92]; //PHONE / SKYPE ID
                          $contact_name_2 = $getData[93]; //CONTACT NAME

                          /*================GUIDE 3==================*/
                          $business_name_3 = $getData[94]; //BUSINESS NAME
                          $website_3 = $getData[95]; //WEBSITE
                          $email_3 = $getData[96]; //EMAIL
                          $phone_3 = $getData[97]; //PHONE / SKYPE ID
                          $contact_name_3 = $getData[98]; //CONTACT NAME

                          /*===============GUIDE 4===================*/
                          $business_name_4 = $getData[99]; //BUSINESS NAME
                          $website_4 = $getData[100]; //WEBSITE
                          $email_4 = $getData[101]; //EMAIL
                          $phone_4 = $getData[102]; //PHONE / SKYPE ID
                          $contact_name_4 = $getData[103]; //CONTACT NAME

                          /*===============GUIDE 5==================*/
                          $business_name_5 = $getData[104]; //BUSINESS NAME
                          $website_5 = $getData[105]; //WEBSITE
                          $email_5 = $getData[106]; //EMAIL
                          $phone_5 = $getData[107]; //PHONE / SKYPE ID
                          $contact_name_5 = $getData[108]; //CONTACT NAME

                          /*===============GUIDE 6==================*/
                          $business_name_6 = $getData[109]; //BUSINESS NAME
                          $website_6 = $getData[110]; //WEBSITE
                          $email_6 = $getData[111]; //EMAIL
                          $phone_6 = $getData[112]; //PHONE / SKYPE ID
                          $contact_name_6 = $getData[113]; //CONTACT NAME

                          /*================guide data insert function=========*/

                          $PrevTourGuide = TourGuide::where('hotel_id', '=', $hotel_id)->get()->all();
                          if(!empty($PrevTourGuide)){
                              TourGuide::where('hotel_id', '=', $hotel_id)->delete();
                          }
                          for ($i=0; $i < 6 ; $i++) {
                            $business_name =  ${ 'business_name_'.($i+1)};
                            $website =  ${ 'website_'.($i+1)};
                            $email =  ${ 'email_'.($i+1)};
                            $phone =  ${ 'phone_'.($i+1)};
                            $contact_name =  ${ 'contact_name_'.($i+1)};
                            $type =  'guide_'.($i+1);
                              if($business_name !=""){
                                 $TourGuide = new TourGuide;
                                 $TourGuide->business_name = $business_name;
                                 $TourGuide->website = $website;
                                 $TourGuide->email = $email;
                                 $TourGuide->phone = $phone;
                                 $TourGuide->contact_name = $contact_name;
                                 $TourGuide->type = $type;
                                 $TourGuide->hotel_id = $hotel_id;
                                 $TourGuide->save();
                              } 
                          }
                          /*============hotel contact data insert========*/
                          $name = $getData[114]; //NAME
                          $title = $getData[115]; //TITLE
                          $phone = $getData[116]; //PHONE
                          $email = $getData[117]; //EMAIL
                          $skype_id = $getData[118]; //SKYPE ID
                          $PrevHotelContact = HotelContact::where('hotel_id', '=', $hotel_id)->get()->first();
                          if(!empty($PrevHotelContact)){
                              HotelContact::where('hotel_id', '=', $hotel_id)->delete();
                          }
                          $HotelContact = new HotelContact;
                          $HotelContact->website = $website;
                          $HotelContact->address = utf8_encode($physical_addrress);
                          $HotelContact->hotel_id = $hotel_id;
                          $HotelContact->contact_person_name = $name;
                          $HotelContact->contact_person_email = utf8_encode($email);
                          $HotelContact->contact_person_phone = $phone;
                          $HotelContact->title = $title;
                          $HotelContact->save();
                    }
                }
            }
            $row++;
        } while (($getData = fgetcsv($file, 0, ","))!== FALSE);
    }
    return redirect()->back()->with('message', 'Hotels added successfully!');

}

public function create()
{
        //
}

public function store(Request $request)
{
        //
}

public function show($id)
{
        //
}

public function edit($lang, $id)
{   
    $hotels = Hotels::where('id', '=' , $id)->get()->first();
    $hotels->translate($lang);
    $species = Species::all();
    $accommodations = Accommodations::all();
    $inspirations = Inspirations::all();
    $experiences = Experiences::all();
    $keyfeature = KeyFeature::all();
    $servicefacility = ServiceFacility::all();
    $roomfacility = RoomFacility::all();
    $recreation = Recreation::all();
    $species_relation = HotelSpeciesRelation::where('hotel_id', '=' , $id)->get();
    $accommodation_relation = HotelAccommodationRelation::where('hotel_id', '=' , $id)->get();
    $inspirations_relation = HotelInspirationsRelation::where('hotel_id', '=' , $id)->get();
    $experiences_relation = HotelExperiencesRelation::where('hotel_id', '=' , $id)->get();
    $features_relations = HotelFeaturesRelation::where('hotel_id', '=' , $id)->get();
    $servicefacilities_relations = ServiceFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
    $roomfacilities_relations = RoomFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
    $reactiontranslation = RecreationTranslation::where('hotel_id', '=' , $id)->get();
    $hotelawards = HotelAward::where('hotel_id', '=' , $id)->get();
    $image_gallery = HotelGallery::where('hotel_id', '=' , $id)->get();
    $hotelcontact = HotelContact::where('hotel_id', '=' , $id)->get()->first();
    $hoteladdress = HotelAddress::where('hotel_id', '=' , $id)->get()->first();
    $hotelfishing = Fisherman::where('hotel_id', '=' , $id)->get()->first();
    $fooddrink = FoodDrink::where('hotel_id', '=' , $id)->get();
    return view('admin.hotels.edit', compact('hotels', 'species', 'species_relation', 'accommodations', 'accommodation_relation', 'inspirations', 'experiences', 'inspirations_relation', 'experiences_relation', 'hotelcontact', 'image_gallery', 'hoteladdress', 'keyfeature', 'features_relations', 'servicefacility', 'servicefacilities_relations', 'roomfacility', 'roomfacilities_relations', 'recreation', 'reactiontranslation', 'hotelawards', 'fooddrink', 'hotelfishing'));
}

public function update(Request $request, $lang, $id)
{   
        
        $form_no = $request->form_no;
        switch ($form_no) {
          case 1:
            $this->validate($request, [
              'hotels_name' => 'required|string|max:255',
              'region_id' => 'required|integer',
              'country_id' => 'required|integer',
              'state_id' => 'required|integer',
              'town' => 'required|string|max:255',
              'email_id' => 'required|email'
          ]);
            $lang =  \App::getLocale(); 
            $hotels = Hotels::find($id);
            $hotels->locale = $request->locale;
            $hotels->hotels_name = $request->hotels_name;
            $hotels->enthusiast_services = $request->enthusiast_services;
            $hotels->distance_airport = $request->distance_airport;
            $hotels->transfers_mode = $request->transfers_mode;
            $hotels->services_amenities = $request->services_amenities;
            $hotels->additional_information = $request->additional_information;
            $hotels->no_of_restaurant = $request->no_of_restaurant;
            $hotels->no_of_pools = $request->no_of_pools;
            $hotels->no_of_floor = $request->no_of_floor;
            $hotels->curator_rating = $request->curator_rating;
            $hotels->size_of_room = $request->size_of_room;
            $hotels->region_id = $request->region_id;
            $hotels->country_id = $request->country_id;
            $hotels->state_id = $request->state_id;
            $hotels->town = $request->town;
            $hotels->activity_season = $request->activity_season;
            $hotels->email_id = $request->email_id;
            $hotels->nearest_airport = $request->nearest_airport;
            $hotels->no_of_rooms = $request->no_of_rooms;
            $hotels->check_in = $request->check_in;
            $hotels->check_out = $request->check_out;
            $hotels->phone = $request->phone;
            $hotels->spa_availability = $request->spa_availability;
            $hotels->beach_availability = $request->beach_availability;
            $hotels->fine_dining_availability = $request->fine_dining_availability;
            $hotels->save();

            return redirect()->back()->with('message', 'Hotels updated successfully!');
            break;
          
          case 2:
              $lang =  \App::getLocale(); 
              $hotels = Hotels::find($id);
              $hotels->hotels_desc = $request->hotels_desc;
              $hotels->how_to_get_there = $request->how_to_get_there;
              $hotels->useful_information = $request->useful_information;
              $hotels->need_to_know = $request->need_to_know;
              $hotels->highlights = $request->highlights;
              $hotels->brief_descp = $request->brief_descp;
              $hotels->fishing = $request->fishing;
              $hotels->deposit_policy = $request->deposit_policy;
              $hotels->cancellation_policy = $request->cancellation_policy;
              $hotels->save();

            return redirect()->back()->with('message', 'Hotels updated successfully!');
            break;
          case 3:
          //Accommodation relation
          $accommodation_relation = HotelAccommodationRelation::where('hotel_id', '=' , $id)->get()->toArray();
          $accommodation_ids = $request->accommodation_id;
          if(!empty($accommodation_relation)){
            for ($i=0; $i < count($accommodation_relation) ; $i++) { 
              HotelAccommodationRelation::where('hotel_id', '=', $id)->where('accommodation_id', '=', $accommodation_relation[$i]['accommodation_id'])->delete();
            }
          }

          if (!empty($accommodation_ids)) {
            for ($j=0; $j < count($accommodation_ids) ; $j++) { 
              $accommodation_relation = new HotelAccommodationRelation;
              $accommodation_relation->accommodation_id = $accommodation_ids[$j];
              $accommodation_relation->hotel_id = $id;
              $accommodation_relation->save();
            }
          }
        //Species
          $species_relation = HotelSpeciesRelation::where('hotel_id', '=' , $id)->get()->toArray();
          $species_ids = $request->species_id;
          if(!empty($species_relation)){
            for ($k=0; $k < count($species_relation) ; $k++) { 
              HotelSpeciesRelation::where('hotel_id', '=', $id)->where('species_id', '=', $species_relation[$k]['species_id'])->delete();
            }
          }

          if (!empty($species_ids)) {
            for ($l=0; $l < count($species_ids) ; $l++) { 
              $species_relation = new HotelSpeciesRelation;
              $species_relation->species_id = $species_ids[$l];
              $species_relation->hotel_id = $id;
              $species_relation->save();
            }
          }

        //Inspirations
          $inspirations_relation = HotelInspirationsRelation::where('hotel_id', '=' , $id)->get()->toArray();
          $inspirations_ids = $request->inspirations_id;
          if(!empty($inspirations_relation)){
            for ($m=0; $m < count($inspirations_relation) ; $m++) { 
              HotelInspirationsRelation::where('hotel_id', '=', $id)->where('inspirations_id', '=', $inspirations_relation[$m]['inspirations_id'])->delete();
            }
          }

          if (!empty($inspirations_ids)) {
            for ($n=0; $n < count($species_ids) ; $n++) { 
              $inspirations_relation = new HotelInspirationsRelation;
              $inspirations_relation->inspirations_id = $inspirations_ids[$n];
              $inspirations_relation->hotel_id = $id;
              $inspirations_relation->save();
            }
          }

        //Experiences
          $experiences_relation = HotelExperiencesRelation::where('hotel_id', '=' , $id)->get()->toArray();
          $experiences_ids = $request->experiences_id;
          if(!empty($experiences_relation)){
            for ($p=0; $p < count($experiences_relation) ; $p++) { 
              HotelExperiencesRelation::where('hotel_id', '=', $id)->where('experiences_id', '=', $experiences_relation[$p]['experiences_id'])->delete();
            }
          }

          if (!empty($experiences_ids)) {
            for ($q=0; $q < count($experiences_ids) ; $q++) { 
              $experiences_relation = new HotelExperiencesRelation;
              $experiences_relation->experiences_id = $experiences_ids[$q];
              $experiences_relation->hotel_id = $id;
              $experiences_relation->save();
            }
          }

        //Features
          $features_relation = HotelFeaturesRelation::where('hotel_id', '=' , $id)->get()->toArray();
          $features_ids = $request->features_id;
          if(!empty($features_relation)){
            for ($r=0; $r < count($features_relation) ; $r++) { 
              HotelFeaturesRelation::where('hotel_id', '=', $id)->where('features_id', '=', $features_relation[$r]['features_id'])->delete();
            }
          }

          if (!empty($features_ids)) {
            for ($s=0; $s < count($features_ids) ; $s++) { 
              $features_relation = new HotelFeaturesRelation;
              $features_relation->features_id = $features_ids[$s];
              $features_relation->hotel_id = $id;
              $features_relation->save();
            }
          }

        //Service & facilities
          $service_relation = ServiceFacilitiesTranslation::where('hotel_id', '=' , $id)->get()->toArray();
          $service_facilities_ids = $request->service_facilities_id;
          if(!empty($service_relation)){
            for ($p=0; $p < count($service_relation) ; $p++) { 
              ServiceFacilitiesTranslation::where('hotel_id', '=', $id)->where('service_facilities_id', '=', $service_relation[$p]['service_facilities_id'])->delete();
            }
          }

          if (!empty($service_facilities_ids)) {
            for ($q=0; $q < count($service_facilities_ids) ; $q++) { 
              $service_relation = new ServiceFacilitiesTranslation;
              $service_relation->service_facilities_id = $service_facilities_ids[$q];
              $service_relation->hotel_id = $id;
              $service_relation->save();
            }
          }

        //Room facilities
          $room_facilities_relation = RoomFacilitiesTranslation::where('hotel_id', '=' , $id)->get()->toArray();
          $room_facilities_ids = $request->room_facilities_id;
          if(!empty($room_facilities_relation)){
            for ($a=0; $a < count($room_facilities_relation) ; $a++) { 
              RoomFacilitiesTranslation::where('hotel_id', '=', $id)->where('room_facilities_id', '=', $room_facilities_relation[$a]['room_facilities_id'])->delete();
            }
          }

          if (!empty($room_facilities_ids)) {
            for ($b=0; $b < count($room_facilities_ids) ; $b++) { 
              $room_facilities_relation = new RoomFacilitiesTranslation;
              $room_facilities_relation->room_facilities_id = $room_facilities_ids[$b];
              $room_facilities_relation->hotel_id = $id;
              $room_facilities_relation->save();
            }
          }

        //Recreations
          $room_facilities_relation = RecreationTranslation::where('hotel_id', '=' , $id)->get()->toArray();
          $recreation_ids = $request->recreation_id;
          if(!empty($room_facilities_relation)){
            for ($c=0; $c < count($room_facilities_relation) ; $c++) { 
              RecreationTranslation::where('hotel_id', '=', $id)->where('recreation_id', '=', $room_facilities_relation[$c]['recreation_id'])->delete();
            }
          }

          if (!empty($recreation_ids)) {
            for ($d=0; $d < count($recreation_ids) ; $d++) { 
              $room_facilities_relation = new RecreationTranslation;
              $room_facilities_relation->recreation_id = $recreation_ids[$d];
              $room_facilities_relation->hotel_id = $id;
              $room_facilities_relation->save();
            }
          }
        //Awards
          $awards = $request->awards;
          $hotelawards = HotelAward::where('hotel_id', '=' , $id)->get()->toArray();
          if(!empty($hotelawards)){
            for ($a=0; $a < count($hotelawards) ; $a++) { 
              HotelAward::where('hotel_id', '=', $id)->delete();
            }
          }
          if (!empty($awards)) {
            for ($e=0; $e < count($awards) ; $e++) { 
              if($awards[$e] !=""){
                $hotelaward = new HotelAward;
                $hotelaward->award_title = $awards[$e];
                $hotelaward->hotel_id = $id;
                $hotelaward->save();
              }
            }
          }
         //Food & Drinks
          $fooddrinks = FoodDrink::where('hotel_id', '=' , $id)->get()->toArray();
          if(!empty($fooddrinks)){
            for ($x=0; $x < count($fooddrinks) ; $x++) { 
              FoodDrink::where('hotel_id', '=', $id)->delete();
            }
          }
          $tot_food = $request->tot_food;
          if ($tot_food !="") {
            for ($f=0; $f < $tot_food  ; $f++) { 
              $food_title = $request->{'food_title_'.$f};
              $cusine_type = $request->{'cusine_type_'.$f};
              $food_drink_descp = $request->{'food_drink_descp_'.$f};
              $meal_served = $request->{'meal_served_'.$f};
              if(!empty($meal_served)){
                //print_r($meal_served);
                $meal_served = implode(", ", $meal_served);

                if($food_title !="" && $cusine_type !="" && $food_drink_descp !="" && $meal_served !=""){
                  $fooddrink = new FoodDrink;
                  $fooddrink->food_title = $food_title;
                  $fooddrink->cusine_type = $cusine_type;
                  $fooddrink->food_drink_descp = $food_drink_descp;
                  $fooddrink->meal_served = $meal_served;
                  $fooddrink->hotel_id = $id;
                  $fooddrink->save();
                }
              }
            }
          }
          return redirect()->back()->with('message', 'Hotels updated successfully!');
            break;
            case 4:
            $hotel_contact = HotelContact::where('hotel_id', '=' , $id)->get()->first();
            if(!empty($hotel_contact)){
              $hotel_contact->website = $request->website;
              $hotel_contact->address = $request->address;
              $hotel_contact->contact_person_name = $request->contact_person_name;
              $hotel_contact->contact_person_email = $request->contact_person_email;
              $hotel_contact->contact_person_phone = $request->contact_person_phone;
              $hotel_contact->title = $request->title;
              $hotel_contact->skype_id = $request->skype_id;
              $hotel_contact->save();
            }else{
              $hotel_contact = new HotelContact;
              $hotel_contact->hotel_id = $id;
              $hotel_contact->website = $request->website;
              $hotel_contact->address = $request->address;
              $hotel_contact->contact_person_name = $request->contact_person_name;
              $hotel_contact->contact_person_email = $request->contact_person_email;
              $hotel_contact->contact_person_phone = $request->contact_person_phone;
              $hotel_contact->title = $request->title;
              $hotel_contact->skype_id = $request->skype_id;
              $hotel_contact->save();
            }
            
            $hoteladdress = HotelAddress::where('hotel_id', '=' , $id)->get()->first();
            if(!empty($hoteladdress)){
              $hoteladdress->hotel_id = $id;
              $hoteladdress->location = $request->address;
              $hoteladdress->street_number = $request->street_number;
              $hoteladdress->route = $request->route;
              $hoteladdress->country = $request->country;
              $hoteladdress->city = $request->locality;
              $hoteladdress->state = $request->administrative_area_level_1;
              $hoteladdress->zip_code = $request->postal_code;
              $hoteladdress->latitude = $request->latitude;
              $hoteladdress->longitude = $request->longitude;
              $hoteladdress->save();
            }else{
              $hoteladdress = new HotelAddress;
              $hoteladdress->hotel_id = $id;
              $hoteladdress->location = $request->address;
              $hoteladdress->street_number = $request->street_number;
              $hoteladdress->route = $request->route;
              $hoteladdress->country = $request->country;
              $hoteladdress->city = $request->locality;
              $hoteladdress->state = $request->administrative_area_level_1;
              $hoteladdress->zip_code = $request->postal_code;
              $hoteladdress->latitude = $request->latitude;
              $hoteladdress->longitude = $request->longitude;
              $hoteladdress->save();
            }
        return redirect()->back()->with('message', 'Hotels updated successfully!');
            break;
            case 5:
            $hotels = Hotels::find($id);
            $featured_image = $request->file('featured_image');
            if($featured_image){
                $featured_image = $featured_image->getClientOriginalName();
                $path = $request->featured_image->store('public/uploads');
                $hotels->featured_image = $path;
            }
            $hotels->save();
             $gallery_images = $request->gallery_image;
              if(!empty($gallery_images)){

                  for ($i=0; $i < count($gallery_images) ; $i++) { 
                   $gallery_image = $request->file('gallery_image')[0];
                   if($gallery_image){
                      $gallery_image = $gallery_image->getClientOriginalName();
                      $path = $request->gallery_image[$i]->store('public/uploads');
                      $data = array();
                      $data['hotel_id'] = $id;
                      $data['image'] = $path;
                      HotelGallery::create($data);
                  }   
              }
          }
          return redirect()->back()->with('message', 'Hotels updated successfully!');
            break;
            case 6:
            $fishing = Fisherman::where('hotel_id', '=' , $id)->get()->first();
            if(!empty($fishing)){
              $fishing->booking_cnf = $request->booking_cnf;
              if(isset($request->provide_on_site)){
                $fishing->provide_on_site = $request->provide_on_site;
              }else{
                $fishing->provide_on_site = 'no';
              }
              if(isset($request->arrange_fishing_nearby)){
                $fishing->arrange_fishing_nearby = $request->arrange_fishing_nearby;
              }else{
                $fishing->arrange_fishing_nearby = 'no';
              }
              if(isset($request->provide_our_curated)){
                $fishing->provide_our_curated = $request->provide_our_curated;
              }else{
                $fishing->provide_our_curated = 'no';
              }
              $fishing->save();
            }else{
              $fishing = new Fisherman;
              $fishing->hotel_id = $id;
              $fishing->booking_cnf = $request->booking_cnf;
              if(isset($request->provide_on_site)){
                $fishing->provide_on_site = $request->provide_on_site;
              }else{
                $fishing->provide_on_site = 'no';
              }
              if(isset($request->arrange_fishing_nearby)){
                $fishing->arrange_fishing_nearby = $request->arrange_fishing_nearby;
              }else{
                $fishing->arrange_fishing_nearby = 'no';
              }
              if(isset($request->provide_our_curated)){
                $fishing->provide_our_curated = $request->provide_our_curated;
              }else{
                $fishing->provide_our_curated = 'no';
              }
              $fishing->save();
            }
            return redirect()->back()->with('message', 'Hotels updated successfully!');
            break;
            case 7:
            TourGuide::where('hotel_id', '=', $id)->delete();
            for ($i=0; $i < 6 ; $i++) {
              $business_name =  $request->{ 'business_name_'.($i+1)};
              $website =  $request->{ 'website_'.($i+1)};
              $email =  $request->{ 'email_'.($i+1)};
              $phone =  $request->{ 'phone_'.($i+1)};
              $contact_name =  $request->{ 'contact_name_'.($i+1)};
              $type =  'guide_'.($i+1);
              if($business_name !=""){
                 $TourGuide = new TourGuide;
                 $TourGuide->business_name = $business_name;
                 $TourGuide->website = $website;
                 $TourGuide->email = $email;
                 $TourGuide->phone = $phone;
                 $TourGuide->contact_name = $contact_name;
                 $TourGuide->type = $type;
                 $TourGuide->hotel_id = $id;
                 $TourGuide->save();
               }
            }
            return redirect()->back()->with('message', 'Hotels updated successfully!');
            break;

        }
        
}

public function doDelete($lang, $id)
{
    $hotels = Hotels::where('id', '=' , $id)->get()->first();
    $hotels->translate($lang);
    Hotels::where('id', $id)->delete();
    return redirect()->back()->with('message', 'Hotel deleted successfully!');

}
public function delHotelgallery(Request $request,$lang){
    $gld=HotelGallery::where('id', '=', $request->key)->get()->first();
    @Storage::Delete($gld->image);
    HotelGallery::where('id', '=', $request->key)->delete();
    $output = array('success' => 'Successfully Deleted' );
    echo json_encode($gld); 
    exit;
}
  public function direct_contact(){
    $hotels = Hotels::select('*', 'hotels.id as h_id')->leftJoin('fishermen', 'hotels.id', '=', 'fishermen.hotel_id')->leftJoin('hotel_contacts', 'hotels.id', '=', 'hotel_contacts.hotel_id')->get()->all();
    return view('admin.hotels.direct_contact', compact('hotels'));
  }

  public function reviews(){
    $review = Review::select('*', 'reviews.created_at as create_date', 'reviews.id as rev_id')->leftJoin('hotels_translations', 'reviews.hotel_id', '=', 'hotels_translations.hotels_id')->leftJoin('users', 'reviews.user_id', '=', 'users.id')->orderBy('reviews.created_at', 'desc')->get()->all();
    return view('admin.hotels.review', compact('review'));
  }
  public function del_reviews($id){
      $review = Review::where('id', '=' , $id)->get()->first();
      Review::where('id', $id)->delete();
      return redirect()->back()->with('message', 'Review deleted successfully!');
  }

  public function change_status(Request $request,$id){
      $review = Review::where('id', '=' , $id)->get()->first();
        if($request->status == 0){
            $review->status = 1;
        }else{
            $review->status = 0;
        }
        $review->save();
        return redirect()->back()->with('message', 'Status changes successfully!');
  }
}
