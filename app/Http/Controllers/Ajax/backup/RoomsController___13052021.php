<?php

namespace App\Http\Controllers\Ajax;
use App\Hotels;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\RoomAvailability;
use App\Booking;
use App\BookingItem;
use App\User;
use App\RoomAllocation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RoomsController extends Controller
{
 public function __construct()
 {
  $this->middleware('auth');
}

public function roomAvailable(Request $request){
           //var_dump($request->all());
 $user = auth('web')->user();
 if($request->roomType=="all"){
  if($request->available=='off'){ 
   $dates =  RoomAvailability::where('hotel_id', '=', $request->hotel_id)->where('availability', '!=', '1')->get();     
 }else if($request->notavailable=='off'){
   $dates =  RoomAvailability::where('hotel_id', '=', $request->hotel_id)->where('availability', '!=', '2')->get();
 }else{
   $dates =  RoomAvailability::where('hotel_id', '=', $request->hotel_id)->get();
 }
}else{
  if($request->available=='off'){ 
   $dates =  RoomAvailability::where('hotel_id', '=', $request->hotel_id)->where('room_id', '=', $request->roomType)->where('availability', '!=', '1')->get();     
 }else if($request->notavailable=='off'){
   $dates =  RoomAvailability::where('hotel_id', '=', $request->hotel_id)->where('room_id', '=', $request->roomType)->where('availability', '!=', '2')->get();
 }else{
   $dates =  RoomAvailability::where('hotel_id', '=', $request->hotel_id)->where('room_id', '=', $request->roomType)->get();
 }
}

$events = array();
$data=array();
 if($request->booked!='off'){ 
    $booking = Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status', 'bookings.id as booked_id')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->where('bookings.hotel_id', '=', $request->hotel_id)->get()->all();;
     
    if ($booking){
      foreach ($booking as $key => $book) {
        $bookrooms= Rooms::where('id', '=',$book->room_id)->get()->first();
        $html="";
        $user = User::find($book->booked_user);
        $data['id'] = $book->id;
        $data['start'] =$book->start_date;
        $data['end'] = $book->end_date;
        $data['key'] = 'Booked';
        $data['price'] = '';
        $data['title'] = $user['first_name'].' '.$user['last_name'].' ID '.$book->id.' ('.$book->nights.' Nights)';
        $data['color'] = '#ec971f;';
        $data['className'] = 'booked';
       
        $html .='<div class="booking_tootip">';
        $html .='<h2>';
        $html .='</h2>';
        $html .='<div class="pop_content">';
         $html .='<div class="bitems_head"><span>'.$book->id.'</span></div>';
         $html .='<div class="bitems_title"><span>'.$user['first_name'].' '.$user['last_name'].'</span></div>';
         $html .='<div class="bitems_sub"><span>'.$bookrooms['name'].'</span></div>';
          $html .='<div class="bitems"><span>Check in</span> -'.date("d/M/Y", strtotime($book->start_date)).'</div>';
          $html .='<div class="bitems"><span>Check out</span> - '.date("d/M/Y", strtotime($book->end_date)).'</div>';
          $html .='<div class="bitems"><span>Nights</span>  '.$book->nights.'</div>';
         $html .='<div class="bitems"><span>Guests</span>2</div>';
         $html .='<div class="bitems_btn"><a href="'.URL('users/view_booking/'.$book->booked_id).'">Details</a><a href="'.URL('users/invoice/'.$book->booked_id).'">Invoice</a></div>';
        $html .='</div>'; 
        $html .='</div>';  
        $data['description'] = $html;
        $data['info'] = 'booked';

        array_push($events, $data); 
      }
    }
}


foreach ($dates as $dt) {
  $rooms= Rooms::where('id', '=',$dt->room_id)->get()->first();
  $allocations = RoomAllocation::select('*', 'room_details.*', 'room_allocations.id as raid')->join('room_details', 'room_allocations.room_details_id', '=', 'room_details.id')->where('room_allocations.availability_id', '=', $dt->id)->get()->all();
  $checkbox='';
  foreach ($allocations as $key => $value) {
    if($value->status==1){
       $checkbox .='<li><input type="checkbox" value="'.$value->raid.'_'.$value->availability_id.'_'.$value->room_details_id.'" name="rooms[]" id="'.$value->raid.'_'.$value->availability_id.'_'.$value->room_details_id.'">'.$value->floor_no.' '.$value->room_no.'<span ><i class="fa fa-check" ></i></span></li>';
    }else{
       $checkbox .='<li><input type="checkbox" value="'.$value->raid.'_'.$value->availability_id.'_'.$value->room_details_id.'" name="rooms[]" id="'.$value->raid.'_'.$value->availability_id.'_'.$value->room_details_id.'">'.$value->floor_no.' '.$value->room_no.'<span><i class="fa fa-times" ></i></span></li>';
    }
  }
  $data['id'] = $dt->id;
  $data['start'] =$dt->date;
  $data['end'] = $dt->date;
  $data['key'] = $dt->availability;
  $data['price'] = $dt->price;
  if($dt->availability=='1'){
    $data['title'] = $rooms['name'];
    $data['color'] = '#6cdda2;';
    $data['className'] = 'available';
  }else if ($dt->availability=='2'){
    $data['title'] = 'Unavailable';
    $data['color'] = '#f69dcd;';
    $data['className'] = 'unavailable';
  }else if ($dt->availability=='3') {
    $data['title'] = 'Booked';
    $data['color'] = '#ec971f;';
    $data['className'] = 'booked';
  }else{
    $data['title'] = 'Not define';
    $data['color'] = '#CCC;';
    $data['className'] = 'not_define';  
  }
  $data['description'] = '<div class="pop_content"><div class="popup_single_content">'.$rooms['name'].' available rooms <span>('.$dt->availabe_rooms.')</span><div></div>';
  $data['info'] = $checkbox;
  array_push($events, $data); 
}

$response["events"]=$events;
echo  json_encode($response);
exit;

}  

public function fetchRoomsdate(Request $request){
  $dates =  RoomAvailability::where('room_id', '=', $request->room_id)->get();
  $events = array();
  $data=array();
  foreach ($dates as $dt) {

    $data['id'] = $dt->id;
    $data['title'] = $dt->availability;
    $data['start'] =$dt->date;
    $data['end'] = $dt->date;
    if($dt->availability=='Available'){
      $data['color'] = '#6cdda2;';
    }else{
      $data['color'] = '#f69dcd;';
    }
                // $data['tips']=$rooms->name;
    array_push($events, $data); 
  }

  $response["events"]=$events;
  echo  json_encode($response);
  exit;
}

public function getRooms(Request $request){
 $rooms= RoomDetail::where('room_id', '=', $request->room_id)->get()->all();
 if ($rooms) {
  foreach ($rooms as $key => $room) {
   echo '<option value="'.$room->id.'">'.$room->floor_no.'-'.$room->room_no.'</option>';
 }
}
exit;
}
public function getRoomtype(Request $request){

  $rooms= Rooms::where('hotel_id', '=',$request->hotel_id)->get()->all();
  if ($rooms) {
    foreach ($rooms as $key => $room) {
      echo '<option value="'.$room->id.'">'.$room->name.'</option>';
   }
  }
 exit;
 }

   public function addUpdateRoomAbility(Request $request){

        $date_from = strtotime($request->start);
        $date_to = strtotime($request->end);
            for ($i=$date_from; $i<=$date_to; $i+=86400) {
                //echo date("Y-m-d", $i).'<br />';
               if($id = RoomAvailability::where('room_id', '=', $request->room_id)->where('date', '=', date("Y-m-d", $i))->get()->first()['id']){
                        $allocation = RoomAllocation::where('availability_id', '=', $id)->get()->count();
                   if(!empty($request->roomd)){
                     foreach ($request->roomd as $key => $value) {
                        $rd=explode("_",$value);
                         $rAllocation = RoomAllocation::find($rd[0]);
                         if($request->title==1){
                          $rAllocation->status = 1;
                         }else{
                          $rAllocation->status = 0;
                         }
                         $rAllocation->save();
                     } 
                      $tr=count($request->roomd);
                      $roomavailability = RoomAvailability::find($id);
                      if($request->title==3){
                           //$roomavailability = RoomAvailability::find($id);
                           if((intval($roomavailability->availabe_rooms)-intval($tr))>=0){
                             $roomavailability->availabe_rooms = (intval($roomavailability->availabe_rooms)-intval($tr));
                           }
                           
                           $roomavailability->price = $request->price;
                           if($roomavailability->availabe_rooms==0){
                                  $roomavailability->availability = 3;
                           }
                      }else{
                           //$roomavailability = RoomAvailability::find($id);
                           if((intval($roomavailability->availabe_rooms)-intval($tr))<=$allocation){
                             $roomavailability->availabe_rooms = (intval($roomavailability->availabe_rooms)+intval($tr));
                           }
                           if($roomavailability->availabe_rooms>0){
                                  $roomavailability->availability = 1;
                           }
                           $roomavailability->price = $request->price;
                      }

                      $roomavailability->save();
                   }else{
                    
                    $allocations= RoomAllocation::where('availability_id', '=', $id)->get()->all();

                    if($allocations){
                     foreach ($allocations as $key => $value) {
                      $allc = RoomAllocation::find($value->id);
                       if($request->title==1){
                         $allc->status=1;
                       }else{
                         $allc->status=0;
                       }
                       $allc->save();
                     } 
                    }
                    
                    $roomavailability = RoomAvailability::find($id);
                    $roomavailability->availability = $request->title;
                    if($request->title==1){
                         $roomavailability->availabe_rooms=$allocation;
                       }else{
                         $roomavailability->availabe_rooms=0;
                       }
                    $roomavailability->price = $request->price;
                    

                   }
                  


               }else{

                  $roomdetail = RoomDetail::where('room_id', '=', $request->room_id)->get();
                  $roomability = new RoomAvailability;
                  $roomability->date = date("Y-m-d", $i);
                  $roomability->availability = $request->title;
                  $roomability->hotel_id = $request->hotel_id;
                  $roomability->room_id = $request->room_id;
                  $roomability->availabe_rooms =  $roomdetail->count();
                  $roomability->price = $request->price;
                  $roomability->save();
                  if($roomability->id){
                    foreach ($roomdetail->all() as $key => $value) {
                      $Roomallo=new RoomAllocation;
                      $Roomallo->availability_id=$roomability->id;
                      $Roomallo->room_details_id=$value->id;
                      if($request->title==1){
                         $Roomallo->status=1;
                       }else{
                         $Roomallo->status=0;
                       }
                      $Roomallo->save();
                    }
                  }

               } 
            }

        echo json_encode(array('success'=>true,'message'=> 'date added successfully!'));
        exit;
    } 
}
