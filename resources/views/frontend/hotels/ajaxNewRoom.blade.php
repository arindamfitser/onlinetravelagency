<?php if(isset($finalSearchHotel)) :
    $hotel_id = $finalSearchHotel["Hotel"]["@attributes"]["id"];
    if(!empty($finalSearchHotel["Result"])):
?>
        <div class="container-fluid2 xmlroom clearfix">
			<h1>Rooms</h1>
<?php
            if(!isset($finalSearchHotel["Result"][0])):
                $room = $finalSearchHotel["Result"]['Room'];
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
                                        <form id="gotcarform" action="{{ route('xmlbooking', ['id' => $finalSearchHotel['Result']['@attributes']['id']]) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="quantity_adults" value="{{ $quantity_adults }}">
                                            <input type="hidden" name="quantity_childs" value="{{ $quantity_child }}">
                                            <input type="hidden" name="quantity_rooms" value="{{ $num_room }}">
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
            else:
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
                                                <input type="hidden" name="quantity_adults" value="{{ $quantity_adults }}">
                                                <input type="hidden" name="quantity_childs" value="{{ $quantity_child }}">
                                                <input type="hidden" name="quantity_rooms" value="{{ $num_room }}">
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
    ?>
        </div>
    <?php
    endif;
?>
<?php endif; ?>