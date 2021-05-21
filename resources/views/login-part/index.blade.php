@extends('frontend.layouts.app')

@section('content')

<!--/////////////////////////////////////////-->
<section class="page_inner innertop_gap" style="min-height: 446px;">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="selectuserbox">
                            <a href="javascript:void(0);" class="goToLogin" data-type="Customer">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <h3>Customer</h3>
                        </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="selectuserbox">
                            <a href="javascript:void(0);" class="goToLogin" data-type="Hotelier">
                            <i class="fa fa-building" aria-hidden="true"></i>
                            <h3>Hotelier</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="selectuserbox">
                            <a href="javascript:void(0);" class="goToLogin" data-type="Operator">
                            <i class="fa fa-plane" aria-hidden="true"></i>
                            <h3>Tour Operator / Guide</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="selectuserbox">
                            <a href="javascript:void(0);" class="goToLogin" data-type="Member">
                            <i class="fa fa-sitemap" aria-hidden="true"></i>
                            <h3>Member</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/////////////////////////////////////////-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).on('click', '.goToLogin', function () {
    let type = $(this).attr('data-type');
    $.ajax({
        type        : "POST",
        url         : "{{ route('save.user.type') }}",
        data        : {
            "_token": "{{ csrf_token() }}",
            "type"  : type
        },
        success     : function(data){
            if(type != 'Hotelier'){
                window.location.href = "{{ route('login') }}";
            }else{
                window.location.href = "{{ route('verify.hotel.code') }}";
            }
        }
    });
});
</script>
@endsection
