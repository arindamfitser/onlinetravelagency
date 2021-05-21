@extends('frontend.layouts.app')
@section('css')
<!--new-->
<link rel="stylesheet" href="{{ asset('frontend/css/flexslider.css') }}" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('frontend/css/prettyPhoto.css') }}" type="text/css" />
<!--new-->
<style type="text/css">
    .booking_cancel{
        display: none;
    }
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
    div#myNavbar {width: 100%;float: left;}
    
    .main-slide-view .flex-viewport ul li {
    height: 547px;
}
.main-slide-view .flex-viewport ul li img {
    height: 100% !important;
    object-fit: contain;
}
  </style>
@endsection
@section('content')
<?php
// echo "<pre>";
// print_r($hotel); die;
$hotelDesc = json_decode(json_encode($hotel->hotelDesc), true);
// echo "<pre>";
// print_r($hotelDesc); die;
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
										<!-- <li><a href="#section1">Overview</a></li> -->
										<li><a href="#section2">Description</a></li>
										<li><a href="#section11">Curators Rating </a></li>
										<li><a href="#section3">Photos</a></li>
										<li><a href="#section99">Amenity</a></li>
										<li><a href="#section98">Activity</a></li>
										<li><a href="#section97">Tour</a></li>
										<li><a href="#section7">Fishing</a></li>
										<li><a href="#section6">Features</a></li>
										<li><a href="#section4">Rooms</a></li>
										{{-- <li><a href="#section10">Guides Or Charters</a></li> --}}
										<li><a href="#section5">Location</a></li>
										<li><a href="#section8">Important Informaton</a></li>
										<li><a href="#section9">Travellers Reviews</a></li>
									</ul>
								</div>
								@if(!empty($hotel->rooms))
									<div class="-cta-container pull-right">
										<form id="gotcarform" action="{{ route('hotel.cart') }}" method="post">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<input type="hidden" id="hotel_id" name="hotel_id" value="">
											<input type="hidden" id="start_date" name="start_date" value="">
											<input type="hidden" id="end_date" name="end_date" value="">
											<input type="hidden" id="quantity_adults" name="quantity_adults" value="">
											<input type="hidden" id="quantity_child" name="quantity_child" value="">
											<button type="button" id="goCart" class="btn_book_green" name="booknow">
												<span id="loadSpin"><i class="fa fa-spinner fa-spin"></i></span>  Book now
											</button>
										</form>
									</div>
								@endif
							</div>
						</div>
					</nav>
				</div>
				<!-- =======Description Section============ -->
				<div id="section2" class="sect-tab">
					<div class="container-fluid2">
						<h1>{{$hotel->hotels_name}}</h1>
						<?= $hotel->hotels_desc?>
						<br/>
						<?=(count($hotelDesc) > 0) ? ( (count($hotelDesc) == 1) ? $hotelDesc['Text'] : $hotelDesc[0]['Text']) : ''?>
						<div class="lakesidebox">
							<?php echo $hotel->highlights; ?>
						</div>
						<div class="hotel-detail-stats">
							<ul>
								@if(isset($hotel->no_of_rooms))
								<li>{{$hotel->no_of_rooms}} Rooms </li>
								@endif
								@if(isset($hotel->no_of_restaurant))
								<li>{{$hotel->no_of_restaurant}} Restaurants </li>
								@endif
								@if($hotel->spa_availability == 1)
								<li> SPA</li>
								@endif
								@if($hotel->fine_dining_availability == 1)
								<li> Fine Dining</li>
								@endif
								@if($hotel->beach_availability == 1)
								<li> Beach</li>
								@endif
								<div class="clearfix"></div>
							</ul>
						</div>
					</div>
				</div>
				<div id="section95" class="sect-tab">
					<div class="container-fluid2">
						<h1>Property Categories</h1>
					    <?php
					    $html = '';
					    $acm = json_decode(json_encode($hotel->accomodation), true);
        				if(count($acm) > 0) :
            				foreach($acm as $ac):
            				    $html .= '<li>' . $ac['accommodations_name'] . '</li>';
            				endforeach;
            			endif;
				        $inspiration = json_decode(json_encode($hotel->inspiration), true);
        				if(count($inspiration) > 0) :
        				    //echo "<pre>";
        				    //print_r($inspiration); die;
            				foreach($inspiration as $ip):
            				    if($ip['inspirations_id'] != '6' && $ip['inspirations_id'] != '7'):
            				        $html .= '<li>' . $ip['inspirations_name'] . '</li>';
            				    endif;
            				endforeach;
            			endif;
            			if($hotel->pool == 'yes'):
            			    $html .= '<li>Pool</li>';
            			endif;
            			$experience = json_decode(json_encode($hotel->experience), true);
        				if(count($experience) > 0) :
            				foreach($experience as $ip):
            				    if($ip['experiences_name'] == 'Purity & Tranquility' || 
            				    $ip['experiences_name'] == 'Fine Dining' || 
            				    $ip['experiences_name'] == 'Spa Resorts' || 
            				    $ip['experiences_name'] == 'Beach Resorts'):
            				        $html .= '<li>' . $ip['experiences_name'] . '</li>';
            				    endif;
            				endforeach;
            			endif;
					    if($html != ''):
					        print '<ul>' . $html . '</ul>';
					    endif;
					    ?>
					</div>
				</div>
				<!-- =============Curators Rating============= -->
				<div id="section11" class="sect-tab">
					<div class="container-fluid2">
						<h1>Curators Rating (<?php echo $hotel->curator_rating; ?>/100)</h1>
					</div>
				</div>
				<!-- ===============Photos======================= -->
				<div id="section3" class="sect-tab">
					<div class="container-fluid2">
						<h1>Photos</h1>
						<?php
						if(count($hotel->images) > 0) :
							if($stuba):
						?>
								<div class="slider-view">
									<div id="slider" class="flexslider main-slide-view">
										<ul class="slides">
											@foreach($hotel->images as $img)
											<li> <a href="https://www.stuba.com{{ $img->Url }}" rel="prettyPhoto[pp_gal]"><img src="https://www.stuba.com{{ $img->Url }}" alt="{{ $hotel->hotels_name }}"></a></li>
											@endforeach
										</ul>
									</div>
									<div  class="carousel flexslider thumble-slide-view">
										<ul class="slides">
											@foreach($hotel->images as $img)
											<li> <img src="https://www.stuba.com{{ $img->Url }}" alt="{{ $hotel->hotels_name }}"></li>
											@endforeach
										</ul>
									</div>
								</div>
						<?php
							else:
						?>
								<div class="slider-view">
									<div id="slider" class="flexslider main-slide-view">
										<ul class="slides">
											@foreach($hotel->images as $img)
											<li> <a href="{{url('public/uploads/' . $img->image)}}" rel="prettyPhoto[pp_gal]"><img
														src="{{url('public/uploads/' . $img->image)}}" alt="{{ $hotel->hotels_name }}"></a></li>
											@endforeach
										</ul>
									</div>
									<div class="carousel flexslider thumble-slide-view">
										<ul class="slides">
											@foreach($hotel->images as $img)
											<li> <img src="{{url('public/uploads/' . $img->image)}}" alt="{{ $hotel->hotels_name }}"></li>
											@endforeach
										</ul>
									</div>
								</div>
						<?php
							endif;
						endif;
						?>
					</div>
				</div>
				<div id="section99" class="sect-tab">
					<div class="container-fluid2">
						<h1>Amenities Services  & Features</h1>
					    <?php
					    if(!empty($hotel->services_amenities)):
					        print '<ul>';
					        $am = explode(',', $hotel->services_amenities);
					        foreach($am as $a):
					            //print '<i class="fa fa-check-circle" aria-hidden="true"></i> <li>'. $a .'</li>';
					            print '<li>'. $a .'</li>';
					        endforeach;
					    endif;
					    ?>
					    <br/>
					    <?php
					    if(count($hotelDesc) > 0) :
        				    $chk = 0;
            				foreach($hotelDesc as $hd):
            				    if($hd['Type'] == 'PropertyInformation' && $chk == 0):
            				        print $hd['Text'];
                					$chk++;
            				    endif;
            				endforeach;
            			endif;
            			?>
					</div>
				</div>
				<div id="section98" class="sect-tab">
					<div class="container-fluid2">
						<h1>Activities</h1>
					    <?php
					    if(!empty($hotel->activities)):
					        print '<ul>';
					        $am = explode(',', $hotel->activities);
					        foreach($am as $a):
					            //print '<i class="fa fa-check-circle" aria-hidden="true"></i> <li>'. $a .'</li>';
					            print '<li>'. $a .'</li>';
					        endforeach;
					    endif;
					    ?>
					</div>
				</div>
				<div id="section97" class="sect-tab">
					<div class="container-fluid2">
						<h1>Tours & External Activities</h1>
					    <?php
					    if(!empty($hotel->tours)):
					        print '<ul>';
					        $am = explode(',', $hotel->tours);
					        foreach($am as $a):
					            if($a != ''):
					            //print '<i class="fa fa-check-circle" aria-hidden="true"></i> <li>'. $a .'</li>';
					                print '<li>'. $a .'</li>';
					           endif;
					        endforeach;
					    endif;
					    ?>
					</div>
				</div>
				<?php
				if(count($hotelDesc) > 0) :
				    $chk = 0;
    				foreach($hotelDesc as $hd):
    				    if($hd['Type'] == 'DiningFacilities' && $chk == 0):
    				        print '<div class="sect-tab">
        							<div class="container-fluid2">
        								<h1>Dining</h1>
        								' . $hd['Text'] . '
        							</div>
        						</div>';
        					$chk++;
    				    endif;
    				endforeach;
    			endif;
				?>
				<!-- =============Fishing============= -->
				<div id="section7" class="sect-tab">
					<div class="container-fluid2">
						<h1>Fishing</h1>
						<p><?php echo $hotel->fishing; ?></p>
						<p><strong>SPECIES</strong> – <?php echo $hotel->species; ?></p>
						<p><strong>FISHING SEASON</strong> – <?php echo $hotel->activity_season; ?>
						</p>
					</div>
				</div>
				<div id="section96" class="sect-tab">
					<div class="container-fluid2">
						<h1>Fishing Categories</h1>
					    <?php
					    $html = '';
				        $inspiration = json_decode(json_encode($hotel->inspiration), true);
        				if(count($inspiration) > 0) :
            				foreach($inspiration as $ip):
            				    $html .= '<li>' . $ip['inspirations_name'] . '</li>';
            				endforeach;
            			endif;
    				    $exp = json_decode(json_encode($hotel->experience), true);
        				if(count($exp) > 0) :
            				foreach($exp as $ep):
            				    if($ep['experiences_id'] != '5' && $ep['experiences_id'] != '6' && $ep['experiences_id'] != '8'):
            				        $html .= '<li>' . $ep['experiences_name'] . '</li>';
            				    endif;
            				endforeach;
            			endif;
					    if($html != ''):
					        print '<ul>' . $html . '</ul>';
					    endif;
					    ?>
					</div>
				</div>
				<!-- ============Features================== -->
				<div id="section6" class="sect-tab">
					<div class="container-fluid2">
						<h1>Room Features</h1>
						<div class="Featuresbox">
							@if ( !empty($hotel->features))
							<ul>
								@foreach ( $hotel->features  as $features)
								<li>
									<img src="{{( isset($features->icons) ?  Storage::disk('local')->url('app/public/uploads/icons/'.$features->icons) : 'https://dummyimage.com/92x92/000000/fff.png&text=Icon' )}}" alt="{{ $features->name }})">
									<h5> {{ $features->name }} </h5>
								</li>
								@endforeach
							</ul>
							@else
						      {{ 'No features found' }}
							@endif
						</div>
						<div class="faqbox">
							<div class="panel-group" id="accordion">
								<!-- /.panel -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">Check in / check out</a> </h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
										<div class="panel-body">
											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
												<div class="check-in-out clearfix">
													<div class="pull-left">
														<h4><strong>Check In</strong></h4>
														<p>@if(isset($hotel->check_in)){{ $hotel->check_in }}@else {{ ' - ' }}@endif</p>
													</div>
													<div class="pull-right">
														<h4><strong>Check Out</strong></h4>
														<p>@if(isset($hotel->check_out)){{ $hotel->check_out }}@else {{ ' - ' }}@endif</p>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"> </div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
												<div class="border">
													<p>Join <b><a href="{{ route('register') }}" class="club">INVITED</a></b> and get 10% off exclusive rates. Plus early check-in and late check-outs among other benefits.</p>
													<p><b><a target="_blank" href="{{ route('login') }}" class="club">SIGN IN HERE</a></b></p>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								<!-- /.panel -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false"> Services & Facilities </a> </h4>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<?php //print_r($hotel->servicefacilities); ?>
												@if(!empty($hotel->servicefacilities))
													<ul class="feature-accordion__list">
														@foreach($hotel->servicefacilities as $servicefacilities)
														<li><span>{{ $servicefacilities->name }}</span></li>
														@endforeach
													</ul>
												  @else
						      						{{ 'No record found' }}
												 @endif
										</div>
									</div>
								</div>
								<!-- /.panel -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false">Room Facilities</a> </h4>
									</div>
									<div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											@if(!empty($hotel->roomfacilities))
											<ul class="feature-accordion__list">
												@foreach($hotel->roomfacilities as $roomfacilities)
												<li><span>{{ $roomfacilities->name }}</span></li>
												@endforeach
											</ul>
											@else
						      					{{ 'No record found' }}
											@endif
										</div>
									</div>
								</div>
								<!-- /.panel -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false">Recreation</a> </h4>
									</div>
									<div id="collapseFour" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											@if(!empty($hotel->recreations))
											<ul class="feature-accordion__list">
												@foreach($hotel->recreations as $recreation)
												<li><span>{{ $recreation->name }}</span></li>
												@endforeach
											</ul>
											@else
						      						{{ 'No record found' }}
											@endif
										</div>
									</div>
								</div>
								<!-- /.panel -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false"> Awards </a> </h4>
									</div>
									<div id="collapseFive" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											@if(!empty($hotel->hotelawards))
											<p>This hotel has been awarded:</p>
											<ul>
												@foreach($hotel->hotelawards as $award)
												<li><strong>{{ $award->award_title }}</strong></li>
												@endforeach
											</ul>
											@else
						      						{{ 'No record found' }}
											@endif
										</div>
									</div>
								</div>
								<!-- /.panel -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false">Food and Drink</a> </h4>
									</div>
									<div id="collapseSix" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<div class="feature-accordion__main" style="display: block;">
											<?php echo $hotel->food_drink; ?>
												@if(!empty($hotel->food_drinks))
													@foreach($hotel->food_drinks as $food_drink)
													<h5>{{ $food_drink->food_title }}</h5>
													<p><strong>Cuisine type: </strong>{{ $food_drink->cusine_type }}</p>
													<p><strong>Meals served: </strong>{{ $food_drink->meal_served }}</p>
													<p>{{ $food_drink->food_drink_descp }}</p>
													@endforeach
												@else
						      						{{ 'No record found' }}
											@endif
											</div>
										</div>
									</div>
								</div>
								<!-- /.panel -->
							</div>
						</div>
					</div>
				</div>
				<!-- ===============Rooms=============== -->
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
				    $chk = 0;
    				foreach($hotelDesc as $hd):
    				    if($hd['Type'] == 'SurroundingArea' && $chk == 0):
    				        print '<div class="sect-tab">
        							<div class="container-fluid2">
        								<h1>Setting</h1>
        								' . $hd['Text'] . '
        							</div>
        						</div>';
        					$chk++;
    				    endif;
    				endforeach;
    			endif;
				?>
				<!-- =================GUIDES OR CHARTERS================ -->
				<!-- ==============Location===================== -->
				<div id="section5" class="sect-tab">
					<div class="container-fluid2">
						<h1>Location</h1>
						<div>
							<div class="MAPbox1">
								<h2>MAP</h2>
								<div id="map" style="min-height: 250px"></div>
							</div>
							<div class="MAPbox2">
								<div class="box1">
									<h2>Transfers</h2>
									<?php
									$transfers = explode(", ", $hotel->transfers_mode);
									?>
									<ul>
										<li><img src="{{ asset('frontend') }}/images/Road.png" alt=""><?php echo $hotel->transfers_mode; ?> </li>
										<!-- @for ($i = 0; $i < count($transfers) ; $i++)
										@switch($transfers[$i])
										@case('Road')
										<li><img src="{{ asset('frontend') }}/images/Road.png" alt="">{{ $transfers[$i] }} </li>
										@break
										@case('Train')
										<li><img src="{{ asset('frontend') }}/images/Train.png" alt="">{{ $transfers[$i] }} </li>
										@break
										@case('Helicopter')
										<li><img src="{{ asset('frontend') }}/images/Helicopter.png" alt="">{{ $transfers[$i] }} </li>
										@break
										@default
										<li><img src="" alt="">{{ $transfers[$i] }} </li>
										@endswitch
										@endfor -->
									</ul>
								</div>
								<div class="box1">
									<h2>Nearest airport</h2>
									<ul>
										<li><img src="{{ asset('frontend') }}/images/Butte.png" alt=""> @if(isset($hotel->nearest_airport)){{ $hotel->nearest_airport }}@else {{ 'None' }}@endif</li>
									</ul>
								</div>
								<div class="box1">
									<h2>Distance</h2>
									<ul>
										<li><img src="{{ asset('frontend') }}/images/kMS.png" alt=""> @if(isset($hotel->distance_airport)){{ $hotel->distance_airport }}@else {{ ' - ' }}@endif</li>
									</ul>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
				
				<?php
				if(count($hotelDesc) > 0) :
    				$chk = 0;
    				foreach($hotelDesc as $hd):
    				    if($hd['Type'] == 'AreaActivities' && $chk == 0):
    				        print '<div class="sect-tab">
        							<div class="container-fluid2">
        								<h1>Nearby Attractions</h1>
        								' . $hd['Text'] . '
        							</div>
        						</div>';
        					$chk++;
    				    endif;
    				endforeach;
    			endif;
				?>
				
				<!-- ===========Important Informaton============ -->
				<div id="section8">
					<div class="container-fluid2">
						<h1>Important Informaton</h1>
						<div class="faqbox">
							<div class="panel-group" id="accordion">
								@if($hotel->deposit_policy !="")
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseDeposit" aria-expanded="false">Deposit Policy</a> </h4>
									</div>
									<div id="collapseDeposit" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<div class="feature-accordion__main" style="display: block;">
												<?php echo $hotel->deposit_policy; ?>
											</div>
										</div>
									</div>
								</div>
								@endif
								@if($hotel->cancellation_policy !="")
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseCancellation" aria-expanded="false">Cancellation Policy</a> </h4>
									</div>
									<div id="collapseCancellation" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<div class="feature-accordion__main" style="display: block;">
												<?php echo $hotel->cancellation_policy; ?>
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- ===================Reviews================== -->
				<div id="section9" class="sect-tab">
					<div  class="container-fluid2">
						<h1>Travellers Reviews</h1>
					
							<div class="row">
								<div class="col-sm-7">
									<div class="col-sm-6">
										<div class="rating-block">
											<?php
											$numberOfReviews = 0;
											$totalStars = 0;
											if(!empty($hotel->hotelreview)):
												foreach($hotel->hotelreview as $review):
													$numberOfReviews++;
													$totalStars += $review->rating;
												endforeach;
											endif;
											if($numberOfReviews != 0){
												$average = $totalStars/$numberOfReviews;
											}else{
												$average = 0;
											}
											$average    = round($average);
											$stubaDet   = json_decode(json_encode($hotel->stubaDet), true);
											$sr         = (!empty($stubaDet)) ? ($stubaDet['stars'] != '' ? $stubaDet['stars'] : '0') : $average;
											?>
											<h4>Average Traveller Rating</h4>
											<h2 class="bold padding-bottom-7"><?php echo $sr; ?> <small>/ 5</small></h2>
											<?php
                                            for($s = 1; $s <= 5; $s++){
                                                if($s <= $sr){
                                                print ' <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
        													<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        												</button>';
                                                }else{
                                                print ' <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
        													<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        												</button>';
                                                }
                                            } ?>
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
													<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 100%">
														<span class="sr-only">80% Complete (danger)</span>
													</div>
												</div>
											</div>
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotel->id, 5); ?></div>
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
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotel->id, 4); ?></div>
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
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotel->id, 3); ?></div>
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
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotel->id, 2); ?></div>
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
											<div class="pull-right" style="margin-left:10px;"><?php echo get_rating_count($hotel->id, 1); ?></div>
										</div>
									</div>
								    <div class="col-sm-12">
								        <div class="review-block">
									    <?php
									    if(count($hotel->hotelreview) > 0):
    										foreach($hotel->hotelreview as $hotelreview) :
										        $user_data = get_user_details($hotelreview->user_id);
										?>
										<div class="appendReview">
											<div class="col-sm-3">
												<?php if($user_data->profile_image!=""){ ?>
													@if(file_exists(Storage::disk('local')->url($user_data->profile_image)))
														<img src="{{ Storage::disk('local')->url($user_data->profile_image) }}" alt="{{ $hotelreview->name }}" class="img-rounded" width="60" height="60"/>
													@else
														<img src="{{ URL::to('/').'/public/frontend/images/timthumb.jpg' }}" alt="{{ $hotelreview->name }}" class="img-rounded" width="60" height="60"/>
													@endif
												<?php }else{ ?>
													<img src="{{ URL::to('/').'/public/frontend/images/timthumb.jpg' }}" alt="{{ $hotelreview->name }}" class="img-rounded" width="60" height="60"/>
												<?php } ?>
												<div class="review-block-name">{{ $user_data->first_name }} {{ $user_data->last_name }}</div>
												<div class="review-block-date">{{ date('d F, Y', strtotime($hotelreview->created_at)) }}</div>
											</div>
											<div class="col-sm-9">
												<div class="review-block-rate">
													<?php for($a=0; $a < $hotelreview->rating; $a++ ){ ?>
													<button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
													<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
													</button>
													<?php } ?>
													<?php for($b=0; $b < (5 - $hotelreview->rating); $b++ ){ ?>
													<button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
													<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
													</button>
													<?php } ?>
												</div>
												<div class="review-block-title">{{ $hotelreview->subjects }}</div>
												<div class="review-block-description">{{ $hotelreview->comments }}</div>
											</div>
										</div>
										<hr/>
										<?php endforeach; else: ?>
										<div class="appendReview"><p>No reviews yet.</p></div>
									    <?php endif; ?>
									</div>
								    </div>
									
								</div>
								<div class="col-sm-5">
									<div class="row" style="margin-top:40px;">
										@if(get_loggedin_id() != 0)
										<?php if(!review_exits($hotel->id)){ ?>
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
										<?php } ?>
										@else
										<p>Please login to send your review. <a href="{{ route('login') }}">Login</a></p>
										@endif
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
						<input type="hidden" name="roomSearchHotel" value="{{ $hotel->hotels_name }}" />
						<input type="hidden" name="roomSearchKeyword" value="{{session('keywords')}}" />
						<input type="hidden" name="roomStubaId" value="{{$hotel->stuba_id}}" />
						<div class="form-group">
							<label for="roomSearchFromDate">From Date: </label>
							<input type="date" placeholder="yyyy-mm-dd" value="{{session('t_start')}}" min="{{date('Y-m-d')}}"  class="form-control" name="roomSearchFromDate" id="roomSearchFromDate">
						</div>
						<div class="form-group">
							<label for="roomSearchToDate">To Date: </label>
							<input type="date" placeholder="yyyy-mm-dd" value="{{session('t_end')}}" min="{{date('Y-m-d', strtotime("+1 day"))}}"  class="form-control" name="roomSearchToDate" id="roomSearchToDate">
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
	<input type="hidden" id="hotelAddress" value="<?=($hotel->hoteladdress->location) ? $hotel->hoteladdress->location : ''?>">
	<!--/////////////////////////////////////////-->
	@endsection
	@section('script')
	<!--new-->
	<script defer src="{{ asset('frontend/js/jquery.flexslider.js') }}"></script>
	<script defer src="{{ asset('frontend/js/script.flexslider.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo" async defer></script>
	<script>
	$(document).ready(function () {
        var map = null;
        var myMarker;
        var myLatlng;
        initializeGMap($('#hotelAddress').val());
        function initializeGMap(address) {
            if(address != ''){
                address = address.replace("%20", "+");
                $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&address='+address+'&sensor=false', null, function (data) {
                    var p = data.results[0].geometry.location;
                    myLatlng = new google.maps.LatLng(p.lat, p.lng);
                    var myOptions = {
                                        zoom: 14,
                                        zoomControl: true,
                                        center: myLatlng,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };
                    map = new google.maps.Map(document.getElementById("map"), myOptions);
                    myMarker = new google.maps.Marker({
                        position: myLatlng
                    });
                    myMarker.setMap(map);
                });
            }
        }
	});
	</script>
	
	<script>
	$(function() {
		// $('#roomSearchFromDate').datepicker({
		// 	dateFormat: 'yy-mm-dd',
		// 	changeMonth: true,
		// 	changeYear: true,
		// 	minDate: 0
		// });
		// $('#roomSearchToDate').datepicker({
		// 	dateFormat: 'yy-mm-dd',
		// 	changeMonth: true,
		// 	changeYear: true,
		// 	minDate: +1
		// });
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
    			url         : '{{ route('hotel.add_review', ['id'=> $hotel->id]) }}',
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
			url: '{{ route('destination.fetch.room') }}',
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
	</script>
	
	
	
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$('#goCart').on('click', function(){
			$('#loadSpin').show();
			setTimeout(
				function()
				{
					$('#gotcarform').find('input#hotel_id').val({{$hotel->id}});
					$('#gotcarform').find('input#start_date').val(localStorage.getItem('t_start'));
					$('#gotcarform').find('input#end_date').val(localStorage.getItem('t_end'));
					$('#gotcarform').find('input#quantity_adults').val(localStorage.getItem('quantity_adults'));
					$('#gotcarform').find('input#quantity_child').val(localStorage.getItem('quantity_child'));
					$('#loadSpin').hide();
					$('#gotcarform').submit();
				}, 2000);
		});
		$('form[id="review_form"]').validate({
			ignore: [],
			rules: {
				subjects: {
					required: true
				},
				comment: {
					required: true
				},
				rating: {
					required: true
				}
			},
			submitHandler: function(form){
				$.ajax({
					type     : $(form).attr('method'),
					url      : $(form).attr('action'),
					data     : $(form).serialize(),
					cache    : false,
					success  : function(data) {
						var data = $.parseJSON(data);
						if(data.status == 1){
							
							$('form[id="review_form"]').trigger("reset");
							 setTimeout(function(){ 
								//location.reload(true);
								$("#review_success").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Thank you!</strong> Your review  waiting for approval ! appear soon.</div>');
								$("#reviewform").hide()
								
							 }, 1000);
							

						}
					}
				});
			}
		});
	</script>
	@endsection