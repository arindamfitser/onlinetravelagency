@extends('admin.layouts.master')
@section('th_head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('backend/assets/css/ScrollTabla.css')}}">
@endsection
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h3 class="card-title">Database Dashboard
               <div class="float-right">
                <!--<select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                  <?php @langOption(); ?>
                </select> -->
                  <a href="#" class="btn-sm btn-success btn-round" id="fullview" style="margin-right:10px;"><i class="fa fa-arrows-alt" aria-hidden="true"></i> View </a>
                  <a href="#" class="btn-sm btn-info  btn-round" data-toggle="modal" data-target="#csvuploadmodal"> 
                    <i class="material-icons">backup</i> Upload CSV</a>
                </div>
            </h3>
          </div>
          <div class="card-body">
              <div class=row>
                   <div class="col-sm-12">
                     <div class="float-right" id="editdiv" style="display:none"><a href="#" class="btn-sm btn-success btn-round" id="editbtn" style="margin-right:10px;" terget="_blank"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a></div>
                   </div>
              </div>
              <form action="">
                <div class=row>
                    <div class="col-sm-4">
                          <div class="form-group">
                            <input type="text" class="form-control" name="hotel_name" id="hotel_name" placeholder="Hotel Name" onkeyup="nameSearch()">
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                             <!--<input type="text" class="form-control" name="hotel_name" id="select_state" placeholder="State" onkeyup="stateSearch()">-->
                            <select class="form-control" name="state" id="select_state" onchange="stateSearch();">
                              <?php 
                                $states = App\States::all();
                            	    echo '<option value="">Select State</option>';
                                	foreach ($states as $key => $value) {
                                	 echo '<option value="'.$value->states_name.'" >'.$value->states_name.'</option>';
                                	}
                            	
                              ?> 
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="form-group">
                                <!--<input type="text" class="form-control" name="hotel_name" id="select_country" placeholder="Country" onkeyup="countrySearch()">-->
                            <select class="form-control" name="state" id="select_country" onchange="countrySearch();">
                              <?php 
                              	$country = App\Countries::all();
                            	echo '<option value="">Select Country</option>';
                            	foreach ($country as $key => $value) {
                            		echo '<option value="'.$value->countries_name.'" >'.$value->countries_name.'</option>';
                            	}
                            
                              ?>  
                            </select>
                          </div>
                        </div>
                        <!--<div class="col-sm-2">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>-->
                    </div>
                 </form> 
              
            <div class="ContenedorTabla">
              <table id="myTable" class="fht-table">
                <thead>
                   <tr>
                    <th class="celda_encabezado_general"></th>
                    <th class="celda_encabezado_general" colspan="1">SL NO</th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="4">DESTINATIONS</th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="6">ACCOMMODATION TYPES </th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="7">INSPIRATIONS</th>
                    <th class="celda_encabezado_general" colspan="4">SERVICE FOR THE FISHERMAN</th>
                    <th class="celda_encabezado_general" colspan="4">PROPERTY DETAILS</th>
                    <th class="celda_encabezado_general" colspan="6">PROPERTY FEATURES</th>
                    <th class="celda_encabezado_general" colspan="3">GETTING THERE</th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="8">EXPERIENCES</th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="32">SEARCH BY SPECIES</th>
                    <th class="celda_encabezado_general" colspan="1"></th>
                    <th class="celda_encabezado_general" colspan="5">GUIDE 1</th>
                    <th class="celda_encabezado_general" colspan="5">GUIDE 2</th>
                    <th class="celda_encabezado_general" colspan="5">GUIDE 3</th>
                    <th class="celda_encabezado_general" colspan="5">GUIDE 4</th>
                    <th class="celda_encabezado_general" colspan="5">GUIDE 5</th>
                    <th class="celda_encabezado_general" colspan="5">GUIDE 6</th>
                    <th class="celda_encabezado_general" colspan="5">ADMINISTRATORS CONTACT WITH PROPERTY</th>
                  </tr>
                  <tr>
                    <th class="celda_encabezado_general"></th>
                    <th class="celda_encabezado_general">#ID</th>
                    <th class="celda_encabezado_general">PROPERTY NAME</th>
                    <!-- ========DESTINATIONS============  -->
                    <th class="celda_encabezado_general">REGION</th>
                    <th class="celda_encabezado_general">COUNTRY</th>
                    <th class="celda_encabezado_general">STATE / DISTRICT</th>
                    <th class="celda_encabezado_general">LOCATION</th>
                    
                    <!-- ====================-- -->
                    <th class="celda_encabezado_general">STUBA / ROOMSXML</th>
                    <th class="celda_encabezado_general">DIRECT CONTRACT</th>
                    <!-- ===========ACCOMMODATION TYPES========  -->
                    <th class="celda_encabezado_general">CASTLES & MANORS</th>
                    <th class="celda_encabezado_general">PRIVATE ISLANDS</th>
                    <th class="celda_encabezado_general">RESORTS</th>
                    <th class="celda_encabezado_general">LODGES</th>
                    <th class="celda_encabezado_general">HOTELS</th>
                    <th class="celda_encabezado_general">LIVE-ABOARD VESSELS</th>
                    <!-- ====================-- -->
                    <th class="celda_encabezado_general">CURATOR RATING</th>
                    <th class="celda_encabezado_general">BRIEF DESCRIPTION FOR INCLUSION ON SEARCH RESULTS PAGE</th>
                    <th class="celda_encabezado_general">FULL DESCRIPTION FOR INCLUSION ON HOTEL PAGE</th>
                    <!-- =========INSPIRATIONS========== -->
                    <th class="celda_encabezado_general">OUR GOLD AWARD WINNERS</th>
                    <th class="celda_encabezado_general">OUR TOP SALTWATER DESTINATIONS</th>
                    <th class="celda_encabezado_general">OUR TOP FRESHWATER DESTINATIONS</th>
                    <th class="celda_encabezado_general">OFF THE BEATEN TRACK</th>
                    <th class="celda_encabezado_general">QUIRKY  FAVOURITES</th>
                    <th class="celda_encabezado_general">CATCH & COOK</th>
                    <th class="celda_encabezado_general">TOURNAMENT TRAIL</th>
                    <!-- ===========SERVICE FOR THE FISHERMAN======= -->
                    <th class="celda_encabezado_general">TEXT FOR INCLUSION ON BOOKING CONFIRMATION VOUCHER</th>
                    <th class="celda_encabezado_general">Bespoke fishing experiences provided on site or nearby</th>
                    <th class="celda_encabezado_general">Property Name concierge staff can arrange fishing nearby</th>
                    <th class="celda_encabezado_general">We provide our curated "best guide or charter" selections</th>
                    <!-- ============PROPERTY DETAILS============= -->
                    <th class="celda_encabezado_general">PHYSICAL ADDRESS</th>
                    <th class="celda_encabezado_general">WEBSITE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">PHONE</th>
                    <!-- ==============PROPERTY FEATURES============ -->
                    <th class="celda_encabezado_general">AMENITIES SERVICES & FEATURES</th>
                    <th class="celda_encabezado_general">AMENITIES ACTIVITIES</th>
                    <th class="celda_encabezado_general">TOURS</th>
                    <th class="celda_encabezado_general">POOL</th>
                    <th class="celda_encabezado_general">DIVING</th>
                    <th class="celda_encabezado_general">WATER SPORTS</th>
                    <!-- ==============GETTING THERE============== -->
                    <th class="celda_encabezado_general">NEAREST AIRPORT</th>
                    <th class="celda_encabezado_general">DISTANCE</th>
                    <th class="celda_encabezado_general">TRANSFERS</th>
                    <!-- ============-==========- -->
                    <th class="celda_encabezado_general">MORE INFO</th>
                    <!-- ===========EXPERIENCES========== -->
                    <th class="celda_encabezado_general">FRESH WATER FISHING</th>
                    <th class="celda_encabezado_general">SALT WATER FISHING</th>
                    <th class="celda_encabezado_general">ACTION</th>
                    <th class="celda_encabezado_general">PURITY & TRANQUILITY</th>
                    <th class="celda_encabezado_general">HELICOPTER OR  FLOAT PLANE FISHING</th>
                    <th class="celda_encabezado_general">FINE DINING</th>
                    <th class="celda_encabezado_general">SPA RESORTS</th>
                    <th class="celda_encabezado_general">BEACH RESORTS</th>
                    <!-- =============--============ -->
                    <th class="celda_encabezado_general">FISHING</th>
                    <th class="celda_encabezado_general">FISHING SEASON</th>
                    <!-- ===========SEARCH BY SPECIES============ -->
                    <th class="celda_encabezado_general">BILLFISH</th>
                    <th class="celda_encabezado_general">TUNA</th>
                    <th class="celda_encabezado_general">MAHI-MAHI</th>
                    <th class="celda_encabezado_general">WAHOO</th>
                    <th class="celda_encabezado_general">KINGFISH</th>
                    <th class="celda_encabezado_general">QUEENFISH</th>
                    <th class="celda_encabezado_general">GT'S</th>
                    <th class="celda_encabezado_general">TREVALLY</th>
                    <th class="celda_encabezado_general">PELAGICS</th>
                    <th class="celda_encabezado_general">REEF FISH</th>
                    <th class="celda_encabezado_general">SNAPPER</th>
                    <th class="celda_encabezado_general">ESTUARY FISH</th>
                    <th class="celda_encabezado_general">BONEFISH</th>
                    <th class="celda_encabezado_general">BARRAMUNDI</th>
                    <th class="celda_encabezado_general">PERMIT</th>
                    <th class="celda_encabezado_general">TARPON</th>
                    <th class="celda_encabezado_general">SEA TROUT</th>
                    <th class="celda_encabezado_general">TROUT</th>
                    <th class="celda_encabezado_general">SALMON</th>
                    <th class="celda_encabezado_general">PIKE</th>
                    <th class="celda_encabezado_general">GRAYLING</th>
                    <th class="celda_encabezado_general">STEELHEAD</th>
                    <th class="celda_encabezado_general">CHAR</th>
                    <th class="celda_encabezado_general">BASS</th>
                    <th class="celda_encabezado_general">PEACOCK BASS</th>
                    <th class="celda_encabezado_general">PERCH</th>
                    <th class="celda_encabezado_general">HALIBUT</th>
                    <th class="celda_encabezado_general">STURGEON</th>
                    <th class="celda_encabezado_general">COD</th>
                    <th class="celda_encabezado_general">GOLDEN DORADO</th>
                    <th class="celda_encabezado_general">ROOSTERFISH</th>
                    <th class="celda_encabezado_general">TIGERFISH</th>
                    <!-- ===========--=============== -->
                    <th class="celda_encabezado_general">SPECIES</th>
                    
                    <!-- ===========GUIDE 1========= -->
                    <th class="celda_encabezado_general">BUSINESS NAME</th>
                    <th class="celda_encabezado_general">WEBSITE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">PHONE / SKYPE ID</th>
                    <th class="celda_encabezado_general">CONTACT NAME</th>
                    <!-- ===========GUIDE 2========= -->
                    
                    <th class="celda_encabezado_general">BUSINESS NAME</th>
                    <th class="celda_encabezado_general">WEBSITE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">PHONE / SKYPE ID</th>
                    <th class="celda_encabezado_general">CONTACT NAME</th>
                    <!-- ===========GUIDE 3========= -->
                    <th class="celda_encabezado_general">BUSINESS NAME</th>
                    <th class="celda_encabezado_general">WEBSITE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">PHONE / SKYPE ID</th>
                    <th class="celda_encabezado_general">CONTACT NAME</th>
                    <!-- ===========GUIDE 4========= -->
                    <th class="celda_encabezado_general">BUSINESS NAME</th>
                    <th class="celda_encabezado_general">WEBSITE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">PHONE / SKYPE ID</th>
                    <th class="celda_encabezado_general">CONTACT NAME</th>
                    <!-- ===========GUIDE 5========= -->
                    <th class="celda_encabezado_general">BUSINESS NAME</th>
                    <th class="celda_encabezado_general">WEBSITE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">PHONE / SKYPE ID</th>
                    <th class="celda_encabezado_general">CONTACT NAME</th>
                    <!-- ===========GUIDE 6========= -->
                    <th class="celda_encabezado_general">BUSINESS NAME</th>
                    <th class="celda_encabezado_general">WEBSITE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">PHONE / SKYPE ID</th>
                    <th class="celda_encabezado_general">CONTACT NAME</th>
                    <!-- =====ADMINISTRATORS CONTACT WITH PROPERTY==== -->
                    <th class="celda_encabezado_general">NAME</th>
                    <th class="celda_encabezado_general">TITLE</th>
                    <th class="celda_encabezado_general">PHONE</th>
                    <th class="celda_encabezado_general">EMAIL</th>
                    <th class="celda_encabezado_general">SKYPE ID </th>
                  </tr>
                 
                </thead>
                
                <tbody>
                  @foreach($hotels as $key => $hotel)
                  <?php
                //echo "<pre>";
                //print_r($hotel); die;
                  ?>
                  <tr>
                    <td class="celda_normal"><input type="checkbox" name="check1" class="check1" value="{{ route('admin.hotels.edit', ['lang' =>'en', 'id' => $hotel->h_id]) }}"/></td>
                    <td class="celda_normal"><?php echo ($key+1); ?></td>
                    <td class="celda_normal">
                        <a href="javascript:void(0);" data-hotel-id="{{$hotel->h_id}}" class="changeData changeData{{$hotel->h_id}}" data-change="hotelName" data-hotel="<?php getHotelfield($hotel->h_id,'hotels_name');?>">
                            <p style="width: 200px;"><?php getHotelfield($hotel->h_id,'hotels_name');?></p>
                        </a>
                    </td>
                    <!-- ========DESTINATIONS============  -->
                    <td class="celda_normal"><p style="width: 200px;">{{ $hotel->region->regions_name }}</p></td>
                    <td class="celda_normal">{{ $hotel->country->countries_name }}</td>
                    <td class="celda_normal">
                        <a href="javascript:void(0);" data-hotel-id="{{$hotel->h_id}}" class="changeData changeState{{$hotel->h_id}}" data-change="state" data-country="<?=$hotel->country_id?>" data-hotel="<?=$hotel->state_id?>">
                            {{ $hotel->state->states_name }}
                        </a>
                    </td>
                    <td class="celda_normal">
                        <a href="javascript:void(0);" data-hotel-id="{{$hotel->h_id}}" class="changeData changeTown{{$hotel->h_id}}" data-change="town" data-hotel="<?=$hotel->town?>">
                            {{ $hotel->town }}
                        </a>
                    </td>
                    <!-- ====================-- -->
                    <td class="celda_normal">
                        <a href="javascript:void(0);" data-hotel-id="{{$hotel->h_id}}" class="changeData changeStuba{{$hotel->h_id}}" data-change="stubaId" data-hotel="<?=$hotel->stuba_id?>">
                            {{ $hotel->stuba_id }}
                        </a>
                    </td>
                        
                    <td class="celda_normal">@if($hotel->contact_status == 'D'){{ 1 }}@endif</td>
                    <!-- ===========ACCOMMODATION TYPES========  -->
                    <td class="celda_normal">
                      <?php accommodation_data($hotel->h_id, 1); ?>
                    </td>
                    <td class="celda_normal">
                       <?php accommodation_data($hotel->h_id, 5); ?>
                    </td>
                    <td class="celda_normal">
                       <?php accommodation_data($hotel->h_id, 6); ?>
                    </td>
                    <td class="celda_normal">
                       <?php accommodation_data($hotel->h_id, 4); ?>
                    </td>
                    <td class="celda_normal">
                       <?php accommodation_data($hotel->h_id, 2); ?>
                    </td>
                    <td class="celda_normal">
                       <?php accommodation_data($hotel->h_id, 3); ?>
                    </td>
                    <!-- ====================-- -->
                    <td class="celda_normal">
                        <a href="javascript:void(0);" data-hotel-id="{{$hotel->h_id}}" class="changeData changeCurator{{$hotel->h_id}}" data-change="curator" data-hotel="<?=$hotel->curator_rating?>">
                            {{ $hotel->curator_rating }}
                        </a>
                    </td>
                    <td class="celda_normal"><p style="width: 300px;"><?php echo $hotel->hotels_desc; ?></p></td>
                    <td class="celda_normal"><?php echo $hotel->brief_descp; ?></td>
                    <!-- =========INSPIRATIONS========== -->
                    <td class="celda_normal"><?php inspiration_data($hotel->h_id, 7); ?></td>
                    <td class="celda_normal"><?php inspiration_data($hotel->h_id, 1); ?></td>
                    <td class="celda_normal"><?php inspiration_data($hotel->h_id, 2); ?></td>
                    <td class="celda_normal"><?php inspiration_data($hotel->h_id, 3); ?></td>
                    <td class="celda_normal"><?php inspiration_data($hotel->h_id, 4); ?></td>
                    <td class="celda_normal"><?php inspiration_data($hotel->h_id, 5); ?></td>
                    <td class="celda_normal"><?php inspiration_data($hotel->h_id, 6); ?></td>
                    <!-- ===========SERVICE FOR THE FISHERMAN======= -->
                    <td class="celda_normal"><?php echo substr($hotel->booking_cnf,0,50); ?></td>
                    <td class="celda_normal"><?php if($hotel->provide_on_site == 'yes'){ echo 1; }else{} ?></td>
                    <td class="celda_normal"><?php if($hotel->arrange_fishing_nearby == 'yes'){ echo 1; }else{} ?></td>
                    <td class="celda_normal"><?php if($hotel->provide_our_curated == 'yes'){ echo 1; }else{} ?></td>
                    <!-- ============PROPERTY DETAILS============= -->
                    <td class="celda_normal"><p style="width: 300px;"><?php echo $hotel->address; ?></p></td>
                    <td class="celda_normal"><?php echo $hotel->website; ?></td>
                    <td class="celda_normal"><?php echo $hotel->email_id; ?></td>
                    <td class="celda_normal"><p style="width:100px;"><?php echo $hotel->phone; ?></p></td>
                    <!-- ==============PROPERTY FEATURES============ -->
                    <td class="celda_normal"><?php echo $hotel->services_amenities; ?></td>
                    <td class="celda_normal"><?php echo $hotel->activities; ?></td>
                    <td class="celda_normal"><p style="width: 300px;"><?php echo substr($hotel->tours,0,50); ?></p></td>
                    <td class="celda_normal"><?php if($hotel->pool == 'yes'){ echo 1; }else{} ?></td>
                    <td class="celda_normal"><?php if($hotel->diving == 'yes'){ echo 1; }else{} ?></td>
                    <td class="celda_normal"><?php if($hotel->water_sports == 'yes'){ echo 1; }else{} ?></td>
                    <!-- ==============GETTING THERE============== -->
                    <td class="celda_normal"><?php echo $hotel->nearest_airport; ?></td>
                    <td class="celda_normal"><?php echo $hotel->distance_airport; ?></td>
                    <td class="celda_normal"><?php echo $hotel->transfers_mode; ?></td>
                    <!-- ============-==========- -->
                    <td class="celda_normal"><?php echo $hotel->additional_information; ?></td>
                    <!-- ===========EXPERIENCES========== -->
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 2); ?></td>
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 1); ?></td>
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 3); ?></td>
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 4); ?></td>
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 7); ?></td>
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 8); ?></td>
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 5); ?></td>
                    <td class="celda_normal"><?php echo experience_data($hotel->h_id, 6); ?></td>
                    <!-- =============--============ -->
                    <td class="celda_normal"><p style="width: 500px;"><?php echo substr($hotel->fishing,0,50); ?></p></td>
                    <td class="celda_normal"><?php echo $hotel->activity_season; ?></td>
                    <!-- ===========SEARCH BY SPECIES============ -->
                    <td class="celda_normal"><?php species_data($hotel->h_id, 2); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 3); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 4); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 8); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 9); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 10); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 5); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 6); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 11); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 12); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 13); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 14); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 15); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 16); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 17); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 18); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 19); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 20); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 21); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 22); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 23); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 24); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 25); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 26); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 27); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 28); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 29); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 30); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 31); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 32); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 33); ?></td>
                    <td class="celda_normal"><?php species_data($hotel->h_id, 34); ?></td>
                    <!-- ===========--=============== -->
                    <td class="celda_normal"><p style="width: 200px;"><?php echo substr($hotel->species,0,50); ?></p></td>
                    <!-- ===========GUIDE 1========= -->
                    <?php
                    for ($i=0; $i <6 ; $i++) { 
                         $guide_type = 'guide_'.($i+1);
                         $tourguide = getTourGuide($hotel->h_id, $guide_type);

                    ?>
                    <td class="celda_normal"><?php echo $tourguide['business_name']; ?></td>
                    <td class="celda_normal"><?php echo $tourguide['website']; ?></td>
                    <td class="celda_normal"><?php echo $tourguide['email']; ?></td>
                    <td class="celda_normal"><?php echo $tourguide['phone']; ?></td>
                    <td class="celda_normal"><?php echo $tourguide['contact_name']; ?></td> 
                    <?php
                     } 
                    ?>
                    <!-- ===ADMINISTRATORS CONTACT WITH PROPERTY=== -->
                    <td class="celda_normal"><?php echo $hotel->contact_person_name; ?></td>
                    <td class="celda_normal"><?php echo $hotel->title; ?></td>
                    <td class="celda_normal"><?php echo $hotel->contact_person_phone; ?></td>
                    <td class="celda_normal"><?php echo $hotel->contact_person_email; ?></td>
                    <td class="celda_normal"><?php echo $hotel->skype_id; ?></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div id="not_found" style="width:100%; text-align: center;display:none;"> Data Not found! </div>
            </div>
          </div>
        </div>
      </div>
              <!-- modal start -->
        <div class="modal fade" id="csvuploadmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-small ">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
            </div>
            <form action="{{ route('admin.hotels.uploadcsv') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body text-center">
                    <div class="form-group">
                        <label class="bmd-label-floating">Upload CSV</label>
                        <span class="btn btn-primary btn-round btn-file">
                          <span class="fileinput-new">Choose file</span>
                          <input type="file" name="upload_csv" id="upload_csv" />
                      </span>
                  </div>
              </div>
              <div class="modal-footer text-center">
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- modal end -->
    </div>
  </div>
