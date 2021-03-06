@extends('frontend.layouts.app')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--Banner sec-->
<section class="innerbannersection">
  
</section>
<?php 
$max_adults_search = 6;
$max_children_search = 2;

   if(!isset($_SESSION['num_adults']))
    $_SESSION['num_adults'] = (isset($_SESSION['book']['adults'])) ? $_SESSION['book']['adults'] : 1;
if(!isset($_SESSION['num_children']))
    $_SESSION['num_children'] = (isset($_SESSION['book']['children'])) ? $_SESSION['book']['children'] : 0;
if(!isset($_SESSION['num_room']))
    $_SESSION['num_room'] = (isset($_SESSION['book']['num_room'])) ? $_SESSION['book']['num_room'] : 1;
    
    
$from_date = (isset($_SESSION['from_date'])) ? $_SESSION['from_date'] : '';
$to_date = (isset($_SESSION['to_date'])) ? $_SESSION['to_date'] : '';

$adultsOpthtml ="";
  for($i = 1; $i <= $max_adults_search; $i++){
      
      if($i==1){
         $adultsOpthtml .='<option value="'.$i.'">'.$i.' Adult </option>';  
      }else{
         $adultsOpthtml .='<option value="'.$i.'">'.$i.' Adults </option>';
      }
      
  }

    
$KidsOpthtml ="";
$KidsOpthtml .='<option value="0">Kid</option>';
  for($i = 1; $i <= $max_children_search; $i++){
      if($i==1){
         $KidsOpthtml .='<option value="'.$i.'">'.$i.' Kid </option>';  
      }else{
         $KidsOpthtml .='<option value="'.$i.'">'.$i.' Kids </option>';
      }
  }
  $markup = '<div class="room-rows">';
             $markup .= '<input type="hidden" id="norm" name="ab[norm][]" value="1" />';
             $markup .= '<div class="room-cell"><span class="roomCount displayBlock">Room 1</span></div>';
             $markup .= '<div class="room-cell"><span class="guestminus"><select name="ab[adlts][]" class="adlt" onchange="update_rmaudkik();">'.$adultsOpthtml.'</select></span> ';
             $markup .= '<span class="guestplus"><select name="ab[kids][]" class="kid" onchange="update_rmaudkik();">'.$KidsOpthtml.'</select></span>';
             $markup .= '<span class="remove" onclick="removeRow(this)">Remove</span></div>';
             $markup .= '</div>';
?>
<script type="text/javascript">
            var markup = '<?php echo $markup;?>';
</script>
<section class="booking_wrapper" id="header_fixed">
  <div class="container">
        <div class="destination_banner">
          <img src="{{ url('/public').Storage::disk('local')->url('uploads/destination-image/'.$image->image) }}" alt="" />
        </div>
   <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="destination_info">
            <a href="{{URL('destinations/search')}}">FISHING DESTINATIONS</a>
            <p>Here you will find our curated collection of the world???s best and most luxurious fishing destinations.  </p>
            <a href="javascript:void(0)" id="en_route" >DESTINATIONS EN-ROUTE</a>
            <p>Destinations en-route is provided as an extra service for all fishing enthusiasts. After booking your Fishing Destination return here to book any accommodation you require for your journey.  
Choose from over 100,000 hotels, resorts or lodges in almost any country.</p>
        <p>You don???t have to be on a fishing trip to book here.
All profits from all bookings go directly to The Sustainable Waterways Fund</p>
        </div>
    </div>
   </div>
  </div>
</section>

