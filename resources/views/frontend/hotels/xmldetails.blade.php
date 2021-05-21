@extends('frontend.layouts.app')
@section('css')
<!--new-->
<link rel="stylesheet" href="{{ asset('frontend/css/flexslider.css') }}" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('frontend/css/prettyPhoto.css') }}" type="text/css" />
<!--new-->
<style type="text/css">
	.header_search_area{display: none;}
	.customBack {
        background: #e84b02 none repeat scroll 0 0;
        border: 1px solid #e84b02;
        border-radius: 0;
        color: #fefefe;
        display: block;
        float: right;
        font-size: 18px;
        font-weight: 700;
        line-height: 36px;
        margin: 0;
        padding: 0;
        text-align: center;
        text-decoration: none;
        transition: all .5s ease 0s;
        width: 74px;
        float:left;
}
  </style>
@endsection
@section('content')
<?php
use App\Filter;
$hotel_data 	= $dataArray['hotels'];
$hotel_images 	= $dataArray['images'];
$hotelDesc 		= $dataArray['hotelDesc'];
//$amenity 		= $dataArray['amenity'];
$amenity        = json_decode(json_encode($dataArray['amenity']), true);
$address 		= (array) $dataArray['address'];
$addrss     	= '';
if(!empty($address)):
	if( $address['Address1']):
		$addrss .= $address['Address1']; 
	endif;
	if( $address['Address2']):
		$addrss .= ', '. $address['Address2']; 
	endif;
	if( $address['Address3']):
		$addrss .= ', '. $address['Address3']; 
	endif;
	if( $address['City']):
		$addrss .= ', '. $address['City']; 
	endif;
	if( $address['State']):
		$addrss .= ', '. $address['State']; 
	endif;
	if( $address['Country']):
		$addrss .= ', '. $address['Country']; 
	endif;
endif;
?>

