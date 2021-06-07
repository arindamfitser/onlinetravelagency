<?php
namespace App\Http\Controllers;
use App\Hotels;
use App\HotelNewEntry;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\RoomCount;
use App\Booking;
use App\BookingItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProfileController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request){
        $user = auth('web')->user();
        if($user->role == '1'):
            //$hotels = Hotels::where('user_id', '=', $user->id)->get();
            $hotel                  = Hotels::where('user_id', '=', $user->id)->first();
            if (!empty($hotel)) :
                $room               = new \StdClass();
                $room->hotel_id     = $hotel->id;
                $room->hotel_token  = $hotel->hotel_token;
                $room->rooms        = Rooms::where('hotel_token', $hotel->hotel_token)->get();
            else :
                $room = new \StdClass();
            endif;
            return view('frontend.hotelier.dashboard', compact('room', 'hotel'));
        else:
            return view('frontend.customer.dashboard');
        endif;  
    }
    public function getAvailableRooms(Request $request){
        $room   = Rooms::find($request->roomId);
        print json_encode(array('success' => TRUE, 'available' => $room->room_capacity));
    }
    public function updateAvailableRooms(Request $request){
        $roomId     = $request->roomId;
        $dateRange  = explode(' - ', $request->dateRange);
        $cIn        = $request->fromDate;
        $cOut       = $request->toDate;
        $diff       = date_diff(date_create($cIn), date_create($cOut));
        $days       = $diff->format("%a");
        for($d = 0; $d <= $days; $d++):
            $strt   = date('Y-m-d', strtotime($cIn. ' + '. $d .' days'));
            $rc     = RoomCount::where('room_id', $roomId)->where('dt', $strt)->first();
            if(empty($rc)):
                RoomCount::create([
                    'room_id'   => $roomId,
                    'dt'        => $strt,
                    'count'     => $request->newAvailable
                ]);
            else:
                $r          = RoomCount::find($rc->id);
                $r->count   = $request->newAvailable;
                $r->save();
            endif;
        endfor;
        print json_encode(array('success' => TRUE));
    }
    public function calenderCallRoomAvailable(Request $request){
        $user       = auth('web')->user();
        $events     = array();
        $data       = array();
        $start      = $request->start;
        $end        = $request->end;
        if($request->booked == 'on'):
            $booking    = Booking::select('bookings.*', 'rooms.name', 'users.first_name', 'users.last_name')
                        ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
                        ->join('users', 'users.id', '=', 'bookings.user_id')
                        ->where('bookings.hotel_token', $request->hotel_token)
                        ->where('bookings.status', 1)
                        ->where('bookings.start_date', '>=', $start)
                        ->where('bookings.start_date', '<=', $end)
                        ->orderBy('bookings.id', 'ASC')->get();
            if (!empty($booking)) :
                foreach ($booking as $key => $book) :
                    $data                   = array();
                    $html                   = "";
                    $data['id']             = $book->id;
                    $data['start']          = $book->start_date;
                    $data['end']            = $book->end_date;
                    //$data['title']          = $book->first_name.' '.$book->last_name.', '.$book->id.' ('.$book->nights.' Nights)';
                    $data['title']          = $book->id;
                    $data['color']          = '#ec971f;';
                    $data['className']      = 'booked';
                    $html .='<div class="booking_tootip">';
                    $html .='<div class="pop_content">';
                    $html .='<div class="bitems_head"><span>'.$book->id.'</span></div>';
                    $html .='<div class="bitems_title"><span>'.$book->first_name.' '.$book->last_name.'</span></div>';
                    $html .='<div class="bitems_sub"><span>'.$book->name.'</span></div>';
                    $html .='<div class="bitems_sub"><span>'.$book->room_type.'</span></div>';
                    $html .='<div class="bitems"><span>Check in</span> - '.date("d M, Y", strtotime($book->start_date)).'</div>';
                    $html .='<div class="bitems"><span>Check out</span> - '.date("d M, Y", strtotime($book->end_date)).'</div>';
                    $html .='<div class="bitems"><span>Nights</span> : '.$book->nights.'</div>';
                    // $html .='<div class="bitems_btn">
                    //             <a href="'.URL('users/view_booking/'.$book->booking_id).'">Details</a> | 
                    //             <a href="'.URL('users/invoice/'.$book->booking_id).'">Invoice</a>
                    //         </div>';
                    $html .='</div>'; 
                    $html .='</div>';  
                    $data['description']    = $html;
                    array_push($events, $data); 
                endforeach;
            endif;
        endif;

        // $cIn    = date('Y-m-d');
        // $cOut   = date('Y').'-12-31';
        // $diff   = date_diff(date_create($cIn), date_create($cOut));
        // $days   = $diff->format("%a");
        // for($d = 0; $d <= $days; $d++):
        //     $data   = array();
        //     $strt   = date('Y-m-d', strtotime($cIn. ' + '. $d .' days'));
        //     $end    = date('Y-m-d', strtotime($cIn. ' + '. ($d+1) .' days'));
        //     $chk    = DB::table('booking_items')->select('id', 'quantity_room')->where('room_id', $request->roomType)->where('status', 1)
        //             ->where('check_in', '>=', $strt)->where('check_out', '<=', $end)->get();
        //     $r          = Rooms::find($request->roomType);
        //     $rc         = RoomCount::where('room_id', $request->roomType)->where('dt', $strt)->first();
        //     $booked     = 0;
        //     $avlbl      = (!empty($rc)) ? $rc->count : $r->room_capacity;;
        //     if(!empty($chk)):
        //         foreach($chk as $c):
        //             $booked += $c->quantity_room;
        //         endforeach;
        //         $avlbl  -= $booked;
        //     endif;
        //     $data['id']             = $r->id;
        //     $data['start']          = $strt;
        //     $data['end']            = $strt;
        //     $data['key']            = $avlbl;
        //     $data['price']          = $r->base_price;
        //     if($avlbl > 0):
        //         $data['title']      = $r->name;
        //         $data['color']      = '#6cdda2;';
        //         $data['className']  = 'available';
        //     else:
        //         $data['title']      = 'Unavailable';
        //         $data['color']      = '#f69dcd;';
        //         $data['className']  = 'unavailable';
        //     endif;
        //     $data['description']    = '<div class="pop_content"><div class="popup_single_content">'.$r->name.' available rooms <span>('.$avlbl.')</span></div></div>';
        //     $data['info']           = '';
        //     array_push($events, $data);
        // endfor;
        $response["events"]=$events;
        echo  json_encode($response);
        exit;
    }
    public function calendarDateDetails(Request $request){
        $strt   = date_format(date_create($request->start), 'Y-m-d');
        $end    = date('Y-m-d', strtotime($strt. ' + 1 days'));
        $html   = '';
        $rooms  = Rooms::where('availability', 1)->where('hotel_token', $request->hotel_token)->get();
        if(!empty($rooms)):
            foreach($rooms as $r):
                $rc         = RoomCount::where('room_id', $r->id)->where('dt', $strt)->first();
                $booked     = 0;
                $avlbl      = (!empty($rc)) ? $rc->count : $r->room_capacity;
                $chk        = DB::table('booking_items')->select('id', 'quantity_room')->where('room_id', $r->id)->where('status', 1)
                            ->where('check_in', $strt)->where('check_out', $end)->get();
                if(!empty($chk)):
                    foreach($chk as $c):
                        $booked += $c->quantity_room;
                    endforeach;
                    $avlbl  -= $booked;
                endif;
                $html .='<div class="booking_tootip">';
                $html .='<div class="pop_content">';
                $html .='<div class="bitems_head"><span>Room : </span><b>'. $r->name .'</b></div>';
                //$html .='<div class="bitems_head"><span>Total : </span><b style="color:blue;">'. ($avlbl + $booked) .'</b></div>';
                $html .='<div class="bitems_head"><span>Total : </span><b style="color:blue;">'. $r->room_capacity .'</b></div>';
                $html .='<div class="bitems_head"><span>No. of Available Rooms : </span><b style="color:green;">'. $avlbl .'</b></div>';
                $html .='<div class="bitems_head"><span>Booked : </span><b style="color:red;">'. $booked .'</b></div>';
                $html .='</div>';
                $html .='</div>';
                $html .='<br/>';
            endforeach;
        endif;
        $bookings = BookingItem::select('booking_items.*', 'rooms.name')
                        ->join('rooms', 'rooms.id', '=', 'booking_items.room_id')
                        ->where('booking_items.hotel_token', '=', $request->hotel_token)
                        ->where('booking_items.status', '=', 1)
                        ->where('booking_items.start_date', '=', $strt)->get();
        if(!empty($bookings)):
            $html .='<br/>';
            foreach($bookings as $b):
                $html .='<div class="booking_tootip">';
                $html .='<div class="pop_content">';
                $html .='<div class="bitems_head"><span>Booking Id : </span><b>'. $b->booking_id .'</b></div>';
                $html .='<div class="bitems_head"><span>Room : </span><b>'. $b->quantity_room .' X '. $b->name .'</b></div>';
                $html .='<div class="bitems_head"><b>'. $b->start_date . ' - ' . $b->end_date .'</b></div>';
                $html .='</div>';
                $html .='</div>';
                $html .='<br/>';
            endforeach;
        endif;
        print json_encode(array('success' => TRUE, 'html' => $html, 'startDate' => $strt));
    }
    public function profile(){
        $user = auth('web')->user();
        if($user->role=='1'):
            return view('frontend.hotelier.profile');
        else:
            return view('frontend.customer.profile');
        endif;
    }
}