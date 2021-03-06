@extends('admin.layouts.master')

@section('th_head')
<link rel="stylesheet" href="{{ asset('backend/froala/css/froala_editor.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/froala_style.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/code_view.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/colors.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/emoticons.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/image_manager.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/image.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/line_breaker.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/table.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/char_counter.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/video.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/fullscreen.css')}}">
<link rel="stylesheet" href="{{ asset('backend/froala/css/plugins/file.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.css'>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/css/fileinput.min.css">
@endsection
@section('content')
<?php $lang = @\Session::get('language'); ?>
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h3 class="card-title ">Edit  Room
          <div class="float-right">

            <a href="{{ route('admin.hotels.rooms.add', ['lang'=>$lang, 'id' => $id]) }}" class="btn-sm btn-info btn-round "> 
              <i class="material-icons">add</i> Add Room</a>
            </div>
          </div>
          
          <div class="card-body table-responsive">
            @include('frontend.layouts.messages')
            <div class="wizard">
              <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Room">
                      <span class="round-tab">
                        <i class="glyphicon glyphicon-folder-open"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Room Details">
                      <span class="round-tab">
                        <i class="glyphicon glyphicon-pencil"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Room Gallery">
                      <span class="round-tab">
                        <i class="glyphicon glyphicon-picture"></i>
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <span id="message"></span>
                <div class="tab-pane active" role="tabpanel" id="step1">
                  <form action="{{ route('admin.hotels.rooms.updateroom', ['lang'=>$lang,'id' => $id]) }}" method="POST" id="RoomAddstep1">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Room Name <span class="required">*</span></label>
                          <input type="text" name="name" id="name" class="form-control" placeholder="Room Name" value="{{ $rooms->name }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Category <span class="required">*</span></label>
                          <select name="category" id="category" class="form-control">
                            <option value="">---Please select---</option>
                            @foreach($roomcategory as $rc)
                            <?php 
                            if($rc->id == $rooms->category){
                              $select = 'SELECTED="SELECTED"';
                            }else{
                              $select = '';
                            }
                            ?>
                            <option value="{{ $rc->id }}" {{ $select }}>{{ $rc->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                       <div class="form-group">
                        <label>Description <span class="required">*</span></label>
                        <textarea class="form-control editor" name="descp" id="descp" placeholder="Description">{{ $rooms->descp }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>No. of Room  <span class="required">*</span></label>
                        <input type="text" name="room_capacity" id="room_capacity" class="form-control" placeholder="Room Capacity" value="{{ $rooms->room_capacity }}" disabled>
                      </div>
                      <div class="form-group">
                        <label>Adult Capacity <span class="required">*</span></label>
                        <input type="text" name="adult_capacity" id="adult_capacity" class="form-control" placeholder="Adult Capacity" value="{{ $rooms->adult_capacity }}">
                      </div>
                      <div class="form-group">
                        <span>Availability <span class="required">*</span></span>&nbsp;&nbsp;
                        <input type="radio" name="availability" value="1" <?php echo ($rooms->availability == 1) ? 'checked' : ''; ?>>Yes
                        <input type="radio" name="availability" value="0" <?php echo ($rooms->availability == 0) ? 'checked' : ''; ?>>No
                      </div>
                      <div class="form-group">
                        <label>Amenities </label>&nbsp;&nbsp;&nbsp;&nbsp;</br>
                        <div class="row">
                          <ul style="list-style: none;">
                            @foreach($amenities as $amenitiy)
                            <?php $checked = '';  ?>
                            @foreach ($roomsamenitie as $aR)
                            @if ($amenitiy->id == $aR->amenities_id)
                            <?php $checked .= 'checked="checked"';  ?>
                            @endif
                            @endforeach
                            <li class="col-sm-6">
                              <label class="checkbox-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenitiy->id }}" {{ $checked }}> {{ $amenitiy->amenities_name }} <span class="form-check-sign"><span class="check"></span></span>
                              </label>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Base Price <span class="required">*</span></label>
                        <input type="text" name="base_price" id="base_price" class="form-control"  value="{{ $rooms->base_price }}">
                      </div>
                      <div class="form-group">
                        <label>No. of bed <span class="required">*</span></label>
                        <input type="text" name="extra_bed" id="extra_bed" class="form-control" value="{{ $rooms->extra_bed }}">
                      </div>
                      <div class="form-group">
                        <label>Child Capacity <span class="required">*</span></label>
                        <input type="text" name="child_capacity" id="child_capacity" class="form-control" value="{{ $rooms->child_capacity }}">
                      </div>
                    </div>
                  </div>
                  <ul class="list-inline pull-right">
                    <li><button type="submit" class="btn btn-primary">Save and continue</button></li>
                  </ul>
                </form>
                <br><br><br><br>
                <div class="row" id="cal_sec" style="display: none;">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div id='calendar'></div>
                      <div class="modal fade calender_modal" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Room Availability Datepicker</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <label>Availibility</label>
                                <select name="event_title" id="event_title" class="form-control">
                                  <option value="1">Available</option>
                                  <option value="2">Not Available</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="room_price" id="room_price" class="form-control" value="{{ $rooms->base_price }}">
                              </div>
                              <div class="form-group" id="date_group">
                                <label>Select range</label>
                                <input type="text" name="date_range" id="date_range" class="form-control">
                              </div>
                            </div>
                            <input type="hidden" name="date_id" id="date_id">
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" id="save_calender" class="btn btn-primary">Update</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" role="tabpanel" id="step2">
                <form action="{{ route('admin.hotels.rooms.editetails', ['lang'=>$lang,'id' => $id]) }}" method="POST" id="step2form">
                  {{ csrf_field() }}
                  <span id="step_2_content">
                    @if(!$rooms_details->isEmpty())
                    @foreach($rooms_details as $key => $rd)
                    <div class="row form_content_box">
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Floor No <span class="required">*</span></label>
                              <input type="text" name="floor_no[]" id="floor_no_{{ $key }}" class="form-control floor_no" value="{{ $rd->floor_no }}" placeholder="Floor No" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Room No <span class="required">*</span></label>
                              <input type="text" name="room_no[]" id="room_no_{{ $key }}" class="form-control room_no" value="{{ $rd->room_no }}" placeholder="Room No" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Seat/ bed count</label>
                              <input type="text" name="bed_count[]" class="form-control" id="bed_count_{{ $key }}" value="{{ $rd->bed_count }}" placeholder="Seat/ bed count">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Availability <span class="required">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="radio" name="availability_{{ $key }}" value="1" <?php echo ($rd->availability == 1) ? 'checked' : ''; ?>>Yes
                              <input type="radio" name="availability_{{ $key }}" value="0" <?php echo ($rd->availability == 0) ? 'checked' : ''; ?>>No
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @else
                    @for ( $i = 0;  $i < $rooms->room_capacity;  $i++)
                    <div class="row form_content_box">
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Floor No <span class="required">*</span></label>
                              <input type="text" name="floor_no[]" id="floor_no_{{ $i }}" class="form-control floor_no" value="" placeholder="Floor No" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Room No <span class="required">*</span></label>
                              <input type="text" name="room_no[]" id="room_no_{{ $i }}" class="form-control room_no" value="" placeholder="Room No" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Seat/ bed count</label>
                              <input type="text" name="bed_count[]" class="form-control" id="bed_count_{{ $i }}" value="" placeholder="Seat/ bed count">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Availability <span class="required">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="radio" name="availability_{{ $i }}" value="1">Yes
                              <input type="radio" name="availability_{{ $i }}" value="0">No
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endfor
                    @endif
                  </span>
                  <ul class="list-inline pull-right">
                    <li><button type="submit" class="btn btn-primary">Save and continue</button></li>
                  </ul>
                </form>
              </div>
              <div class="tab-pane" role="tabpanel" id="step3">
                <form action="{{ route('admin.hotels.rooms.editgallery', ['lang'=>$lang,'id' => $id]) }}" id="" method="POST" class="" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="row">
                    <div class="col-sm-12">
                     <div class="form-group">
                      <label>Featured Image</label>
                      <div class="file-loading">
                        <input id="featured_image" name="featured_image" type="file" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Gallery Images</label>
                      <div class="file-loading">
                        <input id="gallery_image" name="gallery_image[]" type="file" accept="image/*" multiple>
                      </div>
                    </div>
                  </div>
                </div>
                <ul class="list-inline pull-right">
                  <li><button type="submit" class="btn btn-primary">Update now</button></li>
                </ul>
              </form>
            </div>
            <div class="clearfix"></div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
</div>

<div class="clearfix"></div>
@endsection
@section('th_foot')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="{{ asset('fullcalender') }}/lib/moment.min.js"></script>
<script src="{{ asset('fullcalender') }}/fullcalendar.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" ></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/froala_editor.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/align.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/code_beautifier.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/code_view.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/colors.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/draggable.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/emoticons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/font_size.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/font_family.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/image.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/file.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/image_manager.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/line_breaker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/link.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/lists.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/paragraph_format.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/paragraph_style.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/video.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/table.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/url.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/entities.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/char_counter.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/inline_style.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/save.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('backend/froala/js/plugins/fullscreen.min.js') }}"></script>
<script type="text/javascript">
  $(function(){
   $('.editor').froalaEditor({
    enter: $.FroalaEditor.ENTER_P,
    initOnClick: false
  })
 });
</script>
<script type="text/javascript">

  $('form[id="RoomAddstep1"]').validate({
    rules: {
      name: {
        required: true
      },
      descp: {
        required: true
      },
      extra_bed: {
        required: true,
        number: true
      },
      category: {
        required: true
      },
      availability: {
        required: true
      },
      room_capacity: {
        required: true,
        number: true,
        min: 1
      },
      base_price: {
        required: true
      },
      adult_capacity: {
        required: true,
        number: true
      },
      child_capacity: {
        required: true,
        number: true
      }
    },
    submitHandler: function(form){
      genericAjax(form);
    }
  });
  function genericAjax(form){
    $.ajax({
      type     : $(form).attr('method'),
      url      : $(form).attr('action'),
      data     : $(form).serialize(),
      cache    : false,
      success  : function(data) {
        var data = $.parseJSON(data);
        if(data.success == true){
          $('#message').html('<div class="alert alert-success"><strong>Success!</strong> '+data.message+'</div>');
          setTimeout(function(){
           /* var $active = $('.wizard .nav-tabs li.active');
            $active.addClass('disabled');
            $active.next().removeClass('disabled');
            nextTab($active);*/
            $('#RoomAddstep1').fadeOut();
            $('#cal_sec').fadeIn();
            $('.alert-success').fadeOut();
          }, 1300);
        }else{
          $('#message').html('<div class="alert alert-danger"><strong>Error!</strong> Something wents wrong.</div>');
        }

      }
    });
  }
  $(document).find('#step2form').validate({
    ignore: [],
    rules:{
      'floor_no[]':
      {
        required:true,
      },
      'room_no[]':
      {
        required:true,
      },
      'availability[]':{
        required:true,
      }
    },
    submitHandler: function(form){
      genericAjax(form)
    }
  });
 /* $(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
      var $target = $(e.target);
      if ($target.parent().hasClass('disabled')) {
        return false;
      }
    });
  });*/
  var getCalenderview = function(){
    $('#calendar').fullCalendar({
     header: {
      left: 'prev',
      center: 'title',
      right: 'next'
    },
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            displayEventTime : false,
            selectable: true,
            selectHelper: true,
            select: function(start, end) {

              $('#date_range').daterangepicker({
                startDate: moment(start).format('YYYY-MM-DD'),
                endDate:moment(start).format('YYYY-MM-DD'),
                minDate: moment(),
                locale: { 
                  format: 'YYYY-MM-DD'
                },
                isInvalidDate: function(date) {
                  var disabled_start = moment('2019-02-24', 'YYYY-MM-DD');
                  var disabled_end = moment('2019-02-28', 'YYYY-MM-DD');
                  return date.isAfter(disabled_start) && date.isBefore(disabled_end);
                }
              });
              $('.calender_modal').modal('show');
            },
            eventClick: function(event, element) {
              console.log(event);

              $('.calender_modal').modal('show');
              $('.calender_modal').find('#event_title').val(event.title);
              $('.calender_modal').find('#start_date').val(event.start);
              $('.calender_modal').find('#date_id').val(event.key);
              $('.calender_modal').find('#room_price').val(event.price);
              $('.calender_modal').find('#end_date').val(event.end);
            },
            eventSources: [
            {
             events: function(start, end, timezone, callback) {
               if(localStorage.getItem("room_id")){
                 var id = localStorage.getItem("room_id");
               }else{
                 var id = {{ $id }};
               }
               $.ajax({
                 type:'GET',
                 url: '{{ route('user.hotels.room.fecthdate') }}',
                 dataType: 'json',
                 data:{ room_id: id},       
                 success: function(msg) {
                   var events = msg.events;
                   callback(events);
                 }
               });
             }
           },
           ]
         });
    
    $('#calendar').fullCalendar('refetchEvents');
  } 
  $('#save_calender').on('click', function() {
    var event_title = $('#event_title').val();
    var date_id = $('#date_id').val();
    var room_price = $('#room_price').val();
    var date_range = $('#date_range').val();
    var availabe_rooms = $('#room_capacity').val();
    var dates = date_range.split(" - ");
    if(localStorage.getItem("room_id")==''){
      localStorage.setItem("room_id",{{ $id }});
    }
    var room_id = localStorage.getItem("room_id");
    if (event_title) {
      var date_data = {
        _token: "{{ csrf_token() }}",
        title: event_title,
        start: dates[0],
        end: dates[1],
        room_id: room_id,
        price: room_price,
        date_id: date_id,
        availabe_rooms: availabe_rooms,
        hotel_id: "{{ $rooms->hotel_id }}"
      };
      $.ajax({
        type     : 'POST',
        url      : "{{ route('user.hotels.rooms.adddate') }}",
        data     : date_data,
        dataType: 'json',
        success  : function(data) {
            //console.log(data);
            getCalenderview();
            //$('#next_tab').show();
          }
        });
    }
    $('.calender_modal').modal('hide');
  });
  $(document).ready(function(){
   localStorage.setItem("room_id", '');
   getCalenderview();
 });
  function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
  }
  function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
  }
  $('.datepicker').datepicker({
    startDate:new Date()
  });
  var featured_image = "{{ Storage::disk('local')->url($rooms->featured_image) }}";
  $("#featured_image").fileinput({
    showUpload: false,
    browseClass: "btn btn-primary btn-block",
    showCaption: false,
    previewClass: "bg-room-feature",
    showRemove: false,
    initialPreview: [featured_image],
    initialPreviewAsData: true,
  });
  var gallery_arr = [];
  @foreach ($roomgallery as $rg)
  gallery_arr.push("{{ Storage::disk('local')->url($rg->image) }}");
  @endforeach
  $("#gallery_image").fileinput({
    showUpload: false,
    browseClass: "btn btn-primary btn-block",
    showCaption: false,
    previewClass: "bg-rom-gallery",
    initialPreview: gallery_arr,
    initialPreviewAsData: true,
    initialPreviewConfig: [
    @foreach ($roomgallery as $rg)
    {caption: "{{$rg->image}}", size: 576237, width: "120px", url: "{{route('user.hotels.rooms.del.gallery',['lang' => $lang])}}", key: "{{$rg->id}}"},
    @endforeach 
    ],
  });

</script>
@endsection