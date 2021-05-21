        @extends('admin.layouts.master')

        @section('th_head')

        @endsection

        @section('content')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-header card-header-warning">
                              <h3 class="card-title">Add new page
                                <div class="float-right">
                                  <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                                    <?php @langOption(); ?>
                                  </select>
                                    <a href="{{ route('admin.pages')}}" class="btn-sm btn-success btn-round "> 
                                    <i class="material-icons">library_books</i> List</a>
                                </div>
                              </h3>

                            </div>
                            <div class="card-body">
                              <form id="AddNewPage" method="post" action="{{ route('admin.pages.doadd') }}">
                               <input type="hidden" id="lang_code" name="locale" value="en">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label class="bmd-label-floating">Page title</label>
                                          <input type="text" id="page_title" name="page_title" class="form-control">
                                          <div>Page slug: <span id="page_slug_lebel"></span></div> 
                                          <input type="hidden" id="page_slug" name="page_slug" value="">
                                        </div>
                                      </div>
                                  
                                   </div>
                                   <div class="row">
                                      <div class="col-md-9">
                                         <div class="row">
                                             <div class="col-md-2"></div>
                                             <div class="col-md-4">
                                               <div class="form-group float-right">
                                                  <label class="bmd-label-floating">Page template</label>
                                                    <select id="template" name="template" class="browser-default   custom-select">
                                                        <!--<option value="home">Home template</option>
                                                        <option value="about">About Tempmate</option>
                                                        <option value="contact">Contact Tempmate</option>-->
                                                        <option value="custom">Custom Template</option>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-group float-right">
                                                  <label class="bmd-label-floating">Status</label>
                                                    <select id="status" name="status" class="browser-default   custom-select">
                                                        <option value="1">Active</option>
                                                        <option value="2">De-active</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group float-right">
                                                  <label class="bmd-label-floating">Show In </label>
                                                     <select id="show_in" name="show_in" class="browser-default   custom-select">
                                                        <option value="none">Select show in </option>
                                                        <option value="header">Header</option>
                                                        <option value="footer">Footer</option>
                                                    </select>
                                                </div>
                                            </div>
                                         </div>
                                      </div>
                                      <div class="col-md-3">
                                         <div class="form-group float-right">
                                            <button type="submit" class="btn btn-success btn-rounded btn-sm waves-effect waves-light"> NEXT </button>
                                            <div class="clearfix"></div>
                                          </div>
                                     </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" ></script>
    <script src="{{ asset('backend/assets/js/pages.js') }}"></script>
    @endsection