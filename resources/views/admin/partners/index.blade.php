@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Our Partners 
                    <div class="float-right">
                        <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>
                        <a href="{{ route('admin.partners.add') }}" class="btn-sm btn-success btn-round "> 
                            <i class="material-icons">create</i> New</a>
                        </div>

                    </div>

                    <div class="card-body table-responsive">
                       @include('admin.layouts.messages')
                       <table class="table" id="order-listing">
                        <thead class=" text-primary"> 
                            <th>Title</th>
                            <th>Image</th>
                            <th>URL</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $lang = @\Session::get('language');
                            ?>
                            @foreach($partners as $partner)
                            <tr>
                                <td>{{ $partner->title }}</td>
                                <td><img src="{{ Storage::disk('local')->url($partner->image) }}" alt="" width="80px" height="80px"></td>
                                <td>{{ $partner->link}}</td>
                                <td>{{ $partner->created_at}}</td>
                                <td class="text-primary">
                                 <a href="{{ route('admin.partners.edit', ['id' => $partner->id]) }}" title="Edit">
                                     <i class="fa fa-edit"></i>
                                 </a>
                                 @if($partner->status==1)
                                 <a href="{{ route('admin.partners.status', ['id' => $partner->id,'status' => '2']) }}" style="color:#4caf50" title="Published">
                                   <i  class="fa fa-toggle-on" aria-hidden="true"></i>
                                 </a>
                                 @else
                                <a href="{{ route('admin.partners.status', ['id' => $partner->id,'status' => '1']) }}" style="color:red" title="Draft">
                                   <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                </a>
                                @endif
                               <form id="delete-form-{{ $partner->id }}" method="post" action="{{ route('admin.partners.del', ['id' => $partner->id]) }}" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              </form>
                            <a href="javascript:void(0);" onclick="swal({
                                title: 'Are you sure?',
                                text: 'Once deleted, you will not be able to recover this!',
                                icon: 'warning',
                                buttons: true,
                                dangerMode: true,
                            }).then((willDelete) => {if(willDelete){event.preventDefault();document.getElementById('delete-form-{{ $partner->id }}').submit();}else{}});" title="Delete">
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