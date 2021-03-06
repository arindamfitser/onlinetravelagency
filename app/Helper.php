<?php

use Illuminate\Support\Facades\Storage;
function langOption(){
	$data=Config::get('laravellocalization.supportedLocales');
	$lang = @\Session::get('language');
	foreach ($data as $key => $value) {
		$selected='';
		if($key==$lang){
			$selected='selected="selected"';
		}
		echo '<option value="'.$key.'" '.$selected.' >'.$value['name'].'</option>';
	}
}
function langlinkslist(){
	$data=Config::get('laravellocalization.supportedLocales');
	foreach ($data as $key => $value) {
		echo '<a href="">'.$value['name'].'</a>';
	}
}

function ota_title($sep,$title){
	//$title=$title;
	$ftitle='';
	if(Request::segment(1)!=""){
      $sndtitle = str_replace('-', ' ', Request::segment(1));
      $sndtitle= ucwords($sndtitle);
      $ftitle = $sndtitle.' '.$sep.' '.$title;
      if(Request::segment(2)!=""){
      	$ertitle = str_replace('-', ' ', Request::segment(2));
        $ertitle= ucwords($ertitle);
        $ftitle = $ertitle.' '.$ftitle;
      }
	}else{
		$ftitle = $title;
	}

	return $ftitle;
}

function dateDiff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}

function countryOption($id=''){
	$country = App\Countries::all();
	$html = '';
	$html .= '<option value="">---Select Country---</option>';
	foreach ($country as $key => $value) {
		if(isset($id)){
			if($value->id == $id){
				$selected='selected="selected"';
			}else{
				$selected='';
			}
		}
		$html .= '<option value="'.$value->id.'" '.$selected.' >'.$value->countries_name.'</option>';
	}
	echo $html;
}
function getStateID($string, $country_id){
	$data = App\StatesTranslation::where('states_name', '=' , $string)->get()->first();
	if(!empty($data)){
		$dataID = $data->states_id;
	}else{
		$state = new App\States;
		$state->states_name = $string;
		$state->countries_id = $country_id;
		$state->save();
		$dataID = $state->id;
	}
	return $dataID;
}

function getCountryID($string){
	$data = App\CountriesTranslation::where('countries_name', '=' , $string)->get()->first();
	if(!empty($data)){
		$dataID = $data->countries_id;
	}else{
		$country = new App\Countries;
		$country->countries_name = $string;
		$country->save();
		$dataID = $country->id;
	}
	return $dataID;
}
function getRegionID($string){
	$data = App\RegionsTranslation::where('regions_name', '=' , $string)->get()->first();
	if(!empty($data)){
		$dataID = $data->regions_id;
	}else{
		$region = new App\Regions;
		$region->regions_name = $string;
		$region->save();
		$dataID = $region->id;
	}
	return $dataID;
}

function getSpeciesID($string){
	$data = App\SpeciesTranslation::where('species_name', '=' , $string)->get()->first();
	if(!empty($data)){
		$dataID = $data->species_id;
	}else{
		$species = new App\Species;
		$species->species_name = $string;
		$species->save();
		$dataID = $species->id;
	}
	return $dataID;
}

function getAccomodationID($string){
	$data = App\AccommodationsTranslation::where('accommodations_name', '=' , $string)->get()->first();
	if(!empty($data)){
		$dataID = $data->accommodations_id;
		return $dataID;
	}
}

function getInspirationID($string){
	$data = App\InspirationsTranslation::where('inspirations_name', '=' , $string)->get()->first();
	if(!empty($data)){
		$dataID = $data->inspirations_id;
		return $dataID;
	}
}

function getExperiencesID($string){
	$data = App\ExperiencesTranslation::where('experiences_name', '=' , $string)->get()->first();
	if(!empty($data)){
		$dataID = $data->experiences_id;
		return $dataID;
	}
}

function speciesSave($string, $hotel_id){
	$speciesID = getSpeciesID($string);
	$hotelSpeciesRelation = new App\HotelSpeciesRelation;
	$hotelSpeciesRelation->hotel_id = $hotel_id;
	$hotelSpeciesRelation->species_id = $speciesID;
	$hotelSpeciesRelation->save();
}

function accommodationSave($string, $hotel_id){
	$accommodation_id = getAccomodationID($string);
	$hotelaccommodationRelation = new App\HotelAccommodationRelation;
	$hotelaccommodationRelation->hotel_id = $hotel_id;
	$hotelaccommodationRelation->accommodation_id = $accommodation_id;
	$hotelaccommodationRelation->save();
}

function inspirationSave($string, $hotel_id){
	$inspiration_id = getInspirationID($string);
	$hotelInspirationsRelation = new App\HotelInspirationsRelation;
	$hotelInspirationsRelation->hotel_id = $hotel_id;
	$hotelInspirationsRelation->inspirations_id = $inspiration_id;
	$hotelInspirationsRelation->save();
}

function experiencesSave($string, $hotel_id){
	$experiences_id = getExperiencesID($string);
	$HotelexperiencesRelation = new App\HotelExperiencesRelation;
	$HotelexperiencesRelation->hotel_id = $hotel_id;
	$HotelexperiencesRelation->experiences_id = $experiences_id;
	$HotelexperiencesRelation->save();
}


    //create header nav from header_nav array constants
function get_header_navigation($classes="", $id=""){
	$header_nav=Config::get('constants.header_nav');
	$pages = App\Pages::where('show_in', '=' , 'header')->where('status', '=' , 1)->get()->all();
		//var_dump($header_nav);
	$html='';
	$html .='<ul class="'.$classes.'" id="'.$id.'">';
	
	if(!empty($header_nav)){
		$active_slug= Request::segment(1);
		foreach ($header_nav as $key => $value) {
			$selected= ($active_slug==$key ? ' class="active"' : ' ');
			if($key != 'journal'){
				$html .='<li><a href="'.url($key).'" '.$selected.' >'.$value.'</a></li>';
			}else{
				$html .='<li><a href="javascript:void(0);" '.$selected.' >'.$value.'</a></li>';
			}
		}
	}
	
	if(!empty($pages)){
    	foreach ($pages as $key => $value) {
			$selected= ($active_slug==$value["page_slug"] ? ' class="active"' : ' ');
			$html .='<li><a href="'.url($value["page_slug"]).'" '.$selected.' >'.$value["page_title"]. '</a></li>';
    	}
	  }
	  $html .='</ul>';
	return $html;
  }

    //Create Footer nav from admin
function get_footer_navigation($classes="", $id=""){
	$header_nav=Config::get('constants.header_nav');
	$pages = App\Pages::where('show_in', '=' , 'footer')->where('status', '=' , 1)->get()->all();
	$active_slug= Request::segment(1);
	$html='';
	$html .='<ul class="'.$classes.'" id="'.$id.'">';
	if(!empty($pages)){
    	foreach ($pages as $key => $value){
    				  $selected= ($active_slug==$value["page_slug"] ? ' class="active"' : ' ');
    			      $html .='<li><a href="'.url($value["page_slug"]).'" '.$selected.' >'.$value["page_title"].'</a></li>';
    	}
	 }
		$html .='</ul>';
	   return $html;
}

    //check slug exist in header_nav constants
