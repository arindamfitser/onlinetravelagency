@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
    @include('frontend.layouts.hotelier_sidenav')
    <div class="dashboard_content">
        <h1>{{ $bookings->hotels->hotels_name }} :: New Booking</h1>
        @include('frontend.layouts.messages')
        <div class="wizard">
            <div class="tab-content">
                <span id="message"></span>
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <form id="hotelierBookingForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>No of Room <span class="required">*</span></label>
                                    <input type="text" name="noOfRoomReq" id="noOfRoomReq" class="form-control isNumber requiredCheck"
                                        data-check="No of Room" placeholder="No of Room" value="1">
                                    <input type="hidden" name="hotelToken" id= "hotelToken" value="{{ $bookings->hotels->hotel_token }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Check In Date <span class="required">*</span></label>
                                    <input type="text" id="checkIn" name="checkIn" class="form-control requiredCheck datepicker" data-check="Check In date" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Check Out Date <span class="required">*</span></label>
                                    <input type="text" id="checkOut" name="checkOut" class="form-control requiredCheck datepicker" data-check="Check Out date" autocomplete="off">
                                </div>
                            </div>
                            <input type="hidden" name="bookingNights" id="bookingNights" value="0">
                            <div class="col-sm-2 text-center">
                                <div class="form-group text-center">
                                    <label class="bmd-label-floating">Check Availability</label>
                                    <input type="button" class="btn btn-info checkAvailble" value="Check Availability">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Room <span class="required">*</span></label>
                                    <select class="form-control requiredCheck" name="roomId" id="roomId" data-check="Room">
                                        <option value="">-- Select Room --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Price <span class="required">*</span></label>
                                    <input type="text" name="roomPrc" id="roomPrc" class="form-control isNumber requiredCheck" data-check="Price"
                                        placeholder="Price" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Per Room Discount</label>
                                    <input type="text" name="roomDisc" id="roomDisc" class="form-control isNumber requiredCheck@" data-check="Discount"
                                        placeholder="Discount" value="">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Final Price <span class="required">*</span></label>
                                    <input type="text" name="roomFnlPrc" id="roomFnlPrc" class="form-control isNumber requiredCheck"
                                        data-check="Final Price" placeholder="Final Price" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. Of Adult <span class="required">*</span></label>
                                    <input type="text" name="noOfAdult" id="noOfAdult" class="form-control isNumber requiredCheck"
                                        data-check="No. Of Adult" placeholder="No. Of Adult" value="0">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. Of Child <span class="required">*</span></label>
                                    <input type="text" name="noOfChild" id="noOfChild" class="form-control isNumber requiredCheck"
                                        data-check="No. Of Child" placeholder="No. Of Child" value="0">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>User Email<span class="required">*</span></label>
                                    <input type="text" name="userEmail" id="userEmail" class="form-control requiredCheck" data-check="Email"
                                        placeholder="User Email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Mobile No. <span class="required">*</span></label>
                                    <input type="text" name="mobileNumber" id="mobileNumber" class="form-control isNumber requiredCheck"
                                        data-check="Mobile No." placeholder="Mobile No.">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>User First Name <span class="required">*</span></label>
                                    <input type="text" name="firstName" id="firstName" class="form-control requiredCheck"
                                        data-check="User First Name" placeholder="User First Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>User Last Name <span class="required">*</span></label>
                                    <input type="text" name="lastName" id="lastName" class="form-control requiredCheck"
                                        data-check="User Last Name" placeholder="User Last Name">
                                </div>
                            </div>
                        </div>
                        <br/>
                        <ul class="list-inline text-center">
                            <li><button type="button" class="btn btn-primary bookHotelButton">Book</button></li>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: 0
        });        
        $(document).on('change', '#hotelToken, #checkIn, #checkOut', function() {
            $('#roomId').html('<option value="">-- Select Room --</option>');
            $('#roomPrc').val('0.00');
            $('#roomFnlPrc').val('0.00');
            $('#roomDisc').val('0');
            $('#bookingNights').val('0');
        });
        $(document).on('keyup', '#noOfRoomReq', function() {
            $('#roomId').html('<option value="">-- Select Room --</option>');
            $('#roomPrc').val('0.00');
            $('#roomFnlPrc').val('0.00');
            $('#roomDisc').val('0');
            $('#bookingNights').val('0');
        });
        $(document).on('click', '.checkAvailble', function() {
            if($('#hotelToken').val() == ''){
                swalAlert('Please Select Hotel !!!', 'warning', 5000);
                return false;
            }else{
                if($('#checkIn').val() == ''){
                    swalAlert('Please Select Check-In Date !!!', 'warning', 5000);
                    return false;
                }else{
                    if($('#checkOut').val() == ''){
                        swalAlert('Please Select Check-Out Date !!!', 'warning', 5000);
                        return false;
                    }else{
                        if($('#checkIn').val() >= $('#checkOut').val()){
                            swalAlert('Check-In Date Must Be Lesser Than Check-out Date !!!', 'warning', 5000);
                            return false;
                        }else{
                            if($('#noOfRoomReq').val() < '1'){
                                swalAlert('No of Room Must be Atleast 1 !!!', 'warning', 5000);
                                return false;
                            }else{
                                $.ajax({
                                    type        : "POST",
                                    url         : "{{ route('user.check.room.available') }}",
                                    dataType    : "JSON",
                                    data        : {
                                        "_token"        : "{{ csrf_token() }}",
                                        "hotelToken"    : $('#hotelToken').val(),
                                        "checkIn"       : $('#checkIn').val(),
                                        "checkOut"      : $('#checkOut').val(),
                                        "noOfRoomReq"   : $('#noOfRoomReq').val()
                                    },
                                    beforeSend : function () {
                                        $("#roomId").empty();
                                        $("#roomId").loading();
                                    },
                                    success     : function(res){
                                        $("#roomId").loading('stop');
                                        if(res.success){
                                            $('#roomId').html(res.html);
                                            $('#bookingNights').val(res.nights);
                                        }
                                    }
                                });
                            }
                        }
                    }
                }
            } 
        });
        $(document).on('change', '#roomId', function() {
            $('#roomPrc').val('0.00');
            $('#roomFnlPrc').val('0.00');
            $('#roomDisc').val('0');
            $('#hiddenBasePrice').val('0');
            if($(this).val() != ''){
                $.ajax({
                    type        : "POST",
                    url         : "{{ route('user.get.room.price') }}",
                    dataType    : "JSON",
                    data        : {
                        "_token"    : "{{ csrf_token() }}",
                        "roomId"    : $(this).val()
                    },
                    beforeSend  : function () {
                        $("#roomPrc").loading();
                        $("#roomFnlPrc").loading();
                    },
                    success     : function(res){
                        $("#roomPrc").loading('stop');
                        $("#roomFnlPrc").loading('stop');
                        if(res.success){
                            $('#roomPrc').val(res.price);
                            $('#roomFnlPrc').val($('#bookingNights').val() *  parseFloat(res.price) * parseFloat($('#noOfRoomReq').val()));
                        }
                    }
                });
            }
        });
        $(document).on('keyup', '#roomDisc', function() {
            if($('#roomPrc').val() > '0'){
                //console.log(isNaN($('#roomDisc').val()));
                if(parseInt($('#roomPrc').val()) >= parseInt($('#roomDisc').val())){
                    let newVal = parseFloat($('#roomPrc').val()) - parseFloat($('#roomDisc').val());
                    $('#roomFnlPrc').val($('#bookingNights').val() * parseFloat(newVal) * parseFloat($('#noOfRoomReq').val()));
                }else{
                    $('#roomFnlPrc').val($('#roomPrc').val());
                    $('#roomDisc').val('0')
                    swalAlert('Discount Can\'t Be Greater Than Base Price !!!', 'warning', 5000);
                    return false;
                }
            }
        });
        $(document).on('click', '.bookHotelButton', function(e) {
            e.preventDefault();
            let flag = commonFormChecking(true);
            if (flag) {
                $('#hotelierBookingForm').submit();
            }
        });
        $(document).on('submit', '#hotelierBookingForm', function(e) {
            e.preventDefault();
            Swal.fire({
                title               : 'Are you sure want to book hotel?',
                type                : 'warning',
                showCancelButton    : true,
                confirmButtonColor  : '#dd6b55',
                cancelButtonColor   : '#48cab2',
                confirmButtonText   : "OK",
                cancelButtonText    : "Cancel"
            }).then((result) => {
                if (result.value) {
                    let formData = new FormData(this);
                    $.ajax({
                        type : "POST",
                        url : "{{ route('user.hotelier.book.hotel') }}",
                        data : formData,
                        cache : false,
                        contentType : false,
                        processData : false,
                        dataType : "JSON",
                        beforeSend : function () {
                            $("#hotelierBookingForm").loading();
                        },
                        success : function (res) {
                            $("#hotelierBookingForm").loading("stop");
                            if(res.success){
                                swalAlertThenRedirect('Booking Successfully Done !!!', 'success', "{{ route('users.bookings') }}");
                            }else{
                                swalAlert('Something Went Wrong !!! Please Try Again !!!');
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection