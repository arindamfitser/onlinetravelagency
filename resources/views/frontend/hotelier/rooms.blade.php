@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<style>
    .green-check-icon{
        color : green;
    }
    .red-check-icon{
        color : red;
    }
</style>
@endsection
@section('content')
<section class="profile dashboard hometop_gap">
    @include('frontend.layouts.hotelier_sidenav')
    <div class="dashboard_content">
        <h1>Rooms</h1>
        @include('frontend.layouts.messages')
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ route('user.hotels.rooms.add', ['id' => $id]) }}" class="btn btn-success pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Room</a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <div class="user_panel">
                    <table class="table table-bordered table-hover" id="roomsTable">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total No. of Room</th>
                                <th scope="col">Total Available Rooms Today</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $key => $room)
                            <?php
                            $rc         = App\RoomCount::where('room_id', $room->id)->where('dt', date('Y-m-d'))->first();
                            $booked     = 0;
                            $avlbl      = (!empty($rc)) ? $rc->count : $room->room_capacity;
                            $chk        = App\BookingItem::select('id', 'quantity_room')->where('room_id', $room->id)->where('status', 1)
                                        ->where('check_in', date('Y-m-d'))->get()->all();
                            if(!empty($chk)):
                                foreach($chk as $c):
                                    $booked += $c->quantity_room;
                                endforeach;
                                $avlbl  -= $booked;
                            endif;
                            ?>
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->base_price }}</td>
                                <td>
                                    <span class="badge">{{ $room->room_capacity }}</span>
                                </td>
                                <!--<td>
                                    <a href="javascript:void(0);" data-id="{{ $room->id }}" class="status-change" data-key="id" data-table="rooms" data-url="{{ route('common.change.status') }}" data-stat="availability" data-change-status="<?=($room->availability) ? '0' : '1'?>" title="Green: Active, Red: InActive">
                                        <?=($room->availability) ? '<i class="fa fa-check green-check-icon" aria-hidden="true"></i>' : '<i class="fa fa-times red-check-icon" aria-hidden="true"></i>'?>
                                    </a>
                                </td> -->
                                <td>{{ $avlbl }}</td>
                                <td>
                                    <?php if($room->featured_image != NULL ||!empty($room->featured_image)): ?>
                                    <img src="{{ url('public/uploads/' . $room->featured_image)}}" alt="{{ $room->name }}"
                                        style="height: 100px; width:auto;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- <a href="{{ route('user.hotels.rooms.price', ['id' => $room->id]) }}" class="btn btn-primary" title="Price"><i class="fa fa-usd" aria-hidden="true"></i></a>&nbsp; -->
                                    <a href="{{ route('user.hotels.rooms.edit', ['id' => $room->id]) }}" class="btn btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;
                                        <form id="delete-form-{{ $room->id }}" method="post" action="{{ route('user.hotels.rooms.delroom', $room->id) }}" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    <a href="javascript:void(0);" onclick="if(confirm('Are you sure, You want to delete this?')){event.preventDefault();document.getElementById('delete-form-{{ $room->id }}').submit();}else{event.preventDefault();}" class="btn btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    //$('#rooms').DataTable();
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
            swalAlert("Status Changed Successfully !!!", "success");
        },
    });
});
</script>
@endsection