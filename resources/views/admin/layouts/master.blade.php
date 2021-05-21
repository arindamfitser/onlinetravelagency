<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ asset('backend/assets/img/apple-icon.png') }}">
    <link rel="icon" href="{{ asset('backend/assets/img/favicon.png') }}">
    <title>Admin Panel
    <?php if(Request::segment(2)!=NULL){
        echo '| '.ucwords(str_replace('_', ' ', Request::segment(2)));
     } ?>
     <?php if(Request::segment(3)!=NULL){
        echo '| '.ucwords(str_replace('_', ' ', Request::segment(3)));
     } ?>
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/fonts/material-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}" >
    <link rel="stylesheet" href="{{ asset('backend/assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/material-dashboard.css?v=2.0.0') }}">

    <!-- Documentation extras -->
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('backend/assets/css/main.css') }}" rel="stylesheet" />
    <!-- iframe removal -->
    <link href="{{ asset('backend/assets/css/loader.css') }}" rel="stylesheet" />
    <script type="text/javascript"> 
        var base_url = "{{ asset('/')}}";
        var token   =  "{{ csrf_token()}}";
        </script>
     @yield('th_head')
</head>
<body class="">
<div class="loader">
        
        <div class="loader08"></div>
  </div>
     <div class="wrapper">
         @include('admin.layouts.sidenav')
           <div class="main-panel">
            <!-- Navbar -->
              @include('admin.layouts.nav')
            <!-- End Navbar -->

            @yield('content')

         @include('admin.layouts.footer')
        </div>
    </div>
</body>
<!--   Core JS Files   -->
@include('admin.layouts.scripts')