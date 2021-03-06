<?php
namespace App\Http\Controllers\Ajax;
use App\Filter;
use App\Countries;
use App\Regions;
use App\States;
use App\Hotels;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\RoomAvailability;
use App\Cart;
use App\User;
use App\StatesTranslation;
use App\HotelNewEntry;
use App\RoomCount;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
//use Session;
class AjaxController extends Controller{
  public function __construct(){
      //$this->middleware('auth');
  }
  public function addWishlist(Request $request){
      $id= DB::table('wishlist')->insert(
        ['hotel_id' => $request['hotel_id'], 'user_id' => $request['user_id']]
      );
      if($id){
          echo 'success';
      }else{
          echo 'error';
      }
  }
  public function getWihlistbyUser(Request $request){
      $user = DB::table('wishlist')->where('user_id', $request['user_id'])->get();
      echo  json_encode($user);
  }
  public function checkUserEmail(Request $request){
      $user = User::all()->where('email', $request['email'])->first();
      $U = auth('web')->user();  
      if ($U){
          return \Response::json(array('msg' => $request['email'].' email is available','status'=>'false'));
      }else if($user) {
          //return \Response::json(array('msg' => $request['email'].' is already taken','status'=>'true'));
          return \Response::json(array('msg' => $request['email'].' is already taken','status'=>'false'));
      }else{
          return \Response::json(array('msg' => $request['email'].' email is available','status'=>'false'));
      }
  }
  public function doSendcontact(Request $request){
      $e_data = [
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'contact' => $request->contact,
          'subject' => $request->subject,
          'body' => $request->message,
      ];
      Mail::send('emails.contact', ['e_data' => $e_data], function ($m) use ($e_data) {
          $m->from('no-reply@fitser.com', get_option('blogname'));
          $m->to(_get_option('email'), $e_data['first_name'].' '.$e_data['last_name'])->subject('New Contact mail :gupta hotel');
      });
      echo json_encode(array('status' => 1));
  }
  public function get_state(Request $request){
      $country_id = $request->country_id;
      $states = StatesTranslation::where('countries_id', $country_id)->get();
      $html = '';
      foreach ($states as $key => $state) {
          $html .= '<option value="'.$state->states_id.'">'.$state->states_name.'</option>';
      }
      echo $html;
  }
  public function getmap(Request $request){
      $id = $request->id;
      $tpid = $request->tpid;
      $list = array();
      switch ($request->type) {
          case 'accommodation':
              switch ($request->condition) {
                  case 'region':
                      $data = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $tpid)->where('hotels.region_id', '=', $id)->groupBy('hotels.id')->get();
                      foreach($data as $hs){
                        $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                      }
                      echo json_encode($list);
                      break;
                  case 'country':
                      $data = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $tpid)->where('hotels.country_id', '=', $id)->groupBy('hotels.id')->get();
                      foreach($data as $hs){
                        $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                      }
                      echo json_encode($list);
                      break;
                  case 'state':
                      $data = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $tpid)->where('hotels.state_id', '=', $id)->groupBy('hotels.id')->get();
                      foreach($data as $hs){
                        $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                      }
                      echo json_encode($list);
                      break;
                  case 'town':
                      $data = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $tpid)->where('hotels.town', '=', $id)->groupBy('hotels.id')->get();
                      foreach($data as $hs){
                        $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                      }
                      echo json_encode($list);
                      break;
                  }
          break;
        case 'experience':
          switch ($request->condition) {
            case 'region':
              $data = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_experiences_relations.experiences_id', '=', $tpid)->where('hotels.region_id', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'country':
              $data = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_experiences_relations.experiences_id', '=', $tpid)->where('hotels.country_id', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'state':
              $data = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_experiences_relations.experiences_id', '=', $tpid)->where('hotels.state_id', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'town':
              $data = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_experiences_relations.experiences_id', '=', $tpid)->where('hotels.town', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
          }
          break;
        case 'inspiration':
          switch ($request->condition) {
            case 'region':
              $data = DB::table('hotels')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $tpid)->where('hotels.region_id', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'country':
              $data = DB::table('hotels')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $tpid)->where('hotels.country_id', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'state':
              $data = DB::table('hotels')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $tpid)->where('hotels.state_id', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'town':
              $data = DB::table('hotels')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $tpid)->where('hotels.town', '=', $id)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
          }
          break;
        case 'species':
          switch ($request->condition) {
            case 'region':
              $data = DB::table('hotels')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->where('hotel_species_relations.species_id', '=', $tpid)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'country':
              $data = DB::table('hotels')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.country_id', '=', $id)->where('hotel_species_relations.species_id', '=', $tpid)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'state':
              $data = DB::table('hotels')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.state_id', '=', $id)->where('hotel_species_relations.species_id', '=', $tpid)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
            case 'town':
              $data = DB::table('hotels')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.town', '=', $id)->where('hotel_species_relations.species_id', '=', $tpid)->groupBy('hotels.id')->get();
              foreach($data as $hs){
                $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
              }
              echo json_encode($list);
              break;
          }
          break;
      }
  }
  public function get_region_data(Request $request){
      $id = $request->id;
      switch ($request->cat) {
          case 'accommodation':
              switch($request->col_type){
                  case 'region':
                      $country = getAccommodationCountry($id);
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')
                                  ->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')
                                  ->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')
                                  ->where('hotels.country_id', '=', $id)
                                  ->orderBy('states_translations.states_name', 'ASC')
                                  ->groupBy('hotels.state_id')
                                  ->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        //$html .= '<li onClick="getMap(\'' . $t->town . '\',\'town\',\'' . $request->cat . '\',this)">'.$t->town.'</li>';
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
                  case 'town':
                      $hotels = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.town', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.id')->get();
                      $html = '';
                      foreach($hotels as $h){
                        $html .= '<li><a href="'.route('hotel.details', ['slug' => $h->hotels_slug]).'">'.$h->hotels_name.'</a></li>';
                      }
                      echo $html;
                      break;
              }
              break;
          case 'experience':
              switch($request->col_type){
                  case 'region':
                      $country = getExperienceCountry($id);
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->where('hotels.country_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
                  case 'town':
                      $hotels = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.town', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.id')->get();
                      $html = '';
                      foreach($hotels as $h){
                        $html .= '<li><a href="'.route('hotel.details', ['slug' => $h->hotels_slug]).'">'.$h->hotels_name.'</a></li>';
                      }
                      echo $html;
                      break;
                  }
              break;
          case 'inspiration':
              switch($request->col_type){
                  case 'region':
                      $country = getExperienceCountry($id);
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->where('hotels.country_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
                  case 'town':
                      $hotels = DB::table('hotels')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.town', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.id')->get();
                      $html = '';
                      foreach($hotels as $h){
                        $html .= '<li><a href="'.route('hotel.details', ['slug' => $h->hotels_slug]).'">'.$h->hotels_name.'</a></li>';
                      }
                      echo $html;
                      break;
              }
            break;
          case 'species':
              switch($request->col_type){
                  case 'region':
                      $country = getExperienceCountry($id);
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->where('hotels.country_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
                  case 'town':
                      $hotels = DB::table('hotels')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.town', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.id')->get();
                      $html = '';
                      foreach($hotels as $h){
                        $html .= '<li><a href="'.route('hotel.details', ['slug' => $h->hotels_slug]).'">'.$h->hotels_name.'</a></li>';
                      }
                      echo $html;
                      break;
              }
              break;
      }
  }
  public function get_region_type_data(Request $request){
      $id = $request->id;
      $data_id = $request->data_id;
      switch ($request->cat) {
          case 'accommodation':
              switch($request->col_type){
                  case 'region':
                      $country = DB::table('countries_translations')->join('hotels', 'countries_translations.countries_id', '=', 'hotels.country_id')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $data_id)->where('hotels.region_id', '=', $id)->groupBy('hotels.country_id')->get();
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $data_id)->where('hotels.country_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.'<span class="float-right" onclick="searchByKeyword(\'' . $s->states_name . '\')">ALL</span></li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_accommodation_relations.accommodation_id', '=', $data_id)->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
              }
              break;
          case 'experience':
              switch($request->col_type){
                  case 'region':
                      $country = getExperienceCountry($id);
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->where('hotel_experiences_relations.experiences_id', '=', $data_id)->where('hotels.country_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.' <span class="float-right" onclick="searchByKeyword(\'' . $s->states_name . '\')">ALL</span></li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_experiences_relations.experiences_id', '=', $data_id)->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
                  case 'town':
                      $hotels = DB::table('hotels')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.town', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.id')->get();
                      $html = '';
                      foreach($hotels as $h){
                        $html .= '<li><a href="'.route('hotel.details', ['slug' => $h->hotels_slug]).'">'.$h->hotels_name.'</a></li>';
                      }
                      echo $html;
                      break;
              }
              break;
          case 'inspiration':
              switch($request->col_type){
                  case 'region':
                      $country = DB::table('countries_translations')->join('hotels', 'countries_translations.countries_id', '=', 'hotels.country_id')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $data_id)->where('hotels.region_id', '=', $id)->groupBy('hotels.country_id')->get();
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $data_id)->where('hotels.country_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.' <span class="float-right" onclick="searchByKeyword(\'' . $s->states_name . '\')">ALL</span></li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotel_inspirations_relations.inspirations_id', '=', $data_id)->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
              }
              break;
          case 'species':
              switch($request->col_type){
                  case 'region':
                      $country = DB::table('countries_translations')->join('hotels', 'countries_translations.countries_id', '=', 'hotels.country_id')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->where('hotel_species_relations.species_id', '=', $data_id)->where('hotels.region_id', '=', $id)->groupBy('hotels.country_id')->get();
                      $html = '';
                      foreach($country as $c){
                        $html .= '<li onClick="getMap(\'' . $c->countries_id . '\',\'country\',\'' . $request->cat . '\',this)">'.$c->countries_name.'</li>';
                      }
                      echo $html;
                      break;
                  case 'country':
                      $states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->where('hotel_species_relations.species_id', '=', $data_id)->where('hotels.country_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get();
                      $html = '';
                      foreach($states as $s){
                        $html .= '<li onClick="getMap(\'' . $s->states_id . '\',\'state\',\'' . $request->cat . '\',this)">'.$s->states_name.'<span class="float-right" onclick="searchByKeyword(\'' . $s->states_name . '\')">ALL</span></li>';
                      }
                      echo $html;
                      break;
                  case 'state':
                      $towns = DB::table('hotels')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->where('hotel_species_relations.species_id', '=', $data_id)->where('hotels.state_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.town')->get();
                      $html = '';
                      foreach($towns as $t){
                        $html .= '<li  onclick="searchByKeyword(\'' . $t->town . '\')">'.$t->town.'</li>';
                      }
                      echo $html;
                      break;
              }
              break;
      }
  }
  public function suggestRegion(Request $request){
      //$region = DB::table('roomxml_region')->Where('name', 'like', '%' .$request->region. '%')->orWhere('country_name', 'like', '%' .$request->region. '%')->get()->toArray();
      $region = DB::table('hotel_region_xml')
              ->select('country as country_name', 'region_id', 'searchable_region as name')
              ->Where('country', 'like', '%' .$request->region. '%')
              ->orWhere('region', 'like', '%' .$request->region. '%')
              ->orWhere('sub_region', 'like', '%' .$request->region. '%')
              ->get()->toArray();
      //echo "<pre>"; print_r($region); die;
      echo $regions= json_encode($region);
      exit;
  }
  public function hotelSortOrder(Request $request){
    ini_set('memory_limit', '-1');
    // echo "<pre>";
    // print_r($request);
    // die;
    // $hotelList        = json_decode(stripslashes($request->totalHotelList));
    // $quantity_adults  = $request->quantity_adults;
    // $quantity_childs  = $request->quantity_childs;
    // $quantity_rooms   = $request->quantity_rooms;
    // $result           = json_decode(stripslashes($request->results));
    // $price            = json_decode(stripslashes($request->price));
    // $currency         = $request->currency;
    $starZero = $starOne =$starTwo = $starThree = $starFour = $starFive = $finalArray = array();
    $sortType = explode(':', $request->sortingOrder);
    $html = '';
    if($request->searchFishing == 'no'){
      $hotelList        = json_decode(session('totalHotelList'), true);
      $quantity_adults  = session('quantity_adults');
      $quantity_childs  = session('quantity_child');
      $quantity_rooms   = session('num_room');
      $result           = json_decode(session('results'), true);
      $price            = json_decode(session('price'), true);
      $currency         = session('currency');
      if($sortType[0] == 'Star'){
        if(!empty($hotelList)){
          foreach($hotelList as $key => $hotel){
            $star = '0';
            if(isset($hotel->hotels->stars)){
              $star = $hotel->hotels->stars;
            }
            switch($star){
              case "1":
                $starOne[] = $hotel;
                break;
              case "2":
                $starTwo[] = $hotel;
                break;
              case "3":
                $starThree[] = $hotel;
                break;
              case "4":
                $starFour[] = $hotel;
                break;
              case "5":
                $starFive[] = $hotel;
                break;
              default:
                $starZero[] = $hotel;
                break;
            }
          }
        }
        switch($sortType[1]){
          case "High to Low":
            $finalArray = array_merge($finalArray, $starFive);
            $finalArray = array_merge($finalArray, $starFour);
            $finalArray = array_merge($finalArray, $starThree);
            $finalArray = array_merge($finalArray, $starTwo);
            $finalArray = array_merge($finalArray, $starOne);
            $finalArray = array_merge($finalArray, $starZero);
            break;
          case "Low to High":
            $finalArray = array_merge($finalArray, $starZero);
            $finalArray = array_merge($finalArray, $starOne);
            $finalArray = array_merge($finalArray, $starTwo);
            $finalArray = array_merge($finalArray, $starThree);
            $finalArray = array_merge($finalArray, $starFour);
            $finalArray = array_merge($finalArray, $starFive);
            break;
          default:
            $finalArray = $hotelList;
            break;
        }
      }elseif($sortType[0] == 'Price'){
        switch($sortType[1]){
          case "High to Low":
            arsort($price);
            break;
          case "Low to High":
            asort($price);
            break;
          default:
          arsort($price);
            break;
        }
        if(!empty($hotelList)){
          foreach($price as $key => $p){
            if(!empty($hotelList)){
              $finalArray[$key] = $hotelList[$key];
            }
          }
        }
      }else{
        $finalArray = $hotelList;
      }
      $html = view('frontend.hotels.ajaxHotel', compact('finalArray', 'currency', 'result', 'price', 'quantity_adults', 'quantity_childs', 'quantity_rooms'))->render();
    }else if($request->searchFishing == 'yes'){
      $hotelList        = json_decode($request->totalHotelList);
      $price            = json_decode($request->searchPrice);
      $star             = json_decode($request->searchStar);
      if($sortType[0] == 'Star'){
        $directHotelsSort = $hotelList;
        switch($sortType[1]){
          case "High to Low":
            arsort($star);
            break;
          case "Low to High":
            asort($star);
            break;
          default:
            arsort($star);
            break;
        }
        if(!empty($star)){
          foreach($star as $key => $p){
            if(!empty($hotelList)){
              $directHotelsSort[$key] = $hotelList[$key];
            }
          }
        }
      }elseif($sortType[0] == 'Price'){
        switch($sortType[1]){
          case "High to Low":
            arsort($price);
            break;
          case "Low to High":
            asort($price);
            break;
          default:
          arsort($price);
            break;
        }
        if(!empty($price)){
          foreach($price as $key => $p){
            if(!empty($hotelList)){
              $directHotelsSort[$key] = $hotelList[$key];
            }
          }
        }
      }else{
        $directHotelsSort = $hotelList;
      }
      $html = view('frontend.hotels.ajaxHotel', compact('directHotelsSort'))->render();
    }
    print json_encode(array("success" => TRUE, 'html' => $html));
  }
  public function destinationFetchRoom(Request $request){
    ini_set('memory_limit', '-1');
    $ab           = array();
    $totalAdults  = 0;
    $totalKids    = 0;
    $totalRoom    = 0;
    $html = '<div class="roombox">
              <div class="row clearfix text-center">
                <h2>Not available for your selected dates!  Please try other dates !!</h2>
                <a href="javascript:void(0);" class="hotelDetailsBack">
                  <h3>or return to your last Search !!</h3>
                </a> 
              </div>
            </div>';
    if($request->roomHotelToken == NULL || empty($request->roomHotelToken)):
      foreach($request->norm as $keyyy => $val):
        $ab['norm'][]   = $val;
        $ab['adlts'][]  = $request->adlts[$keyyy];
        $ab['kids'][]   = $request->kids[$keyyy];
        $totalAdults    += $request->adlts[$keyyy];
        $totalKids      += $request->kids[$keyyy];
        $totalRoom++;
      endforeach;
      Session::put('t_start', $request->roomSearchFromDate);
      Session::put('t_end', $request->roomSearchToDate);
      Session::put('keywords', $request->roomSearchKeyword);
      Session::put('quantity_adults', $totalAdults);
      Session::put('quantity_child', $totalKids);
      Session::put('ab', $ab);
      Session::put('rooms', $ab);
      Session::put('num_room', $totalRoom);
      Session::put('quantityRooms', $totalRoom);
      Session::put('noguests', ($totalAdults + $totalKids));
      Session::save();
      //$region = DB::table('roomxml_region')->Where('name', 'like', $request->roomSearchKeyword. '%')->get()->toArray();
      $region = DB::table('hotel_region_xml')
              ->select('country as country_name', 'region_id', 'searchable_region as name')
              ->Where('country', 'like', '%' .$request->roomSearchKeyword. '%')
              ->orWhere('region', 'like', '%' .$request->roomSearchKeyword. '%')
              ->orWhere('sub_region', 'like', '%' .$request->roomSearchKeyword. '%')
              ->get()->toArray();
      if(!empty($region)):
        //session(['region_id' => $region[0]->region_id]);
        Session::put('region_id', $region[0]->region_id);
        $diff = date_diff(date_create($request->roomSearchFromDate), date_create($request->roomSearchToDate));
        $diff = $diff->format("%a");
        //session(['totalNight' => $diff]);
        Session::put('totalNight', $diff);
        // echo "<pre>";
        // print_r(session()->all()); die;
        $request['ab']              = Session::get('ab');
        $request['rooms']           = Session::get('rooms');
        $request['num_room']        = Session::get('num_room');
        $request['region_id']       = Session::get('region_id');
        $request['keywords']        = Session::get('keywords');
        $request['t_start']         = Session::get('t_start');
        $request['t_end']           = Session::get('t_end');
        $request['quantity_adults'] = Session::get('quantity_adults');
        $request['quantity_child']  = Session::get('quantity_child');
        $request['noguests']        = Session::get('noguests');
        $filter                     = new Filter;
        $xml                        = $filter->AvailabilitySearchXML($request);
        $url                        = "http://api.stuba.com/RXLServices/ASMX/XmlService.asmx";

        

        $data                       = $filter->fatchRoomsxml($url,$xml);
        $currency                   = 'AUD';
        $hotelForRoom               = array();
        $price                      = array();
        $result                     = array();
        $finalSearchHotel           = array();





        //pr($data);
        if($data["HotelAvailability"]):
          for ($i = 0; $i < count($data["HotelAvailability"]); $i++) :
            @$hotel_name = $data["HotelAvailability"][$i]["Hotel"]["@attributes"]["id"];
            if($hotel_name == $request->roomStubaId):
              $finalSearchHotel = $data["HotelAvailability"][$i];
              break;
            endif;
          endfor;
        endif;
        if(!empty($finalSearchHotel)):
          $html = view('frontend.hotels.ajaxHotel', compact('finalSearchHotel'))->render();
        endif;
      endif;
    else:
      $cIn          = $request->roomSearchFromDate;
      $cOut         = $request->roomSearchToDate;
      $diff         = date_diff(date_create($cIn), date_create($cOut));
      $nights       = $diff->format("%a");
      $maxAdult     = '';
      $maxChild     = '';
      foreach($request->norm as $keyyy => $val):
        $ab['norm'][]   = $val;
        $ab['adlts'][]  = $request->adlts[$keyyy];
        $ab['kids'][]   = $request->kids[$keyyy];
        $totalAdults    += $request->adlts[$keyyy];
        $totalKids      += $request->kids[$keyyy];
        if(empty($maxAdult)):
          $maxAdult     = $request->adlts[$keyyy];
        else:
          if($maxAdult < $request->adlts[$keyyy]):
            $maxAdult   = $request->adlts[$keyyy];
          endif;
        endif;
        if(empty($maxChild)):
          $maxChild     = $request->kids[$keyyy];
        else:
          if($maxChild < $request->kids[$keyyy]):
            $maxChild   = $request->kids[$keyyy];
          endif;
        endif;
        $totalRoom++;
      endforeach;
      $rooms  = Rooms::where('availability', 1)->where('hotel_token', $request->roomHotelToken)
                ->where('adult_capacity', '>=', $maxAdult)
                ->where('child_capacity', '>=', $maxChild)->get();
      $finalSearchRooms           = array();
      if(!empty($rooms)):
        $bookingArray = array(
          'startDate'       => $cIn,
          'endDate'         => $cOut,
          'quantityAdults'  => $totalAdults,
          'quantityChild'   => $totalKids,
          'rooms'           => $ab,
          'quantityRooms'   => $totalRoom,
          'noguests'        => ($totalAdults + $totalKids),
          'totalNight'      => $nights,
          'hotelToken'      => $request->roomHotelToken
        );
        foreach($rooms as $r):
          $max = '';
          for($d = 0; $d < $nights; $d++):
            $strt   = date('Y-m-d', strtotime($cIn. ' + '. $d .' days'));
            $end    = date('Y-m-d', strtotime($cIn. ' + '. ($d+1) .' days'));
            $chk    = DB::table('booking_items')->select('id', 'quantity_room')->where('room_id', $r->id)->where('status', 1)
                      ->where('check_in', '>=', $strt)->where('check_out', '<=', $end)->get();
            $rc     = RoomCount::where('room_id', $r->id)->where('dt', $strt)->first();
            $avlbl  = (!empty($rc)) ? $rc->count : $r->room_capacity;
            if(!empty($chk)):
              $booked = 0;
              foreach($chk as $c):
                $booked += $c->quantity_room;
              endforeach;
              $avlbl -= $booked;
              if(!empty($max)):
                if($max > $avlbl):
                  $max = $avlbl;
                endif;
              else:
                $max = $avlbl;
              endif;
            else:
              $max = $avlbl;
              break;
            endif;
          endfor;
          if(!empty($max) && $max != '0'):
            if($max >= $totalRoom):
              array_push($finalSearchRooms, $r);
            endif;
          endif;
        endforeach;
      endif;
      if(!empty($finalSearchRooms)):
        $html = view('frontend.hotels.ajaxHotel', compact('finalSearchRooms', 'bookingArray'))->render();
      endif;
    endif;
    print json_encode(array(
      "html" => $html
    ));
    die;
  }
  public function stubaFetchRoom(Request $request){
    ini_set('memory_limit', '-1');
    $ab           = array();
    $totalAdults  = 0;
    $totalKids    = 0;
    $totalRoom    = 0;
    foreach($request->norm as $keyyy => $val):
      $ab['norm'][]   = $val;
      $ab['adlts'][]  = $request->adlts[$keyyy];
      $ab['kids'][]   = $request->kids[$keyyy];
      $totalAdults    += $request->adlts[$keyyy];
      $totalKids      += $request->kids[$keyyy];
      $totalRoom++;
    endforeach;
    Session::put('t_start', $request->roomSearchFromDate);
    Session::put('t_end', $request->roomSearchToDate);
    Session::put('keywords', $request->roomSearchKeyword);
    Session::put('quantity_adults', $totalAdults);
    Session::put('quantity_child', $totalKids);
    Session::put('ab', $ab);
    Session::put('rooms', $ab);
    Session::put('num_room', $totalRoom);
    Session::put('quantityRooms', $totalRoom);
    Session::put('noguests', ($totalAdults + $totalKids));
    Session::save();
    Session::put('region_id', $request->region_id);
    $diff                       = date_diff(date_create($request->roomSearchFromDate), date_create($request->roomSearchToDate));
    $diff                       = $diff->format("%a");
    Session::put('totalNight', $diff);
    $request['ab']              = Session::get('ab');
    $request['rooms']           = Session::get('rooms');
    $request['num_room']        = Session::get('num_room');
    $request['region_id']       = Session::get('region_id');
    $request['keywords']        = Session::get('keywords');
    $request['t_start']         = Session::get('t_start');
    $request['t_end']           = Session::get('t_end');
    $request['quantity_adults'] = Session::get('quantity_adults');
    $request['quantity_child']  = Session::get('quantity_child');
    $request['noguests']        = Session::get('noguests');
    $filter                     = new Filter;
    $xml                        = $filter->AvailabilitySearchXML($request);
    $url                        = "http://api.stuba.com/RXLServices/ASMX/XmlService.asmx";
    $data                       = $filter->fatchRoomsxml($url,$xml);
    $currency                   = 'AUD';
    $hotelForRoom               = array();
    $price                      = array();
    $result                     = array();
    $finalSearchHotel           = array();
    //echo "<pre>"; print_r($data["HotelAvailability"]); die;
    if($data["HotelAvailability"]):
        if(isset($data["HotelAvailability"][0])):
            for ($i = 0; $i < count($data["HotelAvailability"]); $i++) :
              if($data["HotelAvailability"][$i]["Hotel"]["@attributes"]["id"] == $request->hotelId):
                $finalSearchHotel = $data["HotelAvailability"][$i];
                break;
              endif;
            endfor;
        else:
            if($data["HotelAvailability"]["Hotel"]["@attributes"]["name"] == $request->roomSearchHotel):
                $finalSearchHotel = $data["HotelAvailability"];
             endif;
        endif;
    endif;
    /*$quantity_adults  = $request['quantity_adults'];
    $quantity_child   = $request['quantity_child'];
    $num_room         = $request['num_room'];*/
    if(!empty($finalSearchHotel)):
        //$html = view('frontend.hotels.ajaxNewRoom', compact('finalSearchHotel', 'quantity_adults', 'quantity_child', 'num_room'))->render();
        $html = view('frontend.hotels.ajaxHotel', compact('finalSearchHotel'))->render();
    else:
        $html = '<div class="roombox">
              <div class="row clearfix text-center">
                <h2>Not available for your selected dates!  Please try other dates !!</h2>
                <a href="javascript:void(0);" class="hotelDetailsBack">
                  <h3>or return to your last Search !!</h3>
                </a> 
              </div>
            </div>';
    endif;
    print json_encode(array(
      "html" => $html
    ));
    die;
  }
  public function stubaFetchRoomBackUp(Request $request){
    ini_set('memory_limit', '-1');
    $ab           = array();
    $totalAdults  = 0;
    $totalKids    = 0;
    $totalRoom    = 0;
    foreach($request->norm as $keyyy => $val):
      $ab['norm'][]   = $val;
      $ab['adlts'][]  = $request->adlts[$keyyy];
      $ab['kids'][]   = $request->kids[$keyyy];
      $totalAdults    += $request->adlts[$keyyy];
      $totalKids      += $request->kids[$keyyy];
      $totalRoom++;
    endforeach;
    $html = '
            <div class="container-fluid2 xmlroom clearfix">
              <h1>Rooms</h1>
              <div class="roombox">
                <div class="row clearfix text-center">
                  <h2>Not available for your selected dates!  Please try other dates !!</h2>
                  <a href="javascript:void(0);" class="hotelDetailsBack">
                    <h3>or return to your last Search !!</h3>
                  </a> 
                </div>
              </div>
            </div>';
      $request['ab']              = $ab;
      $request['rooms']           = $ab;
      $request['num_room']        = $totalRoom;
      $request['noguests']        = ($totalAdults + $totalKids);
      // $request['t_start']         = Session::get('t_start');
      // $request['t_end']           = Session::get('t_end');
      // $request['keywords']        = Session::get('keywords');
      // $request['region_id']       = Session::get('region_id');
      // $request['quantity_adults'] = Session::get('quantity_adults');
      // $request['quantity_child']  = Session::get('quantity_child');
      $filter                     = new Filter;
      $xml                        = $filter->AvailabilitySearchXML($request);
      $url                        = "http://api.stuba.com/RXLServices/ASMX/XmlService.asmx";
      $data                       = $filter->fatchRoomsxml($url,$xml);
      $currency                   = 'AUD';
      $hotelForRoom               = array();
      $price                      = array();
      $result                     = array();
      $finalSearchHotel         = array();
      if($data["HotelAvailability"]):
        /*echo "<pre>"; print_r($data["HotelAvailability"]); die;*/
        if(isset($data["HotelAvailability"][0])):
            for ($i = 0; $i < count($data["HotelAvailability"]); $i++) :
              if($data["HotelAvailability"][$i]["Hotel"]["@attributes"]["id"] == $request['hotelId']):
                $finalSearchHotel = $data["HotelAvailability"][$i];
                break;
              endif;
            endfor;
        else:
            if($data["HotelAvailability"]["Hotel"]["@attributes"]["id"] == $request['hotelId']):
                $finalSearchHotel = $data["HotelAvailability"];
             endif;
        endif;
      endif;
      /*echo "<pre>"; print_r($finalSearchHotel); die;*/
      $quantity_adults  = $request['quantity_adults'];
      $quantity_child   = $request['quantity_child'];
      $num_room         = $totalRoom;
      //$totalNight       = $request->totalNight;
      if(!empty($finalSearchHotel)):
        $html = view('frontend.hotels.ajaxNewRoom', compact('finalSearchHotel', 'quantity_adults', 'quantity_child', 'num_room'))->render();
      endif;
    print json_encode(array(
      "html" => $html
    ));
    die;
  }
  public function searchImageCarousel(Request $request){
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', '90000000000000');
    $imageId    = $request->imageId;
    $hotelId    = $request->hotelId;
    $op         = ($request->action == 'prev') ? '<' : '>';
    $order      = ($request->action == 'prev') ? 'DESC' : 'ASC';
    if($request->stuba == 'yes'):
      $images     = DB::table('hotel_images_xml')
                      ->select('hotel_image_id', 'Url')
                      ->where('hotel_images_xml.hotel_id', $hotelId)
                      ->where('hotel_images_xml.hotel_image_id', $op, $imageId)
                      ->orderBy('hotel_image_id', $order)
                      ->first();
      if(empty($images)):
        $images = DB::table('hotel_images_xml')
                    ->select('hotel_image_id', 'Url')
                    ->where('hotel_images_xml.hotel_id', $hotelId)
                    ->orderBy('hotel_image_id','ASC')
                    ->first(); 
      endif;
      $return = array(
          'id'    => $images->hotel_image_id,
          'url'   => 'https://www.stuba.com' . $images->Url
      );
    elseif($request->stuba == 'no'):
      $det    = DB::table('hotels')->select('id')->where('hotel_token', $hotelId)->get()->first();
      $image  = DB::table('hotel_galleries')
                ->select('id', 'image')
                ->where('hotel_galleries.hotel_id', $det->id)
                ->where('hotel_galleries.id', $op, $imageId)
                ->orderBy('id', $order)
                ->first();
      if(empty($image)):
        $image  = DB::table('hotel_galleries')
                ->select('id', 'image')
                ->where('hotel_galleries.hotel_id', $det->id)
                ->orderBy('id','ASC')
                ->first();
      endif;
      $return = array(
          'id'    => $image->id,
          'url'   => url('public/uploads/' . $image->image)
      );
    endif;
    print json_encode($return);
  }
  public function fetchSearchHotelImage(Request $request){
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', '90000000000000');
    $hotelImagesId    = json_decode($request->hotelImagesId, true);
    //echo "<pre>"; print_r($hotelImagesId); die;
    foreach($hotelImagesId as $hotelId):
      if(is_numeric($hotelId)):
        $image  = DB::table('hotel_images_xml')
                ->select('hotel_image_id', 'Url')
                ->where('hotel_images_xml.hotel_id', $hotelId)
                ->orderBy('hotel_image_id','ASC')
                ->first();
        $stuba  = TRUE;
      else:
        $det    = DB::table('hotels')->select('id')->where('hotel_token', $hotelId)->get()->first();
        $image  = DB::table('hotel_galleries')
                ->select('id', 'image')
                ->where('hotel_galleries.hotel_id', $det->id)
                ->orderBy('id','ASC')
                ->first();
        $stuba  = FALSE;
      endif;
      $html[] = view('frontend.hotels.ajaxSearchHotelImage', compact('image', 'hotelId', 'stuba'))->render();
    endforeach;
    print json_encode(array(
        'hotelImagesId' => $hotelImagesId,
        'html'          => $html
    ));
  }
  public function destinationFetchRoomBACKUP(Request $request){
    ini_set('memory_limit', '-1');
    $ab           = array();
    $totalAdults  = 0;
    $totalKids    = 0;
    $totalRoom    = 0;
    foreach($request->norm as $keyyy => $val):
      $ab['norm'][]   = $val;
      $ab['adlts'][]  = $request->adlts[$keyyy];
      $ab['kids'][]   = $request->kids[$keyyy];
      $totalAdults    += $request->adlts[$keyyy];
      $totalKids      += $request->kids[$keyyy];
      $totalRoom++;
    endforeach;
    Session::put('t_start', $request->roomSearchFromDate);
    Session::put('t_end', $request->roomSearchToDate);
    Session::put('keywords', $request->roomSearchKeyword);
    Session::put('quantity_adults', $totalAdults);
    Session::put('quantity_child', $totalKids);
    Session::put('ab', $ab);
    Session::put('rooms', $ab);
    Session::put('num_room', $totalRoom);
    Session::put('quantityRooms', $totalRoom);
    Session::put('noguests', ($totalAdults + $totalKids));
    Session::save();
    $html = '<div class="roombox">
              <div class="row clearfix text-center">
                <h2>Not available for your selected dates!  Please try other dates !!</h2>
                <a href="javascript:void(0);" class="hotelDetailsBack">
                  <h3>or return to your last Search !!</h3>
                </a> 
              </div>
            </div>';
    //$region = DB::table('roomxml_region')->Where('name', 'like', $request->roomSearchKeyword. '%')->get()->toArray();
    $region = DB::table('hotel_region_xml')
            ->select('country as country_name', 'region_id', 'searchable_region as name')
            ->Where('country', 'like', '%' .$request->roomSearchKeyword. '%')
            ->orWhere('region', 'like', '%' .$request->roomSearchKeyword. '%')
            ->orWhere('sub_region', 'like', '%' .$request->roomSearchKeyword. '%')
            ->get()->toArray();
    if(!empty($region)):
      //session(['region_id' => $region[0]->region_id]);
      Session::put('region_id', $region[0]->region_id);
      $diff = date_diff(date_create($request->roomSearchFromDate), date_create($request->roomSearchToDate));
      $diff = $diff->format("%a");
      //session(['totalNight' => $diff]);
      Session::put('totalNight', $diff);
      // echo "<pre>";
      // print_r(session()->all()); die;
      $request['ab']              = Session::get('ab');
      $request['rooms']           = Session::get('rooms');
      $request['num_room']        = Session::get('num_room');
      $request['region_id']       = Session::get('region_id');
      $request['keywords']        = Session::get('keywords');
      $request['t_start']         = Session::get('t_start');
      $request['t_end']           = Session::get('t_end');
      $request['quantity_adults'] = Session::get('quantity_adults');
      $request['quantity_child']  = Session::get('quantity_child');
      $request['noguests']        = Session::get('noguests');
      $filter                     = new Filter;
      $xml                        = $filter->AvailabilitySearchXML($request);
      $url                        = "http://api.stuba.com/RXLServices/ASMX/XmlService.asmx";
      $data                       = $filter->fatchRoomsxml($url,$xml);
      $currency                   = 'AUD';
      $hotelForRoom               = array();
      $price                      = array();
      $result                     = array();
      $finalSearchHotel         = array();
      //echo "<pre>"; print_r($data); die;
      if($data["HotelAvailability"]):
        for ($i = 0; $i < count($data["HotelAvailability"]); $i++) :
          @$hotel_name = $data["HotelAvailability"][$i]["Hotel"]["@attributes"]["id"];
          if($hotel_name == $request->roomStubaId):
            $finalSearchHotel = $data["HotelAvailability"][$i];
            break;
          endif;
        endfor;
      endif;
      if(!empty($finalSearchHotel)):
        $html = view('frontend.hotels.ajaxHotel', compact('finalSearchHotel'))->render();
      endif;
    endif;
    print json_encode(array(
      "html" => $html
    ));
    die;
  }
}