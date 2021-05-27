<?php
namespace App\Http\Controllers;
use App\Hotels;
use App\Booking;
use App\BookingItem;
use App\User;
use App\TourGuide;
use Mail;
use Illuminate\Http\Request;
use App\Filter;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Rooms;
use App\HotelNewEntry;
class XmlController extends Controller{
  public function getBookingReq(Request $request, $id){
    $quantity_adults = explode(" ", $request->quantity_adults);
    $quantity_adults = $quantity_adults[0];
    $quantity_childs = explode(" ", $request->quantity_childs);
    $quantity_childs = $quantity_childs[0];
    $quantity_rooms = explode(" ", $request->quantity_rooms);
    $quantity_rooms = $quantity_rooms[0];
    if((Session::has('rooms'))){
      $rooms_details = Session::get('rooms');
    }else{
      for($i = 0; $i < $quantity_adults; $i++){
        $tmp['norm'][] = 1;
        $tmp['adlts'][] = 1;
        $tmp['kids'][] = 0;
      }
      Session::put('rooms', $tmp);
      $rooms_details = Session::get('rooms');
    }
    Session::put('quantityAdults', $quantity_adults);
    Session::put('quantityChilds', $quantity_childs);
    Session::put('quantityRooms', $quantity_rooms);
    //(Session::has('returnURLIfNoRoom'))
    Session::put('returnURLIfNoRoom', Session::get('_previous')['url']);
    return view('frontend.hotels.xmlbooking', compact('quantity_adults', 'quantity_childs', 'rooms_details', 'id'));
  }
  public function getBookingSummery(Request $request){
    $adults = $request->quantity_adults;
    $quoteid =$request->quoteid;
    session(['guests' => $request->room]);
    session(['quoteid' => $request->quoteid]);
    //$room = serialize($request->room);
    $filter = new Filter;
    $xml = $filter->BookingPrepareXML($request);
    //echo $xml; die;
    $url = get_option('stuba_post_url')."/RXLServices/ASMX/XmlService.asmx"; 
    $data = $filter->fatchRoomsxml($url,$xml);
    // echo "<pre>";
    // print_r($request->all());
    // die;
    // echo "<pre>";
    // print_r($data);
    // die;
    return view('frontend.hotels.xmlconfirm', compact('data','adults','quoteid','room'));
  }
  public function bookingConfirm(Request $request){
    // print_r($request->all());
    // die;
    $guests_details=Session::get('guests');
    $request->room = $guests_details;
    $filter = new Filter;
    $xml = $filter->BookingPrepareXML($request);
    $url = get_option('stuba_post_url')."/RXLServices/ASMX/XmlService.asmx"; 
    $bookdata = $filter->fatchRoomsxml($url,$xml);
    /*echo '<pre>';
      var_dump($bookdata);
    echo '</pre>';
    exit;*/
    if(isset($bookdata["CommitLevel"])){
      //$xml_booking_id = $bookdata["Booking"]['Id'];
      //$xml_booking_id = '777777777777';
      $xml_booking_id = rand(1111111111111, 9999999999999);
      $hotelbooking = $bookdata['Booking']['HotelBooking'];
      $totalsellingprice=0;
      if(isset($hotelbooking[0])){
        foreach($hotelbooking as $hotelbook){
          $totalsellingprice += (float) get_option('markup_price') + (float)$hotelbook['Room']['TotalSellingPrice']['@attributes']['amt']; 
          $hotel_id =$hotelbook['HotelId'];
        }
      }else{
        $totalsellingprice = number_format(((float) get_option('markup_price') + (float)$hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt']), 2); 
        $hotel_id =$bookdata['Booking']['HotelBooking']['HotelId'];
      }
      $totalsellingprice = number_format((float)$totalsellingprice, 2);
      $html = "";
      $booking_id=0;
      $booking_user_id='';
      $braintree_customer_id='';
      $pricehtml='';
      $userhtml='';
      $user_id =get_loggedin_id();
      $user = User::all()->where('email', $request->email)->first();
      //if($user_id==0){
      if(empty($user)){            
        $password = get_randompass(8);
        $username = get_randompass(8);
        $user = User::create([
          'username' => $request->first_name.$username,
          'email' => $request->email,
          'first_name' => $request->first_name,
          'last_name' =>  $request->surname,
          'password' => bcrypt($password ),
          'mobile_number'=>'0',
          'country_code'=>'0',
        ]); 
        $user->title = $request->title;
        $user->first_name = $request->first_name;
        $user->last_name = $request->surname;
        $user->mobile_number = $request->mobile_number;
        $user->address  = $request->address;
        $user->address_2  = $request->address_2;
        $user->city   = $request->city;
        $user->zipcode   = $request->zipcode;
        $user->country_code = $request->country;
        $user->save();
        $user_id = $user->id;
        //  send mail 
        if (is_live()) {
          $e_data = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => $password,
          ];
          Mail::send('emails.welcome', ['e_data' => $e_data], function ($m) use ($e_data) {
            $m->from('no-reply@fitser.com', get_option('blogname'));
            $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to '.get_option('blogname'));
          });
        }
        $booking_user_id = $user->id;
        $booking = new Booking;
        $booking->xml_booking_id =  $xml_booking_id;
        $booking->user_id =  $user->id;
        $booking->hotel_id = $hotel_id;
        $booking->carttotal = $request->totalprice;
        $booking->markUpTotal = $request->markUpPrice;
        // $booking->carttotal = round($request->totalprice);
        // $booking->markUpTotal = round($request->markUpPrice);
        $booking->currency = $bookdata["Currency"];
        $booking->start_date = $request->start_date;
        $booking->end_date = $request->end_date;
        $booking->booking_comment = $request->booking_comment;
        $booking->status = 4;
        $booking->type = 'stuba';
        $booking->xml_data = serialize($bookdata);
        $booking->save();
        $booking_id = $booking->id;
      }else{
        //$user = auth('web')->user();
        $user_id = $user->id;
        $cUser= User::find($user->id);
        if($cUser){
          $cUser->title = $request->title;
          $cUser->first_name = $request->first_name;
          $cUser->last_name = $request->surname;
          $cUser->mobile_number = $request->mobile_number;
          $cUser->address  = $request->address_1;
          $cUser->address_2  = $request->address_2;
          $cUser->city   = $request->city;
          $cUser->zipcode   = $request->zipcode;
          $cUser->country_code = $request->country;
          $cUser->save();
        }
        $booking = new Booking;
        $booking->xml_booking_id =  $xml_booking_id;
        $booking->user_id =  $user->id;
        $booking->hotel_id = $hotel_id;
        $booking->carttotal = $request->totalprice;
        $booking->markUpTotal = $request->markUpPrice;
        // $booking->carttotal = round($request->totalprice);
        // $booking->markUpTotal = round($request->markUpPrice);
        $booking->currency = $request->currency;
        $booking->start_date = $request->start_date;
        $booking->end_date = $request->end_date;
        $booking->booking_comment = $request->booking_comment;
        $booking->status = 4;
        $booking->type = 'stuba';
        $booking->xml_data = serialize($bookdata);
        $booking->save();
        $booking_id = $booking->id;
        $booking_user_id = $user->id;
      } 
      $data['status'] = 'success';
      $pricehtml .='<h3>'.getPrice($request->totalprice).'</h3>';
      $html .='<div>';
      $html .='<input type="hidden" id="totalprice" name="totalprice" value="'.$request->totalprice.'">';
      $html .='<input type="hidden" id="markUpPrice" name="markUpPrice" value="'.$request->markUpPrice.'">';
      $html .='<input type="hidden" id="booking_id" name="booking_id" value="'.$booking_id.'">';
      $html .='<input type="hidden" id="booking_user_id" name="booking_user_id" value="'.$booking_user_id.'">';
      $html .='<input type="hidden" id="currency" name="currency" value="'.$request->currency.'">';
      $html .='</div>';
      $userhtml .='<div class="user_info">';
      $userhtml .='<input readonly type="text" id="first_name" name="first_name" value="'.$request->first_name.'">';
      $userhtml .='<input readonly type="text" id="last_name" name="last_name" value="'.$request->surname.'">';
      $userhtml .='<input readonly type="text" id="mobile_number" name="mobile_number" value="'.$request->mobile_number.'">';
      $userhtml .='<input readonly type="text" id="email" name="email" value="'.$request->email.'">';
      $userhtml .='<input readonly type="text" id="address" name="address" value="'.$request->address_1.'">';
      $userhtml .='<input readonly type="text" id="address2" name="address2" value="'.$request->address_2.'">';
      $userhtml .='<input readonly type="text" id="city" name="city" value="'.$request->city.'">';
      $userhtml .='<input readonly type="text" id="zipcode" name="zipcode" value="'.$request->zipcode.'">';
      $userhtml .='</div>';
      $newHtml = '';
      $newHtml .='<input type="hidden" id="paymenttotalprice" value="'.$request->totalprice.'">';
      $newHtml .='<input type="hidden" id="paymentmarkUpPrice" value="'.$request->markUpPrice.'">';
      $newHtml .='<input type="hidden" id="paymentbooking_id" value="'.$booking_id.'">';
      $newHtml .='<input type="hidden" id="paymentbooking_user_id" value="'.$booking_user_id.'">';
      $newHtml .='<input type="hidden" id="paymentcurrency" value="'.$request->currency.'">';
      $newHtml .='<input type="hidden" id="paymentfirst_name" value="'.$request->first_name.'">';
      $newHtml .='<input type="hidden" id="paymentlast_name" value="'.$request->surname.'">';
      $newHtml .='<input type="hidden" id="paymentmobile_number" value="'.$request->mobile_number.'">';
      $newHtml .='<input type="hidden" id="paymentemail" value="'.$request->email.'">';
      $newHtml .='<input type="hidden" id="paymentaddress" value="'.$request->address_1.'">';
      $newHtml .='<input type="hidden" id="paymentaddress2" value="'.$request->address_2.'">';
      $newHtml .='<input type="hidden" id="paymentcity" value="'.$request->city.'">';
      $newHtml .='<input type="hidden" id="paymentzipcode" value="'.$request->zipcode.'">';
      $newHtml .='<input type="hidden" id="paymentfinalBtn">';
      $data['phtml']= $html;
      $data['userhtml']= $userhtml;
      $data['pricehtml']= $pricehtml;
      $data['totalprice'] = $request->totalprice;
      $data['markUpPrice'] = $request->markUpPrice;
      $data['booking_id'] = $booking_id;
      $data['user_id'] = $booking_user_id; 
      $data['currency'] = $request->currency;
      //return view('frontend.hotels.xmlpay', compact('data'));
      print json_encode(array(
        "success" => TRUE,
        "newHtml" => $newHtml
      ));
    }else{
      print json_encode(array(
        "success"   => FALSE
      ));
      // $code=$bookdata["Code"];
      // $message = $bookdata["Description"];
      // return view('frontend.hotels.4004', compact('code','message'));
    }
  }

  public function getBookingReqNew(Request $request){
    $bookingArray           = json_decode($request->bookingArray, true);
    $bookingArray['roomId'] = $request->roomId;
    return view('frontend.hotels.hotel-booking', compact('bookingArray'));
  }
  public function getBookingSummeryNew(Request $request){
    $bookingArray         = json_decode($request->bookingArray, true);
    $guestsDetails        = array();
    foreach($bookingArray['rooms']['norm'] as $k => $v):
      for($a = 0; $a < $bookingArray['rooms']['adlts'][$k]; $a++):
        $guestsDetails['adlts'][$k][] = array(
          'title'     => $request->adultTitle[$k][$a],
          'firstName' => $request->adultFirst[$k][$a],
          'lastName'  => $request->adultLast[$k][$a]
        );
      endfor;
      if($bookingArray['rooms']['kids'][$k]):
        for($a = 0; $a < $bookingArray['rooms']['kids'][$k]; $a++):
          $guestsDetails['kids'][$k][] = array(
            'title'     => $request->childTitle[$k][$a],
            'firstName' => $request->childFirst[$k][$a],
            'lastName'  => $request->childLast[$k][$a],
            'age'       => $request->childAge[$k][$a],
          );
        endfor;
      else:
        $guestsDetails['kids'][$k]  = array();
      endif;
    endforeach;
    $bookingArray['guestsDetails']  = $guestsDetails;
    $bookingArray['hotelDetails']   = Hotels::where('hotel_token', $bookingArray['hotelToken'])->first();
    $bookingArray['roomDetails']    = Rooms::find($bookingArray['roomId']);
    return view('frontend.hotels.hotel-booking-summary', compact('bookingArray'));
  }
  public function hotelBookingConfirm(Request $request){
    // pr($request->all(), false);
    $bookingArray = json_decode($request->bookingArray, true);
    $userId       = get_loggedin_id();
    //$chkUser    = User::where('email', $request->userEmail)->where('role', 2)->first();
    $chkUser      = User::where('email', $request->userEmail)->first();
    if(empty($chkUser)):
      $password = get_randompass(8);
      $username = get_randompass(4);
      $u        = User::create([
        'username'      => $request->firstName.$username,
        'email'         => $request->userEmail,
        'title	'       => $request->title,
        'first_name'    => $request->firstName,
        'last_name'     => $request->lastName,
        'password'      => bcrypt($password),
        'mobile_number' => $request->mobileNumber,
        'address'       => $request->address_1,
        'address_2'     => $request->address_2,
        'city'          => $request->city,
        'zipcode'       => $request->zipcode,
        'country_code'  => $request->country,
      ]);
      $userId = $u->id;
      //  send mail 
      // if (is_live()) :
      //   $e_data = [
      //     'first_name' => $user->first_name,
      //     'last_name' => $user->last_name,
      //     'email' => $user->email,
      //     'password' => $password,
      //   ];
      //   Mail::send('emails.welcome', ['e_data' => $e_data], function ($m) use ($e_data) {
      //     $m->from('no-reply@fitser.com', get_option('blogname'));
      //     $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to '.get_option('blogname'));
      //   });
      // endif;
    else:
      $userId = $chkUser->id;
    endif;
    $booking    = Booking::create([
      'user_id'         => $userId,
      'hotel_id	'       => $bookingArray['hotelDetails']['id'],
      'hotel_token'     => $bookingArray['hotelToken'],
      'room_id'         => $bookingArray['roomId'],
      'start_date'      => $bookingArray['startDate'],
      'end_date'        => $bookingArray['endDate'],
      'nights'          => $bookingArray['totalNight'],
      'carttotal'       => $bookingArray['roomDetails']['base_price'] * $bookingArray['totalNight'] * $bookingArray['quantityRooms'],
      'currency'        => getCurrency(),
      'booking_comment' => $request->booking_comment,
      'status'          => 1,
      'type'            => 'site',
      'booking_data'    => $request->bookingArray,
      'guest_details'   => json_encode($bookingArray['guestsDetails'])
    ]);
    $bookingId = $booking->id;
    for($n = 0; $n < $bookingArray['totalNight']; $n++):
      $strt = date('Y-m-d', strtotime($bookingArray['startDate']. ' + '. $n .' days'));
      $end  = date('Y-m-d', strtotime($bookingArray['startDate']. ' + '. ($n+1) .' days'));
      $bi   = BookingItem::create([
        'booking_id'      => $bookingId,
        'hotel_id	'       => $bookingArray['hotelDetails']['id'],
        'hotel_token'     => $bookingArray['hotelToken'],
        'room_id'         => $bookingArray['roomId'],
        'user_id'         => $userId,
        'base_price'      => $bookingArray['roomDetails']['base_price'],
        'price'           => $bookingArray['roomDetails']['base_price'],
        'discount'        => '0',
        'total_price'     => ($bookingArray['quantityRooms'] * $bookingArray['roomDetails']['base_price']),
        'nights'          => 1,
        'room_details_id' => $bookingArray['roomId'],
        'check_in'        => $strt,
        'check_out'       => $end,
        'start_date'      => $strt,
        'end_date'        => $end,
        'quantity_adults' => $bookingArray['quantityAdults'],
        'quantity_child'  => $bookingArray['quantityChild'],
        'quantity_room'   => $bookingArray['quantityRooms'],
        'status'          => '1'
      ]);
    endfor;
    print json_encode(array('success' => TRUE));
  }
}
