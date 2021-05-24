@extends('frontend.layouts.app')
@section('content')
@include('imageResizer.resize')
<section class="banner_slider_sec hometop_gap"></section>
<section class="img_box_sec">
    <div class="container">
        <div class="row">
            <div class="image_sec_heading">
                <h2>Accommodation Types</h2>
            </div>
            <div class="visit_img_area_main">
                @foreach($accommodation_types as $accommodation)
                <div class="col-md-4 col-sm-6 col-xs-6 mobile_width_full">
                    <a href="javascript:void(0);"  onclick="onSubmitData('{{ $accommodation->id }}', 'accommodation')" class="category-thumbnail">
                        <div class="wrapper-category-image"> 
                        <?php
                        if($accommodation->accommodations_image !=""){
                        ?>
                            <!-- <img src="{{ imageUrl(Storage::disk('local')->url($accommodation->accommodations_image), 371, 261, 100, 1)}}" alt="{{ $accommodation->accommodations_name }}"> -->
                            {{-- <img src="{{ url('/'). resize(base_path('public').Storage::disk('local')->url($accommodation->accommodations_image), array('w'=>371,'h'=>261), 1) }}" alt="{{ $accommodation->accommodations_name }}" /> --}}
                            <img src="{{ url('/public/').Storage::disk('local')->url($accommodation->accommodations_image) }}" alt="{{ $accommodation->accommodations_name }}"/>
                        <?php }else{ ?>
                            <img src="{{ asset('frontend/images/timthumb.jpg') }}" alt="{{ $accommodation->accommodations_name }}"> 
                        <?php } ?>
                        </div>
                        <h3>{{ $accommodation->accommodations_name }}</h3>
                    </a>
                </div>
               @endforeach
               <!-- temp -->
               <!-- temp -->
               <div class="clearfix"></div>
           </div>
            <form action="{{ route('region.type_data', ['type' => 'accommodation']) }}" method="post" id="cat_form">
                {{ csrf_field() }}
                <input type="hidden" name="data_id" id="data_id" value="">
                <input type="hidden" name="type" id="type" value="">
           </form>
        </div>
    </div>
</section>


@endsection
@section('script')
@endsection

