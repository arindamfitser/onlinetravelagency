@extends('frontend.layouts.app')
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
@section('content')
<!--Banner sec-->
<?php $user = auth('web')->user();   ?>
<section class="profile dashboard hometop_gap">
    @include('frontend.layouts.customer_sidenav')
    <div class="dashboard_content">
        <h1>My profile</h1>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="update_profile">
                    <h2 class="control-label">Update profile</h2>
                    <form id="update_profile">
                        <input type="hidden" value="{{$user->id}}" name="user_id">
                        {{ csrf_field() }}
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">First Name<sup style="color:red">*</sup></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" name="first_name" class="form-control requiredCheck" data-check="First Name"
                                        value="{{$user->first_name}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Last Name<sup style="color:red">*</sup></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" name="last_name" class="form-control requiredCheck" data-check="Last Name"
                                        value="{{$user->last_name}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Email<sup style="color:red">*</sup></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input type="text" name="email" class="form-control requiredCheck" data-check="Email" disabled
                                        value="{{$user->email}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Mobile<sup style="color:red">*</sup></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input type="text" name="mobile_number" class="form-control requiredCheck isPhone" data-check="Mobile"
                                        value="{{$user->mobile_number}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Address<sup style="color:red">*</sup></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" name="address" class="form-control requiredCheck"
                                    data-check="Address" value="{{$user->address}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Country<sup style="color:red">*</sup></label>
                                <select class="form-control requiredCheck" name="country_code" data-check="Country">
                                    <?php countryOption($user->country_code);?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Date Of Birth </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="dob" class="form-control dobDatePicker"  value="{{$user->dob}}" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Gender</label>
                                <div class="input-group">
                                    <input type="radio" value="male" name ="gender" id="gender" {{ $user->gender === "male" ? "checked" : " " }} /> Male
                                    <input type="radio" value="female" name ="gender" id="gender" {{ $user->gender === "female" ? "checked" : " " }} /> Female
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 text-center">
                            <button type="submit" class="btn btn-success btn-lg">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="change-password">
                    <h2 class="control-label">Change Password</h2>
                    <div id="change_pass_msg"></div>
                    <div class="form-group">
                        <p class="c-form__instruction">Your password must have at least eight characters and feature one capital
                            letter, one number and one lower-case letter.</p>
                    </div>
                    <form id="change_password">
                        <input type="hidden" value="{{$user->id}}" name="user_id">
                        {{ csrf_field() }}
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">New password<sup style="color:red">*</sup></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control requiredCheckPwd"
                                        data-check="New password" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Confirm Password<sup style="color:red">*</sup></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control requiredCheckPwd" data-check="Confirm Password" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 text-center">
                            <button type="submit" class="btn btn-success btn-lg">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
@endsection
@section('script')
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script src="{{ asset('backend/assets/js/jquery-ui.js') }}"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('.dobDatePicker').datepicker({
    dateFormat: 'yy-mm-dd',
    showButtonPanel: true,
    changeMonth: true,
    changeYear: true,
    yearRange: '1900:2200',
    inline: true
});
$("#update_profile").on('submit', function(e){
    e.preventDefault();
    let flag = commonFormChecking(true);
    if (flag) {
        let formData = new FormData(this);
        $.ajax({
            type        : "POST",
            url         : "{{ route('ajax.profile.update') }}",
            data        : formData,
            cache       : false,
            contentType : false,
            processData : false,
            dataType    : "JSON",
            beforeSend  : function () {
                $("#update_profile").loading();
            },
            success     : function (res) {
                $("#update_profile").loading("stop");
                swalAlert(res.message, res.swal, 5000);
            },
        });
    }
});
$(document).on('submit', '#change_password', function (e) {
    e.preventDefault();
    let flag = commonFormChecking(true, 'requiredCheckPwd');
    if (flag) {
        let lowerCaseLetters = /[a-z]/g;
        let upperCaseLetters = /[A-Z]/g;
        let numbers = /[0-9]/g;
        if (!$('#password').val().match(lowerCaseLetters)) {
            swalAlert('Password must contain one lowercase letter !!!', 'warning', 5000);
            flag = false;
            return false;
        }
        if (!$('#password').val().match(upperCaseLetters)) {
            swalAlert('Password must contain one upercase letter !!!', 'warning', 5000);
            flag = false;
            return false;
        }
        if (!$('#password').val().match(numbers)) {
            swalAlert('Password must contain one number !!!', 'warning', 5000);
            flag = false;
            return false;
        }
        if ($('#password').val().length < 8) {
            swalAlert('Password must contain eight(8) charecters !!!', 'warning' , 5000);
            flag=false;
            return false;
        }
        if ($('#password').val() != $('#confirm_password').val()) {
            swalAlert('Password & Confirm Password didn\'t match !!!', 'warning', 5000);
            flag = false;
            return false;
        }
        if(flag){
            let formData    = new FormData(this);
            $.ajax({
                type        : "POST",
                url         : "{{ route('ajax.profile.changepass') }}",
                data        : formData,
                cache       : false,
                contentType : false,
                processData : false,
                dataType    : "JSON",
                beforeSend  : function () {
                    $("#change_password").loading();
                },
                success     : function (res) {
                    $("#change_password").loading("stop");
                    swalAlert(res.message, res.swal, 5000);
                    if(res.success){
                        $('#password').val('');
                        $('#confirm_password').val('');
                    }
                },
            });
        }
    }
});
</script>
@endsection