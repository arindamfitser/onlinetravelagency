<script src="{{ asset('frontend/js/jquery.js') }}"></script> 
<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --> 
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script> 
<!--<script type="text/javascript" src="js/stellarnav.min.js"></script> --> 
<script type="text/javascript" src="{{ asset('frontend/js/webslidemenu.js') }}"></script> 
<script src="{{ asset('frontend/js/owl.carousel.js') }}"></script> 
<script src="{{ asset('frontend/js/wow.js') }}"></script> 
<script src="{{ asset('frontend/js/theme.js') }}"></script> 
<script src="{{ asset('frontend/js/t-datepicker.js') }}"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/froala_editor.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/align.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/code_beautifier.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/code_view.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/font_size.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/line_breaker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/lists.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/fullscreen.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.loading.js') }}"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  

<!-- Gallery Load More and top script Script--> 
@yield('script')

<script>   
 $(function () {
  $(".experience_box_load").slice(0, 6).show();
  $("#loadMore").on('click', function (e) {
    //alert($(this).attr('data-count'));
    numItems = $('.experience_box_load:visible').length;
    //alert(numItems)
    e.preventDefault();
    $(".experience_box_load:hidden").slice(0, 3).slideDown();
    if ($(".experience_box_load:hidden").length == 0) {
      $("#loadMore").fadeOut('slow');
    }
    $(".navigation_sec").animate({
      scrollTop: $(this).offset().top
    }, 1500);
  });
});
 $(function(){
  $('.editor').froalaEditor({
    enter: $.FroalaEditor.ENTER_P,
    initOnClick: false,
    heightMin: 100,
    heightMax: 500
  })
});

</script>

<script>

  $(function () {
    $(".inspiration_box_load").slice(0, 6).show();
    $("#loadMore_insp").on('click', function (e) {
      e.preventDefault();
      $(".inspiration_box_load:hidden").slice(0, 3).slideDown();
      if ($(".inspiration_box_load:hidden").length == 0) {
        $("#loadMore_insp").fadeOut('slow');
      }
      $(".navigation_sec").animate({
        scrollTop: $(this).offset().top
      }, 1500);
    });
  });

</script>

<!-- sript for mobile search --> 
<script>
  $(document).ready(function(){
    $("#search_toggle_open").click(function(){
      $("#mobile_search_area_toggle").toggle(300);
      $(".navigation_sec").addClass("nav_toggle_bg");
    });
    $("#mobCancelSearch").click(function(){
      $("#mobile_search_area_toggle").toggle(300);
      $(".navigation_sec").removeClass("nav_toggle_bg");
    });
    $("#wsnavtoggle").click(function(){
      $("#mobile_search_area_toggle").hide(300);
      $(".navigation_sec").removeClass("nav_toggle_bg");
    });    
  });
</script> 
<!--<script>
 $(document).ready(function(){
    $('.t-datepicker').tDatePicker({
    });
  });
</script>--> 
<script type="text/javascript">

</script> 
<!-- stiky_menu --> 

<script>
 wow = new WOW(
 {
   animateClass: 'animated',
   offset:       200
 }
 );
 wow.init();
</script> 
<script>
//script to create sticky header 
jQuery(function(){
  createSticky(jQuery("#sticky-wrap"));
});

function createSticky(sticky) {
  if (typeof sticky != "undefined") {

    var pos = sticky.offset().top ,
    win = jQuery(window);

    win.on("scroll", function() {

      if( win.scrollTop() > pos ) {
        sticky.addClass("stickyhead");
      } else {
        sticky.removeClass("stickyhead");
      }           
    });         
  }
}
</script> 
<script>
/*$('#banner_carousel').carousel({
  interval: 7000,
  pause: false
})  */



