@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Inspirations
                    <div class="float-right">
                        <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>
                        <a href="{{ route('admin.inspirations.add') }}" class="btn-sm btn-success btn-round "> 
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
                            @foreach($inspirations as $inspiration)
                            @if($inspiration->locale == $lang)
                            <tr>
                                <td>{{ $inspiration->inspirations_name }}</td>
                                <td>{{ $inspiration->created_at }}</td>
                                <td class="text-primary">
                                    <a href="{{ route('admin.inspirations.edit', ['lang' => $inspiration->locale, 'id' => $inspiration->id]) }}" title="Edit">
                                     <i class="fa fa-edit"></i>
                                    </a>
                                 @if($inspiration->status==1)
                                 <a href="{{ route('admin.inspirations.status', ['id' => $inspiration->id,'status' => '2']) }}" style="color:#4caf50" title="Published">
                                     <i  class="fa fa-toggle-on" aria-hidden="true"></i>
                                 </a>
                                 @else
                                 <a href="{{ route('admin.inspirations.status', ['id' => $inspiration->id,'status' => '1']) }}" style="color:red" title="Draft">
                                     <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                 </a>
                                 @endif
                                 <form id="delete-form-{{ $inspiration->id }}" method="post" action="{{ route('admin.inspirations.del', ['lang' => $inspiration->locale, 'id' => $inspiration->id]) }}" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                <a href="javascript:void(0);" onclick="swal({
                                    title: 'Are you sure?',
                                    text: 'Once deleted, you will not be able to recover this!',
                                    icon: 'warning',
                                    buttons: true,
                                    dangerMode: true,
                                }).then((willDelete) => {if(willDelete){event.preventDefault();document.getElementById('delete-form-{{ $inspiration->id }}').submit();}else{}});" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                <tbody>
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