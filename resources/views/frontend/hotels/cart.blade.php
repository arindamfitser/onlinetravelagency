	@extends('frontend.layouts.app')
	 @section('css')
	<!--new-->
	<link rel="stylesheet" href="{{ asset('frontend/css/cardForm.css') }}" type="text/css" media="screen" />
	<!--new-->
     @endsection
	@section('content')
	<?php 
	$user = auth('web')->user();
	if($user){
		$user = App\User::where('id', $user->id)->get()->first();
		$first_name=$user['first_name'];
		$last_name=$user['last_name'];
		$mobile_number=$user['mobile_number'];
		$email=$user['email'];
		$address=$user['address'];
		$address_2 =$user['address_2 '];
		$city=$user['city'];
		$zipcode=$user['zipcode'];
		$country_code=$user['country_code'];
	}else{
		$first_name='';
		$last_name='';
		$mobile_number='';
		$email='';
		$address='';
		$address_2 ='';
		$city='';
		$zipcode='';
		$country_code=0;
	}
	?>
	<!--/////////////////////////////////////////-->
	<section class="innerbannersection">
	</section>
	<?php //var_dump($hotels);?>
	<section class="booking_wrapper" id="header_fixed">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
					<div class="bkr_left">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="inactive"><a href="" aria-controls="" role="tab" ><span>0</span> Hotels</a></li>
							<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" ><span>1</span> Rooms</a></li>
							<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" ><span>2</span>Guest Details</a></li>
							<li role="presentation"><a href="#messages" aria-controls="messages" role="tab"><span>3</span>Payment</a></li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content cart_tab_panel">
							<div role="tabpanel" class="tab-pane active" id="home">
								<div class="tab_content_top">
									<h3>Choose a Room</h3>
								</div>
								<?php 
								if($rooms){
								 foreach($rooms as $room){
									if(count($room)==$nights){ ?>
										<div class="tab_content_box">
											<div class="tbc_pic">
												@if(file_exists(Storage::disk('local')->url($room[0]['featured_image'])))
													<img src="{{ Storage::disk('local')->url($room[0]['featured_image']) }}" alt="{{ $room[0]['name'] }}"/>
												@else
													<img src="{{ URL::to('/').'/public/frontend/images/timthumb.jpg' }}" alt="{{ $room[0]['name'] }}"/>
												@endif
											</div>
											<div class="tbc_pic_info">
												<a href="javascript:void(0);"><?php echo $room[0]['name'] ?></a>
												 <ul>
													<li><img src="{{ asset('frontend') }}/images/tab-icon1.png" alt="" /> <?php echo $room[0]['adult_capacity'] ?> Guests</li>
													<li><img src="{{ asset('frontend') }}/images/tab-icon2.png" alt="" /> <?php echo $room[0]['extra_bed'] ?>  Bed</li>
												</ul>
												<p><?php echo substr( strip_tags($room[0]['descp']), 0 ,200) ?></p>
											</div>
											<div class="tbc_pic_right">
												<?=($room[0]['base_price'] != $room[0]['price']) ? '<h2><span>'.getPrice($room[0]['base_price']).'</span></h2>' : ''?>
												<h3><?php echo getPrice($room[0]['price'])?></h3>
												<h4>Average Per Night</h4>
												<!-- <h2>Including Taxes & Fees</h2> -->
												<form id="addtocartForm_<?php echo $room[0]['room_id'] ?>" class="carform" action="{{ route('hotel.cart') }}" method="get">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden"  id="hotel_id" name="hotel_id" value="<?php echo $room[0]['hotel_id'] ?>">
													<input type="hidden" id="room_id" name="room_id" value="<?php echo $room[0]['room_id'] ?>">
													<input type="hidden" id="user_id" name="user_id" value="<?php echo get_loggedin_id()?>">
													<input type="hidden" id="base_price" name="base_price" value="<?php echo $room[0]['base_price'] ?>">
													<input type="hidden" id="price" name="price" value="<?php echo $room[0]['price'] ?>">
													<input type="hidden" id="nights" name="nights" value="{{$nights}}">
													<input type="hidden" id="check_in" name="check_in" value="{{$hotels['check_in']}}">
													<input type="hidden" id="check_out" name="check_out" value="{{$hotels['check_out']}}">
													<input type="hidden" class="start_date" id="start_date" name="start_date" value="">
													<input type="hidden" class="end_date"  id="end_date" name="end_date" value="">
													<input type="hidden"  class="quantity_adults" id="quantity_adults" name="quantity_adults" value="">
													<input type="hidden" class="quantity_child"  id="quantity_child" name="quantity_child" value="">
													<input type="hidden" class="deviceid"  id="deviceid" name="deviceid" value="">
													<button type="button" id="add2CartBtn_<?php echo $room[0]['room_id'] ?>" class="btn_book addtocart" name="booknow" id="">
													<span class="loadSpin" id="loadSpin_<?php echo $room[0]['room_id'] ?>"><i class="fa fa-spinner fa-spin"></i></span>  Book now
													</button>
												</form> 
											</div>
										</div>
									<?php }
							        }
							     }else{
                                   echo '<span class="norecord">No record found</span>';
							     } 
								?>
							</div>
							<div role="tabpanel" class="tab-pane" id="profile">
								<div class="tab_form">
									<form id="cartform" name="cartform" method="post" >
										<div class="row">
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
												<h2>Contact Info</h2>
												<div class="form-group">
													<select class="form-control" name="title" id="title">
														<option value="Mr.">Mr</option>
														<option value="Mrs.">Mrs</option>
														<option value="Dr.">Dr</option>
														<option value="Ms">Ms</option>
													</select>
												</div>
												<div class="form-group">
													<input type="text" class="form-control" placeholder="First Name*" name="first_name" id="first_name" value="{{$first_name}}">
												</div>
												<div class="form-group"> 
													<input type="text" class="form-control" placeholder="Surname*" name="surname" id="surname" value="{{$last_name}}">
												</div>
												<div class="form-group"> 
													<input type="text" class="form-control" placeholder="Phone" name="mobile_number" id="mobile_number" value="{{$mobile_number}}">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Email Address*" name="email" id="email" value="{{$email}}"  >
												</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="address">
												<h2>Address</h2>
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address 1" id="street_number" name="address_1" value="{{$address}}">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address 2" id="route" name="address_2" value="{{$address_2}}">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" placeholder="City" id="locality" name="city" value="{{$city}}">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Zip / Postcode" id="postal_code" name="zipcode" value="{{$zipcode}}">
												</div>
												<div class="form-group">
													<select class="form-control" id="country" name="country">
														<?php countryOption($country_code);?>
													</select>
												</div>
											</div>
											<div id="cart_item_value"></div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h2>Additional Details</h2></div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left option_txt">
												<h3>SPECIAL REQUESTS (Optional)</h3>
												<textarea name="booking_comment" class="form-control" placeholder="Please note your requests or special needs. "></textarea>
											</div>
											<div class="cartfields">
												<input type="hidden" id="totalprice" name="totalprice" value="">
												<input type="hidden" id="currency" name="currency" value="<?php echo getCurrency();?>">
												<input type="hidden" class="start_date" id="cart_hotel_id" name="hotel_id" value="{{$hotel_id}}">
												<input type="hidden" class="cart_start_date" id="start_date" name="start_date" value="">
												<input type="hidden" class="cart_end_date"  id="end_date" name="end_date" value="">
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<h2>Policies:</h2>
														<div class="bkr_rht_top">
															<p>GUARANTEE / DEPOSIT POLICY <br>All reservations must be guaranteed with a valid credit card. </p>
															<p>CANCEL POLICY <br>Cancel by 12PM (noon) - local time - 1 day prior to arrival to avoid 1 night penalty fee. </p>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h2>Acknowledgement</h2></div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="form-group">
																<input type="checkbox" id="newsletters" name="newsletters" value="">
																<label>I would like to receive newsletters and special offers by email.</label>
															</div>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="form-group">
																<input type="checkbox" id="booking_conditions" name="booking_conditions" value="">
																<label>I  agree with the above <a href="{{URL('terms-conditions')}}" target="_blank">Booking Conditions.</a></label>
															</div>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="form-group">
																<input type="checkbox" id="privacy_policies" name="privacy_policies" value="">
																<label>I agree with the <a href="{{URL('privacy-policy')}}" target="_blank">Privacy Policies.</a></label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
									<div class="contbutton">
									    <button type="button" id="cartConinue" name="cartConinue">
										<span class="loadSpin" id="loadSpin_cart"><i class="fa fa-spinner fa-spin"></i></span>Continue</button>
									 </div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="messages">
								<div class="tab_thankyou">
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<div class="panel-group">
												<div class="panel panel-default">
												    <div class="pi_div">
												    	<h3>Personal information</h3>
												    </div>
												    <div id="customer_info"></div>
												    <div class="pay_type_div">
												    	<h3>Payment Type</h3>
												    </div>
												    
												    <div class="row clearfix">
												    	<div class="col-sm-6 col-xs-6">
												    		
												    	</div>
												    </div>
												    
												    <!---->
												    <div class="cart_pay_button_area clearfix">
												    	<div class="col-sm-6 col-xs-6 cart_pay_button_box">
												    		<a class="paybtn" data-toggle="modal" data-target="#myModal" href="#collapse1">Pay at Hotel</a>
												    	</div>
												    	<div class="col-sm-6 col-xs-6 cart_pay_button_box">
												    		<a class="paybtn" data-toggle="modal" data-target="#myModal_second" href="#collapse1">Pay Now</a> 
												    	</div>
												    </div>
												    
												    
												    
												    <!--<a class="paybtn" data-toggle="modal" data-target="#myModal" href="#collapse1">Pay at Hotel</a>
												    <a class="paybtn" data-toggle="modal" data-target="#myModal_second" href="#collapse1">Pay Now</a> --> 
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4" id="cart_box">
					<div class="bkr_right">
						<div id="cart_loading"><img src="{{ asset('frontend') }}/images/cart-loading.gif" alt="" /></div>
						<div id="cartBody">
						  <div class="cart_check_field">
							    
							    <div class="form_box_medium search_box_comman">
						          <div class="t-datepicker">
						            <div class="t-check-in">
						              <input type="text" class="" name="check_in" id="check_in_cart" >
						            </div>
						            <div class="t-check-out">
						              <input type="text" class="" name="check_out" id="check_out_cart" >
						            </div>
						          </div>
						        </div>

						        <!--<div class="form_box_small search_box_comman">
						          <div class="input-group adult_input"> <span class="input-group-btn">
						            <button type="button" class="quantity-left-minus btn btn-number"  data-type="minus" data-field=""> <span class="glyphicon glyphicon-minus"></span> </button>
						            </span>
						            <div class="quantity_inp quantity_inp_adult">
						              <input type="text" id="quantity_cart" name="quantity_adults" class="form-control input-number" value="2 Adult" >
						            </div>
						            <span class="input-group-btn">
						            <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field=""> <span class="glyphicon glyphicon-plus"></span> </button>
						            </span> 
						          </div>
						        </div>

						        <div class="form_box_small_children search_box_comman form_box_child">
						          <div class="input-group adult_input"> <span class="input-group-btn">
						            <button type="button" class="quantity-left-minus-child btn btn-danger btn-number"  data-type="minus" data-field=""> <span class="glyphicon glyphicon-minus"></span> </button>
						            </span>
						            <div class="quantity_inp quantity_inp_child">
						              <input type="text" id="quantity_child_cart" name="quantity_child" class="form-control input-number" value="0 Child" >
						               
						            </div>
						            <span class="input-group-btn">
						            <button type="button" class="quantity-right-plus-child btn btn-success btn-number" data-type="plus" data-field=""> <span class="glyphicon glyphicon-plus"></span> </button>
						            </span> 
						           </div>
						        </div> -->
					        </div>
						    <div id="cart_hotel_details"></div>
							
							  <div class="bkr_rht_top">
								<div class="check_in"> <i class="fa fa-long-arrow-right"></i>{{$startdate}} <span> check in  {{$hotels['check_in']}}</span></div>
								<div class="check_out"> <i class="fa fa-long-arrow-left"></i>{{$enddate}} <span> check out {{$hotels['check_out']}}</span></div>
							  </div>

							  <div class="bkr_rht_middle">
								<div id="cartItems"></div>
								<div class="infolinks">
									<span onclick="goCartTab();"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a room</span>
								</div>
							  </div>

							 <div class="bkr_rht_bottom price_part">
								<ul>
									<li><strong>Payable Amount</strong></li>
									<li><strong><span><?php echo getCurrency();?></span><span id="cartprice">0.00</span></strong></li>
								</ul>
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</section>
		<!--/////////////////////////////////////////-->
		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Pay On Hotel <div class="pricehtml"></div></h4>
		      </div>
		      <div class="modal-body paymodal">
		      <form id="payment-form" action="{{ route('payment.checkout.cashon') }}" method="post">
		        <ul>
		            <li><a class="paymentopt" id="cash_pay" href="JavaScript:Void(0);"><i class="fa fa-money" aria-hidden="true"></i>Cash pay <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
		        	<li><a class="paymentopt" id="credit_card" href="JavaScript:Void(0);"><i class="fa fa-credit-card" aria-hidden="true"></i> Credit Card <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
		        	<li><a class="paymentopt" id="debit_card" href="JavaScript:Void(0);"><i class="fa fa-cc-visa" aria-hidden="true"></i> Debit Card <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
		        	<li><a class="paymentopt" id="Net_banking" href="JavaScript:Void(0);"><i class="fa fa-television" aria-hidden="true"></i> Net Banking <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
		        	<li><a class="paymentopt" id="paytm" href="JavaScript:Void(0);"><i class="fa fa-credit-card" aria-hidden="true"></i> Paytm <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
		        </ul>
		         {{ csrf_field() }}
					<input type="hidden" name="payment_type" value="payathotel">
					<input type="hidden" id="payment_opt" name="payment_opt" value="">
					<div class="payment_fields" id="cash_payment-fields"></div>
					<button id="submit_button" disabled=""> Continue</button> 
				</form>
														
		      </div>
		    </div>
		  </div>
		</div>

		<div id="myModal_second" class="modal fade payment_modal" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Pay Now <div class="pricehtml"></div></h4>
		      </div>
		       <div class="modal-body paymodal">
				<!-- <form id="payment-form" action="{{ route('payment.checkout.process') }}" method="post">
					<input type="hidden" name="payment_type" value="braintree">
					{{ csrf_field() }}
					<div class="payment_fields" id="payment-fields"></div>
					<div id="payment-container"></div>
					<button id="submit-button">Continue </button> 
				</form> -->
				    <form method="post" id="paymentForm" action="{{ route('payment.checkout.process') }}" method="post">
				    <input type="hidden" name="payment_type" value="paypal_pro">
				    {{ csrf_field() }}
						<div class="row">
							 <div class="col-md-12">
									<div class="payment_fields " id="payment-fields"></div>
									 <h3>Payment information</h3>
								      <div id="paymentSection">
						          	  <ul>
								        <li>
								            <label>Card number</label>
								            <input type="text" placeholder="1234 5678 9012 3456" maxlength="20" id="card_number" name="card_number">
								        </li>
								        <li class="vertical">
								            <ul>
								                <li>
								                    <label>Expiry month</label>
								                    <input type="text" placeholder="MM" maxlength="5" id="expiry_month" name="expiry_month">
								                </li>
								                <li>
								                    <label>Expiry year</label>
								                    <input type="text" placeholder="YYYY" maxlength="5" id="expiry_year" name="expiry_year">
								                </li>
								                <li>
								                    <label>CVV</label>
								                    <input type="password" placeholder="123" maxlength="3" id="cvv" name="cvv">
								                </li>
								            </ul>
								        </li>
								        <li>
								            <label>Name on card</label>
								            <input type="text" placeholder="John Doe" id="name_on_card" name="name_on_card">
								        </li>
								        <li>
								            <input type="hidden" name="card_type" id="card_type" value=""/>
								            <input type="button" name="card_submit" id="cardSubmitBtn" value="Proceed" class="payment-btn" disabled="true" >
								        </li>
							        </ul>
						           </div>
						          </div>
							    </div> 
							</form>
		            </div>
		       </div>
		  </div>
		</div>	
		
		@endsection
		@section('script')
		<script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>

		<script>
			window.onload = function() {
				setTimeout(
					function(){
						$('.carform').find('input.start_date').val(localStorage.getItem('t_start'));
						$('.carform').find('input.end_date').val(localStorage.getItem('t_end'));
						$('.cartfields').find('input.cart_start_date').val(localStorage.getItem('t_start'));
						$('.cartfields').find('input.cart_end_date').val(localStorage.getItem('t_end'));
						$('.carform').find('input.quantity_adults').val(localStorage.getItem('quantity_adults'));
						$('.carform').find('input.quantity_child').val(localStorage.getItem('quantity_child'));
						$('.carform').find('input.deviceid').val(getDeviceId());
					}, 2000);
				$('.loadSpin').css('display', 'none');

			}

			$(document).ready(function(){
				$('#cartConinue').prop('disabled', true);
				$('.loadSpin').css('display', 'none');
				$('#cart_loading').hide();
				getCartdata();
			});

		   // Ajax for Add to cart item
		   $('.addtocart').click(function(){
		   	var btn_text = this.id;
		   	var btn_id = btn_text.split('_')[1]; 
		   	$('#loadSpin_'+btn_id).show();
		   	$('#cart_loading').show();
		   	$('#cartBody').hide();
		   	$('#cart_hotel_details').html('');
		   	jQuery.ajax({
		   		type: 'POST',
		   		url: '{{ route('hotel.addtocart') }}',
		   		data: $('#addtocartForm_'+btn_id).serialize(),
		   		dataType: 'json',
		   		success: function(res){ 
		   			$('#cart_hotel_details').html(res.data.hotelinfo)
		   			$('#cartItems').append(res.data.view)
		   			var ocap = parseInt($('#cartprice').text());
		   			var cartprice = ocap+res.data.item_price;
		   			$('#cartprice').text(cartprice.toFixed(2));
		   			$('#totalprice').val(cartprice.toFixed(2));
		   			$('#cart_item_value').append(res.data.cartitem);
		   			setTimeout(function(){
		   				$('#cartBody').show();
		   				$('#loadSpin_'+btn_id).hide();
		   				$('#cart_loading').hide();
		   				$('.nav-tabs a[href="#profile"]').tab('show');
		   				$('#cartConinue').prop('disabled', false);
		   			}, 2000);
		   		}
		   	});
		   })

		    // Ajax for delete cart item
		    $("#cartItems").on("click",".remove_cart", function(){
		    	var cart_id = this.id;
		    	//$('#loadSpin_'+cart_id).show();
		    	$('#loadSpin_'+cart_id).removeClass('hide');
		    	jQuery.ajax({
		    		type: 'POST',
		    		url: '{{ route('hotel.cart.item') }}',
		    		data: {'cart_id':cart_id,'_token':'{{ csrf_token()}}'},
		    		dataType: 'html',
		    		success: function(res){ 
		    			if(res){
		    				setTimeout(function(){	
		    					$('#loadSpin_'+cart_id).addClass('hide');
		    					location.reload();
		    				}, 2000);	
		    			}

		    		}
		    	});
		    })

		</script>

		<script>
		   // jquery function for generate uniq device id
		   uuid=function(){
		   	var u = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g,
		   		function(c) {
		   			var r = Math.random() * 16 | 0,
		   			v = c == 'x' ? r : (r & 0x3 | 0x8);
		   			return v.toString(16);
		   		});
		   	return u;
		   }

			 // jquery function for Store uniq device id
			 getDeviceId = function(){
			 	var current = window.localStorage.getItem("_DEVICEID_")
			 	if (current) return current;
			 	var id = uuid();
			 	window.localStorage.setItem("_DEVICEID_",id);   
			 	return id;
			 }

			 // jquery ajax function for  autoload cart item
			 getCartdata = function(){
			 	var deviceid = window.localStorage.getItem("_DEVICEID_");
			 	$('#cart_loading').show();
				$('#cart_hotel_details').html('');
			 	$('#cartBody').hide();
			 	var  data = {
			 		'_token':'{{ csrf_token()}}',
			 		'user_id':'{{get_loggedin_id()}}',
			 		'deviceid':deviceid
			 	};
			 	jQuery.ajax({
			 		type: 'POST',
			 		url: '{{ route('hotel.getcart') }}',
			 		data: data,
			 		dataType: 'json',
			 		success: function(res){ 
			 			$('#cart_hotel_details').html(res.data.hotelinfo);
			 			$('#cartItems').append(res.data.view);

			 			var ocap = parseInt($('#cartprice').text());
			 			var cartprice = ocap+res.data.item_price;
			 			$('#cartprice').text(cartprice.toFixed(2));
			 			$('#totalprice').val(cartprice.toFixed(2));
			 			$('#cart_item_value').append(res.data.cartitem);
			 			setTimeout(function(){
			 				$('#cartBody').show();
			 				$('#cart_loading').hide();
			 				if(res.data.status=='success'){
			 					$('.nav-tabs a[href="#profile"]').tab('show');
			 					$('#cartConinue').prop('disabled', false);
			 				}

			 			}, 2000);
			 		}
			 	});
			 }

			 function goCartTab(){
			 	$('.nav-tabs a[href="#home"]').tab('show');
			 };

			 $.ajaxSetup({
			 	headers: {
			 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			 		'Accept' : 'application/json'
			 	}
			 });
	    /**
	 * Custom validator for contains at least one lower-case letter
	 */
	 jQuery.validator.addMethod("atLeastOneLowercaseLetter", function (value, element) {
	 	return this.optional(element) || /[a-z]+/.test(value);
	 }, "Must have at least one lowercase letter");

	  /**
	   * Custom validator for contains at least one upper-case letter.
	   */

	   jQuery.validator.addMethod("atLeastOneUppercaseLetter", function (value, element) {
	   	return this.optional(element) || /[A-Z]+/.test(value);
	   }, "Must have at least one uppercase letter");
	   
	  /**
	   * Custom validator for contains at least one number.
	   */
	   jQuery.validator.addMethod("atLeastOneNumber", function (value, element) {
	   	return this.optional(element) || /[0-9]+/.test(value);
	   }, "Must have at least one number");
	   
	  /**
	   * Custom validator for contains at least one symbol.
	   */
	   $.validator.addMethod("atLeastOneSymbol", function (value, element) {
	   	return this.optional(element) || /[!@#$%^&*()]+/.test(value);
	   }, "Must have at least one symbol");

	   jQuery.validator.addMethod("phoneno", function(phone_number, element) {
	   	phone_number = phone_number.replace(/\s+/g, "");
	   	return this.optional(element) || phone_number.length > 9 && 
	   	phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
	   }, "<br />Please specify a valid phone number");

	   $('form[id="cartform"]').validate({
	   	rules: {
	   		title: 'required',
	   		first_name: 'required',
	   		surname: 'required',
	   		"mobile_number":
	   		{   
	   			required:true,
	   			phoneno:true
	   		},
	   		city: 'required',
	   		zipcode: 'required',
	   		address_1: 'required',
	   		email: {
            required: true,
            email: true,
            remote: {
                url: "{{route('ajax.email.check')}}",
                type: 'GET',
                dataType: 'json',
                data: {
                    email: function() {
                        return $('#email').val();
                    }

                 },
                 dataFilter: function (data) {
			        var json = JSON.parse(data);
			        if (json.status == "true") {
			            return "\"" + json.msg + "\"";
			        } else {
			            return 'true';
			        }
			    }
              }
            }, 
	   		booking_conditions: 'required',
	   		privacy_policies: 'required',

	   	},
	   	messages: {
	   		title: 'This Title is required',
	   		first_name: 'This First name is required',
	   		surname: 'This Last name is required',
	   		mobile_number: 'Please specify a valid phone number',
	   		city: 'This City is required',
	   		zipcode: 'This Zipcode is required',
	   		address_1: 'This Address link 1 is required',
	   		email: {
                required: "Please Enter Email!",
                email: "This is not a valid email!",
                remote: "Email already in use!"
            },
	   		booking_conditions: 'Please Check booking Conditions',
	   		privacy_policies: 'Please Read hotel privacy policies',
	   	},
	   	submitHandler: function() {
	   		$('#cartConinue').prop('disabled', true);
	   		$('#loadSpin_cart').css('display', 'block');
	   		$.ajax({
	   			type:'POST',
	   			url:"{{route('hotel.booking.process')}}",
	   			dataType: 'json',
	   			data:$('#cartform').serialize(),
	   			success:function(data){
	   				 //alert(data.phtml);
	   				 //getCartdata();
	   				 if (data.status='success') {
	   				 	$('.payment_fields').html(data.phtml);
	   				 	$('.pricehtml').html(data.pricehtml);
	   				 	$('#customer_info').html(data.userhtml);
	   				 	
	   				 	braintree.setup('{{$clientToken}}', 'dropin', {
	   				 		container: 'payment-container'
	   				 	});

	   				 	setTimeout(function() {
	   				 		$('.nav-tabs a[href="#messages"]').tab('show');
	   				 		$('#cartConinue').css('display', 'none');
	   				 		$('#loadSpin_cart').css('display', 'none');
	   				 		$this.button('reset');
	   				 	}, 2000);
	   				 };

	   				}
	   			});
	   	}
	   });



	     $('#cartConinue').click(function(){
	   	   $('#cartform').submit();
	     });

	      // Ajax for Add to cart item
		$('.paymentopt').click(function(){
			$('.paymentopt').removeClass('active');	
		    var ptopt = this.id;
		    $('#payment_opt').val(ptopt);
		    $('#submit_button').prop('disabled', false);
		    $(this).addClass('active');	
		 })

	</script>


	<script>

		var componentForm = {
			street_number: 'long_name',
			route: 'long_name',
			locality: 'long_name',
			administrative_area_level_1: 'long_name',
			country: 'long_name',
			postal_code: 'short_name'
		};

		function initMap() {

			var map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: -33.8688, lng: 151.2195},
				zoom: 13
			});
			var input = document.getElementById('address');

			var autocomplete = new google.maps.places.Autocomplete(input);
			autocomplete.bindTo('bounds', map);

    // Set the data fields to return when the user selects a place.
    autocomplete.setFields(
    	['address_components', 'geometry', 'icon', 'name']);
    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
    	map: map,
    	anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
    	infowindow.close();
    	marker.setVisible(false);
    	var place = autocomplete.getPlace();
      //console.log(place);
      document.getElementById('latitude').value = place.geometry.location.lat();
      document.getElementById('longitude').value = place.geometry.location.lng();
      for (var i = 0; i < place.address_components.length; i++) {
      	var addressType = place.address_components[i].types[0];
      	if (componentForm[addressType]) {
      		var val = place.address_components[i][componentForm[addressType]];
      		document.getElementById(addressType).value = val;
          //console.log(addressType +' =>>>> '+ val);
          //console.log(addressType);
      }
  }
  if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place.name + "'");
        return;
    }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
      	map.fitBounds(place.geometry.viewport);
      } else {
      	map.setCenter(place.geometry.location);
        map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
    	address = [
    	(place.address_components[0] && place.address_components[0].short_name || ''),
    	(place.address_components[1] && place.address_components[1].short_name || ''),
    	(place.address_components[2] && place.address_components[2].short_name || '')
    	].join(' ');
    }

    infowindowContent.children['place-icon'].src = place.icon;
    infowindowContent.children['place-name'].textContent = place.name;
    infowindowContent.children['place-address'].textContent = address;
    infowindow.open(map, marker);
});
    
}
</script>
<script src="{{ asset('frontend/js/creditCardValidator.js') }}"></script>
<script type="text/javascript">
	function cardFormValidate(){
    var cardValid = 0;
      
	    // Card number validation
	    $('#card_number').validateCreditCard(function(result) {
	        var cardType = (result.card_type == null)?'':result.card_type.name;
	        if(cardType == 'Visa'){
	            var backPosition = result.valid?'2px -163px, 260px -87px':'2px -163px, 260px -61px';
	        }else if(cardType == 'MasterCard'){
	            var backPosition = result.valid?'2px -247px, 260px -87px':'2px -247px, 260px -61px';
	        }else if(cardType == 'Maestro'){
	            var backPosition = result.valid?'2px -289px, 260px -87px':'2px -289px, 260px -61px';
	        }else if(cardType == 'Discover'){
	            var backPosition = result.valid?'2px -331px, 260px -87px':'2px -331px, 260px -61px';
	        }else if(cardType == 'Amex'){
	            var backPosition = result.valid?'2px -121px, 260px -87px':'2px -121px, 260px -61px';
	        }else{
	            var backPosition = result.valid?'2px -121px, 260px -87px':'2px -121px, 260px -61px';
	        }
	        $('#card_number').css("background-position", backPosition);
	        if(result.valid){
	            $("#card_type").val(cardType);
	            $("#card_number").removeClass('required');
	            cardValid = 1;
	        }else{
	            $("#card_type").val('');
	            $("#card_number").addClass('required');
	            cardValid = 0;
	        }
	    });
      
	    // Card details validation
	    var cardName = $("#name_on_card").val();
	    var expMonth = $("#expiry_month").val();
	    var expYear = $("#expiry_year").val();
	    var cvv = $("#cvv").val();
	    var regName = /^[a-z ,.'-]+$/i;
	    var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
	    var regYear = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
	    var regCVV = /^[0-9]{3,3}$/;
	    if(cardValid == 0){
	        $("#card_number").addClass('required');
	        $("#card_number").focus();
	        return false;
	    }else if(!regMonth.test(expMonth)){
	        $("#card_number").removeClass('required');
	        $("#expiry_month").addClass('required');
	        $("#expiry_month").focus();
	        return false;
	    }else if(!regYear.test(expYear)){
	        $("#card_number").removeClass('required');
	        $("#expiry_month").removeClass('required');
	        $("#expiry_year").addClass('required');
	        $("#expiry_year").focus();
	        return false;
	    }else if(!regCVV.test(cvv)){
	        $("#card_number").removeClass('required');
	        $("#expiry_month").removeClass('required');
	        $("#expiry_year").removeClass('required');
	        $("#cvv").addClass('required');
	        $("#cvv").focus();
	        return false;
	    }else if(!regName.test(cardName)){
	        $("#card_number").removeClass('required');
	        $("#expiry_month").removeClass('required');
	        $("#expiry_year").removeClass('required');
	        $("#cvv").removeClass('required');
	        $("#name_on_card").addClass('required');
	        $("#name_on_card").focus();
	        return false;
	    }else{
	        $("#card_number").removeClass('required');
	        $("#expiry_month").removeClass('required');
	        $("#expiry_year").removeClass('required');
	        $("#cvv").removeClass('required');
	        $("#name_on_card").removeClass('required');
	        $('#cardSubmitBtn').prop('disabled', false);  
	        return true;
	    }
	}
	$(document).ready(function(){
    // Initiate validation on input fields
    $('#paymentForm input[type=text]').on('keyup',function(){
        cardFormValidate();
    });
    
    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			  'Accept' : 'application/json'
			}
		});
	// Submit card form
	$("#cardSubmitBtn").on('click',function(){
		    $('#paymentConfirm').html('');
	        $('.status-msg').remove();
	        if(cardFormValidate()){
	        	$("#cardSubmitBtn").prop('disabled', true);
	            $("#cardSubmitBtn").val('Processing....');
	            var formData = $('#paymentForm').serialize();
	            $('#paymentForm').submit();
	           /* $.ajax({
	                type:'POST',
	                url: "{{route('ajax.booking.paypal.process')}}",
	                dataType: "json",
	                data:formData,
	                beforeSend: function(){
	                    $("#cardSubmitBtn").prop('disabled', true);
	                    $("#cardSubmitBtn").val('Processing....');
	                },
	                success:function(data){
	                    if(data.status == 1){
	                    	$('#paymentConfirm').show();
	                        $('#paymentConfirm').html('<p class="status-msg success">The transaction was successful. Booking ID: <span>'+data.bookingID+'</span></p>');
	                   		$('#paymentForm').hide();
	                    }else{
	                    	$('#paymentConfirm').show();
	                        $("#cardSubmitBtn").prop('disabled', false);
	                        $("#cardSubmitBtn").val('Proceed');
	                        $('#paymentConfirm').html('<p class="status-msg error">Transaction has been failed, please try again.</p>');
	                    }
	                }
	            });*/
	        }
	    });
	});
	</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&libraries=places&callback=initMap"
async defer></script>

@endsection
