<?php
session_start();
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage online_travel
 * @since Online Travel 1.0
 */
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Online Travel</title>
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
<link href="<?php echo get_template_directory_uri(); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/theme.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/webslidemenu.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/stellarnav.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/owl.theme.default.min.css">
<link href="<?php echo get_template_directory_uri(); ?>/css/animate.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/t-datepicker.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" rel="stylesheet">
<?php wp_head(); ?>
</head>

<body>
    
<!-- header_middle-sec -->
<div class="headerMain" id="headerfixed">
<section class="header_middle">
  <div class="container">
  <div class="row clearfix">
    <div class="col-md-3 col-sm-2 header_fish">
      <div class="header_logo1"><img src="<?php echo get_template_directory_uri(); ?>/images/fish_header_img.png" alt="" /> </div>
    </div>
    <div class="col-md-6 col-sm-6 header_logo">
      <div class="header_logo"> <a href="<?php base_url();?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="" /></a>
        <h3>the world's best & most luxurious fishing destinations</h3>
      </div>
    </div>
    <div class="col-md-3 col-sm-4 header_top_right">
      <div class="header_top_right_inner">
        <ul class="list_header_account">
          <li><a href="<?php base_url();?>/login">Sign In</a></li>
          
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
        <div class="wsmobileheader clearfix"> <a id="wsnavtoggle" class="animated-arrow" title="Open menu"><span></span></a> <a class="smallogo" href="<?php base_url();?>" title="Small Logo"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" width="170" alt=""  /></a>
          <p class="mobile_header_tagline">The world's best & most luxurious fishing destinations</p>
          <!--<a class="callusicon" href="tel:123456789" title="Call us"><span class="fa fa-phone"></span></a>-->
          <ul class="list_mobile_header">
            <li><a href=""><span class="fa fa-heart-o"></span></a></li>
            <!--<li><a href=""><span class="fa fa-phone"></span></a></li>-->
          </ul>
        </div>
        <header>
          <div class="container">
            <div class="header-content bigmegamenu clearfix"> 
              <!--<div class="logo"><a href="#" title="Web Slide Bootstrap Mega Menu"><img src="images/logo.png" alt="Logo"></a></div>-->
              <nav class="wsmenu slideLeft clearfix">
                <div class="mobile_menu_area">
                  <div class="mobile_menu_logo"> <a href="index.html"><img src="<?php echo get_template_directory_uri(); ?>/images/menu_logo.png" width="190px" alt=""  /></a> </div>
                  <ul>
                    <li><a href="<?php base_url();?>/login">Sign In</a></li>
                  </ul>
                </div>
                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'items_wrap'     => '<ul class="mobile-sub wsmenu-list">%3$s</ul>'
                 ) );
                ?>
               
              </nav>
            </div>
          </div>
        </header>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
  
   
   <form id="desk_search" name="desk_search" action="<?php base_url();?>/hotels/search" method="get">
  <input type="hidden" value="" name="region_id" class="search_region_id">
  <div class="header_search_sec" id="desktop_search">
    <div class="container">
      <div class="header_search_area">
        <div class="form_box_large search_box_comman">
          <div class="header_search">
            <input type="text" autocomplete="off" class="header_search_txt" name="keywords" id="keywords" placeholder="Search.." value="<?php echo isset($_GET['keywords']) ? $_GET['keywords'] : ''; ?>">
            <button type="submit" class="search-btn22"><img src="<?php echo get_template_directory_uri(); ?>/images/search_icon_head.png" alt="" /></button>
          </div>
          <ul class="suggest_list"></ul>
        </div>
        
        <div class="form_box_medium search_box_comman">
          <div class="t-datepicker">
            <div class="t-check-in">
              <input type="text" class="" name="check_in" id="check_in" >
            </div>
            <div class="t-check-out">
              <input type="text" class="" name="check_out" id="check_out" >
            </div>
          </div>
        </div>

        <div class="form_box_small search_box_comman">
          <div class="input-group adult_input"> <span class="input-group-btn">
            <button type="button" class="quantity-left-minus btn btn-number"  data-type="minus" data-field=""> <span class="glyphicon glyphicon-minus"></span> </button>
            </span>
            <div class="quantity_inp quantity_inp_adult">
              <input type="text" id="quantity" name="quantity_adults" class="form-control input-number" value="2 Adult" >
              <!--<label for="adults" class="adult_input_label">adults</label>--> 
            </div>
            <span class="input-group-btn">
            <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field=""> <span class="glyphicon glyphicon-plus"></span> </button>
            </span> </div>
        </div>

        <div class="form_box_small_children search_box_comman form_box_child">
          <div class="input-group adult_input"> <span class="input-group-btn">
            <button type="button" class="quantity-left-minus-child btn btn-danger btn-number"  data-type="minus" data-field=""> <span class="glyphicon glyphicon-minus"></span> </button>
            </span>
            <div class="quantity_inp quantity_inp_child">
              <input type="text" id="quantity_child" name="quantity_child" class="form-control input-number" value="0 Child" >
              <!--<label for="adults" class="adult_input_label">adults</label>--> 
            </div>
            <span class="input-group-btn">
            <button type="button" class="quantity-right-plus-child btn btn-success btn-number" data-type="plus" data-field=""> <span class="glyphicon glyphicon-plus"></span> </button>
            </span> </div>
        </div>

        <div class="search_btn_b">
          <button type="submit" class="f_submit_btn" id="desk_search_btn">Search</button>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  </form>

  <!-- mobile_search_sec -->
