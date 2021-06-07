@extends('frontend.layouts.app')
@section('css')
  <style type="text/css">
	.header_search_area{display: none;}
  </style>
@endsection
@section('content')
<?php 
	$user = auth('web')->user();
	if($user):
		$user = App\User::where('id', $user->id)->get()->first();
		$first_name		= $user['first_name'];
		$last_name		= $user['last_name'];
		$mobile_number	= $user['mobile_number'];
		$email			= $user['email'];
		$address		= $user['address'];
		$address_2 		= $user['address_2 '];
		$city			= $user['city'];
		$zipcode		= $user['zipcode'];
		$country_code	= $user['country_code'];
	else: 
		$first_name='';
		$last_name='';
		$mobile_number='';
		$email='';
		$address='';
		$address_2 ='';
		$city='';
		$zipcode='';
		$country_code=0;
	endif;
	$hotel_id 			= $bookingArray['hotelDetails']->id;
	$HotelName 			= $bookingArray['hotelDetails']->hotels_name;
	$ArrivalDate 		= $bookingArray['startDate'];
	$Nights 			= $bookingArray['totalNight'];
	$showRTyp			= ($bookingArray['selectedRoomType'] != 'Room Only') ? ' - ' . $bookingArray['selectedRoomType'] : '';;
  	if($bookingArray['selectedRoomType'] == 'Room Only'):
  		$nightcost 		= $bookingArray['roomDetails']->base_price;
	else:
		$mealDetails 	= json_decode($bookingArray['roomDetails']->meal_details, true);
		$packageDetails = json_decode($bookingArray['roomDetails']->package_details, true);
  		$nightcost 		= (in_array($bookingArray['selectedRoomType'], $mealDetails)) ? array_search($bookingArray['selectedRoomType'], $mealDetails) : array_search($bookingArray['selectedRoomType'], $packageDetails);
	endif;
	$totalprice 		= $nightcost * $bookingArray['totalNight'] * $bookingArray['quantityRooms'];
	$totalsellingprice 	= number_format((float) $totalprice, 2);
	$Cancelpolicy 		= array();
