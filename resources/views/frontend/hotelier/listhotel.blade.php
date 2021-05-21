@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
    @include('frontend.layouts.hotelier_sidenav')
    <div class="dashboard_content">
        <h1>{{ empty(Auth::user()->hotel_token) ? 'Our Hotels' : (!empty($hotels) ? $hotels[0]->hotels_name : 'My Hotel')}}</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="user_panel">
                    <table class="table table-bordered table-hover common_table" id="hotel">
                        <thead>
                            <tr>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">Region</th>
                                <th scope="col">Country</th>
                                <th scope="col">State</th>
                                <th scope="col">Town</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($hotels)):
                                foreach ($hotels as $hotel):
                            ?>
                            <tr>
                                <td>{{ $hotel->hotels_name }}</td>
                                <td>{{ $hotel->region->regions_name }}</td>
                                <td>{{ $hotel->country->countries_name }}</td>
                                <td>{{ $hotel->state->states_name }}</td>
                                <td>{{ $hotel->town }}</td>
                                <td>{{ $hotel->email_id }}</td>
                                <td>
                    
                                  @if($hotel->status == 1)
                                   <a href="javascript:void(0);" onclick="document.getElementById('status-form-{{ $hotel->id }}').submit();"> <span class="label label-success">Active</span></a>
                                 
                                  @else
                                  <a href="javascript:void(0);" onclick="document.getElementById('status-form-{{ $hotel->id }}').submit();"><span class="label label-danger">Deactive</span></a>
                                  @endif
                                  <form id="status-form-{{ $hotel->id }}" method="post" action="{{ route('user.hotel.status', $hotel->id) }}" style="display: none;">
                                    @if($hotel->status == 1)
                                      <input type="hidden" name="status" value="0">
                                    @else
                                      <input type="hidden" name="status" value="1">
                                    @endif
                                      {{ csrf_field() }}
                                  </form>
                                </td>
                                <td>
                                  <a href="/hotel/{{ $hotel->hotels_slug }}" target="_blank" class="btn btn-warning" title="Edit"><i class="fa fa-eye"></i></a>
                                  <a href="{{ route('user.hotels.rooms', ['id' => $hotel->id]) }}" class="btn btn-success" title="Rooms"><i class="fa fa-home"></i> </a>
                                  <a href="{{ route('user.hotels.edit', ['id' => $hotel->id]) }}" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i> </a>
                                 
                                </td>
                            </tr>
                            <?php
                                endforeach;
                            endif;
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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#hotel').DataTable();
} );
</script>
@endsection
