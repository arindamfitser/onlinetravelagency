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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/css/fileinput.min.css">
@endsection
@section('content')
<?php $lang = @\Session::get('language'); ?>
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h3 class="card-title ">Add Room
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
                  <li role="presentation" class="disabled">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Room Details">
                      <span class="round-tab">
                        <i class="glyphicon glyphicon-pencil"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled">
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
                  <form action="{{ route('admin.hotels.rooms.doadd', ['lang'=>$lang, 'id' => $id]) }}" method="POST" id="RoomAddstep1">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Room Name <span class="required">*</span></label>
                          <input type="text" name="name" id="name" class="form-control">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Category <span class="required">*</span></label>
                          <select name="category" id="category" class="form-control">
                            <option value="">---Please select---</option>
                            @foreach($roomcategory as $rc)
                            <option value="{{ $rc->id }}">{{ $rc->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                       <div class="form-group">
                        <label class="bmd-label-floating" >Description <span class="required">*</span></label>
                        <textarea class="form-control editor" name="descp" id="descp" ></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="bmd-label-floating" >No. of Rooms <span class="required">*</span></label>
                        <input type="text" name="room_capacity" id="room_capacity" class="form-control">
                      </div>
                      <div class="form-group">
                        <label class="bmd-label-floating">Adult Capacity <span class="required">*</span></label>
                        <input type="text" name="adult_capacity" id="adult_capacity" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label>Availability <span class="required">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="availability" value="1" checked>Yes
                        <input type="radio" name="availability" value="0">No
                      </div>
                      <div class="form-group">
                         <label>Amenities </label>&nbsp;&nbsp;&nbsp;&nbsp;</br>
                        <div class="row">
                            <ul style="list-style: none;">
                               @foreach($amenities as $amenitiy)
                              <li class="col-sm-6">
                                <label class="checkbox-inline"><input type="checkbox" name="amenities[]" value="{{ $amenitiy->id }}">{{ $amenitiy->amenities_name }}</label>
                              </li>
                               @endforeach
                            </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                     <div class="form-group">
                      <label>Base Price <span class="required">*</span></label>
                      <input type="text" name="base_price" id="base_price" class="form-control">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">No. of Bed <span class="required">*</span></label>
                      <input type="text" name="extra_bed" id="extra_bed" class="form-control" >
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Child Capacity <span class="required">*</span></label>
                      <input type="text" name="child_capacity" id="  child_capacity" class="form-control" >
                    </div>
                  </div>
                </div>
                <ul class="list-inline pull-right">
                  <li><button type="submit" class="btn btn-primary">Save and continue</button></li>
                </ul>
              </form>
            </div>
            <div class="tab-pane" role="tabpanel" id="step2">
              <form action="{{ route('user.hotels.rooms.adddetails') }}" method="POST" id="step2form">
                {{ csrf_field() }}
                <span id="step_2_content"></span>
                <ul class="list-inline pull-right">
                  <li><button type="submit" class="btn btn-primary">Save and continue</button></li>
                </ul>
              </form>
            </div>
            <div class="tab-pane" role="tabpanel" id="step3">
              <form action="{{ route('user.hotels.rooms.addgallery') }}" id="" method="POST" class="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <span id="step_3_content"></span>
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
                <li><button type="submit" class="btn btn-primary">Save</button></li>
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
        required: true,
        number: true,
        min: 1
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
            var $active = $('.wizard .nav-tabs li.active');
            $active.addClass('disabled');
            $active.next().removeClass('disabled');
            nextTab($active);
            $('.alert-success').fadeOut();
          }, 1300);
          var room_capacity = data.results.room_capacity;
          if(room_capacity !=""){
            var details_html = '';
            for (var i = 0; i < room_capacity; i++) {
              details_html += '<div class="row form_content_box"><div class="col-sm-12"><div class="row"><div class="col-sm-4"><div class="form-group"><label>Floor No <span class="required">*</span></label><input type="text" name="floor_no[]" id="floor_no_'+i+'" class="form-control floor_no" placeholder="Floor No" required></div></div><div class="col-sm-4"><div class="form-group"><label>Room No <span class="required">*</span></label><input type="text" name="room_no[]" id="room_no_'+i+'" class="form-control room_no" placeholder="Room No" required></div></div><div class="col-sm-4"><div class="form-group"><label>Seat/ bed count</label><input type="text" name="bed_count[]" class="form-control" id="bed_count_'+i+'" placeholder="Seat/ bed count"></div></div></div><div class="row"><div class="col-sm-12"><div class="form-group"><label>Availability <span class="required">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" name="availability_'+i+'" value="1" checked>Yes</label><label class="radio-inline"><input type="radio" name="availability_'+i+'" value="0">No</label></div></div></div></div></div>';
            }
            $('#step_2_content').html(details_html);
            $('#step_2_content').append('<input type="hidden" name="room_id" value="'+data.results.id+'" />');
          }
          if(data.results.room_id != ""){
            $('#step_3_content').append('<input type="hidden" name="room_id" value="'+data.results.room_id+'" />');
          }
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
  $('.datepicker').datepicker({
    startDate:new Date()
  });
  $(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
      var $target = $(e.target);
      if ($target.parent().hasClass('disabled')) {
        return false;
      }
    });
  });
  function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
  }
  function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
  }
  $("#featured_image").fileinput({
    showUpload: false,
    browseClass: "btn btn-primary btn-block",
    showCaption: false,
    showRemove: false,
  });
  $("#gallery_image").fileinput({
    showUpload: false,
  });
</script>
<script>
  $(function(){
    $('#editor').froalaEditor({
      enter: $.FroalaEditor.ENTER_P,
      initOnClick: false
    })
  });
</script>
@endsection