$(document).ready(function() {
  //carousel options
  $('#banner_carousel').carousel({
    pause: true, 
    interval: 19000,
  });
});
</script> 
<script>
//IMAGE CAROUSEL
var cd = $('#collect1, #collect2, #collect3');
cd.owlCarousel({
  loop: false,
  nav: true,
  dots: false,
  items:1,
  autoplay: 2000,
  smartSpeed: 1000,
});
</script> 
<script>
//TESTIMONIALS
var cd = $('#testiMonial');
cd.owlCarousel({
  loop: true,
  nav: false,
  dots: true,
  items:1,
  autoplay: true,
  smartSpeed: 1000,
});
</script> 

<!-- range datepicker --> 
<script>
 $(document).ready(function(){
    // Call global the function
    // var date = new Date();
    // var currentDate = new Date();
    // var tomorrows =   date.setDate(date.getDate() + 1);

    // if(localStorage.getItem('t_start')){
    //   var std=localStorage.getItem('t_start');
    // }else{
    //   var std = currentDate;
    // }
    // if(localStorage.getItem('t_end')){
    //   var etd = localStorage.getItem('t_end');
    // }else{
    //   var etd = tomorrows;
    // }
    
    // $('.t-datepicker').tDatePicker({
    //   dateCheckIn: std,
    //   dateCheckOut: etd
    // });
    
    if($("#roomSearchFromDate").length){
    	$('#roomSearchFromDate, #roomSearchToDate').datepicker({
    		dateFormat: 'yy-mm-dd',
    		changeMonth: true,
    		changeYear: true,
    		minDate: 0
    	});
    }

  });
</script> 

<!-- adult_quntitt_button --> 
<script>
  $(document).ready(function(){
    //var quantitiy=0;
    $('.quantity-right-plus').click(function(e){
      e.preventDefault();
      var quantity = parseInt($('#quantity_'+this.id).val());
      if(quantity<=5){
        var quan = (quantity+1);
        $('#quantity_'+this.id).val((quan)+' Adults');
        $('#quantity_cart').val((quan)+' Adults');
        localStorage.setItem('quantity_adults', quan);
      }
    });
    $('.quantity-left-minus').click(function(e){
      e.preventDefault();
      var quantity1 = parseInt($('#quantity_'+this.id).val());
      if(quantity1>1){
        var quan1 = (quantity1-1);
        $('#quantity_'+this.id).val((quan1)+' Adults');
        $('#quantity_cart').val((quan1)+' Adults');
        localStorage.setItem('quantity_adults', quan1);
      }
    });    
    $('.quantity-room-right-plus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_'+this.id).val());
            // If is not undefined
            if(quantity<=5){
              var quan = (quantity+1);
              $('#quantity_'+this.id).val((quan)+' Rooms');
               localStorage.setItem('quantity_room', quan);
            }

          });

    $('.quantity-room-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity1 = parseInt($('#quantity_'+this.id).val());
        // If is not undefined
            // Increment
            if(quantity1>1){
              var quan1 = (quantity1-1);
              $('#quantity_'+this.id).val((quan1)+' Rooms');
              localStorage.setItem('quantity_room', quan1);
            }
          });
    
  }); 
</script> 



