@extends('frontend.layouts.app')
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.customer_sidenav')
  <div class="dashboard_content">
    <h1>My Booking</h1>
    <div class="update_profile">
      <div class="row">
        <div class="col-md-12">
              <table class="table table-bordered table-hover" id="booking_list">
              <thead>
                <tr>
                  <th scope="col">Bookig ID</th>
                  <th scope="col">Hotel Name</th>
                  <th scope="col">Room Title</th>
                  <th scope="col">Start Date Time</th>
                  <th scope="col">End Date Time</th>
                  <th scope="col">Guests</th>
                  <th scope="col">Nights</th>
                  <th scope="col">Type</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($bookings))
                @foreach($bookings as $booking)
                <tr>
                  <td><?php echo ($booking->xml_booking_id!=""?$booking->xml_booking_id:$booking->booking_id );?></td>
                  <td><?php echo ($booking->hotels_name!=''? $booking->hotels_name:getRoomxmlHotelData('hotelName',$booking->hotel_id) )?></td>
                  
                  <?php if($booking->type=="stuba"){ ?>
                    <td>{{ getStubaBookingValue('RoomName',$booking->booking_id) }}</td>
                    <td><?php echo date('d F, Y', strtotime(getStubaBookingValue('ArrivalDate',$booking->booking_id))) ?></td>
                    <td>{{ date('d F, Y', strtotime($booking->end_date)) }}</td>
                    <td>{{ getStubaBookingValue('Guests',$booking->booking_id) }}</td>
                    <td><span class="badge badge-info">{{ getStubaBookingValue('Nights',$booking->booking_id) }}</span></td>
                  <?php }else{ ?>
                    <td>{{ $booking->name }}</td>
                    <td>{{ date('d F, Y', strtotime($booking->start_date)) }} ({{ $booking->check_in }})</td>
                    <td>{{ date('d F, Y', strtotime($booking->end_date)) }} ({{ $booking->check_out }})</td>
                    <td>{{ $booking->quantity_adults + $booking->quantity_child }}</td>
                    <td><span class="badge badge-info">{{ $booking->nights }}</span></td>
                  <?php } ?>
                  
                   <?php if($booking->type=="stuba"){ ?>
                    <td><span style="padding:5px" class="badge-success">{{ $booking->type }}</span></td>
                  <?php }else{ ?>
                    <td><span style="padding:5px" class="badge-primary">{{ $booking->type }}</span></td>
                  <?php } ?>
                  
                  <td>
                    @switch($booking->booked_status)
                    @case(1)
                    <span class="label label-success">Completed</span>
                    @break
                    @case(2)
                    <span class="label label-danger">Cancelled</span>
                    @break
                    @case(3)
                    <span class="label label-primary">Pending</span>
                    @break
                    @endswitch
                  </td>
                  <td><a href="{{ route('customer.booking.details', ['id' => $booking->booking_id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="8" class="text-center">Data Not Available.</td>
                </tr>
                @endif
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js "></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#booking_list').DataTable();
} );
</script>
 
@endsection