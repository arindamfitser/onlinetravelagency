@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')
<?php $lang = @\Session::get('language'); ?>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Room
                    <div class="float-right">
                        <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>
                            <a href="{{ route('admin.hotels.rooms.add', ['lang'=>$lang, 'id' => $id]) }}" class="btn-sm btn-info btn-round "> 
                                <i class="material-icons">add</i> Add Room</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                           @include('admin.layouts.messages')
                           <table class="table" id="order-listing">
                            <thead class=" text-primary"> 
                                 <tr>
                                  <th scope="col">Name</th>
                                  <th scope="col">Category/Type</th>
                                  <th scope="col">Capacity</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                        <tbody>
                            
                           @foreach($rooms as $key => $room)
                                <tr>
                                 <td>{{ $room->name }}</td>
                                 <td>{{ getCatByID($room->category) }}</td>
                                 <td>{{ $room->room_capacity }}</td>
                              <td>
                            <!--    <a href="{{ route('admin.hotels.rooms.price', ['lang'=>$lang,'id' => $room->id]) }}" class="btn btn-primary" title="Price"><i class="fa fa-usd" aria-hidden="true"></i></a> -->
                               <a href="{{ route('admin.hotels.rooms.edit', ['lang'=>$lang,'id' => $room->id]) }}" class="btn btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                               <a href="{{ route('admin.hotels.rooms.delroom', ['lang'=>$lang,'id' => $room->id]) }}" class="btn btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
