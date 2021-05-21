<?php
namespace App\Http\Controllers\admin;
use Mail;
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

use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\PriceMatrix;
use App\Price;
use App\RoomAvailability;
use App\Amenities;
use App\RoomsAmenitie;
use App\RoomAllocation;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotelsControllerNew extends Controller{
    public function __construct(){
    }
    private static function pr($data, $action = TRUE){
        echo "<pre>";
        print_r($data);
        if($action):
            die;
        endif;
    }
    public function index(){  
        $this->middleware('auth:admin');
        $hotels = HotelNewEntry::all();
        return view('admin.direct-contract.hotels', compact('hotels'));
    }
    public function sendInvitation(){
        $this->middleware('auth:admin'); 
        return view('admin.direct-contract.send-invidation');
    }
    public function saveInvitation(Request $request){
        $this->middleware('auth:admin'); 
        $check      = DB::table('invitations')->select('id')->where('contact_email', $request->contact_email)->get()->first();
        if(empty($check)):
            $e_data = array(
                'hotel_name'            => $request->hotel_name,
                'address'               => $request->address,
                'country'               => $request->country, 
                'state'                 => $request->state,
                'city'                  => $request->city, 
                'representative_name'   => $request->representative_name,
                'contact_email'         => $request->contact_email, 
                'contact_phone'         => $request->contact_phone
            );
            $insertId               = DB::table('invitations')->insertGetId($e_data);
            $e_data['verifyLink']   = url('register-for-direct-contract/' . base64_encode($insertId));
            DB::table('invitations')
                ->where('id', $insertId)
                ->update(['link' => $e_data['verifyLink']]);
            /*Mail::send('emails.direct-contract-invitation', ['e_data' => $e_data], function ($m) use ($e_data) {
                $m->from('no-reply@fitser.com', 'Luxury Fishing');
                $m->to($e_data['contact_email'], $e_data['representative_name'])->subject('Invitaion To Register | Luxury Fishing');
            });*/
            $response = array(
                'success'   => TRUE,
                'message'   => 'Invitation Sent Successfully !!!',
                'swal'      => 'success'
            );
        else:
            $response = array(
                'success'   => FALSE,
                'message'   => 'Invitation Already Sent !!!',
                'swal'      => 'warning'
            );
        endif;
        print json_encode($response);
    }
    public function invitationList(){
        $this->middleware('auth:admin'); 
        $invitations = DB::table('invitations')->orderBy('id', 'DESC')->get()->all();
        return view('admin.direct-contract.invitations', compact('invitations'));
    }
    public function registerDirectContract($code = ''){
        $code = (empty($code)) ? base64_encode('1') : $code;
        $details    = DB::table('invitations')->select('*')->where('id', base64_decode($code))->get()->first();
        return view('admin.direct-contract.register', compact('details'));
    }
    public function registerNewDirectContractHotel(Request $request){
        $check                              = DB::table('temp_direct_contract')->select('id')->where('hotel_email', $request->hotel_email)->get()->first();
        if(empty($check)):
            $insertArray                    = array(
                'invitation_id'             => $request->invitation_id,
                'hotel_name'                => $request->hotel_name,
                'hotel_email'               => $request->hotel_email,
                'hotel_phone'               => $request->hotel_phone,
                'hotel_address'             => $request->hotel_address,
                'hotel_country'             => $request->hotel_country,
                'hotel_state'               => $request->hotel_state, 
                'hotel_city'                => $request->hotel_city,
                'hotel_description'         => $request->hotel_description,
                'addition_info'             => $request->addition_info,
                'amenities'                 => $request->amenities,
                'spa_available'             => $request->spa_available,
                'beach_available'           => $request->beach_available,
                'fine_dining_available'     => $request->fine_dining_available,
                'pool_available'            => $request->pool_available,
                'diving_available'          => $request->diving_available,
                'water_sports_available'    => $request->water_sports_available
            );
            $insertId                       = DB::table('temp_direct_contract')->insertGetId($insertArray);
            $response = array(
                'success'   => TRUE,
                'message'   => 'Hotel Registered Successfully !!!',
                'swal'      => 'success'
            );
        else:
            $response = array(
                'success'   => FALSE,
                'message'   => 'Hotel Already Registered !!!',
                'swal'      => 'warning'
            );
        endif;
        print json_encode($response);
    }
    public function invitationReceived($type = ''){
        $this->middleware('auth:admin');
        switch($type):
            case 'approved':
                $status = '1';
                break;
            case 'rejected':
                $status = '4';
                break;
            case 'return-to-customer':
                $status = '2';
                break;
            default:
                $status = '0';
                break;
        endswitch;
        $received = DB::table('temp_direct_contract')->where('status', $status)->orderBy('id', 'DESC')->get()->all();
        return view('admin.direct-contract.invitation-received', compact('received', 'type'));
    }
    public function invitationDetails($code = ''){
        $code = (empty($code)) ? base64_encode('1') : $code;
        $details    = DB::table('temp_direct_contract')->select('*')->where('id', base64_decode($code))->get()->first();
        return view('admin.direct-contract.invitation-details', compact('details'));
    }
    public function changeHotelStatus(Request $request){
        $hotelCode          = '';
        if($request->changedVal == '1'):
            $details    = DB::table('temp_direct_contract')->select('*')->where('id', $request->changedId)->get()->first();
            DB::table('invitations')->delete($details->invitation_id);
            $insertArray                    = array(
                'hotels_name'               => $details->hotel_name,
                'hotels_slug'               => strtolower(str_replace(' ', '-', $details->hotel_name)),
                'hotels_desc'               => $details->hotel_description,
                'region_id'                 => 9,
                'country_id'                => $details->hotel_country,
                'state_id'                  => $details->hotel_state,
                'town'                      => $details->hotel_city,
                'address'                   => $details->hotel_address,
                'email_id'                  => $details->hotel_email,
                'phone'                     => $details->hotel_phone,
                'additional_information'    => $details->addition_info,
                'services_amenities'        => $details->amenities,
                'spa_availability'          => $details->spa_available,
                'beach_availability'        => $details->beach_available,
                'fine_dining_availability'  => $details->fine_dining_available,
                'pool'                      => ($details->pool_available == '1') ? 'yes' : 'no',
                'diving'                    => ($details->diving_available == '1') ? 'yes' : 'no',
                'water_sports'              => ($details->water_sports_available == '1') ? 'yes' : 'no',
                'contact_status'            => 'D',
                'status'                    => 1
            );
            $insertId                       = DB::table('hotel_new_entries')->insertGetId($insertArray);
            $hotelCode                      = strtoupper('LF'.substr(date('Y'), -2).$insertId.substr($details->hotel_city, 0, 1).substr($details->hotel_name, 0, 2));
            DB::table('hotel_new_entries')
                ->where('id', $insertId)
                ->update(array('hotel_token' => $hotelCode));
        endif;
        $updateArray        = array(
            'status'        => $request->changedVal,
            'hotel_code'    => $hotelCode
        );
        DB::table('temp_direct_contract')
                ->where('id', $request->changedId)
                ->update($updateArray);
    }
    public function invitedHotelDetails($token = ''){
        $this->middleware('auth:admin');
        $hotels                             = HotelNewEntry::where('hotel_token', '=' , $token)->first();
        if($hotels):
            $hotels->accommodations         = Accommodations::all();
            $hotels->species                = Species::all();
            $hotels->inspirations           = Inspirations::all();
            $hotels->experiences            = Experiences::all();
            $hotels->keyfeature             = KeyFeature::all();
            $hotels->servicefacility        = ServiceFacility::all();
            $hotels->roomfacility           = RoomFacility::all();
            $hotels->recreation             = Recreation::all();
            // $hotels->accommodation_relation         = HotelAccommodationRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->species_relation               = HotelSpeciesRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->inspirations_relation          = HotelInspirationsRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->experiences_relation           = HotelExperiencesRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->features_relations             = HotelFeaturesRelation::where('hotel_id', '=' , $id)->get();
            // $hotels->servicefacilities_relations    = ServiceFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
            // $hotels->roomfacilities_relations       = RoomFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
            // $hotels->reactiontranslation            = RecreationTranslation::where('hotel_id', '=' , $id)->get();
            // $hotels->image_gallery                  = HotelGallery::where('hotel_id', '=' , $id)->get();
            // $hotels->hotelcontact                   = HotelContact::where('hotel_id', '=' , $id)->get()->first();
            // $hotels->hoteladdress                   = HotelAddress::where('hotel_id', '=' , $id)->get()->first();
            // $hotels->hotelawards                    = HotelAward::where('hotel_id', '=' , $id)->get();
            // $hotels->hotelfishing                   = Fisherman::where('hotel_id', '=' , $id)->get()->first();
            // $hotels->fooddrink                      = FoodDrink::where('hotel_id', '=' , $id)->get();
            return view('admin.direct-contract.hotel-details', compact('hotels'));
        else:
            return abort(404); 
        endif;
        
    }
    public function hotelsUpdate(Request $request, $id){
        $form_no = $request->form_no;
        switch ($form_no) :
            case 1:
                $lang                               = \App::getLocale(); 
                $hotels                             = HotelNewEntry::find($id);
                $hotels_slug                        = createSlug($request->hotels_name);
                $hotels->hotels_name                = $request->hotels_name;
                $hotels->nearest_airport            = $request->nearest_airport;
                $hotels->distance_airport           = $request->distance_airport;
                $hotels->transfers_mode             = $request->transfers_mode;
                $hotels->region_id                  = $request->region_id;
                $hotels->country_id                 = $request->country_id;
                $hotels->state_id                   = $request->state_id;
                $hotels->town                       = $request->town;
                $hotels->email_id                   = $request->email_id;
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
                if(hotelSlugExists($hotels_slug) == false):
                    $hotels->hotels_slug            = $hotels_slug;
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
                if(isset($request->old_gallery_image)):
                    foreach($request->old_gallery_image as $ogKeyyy => $ogi):
                        array_push($image_gallery, $ogi);
                        array_push($image_alt, $request->old_gallery_image_alt[$ogKeyyy]);
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
                            endif;
                        endfor;
                    endif;
                endif;
                $hotels->image_gallery  = json_encode($image_gallery);
                $hotels->image_alt      = json_encode($image_alt);
                $hotels->save();
                break;
        endswitch;
    }
    public function invitedHotelRooms($code = ''){
        $this->middleware('auth:admin');
        $hotel = HotelNewEntry::where('hotel_token', '=', $code)->first();
        $rooms = Rooms::where('hotel_token', '=', $code)->get();
		return view('admin.direct-contract.rooms', compact('code', 'hotel', 'rooms'));
    }
    public function roomsAdd($code){
        $this->middleware('auth:admin');
        $roomcategory   = RoomCategory::all();
        $amenities      = Amenities::all();
		return view('admin.direct-contract.room-add', compact('code', 'roomcategory', 'amenities'));
	}
    public function roomsDoAdd(Request $request, $code){
        $this->middleware('auth:admin');
        $hotel                      = HotelNewEntry::where('hotel_token', '=', $code)->first();
    	$rooms                      = new Rooms;
    	$featured_image             = $request->file('featured_image');
    	$img                        = '';
        if($featured_image):
            $img                    = time().$featured_image->getClientOriginalName();
            $request->featured_image->move(public_path('uploads'), $img);
        endif;
        $rooms->featured_image      = $img;
    	$rooms->name                = $request->name;
    	$rooms->hotel_token         = $hotel->hotel_token;
    	$rooms->hotel_id            = $hotel->id;
    	$rooms->adult_capacity      = $request->adult_capacity;
    	$rooms->child_capacity      = $request->child_capacity;
        $rooms->room_capacity       = $request->room_capacity;
        $rooms->extra_bed           = $request->extra_bed;
        $rooms->descp               = $request->descp;
        $rooms->availability        = $request->availability;
        $rooms->base_price          = $request->base_price;
    	$rooms->save();
        $room_id = $rooms->id;
        for ($i=0; $i < count($request->amenities) ; $i++) :
           $roomsamenitie = new RoomsAmenitie;
           $roomsamenitie->room_id = $room_id;
           $roomsamenitie->amenities_id = $request->amenities[$i];
           $roomsamenitie->save();
        endfor;
        if(isset($request->gallery_image)):
            $gallery_images = $request->gallery_image;
            if(!empty($gallery_images)):
                for ($i=0; $i < count($gallery_images) ; $i++) :
                     $gallery_image = $request->file('gallery_image')[$i];
                     if($gallery_image):
                        $gallery_image      = time().$gallery_image->getClientOriginalName();
                        $request->gallery_image[$i]->move(public_path('uploads'), $gallery_image);
                        $data               = array();
                        $data['room_id']    = $room_id;
                        $data['image']      = $gallery_image;
                        $data['image_alt']  = $request->gallery_image_alt[$i];
                        RoomGallery::create($data);
                    endif;
                endfor;
            endif;
        endif;
        print json_encode(array('success' => true, 'message'=> 'Room Added successfully !!!', 'swal' => 'success'));
    }
    public function roomsEdit($id){
        $this->middleware('auth:admin');
        $rooms          = Rooms::where('id', '=', $id)->get()->first();
        $roomcategory   = RoomCategory::all();
        $amenities      = Amenities::all();
        $rooms_details  = RoomDetail::where('room_id', '=', $id)->get();
        $roomgallery    = RoomGallery::where('room_id', '=', $id)->get();
        $roomsamenitie  = RoomsAmenitie::where('room_id', '=', $id)->get();
        return view('admin.direct-contract.room-edit', compact('id', 'rooms', 'roomcategory', 'rooms_details', 'roomgallery', 'amenities', 'roomsamenitie'));
    }
    public function updateRoom(Request $request, $id){
        $this->middleware('auth:admin');
        $rooms                      = new Rooms;
    	$featured_image             = $request->file('featured_image');
    	$img                        = $request->old_featured_image;
        if($featured_image):
            $img                    = time().$featured_image->getClientOriginalName();
            $request->featured_image->move(public_path('uploads'), $img);
        endif;
        $rooms                      = Rooms::where('id', '=', $id)->get()->first();
        $rooms->featured_image      = $img;
    	$rooms->name                = $request->name;
    	$rooms->adult_capacity      = $request->adult_capacity;
    	$rooms->child_capacity      = $request->child_capacity;
        $rooms->room_capacity       = $request->room_capacity;
        $rooms->extra_bed           = $request->extra_bed;
        $rooms->descp               = $request->descp;
        $rooms->availability        = $request->availability;
        $rooms->base_price          = $request->base_price;
    	$rooms->save();
        if(!empty($request->amenities)):
            RoomsAmenitie::where('room_id', '=', $id)->delete();
            for ($i=0; $i < count($request->amenities) ; $i++) :
                $roomsamenitie                  = new RoomsAmenitie;
                $roomsamenitie->room_id         = $id;
                $roomsamenitie->amenities_id    = $request->amenities[$i];
                $roomsamenitie->save();
            endfor;
        endif;
        if(isset($request->old_gallery_image_id)):
            foreach($request->old_gallery_image_id as $ogiiKey => $ogii):
                $gld            = RoomGallery::where('id', '=', $ogii)->get()->first();
                $gld->image_alt = $request->old_gallery_image_alt[$ogiiKey];
                $gld->save();
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
                        $data               = array();
                        $data['room_id']    = $id;
                        $data['image']      = $gallery_image;
                        $data['image_alt']  = $request->gallery_image_alt[$i];
                        RoomGallery::create($data);
                    endif;
                endfor;
            endif;
        endif;
        print json_encode(array('success' => true, 'message'=> 'Room Details Updated successfully !!!', 'swal' => 'success'));
    }
    public function hotelierDeleteGalleryImage(Request $request){
        $this->middleware('auth:admin');
        $gld    =   RoomGallery::where('id', '=', $request->imgId)->get()->first();
        unlink(public_path('uploads/' . $gld->image));
        RoomGallery::where('id', '=', $request->imgId)->delete();
    }
    
























    
    public function invitedHotelDetailsOLD($token = ''){
        $this->middleware('auth:admin');
        // $details    = DB::table('temp_direct_contract')->select('hotel_code')->where('id', base64_decode($token))->get()->first();
        // $hotels     = Hotels::where('hotel_token', '=' , $details->hotel_code)->get()->first();
        $hotels     = Hotels::where('hotel_token', '=' , $token)->get()->first();
        if($hotels):
            $id                                     = $hotels->id;
            $hotels->accommodations                 = Accommodations::all();
            $hotels->species                        = Species::all();
            $hotels->inspirations                   = Inspirations::all();
            $hotels->experiences                    = Experiences::all();
            $hotels->keyfeature                     = KeyFeature::all();
            $hotels->servicefacility                = ServiceFacility::all();
            $hotels->roomfacility                   = RoomFacility::all();
            $hotels->recreation                     = Recreation::all();
            $hotels->accommodation_relation         = HotelAccommodationRelation::where('hotel_id', '=' , $id)->get();
            $hotels->species_relation               = HotelSpeciesRelation::where('hotel_id', '=' , $id)->get();
            $hotels->inspirations_relation          = HotelInspirationsRelation::where('hotel_id', '=' , $id)->get();
            $hotels->experiences_relation           = HotelExperiencesRelation::where('hotel_id', '=' , $id)->get();
            $hotels->features_relations             = HotelFeaturesRelation::where('hotel_id', '=' , $id)->get();
            $hotels->servicefacilities_relations    = ServiceFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
            $hotels->roomfacilities_relations       = RoomFacilitiesTranslation::where('hotel_id', '=' , $id)->get();
            $hotels->reactiontranslation            = RecreationTranslation::where('hotel_id', '=' , $id)->get();
            $hotels->image_gallery                  = HotelGallery::where('hotel_id', '=' , $id)->get();
            $hotels->hotelcontact                   = HotelContact::where('hotel_id', '=' , $id)->get()->first();
            $hotels->hoteladdress                   = HotelAddress::where('hotel_id', '=' , $id)->get()->first();
            $hotels->hotelawards                    = HotelAward::where('hotel_id', '=' , $id)->get();
            $hotels->hotelfishing                   = Fisherman::where('hotel_id', '=' , $id)->get()->first();
            $hotels->fooddrink                      = FoodDrink::where('hotel_id', '=' , $id)->get();
            return view('admin.direct-contract.hotel-details', compact('hotels'));
        else:
            return abort(404); 
        endif;
        
    }
    public function hotelsUpdateOLD(Request $request, $id){
        $form_no = $request->form_no;
        switch ($form_no) :
            case 1:
                $lang =  \App::getLocale(); 
                $hotels = Hotels::find($id);
                $hotels->nearest_airport            = $request->nearest_airport;
                $hotels->distance_airport           = $request->distance_airport;
                $hotels->transfers_mode             = $request->transfers_mode;
                $hotels->region_id                  = $request->region_id;
                $hotels->country_id                 = $request->country_id;
                $hotels->state_id                   = $request->state_id;
                $hotels->town                       = $request->town;
                $hotels->email_id                   = $request->email_id;
                $hotels->save();
                $hotel_contact = HotelContact::where('hotel_id', '=' , $id)->get()->first();
                if(!empty($hotel_contact)):
                  $hotel_contact->website           = $request->website;
                  $hotel_contact->address           = $request->address;
                  $hotel_contact->mailing_address   = $request->mailing_address;
                  $hotel_contact->save();
                else:
                  $hotel_contact = new HotelContact;
                  $hotel_contact->hotel_id          = $id;
                  $hotel_contact->website           = $request->website;
                  $hotel_contact->address           = $request->address;
                  $hotel_contact->mailing_address   = $request->mailing_address;
                  $hotel_contact->save();
                endif;
                $updtArray  = array(
                                'hotels_name' => $request->hotels_name
                            );
                $hotels_slug = createSlug($request->hotels_name);
                if(hotelSlugExists($hotels_slug) == false):
                    $updtArray['hotels_slug']       = $hotels_slug;
                endif;
                 DB::table('hotels_translations')
                    ->where('hotels_id', $id)
                    ->update($updtArray);
                print 'Hotel Details Updated Successfully !!!';
                break;
            case 2:
                $lang =  \App::getLocale(); 
                $hotels = Hotels::find($id);
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
                $hotels->save();
                //Service & facilities
                $service_relation = ServiceFacilitiesTranslation::where('hotel_id', '=' , $id)->get()->toArray();
                $service_facilities_ids = $request->service_facilities_id;
                if(!empty($service_relation)):
                    for ($p=0; $p < count($service_relation) ; $p++) :
                        ServiceFacilitiesTranslation::where('hotel_id', '=', $id)->where('service_facilities_id', '=', $service_relation[$p]['service_facilities_id'])->delete();
                    endfor;
                endif;
                if (!empty($service_facilities_ids)) :
                    for ($q=0; $q < count($service_facilities_ids); $q++) :
                        $service_relation = new ServiceFacilitiesTranslation;
                        $service_relation->service_facilities_id = $service_facilities_ids[$q];
                        $service_relation->hotel_id = $id;
                        $service_relation->save();
                    endfor;
                endif;
                //Room facilities
                $room_facilities_relation = RoomFacilitiesTranslation::where('hotel_id', '=' , $id)->get()->toArray();
                $room_facilities_ids = $request->room_facilities_id;
                if(!empty($room_facilities_relation)):
                    for ($a=0; $a < count($room_facilities_relation) ; $a++) :
                        RoomFacilitiesTranslation::where('hotel_id', '=', $id)->where('room_facilities_id', '=', $room_facilities_relation[$a]['room_facilities_id'])->delete();
                    endfor;
                endif;
                if (!empty($room_facilities_ids)) :
                    for ($b=0; $b < count($room_facilities_ids) ; $b++) :
                        $room_facilities_relation = new RoomFacilitiesTranslation;
                        $room_facilities_relation->room_facilities_id = $room_facilities_ids[$b];
                        $room_facilities_relation->hotel_id = $id;
                        $room_facilities_relation->save();
                    endfor;
                endif;
                $fishing = Fisherman::where('hotel_id', '=' , $id)->get()->first();
                if(!empty($fishing)):
                    $fishing->booking_cnf = $request->booking_cnf;
                    if(isset($request->provide_on_site)):
                        $fishing->provide_on_site = $request->provide_on_site;
                    else:
                        $fishing->provide_on_site = 'no';
                    endif;
                    if(isset($request->arrange_fishing_nearby)):
                        $fishing->arrange_fishing_nearby = $request->arrange_fishing_nearby;
                    else:
                        $fishing->arrange_fishing_nearby = 'no';
                    endif;
                    if(isset($request->provide_our_curated)):
                        $fishing->provide_our_curated = $request->provide_our_curated;
                    else :
                        $fishing->provide_our_curated = 'no';
                    endif;
                    $fishing->save();
                else:
                    $fishing              = new Fisherman;
                    $fishing->hotel_id    = $id;
                    $fishing->booking_cnf = $request->booking_cnf;
                    if(isset($request->provide_on_site)):
                        $fishing->provide_on_site = $request->provide_on_site;
                    else:
                        $fishing->provide_on_site = 'no';
                    endif;
                    if(isset($request->arrange_fishing_nearby)):
                        $fishing->arrange_fishing_nearby = $request->arrange_fishing_nearby;
                    else:
                        $fishing->arrange_fishing_nearby = 'no';
                    endif;
                    if(isset($request->provide_our_curated)):
                        $fishing->provide_our_curated = $request->provide_our_curated;
                    else:
                        $fishing->provide_our_curated = 'no';
                    endif;
                  $fishing->save();
                endif;
                return redirect()->back()->with('message', 'Hotels updated successfully!');
                break;
        case 3:
            $hotels         = Hotels::find($id);
            $featured_image = $request->file('featured_image');
            $img            = $request->old_featured_image;
            if($featured_image):
                $img        = time().$featured_image->getClientOriginalName();
                $request->featured_image->move(public_path('uploads'), $img);
            endif;
            $hotels->featured_image = $img;
            $hotels->save();
            if(isset($request->old_gallery_image_id)):
                foreach($request->old_gallery_image_id as $ogiiKey => $ogii):
                    $gld            = HotelGallery::where('id', '=', $ogii)->get()->first();
                    $gld->image_alt = $request->old_gallery_image_alt[$ogiiKey];
                    $gld->save();
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
                            $data               = array();
                            $data['hotel_id']   = $id;
                            $data['image']      = $gallery_image;
                            $data['image_alt']  = $request->gallery_image_alt[$i];
                            HotelGallery::create($data);
                        endif;
                    endfor;
                endif;
            endif;
            break;
        endswitch;
    }
}
