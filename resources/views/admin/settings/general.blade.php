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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
@endsection
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h3 class="card-title">General Settings
            <div class="float-right">
              <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                <?php @langOption(); ?>
              </select>
            </div>
            </h3>
          </div>
          <div class="card-body">
            @include('admin.layouts.messages')
            <?php
            $lang = @\Session::get('language');
            ?>
            <form id="GeneralSettings" method="post" action="{{ route('admin.settings.general.save', ['lang' => $lang]) }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" id="lang_code" name="locale" value="en">
              <div class="row">
                <div class="col-md-8">
                <!-- Start Site General Setup -->
                  <div class="form-group">
                    <label class="bmd-label-floating">Site Title</label>
                    <input type="text" id="blogname" name="blogname" class="form-control" value="<?php echo get_option('blogname'); ?>">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Site Description</label>
                    <textarea id="blogdescription" name="blogdescription" class="form-control"><?php echo get_option('blogdescription'); ?></textarea>
                  </div>
                  
                  <div class="form-group" style="display:none;">
                    <label class="bmd-label-floating">Site Logo</label>
                    <div class="file-field">
                      <div class="z-depth-1-half mb-4">
                        @if(get_option('site_logo'))
                        <img src="{{ Storage::disk('local')->url(get_option('site_logo')) }}" class="img-fluid" alt="example placeholder" width="100px" height="100px">
                        @endif
                      </div>
                      <div class="d-flex">
                        <div class="btn btn-primary btn-round btn-file" >
                          <span>Choose file</span>
                          <input type="file" name="site_logo" id="site_logo">
                        </div>
                      </div>
                    </div>
                  </div>

                   <div class="form-group">
                    <label class="bmd-label-floating">Site Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo get_option('phone'); ?>">
                  </div>
                   <div class="form-group">
                    <label class="bmd-label-floating">Site Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?php echo get_option('email'); ?>">
                  </div>
                   <div class="form-group">
                    <label class="bmd-label-floating">Site Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo get_option('address'); ?>">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Currency</label>
                    <select class="form-control" name="currency">
                    @foreach($currency as $c)
                     <option value="{{$c->code}}" @if(get_option('currency') == $c->code){{ 'selected' }}@else{{ '' }}@endif><?php echo $c->code; ?></option>
                    @endForeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="bmd-label-floating">Global Commission(%)</label>
                    <input type="text" id="commission" name="commission" class="form-control" value="<?php echo get_option('commission'); ?>">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Markup Price(%)</label>
                    <input type="text" id="markup_price" name="markup_price" class="form-control" value="<?php echo get_option('markup_price'); ?>">
                  </div>
                  
                  <!-- End Site General Setup -->
                    <div class="form-group">
                      <label class="bmd-label-floating">Post URL</label>
                      <input type="text" id="stuba_post_url" name="stuba_post_url" class="form-control" value="<?php echo get_option('stuba_post_url'); ?>">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Authority Org</label>
                      <input type="text" id="authority_org" name="authority_org" class="form-control" value="<?php echo get_option('authority_org'); ?>">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Authority User</label>
                      <input type="text" id="authority_user" name="authority_user" class="form-control" value="<?php echo get_option('authority_user'); ?>">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Authority Password</label>
                      <input type="text" id="authority_password" name="authority_password" class="form-control" value="<?php echo get_option('authority_password'); ?>">
                    </div>
                  <!-- Start Rooms XML Setup -->
                  
                  <!--Start Paypal Pro Setup-->
                    <div class="form-group">
                      <label class="bmd-label-floating">Paypal Mode</label>
                      <input type="radio" id="paypal_mode" name="paypal_mode"  <?php echo (get_option('paypal_mode')=='sandbox'?'checked="checked"':''); ?>  value="sandbox"> Sandbox
                      <input type="radio" id="paypal_mode" name="paypal_mode"  <?php echo (get_option('paypal_mode')=='live'?'checked="checked"':''); ?> value="live"> Live
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Paypal Username</label>
                      <input type="text" id="paypal_username" name="paypal_username" class="form-control" value="<?php echo get_option('paypal_username'); ?>">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Paypal Password</label>
                      <input type="text" id="paypal_password" name="paypal_password" class="form-control" value="<?php echo get_option('paypal_password'); ?>">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Paypal Signature</label>
                      <input type="text" id="paypal_signature" name="paypal_signature" class="form-control" value="<?php echo get_option('paypal_signature'); ?>">
                    </div>
                  <!-- End Paypal Pro Setup -->

                  <!-- ENd Rooms XML Setup -->

                  <!-- Start Social Setup -->
                    <div class="form-group">
                      <label class="bmd-label-floating">Facebook Link</label>
                      <input type="text" id="facebook_link" name="facebook_link" class="form-control" value="<?php echo get_option('facebook_link'); ?>">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Instagram Link</label>
                      <input type="text" id="instagram_link" name="instagram_link" class="form-control" value="<?php echo get_option('instagram_link'); ?>">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating">Pinterest Link</label>
                      <input type="text" id="pinterest_link" name="pinterest_link" class="form-control" value="<?php echo get_option('pinterest_link'); ?>">
                    </div>
                  <!-- End Social Setup -->

                </div>

                
                <div class="col-md-4">
                  <!-- right section -->
                  <div class="form-group">
                  <!-- <label class="bmd-label-floating">Header Menu</label>
                     <select class="form-control" name="header_menu_opt[]" id="header_menu_opt" multiple>
                        <option value="/">Home</option>
                        <option value="destinations">Destinations</option>
                        <option value="accommodation-types">Accommodation Types</option>
                        <option value="experiences">Experiences</option>
                        <option value="inspirations">Inspirations</option>
                        <option value="target-species">Target Species</option>
                        <option value="journal">Journal</option>
                      </select>-->
                   
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success btn-rounded btn-sm waves-effect waves-light"> Save </button>
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