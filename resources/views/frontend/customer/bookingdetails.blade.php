@extends('frontend.layouts.app')
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.customer_sidenav')
  <div class="dashboard_content">
    <h1>Booking Details</h1>
     @include('frontend.layouts.messages')
      <div class="row">
        <div class="col-md-12">
         <?php 
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
  </div>
</section>
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
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="cnclbox">
              <h2><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span>Cancellation Fees</span></h2>
                 <p id="RefundablePolicies"></p>
            </div>
          </div>
          <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="cnclbox2">
              <b>Cancellation Fees</b>
              
            </div>
          </div> -->
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
      <button type="button" id="xml_cancel_btn" style="display:none;" class="btn btn-default" onclick="stubaCancelConfirm({{$booking->xml_booking_id}});">Confirm</button>
    </div>
  </div>

</div>
</div>
<div class="clearfix"></div>
@endsection
@section('script')
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
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
              "booking_id": {{ $id }}
          },
          cache    : false,
          success  : function(data) {
            var data = $.parseJSON(data);
            if(data.status == 1){
              $("#myModal").modal('hide');
              swal({title: 'Canceled!',
                text: "Booking canceled successfully!",
                type: 'success',
                buttons:false});
              //swal("Canceled!", "Booking canceled successfully!", "success");
              setTimeout(function(){
                location.reload();
              }, 2000);
            }
          }
      });
    }else{
      swal('Please select a reason for cancellation');
    }
  });

  var stubaCancel = function(booking_id){
    Swal.fire({
      title: 'Are you sure want to cancel booking?',
      text: "",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Cancel it !'
    }).then((result) => {
      if (result.value) {
        $("#RefundablePolicies").html();
        $.ajax({
          type     : "post",
          url      : "{{ route('stuba.booking.cancel.prepare') }}",
          data     : {
              "_token": "{{ csrf_token() }}",
              "booking_id": booking_id
          },
          cache    : false,
          success  : function(data) {
            var data = $.parseJSON(data);
            if(data.CommitLevel == 'prepare'){
              $("#cancel_btn").hide();
              $("#xml_cancel_btn").show();
              $("#RefundablePolicies").html(data.msg);
              $("#myModal").modal('show');
            }
            if (data.Code) {
              swal("Error!", data.Description, "error");
            }
          }
        });
      }
    });    
  }
  var stubaCancelConfirm = function(booking_id){
    var reason = $("#reason").val();
    if(reason != ""){
      $.ajax({
        type     : "post",
        url      : "{{ route('stuba.booking.cancel.confirm') }}",
        data     : {
            "_token": "{{ csrf_token() }}",
            "reason": reason,
            "booking_id": "{{ $id }}",
            "xbooking_id": booking_id
        },
        cache    : false,
        success  : function(data) {
          var data = $.parseJSON(data);
          if(data.CommitLevel == 'confirm'){
            $("#myModal").modal('hide');
            swal({title: 'Canceled!',
              text: "Booking Cancelled successfully!",
              type: 'success',
              buttons:false});
            //swal("Canceled!", "Booking canceled successfully!", "success");
            setTimeout(function(){
              location.reload();
            }, 2000);
          }
          if (data.Code) {
            swal("Error!", data.Description, "error");
          } 
        }
      });
    }else{
      swal('','Please select a reason for cancellation',"error");
    }
  }
</script>
@endsection