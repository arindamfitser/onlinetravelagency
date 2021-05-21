@extends('frontend.layouts.app')
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.customer_sidenav')
  <div class="dashboard_content">
    <h1>My Wishlist</h1>
    @include('frontend.layouts.messages')
    <div class="update_profile">
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-hover" id="hotel">
            <thead>
              <tr>
                <th scope="col">Hotel Image</th>
                <th scope="col">Hotel Name</th>
                <th scope="col">Country</th>
                <th scope="col">Address</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($wishlists))
              @foreach($wishlists as $wishlist)
              <tr>
                <td><img src="{{ Storage::disk('local')->url($wishlist->featured_image) }}" alt="" width="150px" height="80px"></td>
                <td>{{ $wishlist->hotels_name }}</td>
                <td>{{ $wishlist->country }}</td>
                <td>{{ $wishlist->location }}</td>
                <td>
                  <a href="{{route('hotel.details', ['slug' => $wishlist->hotels_slug]) }}" class="btn btn-info" title="View"><i class="fa fa-eye"></i></a>
                  <form id="delete-form-{{ $wishlist->wish_id }}" method="post" action="{{ route('customer.wishlist.del', ['id' => $wishlist->wish_id]) }}" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                  </form>
                  <a href="javascript:void(0);" onclick="document.getElementById('delete-form-{{ $wishlist->wish_id }}').submit();" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="5" class="text-center">Data Not Available.</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
@endsection