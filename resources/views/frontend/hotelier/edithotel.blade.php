@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/css/fileinput.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
<style>
/* Always set the map height explicitly to define the size of the div
* element that contains the map. */
#map {
height: 250px;
}
/* Optional: Makes the sample page fill the window. */
#infowindow-content .title {
font-weight: bold;
}
#infowindow-content {
display: none;
}
#map #infowindow-content {
display: inline;
}
</style>
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
    @include('frontend.layouts.hotelier_sidenav')
    <div class="dashboard_content">
        <h1>{{ $hotels->hotels_name }}</h1>
        @include('frontend.layouts.messages')
        <div class="user_panel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#one">General Information</a></li>
                <li><a data-toggle="tab" href="#two">Property Data</a></li>
                <li><a data-toggle="tab" href="#three">Property Images</a></li>
            </ul>
            <div class="wizard">
                <div class="tab-content">
                    <div id="one" class="tab-pane fade in active">
                        <form enctype="multipart/form-data" id="tabOneEditHotel">
                            <input type="hidden" name="form_no" value="1">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Luxury Fishing ID Number (eg LF1234) <span class="required">*</span></label>
                                        <input type="text" name="hotel_token" class="form-control requiredCheck" data-check="Hotel Token" value="{{ $hotels->hotel_token }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Property Name  <span class="required">*</span><em style="font-size: 12px;color: #3fa7f1;">(To be displayed on website)</em></label>
                                        <input type="text" id="hotels_name" name="hotels_name" class="form-control requiredCheck" data-check="Name" value="{{ $hotels->hotels_name }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Physical Address <span class="required">*</span><em
                                                style="font-size: 12px;color: #3fa7f1;">(for GPS location – must not be a P.O.Box or separate mailing
                                                address)</em></label>
                                        <input type="text" id="address" name="address" class="form-control requiredCheck" data-check="Hotel Address"
                                            value="{{ $hotels->address }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Mailing Address Same As Hotel Address?</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="checkbox" class="form-control@ sameMailAddress">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Mailing Address <span class="required">*</span><em
                                                style="font-size: 12px;color: #3fa7f1;">if different to the above address</em></label>
                                        <input type="text" name="mailing_address" id="mailing_address" class="form-control requiredCheck"
                                            data-check="Mailing Address" value="{{ $hotels->mailing_address }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Property Website</label>
                                        <input type="text" id="website" name="website" class="form-control" value="{{ $hotels->website }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Reservations Email Address <span class="required">*</span><em
                                                style="font-size: 12px;color: #3fa7f1;">(for booking notification)</em></label>
                                        <input type="text" id="email_id" name="email_id" class="form-control requiredCheck" data-check="Email"
                                            value="{{ $hotels->email_id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Property Phone Number <span class="required">*</span></label>
                                        <input type="text" name="phone" class="form-control isPhone requiredCheck" data-check="Property Phone Number"
                                            value="{{ $hotels->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Region <span class="required">*</span><em
                                                style="font-size: 12px;color: #3fa7f1;">(Select on of the following (tick box)</em></label>
                                        <select id="region_id" class="form-control requiredCheck" data-check="Region" name="region_id">
                                            <?php @regionOption($hotels->region_id); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Country <span class="required">*</span></label>
                                        <select id="country_id" class="form-control requiredCheck" data-check="Country" name="country_id"
                                            onchange="getState(this.value);">
                                            <?php @countryOption($hotels->country_id); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">State / District <span class="required">*</span></label>
                                        <select id="state_id" class="form-control requiredCheck" data-check="State" name="state_id">
                                            <?php @stateOption($hotels->state_id); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Town <span class="required">*</span><em
                                                style="font-size: 12px;color: #3fa7f1;">(nearest to property)</em></label>
                                        <input type="text" id="town" name="town" class="form-control requiredCheck" data-check="Town"
                                            value="{{ $hotels->town }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nearest Airport <em style="font-size: 12px;color: #3fa7f1;">(Name and IATA code)</em></label>
                                        <input type="text" id="nearest_airport" name="nearest_airport" class="form-control" value="{{ $hotels->nearest_airport }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Distance to Nearest Airport <em style="font-size: 12px;color: #3fa7f1;">(specify kms or miles)</em></label>
                                        <input type="text" id="distance_airport" name="distance_airport" class="form-control" value="{{ $hotels->distance_airport }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Transfers <em style="font-size: 12px;color: #3fa7f1;">(include airport transfers offered to guests and alternative options)</em></label>
                                        <input type="text" id="transfers_mode" name="transfers_mode" class="form-control" value="{{ $hotels->transfers_mode }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Location</label>
                                        <div id="map"></div>
                                        <div id="infowindow-content">
                                            <img src="" width="16" height="16" id="place-icon">
                                            <span id="place-name" class="title"></span><br>
                                            <span id="place-address"></span>
                                        </div>
                                        <input type="hidden" name="latitude" id="latitude"
                                            value="@if(isset($hotels->latitude)){{ $hotels->latitude }}@else {{ '' }}@endif">
                                        <input type="hidden" name="longitude" id="longitude"
                                            value="@if(isset($hotels->longitude)){{ $hotels->longitude }}@else {{ '' }}@endif">
                                        <input type="hidden" name="street_number" id="street_number"
                                            value="@if(isset($hotels->street_number)){{ $hotels->street_number }}@else {{ '' }}@endif">
                                        <input type="hidden" name="route" id="route"
                                            value="@if(isset($hotels->route)){{ $hotels->route }}@else {{ '' }}@endif">
                                        <input type="hidden" name="locality" id="locality"
                                            value="@if(isset($hotels->city)){{ $hotels->city }}@else {{ '' }}@endif">
                                        <input type="hidden" name="administrative_area_level_1" id="administrative_area_level_1"
                                            value="@if(isset($hotels->state)){{ $hotels->state }}@else {{ '' }}@endif">
                                        <input type="hidden" name="country" id="country"
                                            value="@if(isset($hotels->country)){{ $hotels->country }}@else {{ '' }}@endif">
                                        <input type="hidden" name="postal_code" id="postal_code"
                                            value="@if(isset($hotels->zip_code)){{ $hotels->zip_code }}@else {{ '' }}@endif">
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                  <button type="submit" class="btn btn-success btn-lg">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="two" class="tab-pane fade">
                        <!-- <form action="{{ route('user.hotels.update.new', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="tabTwoEditHotel"> -->
                        <form  enctype="multipart/form-data" id="tabTwoEditHotel">
                            <input type="hidden" name="form_no" value="2">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" data-toggle="tooltip" data-placement="bottom" title="Please note that we provide a very brief property description which precedes your description.  We suggest that you view the finished display on our website and if required edit your description to avoid repetition, to improve flow and to ensure that your property is described truthfully in its best light)">Property Description <span class="required">*</span><em style="font-size: 12px;color: #3fa7f1;">(must be written in the Third Person – do not use terms such as “we” “us” “our” etc. )</em></label>
                                        <textarea class="form-control ckeditor requiredCheckTwo" data-check="Property Description" name="hotels_desc" id="hotels_desc">{{ $hotels->hotels_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Brief Description</label>
                                        <textarea class="form-control ckeditor" name="brief_descp" id="brief_descp">{{ $hotels->brief_descp }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h3>Answer Yes or No to which of these features are applicable to your property</h3>
                                        <label class="bmd-label-floating">Do you have a Beach on or adjacent to your site</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="beach_availability" value="1" {{ ($hotels->beach_availability) ? 'checked' : '' }}>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="beach_availability" value="0" {{ (!$hotels->beach_availability) ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Do you offer Fine Dining at your Restaurant</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="fine_dining_availability" value="1"
                                                {{ ($hotels->fine_dining_availability) ? 'checked' : '' }}>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="fine_dining_availability" value="0"
                                                {{ (!$hotels->fine_dining_availability) ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Do you have a Spa on site</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="spa_availability" value="1" id="spa_availability"
                                                {{ ($hotels->spa_availability) ? 'checked' : '' }}>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="spa_availability" value="0" id="spa_availability"
                                                {{ (!$hotels->spa_availability) ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 spaDiv {{ ($hotels->spa_availability == '0') ? 'hide' : '' }}">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Spa Type</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="spa_type" value="Spa" {{ ($hotels->spa_type == 'Spa') ? 'checked' : '' }}>Spa
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="spa_type" value="In-room spa services"
                                                {{ ($hotels->spa_type == 'In-room spa services') ? 'checked' : '' }}>In-room spa services
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="spa_type" value="In-room Massage services"
                                                {{ ($hotels->spa_type == 'In-room Massage services') ? 'checked' : '' }}>In-room Massage services
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="spa_type" value="In-room beauty treatments"
                                                {{ ($hotels->spa_type == 'In-room beauty treatments') ? 'checked' : '' }}>In-room beauty treatments
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Do you have a Pool on site</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="pool" value="yes" id="pool" {{ ($hotels->pool == 'yes') ? 'checked' : '' }}>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="pool" value="no" id="pool" {{ ($hotels->pool == 'no') ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 poolDiv {{ ($hotels->pool == 'no') ? 'hide' : '' }}">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Pool Type</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="pool_type" value="Pool" id="pool_type"
                                                {{ ($hotels->pool_type == 'Pool') ? 'checked' : '' }}>Pool
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="pool_type" value="Pools" id="pool_type"
                                                {{ ($hotels->pool_type == 'Pools') ? 'checked' : '' }}>(number) Pools
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="pool_type" value="Pools with separate children’s pool" id="pool_type"
                                                {{ ($hotels->pool_type == 'Pools with separate children’s pool') ? 'checked' : '' }}>(number) Pools
                                            with separate children’s pool
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 poolDiv {{ ($hotels->pool == 'no') ? 'hide' : '' }}">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Number of Pools</label>
                                        <input type="text" id="no_of_pools" name="no_of_pools" class="form-control isNumber"
                                            value="{{ $hotels->no_of_pools }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Do you offer Watersports as a guest activity</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="water_sports" value="yes" {{ ($hotels->water_sports == 'yes') ? 'checked' : '' }}>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="water_sports" value="no" {{ ($hotels->water_sports == 'no') ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Do you offer Diving as a guest activity</label>&nbsp;&nbsp;&nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="diving" value="yes" {{ ($hotels->diving == 'yes') ? 'checked' : '' }}>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="diving" value="no" {{ ($hotels->diving == 'no') ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <h3>Amenities Services & Features</h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Total number of Rooms</label>
                                        <input type="text" id="no_of_rooms" name="no_of_rooms" class="form-control isNumber" value="{{ $hotels->no_of_rooms }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Number of Restaurants</label>
                                        <input type="text" id="no_of_restaurant" name="no_of_restaurant" class="form-control isNumber" value="{{ $hotels->no_of_restaurant }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Number of Floors</label>
                                        <input type="text" id="no_of_floor" name="no_of_floor" class="form-control isNumber" value="{{ $hotels->no_of_floor }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Key & Most Attractive Features offered by your property</label>
                                        <textarea class="form-control ckeditor" id="additional_information" name="additional_information">{{ $hotels->additional_information }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingSerFa">
                                                <h6 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSerFa" aria-expanded="true" aria-controls="collapseSerFa">
                                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                                        Services and Facilities
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="collapseSerFa" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSerFa">
                                                <div class="panel-body">
                                                    <ul style="list-style: none;">
                                                        <?php
                                                        $service_facility = (!empty($hotels->service_facility) || $hotels->service_facility != NULL) ? json_decode($hotels->service_facility, true) : array();
                                                        $checked = '';
                                                        if(!empty($hotels->servicefacility)):
                                                            foreach ($hotels->servicefacility as $sData):
                                                                $checked = (in_array($sData->name, $service_facility)) ? 'checked="checked"' : '';
                                                        ?>
                                                        <li class="col-md-4">
                                                            <label class="checkbox-inline">
                                                                <input class="form-check-input" type="checkbox" name="service_facilities_id[]"
                                                                    value="{{ $sData->name }}" {{ $checked }}>
                                                                {{ $sData->name }} <span class="form-check-sign"><span class="check"></span></span>
                                                            </label>
                                                        </li>
                                                        <?php 
                                                            endforeach;
                                                        endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingRoFac">
                                                <h6 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseRoFac" aria-expanded="true" aria-controls="collapseRoFac">
                                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                                        Room Facilities
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="collapseRoFac" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRoFac">
                                                <div class="panel-body">
                                                    <ul style="list-style: none;">
                                                        <?php
                                                        $checked        = '';
                                                        $room_facility  = (!empty($hotels->room_facility) || $hotels->room_facility != NULL) ? json_decode($hotels->room_facility, true) : array();
                                                        if(!empty($hotels->roomfacility)):
                                                            foreach ($hotels->roomfacility as $rData):
                                                                $checked = (in_array($rData->name, $room_facility)) ? 'checked="checked"' : '';
                                                        ?>
                                                        <li class="col-md-4">
                                                            <label class="checkbox-inline">
                                                                <input class="form-check-input" type="checkbox" name="room_facilities_id[]"
                                                                    value="{{ $rData->name }}" {{ $checked }}> {{ $rData->name }} <span
                                                                    class="form-check-sign"><span class="check"></span></span>
                                                            </label>
                                                        </li>
                                                        <?php 
                                                            endforeach;
                                                        endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Activities <em style="font-size: 12px;color: #3fa7f1;">List activities provided to guests (including children’s activity programs), separated by commas</em></label>
                                        <textarea class="form-control" name="activities" id="activities">{{ $hotels->activities }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Tours & External Activities <em style="font-size: 12px;color: #3fa7f1;">List tours and external activities arranged by your concierge for guests, separated by commas</em> </label>
                                        <textarea class="form-control" name="tours" id="tours">{{ $hotels->tours }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Dining <em style="font-size: 12px;color: #3fa7f1;">(must be written in the Third Person – do not use
                                        terms such as “we” “us” “our” etc. )</em></label>
                                        <textarea class="form-control ckeditor" name="dining" id="dining">{{ $hotels->dining }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Setting  <em style="font-size: 12px;color: #3fa7f1;">(must be written in the Third Person – do not use terms such as “we” “us” “our” etc. )</em></label>
                                        <textarea class="form-control ckeditor" name="highlights" id="highlights">{{ $hotels->highlights }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group text-center">
                                            <label class="bmd-label-floating">Nearby Attractions <em style="font-size: 12px;color: #3fa7f1;">List nearby attractions with travel distances from your property to each attraction</em></label>
                                        </div>
                                    </div>
                                    <?php
                                        $nearby_attraction  = json_decode($hotels->nearby_attraction, true);
                                        $distance           = json_decode($hotels->distance, true);
                                    ?>
                                    <div class="addMrAtrction">
                                        <?php
                                        if(!empty($nearby_attraction)):
                                            $cnt = 0;
                                            foreach($nearby_attraction as $nakey => $na):
                                        ?>
                                                <div class="col-md-5 attrction{{$nakey}}">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Attraction</label>
                                                        <input type="text" name="nearby_attraction[]" class="form-control" value="{{ $na }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-5 attrction{{$nakey}}">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Travel Distance</label>
                                                        <input type="text" name="distance[]" class="form-control" value="{{ $distance[$nakey] }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 attrction{{$nakey}}">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Action</label><br/>
                                                        <input type="button" class="btn btn-danger deleteMrAtrctionBtn" data-key="{{ $nakey }}" value="Remove">
                                                    </div>
                                                </div>
                                        <?php
                                            $cnt++;
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                    <input type="hidden" id="attrctionCnt" value="{{count($nearby_attraction)}}">
                                    <div class="col-sm-12 text-center">
                                        <div class="form-group text-center">
                                            <input type="button" class="btn btn-warning addMrAtrctionBtn" value="+ Add Attraction">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <h3>Fishing</h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Description <em style="font-size: 12px;color: #3fa7f1;">(must be written in the Third Person – do not use terms such as “we” “us” “our” etc. )</em></label>
                                        <textarea class="form-control" name="hotelfishing" rows="10">{{ $hotels->hotelfishing }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Do you provide bespoke fishing experiences for guests on site or
                                            nearby?</label>
                                        <select class="form-control" name="provide_on_site">
                                            <option value="yes" {{ ($hotels->provide_on_site == 'yes') ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="no" {{ ($hotels->provide_on_site == 'no') ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Is your concierge able to arrange fishing experiences for
                                            guests?</label>
                                        <select class="form-control" name="arrange_fishing_nearby">
                                            <option value="yes" {{ ($hotels->arrange_fishing_nearby == 'yes') ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="no" {{ ($hotels->arrange_fishing_nearby == 'no') ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Do you have exclusive arrangements with external fishing guides or
                                            fishing charter operators to provide fishing experiences for guests?</label>
                                        <select class="form-control" name="provide_our_curated">
                                            <option value="yes"
                                                {{ ($hotels->provide_our_curated == 'no') ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="no"
                                                {{ ($hotels->provide_our_curated == 'no') ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <h3>Important Information</h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Policy </label>
                                        <textarea class="form-control ckeditor" name="hotel_policy" id="hotel_policy">{{ $hotels->hotel_policy }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Check In Time</label>
                                        <input type="text" id="check_in" name="check_in" class="form-control time" value="{{ $hotels->check_in }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Check Out Time</label>
                                        <input type="text" id="check_out" name="check_out" class="form-control time" value="{{ $hotels->check_out }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Need To Know</label>
                                        <textarea class="form-control ckeditor" id="need_to_know" name="need_to_know">{{ $hotels->need_to_know }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <input type="submit" class="btn btn-success" name="update" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="three" class="tab-pane fade">
                        <form id="tabThreeEditHotel" enctype="multipart/form-data">
                            <input type="hidden" name="form_no" value="3">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Featured Image </label>
                                        <br />
                                        <input type="hidden" name="old_featured_image" value="{{$hotels->featured_image}}">
                                        <?php if($hotels->featured_image != NULL || !empty($hotels->featured_image)): ?>
                                        <img src="{{ url('public/uploads/' . $hotels->featured_image)}}" alt="{{ $hotels->hotels_name }}"
                                            style="height: 150px; width:auto;">
                                        <br /><br /><br />
                                        <?php endif; ?>
                                        <input type="file" name="featured_image" class="form-control" style="position: static !important;">
                                    </div>
                                </div>
                            </div>
                            <div class="row hotelImageDiv">
                                <?php
                                $image_gallery  = (!empty($hotels->image_gallery) || $hotels->image_gallery != NULL) ? json_decode($hotels->image_gallery, true) : array();
                                $image_alt      = (!empty($hotels->image_alt) || $hotels->image_alt != NULL) ? json_decode($hotels->image_alt, true) : array();
                                $image_seq      = (!empty($hotels->image_sequence) || $hotels->image_sequence != NULL) ? json_decode($hotels->image_sequence, true) : array();
                                if(!empty($image_gallery)) :
                                    foreach($image_gallery as $rgKey => $rg):
                                        if(!empty($rg)):
                                ?>
                                <div class="col-sm-3 roomImg<?=$rgKey?>" style="height: 150px; max-height: 150px;">
                                    <div class="form-group">
                                        <label>Hotel Gallery Image </label>
                                        <br />
                                        <img src="{{ url('public/uploads/' . $rg)}}" alt="{{ $hotels->hotels_name }}"
                                            style="height: 90px; width:auto;">
                                        <input type="hidden" name="old_gallery_image[]" value="{{$rg}}">
                                    </div>
                                </div>
                                <div class="col-sm-3 roomImg<?=$rgKey?>" style="height: 150px; max-height: 150px;">
                                    <div class="form-group">
                                        <label>Image Location in Sequence <em style="font-size: 12px;color: #3fa7f1;">(Use numeral 1 for 
                                            first, 2 for second etc)</em></label>
                                        <input type="text" name="old_gallery_image_seq[]" class="form-control isNumber"
                                        value="{{$image_seq[$rgKey] }}">
                                    </div>
                                </div>
                                <div class="col-sm-4 roomImg<?=$rgKey?>" style="height: 150px; max-height: 150px;">
                                    <div class="form-group">
                                        <label>Image Alt Text <em style="font-size: 12px;color: #3fa7f1;">Property Name followed by brief 
                                            text describing the image ” (max 50 characters )</em></label>
                                        <textarea name="old_gallery_image_alt[]" class="form-control imageAlt"
                                            rows="3">{{$image_alt[$rgKey] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-2 roomImg<?=$rgKey?>" style="height: 150px; max-height: 150px;">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Action</label><br />
                                        <input type="button" class="btn btn-danger deleteMrImgBtn deleteFromDb" data-key="<?=$rgKey?>"
                                            value="Remove">
                                    </div>
                                </div>
                                <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                            </div>
                            <div class="row">
                                <input type="hidden" id="imgCnt" value="{{count($image_gallery)}}">
                                <div class="col-sm-12 text-center">
                                    <div class="form-group text-center">
                                        <input type="button" class="btn btn-warning addMrImgBtn" value="+ Add Hotel Gallery Image">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <input type="submit" class="btn btn-success" name="update" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/js/fileinput.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="{{ asset('js/jquery.loading.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/common-function.js') }}"></script>
<script type="text/javascript">
$(document).on('click', '.addMrImgBtn', function() {
    let key = parseInt($('#imgCnt').val()) + parseInt(1);
    $('#imgCnt').val(key);
    $('.hotelImageDiv').append('\
                                <div class="col-sm-3 roomImg'+key+'" style="height: 150px; max-height: 150px;">\
                                    <div class="form-group">\
                                        <label>Hotel Gallery Image <em style="font-size: 12px;color: #3fa7f1;">Your images should all \
                                        be high quality (from min"150px to max:150px)</em></label>\
                                        <input type="file" name="gallery_image[]" class="form-control">\
                                    </div>\
                                </div>\
                                <div class="col-sm-3 roomImg'+key+'" style="height: 150px; max-height: 150px;">\
                                    <div class="form-group">\
                                        <label>Image Location in Sequence <em style="font-size: 12px;color: #3fa7f1;">(Use numeral 1 for \
                                            first, 2 for second etc)</em></label>\
                                        <input type="text" name="gallery_image_seq[]" class="form-control isNumber">\
                                    </div>\
                                </div>\
                                <div class="col-sm-4 roomImg'+key+'" style="height: 150px; max-height: 150px;">\
                                    <div class="form-group">\
                                        <label>Image Alt Text <em style="font-size: 12px;color: #3fa7f1;">Property Name followed by brief \
                                        text describing the image ” (max 50 characters )</em>\
                                        <textarea name="gallery_image_alt[]" class="form-control imageAlt" rows="3"></textarea>\
                                    </div>\
                                </div>\
                                <div class="col-md-2 roomImg'+key+'" style="height: 150px; max-height: 150px;">\
                                    <div class="form-group">\
                                        <label class="bmd-label-floating">Action</label><br/>\
                                        <input type="button" class="btn btn-danger deleteMrImgBtn" data-key="'+key+'" value="Remove">\
                                    </div>\
                                </div>');
});
$(document).on('click', '.deleteMrImgBtn', function() {
    if($(this).hasClass('deleteFromDb')){
        Swal.fire({
    		title: "Are you sure want to delete image?",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: "#dd6b55",
    		cancelButtonColor: "#48cab2",
    		confirmButtonText: "Yes !!!",
    	}).then((result) => {
    		if (result.value) {
    			let imgId   = $(this).attr('data-img-id');
                let dataKey = $(this).attr('data-key');
                $.ajax({
                    type: "POST",
                    url: "{{ route('hotelier.delete.hotel.image') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "imgId" : imgId
                    },
                    beforeSend  : function () {
                        $('.roomImg' + dataKey).loading();
                    },
                    success: function(data){
                        $('.roomImg' + dataKey).loading('stop');
                        $('.roomImg' + dataKey).remove();
                    }
                });
    		}
    	});
    }else{
        $('.roomImg' + $(this).attr('data-key')).remove();
    }
});
$(document).on('submit', '#tabThreeEditHotel', function(e) {
    e.preventDefault();
    //let flag            = commonFormChecking(true);
    let flag            = true;
    if (flag) {
        if($(".imageAlt").length){
            $('.imageAlt').each(function () {
                if($(this).val().length > '50'){
                    swalAletr('Image Alt Text can\'t be greater than 50 chars !!!', 'warning', 5000);
                    flag = false;
                    return false;
                }
            });
        }
        if (flag) {
            let formData    = new FormData(this);
            let redirect    = "{{ route('user.hotels.edit', ['id' => $hotels->id]) }}";
            $.ajax({
                type        : "POST",
                url         : "{{ route('user.hotels.update.new', ['id' => $hotels->id]) }}",
                data        : formData,
                cache       : false,
                contentType : false,
                processData : false,
                beforeSend  : function () {
                    $("#tabThreeEditHotel").loading();
                },
                success     : function (res) {
                    $("#tabThreeEditHotel").loading("stop");
                    swalAlertThenRedirect('Hotel Details Updated Successfully !!!', 'success', redirect);
                },
            });
        }
    }
});
$(document).on('submit', '#tabTwoEditHotel', function(e) {
    e.preventDefault();
    let flag            = commonFormChecking(true, 'requiredCheckTwo');
    if (flag) {
        let formData    = new FormData(this);
        let redirect    = "{{ route('user.hotels.edit', ['id' => $hotels->id]) }}";
        $.ajax({
            type        : "POST",
            url         : "{{ route('user.hotels.update.new', ['id' => $hotels->id]) }}",
            data        : formData,
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend  : function () {
                $("#tabTwoEditHotel").loading();
            },
            success     : function (res) {
                $("#tabTwoEditHotel").loading("stop");
                swalAlert('Hotel Details Updated Successfully !!!', 'success', 5000);
                //swalAlertThenRedirect('Hotel Details Updated Successfully !!!', 'success', redirect);
            },
        });
    }
});
$(document).on('submit', '#tabOneEditHotel', function(e) {
    e.preventDefault();
    let flag            = commonFormChecking(true);
    if (flag) {
        let formData    = new FormData(this);
        $.ajax({
            type        : "POST",
            url         : "{{ route('user.hotels.update.new', ['id' => $hotels->id]) }}",
            data        : formData,
            cache       : false,
            contentType : false,
            processData : false,
            //dataType    : "JSON",
            beforeSend  : function () {
                $("#tabOneEditHotel").loading();
            },
            success     : function (res) {
                $("#tabOneEditHotel").loading("stop");
                //swalAlert(res.message, res.swal, 5000);
                swalAlert('Hotel Details Updated Successfully !!!', 'success', 5000);
            },
        });
    }
});
$(document).on('click', '.addMrAtrctionBtn', function() {
    let key = parseInt($('#attrctionCnt').val()) + parseInt(1);
    $('#attrctionCnt').val(key);
    $('.addMrAtrction').append('\
                                <div class="col-md-5 attrction'+key+'">\
                                    <div class="form-group">\
                                        <label class="bmd-label-floating">Attraction</label>\
                                        <input type="text" name="nearby_attraction[]" class="form-control">\
                                    </div>\
                                </div>\
                                <div class="col-md-5 attrction'+key+'">\
                                    <div class="form-group">\
                                        <label class="bmd-label-floating">Travel Distance</label>\
                                        <input type="text" name="distance[]" class="form-control">\
                                    </div>\
                                </div>\
                                <div class="col-md-2 attrction'+key+'">\
                                    <div class="form-group">\
                                        <label class="bmd-label-floating">Action</label><br/>\
                                        <input type="button" class="btn btn-danger deleteMrAtrctionBtn" data-key="'+key+'" value="Remove">\
                                    </div>\
                                </div>');
});
$(document).on('click', '.deleteMrAtrctionBtn', function() {
    $('.attrction' + $(this).attr('data-key')).remove();
});
$(document).on('click', '.sameMailAddress', function() {
    if ($(this).is(":checked")) {
        if($('#address').val() != ''){
            $('#mailing_address').val($('#address').val());
        }else{
            swalAlert('Please Add Hotel Address First !!!', 'warning', 5000);
        }
    }else{
        $('#mailing_address').val('');
    }
});
$(document).on('change', '#spa_availability', function() {
    if ($(this).val() == '1') {
        if($('.spaDiv').hasClass('hide')){
            $('.spaDiv').removeClass('hide');
        }
    }else{
        if(!$('.spaDiv').hasClass('hide')){
            $('.spaDiv').addClass('hide');
        }
    }
});
$(document).on('change', '#pool', function() {
    if ($(this).val() == 'yes') {
        if($('.poolDiv').hasClass('hide')){
            $('.poolDiv').removeClass('hide');
        }
    }else{
        if(!$('.poolDiv').hasClass('hide')){
            $('.poolDiv').addClass('hide');
        }
    }
});
function getState(id){
    $.ajax({
        type: "POST",
        url: "{{ route('admin.get_state') }}",
        data:{
            "_token": "{{ csrf_token() }}",
            "country_id": id
        },
        success: function(data){
            $('#state_id').html(data);
        }
    });
}
$(function () {
    $('.time').datetimepicker({
        format: 'LT'
    });
});
var componentForm = {
    street_number: 'long_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    country: 'long_name',
    postal_code: 'short_name'
};
function initMap() {
    var map = null;
    var myMarker;
    var myLatlng;
    //initializeGMap($('#address').val());
    let address = $('#address').val()
    if(address != ''){
        address = address.replace("%20", "+");
        $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&address='+address+'&sensor=false', null, function (data) {
            var p = data.results[0].geometry.location;
            myLatlng = new google.maps.LatLng(p.lat, p.lng);
            var myOptions = {
                                zoom: 16,
                                zoomControl: true,
                                center: myLatlng,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            };
            map = new google.maps.Map(document.getElementById("map"), myOptions);
            myMarker = new google.maps.Marker({
                position: myLatlng
            });
            myMarker.setMap(map);
        });
        }
        
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -33.8688, lng: 151.2195},
        zoom: 15
    });
    var input = document.getElementById('address');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    // Set the data fields to return when the user selects a place.
    autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);
    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
        if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
        }
        infowindowContent.children['place-icon'].src = place.icon;
        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent = address;
        infowindow.open(map, marker);
    });
    @if(isset($hoteladdress->latitude) && isset($hoteladdress->longitude))
        var uluru = { lat: {{ $hoteladdress->latitude }}, lng: {{ $hoteladdress->longitude }} };
        var map = new google.maps.Map(
        document.getElementById('map'), {zoom: 17, center: uluru});
        var marker = new google.maps.Marker({position: uluru, map: map});
    @endif
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&libraries=places&callback=initMap"
async defer></script>
<script>
    $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
@endsection