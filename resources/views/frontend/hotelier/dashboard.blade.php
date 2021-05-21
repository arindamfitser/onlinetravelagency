@extends('frontend.layouts.app')

@section('css')
<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.css'>
<link href="{{ asset('fullcalender') }}/fullcalendar.print.min.css" rel='stylesheet' media='print' />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/basic/jquery.qtip.css" />
@endsection

@section('content')
<!--Banner sec-->
{{ asset('fullcalender') }}
<section class="profile dashboard hometop_gap">
	@include('frontend.layouts.hotelier_sidenav')
	<div class="dashboard_content">
		<h1>Hotel availability calendar</h1>
		<div class="row">
			<div class="col-md-12">
				<div class="user_panel">
					<div class="col-md-3"> 
							<div id="calender_filter">
								<form id="calenderFilter">
									<input type="hidden" name="available" value="off">
									<input type="hidden" name="notavailable" value="off">
									<input type="hidden" name="booked" value="off">
									<input type="hidden" name="hotel_id" id="hotel_id" value="">
									<span class="btn-success"> <label class="checkbox-inline   " for="e1"> <input type="checkbox" checked="checked"  name="available" value="on" id="e1" onclick="getAvailableCalender();"/>
										Available</label></span>
										<span class="btn-danger">  <label class="checkbox-inline  " for="e2"><input type="checkbox" checked="checked" name="notavailable" value="on" id="e2" onclick="getAvailableCalender();" />
											Unavailable</label></span>
											<span class="btn-warning">  <label class="checkbox-inline" for="e3"><input type="checkbox" checked="checked" name="booked" value="on" id="e3" onclick="getAvailableCalender();" />
												Booked</label></span>

												<div class="form-group">
													<select class="form-control" id="hotel_id"  name="hotel_id">
													@if(!empty($hotels))
														@foreach ($hotels as $hotel)
															@if($hotel->hotels_name!="")
																	  <option value="{{ $hotel->id }}">{{ $hotel->hotels_name }}</option>
																@endif
														@endforeach
													@endif
													</select>
												</div>
												
												<div class="form-group">
													<select class="form-control" id="roomtype"  name="roomType">
														<?php 
														$rms = (array)$room;
														if(!empty($rms)) { ?>
															@foreach ($room->rooms as $room)
																<option value="{{ $room->id }}">{{ $room->name }}</option>
															@endforeach
														<?php } ?>
													</select>
												</div>
												
												<div class="form-group" style="display:none;">
													<select class="form-control" onchange="getAvailableCalender();" name="room" id="rooms">
														<option>Select room</option>
													</select>
												</div>
											</form>
										</div>
										<div id="eventdetails">
										<div class="modal-body" >
											<div class="form-group">
												<label>Status</label>
												<select name="event_title" id="event_title" class="form-control">
													<option value="1">Available</option>
													<option value="2">Unavailable</option>
													<option value="3">Booked</option>
												</select>
											</div>
											<div class="form-group">
												<label>Price</label>
												<input type="text" name="room_price" id="room_price" class="form-control">
											</div>
											<div class="form-group">
														<label>Rooms details</label>
														<div id="rooms_details"></div>
													</div>
											<div class="form-group">
												<label>Select range</label>
												<input type="text" name="date_range" id="date_range" class="form-control">
											</div>
											<div class="form-group">
												<input type="hidden" name="date_id" id="date_id">
												<button type="button" name="update_date" id="save_calender" class="form-control">
													<span id="loadSpin"><i class="fa fa-spinner fa-spin"></i></span>Submit</button>
												</div>
											</div>
										</div>
								</div>
								<div class="col-md-9">
									<div id='calendar'></div>                  
								</div>
								<!-- <div class="col-md-3"></div> -->
									
								</div>
							</div>
						</div>
					</div>
					
					
				</section>
				<div class="clearfix"></div>




				@endsection

				@section('script')
				<script src="{{ asset('fullcalender') }}/lib/moment.min.js"></script>
				<script src="{{ asset('fullcalender') }}/fullcalendar.js"></script>
				<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/basic/jquery.qtip.js"></script>
				<script type="text/javascript">
					
					$(document).ready(function() {
						getAvailableCalender();
					});


					var getAvailableCalender = function(){
						$('#calendar').fullCalendar({
							header: {
								left: 'prev',
								center: 'title',
								right: 'next'
							},
							
		      navLinks: true, // can click day/week names to navigate views
		      editable: true,
              //eventLimit: true, // allow "more" link when too many events
              views: {
						agenda: {
						eventLimit: 4 // adjust to 6 only for agendaWeek/agendaDay
								 }
					},
              displayEventTime : false,
              selectable: true,
              select: function(start, end) {
              	$('#date_range').daterangepicker({
              		startDate: moment(start).format('YYYY-MM-DD'),
              		endDate:moment(end).format('YYYY-MM-DD'),
              		minDate: moment(),
              		locale: { 
              			format: 'YYYY-MM-DD'
              		}
              	});
              	$('.calender_modal').modal('show'); 
              },
              
              eventSources: [
              {
              	events: function(start, end, timezone, callback) {
              		$.ajax({
              			type:'GET',
              			url: '{{route('user.hotels.available')}}',
              			dataType: 'json',
              			data:$('#calenderFilter').serialize(),				
              			success: function(msg) {
              				var events = msg.events;
              				callback(events);
              			}
              		});
              	}
              },
              ],
              eventClick: function(event,jsEvent,view) {

              	$('#eventdetails').find('#event_title').val('');
              	$('#eventdetails').find('#start_date').val('');
              	$('#eventdetails').find('#date_id').val('');
              	$('#eventdetails').find('#room_price').val('');
              	$('#eventdetails').find('#end_date').val('');
              	$('#eventdetails').find('#rooms_details').html('');

              	$('#date_range').daterangepicker({
              		startDate: moment(event.start).format('YYYY-MM-DD'),
              		endDate:moment(event.start).format('YYYY-MM-DD'),
              		minDate: moment(),
              		locale: { 
              			format: 'YYYY-MM-DD'
              		}
              	});

              	$('#eventdetails').find('#event_title').val(event.key);
              	$('#eventdetails').find('#start_date').val(event.start);
              	$('#eventdetails').find('#date_id').val(event.id);
              	$('#eventdetails').find('#room_price').val(event.price);
              	$('#eventdetails').find('#end_date').val(event.end);
              	$('#eventdetails').find('#rooms_details').html(event.info);
              	var content = '<div>'+event.description+'</div>';

							tooltip.set({
								'content.text': content
							})
							.reposition(jsEvent).show(event);
		              },
		              
		              dayClick: function() { tooltip.hide() },
					  eventResizeStart: function() { tooltip.hide() },
					  eventDragStart: function() { tooltip.hide() },
					  viewDisplay: function() { tooltip.hide() },
		              eventRender: function(event, element) { 
		              	//element.find(".fc-title").append('<br>'+event.price);
              },
              eventRender: function(event, element) { 
              	element.find(".fc-title").append('<br>'+event.price);

              },    
          });

$('#calendar').fullCalendar('refetchEvents');

}