?>
<section class="search_result_section innertop_gap">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="holidaysection" style="padding:25px">
					<form id="cartform">
						{{ csrf_field() }}
						<input type="hidden" name="bookingArray" value="{{ json_encode($bookingArray) }}">
						<input type="hidden" name="totalSellingPrice" value="{{ $totalsellingprice }}">
						<input type="hidden" name="nightCost" value="{{ $nightcost }}">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<h2>Contact Information</h2>
										<div class="form-group">
											<select class="form-control" name="title" id="title">
												<option value="Mr">Mr</option>
												<option value="Mrs">Mrs</option>
												<option value="Ms">Ms</option>
											</select>
										</div>
										<div class="form-group">
											<input type="text" class="form-control requiredCheck" data-check="First Name" placeholder="First Name *" name="firstName" id="firstName" value="{{$first_name}}">
										</div>
										<div class="form-group"> 
											<input type="text" class="form-control requiredCheck" data-check="Last Name" placeholder="Last Name *" name="lastName" id="lastName" value="{{$last_name}}">
										</div>
										<div class="form-group"> 
											<input type="text" class="form-control isNumber" data-check="Phone" placeholder="Phone" name="mobileNumber" id="mobileNumber" value="{{$mobile_number}}">
										</div>
										<div class="form-group">
											<input type="text" class="form-control requiredCheck" data-check="Email" placeholder="Email *" name="userEmail" id="userEmail" value="{{$email}}"  >
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
											<input type="text" class="form-control isNumber" placeholder="Zip / Postcode" id="postal_code" name="zipcode" value="{{$zipcode}}">
										</div>
										<div class="form-group">
											<select class="form-control" id="country" name="country">
												<?php countryOption($country_code);?>
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<h2>Additional Details</h2>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<h3>SPECIAL REQUESTS (Optional)</h3>
										<div class="form-group">
											<textarea name="booking_comment" class="form-control" placeholder="Please note your requests or special needs."></textarea>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<h2>Policies:</h2>
												<div class="bkr_rht_top">
													<p>GUARANTEE / DEPOSIT POLICY 
														<br/>All reservations must be guaranteed with a valid credit card. </p>
												</div>
												<div class="xml_cancel_policy clearfix">
													<div class="col-sm-12">
														<p style="color:red;"><b> CANCELLATION POLICY</b> </p>
														<p style="color:red;">The Booking Fee applicable to this reservation ($ <span id="serviceFeeShow" style="font-size: 14px; color: red;">0</span>) is non-refundable under all circumstances regardless of the following Hotel Cancellation Policy prescribed by the Hotel</p>
														<?php
														if (!empty($Cancelpolicy)) {
														print '<p style="color:red;"><b>Hotel Cancellation Policy</b></p>';
														foreach ($Cancelpolicy as $key => $policies) { ?>
															<ul style="color:red;">
																<!-- <li><span>Fees for Room <?php echo $key+1; ?></span></li> -->
																	<ul style="color:red;">
																	<?php
																	//var_dump($policies['Fee']);
																		foreach ($policies['Fee'] as $key => $poicy) {
																			if(isset($poicy) && count($poicy)>1){
																				echo '<li style="color:red; padding: 0 0 10px;">';
																				if(isset($poicy['@attributes']['from'])){
																					echo '<p style="color:red; padding: 0 0 0px;"><b>Cancel on or after '.date("D d M Y", strtotime($poicy['@attributes']['from'])).'</b></p>';
																				}
																				if(isset($poicy['Amount']['@attributes']['amt'])){
																					echo '<p style="color:red; padding: 0 0 0px;"> A cancellation charge of  '.$data['Currency'].number_format($poicy['Amount']['@attributes']['amt'], 2).' will be applied</p>';
																				}
																				echo '</li>';
																			//echo '<li>'.date("Y-m-d", strtotime($poicy['@attributes']['from'])).' will be '.$data['Currency'].number_format($poicy['Amount']['@attributes']['amt'], 2).'</li>';
																			}
																		}
																	?>
																	</ul>
																
															</ul>
														<?php }
														}
														?>
														</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h2>Acknowledgement</h2></div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group">
														<input type="checkbox" class="checkIfChecked" id="bookingConditions" value="0">
														<label>I agree with the above Booking Conditions.</a></label>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group">
														<input type="checkbox" class="checkIfChecked" id="privacyPolicies" value="0">
														<label>I agree with the Terms & Conditions and the Privacy Policy applicable to use of this website (<a href="{{URL('terms-conditions')}}" target="_blank">Terms & Conditions</a>, <a href="{{URL('privacy-policy')}}" target="_blank">Privacy Policy</a>)</label>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group">
														<input type="checkbox" class="checkIfChecked" name="newsletters" value="0">
														<label>I would like to receive newsletters and special offers by email.</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h2>Booking Details</h2>
								<div class="hotelsetail">
									<h3>{{ $HotelName }}</h3>
									<p><b>Check In : </b>{{ date("D d M Y", strtotime($ArrivalDate)) }}
									<b>Check out : </b> {{ date("D d M Y", strtotime($bookingArray['endDate'])) }}</p>
									<p><b>ADULT : </b>{{$bookingArray['quantityAdults']}} , <b>CHILD : </b>{{$bookingArray['quantityChild']}}</p>
								</div>
								<table class="table table-bordered ">
									<thead>
										<th class="text-center">Nights</th>
										<th class="text-center">Price</th>
									</thead>
									<tbody>
										<tr>
											<td>{{ $bookingArray['roomDetails']->name . $showRTyp }} - {{$bookingArray['totalNight']}} Night(s) X {{ $bookingArray['quantityRooms'] }} Room(s)</td>
											<td style="text-align: right;">{{ getCurrency() }} {{ number_format(((float)$nightcost), 2) }}</td>
										</tr>
										<tr>
											<td><span>Sub Total : </span></td>
											<td style="text-align: right;">{{ getCurrency() }} {{ $totalsellingprice }}</td>
										</tr>
										<input type="hidden" id="checkoutPrice" value="<?=$totalsellingprice?>">
										<tr>
											<td><span>Grand Total : </span></td>
											<td style="text-align: right;">{{ getCurrency() }} <?=$totalsellingprice?></td>
										</tr>
									</tbody>
								</table>
								<h2>Payment Information</h2>
								<div id="paymentSection">
									<div id="paymentPostData"></div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label>Card number *</label>
											<input class="form-control requiredCheck isNumber" data-check="Card number" type="text" placeholder="1234 5678 9012 3456" maxlength="20" id="cartCardNo" name="cartCardNo">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group">
											<label>Expiry Month *</label>
											<input class="form-control requiredCheck isNumber" data-check="Expiry Month" type="text" placeholder="MM" maxlength="2" id="cartCardMm" name="cartCardMm">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group">
											<label>Expiry Year *</label>
											<input class="form-control requiredCheck isNumber" data-check="Expiry Yea" type="text" placeholder="YYYY" maxlength="4" id="cartCardYy" name="cartCardYy">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group">
											<label>CVN *</label>
											<input class="form-control requiredCheck isNumber" data-check="CVN" type="password" placeholder="123" maxlength="3" id="cartCardCvc" name="cartCardCvc">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label>Name on Card *</label>
											<input class="form-control requiredCheck" data-check="Name on Card" type="text" placeholder="John Doe" name="nameOnCard">
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row clerafix">
						<div class="col-sm-12 con_button_area">
							<a href="javascript:void(0);" id="cartConinue" class="con_btn comman_button">Confirm</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script src="{{ asset('frontend/js/creditCardValidator.js') }}"></script>
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			'Accept' : 'application/json'
		}
	});
	$(function(){
		$('#serviceFeeShow').text($('#serviceFee').val());
		$(document).on('click', '.checkIfChecked', function(e) {
			if($(this).is(":checked") == true){
				$(this).val('1');
			}else{
				$(this).val('0');
			}
		});
		$(document).on('click', '#cartConinue', function(e) {
			e.preventDefault();
			let flag = commonFormChecking(true);
			if(flag){
				if($('#bookingConditions').prop("checked") == false){
					swalAlert('Please agree Booking Conditions !!!', 'warning');
					flag = false;
					return false;
				}
				if($('#privacyPolicies').prop("checked") == false){
					swalAlert('Please agree Terms & Conditions and Privacy Policy !!!', 'warning');
					flag = false;
					return false;
				}
				if($('#cartCardNo').val().length != 16){
					swalAlert("Card No must be of 16 digits !!!", 'warning', 5000);
					flag = false;
					return false;
				}
				if($.isNumeric( $('#cartCardNo').val()) === false){
					swalAlert("Card No must contains digits only !!!", 'warning', 5000);
					flag = false;
					return false;
				}
				if($('#cartCardMm').val().length != 2){
					swalAlert("Card Expiry Month must be of 2 digits !!!", 'warning', 5000);
					flag = false;
					return false;
				}
				if($('#cartCardYy').val().length != 4){
					swalAlert("Card Expiry Year must be of 4 digits !!!", 'warning', 5000);
					flag = false;
					return false;
				}
				if($('#cartCardCvc').val().length != 3){
					swalAlert("Card CVN must be of 3 digits !!!", 'warning', 5000);
					flag = false;
					return false;
				}
				if(flag){
					$("#cartform").submit();
				}
			}
		});
		$("#cartform").submit(function(e) {
			e.preventDefault();
			Swal.fire({
				title 				: 'Are you sure want to book hotel?',
				type 				: 'warning',
				showCancelButton 	: true,
				confirmButtonColor 	: '#dd6b55',
				cancelButtonColor 	: '#48cab2',
				confirmButtonText 	: "OK",
				cancelButtonText	: "Cancel"
			}).then((result) => {
				if (result.value) {
					let formData = new FormData(this);
					$.ajax({
						type: "POST",
						url: "{{ route('hotel.booking.confirm') }}",
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "JSON",
						beforeSend: function() {
							$("#cartConinue").prop("disabled", true);
							$(".holidaysection").loading();
						},
						success: function(res) {
							if(res.success){
								swalAlertThenRedirect('Booking Successfull !!!', 'success', "{{ route('home') }}");
							}else{
								$("#cartConinue").prop("disabled", false);
								$(".holidaysection").loading('stop');
								swalAlert('Something Went Wrong !!! Please Try Again !!!', 'error');
							}
						}
					});
				}
			});
		});
	});
	/*function cardFormValidate(){
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
	    var regYear = /^2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
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
	$(document).on('click', '#paymentfinalBtn', function () {
		$.ajax({
			type:'POST',
			url: "{{route('ajax.booking.paypal.process')}}",
			dataType: "json",
			data:{
				'totalprice': $('#paymenttotalprice').val(),
				'markUpPrice': $('#paymentmarkUpPrice').val(),
				'booking_id': $('#paymentbooking_id').val(),
				'booking_user_id': $('#paymentbooking_user_id').val(),
				'currency': $('#paymentcurrency').val(),
				'first_name': $('#paymentfirst_name').val(),
				'last_name': $('#paymentlast_name').val(),
				'mobile_number': $('#paymentmobile_number').val(),
				'email': $('#paymentemail').val(),
				'address': $('#paymentaddress').val(),
				'address2': $('#paymentaddress2').val(),
				'city': $('#paymentcity').val(),
				'zipcode': $('#paymentzipcode').val(),
				'card_number': $('#card_number').val(),
				'expiry_month': $('#expiry_month').val(),
				'expiry_year': $('#expiry_year').val(),
				'cvv': $('#cvv').val(),
			},
			success:function(data){
				$(".holidaysection").loading('stop');
				if(data.status == 1){
					var url="{{route('user.booking.confirm')}}?booking="+data.bookid;
					swalAlertThenRedirect("Transaction Successfull !!! Booking ID : " +data.bookingID, "success", url);
				}else{
					$("#cartConinue").prop("disabled", false);
					console.log(data.message);
					swalAlert('Something Went Wrong !!! Please Try Again !!!', 'error');
				}
			}
		});
	});*/
</script>
@endsection