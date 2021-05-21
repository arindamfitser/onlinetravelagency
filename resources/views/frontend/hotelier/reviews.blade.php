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
        <h1>All Reviews</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="user_panel">
                    <table class="table table-bordered table-hover" id="reviewTable">
                        <thead>
                            <tr>
                                <th scope="col">User Name</th>
                                <th scope="col">User Email</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Rating</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($dData->hotelreviews as $hotelreviews):
                            foreach($hotelreviews as $hotelreview):
                                $users = get_user_details($hotelreview->user_id);
                        ?>
                                <tr>
                                    <td>{{ $users->first_name }} {{ $users->last_name }}</td>
                                    <td>{{ $users->email }}</td>
                                    <td>{{ $hotelreview->subjects }}</td>
                                    <td>{{ $hotelreview->comments }}</td>
                                    <td>
                                    <?php
                                    for ($i=0; $i < $hotelreview->rating ; $i++) :
                                        print '<i class="fa fa-star"></i>';
                                    endfor;
                                    ?>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" data-id="{{ $hotelreview->id }}" class="status-change" data-key="id" data-table="reviews" data-url="{{ route('common.change.status') }}" data-stat="status" data-change-status="<?=($hotelreview->status) ? '0' : '1'?>" title="Green: Approved, Red: Disapproved">
                                            <?=($hotelreview->status) ? '<i class="fa fa-check green-check-icon" aria-hidden="true"></i>' : '<i class="fa fa-times red-check-icon" aria-hidden="true"></i>'?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" data-id="{{ $hotelreview->id }}" class="btn btn-danger deleteRow" title="Delete"><i class="fa fa-trash"></i></a>
                                        <form id="delete-form-{{ $hotelreview->id }}" method="post" action="{{ route('users.hotels.reviews.delete', $hotelreview->id) }}" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            endforeach;
                        endforeach;
                        ?>
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
    //$('#hotel').DataTable();
    $('#reviewTable').DataTable({
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
$(document).on("click", ".deleteRow", function () {
	Swal.fire({
		title: "Are you sure want to delete review?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#dd6b55",
		cancelButtonColor: "#48cab2",
		confirmButtonText: "Yes !!!",
	}).then((result) => {
		if (result.value) {
		    event.preventDefault();
		    let removeId = $(this).attr("data-id");
		    $('#delete-form-' + removeId).submit();
		}
	});
});
</script>
@endsection