$(document).on('change','#roomtype',function(){
	alert($('#roomtype').val());
	$.ajax({
		type:'GET',
		url: '{{route('user.hotels.allrooms')}}',
		dataType: 'html',
		data:{room_id:$('#roomtype').val()},				
		success: function(data) {
			$('#rooms').html(data);
		}
	});
	getAvailableCalender();
});

$('#save_calender').on('click', function() {
	$('#loadSpin').show();
	var event_title = $('#event_title').val();
	var date_id = $('#date_id').val();
	var date_range = $('#date_range').val();
	var dates = date_range.split(" - ");
	var room_price = $('#room_price').val();
	
	
	if (event_title) {
		var date_data = {
			_token: "{{ csrf_token() }}",
			title: event_title,
			start: dates[0],
			end: dates[1],
			price: room_price,
			room_id: $('#roomtype').val(),
			date_id: date_id,
			hotel_id: "<?php echo (isset($room->hotel_id)?$room->hotel_id:''); ?>"

		};
		$.ajax({
			type     : 'POST',
			url      : "{{ route('user.hotels.rooms.adddate') }}",
			data     : date_data,
			dataType: 'json',
			success  : function(data) {
            //console.log(data);
            setTimeout(
            	function() 
            	{
            		
            		$('#loadSpin').hide();
            		getAvailableCalender();
            		
            	}, 2000);
        }
    });
	}
	
});

</script>

<style>
	#calendar {
		max-width: 100%!important;
		margin: 0 auto;
	}
	#calender_filter{
		margin: 10px 10px;
	}

</style>

@endsection
