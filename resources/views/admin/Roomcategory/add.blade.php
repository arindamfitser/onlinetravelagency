@extends('admin.layouts.master')
@section('th_head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css')}}">
@endsection
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h3 class="card-title">Add New Category
            <div class="float-right">
              <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                <?php @langOption(); ?>
              </select>
              <a href="{{ route('admin.category')}}" class="btn-sm btn-success btn-round ">
              <i class="material-icons">library_books</i> List</a>
            </div>
            </h3>
          </div>
          <div class="card-body">
            @include('admin.layouts.messages')
            <form id="AddCategory" method="post" action="{{ route('admin.category.doadd') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" id="lang_code" name="locale" value="en">
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label class="bmd-label-floating">Category Name</label>
                    <input type="text" id="name" name="name" class="form-control">
                  </div>   
                  <div class="form-group">
                    <label class="bmd-label-floating">Classification</label>
                    <select class="form-control" id="classification_id" name="classification_id">
                      <option>---Please select---</option>
                      @foreach($classification as $cls)
                        <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                      @endforeach
                    </select>
                  </div>              
                </div>
                <div class="col-md-2">
                  <!-- right section -->
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success btn-rounded btn-sm waves-effect waves-light"> Published </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('th_foot')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
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
<script>
$(function(){
$('#edit').froalaEditor({
enter: $.FroalaEditor.ENTER_P,
initOnClick: false
})
});
</script>
<script src="{{ asset('backend/assets/js/posts.js') }}"></script>
@endsection