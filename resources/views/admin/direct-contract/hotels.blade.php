@extends('admin.layouts.master')
@section('th_head')
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Direct Contract Hotels</h3>
                <div class="float-right">
                    {{-- <a href="#" class="btn-sm btn-info btn-round " data-toggle="modal" data-target="#csvuploadmodal"> 
                        <i class="material-icons">backup</i> Upload CSV
                    </a> --}}
                </div>
            </div>
            <div class="card-body table-responsive">
                @include('admin.layouts.messages')
                <table class="table" id="order-listing">
                    <thead class=" text-primary"> 
                        <th>Name</th>
                        <th>Hotel Code</th>
                        <th>Address</th>
                        <th>Town</th>
                        <th>Image</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $lang = @\Session::get('language');
                        if(!empty($hotels)) :
                            foreach($hotels as $hotel):
                        ?>
                                <tr>
                                    <td>{{ $hotel->hotels_name }}</td>
                                    <td>{{ $hotel->hotel_token }}</td>
                                    <td>{{ $hotel->address }}</td>
                                    <td>{{ $hotel->town }}</td>
                                    <td>
                                        <?php if($hotel->featured_image != NULL || !empty($hotel->featured_image)): ?>
                                        <img src="{{ url('public/uploads/' . $hotel->featured_image)}}" alt="{{ $hotel->hotels_name }}"
                                            style="height: 100px; width:auto;">
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-primary">
                                        <a href="{{ route('admin.invited.hotel.details', $hotel->hotel_token) }}" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.invited.hotel.rooms', $hotel->hotel_token) }}" title="Rooms">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                        </a>                                        
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                        else:
                            print '<tr><td colspan="6">No Hotel Found !!!</td></tr>';
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
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