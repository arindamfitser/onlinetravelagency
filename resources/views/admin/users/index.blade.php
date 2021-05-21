@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Users management 
                    <div class="float-right">
                        <a href="" class="btn-sm btn-success btn-round "> 
                            <i class="material-icons">create</i> New</a>
                        </div>

                    </div>
                    <div class="card-body table-responsive">
                        <table class="table" id="order-listing">
                            <thead class=" text-primary"> 
                                <th>Username</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>Action</th>
                            </thead>
                            <tbody>

                                @foreach ($users as $user)  
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at}}</td>
                                    <td class="text-primary">
                                     <a href="{{ route('admin.user.edit', $user->id) }}">
                                         <i class="fa fa-edit"></i>
                                     </a>
                                     <form id="delete-form-{{ $user->id }}" method="post" action="{{ route('admin.user.del', $user->id) }}" style="display: none;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <a href="javascript:void(0);" onclick="swal({
                                        title: 'Are you sure?',
                                        text: 'Once deleted, you will not be able to recover this!',
                                        icon: 'warning',
                                        buttons: true,
                                        dangerMode: true,
                                    }).then((willDelete) => {if(willDelete){event.preventDefault();document.getElementById('delete-form-{{ $user->id }}').submit();}else{}});" title="Delete">
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