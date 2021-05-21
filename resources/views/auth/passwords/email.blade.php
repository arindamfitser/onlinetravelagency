@extends('frontend.layouts.app')

@section('content')
<section class="page_inner innertop_gap">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="login_form">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="login100-form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        <span class="login100-form-title">Reset password</span>
                         <div class="form_box">
                             <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" placeholder="email*" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                             </div>
                            <div class="form_btn">
                             <button class="login100-form-btn" type="submit"> Send Password Reset Link</button>
                           </div>
                        </div>
                    </form>
                 </div>
          </div>
        </div>
     </div>
</section>
@endsection
