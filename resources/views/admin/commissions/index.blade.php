@extends('admin.layouts.master')
@section('th_head')
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Hotel Commissions
                <div class="float-right">
                    <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                        <?php @langOption(); ?>
                    </select>
                </div>
            </div>
            <div class="card-body table-responsive">
                @include('admin.layouts.messages')
                <form action="{{ route('admin.commissions.add') }}" method="post">
                    {{ csrf_field() }}
                    <table class="table">
                        <thead class=" text-primary">
                            <th>Hotel Name</th>
                            <th>Commissions (%)</th>
                        </thead>
                        <tbody>
                            @foreach($hotels as $hotel)
                            <tr>
                                <td>{{ $hotel->hotels_name }}</td>
                                <td>
                                    <input type="hidden" name="hotel_ids[]" value="<?php echo $hotel->id; ?>">
                                    <input type="text" class="form-control" name="commissions[]" value="<?php echo (isset($hotel->commission)) ? $hotel->commission : get_option('commission'); ?>"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="submit" class="btn btn-primary pull-right" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('th_foot')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    @endsection