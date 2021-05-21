@extends('frontend.layouts.app')
@section('css')
<style type="text/css">
  .booking_cancel{
    display: none;
  }
</style>
@endsection
@section('content')

<!--/////////////////////////////////////////-->
<section class="search_result_section innertop_gap">
<div class="container">
<div class="row">
  <div class="col-md-8 col-md-offset-2">
     <?php 
    /* $booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->where('bookings.id', '=', $id)->get()->first();
     echo bookingdetailsHtml($booking['id']);*/
     ?>
     <?php 
         $id=$booking['id'];
          $booking = App\Booking::select('*', 'bookings.user_id as booked_user', 'bookings.status as booked_status')->where('bookings.id', '=', $id)->get()->first();
          if($booking->type=='site'){
              echo bookingdetailsHtml($id);
              //echo invoice_generate($id,'site');
          }else if($booking->type=='stuba'){
              echo stubaBookingdetailsHtml($id);
               //echo getStubaBookingValue('roomName',$id);
          }
          
         ?>
  </div>
</div>
</section>
<!--/////////////////////////////////////////-->
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
              "booking_id": {{ $booking['id'] }}
          },
          cache    : false,
          success  : function(data) {
            var data = $.parseJSON(data);
            if(data.status == 1){
              $("#myModal").modal('hide');
              swal({title: 'Cancelled!',
                text: "Booking cancelled successfully!",
                type: 'success',
                buttons:false});
              //swal("Canceled!", "Booking canceled successfully!", "success");
              setTimeout(function(){
                location.reload();
              }, 2000);
            }
          },
          error: function(err){
            swal('Please login to your account for cancellation process!');
          }
      });
    }else{
      swal('Please select a reason for cancellation');
    }
  });
</script>
@endsection
