@extends('frontend.layouts.app')
@section('css')
<style type="text/css">
  #map {
  margin: 0;
  padding: 0;
  height: 400px;
  max-width: none;
}
#map img {
  max-width: none !important;
}
.gm-style-iw {
  width: 350px !important;
  top: 15px !important;
  left: 0px !important;
  background-color: #fff;
  box-shadow: 0 1px 6px rgba(178, 178, 178, 0.6);
  border: 1px solid rgba(72, 181, 233, 0.6);
  border-radius: 2px 2px 10px 10px;
}
#iw-container {
  margin-bottom: 10px;
}
#iw-container .iw-title {
  font-family: 'Open Sans Condensed', sans-serif;
  font-size: 22px;
  font-weight: 400;
  padding: 10px;
  background-color: #110591;
  color: white;
  margin: 0;
  border-radius: 2px 2px 0 0;
}
#iw-container .iw-content {
  font-size: 13px;
  line-height: 18px;
  font-weight: 400;
  margin-right: 1px;
  padding: 15px 5px 20px 15px;
  max-height: 140px;
}
.iw-content img {
  float: right;
  margin: 0 5px 5px 10px; 
}
.iw-subTitle {
  font-size: 16px;
  font-weight: 700;
  padding: 5px 0;
}
.iw-bottom-gradient {
  position: absolute;
  width: 326px;
  height: 25px;
  bottom: 10px;
  right: 18px;
  background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
  background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
  background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
  background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
}
</style>
@endsection
@section('content')
<!--/////////////////////////////////////////-->
<section class="country_search">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="tabcard">
          <ul class="nav nav-tabs" role="tablist" id="my-tab">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Accommodation</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Experience</a></li>
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Inspirations</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Target Species</a></li>
          </ul>
          
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
              <div class="row clearfix">
                <div class="col-md-12">
                  <div class="hotel_map">
                    <div id = "map" style = "width:100%; height:350px;"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <?php
                  $list = array();
                  ?>
                  <div class="table_content table-responsive div_destination">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State</th>
                          <th>Town</th>
                          <th>Hotel</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($accommodation_search as $as)
                        <tr>
                          <td><span onClick="getMap({{ $as->regions_id }}, 'region', 'accommodation');">{{ $as->regions_name }}</span></td>
                          <td>
                            <?php
                            $countries =  getAccommodationCountry($as->region_id);
                            ?>
                            <ul class="name">
                              @foreach($countries as $cs)
                              <li onClick="getMap({{ $cs->country_id }}, 'country', 'accommodation');">{{ $cs->countries_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $states =  getAccommodationState($as->region_id);
                            ?>
                            <ul class="name">
                              @foreach($states as $ss)
                              <li onClick="getMap({{ $ss->state_id }}, 'state', 'accommodation');">{{ $ss->states_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $towns =  getAccommodationTown($as->region_id);
                            ?>
                            <ul class="name">
                              @foreach($towns as $ts)
                              <li onClick="getMap('{{ $ts->town }}', 'town', 'accommodation');">{{ $ts->town }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $hotels =  getAccommodationHotels($as->region_id);
                            //print_r($hotels);
                            ?>
                            <ul class="name">
                              @foreach($hotels as $hs)
                              <?php
                              $list[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                              ?>
                              <li class="region_longlat" data-lat="<?php echo $hs->latitude; ?>" data-name="<?php echo $hs->hotels_name; ?>" data-id="map" data-long="<?php echo $hs->longitude; ?>" data-link="<?php echo route('hotel.details', ['slug' => $hs->hotels_slug]); ?>" data-address="<?php echo $hs->location; ?>" data-image="<?php echo Storage::disk('local')->url($hs->featured_image); ?>">{{ $hs->hotels_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <?php
                //print_r($list);
                
                ?>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
              <div class="row clearfix">
                <div class="col-sm-12">
                  <div class="hotel_map">
                    <div id = "map1" style = "width:100%; height:350px;"></div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <?php
                  $list1 = array();
                  ?>
                  <div class="table_content table-responsive div_destination">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State</th>
                          <th>Town</th>
                          <th>Hotel</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($experience_search as $es)
                        <tr>
                          <td><span onClick="getMap({{ $es->regions_id }}, 'region', 'experience');">{{ $es->regions_name }}</span></td>
                          <td>
                            <?php
                            $countries =  getExperienceCountry($es->region_id);
                            ?>
                            <ul class="name">
                              @foreach($countries as $cs)
                              <li onClick="getMap({{ $cs->country_id }}, 'country', 'experience');">{{ $cs->countries_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $states =  getExperienceState($es->region_id);
                            ?>
                            <ul class="name">
                              @foreach($states as $ss)
                              <li onClick="getMap({{ $ss->state_id }}, 'state', 'experience');">{{ $ss->states_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $towns = getExperienceTown($es->region_id);
                            ?>
                            <ul class="name">
                              @foreach($towns as $ts)
                              <li onClick="getMap('{{ $ts->town }}', 'town', 'experience');">{{ $ts->town }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $hotels = getExperienceHotel($es->region_id);
                            //print_r($hotels);
                            ?>
                            <ul class="name">
                              @foreach($hotels as $hs)
                              <?php
                              $list1[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                              ?>
                              <li class="region_longlat" data-name="<?php echo $hs->hotels_name; ?>" data-id="map1" data-lat="<?php echo $hs->latitude; ?>" data-long="<?php echo $hs->longitude; ?>" data-link="<?php echo route('hotel.details', ['slug' => $hs->hotels_slug]); ?>" data-address="<?php echo $hs->location; ?>" data-image="<?php echo Storage::disk('local')->url($hs->featured_image); ?>">{{ $hs->hotels_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="messages">
              <div class="row clearfix">
                <div class="col-sm-12">
                  <div class="hotel_map">
                    <div id = "map2" style = "width:100%; height:350px;"></div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <?php
                  $list2 = array();
                  ?>
                  <div class="table_content table-responsive div_destination">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State</th>
                          <th>Town</th>
                          <th>Hotel</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($inspiration_search as $is)
                        <tr>
                          <td><span onClick="getMap({{ $is->regions_id }}, 'region', 'inspiration');">{{ $is->regions_name }}</span></td>
                          <td>
                            <?php
                            $countries =  getInspirationCountry($is->region_id);
                            ?>
                            <ul class="name">
                              @foreach($countries as $cs)
                              <li onClick="getMap({{ $cs->country_id }}, 'country', 'inspiration');">{{ $cs->countries_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $states =  getInspirationState($is->region_id);
                            ?>
                            <ul class="name">
                              @foreach($states as $ss)
                              <li onClick="getMap({{ $ss->state_id }}, 'state', 'inspiration');">{{ $ss->states_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $towns =  getInspirationTown($is->region_id);
                            ?>
                            <ul class="name">
                              @foreach($towns as $ts)
                              <li onClick="getMap('{{ $ts->town }}', 'town', 'inspiration');">{{ $ts->town }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $hotels = getInspirationHotel($is->region_id);
                            //print_r($hotels);
                            ?>
                            <ul class="name">
                              @foreach($hotels as $hs)
                              <?php
                              $list2[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                              ?>
                              <li class="region_longlat" data-name="<?php echo $hs->hotels_name; ?>" data-id="map2" data-lat="<?php echo $hs->latitude; ?>" data-long="<?php echo $hs->longitude; ?>" data-link="<?php echo route('hotel.details', ['slug' => $hs->hotels_slug]); ?>" data-address="<?php echo $hs->location; ?>" data-image="<?php echo Storage::disk('local')->url($hs->featured_image); ?>">{{ $hs->hotels_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">
              <div class="row clearfix">
                <div class="col-md-12">
                  <div class="hotel_map">
                    <div id = "map3" style = "width:100%; height:350px;"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <?php
                  $list3 = array();
                  ?>
                  <div class="table_content table-responsive div_destination">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State</th>
                          <th>Town</th>
                          <th>Hotel</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($species_search as $ss)
                        <tr>
                          <td><span onClick="getMap({{ $ss->regions_id }}, 'region', 'species');">{{ $ss->regions_name }}</span></td>
                          <td>
                            <?php
                            $countries =  getSpeciesCountry($ss->region_id);
                            ?>
                            <ul class="name">
                              @foreach($countries as $cs)
                              <li onClick="getMap({{ $cs->country_id }}, 'country', 'species');">{{ $cs->countries_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $states =  getSpeciesState($ss->region_id);
                            ?>
                            <ul class="name">
                              @foreach($states as $ss)
                              <li onClick="getMap({{ $ss->state_id }}, 'state', 'species');">{{ $ss->states_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $towns =  getSpeciesTown($ss->region_id);
                            ?>
                            <ul class="name">
                              @foreach($towns as $ts)
                              <li onClick="getMap('{{ $ts->town }}', 'town', 'species');">{{ $ts->town }}</li>
                              @endforeach
                            </ul>
                          </td>
                          <td>
                            <?php
                            $hotels = getSpeciesHotel($ss->region_id);
                            //print_r($hotels);
                            ?>
                            <ul class="name">
                              @foreach($hotels as $hs)
                              <?php
                              $list3[] =  array('name' => $hs->hotels_name, 'location' => array($hs->latitude, $hs->longitude), 'address' =>$hs->location, 'image' => Storage::disk('local')->url($hs->featured_image), 'link' => route('hotel.details', ['slug' => $hs->hotels_slug]));
                              ?>
                              <li class="region_longlat" data-name="<?php echo $hs->hotels_name; ?>" data-id="map3" data-lat="<?php echo $hs->latitude; ?>" data-long="<?php echo $hs->longitude; ?>" data-link="<?php echo route('hotel.details', ['slug' => $hs->hotels_slug]); ?>" data-address="<?php echo $hs->location; ?>" data-image="<?php echo Storage::disk('local')->url($hs->featured_image); ?>">{{ $hs->hotels_name }}</li>
                              @endforeach
                            </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div> 

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/////////////////////////////////////////-->
@endsection
@section('script')
<script>
window.onload = function() {
loadMap();
loadMap1();
loadMap2();
loadMap3();
}
// fake JSON call
function getJSONMarkers() {
const markers = <?php echo json_encode($list); ?>;
return markers;
}
function getJSONMarkers1() { 
const markers = <?php echo json_encode($list1); ?>;
return markers;
}
function getJSONMarkers2() {
const markers = <?php echo json_encode($list2); ?>;
return markers;
}
function getJSONMarkers3() {
const markers = <?php echo json_encode($list3); ?>;
return markers;
}
function loadMap() {
// Initialize Google Maps
const mapOptions = {
center:new google.maps.LatLng({{ $hs->latitude }}, {{ $hs->longitude }}),
zoom: 1
}
const map = new google.maps.Map(document.getElementById("map"), mapOptions);
// Load JSON Data
const hotelMarkers = getJSONMarkers();
var infoWindow = new google.maps.InfoWindow();

// Initialize Google Markers
for(hotel of hotelMarkers) {
let marker = new google.maps.Marker({
map: map,
position: new google.maps.LatLng(hotel.location[0], hotel.location[1]),
title: hotel.name,
});
(function (marker, hotel) {
  google.maps.event.addListener(marker, "click", function (e) {

    infoWindow.setContent('<div id="iw-container">' +
                    '<div class="iw-title">'+hotel.name+'</div>' +
                    '<div class="iw-content"><a href="'+hotel.link+'"><img src="'+hotel.image+'" alt="'+hotel.name+'" width="100%"></a><div class="iw-subTitle">Address</div>' +
                      '<p>'+hotel.address+'</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>');
    infoWindow.open(map, marker);
  });
})(marker, hotel);
}
}
function loadMap1() {
// Initialize Google Maps
const mapOptions = {
center:new google.maps.LatLng({{ $hs->latitude }}, {{ $hs->longitude }}),
zoom: 1
}
const map = new google.maps.Map(document.getElementById("map1"), mapOptions);
// Load JSON Data
const hotelMarkers = getJSONMarkers1();
var infoWindow = new google.maps.InfoWindow();
// Initialize Google Markers
for(hotel of hotelMarkers) {
let marker = new google.maps.Marker({
map: map,
position: new google.maps.LatLng(hotel.location[0], hotel.location[1]),
title: hotel.name,
});
(function (marker, hotel) {
  google.maps.event.addListener(marker, "click", function (e) {
    
    infoWindow.setContent('<div id="iw-container">' +
                    '<div class="iw-title">'+hotel.name+'</div>' +
                    '<div class="iw-content"><a href="'+hotel.link+'"><img src="'+hotel.image+'" alt="'+hotel.name+'" width="100%"></a><div class="iw-subTitle">Address</div>' +
                      '<p>'+hotel.address+'</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>');
    infoWindow.open(map, marker);
  });
})(marker, hotel);
}
}
function loadMap2() {
// Initialize Google Maps
const mapOptions = {
center:new google.maps.LatLng({{ $hs->latitude }}, {{ $hs->longitude }}),
zoom: 1
}
const map = new google.maps.Map(document.getElementById("map2"), mapOptions);
// Load JSON Data
const hotelMarkers = getJSONMarkers2();
var infoWindow = new google.maps.InfoWindow();
// Initialize Google Markers
for(hotel of hotelMarkers) {

let marker = new google.maps.Marker({
map: map,
position: new google.maps.LatLng(hotel.location[0], hotel.location[1]),
title: hotel.name,
});
(function (marker, hotel) {
  google.maps.event.addListener(marker, "click", function (e) {
    
    infoWindow.setContent('<div id="iw-container">' +
                    '<div class="iw-title">'+hotel.name+'</div>' +
                    '<div class="iw-content"><a href="'+hotel.link+'"><img src="'+hotel.image+'" alt="'+hotel.name+'" width="100%"></a><div class="iw-subTitle">Address</div>' +
                      '<p>'+hotel.address+'</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>');
    infoWindow.open(map, marker);
  });
})(marker, hotel);
}
}
function loadMap3() {
// Initialize Google Maps
const mapOptions = {
center:new google.maps.LatLng({{ $hs->latitude }}, {{ $hs->longitude }}),
zoom: 1
}
const map = new google.maps.Map(document.getElementById("map3"), mapOptions);
// Load JSON Data
const hotelMarkers = getJSONMarkers3();
var infoWindow = new google.maps.InfoWindow();
// Initialize Google Markers
for(hotel of hotelMarkers) {
let marker = new google.maps.Marker({
map: map,
position: new google.maps.LatLng(hotel.location[0], hotel.location[1]),
title: hotel.name,
});
(function (marker, hotel) {
  google.maps.event.addListener(marker, "click", function (e) {
    
    infoWindow.setContent('<div id="iw-container">' +
                    '<div class="iw-title">'+hotel.name+'</div>' +
                    '<div class="iw-content"><a href="'+hotel.link+'"><img src="'+hotel.image+'" alt="'+hotel.name+'" width="100%"></a><div class="iw-subTitle">Address</div>' +
                      '<p>'+hotel.address+'</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>');
    infoWindow.open(map, marker);
  });
})(marker, hotel);
}
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&callback=loadMap" async defer ></script>
<script type="text/javascript">
$('.region_longlat').on('click', function(){
var lat = $(this).attr("data-lat");
var long = $(this).attr("data-long");
var map_id = $(this).attr("data-id");
var name = $(this).attr("data-name");
var link = $(this).attr("data-link");
var address = $(this).attr("data-address");
var image = $(this).attr("data-image");
//clickroute(lat, long);
// Initialize Google Maps
mapDetails(lat, long, map_id, name, link, address, image);

});
function mapDetails(lat, long, map_id, name, link, address, image){
  const mapOptions = {
center:new google.maps.LatLng(lat, long),
zoom: 11
}
const map = new google.maps.Map(document.getElementById(map_id), mapOptions);
// Load JSON Data
const hotelMarkers = getJSONMarkers();
// Initialize Google Markers
let marker = new google.maps.Marker({
map: map,
position: new google.maps.LatLng(lat, long)
});
 google.maps.event.addListener(marker, "click", function (e) {
    var infoWindow = new google.maps.InfoWindow();
    infoWindow.setContent('<div id="iw-container">' +
                    '<div class="iw-title">'+name+'</div>' +
                    '<div class="iw-content"><a href="'+link+'"><img src="'+image+'" alt="'+name+'" width="100%"></a><div class="iw-subTitle">Address</div>' +
                      '<p>'+address+'</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>');
    infoWindow.open(map, marker);
  });
}
$("#my-tab a").on('shown.bs.tab', function(){
    loadMap();
    loadMap1();
    loadMap2();
    loadMap3();
});
function getMap(id, condition, type){
  switch(type) {
    case 'accommodation':
      mapAjax(id, condition, type, 'map');
      break;
    case 'experience':
      mapAjax(id, condition, type, 'map1');
      break;
    case 'inspiration':
      mapAjax(id, condition, type, 'map2');
      break;
    case 'species':
      mapAjax(id, condition, type, 'map3');
      break;
   
    default:
     return false;
  }
}

function mapAjax(id, condition, type, mapID){
    $.ajax({
    type: 'POST',
    url: "{{ route('hotel.get.map') }}",
      data:{
        "_token": "{{ csrf_token() }}",
        "id": id,
        "condition": condition,
        "type": type
      },
      success: function(data){
        const hotelMarkers = jQuery.parseJSON(data);
        const mapOptions = {
          center:new google.maps.LatLng(hotelMarkers[0].location[0], hotelMarkers[0].location[1]),
          zoom: 1
        }
        const map = new google.maps.Map(document.getElementById(mapID), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        for(hotel of hotelMarkers) {
          let marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(hotel.location[0], hotel.location[1]),
            title: hotel.name,
          });
          (function (marker, hotel) {
            google.maps.event.addListener(marker, "click", function (e) {

              infoWindow.setContent('<div id="iw-container">' +
                    '<div class="iw-title">'+hotel.name+'</div>' +
                    '<div class="iw-content"><a href="'+hotel.link+'"><img src="'+hotel.image+'" alt="'+hotel.name+'" width="100%"></a><div class="iw-subTitle">Address</div>' +
                      '<p>'+hotel.address+'</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>');
              infoWindow.open(map, marker);
            });
          })(marker, hotel);
        }
      }
  });
}
</script>

@endsection