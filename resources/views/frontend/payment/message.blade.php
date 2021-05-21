@extends('frontend.layouts.app')
@section('content')
<!--/////////////////////////////////////////-->
<section class="search_result_section innertop_gap">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="booking_confirmation">       
           {{$message}}
       </div>
    </div>
    </div>
  </div>
</section>
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

  $('#confirm_btn').on('click', function(){
    var guides = [];
    var atLeastOneIsChecked = false;
    if ( $( ".checkbox" ).length ) {
 		$('input:checkbox').each(function () {
	      if ($(this).is(':checked')) {
	      	guides.push($(this).val());
	        atLeastOneIsChecked = true;
	        return false;
	      }
	    });
     }else{
     	guides.push(0);
     	atLeastOneIsChecked = true;
     }
    
    if(atLeastOneIsChecked){
        $.ajax({
          type     : "post",
          url      : "{{ route('hotel.booking.confirm') }}",
          data     : {
              "_token": "{{ csrf_token() }}",
              "guides": guides,
              "booking_id": {{ $booking['id'] }}
          },
          cache    : false,
          success  : function(data) {
            var data = $.parseJSON(data);
            if(data.status == 1){
             // $("#myModal").modal('hide');
              swal({title: 'Booking Confirmation!',
                text: "Your Booking successfully Confirm Please.. Thank you",
                type: 'success',
                buttons:false
              });
              //swal("Canceled!", "Booking canceled successfully!", "success");
              setTimeout(function(){
              window.location.href = '{{ route('user.booking.confirm') }}?booking='+'{{ $booking['id'] }}';
              }, 2000);
            }
          },
          error: function(err){
            swal('Please login to your account for cancellation process!');
          }
       });
     }else{
      swal('Please select a guide at least one guide');
    }
  });
</script>
@endsection
