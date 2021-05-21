@extends('frontend.layouts.app')
@section('content')
<section class="banner_slider_sec hometop_gap"></section>
<section class="img_box_sec">
<div class="container">
  <div class="row">
    <div class="image_sec_heading">
      <h2>Testimonials</h2>
    </div>
    <div class="box">
      <div class="container">
        <div class="row">
          <?php
          foreach ($testimonials as $key => $value) {
           ?>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box-part">
              <div class="title">
                <h4><?php echo $value->testimonials_name; ?></h4>
              </div>
              <div class="text">
                <span><?php echo strip_tags($value->testimonials_content); ?></span>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@endsection