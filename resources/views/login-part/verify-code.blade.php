@extends('frontend.layouts.app')
@section('content')
<!--/////////////////////////////////////////-->
<section class="page_inner innertop_gap">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="login_form">
                    <span class="login100-form-title">Verify Hotel Code</span>
                    <form class="login100-form">
                        <div class="form_box">
                            <div class="form-group">
                                <input type="text" placeholder="Hotel Code* (Case Sensitive)" class="form-control" id="hotel_code" autofocus>
                            </div>
                            <div class="form_btn">
                                <button class="login100-form-btn verifyCodeBtn" type="button">Validate Code</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/////////////////////////////////////////-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).on('click', '.verifyCodeBtn', function () {
    let type = $(this).attr('data-type');
    $.ajax({
        type        : "POST",
        url         : "{{ route('verify.code') }}",
        data        : {
            "_token": "{{ csrf_token() }}",
            "code"  : $('#hotel_code').val()
        },
        dataType	: "JSON",
        success     : function(data){
            if(data.success){
                window.location.href= "{{ route('login') }}";
                //swalAlertThenRedirect('Code Found !!!', 'success', redirect);
            }else{
                swalAlert('No Such Code Found !!!', 'error', 10000);
            }
        }
    });
});
</script>
@endsection
