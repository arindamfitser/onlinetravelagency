@extends('frontend.layouts.app')
@section('css')
  <style type="text/css">
  .header_search_area{display: none;}
  </style>
@endsection
@section('content')

<!--/////////////////////////////////////////-->
<section class="search_result_section innertop_gap">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2" style="margin: 20px 0;">
        {{-- <a href="{{ url('/destinations') }}" class="Viewbox viewHotelDetails@">BACK</a>  --}}
        <a href="{{ session('returnUrlFromList') }}" onclick="{{ session('returnUrlFromOnclick') }}" class="Viewbox viewHotelDetails@">BACK</a> 
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1><span id="rekeyword">{{ session('keywords') }}</span>, <span id="hotelCount"></span> properties available</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
        <!--<div class="selectbox">-->
        <!--  <select name="page" id="page">-->
        <!--    <option value="10"> Show : 10 </option>-->
        <!--    <option value="20"> Show : 20 </option>-->
        <!--    <option value="30"> Show : 30 </option>-->
        <!--    <option value="40"> Show : 40 </option>-->
        <!--    <option value="50"> Show : 50 </option>-->
        <!--  </select>-->
        <!--</div>-->
      </div>
      <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
        {{-- <div class="selectbox">
          <select id="sortingOrder">
            <option value=""> Sort By </option>
            <option value="Price:High to Low" selected> Price: High to Low </option>
            <option value="Price:Low to High"> Price: Low to High </option>
            <option value="Star:High to Low"> Rating: High to Low </option>
            <option value="Star:Low to High"> Rating: Low to High </option>
          </select>
        </div> --}}
      </div>
      <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 selectbox2"></div>
    </div>
    <input type="hidden" id="hotelImagesId">
    <input type="hidden" id="searchFishing">
    <input type="hidden" id="pageNo" value="{{ $pageNo }}">
    <input type="hidden" id="backHotelId" value="{{ $backHotelId }}">
    <input type="hidden" id="postRegionId">
    <div class="row" id="easyPaginate"></div>
    <div class="loadingHotelHtml"></div>
  </div>
</div>
</section>
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
<form action="{{ session('returnFormUrl') }}" method="post" id="cat_form_list">
  {{ csrf_field() }}
  <input type="hidden" name="data_id" id="data_id" value="{{session('returnFormDataId')}}">
  <input type="hidden" name="type" id="type" value="{{session('returnFormType')}}">
</form>
<!--/////////////////////////////////////////-->
@endsection
@section('script')
<script src="{{ asset('frontend/js/jquery.easyPaginate.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&libraries=places" async defer></script>
<script type="text/javascript">
    let lst         = 0;
    let scrollFlag  = true;
    function onReturnUrl(){
        $("#cat_form_list").submit()
    }
    $(function() {
        $('#page').on('change', function(){
          window.localStorage.setItem("page",this.value);  
          location.reload();
        });
        $.ajax({
          type: 'POST',
          url: '{{ route('enroute.fetch.result') }}',
          data: {
            '_token': '{{ csrf_token()}}',
            'pageNo': $("#pageNo").val()
          },
          dataType: 'JSON',
          beforeSend: function () {
            $("#easyPaginate").loading();
          },
          success: function(res){
            $("#easyPaginate").loading("stop");
            $("#hotelCount").text(res.count);
            $("#easyPaginate").html(res.html);
            $("#searchFishing").val(res.fromFishing);
            $("#pageNo").val(res.pageNo);
            $("#postRegionId").val(res.postRegionId);
            $("#hotelImagesId").val(res.hotelImagesId);
            setTimeout(function(){ 
                if($("#backHotelId").val() != ''){
                    $('html, body').animate({
                        scrollTop: $(".hotel-list-div-" + $("#backHotelId").val()).offset().top
                    }, 2000);
                }
             }, 500);
            if(res.success){
                loadImages();
                onLoadwishlist();
                //setTimeout(function(){ rePaginate(); }, 500);
            }
          }
        });
        function loadImages(){
            if($("#hotelImagesId").val() != ''){
                $.ajax({
                    type: 'POST',
                    url: '{{ route('fetch.search.hotel.image') }}',
                    data: {
                        '_token': '{{ csrf_token()}}',
                        'hotelImagesId': $("#hotelImagesId").val()
                    },
                    dataType: 'JSON',
                    success: function(res){
                        $.each(res.hotelImagesId, function (index, value) {
                            $('.appendImage' + value).empty();
                            $('.appendImage' + value).html(res.html[index]);
                        });
                    }
                });
            }
        }
        $(window).on('scroll', function () {
            if($("#searchFishing").val() != 'yes'){
                let st = $( this ).scrollTop();
                if ( st > lst ) {
                    if(( $( window ).scrollTop() + $( window ).height() >= $( document ).height() - 1200 ) && scrollFlag == true ) {
                        if($('#pageNo').val() != ''){
                            scrollFlag = false;
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('enroute.fetch.result.load.more') }}',
                                data: {
                                    '_token'      : '{{ csrf_token()}}',
                                    'pageNo'      : $('#pageNo').val(),
                                    'postRegionId': $('#postRegionId').val(),
                                },
                                dataType: 'JSON',
                                beforeSend: function () {
                                    $(".loadingHotelHtml").loading();
                                },
                                success: function(res){
                                    scrollFlag = res.success;
                                    $(".loadingHotelHtml").loading('stop');
                                    $("#pageNo").val(res.pageNo);
                                    if(res.success){
                                        $("#hotelImagesId").val(res.hotelImagesId);
                                        $("#easyPaginate").append(res.html);
                                        loadImages();
                                    }else{
                                        $(".loadingHotelHtml").html('<h3 class="text-center">No More Hotels Found !!!</h3>');
                                        $("#hotelImagesId").val('');
                                    }
                                }
                            });
                        }
                    }
                }
                lst = st;
            }
        });
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
  $(document).ready(function () {
    var map = null;
    var myMarker;
    var myLatlng;
    function initializeGMap(address, lat, lng) {
      address = address.replace("%20", "+");
      $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&address='+address+'&sensor=false', null, function (data) {
        var p = data.results[0].geometry.location;
        myLatlng = new google.maps.LatLng(p.lat, p.lng);
        var myOptions = {
          zoom: 14,
          zoomControl: true,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        myMarker = new google.maps.Marker({
          position: myLatlng
        });
        myMarker.setMap(map);
      });
    }
    // Re-init map before show modal
    $('#myModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      initializeGMap(button.data('address'), button.data('lat'), button.data('lng'));
      $("#location-map").css("width", "100%");
      $("#map_canvas").css("width", "100%");
    });
    // Trigger map resize event after modal shown
    $('#myModal').on('shown.bs.modal', function() {
      google.maps.event.trigger(map, "resize");
      map.setCenter(myLatlng);
    });
    $(document).on("click", ".viewHotelDetails", function() {
      //alert("ok"); return false;
      var hotelId = $(this).attr("data-hotel-id");
      $('#list-form-'+hotelId).submit();
    });
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
    } else {
      Swal.fire('Your not logged in !! please login first');
    } 
  })
 });
  // onload get all logged wishlist
  window.onload = function() {
    //onLoadwishlist();
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
</script>
@endsection