<!-- adult_quntitt_button --> 
<script>
  $(document).ready(function(){
    var quantitiy=0;
    $('.quantity-right-plus-child').click(function(e){
      // Stop acting like a button
      e.preventDefault();
      // Get the field name
      var quantity2 = parseInt($('#quantity_'+this.id).val());
      // If is not undefined
      if(quantity2<=5){
        var quan2 = (quantity2 + 1);
        $('#quantity_'+this.id).val((quan2)+' Childs');
        $('#quantity_child_cart').val((quan2)+' Childs');
        localStorage.setItem('quantity_child', quan2);
      }
    });
    $('.quantity-left-minus-child').click(function(e){
      // Stop acting like a button
      e.preventDefault();
      // Get the field name
      var quantity3 = parseInt($('#quantity_'+this.id).val());
      // If is not undefined
      // Increment
      if(quantity3>0){
        var quan3= (quantity3 - 1);
        $('#quantity_'+this.id).val((quan3)+' Childs');
        $('#quantity_child_cart').val((quan3)+' Childs');
        localStorage.setItem('quantity_child', quan3);
      }
    });
  }); 
  jQuery.validator.addMethod("notEqual", function(value, element, param) {
    return this.optional(element) || value != param;
  }, "Please specify a different (non-default) value");
  // Shorthand for $( document ).ready()
  $(function() {
    var header_num_guests = 0;
    $('#keywords').val( localStorage.getItem('keywords'));
    if(localStorage.getItem('quantity_adults') && localStorage.getItem('quantity_adults')!='undefined'){
      $('#quantity_ha').val(localStorage.getItem('quantity_adults'));
      $('#quantity_adults').val(localStorage.getItem('quantity_adults'));
      $('#header_adults').val(localStorage.getItem('quantity_adults'));
      $('#mobAdultDisplay').text(localStorage.getItem('quantity_adults'));
      header_num_guests = localStorage.getItem('quantity_adults');
    }else{
      $('#quantity_ha').val('1 Adult');
      header_num_guests = 1;
    }
    if(localStorage.getItem('quantity_child') && localStorage.getItem('quantity_child')!='undefined'){
      $('#quantity_hc').val(localStorage.getItem('quantity_child'));
      $('#quantity_child').val(localStorage.getItem('quantity_child'));
      $('#header_children').val(localStorage.getItem('quantity_child'));
      $('#mobChildDisplay').text(localStorage.getItem('quantity_child'));
      header_num_guests = parseInt(localStorage.getItem('quantity_child')) + parseInt(localStorage.getItem('quantity_adults'));
    }else{
      $('#quantity_child').val('0 Child');
    }
    if(localStorage.getItem('region_id') && localStorage.getItem('region_id')!='undefined'){
      $('#header_search_region_id').val(localStorage.getItem('region_id'));
      $('#headerkeywords').val(localStorage.getItem('keywords'));
      $('#mob_header_search_region_id').val(localStorage.getItem('region_id'));
      $('#mobheaderkeywords').val(localStorage.getItem('keywords'));
    }
    $('#header_num_guests').val(header_num_guests);
    $('#mob_header_num_guests').val(header_num_guests);
  });
  function changeProfile() {
    $('#file').click();
  }
  $('#file').change(function () {
    if ($(this).val() != '') {
      upload(this);
    }
  });
  function upload(img) {
    var form_data = new FormData();
    form_data.append('file', img.files[0]);
    form_data.append('_token', '{{csrf_token()}}');
    $('#loading').css('display', 'block');
    $.ajax({
      url: "{{url('ajax-image-upload')}}",
      data: form_data,
      type: 'POST',
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.fail) {
          $('#preview_image').attr('src', '{{asset('frontend/images/noimage.jpg')}}');
          alert(data.errors['file']);
        }
        else {
          $('#file_name').val(data);
          $('#preview_image').attr('src',data);
        }
        $('#loading').css('display', 'none');
      },
      error: function (xhr, status, error) {
        //alert(xhr.responseText);
        $('#preview_image').attr('src', '{{asset('frontend/images/noimage.jpg')}}');
        $('#loading').css('display', 'none');
      }
    });
  }
  function removeFile() {
      if ($('#file_name').val() != ''){
        if (confirm('Are you sure want to remove profile picture?')) {
          $('#loading').css('display', 'block');
          var form_data = new FormData();
          //form_data.append('_method', 'DELETE');
          form_data.append('filename',  $('#file_name').val());
          form_data.append('_token', '{{csrf_token()}}');
          $.ajax({
            url: "{{url('ajax-remove-image')}}",
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (data) {
              $('#preview_image').attr('src', '{{asset('frontend/images/noimage.jpg')}}');
              $('#file_name').val('');
              $('#loading').css('display', 'none');
            },
            error: function (xhr, status, error) {
              alert(xhr.responseText);
            }
          });
         }
        }
      }
