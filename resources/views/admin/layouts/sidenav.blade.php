 <div class="sidebar" data-color="green" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
    <div class="logo">
        <a href="/" class="simple-text logo-normal">
            OTA 
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <!-- Dashboard -->
            <li class="nav-item {{ Request::is('admin') ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="material-icons"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <!-- Pages -->
            <li class="nav-item {{ Request::is('admin/pages*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.pages') }}">
                    <i class="material-icons"></i>
                    <p>Manage Pages </p>
                </a>
            </li>

            <!-- Banners -->
            <li class="nav-item {{ Request::is('admin/banners*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.banners') }}">
                    <i class="material-icons"></i>
                    <p>Manage Banners </p>
                </a>
            </li>

            <!-- Hotels -->
            <!--<li class="nav-item {{ Request::is('admin/hotels*') ? 'active' : '' }}  ">-->
            <!--    <a class="nav-link" href="{{ route('admin.hotels') }}">-->
            <!--        <i class="material-icons"></i>-->
            <!--        <p>Direct Contract Module</p>-->
            <!--    </a>-->
            <!--</li>-->
            <?php $dircontract = array('hotels','send-invitation','invitation-list', 'invitation-received', 'invite-hotel-details', 'invited-hotel-rooms'); ?>
            <li class="nav-item {{ Request::is('admin/hotels*') ? 'active' : '' }} " >
                <a class="nav-link <?php echo (in_array(Request::segment(2),$dircontract)?'':'collapsed');?>" data-toggle="collapse" href="#dirContract">
                    <i class="material-icons"></i>
                    <p>Direct Contract Module 
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse <?php echo (in_array(Request::segment(2),$dircontract) ? 'show' : '');?>" id="dirContract">
                    <ul class="nav">
                        <li class="nav-item {{ (Request::is('admin/hotels*') || Request::is('admin/invited-hotel-rooms*'))  ? 'active' : '' }}">
                            <a href="{{ route('admin.hotels') }}" class="nav-link">Hotels<i class="material-icons"></i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/send-invitation*') ? 'active' : '' }}">
                            <a href="{{ route('admin.send.invitation') }}" class="nav-link">Send Invitation<i class="material-icons"></i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/invitation-list*') ? 'active' : '' }}">
                            <a href="{{ route('admin.invitation.list') }}" class="nav-link">Invitation List<i class="material-icons"></i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/invitation-received/pending') ? 'active' : '' }}">
                            <a href="{{ route('admin.invitation.received', 'pending') }}" class="nav-link">Pending Invitations <i class="material-icons"></i></a>
                        </li>
                        <li class="nav-item {{ (Request::is('admin/invitation-received/approved') || Request::is('admin/invite-hotel-details*')) ? 'active' : '' }}">
                            <a href="{{ route('admin.invitation.received', 'approved') }}" class="nav-link">Approved Invitations <i class="material-icons"></i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/invitation-received/return-to-customer') ? 'active' : '' }}">
                            <a href="{{ route('admin.invitation.received', 'return-to-customer') }}" class="nav-link">Return To Customer Invitations <i class="material-icons"></i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/invitation-received/rejected') ? 'active' : '' }}">
                            <a href="{{ route('admin.invitation.received', 'rejected') }}" class="nav-link">Rejected Invitations <i class="material-icons"></i></a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Direct Contact module -->
            <li class="nav-item {{ Request::is('admin/direct_contact*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.direct_contact') }}">
                    <i class="material-icons"></i>
                    <p>Database Dashboard</p>
                    <!--<p>Direct Contract Module</p> -->
                </a>
            </li>
            <!-- Bookings -->
            <li class="nav-item {{ Request::is('admin/bookings*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.bookings') }}">
                    <i class="material-icons"></i>
                    <p>Manage Bookings</p>
                </a>
            </li>

            <!-- Commissions -->
            <li class="nav-item {{ Request::is('admin/commissions*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.commissions') }}">
                    <i class="material-icons"></i>
                    <p>Manage Commissions</p>
                </a>
            </li>

             <!-- Reviews -->
            <li class="nav-item {{ Request::is('admin/reviews*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.reviews') }}">
                    <i class="material-icons"></i>
                    <p>Hotel Reviews</p>
                </a>
            </li>



             <!-- Our Partners -->
            <li class="nav-item {{ Request::is('admin/partners*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.partners') }}">
                    <i class="material-icons"></i>
                    <p>Manage Partners</p>
                </a>
            </li>

            <!-- Masters -->
            <?php $master = array('countries','states','amenities','classification','category','species','inspirations','experiences','features','regions','service_facilities','room_facilities','recreation'); ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (in_array(Request::segment(2),$master)?'':'collapsed');?>" data-toggle="collapse" href="#masters" >
                    <i class="material-icons"></i>
                    <p>Manage Masters
                  <b class="caret"></b>
                  </p>
                </a>
                <div class="collapse <?php echo (in_array(Request::segment(2),$master)?'show':'');?>" id="masters">
                	<ul class="nav">
                		<li class="nav-item {{ Request::is('admin/countries*') ? 'active' : '' }}">
                			<a href="{{ route('admin.countries') }}" class="nav-link">Country<i class="material-icons">fiber_manual_record</i>
                            
                            </a>
                		</li>
                		<li class="nav-item {{ Request::is('admin/states*') ? 'active' : '' }}">
                			<a href="{{ route('admin.states') }}" class="nav-link">State<i class="material-icons">fiber_manual_record</i></a>
                		</li>
                		<li class="nav-item {{ Request::is('admin/accommodations*') ? 'active' : '' }}">
                			<a href="{{ route('admin.accommodations') }}" class="nav-link">Accommodations<i class="material-icons">fiber_manual_record</i></a>
                		</li>
                        <li class="nav-item {{ Request::is('admin/amenities*') ? 'active' : '' }}">
                            <a href="{{ route('admin.amenities') }}" class="nav-link">Room Amenities<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/classification*') ? 'active' : '' }}">
                            <a href="{{ route('admin.classification') }}" class="nav-link">Room Classification<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                         <li class="nav-item {{ Request::is('admin/category*') ? 'active' : '' }}">
                            <a href="{{ route('admin.category') }}" class="nav-link">Room Category<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                		<li class="nav-item {{ Request::is('admin/species*') ? 'active' : '' }}">
                			<a href="{{ route('admin.species') }}" class="nav-link">Species<i class="material-icons">fiber_manual_record</i></a>
                		</li>
                        <li class="nav-item {{ Request::is('admin/inspirations*') ? 'active' : '' }}">
                            <a href="{{ route('admin.inspirations') }}" class="nav-link">Inspirations<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/experiences*') ? 'active' : '' }}">
                            <a href="{{ route('admin.experiences') }}" class="nav-link">Experiences<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/regions*') ? 'active' : '' }}">
                            <a href="{{ route('admin.regions') }}" class="nav-link">Regions<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/features*') ? 'active' : '' }}">
                            <a href="{{ route('admin.features') }}" class="nav-link">Key Features<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/service_facilities*') ? 'active' : '' }}">
                            <a href="{{ route('admin.service_facilities') }}" class="nav-link">Service Facilities<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                         <li class="nav-item {{ Request::is('admin/room_facilities*') ? 'active' : '' }}">
                            <a href="{{ route('admin.room_facilities') }}" class="nav-link">Room Facilities<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/recreation*') ? 'active' : '' }}">
                            <a href="{{ route('admin.recreation') }}" class="nav-link">Recreation<i class="material-icons">fiber_manual_record</i></a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Users -->
            <?php $users = array('users','hotelier'); ?>
            <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }} " >
                <a class="nav-link <?php echo (in_array(Request::segment(2),$users)?'':'collapsed');?>" data-toggle="collapse" href="#users">
                    <i class="material-icons"></i>
                    <p>Manage Users 
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse <?php echo (in_array(Request::segment(2),$users)?'show':'');?>" id="users">
                    <ul class="nav">
                      <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users') }}" class="nav-link">Customers<i class="material-icons">fiber_manual_record</i></a>
                      </li>
                      <li class="nav-item {{ Request::is('admin/hotelier*') ? 'active' : '' }}">
                            <a href="{{ route('admin.hoteliers') }}" class="nav-link">Hoteliers<i class="material-icons">fiber_manual_record</i></a>
                      </li>
                    </ul>
                </div>
            </li>

            <!-- Testimonials -->
            <li class="nav-item {{ Request::is('admin/testimonials*') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.testimonials') }}">
                    <i class="material-icons"></i>
                    <p>Manage Testimonials </p>
                </a>
            </li>

            <!-- Settings -->
            <?php $settings = array('settings'); ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (in_array(Request::segment(2),$settings)?'':'collapsed');?>" data-toggle="collapse" href="#settings" >
                    <i class="material-icons"></i>
                    <p>Settings
                  <b class="caret"></b>
                  </p>
                </a>
                <div class="collapse <?php echo (in_array(Request::segment(2),$settings)?'show':'');?>" id="settings">
                    <ul class="nav">
                        <li class="nav-item {{ Request::is('admin/settings/general') ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.general') }}" class="nav-link">General<i class="material-icons">fiber_manual_record</i>
                            
                            </a>
                        </li>
                        <!-- <li class="nav-item {{ Request::is('admin/states*') ? 'active' : '' }}">
                            <a href="{{ route('admin.states') }}" class="nav-link">Social Links<i class="material-icons">fiber_manual_record</i></a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ Request::is('admin/destination/image') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.destination.image') }}">
                    <i class="material-icons"></i>
                    <p>Destination Image</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/hotel/image') ? 'active' : '' }}  ">
                <a class="nav-link" href="{{ route('admin.hotel.image') }}">
                    <i class="material-icons"></i>
                    <p>Hotel Image</p>
                </a>
            </li>
            
        </ul>
    </div>
</div>