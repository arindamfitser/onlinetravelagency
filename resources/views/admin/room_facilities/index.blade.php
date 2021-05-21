@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Room Facilities
                    <div class="float-right">
                        <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>
                        <a href="{{ route('admin.room_facilities.add') }}" class="btn-sm btn-success btn-round "> 
                            <i class="material-icons">create</i> New</a>
                    </div>
                    </div>
                    <div class="card-body table-responsive">
                       @include('admin.layouts.messages')
                       <table class="table" id="order-listing">
                        <thead class=" text-primary"> 
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $lang = @\Session::get('language');
                            ?>
                            @foreach($roomfacility as $roomf)
                            <tr>
                                <td>{{ $roomf->name }}</td>
                                <td>{{ $roomf->created_at }}</td>
                                <td class="text-primary">
                                    <a href="{{ route('admin.room_facilities.edit', ['id' => $roomf->id]) }}" title="Edit">
                                       <i class="fa fa-edit"></i>
                                   </a>
                                   <form id="delete-form-{{ $roomf->id }}" method="post" action="{{ route('admin.room_facilities.del', ['id' => $roomf->id]) }}" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                <a href="javascript:void(0);" onclick="swal({
                                    title: 'Are you sure?',
                                    text: 'Once deleted, you will not be able to recover this!',
                                    icon: 'warning',
                                    buttons: true,
                                    dangerMode: true,
                                }).then((willDelete) => {if(willDelete){event.preventDefault();document.getElementById('delete-form-{{ $roomf->id }}').submit();}else{}});" title="Delete">
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