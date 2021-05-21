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
            <h3 class="card-title">Edit User
              <div class="float-right">
                <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                  <?php @langOption(); ?>
                </select>
                <a href="{{ route('admin.users')}}" class="btn-sm btn-success btn-round ">
                  <i class="material-icons">library_books</i> List</a>
                </div>
              </h3>
            </div>
            <div class="card-body">
              @include('admin.layouts.messages')
              <?php $lang = @\Session::get('language');?>
              <form id="EditSpecies" method="post" action="{{route('admin.user.update')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="lang_code" name="locale" value="en">
                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                <div class="row">
                  <div class="col-md-10">
                  <h3>Update user details</h3>
                      <div class="form-group">
                        <label class="bmd-label-floating">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" disabled="disabled">
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                        <label class="bmd-label-floating">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->last_name }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Email</label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}" disabled="disabled">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Mobile</label>
                        <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="{{ $user->mobile_number }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Gender</label>
                         <select id="country_code" class="form-control" name="gender">
                          <option value="male"> Male</option>
                          <option value="female"> Female</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">DOB</label>
                        <input type="text" id="dob" name="dob" class="form-control" value="{{ $user->dob }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Country</label>
                        <select id="country_code" class="form-control" name="country_code">
                          <option>---Please Select---</option>
                          <?php @countryOption($user->country_code); ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Address</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{ $user->address }}">
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-10">
                    <button type="submit" class="btn btn-success btn-rounded btn-sm waves-effect waves-light"> Update details </button>
                  </div>
                </div>
              </form>

              <form id="EditUserpass" method="post" action="{{route('admin.user.updatepass')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="lang_code" name="locale" value="en">
                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                <div class="row">
                  <div class="col-md-10">
                   <h3>Change password</h3>
                      <div class="form-group">
                        <label class="bmd-label-floating">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" disabled="disabled">
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                        <label class="bmd-label-floating">Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Confirm password</label>
                        <input type="password" id="cpassword" name="cpassword" class="form-control" value="">
                      </div>
                    </div>
                  </div>
                  
                
                 <div class="row">
                   <div class="col-md-10">
                    <button type="submit" class="btn btn-success btn-rounded btn-sm waves-effect waves-light"> Change password </button>
                   </div>
                 </div>
               </form>

              </div>
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