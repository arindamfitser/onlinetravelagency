
text/x-generic index.blade.php ( HTML document, ASCII text, with CRLF line terminators )

@extends('admin.layouts.master')
@section('th_head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('backend/froala/css/froala_editor.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/froala_style.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/code_view.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/colors.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/emoticons.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/image_manager.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/image.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/line_breaker.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/table.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/char_counter.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/video.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/fullscreen.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/file.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/css/fileinput.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.11.14/jquery.timepicker.css">
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<style>
/* Always set the map height explicitly to define the size of the div
* element that contains the map. */
#map {
  height: 250px;
}
/* Optional: Makes the sample page fill the window. */
#infowindow-content .title {
  font-weight: bold;
}
#infowindow-content {
  display: none;
}
#map #infowindow-content {
  display: inline;
}
.red{
    color : red;
}
</style>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h3 class="card-title">Invitation Details : {{ $details->hotel_code }}
                        <div class="float-right">
                            <!--<select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">-->
                            <!--  <?php @langOption(); ?>-->
                            <!--</select>-->
                            <!--<a href="{{ route('admin.hotels')}}" class="btn-sm btn-success btn-round ">-->
                            <!--  <i class="material-icons">library_books</i> List</a>-->
                        </div>
                        </h3>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.messages')
                        <?php
                        $lang = @\Session::get('language');
                        ?>
                        <div class="wizard">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tab-content tab-space">
                                        <div class="tab-pane active" id="pill1">
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Code </label>
                                                            <input type="text" class="form-control" readonly value="{{ $details->hotel_code }}" autofocus>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Name </label>
                                                            <input type="text" class="form-control requiredCheck" value="{{ $details->hotel_name }}" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Email </label>
                                                            <input type="text" value="{{ $details->hotel_email }}" class="form-control requiredCheck" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Phone </label>
                                                            <input type="text" value="{{ $details->hotel_phone }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Address </label>
                                                            <input type="text" value="{{ $details->hotel_address }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Country </label>
                                                            <select class="form-control" readonly>
                                                                <?php @countryOption($details->hotel_country); ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel State </label>
                                                            <select class="form-control" readonly>
                                                                <?php @stateOption($details->hotel_state); ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel City </label>
                                                            <input type="text" value="{{ $details->hotel_city }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Description </label>
                                                            <textarea class="form-control" rows="10" readonly>{{ $details->hotel_description }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Additional Information</label>
                                                            <textarea class="form-control" rows="5" readonly>{{ $details->addition_info }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Service Amenities</label>
                                                            <textarea class="form-control" rows="5" readonly>{{ $details->amenities }}</textarea>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Spa Available? </label>
                                                            <input type="text" value="{{ ($details->spa_available) ? 'Yes' : 'No' }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Beach Available? </label>
                                                            <input type="text" value="{{ ($details->beach_available) ? 'Yes' : 'No' }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Fine Dining Available? </label>
                                                            <input type="text" value="{{ ($details->fine_dining_available) ? 'Yes' : 'No' }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Pool Available? </label>
                                                            <input type="text" value="{{ ($details->pool_available) ? 'Yes' : 'No' }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Diving Available? </label>
                                                            <input type="text" value="{{ ($details->diving_available) ? 'Yes' : 'No' }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Water Sports Available? </label>
                                                            <input type="text" value="{{ ($details->water_sports_available) ? 'Yes' : 'No' }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul class="list-inline text-center">
                                                            <li>
                                                                <a href="{{ url()->previous() }}">
                                                                    <button type="button" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light"> Back </button>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('th_foot')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" ></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/froala_editor.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/align.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/code_beautifier.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/code_view.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/colors.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/draggable.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/emoticons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/font_size.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/font_family.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/image.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/file.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/image_manager.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/line_breaker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/link.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/lists.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/paragraph_format.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/paragraph_style.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/video.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/table.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/url.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/entities.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/char_counter.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/inline_style.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/save.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/fullscreen.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/js/fileinput.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/timepicker@1.11.14/jquery.timepicker.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script src="{{ asset('backend/assets/js/posts.js') }}"></script>
<script type="text/javascript">
function getState(id){
    $.ajax({
        type: "POST",
        url: "{{ route('admin.get_state') }}",
        data:{
            "_token": "{{ csrf_token() }}",
            "country_id": id
        },
        success: function(data){
            $('#state_id').html(data);
        }
    });
};
</script>
@endsection

