@extends('frontend.layouts.hotelier_app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
@endsection
@section('content')
<div class="dashboard_right">
  @include('frontend.layouts.hotelier_head_top')
  <div class="booking_panel">
    <div role="tabpanel" class="tab-pane" id="client">
      <div class="customer_info">
        <div class="bookingtable">

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
                  <a href="{{ route('user.invoice.invoice_generate', ['id' => $bkData->booking_id]) }}" class="btn btn-danger" title="Download Pdf" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
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
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable({
        "order": [[ 0, "desc" ]]
    } );
} );
</script>
@endsection