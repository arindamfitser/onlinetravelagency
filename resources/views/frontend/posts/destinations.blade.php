@extends('frontend.layouts.app')
@section('content')
<!--Banner sec-->
<section class="banner_slider_sec hometop_gap">
        <div id="banner_carousel" class="carousel slide carousel-fade" data-ride="carousel"> 
                <!-- Indicators --> 
           <ol class="carousel-indicators">
                <li data-target="#banner_carousel" data-slide-to="0" class="active"></li>
                <li data-target="#banner_carousel" data-slide-to="1"></li>
                <li data-target="#banner_carousel" data-slide-to="2"></li>
                <li data-target="#banner_carousel" data-slide-to="3"></li>
                <li data-target="#banner_carousel" data-slide-to="4"></li>
                <li data-target="#banner_carousel" data-slide-to="5"></li>
            </ol>
                <!-- Wrapper for slides -->
                
                <div class="carousel-inner">
                        <div class="item active"> <img src="{{ asset('frontend/images/banner1.jpg') }}" alt="First slide" />
                                <div class="banner_text">
                                        <div class="banner_text_inner">
                                                <h2>Discover the world's most luxurious ﬁshing destinations ....</h2>
                                        </div>
                                </div>
                        </div>
                        <div class="item"> <img src="{{ asset('frontend/images/banner2.jpg') }}" alt="First slide" />
                        <div class="banner_text">
                                        <div class="banner_text_inner">
                                                <h2>Discover the world's most luxurious ﬁshing destinations ....</h2>
                                        </div>
                                </div>
                        </div>
                        <div class="item"> <img src="{{ asset('frontend/images/banner3.jpg') }}" alt="First slide" />
                        <div class="banner_text">
                                        <div class="banner_text_inner">
                                                <h2>Discover the world's most luxurious ﬁshing destinations ....</h2>
                                        </div>
                                </div>
                        </div>
                        <div class="item"> <img src="{{ asset('frontend/images/banner4.jpg') }}" alt="" />
                        <div class="banner_text">
                                        <div class="banner_text_inner">
                                                <h2>Discover the world's most luxurious ﬁshing destinations ....</h2>
                                        </div>
                                </div>
                        </div>
                        <div class="item"> <img src="{{ asset('frontend/images/banner5.jpg') }}" alt="" />
                        <div class="banner_text">
                                        <div class="banner_text_inner">
                                                <h2>Discover the world's most luxurious ﬁshing destinations ....</h2>
                                        </div>
                                </div>
                        </div>
                        <div class="item"> <img src="{{ asset('frontend/images/banner6.jpg') }}" alt="" />
                        <div class="banner_text">
                                        <div class="banner_text_inner">
                                                <h2>Discover the world's most luxurious ﬁshing destinations ....</h2>
                                        </div>
                                </div>
                        </div>
                         
                </div>
                
                <!-- Controls --> 
                
                <a class="left carousel-control" href="#banner_carousel" data-slide="prev"> <span class="glyphicon"><img src="images/left_arow.png"/></span> </a> <a class="right carousel-control" href="#banner_carousel" data-slide="next"> <span class="glyphicon"><img src="images/right_arow.png"/></span> </a> </div>
        <!-- /carousel --> 
        
        <!--slider--> 
</section>
<section class="under_banner_text">
        <div class="container">
                <div class="row clearfix">
                        <div class="col-md-12">
                                <div class="text_bg">
                                        <!--<p>Whether your passion is ﬂy casting in crystal chalk streams, challenging the deep blue or searching for your paradise location you will ﬁnd the best here</p>-->
                                        <p>Angling adventures in luxury to share with your loved ones</p>
                                </div>
                        </div>
                </div>
        </div>
</section>
<section class="img_box_sec visit_collection">
        <div class="container">
                <div class="row">
                        <div class="image_sec_heading">
                                <h2>VISIT OUR CURATED COLLECTION</h2>
                        </div>
                        <div class="visit_img_area_main">
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/collection1.jpg') }}" alt=""> </div>
                                        <!--<h3>Castles, Chateaux & Luxury Manors</h3>-->
                                        <h3>Castles & Manors</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/collection2.jpg') }}" alt=""> </div>
                                        <h3>Private Islands</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/collection3.jpg') }}" alt=""> </div>
                                        <h3>Lodges</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/collection4.jpg') }}" alt=""> </div>
                                        <h3>Resorts</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/collection5.jpg') }}" alt=""> </div>
                                        <h3>Hotels</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/collection6.jpg') }}" alt=""> </div>
                                        <h3>Live-aboard Vessels</h3>
                                        </a> </div>
                        </div>
                        
                </div>
        </div>
</section>
<section class="under_banner_text">
        <div class="container">
                <div class="row clearfix">
                        <div class="col-md-12">
                                <div class="text_bg">
                                        <p>Whether your passion is ﬂy casting in crystal chalk streams, challenging the deep blue or searching for your paradise location you will ﬁnd the best here</p>
                                </div>
                        </div>
                </div>
        </div>
</section>
<section class="WhyBooksection">
        <h1>Why Book With Us?</h1>
        <div class="Booksection">
                <div class="container">
                        <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1"></div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                        <h2>Support the Sustainable Waterways Fund</h2>
                                        <p>When you make a booking on this site, 100% of all profits go directly to The Sustainable Waterways Fund.
                                                To discover how you are helping to sustain the environment that supports your passion click <a href="#">here </a></p>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1"></div>
                        </div>
                </div>
        </div>