<section class="innerbannersection"></section>
<section class="hotelsection tab-box" id="header_fixed">
    <a href="javascript:void(0);" class="customBack hotelDetailsBack">BACK</a> 
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-section" >
					<nav class="navbar navbar-inverse">
						<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
							</div>
							<div>
								<div class="collapse navbar-collapse" id="myNavbar">
									<ul class="nav navbar-nav">
										<li><a href="#section2">Description</a></li>
										<li><a href="#section3">Photos</a></li>
										<li><a href="#section6">Amenity</a></li>
										<li><a href="#section4">Rooms</a></li>
										<li><a href="#section5">Location</a></li>
									</ul>
								</div>
							</div>
						</div>
					</nav>
				</div>
				<div id="section2" class="sect-tab">
					<div class="container-fluid2">
						<h1>{{$hotel_data->name}} </h1>
						<?=(count($hotelDesc) > 0) ? ( (count($hotelDesc) == 1) ? $hotelDesc->Text : $hotelDesc[0]->Text) : ''?>
					</div>
				</div>
				<div id="section3" class="sect-tab">
					<div class="container-fluid2">
						<h1>Photos</h1>
						<?php if(count($hotel_images) > 0) :?>
						<div class="slider-view">
							<div id="slider" class="flexslider main-slide-view">
								<ul class="slides">
									<!--<li> <a href="https://www.stuba.com{{ (count($hotel_images) == 1) ? $hotel_images->Url : $hotel_images[0]->Url }}" alt="{{ $hotel_data->name }}"></a></li>-->
									@foreach($hotel_images as $img)
									<li> <a href="https://www.stuba.com{{ $img->Url }}" rel="prettyPhoto[pp_gal]"><img src="https://www.stuba.com{{ $img->Url }}" alt="{{ $hotel_data->name }}"></a></li>
									@endforeach
								</ul>
							</div>
							<div  class="carousel flexslider thumble-slide-view">
								<ul class="slides">
									<!--<li> <a href="https://www.stuba.com{{ (count($hotel_images) == 1) ? $hotel_images->Url : $hotel_images[0]->Url }}" alt="{{ $hotel_data->name }}"></a></li>-->
									@foreach($hotel_images as $img)
									<li> <img src="https://www.stuba.com{{ $img->Url }}" alt="{{ $hotel_data->name }}"></li>
									@endforeach
								</ul>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<div id="section6" class="sect-tab">
					<div class="container-fluid2">
						<h1>Amenity</h1>
						@if(count($amenity) > 0)
						<ul>
						    @foreach($amenity as $am)
						        <li>{{ $am['Text'] }}</li>
						    @endforeach
						    </ul>
						@endif
					</div>
				</div>
                <?php
				if(count($hotelDesc) > 0) :
				    for($f = 0; $f < 3; $f++):
				        $typ = '';
				        $txt = '';
				        foreach($hotelDesc as $hd) :
				            if($f == 0 && $hd->Type == 'PropertyInformation'):
				                $typ = 'Features';
				                $txt = $hd->Text;
				            elseif($f == 1 && $hd->Type == 'DiningFacilities'):
				                $typ = 'Dining';
				                $txt = $hd->Text;
				            elseif($f == 2 && $hd->Type == 'RoomTypes'):
				                $typ = 'Room Features';
				                $txt = $hd->Text;
				            endif;
				        endforeach;
				        if($typ != '' && $txt != ''):
				?>
    				        <div class="sect-tab">
    							<div class="container-fluid2">
    								<h1>{{$typ}} </h1>
    								<?=$txt?>
    							</div>
    						</div>
				<?php
				        endif;
				    endfor;
				endif;
				?>
                <div id="section4" class="sect-tab">
					<div class="container-fluid2">
						<h1>Rooms</h1>
						<div class="roompage_container">
							<div class="col-xs-12 col-sm-4 col-md-2 col-lg-12">
								<a href="javascript:void(0);" class="Viewbox roomAvailablity" style="width: 200px !important;">Check Availability</a> 
							</div>
							<div class="container-fluid2 xmlroom clearfix roomListAppend"></div>
						</div>
					</div>
				</div>
                <?php
				if(count($hotelDesc) > 0) :
				    for($f = 0; $f < 1; $f++):
				        $typ = '';
				        $txt = '';
				        foreach($hotelDesc as $hd) :
				            if($hd->Type == 'SurroundingArea'):
				                $typ = 'Setting';
				                $txt = $hd->Text;
				            endif;
				        endforeach;
				        if($typ != '' && $txt != ''):
				?>
    				        <div class="sect-tab">
    							<div class="container-fluid2">
    								<h1>{{$typ}} </h1>
    								<?=$txt?>
    							</div>
    						</div>
				<?php
				        endif;
				    endfor;
				endif;
				?>
				<div id="section5" class="sect-tab" style="padding-top:0px;">
					<div class="container-fluid2">
						 <h1>Location</h1>
						 <?=$addrss?>
						 <div id="googleMap" style="width:100%;height:400px;"></div>
					</div>
				</div>
				<?php
				if(count($hotelDesc) > 0) :
				    for($f = 0; $f < 3; $f++):
				        $typ = '';
				        $txt = '';
				        foreach($hotelDesc as $hd) :
				            if($f == 0 && $hd->Type == 'AreaActivities'):
				                $typ = 'Nearby Attractions';
				                $txt = $hd->Text;
				            elseif($f == 1 && $hd->Type == 'DrivingDirections'):
				                $typ = 'Driving Directions';
				                $txt = $hd->Text;
				            elseif($f == 2 && $hd->Type == 'EssentialInfo'):
				                $typ = 'Essential Info';
				                $txt = $hd->Text;
				            elseif($f == 3 && $hd->Type == 'PoliciesDisclaimers'):
				                $typ = 'Hotel Policies';
				                $txt = $hd->Text;
				            endif;
				        endforeach;
				        if($typ != '' && $txt != ''):
				?>
    				        <div class="sect-tab">
    							<div class="container-fluid2">
    								<h1>{{$typ}} </h1>
    								<?=$txt?>
    							</div>
    						</div>
				<?php
				        endif;
				    endfor;
				endif;
				?>
				
				
				
				
				
				
				
				
				
				<div id="section9" class="sect-tab">
					<div  class="container-fluid2">
						<h1>Travellers Reviews</h1>
						<div class="container">
							<div class="row">
								<div class="col-sm-7">
									<div class="col-sm-6">
										<div class="rating-block">
											<?php
											$numberOfReviews    = 0;
											$totalStars         = 0;
								// 			echo "<pre>";
								// 			print_r($hotelreview); die;
											if(count($hotelreview) > 0):
    											foreach($hotelreview as $review) :
    												$numberOfReviews++;
    												$totalStars += $review->rating;
    											endforeach;
											endif;
											$average    = round(($numberOfReviews != 0) ? $totalStars/$numberOfReviews : 0);
											$sr         = ($hotel_data->stars != '') ? $hotel_data->stars : '0';
											?>
											<h4>Average Traveller Rating</h4>
											<h2 class="bold padding-bottom-7"><?php echo $sr; ?> <small>/ 5</small></h2>
											<?php
											for($c=1; $c <= 5; $c++){
												if($c <= $sr){
											?>
												<button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
													<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
												</button>
											<?php } else{ ?>
												<button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
													<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
												</button>
											<?php } } ?>
										</div>
									</div>
									<div class="col-sm-6">
										<h4>Rating breakdown</h4>
										<div class="pull-left">
											<div class="pull-left" style="width:35px; line-height:1;">
												<div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
											</div>
											<div class="pull-left" style="width:180px;">
												<div class="progress" style="height:9px; margin:8px 0;">
													<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 1000%">
														<span class="sr-only">80% Complete (danger)</span>
													</div>
												</div>
											</div>
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotelId, 5); ?></div>
										</div>
										<div class="pull-left">
											<div class="pull-left" style="width:35px; line-height:1;">
												<div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
											</div>
											<div class="pull-left" style="width:180px;">
												<div class="progress" style="height:9px; margin:8px 0;">
													<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: 80%">
														<span class="sr-only">80% Complete (danger)</span>
													</div>
												</div>
											</div>
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotelId, 4); ?></div>
										</div>
										<div class="pull-left">
											<div class="pull-left" style="width:35px; line-height:1;">
												<div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
											</div>
											<div class="pull-left" style="width:180px;">
												<div class="progress" style="height:9px; margin:8px 0;">
													<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: 60%">
														<span class="sr-only">80% Complete (danger)</span>
													</div>
												</div>
											</div>
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotelId, 3); ?></div>
										</div>
										<div class="pull-left">
											<div class="pull-left" style="width:35px; line-height:1;">
												<div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
											</div>
											<div class="pull-left" style="width:180px;">
												<div class="progress" style="height:9px; margin:8px 0;">
													<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: 40%">
														<span class="sr-only">80% Complete (danger)</span>
													</div>
												</div>
											</div>
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotelId, 2); ?></div>
										</div>
										<div class="pull-left">
											<div class="pull-left" style="width:35px; line-height:1;">
												<div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
											</div>
											<div class="pull-left" style="width:180px;">
												<div class="progress" style="height:9px; margin:8px 0;">
													<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: 20%">
														<span class="sr-only">80% Complete (danger)</span>
													</div>
												</div>
											</div>
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotelId, 1); ?></div>
										</div>
									</div>
									<hr/>
									<div class="clearfix"></div>
									<div class="review-block">
										<?php
										if(count($hotelreview) > 0):
										    echo "<pre>";
										  //  print_r($hotelreview);
										  //  die;
    										foreach($hotelreview as $review) :
										        $user_data = get_user_details($review->user_id);
										      //  echo "<pre>";
    										  //  print_r($user_data);
    										  //  die;
										?>
										<div class="row appendReview">
											<div class="col-sm-3">
												<?php if(isset($user_data->profile_image) && $user_data->profile_image!=""){ ?>
													@if(file_exists(Storage::disk('local')->url($user_data->profile_image)))
														<img src="{{ Storage::disk('local')->url($user_data->profile_image) }}" alt="{{ $review->user_id }}" class="img-rounded" width="60" height="60"/>
													@else
														<img src="{{ URL::to('/').'/public/frontend/images/timthumb.jpg' }}" alt="{{ $review->user_id }}" class="img-rounded" width="60" height="60"/>
													@endif
												<?php }else{ ?>
													<img src="{{ URL::to('/').'/public/frontend/images/timthumb.jpg' }}" alt="{{ $review->user_id }}" class="img-rounded" width="60" height="60"/>
												<?php } ?>
												<div class="review-block-name">{{ $user_data->first_name }} {{ $user_data->last_name }}</div>
												<div class="review-block-date">{{ date('d F, Y', strtotime($review->created_at)) }}</div>
											</div>
											<div class="col-sm-9">
												<div class="review-block-rate">
												    <?php 
													for($a = 1; $a <= 5 ; $a++ ):
													    if($a <= $review->rating):
													?>
        													<button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
        													    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        													</button>
													<?php else: ?>
        													<button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
        													    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        													</button>
													<?php endif; endfor; ?>
												</div>
												<div class="review-block-title">{{ $review->subjects }}</div>
												<div class="review-block-description">{{ $review->comments }}</div>
											</div>
										</div>
										<hr/>
										<?php endforeach; else: ?>
										<div class="row appendReview"><p>No reviews yet.</p></div>
									    <?php endif; ?>
									</div>
								</div>
								<div class="col-sm-5">
									<div class="row" style="margin-top:40px;">
										<?php if(get_loggedin_id() != 0) : ?>
											<div class="col-md-11">
												<div class="well well-sm">
													<div class="row" id="post-review-box" style="display:block;">
													<div class="form-group">
														<span id="review_success"></span>
													</div>
														<div class="col-md-12" id="reviewform">
															<form accept-charset="UTF-8" id="review_form">
																{{ csrf_field() }}
																<div class="form-group">
																	<input type="text" name="subjects" id="subjects" class="form-control" placeholder="Subject">
																</div>
																<div class="form-group">
																	<textarea class="form-control animated" cols="50" id="comment" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
																</div>
																<div class="form-group">
																	<div class="text-right">
																		<div class="stars starrr" data-rating="0"></div>
																		<input id="ratings-hidden" name="rating" type="hidden">
																	</div>
																</div>
																<div class="form-group">
																	<button class="btn btn-primary pull-right" type="submit">Submit</button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										<?php else : ?>
										    <p>Please login to send your review. <a href="{{ route('login') }}">Login</a></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<form id="hotelDetailsBackForm"  action="{{route('enroute.search')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="region_id" value="{{session('region_id')}}">
	<input type="hidden" name="fromFishing" value="{{session('fromFishing')}}">
	<input type="hidden" name="quantity_adults" value="{{session('quantity_adults')}}" />
	<input type="hidden" name="quantity_child" value="{{session('quantity_child')}}" />
	<input type="hidden" name="num_room" value="{{session('num_room')}}" />
	<input type="hidden" name="noguests" value="{{session('noguests')}}" />
	<input type="hidden" name="t_start" value="{{session('t_start')}}" />
	<input type="hidden" name="t_end" value="{{session('t_end')}}" />
	<input type="hidden" name="pageNo" value="{{$pageNo}}" />
	<input type="hidden" name="backHotelId" value="{{$hotelId}}" />
	<input type="hidden" name="rooms" value="" />
	<input type="hidden" name="keywords" value="{{session('keywords')}}" />
	<input type="hidden" name="ab" value="" />
