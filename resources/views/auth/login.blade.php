@extends('frontend.layouts.app')
@section('content')
<!--/////////////////////////////////////////-->
<section class="page_inner innertop_gap">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="login_form">
                    <span class="login100-form-title">Sign in</span>
                    @if ($errors->has('msg'))
                        <div class="alert alert-warning">
                            {{ $errors->first('msg') }}
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                    @endif
                    @if(Session::get('loginUserType') != 'Hotelier')
                    <div class="panel-body">
                            <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-primary btn-block">
                                Login with Facebook
                            </a>
                            <!--<a href="{{ route('social.oauth', 'twitter') }}" class="btn btn-info btn-block">
                                Login with Twitter
                            </a> -->
                            <a href="{{ route('social.oauth', 'google') }}" class="btn btn-danger btn-block">
                                Login with Google
                            </a>
                        </div>
                    @endif
                    <form class="login100-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form_box">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" placeholder="Email*" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" placeholder="Password*" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-right"> <a href="{{ route('password.request') }}">Forgot&nbsp; Password?</a> </div>
                            <div class="form_btn">
                                <button class="login100-form-btn" type="submit">Sign in</button>
                            </div>
                            <div class="txt1"> <span>Don't have an account?</span> <a href="{{ route('register') }}">Register Now</a> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/////////////////////////////////////////-->
@endsection