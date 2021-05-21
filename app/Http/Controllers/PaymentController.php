<?php

namespace App\Http\Controllers;
use App\RecreationTranslation;
use Auth;
use App\Hotels;
use App\User;
use App\Rooms;
use App\Booking;
use App\BookingItem;
use App\Transaction;
use App\RoomAllocation;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PaymentController extends Controller
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

  public function checkout(Request $request) 
     {
        $config = new \Braintree_Configuration([
            'environment' => 'sandbox',
            'merchantId' => 'kp8tw949t876r8gv',
            'publicKey' => 'qh72yshrh9jzd8zh',
            'privateKey' => '36ce8b294f9d0d4ec81df1fe67d11dce'
          ]);
          $gateway = new \Braintree\Gateway($config);
       
           $clientToken = $gateway->clientToken()->generate();


          // $customer = Auth::user();
           $customer=User::where('id',$request->booking_user_id) -> first();

           // when client hit checkout button
           if( $request->isMethod('post') ) 
           {
                // brain tree customer payment nouce
                $payment_method_nonce = $request->get('payment_method_nonce');

                // make sure that if we do not have customer nonce already
                // then we create nonce and save it to our database
                if ( !$customer['braintree_nonce']) 
                {
                      // once we recieved customer payment nonce
                      // we have to save this nonce to our customer table
                      // so that next time user does not need to enter his credit card details
                      
                      $result = $gateway->paymentMethod()->create([
                          'customerId' =>  $customer['braintree_customer_id'],
                          'paymentMethodNonce' => $payment_method_nonce
                      ]);

                      // save this nonce to customer table
                      $customer['braintree_nonce'] = @$result->customer->paymentMethods[0]->token;
                      $customer->save();
                }
                
                // process the customer payment
                $result = @$gateway->paymentMethodNonce()->create($customer['braintree_nonce']);

                $nonce = $result->paymentMethodNonce->nonce;
                $result = $gateway->transaction()->sale([
                    'amount' => $request->totalprice,
                    'paymentMethodNonce' => nonceFromTheClient,
                    'options' => [
                      'submitForSettlement' => True
                    ]
                  ]);

                  if ($result->success) {
                    // See $result->transaction for details
                      echo 'your customer payment is done successfully';
                  } else {
                    // Handle errors
                  }
           }
           return view('frontend.payment.checkout', compact('clientToken'));
          
     }
     
     public function checkoutProcessBraintree(Request $request) {
         //var_dump($request);
        $message='';
        $config = new \Braintree_Configuration([
            'environment' => 'sandbox',
            'merchantId' => 'kp8tw949t876r8gv',
            'publicKey' => 'qh72yshrh9jzd8zh',
            'privateKey' => '36ce8b294f9d0d4ec81df1fe67d11dce'
          ]);
          $gateway = new \Braintree\Gateway($config);
          $clientToken = $gateway->clientToken()->generate(); 
          // $customer = Auth::user();
           $customer=User::find($request['booking_user_id']);

           // when client hit checkout button
           if( $request->isMethod('post') ) 
           {
                // brain tree customer payment nouce
                 $payment_method_nonce = $request->get('payment_method_nonce');
                 $totalprice = $request->get('totalprice');
                 $result = $gateway->transaction()->sale([
                    'amount' => $totalprice,
                    'paymentMethodNonce' =>  $payment_method_nonce,
                    'options' => [
                      'submitForSettlement' => True
                    ]
                  ]);
                
                 if ($result->success || !is_null($result->transaction)) {
                          $tt = $result->transaction;
                          $message= 'Hi '.$customer->first_name .' your payment is  successfully done ID '.$tt->id;
                          $transaction = new Transaction;
                          $transaction->transid  =  $tt->id;
                          $transaction->user_id =  $customer->id;
                          $transaction->booking_id = $request->get('booking_id');
                          $transaction->amount = $request->totalprice;
                          $transaction->currency = $request->get('currency');
                          $transaction->payment_type = $request->get('payment_type');
                          $transaction->status = 1;
                          $transaction->save();
                          $transaction_id = $transaction->id;
                        //var_dump($result->transaction);
                        // change booking status after successfully payment done
                        if($transaction_id){
                          $booking = Booking::find($request->get('booking_id'));
                          $booking->status = 1;
                          $booking->save();
                        }
                        $booking->items= BookingItem::where('booking_id', '=' , $booking->id)->get()->all();
                        $booking->hotel = Hotels::where('id', '=' , $booking->hotel_id)->get()->first();
                        foreach ($booking->items as $key => $value) {
                            $availability_ids = explode(',', $value['availability_ids']);
                            foreach ($availability_ids as $key => $id) {
                               RoomAllocation::where('availability_id', $id)->where('room_details_id', $value['room_details_id'])->update(['status' => 0]);
                            }
                           //$booking->rooms[] = Rooms::where('id', '=', $value['room_id'])->get()->first(); 
                         }

                          //  send mail 
                         if (is_live()) {
                           $e_data = [
                              'booking_id' => $request->get('booking_id'),
                              'first_name' => $customer->first_name,
                              'last_name' => $customer->last_name,
                              'email' => $customer->email,
                            ];
                            Mail::send('emails.booking', ['e_data' => $e_data], function ($m) use ($e_data) {
                              $m->from('no-reply@fitser.com', get_option('blogname'));

                              $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Complete');
                            });
                         }
                                                
                        return view('frontend.payment.confirm', compact('booking','transaction_id','customer'));
                  }else {
                        $errorString = "";
                      foreach($result->errors->deepAll() as $error) {
                            $message .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                      }
                      //$_SESSION["errors"] = $errorString;   
                      return view('frontend.payment.message', compact('message'));
                  } 
           }else{
              return view('frontend.payment.message', compact('message'));
           }
     }


      public function hotelierCheckoutProcessBraintree(Request $request) {
        $message='';
        $config = new \Braintree_Configuration([
            'environment' => 'sandbox',
            'merchantId' => 'kp8tw949t876r8gv',
            'publicKey' => 'qh72yshrh9jzd8zh',
            'privateKey' => '36ce8b294f9d0d4ec81df1fe67d11dce'
          ]);
          $gateway = new \Braintree\Gateway($config);
          $clientToken = $gateway->clientToken()->generate(); 
          // $customer = Auth::user();
           $customer=User::find($request['booking_user_id']);

           // when client hit checkout button
           if( $request->isMethod('post') ) 
           {
                // brain tree customer payment nouce
                 $payment_method_nonce = $request->get('payment_method_nonce');
                 $totalprice = $request->get('totalprice');
                 $result = $gateway->transaction()->sale([
                    'amount' => $totalprice,
                    'paymentMethodNonce' =>  $payment_method_nonce,
                    'options' => [
                      'submitForSettlement' => True
                    ]
                  ]);
                
                 if ($result->success || !is_null($result->transaction)) {
                          $tt = $result->transaction;
                          $message= 'Hi '.$customer->first_name .' your payment is  successfully done ID '.$tt->id;
                          $transaction = new Transaction;
                          $transaction->transid  =  $tt->id;
                          $transaction->user_id =  $customer->id;
                          $transaction->booking_id = $request->get('booking_id');
                          $transaction->amount = $request->totalprice;
                          $transaction->currency = $request->get('currency');
                          $transaction->payment_type = $request->get('payment_type');
                          $transaction->status = 1;
                          $transaction->save();
                          $transaction_id = $transaction->id;
                        //var_dump($result->transaction);
                        // change booking status after successfully payment done
                        if($transaction_id){
                          $booking = Booking::find($request->get('booking_id'));
                          $booking->status = 1;
                          $booking->save();
                        }
                        $booking->items= BookingItem::where('booking_id', '=' , $booking->id)->get()->all();
                        $booking->hotel = Hotels::where('id', '=' , $booking->hotel_id)->get()->first();
                        foreach ($booking->items as $key => $value) {
                            $availability_ids = explode(',', $value['availability_ids']);
                            foreach ($availability_ids as $key => $id) {
                               RoomAllocation::where('availability_id', $id)->where('room_details_id', $value['room_details_id'])->update(['status' => 0]);
                            }
                           $booking->rooms[] = Rooms::where('id', '=', $value['room_id'])->get()->first(); 
                        }
                         if (is_live()) {
                           //  send mail 
                           $e_data = [
                              'booking_id' => $request->get('booking_id'),
                              'first_name' => $customer->first_name,
                              'last_name' => $customer->last_name,
                              'email' => $customer->email,
                            ];
                            Mail::send('emails.booking', ['e_data' => $e_data], function ($m) use ($e_data) {
                              $m->from('no-reply@fitser.com', get_option('blogname'));

                              $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Complete');
                            });
                          }
                        
                        return view('frontend.hotelier.confirm', compact('booking','transaction_id','customer'));
                  } else {
                        $errorString = "";
                      foreach($result->errors->deepAll() as $error) {
                            $message .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                      }
                      //$_SESSION["errors"] = $errorString;   
                      return view('frontend.hotelier.message', compact('message'));
                  } 
           }else{
              return view('frontend.hotelier.message', compact('message'));
           }
     }

     public function checkoutProcessCashon(Request $request){
        $message='';
        $customer=User::find($request['booking_user_id']);
         if( $request->isMethod('post') ){
           $transactionid  = getTransactionNoHash();
                 if ($transactionid) {
                          $message .= 'Hi '.$customer->first_name .' your Booking is  successfully done,Your transaction ID '.$transactionid;
                          $transaction = new Transaction;
                          $transaction->transid  =  $transactionid;
                          $transaction->user_id =  $customer->id;
                          $transaction->booking_id = $request->get('booking_id');
                          $transaction->amount = $request->totalprice;
                          $transaction->currency = $request->get('currency');
                          $transaction->payment_type = $request->get('payment_type');
                          $transaction->payment_opt = $request->get('payment_opt');
                          $transaction->status = 2;
                          $transaction->save();
                          $transaction_id = $transaction->id;
                        //var_dump($result->transaction);
                        // change booking status after successfully payment done
                        if($transaction_id){
                          $booking = Booking::find($request->get('booking_id'));
                          $booking->status = 1;
                          $booking->save();
                        }
                        $booking->items= BookingItem::where('booking_id', '=' , $booking->id)->get()->all();
                        $booking->hotel = Hotels::where('id', '=' , $booking->hotel_id)->get()->first();
                         foreach ($booking->items as $key => $value) {
                            $availability_ids = explode(',', $value['availability_ids']);
                            foreach ($availability_ids as $key => $id) {
                               RoomAllocation::where('availability_id', $id)->where('room_details_id', $value['room_details_id'])->update(['status' => 0]);
                            }
                           
                        } 

                        //  send mail 
                        if (is_live()){
                          $e_data = [
                            'booking_id' => $request->get('booking_id'),
                            'first_name' => $customer->first_name,
                            'last_name' => $customer->last_name,
                            'email' => $customer->email,
                           ];
                          Mail::send('emails.booking', ['e_data' => $e_data], function ($m) use ($e_data) {
                            $m->from('no-reply@fitser.com', get_option('blogname'));

                            $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Complete');
                          });
                        }
                       return view('frontend.payment.confirm', compact('booking','transactionid','customer'));
                    }else{
                      $errorString = "";  
                      return view('frontend.payment.message', compact('message'));
                  } 
           }else{
              return view('frontend.payment.message', compact('message'));
           }
     }

     public function hotelierCheckoutProcessCashon(Request $request){
        $message='';
        $customer=User::find($request['booking_user_id']);
         if( $request->isMethod('post') ){
           $transactionid  = getTransactionNoHash();
                 if ($transactionid) {
                          $message .= 'Hi '.$customer->first_name .' your Booking is  successfully done,Your transaction ID '.$transactionid;
                          $transaction = new Transaction;
                          $transaction->transid  =  $transactionid;
                          $transaction->user_id =  $customer->id;
                          $transaction->booking_id = $request->get('booking_id');
                          $transaction->amount = $request->totalprice;
                          $transaction->currency = $request->get('currency');
                          $transaction->payment_type = $request->get('payment_type');
                          $transaction->payment_opt = $request->get('payment_opt');
                          $transaction->status = 2;
                          $transaction->save();
                          $transaction_id = $transaction->id;
                        //var_dump($result->transaction);
                        // change booking status after successfully payment done
                        if($transaction_id){
                          $booking = Booking::find($request->get('booking_id'));
                          $booking->status = 1;
                          $booking->save();
                        }
                        $booking->items= BookingItem::where('booking_id', '=' , $booking->id)->get()->all();
                        $booking->hotel = Hotels::where('id', '=' , $booking->hotel_id)->get()->first();
                         foreach ($booking->items as $key => $value) {
                            $availability_ids = explode(',', $value['availability_ids']);
                            foreach ($availability_ids as $key => $id) {
                               RoomAllocation::where('availability_id', $id)->where('room_details_id', $value['room_details_id'])->update(['status' => 0]);
                            }
                           
                        } 

                        //  send mail 
                          $e_data = [
                            'booking_id' => $request->get('booking_id'),
                            'first_name' => $customer->first_name,
                            'last_name' => $customer->last_name,
                            'email' => $customer->email,
                          ];
                          Mail::send('emails.booking', ['e_data' => $e_data], function ($m) use ($e_data) {
                            $m->from('no-reply@fitser.com', get_option('blogname'));

                            $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Complete');
                          });

                       return view('frontend.hotelier.confirm', compact('booking','transactionid','customer'));
                    }else{
                      $errorString = "";  
                      return view('frontend.hotelier.message', compact('message'));
                  } 
           }else{
              return view('frontend.hotelier.message', compact('message'));
           }
     }

      public function checkoutProcessPaypalPro(Request $request){
         //var_dump($request);
        // $customer = Auth::user();
           $customer=User::find($request['booking_user_id']);
           $message='';
           // when client hit checkout button
           if( $request->isMethod('post') ) 
           {
                 $booking_id = $request->get('booking_id');
                 $totalprice = $request["totalprice"];
                 $exp_date = $request["expiry_month"].$request["expiry_year"];
            
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
                        'FIRSTNAME' => $customer->first_name,
                        'LASTNAME' => $customer->last_name,
                        'STREET' => $customer->address,
                        'CITY' => $customer->city,
                        //'STATE' => $request['state'],             
                        'COUNTRYCODE' => 'AU',
                        'ZIP' => $customer->zipcode,
                        'AMT' => $request["totalprice"],
                        'CURRENCYCODE' => $request["currency"],
                        'ORDERID' => $booking_id
                 );
            //currency
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
                  curl_close($curl);
                  // Parse the API response
                  //$nvp_response_array = parse_str($result);
                   $response = $this->strParse($result);
                  //echo "<pre>"; print_r($response); echo "</pre>";
                    $paymentStatus = $response["ACK"];
                    
                 if($paymentStatus == "Success"){
                          $transactionID = $response['TRANSACTIONID'];
                          $paidAmount = $response['AMT'];
                          $message= 'Hi '.$customer->first_name .' your payment is  successfully done ID '.$transactionID;
                          $transaction = new Transaction;
                          $transaction->transid  =  $transactionID;
                          $transaction->user_id =  $customer->id;
                          $transaction->booking_id = $request->get('booking_id');
                          $transaction->amount = $request->totalprice;
                          $transaction->currency = $request->get('currency');
                          $transaction->payment_type = $request->get('payment_type');
                          $transaction->status = 1;
                          $transaction->save();
                          $transaction_id = $transaction->id;
                        if($transaction_id){
                          $booking = Booking::find($request->get('booking_id'));
                          $booking->status = 1;
                          $booking->save();
                        }
                        $booking->items= BookingItem::where('booking_id', '=' , $booking->id)->get()->all();
                        $booking->hotel = Hotels::where('id', '=' , $booking->hotel_id)->get()->first();
                        foreach ($booking->items as $key => $value) {
                            $availability_ids = explode(',', $value['availability_ids']);
                            foreach ($availability_ids as $key => $id) {
                               RoomAllocation::where('availability_id', $id)->where('room_details_id', $value['room_details_id'])->update(['status' => 0]);
                            }
                           //$booking->rooms[] = Rooms::where('id', '=', $value['room_id'])->get()->first(); 
                         }
                          $pdf = invoice_generate($booking->id,'site');
                          //  send mail 
                         if (is_live()){
                           $e_data = [
                              'booking_id' => $request->get('booking_id'),
                              'first_name' => $customer->first_name,
                              'last_name' => $customer->last_name,
                              'email' => $customer->email,
                            ];
                            Mail::send('emails.booking', ['e_data' => $e_data], function ($m) use ($e_data,$pdf) {
                              $m->from('no-reply@fitser.com', get_option('blogname'));
                              $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Complete '.get_option('blogname'));
                              $m->attach($pdf , [
                                  'as' => 'invoice.pdf', 
                                  'mime' => 'application/pdf'
                              ]);
                            });
                         }  
                                             
                        return view('frontend.payment.confirm', compact('booking','transaction_id','customer'));
                   }else {
                      return view('frontend.payment.message', compact('message'));
                  } 
           }else{
              return view('frontend.payment.message', compact('message'));
           }
     }


     public function bookingConfirm(Request $request){
      $booking['id'] = Input::get('booking');
      return view('frontend.payment.final_confirm', compact('booking'));
     }
    private function strParse($str){
            $nvp_response_array = explode('&', $str);
            $temp = array();
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

}