@extends('admin.layouts.master')
@section('th_head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
<style>
    .green-check-icon {
        color: green;
    }

    .red-check-icon {
        color: red;
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">{{ $hotel ->hotels_name }} Rooms 
                    <div class="float-right">
                        <a href="{{ route('admin.invited.hotel.rooms.add', ['code' => $code]) }}" class="btn btn-success pull-right"><i class="fa fa-plus"
                                aria-hidden="true"></i> Add Room</a>
                    </div>
                </h3>
            </div>
            <div class="card-body table-responsive">
                @include('admin.layouts.messages')
                <table class="table table-bordered table-hover" id="roomsTable">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total Room</th>
                            <th scope="col">Availablity</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $key => $room)
                        <tr>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->base_price }}</td>
                            <td>
                                <span class="badge">{{ $room->room_capacity }}</span>
                            </td>
                            <td>
                                <a href="javascript:void(0);" data-id="{{ $room->id }}" class="status-change" data-key="id"
                                    data-table="rooms" data-url="{{ route('common.change.status') }}" data-stat="availability"
                                    data-change-status="<?=($room->availability) ? '0' : '1'?>" title="Green: Active, Red: InActive">
                                    <?=($room->availability) ? '<i class="fa fa-check green-check-icon" aria-hidden="true"></i>' : '<i class="fa fa-times red-check-icon" aria-hidden="true"></i>'?>
                                </a>
                            </td>
                            <td>
                                <?php if($room->featured_image != NULL ||!empty($room->featured_image)): ?>
                                <img src="{{ url('public/uploads/' . $room->featured_image)}}" alt="{{ $room->name }}"
                                    style="height: 100px; width:auto;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- <a href="{{ route('user.hotels.rooms.price', ['id' => $room->id]) }}" class="btn btn-primary" title="Price"><i class="fa fa-usd" aria-hidden="true"></i></a>&nbsp; -->
                                <a href="{{ route('admin.invited.hotel.rooms.edit', ['id' => $room->id]) }}" class="btn btn-info"
                                    title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;
                                <form id="delete-form-{{ $room->id }}" method="post"
                                    action="{{ route('user.hotels.rooms.delroom', $room->id) }}" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                <a href="javascript:void(0);"
                                    onclick="if(confirm('Are you sure, You want to delete this?')){event.preventDefault();document.getElementById('delete-form-{{ $room->id }}').submit();}else{event.preventDefault();}"
                                    class="btn btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i>
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
<!-- modal end -->
</div>
</div>
</div>
@endsection
@section('th_foot')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#roomsTable').DataTable({
            pageLength: 10,
            searching: true,
        });
    });
$(document).on("click", ".status-change", function () {
	let module      = this;
    let id          = $(this).attr("data-id");
    let table       = $(this).attr("data-table");
    let tableKey    = $(this).attr("data-key");
    let status      = $(this).attr("data-change-status");
    let statusKey   = $(this).attr("data-stat");
    $.ajax({
        type    : "POST",
        url     : $(this).attr("data-url"),
        data    : {
            "_token"    : "{{ csrf_token() }}",
            "id"        : id,
            "table"     : table,
            "tableKey"  : tableKey,
            "status"    : status,
            "statusKey" : statusKey
        },
        dataType    : "JSON",
        success : function (resultData) {
            $(module).html(resultData.html);
            if(status == '1'){
                $(module).attr("data-change-status", '0');
            }else{
                $(module).attr("data-change-status", '1');
            }
            swalAlert("Status Changed Successfully !!!", "success", 5000);
        },
    });
});
</script>
@endsection