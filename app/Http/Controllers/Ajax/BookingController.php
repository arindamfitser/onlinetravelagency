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
use App\Cancelation;
use App\BookingItem;
use App\Transaction;
use App\User;
use App\TourGuide;
use Mail;
use App\Filter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Session;
class BookingController extends Controller
{
  public function __construct()
  {
            //$this->middleware('auth');
    //(get_option('markup_price')=='sandbox'?TRUE:FALSE)
    $sandbox =(get_option('paypal_mode')=='sandbox'?TRUE:FALSE);
    $this->api_endpoint       = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
    $this->api_username     = $sandbox ? get_option('paypal_username') :get_option('paypal_username'); 
    $this->api_password      = $sandbox ? get_option('paypal_password') : get_option('paypal_password');
    $this->api_signature       = $sandbox ? get_option('paypal_signature') : get_option('paypal_signature');
    $this->api_version        = '51.0';
  }

  public function bookingProcess(Request $request){
        // or like this:
    $config = new \Braintree_Configuration([
        'environment' => 'sandbox',
        'merchantId' => 'kp8tw949t876r8gv',
        'publicKey' => 'qh72yshrh9jzd8zh',
        'privateKey' => '36ce8b294f9d0d4ec81df1fe67d11dce'
        ]);
    $gateway = new \Braintree\Gateway($config);
    $clientToken = $gateway->clientToken()->generate();
    $postdata=$request->all();
    $html = "";
    $booking_id=0;
    $booking_user_id='';
    $braintree_customer_id='';
    $pricehtml='';
    $userhtml='';
    $user_id =get_loggedin_id();
    if($user_id==0){
      $exists = DB::table('users')->select('id')->where('email', $request->email)->get()->first();
      if(empty($exists)){
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
        $user->mobile_number = $request->mobile_number;
        $user->address  = $request->address;
        $user->address_2  = $request->address_2;
        $user->city   = $request->city;
        $user->zipcode   = $request->zipcode;
        $user->country_code = $request->country;
        $user->save();
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
                  $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to Guptahotels');
            });
        }
        $booking_user_id = $user->id;
      }else{
        $booking_user_id = $exists->id;
        $cUser= User::find($exists->id);
        if($cUser){
          $cUser->title = $request->title;
          $cUser->mobile_number = $request->mobile_number;
          $cUser->address  = $request->address_1;
          $cUser->address_2  = $request->address_2;
          $cUser->city   = $request->city;
          $cUser->zipcode   = $request->zipcode;
          $cUser->country_code = $request->country;
          $cUser->save();
        }
      }
      $booking = new Booking;
      $booking->user_id =  $booking_user_id;
      $booking->hotel_id = $request->hotel_id;
      $booking->carttotal = $request->totalprice;
      $booking->currency = $request->currency;
      $booking->start_date = $request->start_date;
      $booking->end_date = $request->end_date;
      $booking->booking_comment = $request->booking_comment;
      $booking->status = 3;
      $booking->save();
      $booking_id = $booking->id;
      if($booking_id){
        foreach ($request->cartid as $key => $value) {
          $cartitem = Cart::where('id', '=', $value )->get()->first()->toArray();
          unset($cartitem['id']);
          $cartitem['booking_id']=$booking_id;
          BookingItem::insert($cartitem);
          if($cartitem['room_id']){
            $abilities= RoomAvailability::where('room_id', '=', $cartitem['room_id'])
            ->where('hotel_id', '=', $cartitem['hotel_id'])
            ->whereBetween('date', array($cartitem['start_date'], $cartitem['end_date']))
            ->get()->all();
            array_pop($abilities);                          
            foreach ($abilities as $key => $value2) {
                reduce_room($cartitem['room_id'],$value2['date']);
            }
          }
          Cart::where('id', '=', $value)->delete();
        } 
      }
    }else{
      $user = auth('web')->user(); 
      $cUser= User::find($user->id);
      if($cUser){
        $cUser->title = $request->title;
        $cUser->mobile_number = $request->mobile_number;
        $cUser->address  = $request->address_1;
        $cUser->address_2  = $request->address_2;
        $cUser->city   = $request->city;
        $cUser->zipcode   = $request->zipcode;
        $cUser->country_code = $request->country;
        $cUser->save();
      }
      $booking = new Booking;
      $booking->user_id =  $user_id;
      $booking->hotel_id = $request->hotel_id;
      $booking->carttotal = $request->totalprice;
      $booking->currency = $request->currency;
      $booking->start_date = $request->start_date;
      $booking->end_date = $request->end_date;
      $booking->booking_comment = $request->booking_comment;
      $booking->status = 3;
      $booking->save();
      $booking_id = $booking->id;
      $booking_user_id = $user->id;
      if($booking_id){
        foreach ($request->cartid as $key => $value) {
          $cartitem = Cart::where('id', '=', $value )->get()->first()->toArray();
          unset($cartitem['id']);
          $cartitem['booking_id']=$booking_id;
          BookingItem::insert($cartitem);
          if($cartitem['room_id']){
            $abilities= RoomAvailability::where('room_id', '=', $cartitem['room_id'])
            ->where('hotel_id', '=', $cartitem['hotel_id'])
            ->whereBetween('date', array($cartitem['start_date'], $cartitem['end_date']))
            ->get()->all();
            array_pop($abilities);                          
            foreach ($abilities as $key => $value2) {
                reduce_room($cartitem['room_id'],$value2['date']);
            }
          }
          Cart::where('id', '=', $value)->delete();
        }
      }
    } 
    $data['status'] = 'success';
    $html .='<div>';
    $html .='<input type="hidden" id="totalprice" name="totalprice" value="'.$request->totalprice.'">';
    $html .='<input type="hidden" id="booking_id" name="booking_id" value="'.$booking_id.'">';
    $html .='<input type="hidden" id="booking_user_id" name="booking_user_id" value="'.$booking_user_id.'">';
    $html .='<input type="hidden" id="currency" name="currency" value="'.$request->currency.'">';
    $html .='</div>';
    $pricehtml .='<span>'.getPrice($request->totalprice).'</span>';
    $userhtml .='<div class="user_info">';
    $userhtml .='<input readonly type="text" id="user_name_bill" name="user_name_bill" value="'.$request->first_name.' '.$request->lame_name.'">';
    $userhtml .='<input readonly type="text" id="user_phone_bill" name="user_phone_bill" value="'.$request->mobile_number.'">';
    $userhtml .='<input readonly type="text" id="user_email_bill" name="user_email_bill" value="'.$request->email.'">';
    $userhtml .='<input readonly type="text" id="user_address_bill" name="user_address_bill" value="'.$request->address_1.'">';
    $userhtml .='<input readonly type="text" id="user_address2_bill" name="user_address2_bill" value="'.$request->address_2.'">';
    $userhtml .='<input readonly type="text" id="user_city_bill" name="user_city_bill" value="'.$request->city.'">';
    $userhtml .='<input readonly type="text" id="user_zipcode_bill" name="user_zipcode_bill" value="'.$request->zipcode.'">';
    $userhtml .='</div>';          
    $data['phtml']= $html;
    $data['userhtml']= $userhtml;
    $data['pricehtml']= $pricehtml;
    $data['totalprice'] = $request->totalprice;
    $data['booking_id'] = $booking_id;
    $data['user_id'] = $booking_user_id; 
    $data['braintree_customer_id'] = $braintree_customer_id;
    $data['currency'] = $request->currency;
    echo  json_encode($data);
    exit;
 }


 public function hotelierBookingProcess(Request $request){
        // or like this:
    $config = new \Braintree_Configuration([
        'environment' => 'sandbox',
        'merchantId' => 'kp8tw949t876r8gv',
        'publicKey' => 'qh72yshrh9jzd8zh',
        'privateKey' => '36ce8b294f9d0d4ec81df1fe67d11dce'
        ]);
    $gateway = new \Braintree\Gateway($config);

    $clientToken = $gateway->clientToken()->generate();

    $postdata=$request->all();

     $html = "";
     $booking_id=0;
     $booking_user_id='';
     $braintree_customer_id='';
     $pricehtml='';
     $userhtml='';

     $user = User::find($request->user_id); 
     $booking = new Booking;
     $booking->user_id =  $request->user_id;
     $booking->hotel_id = $request->hotel_id;
     $booking->carttotal = $request->totalprice;
     $booking->currency = $request->currency;
     $booking->start_date = date('Y-m-d', strtotime($request->start_date));
     $booking->end_date = date('Y-m-d', strtotime($request->end_date));
     $booking->status = 3;
     $booking->save();
     $booking_id = $booking->id;
     $booking_user_id = $user->id;
     if($booking_id){
      foreach ($request->cartid as $key => $value) {
          $cartitem = Cart::where('id', '=', $value )->get()->first()->toArray();
          unset($cartitem['id']);
          $cartitem['booking_id']=$booking_id;
          BookingItem::insert($cartitem);
          if($cartitem['room_id']){
             $abilities= RoomAvailability::where('room_id', '=', $cartitem['room_id'])
             ->where('hotel_id', '=', $cartitem['hotel_id'])
             ->whereBetween('date', array($cartitem['start_date'], $cartitem['end_date']))
             ->get()->all();
             array_pop($abilities);                          
             foreach ($abilities as $key => $value2) {
                reduce_room($cartitem['room_id'],$value2['date']);
             }
         }
       Cart::where('id', '=', $value)->delete();
         
     }  
 }

  $data['status'] = 'success';
  
  $html .='<div>';
   $html .='<input type="hidden" id="totalprice" name="totalprice" value="'.$request->totalprice.'">';
   $html .='<input type="hidden" id="booking_id" name="booking_id" value="'.$booking_id.'">';
   $html .='<input type="hidden" id="booking_user_id" name="booking_user_id" value="'.$booking_user_id.'">';
   $html .='<input type="hidden" id="currency" name="currency" value="'.$request->currency.'">';
  $html .='</div>';
  $pricehtml .='<span>'.getPrice($request->totalprice).'</span>';

  $userhtml .='<div class="user_info">';
    $userhtml .='<input readonly type="text" id="user_name_bill" name="user_name_bill" value="'.$user->first_name.' '.$user->lame_name.'">';
    $userhtml .='<input readonly type="text" id="user_phone_bill" name="user_phone_bill" value="'.$user->mobile_number.'">';
    $userhtml .='<input readonly type="text" id="user_email_bill" name="user_email_bill" value="'.$user->email.'">';
    $userhtml .='<input readonly type="text" id="user_address_bill" name="user_address_bill" value="'.$user->address.'">';
    $userhtml .='<input readonly type="text" id="user_address2_bill" name="user_address2_bill" value="'.$user->address_2.'">';
    $userhtml .='<input readonly type="text" id="user_city_bill" name="user_city_bill" value="'.$user->city.'">';
    $userhtml .='<input readonly type="text" id="user_zipcode_bill" name="user_zipcode_bill" value="'.$user->zipcode.'">';
  $userhtml .='</div>';

  $data['phtml']= $html;
  $data['userhtml']= $userhtml;
  $data['pricehtml']= $pricehtml;
  $data['totalprice'] = $request->totalprice;
  $data['booking_id'] = $booking_id;
  $data['user_id'] = $booking_user_id; 
  $data['braintree_customer_id'] = $braintree_customer_id;
  $data['currency'] = $request->currency;
  
  echo  json_encode($data);
  exit;
 }

  public function bookingConfirmProcess(Request $request){
      $guides     = $request->get('guides');
      $customer=User::find($request->get('booking_user_id'));
      if($guides[0]!=0){
        if (is_live()) {
            //  send mail 
           foreach ($guides as $key => $value) {
              $guide=TourGuide::find($value);
              $e_data = [
               'booking_id' => $request->get('booking_id'),
               'first_name' => $customer->first_name,
               'last_name' => $customer->last_name,
               'email' => $customer->email,
               'guide_email' => $guide->email,
               'guide_name' => $guide->business_name,
               ];
               Mail::send('emails.confirm', ['e_data' => $e_data], function ($m) use ($e_data) {
                  $m->from('no-reply@fitser.com', get_option('blogname'));
                  $m->to($e_data['guide_email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Confirm');
               });
             }
            
          }
      }
      
    echo json_encode(array('status' => 1));
  }
 
  public function rxmlBookingProcess(Request $request){
    //var_dump($request->all());
    $guests_details=Session::get('guests');
    $request->room = $guests_details;
    $quoteid=Session::get('quoteid');
    $request->quoteid = $quoteid;
    $customer=User::find($request['booking_user_id']);
    $booking_id = $request["booking_id"];
    $totalprice = $request["totalprice"];
    $exp_date = $request["expiry_month"].$request["expiry_year"];
    if($booking_id){
      $request_params = array(
        'METHOD' => 'DoDirectPayment', 
        'USER' => $this->api_username, 
        'PWD' => $this->api_password, 
        'SIGNATURE' => $this->api_signature, 
        'VERSION' => $this->api_version, 
        'PAYMENTACTION' => 'Sale',                   
        'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
        'CREDITCARDTYPE' => $request['card_type'], 
        'ACCT' => $request['card_number'],
        'EXPDATE' => $exp_date,
        'CVV2' => $request['cvv'],
        'FIRSTNAME' => $request['first_name'],
        'LASTNAME' => $request['last_name'],
        'STREET' => $request['address'],
        'CITY' => $request['city'],
        //'STATE' => $request['state'],             
        'COUNTRYCODE' => 'AU',
        'ZIP' => $request['zipcode'],
        'AMT' => number_format((float)$request["totalprice"], 2, '.', ''),
        'CURRENCYCODE' => $request["currency"],
        'ORDERID' => $booking_id
      );
      // $data['status'] = 0;
      // $data['message'] = $request_params;
      // echo json_encode($data);
      // die;
      $nvp_string = '';
      foreach($request_params as $var=>$val){
          $nvp_string .= '&'.$var.'='.urlencode($val);    
      }
      // Send NVP string to PayPal and store response
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_VERBOSE, 1);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_TIMEOUT, 30);
      curl_setopt($curl, CURLOPT_URL, $this->api_endpoint);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
      $result = curl_exec($curl);    
      $err = curl_error($curl); 
      curl_close($curl);
      // Parse the API response
      //$nvp_response_array = parse_str($result);
      $response = $this->strParse($result);

      
      // $data['status'] = 0;
      // $data['message'] = $response;
      // echo json_encode($data);
      // die;


      // echo "<pre>"; print_r($response); echo "</pre>";
      // die;
      $paymentStatus = $response["ACK"];
      if($paymentStatus == "Success"){
        // Transaction info
        $filter = new Filter;
        $xml = $filter->BookingConfirmXML($request);
        //$url = get_option('stuba_post_url')."/RXLServices/ASMX/XmlService.asmx"; 
        $url = "http://api.stuba.com/RXLServices/ASMX/XmlService.asmx"; 
        $bookdata = $filter->fatchRoomsxml($url,$xml);
        // $data['status'] = 0;
        // $data['message'] = $bookdata;
        // echo json_encode($data);
        // die;
        if(isset($bookdata["CommitLevel"])){
          $xml_booking_id = $bookdata["Booking"]['Id'];
          $transactionID = $response['TRANSACTIONID'];
          $paidAmount = $response['AMT'];
        // Insert tansaction data into the database
          $transaction = new Transaction;
          $transaction->transid  =  urlencode($transactionID);
          $transaction->user_id =  $request->get('booking_user_id');
          $transaction->booking_id = $request->get('booking_id');
          $transaction->amount = $totalprice;
          $transaction->currency = $request->get('currency');
          $transaction->payment_type = 'Paypal';
          $transaction->payment_opt = $request['card_type'];
          $transaction->status = 1;
          $transaction->save();
          // Update booking  status into the database                          
          $booking = Booking::find($booking_id);
          $booking->xml_booking_id =  $xml_booking_id;
          $booking->xml_data = serialize($bookdata);
          $booking->status = 1;
          $booking->save();
          //  send mail 
          $pdf = invoice_generate($booking_id,'stuba');
          if (is_live()) {
            $e_data = [
              'booking_id' => $request->get('booking_id'),
              'first_name' => $customer->first_name,
              'last_name' => $customer->last_name,
              'email' => $customer->email,
            ];
            Mail::send('emails.stuba-booking', ['e_data' => $e_data], function ($m) use ($e_data, $pdf) {
              $m->from('no-reply@fitser.com', 'OTA Hotels');
              $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Complete '.get_option('blogname'));
              $m->attach($pdf , [
                  'as' => 'invoice.pdf', 
                  'mime' => 'application/pdf'
              ]);
            });
          }
          $data['status'] = 1;
          $data['transactionID'] = urlencode($response['TRANSACTIONID']);
          $data['bookid'] = $request->get('booking_id');
          $data['bookingID']= $xml_booking_id;
        }else{
            $data['status'] = 0;
            $data['message'] = 'Payment Failed';
        }
      }else{
        $data['status'] = 0;
        $data['message'] = 'Payment Failed';
      }
    }
    echo json_encode($data);
    exit;
  }

  public function PaypalbookingProcess(Request $request){
     echo 'ok';
     exit;
   }

  private function strParse($str){
            $nvp_response_array = explode('&', $str); $temp = array();
            foreach($nvp_response_array as $row){
                $asd = explode('=', $row);
                 if ( ! isset($asd[1])) {
                     $asd[1] = null;
                  }
                $temp[$asd[0]] = $asd[1];
                  }
                return $temp;
                //echo "<pre>"; print_r($temp); echo "</pre>"; die();
   }

  public function stubaCancelPrepare(Request $request){
       //$room = serialize($request->room);
         $booking_id = $request->get('booking_id');
         $filter = new Filter;
         $xml = $filter->BookingCancelPrepareXML($booking_id);
         $url = get_option('stuba_post_url')."/RXLServices/ASMX/XmlService.asmx"; 
         $data = $filter->fatchRoomsxml($url,$xml);
         $hotelbooking = $data['Booking']['HotelBooking'];
         $Cancelpolicy =array();
        if(isset($hotelbooking[0])){
           foreach($hotelbooking as $hotelbook){
              $Cancelpolicy[] =$hotelbook['Room']['CanxFees'];
           }
        }else{
            $Cancelpolicy[] =$hotelbooking['Room']['CanxFees'];
          }
          $msg='';
          if (!empty($Cancelpolicy)) {
                foreach ($Cancelpolicy as $key => $policies) { 
                   $msg .='<ul>';
                      $msg .='<li><span>Fees for Room'.($key+1).'</span></li>';
                       $msg .=' <ul>';
                            foreach ($policies['Fee'] as $key => $poicy) {
                              if (isset($poicy['@attributes']['from'])) {
                                // $msg .='<li>'.date("Y-m-d", strtotime($poicy['@attributes']['from'])).' will be '.$data['Currency'].number_format($poicy['Amount']['@attributes']['amt'], 2).'</li>';
                                 $msg .='<li>';
                                            if(isset($poicy['@attributes']['from'])){
                                                $msg .= date("Y-m-d", strtotime($poicy['@attributes']['from']));
                                            }
                                            if(isset($poicy['Amount']['@attributes']['amt'])){
                                               $msg .= ' will be '.$data['Currency'].number_format($poicy['Amount']['@attributes']['amt'], 2);
                                            }
                                   $msg .='</li>';
                              }    
                            }
                        $msg .='</ul>';
                                      
                    $msg .='</ul>';
              }
           }
       //print_r($data);
           $data['msg'] = $msg;
       echo json_encode($data);
       exit;

  }

  public function stubaCancelConfirm(Request $request){
        // xbooking_id: 720138620
         $booking_id = $request->get('booking_id');
         $xbooking_id = $request->get('xbooking_id');
         $reason = $request->get('reason');
         $filter = new Filter;
         $xml = $filter->BookingCancelConfirmXML($xbooking_id);
         $url = get_option('stuba_post_url')."/RXLServices/ASMX/XmlService.asmx"; 
         $data = $filter->fatchRoomsxml($url,$xml);

         if(isset($data['CommitLevel']) && $data['CommitLevel']=='confirm'){
            $booking_id = $request->booking_id;
            $booking = Booking::find($booking_id);
            $carttotal = $booking->carttotal;
            $user_id = $booking->user_id;
            $cancelation = new Cancelation;
            $cancelation->booking_id = $booking_id;
            $cancelation->xml_book_id = $xbooking_id;
            $cancelation->user_id = $user_id;
            $cancelation->payable_amount = $carttotal;
            $cancelation->refund_percent = 1;
            $cancelation->reason = $request->reason;
            $cancelation->xml_cancel_data = serialize($data);
            $cancelation->save();
            $booking->status = 2;
            $booking->save();
            //print_r($request->all());
            $user = get_user_details($user_id);
            $e_data = [
                'booking_id' => $xbooking_id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'room' => getStubaBookingValue('RoomName',$booking_id),
                'hotel' => getStubaBookingValue('HotelName',$booking_id),
            ];
            if (is_live()){
              Mail::send('emails.cancel', ['e_data' => $e_data], function ($m) use ($e_data) {
              $m->from('no-reply@fitser.com', get_option('blogname'));
              $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Cancellation');
             });
            }
         }

       echo json_encode($data);
       exit;
  }
 
}



