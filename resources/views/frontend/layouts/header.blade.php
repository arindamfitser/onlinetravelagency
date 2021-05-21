<!-- header_middle-sec -->
<div class="headerMain" id="headerfixed">
  <section class="header_middle">
    <div class="container">
      <div class="row clearfix">
        <div class="col-md-3 col-sm-2 header_fish">
          <div class="header_logo1"><a href="{{ url('/') }}"><img src="{{ asset('frontend/images/fish_header_img.png') }}" alt="" /></a></div>
        </div>
        <div class="col-md-6 col-sm-6 header_logo">
          <div class="header_logo"> <a href="{{ url('/') }}"><img src="{{ asset('frontend/images/logo.png') }}" alt="" /></a>
          <h3>the world's best & most luxurious fishing destinations</h3>
        </div>
      </div>
      <div class="col-md-3 col-sm-4 header_top_right">
        <div class="header_top_right_inner">
          <ul class="list_header_account">
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Language <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li> <a href="">Dashboard</a> </li>
                  <li> <a href="">My profile </a> </li>
                  <li> <a href="">Logout </a> </li>
                </ul>
              </li> -->
              <li><div style="disply:inline-block" id="google_translate_element"></div></li>
              @guest
              <!--<li><a href="{{ route('login') }}">Step Aboard</a></li>-->
              <li><a href="{{ route('choose.user.type') }}">Step Aboard</a></li>
              <!--<li><a href="{{ route('register') }}">Register</a></li> -->
              @else
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                  {{ Auth::user()->first_name}} <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li> <a href="{{ route('user.dashboard') }}">Dashboard</a> </li>
                    <li> <a href="{{ route('user.profile') }}">My profile </a> </li>
                    <li> <a href="{{ route('user.logout') }}">Logout </a> </li>
                  </ul>
                </li>
                @endguest
                <!--<li class="head_heart_icon"><a href="javascript:void(0);" id="bookmark" ><i class="fa fa-heart" aria-hidden="true"></i></a></li> -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Navigation Sec-->
    <section class="navigation_sec" id="sticky-wrap">
      <div class="container">
        <div class="navigation_area">
          <div class="wsmenucontainer clearfix">
            <div class="overlapblackbg"></div>
            <div class="wsmobileheader clearfix"> <a id="wsnavtoggle" class="animated-arrow" title="Open menu"><span></span></a> <a class="smallogo" title="Small Logo">
              <img src="{{ asset('frontend/images/logo.png')}}" width="170" alt=""  /></a>
          <p class="mobile_header_tagline">The world's best & most luxurious fishing destinations</p>
          <!--<a class="callusicon" href="tel:123456789" title="Call us"><span class="fa fa-phone"></span></a>-->
          <ul class="list_mobile_header">
            <li><a href="javascript:void(0);" id="bookmark"><span class="fa fa-heart-o"></span></a></li>
            <!--<li><a href=""><span class="fa fa-phone"></span></a></li>-->
          </ul>
        </div>
        <header>
          <div class="container">
            <div class="header-content bigmegamenu clearfix">
              <!--<div class="logo"><a href="#" title="Web Slide Bootstrap Mega Menu"><img src="images/logo.png" alt="Logo"></a></div>-->
              <nav class="wsmenu slideLeft clearfix">
                <div class="mobile_menu_area">
                  <div class="mobile_menu_logo"> <a href="{{ url('/') }}"><img src="{{ asset('frontend/images/menu_logo.png') }}" width="190px" alt=""  /></a> </div>
                  <ul>
                    @guest
                    <!--<li><a href="{{ route('login') }}">Step Aboard</a></li>-->
                    <li><a href="{{ route('choose.user.type') }}">Step Aboard</a></li>
                    <!--<li><a href="{{ route('register') }}">Register</a></li> -->
                    @else
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        {{ Auth::user()->first_name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li> <a href="{{ route('user.dashboard') }}">Dashboard</a> </li>
                          <li> <a href="{{ route('user.profile') }}">My profile </a> </li>
                          <li> <a href="{{ route('user.logout') }}">Logout </a> </li>
                        </ul>
                      </li>
                      @endguest
                    </ul>
                  </div>
                  <?php if(Request::segment(1)!='users' && Request::segment(1)!='customer' && Request::segment(1)!='hoteliar'){ ?>
                  <?php echo get_header_navigation('mobile-sub wsmenu-list','xyz'); ?>
                  <?php } ?>
                </nav>
              </div>
            </div>
          </header>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <?php
    if(Request::segment(1)!='users' && Request::segment(1)!='customer' && Request::segment(1)!='hoteliar'){
      $max_adults_search_hdr = 6;
      $max_children_search_hdr = 2;
      if(!isset($_SESSION['num_adults']))
        $_SESSION['num_adults'] = (isset($_SESSION['book']['adults'])) ? $_SESSION['book']['adults'] : 1;
      if(!isset($_SESSION['num_children']))
        $_SESSION['num_children'] = (isset($_SESSION['book']['children'])) ? $_SESSION['book']['children'] : 0;
      if(!isset($_SESSION['num_room']))
        $_SESSION['num_room'] = (isset($_SESSION['book']['num_room'])) ? $_SESSION['book']['num_room'] : 1;
      $from_date = (isset($_SESSION['from_date'])) ? $_SESSION['from_date'] : '';
      $to_date = (isset($_SESSION['to_date'])) ? $_SESSION['to_date'] : '';
      $adultsOpthtmlHdr ="";
      for($i = 1; $i <= $max_adults_search_hdr; $i++){
        if($i==1){
          $adultsOpthtmlHdr .='<option value="'.$i.'">'.$i.' Adult </option>';  
        }else{
          $adultsOpthtmlHdr .='<option value="'.$i.'">'.$i.' Adults </option>';
        }
      }
      $KidsOpthtmlHdr ="";
      $KidsOpthtmlHdr .='<option value="0">0 Kid</option>';
      for($i = 1; $i <= $max_children_search_hdr; $i++){
        if($i==1){
          $KidsOpthtmlHdr .='<option value="'.$i.'">'.$i.' Kid </option>';  
        }else{
          $KidsOpthtmlHdr .='<option value="'.$i.'">'.$i.' Kids </option>';
        }
      }
    ?>
    <script type="text/javascript">
      var adultsOpthtmlHdr  = '<?=$adultsOpthtmlHdr?>';
      var KidsOpthtmlHdr    = '<?=$KidsOpthtmlHdr?>';
    </script>
<?php } ?>
</section>
<!--/////////////////////////////////////////-->
</div>