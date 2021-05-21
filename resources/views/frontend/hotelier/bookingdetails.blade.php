@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.hotelier_sidenav')
  <div class="dashboard_content">
    <h1>All Bookings</h1>
    <div class="row">
      <div class="col-md-12">
        <div class="user_panel">
          <table class="table table-bordered table-hover" id="hotel">
            <thead>
              <tr>
                <th scope="col">User Name</th>
                <th scope="col">User Email</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Total Nights</th>
                <th scope="col">Amount</th>
                <th scope="col">Booking Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bookings as $booking)
              <?php
              $users = get_user_details($booking->booked_user);
              if(!empty($users)){
              ?>
              <tr>
                <td>{{ $users->first_name }} {{ $users->last_name }}</td>
                <td>{{ $users->email }}</td>
                <td>{{ date('d F, Y', strtotime($booking->start_date)) }}</td>
                <td>{{ date('d F, Y', strtotime($booking->end_date)) }}</td>
                <td>{{ $booking->nights }}</td>
                <td>{{ $booking->carttotal }} {{ $booking->currency }}</td>
                <td>
                  @switch($booking->booked_status)
                  @case(1)
                  <span class="label label-success">Completed</span>
                  @break
                  @case(2)
                  <span class="label label-danger">Cancel</span>
                  @break
                  @case(3)
                  <span class="label label-primary">Pending</span>
                  @break
                  @endswitch
                </td>
                <td>
                  <a href="{{ route('users.view_booking', ['id' => $booking->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                </td>
              </tr>
              <?php } ?>
              @endforeach
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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#hotel').DataTable();
} );
</script>
@endsection