function is_nav($slug){
	$header_nav=Config::get('constants.header_nav');
	if(array_key_exists($slug, $header_nav)){
		return true;
	}
}

function is_slug($slug){
	$active_slug= Request::segment('1');
}

function split_name($name) {
	$name = trim($name);
	$last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
	$first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
	return array($first_name, $last_name);

}


function createSlug($str, $delimiter = '-'){
	$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
	return $slug;
} 

function hotelSlugExists($slug){
	$data = App\HotelsTranslation::where('hotels_slug', '=' , $slug)->get()->first();
	if(!empty($data)){
		return true;
	}else{
		return false;
	}
}

function emailExists($email){
	$data = App\User::where('email', '=' , $email)->get()->first();
	if(!empty($data)){
		return $data->id;
	}
}

function regionOption($id=''){
	$region = App\Regions::all();
	$html = '';
	$html .= '<option value="">---Select---</option>';
	foreach ($region as $key => $value) {
		if(isset($id)){
			if($value->id == $id){
				$selected='selected="selected"';
			}else{
				$selected='';
			}
		}
		$html .='<option value="'.$value->id.'" '.$selected.' >'.$value->regions_name.'</option>';
	}
	echo $html;
}

function stateOption($id=''){
	$states = App\States::all();
	$html = '';
	$html .= '<option value="">---Select---</option>';
	foreach ($states as $key => $value) {
		if(isset($id)){
			if($value->id == $id){
				$selected='selected="selected"';
			}else{
				$selected='';
			}
		}
		$html .= '<option value="'.$value->id.'" '.$selected.' >'.$value->states_name.'</option>';
	}
	echo $html;
}

function get_option($option){
	$options = App\Options::where('option_name', '=', $option)->get()->first();
	if(!empty($options )){
		return $options->options_value;
	}
}

function getCatByID($id){
	$room_cat = App\RoomCategory::where('id', $id)->get()->first();
	return $room_cat->name; 
}

function get_amenities($room_id){
	$amenities = App\AmenitiesTranslation::join('rooms_amenities', 'amenities_translations.amenities_id', '=', 'rooms_amenities.amenities_id')
	->where('rooms_amenities.room_id', '=', $room_id)
	->get()->all();
	return $amenities;
}

function get_loggedin_id(){
	$user = auth('web')->user();
	if($user){
		return $user['id'];
	}else{
		return 0;
	}
}

function getPrice($price){
	if($price!=""){
		return $pdiv= '<span class="curency">'.getCurrency().'</span><span class="price">'.number_format((float)$price, 2, '.', '').'</span>';
	}else{
		return $pdiv= '<span class="curency">'.getCurrency().'</span><span class="price">0.00</span>';
	}
}

function getCurrency(){
   return get_option('currency');
}

function imageUrl($path, $width = NULL, $height = NULL,$quality=NULL,$crop=NULL) {

	if(!$width && !$height) {
		$url = env('IMAGE_URL') . $path;
	} else {
		$url = url('/') . '/timthumb.php?src=' . env('IMAGE_URL') . $path;
		if(isset($width)) {
			$url .= '&w=' . $width; 
		}
		if(isset($height) && $height>0) {
			$url .= '&h=' .$height;
		}
		if(isset($crop))
		{
			$url .= "&zc=".$crop;
		}
		else
		{
			$url .= "&zc=1";
		}
		if(isset($quality))
		{
			$url .='&q='.$quality.'&s=1';
		}
		else
		{
			$url .='&q=95&s=1';
		}
	}

	return $url;
}
function get_user_details($id){
	$user = App\User::where('id', $id)->first();
	return $user;
}
function get_rating_count($hotel_id, $rating){
	$reviews = App\Review::where('hotel_id', $hotel_id)->where('rating', $rating)->get();
	return count($reviews);
}
function get_randompass($limit=8){
  	if($limit){
  		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $limit);
  	}else{
  		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, 8);
  	}	 
  }

 function reduce_room($room_id,$date){
 	$dates =  App\RoomAvailability::where('room_id', '=', $room_id)->where('date', '=', $date)->get()->first();
 	if($dates){
 		if($dates['availabe_rooms']>0){
 			$availabe_rooms = intval($dates['availabe_rooms'])-1;
 			  App\RoomAvailability::where('room_id', $room_id)->where('date', $date)->update(['availabe_rooms' => $availabe_rooms]);
 			if($availabe_rooms==0){
 			  App\RoomAvailability::where('room_id', $room_id)->where('date', $date)->update(['availability' => 3]);	
 			}
 		}
 	}
 	return $dates['availabe_rooms'];
 } 
 function increment_room($room_id,$date){
 	$dates =  App\RoomAvailability::where('room_id', '=', $room_id)->where('date', '=', $date)->get()->first();
 	if($dates){
 			$availabe_rooms = intval($dates['availabe_rooms'])+1;
 			 App\RoomAvailability::where('room_id', $room_id)->where('date', $date)->update(['availabe_rooms' => $availabe_rooms]);
 	}
 	return $dates['availabe_rooms'];
 }
 function check_room_count($room_id,$date){
 	$dates =  App\RoomAvailability::where('room_id', '=', $room_id)
 									->where('date', '=', $date)
 									->where('availabe_rooms', '>=',1 )
 									->get()->first();
 	if($dates){
 		return true;
 	}else{
 		return false;
 	}								
 }

 
 function get_avatar(){
 	$user = auth('web')->user();
 	if($user){
 		$user = App\User::where('id', $user->id)->get()->first();
	   return $user->profile_image;
 	}
 }


 function getTransactionNoHash(){
         mt_srand((double)microtime()*10000);
         $charid = md5(uniqid(rand(), true));
         $c = unpack("C*",$charid);
         $c = implode("",$c);
         return substr($c,0,10);
 }
