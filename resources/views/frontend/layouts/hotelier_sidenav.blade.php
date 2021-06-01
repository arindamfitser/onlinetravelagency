<div class="sidenav">
    <ul>
        <?php if(empty(Auth::user()->hotel_token)) : ?>
        <center>
	        <div style="width:200px;height:200px; border: 1px solid whitesmoke ;text-align: center;position: relative" id="image">
	       <?php 
	         if(get_avatar()){ ?>
	         	<img width="100%" height="100%" id="preview_image" src="{{ Storage::disk('local')->url(get_avatar()) }}"/>
	         <?php }else{ ?>
	         	<img width="100%" height="100%" id="preview_image" src="{{asset('frontend/images/noimage.jpg')}}"/>
	         <?php }
	       ?>
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
	    <?php endif; ?>
        <li class="{{ Request::is('users/dashboard*') ? 'active' : '' }}"><a href="{{route('user.dashboard')}}"><i class="fa fa-th-large" aria-hidden="true"></i>Available Calendar</a></li>
        <li class="{{ Request::is('users/profile*') ? 'active' : '' }}"><a href="{{route('user.profile')}}"><i class="fa fa-user" aria-hidden="true"></i>{{ empty(Auth::user()->hotel_token) ? 'Profile' : 'User Profile'}}</a></li>
        <?php if(empty(Auth::user()->hotel_token)) : ?>
        <li class="{{ Request::is('users/hotels*') ? 'active' : '' }}">
            <a href="{{ route('user.hotels') }}">
                <i class="fa fa-hotel" aria-hidden="true"></i>My Hotels
            </a>
        </li> 
        <?php
        else:
            $hotel  = DB::table('hotel_new_entries')
                        ->select('id')
                        ->where('hotel_token', Auth::user()->hotel_token)
                        ->first();
        ?>
            <li class="{{ Request::is('users/hotels/edit*') ? 'active' : '' }}">
                <a href="{{ route('user.hotels.edit', ['id' => $hotel->id]) }}">
                    <i class="fa fa-hotel" aria-hidden="true"></i>My Hotel
                </a>
            </li>
            <li class="{{ Request::is('users/hotels/rooms*') ? 'active' : '' }}">
                <a href="{{ route('user.hotels.rooms', ['id' => $hotel->id]) }}">
                    <i class="fa fa-home" aria-hidden="true"></i>Room Type
                </a>
            </li>
        <?php endif; ?>
        <li class="{{ (Request::is('users/bookings*') || Request::is('users/booking*')) ? 'active' : '' }}"><a href="{{ route('users.bookings') }}"><i class="fa fa-list" aria-hidden="true"></i>Bookings</a></li>             
        <li class="{{ Request::is('users/reviews*') ? 'active' : '' }}"><a href="{{ route('users.hotels.reviews') }}"><i class="fa fa-list" aria-hidden="true"></i>Reviews</a></li>           
        <li class="{{ Request::is('users/transactions*') ? 'active' : '' }}"><a href="{{ route('user.transactions') }}"><i class="fa fa-list" aria-hidden="true"></i>Transactions</a></li>           
    </ul>
</div>