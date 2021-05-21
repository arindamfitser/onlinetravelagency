@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')
   
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h3 class="card-title ">Pages management 
                                <div class="float-right">
                                    <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                                    <?php @langOption(); ?>
                                  </select>
                                    <a href="{{route('admin.pages.add') }}" class="btn-sm btn-success btn-round "> 
                                    <i class="material-icons">create</i> New</a>
                                </div>

                        </div>
                        <div class="card-body table-responsive">
                           @include('admin.layouts.messages')
                            <table class="table" id="order-listing">
                                <thead class=" text-primary"> 
                                    <th>ID</th>
                                    <th>Page Title</th>
                                    <th>Page Slug</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php $lang = @\Session::get('language'); ?>
                                @foreach ($pages as $page)

                                  <?php 
                                  if($page->locale==$lang){  ?>
                                    <tr>
                                        <td>{{ $page->id }}</td>
                                        <td>{{ $page->page_title }}</td>
                                        <td>{{ $page->page_slug }}</td>
                                        <td>{{ $page->created_at}}</td>
                                        <td class="text-primary">
                                            <!-- <a href="javascript:void(0);" onclick="openNav()">
                                               <i class="fa fa-cog"></i>
                                            </a> -->

                                            <a href="{{ route('admin.pages.edit', ['lang' => $page->locale, 'id' => $page->id]) }}">
                                               <i class="fa fa-edit"></i>
                                            </a>
                                            @if($page->status==1)
                                              <a href="{{ route('admin.pages.change', ['lang' => $page->locale, 'id' => $page->id,'st' => '2']) }}" style="color:#4caf50">
                                                 <i  class="fa fa-toggle-on" aria-hidden="true"></i>
                                             </a>
                                             @else
                                             <a href="{{ route('admin.pages.change', ['lang' => $page->locale, 'id' => $page->id,'st' => '1']) }}" style="color:red">
                                                 <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                             </a>
                                             @endif
                                            <a href="{{ route('admin.pages.del', ['lang' => 'en', 'id' => $page->id]) }}">
                                               <i class="fa fa-trash" aria-hidden="true"></i>
                                           </a>
                                        </td>
                                      </tr>
                                      <?php } ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
           
@endsection
@section('th_foot')

@endsection