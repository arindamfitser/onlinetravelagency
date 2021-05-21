@extends('frontend.layouts.app')
@section('css')
  <style type="text/css">
     .holidayimg .carousel-control.left, .holidayimg .carousel-control.right {
       display: none !important;
     }
  </style>
@endsection
@section('content')

<!--/////////////////////////////////////////-->
<section class="search_result_section innertop_gap">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1><span id="rekeyword"></span>, {{count($hotels)}} properties available</h1>
      </div>
    </div>
    <div class="row">
      <!--<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="selectbox">
          <select>
            <option>Sort By Curators Rating (recommended)</option>
            
          </select>
        </div>
      </div> -->
      <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
        <div class="selectbox">
          <select name="page" id="page">
            <option value="10"> Show : 10 </option>
            <option value="20"> Show : 20 </option>
            <option value="30"> Show : 30 </option>
            <option value="40"> Show : 40 </option>
            <option value="50"> Show : 50 </option>
          </select>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 selectbox2">
        <div class="selectbox">
          <select>
            <option>Currency (egAU$)</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row" id="easyPaginate">
     @foreach($hotels as $hotel)
     <item class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       <div class="holidaysection">
        <div class="holidayimg">
          <div class="holidaybox">
            <div class="mapbox"><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="modal_cls" data-lat="<?php echo (isset($hotel->address['latitude'])) ? $hotel->address['latitude'] : ''; ?>" data-lng="<?php echo (isset($hotel->address['longitude'])) ? $hotel->address['longitude'] : ''; ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> </a> </div>
            <div class="heartbox" id="{{$hotel->id}}"> <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i> </a> </div>
          </div>
          <div id="hotelCarousel{{$hotel->id}}" class="carousel slide" data-ride="carousel"> 
            <!-- Wrapper for slides -->
            <?php //var_dump($hotel->galleries); ?>
            <div class="carousel-inner">
              <div class="item active"> 
                @if($hotel->featured_image != "")
                <img src="{{ Storage::disk('local')->url($hotel->featured_image) }}" alt=""> 
                @else
                <img src="{{ asset('frontend/images/no_image.jpg')}}" alt="" height="300px"> 
                @endif
              </div>
              @foreach($hotel->galleries as $gallery)
              <div class="item"> <img src="{{ Storage::disk('local')->url($gallery->image) }}" alt=""> </div>
              @endforeach
            </div>
            <!-- Left and right controls --> 
            <!--              <a class="left carousel-control" href="#hotelCarousel1" data-slide="prev"> <span class="angle_left"></span> </a> <a class="right carousel-control" href="#hotelCarousel1" data-slide="next"> <span class="angle_right"></span> </a> --> 
            <a class="left carousel-control" href="#hotelCarousel{{$hotel->id}}" data-slide="prev">
              <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
            </a> 
            <a class="right carousel-control" href="#hotelCarousel{{$hotel->id}}" data-slide="next"> 
              <span><i class="fa fa-angle-right" aria-hidden="true"></i></span> 
            </a> 
          </div>
        </div>
        <div class="holidaytex">
          <div class="Travellerbox1">
            <h2>{{$hotel->hotels_name}} </h2>
            <p><span> <i class="fa fa-map-marker" aria-hidden="true"></i> </span> <?php echo (isset($hotel->address['location'])) ? $hotel->address['location'] : ''; ?></p>
            <p><?php echo $hotel->brief_descp; ?> <a href="javascript:void(0);" class="more_btn" data-id="hotel_<?php echo $hotel->id; ?>">More</a></p>
            <a href="#" class="Curatorbox">Curator’s Rating <strong>{{ $hotel->curator_rating }}</strong>/100</a>
            @if(!empty($hotel->features))
            <ul>
              @foreach($hotel->features as $features)
                @if($features->icons)
                  <li><img src="{{ Storage::disk('local')->url('public/uploads/icons/'.$features->icons) }}" alt=""> {{ $features->name }}</li>
                @endif
              @endforeach
            </ul>
            @endif
          </div>
          <div class="Travellerbox2">
            <?php
                $numberOfReviews = 0;
                $totalStars = 0;
                foreach($hotel->review as $review)
                {
                  $numberOfReviews++;
                  $totalStars += $review->rating;
                }
                if($numberOfReviews !=0){
                  $average = $totalStars/$numberOfReviews;
                }else{
                  $average = 0; 
                }
                ?>
            <div class="starbox">
            <?php for($c=0; $c < $average; $c++){ ?>
             <i class="fa fa-star" aria-hidden="true"></i> 
             <?php } ?>
             <?php for($d=0; $d < (5-$average); $d++){ ?>
             <i class="fa fa-star-o" aria-hidden="true"></i>
             <?php } ?>
           </div> 
            @if($hotel->price !="")
            <h6>From <?php echo getPrice($hotel->price); ?></h6>
            <p>Per Night (Inc. Tax)</p>
            @endif
            <p>Traveller’s Rating</p>
            <p><a href="{{route('hotel.details', ['slug' => $hotel->hotels_slug]) }}">{{ count($hotel->review) }} reviews</a> </p>
            <div class="clearfix"></div>
          </div>
          <div class="clearfix"></div>
          <div id="hotel_<?php echo $hotel->id; ?>"  style="display: none;"  class="fisherman_txt">
            <strong>Service For The Fisherman</strong>
            <ul>
              <?php if($hotel->fishing_data['provide_on_site'] == 'yes'){ ?>
              <li>Bespoke fishing experiences provided on site or nearby</li>
              <?php } ?>
              <?php if($hotel->fishing_data['arrange_fishing_nearby'] == 'yes'){ ?>
              <li><?php echo $hotel->hotels_name; ?> concierge staff can arrange fishing nearby</li>
              <?php } ?>
              <?php if($hotel->fishing_data['provide_our_curated'] == 'yes'){ ?>
              <li>We provide our curated "best guide or charter" selections</li>
               <?php } ?>
            </ul>
            <div class="row">
              <div class="col-sm-6">
                <strong>Species</strong>
            <p><?php echo $hotel->species; ?></p>
              </div>
              <div class="col-sm-6">
                <strong>Fishing Season</strong>
            <p><?php echo $hotel->activity_season; ?></p>
              </div>
            </div>
          </div>
           <a href="{{route('hotel.details', ['slug' => $hotel->hotels_slug]) }}" class="Viewbox">View</a> 
        </div>
        <div class="clearfix"></div>
      </div>
    </item>

    @endforeach
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
            <div class="col-md-12 modal_body_map">
              <div class="location-map" id="location-map">
                <div style="width: 600px; height: 400px;" id="map_canvas"></div>
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
 <!-- Modal -->
  <div class="modal fade" id="notLoggedinModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <p>Your not logged in !! pleasse logged in first</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--/////////////////////////////////////////-->

