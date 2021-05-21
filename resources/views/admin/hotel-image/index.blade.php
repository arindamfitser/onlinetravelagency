@extends('admin.layouts.master')
@section('th_head')
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Stuba Hotel Main Image
                <div class="float-right">
                    <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                        <?php @langOption(); ?>
                    </select>
                </div>
            </div>
            <div class="card-body table-responsive stubaHotelImage">
                @include('admin.layouts.messages')
             </div>
         </div>
     </div>
 </div>
@endsection
@section('th_foot')
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.loading.css') }}">
<script src="{{ asset('frontend/js/jquery.loading.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(function() {
        $.ajax({
          type: 'POST',
          url: '{{ route('admin.fetch.hotel.image') }}',
          data: {
            '_token': '{{ csrf_token()}}'
          },
          dataType: 'JSON',
          beforeSend: function () {
            $(".stubaHotelImage").loading();
          },
          success: function(res){
            $(".stubaHotelImage").loading("stop");
            $(".stubaHotelImage").append(res.html);
          }
        });
    });
</script>
@endsection