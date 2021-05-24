@extends('frontend.layouts.app')
@section('content')
@include('imageResizer.resize')
<!--Banner sec-->
<?php
if(!empty($banners)){
?>
<section class="banner_slider_sec hometop_gap">
    <div id="banner_carousel" class="carousel slide carousel-fade" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @for ($i = 0; $i < count($banners) ; $i++)
            <li data-target="#banner_carousel" data-slide-to="<?php echo $i; ?>" <?php echo ($i == 0) ? 'class="active"' : ''; ?>></li>
            @endfor
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @foreach($banners as $key => $banner)

            <?php
            //echo url('/public/').Storage::disk('local')->url($banner->banners_image); die;
            ?>
            <div class="item <?php echo ($key == 0) ? 'active' : ''; ?>">
                {{-- <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($banner->banners_image), array('w'=>1498,'h'=>681), 1) }}"
                    alt="slide" /> --}}
                <img src="{{  url('/public/').Storage::disk('local')->url($banner->banners_image) }}" alt="slide <?=$key?>" />
                <div class="banner_text">
                    <div class="banner_text_inner">
                        <h2><?php echo strip_tags($banner->banners_description); ?></h2>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#banner_carousel" data-slide="prev"> <span class="glyphicon"><img src="{{ asset('frontend/images/left_arow.png') }}"/></span> </a> <a class="right carousel-control" href="#banner_carousel" data-slide="next"> <span class="glyphicon"><img src="{{ asset('frontend/images/right_arow.png') }}"/></span> </a> </div>
        <!-- /carousel -->
        <!--slider-->
    </section>
    <?php } ?>
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
                    @foreach($accommodations as $acc)
                    <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> <a href="javascript:void(0);"  onclick="onSubmitDataAcc('{{ $acc->id }}', 'accommodation')" class="category-thumbnail">
                        <div class="wrapper-category-image"> 
                            <?php if($acc->accommodations_image !=""){ ?>
                                <!--<img src="{{ imageUrl(Storage::disk('local')->url($acc->accommodations_image), 371, 261, 100, 1)}}" alt="{{ $acc->accommodations_name }}"> -->
                                {{-- <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($acc->accommodations_image), array('w'=>371,'h'=>261), 1) }}" alt="{{ $acc->accommodations_name }}" /> --}}
                                <img src="{{ url('/public/').Storage::disk('local')->url($acc->accommodations_image) }}" alt="{{ $acc->accommodations_name }}" />
                            <?php }else{ ?>
                                <img src="{{ asset('frontend/images/timthumb.jpg') }}" alt="{{ $acc->accommodations_name }}"> 
                            <?php } ?>
                        </div>
                        <!--<h3>Castles, Chateaux & Luxury Manors</h3>-->
                        <h3>{{ $acc->accommodations_name }}</h3>
                    </a>c
                </div>
                @endforeach
            </div>
            <form action="{{ route('region.type_data', ['type' => 'accommodation']) }}" method="post" id="acc_form">
                {{ csrf_field() }}
                <input type="hidden" name="data_id" id="acc_data_id" value="">
                <input type="hidden" name="type" id="acc_type" value="">
            </form>
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
                    @foreach($experiences as $exp)
                        <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> 
                           <a href="javascript:void(0);"  onclick="onSubmitData('{{ $exp->id }}', 'experience')" class="category-thumbnail">
                              <?php if($exp->experiences_image !=""){?>
                                <!--<img src="{{ imageUrl(Storage::disk('local')->url($exp->experiences_image), 371, 261, 100, 1)}}" alt="{{ $exp->experiences_name }}"> -->
                                {{-- <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($exp->experiences_image), array('w'=>371,'h'=>261), 1) }}" alt="{{ $exp->experiences_name }}" /> --}}
                                <img src="{{ url('/public/').Storage::disk('local')->url($exp->experiences_image) }}" alt="{{ $exp->experiences_name }}" />
                                <?php }else{ ?>
                                <img src="{{ asset('frontend/images/timthumb.jpg') }}" alt="{{ $exp->experiences_name }}"> 
                              <?php } ?>
                            <h3>{{ $exp->experiences_name }}</h3>
                          </a>
                        </div>
                    @endforeach
                <!-- temp -->
                <!-- temp -->
                <div class="clearfix"></div>
                <form action="{{ route('region.type_data', ['type' => 'experience']) }}" method="post" id="cat_form">
                     {{ csrf_field() }}
                     <input type="hidden" name="data_id" id="data_id" value="">
                     <input type="hidden" name="type" id="type" value="">
                </form>
            </div>
            <div class="load_more_area">
                <div class="load_more_btn_area"> <a href="" data-count="<?php echo count($experiences);?>" id="loadMore">Load more</a> </div>
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
                <?php
                if(!empty($testimonials)){ ?>
                <div class="owl-carousel owl-theme" id="testiMonial">
                    <?php
                    foreach($testimonials as $tst){ 
                    ?>
                    <div class="item">
                        <p>"<?php echo strip_tags($tst->testimonials_content); ?>"<span>
                        <?php echo $tst->testimonials_name; ?> </span></p>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
                <div class="load_more_area">
            <div class="load_more_btn_area"> <a href="{{ url('/testimonial') }}">Read more</a> </div>
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
                @foreach($inspirations as $insp)
                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full inspiration_box_load"> <a href="javascript:void(0);" onclick="onSubmitDataInp('{{ $insp->id }}', 'inspiration')" class="category-thumbnail">
                    <div class="wrapper-category-image"> 
                          <?php if($insp->inspirations_image !=""){ ?>
                                <!--<img src="{{ imageUrl(Storage::disk('local')->url($insp->inspirations_image), 371, 261, 100, 1)}}" alt="{{ $insp->inspirations_name }}"> -->
                                {{-- <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($insp->inspirations_image), array('w'=>371,'h'=>261), 1) }}" alt="{{ $insp->inspirations_name }}"/> --}}
                                <img src="{{ url('/public/').Storage::disk('local')->url($insp->inspirations_image) }}"
                                    alt="{{ $insp->inspirations_name }}" />
                                <?php }else{ ?>
                                <img src="{{ asset('frontend/images/timthumb.jpg') }}" alt="{{ $insp->inspirations_name }}"> 
                          <?php } ?>
                    </div>
                    <h3>{{ $insp->inspirations_name }}</h3>
                </a>
            </div>
            @endforeach
            
            <div class="clearfix"></div>
            <form action="{{ route('region.type_data', ['type' => 'inspiration']) }}" method="post" id="insp_form">
             {{ csrf_field() }}
             <input type="hidden" name="data_id" id="insp_data_id" value="">
             <input type="hidden" name="type" id="insp_type" value="">
           </form>
        </div>
        <div class="load_more_area">
            <div class="load_more_btn_area"> <a href="javascript:void(0)" data-count="<?php echo count($inspirations);?>"  id="loadMore_insp">Load more</a> </div>
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
                @foreach($partners as $partner)
                  @if($partner->status==1)
                    <div class="item">
                        <!--<img src="{{ imageUrl(asset(Storage::disk('local')->url($partner->image)), 185, 168, 100, 2)}}" />-->
                        <div class="logo_box_inner">
                            <a href="{{ $partner->link }}" target="_blank">
                                {{-- <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($partner->image), array('w'=>185,'h'=>168), 1) }}" /> --}}
                                <img src="{{ url('/public/').Storage::disk('local')->url($partner->image) }}"/>
                            </a>
                        </div>
                    </div>
                  @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
</section>
@endsection