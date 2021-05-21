@extends('frontend.layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<!--/////////////////////////////////////////-->
<section class="page_inner innertop_gap">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="login_form">
                    <form name="user-register" id="user-register" class="login100-form">
                        <span class="login100-form-title">Register</span>
                            {{ csrf_field() }}
                            <div class="form_box">
                                @if(Session::get('loginUserType') == 'Hotelier')
                                    <div class="form-group">
                                        <input type="text" name="hotel_token" placeholder="Hotel Token* (CASE SENSITIVE)" class="form-control requiredCheck" data-check="Hotel Token">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <input type="text" name="first_name" placeholder="First name*" class="form-control requiredCheck" data-check="First name">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" placeholder="Last name*" class="form-control requiredCheck" data-check="Last name">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Email*" class="form-control requiredCheck" data-check="Email">
                                </div>
                                <div class="form-group">
                                    <select class="form-control requiredCheck" name="country_code" data-check="Country">
                                        <option value="">Country</option>
                                        <?php countryOption(''); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                     <input type="password" name="password" placeholder="Password*" class="form-control requiredCheck" id="regPwg" data-check="Password">
                                </div>
                                <div class="form-group">
                                    <p class="c-form__instruction">Your password must have at least eight characters, one capital letter, one number and one lower-case letter.</p>
                                </div>

                                <div class="form-group">
                                    <input type="password" id="cnfRegPwg" placeholder="Confirm Password*" class="form-control requiredCheck" name="confirm_password" data-check="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <label class="update_txt">
                                    <input type="checkbox" class="checkIfChecked" data-val-id="send_me" autofocus>
                                    <input type="hidden" name="send_me" id="send_me" value="0">
                                    &nbsp;Accept terms and conditions</label>
                                </div>
                                <div class="form_btn">
                                    <button class="login100-form-btn btn" type="submit">Register</button>
                                </div>
                                <div class="txt1"> <span>Already a member?</span> <a href="{{ route('login') }}">Login</a> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/////////////////////////////////////////-->
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
$(document).on("click", ".checkIfChecked", function () {
	if($(this).prop('checked') == true){
		$('#' + $(this).attr('data-val-id')).val('1');
	}else if($(this).prop('checked') == false){
		$('#' + $(this).attr('data-val-id')).val('0');
	}
});
$(document).on('submit', '#user-register', function (e) {
	e.preventDefault();
	let flag            = commonFormChecking(true);
    if (flag) {
        let lowerCaseLetters = /[a-z]/g;
		let upperCaseLetters = /[A-Z]/g;
		let numbers = /[0-9]/g;
		if (!$('#regPwg').val().match(lowerCaseLetters)) {
			swalAlert('Password must contain one lowercase letter !!!', 'warning', 5000);
			flag = false;
			return false;
		}
		if (!$('#regPwg').val().match(upperCaseLetters)) {
			swalAlert('Password must contain one upercase letter !!!', 'warning', 5000);
			flag = false;
			return false;
		} 
		if (!$('#regPwg').val().match(numbers)) {
			swalAlert('Password must contain one number !!!', 'warning', 5000);
			flag = false;
			return false;
		}
		if ($('#regPwg').val().length < 8) {
			swalAlert('Password must contain eight(8) charecters !!!', 'warning', 5000);
			flag = false;
			return false;
		}
		if ($('#regPwg').val() != $('#cnfRegPwg').val()) {
			swalAlert('Password & Confirm Password didn\'t match !!!', 'warning', 5000);
			flag = false;
			return false;
		}
		
		if ($('#send_me').val() == '0') {
			swalAlert('Please Accept Terms & Conditions !!!', 'warning', 5000);
			flag = false;
			return false;
		}
        if(flag){
        	let formData    = new FormData(this);
    		$.ajax({
    			type        : "POST",
    			url         : "{{ route('user.register') }}",
    			data        : formData,
    			cache       : false,
    			contentType : false,
    			processData : false,
    			dataType    : "JSON",
    			beforeSend  : function () {
    				$("#user-register").loading();
    			},
    			success     : function (res) {
    				$("#user-register").loading("stop");
    				if(res.success){
    					swalAlertThenRedirect(res.message, res.swal, "{{ route('login') }}");
    				}else{
    					swalAlert(res.message, res.swal, 5000);
    				}
    			},
    		});
        }
    }
});
</script>
@endsection