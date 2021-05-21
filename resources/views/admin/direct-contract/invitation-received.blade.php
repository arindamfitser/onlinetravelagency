@extends('admin.layouts.master')
@section('th_head')
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Direct Contract Module : {{ucwords(str_replace('-', ' ', $type))}} Invitations
                <div class="float-right"></div>
            </div>
            <div class="card-body table-responsive">
                @include('admin.layouts.messages')
                <table class="table" id="order-listing">
                    <thead class=" text-primary"> 
                        <th>#</th>
                        <th>Hotel Name</th>
                        <th>Hotel Code</th>
                        <th>Hotel Phone</th>
                        <th>Hotel Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if(!empty($received))
                            @foreach($received as $key => $inv)
                                <tr class="inviRow{{$inv->id}}">
                                    <td>{{ ($key + 1) }}</td>
                                    <td>{{ $inv->hotel_name }}</td>
                                    <td>{{ $inv->hotel_code }}</td>
                                    <td>{{ $inv->hotel_phone }}</td>
                                    <td>{{ $inv->hotel_email }}</td>
                                    <td>
                                        @if($inv->status != '1')
                                        <select class="form-control change-invitation-status" data-id="{{ $inv->id }}">
                                            <option value="0" {{ ($inv->status == '0' ? 'selected' : '') }}>Pending</option>
                                            <option value="1" {{ ($inv->status == '1' ? 'selected' : '') }}>Approve</option>
                                            <option value="2" {{ ($inv->status == '2' ? 'selected' : '') }}>Return to Customer</option>
                                            <option value="4" {{ ($inv->status == '4' ? 'selected' : '') }}>Reject</option>
                                        </select>
                                        @else
                                            Approved
                                        @endif
                                    </td>
                                    <td class="text-primary">
                                        <a href="{{ route('admin.invitation.details', base64_encode($inv->id)) }}" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php if($inv->status == '1'): ?>
                                        <a href="{{ route('admin.invited.hotel.details', $inv->hotel_code) }}" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            @endforeach
                        @endif;
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('th_foot')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
$(document).on('change', '.change-invitation-status', function (e) {
	e.preventDefault();
    Swal.fire({
        title               : 'Are You Sure Want To Change Status?',
        type                : 'warning',
        showCancelButton    : true,
        confirmButtonColor  : '#dd6b55',
        cancelButtonColor   : '#48cab2',
        confirmButtonText   : "Yes !!!",
        cancelButtonText    : "Cancel"
    }).then((result) => {
        if (result.value) {
            let changedVal  = $(this).val();
            let changedId   = $(this).attr('data-id');
            let redirect    = '';
            switch(changedVal){
                case '0':
                    redirect    = "{{ route('admin.invitation.received', 'pending') }}";
                    break;
                case '1':
                    redirect    = "{{ route('admin.invitation.received', 'approved') }}";
                    break;
                case '2':
                    redirect    = "{{ route('admin.invitation.received', 'return-to-customer') }}";
                    break;
                default:
                    redirect    = "{{ route('admin.invitation.received', 'rejected') }}";
                    break;
            }
            $.ajax({
                type    : "POST",
                url     : "{{ route('admin.change.hotel.status') }}",
                data    :{
                    "_token"        : "{{ csrf_token() }}",
                    "changedId"     : changedId,
                    "changedVal"    : changedVal
                },
                success : function(data){
                    $('.inviRow' + changedId).remove();
                    swalAlertThenRedirect('Status Changed Successfully !!!', 'success', redirect);
                }
            });
        }
    });
});
</script>
@endsection