<!DOCTYPE html>
<?php 
  //var_dump($page->template);
   $pageinfo = $page->translate();
  //var_dump($pageinfo->page_description);
 ?>

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>OTA Admin - Page Content Editor</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/keditor/sample/plugins/bootstrap-3.3.6/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/keditor/sample/plugins/font-awesome-4.5.0/css/font-awesome.min.css')}}" />
        <!-- Start of KEditor styles -->
        <script type="text/javascript"> var asset_url = "{{ asset('/')}}"; </script>
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/keditor/dist/css/keditor.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/keditor/dist/css/keditor-components.min.css')}}" />
        <!-- End of KEditor styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/keditor/sample/plugins/code-prettify/src/prettify.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/keditor/sample/css/examples.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/assets/css/loader.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet" />
       
        <script type="text/javascript">
          var base_url = "<?php echo asset('/');  ?>";
          var ajax_url = "{{route('admin.pages.update')}}";
          var ajax_prevew_url = "{{route('admin.pages.update')}}";
          var page_id  = "{{$page->id}}";
          var token   =  "{{ csrf_token()}}";
        </script>
        <style>
            #page_title_updtz {
                width: 100%;
                padding: 5px;
            }
            #page_status{
               padding: 5px;
               width: 100%; 
            }
            #page_template{
               padding: 5px;
               width: 100%; 
            }
             #page_show_in{
               padding: 5px;
               width: 100%; 
            }
        </style>
    </head>
    <body>
     <div class="loader">
        <div class="loader08"></div>
     </div>
        <!--<div class="action">
            <button class="button">Update</button>
            <button class="button">View</button>
            <button class="button">Red</button>
        </div> -->
       
        <div data-keditor="html" style="border:1px;">
            <!--<h1 style="margin-top:30px"><?php echo $pageinfo->page_title ; ?></h1>-->
            <div style="margin-top: 35px;font-size:16px;padding: 0 30px;">
                    <div class="row">
                         <div class="col-md-9">
                              <div class="form-group float-left">
                                <label>Page Title</label>
                                <input type="text" value="<?php echo $pageinfo->page_title ; ?>" id="page_title_updtz">
                              </div>
                        </div>
                  </div>
                  <div class="row">
                    <div class="col-md-9">
                         <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group float-left">
                                      <label class="bmd-label-floating">Page template</label>
                                           <select id="page_template" name="page_template" class="browser-default   custom-select">
                                                <option value="custom" <?php echo ($page->status=='template'?'selected="selected"':''); ?>>Custom Template</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group float-left">
                                        <label class="bmd-label-floating">Status</label>
                                            <select id="page_status" name="page_status" class="browser-default   custom-select">
                                                <option value="1" <?php echo ($page->status==1?'selected="selected"':''); ?>>Active</option>
                                                <option value="2" <?php echo ($page->status==2?'selected="selected"':''); ?>>De-active</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group float-left">
                                        <label class="bmd-label-floating">Show In </label>
                                                <select id="page_show_in" name="page_show_in" class="browser-default   custom-select">
                                                    <option value="none">Select show in </option>
                                                    <option value="header" <?php echo ($page->show_in=='header'?'selected="selected"':''); ?>>Header</option>
                                                    <option value="footer" <?php echo ($page->show_in=='footer'?'selected="selected"':''); ?>>Footer</option>
                                                </select>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            </div>
            
           @if($pageinfo->page_description)
              <div id="content-area" >
                <?php echo $pageinfo->page_description ; ?>
              </div>
            @else
              @if($page->template =='custom')         
               <div id="content-area">
                 <section><div class="row"><div class="col-md-12" data-type="container-content"><section data-type="component-text">New content</section></div></div></section>
               </div>   
               @else            
              @endif
            @endif  
             
        </div>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/jquery-1.11.3/jquery-1.11.3.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/bootstrap-3.3.6/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/jquery.nicescroll-3.6.6/jquery.nicescroll.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/ckeditor-4.5.6/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/ckeditor-4.5.6/adapters/jquery.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/formBuilder-2.5.3/form-builder.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/formBuilder-2.5.3/form-render.min.js')}}"></script>
        <!-- Start of KEditor scripts -->
        <script type="text/javascript" src="{{ asset('backend/keditor/dist/js/keditor.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/dist/js/keditor-components.min.js')}}"></script>

        <!-- End of KEditor scripts -->
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/code-prettify/src/prettify.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/js-beautify-1.7.5/js/lib/beautify.js')}}"></script>
        <script type="text/javascript" src="{{ asset('backend/keditor/sample/plugins/js-beautify-1.7.5/js/lib/beautify-html.js')}}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" ></script>
        <script type="text/javascript" src="{{ asset('backend/assets/js/keditor.js')}}" data-keditor="script"></script>
        <style type="text/css">
        .keditor-content-area {
          background-color: #f0f0f0;
          border: 1px solied #000;
         }
    
        </style>

    </body>
</html>
