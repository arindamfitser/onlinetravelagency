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
                        <h3 class="card-title">Send Invitation
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
                                            <form id="sendInviForm" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Name <span class="red">*</span></label>
                                                            <input type="text" name="hotel_name" class="form-control requiredCheck" data-check="Hotel Name" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Address <span class="red">*</span></label>
                                                            <input type="text" name="address" class="form-control requiredCheck" data-check="Hotel Address" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel Country <span class="red">*</span></label>
                                                            <select id="country_id" class="form-control requiredCheck" data-check="Hotel Country" name="country" onchange="getState(this.value);">
                                                                <?php @countryOption(); ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel State <span class="red">*</span></label>
                                                            <select id="state_id" class="form-control requiredCheck" data-check="Hotel State" name="state">
                                                                <?php @stateOption(); ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Hotel City/Town <span class="red">*</span></label>
                                                            <input type="text" name="city" class="form-control requiredCheck" data-check="Hotel City/Town" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Name of Representative <span class="red">*</span></label>
                                                            <input type="text" name="representative_name" data-check="Name of Representative" class="form-control requiredCheck" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Contact Email <span class="red">*</span></label>
                                                            <input type="text" name="contact_email" data-check="Contact Email" class="form-control requiredCheck" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Contact Phone <span class="red">*</span></label>
                                                            <input type="text" name="contact_phone" data-check="Contact Phone" class="form-control requiredCheck isNumber" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul class="list-inline text-center">
                                                            <li><button type="submit" class="btn btn-success btn-rounded btn-sm waves-effect waves-light"> Send Invitation </button></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </form>
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
}
$("#sendInviForm").on('submit', function(e){
	e.preventDefault();
    let flag            = commonFormChecking(true);
    if (flag) {
    	let formData    = new FormData(this);
		$.ajax({
			type        : "POST",
			url         : "{{ route('admin.save.invitation') }}",
			data        : formData,
			cache       : false,
			contentType : false,
			processData : false,
			dataType    : "JSON",
			beforeSend  : function () {
				$("#sendInviForm").loading();
			},
			success     : function (res) {
				$("#sendInviForm").loading("stop");
				if(res.success){
					swalAlertThenRedirect(res.message, res.swal, "{{ route('admin.invitation.list') }}");
				}else{
					swalAlert(res.message, res.swal, 5000);
				}
			},
		});
    }
});
</script>
@endsection