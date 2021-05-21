@extends('frontend.layouts.app')
@section('content')
@include('imageResizer.resize')
<section class="banner_slider_sec hometop_gap"></section>
<section class="img_box_sec">
    <div class="container">
        <div class="row">
            <div class="image_sec_heading">
                <h2>Our Partners</h2>
            </div>
            <div class="visit_img_area_main">
                @foreach($partners as $partner)
                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full experience_box_load"> 
                    <a href="{{$partner->link}}"   class="category-thumbnail">
                        <div class="wrapper-category-image">
                            <!-- <img src="{{ imageUrl(Storage::disk('local')->url($partner->image), 371, 261, 100, 1)}}" alt=""> -->
                            <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($partner->image), array('w'=>371,'h'=>261), 1) }}" alt="{{ $partner->title }}" />
                        </div>
                      <h3>{{ @$partner->title }}</h3>
                  </a> 
                </div>
               @endforeach
               <!-- temp -->
               <div class="clearfix"></div>
           </div>
           <div class="load_more_area">
                <div class="load_more_btn_area"> <a href="" id="loadMore">Load more</a> </div>
            </div>
        </div>
    </div>
</section>
@endsection
