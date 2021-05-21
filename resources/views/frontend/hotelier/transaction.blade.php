@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.hotelier_sidenav')
  <div class="dashboard_content">
    <h1>All Transactions</h1>
    <div class="row">
      <div class="col-md-12">
        <div class="user_panel">
          <table class="table table-bordered table-responsive" id="datatable">
            <thead>
              <tr>
                <th>ID </th>
                <th>Booking ID </th>
                <th>Transaction ID </th>
                <th>Client Name</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Payment Option</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($transaction as $tkey => $tData){
              if(!empty($tData)){
              foreach($tData as $data){
              $udata = App\User::where('id', $data->user_id)->get()->first();
              ?>
              <tr>
                <td>{{ $data->ts_id }}</td>
                <td><a href="{{ route('users.view_booking', ['id' => $data->booking_id]) }}">{{ $data->booking_id }}</a></td>
                <td>{{ $data->transid }}</td>
                <td>{{ $udata->first_name.' '.$udata->last_name }}</td>
                <td><?php echo getPrice($data->amount); ?></td>
                <td>{{ $data->payment_type }}</td>
                <td>
                  {{ $data->payment_opt }}
                </td>
                <td>
                  @switch($data->status)
                  @case(1)
                  <span class="label label-success">Completed</span>
                  @break
                  @case(3)
                  <span class="label label-primary">Processing</span>
                  @break
                  @case(2)
                  <span class="label label-danger">Failed</span>
                  @break
                  @endswitch
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
$('#datatable').DataTable({
  "order": [[ 0, "desc" ]]
});
} );
</script>
@endsection