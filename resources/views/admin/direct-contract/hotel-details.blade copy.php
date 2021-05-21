@extends('admin.layouts.master')
@section('th_head')
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
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">{{ $hotels->hotels_name }}
                <div class="float-right"></div>
            </div>
            <div class="card-body table-responsive">
                @include('admin.layouts.messages')
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
                                                <label class="bmd-label-floating">Hotel Token <span class="required">*</span></label>
                                                <input type="text" name="hotel_token" class="form-control requiredCheck" data-check="Hotel Token" value="{{ $hotels->hotel_token }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Name <span class="required">*</span></label>
                                                <input type="text" id="hotels_name" name="hotels_name" class="form-control requiredCheck" data-check="Name" value="{{ $hotels->hotels_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Nearest Airport</label>
                                                <input type="text" id="nearest_airport" name="nearest_airport" class="form-control" value="{{ $hotels->nearest_airport }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Distance Airport To Hotel</label>
                                                <input type="text" id="distance_airport" name="distance_airport" class="form-control" value="{{ $hotels->distance_airport }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Transfers</label>
                                                <input type="text" id="transfers_mode" name="transfers_mode" class="form-control" value="{{ $hotels->transfers_mode }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Region <span class="required">*</span></label>
                                                <select id="region_id" class="form-control requiredCheck" data-check="Region" name="region_id">
                                                <?php @regionOption($hotels->region_id); ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Country <span class="required">*</span></label>
                                                <select id="country_id" class="form-control requiredCheck" data-check="Country" name="country_id" onchange="getState(this.value);">
                                                <?php @countryOption($hotels->country_id); ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">State <span class="required">*</span></label>
                                                <select id="state_id" class="form-control requiredCheck" data-check="State" name="state_id">
                                                <?php @stateOption($hotels->state_id); ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Town <span class="required">*</span></label>
                                                <input type="text" id="town" name="town" class="form-control requiredCheck" data-check="Town" value="{{ $hotels->town }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Reservations Email Address  <span class="required">*</span></label>
                                                <input type="text" id="email_id" name="email_id" class="form-control requiredCheck" data-check="Email" value="{{ $hotels->email_id }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Hotel Website</label>
                                                <input type="text" id="website" name="website" class="form-control" value="{{ $hotels->hotelcontact->website }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Hotel Address <span class="required">*</span></label>
                                                <input type="text" id="address" name="address" class="form-control requiredCheck" data-check="Hotel Address" value="{{ $hotels->hotelcontact->address }}">
                                            </div>
                                            <div class="form-group">
                                                <div id="map"></div>
                                                <div id="infowindow-content">
                                                    <img src="" width="16" height="16" id="place-icon">
                                                    <span id="place-name"  class="title"></span><br>
                                                    <span id="place-address"></span>
                                                </div>
                                                <input type="hidden" name="latitude" id="latitude" value="@if(isset($hotels->hoteladdress->latitude)){{ $hotels->hoteladdress->latitude }}@else {{ '' }}@endif">
                                                <input type="hidden" name="longitude" id="longitude" value="@if(isset($hotels->hoteladdress->longitude)){{ $hotels->hoteladdress->longitude }}@else {{ '' }}@endif">
                                                <input type="hidden" name="street_number" id="street_number" value="@if(isset($hotels->hoteladdress->street_number)){{ $hotels->hoteladdress->street_number }}@else {{ '' }}@endif">
                                                <input type="hidden" name="route" id="route" value="@if(isset($hotels->hoteladdress->route)){{ $hotels->hoteladdress->route }}@else {{ '' }}@endif">
                                                <input type="hidden" name="locality" id="locality" value="@if(isset($hotels->hoteladdress->city)){{ $hotels->hoteladdress->city }}@else {{ '' }}@endif">
                                                <input type="hidden" name="administrative_area_level_1" id="administrative_area_level_1" value="@if(isset($hotels->hoteladdress->state)){{ $hotels->hoteladdress->state }}@else {{ '' }}@endif">
                                                <input type="hidden" name="country" id="country" value="@if(isset($hotels->hoteladdress->country)){{ $hotels->hoteladdress->country }}@else {{ '' }}@endif">
                                                <input type="hidden" name="postal_code" id="postal_code" value="@if(isset($hotels->hoteladdress->zip_code)){{ $hotels->hoteladdress->zip_code }}@else {{ '' }}@endif">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Mailing Address Same As Hotel Address?</label>&nbsp;&nbsp;&nbsp;
                                                <label class="radio-inline">
                                                    <input type="checkbox" class="form-control@ sameMailAddress">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Mailing Address <span class="required">*</span></label>
                                                <input type="text" name="mailing_address" id="mailing_address" class="form-control requiredCheck" data-check="Mailing Address" value="{{ $hotels->hotelcontact->address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-lg">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="two" class="tab-pane fade">
                                <form action="{{ route('admin.hotels.update.new', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="tabTwoEditHotel">
                                    <input type="hidden" name="form_no" value="2">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Property Description <span class="required">*</span></label>
                                                <textarea class="form-control ckeditor" name="hotels_desc" id="hotels_desc">{{ $hotels->hotels_desc }}</textarea>
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
                                                <label class="bmd-label-floating">Do you have a Beach on or adjacent to your site?</label>&nbsp;&nbsp;&nbsp;
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
                                                <label class="bmd-label-floating">Do you offer Fine Dining at your Restaurant?</label>&nbsp;&nbsp;&nbsp;
                                                <label class="radio-inline">
                                                    <input type="radio" name="fine_dining_availability" value="1" {{ ($hotels->fine_dining_availability) ? 'checked' : '' }}>Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="fine_dining_availability" value="0" {{ (!$hotels->fine_dining_availability) ? 'checked' : '' }}>No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Do you offer Watersports as a guest activity?</label>&nbsp;&nbsp;&nbsp;
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
                                                <label class="bmd-label-floating">Do you offer Diving as a guest activity?</label>&nbsp;&nbsp;&nbsp;
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
                                            <div class="form-group text-center">
                                                <label class="bmd-label-floating">Amenities Services & Features</label>
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
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Do you have a Spa on site?</label>
                                                <select class="form-control" name="spa_availability" id="spa_availability">
                                                    <option value="1" {{ ($hotels->spa_availability == '1') ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ ($hotels->spa_availability == '0') ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 spaDiv {{ ($hotels->spa_availability == '0') ? 'hide' : '' }}">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Spa Type</label>
                                                <select class="form-control" name="spa_type">
                                                    <option value="Spa" {{ ($hotels->spa_type == 'Spa') ? 'selected' : '' }}>Spa</option>
                                                    <option value="In-room spa services" {{ ($hotels->spa_type == 'In-room spa services') ? 'selected' : '' }}>In-room spa services</option>
                                                    <option value="In-room Massage services" {{ ($hotels->spa_type == 'In-room Massage services') ? 'selected' : '' }}>In-room Massage services</option>
                                                    <option value="In-room beauty treatments" {{ ($hotels->spa_type == 'In-room beauty treatments') ? 'selected' : '' }}>In-room beauty treatments</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Do you have a Pool on site?</label>
                                                <select class="form-control" name="pool" id="pool">
                                                    <option value="yes" {{ ($hotels->pool == 'yes') ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ ($hotels->pool == 'no') ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 poolDiv {{ ($hotels->pool == 'no') ? 'hide' : '' }}">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Pool Type</label>
                                                <select class="form-control" name="pool_type" id="pool_type">
                                                    <option value="Pool" {{ ($hotels->pool_type == 'Pool') ? 'selected' : '' }}>Pool</option>
                                                    <option value="Pools" {{ ($hotels->pool_type == 'Pools') ? 'selected' : '' }}>(number) Pools</option>
                                                    <option value="Pools with separate children’s pool" {{ ($hotels->pool_type == 'Pools with separate children’s pool') ? 'selected' : '' }}>(number) Pools with separate children’s pool</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 poolDiv {{ ($hotels->pool == 'no') ? 'hide' : '' }}">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Number of Pools</label>
                                                <input type="text" id="no_of_pools" name="no_of_pools" class="form-control isNumber" value="{{ $hotels->no_of_pools }}">
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
                                                                @foreach ($hotels->servicefacility as $sData)
                                                                <?php $checked = '';  ?>
                                                                    @foreach ($hotels->servicefacilities_relations as $sR)
                                                                        @if ($sData->id == $sR['service_facilities_id'])
                                                                            <?php $checked .= 'checked="checked"';  ?>
                                                                        @endif
                                                                    @endforeach
                                                                    <li class="col-md-4">
                                                                        <label class="checkbox-inline">
                                                                        <input class="form-check-input" type="checkbox" name="service_facilities_id[]" value="{{ $sData->id }}" {{ $checked }}> {{ $sData->name }} <span class="form-check-sign"><span class="check"></span></span>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
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
                                                                @foreach ($hotels->roomfacility as $rData)
                                                                <?php $checked = '';  ?>
                                                                    @foreach ($hotels->roomfacilities_relations as $rR)
                                                                        @if ($rData->id == $rR['room_facilities_id'])
                                                                            <?php $checked .= 'checked="checked"';  ?>
                                                                        @endif
                                                                    @endforeach
                                                                    <li class="col-md-4">
                                                                        <label class="checkbox-inline">
                                                                        <input class="form-check-input" type="checkbox" name="room_facilities_id[]" value="{{ $rData->id }}" {{ $checked }}> {{ $rData->name }} <span class="form-check-sign"><span class="check"></span></span>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Activities </label>
                                                <textarea class="form-control ckeditor" name="activities" id="activities">{{ $hotels->activities }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Tours & External Activities </label>
                                                <textarea class="form-control ckeditor" name="tours" id="tours">{{ $hotels->tours }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Dining </label>
                                                <textarea class="form-control ckeditor" name="dining" id="dining">{{ $hotels->dining }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Setting </label>
                                                <textarea class="form-control ckeditor" name="highlights" id="highlights">{{ $hotels->highlights }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group text-center">
                                                    <label class="bmd-label-floating">Nearby Attractions</label>
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
                                            <div class="form-group text-center">
                                                <label class="bmd-label-floating">Fishing</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Description</label>
                                                <textarea class="form-control" name="booking_cnf" rows="10">{{ !empty($hotels->hotelfishing) ? $hotels->hotelfishing['booking_cnf'] : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Do you provide bespoke fishing experiences for guests on site or nearby?</label>
                                                <select class="form-control" name="provide_on_site">
                                                    <option value="yes" {{ !empty($hotels->hotelfishing) ? (($hotels->hotelfishing['provide_on_site'] == 'yes') ? 'selected' : '') : '' }}>Yes</option>
                                                    <option value="no" {{ !empty($hotels->hotelfishing) ? (($hotels->hotelfishing['provide_on_site'] == 'no') ? 'selected' : '') : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Is your concierge able to arrange fishing experiences for guests?</label>
                                                <select class="form-control" name="arrange_fishing_nearby">
                                                    <option value="yes" {{ !empty($hotels->hotelfishing) ? (($hotels->hotelfishing['arrange_fishing_nearby'] == 'yes') ? 'selected' : '') : '' }}>Yes</option>
                                                    <option value="no" {{ !empty($hotels->hotelfishing) ? (($hotels->hotelfishing['arrange_fishing_nearby'] == 'no') ? 'selected' : '') : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Do you have exclusive arrangements with external fishing guides or fishing charter operators to provide fishing experiences for guests?</label>
                                                <select class="form-control" name="provide_our_curated">
                                                    <option value="yes" {{ !empty($hotels->hotelfishing) ? (($hotels->hotelfishing['provide_our_curated'] == 'yes') ? 'selected' : '') : '' }}>Yes</option>
                                                    <option value="no" {{ !empty($hotels->hotelfishing) ? (($hotels->hotelfishing['provide_our_curated'] == 'no') ? 'selected' : '') : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group text-center">
                                                <label class="bmd-label-floating">Important Information</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Hotel Policy </label>
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
                                        <div class="col-sm-12">
                                            <input type="submit" class="btn btn-primary" name="update" value="Update">
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
                                                <br/>
                                                <input type="hidden" name="old_featured_image" value="{{$hotels->featured_image}}">
                                                <?php if($hotels->featured_image != NULL || !empty($hotels->featured_image)): ?>
                                                    <img src="{{ url('public/uploads/' . $hotels->featured_image)}}" alt="{{ $hotels->hotels_name }}" style="height: 150px; width:auto;">
                                                    <br/><br/><br/>
                                                <?php endif; ?>
                                                <input type="file" name="featured_image" class="form-control" style="position: static !important;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hotelImageDiv">
                                        <?php
                                        if(!empty($hotels->image_gallery)) :
                                            foreach($hotels->image_gallery as $rgKey => $rg):
                                        ?>
                                                <div class="col-sm-5 roomImg<?=$rgKey?>">
                                                    <div class="form-group">
                                                        <label>Hotel Gallery Image </label>
                                                        <br/>
                                                        <img src="{{ url('public/uploads/' . $rg->image)}}" alt="{{ $hotels->hotels_name }}" style="height: 90px; width:auto;"> 
                                                        <input type="hidden" name="old_gallery_image_id[]" value="{{$rg->id}}">
                                                        <input type="hidden" name="old_gallery_image[]" value="{{$rg->image}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 roomImg<?=$rgKey?>">
                                                    <div class="form-group">
                                                        <label>Image Alt Text</label>
                                                        <textarea name="old_gallery_image_alt[]" class="form-control imageAlt" rows="3">{{$rg->image_alt}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 roomImg<?=$rgKey?>">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Action</label><br/>
                                                        <input type="button" class="btn btn-danger deleteMrImgBtn deleteFromDb" data-img-id="{{$rg->id}}" data-key="<?=$rgKey?>" value="Remove">
                                                    </div>
                                                </div>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" id="imgCnt" value="{{count($hotels->image_gallery)}}">
                                        <div class="col-sm-12 text-center">
                                            <div class="form-group text-center">
                                                <input type="button" class="btn btn-warning addMrImgBtn" value="+ Add Hotel Gallery Image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="submit" class="btn btn-primary" name="update" value="Update">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
</div>
@endsection
@section('th_foot')
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
                                <div class="col-sm-5 roomImg'+key+'">\
                                    <div class="form-group">\
                                        <label>Hotel Gallery Image </label>\
                                        <input type="file" name="gallery_image[]" class="form-control" style="position: static !important;">\
                                    </div>\
                                </div>\
                                <div class="col-sm-5 roomImg'+key+'">\
                                    <div class="form-group">\
                                        <label>Image Alt Text</label>\
                                        <textarea name="gallery_image_alt[]" class="form-control imageAlt" rows="3"></textarea>\
                                    </div>\
                                </div>\
                                <div class="col-md-2 roomImg'+key+'">\
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
    let flag            = commonFormChecking(true);
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
            $.ajax({
                type        : "POST",
                url         : "{{ route('admin.hotels.update.new', ['id' => $hotels->id]) }}",
                data        : formData,
                cache       : false,
                contentType : false,
                processData : false,
                beforeSend  : function () {
                    $("#tabThreeEditHotel").loading();
                },
                success     : function (res) {
                    $("#tabThreeEditHotel").loading("stop");
                    swalAlert('Hotel Details Updated Successfully !!!', 'success', 5000);
                },
            });
        }
    }
});

$(document).on('submit', '#tabOneEditHotel', function(e) {
    e.preventDefault();
    let flag            = commonFormChecking(true);
    if (flag) {
        let formData    = new FormData(this);
        $.ajax({
            type        : "POST",
            url         : "{{ route('admin.hotels.update.new', ['id' => $hotels->id]) }}",
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

$(document).on('ready', function() {
$('#add_award_btn').on('click', function(){
$('#add_award_field').append('<div class="form-group"><div class="row"><div class="col-sm-9"><input type="text" name="awards[]" class="form-control" placeholder="Award Title"></div><div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-danger remove_award_field"><i class="fa fa-trash"> Remove</a></div></div></div>');
});
$('#add_award_field').on('click', ".remove_award_field", function(e){
if(confirm('Are you sure, You want to delete this?')){
e.preventDefault();
$(this).parent('div').parent('div').parent('div').remove();
}else{
e.preventDefault();
}
});
@if(isset($key))
var i = {{ $key }};
@else
var i = 0;
@endif
$('#add_food_btn').on('click', function(){
i++;
$('.food_drink_bdy').append('<tr><td><input type="text" name="food_title_'+i+'" class="form-control" placeholder="Title"></td><td><input type="text" name="cusine_type_'+i+'" class="form-control" placeholder="Cuisine Type"></td><td><div class="checkbox"><label><input type="checkbox" name="meal_served_'+i+'[]" value="Breakfast">Breakfast</label></div><div class="checkbox"><label><input type="checkbox" name="meal_served_'+i+'[]" value="Lunch">Lunch</label></div><div class="checkbox"><label><input type="checkbox" name="meal_served_'+i+'[]" value="Dinner">Dinner</label></div></td><td><textarea class="form-control" name="food_drink_descp_'+i+'" placeholder="Description"></textarea></td><td><a href="javascript:void(0);" class="remove_food_btn btn btn-danger"><i class="fa fa-trash"> Remove</i></a></td></tr>');
$('#tot_food').val(i+1);
});
$('.food_drink_bdy').on('click', ".remove_food_btn", function(e){
if(confirm('Are you sure, You want to delete this?')){
e.preventDefault();
$(this).parent('td').parent('tr').remove();
}else{
e.preventDefault();
}
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







$(document).on('change', '.change-invitation-status', function (e) {
	e.preventDefault();
    Swal.fire({
        title               : 'Are You Sure Want To Change Status?',
        type                : 'warning',
        showCancelButton    : true,
        confirmButtonColor  : '#dd6b55',
        cancelButtonColor   : '#48cab2',
        confirmButtonText   : "Yes !!!",
        cancelButtonText    : "Cancel"
    }).then((result) => {
        if (result.value) {
            let changedVal  = $(this).val();
            let changedId   = $(this).attr('data-id');
            let redirect    = '';
            switch(changedVal){
                case '0':
                    redirect    = "{{ route('admin.invitation.received', 'pending') }}";
                    break;
                case '1':
                    redirect    = "{{ route('admin.invitation.received', 'approved') }}";
                    break;
                case '2':
                    redirect    = "{{ route('admin.invitation.received', 'return-to-customer') }}";
                    break;
                default:
                    redirect    = "{{ route('admin.invitation.received', 'rejected') }}";
                    break;
            }
            $.ajax({
                type    : "POST",
                url     : "{{ route('admin.change.hotel.status') }}",
                data    :{
                    "_token"        : "{{ csrf_token() }}",
                    "changedId"     : changedId,
                    "changedVal"    : changedVal
                },
                success : function(data){
                    $('.inviRow' + changedId).remove();
                    swalAlertThenRedirect('Status Changed Successfully !!!', 'success', redirect);
                }
            });
        }
    });
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK4rMTf9bUlqpg1g8SF2zUnV4HQmatsVo&libraries=places&callback=initMap"
async defer></script>
@endsection