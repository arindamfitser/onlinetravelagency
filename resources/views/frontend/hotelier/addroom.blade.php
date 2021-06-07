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
                                     <label>Room Type Name <span class="required">*</span><em style="font-size: 12px;color: #3fa7f1;">(e.g. “Garden Room”, “Pool Suite”, “Overwater Bungalow” etc)</em></label>
                                    <input type="text" name="name" class="form-control requiredCheck" data-check="Room Name" placeholder="Room Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Room Description <span class="required">*</span><em style="font-size: 12px;color: #3fa7f1;">Describe best room features & attractions - include bed size(s)</em></label>
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
                                    <input type="text" name="adult_capacity" class="form-control isNumber requiredCheck" data-check="Adult Capacity"
                                        placeholder="Adult Capacity">
                                </div>
                                <div class="form-group">
                                    <label>Availability <span class="required">*</span></label>
                                    <select class="form-control requiredCheck" name="availability" data-check="Availability">
                                        <option value="">-- Select Availability --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No.of bed <span class="required">*</span></label>
                                    <input type="text" name="extra_bed" class="form-control isNumber requiredCheck" data-check="No.of bed" placeholder="No.of bed">
                                </div>
                                <div class="form-group">
                                    <label>Child Capacity <span class="required">*</span></label>
                                    <input type="text" name="child_capacity" class="form-control isNumber requiredCheck" data-check="Child Capacity"
                                        placeholder="Child Capacity" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Room Amenities <em style="font-size: 12px;color: #3fa7f1;">List Room Amenities separated by commas</em></label><br />
                                    @foreach($amenities as $amenitiy)
                                    <label class="checkbox-inline"><input type="checkbox" name="amenities[]"
                                            value="{{ $amenitiy->id }}">{{ $amenitiy->amenities_name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Room Only Wholesale Rate <span class="required">*</span></label>
                                    <input type="text" name="base_price" class="form-control allowNumberDot requiredCheck"
                                        data-check="Base Price" placeholder="Room Only Wholesale Rate">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="prcCnt" value="0">
                        <div class="row moreMealDiv">
                            <h2 class="text-center">Add Meal Plan</h2>
                            <div class="col-sm-5 roomPrc">
                                <div class="form-group">
                                    <label>Meal Plan </label>
                                    <input type="text" name="mealText[]" class="form-control" data-check="Meal Plan"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-5 roomPrc">
                                <div class="form-group">
                                    <label>Meal Price</label>
                                    <input type="text" name="mealValue[]" class="form-control allowNumberDot" data-check="Meal Price"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="form-group text-center">
                                    <input type="button" class="btn btn-info addMealBtn" value="+ Add Meal">
                                </div>
                            </div>
                        </div>
                        <br /><br />
                        <div class="row morePackageDiv">
                            <h2 class="text-center">Add Package</h2>
                            <div class="col-sm-5 roomPrc">
                                <div class="form-group">
                                    <label>Package Name </label>
                                    <input type="text" name="packageText[]" class="form-control" data-check="Package Name" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-5 roomPrc">
                                <div class="form-group">
                                    <label>Package Price</label>
                                    <input type="text" name="packageValue[]" class="form-control allowNumberDot" data-check="Package Price"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="form-group text-center">
                                    <input type="button" class="btn btn-info addPackageBtn" value="+ Add Package">
                                </div>
                            </div>
                        </div>
                        <br /><br />
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Minimum Stay Policy <span class="required">*</span></label>
                                    <input type="text" name="min_stay_policy" class="form-control isNumber requiredCheck"
                                        data-check="Minimum Stay Policy" placeholder="Minimum Stay Policy" value="1">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Inclusions Description of Inclusions</label>
                                    <textarea class="form-control ckeditor" name="inclusions" id="inclusions"
                                        placeholder="Inclusions Description of Inclusions"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Exclusions Description of Exclusions</label>
                                    <textarea class="form-control ckeditor" name="exclusions" id="exclusions"
                                        placeholder="Exclusions Description of Exclusions"></textarea>
                                </div>
                            </div>
                            <div class="row moreCancPolDiv"><h1 class="text-center">Cancellation Policy</h1></div>
                            <div class="row">
                                <input type="hidden" id="cancCnt" value="0">
                                <div class="col-sm-12 text-center">
                                    <div class="form-group text-center">
                                        <input type="button" class="btn btn-primary addMrCancBtn" value="+ Add Cancellation Policy">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br /><br />
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
                            <li><a href="{{ route('user.hotels.rooms', ['id' => $id]) }}"><button type="button"
                                        class="btn btn-danger">Cancel</button></a></li>
                            <li><button type="submit" class="btn btn-success">Add Room</button></li>
                        </ul>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
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
    $(document).on('click', '.addMealBtn', function() {
        let key = parseInt($('#prcCnt').val()) + parseInt(1);
        $('#prcCnt').val(key);
        $('.moreMealDiv').append('\
        <div class="col-sm-5 roomPrc'+key+'">\
            <div class="form-group">\
                <label>Meal Plan </label>\
                <input type="text" name="mealText[]" class="form-control" data-check="Meal Plan" autocomplete="off">\
            </div>\
        </div>\
        <div class="col-sm-5 roomPrc'+key+'">\
            <div class="form-group">\
                <label>Meal Price</label>\
                <input type="text" name="mealValue[]" class="form-control allowNumberDot" data-check="Meal Price"\
                    autocomplete="off">\
            </div>\
        </div>\
        <div class="col-md-2 roomPrc'+key+'">\
            <div class="form-group">\
                <label class="bmd-label-floating">Action</label><br />\
                <input type="button" class="btn btn-danger deleteMrPriceBtn" data-key="'+key+'" value="Remove">\
            </div>\
        </div>');
    });
    $(document).on('click', '.addPackageBtn', function() {
        let key = parseInt($('#prcCnt').val()) + parseInt(1);
        $('#prcCnt').val(key);
        $('.morePackageDiv').append('\
        <div class="col-sm-5 roomPrc'+key+'">\
            <div class="form-group">\
                <label>Package Name </label>\
                <input type="text" name="packageText[]" class="form-control" data-check="Package Name" autocomplete="off">\
            </div>\
        </div>\
        <div class="col-sm-5 roomPrc'+key+'">\
            <div class="form-group">\
                <label>Package Price</label>\
                <input type="text" name="packageValue[]" class="form-control allowNumberDot" data-check="Package Price"\
                    autocomplete="off">\
            </div>\
        </div>\
        <div class="col-md-2 roomPrc'+key+'">\
            <div class="form-group">\
                <label class="bmd-label-floating">Action</label><br />\
                <input type="button" class="btn btn-danger deleteMrPriceBtn" data-key="'+key+'" value="Remove">\
            </div>\
        </div>');
    });
    $(document).on('click', '.addMrCancBtn', function() {
        let key = parseInt($('#cancCnt').val()) + parseInt(1);
        $('#cancCnt').val(key);
        $('.moreCancPolDiv').append('\
        <div class="col-sm-5 cancPolicy'+key+'">\
            <div class="form-group">\
                <label>Days Before Check-In <span class="required">*</span></label>\
                <input type="text" name="daysBeforeCheckIn[]" class="form-control isNumber requiredCheck" data-check="Days Before Check-In" placeholder="Days Before Check-In" autocomplete="off">\
            </div>\
        </div>\
        <div class="col-sm-5 cancPolicy'+key+'">\
            <div class="form-group">\
                <label>Deduct Percentage <span class="required">*</span></label>\
                <input type="text" name="deductPercentage[]" class="form-control isNumber requiredCheck" data-check="Deduct Percentage" autocomplete="off" placeholder="Deduct Percentage">\
            </div>\
        </div>\
        <div class="col-md-2 cancPolicy'+key+'">\
            <div class="form-group">\
                <label class="bmd-label-floating">Action</label><br />\
                <input type="button" class="btn btn-danger deleteCanPolBtn" data-key="'+key+'" value="Remove">\
            </div>\
        </div>');
    });
    $(document).on('click', '.deleteCanPolBtn', function() {
        $('.cancPolicy' + $(this).attr('data-key')).remove();
    });
    $(document).on('click', '.deleteMrPriceBtn', function() {
        $('.roomPrc' + $(this).attr('data-key')).remove();
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