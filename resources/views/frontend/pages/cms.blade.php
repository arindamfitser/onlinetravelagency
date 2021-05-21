@extends('frontend.layouts.app')
@section('content')
<section class="banner_slider_sec hometop_gap"></section>
<section class="img_box_sec">
    <div class="container">
        <div class="row">
            <div class="image_sec_heading">
                <h2>{{$page->page_title}}</h2>
            </div>
            <?php //var_dump($page); ?>
            <div class="visit_img_area_main">
                 <?php echo $page->page_description ?>
               <div class="clearfix"></div>
           </div>
        </div>
    </div>
</section>
@endsection
