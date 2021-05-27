@extends('frontend.layouts.app')
@section('css')
<style type="text/css">
	.header_search_area{display: none;}
	.bookingGuestFormSubmit {
		background: #E84B02;
		color: #fff;
		display: block;
		font-size: 16px;
		font-weight: 400;
		padding: 8px 25px;
		border: none;
		border-radius: 0;
	}
</style>
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
@endsection
@section('content')
<section class="innerbannersection"></section>
<section class="booking_wrapper" id="header_fixed">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-10 col-lg-offset-1">
				<div class="bkr_left"><div>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="profile">
						<div class="tab_form">
							<form id="bookingGuestForm" action="{{ route('hotel.booking.summary') }}" method="post">
								{{ csrf_field() }}
								<input type="hidden" name="bookingArray" value="{{ json_encode($bookingArray) }}">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<h2>Guest Details</h2>
									</div>
									<?php
									foreach ($bookingArray['rooms']['norm'] as $j => $val) :							
									?>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<h3>Room {{ ($j+1) }} Guest Details</h3></div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<h4>Adult Details</h4>
									<?php for ($i=0; $i < $bookingArray['rooms']["adlts"][$j] ; $i++) : ?>
												<div class="row">
													<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
														<div class="form-group">
															<select class="form-control requiredCheck" name="adultTitle[{{ $j }}][]" data-check="Adult Title">
																<option value="">Title</option>
																<option value="Mr">Mr</option>
																<option value="Mrs">Mrs</option>
																<option value="Dr">Dr</option>
																<option value="Miss">Miss</option>
																<option value="Ms">Ms</option>
																<option value="Mr and Mrs">Mr and Mrs</option>
																<option value="Prof">Prof</option>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
														<div class="form-group">
															<input type="text" class="form-control requiredCheck" placeholder="First Name*" name="adultFirst[{{ $j }}][]" data-check="Adult First Name">
														</div>
													</div>
													<div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
														<div class="form-group">
															<input type="text" class="form-control requiredCheck" placeholder="Last Name*" name="adultLast[{{ $j }}][]" data-check="Adult Last Name">
														</div>
													</div>
												</div>
									<?php 
										endfor;
										print '</div>';
										if($bookingArray['rooms']["kids"][$j] > 0) :										
									?>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<h4>Child Details</h4>
									<?php for ($i=0; $i < $bookingArray['rooms']["kids"][$j]; $i++) : ?>
												<div class="row">
													<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
														<div class="form-group">
															<select class="form-control requiredCheck" name="childTitle[{{ $j }}][]" data-check="Child Title">
																<option value="">Title</option>
																<option value="Mr">Mr</option>
																<option value="Miss">Miss</option>
																<option value="Ms">Ms</option>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
														<div class="form-group">
															<input type="text" class="form-control requiredCheck" placeholder="First Name*" name="childFirst[{{ $j }}][]" data-check="Child First Name">
														</div>
													</div>
													<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
														<div class="form-group">
															<input type="text" class="form-control requiredCheck" placeholder="Surname*" name="childLast[{{ $j }}][]" data-check="Child Last Name">
														</div>
													</div>
													<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
														<div class="form-group">
															<select class="form-control requiredCheck" name="childAge[{{ $j }}][]" data-check="Child Age">
																<option value="">Age</option>
																<option value="1">1</option>
																<option value="2">2</option>
																<option value="3">3</option>
																<option value="4">4</option>
																<option value="5">5</option>
																<option value="6">6</option>
																<option value="7">7</option>
															</select>
														</div>
													</div>
												</div>
									<?php
											endfor;
											print '</div>';
										endif;
									endforeach;
									?> 
								</div>
								<button type="button" class="btn btn-primary bookingGuestFormSubmit">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3"></div>
</section>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	function disablePrev() { window.history.forward() }
	window.onload = disablePrev();
	window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
	$(document).on('click', '.bookingGuestFormSubmit', function(e) {
		e.preventDefault();
		let flag = commonFormChecking(true);
		if (flag) {
			$('#bookingGuestForm').submit();
		}
	});
});
</script>