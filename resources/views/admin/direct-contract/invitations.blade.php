@extends('admin.layouts.master')
@section('th_head')
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Direct Contract Module : Invitation List
                <div class="float-right"></div>
            </div>
            <div class="card-body table-responsive">
                @include('admin.layouts.messages')
                <table class="table" id="order-listing">
                    <thead class=" text-primary"> 
                        <th>#</th>
                        <th>Hotel Name</th>
                        <th>Contact Name</th>
                        <th>Contact Phone</th>
                        <th>Contact Email</th>
                        <th>Link</th>
                    </thead>
                    <tbody>
                        @if(!empty($invitations))
                            @foreach($invitations as $key => $inv)
                                <tr>
                                    <td>{{ ($key + 1) }}</td>
                                    <td>{{ $inv->hotel_name }}</td>
                                    <td>{{ $inv->representative_name }}</td>
                                    <td>{{ $inv->contact_phone }}</td>
                                    <td>{{ $inv->contact_email }}</td>
                                    <td><a href="{{ $inv->link }}" target="_blank">Register</a></td>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endsection