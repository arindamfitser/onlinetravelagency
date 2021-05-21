<?php
namespace App\Http\Controllers\Ajax;
use App\Hotels;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\RoomAvailability;
use App\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoomAllocation;
use Illuminate\Support\Facades\Storage;
class CartController extends Controller
{
  public function __construct()
  {
        //$this->middleware('auth');
  }
  public function index(Request $request){
    $user = auth('web')->user();
    $html = '';
    $item = '';
    $hotelhtml = '';
    $total_price = 0;
    $cartids= array();
    $abilities= RoomAvailability::where('room_id', '=', $request->room_id)
    ->where('hotel_id', '=', $request->hotel_id)
    ->whereBetween('date', array($request->start_date, $request->end_date))
    ->get()->all();
    array_pop($abilities);                          
    $nights = '';
    $price=0;
    $avl=array();
    $avrdid=array();
    foreach ($abilities as $key => $value){
      $avl[]=$value['id'];
      $allocation = RoomAllocation::where('availability_id', '=', $value['id'])->where('status', '=',1)->get()->first();
      $avrdid=$allocation['room_details_id'];
      $price= $price+$value['price'];
      $nights .= '<div class="nght_show"><span>'.$value['date'].'</span><div class="room_price">'.getPrice($value['price']).'</div></div><div>';
    }
    $cart = new Cart;
    $cart->hotel_id = $request->hotel_id;
    $cart->room_id = $request->room_id;
    $cart->user_id = $request->user_id;
    $cart->base_price = $request->base_price;
    $cart->price = $request->price;
    $cart->total_price = $price;
    $cart->nights = $request->nights;
    $cart->availability_ids = implode(',', $avl);
    $cart->room_details_id = $avrdid;
    $cart->check_in = $request->check_in;
    $cart->check_out = $request->check_out;
    $cart->start_date = $request->start_date;
    $cart->end_date = $request->end_date;
    $cart->quantity_adults = intval($request->quantity_adults);
    $cart->quantity_child = intval($request->quantity_child);
    $cart->deviceid = $request->deviceid;
    $cart->save();
    $cart_id = $cart->id;
    if($cart_id){
      $rooms = Rooms::where('id', '=', $request->room_id)->get()->first();       
      $cartids[]=$cart_id;
      $rooms = Rooms::where('id', '=', $request->room_id)->get()->first();  
      $nights .= '';
      $hotels = Hotels::where('id', '=' , $request->hotel_id)->get()->first();
      $hotelhtml .= '<div class="hotelinfo">';
      $hotelhtml .= '<div class="hotelimg">';
      if(file_exists(URL(Storage::disk('local')->url($hotels->featured_image)))) :
        $hotelhtml .= '<img src="'.URL(Storage::disk('local')->url($hotels->featured_image)).'" width="75px" />';
      else:
        $hotelhtml .= '<img src="'.URL('/public/frontend/images/timthumb.jpg').'" width="75px" />';
      endif;
      $hotelhtml .= '</div>';
      $hotelhtml .= '<div class="hoteldata">';
      $hotelhtml .= '<h3>'.$hotels['hotels_name'].'</h3>';
      $hotelhtml .= '<p>'.$hotels['hotels_name'].'</p>';
      $hotelhtml .= '</div>';
      $hotelhtml .= '</div>';
      $html .= '<div class="item">';
      $html .= '<div class="roomde">';
      $html .= '<h3><a href="#"><strong><i class="fa fa-user"></i> '.$rooms['name'].'Room '.(intval($request->quantity_adults) +intval($request->quantity_child)).' Guests';
      $html .= ' '.$request->nights.($request->nights>1?'Nights':'Night').'  </strong></a> </h3>';
      $html .= '</div>';
      $html .= '<div class="editlinks">';
      $html .= '<a href="javascript:void(0)" class="remove_cart" id="'.$cart_id.'"><i class="fa fa-remove"></i>Remove</a>';
      $html .= '</div>';
      $html .=  $nights;
      $html .= '<h4><strong style="color: #110591;" class="float-right">'.getPrice($price).'</strong></h4>';
      $html .= '</div>';
      $item .='<div id="item"'.$cart_id.'>';
      $item .='<input type="hidden" id="cartid" name="cartid[]" value="'.$cart_id.'">';
      $item .='<input type="hidden" id="hotelid" name="hotelid[]" value="'.$rooms['hotel_id'].'">';
      $item .='<input type="hidden" id="roomid" name="roomid[]" value="'.$rooms['room_id'].'">';
      $item .='<input type="hidden" id="nights" name="nights[]" value="'.$request->nights.'">';
      $item .='<input type="hidden" id="itemprice" name="itemprice[]" value="'.$price.'">';
      $item .= '</div>';
      $total_price = $total_price +$price;
      $data['status']= 'success';
    }else{
      $data['status']= 'error';
    }
    $data['status']= $html;
    $data['view']= $html;
    $data['hotelinfo']= $hotelhtml;
    $data['item_price']= $total_price;
    $data['cartids']= $cartids;
    $data['cartitem']= $item;
    $response["data"]=$data;
    echo  json_encode($response);
    exit;
  } 
  public function getCartdata(Request $request){
    if($request->user_id > 0 ){
      $cartItems = Cart::where('user_id', '=', $request->user_id)->get()->all();
    }else{
      $cartItems = Cart::where('deviceid', '=', $request->deviceid)->get()->all();
    }
    $html = '';
    $hotelhtml = '';
    $caitem = '';
    $total_price = 0;
    $cartids= array();
    if($cartItems){
      $harr=array();
      foreach ($cartItems as $key => $item) {
        $cartids[]=$item['id'];
        $rooms = Rooms::where('id', '=', $item['room_id'])->get()->first();
        $abilities= RoomAvailability::where('room_id', '=', $item['room_id'])
        ->where('hotel_id', '=', $item['hotel_id'])
        ->whereBetween('date', array($item['start_date'], $item['end_date']))
        ->get()->all();
        array_pop($abilities);
        $nights = '';
        $price=0;
        foreach ($abilities as $key => $value) {
          $price= $price+$value['price'];
          $nights .= '<div class="nght_show"><span>'.$value['date'].'</span><div class="room_price">'.getPrice($value['price']).'</div></div><div>';
        }
        $nights .= '';
      
        $hotels = Hotels::where('id', '=' ,$item['hotel_id'])->get()->first();
    
        if (!in_array($item['hotel_id'], $harr)) {
          $harr[]=$item['hotel_id'];
          $hotelhtml .= '<div class="hotelinfo">';
          $hotelhtml .= '<div class="hotelimg">';
          if(file_exists(URL(Storage::disk('local')->url($hotels->featured_image)))) :
            $hotelhtml .= '<img src="'.URl(Storage::disk('local')->url($hotels['featured_image'])).'" width="75px" />';
          else:
            $hotelhtml .= '<img src="'.URL('/public/frontend/images/timthumb.jpg').'" width="75px" />';
          endif;
          $hotelhtml .= '</div>';
          $hotelhtml .= '<div class="hoteldata">';
          $hotelhtml .= '<h3>'.$hotels['hotels_name'].'</h3>';
          $hotelhtml .= '<p>'.$hotels['hotels_name'].'</p>';
          $hotelhtml .= '</div>';
          $hotelhtml .= '</div>';
        }
        $caitem .='<div id="item'.$item['id'].'">';
        $caitem .='<input type="hidden" id="cartid" name="cartid[]" value="'.$item['id'].'">';
        $caitem .='<input type="hidden" id="hotelid" name="hotelid[]" value="'.$item['hotel_id'].'">';
        $caitem .='<input type="hidden" id="roomid" name="roomid[]" value="'.$item['room_id'].'">';
        $caitem .='<input type="hidden" id="nights" name="nights[]" value="'.$item['nights'].'">';
        $caitem .='<input type="hidden" id="itemprice" name="itemprice[]" value="'.$price.'">';
        $caitem .= '</div>';
        $html .= '<div class="item">';
        $html .= '<div class="roomde">';
        $html .= '<h3><a href="#"><strong><i class="fa fa-user"></i>'.$rooms['name'].' Room '.(intval($item['quantity_adults']) +intval($item['quantity_child'])).' Guests';
        $html .=' '. $item['nights'].($item['nights']>1?'Nights':'Night').' </strong></a></h3>';
        $html .= '</div>';
        $html .= '<div class="editlinks">';
        $html .= '<a href="javascript:void(0);" class="remove_cart" id="'.$item['id'].'"><span class="loadSpin hide" id="loadSpin_'.$item['id'].'"><i class="fa fa-spinner fa-spin"></i></span>Remove</a>';
        $html .= '</div>';
        $html .=  $nights;
        $html .= '<h4><strong class="float-right" style="color: #110591;">'.getPrice($price).'</strong></h4>';
        $html .= '</div>'; 
        $total_price = $total_price +$price;
      }
      $data['status']= 'success';
    }else{
      $data['status']= 'error';
    }
    $data['view']= $html;
    $data['hotelinfo']= $hotelhtml;
    $data['item_price']= $total_price;
    $data['cartids']= $cartids;
    $data['cartitem']= $caitem;
    $response["data"]=$data;
    echo  json_encode($response);
    exit;
  } 
  public function  doDeleteCartItem(Request $request){
    $del = Cart::where('id', $request->cart_id)->delete();
    if ($del) {
      echo 'Item Successfully Deleted ';
    }
    exit;
  }
}