function pr($data, $action = TRUE){
	print "<pre>";
	print_r($data);
	if($action):
		die;
	endif;
}
function bookingdetailsHtml($id){
 	// $booking 		= App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status','bookings.created_at as created_at')
	//  ->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')
	//  ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
	//  ->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')
	//  ->join('hotel_addresses', 'hotels_translations.hotels_id', '=', 'hotel_addresses.hotel_id')
	//  ->where('bookings.id', '=', $id)->first();
	$booking 		= App\Booking::select('*', 'hotels.featured_image', 'bookings.user_id as booked_user', 'bookings.status as booked_status','bookings.created_at as created_at')
                    ->join('hotels', 'bookings.hotel_token', '=', 'hotels.hotel_token')
                    ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                    ->where('bookings.id', $id)->first();
	$bookingItem	= App\BookingItem::where('booking_id', '=', $id)->first();
 	$tot_booking 	= App\BookingItem::where('booking_id', '=', $id)->get()->count();
 	$users 			= get_user_details($booking->booked_user);
 	$html 			= '';
 	$html 			.= '<div class="bookingdetails_wrapper">';
	if($booking->booked_status==1):
		$html .= '<div class="pull-right clearfix"><span class="label label-success">Completed</span></div>';
	elseif($booking->booked_status==2):
		$html .= '<div class="pull-right clearfix"><span class="label label-danger">Cancelled</span></div>';
	elseif($booking->booked_status==3):
		$html .= '<div class="pull-right clearfix"><span class="label ellab-primary">Pending</span></div>';
	endif;
 	$html .='
	<div class="booking_details_top">
 		<span>Booking ID <br><strong>'.$id.'</strong></span>
 		<span>Booked by '.$users['first_name'].' '.$users['last_name'].' on '.date('D, d F Y', strtotime($booking->created_at)).'</span>
	</div>
	<div class="booking_details_middle">
 		<div class="row">
 			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
 				<h2>'.$booking->hotels_name.'</h2>
 				<p><strong>Address :</strong> '.$booking->address.' </p>
 			</div>
 			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<img src="'.url('public/uploads/' . $booking->featured_image).'" alt="'.$booking->hotels_name.'" style="height: 100px; width:auto;">
 			</div>
 		</div>
 	</div>
	<div class="booking_details_date_info">
 		<div class="dibox">
 			<span>'.date('d F', strtotime($booking->start_date)).' <br><b>'.date('D', strtotime($booking->start_date)).', '.$booking->start_date.' </b></span>
 			<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
 			<span>'.date('F d', strtotime($booking->end_date)).' <br><b>'.date('D', strtotime($booking->end_date)).', '.$booking->end_date.' </b></span>
 		</div>
 		<div class="dibox">'.($bookingItem->quantity_adults + $bookingItem->quantity_child).' Guests</div>
 		<div class="dibox">'.$booking->name.'<br/>'.$booking->room_type.'</div>
 	</div>
 	<div class="guest_info">
 		<div class="gibox"><span>PRIMARY GUEST</span> '.$users['first_name'].' '.$users['last_name'].' </div>
		<div class="gibox"><span>Mobile Number</span>  '.$users['mobile_number'].' </div>
		<div class="gibox"><span>Email ID</span>  '.$users['email'].'  </div>
 	</div>
 	<div class="bkdtls_table">
 		<table class="table">   
 			<tbody> 
				<tr> 
					<td>Room Tariff</td> 
					<td>'.getPrice($bookingItem->base_price).' x '.$booking->nights.' Nights</td> 
					<td>'.getPrice($bookingItem->base_price * $booking->nights).'</td>
				</tr>
				<tr> 
					<td>Discount</td> 
					<td>'.getPrice($bookingItem->discount).' x '.$booking->nights.' Nights</td> 
					<td>'.getPrice($bookingItem->discount * $booking->nights).'</td> 
				</tr>
				<tr> 
					<td>Net Room Tariff</td> 
					<td>'.getPrice($bookingItem->price).' x '.$booking->nights.' Nights</td> 
					<td>'.getPrice($bookingItem->price * $booking->nights).'</td>
				</tr>
				<tr> 
					<td>Booking Amount</td> 
					<td>'.getPrice($bookingItem->total_price).' x '.$bookingItem->quantity_room .' Room(s)</td> 
					<td>'.getPrice($booking->carttotal).'</td>
				</tr> 
				<tr> 
					<td>Net Booking Amount</td> 
					<td>Rounding up</td> 
					<td>'.getPrice($booking->carttotal).'</td>
				</tr> 
				<tr> 
					<td>Minimum Prepaid Amount to be Paid</td> 
					<td>&nbsp;</td> 
					<td>'.getPrice($booking->carttotal).'</td>
				</tr>
				<tr class="bkt_tot"> 
					<td>Total Amount <br><b>(Inclusive of all taxes)</b></td> 
					<td>&nbsp;</td> 
					<td>'.getPrice($booking->carttotal).'</td>
				</tr>
 			</tbody> 
 		</table>
 	</div>';
 	if($booking->booked_status != 2 && strtotime($booking->start_date) > strtotime(date('Y-m-d'))):
 	    $html .= '
		<div class="booking_cancel">Something is not right ? <a data-toggle="modal" data-target="#myModal">cancel the booking</a></div>';
	endif;
 	return $html;
 }



 function bookingdetailsHtmlBack($id){
 	$booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status','bookings.created_at as created_at')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels_translations.hotels_id', '=', 'hotel_addresses.hotel_id')->where('bookings.id', '=', $id)
 	->get()->first();
 	$tot_booking = App\BookingItem::where('booking_id', '=', $id)->get()->count();
 	$users = get_user_details($booking->booked_user);
 	$html = '';
 	$html .= '<div class="bookingdetails_wrapper">';
 	    if($booking->booked_status==1){
			$html .= '<div class="pull-right clearfix"><span class="label label-success">Completed</span></div>';
		}else if($booking->booked_status==2){
			$html .= '<div class="pull-right clearfix"><span class="label label-danger">Cancelled</span></div>';
		}else if($booking->booked_status==3){
			$html .= '<div class="pull-right clearfix"><span class="label ellab-primary">Pending</span></div>';
		}

 	$html .='<div class="booking_details_top">
 		<span>Booking ID <br><strong>'.$booking->booking_id.'</strong></span>
 		<span>Booked by '.$users['first_name'].' '.$users['last_name'].' on '.date('D, d F Y', strtotime($booking->created_at)).'</span>';
       
		
 	$html .= '</div>
 	<div class="booking_details_middle">
 	<div class="row">
 	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
 	<h2>'.$booking->hotels_name.'</h2>
 	<p><strong>Address :</strong> '.$booking->location.' </p>
 	</div>
 	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
 	<img src="'.Storage::disk('local')->url($booking->featured_image).'" alt="" />
 	</div>
 	</div>
 	</div>
 	<div class="booking_details_date_info">
 	<div class="dibox">
 	<span>'.date('d F', strtotime($booking->start_date)).' <br><b>'.date('D', strtotime($booking->start_date)).', '.$booking->check_in.' </b></span>
 	<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
 	<span>'.date('F d', strtotime($booking->end_date)).' <br><b>'.date('D', strtotime($booking->end_date)).', '.$booking->check_out.' </b></span>
 	</div>
 	<div class="dibox">'.($booking->quantity_adults+$booking->quantity_child).' Guests</div>
 	<div class="dibox">'.$booking->name.'</div>
 	</div>
 	<div class="guest_info">
 	<div class="gibox"><span>PRIMARY GUEST</span> '.$users['first_name'].' '.$users['last_name'].' </div>
 	<div class="gibox"><span>Mobile Number</span>  '.$users['mobile_number'].' </div>
 	<div class="gibox"><span>Email ID</span>  '.$users['email'].'  </div>
 	</div>
 	<div class="bkdtls_table">
 	<table class="table">   
 	<tbody> 
 	<tr> 
 	<td>Room Tariff</td> 
 	<td>'.getPrice($booking->price).' x '.$booking->nights.' Nights</td> 
 	<td>'.getPrice($booking->total_price).'</td> 
 	</tr>
 	<tr> 
 	<td>Booking Amount</td> 
 	<td>'.getPrice($booking->total_price).' x '.$tot_booking.' Room</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).'</td>  
 	</tr> 
 	<tr> 
 	<td>Net Booking Amount</td> 
 	<td>Rounding up</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).'</td> 
 	</tr> 
 	<tr> 
 	<td>Minimum Prepaid Amount to be Paid</td> 
 	<td>&nbsp;</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).' </td> 
 	</tr>
 	<tr class="bkt_tot"> 
 	<td>Total Amount <br><b>(Inclusive of all taxes)</b></td> 
 	<td>&nbsp;</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).' </td> 
 	</tr>
 	</tbody> 
 	</table>
 	</div>';
 	if($booking->booked_status != 2 && strtotime($booking->start_date) > strtotime(date('Y-m-d'))){
 	    $html .= '<div class="booking_cancel">Something is not right ? <a data-toggle="modal" data-target="#myModal">cancel the booking</a></div>
 	</div>';
 	}
 	return $html;

 }

 function stubaBookingdetailsHtml($id){
 		$booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status', 'bookings.carttotal as total_price')->where('bookings.id', '=', $id)->get()->first();
 		$users = get_user_details($booking->booked_user);
 		$data = unserialize($booking->xml_data);
 		//getRoomxmlHotelData('hotelName',$booking->hotel_id);
 		
 		/*echo "<pre>";
 			print_r($data);
 		echo "</pre>";*/
 		
 		$hotelbooking = $data['Booking']['HotelBooking'];
    			$totalsellingprice=0;
    			$totalprice =0;
    			$hotelname ='';
    			if(isset($hotelbooking[0])){
    			    foreach($hotelbooking as $hotelbook){
    			        $nightcost[] = $hotelbook['Room']['NightCost'];
    			        $totalsellingprice =$totalsellingprice + $hotelbook['Room']['TotalSellingPrice']['@attributes']['amt']; 
    			        $hotel_id =$hotelbook['HotelId'];
    			        $hotelname =$hotelbook['HotelName'];
    			    }
    			}else{
    			  $hotelname =$data['Booking']['HotelBooking']['HotelName'];
    			  $nightcost = $hotelbooking['Room']['NightCost'];
    			  $totalsellingprice = number_format((float) $hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt'], 2); 
    			  $hotel_id =$data['Booking']['HotelBooking']['HotelId'];
    			}
    			$totalprice = $totalsellingprice;
    			$totalsellingprice = number_format((float) $totalsellingprice, 2);
		 	    $html = '';
			 	$html .= '<div class="bookingdetails_wrapper">';
			 	if($booking->booked_status==1){
					$html .= '<div class="pull-right clearfix"><span class="label label-success">Completed</span></div>';
					}else if($booking->booked_status==2){
						$html .= '<div class="pull-right clearfix"><span class="label label-danger">Cancelled</span></div>';
					}else if($booking->booked_status==3){
						$html .= '<div class="pull-right clearfix"><span class="label ellab-primary">Pending</span></div>';
					}
			 	$html .='<div class="booking_details_top">
			 	<span>Booking ID <br><strong>'.$booking->xml_booking_id.'</strong></span>
			 	<span>Booked by '.$users['first_name'].' '.$users['last_name'].' on '.date('D, d F Y', strtotime($booking->created_at)).'</span> 	
			 	</div>
			 	<div class="booking_details_middle">
			 	<div class="row">
			 	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			 	<h2>'.$hotelname.'</h2>
			 	<p><strong>Address :'.getRoomxmlHotelData('hotelAddress',$booking->hotel_id).'</strong></p>
			 	</div>
			 	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			 	<img src="http://stuba.com'.getRoomxmlHotelData('hotelImage',$booking->hotel_id).'" height="200px" alt="" />
			 	</div>
			 	</div>
			 	</div>
			 	<div class="booking_details_date_info">
			 	<div class="dibox">
			 	<span>'.date('d F Y', strtotime(getStubaBookingValue('ArrivalDate',$id))).'</span>
			 	<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
			 	<span>'.date('d F Y', strtotime($booking->end_date)).'</span>
			 	</div>
			 	</div>
			 	<div class="guest_info">
			 	<div class="gibox"><span>PRIMARY GUEST</span> '.$users['first_name'].' '.$users['last_name'].' </div>
			 	<div class="gibox"><span>Mobile Number</span>  '.$users['mobile_number'].' </div>
			 	<div class="gibox"><span>Email ID</span>  '.$users['email'].'  </div>
			 	</div>
			 	<div class="bkdtls_table">
			 	<table class="table table-bordered ">
		            			<thead>
		            			<th class="text-center">Nights</th>
		            			<th class="text-center">Price</th>
		            			</thead>
		        	<tbody>';

			 	if(isset($hotelbooking[0])){
					$dMarkUpPrice = number_format((float)($booking->markUpTotal / count($hotelbooking)), 2, '.', '');
				    foreach($hotelbooking as $k=>$htelbook){
				        if($hotelbooking[$k]['Nights']>1){
							$html .= '<tr>
								<td>'.$hotelbooking[$k]["Room"]["RoomType"]["@attributes"]["text"].'-'.$hotelbooking[$k]["Nights"].' Night</td>
								<td>'. $data['Currency']. ' ' .number_format(((float) $dMarkUpPrice +  + (float) $hotelbooking[$k]["Room"]["TotalSellingPrice"]["@attributes"]["amt"]), 2).'</td>
							</tr>';
						}else{
							$html .= '<tr>
								<td>'.$hotelbooking[$k]["Room"]["RoomType"]["@attributes"]["text"].' -1 Night</td>
								<td>'.$data["Currency"]. ' ' .number_format(((float) $dMarkUpPrice +  + (float) $hotelbooking[$k]["Room"]["TotalSellingPrice"]["@attributes"]["amt"]), 2).'</td>
							</tr>';
						}
				    }
				}else{ 
					if($hotelbooking['Nights']>1){
						$dMarkUpPrice = number_format((float)($booking->markUpTotal / count($nightcost)), 2, '.', '');
						for ($i=0; $i < count($nightcost) ; $i++) {
							$html .= '<tr>
								<td>'.$hotelbooking["Room"]["RoomType"]["@attributes"]["text"].'-'.($nightcost[$i]["Night"]+1).' Night</td>
								<td>'.$data["Currency"]. ' ' .number_format(((float) $dMarkUpPrice + (float) $nightcost[$i]["SellingPrice"]["@attributes"]["amt"]), 2).'</td>
							</tr>';
						}  
					}else{
						$html .= '<tr>
							<td>'.$hotelbooking["Room"]["RoomType"]["@attributes"]["text"].'-'.($nightcost['Night']+1).' Night</td>
							<td>'.$data["Currency"].number_format(((float) $booking->markUpTotal + (float) $nightcost["SellingPrice"]["@attributes"]["amt"]), 2).'</td>
						</tr>';
					}
				}

	 	$html .= '</tbody>
        </table><table class="table">   
	 	<tbody> 
	 	<td>Booking Amount</td> 
	 	<td>'.getPrice($booking->total_price).'</td>  
	 	</tr> 
	 	<tr> 
	 	<td>Net Booking Amount (Rounding up)</td>
	 	<td>'.getPrice(round($booking->total_price)).'</td> 
	 	</tr>
	 	<tr class="bkt_tot"> 
	 	<td>Total Amount <br><b>(Inclusive of all taxes)</b></td> 
	 	<td>'.getPrice(round($booking->total_price)).' </td> 
	 	</tr>
	 	</tbody> 
	 	</table>
	 	</div>';
	 	if($booking->booked_status != 2 && strtotime(getStubaBookingValue('ArrivalDate',$id)) > strtotime(date('Y-m-d'))){
	 	    $html .= '<div class="booking_cancel">Something is not right ? <a href="javascript:void(0);" onclick="stubaCancel(\''.$booking->xml_booking_id.'\');">cancel the booking</a></div>
	 	</div>';
	 	}
 	    return $html;
    }

 function pdfGenerator($id){
	    $data = array();
	    $pdf = PDF::loadView('frontend.invoice', $data);
	    //return $pdf->stream();
	    $pdf->save(public_path().'/storage/invoice.pdf');
	    return $pdf->download('invoice.pdf');
 }

 function invoice_generate($id,$type){
 	
 	
        if($type=='site'){
        	$link = "/storage/invoices/".$id.'-invoice.pdf';
	        $booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status','bookings.created_at as created_at')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels_translations.hotels_id', '=', 'hotel_addresses.hotel_id')->where('bookings.id', '=', $id)->get()->first();
			$tot_booking = App\BookingItem::where('booking_id', '=', $id)->get()->count();
	        $users = get_user_details($booking->booked_user);
	        $data = compact('booking', 'users', 'tot_booking');
	        $pdf = PDF::loadView('frontend.invoice.site', $data);
	        $filepath = public_path().$link;
	        if (!file_exists($filepath)) {
			   $pdf->save(public_path().$link);
			   $pdf->stream();
			} 
        	return $filepath;
		}else if($type=='stuba'){
	 		$booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->where('bookings.id', '=', $id)->get()->first();
			$bid=$booking->xml_booking_id;
			$link = "/storage/invoices/".$bid.'-invoice.pdf';
			$users = get_user_details($booking->booked_user);
        	$data = compact('booking', 'users', 'totalprice');
        	$pdf = PDF::loadView('frontend.invoice.stuba', $data);
        	$filepath = public_path().$link;
        	if (!file_exists($filepath)) {
			   $pdf->save(public_path().$link);
			   $pdf->stream();
			} 
        	return $filepath;
		}   
    }

 function bookingEmail_template($id){
 	$booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status','bookings.created_at as created_at')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels_translations.hotels_id', '=', 'hotel_addresses.hotel_id')->where('bookings.id', '=', $id)
    ->get()->first();
        $tot_booking = App\BookingItem::where('booking_id', '=', $id)->get()->count();
        $users = get_user_details($booking->booked_user);
	 	$html = '';
	 	$html .= '<table style="border:2px solid #000;; border-spacing: 0px;border-collapse: separate; width:728px; margin: 0 auto;">
		<tbody>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0">
					<thead> 
					<tr> 
					<th style="margin: 0 auto;display: block;max-width: 100%;"><a href="'.URL('/').'"><img src="'.asset('frontend/images/fish_header_img.png').'" alt="" /></a></th>
					</tr> 
					</thead> 
					<tbody> 
					<tr><td style="padding: 5px 20px;">Dear '.$users['first_name'].',</td></tr> 
					<tr><td style="padding: 5px 20px;">We are glad to have the chance to host you again. We confirm that <strong>'.$tot_booking.' '.$booking['name'].' at '.$booking['hotels_name'].'</strong> has been reserved under your name.</td> </tr> 
					<tr><td style="padding: 5px 20px;"> At '.$booking['hotels_name'].', you can always expect to be welcomed to a beautiful living space, whether it???s a hotel next door or a far off location. </td></tr> 
					<tr style="height: 20px;">&nbsp;</tr>
					<tr style="background: #d7b956;color:#fff;font-size: 19px;"><td style="padding: 6px 20px;">Booking Details</td></tr>
					<tr style="height: 10px;border-bottom: 1px solid #ccc;display: block;">&nbsp;</tr>
					<tr style="height: 20px;">&nbsp;</tr>
					</tbody>
					</table> 
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl2" style="padding: 0 20px;">
							<tbody>
								<tr>
									<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>BOOKING ID:</strong> '.$booking['booking_id'].' </td>
									<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-IN -</strong> '.date('jS F\'y ', strtotime($booking['start_date'])).' </td>
									<td style="border-bottom: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-OUT -</strong> '.date('jS F\'y ', strtotime($booking['end_date'])).' </td>
								</tr>
								<tr>
									<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>ADDRESS -</strong> '.$booking['location'].' </td>
									<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>Landmark -</strong> '.$booking['city'].' </td>
									<td style="border-right: none;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>Total payment to be made -</strong> '.getPrice($booking['total_price']*$tot_booking).' </td>
								</tr>
							</tbody>
						</table>
						<table width="100%" cellpadding="0" cellspacing="0" class="tble_bottom" style="padding: 40px 0 10px 0;">
							<tr>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;">'.date('d F', strtotime($booking['start_date'])).'</span><br>'.$booking['check_in'].' Onwards</td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><img src="'.asset('frontend/images/moon.png').'" alt="" /></span><br>'.$booking['nights'].' Night</td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;">'.date('d F', strtotime($booking['end_date'])).'</span><br>Till '.$booking['check_out'].'</td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><img src="'.asset('frontend/images/guest.png').'" alt="" /></span><br>'.($booking['adult_capacity']+$booking['child_capacity']).' Guest</td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;">'.$tot_booking.' Room</span><br></td>
							</tr>
						</table>
							</td>
						</tr>
					</tbody>
				</table>';
				return $html;
 }


  function stubaBookingEmailTemplate($id){
 	    $booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status', 'bookings.carttotal as total_price')->where('bookings.id', '=', $id)->get()->first();
 		$users = get_user_details($booking->booked_user);
 		$data = unserialize($booking->xml_data);
	 	$hotelbooking = $data['Booking']['HotelBooking'];
    			$totalsellingprice=0;
    			$totalprice =0;
    			$hotelname ='';
    			if(isset($hotelbooking[0])){
    			    foreach($hotelbooking as $hotelbook){
    			        $nightcost[] = $hotelbook['Room']['NightCost'];
    			        $totalsellingprice =$totalsellingprice + $hotelbook['Room']['TotalSellingPrice']['@attributes']['amt']; 
    			        $hotel_id =$hotelbook['HotelId'];
    			        $hotelname =$hotelbook['HotelName'];
    			    }
    			}else{
    			  $hotelname =$data['Booking']['HotelBooking']['HotelName'];
    			  $nightcost = $hotelbooking['Room']['NightCost'];
    			  $totalsellingprice = number_format((float) $hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt'], 2); 
    			  $hotel_id =$data['Booking']['HotelBooking']['HotelId'];
    			}
    			$totalprice = $totalsellingprice;
    			$totalsellingprice = number_format((float) $totalsellingprice, 2);
	 	
	 	$html = '';
	 	$html .= '<table style="border:2px solid #000;; border-spacing: 0px;border-collapse: separate; width:728px; margin: 0 auto;">
		<tbody>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0">
					<thead> 
					<tr> 
					<th style="margin: 0 auto;display: block;max-width: 100%;"><a href="'.URL('/').'"><img src="'.asset('frontend/images/fish_header_img.png').'" alt="" /></a></th>
					</tr> 
					</thead> 
					<tbody> 
					<tr><td style="padding: 5px 20px;">Dear '.$users['first_name'].',</td></tr> 
					<tr><td style="padding: 5px 20px;">We are glad to have the chance to host you again. We confirm that <strong>'.$totalprice.' '.$booking['name'].' at '.getRoomxmlHotelData('hotelName',$booking->hotel_id).'</strong> has been reserved under your name.</td> </tr> 
					<tr><td style="padding: 5px 20px;"> At '.getRoomxmlHotelData('hotelName',$booking->hotel_id).', you can always expect to be welcomed to a beautiful living space, whether it???s a hotel next door or a far off location. </td></tr> 
					<tr style="height: 20px;">&nbsp;</tr>
					<tr style="background: #d7b956;color:#fff;font-size: 19px;"><td style="padding: 6px 20px;">Booking Details</td></tr>
					<tr style="height: 10px;border-bottom: 1px solid #ccc;display: block;">&nbsp;</tr>
					<tr style="height: 20px;">&nbsp;</tr>
					</tbody>
					</table> 
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl2" style="padding: 0 20px;">
							<tbody>
								<tr>
									<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>BOOKING ID:</strong> '.$booking['xml_booking_id'].' </td>
									<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-IN -</strong> '.date('jS F\'y ', strtotime(getStubaBookingValue('ArrivalDate',$id))).' </td>
									<td style="border-bottom: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-OUT -</strong> '.date('jS F\'y ', strtotime($booking['end_date'])).' </td>
								</tr>
								<tr>
									<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>ADDRESS -</strong> '.getRoomxmlHotelData('hotelAddress',$booking->hotel_id).' </td>
									<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>Landmark -</strong> '.$booking['city'].' </td>
									<td style="border-right: none;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>Total payment to be made -</strong> '.getPrice($booking['total_price']).' </td>
								</tr>
							</tbody>
						</table>
						<table width="100%" cellpadding="0" cellspacing="0" class="tble_bottom" style="padding: 40px 0 10px 0;">
							<tr>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;">'.date('d F', strtotime(getStubaBookingValue('ArrivalDate',$id))).'</span></td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><img src="'.asset('frontend/images/moon.png').'" alt="" /></span><br>'.getStubaBookingValue('Nights',$id).' Night</td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;">'.date('d F', strtotime($booking['end_date'])).'</span></td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><img src="'.asset('frontend/images/guest.png').'" alt="" /></span><br>'.getStubaBookingValue('Guests',$id).' Guest</td>
								<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;">'.$totalprice.' Room</span><br></td>
							</tr>
						</table>
							</td>
						</tr>
					</tbody>
				</table>';
				return $html;
 }

 function getAccommodationCountry($id){
 	$country = DB::table('countries_translations')->join('hotels', 'countries_translations.countries_id', '=', 'hotels.country_id')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->where('hotels.region_id', '=', $id)->groupBy('hotels.country_id')->get()->all();
 	return $country;
 }

 function getAccommodationState($id){
 	$states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('states_translations.states_name', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $states;
 }

  function getAccommodationTown($id){
 	$town = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.id')->get()->all();
 	return $town;
 }

 function getAccommodationHotels($id){
 	$hotels = DB::table('hotels')->join('hotel_accommodation_relations', 'hotels.id', '=', 'hotel_accommodation_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.id')->get()->all();
 	return $hotels;
 }

  function getExperienceCountry($id){
 	$country = DB::table('countries_translations')->join('hotels', 'countries_translations.countries_id', '=', 'hotels.country_id')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->where('hotels.region_id', '=', $id)->groupBy('hotels.country_id')->get()->all();
 	return $country;
 }

 function getExperienceState($id){
 	$states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $states;
 }

  function getExperienceTown($id){
 	$town = App\Hotels::join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $town;
 }

 function getExperienceHotel($id){
 	$hotel = App\Hotels::join('hotel_experiences_relations', 'hotels.id', '=', 'hotel_experiences_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $hotel;
 }

  function getInspirationCountry($id){
 	$country = DB::table('countries_translations')->join('hotels', 'countries_translations.countries_id', '=', 'hotels.country_id')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->where('hotels.region_id', '=', $id)->groupBy('hotels.country_id')->get()->all();
 	return $country;
 }

 function getInspirationState($id){
 	$states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $states;
 }

  function getInspirationTown($id){
 	$town = App\Hotels::join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $town;
 }

 function getInspirationHotel($id){
 	$hotels = App\Hotels::join('hotel_inspirations_relations', 'hotels.id', '=', 'hotel_inspirations_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $hotels;
 }

 function getSpeciesCountry($id){
 	$country = DB::table('countries_translations')->join('hotels', 'countries_translations.countries_id', '=', 'hotels.country_id')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->where('hotels.region_id', '=', $id)->groupBy('hotels.country_id')->get()->all();
 	return $country;
 }

 function getSpeciesState($id){
 	$states = DB::table('states_translations')->join('hotels', 'states_translations.states_id', '=', 'hotels.state_id')->join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $states;
 }

  function getSpeciesTown($id){
 	$town = App\Hotels::join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels.town', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $town;
 }
 function getSpeciesHotel($id){
 	$hotels = App\Hotels::join('hotel_species_relations', 'hotels.id', '=', 'hotel_species_relations.hotel_id')->join('hotels_translations', 'hotels.id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels.id', '=', 'hotel_addresses.hotel_id')->where('hotels.region_id', '=', $id)->orderBy('hotels_translations.hotels_name', 'ASC')->groupBy('hotels.state_id')->get()->all();
 	return $hotels;
 }

  function getTourGuide($hotel_id, $type){
 	$guides = App\TourGuide::where('hotel_id', $hotel_id)->where('type', $type)->get()->first();
 	return $guides;
  }

  function is_live(){
 	if(request()->getHost()!='127.0.0.1'){
     return true;
 	}else{
 		return false;
 	}
  }


  function getHotelBooking_confirmationVoucher($id,$hotel_id){
 	$booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels_translations.hotels_id', '=', 'hotel_addresses.hotel_id')->where('bookings.id', '=', $id)
 	->get()->first();
 	$tot_booking = App\BookingItem::where('booking_id', '=', $id)->get()->count();
 	$users = get_user_details($booking->booked_user);
 	//$users = App\User::where('id', $booking->booked_user)->first();
 	$html = '';
 	$html .= '<div class="bookingdetails_wrapper">
 	<div class="booking_details_top">
 	<span>Booking ID <br><strong>'.$booking->booking_id.'</strong></span>
 	<span>Booked by '.$users['first_name'].' '.$users['last_name'].' on '.date('D, d F Y', strtotime($booking->created_at)).'</span>
 	</div>
 	<div class="booking_details_middle">
 	<div class="row">
 	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
 	<h2>'.$booking->hotels_name.'</h2>
 	<p><strong>Address :</strong> '.$booking->location.' </p>
 	</div>
 	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
 	<img src="'.Storage::disk('local')->url($booking->featured_image).'" alt="" />
 	</div>
 	</div>
 	</div>
 	<div class="booking_details_date_info">
 	<div class="dibox">
 	<span>'.date('d F', strtotime($booking->start_date)).' <br><b>'.date('D', strtotime($booking->start_date)).', '.$booking->check_in.' </b></span>
 	<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
 	<span>'.date('F d', strtotime($booking->end_date)).' <br><b>'.date('D', strtotime($booking->end_date)).', '.$booking->check_out.' </b></span>
 	</div>
 	<div class="dibox">'.($booking->adult_capacity+$booking->child_capacity).' Guests</div>
 	<div class="dibox">'.$booking->name.'</div>
 	</div>
 	<div class="guest_info">
 	<div class="gibox"><span>PRIMARY GUEST</span> '.$users['first_name'].' '.$users['last_name'].' </div>
 	<div class="gibox"><span>Mobile Number</span>  '.$users['mobile_number'].' </div>
 	<div class="gibox"><span>Email ID</span>  '.$users['email'].'  </div>
 	</div>
 	<div class="bkdtls_table">
 	<table class="table">   
 	<tbody> 
 	<tr> 
 	<td>Room Tariff</td> 
 	<td>'.getPrice($booking->price).' x '.$booking->nights.' Nights</td> 
 	<td>'.getPrice($booking->total_price).'</td> 
 	</tr>
 	<tr> 
 	<td>Booking Amount</td> 
 	<td>'.getPrice($booking->total_price).' x '.$tot_booking.' Room</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).'</td>  
 	</tr> 
 	<tr> 
 	<td>Net Booking Amount</td> 
 	<td>Rounding up</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).'</td> 
 	</tr> 
 	<tr> 
 	<td>Minimum Prepaid Amount to be Paid</td> 
 	<td>&nbsp;</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).' </td> 
 	</tr>
 	<tr class="bkt_tot"> 
 	<td>Total Amount <br><b>(Inclusive of all taxes)</b></td> 
 	<td>&nbsp;</td> 
 	<td>'.getPrice($booking->total_price*$tot_booking).' </td> 
 	</tr>
 	</tbody> 
 	</table>
 	</div>';
 	 
 	  $html .= '<div class="booking_cancel confirm_data">';
	 	 $html .= '<form id="confirm" name="confirm">';
	 	 $fishing = App\Fisherman::where('hotel_id', $hotel_id)->get()->first();
	 	 $tourguides = App\TourGuide::where('hotel_id', $hotel_id)->get()->all();
	 	//var_dump($fishing);
	    //var_dump($fishing["booking_cnf"]);
	    //var_dump($fishing["provide_on_site"]);
	    //var_dump($fishing["arrange_fishing_nearby"]);
	    //var_dump($fishing["provide_our_curated"]);
	     $booking_cnf =  str_replace('PROPERTY NAME', $booking->hotels_name, $fishing["booking_cnf"]);
	      if($fishing){
		     if($fishing["provide_our_curated"]=='yes'){
		    	$html .= '<div class="confirmation_msg">'.$booking_cnf.'</div>';
		    	  $html .= '<div class="tour_guides">';
		    	   foreach ($tourguides as $key => $guide) {
		    	  	 $html .= '<h4><input class="checkbox" type="checkbox" value="'.$guide->id.'" name="guide[]">'.$guide->business_name.'</h4>';
		    	   }
		    	 $html .= '</div>';
		     }else{
		    	$html .= '<div class="confirmation_msg">'.$booking_cnf.'</div>';
		     }
	      }
	       $html .= '</form>';
	      $html .='<div> <button id="confirm_btn"> Confirm</button></div>';
	 	$html .= '</div>';
 	  $html .= '</div>';
 	 return $html;
    }
 

  function bookingGuideConfirmEmail_template($id){
 	$booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')->join('rooms', 'booking_items.room_id', '=', 'rooms.id')->join('hotels_translations', 'booking_items.hotel_id', '=', 'hotels_translations.hotels_id')->join('hotel_addresses', 'hotels_translations.hotels_id', '=', 'hotel_addresses.hotel_id')->where('bookings.id', '=', $id)
    ->get()->first();
        $tot_booking = App\BookingItem::where('booking_id', '=', $id)->get()->count();
        $users = get_user_details($booking->booked_user);
 		$html = '';
 		$html .= '<table style="border:2px solid #000;; border-spacing: 0px;border-collapse: separate; width:728px; margin: 0 auto;">
				   <tbody>
					<tr>
						<td>
							<table width="100%" cellpadding="0" cellspacing="0">
							<thead> 
							<tr> 
							<th style="margin: 0 auto;display: block;max-width: 100%;"><a href="'.URL('/').'"><img src="'.asset('frontend/images/fish_header_img.png').'" alt="" /></a></th>
							</tr> 
							</thead> 
							<tbody> 
							<tr><td style="padding: 5px 20px;">Dear '.$users['first_name'].',</td></tr> 
							<tr><td style="padding: 5px 20px;">We are glad to have the chance to host you again. We confirm that <strong>'.$tot_booking.' '.$booking['name'].' at '.$booking['hotels_name'].'</strong> has been reserved under your name.</td> </tr> 
							<tr><td style="padding: 5px 20px;"> At '.$booking['hotels_name'].', you can always expect to be welcomed to a beautiful living space, whether it???s a hotel next door or a far off location. </td></tr> 
							<tr style="height: 20px;">&nbsp;</tr>
							<tr style="background: #d7b956;color:#fff;font-size: 19px;"><td style="padding: 6px 20px;">Booking Details</td></tr>
							<tr style="height: 10px;border-bottom: 1px solid #ccc;display: block;">&nbsp;</tr>
							<tr style="height: 20px;">&nbsp;</tr>
							</tbody>
							</table> 
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl2" style="padding: 0 20px;">
								<tbody>
									<tr>
										<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>BOOKING ID:</strong> '.$booking['booking_id'].' </td>
										<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-IN -</strong> '.date('jS F\'y ', strtotime($booking['start_date'])).' </td>
										<td style="border-bottom: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-OUT -</strong> '.date('jS F\'y ', strtotime($booking['end_date'])).' </td>
									</tr>
									<tr>
										<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>ADDRESS -</strong> '.$booking['location'].' </td>
										<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>Landmark -</strong> '.$booking['city'].' </td>
									</tr>
								</tbody>
							</table>
							
						</td>
					</tr>
				</tbody>
            </table>';
      return $html;
    }

	function accommodation_data($hotel_id, $ac_id){
		$hotelaccommodationRelation = App\HotelAccommodationRelation::where('hotel_id', $hotel_id)->get()->all();
		foreach ($hotelaccommodationRelation as $key => $value) {
			if($value->accommodation_id == $ac_id){
				echo 1;
			}else{
				
			}
		}
	}

	function inspiration_data($hotel_id, $insp_id){
		$hotelinspirationsrelation = App\HotelInspirationsRelation::where('hotel_id', $hotel_id)->get()->all();
		foreach ($hotelinspirationsrelation as $key => $value) {
			if($value->inspirations_id == $insp_id){
				echo 1;
			}else{
				
			}
		}
	}

	function experience_data($hotel_id, $exp_id){
		$hotelexperiencesrelation = App\HotelExperiencesRelation::where('hotel_id', $hotel_id)->get()->all();
		foreach ($hotelexperiencesrelation as $key => $value) {
			if($value->experiences_id == $exp_id){
				echo 1;
			}else{
				
			}
		}
	}

	function species_data($hotel_id, $spec_id){
		$hotelspeciesrelation = App\HotelSpeciesRelation::where('hotel_id', $hotel_id)->get()->all();
		foreach ($hotelspeciesrelation as $key => $value) {
			if($value->species_id == $spec_id){
				echo 1;
			}else{
				
			}
		}
	}

	function _hash_hmac( $algo, $data, $key, $raw_output = false ) {
	$packs = array(
		'md5'  => 'H32',
		'sha1' => 'H40',
	);

	if ( ! isset( $packs[ $algo ] ) ) {
		return false;
	}

	$pack = $packs[ $algo ];

	if ( strlen( $key ) > 64 ) {
		$key = pack( $pack, $algo( $key ) );
	}

	$key = str_pad( $key, 64, chr( 0 ) );

	$ipad = ( substr( $key, 0, 64 ) ^ str_repeat( chr( 0x36 ), 64 ) );
	$opad = ( substr( $key, 0, 64 ) ^ str_repeat( chr( 0x5C ), 64 ) );

	$hmac = $algo( $opad . pack( $pack, $algo( $ipad . $data ) ) );

	if ( $raw_output ) {
		return pack( $pack, $hmac );
	}
	return $hmac;
}
function getHotelfield($id,$field){
    //echo $id . '  ' .$field; die;
	$data = App\HotelsTranslation::where('hotels_id', $id)->get()->first();
// 	echo "<pre>";
// 	print_r($data); die;
	
	if(!empty($data)){
		//echo $data[$field];
		echo $data->$field;
	}else{
		echo '';
	}
}
function review_exits($hid){
	$user_id=get_loggedin_id();
	$review =  App\Review::where('hotel_id', '=', $hid)->where('user_id', '=', $user_id)->get()->first();
 	if($review){
 		return true;
 	}else{
 		return false;
 	}
}
function getRoomxmlHotelData($field,$id){
	$hotels = DB::table('hotel_master_xml')->join('hotel_description_xml', 'hotel_master_xml.id', '=', 'hotel_description_xml.hotel_id')->join('hotel_address_xml', 'hotel_master_xml.id', '=', 'hotel_address_xml.hotel_id')->where('hotel_master_xml.id', $id)->get()->first();
    $images = DB::table('hotel_images_xml')->select('*')->where('hotel_images_xml.hotel_id', $id)->get()->first();
    $amenity = DB::table('hotel_amenity_xml')->select('*')->where('hotel_amenity_xml.hotel_id', $id)->get()->all();
    //var_dump($hotels);
    if($field=='hotelImage'){
    	return $images->Url;
    }
    if($field=='hotelName'){

    	if($hotels->name){
    		return $hotels->name;
    	}else{
    		return '';
    	}
        
    } 
    if($field=='hotelAddress'){
    	$address = '';
    	if( $hotels->Address1){
    		$address .=$hotels->Address1; 
    	}
    	if( $hotels->Address2){
    		$address .= ', '.$hotels->Address2; 
    	}
    	if( $hotels->Address3){
    		$address .= ', '.$hotels->Address3; 
    	}
    	if( $hotels->City){
    		$address .= ', '.$hotels->City; 
    	}
    	if( $hotels->State){
    		$address .= ', '.$hotels->State; 
    	}
    	if( $hotels->Country){
    		$address .= ', '.$hotels->Country; 
    	}
    	
    	return $address;
    }
}
//
  function getStubaBookingValue($field,$id){
 	    $booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status', 'bookings.carttotal as total_price')->where('bookings.id', '=', $id)->get()->first();
 		$data = unserialize($booking->xml_data);
	 	$hotelbooking = $data['Booking']['HotelBooking'];
	 	//echo '<pre>';
	 	  //var_dump($hotelbooking);
	 	//echo '</pre>';
    			$totalsellingprice=0;
    			$totalprice =0;
    			$HotelName ="";
    			$RoomName="";
    			$CreationDate="";
    			$ArrivalDate="";
    			$Nights="";
    			$Guests=0;
    			if(isset($hotelbooking[0])){
    			    foreach($hotelbooking as $hotelbook){
    			        $nightcost[] = $hotelbook['Room']['NightCost'];
    			        $totalsellingprice =$totalsellingprice + $hotelbook['Room']['TotalSellingPrice']['@attributes']['amt']; 
    			        $hotel_id =$hotelbook['HotelId'];
    			        $HotelName =$hotelbook['HotelName'];
    			        $CreationDate=$hotelbook['CreationDate'];
    			  		$ArrivalDate=$hotelbook['ArrivalDate'];
    			  		$Nights=$hotelbook['Nights'];
    			  		$Guests = $Guests +count($hotelbook["Room"]['Guests']);
    			  		$RoomName=$hotelbook["Room"]['RoomType']['@attributes']['text'];
    			    }
    			}else{
    			  $hotelname =$data['Booking']['HotelBooking']['HotelName'];
    			  $nightcost = $hotelbooking['Room']['NightCost'];
    			  $totalsellingprice = number_format($hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt'], 2); 
    			  $hotel_id =$data['Booking']['HotelBooking']['HotelId'];
    			  $HotelName =$data['Booking']['HotelBooking']['HotelName'];
    			  $CreationDate=$data['Booking']['HotelBooking']['CreationDate'];
    			  $ArrivalDate=$data['Booking']['HotelBooking']['ArrivalDate'];
    			  $Nights=$data['Booking']['HotelBooking']['Nights'];
    			  $RoomName=$hotelbooking["Room"]['RoomType']['@attributes']['text'];
    			  $Guests=count($hotelbooking["Room"]['Guests']);
    			}
    			if($field=='HotelName'){
    				return $HotelName;
    			}
    			if($field=='CreationDate'){
    				return $CreationDate;
    			}
    			if($field=='ArrivalDate'){
    				return $ArrivalDate;
    			}
    			if($field=='Nights'){
    				return $Nights;
    			}
    			if($field=='RoomName'){
    				return $RoomName;
    			}
    			if($field=='Guests'){
    				return $Guests;
    			}
    			//$totalprice = $totalsellingprice;
    			//$totalsellingprice = number_format($totalsellingprice, 2);
    }
    // getStubaBookingValue('HotelName',$booking_id);
    // getStubaBookingValue('RoomName',$booking_id);
    // getStubaBookingValue('CreationDate',$booking_id);
    // getStubaBookingValue('ArrivalDate',$booking_id);
    // getStubaBookingValue('Nights',$booking_id);
    // getStubaBookingValue('RoomName',$booking_id);
    // getStubaBookingValue('Guests',$booking_id);
?>