</section>
<section class="img_box_sec">
        <div class="container">
                <div class="row">
                        <div class="image_sec_heading">
                                <h2>Experiences</h2>
                        </div>
                        <div class="visit_img_area_main">
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience1.jpg') }}" alt=""> </div>
                                        <h3>Saltwater Destinations</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience2.jpg') }}" alt=""> </div>
                                        <h3>Freshwater Destinations </h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience3.jpg') }}" alt=""> </div>
                                        <h3>Action</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience4.jpg') }}" alt=""> </div>
                                        <h3>Purity and Tranquility</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience5.jpg') }}" alt=""> </div>
                                        <h3>Spa Resorts & Hotels</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience6.jpg') }}" alt=""> </div>
                                        <h3>Beach Resorts & Hotels</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience1.jpg') }}" alt=""> </div>
                                        <h3>Fine Dining</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/experience8.jpg') }}" alt=""> </div>
                                        <h3>Helicopter & Float plane</h3>
                                        </a> </div>
                                        
                                        <!-- temp -->
                                        
                                        <!-- temp -->
                                <div class="clearfix"></div>
                        </div>
                        <div class="load_more_area">
                                <div class="load_more_btn_area"> <a href="" id="loadMore">Load more</a> </div>
                        </div>
                        
                        <!--<div class="owl-carousel owl-theme clearfix" id="collect2">
                                <div class="item">
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience1.jpg" alt=""> </div>
                                                <h3>Saltwater Destinations</h3>
                                                </a> </div>
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience2.jpg" alt=""> </div>
                                                <h3>Freshwater Destinations </h3>
                                                </a> </div>
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience3.jpg" alt=""> </div>
                                                <h3>Action</h3>
                                                </a> </div>
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience4.jpg" alt=""> </div>
                                                <h3>Purity and Tranquility</h3>
                                                </a> </div>
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience5.jpg" alt=""> </div>
                                                <h3>Spa Resorts & Hotels</h3>
                                                </a> </div>
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience6.jpg" alt=""> </div>
                                                <h3>Beach Resorts & Hotels</h3>
                                                </a> </div>
                                </div>
                                <div class="item">
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience7.jpg" alt=""> </div>
                                                <h3>Fine Dining</h3>
                                                </a> </div>
                                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="#" class="category-thumbnail">
                                                <div class="wrapper-category-image"> <img src="images/experience8.jpg" alt=""> </div>
                                                <h3>Helicopter & Float plane</h3>
                                                </a> </div>
                                        
                                </div>
                        </div>--> 
                </div>
        </div>
</section>
<section class="testimonials">
        <div class="container">
                <div class="row clearfix">
                        <div class="col-md-12">
                                <div class="owl-carousel owl-theme" id="testiMonial">
                                        <div class="item">
                                                <p>"My partner's passion for ﬁshing, my desire for luxury and our wish to holiday together all solved in one place - thank you Luxury Fishing..." <span>Lesley Purdie </span></p>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</section>
<section class="blue_mid_sec">
        <div class="container">
                <div class="row clearfix">
                        <div class="col-md-12">
                                <div class="blue_box_holder">
                                        <h2>Can't decide ?....Too Many Choices ?...<br>
                                                Think you've done it all ?</h2>
                                        <p>Let us help you with some inspiring suggestions</p>
                                </div>
                        </div>
                </div>
        </div>
</section>
<section class="img_box_sec">
        <div class="container">
                <div class="row">
                        <div class="image_sec_heading">
                                <h2>Inspirations</h2>
                        </div>
                        <div class="visit_img_area_main">
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration1.jpg') }}" alt=""> </div>
                                        <h3>Our Top Choice Saltwater Destinations</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration2.jpg') }}" alt=""> </div>
                                        <h3>Our Top Choice Freshwater Destinations</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration3.jpg') }}" alt=""> </div>
                                        <h3>Off The Beaten Track</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration4.jpg') }}" alt=""> </div>
                                        <h3>Quirky Favourites</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration5.jpg') }}" alt=""> </div>
                                        <h3>Catch & Cook</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration6.jpg') }}" alt=""> </div>
                                        <h3>Tournament Trail</h3>
                                        </a> </div>
                                        <!--- temp -->
                                        
                                        <!--- temp -->
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration7.jpg') }}" alt=""> </div>
                                        <h3>Our Gold award winners</h3>
                                        </a> </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="#" class="category-thumbnail">
                                        <div class="wrapper-category-image"> <img src="{{ asset('frontend/images/inspiration8.jpg') }}" alt=""> </div>
                                        <h3>Personal Challenge</h3>
                                        </a> </div>
                                        <div class="clearfix"></div>
                        </div>
                        <div class="load_more_area">
                                <div class="load_more_btn_area"> <a href="javascript:void(0)" id="loadMore_insp">Load more</a> </div>
                        </div>
                    
                </div>
        </div>
</section>
<section class="Partnerssection">
        <div class="container">
                <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h1>Our Partners</h1>
                                
                                <div class="owl-carousel owl-theme" id="client_logo_slider">
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/1.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/2.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/3.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/4.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/5.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/6.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/7.jpg') }}" /> </div>
                                    </div>
                            </div>
                                
                        </div>
                </div>
        </div>
</section>

@endsection