<!-- Modal -->
<div id="enRouteModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">DESTINATIONS EN-ROUTE SEARCH</h4>
      </div>
      <div class="modal-body">
        <div class="modal_search">
          <form id="enroute_search" name="enroute_search" action="{{route('enroute.search')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" value="" name="region_id" class="search_region_id">
            <div class="header_search_sec" id="desktop_search">
              <div class="header_search_area">
                <div class="form_box_large search_box_comman" style="width: 80% !important;">
                  <div class="header_search">
                    <input type="text" autocomplete="off" class="header_search_txt" name="keywords" id="enkeywords" placeholder="Search By Location.." value="<?php echo isset($_GET['keywords']) ? $_GET['keywords'] : ''; ?>">
                    <button type="submit" class="search-btn22"><img src="{{ asset('frontend/images/search_icon_head.png') }}" alt="" /></button>
                  </div>
                  <ul class="suggest_list"></ul>
                </div>
                <input type="hidden" class="" name="check_in" id="check_in" >
                <input type="hidden" class="" name="check_out" id="check_out" >
                <input type="hidden" id="num_adults" name="quantity_adults" value="1" />
                <input type="hidden" id="num_children" name="quantity_child" value="0" />
                <input type="hidden" id="num_rooms" name="num_room" value="<?=(session('num_room') ? session('num_room') : '1')?>" />
                <input type="hidden" id="num_guests" name="noguests" value="1" />
                <input type="hidden" id="norm" name="ab[norm][]" value="<?php echo session('ab')['norm'][0];?>" />
                <input type="hidden" id="norm" name="ab[adlts][]" value="1" />
                <input type="hidden" id="norm" name="ab[kids][]" value="0" />
                <div class="search_btn_b">
                    <button type="submit" class="f_submit_btn" id="desk_search_btn">Search</button>
                </div>
                <div class="clearfix"></div>    
            </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
  <script type="text/javascript">
   
    $('#en_route').on('click', function(e) {
        e.preventDefault();
        $('#enRouteModal').modal('show');
        $('#enkeywords').val('');
        $('.search_region_id').val('');
        $('#enkeywords').focus();
    });

    jQuery.validator.addMethod("notEqual", function(value, element, param) {
     return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");

  $('form[id="enroute_search"]').validate({
    ignore: "",
    rules: {
      keywords: 'required',
      t_start: { notEqual: "null" },
      t_end: { notEqual: "null" },
      quantity: 'required',
    },
    messages: {
      keywords: 'This keyword is required',
      t_start: 'Enter start date ',
      t_end: 'Enter end date ',
      quantity: 'Please specify a valid phone number',

    },
    submitHandler: function(e) {
      localStorage.setItem('region_id', $('.search_region_id').val());
      localStorage.setItem('keywords', $('#enkeywords').val());
      localStorage.setItem('t_start', $('#t_start').val());
      localStorage.setItem('t_end', $('#t_end').val());
      localStorage.setItem('quantity_adults', $('#quantity').val());
      localStorage.setItem('quantity_child', $('#quantity_child').val());
      e.preventDefault();
    }
  });
  </script>
  <script>
    $( function() {
        var minlength = 2;
     //$('ul.suggest_list').css('display','none');
       $("#enkeywords").keyup(function () {
        var that = this,
        value = $(this).val();
        //alert(value);
        $('ul.suggest_list').css('display','none');
        if (value.length >= minlength ) {
             $.ajax({
                type: "GET",
                url: "{{route('ajax.get.region')}}",
                data: {
                    'region' : value
                },
                dataType: "json",
                success: function(json){
                    $('ul.suggest_list').html('');
                    if(json){
                        $('ul.suggest_list').css('display','block'); 
                        $.each(json, function (key, data) {
                            var li= '<li class="sgitem" data-id="'+data.region_id+'" data-name="'+data.name+'('+data.country_name+')">'+data.name+'('+data.country_name+')'+'</li>'
                            $('ul.suggest_list').append(li);
                        })
                    }   
                }
            });
        }
    });
  
    $("ul.suggest_list").on('click', '.sgitem', function () {
        $('.search_region_id').val($(this).attr("data-id"));
        $('.header_search_txt').val($(this).attr("data-name"));
        $('ul.suggest_list').css('display','none');
      });   
    } );
    </script>
    <script type="text/javascript">
        var ct = 0;
        $(document).ready(function(){
        $(".add-row").click(function(){
            var numItems = $('.room-rows').length;
            if(numItems<=5){
                var name = $("#name").val();
                var email = $("#email").val();
                $("#rooms_rows").append(markup);
                update_rmaudkik();
             }
        });

         $(".confirm").click(function(){
            var numItems = $('.room-rows').length;
            $('#room_container').fadeToggle();
            update_rmaudkik();
        });
        
        $("#input_room_row").click(function(){
            $('#room_container').fadeToggle();
            update_rmaudkik();
        });
        // Find and remove selected table rows
        
    });  
    var removeRow = function(el){
            $(el).parents("div.room-rows").remove();  
             var numItems = $('.room-rows').length;
           update_rmaudkik();
    }

    var update_rmaudkik = function(){
            var adlt=0;
            var kds=0;
            jQuery('div.room-rows').each(function(key, val){
                 var rsm = key +1;
                 var room = $(this);
                    $(room ).find( "span.roomCount").text('Room '+rsm);
                    var adultsCount = $(room).find(".guestminus option:selected").val();
                    var kidsCount = $(room).find(".guestplus option:selected").val();
                    adlt = adlt+parseInt(adultsCount);
                    kds = kds + parseInt(kidsCount);
                    var guests = adlt + kds;
                    if(rsm==1){
                      $('#sRooms').text(rsm+' Room');  
                    }else{
                      $('#sRooms').text(rsm+' Rooms');
                    }
                    if(adlt==1){
                      $('#sGuests').text(guests+' Guest');  
                    }else{
                      $('#sGuests').text(guests+' Guests');
                    }
                  
                    $('#num_adults').val(adlt); 
                    $('#num_children').val(kds); 
                    $('#num_rooms').val(rsm);
                    $('#num_guests').val(guests);
             });
     }
     
    </script>
@endsection