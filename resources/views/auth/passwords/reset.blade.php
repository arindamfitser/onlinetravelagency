@extends('frontend.layouts.app')

@section('content')
<section class="page_inner innertop_gap">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="login_form">
                    <form class="login100-form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}
                        <span class="login100-form-title">Reset password</span>
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form_box">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                           
                                <input id="password"  placeholder="Password*" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input id="password-confirm" placeholder="Confirm Password*" type="password" class="form-control" name="password_confirmation" required>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                           
                        </div>

                        <div class="form_btn">
                        <button class="login100-form-btn" type="submit">Reset</button>
                      </div>
                      </div>
                    </form>
               </div>
          </div>
        </div>
     </div>
</section>
@endsection
