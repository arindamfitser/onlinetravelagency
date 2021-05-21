<?php
if(isset($image)) :
    if($stuba):
        $showImage      = (!empty($image)) ? 'https://www.stuba.com'.$image->Url : URL::to('/').'/public/frontend/images/timthumb.jpg';
        $showImageId    = (!empty($image)) ? $image->hotel_image_id : '';
    else:
        $showImage      = (!empty($image)) ? url('public/uploads/' . $image->image) :
        URL::to('/').'/public/frontend/images/timthumb.jpg';
        $showImageId    = (!empty($image)) ? $image->id : '';
    endif;
?>
    <div class="search-image search-image{{$hotelId}}">
        <img src="{{$showImage}}">
    </div>
    <?php if(!empty($showImageId)) : ?>
    <ul class="prevnext-btn">
        <li>
            <button class="img-btn imageCarousel" data-action="prev" data-id="{{$showImageId}}" data-stuba="{{($stuba) ? 'yes' : 'no'}}" data-hotel="{{$hotelId}}">
                <i class="fa fa-angle-left" aria-hidden="true"></i> 
            </button>
        </li>
        <li>
            <button class="img-btn imageCarousel" data-action="next" data-id="{{$showImageId}}" data-stuba="{{($stuba) ? 'yes' : 'no'}}" data-hotel="{{$hotelId}}">
               <i class="fa fa-angle-right" aria-hidden="true"></i>
            </button>
        </li>
    </ul>
    <?php 
    endif;
endif;
?>