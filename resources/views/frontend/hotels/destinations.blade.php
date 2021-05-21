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
                    <div class="destination_banner"><img src="{{ asset('frontend') }}/images/destination-banner.jpg" alt="" /></div>
                    <div id = "map" style = "width:100%; height:350px; display: none;"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <?php
                  $list = array();
                  ?>
                  <div class="table_content table-responsive div_destination divDestinationFishing">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State / District</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($accommodation_search as $as)
                        <tr>
                          <td><span onClick="getMap({{ $as->regions_id }}, 'region', 'accommodation', this);">{{ $as->regions_name }}</span></td>
                          <td>
                            <ul class="name" id="acc_country"></ul>
                          </td>
                          <td>
                            <ul class="name" id="acc_state"></ul>
                          </td>
                          <td>
                            <ul class="name" id="acc_town"></ul>
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
                    <div class="destination_banner1"><img src="{{ asset('frontend') }}/images/destination-banner.jpg" alt="" /></div>
                    <div id = "map1" style = "width:100%; height:350px; display: none;"></div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <?php
                  $list1 = array();
                  ?>
                  <div class="table_content table-responsive div_destination divDestinationFishing">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State / District</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($experience_search as $es)
                        <tr>
                          <td><span onClick="getMap({{ $es->regions_id }}, 'region', 'experience');">{{ $es->regions_name }}</span></td>
                          <td>
                            <ul class="name" id="exp_country"></ul>
                          </td>
                          <td>
                            <ul class="name" id="exp_state"></ul>
                          </td>
                          <td>
                            <ul class="name" id="exp_town"></ul>
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
                    <div class="destination_banner2"><img src="{{ asset('frontend') }}/images/destination-banner.jpg" alt="" /></div>
                    <div id = "map2" style = "width:100%; height:350px; display: none;"></div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <?php
                  $list2 = array();
                  ?>
                  <div class="table_content table-responsive div_destination divDestinationFishing">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State / District</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($inspiration_search as $is)
                        <tr>
                          <td><span onClick="getMap({{ $is->regions_id }}, 'region', 'inspiration');">{{ $is->regions_name }}</span></td>
                          <td>
                            <ul class="name" id="ins_country"></ul>
                          </td>
                          <td>
                            <ul class="name" id="ins_state"></ul>
                          </td>
                          <td>
                            <ul class="name" id="ins_town"></ul>
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
                     <div class="destination_banner3"><img src="{{ asset('frontend') }}/images/destination-banner.jpg" alt="" /></div>
                    <div id = "map3" style = "width:100%; height:350px; display: none;"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <?php
                  $list3 = array();
                  ?>
                  <div class="table_content table-responsive div_destination divDestinationFishing">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>Country</th>
                          <th>State / District</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($species_search as $ss)
                        <tr>
                          <td><span onClick="getMap({{ $ss->regions_id }}, 'region', 'species');">{{ $ss->regions_name }}</span></td>
                          <td>
                            <ul class="name" id="spe_country"></ul>
                          </td>
                          <td>
                            <ul class="name" id="spe_state"></ul>
                          </td>
                          <td>
                            <ul class="name" id="spe_town"></ul>
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
<script type="text/javascript">
  var getMap = function(id, col_type, cat, elem){
    
    switch(cat) {
      case 'accommodation':
        switch(col_type){
          case 'region':
            $('.destination_banner').show();
            $('#map').hide();
            $('#acc_country').html('');
            $('#acc_state').html('');
            $('#acc_town').html('');
            genericAjax(id, col_type, cat, 'acc_country');
          break;
          case 'country':
            $('.destination_banner').hide();
            $('#map').show();
            $('#acc_country>li').removeClass('active');
            elem.classList.add('active');
            $('#acc_town').html('');
            $('#acc_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
            genericAjax(id, col_type, cat, 'acc_state');
          break;
          case 'state':
            $('#acc_state>li').removeClass('active');
            elem.classList.add('active');
            $('#acc_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
            genericAjax(id, col_type, cat, 'acc_town');
          break;
          case 'town':
            $('#acc_town>li').removeClass('active');
            elem.classList.add('active');
            genericAjax(id, col_type, cat, 'acc_hotel');
          break;
        }
      break;
      case 'experience':
        switch(col_type){
          case 'region':
           $('.destination_banner1').show();
            $('#map1').hide();
            $('#acc_state').html('');
            $('#acc_town').html('');
            genericAjax(id, col_type, cat, 'exp_country');
          break;
          case 'country':
            $('.destination_banner1').hide();
            $('#map1').show();
            $('#exp_country>li').removeClass('active');
            elem.classList.add('active');
            $('#exp_town').html('');
            $('#exp_hotel').html('');
            mapAjax(id, col_type, cat, 'map1');
            genericAjax(id, col_type, cat, 'exp_state');
          break;
          case 'state':
            $('#exp_state>li').removeClass('active');
            elem.classList.add('active');
            $('#exp_hotel').html('');
            mapAjax(id, col_type, cat, 'map1');
            genericAjax(id, col_type, cat, 'exp_town');
          break;
          case 'town':
            $('#exp_town>li').removeClass('active');
            elem.classList.add('active');
            genericAjax(id, col_type, cat, 'exp_hotel');
          break;
        }
      break;
      case 'inspiration':
        switch(col_type){
          case 'region':
           $('.destination_banner2').show();
            $('#map2').hide();
            $('#acc_state').html('');
            $('#acc_town').html('');
            genericAjax(id, col_type, cat, 'ins_country');
          break;
          case 'country':
            $('.destination_banner2').hide();
            $('#map2').show();
            $('#ins_country>li').removeClass('active');
            elem.classList.add('active');
            $('#ins_town').html('');
            $('#ins_hotel').html('');
            mapAjax(id, col_type, cat, 'map2');
            genericAjax(id, col_type, cat, 'ins_state');
          break;
          case 'state':
            $('#ins_state>li').removeClass('active');
            elem.classList.add('active');
            $('#ins_hotel').html('');
            mapAjax(id, col_type, cat, 'map2');
            genericAjax(id, col_type, cat, 'ins_town');
          break;
          case 'town':
            $('#ins_town>li').removeClass('active');
            elem.classList.add('active');
            genericAjax(id, col_type, cat, 'ins_hotel');
          break;
        }
      break;
      case 'species':
        switch(col_type){
          case 'region':
            $('.destination_banner3').show();
            $('#map3').hide();
            $('#acc_state').html('');
            $('#acc_town').html('');
            genericAjax(id, col_type, cat, 'spe_country');
          break;
          case 'country':
            $('.destination_banner3').hide();
            $('#map3').show();
            $('#spe_country>li').removeClass('active');
            elem.classList.add('active');
            $('#spe_town').html('');
            $('#spe_hotel').html('');
            mapAjax(id, col_type, cat, 'map3');
            genericAjax(id, col_type, cat, 'spe_state');
          break;
          case 'state':
            $('#spe_state>li').removeClass('active');
            elem.classList.add('active');
            $('#spe_hotel').html('');
            mapAjax(id, col_type, cat, 'map3');
            genericAjax(id, col_type, cat, 'spe_town');
          break;
          case 'town':
            $('#spe_town>li').removeClass('active');
            elem.classList.add('active');
            genericAjax(id, col_type, cat, 'spe_hotel');
          break;
        }
      break;
    }
  }
  var genericAjax = function(id, col_type, cat, append_id){
    var tpid = localStorage.getItem("tpid");
    $.ajax({
      type: 'POST',
      url: "{{ route('hotel.get.region') }}",
      data:{
        "_token": "{{ csrf_token() }}",
        "id": id,
        "col_type": col_type,
        "tpid": tpid,
        "cat": cat
      },
      beforeSend: function(){
        $('#'+append_id).html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
      },
      success: function(data){
      $('#'+append_id).html(data);
      }
    });
  }
  let mapAjax = (id, condition, type, mapID) => {
    var tpid = localStorage.getItem("tpid");
    var tpid = 5;
    $.ajax({
    type: 'POST',
    url: "{{ route('hotel.get.map') }}",
    data:{
      "_token": "{{ csrf_token() }}",
      "id": id,
      "tpid": tpid,
      "condition": condition,
      "type": type
    },
    success: function(data){
      console.log(data);
      const hotelMarkers = jQuery.parseJSON(data);
      const mapOptions = {
        center:new google.maps.LatLng(hotelMarkers[0].location[0], hotelMarkers[0].location[1]),
        zoom: 4
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
            infoWindow.setContent('\
                <div id="iw-container">\
                  <a href="'+hotel.link+'">\
                    <div class="iw-title">'+hotel.name+'</div>\
                    <div class="iw-content">\
                      <img src="'+hotel.image+'" alt="'+hotel.name+'" width="100%">\
                      <div class="iw-subTitle">Address</div>\
                      <p>'+hotel.address+'</p>\
                    </div>\
                  </a>\
                  <div class="iw-bottom-gradient"></div>\
                </div>');
            infoWindow.open(map, marker);
          });
        })(marker, hotel);
      }
    }
  });
}
/*$("#my-tab a").on('shown.bs.tab', function(){
    $('.destination_banner').show();
});*/
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&callback=loadMap" async defer ></script>
@endsection