</form>
<div class="modal fade" id="roomSelectModal" role="dialog">
	<div class="modal-dialog">
	  	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form id="roomSearchForm">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="roomSearchHotel" value="{{ $hotel_data->name }}" />
					<input type="hidden" name="hotelId" value="{{ $hotel_data->id }}" />
					<input type="hidden" name="roomSearchKeyword" value="{{$keyword}}" />
					<input type="hidden" name="region_id" value="{{session('region_id')}}" />
					<div class="form-group">
						<label for="roomSearchFromDate">From Date: </label>
						<input type="text" placeholder="yyyy-mm-dd" value="{{session('t_start')}}" min="{{date('Y-m-d')}}"  class="form-control" name="roomSearchFromDate" id="roomSearchFromDate">
					</div>
					<div class="form-group">
						<label for="roomSearchToDate">To Date: </label>
						<input type="text" placeholder="yyyy-mm-dd" value="{{session('t_end')}}" min="{{date('Y-m-d', strtotime("+1 day"))}}"  class="form-control" name="roomSearchToDate" id="roomSearchToDate">
					</div>
					<div class="form-group">
						<label>Room : </label>
						<div class="col-md-12">
							<input type="hidden" name="norm[]" value="1" />
							<div class="col-md-5">
								<select class="form-control" name="adlts[]">
									@for($i = 1; $i <= 6; $i++)
										<option value="{{ $i }}">{{ $i }} {{ ($i == 1) ? 'Adult' : 'Adults'}}</option>
									@endfor
								</select>
							</div>
							<div class="col-md-5">
								<select class="form-control" name="kids[]">
									@for($i = 0; $i <= 4; $i++)
										<option value="{{ $i }}">{{ $i }} {{ ($i == 0 || $i == 1) ? 'Child' : 'Children'}}</option>
									@endfor
								</select>
							</div>
						</div>
					</div>
					<div class="newRoomAppendDiv"></div>
				</form>
				<input type="hidden" id="roomRowCnt" value="1">
				<div class="form-group roomSearchAddRowDiv">
					<button type="button" class="btn btn-info" id="roomSearchAddRow" style="margin-top: 60px;">Add Room</button>
				</div>
				<div class="form-group modalError text-center"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success Viewbox" id="roomSearchBtn">Search</button>
			</div>
		</div>
  	</div>
