   <div class="sidenav">
      <ul>
        <center>
            <div style="width:200px;height:200px; border: 1px solid whitesmoke ;text-align: center;position: relative" id="image">
                <?php if(get_avatar()): ?>
                    <img width="100%" height="100%" id="preview_image" 
                    src="{{ url('public/storage/uploads/profile/' . get_avatar()) }}"/>
                <?php else: ?>
                    <img width="100%" height="100%" id="preview_image" src="{{asset('frontend/images/noimage.jpg')}}"/>
                <?php endif; ?>                
                <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 40%;top: 40%;display: none"></i>
            </div>
            <p>
                <span onclick="changeProfile()" style="text-decoration: none;">
                    <i class="glyphicon glyphicon-edit"></i> Change
                </span>&nbsp;&nbsp;
                <span   onclick="removeFile()" style="color: red;text-decoration: none;">
                    <i class="glyphicon glyphicon-trash"></i>
                    Remove
                </span>
            </p>
            <input type="file" id="file" style="display: none"/>
            <input type="hidden" id="file_name" value="{{ Storage::disk('local')->url(get_avatar()) }}" />
        </center>
        <li class="{{ Request::is('users/dashboard*') ? 'active' : '' }}" ><a href="{{route('user.dashboard')}}"><i class="fa fa-th-large" aria-hidden="true"></i>My Dashboard</a></li>
        <li class="{{ Request::is('users/profile*') ? 'active' : '' }}"><a href="{{route('user.profile')}}"><i class="fa fa-user" aria-hidden="true"></i> My Profile</a></li>
        <li class="{{ Request::is('customer/booking*') ? 'active' : '' }}"><a href="{{ route('customer.booking') }}"><i class="fa fa-hotel" aria-hidden="true"></i>My Booking</a></li>                 
        <li class="{{ Request::is('customer/testimonial*') ? 'active' : '' }}"><a href="{{ route('customer.testimonial') }}"><i class="fa fa-newspaper-o" aria-hidden="true"></i>My Testimonials</a></li>
        <li class="{{ Request::is('customer/dashboard*') ? 'active' : '' }}"><a href="javascript:void(0);"><i class="fa fa-newspaper-o" aria-hidden="true"></i>My Journal</a></li>
          {{-- <li class="{{ Request::is('customer/wishlist*') ? 'active' : '' }}"><a href="{{ route('customer.wishlist') }}"><i
              class="fa fa-heart" aria-hidden="true"></i>My Wishlist</a></li> --}}
          {{-- <li><a href="{{ route('customer.membership') }}"><i class="fa fa-address-card-o" aria-hidden="true"></i>My
          membership</a></li> 
          <li><a href="{{ route('customer.offer') }}"><i class="fa fa-gift" aria-hidden="true"></i>My offers</a></li> --}}
    </ul>
</div>