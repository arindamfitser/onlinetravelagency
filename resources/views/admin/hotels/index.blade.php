@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Direct Contract Module
                    <div class="float-right">
                        <!--<select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>-->
                        <a href="#" class="btn-sm btn-info btn-round " data-toggle="modal" data-target="#csvuploadmodal"> 
                            <i class="material-icons">backup</i> Upload CSV</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                     @include('admin.layouts.messages')
                     <table class="table" id="order-listing">
                        <thead class=" text-primary"> 
                            <th>#ID</th>
                            <th>Stuba ID</th>
                            <th>Name</th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>Town</th>
                            <th>Image</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $lang = @\Session::get('language');
                            ?>
                            @foreach($hotels as $hotel)
                            @if($hotel->locale == $lang)
                            <tr>
                                <td>{{ $hotel->id }}</td>
                                <td>{{ $hotel->stuba_id }}</td>
                                <td>{{ $hotel->hotels_name }}</td>
                                <td>{{ $hotel->region->regions_name }}</td>
                                <td>{{ $hotel->country->countries_name }}</td>
                                <td>{{ $hotel->state->states_name }}</td>
                                <td>{{ $hotel->town }}</td>
                                <td><img src="{{ Storage::disk('local')->url($hotel->featured_image) }}" alt="" width="150px"></td>
                                <td class="text-primary">
                                    <a href="{{ route('admin.hotels.edit', ['lang' => $hotel->locale, 'id' => $hotel->id]) }}" title="Edit">
                                       <i class="fa fa-edit"></i>
                                   </a>

                                   <form id="delete-form-{{ $hotel->id }}" method="post" action="{{ route('admin.hotels.del', ['lang' => $hotel->locale, 'id' => $hotel->id]) }}" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                <!-- <a href="javascript:void(0);" onclick="swal({
                                    title: 'Are you sure?',
                                    text: 'Once deleted, you will not be able to recover this!',
                                    icon: 'warning',
                                    buttons: true,
                                    dangerMode: true,
                                }).then((willDelete) => {if(willDelete){event.preventDefault();document.getElementById('delete-form-{{ $hotel->id }}').submit();}else{}});" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a> -->
                            <a href="{{ route('admin.hotels.rooms', ['lang' => $hotel->locale,'id' => $hotel->id]) }}"><i class="fa fa-home" title="Rooms"></i></a>
                            <!-- <a href="{{ route('admin.hotels.packages', ['id' => $hotel->id]) }}"><i class="fa fa-list" title="Packages"></i></a> -->
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- modal start -->
        <div class="modal fade" id="csvuploadmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-small ">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
            </div>
            <form action="{{ route('admin.hotels.uploadcsv') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body text-center">
                    <div class="form-group">
                        <label class="bmd-label-floating">Upload CSV</label>
                        <span class="btn btn-primary btn-round btn-file">
                          <span class="fileinput-new">Choose file</span>
                          <input type="file" name="upload_csv" id="upload_csv" />
                      </span>
                  </div>
              </div>
              <div class="modal-footer text-center">
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- modal end -->

</div>
</div>
</div>

@endsection
@section('th_foot')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

@endsection