</script>  
<?php if(Request::segment(1)=='users' && Request::segment(1)=='customer' && Request::segment(1)=='hoteliar'){ ?>
  <style type="text/css">
    .navigation_sec {
      height: 0px!important;
    }
    .hometop_gap {
      padding-top: 72px!important;
    }
  </style>  
<?php } ?>
<!-- HEADER SEARCH FOR BOTH MOBILE & DESKTOP-->
<script type="text/javascript">
$( function() {
  var minlength = 2;
  $("#headerkeywords").keyup(function () {
    var that = this,
    value = $(this).val();
    $('ul.suggest_list_header').css('display','none');
    $('#header_search_region_id').val('');
    if (value.length >= minlength ) {
      $.ajax({
        type: "GET",
        url: "{{route('ajax.get.region')}}",
        data: {
            'region' : value
        },
        dataType: "json",
        success: function(json){
          $('#header_suggest').html('');
          if(json){
            $('#header_suggest').css('display','block'); 
            $.each(json, function (key, data) {
              var li= '<li class="sgitem" data-id="'+data.region_id+'" data-name="'+data.name+'('+data.country_name+')">'+data.name+'('+data.country_name+')'+'</li>'
              $('#header_suggest').append(li);
            })
          }else{
            $('#header_suggest').css('display','none');
          }
        }
      });
    }
  });
  $("#mobheaderkeywords").keyup(function () {
    var that = this,
    value = $(this).val();
    $('ul.suggest_list_header_mob').css('display','none');
    $('#mob_header_search_region_id').val('');
    if (value.length >= minlength ) {
      $.ajax({
        type: "GET",
        url: "{{route('ajax.get.region')}}",
        data: {
            'region' : value
        },
        dataType: "json",
        success: function(json){
          $('#mob_header_suggest').html('');
          if(json){
            $('#mob_header_suggest').css('display','block'); 
            $.each(json, function (key, data) {
              var li= '<li class="sgitem" data-id="'+data.region_id+'" data-name="'+data.name+'('+data.country_name+')">'+data.name+'('+data.country_name+')'+'</li>'
              $('#mob_header_suggest').append(li);
            })
          }else{
            $('#mob_header_suggest').css('display','none');
          }
        }
      });
    }
  });
  $("#header_suggest").on('click', '.sgitem', function () {
    $('#header_search_region_id').val($(this).attr("data-id"));
    $('#headerkeywords').val($(this).attr("data-name"));
    $('#header_suggest').css('display','none');
  });
  $("#mob_header_suggest").on('click', '.sgitem', function () {
    $('#mob_header_search_region_id').val($(this).attr("data-id"));
    $('#mobheaderkeywords').val($(this).attr("data-name"));
    $('#mob_header_suggest').css('display','none');
  });
  $("#hdr_desk_search_btn").click(function(){
    if($('#header_search_region_id').val() == ''){
      if($('#fromFishing').val() == 'no'){
        swalAlert("Location Keyword is madatory !!!", "warning", 2000);
        $('#header_search_region_id').focus();
        return false;
      }
    }
    if($('.header_check_in').val() == ''){
      swalAlert("Checkin Date is madatory !!!", "warning", 2000);
      $('.header_check_in').focus();
      return false;
    }
    if($('.header_check_out').val() == ''){
      swalAlert("Checkout Date is madatory !!!", "warning", 2000);
      $('.header_check_out').focus();
      return false;
    }
    localStorage.setItem('region_id', $('#header_search_region_id').val());
    localStorage.setItem('keywords', $('#headerkeywords').val());
    localStorage.setItem('t_start', $('#t_start').val());
    localStorage.setItem('t_end', $('#t_end').val());
    localStorage.setItem('quantity_adults', $('#header_adults').val());
    localStorage.setItem('quantity_child', $('#header_children').val());
    $("#header_search_form").submit();
  });
  $("#mob_hdr_desk_search_btn").click(function(){
    if($('#mob_header_search_region_id').val() == ''){
      if($('#mobFromFishing').val() == 'no'){
        swalAlert("Location Keyword is madatory !!!", "warning", 2000);
        $('#mob_header_search_region_id').focus();
        return false;
      }
    }
    if($('.mob_header_check_in').val() == ''){
      swalAlert("Checkin Date is madatory !!!", "warning", 2000);
      $('.mob_header_check_in').focus();
      return false;
    }
    if($('.mob_header_check_out').val() == ''){
      swalAlert("Checkout Date is madatory !!!", "warning", 2000);
      $('.mob_header_check_out').focus();
      return false;
    }
    localStorage.setItem('region_id', $('#mob_header_search_region_id').val());
    localStorage.setItem('keywords', $('#mobheaderkeywords').val());
    localStorage.setItem('t_start', $('#t_start').val());
    localStorage.setItem('t_end', $('#t_end').val());
    localStorage.setItem('quantity_adults', $('#mob_header_adults').val());
    localStorage.setItem('quantity_child', $('#mob_header_children').val());
    $("#header_mob_search_form").submit();
  });
  $("#input_room_row_header").click(function(){
    $('#room_container_header').fadeToggle();
    update_rmaudkik_header();
  });
  $("#input_room_row_header_mob").click(function(){
    $('#room_container_header_mob').fadeToggle();
    update_rmaudkik_header_mob();
  });
  var ct = 0;
  $("#add-row-header").click(function(){
    var numItems = $('.room-rows-header').length;
    if(numItems<=5){
      var name = $("#name").val();
      var email = $("#email").val();
      $("#rooms_rows_header").append('<div class="room-rows-header">\
                                        <input type="hidden" id="normHeader" name="ab[norm][]" value="1" />\
                                        <div class="room-cell">\
                                          <span class="displayBlock" id="roomCountHeader">Room 1</span>\
                                        </div>\
                                        <div class="room-cell">\
                                          <span class="guestminusHeader">\
                                            <select name="ab[adlts][]" class="adlt" onchange="update_rmaudkik_header();">' + adultsOpthtmlHdr + '</select>\
                                          </span>\
                                          <span class="guestplusHeader">\
                                            <select name="ab[kids][]" class="kid" onchange="update_rmaudkik_header();">' + KidsOpthtmlHdr + '</select>\
                                          </span>\
                                          <span class="removeHdr" onclick="removeRowHeader(this)">Remove</span>\
                                        </div>\
                                      </div>');
      update_rmaudkik_header();
    }
  });
  $("#add-row-header-mob").click(function(){
    var numItems = $('.room-rows-header-mob').length;
    if(numItems<=5){
      var name = $("#name").val();
      var email = $("#email").val();
      $("#rooms_rows_header_mob").append('<div class="room-rows-header-mob">\
                                        <input type="hidden" id="normHeaderMob" name="ab[norm][]" value="1" />\
                                        <div class="room-cell">\
                                          <span class="displayBlock" id="roomCountHeaderMob">Room 1</span>\
                                        </div>\
                                        <div class="room-cell">\
                                          <span class="guestminusHeaderMob">\
                                            <select name="ab[adlts][]" class="adlt" onchange="update_rmaudkik_header_mob();">' + adultsOpthtmlHdr + '</select>\
                                          </span>\
                                          <span class="guestplusHeaderMob">\
                                            <select name="ab[kids][]" class="kid" onchange="update_rmaudkik_header_mob();">' + KidsOpthtmlHdr + '</select>\
                                          </span>\
                                          <span class="removeHdr" onclick="removeRowHeaderMob(this)">Remove</span>\
                                        </div>\
                                      </div>');
      update_rmaudkik_header_mob();
    }
  });
  $("#confirm-header").click(function(){
    var numItems = $('.room-rows-header').length;
    $('#room_container_header').fadeToggle();
    update_rmaudkik_header();
  });
  $("#confirm-header-mob").click(function(){
    var numItems = $('.room-rows-header-mob').length;
    $('#room_container_header_mob').fadeToggle();
    update_rmaudkik_header_mob();
  });
});
function removeRowHeader(el){
  $(el).parents(".room-rows-header").remove();
  var numItems = $('.room-rows-header').length;
  update_rmaudkik_header();
}
function removeRowHeaderMob(el){
  $(el).parents(".room-rows-header-mob").remove();
  var numItems = $('.room-rows-header-mob').length;
  update_rmaudkik_header_mob();
}
function update_rmaudkik_header(){
  var adlt=0;
  var kds=0;
  jQuery('.room-rows-header').each(function(key, val){
    var rsm = key +1;
    var room = $(this);
    $(room).find("span#roomCountHeader").text('Room '+rsm);
    var adultsCount = $(room).find(".guestminusHeader option:selected").val();
    var kidsCount = $(room).find(".guestplusHeader option:selected").val();
    adlt = adlt+parseInt(adultsCount);
    kds = kds + parseInt(kidsCount);
    var guests = adlt + kds;
    if(rsm==1){
      $('#sRoomsHeader').text(rsm+' Room');  
    }else{
      $('#sRoomsHeader').text(rsm+' Rooms');
    }
    if(adlt==1){
      $('#sGuestsHeader').text(guests+' Guest');  
    }else{
      $('#sGuestsHeader').text(guests+' Guests');
    }
    $('#header_adults').val(adlt); 
    $('#header_children').val(kds); 
    $('#header_num_rooms').val(rsm);
    $('#header_num_guests').val(guests);
  });
}
function update_rmaudkik_header_mob(){
  var adlt=0;
  var kds=0;
  jQuery('.room-rows-header-mob').each(function(key, val){
    var rsm = key +1;
    var room = $(this);
    $(room).find("span#roomCountHeaderMob").text('Room '+rsm);
    var adultsCount = $(room).find(".guestminusHeaderMob option:selected").val();
    var kidsCount = $(room).find(".guestplusHeaderMob option:selected").val();
    adlt = adlt+parseInt(adultsCount);
    kds = kds + parseInt(kidsCount);
    var guests = adlt + kds;
    if(rsm==1){
      $('#sRoomsHeaderMob').text(rsm+' Room');  
    }else{
      $('#sRoomsHeaderMob').text(rsm+' Rooms');
    }
    if(adlt==1){
      $('#sGuestsHeaderMob').text(guests+' Guest');  
    }else{
      $('#sGuestsHeaderMob').text(guests+' Guests');
    }
    $('#mob_header_adults').val(adlt); 
    $('#mob_header_children').val(kds); 
    $('#mob_header_num_rooms').val(rsm);
    $('#mob_header_num_guests').val(guests);
  });
}
function swalAlert(text, type, timer = 2000) {
    Swal.fire({
        type: type,
        title: text,
        timer: timer
    })
}
$(document).on('click', '.imageCarousel', function (e) { 
	e.preventDefault();
	let imageId = $(this).attr('data-id');
	let hotelId = $(this).attr('data-hotel');
	let action  = $(this).attr('data-action');
	let stuba   = $(this).attr('data-stuba');
    $.ajax({
		type: "POST",
		url: '{{ route('search.image.carousel') }}',
		data: {
			'_token'    : '{{ csrf_token()}}',
            'imageId'   : imageId,
            'hotelId'   : hotelId,
            'action'    : action,
            'stuba'     : stuba,
		},
		dataType: "JSON",
		beforeSend: function () {
			$(".holidayimg" + hotelId).loading();
		},
		success: function (res) {
			$(".holidayimg" + hotelId).loading("stop");
			$(".search-image" + hotelId).html('<img src="'+res.url+'">');
			$(".imageCarousel").attr("data-id", res.id);
		}
	});
});
    
</script>