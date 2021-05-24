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
    @include('frontend.layouts.messages')
    <div class="row">
      <div class="col-sm-12">
        <a href="{{ route('user.booking.add') }}" class="btn btn-success pull-right">
          <i class="fa fa-plus" aria-hidden="true"></i> New Booking
        </a>
      </div>
    </div>
    <br>
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
                <th>Nights</th>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($bookings)):
                foreach($bookings as $bkey => $bData):
                  foreach($bData as $bkData):
                    $udata = App\User::where('id', $bkData->user_id)->first();
              ?>
                  <tr>
                    <td>{{ $bkData->id }}</td>
                    <td>{{ $bkData->hotels_name }}</td>
                    <td>{{ $bkData->name }}</td>
                    <td>{{ date('d F, Y', strtotime($bkData->start_date)) }} ({{ $bkData->start_date }})</td>
                    <td>{{ date('d F, Y', strtotime($bkData->end_date)) }} ({{ $bkData->end_date }})</td>
                    <td><span class="badge badge-info">{{ $bkData->nights }}</span></td>
                    <td>{{ $udata->first_name . ' ' . $udata->last_name }}</td>
                    <td> <?php echo getPrice($bkData->carttotal); ?></td>
                    <td>
                      @switch($bkData->status)
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
                      <a href="{{ route('users.view.booking', ['id' => $bkData->id]) }}" class="btn btn-info"><i
                          class="fa fa-eye"></i></a>
                    </td>
                  </tr>
              <?php
                endforeach;
              endforeach;
            endif;
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