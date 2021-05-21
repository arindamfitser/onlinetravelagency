@extends('frontend.layouts.app')
@section('css')
<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.css'>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/css/fileinput.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/css/fileinput.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
    @include('frontend.layouts.hotelier_sidenav')
    <div class="dashboard_content">
        <h1>Add Room</h1>
        @include('frontend.layouts.messages')
        <div class="wizard">
            <div class="tab-content">
                <span id="message"></span>
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <form id="RoomAddstep1" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                     <label>Room Name <span class="required">*</span></label>
                                    <input type="text" name="name" class="form-control requiredCheck" data-check="Room Name" placeholder="Room Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description <span class="required">*</span></label>
                                    <textarea class="form-control ckeditor requiredCheck" name="descp" id="descp" data-check="Description" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. of Rooms <span class="required">*</span></label>
                                    <input type="text" name="room_capacity" class="form-control isNumber requiredCheck" data-check="No. of Rooms" placeholder="No. of Rooms">
                                </div>
                                <div class="form-group">
                                    <label>Adult Capacity <span class="required">*</span></label>
                                    <input type="text" name="adult_capacity" class="form-control isNumber requiredCheck" data-check="Adult Capacity" placeholder="Adult Capacity">
                                </div>
                                <div class="form-group">
                                    <label>Availability <span class="required">*</span></label>
                                    <select class="form-control requiredCheck" name="availability" data-check="Availability">
                                        <option value="">-- Select Availability --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Amenities </label>&nbsp;&nbsp;&nbsp;&nbsp;</br>
                                    @foreach($amenities as $amenitiy)
                                        <label class="checkbox-inline"><input type="checkbox" name="amenities[]" value="{{ $amenitiy->id }}">{{ $amenitiy->amenities_name }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Base Price <span class="required">*</span></label>
                                    <input type="text" name="base_price" class="form-control allowNumberDot requiredCheck" data-check="Base Price" placeholder="Base Price">
                                </div>
                                <div class="form-group">
                                    <label>No.of bed <span class="required">*</span></label>
                                    <input type="text" name="extra_bed" class="form-control isNumber requiredCheck" data-check="No.of bed" placeholder="No.of bed">
                                </div>
                                <div class="form-group">
                                    <label>Child Capacity <span class="required">*</span></label>
                                    <input type="text" name="child_capacity" class="form-control requiredCheck" data-check="Child Capacity" placeholder="Child Capacity" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Featured Image <span class="required">*</span></label>
                                    <input type="file" name="featured_image" class="form-control requiredCheck" data-check="Featured Image">
                                </div>
                            </div>
                        </div>
                        <div class="row rommImageDiv"></div>
                        <div class="row">
                            <input type="hidden" id="imgCnt" value="0">
                            <div class="col-sm-12 text-center">
                                <div class="form-group text-center">
                                    <input type="button" class="btn btn-warning addMrImgBtn" value="+ Add Room Gallery Image">
                                </div>
                            </div>
                        </div>
                        <br/>
                        <ul class="list-inline text-center">
                            <li><button type="submit" class="btn btn-primary">Add Room</button></li>
                        </ul>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
            </form>
        </div>
    </div>
</section>
<div class="clearfix"></div>
@endsection
@section('script')
<script src="{{ asset('fullcalender') }}/lib/moment.min.js"></script>
<script src="{{ asset('fullcalender') }}/fullcalendar.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/js/fileinput.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
    $(document).on('click', '.addMrImgBtn', function() {
        let key = parseInt($('#imgCnt').val()) + parseInt(1);
        $('#imgCnt').val(key);
        $('.rommImageDiv').append('\
                                    <div class="col-sm-5 roomImg'+key+'">\
                                        <div class="form-group">\
                                            <label>Room Gallery Image </label>\
                                            <input type="file" name="gallery_image[]" class="form-control">\
                                        </div>\
                                    </div>\
                                    <div class="col-sm-5 roomImg'+key+'">\
                                        <div class="form-group">\
                                            <label>Image Alt Text</label>\
                                            <textarea name="gallery_image_alt[]" class="form-control imageAlt" rows="3"></textarea>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-2 roomImg'+key+'">\
                                        <div class="form-group">\
                                            <label class="bmd-label-floating">Action</label><br />\
                                            <input type="button" class="btn btn-danger deleteMrImgBtn" data-key="'+key+'" value="Remove">\
                                        </div>\
                                    </div>');
    });
    $(document).on('click', '.deleteMrImgBtn', function() {
        $('.roomImg' + $(this).attr('data-key')).remove();
    });
    $(document).on('submit', '#RoomAddstep1', function(e) {
        e.preventDefault();
        let flag            = commonFormChecking(true);
        if (flag) {
            let formData    = new FormData(this);
            $.ajax({
                type        : "POST",
                url         : "{{ route('user.hotels.rooms.doadd', ['id' => $id]) }}",
                data        : formData,
                cache       : false,
                contentType : false,
                processData : false,
                dataType    : "JSON",
                beforeSend  : function () {
                    $("#RoomAddstep1").loading();
                },
                success     : function (res) {
                    $("#RoomAddstep1").loading("stop");
                    if(res.success){
                        swalAlertThenRedirect(res.message, res.swal, "{{ route('user.hotels.rooms', ['id' => $id]) }}");
                    }else{
                        swalAlert(res.message, res.swal, 5000);
                    }
                },
            });
        }
    });
</script>
@endsection