@endsection
@section('script')
<script src="{{ asset('frontend/js/jquery.easyPaginate.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&libraries=places&callback=initMap"
  async defer></script>
<script type="text/javascript">
  $('.more_btn').on('click', function(){
      var data_id = $(this).attr('data-id');
      $('#'+data_id).toggle();
      $(this).remove();

  });

  $(document).ready(function () {
   $('.heartbox').on('click', function(){
      var user_id = "{{get_loggedin_id()}}";
      var hotel_id = this.id;
      var data ={
       '_token':'{{ csrf_token()}}',
        'user_id' : user_id,
        'hotel_id': hotel_id,
      }
       if(user_id > 0){
          jQuery.ajax({
              type: 'POST',
              url: '{{ route('hotel.add.wishlist') }}',
              data: data,
              dataType: 'html',
                success: function(res){ 
                if(res){
                  setTimeout(function(){  
                    $('#'+hotel_id+' a').css('color','green');
                    Swal.fire('The hotel successfully added in your wishlist! Thank you');
                  }, 2000); 
                }
                
              }
            });        
        }else{
         Swal.fire('Your not logged in !! please login first');
      } 
   })

   // Code goes here

        var map = null;
   var myMarker;
   var myLatlng;

   function initializeGMap(lat, lng) {
    myLatlng = new google.maps.LatLng(lat, lng);

    var myOptions = {
      zoom: 12,
      zoomControl: true,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    myMarker = new google.maps.Marker({
      position: myLatlng
    });
    myMarker.setMap(map);
  }

  // Re-init map before show modal
  $('#myModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    initializeGMap(button.data('lat'), button.data('lng'));
    $("#location-map").css("width", "100%");
    $("#map_canvas").css("width", "100%");
  });

  // Trigger map resize event after modal shown
  $('#myModal').on('shown.bs.modal', function() {
    google.maps.event.trigger(map, "resize");
    map.setCenter(myLatlng);
  });
  

  });
  // onload get all logged wishlist
   window.onload = function() {
    onLoadwishlist();
   }
  var onLoadwishlist= function(){
      var user_id = "{{get_loggedin_id()}}";
      
      var data ={
       '_token':'{{ csrf_token()}}',
        'user_id' : user_id,
      }

    if(user_id > 0){
          jQuery.ajax({
              type: 'POST',
              url: '{{ route('hotel.get.wishlist') }}',
              data: data,
              dataType: 'json',
              success: function(res){ 
                if(res){
                  for(var item in res) {
                   // alert(res[item]['hotel_id']);
                    $('#'+res[item]['hotel_id']+' a').css('color','green');
                  }
                } 
              }
            });        
        }

  }
  $(function() {
     $('#page').on('change', function(){
        window.localStorage.setItem("page",this.value);  
        location.reload();
     });
    rePaginate();
    $('#rekeyword').text( localStorage.getItem('keywords'));
  });
  var rePaginate = function(){
    
      var page = window.localStorage.getItem("page");
      if(page!=""){
          page =  $('#page').val();
       }
     $('#easyPaginate').easyPaginate({
      paginateElement: 'item',
      elementsPerPage: page,
      effect: 'climb'
    });
  }
</script>

@endsection