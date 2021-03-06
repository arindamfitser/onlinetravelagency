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
use App\FoodDrink;
use App\Review;
use App\Fisherman;
use App\HotelNewEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Session;
class SearchController extends Controller{
  public function __construct(){
      //$this->middleware('auth');
  }
  public function index(Request $request){   
    $filter = new Filter;
    if($request->keywords):
      $hotels=$filter->parce_kayword($request->keywords);
      if(!empty($hotels)):
        foreach ($hotels as $key => $hotel) {
              $hotel->address = HotelAddress::where('hotel_id', '=' , $hotel->id)->first();
              if($hotel->address==""){
                $hotel->address = HotelAddress::where('hotel_id', '=' , $hotel->hotel_id)->first();
              } 
              $hotel->galleries= HotelGallery::where('hotel_id', '=' , $hotel->id)->get();
              $hotel->price = Rooms::where('hotel_id', '=' , $hotel->id)->min('base_price');
              $hotel->review = Review::where('hotel_id', '=' , $hotel->id)->where('status', '=' , 1)->get();
              $hotel->features = KeyFeature::join('hotel_features_relations', 'key_features.id', '=', 'hotel_features_relations.features_id')
        ->where('hotel_features_relations.hotel_id', '=', $hotel->id)
        ->get();

          $hotel->fishing_data = Fisherman::where('hotel_id', '=' , $hotel->id)->first();
          if(empty($hotel->fishing_data)){
              $hotel->fishing_data = Fisherman::where('hotel_id', '=' , $hotel->hotel_id)->first();
          }
        }
        return view('frontend.hotels.search', compact('hotels', 'hotels'));
      else:
        return view('frontend.hotels.empty');
      endif;
    endif;
  }
  public function hotelDetails($slug){
    $hotel                      = Hotels::whereTranslation('hotels_slug', $slug)->first();
    $hotelNewEntry              = array();
    if($hotel):
      if($hotel->hotel_token != NULL || !empty($hotel->hotel_token)):
        $hotelNewEntry            = HotelNewEntry::where('hotel_token',  $hotel->hotel_token)->first();
      endif;
      $hotel->features          = KeyFeature::join('hotel_features_relations', 'key_features.id', '=', 'hotel_features_relations.features_id')
        ->where('hotel_features_relations.hotel_id', $hotel->id)
        ->get();
      $hotel->servicefacilities = ServiceFacility::join('service_facilities_translations', 'service_facilities.id', '=', 'service_facilities_translations.service_facilities_id')
        ->where('service_facilities_translations.hotel_id', $hotel->id)
        ->get();
      $hotel->roomfacilities    = RoomFacility::join('room_facilities_translations', 'room_facilities.id', '=', 'room_facilities_translations.room_facilities_id')
        ->where('room_facilities_translations.hotel_id', $hotel->id)
        ->get();
      $hotel->recreations       = Recreation::join('recreation_translations', 'recreations.id', '=', 'recreation_translations.recreation_id')
        ->where('recreation_translations.hotel_id', $hotel->id)
        ->get();
      $hotel->rooms             = Rooms::where('hotel_token',  $hotel->hotel_token)
        ->get();
      $hotel->food_drinks       = FoodDrink::where('hotel_id', $hotel->id)
        ->get();
      $hotel->galleries         = HotelGallery::where('hotel_id', $hotel->id)->get();
      $hotel->hotelcontact      = HotelContact::where('hotel_id', $hotel->id)->first();
      $hotel->hoteladdress      = HotelAddress::where('hotel_id', $hotel->id)->first();
      $hotel->hotelawards       = HotelAward::where('hotel_id', $hotel->id)->get();
      $hotel->hotelreview       = Review::where('hotel_id', $hotel->id)->where('status', 1)->orderBy('id', 'DESC')->get();
      $hotel->inspiration       = DB::table('inspirations_translations')
                                  ->select('inspirations_translations.inspirations_id','inspirations_translations.inspirations_name')
                                  ->join('hotel_inspirations_relations', 'hotel_inspirations_relations.inspirations_id', '=', 'inspirations_translations.inspirations_id')
                                  ->where('hotel_inspirations_relations.hotel_id', $hotel->id)->get();
      $hotel->experience        = DB::table('experiences_translations')
                                  ->select('experiences_translations.experiences_id','experiences_translations.experiences_name')
                                  ->join('hotel_experiences_relations', 'hotel_experiences_relations.experiences_id', '=', 'experiences_translations.experiences_id')
                                  ->where('hotel_experiences_relations.hotel_id', $hotel->id)->get();                       
      $hotel->accomodation      = DB::table('accommodations_translations')
                                  ->select('accommodations_translations.accommodations_name')
                                  ->join('hotel_accommodation_relations', 'hotel_accommodation_relations.accommodation_id', '=', 'accommodations_translations.accommodations_id')
                                  ->where('hotel_accommodation_relations.hotel_id', $hotel->id)->get();
      $hotel->images            = array();
      $hotel->hotelDesc         = array();
      $hotel->stubaDet          = array();
      $stuba                    = FALSE;
      if($hotel->stuba_id != NULL || !empty($hotel->stuba_id)):
        $hotel->images          = DB::table('hotel_images_xml')->select('*')->where('hotel_images_xml.hotel_id', $hotel->stuba_id)->get();
        $hotel->hotelDesc       = DB::table('hotel_description_xml')->where('hotel_id', $hotel->stuba_id)->get();
        $hotel->stubaDet        = DB::table('hotel_master_xml')->select('stars')->where('hotel_master_xml.id', $hotel->stuba_id)->first();
        $stuba                  = TRUE;
      endif;
    endif;
    return view('frontend.hotels.details', compact('hotel', 'stuba', 'hotelNewEntry'));
  }
  public function xmlhotelDetails(Request $request, $id){
    ini_set('memory_limit', '-1');
    $quantity_adults    = $request->quantity_adults;
    $quantity_childs    = $request->quantity_childs;
    $quantity_rooms     = $request->quantity_rooms;
    $hotelId            = $request->hotelId;
    $regionId           = $request->regionId;
    $keyword            = $request->keyword;
    $totalNight         = $request->totalNight;
    $t_end              = $request->t_end;
    $t_start            = $request->t_start;
    $pageNo             = $request->pageNo;
    $hotelid            = $id;
    $hotel              = DB::table('hotel_master_xml')->where('hotel_master_xml.id', $hotelid)->first();
    $hotelDesc          = DB::table('hotel_description_xml')->where('hotel_id', $hotelid)->get();
    $images             = DB::table('hotel_images_xml')->select('*')->where('hotel_images_xml.hotel_id', $hotelid)->get();
    $amenity            = DB::table('hotel_amenity_xml')->select('Text')->where('hotel_amenity_xml.hotel_id', $hotelid)->get();
    $address            = DB::table('hotel_address_xml')->select('*')->where('hotel_address_xml.hotel_id', $hotelid)->first();
    $hotelreview        = DB::table('reviews')->select('*')->where('hotel_id', $hotelid)->where('status', 1)->orderBy('id', 'DESC')->get();
    $dataArray          = array('hotels' => $hotel, 'images' => $images, 'amenity' => $amenity, 'hotelDesc' => $hotelDesc, 'address' => $address);
    return view('frontend.hotels.xmldetails', compact('dataArray', 'quantity_adults', 'quantity_childs', 'quantity_rooms', 'hotelId', 'regionId', 'keyword', 'totalNight', 't_end', 't_start', 'pageNo', 'hotelreview'));
  }
  public function byDestination(){
      $accommodation_search = DB::table('regions_translations')->select('*', 'hotels.id as hotel_id')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->groupBy('hotels.region_id')->get();
      $experience_search = DB::table('regions_translations')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->groupBy('hotels.region_id')->get();
      $inspiration_search = DB::table('regions_translations')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->groupBy('hotels.region_id')->get();
      $species_search = DB::table('regions_translations')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->groupBy('hotels.region_id')->get();
      return view('frontend.hotels.destinations', compact('accommodation_search', 'experience_search', 'inspiration_search', 'species_search'));
  }
  public function get_rg_type_data(Request $request){
    //print_r($request->all());
    $type = $request->type;
    $data_id = $request->data_id;
    session(['subReferenceType' => $type]);
    session(['SubReferenceId'   => $data_id]);
    switch ($type) {
        case 'accommodation':
          $search_data = DB::table('regions_translations')->select('*', 'hotels.id as hotel_id')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $data_id)->groupBy('hotels.region_id')->get();
        break;
      case 'experience':
          $search_data = DB::table('regions_translations')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->where('hotel_experiences_relations.experiences_id', '=', $data_id)->groupBy('hotels.region_id')->get();
        break;
      case 'inspiration':
          $search_data = DB::table('regions_translations')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $data_id)->groupBy('hotels.region_id')->get();
        break;
      case 'species':
          $search_data = DB::table('regions_translations')->join('hotels', 'regions_translations.regions_id', '=', 'hotels.region_id')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->where('hotel_species_relations.species_id', '=', $data_id)->groupBy('hotels.region_id')->get();
        break;
    }
    if(!empty($search_data)){
      return view('frontend.hotels.region', compact('search_data', 'type'));
    }else{
      return view('frontend.hotels.empty');
    }
  }
  public function soapCurl(Request $request){
    $filter = new Filter;
    $xml = $filter->AvailabilitySearchXML($request);
    $url = "http://api.stuba.com/RXLServices/ASMX/XmlService.asmx"; 
    //setting the curl parameters.
    $data=$filter->fatchRoomsxml($url,$xml);
    echo 'Results=' .count($data["HotelAvailability"]);
    foreach ($data["HotelAvailability"] as $key => $value) {
      $data=$filter->HotelDetailXML($value["Hotel"]["@attributes"]["id"]);
    }  
  }
  public function destinationsEnroute(Request $request){
    ini_set('memory_limit', '-1');
    $referer = $request->headers->get('referer');
    if($referer ==  url('/').'/' || $referer == url('/destinations') || $referer == url('/destinations/search') 
    || $referer == url('/accommodation-types') || $referer == url('/region/accommodation') || $referer == url('/experiences')
    || $referer == url('/region/experience') || $referer == url('/inspirations') || $referer == url('/region/inspiration')
    || $referer == url('/target-species') || $referer == url('/region/species')):
      if($referer ==  url('/').'/' || $referer == url('/destinations') || $referer == url('/destinations/search') || $referer == url('/accommodation-types') 
      || $referer == url('/experiences') || $referer == url('/inspirations') || $referer == url('/target-species')):
        session(['returnUrlFromList'    => $referer]);
        session(['returnUrlFromOnclick' => '']);
        session(['returnFormUrl'        => '']);
        session(['returnFormDataId'     => '']);
        session(['returnFormType'       => '']);
      else:
        session(['returnUrlFromList'    => "javascript:void(0);"]);
        session(['returnUrlFromOnclick' => "onReturnUrl()"]);
        session(['returnFormUrl'        => url('/region/').'/'.session('subReferenceType')]);
        session(['returnFormDataId'     => session('SubReferenceId')]);
        session(['returnFormType'       => session('subReferenceType')]);
      endif;
    endif;
    session(['ab'               => $request->ab]);    
    session(['rooms'            => $request->ab]);
    session(['num_room'         => $request->num_room]);
    session(['region_id'        => $request->region_id]);
    session(['keywords'         => $request->keywords]);
    session(['t_start'          => $request->t_start]);
    session(['t_end'            => $request->t_end]);
    session(['quantity_adults'  => $request->quantity_adults]);
    session(['quantity_child'   => $request->quantity_child]);
    session(['noguests'         => $request->noguests]);
    session(['fromFishing'      => $request->fromFishing]);
    session(['totalNight'       => '1']);
    $pageNo         = (isset($request->pageNo)) ? $request->pageNo : '1';
    $backHotelId    = (isset($request->backHotelId)) ? $request->backHotelId : '';
    return view('frontend.hotels.rxmlsearch', compact('pageNo', 'backHotelId'));
  }
  public function destinationsEnrouteFetchResult(Request $request){
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', '90000000000000');
      /*echo "<pre>";
    print_r(session()->all());
    die;*/
    $request['ab']              = session('ab');
    $request['rooms']           = session('rooms');
    $request['num_room']        = session('num_room');
    $request['region_id']       = session('region_id');
    $request['keywords']        = session('keywords');
    $request['t_start']         = session('t_start');
    $request['t_end']           = session('t_end');
    $request['quantity_adults'] = session('quantity_adults');
    $request['quantity_child']  = session('quantity_child');
    $request['noguests']        = session('noguests');
    $fromFishing                = session('fromFishing');
    ini_set('memory_limit', '-1');
    $html = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="holidaysection text-center" style="padding:25px">
                  <h2> Search result not found! please try another!!</h2>
                </div>
              </div>';
    $count = 0;
    $hotels   = array();
    $price    = array();
    $result   = array();
    $star     = array();
    $directHotels = array();
    if($fromFishing == 'yes'):
      $dirHotels      = Hotels::where('town', '=', $request->keywords)->orderBy('curator_rating', 'DESC')->get();
      if($dirHotels):
        foreach($dirHotels as $keyy => $directHotel):
          if($directHotel->hotel_token != NULL || !empty($directHotel->hotel_token)):
            $directHotels[$keyy]['hotelNewEntry']   = HotelNewEntry::where('hotel_token',  $directHotel->hotel_token)->first();
          else:
            $directHotels[$keyy]['hotelNewEntry']   = array();
          endif;
          $directHotels[$keyy]['hotelImagesId']     = (!empty($directHotel->stuba_id)) ? $directHotel->stuba_id : $directHotel->hotel_token;
          $hotelImagesId[]                          = (!empty($directHotel->stuba_id)) ? $directHotel->stuba_id : $directHotel->hotel_token;
          $directHotels[$keyy]['details']           = $directHotel;
          $directHotels[$keyy]['translation']       = DB::table('hotels_translations')->select('hotels_name', 'hotels_slug', 'hotels_desc')->where('hotels_id', $directHotel->id)->first();
          $directHotels[$keyy]['features']          = KeyFeature::join('hotel_features_relations', 'key_features.id', '=', 'hotel_features_relations.features_id')
                                                          ->where('hotel_features_relations.hotel_id', '=', $directHotel->id)
                                                          ->get();
          $directHotels[$keyy]['servicefacilities'] = ServiceFacility::join('service_facilities_translations', 'service_facilities.id', '=', 'service_facilities_translations.service_facilities_id')
                                                            ->where('service_facilities_translations.hotel_id', '=', $directHotel->id)
                                                            ->get();
          $directHotels[$keyy]['roomfacilities']    = RoomFacility::join('room_facilities_translations', 'room_facilities.id', '=', 'room_facilities_translations.room_facilities_id')
                                                          ->where('room_facilities_translations.hotel_id', '=', $directHotel->id)
                                                          ->get();
          $directHotels[$keyy]['recreations']       = Recreation::join('recreation_translations', 'recreations.id', '=', 'recreation_translations.recreation_id')
                                                          ->where('recreation_translations.hotel_id', '=', $directHotel->id)
                                                          ->get();
          $directHotels[$keyy]['rooms']             = Rooms::where('hotel_id', '=', $directHotel->id)
                                                          ->get();
          $directHotels[$keyy]['food_drinks']       = FoodDrink::where('hotel_id', '=', $directHotel->id)
                                                          ->get();
          $directHotels[$keyy]['galleries']         = HotelGallery::where('hotel_id', '=' , $directHotel->id)->get();
          $directHotels[$keyy]['hotelcontact']      = HotelContact::where('hotel_id', '=' , $directHotel->id)->first();
          $directHotels[$keyy]['hoteladdress']      = HotelAddress::where('hotel_id', '=' , $directHotel->id)->first();
          $directHotels[$keyy]['hotelawards']       = HotelAward::where('hotel_id', '=' , $directHotel->id)->get();
          $directHotels[$keyy]['hotelreview']       = Review::where('hotel_id', '=' , $directHotel->id)->where('status', '=' , 1)->get();
          if(!empty($directHotels[$keyy]['rooms'])) :
              $roomLowestPrice = 0;
              foreach($directHotels[$keyy]['rooms'] as $prc) :
                  if($roomLowestPrice == 0):
                      $roomLowestPrice = $prc->base_price;
                  else:
                      if($prc->base_price < $roomLowestPrice):
                          $roomLowestPrice = $prc->base_price;
                      endif;
                  endif;
              endforeach;
          endif;
          $price[] = (!empty($directHotels[$keyy]['rooms'])) ? $roomLowestPrice : '0.00';
          $average = 0;
          if(!empty($directHotels[$keyy]['hotelreview'])) :
              $numberOfReviews = 0;
              $totalStars = 0;
              foreach($directHotels[$keyy]['hotelreview'] as $review) :
                      $numberOfReviews++;
                      $totalStars += $review->rating;
              endforeach;
              if($numberOfReviews != 0):
              $average = $totalStars/$numberOfReviews;
              endif;
          endif;
          $average = round($average);
          $star[] = (string) $average;
          $count++;
        endforeach;
      endif;
      if(!empty($directHotels)):
          $temp = array();
          $directHotelsSort = array();
          foreach($directHotels as $k => $val):
            $temp[$k] = $val['details']->curator_rating;
          endforeach;
          arsort($temp);
          foreach($temp as $key => $p):
            $directHotelsSort[$key] = $directHotels[$key];
          endforeach;
          session(array(
            "totalHotelList"  => json_encode($directHotels),
            "results"         => json_encode(array()),
            "price"           => json_encode($price),
            "currency"        => "AUD",
          ));
          $html = view('frontend.hotels.ajaxHotel', compact('directHotels'))->render();
          print json_encode(array(
            "success"         => TRUE,
            "html"            => $html,
            "count"           => $count,
            "totalHotelList"  => json_encode($directHotels),
            "results"         => json_encode(array()),
            "price"           => json_encode($price),
            "currency"        => "AUD",
            "fromFishing"     => $fromFishing,
            "star"            => json_encode($star),
            "hotelImagesId"   => json_encode($hotelImagesId)
          ));
      endif;
      die;
    endif;
    $success            = FALSE;
    $currency           = 'AUD';
    $quantity_adults    = $request->quantity_adults;
    $quantity_childs    = $request->quantity_child;
    $quantity_rooms     = $request->quantity_rooms;
    $html               = '';
    $pageNo             = '';
    $postRegionId       = $request->region_id;
    if($request->keywords && $request->region_id != ''):
      $t_start    = $request->t_start;
      $t_end      = $request->t_end;
      $keyword    = $request->keywords;
      $totalNight = '1';
      $pageNo     = $request->pageNo;
      $take       = ($pageNo * 4);
      $checkAll   = DB::table('hotel_master_xml')
                      ->select('*')
                      ->where('hotel_master_xml.city_id', $postRegionId)
                      ->orWhere('hotel_master_xml.region_id', $postRegionId)
                      ->orderBy('stars', 'DESC')->get();
      if(!$checkAll->isEmpty()):
          $success      = TRUE;
            foreach($checkAll as $key => $val):
                if($key < $take):
                    $hotel              = $val;
                    $hotelDesc          = DB::table('hotel_description_xml')->where('hotel_id', $val->id)->first();
                    //$images           = DB::table('hotel_images_xml')->select('hotel_image_id', 'Url')->where('hotel_images_xml.hotel_id', $val->id)->orderBy('hotel_image_id','ASC')->skip(0)->take(1)->get();
                    $amenity            = DB::table('hotel_amenity_xml')->select('Text')->where('hotel_amenity_xml.hotel_id', $val->id)->orderBy('aminity_id','ASC')->skip(0)->take(5)->get();
                    $address            = DB::table('hotel_address_xml')->select('*')->where('hotel_address_xml.hotel_id', $val->id)->first();
                    $hotelImagesId[]    = $val->id;
                    $hotels[]           = array('hotels' => $hotel, 'amenity' => $amenity, 'address' => $address, 'hotelDesc' => $hotelDesc);
                else:
                    break;
                endif;
            endforeach;
            $html           = view('frontend.hotels.ajaxNewHotel', compact('hotels', 'currency', 'result', 'price', 'quantity_adults', 'quantity_childs', 'quantity_rooms', 't_start', 't_end', 'totalNight', 'keyword', 'pageNo'))->render();
      endif;
      $count              = count($checkAll);
    endif;
    print json_encode(array(
      "success"         => $success,
      "html"            => $html,
      "count"           => $count,
      "fromFishing"     => $fromFishing,
      "pageNo"          => $pageNo,
      "postRegionId"    => $postRegionId,
      "hotelImagesId"   => json_encode($hotelImagesId)
    ));
  }
  public function destinationsEnrouteFetchResultLoadMore(Request $request){
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '90000000000000');
      $success            = FALSE;
      $currency           = 'AUD';
      $quantity_rooms     = 1;
      $hotels             = array();
      $price              = array();
      $result             = array();
      $check              = array();
      $html               = '';
      $skip               = 0;
      $pageNo             = $request->pageNo;
      $postRegionId       = $request->postRegionId;
      $quantity_adults    = session('quantity_adults');
      $quantity_childs    = session('quantity_child');
      $t_start            = session('t_start');
      $t_end              = session('t_end');
      $keyword            = session('keywords');
      $totalNight         = session('totalNight');
      if(!empty($pageNo)):
          $skip           = ($pageNo * 4);
          $check          = DB::table('hotel_master_xml')->select('*')->where('hotel_master_xml.city_id', $postRegionId)->orWhere('hotel_master_xml.region_id', $postRegionId)->orderBy('stars', 'DESC')->skip($skip)->take(4)->get();
      endif;
      if(!$check->isEmpty()):
          $pageNo         += 1;
          $success        = TRUE;
          foreach($check as $key => $val):
              $hotel              = $val;
              $hotelDesc          = DB::table('hotel_description_xml')->where('hotel_id', $val->id)->first();
              $amenity            = DB::table('hotel_amenity_xml')->select('Text')->where('hotel_amenity_xml.hotel_id', $val->id)->orderBy('aminity_id','ASC')->skip(0)->take(5)->get();
              $address            = DB::table('hotel_address_xml')->select('*')->where('hotel_address_xml.hotel_id', $val->id)->first();
              $hotelImagesId[]    = $val->id;
              $hotels[]           = array('hotels' => $hotel, 'amenity' => $amenity, 'address' => $address, 'hotelDesc' => $hotelDesc);
          endforeach;
          $html           = view('frontend.hotels.ajaxNewHotel', compact('hotels', 'currency', 'result', 'price', 'quantity_adults', 'quantity_childs', 'quantity_rooms', 't_start', 't_end', 'totalNight', 'keyword', 'pageNo'))->render();
      else:
          $pageNo         = '';
      endif;
      print json_encode(array(
          "success"         => $success,
          "html"            => $html,
          "pageNo"          => $pageNo,
          "hotelImagesId"   => json_encode($hotelImagesId)
      ));
  }
}
