@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')
<?php $lang = @\Session::get('language'); ?>
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h3 class="card-title ">Packages
          <div class="float-right">
            <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
              <?php @langOption(); ?>
            </select>
            <a href="{{ route('admin.hotels.packages.add', ['id' => $id]) }}" class="btn-sm btn-info btn-round "> 
              <i class="material-icons">add</i> Add Package</a>
            </div>
          </div>
          <div class="card-body table-responsive">
           @include('admin.layouts.messages')
           <table class="table" id="order-listing">
            <thead class=" text-primary"> 
             <tr>
              <th scope="col">Name</th>
              <th scope="col">Image</th>
              <th scope="col">Price</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
           @foreach($packages as $key => $package)
           <tr>
             <td>{{ $package->pkg_name }}</td>
             <td><img src="{{ Storage::disk('local')->url($package->pkg_image) }}" alt="" width="80px" height="80px"></td>
             <td>{{ $package->pkg_price }}</td>
             <td>
              <a href="{{ route('admin.hotels.packages.edit', ['id' => $package->id]) }}" class="btn btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
              <form id="delete-form-{{ $package->id }}" method="post" action="{{ route('admin.hotels.packages.del', ['id' => $package->id]) }}" style="display: none;">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
              </form>
              <a href="javascript:void(0);" onclick="swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
              }).then((willDelete) => {if(willDelete){event.preventDefault();document.getElementById('delete-form-{{ $package->id }}').submit();}else{}});" title="Delete" class="btn btn-danger">
              <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
@endsection
@section('th_foot')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

@endsection
