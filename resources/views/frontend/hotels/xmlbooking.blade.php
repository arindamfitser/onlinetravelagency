@extends('frontend.layouts.app')
@section('css')
<style type="text/css">
	.header_search_area{display: none;}
</style>
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
							<form action="{{ route('bookingconfirm') }}" method="post">
								{{ csrf_field() }}
								<input type="hidden" name="quoteid" value="{{ $id }}">
								<input type="hidden" name="quantity_adults" value="{{ $quantity_adults }}">
								{{-- <input type="hidden" name="quantity_adults" value="{{ session('quantity_adults') }}"> --}}
								<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h2>Guest Details</h2></div>
								
								<?php
								//var_dump(Session::get('rooms'));
								//$quantity_rooms=$rooms_details["norm"];
								//$rooms_details = Session::get('rooms');
								// echo "<pre>";
								// print_r($rooms_details); die;
								if(isset($rooms_details["norm"])){ ?>
								<?php foreach ($rooms_details["norm"] as $j=>$val) { ?>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h3>Room <?php echo $a=$j+1;?> Guest Details</h3></div>
								<?php
								$quantity_adults = $rooms_details["adlts"][$j];
								$quantity_childs = (isset($rooms_details["kids"])) ? $rooms_details["kids"][$j] : 0;
								if($quantity_adults>0){ ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h4>Adult Details</h4>
								<?php for ($i=0; $i < $quantity_adults ; $i++) { ?>
								<div class="row">
									<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
										<div class="form-group">
												<select class="form-control" name="room[<?=$j;?>][audlt][<?=$i;?>][title]" required>
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
												<input type="text" class="form-control" placeholder="First Name*" name="room[<?=$j;?>][audlt][<?=$i;?>][first]" required>
											</div>
										</div>
										<div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Surname*" name="room[<?=$j;?>][audlt][<?=$i;?>][last]" required>
											</div>
										</div>
									</div>
									<?php
									} ?> 
									</div>
								<?php }
									if($quantity_childs>0){ ?>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h4>Child Details</h4>
									<?php for ($i=0; $i < $quantity_childs ; $i++) { ?>
										<div class="row">
											<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
												<div class="form-group">
													<select class="form-control" name="room[<?=$j;?>][child][<?=$i;?>][title]" required>
														<option value="">Title</option>
														<option value="Mr">Mr</option>
														<option value="Miss">Miss</option>
														<option value="Ms">Ms</option>
													</select>
												</div>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="First Name*" name="room[<?=$j;?>][child][<?=$i;?>][first]" required>
													</div>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="Surname*" name="room[<?=$j;?>][child][<?=$i;?>][last]" required>
													</div>
												</div>
												<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
												<div class="form-group">
														<select class="form-control" name="room[<?=$j;?>][child][<?=$i;?>][age]" required>
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
										<?php } ?> 
										</div>
									<?php }?>
									<?php }?>
									<?php }?>
								</div>
								<button type="submit" class="btn btn-primary xmlsubmit">Submit</button>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3"></div>
</section>
@endsection
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></scr
<script type="text/javascript">
$(document).ready(function() {
	function disablePrev() { window.history.forward() }
	window.onload = disablePrev();
	window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
});
</script>