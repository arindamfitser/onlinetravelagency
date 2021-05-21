@extends('frontend.layouts.app')
@section('content')
<?php
    $pcontent = session('pcontent');
    $ptitle = session('ptitle');
?>
<section class="banner_slider_sec hometop_gap"></section>
<section class="img_box_sec">
    <div class="container">
        <div class="row">
            <div class="image_sec_heading">
                <h2 id="ptitle">{{$ptitle}}</h2>
            </div>
            <?php //var_dump($page); ?>
            <div class="visit_img_area_main" id="pcontent">
                 <?php echo $pcontent; ?>
               <div class="clearfix"></div>
           </div>

    </div>
</div>
</section>


@endsection
@section('script')

<script type="text/javascript">
$(document).ready(function() {
    $('#ptitle').html(localStorage.getItem("ptitle"));
    $('#pcontent').html(localStorage.getItem("pcontent"));
} );
</script>
@endsection