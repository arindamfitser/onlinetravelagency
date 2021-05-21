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
                              <h3 class="card-title">Add new posts
                                <div class="float-right">
                                  <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                                    <?php @langOption(); ?>
                                  </select>
                                    <a href="{{ route('admin.posts')}}" class="btn-sm btn-success btn-round "> 
                                    <i class="material-icons">library_books</i> List</a>
                                </div>
                              </h3>

                            </div>
                            <div class="card-body">
                              <form id="AddNewPost" method="post" action="{{ route('admin.posts.doadd') }}">
                               <input type="hidden" id="lang_code" name="locale" value="en">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-7">
                                    <div class="form-group">
                                      <label class="bmd-label-floating">Post title</label>
                                      <input type="text" id="post_title" name="post_title" class="form-control">
                                      
                                      <div>Post slug: <span id="post_slug_lebel"></span></div> 
                                      <input type="hidden" id="post_slug" name="post_slug" value="">
                                    </div>
                                  </div>

                                   <div class="col-md-3">
                                    <div class="form-group float-right">
                                      <label class="bmd-label-floating">Post Status</label>
                                        <select id="status" name="status" class="browser-default   custom-select">
                                            <option value="1">Published</option>
                                            <option value="2">Draft</option>
                                            <option value="3">De-active</option>
                                        </select>
                                    </div>
                                  </div>
                                  
                                </div>
                                  
                                </div>

                                <div class="col-md-12">
                                 <div class="row">
                                   <div class="col-md-10">
                                     <div class="form-group float-right">
                                       <label class="bmd-label-floating">Post content</label>
                                         
                                         <textarea id='edit' class="form-control" name="post_description">
                                            <div id="editor">
                                                <div  style="margin-top: 30px;">
                                                  <h1>Sample Post</h1>
                                                  <p>Init on click improves the page performance by initializing only the basic code when the page is loaded and the rest of the code when clicking in the editable area. It is highly recommended to use the <a href="https://www.froala.com/wysiwyg-editor/docs/options#initOnClick" target="_blank" title="initOnClick option">initOnClick</a> option if you have more rich text editors on the same page.</p>
                                                  <p><strong>Click here to initialize the WYSIWYG HTML editor on this text.</strong></p>
                                                </div>
                                            </div>
                                        </textarea>
                                    </div>
                                  </div>
                                </div>
                                  
                                </div>
                                  

                                </div>
                                <button type="submit" class="btn btn-success btn-rounded btn-sm waves-effect waves-light"> Published </button>
                                <div class="clearfix"></div>
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