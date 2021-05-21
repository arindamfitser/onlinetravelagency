@extends('frontend.layouts.app')
@section('css')
  <style type="text/css">
	.header_search_area{display: none;}
  </style>
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
<section class="search_result_section innertop_gap">
	<div class="container">
		<div class="row">
		 <?php
    		$hotelbooking = $data['Booking']['HotelBooking'];
    		$HotelName = ''; 
    		$ArrivalDate = '';
    		$Nights = 0;	     
    		$totalsellingprice=0;
    		$totalprice=0;
    		$mrkUpPrc = 0;
			$Cancelpolicy =array();
			// echo "<pre>";
			// 		print_r($hotelbooking);
			// 		die;
    		if(isset($hotelbooking[0])){
				if($hotelbooking[0]['Status'] == 'unavailable'){
					$available = false;
				}else{
					$available = true;
					foreach($hotelbooking as $hotelbook){
						$nightcost[] = $hotelbook['Room']['NightCost'];
						$totalsellingprice += (float) (($hotelbook['Room']['TotalSellingPrice']['@attributes']['amt'] * get_option('markup_price')) / 100 ) + (float) $hotelbook['Room']['TotalSellingPrice']['@attributes']['amt']; 
						$mrkUpPrc = (float)$mrkUpPrc + (float) (($hotelbook['Room']['TotalSellingPrice']['@attributes']['amt'] * get_option('markup_price')) / 100 );
						$hotel_id =$hotelbook['HotelId'];
						$HotelName = $hotelbook['HotelName']; 
						$ArrivalDate = $hotelbook['ArrivalDate'];
						$Nights = $hotelbook['Nights'];
						$Cancelpolicy[] =$hotelbook['Room']['CanxFees'];
					}
				}
    		}else{
				if($hotelbooking['Status'] == 'unavailable'){
					$available = false;
				}else{
					$available = true;
					$nightcost = $hotelbooking['Room']['NightCost'];
					$totalsellingprice = ((float) (($hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt'] * get_option('markup_price')) / 100) + (float) $hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt']); 
					$hotel_id =$data['Booking']['HotelBooking']['HotelId'];
					$HotelName = $data['Booking']['HotelBooking']['HotelName']; 
					$ArrivalDate = $data['Booking']['HotelBooking']['ArrivalDate'];
					$Nights = $data['Booking']['HotelBooking']['Nights'];  
					$Cancelpolicy[] =$hotelbooking['Room']['CanxFees'];
					$mrkUpPrc = (float) (($hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt'] * get_option('markup_price')) / 100);
				}
			}
			$totalprice = $totalsellingprice;
			$totalsellingprice = number_format((float)$totalsellingprice, 2);
			if($available){
			?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="holidaysection" style="padding:25px">
				    <div class="row">
				        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				            <form id="cartform" name="cartform">
				                {{ csrf_field() }}
							    <input type="hidden" name="quoteid" value="{{ $quoteid }}">
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
											<input type="text" class="form-control requiredCheck" data-check="First Name" placeholder="First Name *" name="first_name" id="first_name" value="{{$first_name}}">
										</div>
										<div class="form-group"> 
											<input type="text" class="form-control requiredCheck" data-check="Last Name" placeholder="Last Name *" name="surname" id="surname" value="{{$last_name}}">
										</div>
										<div class="form-group"> 
											<input type="text" class="form-control" onkeypress="return isNumber(this.event)" data-check="Phone" placeholder="Phone" name="mobile_number" id="mobile_number" value="{{$mobile_number}}">
										</div>
										<div class="form-group">
											<input type="text" class="form-control requiredCheck" data-check="Email" placeholder="Email Address*" name="email" id="email" value="{{$email}}"  >
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
											<input type="text" class="form-control" onkeypress="return isNumber(this.event)" placeholder="Zip / Postcode" id="postal_code" name="zipcode" value="{{$zipcode}}">
										</div>
										<div class="form-group">
											<select class="form-control" id="country" name="country">
												<?php countryOption($country_code);?>
											</select>
										</div>
									</div>
									<div id="cart_item_value"></div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h2>Additional Details</h2></div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<h3>SPECIAL REQUESTS (Optional)</h3>
										<div class="form-group">
											<textarea name="booking_comment" class="form-control" placeholder="Please note your requests or special needs. "></textarea>
										</div>
									</div>
									<div class="cartfields">
										<input type="hidden" id="totalprice" name="totalprice" value="<?php echo $totalprice ?>">
										<input type="hidden" id="markUpPrice" name="markUpPrice" value="<?php echo $mrkUpPrc ?>">
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
														<input type="checkbox" id="booking_conditions" name="booking_conditions" value="">
														<label>I agree with the above Booking Conditions.</a></label>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group">
														<input type="checkbox" id="privacy_policies" name="privacy_policies" value="">
														<label>I agree with the Terms & Conditions and the Privacy Policy applicable to use of this website (<a href="{{URL('terms-conditions')}}" target="_blank">Terms & Conditions</a>, <a href="{{URL('privacy-policy')}}" target="_blank">Privacy Policy</a>)</label>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group">
														<input type="checkbox" id="newsletters" name="newsletters" value="">
														<label>I would like to receive newsletters and special offers by email.</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="total_price" value="{{ $totalprice }}">
							</form>
				        </div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<h2>Booking Details</h2>
							<div class="hotelsetail">
								<h3><?php echo $HotelName;?></h3>
								<p><b>Check In </b><?php echo date("D d M Y", strtotime($ArrivalDate));?>
								<b>Check out </b> <?php echo date("D d M Y", strtotime("+".$Nights." day", strtotime($ArrivalDate)));?></p>
								<p><b>ADULT : </b>{{session('quantity_adults')}} , <b>CHILD : </b>{{session('quantity_child')}}</p>
							</div>
							<table class="table table-bordered ">
								<thead>
									<th class="text-center">Nights</th>
									<th class="text-center">Price</th>
								</thead>
								<tbody>
								<?php
									/*echo '<pre>';
									var_dump($hotelbooking['Nights']);
									echo '<pre>';
									exit;*/
								$subTotal = 0;
								$totMarkUp = 0;
								$markUpPrice = get_option('markup_price');
								if(isset($hotelbooking[0])){
									$st = 0;
									foreach($hotelbooking as $u=>$v){
										$st += (float)$hotelbooking[$k]['Room']['TotalSellingPrice']['@attributes']['amt'];
									}
									$totMarkUp = number_format((float)(($markUpPrice * $st) / 100), 2, '.', '');
									$dMarkUpPrice = number_format((float)($totMarkUp / count($nightcost)), 2, '.', '');
									//$dMarkUpPrice = number_format((float)($markUpPrice / count($hotelbooking)), 2, '.', '');
									foreach($hotelbooking as $k=>$htelbook){
										if($hotelbooking[$k]['Nights']>1){ ?>
										<tr>
											<td>
												<?php echo $hotelbooking[$k]['Room']['RoomType']['@attributes']['text']; ?> - <?php echo $hotelbooking[$k]['Nights']; ?> Night
												<p>{{ (isset($hotelbooking[$k]['Room']['MealType']['@attributes']['text']) ? $hotelbooking[$k]['Room']['MealType']['@attributes']['text'] : '' ) }}</p>
											</td>
											<td style="text-align: right;"><?php echo $data['Currency']; ?> <?php echo number_format(((float) $dMarkUpPrice + (float)$hotelbooking[$k]['Room']['TotalSellingPrice']['@attributes']['amt']), 2); ?></td>
										</tr>
										<?php
										}else{
										?>
										<tr>
											<td><?php echo $hotelbooking[$k]['Room']['RoomType']['@attributes']['text']; ?> -1 Night</td>
											<td style="text-align: right;"><?php echo $data['Currency']; ?> <?php echo number_format(((float)$hotelbooking[$k]['Room']['TotalSellingPrice']['@attributes']['amt'] + (float)$hotelbooking[$k]['Room']['TotalSellingPrice']['@attributes']['amt']), 2); ?></td>
										</tr>
										<?php 
										}
										$subTotal += (float)$hotelbooking[$k]['Room']['TotalSellingPrice']['@attributes']['amt'];
									}
								}else{
									if($hotelbooking['Nights']>1){
										$st = 0;
										for ($m=0; $m < count($nightcost) ; $m++) {
											$st += (float)$nightcost[$m]['SellingPrice']['@attributes']['amt'];
										}
										//$dMarkUpPrice = number_format((float)($markUpPrice / count($nightcost)), 2, '.', '');
										$totMarkUp = number_format((float)(($markUpPrice * $st) / 100), 2, '.', '');
										$dMarkUpPrice = number_format((float)($totMarkUp / count($nightcost)), 2, '.', '');
										for ($i=0; $i < count($nightcost) ; $i++) {	?>
											<tr>
												<td>
													<?php echo $hotelbooking['Room']['RoomType']['@attributes']['text']; ?> - <?php echo $nightcost[$i]['Night'] + 1; ?> Night
													<p>{{ (isset($hotelbooking['Room']['MealType']['@attributes']['text']) ? $hotelbooking['Room']['MealType']['@attributes']['text'] : '' ) }}</p>
												</td>
												<td style="text-align: right;"><?php echo $data['Currency']; ?> <?php echo number_format(((float) $dMarkUpPrice + (float)$nightcost[$i]['SellingPrice']['@attributes']['amt']), 2); ?></td>
											</tr>
										<?php
											$subTotal += (float)$nightcost[$i]['SellingPrice']['@attributes']['amt'];
										}  
									}else{ ?>
										<tr>
											<td>
												<?php echo $hotelbooking['Room']['RoomType']['@attributes']['text']; ?> - <?php echo $nightcost['Night']+1; ?> Night
												<p>{{ (isset($hotelbooking['Room']['MealType']['@attributes']['text']) ? $hotelbooking['Room']['MealType']['@attributes']['text'] : '' ) }}</p>
											</td>
											<td style="text-align: right;"><?php echo $data['Currency']; ?> <?php echo number_format(((float) (($nightcost['SellingPrice']['@attributes']['amt'] * $markUpPrice) / 100) + (float)$nightcost['SellingPrice']['@attributes']['amt']), 2); ?></td>
										</tr>
										<?php 
										$subTotal += (float)$nightcost['SellingPrice']['@attributes']['amt'];
										$totMarkUp = number_format((float)(($markUpPrice * $subTotal) / 100), 2, '.', '');
									}
								}
								//$subTotal += (float) (($markUpPrice * $subTotal) / 100);
								$subTotal += (float) $totMarkUp;
								$totalsellingprice = $subTotal;
								$subTotal = number_format((float)$subTotal, 2);
								$totalsellingprice = number_format($totalsellingprice, 2);
								$markUpPrice = $totMarkUp;
								?>
									<tr>
										<td><span>Sub Total : </span></td>
										<td style="text-align: right;"><?php echo $data['Currency']; ?> <?=$subTotal?></td>
									</tr>
									<input type="hidden" id="serviceFee" value="<?=$markUpPrice?>">
									<input type="hidden" id="checkoutPrice" value="<?=$totalsellingprice?>">
									<tr>
										<td><span>Grand Total : </span></td>
										<td style="text-align: right;"><?php echo $data['Currency']; ?> <?=$totalsellingprice?></td>
									</tr>
								</tbody>
							</table>
							<h2>Payment Information</h2>
							<div id="paymentSection">
								<form id="paymentForm">
									<div id="paymentPostData"></div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label>Card number *</label>
											<input class="form-control requiredCheck" onkeypress="return isNumber(this.event)" data-check="Card number" type="text" placeholder="1234 5678 9012 3456" maxlength="20" id="card_number" name="card_number">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group">
											<label>Expiry Month *</label>
											<input class="form-control requiredCheck" onkeypress="return isNumber(this.event)" data-check="Expiry Month" type="text" placeholder="MM" maxlength="2" id="expiry_month" name="expiry_month">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group">
											<label>Expiry Year *</label>
											<input class="form-control requiredCheck" onkeypress="return isNumber(this.event)" data-check="Expiry Yea" type="text" placeholder="YYYY" maxlength="4" id="expiry_year" name="expiry_year">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group">
											<label>CVV *</label>
											<input class="form-control requiredCheck" onkeypress="return isNumber(this.event)" data-check="CVV" type="text" placeholder="123" maxlength="3" id="cvv" name="cvv">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label>Name on Card *</label>
											<input class="form-control requiredCheck" data-check="Name on Card" type="text" placeholder="John Doe" id="name_on_card" name="name_on_card">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="row clerafix">
						<div class="col-sm-12 con_button_area">
							<a href="javascript:void(0);" id="cartConinue" class="con_btn comman_button">Confirm</a>
						</div>
					</div>
				</div>
			</div>
		</div>
			<?php
			}else{
			?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h2>This room is currently unavailable !!!</h2>
				</div>
			<?php } ?>
		</div>
	</section>
	<!--/////////////////////////////////////////-->
	@endsection
	@section('script')
	<script src="{{ asset('frontend/js/creditCardValidator.js') }}"></script>
	<script>
		$(function(){
			$('#serviceFeeShow').text($('#serviceFee').val());
		});
		window.onload = function() {
			setTimeout(
				function(){
					$('.cartfields').find('input.cart_start_date').val(localStorage.getItem('t_start'));
					$('.cartfields').find('input.cart_end_date').val(localStorage.getItem('t_end'));
					$('.carform').find('input.deviceid').val(getDeviceId());
				}, 2000);
			//$('.loadSpin').css('display', 'none');
		}
		$(document).ready(function(){
			$('#cartConinue').prop('disabled', true);
			$('.loadSpin').css('display', 'none');
			$('#cart_loading').hide();
			getCartdata();
		});
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
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			'Accept' : 'application/json'
		}
	});
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			if (charCode == 32 || charCode == 43 || charCode == 45 || charCode == 46 || charCode == 4) {
				return true;
			}
			return false;
		}
		return true;
	}
	function swalAlert(text, type, timer = 2000) {
		Swal.fire({
			type: type,
			title: text,
			timer: timer
		})
	}
	function swalAlertThenRedirect(text, type, url, showCancelButton = false) {
		if (showCancelButton == false) {
			var confirmButtonColor = '#48cab2';
			var cancelButtonColor = '#dd6b55';
		} else {
			var confirmButtonColor = '#dd6b55';
			var cancelButtonColor = '#48cab2';
		}
		Swal.fire({
			title: text,
			type: type,
			showCancelButton: showCancelButton, // true or false
			confirmButtonColor: confirmButtonColor,
			cancelButtonColor: cancelButtonColor,
			confirmButtonText: "OK",
			cancelButtonText: "Cancel"
		}).then((result) => {
			if (result.value) {
				window.location = url;
			}
		});
	}
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
	    var regYear = /^2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
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
	function commonFormChecking(flag, cls = '', msgbox = '') {
		if (cls == '') {
			cls = 'requiredCheck';
		}
		$('.' + cls).each(function () {
			if ($.trim($(this).val()) == '') {
				if (msgbox != '') {
					$("." + msgbox).text($(this).attr('data-check') + ' is mandatory !!!');
				} else {
					swalAlert($(this).attr('data-check') + ' is mandatory !!!', 'warning');
				}
				flag = false;
				return false;
			} else {
				if ($(this).attr('data-check') == 'Email') {
					var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
					if (reg.test($.trim($(this).val())) == false) {
						if (msgbox != '') {
							$("." + msgbox).text('Enter valid Email address!!!');
						} else {
							swalAlert('Enter valid Email address !!!', 'warning');
						}
						flag = false;
						return false;
					}
				}
				if ($(this).attr('data-check') == 'Phone') {
					if ($.trim($(this).val()).length != 10) {
						var txt = 'Enter 10 digit phone number !!!';
						if (msgbox != '') {
							$("." + msgbox).text('Enter 10 digit phone number !!!');
						} else {
							swalAlert('Enter 10 digit phone number !!!', 'warning');
						}
						flag = false;
						return false;
					}
				}
				if ($(this).attr('data-check') == 'Zip') {
					if ($.trim($(this).val()).length != 6) {
						if (msgbox != '') {
							$("." + msgbox).text('Enter 6 digit Postcode !!!');
						} else {
							swalAlert('Enter 6 digit Postcode !!!', 'warning');
						}
						flag = false;
						return false;
					}
				}
			}
		});
		return flag;
	}
	$("#cartform").submit(function(e) {
		e.preventDefault();
		var flag = commonFormChecking(true);
		if(flag){
			if($('#booking_conditions').prop("checked") == false){
				swalAlert('Please agree Booking Conditions !!!', 'warning');
				flag = false;
				return false;
			}
			if($('#privacy_policies').prop("checked") == false){
				swalAlert('Please agree Terms & Conditions and Privacy Policy !!!', 'warning');
				flag = false;
				return false;
			}
		}
		if (flag) {
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				url: "{{ route('bookingconfirmpay') }}",
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
						$('#paymentPostData').html(res.newHtml);
						setTimeout(function(){ $('#paymentfinalBtn').click(); }, 500);
					}else{
						$("#cartConinue").prop("disabled", false);
						$(".holidaysection").loading('stop');
						swalAlert('Something Went Wrong !!! Please Try Again !!!', 'error');
					}
				}
			});
		}
	});
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
	});
	$('#cartConinue').click(function(){
		$('#cartform').submit();
	});
	$('#paymentForm input[type=text]').on('keyup',function(){
        cardFormValidate();
    });
	
</script>
@endsection