</div>
<!--/////////////////////////////////////////-->
@endsection
@section('script')
<!--new-->
<script defer src="{{ asset('frontend/js/jquery.flexslider.js') }}"></script> 
<script defer src="{{ asset('frontend/js/script.flexslider.js') }}"></script> 
<script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script> 
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&libraries=places" async defer></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&callback=gMap" async defer></script>
<script>
function gMap() {
    let latlng = new google.maps.LatLng(<?=$hotel_data->latitude?>, <?=$hotel_data->longitude?>);
    let mapProp= {
      center:latlng,
      zoom:16,
      zoomControl: true,
    };
    let map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    let myMarker = new google.maps.Marker({
      position: latlng
    });
    myMarker.setMap(map);
}
$(function() {
	$('#roomSearchAddRow').on('click', function(e){
		e.preventDefault();
		let adultHtml = '';
		let kidHtml = '';
		for(let i = 1; i <= 6; i++){
		    let adlt = (i == 1) ? 'Adult' : 'Adults';
			adultHtml += '<option value="'+i+'">'+i+' '+adlt+'</option>';
		}
		for(let j = 0; j <= 4; j++){
			let kid = (j == 0 || j == 1) ? 'Child' : 'Children';
			kidHtml += '<option value="'+j+'">'+j+' '+kid+'</option>';
		}
		$('.newRoomAppendDiv').append('<div class="form-group newRoom' + $('#roomRowCnt').val() + '">\
										<label>Room : </label>\
										<div class="col-md-12">\
											<input type="hidden" name="norm[]" value="1" />\
											<div class="col-md-5">\
												<select class="form-control" name="adlts[]">\
												' + adultHtml + '\
												</select>\
											</div>\
											<div class="col-md-5">\
												<select class="form-control" name="kids[]">\
												' + kidHtml + '\
												</select>\
											</div>\
											<div class="col-md-2">\
												<button type="button" class="btn btn-danger roomSearchRemoveRow" data-row="' + $('#roomRowCnt').val() + '">Remove</button>\
											</div>\
										</div>\
									</div>');
		$('#roomRowCnt').val(parseInt($('#roomRowCnt').val()) + parseInt(1));
	});
	$('.roomAvailablity').on('click', function(e){
		e.preventDefault();
		$('#roomSelectModal').modal('show');
	});
	$('#roomSearchBtn').on('click', function(e){
		e.preventDefault();
		$('.modalError').empty();
		if($('#roomSearchFromDate').val() == ''){
			$('.modalError').html('<span style="color:red;">Please Select From Date !!!</span>');
			return false;
		}
		if($('#roomSearchToDate').val() == ''){
			$('.modalError').html('<span style="color:red;">Please Select To Date !!!</span>');
			return false;
		}
		if($('#roomSearchFromDate').val() >= $('#roomSearchToDate').val()){
			$('.modalError').html('<span style="color:red;">From Date must be lesser than To Date !!!</span>');
			return false;
		}
		$('#roomSearchForm').submit();
	});
});
    $("#review_form").submit(function (e) {
		e.preventDefault();
		let flg = true;
		if($('#subjects').val() == ''){
		    swalAlert("Subject is mandatory !!!", 'warning', 5000);
		    flg = false;
		    return false;
		}
		if($('#comment').val() == ''){
		    swalAlert("Comment is mandatory !!!", 'warning', 5000);
		    flg = false;
		    return false;
		}
		if($('#ratings-hidden').val() == ''){
		    swalAlert("Rating is mandatory !!!", 'warning', 5000);
		    flg = false;
		    return false;
		}
		if(flg){
		    var formData = new FormData(this);
    		$.ajax({
    			type        : "POST",
    			url         : '{{ route('hotel.add_review', ['id'=> $hotelId]) }}',
    			data        : formData,
    			cache       : false,
    			contentType : false,
    			processData : false,
    			dataType    : "JSON",
    			beforeSend  : function () {
    				$("#review_form").loading();
    				$(".appendReview").empty();
    			},
    			success: function (res) {
    				$("#review_form").loading("stop");
    				$(".appendReview").html(res.html);
    				$('#subjects').val('');
    				$('#comment').val('');
    				$('#ratings-hidden').val('');
    			},
    		});
		}
	});
	$("#roomSearchForm").submit(function (e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			type: "POST",
			url: '{{ route('stuba.fetch.room') }}',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
			beforeSend: function () {
				$('#roomSelectModal').modal('hide');
				$(".roomListAppend").empty();
				$(".roomListAppend").loading();
			},
			success: function (res) {
				$(".roomListAppend").loading("stop");
				$(".roomListAppend").html(res.html);
			},
		});
	});
	$(document).on('click', '.roomSearchRemoveRow', function () {
		$('.newRoom' + $(this).attr('data-row')).remove();
	});
	$(document).on('click', '.hotelDetailsBack', function () {
		$("#hotelDetailsBackForm").submit();
	});
	$(document).ready(function () {
		$("a[rel^='prettyPhoto']").prettyPhoto();
	});
	/*$(function() {
		$('#roomSearchForm').submit();
	});
	$("#roomSearchForm").submit(function (e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			type: "POST",
			url: '{{ route('stuba.fetch.room') }}',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
			beforeSend: function () {
				$(".roomListAppend").empty();
				$(".roomListAppend").loading();
			},
			success: function (res) {
				$(".roomListAppend").loading("stop");
				$(".roomListAppend").html(res.html);
			},
		});
	});*/
</script> 
<!--new-->
@endsection