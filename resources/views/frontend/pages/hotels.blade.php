@extends('frontend.layouts.app')
@section('content')
@include('imageResizer.resize')
<section class="banner_slider_sec hometop_gap"></section>
<section class="img_box_sec">
    <div class="container">
        <div class="row">
            <div class="image_sec_heading">
                  <h2>OUR HOTELS</h2>
            </div>
            <div class="visit_img_area_main">
                @foreach($hotels as $hotel)
                @if($hotel->hotels_name!='')
                    <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full"> 
                        <a href="{{route('hotel.details', ['slug' => $hotel->hotels_slug]) }}"  class="category-thumbnail">
                            <div class="wrapper-category-image"> 
                            <img src="{{ imageUrl(asset(Storage::disk('local')->url($hotel->featured_image)), 371, 261, 100, 1)}}" alt="{{ $hotel->hotels_name }}"> </div>
                            <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($hotel->featured_image), array('w'=>371,'h'=>261), 1) }}" alt="{{ $hotel->featured_image }}" />
                            <h3>{{ $hotel->hotels_name }}</h3>
                        </a> 
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
