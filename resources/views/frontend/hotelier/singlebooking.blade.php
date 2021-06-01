@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.hotelier_sidenav')
  <div class="dashboard_content">
    <h1>Booking Details</h1>
    <div class="row">
      <div class="col-md-12">
          <?php echo bookingdetailsHtml($id); ?>
          <br />
          <ul class="list-inline text-center">
            <li>
              <a href="{{ route('users.bookings') }}">
                <button type="button" class="btn btn-danger">Back to Bookings</button>
              </a>
            </li>
          </ul>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cancel Booking</h4>
      </div>
      <div class="modal-body">
       <div class="cncl_modalbody_top">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="cnclbox">
              <h2><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No Cancellation Fees</h2>
              <p>100% Refundable</p>
              <p>Free cancellation within 10 minutes booking</p>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="cnclbox2">
              100% <br><b>Refundable </b>
            </div>
          </div>
        </div>
      </div>
      <div class="cncl_modalbody_bottom">
        <input type="hidden" name="reason" id="reason" value="">
        <h2>Please select a reason for cancellation</h2>
        <a href="javascript:void(0);" class="reason_cls" data-val="Change plan"><i class="fa fa-retweet" aria-hidden="true"></i> Change plan</a>
        <a href="javascript:void(0);" class="reason_cls" data-val="Got a better deal"><i class="fa fa-object-ungroup" aria-hidden="true"></i> Got a better deal</a>
        <a href="javascript:void(0);" class="reason_cls" data-val="Want to book different hotel"><i class="fa fa-bed" aria-hidden="true"></i> Want to book different hotel</a>
        <a href="javascript:void(0);" class="reason_cls" data-val="Booking created by mistake"><i class="fa fa-random" aria-hidden="true"></i> Booking created by mistake</a>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" id="cancel_btn" class="btn btn-default">Confirm</button>
    </div>
  </div>
</div>
</div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#hotel').DataTable();
} );
</script>
<script type="text/javascript">
  $(".reason_cls").on('click', function(){
    $('a').removeClass('active');
    var data_val = $(this).attr('data-val');
    $("#reason").val(data_val);
    $(this).addClass('active');
  });
  $('#cancel_btn').on('click', function(){
    var reason = $("#reason").val();
    if(reason != ""){
        $.ajax({
          type     : "post",
          url      : "{{ route('user.booking.cancelation') }}",
          data     : {
            "_token": "{{ csrf_token() }}",
            "reason": reason,
            "booking_id": {{ $id }}
          },
          dataType : "JSON",
          success  : function(res) {
            if(res.success){
              //$("#myModal").modal('hide');
              swalAlertThenRedirect('"Booking Cancelled Successfully !!!', 'success', "{{ route('users.bookings') }}");
            }
          }
      });
    }else{
      swalAlert("Please select a reason for cancellation !!!", "warning", 5000);
    }
  });
</script>
@endsection