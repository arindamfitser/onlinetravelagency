<style>
 ul.prevnext-btn {
    position: absolute;
    top: 150px;
    right: 15px;
    z-index: 9;
    padding: 0;
    margin: 0;
    list-style: none;
    display: flex;
    left: 15px;
    justify-content: space-between;
}
.img-btn {
    border: none;
    background: transparent;
    color: #fefefe;
    display: block;
    font-size: 38px;
}
.search-image img {
    width: 100%;
    height: 360px;
}
</style>

<?php if(isset($hotels)) : ?>
@foreach($hotels as $key => $hotel)
    <?php
    $data       = (array) $hotel['hotels'];
    //$images     = json_decode(json_encode($hotel['images']), true);
    $amenity    = json_decode(json_encode($hotel['amenity']), true);
    $address    = (array) $hotel['address'];
    $hotelDesc  = (array) $hotel['hotelDesc'];
    // echo "<pre>";
    // print_r($data);
    // echo "<pre>";
    // print_r($images);
    // echo "<pre>";
    // print_r($amenity);
    // die;
    // echo "<pre>";
    // print_r($address);
    // echo "<pre>";
    // print_r($hotelDesc);
    // echo $data['id'];
    // die;
    $addrss     = '';
    if(!empty($address)):
        if( $address['Address1']):
            $addrss .= $address['Address1']; 
        endif;
        if( $address['Address2']):
            $addrss .= ', '. $address['Address2']; 
        endif;
        if( $address['Address3']):
            $addrss .= ', '. $address['Address3']; 
        endif;
        if( $address['City']):
            $addrss .= ', '. $address['City']; 
        endif;
        if( $address['State']):
            $addrss .= ', '. $address['State']; 
        endif;
        if( $address['Country']):
            $addrss .= ', '. $address['Country']; 
        endif;
    endif;
    ?>
    @if(!empty($data))
        <item class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hotel-list-div-{{ $data['id'] }}">
            <div class="holidaysection">
                <div class="holidayimg holidayimg{{$data['id']}}">
                    <div class="appendImage appendImage{{$data['id']}}">
                        <div class="search-image search-image{{$data['id']}}">
                        <?php $showImage = URL::to('/').'/public/frontend/images/loading.gif'; ?>
                        <img src="{{$showImage}}">
                    </div>
                    </div>
                    <div class="holidaybox holidaybox{{$data['id']}}">
                        <?php if($addrss != ''): ?>
                        <div class="mapbox">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="modal_cls" data-address="<?=$addrss?>" data-lat="<?=(isset($data['latitude']) ? $data['latitude'] : '')?>" data-lng="<?=(isset($data['longitude']) ? $data['longitude'] : '')?>">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="holidaytex">
                    <div class="Travellerbox1">
                        <h2>{{ $data['name'] }} </h2>
                        <?php if($addrss != ''){ ?>
                        <p>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            <?=$addrss?>
                        </p>
                        <?php } ?>
                        <p><?=(!empty($hotelDesc)) ? substr(strip_tags($hotelDesc['Text']), 0, 80).' ...' : ''?> <a href="javascript:void(0);" onclick="document.getElementById('list-form-{{ $data['id'] }}').submit();">more</a></p>
                        <ul>
                            <?php
                            if(!empty($amenity)):
                                foreach($amenity as $akey => $am):
                                    if($am['Text'] !="" && $akey < 5):
                            ?>
                                        <li><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; {{ $am['Text'] }}</li>
                            <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <div class="Travellerbox2">
                        <div class="starbox">
                            <?php 
                            $sr = ($data['stars'] != '' ? $data['stars'] : '0');
                            for($s = 1; $s <= 5; $s++):
                                print ($s <= $sr) ? '<i class="fa fa-star" aria-hidden="true"></i>' : '<i class="fa fa-star-o" aria-hidden="true"></i>';
                            ?>
                            <?php endfor; ?>
                        </div>
                        <!--<p>GUESTS STAR RATING</p>-->
                        <form action="{{route('hotel.hoteldetails', ['id' => $data['id']]) }}" style="display: none;" id="list-form-{{ $data['id'] }}" method="POST">
                            {{ csrf_field()  }}
                            <input type="hidden" name="t_start" value="{{ $t_start }}">
                            <input type="hidden" name="t_end" value="{{ $t_end }}">
                            <input type="hidden" name="totalNight" value="1">
                            <input type="hidden" name="keyword" value="{{ $keyword }}">
                            <input type="hidden" name="regionId" value="{{ $data['region_id'] }}">
                            <input type="hidden" name="hotelId" value="{{ $data['id'] }}">
                            <input type="hidden" name="quantity_adults" value="{{ $quantity_adults }}">
                            <input type="hidden" name="quantity_childs" value="{{ $quantity_childs}}">
                            <input type="hidden" name="quantity_rooms" value="{{ $quantity_rooms }}">
                            <input type="hidden" name="pageNo" value="{{ $pageNo }}">
                        </form>
                        <a href="javascript:void(0);" data-hotel-id="{{ $data['id'] }}" class="Viewbox viewHotelDetails">View</a> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </item>
    @endif
@endforeach
<?php endif; ?>