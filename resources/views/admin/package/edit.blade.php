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
            <h3 class="card-title">Edit Package
              <div class="float-right">
                <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                  <?php @langOption(); ?>
                </select>
                <a href="{{ route('admin.hotels.packages', ['id' => $package->id]) }}" class="btn-sm btn-success btn-round ">
                  <i class="material-icons">library_books</i> List</a>
                </div>
              </h3>
            </div>
            <div class="card-body">
              @include('admin.layouts.messages')
              <form id="EditPackage" method="post" action="{{ route('admin.hotels.packages.update', ['id' => $package->id]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="lang_code" name="locale" value="en">
                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label class="bmd-label-floating">Package Name</label>
                      <input type="text" id="pkg_name" name="pkg_name" class="form-control" value="{{ $package->pkg_name }}">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Package Content</label>
                      <textarea id='edit' class="form-control" name="pkg_descp">{{ $package->pkg_descp }}
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Package Image</label>
                      <div class="file-field">
                        <div class="z-depth-1-half mb-4">
                          @if($package->pkg_image)
                          <img src="{{ Storage::disk('local')->url($package->pkg_image) }}" class="img-fluid" alt="example placeholder" width="300px" height="200px">
                          @endif
                        </div>
                        <div class="d-flex">
                          <div class="btn btn-primary btn-round btn-file">
                            <span>Choose file</span>
                            <input type="file" name="pkg_image" id="pkg_image">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Package Price</label>
                      <input type="text" id="pkg_price" name="pkg_price" class="form-control" value="{{ $package->pkg_price }}">
                    </div>
                  </div>
                  <div class="col-md-2">
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
  <script type="text/javascript">
    $('form[id="EditPackage"]').validate({
      rules: {
        pkg_name: {
          required: true
        },
        pkg_descp: {
          required: true
        },
        pkg_price: {
          required: true,
          number: true,
          min: 1
        }
      }
    });
  </script>

  @endsection