<form  id="mob_search"  action="{{route('hotels.search')}}" method="get">
  <input type="hidden" value="" name="region_id" class="search_region_id">
    <div class="mobile_search_sec" id="mobile_search">
    <div class="container">
      <div class="mobile_search_area">
        <div class="mobile_search_big"> 
          <!--<input type="text" class="form-control mob_search_txt" placeholder="" id="search_toggle_open">-->
          <div class="mob_search_txt" id="search_toggle_open">
            <p><img src="<?php echo get_template_directory_uri(); ?>/images/search_icon_head.png" alt=""> Search for your perfect hotel or villa…</p>
            <div class="mob_search_icon">
              <ul>
                <li><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_checkin_calendar.png" alt=""></a></li>
                <li><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri(); ?>/images/adult_icon.png" alt=""> 2</a></li>
                <li><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri(); ?>/images/children_icon.png" alt=""> 0</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="mob_search_open_bg bgg">
      <div class="container"> 
        <!-- mobile_search_form_area -->
        <div class="mobile_search_form_area" id="mobile_search_area_toggle">
        
          <div class="header_search_area">
            <div class="form_box_large search_box_comman">
              <div class="header_search">
                <input type="text" name="keywords" id="keywords" value="" class="header_search_txt" placeholder="Search..">
                <button type="submit" class="search-btn22"><img src="<?php echo get_template_directory_uri(); ?>/images/search_icon_head.png" alt="" /></button>
              </div>
               <ul class="suggest_list"></ul>
            </div>
            <div class="form_box_medium search_box_comman">
              <div class="t-datepicker">
                <div class="t-check-in">
                  <input type="text" class="" name="check_in" id="check_in" >
                </div>
                <div class="t-check-out">
                  <input type="text" class="" name="check_out" id="check_out" >
                </div>
              </div>
            </div>
            <div class="form_box_small search_box_comman">
              <div class="input-group adult_input"> <span class="input-group-btn">
                <button type="button" class="quantity-left-minus btn btn-number"  data-type="minus" data-field=""> <span class="glyphicon glyphicon-minus"></span> </button>
                </span>
                <div class="quantity_inp quantity_inp_adult">
                  <input type="text" id="quantity_mobile" name="quantity_mobile" class="form-control input-number" value="2 Adult" min="1" max="100">
                  <!--<label for="adults" class="adult_input_label">adults</label>--> 
                </div>
                <span class="input-group-btn">
                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field=""> <span class="glyphicon glyphicon-plus"></span> </button>
                </span> </div>
            </div>
            <div class="form_box_small_children search_box_comman form_box_child">
              <div class="input-group adult_input"> <span class="input-group-btn">
                <button type="button" class="quantity-left-minus-child btn btn-danger btn-number"  data-type="minus" data-field=""> <span class="glyphicon glyphicon-minus"></span> </button>
                </span>
                <div class="quantity_inp quantity_inp_child">
                  <input type="text" id="quantity_child_mobile" name="quantity_child_mobile" class="form-control input-number" value="0 Children" min="1" max="100">
                  <!--<label for="adults" class="adult_input_label">adults</label>--> 
                </div>
                <span class="input-group-btn">
                <button type="button" class="quantity-right-plus-child btn btn-success btn-number" data-type="plus" data-field=""> <span class="glyphicon glyphicon-plus"></span> </button>
                </span> </div>
            </div>
            <div class="search_btn_b">
              <button type="submit" class="f_submit_btn">Search</button>
            </div>
            <div class="clearfix"></div>
          </div>
      
        </div>
      </div>
    </section>
   </div>
  </form>
   
  </div>
  </section>
<!--/////////////////////////////////////////-->
</div>