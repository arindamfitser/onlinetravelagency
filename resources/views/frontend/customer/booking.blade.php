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
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Nights</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($bookings)):
                foreach($bookings as $booking):
              ?>
                <tr>
                  <td>{{ $booking->id }}</td>
                  <td>{{ !empty($booking->hotels_name) ? $booking->hotels_name : getRoomxmlHotelData('hotelName',$booking->hotel_id) }}</td>
                  <?php if($booking->type=="stuba"): ?>
                    <td>{{ getStubaBookingValue('RoomName',$booking->booking_id) }}</td>
                    <td><?php echo date('d F, Y', strtotime(getStubaBookingValue('ArrivalDate',$booking->booking_id))) ?></td>
                    <td>{{ date('d F, Y', strtotime($booking->end_date)) }}</td>
                    <td><span class="badge badge-info">{{ getStubaBookingValue('Nights',$booking->booking_id) }}</span></td>
                  <?php else: ?>
                    <td>{{ $booking->name }}</td>
                    <td>{{ date('d F, Y', strtotime($booking->start_date)) }} ({{ $booking->start_date }})</td>
                    <td>{{ date('d F, Y', strtotime($booking->end_date)) }} ({{ $booking->end_date }})</td>
                    <td><span class="badge badge-info">{{ $booking->nights }}</span></td>
                  <?php endif; ?>                    
                  <td>
                    @switch($booking->status)
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
                  <td><a href="{{ route('customer.booking.details', ['id' => $booking->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                </tr>
              <?php
                endforeach;
              else:
              ?>
                <tr>
                  <td colspan="6" class="text-center">No Booking Available !!!</td>
                </tr>
              <?php endif; ?>
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
  $('#booking_list').DataTable({
    pageLength: 10,
    searching: true,
    autoWidth: false,
    order: [[ 0, "desc" ]]
    /*
    dom: 'Bfrtip',
    buttons: [
    //'copy', 'csv', 'excel', 'pdf', 'print'
    'excel', 'pdf', 'print'
    ]
    */
  });
});
</script>
@endsection