</div>
<input type="hidden" id="edit" value="no">
@endsection
@section('th_foot')
<script src="{{ asset('backend/assets/js/jquery.CongelarFilaColumna.js')}}"></script>
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.loading.css') }}">
<script src="{{ asset('frontend/js/jquery.loading.js') }}"></script>
<script type="text/javascript">
$(function() {
    $(".changeData").click(function(){
        if($('#edit').val() == 'no'){
            if($(this).attr('data-change') == 'hotelName'){
                $('#edit').val('yes');
                $(this).empty();
                $(this).html('\
                    <input type="text" class="form-control" id="changedData" value="'+$(this).attr('data-hotel')+'">\
                    <input type="hidden" id="changeProp" value="'+$(this).attr('data-change')+'">\
                    <input type="hidden" id="table" value="hotels_translations">\
                    <input type="hidden" id="key" value="hotels_name">\
                    <input type="hidden" id="updateKey" value="hotels_id">\
                    <input type="hidden" id="hotels_id" value="'+$(this).attr('data-hotel-id')+'">\
                ');
            }else if($(this).attr('data-change') == 'stubaId'){
                $('#edit').val('yes');
                $(this).empty();
                $(this).html('\
                    <input type="text" class="form-control" id="changedData" value="'+$(this).attr('data-hotel')+'">\
                    <input type="hidden" id="changeProp" value="'+$(this).attr('data-change')+'">\
                    <input type="hidden" id="table" value="hotels">\
                    <input type="hidden" id="key" value="stuba_id">\
                    <input type="hidden" id="updateKey" value="id">\
                    <input type="hidden" id="hotels_id" value="'+$(this).attr('data-hotel-id')+'">\
                ');
            }else if($(this).attr('data-change') == 'state'){
                $('#edit').val('yes');
                $(this).empty();
                let hId = $(this).attr('data-hotel-id');
                let dc  = $(this).attr('data-change');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.get.state') }}',
                    data: {
                        '_token'    : '{{ csrf_token()}}',
                        'countryId' : $(this).attr('data-country'),
                        'stateId'   : $(this).attr('data-hotel'),
                    },
                    success: function(res){
                        $('.changeState'+hId).html(res+
                            '<input type="hidden" id="changeProp" value="'+dc+'">\
                            <input type="hidden" id="table" value="hotels">\
                            <input type="hidden" id="key" value="state_id">\
                            <input type="hidden" id="updateKey" value="id">\
                            <input type="hidden" id="hotels_id" value="'+hId+'">\
                        ');
                    }
                });
            }else if($(this).attr('data-change') == 'town'){
                $('#edit').val('yes');
                $(this).empty();
                $(this).html('\
                    <input type="text" class="form-control" id="changedData" value="'+$(this).attr('data-hotel')+'">\
                    <input type="hidden" id="changeProp" value="'+$(this).attr('data-change')+'">\
                    <input type="hidden" id="table" value="hotels">\
                    <input type="hidden" id="key" value="town">\
                    <input type="hidden" id="updateKey" value="id">\
                    <input type="hidden" id="hotels_id" value="'+$(this).attr('data-hotel-id')+'">\
                ');
            }else if($(this).attr('data-change') == 'curator'){
                $('#edit').val('yes');
                $(this).empty();
                $(this).html('\
                    <input type="text" class="form-control" id="changedData" value="'+$(this).attr('data-hotel')+'">\
                    <input type="hidden" id="changeProp" value="'+$(this).attr('data-change')+'">\
                    <input type="hidden" id="table" value="hotels">\
                    <input type="hidden" id="key" value="curator_rating">\
                    <input type="hidden" id="updateKey" value="id">\
                    <input type="hidden" id="hotels_id" value="'+$(this).attr('data-hotel-id')+'">\
                ');
            }
        }
    });
});
function saveData(){
    let changedData = $("#changedData").val();
    let changeProp  = $("#changeProp").val();
    let hotel_id    = $("#hotels_id").val();
    $.ajax({
        type: 'POST',
        url: '{{ route('admin.edit.direct.contact') }}',
        data: {
            '_token'        : '{{ csrf_token()}}',
            'changedData'   : changedData,
            'changeProp'    : changeProp,
            'table'         : $("#table").val(),
            'key'           : $("#key").val(),
            'updateKey'     : $("#updateKey").val(),
            'hotel_id'      : hotel_id,
        },
        dataType: "json",
        beforeSend: function () {
            $("#myTable").loading();
            $('#edit').val('no');
        },
        success: function(res){
            $("#myTable").loading('stop');
            if(changeProp == 'hotelName'){
                $(".changeData"+hotel_id).empty();
                $(".changeData"+hotel_id).html('<p style="width: 200px;">'+changedData+'</p>');
                $(".changeData"+hotel_id).attr('data-hotel', changedData);
            }else if(changeProp == 'stubaId'){
                $(".changeStuba"+hotel_id).empty();
                $(".changeStuba"+hotel_id).html(changedData);
                $(".changeStuba"+hotel_id).attr('data-hotel', changedData);
            }else if(changeProp == 'state'){
                $(".changeState"+hotel_id).empty();
                $(".changeState"+hotel_id).html(res.stateNm);
                $(".changeState"+hotel_id).attr('data-hotel', changedData);
            }else if(changeProp == 'town'){
                $(".changeTown"+hotel_id).empty();
                $(".changeTown"+hotel_id).html(changedData);
                $(".changeTown"+hotel_id).attr('data-hotel', changedData);
            }else if(changeProp == 'curator'){
                $(".changeCurator"+hotel_id).empty();
                $(".changeCurator"+hotel_id).html(changedData);
                $(".changeCurator"+hotel_id).attr('data-hotel', changedData);
            }
        }
    });
}
$(document).on('keypress', function (e) {
    if (e.keyCode == 13) {
        if($('#edit').val() == 'yes'){
            saveData();
        }
    }
});


