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
          <h1 class="region_head"><?php echo $type; ?></h1>
            <div class="row clearfix">
                <div class="col-md-12">
                  <div class="hotel_map">
                    <div class="destination_banner"><img src="{{ asset('frontend') }}/images/destination-banner.jpg" alt="" /></div>
                    <div id = "map" style = "width:100%; height:350px; display: none;"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="table_content table-responsive div_destination">
                    <?php
                    switch ($type) {
                      case 'accommodation':
                        $country_field_id =  'acc_country';
                        $state_field_id =  'acc_state';
                        $town_field_id =  'acc_town';
                        $data_id = $search_data[0]->accommodation_id;
                        break;
                      case 'experience':
                        $country_field_id =  'exp_country';
                        $state_field_id =  'exp_state';
                        $town_field_id =  'exp_town';
                        $data_id = $search_data[0]->experiences_id;
                        break;
                      case 'inspiration':
                        $country_field_id =  'ins_country';
                        $state_field_id =  'ins_state';
                        $town_field_id =  'ins_town';
                        $data_id = $search_data[0]->inspirations_id;
                        break;
                      case 'species':
                        $country_field_id =  'spe_country';
                        $state_field_id =  'spe_state';
                        $town_field_id =  'spe_town';
                        $data_id = $search_data[0]->species_id;
                        break;
                    }
                    ?>
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
                        @foreach($search_data as $tData)
                        <tr>
                          <td><span onClick="getMap({{ $tData->regions_id }}, 'region', '{{ $type }}', this);">{{ $tData->regions_name }}</span></td>
                          <td>
                            <ul class="name" id="{{ $country_field_id }}"></ul>
                          </td>
                          <td>
                            <ul class="name" id="{{ $state_field_id }}"></ul>
                          </td>
                          <td>
                            <ul class="name" id="{{ $town_field_id }}"></ul>
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
            $('.destination_banner').show();
            $('#map').hide();
            genericAjax(id, col_type, cat, 'exp_country');
          break;
          case 'country':
            $('.destination_banner').hide();
            $('#map').show();
            $('#exp_country>li').removeClass('active');
            elem.classList.add('active');
            $('#exp_town').html('');
            $('#exp_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
            genericAjax(id, col_type, cat, 'exp_state');
          break;
          case 'state':
            $('#exp_state>li').removeClass('active');
            elem.classList.add('active');
            $('#exp_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
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
          $('.destination_banner').show();
            $('#map').hide();
            genericAjax(id, col_type, cat, 'ins_country');
          break;
          case 'country':
            $('.destination_banner').hide();
            $('#map').show();
            $('#ins_country>li').removeClass('active');
            elem.classList.add('active');
            $('#ins_town').html('');
            $('#ins_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
            genericAjax(id, col_type, cat, 'ins_state');
          break;
          case 'state':
            $('#ins_state>li').removeClass('active');
            elem.classList.add('active');
            $('#ins_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
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
            $('.destination_banner').show();
            $('#map').hide();
            genericAjax(id, col_type, cat, 'spe_country');
          break;
          case 'country':
            $('.destination_banner').hide();
            $('#map').show();
            $('#spe_country>li').removeClass('active');
            elem.classList.add('active');
            $('#spe_town').html('');
            $('#spe_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
            genericAjax(id, col_type, cat, 'spe_state');
          break;
          case 'state':
            $('#spe_state>li').removeClass('active');
            elem.classList.add('active');
            $('#spe_hotel').html('');
            mapAjax(id, col_type, cat, 'map');
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
    url: "{{ route('hotel.type.region', ['type' => $type]) }}",
    data:{
      "_token": "{{ csrf_token() }}",
      "id": id,
      "col_type": col_type,
      "cat": cat,
      "tpid": tpid,
      "data_id": {{ $data_id }}
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
    $.ajax({
    type: 'POST',
    url: "{{ route('hotel.get.map') }}",
      data:{
        "_token": "{{ csrf_token() }}",
        "id": id,
        "condition": condition,
        "tpid": tpid,
        "type": type
      },
      success: function(data){
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&callback=loadMap" async defer ></script>
@endsection