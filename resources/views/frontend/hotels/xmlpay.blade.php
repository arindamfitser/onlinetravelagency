	@extends('frontend.layouts.app')
	@section('css')
	<!--new-->
	<link rel="stylesheet" href="{{ asset('frontend/css/cardForm.css') }}" type="text/css" media="screen" />
	<!--new-->
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="holidaysection" style="padding:25px">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2">
							<div class="tab_thankyou">
									<div class="row">
										<div class="col-md-12">
											<div class="panel-group">
												<div class="panel panel-default">
												    <div id="paymentConfirm" class="paymentSucessmsg"  style="display:none;"></div>
													   	<form method="post" id="paymentForm">
													    	<div class="row">
													    		<div class="col-md-12">
													    			<?=$data['pricehtml']?>
													    		</div>
																<div class="col-md-6">
																	<h3>Personal information</h3>
																	<div id="customer_info">
																		<?php echo $data['phtml']; ?>
																		<?php echo $data['userhtml']; ?>
																	</div>
																</div>
												          		<div class="col-md-6">
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
									</div>
				          		</div>
				       		</div>
				    	</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/////////////////////////////////////////-->
	<div id="myModal_second" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Pay Now <div class="pricehtml"></div></h4>
			      </div>
			      <div class="modal-body paymodal">
					<form id="payment-form" action="{{ route('payment.checkout.process') }}" method="post">
						<input type="hidden" name="payment_type" value="braintree">
						{{ csrf_field() }}
						<div class="payment_fields" id="payment-fields"></div>
						<div id="payment-container"></div>
						<button id="submit-button">Continue </button> 
					</form>
			      </div>
			    </div>
			  </div>
			</div>	
	@endsection

	@section('script')
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
	    //var regYear = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
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
	            var formData = $('#paymentForm').serialize();
	            $.ajax({
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
	                   		var url="{{route('user.booking.confirm')}}?booking="+data.bookid;
	                   		setTimeout(function(){ 
	                   			window.location = url;
	                   		}, 3000);
	                    }else{
	                    	$('#paymentConfirm').show();
	                        $("#cardSubmitBtn").prop('disabled', false);
	                        $("#cardSubmitBtn").val('Proceed');
	                        $('#paymentConfirm').html('<p class="status-msg error">Transaction has been failed, please try again.</p>');
	                    }
	                }
	            });
	        }
	    });
	});
	</script>
	@endsection

