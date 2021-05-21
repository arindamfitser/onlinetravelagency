<?php

namespace App\Http\Controllers;
use App\Hotels;
use App\Booking;
use App\User;
use App\Rooms;
use App\RoomAllocation;
use App\Cart;
use App\RoomDetail;
use App\BookingItem;
use App\Cancelation;
use App\RoomAvailability;
use PDF;
use Mail;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
    	$user = auth('web')->user();
    	$hotels = Hotels::where('user_id', $user->id)->get()->all();
    	if(!empty($hotels)){
            foreach($hotels as $hkey => $hdata){
                $bookings[] = Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'bookings.hotel_id', '=', 'hotels_translations.hotels_id')->where('bookings.hotel_id', '=', $hdata->id)
              ->get()->all();
            }
            return view('frontend.hotelier.booking', compact('bookings'));
    	}else{
            abort(404);
        }
    }

    public function email_check(){
        echo 123;
    }

    public function add_user(Request $request){
        $password = get_randompass(8);
        $username = get_randompass(4);
        $user = User::create([
            'username' => $request->first_name.$username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'password' => bcrypt($password ),
            'mobile_number'=>'0',
            'country_code'=>'0',
        ]); 
       //$user->title = $request->title;
       $user->mobile_number = $request->phone;
       $user->country_code = $request->country;
       $user->save();
       echo json_encode(array('id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name));
    }

    public function room_availability(Request $request){
        $result = Rooms::leftJoin('room_availabilities', function ($join) use($request){
                    $from = date('Y-m-d', strtotime($request->start_date));
                    $to = date('Y-m-d', strtotime($request->end_date));
                    $hotel_id = $request->hotel_id;
                    $join->on('rooms.id', '=', 'room_availabilities.room_id')
                     ->whereBetween('room_availabilities.date', array($from, $to))
                     ->where('room_availabilities.availability', '=', 1)
                     ->where('rooms.hotel_id', '=', $hotel_id)
                     ->groupBy('room_availabilities.room_id');
        })->get();
        $nights = dateDiff($request->start_date, $request->end_date);
        $rooms = array();
        $rooms_ids = array();
        $available_rooms = array();
         foreach ($result->all() as $key => $value) {
            if(in_array($value['room_id'], $rooms_ids )){
                $rooms[$value['room_id']][] =$value;
            }else{
                $rooms_ids[]=$value['room_id'];
            }
        }
        $html = '';
        /*echo '<pre>';
        print_r($rooms);
        echo '</pre>';
        exit();*/
        $available_rooms = '';
        foreach($rooms as $room){
           /* echo '<pre>';
           print_r($room[0]['id']);
           echo '</pre>';*/
            if(count($room) == $nights){
                $available_rooms = RoomAllocation::join('room_details', 'room_details.id', '=', 'room_allocations.room_details_id')->where('room_allocations.availability_id', '=', $room[0]['id'])->where('room_allocations.status', 1)->get()->all();
                if(!empty($available_rooms)){
                $html .= '<input type="hidden" name="nights" value="'.$nights.'" /><tr><td><label class="bookchk"><input type="checkbox" name="room_id" value="'.$room[0]['room_id'].'"><span class="checkmark"></span></label></td><td>'.$room[0]['name'].'</td><td>Avialable</td><td><input type="hidden" name="price" id="price_'.$room[0]['room_id'].'" value="'.$room[0]['price'].'" />'.getPrice($room[0]['price']).'</td><td><select class="form-control" name="room_no" id="room_no_'.$room[0]['room_id'].'">';
                    $availability_id = '';    
                    foreach($available_rooms as $arm){
                        $availability_id = $arm->availability_id;
                        $html .= '<option value="'.$arm->room_details_id.'">'.$arm->room_no.' ('.$arm->floor_no.')</option>';     
                    }
                $html .= '</select><input type="hidden" name="allocation_no" id="allocation_no_'.$room[0]['room_id'].'" value="'.$availability_id.'" /></td></tr>';
                }
            }
        }
        //exit();
        echo $html;
        //echo json_encode(array('rooms' => $rooms, 'nights' => $nights, 'available_rooms' => $available_rooms));

    }

    public function room_add(Request $request){
        $room_id = $request->room_id;
        $client_id = $request->client_id;
        $nights = $request->nights;
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        $hotel_id = $request->hotel_id;
        $price = $request->price;
        $room = Rooms::find($room_id);
        $hotel = Hotels::find($hotel_id);
        $base_price = $room->base_price;
        $base_price = $room->base_price;
        $adult_capacity = $room->adult_capacity;
        $child_capacity = $room->child_capacity;
        $check_in = $hotel->check_in;
        $check_out = $hotel->check_out;
        $total_price = $price*$nights;
        $allocation_no = $request->allocation_no;
        $allocation_no = $allocation_no - 1;
        $allocation_arr = array();
        for ($i=0; $i < $nights; $i++) { 
            if($i == 0){
                 $allocation_no = $allocation_no + $i;
            }else{
                 $allocation_no = $allocation_no + 1;
            }
            array_push($allocation_arr, $allocation_no);
        }
        //exit();
        $cart = new Cart;
        $cart->hotel_id = $hotel_id;
        $cart->room_id = $room_id;
        $cart->user_id = $client_id;
        $cart->nights = $nights;
        $cart->base_price = $base_price;
        $cart->price = $price;
        $cart->total_price = $total_price;
        $cart->start_date = $start_date;
        $cart->end_date = $end_date;
        $cart->quantity_adults = $adult_capacity;
        $cart->quantity_child = $child_capacity;
        $cart->check_in = $check_in;
        $cart->check_out = $check_out;
        $cart->room_details_id = $request->room_no;
        $cart->availability_ids = implode(",", $allocation_arr);
        $cart->save();
        $roomdetail = RoomDetail::find($cart->room_details_id);
        $availability_ids = $cart->availability_ids;
        $availability_ids_arr = explode(",", $availability_ids);
        for ($j=0; $j < count($availability_ids_arr) ; $j++) {
             $roomallocation = RoomAllocation::where('availability_id', '=', $availability_ids_arr[$j])->where('room_details_id', '=', $cart->room_details_id)->get()->first();
             $roomallocation->status = 0;
             $roomallocation->save(); 
        }

        $html = '';
        $html .= '<tr><td>'.$room->name.'</td><td><span class="highlight_data">'.$roomdetail->room_no.'</span></td><td>'.getPrice($cart->price).'</td><td><a href="javascript:void(0);" title="Delete" onclick="delete_room('.$cart->id.')" class="room_delete"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
        //echo $html;
        $c_html = '';
        $cart_data = Cart::where('user_id', '=', $client_id)->get()->all();
        $c_html .= '<h3>Invoice</h3>
                <div class="bookingtable">
                  <table class="table table-bordered table-responsive">
                    <thead>
                      <tr>
                        <th>Room</th>
                        <th>Nights</th>
                        <th>Unit Price</th>
                        <th>Line Total</th>
                      </tr>
                    </thead>
                    <tbody>';
                    $tot_price = 0;
                    foreach($cart_data as $c_data){
                     $cart_room = Rooms::find($c_data->room_id);
                      $c_html .= '<tr>
                        <td><input type="hidden" name="cartid[]" value="'.$c_data->id.'" />'.$cart_room->name.'</td>
                        <td>'.$c_data->nights.'</td>
                        <td>'.getPrice($c_data->price).'</td>
                        <td>'.getPrice($c_data->total_price).'</td>
                      </tr>';
                      $tot_price += floatval($c_data->total_price);
                    }
                    $c_html .= '</tbody>
                  </table>
                </div>
                <div class="subtotal_bottom">
                  <div class="spanbox">
                    <span class="sb_left">Subtotal:</span>
                    <span class="sb_right">'.getPrice($tot_price).'</span>
                  </div>
                  <div class="spanbox">
                    <span class="sb_left"><strong>Payable Amount:</strong></span>
                    <span class="sb_right"><strong>'.getPrice($tot_price).'</strong></span>
                  </div>
                </div>';
        echo json_encode(array('cart_html' => $html, 'c_html' => $c_html, 'tot_price' => $tot_price,));


    }

    public function show_booking($id){
        return view('frontend.hotelier.singlebooking', compact('id'));
    }

    public function add_Booking(){
        $user = auth('web')->user();
         $config = new \Braintree_Configuration([
            'environment' => 'sandbox',
            'merchantId' => 'kp8tw949t876r8gv',
            'publicKey' => 'qh72yshrh9jzd8zh',
            'privateKey' => '36ce8b294f9d0d4ec81df1fe67d11dce'
            ]);
         
         $gateway = new \Braintree\Gateway($config);

        $clientToken = $gateway->clientToken()->generate();
        $bookings = new \StdClass();
        $bookings->hotels = Hotels::where('user_id', $user->id)->get()->all();
        $bookings->users = User::where('role', 2)->get()->all();
        return view('frontend.hotelier.add_booking', compact('bookings','clientToken'));
       
    }

    public function booking_payment_process(Request $request){
        $user_id = $request->user_id;
        $carts = Cart::where('user_id', '=', $user_id)->get()->all();
        print_r($carts);

    }

    public function invoice_list(){
        $user = auth('web')->user();
        $hotels = Hotels::where('user_id', $user->id)->get()->all();
        if(!empty($hotels)){
            foreach($hotels as $hkey => $hdata){
                $bookings[] = Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'bookings.hotel_id', '=', 'hotels_translations.hotels_id')->where('bookings.hotel_id', '=', $hdata->id)
              ->get()->all();
            }
            return view('frontend.hotelier.invoice', compact('bookings'));
        }else{
            abort(404);
        }
    }

    public function invoice_generate($id){
        $booking = Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels_translations.hotels_id', '=', 'hotel_addresses.hotel_id')->where('bookings.id', '=', $id)
    ->get()->first();
        $tot_booking = BookingItem::where('booking_id', '=', $id)->get()->count();
        $users = get_user_details($booking->booked_user);
        $data = compact('booking', 'users', 'tot_booking');
        $pdf = PDF::loadView('frontend.invoice', $data);
        return $pdf->stream();
        //$pdf->save(public_path().'/storage/invoice.pdf');
        //return $pdf->download('invoice.pdf');
    }

    public function room_del(Request $request){
        $carts = Cart::find($request->cart_id);
        $availability_ids = $carts->availability_ids;
        $room_details_id = $carts->room_details_id;
        $availability_ids_arr = explode(", ", $availability_ids);
        for ($j=0; $j < count($availability_ids_arr) ; $j++) {
             $roomallocation = RoomAllocation::where('availability_id', '=', $availability_ids_arr[$j])->where('room_details_id', '=', $room_details_id)->get()->first();
             $roomallocation->status = 1;
             $roomallocation->save(); 
        }
        Cart::where('id', $request->cart_id)->delete();
        $cart_data = Cart::where('user_id', '=', $request->client_id)->get()->all();
        $c_html = '';
        $html = '';
        if(!empty($cart_data)){
        foreach($cart_data as $html_data){
        $cart_room = Rooms::find($html_data->room_id);
        $roomdetail = RoomDetail::find($html_data->room_id);
        $html .= '<tr><td>'.$cart_room->name.'</td><td><span class="highlight_data">'.$roomdetail->room_no.'</span></td><td>'.getPrice($html_data->price).'</td><td><a href="javascript:void(0);" title="Delete" onclick="delete_room('.$html_data->id.')" class="room_delete"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
            }
            $c_html .= '<h3>Invoice</h3>
                <div class="bookingtable">
                  <table class="table table-bordered table-responsive">
                    <thead>
                      <tr>
                        <th>Room</th>
                        <th>Nights</th>
                        <th>Unit Price</th>
                        <th>Line Total</th>
                      </tr>
                    </thead>
                    <tbody>';
                    $tot_price = 0;
                    foreach($cart_data as $c_data){
                     $cart_room = Rooms::find($c_data->room_id);
                      $c_html .= '<tr>
                        <td>'.$cart_room->name.'</td>
                        <td>'.$c_data->nights.'</td>
                        <td>'.getPrice($c_data->price).'</td>
                        <td>'.getPrice($c_data->total_price).'</td>
                      </tr>';
                      $tot_price += floatval($c_data->total_price);
                    }
                    $c_html .= '</tbody>
                  </table>
                </div>
                <div class="subtotal_bottom">
                  <div class="spanbox">
                    <span class="sb_left">Subtotal:</span>
                    <span class="sb_right">'.getPrice($tot_price).'</span>
                  </div>
                  <div class="spanbox">
                    <span class="sb_left"><strong>Total:</strong></span>
                    <span class="sb_right"><strong>'.getPrice($tot_price).'</strong></span>
                  </div>
                </div>';
            }
        echo json_encode(array('cart_html' => $html, 'c_html' => $c_html));

    }

    public function booking_cancelation(Request $request){
        $booking_id = $request->booking_id;
        $booking = Booking::find($booking_id);
        $carttotal = $booking->carttotal;
        $user_id = $booking->user_id;
        $cancelation = new Cancelation;
        $cancelation->booking_id = $booking_id;
        $cancelation->user_id = $user_id;
        $cancelation->payable_amount = $carttotal;
        $cancelation->refund_percent = 100;
        $cancelation->reason = $request->reason;
        $cancelation->save();
        $bookings = Booking::join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->where('bookings.id', '=', $booking_id)->get()->first();
        $availability_ids = $bookings->availability_ids;
        $availability_ids = explode(",", $availability_ids);
        for ($i=0; $i < count($availability_ids) ; $i++) {
            $roomavailability = RoomAvailability::find($availability_ids[$i]);
            $availabe_rooms = $roomavailability->availabe_rooms;
            $roomavailability->availabe_rooms = $availabe_rooms + 1;
            $roomavailability->save();
            $room_details_id = $bookings->room_details_id;  
            //$roomallocation = RoomAllocation::where('availability_id', '=', $availability_ids[$i])->where('room_details_id', '=', $room_details_id)->get()->first();
            //$roomallocation->status = 1;
            //$roomallocation->save();
        }
        $booking->status = 2;
        $booking->save();
        //print_r($request->all());
        $user = get_user_details($user_id);
        $bookingitem = BookingItem::where('booking_id', '=', $booking_id)->get()->first();
        $room = Rooms::find($bookingitem->room_id);
        $hotel = Hotels::find($bookingitem->hotel_id);
         
        $e_data = [
            'booking_id' => $booking_id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'room' => $room->name,
            'hotel' => $hotel->hotels_name,
        ];
        if (is_live()){
          Mail::send('emails.cancel', ['e_data' => $e_data], function ($m) use ($e_data) {
            $m->from('no-reply@fitser.com', get_option('blogname'));
            $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Booking Cancellation');
          });
        }
        echo json_encode(array('status' => 1));
    }

}
