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
<?php if(isset($finalArray)) : ?>
@foreach($finalArray as $key => $hotel)
    <?php
    $data = (array) $hotel['hotels'];
    $images = $hotel['images'];
    $amenity = $hotel['amenity'];
    $results = $result[$key];
    ?>
    @if(!empty($data))
        <item class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="holidaysection">
                <div class="holidayimg">
                    <div class="holidaybox">
                        <?php if(getRoomxmlHotelData('hotelAddress',$data['id']) != ''){ ?>
                        <div class="mapbox">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="modal_cls" data-address="<?=getRoomxmlHotelData('hotelAddress',$data['id'])?>" data-lat="<?=(isset($hotel->address['latitude']) ? $hotel->address['latitude'] : '')?>" data-lng="<?=(isset($hotel->address['longitude']) ? $hotel->address['longitude'] : '')?>">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </a>
                        </div>
                        <?php } ?>
                    <!--  <div class="heartbox" id="116"> <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i> </a> </div> -->
                    </div>
                    <div id="hotelCarousel{{@$data['id']}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $noimage = URL::to('/').'/public/frontend/images/timthumb.jpg';
                            if(!empty($images)){
                                $i = 0;
                                foreach($images as $img){
                                    $showImage = 'https://stuba.com'.$img['Url'];
                                    //$headers = @get_headers($showImage);
                            ?>
                                    <div class="item_image item <?=($i == 0 ? 'active' : '')?>">
                                    {{-- <img src="{{ (stripos($headers[0], "200 OK") ? $showImage : $noimage) }}" alt="{{ @$data['name'] }}" style="height: 360px; width: auto;"> --}}
                                        <img src="{{ $showImage }}" alt="{{ @$data['name'] }}" style="height: 360px; width: auto;">
                                    </div>
                            <?php $i++; } }else{ ?>
                                    <div class="item_image item active">
                                        <img src="{{ $noimage }}" alt="{{ @$data['name'] }}" style="height: 360px; width: auto;">
                                    </div>
                            <?php } ?>
                        </div>
                        <a class="left carousel-control" href="#hotelCarousel{{@$data['id']}}" data-slide="prev">
                            <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        </a> 
                        <a class="right carousel-control" href="#hotelCarousel{{@$data['id']}}" data-slide="next"> 
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span> 
                        </a> 
                    </div>
                </div>
                <div class="holidaytex">
                    <div class="Travellerbox1">
                        <h2>{{ @$data['name'] }} </h2>
                        <?php if(getRoomxmlHotelData('hotelAddress',$data['id']) != ''){ ?>
                        <p>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            <?php echo getRoomxmlHotelData('hotelAddress',$data['id']); ?>
                        </p>
                        <?php } ?>
                        <p>{{ substr(strip_tags($data['Text']),0,80).'...' }} <a href="javascript:void(0);" onclick="document.getElementById('list-form-{{ $data['id'] }}').submit();">more</a></p>
                        {{-- <a href="javascript:void(0);" class="Curatorbox">Stuba Star Rating : <strong>{{ (@$data['stars'] != '' ? @$data['stars'] : '0') }}</strong></a> --}}
                        <ul>
                            @foreach($amenity as $akey => $am)
                                @if($am['Text'] !="" && $akey < 5)
                            <li><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; {{ $am['Text'] }}</li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="Travellerbox2">
                        <div class="starbox">
                            <?php 
                            $sr = (@$data['stars'] != '' ? @$data['stars'] : '0');
                            for($s = 1; $s <= 5; $s++){
                                if($s <= $sr){
                                print '<i class="fa fa-star" aria-hidden="true"></i>';
                                }else{
                                print '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                }
                            ?>
                            <?php } ?>
                        </div>
                        <p>GUESTS STAR RATING</p>
                        @if($price[$key] != "")
                            <h6>{{ $currency }} <?php echo number_format(((float) $price[$key] + (float) (($price[$key] * get_option('markup_price')) / 100)   ), 2); ?></h6>
                            {{-- <p>Per Night (Inc. Tax)</p> --}}
                            <p>Indicative Room Rate (Inc. Tax)</p>
                        @endif
                        <form action="{{route('hotel.hoteldetails', ['id' => $data['id']]) }}" style="display: none;" id="list-form-{{ $data['id'] }}" method="POST">
                        {{ csrf_field()  }}
                            <input type="hidden" name="results" value="{{ serialize($results) }}">
                            <input type="hidden" name="quantity_adults" value="{{ $quantity_adults }}">
                            <input type="hidden" name="quantity_childs" value="{{ $quantity_childs}}">
                            <input type="hidden" name="quantity_rooms" value="{{ $quantity_rooms }}">
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
<?php elseif(isset($hotels)) : ?>
@foreach($hotels as $key => $hotel)
    <?php
    $data = (array) $hotel['hotels'];
    $images = $hotel['images'];
    $amenity = $hotel['amenity'];
    $results = $result[$key];
    ?>
    @if(!empty($data))
        <item class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="holidaysection">
                <div class="holidayimg">
                    <div class="holidaybox">
                        <?php if(getRoomxmlHotelData('hotelAddress',$data['id']) != ''){ ?>
                        <div class="mapbox">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="modal_cls" data-address="<?=getRoomxmlHotelData('hotelAddress',$data['id'])?>" data-lat="<?=(isset($hotel->address['latitude']) ? $hotel->address['latitude'] : '')?>" data-lng="<?=(isset($hotel->address['longitude']) ? $hotel->address['longitude'] : '')?>">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </a>
                        </div>
                        <?php } ?>
                    <!--  <div class="heartbox" id="116"> <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i> </a> </div> -->
                    </div>
                    <div id="hotelCarousel{{@$data['id']}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $noimage = URL::to('/').'/public/frontend/images/timthumb.jpg';
                            if(!empty($images)){
                                $i = 0;
                                foreach($images as $img){
                                    $showImage = 'https://stuba.com'.$img->Url;
                                    //$headers = @get_headers($showImage);
                            ?>
                                    <div class="item_image item <?=($i == 0 ? 'active' : '')?>">
                                    {{-- <img src="{{ (stripos($headers[0], "200 OK") ? $showImage : $noimage) }}" alt="{{ @$data['name'] }}" style="height: 360px; width: auto;"> --}}
                                        <img src="{{ $showImage }}" alt="{{ @$data['name'] }}" style="height: 360px; width: auto;">
                                    </div>
                            <?php $i++; } }else{ ?>
                                    <div class="item_image item active">
                                        <img src="{{ $noimage }}" alt="{{ @$data['name'] }}" style="height: 360px; width: auto;">
                                    </div>
                            <?php } ?>
                        </div>
                        <a class="left carousel-control" href="#hotelCarousel{{@$data['id']}}" data-slide="prev">
                            <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        </a> 
                        <a class="right carousel-control" href="#hotelCarousel{{@$data['id']}}" data-slide="next"> 
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span> 
                        </a> 
                    </div>
                </div>
                <div class="holidaytex">
                    <div class="Travellerbox1">
                        <h2>{{ @$data['name'] }} </h2>
                        <?php if(getRoomxmlHotelData('hotelAddress',$data['id']) != ''){ ?>
                        <p>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            <?php echo getRoomxmlHotelData('hotelAddress',$data['id']); ?>
                        </p>
                        <?php } ?>
                        <p>{{ substr(strip_tags($data['Text']),0,80).'...' }} <a href="javascript:void(0);" onclick="document.getElementById('list-form-{{ $data['id'] }}').submit();">more</a></p>
                        {{-- <a href="javascript:void(0);" class="Curatorbox">Stuba Star Rating : <strong>{{ (@$data['stars'] != '' ? @$data['stars'] : '0') }}</strong></a> --}}
                        <ul>
                            @foreach($amenity as $akey => $am)
                                @if($am->Text !="" && $akey < 5)
                            <li><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; {{ $am->Text }}</li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="Travellerbox2">
                        <div class="starbox">
                            <?php 
                            $sr = (@$data['stars'] != '' ? @$data['stars'] : '0');
                            for($s = 1; $s <= 5; $s++){
                                if($s <= $sr){
                                print '<i class="fa fa-star" aria-hidden="true"></i>';
                                }else{
                                print '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                }
                            ?>
                            <?php } ?>
                        </div>
                        <p>GUESTS STAR RATING</p>
                        @if($price[$key] != "")
                            <h6>{{ $currency }} <?php echo number_format(((float) $price[$key] + (float) (($price[$key] * get_option('markup_price')) / 100)   ), 2); ?></h6>
                            {{-- <p>Per Night (Inc. Tax)</p> --}}
                            <p>Indicative Room Rate (Inc. Tax)</p>
                        @endif
                        <form action="{{route('hotel.hoteldetails', ['id' => $data['id']]) }}" style="display: none;" id="list-form-{{ $data['id'] }}" method="POST">
                        {{ csrf_field()  }}
                            <input type="hidden" name="results" value="{{ serialize($results) }}">
                            <input type="hidden" name="quantity_adults" value="{{ $quantity_adults }}">
                            <input type="hidden" name="quantity_childs" value="{{ $quantity_childs}}">
                            <input type="hidden" name="quantity_rooms" value="{{ $quantity_rooms }}">
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
<?php elseif(isset($directHotels)) : 
    // echo "<pre>";
    // print_r($directHotels);
    // die;
?>
@foreach($directHotels as $key => $hotel)
    @if(!empty($hotel))
        <item class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="holidaysection">
                <div class="holidayimg">
                    <div class="holidaybox">
                        <?php if((isset($hotel['hoteladdress']->location) && $hotel['hoteladdress']->location != '') && $hotel['hoteladdress']->latitude != '' && $hotel['hoteladdress']->longitude != ''): ?>
                        <div class="mapbox">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="modal_cls" data-address="<?=isset($hotel['hoteladdress']->location) ? $hotel['hoteladdress']->location : ''?>" data-lat="<?=$hotel['hoteladdress']->latitude?>" data-lng="<?=$hotel['hoteladdress']->longitude?>">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="appendImage appendImage{{$hotel['hotelImagesId']}}">
                        <div class="search-image search-image{{$hotel['hotelImagesId']}}">
                            <img src="{{URL::to('/').'/public/frontend/images/loading.gif'}}">
                        </div>
                    </div>
                </div>
                <div class="holidaytex">
                    <div class="Travellerbox1">
                        <h2>{{ @$hotel['translation']->hotels_name }} </h2>
                        <?php if(isset($hotel['hoteladdress']->location) && $hotel['hoteladdress']->location != '') : ?>
                        <p>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            {{ $hotel['hoteladdress']->location }}
                        </p>
                        <?php endif; ?>
                        <p>{{ strip_tags($hotel['details']->brief_descp).'...' }} <a href="<?=URL::to('/').'/hotel/'.$hotel['translation']->hotels_slug?>">more</a></p>
                        <?php if(!empty($hotel['details']->services_amenities)) :
                            $aminities = explode(', ', $hotel['details']->services_amenities);
                        ?>
                        <ul>
                            <?php foreach($aminities as $akey => $am) : if($akey < 5 && $am != '') :?>
                                <li><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; {{ $am }}</li>
                            <?php endif; endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <div class="Travellerbox2">
                        <div class="starbox">
                            <a href="javascript:void(0);" class="Curatorbox">Curator Rating : <strong>{{ (@$hotel['details']->curator_rating != '' ? $hotel['details']->curator_rating : '0') }}</strong></a>
                        </div>
                        <a href="<?=URL::to('/').'/hotel/'.$hotel['translation']->hotels_slug?>" class="Viewbox viewHotelDetails@">View</a> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </item>
    @endif
@endforeach
<?php elseif(isset($directHotelsSort)) : ?>
@foreach($directHotelsSort as $key => $hotel)
    @if(!empty($hotel))
        <item class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="holidaysection">
                <div class="holidayimg">
                    <div class="holidaybox">
                        <?php if($hotel->hoteladdress->location != '' && $hotel->hoteladdress->latitude != '' && $hotel->hoteladdress->longitude != ''): ?>
                        <div class="mapbox">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="modal_cls" data-address="<?=$hotel->hoteladdress->location?>" data-lat="<?=$hotel->hoteladdress->latitude?>" data-lng="<?=$hotel->hoteladdress->longitude?>">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div id="hotelCarousel{{@$hotel->details->id}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            if($hotel->details->featured_image != "") :
                                //$image = URL::to('/'). $hotel->details->featured_image;
                                $image = URL::to('/').'/public/frontend/images/timthumb.jpg';
                            else:
                                $image = URL::to('/').'/public/frontend/images/timthumb.jpg';
                            endif;
                            ?>
                            <div class="item_image item active">
                                <img src="{{ $image }}" alt="{{ @$hotel->translation->hotels_name }}" style="height: 360px; width: auto;">
                            </div>
                        </div>
                        {{-- <a class="left carousel-control" href="#hotelCarousel{{@$hotel['details']->id}}" data-slide="prev">
                            <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        </a> 
                        <a class="right carousel-control" href="#hotelCarousel{{@$hotel['details']->id}}" data-slide="next"> 
                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span> 
                        </a>  --}}
                    </div>
                </div>
                <div class="holidaytex">
                    <div class="Travellerbox1">
                        <h2>{{ @$hotel->translation->hotels_name }} </h2>
                        <?php if($hotel->hoteladdress->location != '') : ?>
                        <p>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            {{ $hotel->hoteladdress->location }}
                        </p>
                        <?php endif; ?>
                        <p>{{ substr(strip_tags($hotel->translation->hotels_desc),0,80).'...' }} <a href="<?=URL::to('/').'/hotel/'.$hotel->translation->hotels_slug?>">more</a></p>
                        <?php if(!empty($hotel->details->services_amenities)) :
                            $aminities = explode(', ', $hotel->details->services_amenities);
                        ?>
                        <ul>
                            @foreach($aminities as $akey => $am)
                                <li><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; {{ $am }}</li>
                            @endforeach
                        </ul>
                        <?php endif; ?>
                    </div>
                    <div class="Travellerbox2">
                        <div class="starbox">
                            <?php
                            $average = 0;
                            if(!empty($hotel->hotelreview)) :
                                $numberOfReviews = 0;
                                $totalStars = 0;
                                foreach($hotel->hotelreview as $review) :
                                    $numberOfReviews++;
                                    $totalStars += $review->rating;
                                endforeach;
                                if($numberOfReviews != 0):
                                    $average = $totalStars/$numberOfReviews;
                                endif;
                            endif;
                            $average = round($average);
                            for($s = 1; $s <= 5; $s++) :
                                if($s <= $average){
                                print '<i class="fa fa-star" aria-hidden="true"></i>';
                                }else{
                                print '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                }
                            endfor;
                            ?>
                        </div>
                        <p>GUESTS STAR RATING</p>
                            <?php 
                            if(!empty($hotel->rooms)) :
                            $roomLowestPrice = 0;
                            foreach($hotel->rooms as $prc) :
                                if($roomLowestPrice == 0):
                                    $roomLowestPrice = $prc->base_price;
                                else:
                                    if($prc->base_price < $roomLowestPrice):
                                        $roomLowestPrice = $prc->base_price;
                                    endif;
                                endif;
                            endforeach;
                        ?>
                            <h6>AUD <?=number_format((float) $roomLowestPrice, 2); ?></h6>
                        <?php else: ?>
                        <h6>AUD 0.00</h6>
                        <?php endif; ?>
                        <p>Indicative Room Rate (Inc. Tax)</p>
                        <a href="<?=URL::to('/').'/hotel/'.$hotel->translation->hotels_slug?>" class="Viewbox viewHotelDetails@">View</a> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </item>
    @endif
@endforeach
<?php elseif(isset($finalSearchHotel)) :
    $hotel_id = $finalSearchHotel["Hotel"]["@attributes"]["id"];
    if(!empty($finalSearchHotel["Result"])):
        foreach($finalSearchHotel["Result"] as $key => $rooms):
        $room = $rooms['Room'];
    ?>
        <div class=" col-sm-6 roompage_container">
            <div class="roombox">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="room_details">
                            <?php
                            $Price=0;
                            if(isset($room[0])){
                                foreach($room as $key=>$rm){
                                    if(isset($rm['RoomType'])){
                                        $RoomType = $rm['RoomType']['@attributes']['text'];
                                    }else{
                                        $RoomType ='';	
                                    }
                                    if(isset($rm['MealType'])){
                                        $MealType = $rm['MealType']['@attributes']['text'];
                                    }else{
                                        $MealType='';
                                    }
                                    $Price += (float) (($rm['Price']['@attributes']['amt'] * get_option('markup_price')) / 100) + (float) $rm['Price']['@attributes']['amt'];
                                }
                            }else{
                                $RoomType = (isset($room['RoomType']['@attributes']['text'])?$room['RoomType']['@attributes']['text']:'');
                                $MealType = (isset($room['MealType']['@attributes']['text'])?$room['MealType']['@attributes']['text']:'');
                                $Price = (float) (($room['Price']['@attributes']['amt'] * get_option('markup_price')) / 100) + (float)$room['Price']['@attributes']['amt'];
                            }
                            ?>
                            <h2><?php echo $RoomType; ?></h2>
                            <p><i class="fa fa-check-circle"></i>  <?php echo $MealType; ?></p>
                            <div class="profile_bannertext2">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <h5>Price Options</h5>
                                    <div class="pullbox">
                                        <div class="rate-price">$ <?=number_format((float) ($Price / session('totalNight')), 2)?></div>
                                        <p>Avg Per Night</p>
                                        <p>Taxes included</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <form id="gotcarform" action="{{ route('xmlbooking', ['id' => $rooms['@attributes']['id']]) }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="quantity_adults" value="{{ session('quantity_adults') }}">
                                    <input type="hidden" name="quantity_childs" value="{{ session('quantity_child') }}">
                                    <input type="hidden" name="quantity_rooms" value="{{ session('num_room') }}">
                                    <button type="submit" class="btn btn-primary">Book Now</button>
                                </form>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
        endforeach;
    endif;
elseif(isset($finalSearchRooms)) :
    if(!empty($finalSearchRooms)):
        foreach($finalSearchRooms as $key => $room):
?>
            <div class=" col-sm-6 roompage_container">
                <div class="roombox">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="room_details">
                                <h2>{{ $room->name }}</h2>
                                {{-- <p><i class="fa fa-check-circle"></i> {{ $room->descp }}</p> --}}
                                <div class="profile_bannertext2">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h5>Price Options</h5>
                                        <div class="pullbox">
                                            <div class="rate-price">$ <?=number_format((float) $room->base_price, 2)?></div>
                                            <p>Per Night</p>
                                            <p>Taxes included</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <form id="gotcarform"
                                            action="{{ route('hotel.book') }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="roomId" value="{{ $room->id }}">
                                            <input type="hidden" name="bookingArray" value="{{ json_encode($bookingArray) }}">
                                            <input type="hidden" name="selectedRoomType" value="Room Only">
                                            <button type="submit" class="btn btn-primary">Book Now</button>
                                        </form>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
            $morePrice  = json_decode($room->more_price, true);
            if(!empty($morePrice)):
                foreach($morePrice as $mrp => $mrpText):
            ?>
                    <div class=" col-sm-6 roompage_container">
                        <div class="roombox">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="room_details">
                                        <h2>{{ $room->name . ' - ' . $mrpText }}</h2>
                                        <div class="profile_bannertext2">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <h5>Price Options</h5>
                                                <div class="pullbox">
                                                    <div class="rate-price">$ <?=number_format((float) $mrp, 2)?></div>
                                                    <p>Per Night</p>
                                                    <p>Taxes included</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <form id="gotcarform" action="{{ route('hotel.book') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="roomId" value="{{ $room->id }}">
                                                    <input type="hidden" name="bookingArray" value="{{ json_encode($bookingArray) }}">
                                                    <input type="hidden" name="selectedRoomType" value="{{ $mrpText }}">
                                                    <button type="submit" class="btn btn-primary">Book Now</button>
                                                </form>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
        endforeach;
    endif;
?>
<?php endif; ?>