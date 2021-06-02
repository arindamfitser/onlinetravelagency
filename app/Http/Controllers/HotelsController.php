<?php
namespace App\Http\Controllers;
use App\Hotels;
use App\HotelNewEntry;
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
use App\FoodDrink;
use App\Fisherman;
use App\TourGuide;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class HotelsController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function hotels_list(){
    	$user = auth('web')->user();
    	$hotels = Hotels::where('user_id', '=', $user->id)->get();
    	return view('frontend.hotelier.listhotel', compact('hotels'));
    }
    public function hotels_add(Request $request){
        $hotels = new Hotels;
        $hotels->user_id = $request->user_id;
        $hotels->save();
        return redirect()->route('user.hotels.edit', ['id' => $hotels->id]);
    }
    public function hotels_edit($id){
        $user = auth('web')->user();
    	$hotels = HotelNewEntry::where('id', '=' , $id)->where('user_id', '=', $user->id)->first();
        if($hotels):
            $hotels->accommodations         = Accommodations::all();
            $hotels->species                = Species::all();
            $hotels->inspirations           = Inspirations::all();
            $hotels->experiences            = Experiences::all();
            $hotels->keyfeature             = KeyFeature::all();
            $hotels->servicefacility        = ServiceFacility::all();
            $hotels->roomfacility           = RoomFacility::all();
            $hotels->recreation             = Recreation::all();
            // $hotels->accommodation_relation = HotelAccommodationRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->species_relation = HotelSpeciesRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->inspirations_relation = HotelInspirationsRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->experiences_relation = HotelExperiencesRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->features_relations = HotelFeaturesRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->servicefacilities_relations = ServiceFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
            // $hotels->roomfacilities_relations = RoomFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
            // $hotels->reactiontranslation = RecreationTranslation::where('hotel_id', '=' , $id)->get();
            // $hotels->image_gallery = HotelGallery::where('hotel_id', '=' , $id)->get();
            // $hotels->hotelcontact = HotelContact::where('hotel_id', '=' , $id)->get()->first();
            // $hotels->hoteladdress = HotelAddress::where('hotel_id', '=' , $id)->get()->first();
            // $hotels->hotelawards = HotelAward::where('hotel_id', '=' , $id)->get();
            // $hotels->hotelfishing = Fisherman::where('hotel_id', '=' , $id)->get()->first();
            // $hotels->fooddrink = FoodDrink::where('hotel_id', '=' , $id)->get();
            return view('frontend.hotelier.edithotel', compact('hotels'));
        else:
            return abort(404); 
        endif;
    } 
    public function hotels_update(Request $request, $id){
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
            $hotels_slug = createSlug($request->hotels_name);
            if(hotelSlugExists($hotels_slug) == false){
                $hotels->hotels_slug = $hotels_slug;
            }
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

        //Features
        $features_relation = HotelFeaturesRelation::where('hotel_id', '=' , $id)->get()->toArray();
        $features_ids = $request->features_id;
        if(!empty($features_relation)){
            for ($p=0; $p < count($features_relation) ; $p++) { 
                HotelFeaturesRelation::where('hotel_id', '=', $id)->where('features_id', '=', $features_relation[$p]['features_id'])->delete();
            }
        }

        if (!empty($features_ids)) {
            for ($q=0; $q < count($features_ids) ; $q++) { 
                $features_relation = new HotelFeaturesRelation;
                $features_relation->features_id = $features_ids[$q];
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
        case 5:
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
        case 6:
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
        case 7:
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
        }
    	

    }
    public function hotels_update_new(Request $request, $id){
        $form_no = $request->form_no;
        switch ($form_no) :
            case 1:
                $lang                               = \App::getLocale();
                $hotels                             = HotelNewEntry::find($id);
                $hotels->hotels_name                = $request->hotels_name;
                $hotels->nearest_airport            = $request->nearest_airport;
                $hotels->distance_airport           = $request->distance_airport;
                $hotels->transfers_mode             = $request->transfers_mode;
                $hotels->region_id                  = $request->region_id;
                $hotels->country_id                 = $request->country_id;
                $hotels->state_id                   = $request->state_id;
                $hotels->town                       = $request->town;
                $hotels->email_id                   = $request->email_id;
                $hotels->phone                      = $request->phone;
                $hotels->website                    = $request->website;
                $hotels->address                    = $request->address;
                $hotels->mailing_address            = $request->mailing_address;
                $hotels->latitude                   = $request->latitude;
                $hotels->longitude                  = $request->longitude;
                $hotels->street_number              = $request->street_number;
                $hotels->route                      = $request->route;
                $hotels->city                       = $request->locality;
                $hotels->state                      = $request->administrative_area_level_1;
                $hotels->country                    = $request->country;
                $hotels->zip_code                   = $request->postal_code;
                $hotels_slug                        = createSlug($request->hotels_name);
                if(hotelSlugExists($hotels_slug) == false):
                    $updtArray['hotels_slug']       = $hotels_slug;
                endif;
                $hotels->save();
                print 'Hotel Details Updated Successfully !!!';
                break;
            case 2:
                $lang =  \App::getLocale();
                $hotels                             = HotelNewEntry::find($id);
                $hotels->hotels_desc                = $request->hotels_desc;
                $hotels->brief_descp                = $request->brief_descp;
                $hotels->beach_availability         = $request->beach_availability;
                $hotels->fine_dining_availability   = $request->fine_dining_availability;
                $hotels->water_sports               = $request->water_sports;
                $hotels->diving                     = $request->diving;
                $hotels->no_of_rooms                = $request->no_of_rooms;
                $hotels->no_of_restaurant           = $request->no_of_restaurant;
                $hotels->no_of_floor                = $request->no_of_floor;
                $hotels->additional_information     = $request->additional_information;
                $hotels->spa_availability           = $request->spa_availability;
                $hotels->spa_type                   = $request->spa_type;
                $hotels->pool                       = $request->pool;
                $hotels->pool_type                  = $request->pool_type;
                $hotels->no_of_pools                = $request->no_of_pools;
                $hotels->activities                 = $request->activities;
                $hotels->tours                      = $request->tours;
                $hotels->dining                     = $request->dining;
                $hotels->highlights                 = $request->highlights;
                $nearby_attraction                  = array();
                $distance                           = array();
                if($request->nearby_attraction):
                    foreach($request->nearby_attraction as $nakey => $na):
                        array_push($nearby_attraction, $na);
                        array_push($distance, $request->distance[$nakey]);
                    endforeach;
                endif;
                $hotels->nearby_attraction          = json_encode($nearby_attraction);
                $hotels->distance                   = json_encode($distance);
                $hotels->check_in                   = $request->check_in;
                $hotels->check_out                  = $request->check_out;
                $hotels->hotel_policy               = $request->hotel_policy;
                $hotels->need_to_know               = $request->need_to_know;
                $service_facilities                 = array();
                if (!empty($request->service_facilities_id)) :
                    foreach($request->service_facilities_id as $sfn):
                        array_push($service_facilities, $sfn);
                    endforeach;
                endif;
                $hotels->service_facility           = json_encode($service_facilities);
                $room_facilitie                     = array();
                if (!empty($request->room_facilities_id)) :
                    foreach($request->room_facilities_id as $rfn):
                        array_push($room_facilitie, $rfn);
                    endforeach;
                endif;
                $hotels->room_facility              = json_encode($room_facilitie);
                $hotels->hotelfishing               = $request->hotelfishing;
                if(isset($request->provide_on_site)):
                    $hotels->provide_on_site        = $request->provide_on_site;
                else:
                    $hotels->provide_on_site        = 'no';
                endif;
                if(isset($request->arrange_fishing_nearby)):
                    $hotels->arrange_fishing_nearby = $request->arrange_fishing_nearby;
                else:
                    $hotels->arrange_fishing_nearby = 'no';
                endif;
                if(isset($request->provide_our_curated)):
                    $hotels->provide_our_curated    = $request->provide_our_curated;
                else :
                    $hotels->provide_our_curated    = 'no';
                endif;
                $hotels->save();
                return redirect()->back()->with('message', 'Hotels updated successfully!');
                break;
            case 3:
                $hotels                 = HotelNewEntry::find($id);
                $featured_image         = $request->file('featured_image');
                $img                    = $request->old_featured_image;
                if($featured_image):
                    $img                = time().$featured_image->getClientOriginalName();
                    $request->featured_image->move(public_path('uploads'), $img);
                endif;
                $hotels->featured_image = $img;
                $image_gallery          = array();
                $image_alt              = array();
                $image_seq              = array();
                if(isset($request->old_gallery_image)):
                    foreach($request->old_gallery_image as $ogKeyyy => $ogi):
                        array_push($image_gallery, $ogi);
                        array_push($image_alt, $request->old_gallery_image_alt[$ogKeyyy]);
                        array_push($image_seq, (!empty($request->old_gallery_image_seq[$ogKeyyy])) ? $request->old_gallery_image_seq[$ogKeyyy] : '1');
                    endforeach;
                endif;
                if(isset($request->gallery_image)):
                    $gallery_images = $request->gallery_image;
                    if(!empty($gallery_images)):
                        for ($i=0; $i < count($gallery_images) ; $i++) :
                            $gallery_image = $request->file('gallery_image')[$i];
                            if($gallery_image):
                                $gallery_image      = time().$gallery_image->getClientOriginalName();
                                $request->gallery_image[$i]->move(public_path('uploads'), $gallery_image);
                                array_push($image_gallery, $gallery_image);
                                array_push($image_alt, $request->gallery_image_alt[$i]);
                                array_push($image_seq, (!empty($request->gallery_image_seq[$i])) ? $request->gallery_image_seq[$i] : '1');
                            endif;
                        endfor;
                    endif;
                endif;
                $hotels->image_gallery  = json_encode($image_gallery);
                $hotels->image_alt      = json_encode($image_alt);
                $hotels->image_sequence = json_encode($image_seq);
                $hotels->save();
                break;
        endswitch;
    }
    public function hotelierDeleteHotelImage(Request $request){
        $gld    = HotelGallery::where('id', '=', $request->imgId)->get()->first();
        unlink(public_path('uploads/' . $gld->image));
        HotelGallery::where('id', '=', $request->imgId)->delete();
    }
    public function delHotelgallery(Request $request){
        $gld=HotelGallery::where('id', '=', $request->key)->get()->first();
        @Storage::Delete($gld->image);
        HotelGallery::where('id', '=', $request->key)->delete();
        $output = array('success' => 'Successfully Deleted' );
        echo json_encode($gld); 
     exit;
    }
    public function hotels_del($id){
        Hotels::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Hotel deleted successfully!');

    }
    public function statusChange(Request $request, $id){
        $hotel = Hotels::find($id);
        $hotel->status = $request->status;
        $hotel->save();
        return redirect()->back();
    }
}