$(document).ready(function(){
$("#pruebatabla").CongelarFilaColumna({lboHoverTr:true});
 var mode = 0;
    $("#fullview").click(function(){
     if(mode==0){
        $(".sidebar").css('display','none');
        $(".main-panel").css('width','calc(100% - 0px)');
        mode=1; 
      }else{
        $(".sidebar").css('display','block');
        $(".main-panel").css('width','calc(100% - 260px)');
        mode=0;
      }
    }); 
});

function nameSearch() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("hotel_name");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  var st =0;
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if(txtValue.toUpperCase().indexOf(filter) > -1) {
           tr[i].style.display = "";
           st++;
           $('#not_found').css('display','none');
      }else {
        tr[i].style.display = "none";
        if(st==0){
            $('#not_found').css('display','block');
          }
      }
    }       
  }
}
function stateSearch(){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("select_state");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  var st =0;
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[5];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        st++;
           $('#not_found').css('display','none');
      } else {
        tr[i].style.display = "none";
        if(st==0){
              $('#not_found').css('display','block');
          }
      }
    }       
  }
}
function countrySearch(){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("select_country");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  var st =0;
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[4];
    if (td) {
        
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        st++;
           $('#not_found').css('display','none');
      } else {
         tr[i].style.display = "none";
          if(st==0){
              $('#not_found').css('display','block');
          }
      }
    }       
  }
  
}
    $(document).ready(function(){

        $('input[name="check1"]').click(function(){
            if($(this).prop("checked") == true){
                //alert(this.value);
                $('#editdiv').css('display','block');
                $('#editbtn').attr("href", this.value);
                 //window.location.href = this.value;
            }
            else if($(this).prop("checked") == false){
                 $('#editdiv').css('display','none');
                 $('#editbtn').attr("href", '');
            }

        });
      $('.check1').click(function() {
        $('.check1').not(this).prop('checked', false);
    });
    });
</script>
@endsection