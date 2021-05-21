@extends('admin.layouts.master')
@section('th_head')
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Bookings
                <div class="float-right">
                    <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                        <?php @langOption(); ?>
                    </select>
                </div>
            </div>
            <div class="card-body table-responsive">
                @include('admin.layouts.messages')
                <table class="table" id="order-listing">
                    <thead>
                <tr>
                  <th scope="col">Bookig ID</th>
                  <th scope="col">Hotel Name</th>
                  <th scope="col">Room Title</th>
                  <th scope="col">Start Date Time</th>
                  <th scope="col">End Date Time</th>
                  <th scope="col">Guests</th>
                  <th scope="col">Nights</th>
                  <th scope="col">Type</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($bookings))
                @foreach($bookings as $booking)
                <tr>
                  <td><?php echo ($booking->xml_booking_id!=""?$booking->xml_booking_id:$booking->booking_id );?></td>
                  <td><?php echo ($booking->hotels_name!=''? $booking->hotels_name:getRoomxmlHotelData('hotelName',$booking->hotel_id) )?></td>
                  <?php if($booking->type=="stuba"){ ?>
                    <td>{{ getStubaBookingValue('RoomName',$booking->booking_id) }}</td>
                    <td><?php echo date('d F, Y', strtotime(getStubaBookingValue('ArrivalDate',$booking->booking_id))) ?></td>
                    <td>{{ date('d F, Y', strtotime($booking->end_date)) }}</td>
                    <td>{{ getStubaBookingValue('Guests',$booking->booking_id) }}</td>
                    <td><span class="badge badge-info">{{ getStubaBookingValue('Nights',$booking->booking_id) }}</span></td>
                  <?php }else{ ?>
                    <td>{{ $booking->name }}</td>
                    <td>{{ date('d F, Y', strtotime($booking->start_date)) }} ({{ $booking->check_in }})</td>
                    <td>{{ date('d F, Y', strtotime($booking->end_date)) }} ({{ $booking->check_out }})</td>
                    <td>{{ $booking->quantity_adults + $booking->quantity_child }}</td>
                    <td><span class="badge badge-info">{{ $booking->nights }}</span></td>
                  <?php } ?>
                  
                  <?php if($booking->type=="stuba"){ ?>
                    <td><span style="padding:5px" class="badge-success">{{ $booking->type }}</span></td>
                  <?php }else{ ?>
                    <td><span style="padding:5px" class="badge-primary">{{ $booking->type }}</span></td>
                  <?php } ?>
                  
                  <td>
                    @switch($booking->booked_status)
                    @case(1)
                    <span class="label label-success">Completed</span>
                    @break
                    @case(2)
                    <span class="label label-danger">Cancelled</span>
                    @break
                    @case(3)
                    <span class="label label-primary">Pending</span>
                    @break
                    @endswitch
                  </td>
                  <td><a href="{{ route('admin.bookings.details', ['id' => $booking->booking_id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="8" class="text-center">Data Not Available.</td>
                </tr>
                @endif
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