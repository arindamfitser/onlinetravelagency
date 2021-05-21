@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Amenities
                    <div class="float-right">
                        <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>
                        <a href="{{ route('admin.amenities.add') }}" class="btn-sm btn-success btn-round "> 
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
                            @foreach($amenities as $amenitie)
                            @if($amenitie->locale == $lang)
                            <tr>
                                <td>{{ $amenitie->amenities_name }}</td>
                                <td>{{ $amenitie->created_at }}</td>
                                <td class="text-primary">
                                    <a href="{{ route('admin.amenities.edit', ['lang' => $amenitie->locale, 'id' => $amenitie->id]) }}" title="Edit">
                                     <i class="fa fa-edit"></i>
                                    </a>
                                
                                 <form id="delete-form-{{ $amenitie->id }}" method="post" action="{{ route('admin.amenities.del', ['lang' => $amenitie->locale, 'id' => $amenitie->id]) }}" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                <a href="javascript:void(0);" onclick="swal({
                                    title: 'Are you sure?',
                                    text: 'Once deleted, you will not be able to recover this!',
                                    icon: 'warning',
                                    buttons: true,
                                    dangerMode: true,
                                }).then((willDelete) => {if(willDelete){event.preventDefault();document.getElementById('delete-form-{{ $amenitie->id }}').submit();}else{}});" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    @endif
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