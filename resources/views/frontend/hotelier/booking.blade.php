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
 <table class="table table-bordered table-responsive" id="datatable">
            <thead>
              <tr>
                  <th>ID </th>
                  <th>Hotel </th>
                  <th>Room</th>
                  <th>Check in</th>
                  <th>Check out</th>
                  <th>Guests</th>
                  <th>Nights</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($bookings as $bkey => $bData){
              if(!empty($bData)){
              foreach($bData as $bkData){
                $udata = App\User::where('id', $bkData->booked_user)->get()->first();
              ?>
              <tr>
                  <td>{{ $bkData->booking_id }}</td>
                  <td>{{ $bkData->hotels_name }}</td>
                  <td>{{ $bkData->name }}</td>
                  <td>{{ date('d F, Y', strtotime($bkData->start_date)) }} ({{ $bkData->check_in }})</td>
                  <td>{{ date('d F, Y', strtotime($bkData->end_date)) }} ({{ $bkData->check_out }})</td>
                  <td>
                    {{ $bkData->quantity_adults + $bkData->quantity_child }}
                  </td>
                  <td><span class="badge badge-info">{{ $bkData->nights }}</span></td>
                  <td> <?php echo getPrice($bkData->carttotal); ?></td>
                <td>
                  @switch($bkData->booked_status)
                  @case(1)
                  <span class="label label-success">Completed</span>
                  @break
                  @case(3)
                  <span class="label label-primary">Processing</span>
                  @break
                  @case(2)
                  <span class="label label-danger">Cancelled</span>
                  @break
                  @endswitch
                </td>
                <td>
                  <a href="{{ route('users.view_booking', ['id' => $bkData->booking_id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                </td>
              </tr>
              <?php
              }
              }
              }
              ?>
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
$('#datatable').DataTable();
} );
</script>
@endsection