
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('backend/assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('backend/assets/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Admin login : OTA
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="{{asset('backend/assets/css/material-login.css')}}" rel="stylesheet" />

</head>

<body class="">
  <div class="wrapper ">
    <div class="main-panel">
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
         
          <div class="row">
            <div class="col-md-4 mx-auto">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Admin login</h4>
                </div>
                <div class="card-body">
                  
                  <form class="form-horizontal" method="POST" action="{{ route('admin.login.submit') }}">
                  {{ csrf_field() }}
                   
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                          <label class="bmd-label-floating">Email address</label>
                          
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autofocus>
                            @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                           @endif
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} ">
                          <label class="bmd-label-floating">Password</label>
                          <input id="password" type="password" class="form-control" name="password" >
                              @if ($errors->has('password'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                        </div>
                      </div>
                      <div class="col-md-12">
                         <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                         </div>
                      </div>

                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Login</button>
                    <div class="clearfix"></div>
                  </form>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
         
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>,Design & Developed by
            <a href="https://www.fitser.com" target="_blank">Fitser </a> 
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{asset('backend/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('backend/assets/js/core/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('backend/assets/js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('backend/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>

  <script src="{{asset('backend/assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('backend/assets/js/material-dashboard.min.js?v=2.1.0')}}" type="text/javascript"></script>
  
</body>

</html>

