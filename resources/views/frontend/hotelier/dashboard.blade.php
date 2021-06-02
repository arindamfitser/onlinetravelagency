@extends('frontend.layouts.app')
@section('css')
<link href="{{ asset('fullcalender') }}/fullcalendar.print.min.css" rel='stylesheet' media='print' />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/basic/jquery.qtip.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{ asset('css/fullcalendar.css')}}">
<style>
	#calendar {
		max-width: 100% !important;
		margin: 0 auto;
	}
	#calender_filter {
		margin: 10px 10px;
	}
	.fc-event-title {
		color: #000000 !important;
	}
</style>
@endsection
@section('content')
<!--Banner sec-->
{{ asset('fullcalender') }}
<?php 
$roomHtml = '';
if(!empty($room->rooms)) :
	foreach ($room->rooms as $room) : 
		$roomHtml .= '<option value="'. $room->id .'">'. $room->name .'</option>';
	endforeach;
endif;
?>
<section class="profile dashboard hometop_gap">
	@include('frontend.layouts.hotelier_sidenav')
	<div class="dashboard_content">
		<h1>Hotel availability Calendar</h1>
		<div class="row">
			<div class="col-md-12">
				<div class="user_panel">
					<div class="col-md-3"> 
						<div id="calender_filter">
							<form id="calenderFilter">
								{{ csrf_field() }}
								<input type="hidden" name="hotel_id" id="hotel_id" value="{{ $hotel->id }}">
								<input type="hidden" name="hotel_token" id="hotel_token" value="{{ $hotel->hotel_token }}">
								<input type="hidden" name="available" value="on">
								<input type="hidden" name="booked" value="on">
							</form>
						</div>
						<input type="hidden" class="datepicker" value="" id="selectedDate">
						<div id="eventdetails">
							<div class="modal-body" >
								<div class="bookingDetails hide">
									<h3 class="text-center bookingDetailshead">Booking Details</h3>
									<div class="form-group">
										<label></label>
										<div id="bookingDetails"></div>
									</div>
								</div>
								<h3 class="text-center">Change Room Availability</h3>
								<form id="roomCountForm">
									{{ csrf_field() }}
									<div class="form-group">
										<label>Room</label>
										<input type="hidden" id="orgCount" value="0">
										<select name="roomId" id="roomId" class="form-control requiredCheck" data-check="Room">
											<option value="">-- Select Room --</option>
											<?= $roomHtml ?>
										</select>
									</div>
									<div class="form-group">
										<label>From Date</label>
										<input type="text" name="fromDate" id="fromDate" class="form-control datepicker requiredCheck" data-check="From Date" autocomplete="off">
									</div>
									<div class="form-group">
										<label>To Date</label>
										<input type="text" name="toDate" id="toDate" class="form-control datepicker requiredCheck" data-check="To Date"
											autocomplete="off">
									</div>
									<div class="form-group newRoomCountDiv hide">
										<label>New Available Room</label>
										<input type="text" name="newAvailable" id="newAvailable" class="form-control isNumber requiredCheck" data-check="New Available Room" autocomplete="off">
									</div>
									<div class="form-group">
										<button type="submit" class="form-control btn btn-success">Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<div id='calendar'></div>                  
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</section>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/basic/jquery.qtip.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// $('.dateRangePicker').daterangepicker({
		// 		minDate: moment(),
		// 		locale: {
		// 			format: 'YYYY-MM-DD'
		// 	}
		// });
		$(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			minDate: 0
		});
	});
	document.addEventListener('DOMContentLoaded', function() {
		let calendarEl	= document.getElementById('calendar');
		let calendar 	= new FullCalendar.Calendar(calendarEl, {
							headerToolbar: {
								left: 'prev,next',
								center: 'title',
								right: 'dayGridMonth,timeGridDay'
								//right: 'dayGridMonth,timeGridWeek,timeGridDay'
								// left	: 'prev',
								// center	: 'title',
								// right	: 'next'
							},
							initialDate		: "{{ date('Y-m-d')}}",
							navLinks		: true, // can click day/week names to navigate views
							selectable		: true,
							selectMirror	: true,
							editable		: true,
							dayMaxEvents	: true, // allow "more" link when too many events
							businessHours	: true,
							select: function(arg) {
								$('#selectedDate').val(arg.startStr);
								getDateData();
								calendar.unselect();
							},
							eventClick: function(arg) {								if(!$('.bookingDetails').hasClass('hide')){
									$('.bookingDetails').addClass('hide');
								}
								$('.bookingDetailshead').text('Booking Details');
								$('#bookingDetails').empty();
								if($('.bookingDetails').hasClass('hide')){
									$('.bookingDetails').removeClass('hide');
								}
								$('#bookingDetails').html(arg.event.extendedProps.description);
							},
							eventSources: [{
								events: function(arg, callback) {
									$.ajax({
										type 		: 'POST',
										url 		: '{{route('user.hotels.available')}}',
										dataType 	: 'JSON',
										//data 		: $('#calenderFilter').serialize(),
										data 		: {
											'_token'		: '{{ csrf_token() }}',
											'start' 		: arg.startStr,
											'end' 			: arg.endStr,
											'hotel_id' 		: $('#hotel_id').val(),
											'hotel_token'	: $('#hotel_token').val(),
											'available' 	: 'on',
											'booked' 		: 'on',
										},
										success 	: function(msg) {
											let events = msg.events;
											callback(events);
										}
									});
								}
							}],
						});
	
		calendar.render();
	});
	
	/*let getAvailableCalender = function(){
		$('#calendar').fullCalendar({
			header: {
				left	: 'prev',
				center	: 'title',
				right	: 'next'
			},
			navLinks	: true,
			editable	: true,
			views: {
				agenda: {
					eventLimit: 4
				}
			},
            displayEventTime : false,
            selectable: true,
            select: function(start, end) {
            	// $('#dateRange').daterangepicker({
              	// 	startDate	: moment(start).format('YYYY-MM-DD'),
              	// 	endDate		: moment(end).format('YYYY-MM-DD'),
              	// 	minDate		: moment(),
              	// 	locale		: { 
              	// 		format: 'YYYY-MM-DD'
              	// 	}
              	// });
            },
            eventSources: [{
              	events: function(start, end, timezone, callback) {
              		$.ajax({
              			type		: 'POST',
              			url			: '{{route('user.hotels.available')}}',
              			dataType	: 'JSON',
              			data		: $('#calenderFilter').serialize(),				
              			success		: function(msg) {
							  //console.log(msg);
              				var events = msg.events;
              				callback(events);
              			}
              		});
              	}
			}],
            eventClick: function(event, jsEvent,view) {
				console.log(event);
				console.log(jsEvent);
				console.log(view);
				if(!$('.bookingDetails').hasClass('hide')){
					$('.bookingDetails').addClass('hide');
				}
				$('.bookingDetailshead').text('Booking Details');
				$('#bookingDetails').empty();
				if($('.bookingDetails').hasClass('hide')){
					$('.bookingDetails').removeClass('hide');
				}
				$('#bookingDetails').html(event.description);
		    },
			dayClick: function(start) {
				$('#selectedDate').val(start);
				getDateData();
			},
			eventResizeStart: function() { tooltip.hide() },
			eventDragStart: function(start, end) { tooltip.hide() },
			viewDisplay: function() { tooltip.hide() },
			eventRender: function(event, element) {
				//element.find(".fc-title").append('<br>'+event.price);
			},
            eventRender: function(event, element) { 
            	element.find(".fc-title").append('<br>'+event.price);
            },
        });
		$('#calendar').fullCalendar('refetchEvents');
	}*/
	function getDateData(){
		$.ajax({
			type 		: 'POST',
			url 		: "{{route('calendar.date.details')}}",
			dataType	: 'JSON',
			data 		: {
				'_token'		: '{{ csrf_token() }}',
				'start' 		: $('#selectedDate').val(),
				'hotel_token' 	: $('#hotel_token').val()
			},
			beforeSend: function() {
				$('#bookingDetails').empty();
				if(!$('.bookingDetails').hasClass('hide')){
					$('.bookingDetails').addClass('hide');
				}
				
			},
			success : function(res) {
				if(res.success){
					$('.bookingDetailshead').text(res.startDate);
					$('#bookingDetails').html(res.html);
					if($('.bookingDetails').hasClass('hide')){
						$('.bookingDetails').removeClass('hide');
					}
				}
			}
		});
	}
	$(document).on('change', '#roomId', function(e) {
		e.preventDefault();
		$('#orgCount').val('0');
		if(!$('.newRoomCountDiv').hasClass('hide')){
			$('.newRoomCountDiv').addClass('hide');
			$('#newAvailable').val('');
		}
		if($('#roomId').val() != ''){
			$.ajax({
				type		: "POST",
				url			: "{{ route('hotel.get.available.rooms') }}",
				data		: {
					_token		: "{{ csrf_token() }}",
					roomId		: $('#roomId').val()
				},
				dataType	: "JSON",
				beforeSend	: function() {
					$("#eventdetails").loading();
				},
				success		: function(res) {
					$("#eventdetails").loading('stop');
					if(res.success){
						$('.newRoomCountDiv').removeClass('hide');
						$('#orgCount').val(res.available);
					}
				}
			});
		}
	});
	$("#roomCountForm").submit(function(e) {
		e.preventDefault();
		let flag = commonFormChecking(true);
		if(flag){
			if(parseInt($('#newAvailable').val()) > parseInt($('#orgCount').val())){
				swalAlert('New Available Rooms can\'t be greater than Stock Rooms !!!', 'warning');
				flag = false;
				return false;
			}else{
				let formData = new FormData(this);
				$.ajax({
					type		: "POST",
					url			: "{{ route('hotel.update.available.rooms') }}",
					data		: formData,
					cache		: false,
					contentType	: false,
					processData	: false,
					dataType	: "JSON",
					beforeSend	: function() {
						$(".eventdetails").loading();
					},
					success		: function(res) {
						$(".holidaysection").loading('stop');
						if(res.success){
							$('.newRoomCountDiv').addClass('hide');
							$('#newAvailable').val('');
							$('#roomId').val('');
							$('#fromDate').val('');
							$('#toDate').val('');
							swalAlert('Available Rooms Update Successfully !!! ', 'success');
						}
					}
				});
			}
		}
	});
	$(document).on('click', '.checkIfChecked', function(e) {
		if($(this).is(":checked") == true){
			$(this).val('on');
		}else{
			$(this).val('off');
		}
		//getAvailableCalender();
	});
</script>
@endsection