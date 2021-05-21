@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/css/fileinput.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
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
    <h1>Edit hotel</h1>
    @include('frontend.layouts.messages')
    <div class="user_panel">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#one">General Information</a></li>
        <li><a data-toggle="tab" href="#two">Other Information</a></li>
        <li><a data-toggle="tab" href="#three">Additional Information</a></li>
        <li><a data-toggle="tab" href="#four">Fishing</a></li>
        <li><a data-toggle="tab" href="#five">Tour Guide</a></li>
        <li><a data-toggle="tab" href="#sixth">Contact Information</a></li>
        <li><a data-toggle="tab" href="#seven">Images</a></li>
      </ul>
      <div class="wizard">
        <div class="tab-content">
          <div id="one" class="tab-pane fade in active">
            <form action="{{ route('user.hotels.update', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="editHotel">
              <input type="hidden" name="form_no" value="1">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Name <span class="required">*</span></label>
                    <input type="text" id="hotels_name" name="hotels_name" class="form-control" value="{{ $hotels->hotels_name }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Services for the Enthusiast</label>
                    <textarea class="form-control" name="enthusiast_services" id="enthusiast_services">{{ $hotels->enthusiast_services }}</textarea>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Distance Airport To Hotel</label>
                    <input type="text" id="distance_airport" name="distance_airport" class="form-control" value="{{ $hotels->distance_airport }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Transfers</label>
                    <input type="text" id="transfers_mode" name="transfers_mode" class="form-control" value="{{ $hotels->transfers_mode }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Amenities & Services</label>
                    <textarea class="form-control" id="services_amenities" name="services_amenities">{{ $hotels->services_amenities }}</textarea>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Additional Information</label>
                    <textarea class="form-control" id="additional_information" name="additional_information">{{ $hotels->additional_information }}</textarea>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Total number of Rooms</label>
                    <input type="number" id="no_of_rooms" name="no_of_rooms" class="form-control" value="{{ $hotels->no_of_rooms }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Number of Restaurants</label>
                    <input type="number" id="no_of_restaurant" name="no_of_restaurant" class="form-control" value="{{ $hotels->no_of_restaurant }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Number of Pools</label>
                    <input type="number" id="no_of_pools" name="no_of_pools" class="form-control" value="{{ $hotels->no_of_pools }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Number of Floors</label>
                    <input type="number" id="no_of_floor" name="no_of_floor" class="form-control" value="{{ $hotels->no_of_floor }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Curator's Rating</label>
                    <input type="number" id="curator_rating" name="curator_rating" class="form-control" value="{{ $hotels->curator_rating }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Region <span class="required">*</span></label>
                    <select id="region_id" class="form-control" name="region_id">
                      <?php @regionOption($hotels->region_id); ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Country <span class="required">*</span></label>
                    <select id="country_id" class="form-control" name="country_id" onchange="getState(this.value);">
                      <?php @countryOption($hotels->country_id); ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">State <span class="required">*</span></label>
                    <select id="state_id" class="form-control" name="state_id">
                      <?php @stateOption($hotels->state_id); ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Town <span class="required">*</span></label>
                    <input type="text" id="town" name="town" class="form-control" value="{{ $hotels->town }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Activity Season</label>
                    <input type="text" id="activity_season" name="activity_season" class="form-control" value="{{ $hotels->activity_season }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Email ID <span class="required">*</span></label>
                    <input type="text" id="email_id" name="email_id" class="form-control" value="{{ $hotels->email_id }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Nearest Airport</label>
                    <input type="text" id="nearest_airport" name="nearest_airport" class="form-control" value="{{ $hotels->nearest_airport }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Size of Room</label>
                    <input type="text" id="size_of_room" name="size_of_room" class="form-control" value="{{ $hotels->size_of_room }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Check In</label>
                    <input type="text" id="check_in" name="check_in" class="form-control time" value="{{ $hotels->check_in }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Check Out</label>
                    <input type="text" id="check_out" name="check_out" class="form-control time" value="{{ $hotels->check_out }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Do you have a Beach?</label>&nbsp;&nbsp;&nbsp;
                    <label class="radio-inline">
                      <input type="radio" name="beach_availability" value="1" @if($hotels->beach_availability == 1) {{ 'checked' }} @else {{ '' }} @endif >Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="beach_availability" value="0" @if($hotels->beach_availability == 0) {{ 'checked' }} @else {{ '' }} @endif>No
                    </label>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">SPA Availability</label>&nbsp;&nbsp;&nbsp;
                    <label class="radio-inline">
                      <input type="radio" name="spa_availability" value="1" @if($hotels->spa_availability == 1) {{ 'checked' }} @else {{ '' }} @endif>Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="spa_availability" value="0" @if($hotels->spa_availability == 0) {{ 'checked' }} @else {{ '' }} @endif>No
                    </label>
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Fine Dining Availability</label>&nbsp;&nbsp;&nbsp;
                    <label class="radio-inline">
                      <input type="radio" name="fine_dining_availability" value="1" @if($hotels->fine_dining_availability == 1) {{ 'checked' }} @else {{ '' }} @endif>Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="fine_dining_availability" value="0" @if($hotels->fine_dining_availability == 0) {{ 'checked' }} @else {{ '' }} @endif>No
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <button type="button" class="update_btn btn btn-primary btn-lg" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait... ">Update</button>
                </div>
              </div>
            </form>
          </div>
          <div id="two" class="tab-pane fade">
            <form action="{{ route('user.hotels.update', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="">
              <input type="hidden" name="form_no" value="2">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Brief Description</label>
                    <textarea class="form-control editor" name="brief_descp" id="brief_descp">{{ $hotels->brief_descp }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Description <span class="required">*</span></label>
                    <textarea class="form-control editor" name="hotels_desc" id="hotels_desc">{{ $hotels->hotels_desc }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">How To Get There</label>
                    <textarea class="form-control editor" name="how_to_get_there" id="how_to_get_there">{{ $hotels->how_to_get_there }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Useful Information</label>
                    <textarea class="form-control editor" name="useful_information" id="useful_information">{{ $hotels->useful_information }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Need To Know</label>
                    <textarea class="form-control editor" name="need_to_know" id="need_to_know">{{ $hotels->need_to_know }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Highlights</label>
                    <textarea class="form-control editor" name="highlights" id="highlights">{{ $hotels->highlights }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Fishing</label>
                    <textarea class="form-control editor" name="fishing" id="fishing">{{ $hotels->fishing }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Deposit Policy </label>
                    <textarea class="form-control editor" name="deposit_policy" id="deposit_policy">{{ $hotels->deposit_policy }}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Cancellation Policy</label>
                    <textarea class="form-control editor" name="cancellation_policy" id="cancellation_policy">{{ $hotels->cancellation_policy }}</textarea>
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
            <form action="{{ route('user.hotels.update', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="">
              <input type="hidden" name="form_no" value="3">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-12">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingAcc">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAcc" aria-expanded="true" aria-controls="collapseAcc">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Hotel Accommodations
                        </a>
                        </h6>
                      </div>
                      <div id="collapseAcc" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAcc">
                        <div class="panel-body">
                          <ul style="list-style: none;">
                            @foreach ($hotels->accommodations as $aData)
                            <?php $checked = '';  ?>
                            @foreach ($hotels->accommodation_relation as $aR)
                            @if ($aData->id == $aR['accommodation_id'])
                            <?php $checked .= 'checked="checked"';  ?>
                            @endif
                            @endforeach
                            <li class="col-md-4">
                              <label class="checkbox-inline">
                                <input class="form-check-input" type="checkbox" name="accommodation_id[]" value="{{ $aData->id }}" {{ $checked }} disabled> {{ $aData->accommodations_name }} <span class="form-check-sign"><span class="check"></span></span>
                              </label>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingSpec">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSpec" aria-expanded="true" aria-controls="collapseSpec">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Hotel Species
                        </a>
                        </h6>
                      </div>
                      <div id="collapseSpec" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSpec">
                        <div class="panel-body">
                          <ul style="list-style: none;">
                            @foreach ($hotels->species as $sData)
                            <?php $checked = '';  ?>
                            @foreach ($hotels->species_relation as $sR)
                            @if ($sData->id == $sR['species_id'])
                            <?php $checked .= 'checked="checked"';  ?>
                            @endif
                            @endforeach
                            <li class="col-md-4">
                              <label class="checkbox-inline">
                                <input class="form-check-input" type="checkbox" name="species_id[]" value="{{ $sData->id }}" {{ $checked }} disabled> {{ $sData->species_name }} <span class="form-check-sign"><span class="check"></span></span>
                              </label>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingInsp">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseInsp" aria-expanded="true" aria-controls="collapseInsp">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Hotel Inspirations
                        </a>
                        </h6>
                      </div>
                      <div id="collapseInsp" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingInsp">
                        <div class="panel-body">
                          <ul style="list-style: none;">
                            @foreach ($hotels->inspirations as $iData)
                            <?php $checked = '';  ?>
                            @foreach ($hotels->inspirations_relation as $iR)
                            @if ($iData->id == $iR['inspirations_id'])
                            <?php $checked .= 'checked="checked"';  ?>
                            @endif
                            @endforeach
                            <li class="col-md-4">
                              <label class="checkbox-inline">
                                <input class="form-check-input" type="checkbox" name="inspirations_id[]" value="{{ $iData->id }}" {{ $checked }} disabled> {{ $iData->inspirations_name }} <span class="form-check-sign"><span class="check"></span></span>
                              </label>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingExp">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseExp" aria-expanded="true" aria-controls="collapseExp">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Hotel Experiences
                        </a>
                        </h6>
                      </div>
                      <div id="collapseExp" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingExp">
                        <div class="panel-body">
                          <ul style="list-style: none;">
                            @foreach ($hotels->experiences as $eData)
                            <?php $checked = '';  ?>
                            @foreach ($hotels->experiences_relation as $eR)
                            @if ($eData->id == $eR['experiences_id'])
                            <?php $checked .= 'checked="checked"';  ?>
                            @endif
                            @endforeach
                            <li class="col-md-4">
                              <label class="checkbox-inline">
                                <input class="form-check-input" type="checkbox" name="experiences_id[]" value="{{ $eData->id }}" {{ $checked }} disabled> {{ $eData->experiences_name }} <span class="form-check-sign"><span class="check"></span></span>
                              </label>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingFeat">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFeat" aria-expanded="true" aria-controls="collapseFeat">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Hotel Key Features
                        </a>
                        </h6>
                      </div>
                      <div id="collapseFeat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFeat">
                        <div class="panel-body">
                          <ul style="list-style: none;">
                            @foreach ($hotels->keyfeature as $kData)
                            <?php $checked = '';  ?>
                            @foreach ($hotels->features_relations as $fR)
                            @if ($kData->id == $fR['features_id'])
                            <?php $checked .= 'checked="checked"';  ?>
                            @endif
                            @endforeach
                            <li class="col-md-4">
                              <label class="checkbox-inline">
                                <input class="form-check-input" type="checkbox" name="features_id[]" value="{{ $kData->id }}" {{ $checked }}> {{ $kData->name }} <span class="form-check-sign"><span class="check"></span></span>
                              </label>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
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
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingRec">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseRec" aria-expanded="true" aria-controls="collapseRec">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Recreation
                        </a>
                        </h6>
                      </div>
                      <div id="collapseRec" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRec">
                        <div class="panel-body">
                          <ul style="list-style: none;">
                            @foreach ($hotels->recreation as $rData)
                            <?php $checked = '';  ?>
                            @foreach ($hotels->reactiontranslation as $rT)
                            @if ($rData->id == $rT['recreation_id'])
                            <?php $checked .= 'checked="checked"';  ?>
                            @endif
                            @endforeach
                            <li class="col-md-4">
                              <label class="checkbox-inline">
                                <input class="form-check-input" type="checkbox" name="recreation_id[]" value="{{ $rData->id }}" {{ $checked }}> {{ $rData->name }} <span class="form-check-sign"><span class="check"></span></span>
                              </label>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingAward">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAward" aria-expanded="true" aria-controls="collapseAward">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Awards
                        </a>
                        </h6>
                      </div>
                      <div id="collapseAward" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAward">
                        <div class="panel-body">
                          <span id="add_award_field">
                            @if(!empty($hotels->hotelawards))
                            @foreach($hotels->hotelawards as $hotelaward)
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-9">
                                  <input type="text" name="awards[]" class="form-control" placeholder="Award Title" value="{{ $hotelaward->award_title }}">
                                </div>
                                <div class="col-sm-3">
                                  <a href="javascript:void(0);" class="btn btn-danger remove_award_field"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                              </div>
                            </div>
                            @endforeach
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-9">
                                  <input type="text" name="awards[]" class="form-control" placeholder="Award Title">
                                </div>
                                <div class="col-sm-3">
                                  <a href="javascript:void(0);" class="btn btn-success" id="add_award_btn"><i class="fa fa-plus"></i> Add</a>
                                </div>
                              </div>
                            </div>
                            @else
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-9">
                                  <input type="text" name="awards[]" class="form-control" placeholder="Award Title">
                                </div>
                                <div class="col-sm-3">
                                  <a href="javascript:void(0);" class="btn btn-success" id="add_award_btn"><i class="fa fa-plus"></i> Add</a>
                                </div>
                              </div>
                            </div>
                            @endif
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingFood">
                        <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFood" aria-expanded="true" aria-controls="collapseFood">
                          <i class="more-less glyphicon glyphicon-plus"></i>
                          Food & Drink
                        </a>
                        </h6>
                      </div>
                      <div id="collapseFood" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFood">
                        <div class="panel-body">
                          <div class="form-group">
                            <label class="bmd-label-floating">Food & Drink Description</label>
                            <textarea class="form-control editor" name="food_drink" id="food_drink">{{ $hotels->food_drink }}</textarea>
                          </div>
                          <div class="row">
                            <div class="col-sm-12">
                              <table class="table table-bordered table-responsive">
                                <thead>
                                  <th>Title</th>
                                  <th>Cuisine Type</th>
                                  <th>Meals Served</th>
                                  <th>Description</th>
                                  <th>Action</th>
                                </thead>
                                <tbody class="food_drink_bdy">
                                  @if(!empty($hotels->fooddrink))
                                  @foreach($hotels->fooddrink as $key => $fd)
                                  <?php $key++; ?>
                                  <tr>
                                    <td><input type="text" name="food_title_{{ $key }}" class="form-control" placeholder="Title" value="{{ $fd->food_title }}"></td>
                                    <td><input type="text" name="cusine_type_{{ $key }}" class="form-control" placeholder="Cuisine Type" value="{{ $fd->cusine_type }}"></td>
                                    <td>
                                      @php
                                      $meal_served = $fd->meal_served;
                                      $meal_served_arr = explode(", ", $meal_served);
                                      @endphp
                                      @for ($k = 0; $k < count($meal_served_arr) ; $k++)
                                      @switch($meal_served_arr[$k])
                                      @case('Breakfast')
                                      @php $breakfastchkd = 'checked="checked"'; @endphp
                                      @break
                                      @case('Lunch')
                                      @php $lunchchkd = 'checked="checked"'; @endphp
                                      @break
                                      @case('Dinner')
                                      @php $dinnerchkd = 'checked="checked"'; @endphp
                                      @break
                                      @default
                                      @endswitch
                                      @endfor
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_{{ $key }}[]" value="Breakfast" @if(isset($breakfastchkd)){{ $breakfastchkd }} @else ''; @endif>Breakfast</label>
                                      </div>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_{{ $key }}[]" value="Lunch" @if(isset($lunchchkd)){{ $lunchchkd }} @else ''; @endif>Lunch</label>
                                      </div>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_{{ $key }}[]" value="Dinner" @if(isset($dinnerchkd)){{ $dinnerchkd }} @else ''; @endif>Dinner</label>
                                      </div>
                                      @php
                                      unset($breakfastchkd);
                                      unset($lunchchkd);
                                      unset($dinnerchkd);
                                      @endphp
                                    </td>
                                    <td><textarea class="form-control" name="food_drink_descp_{{ $key }}" placeholder="Description">{{ $fd->food_drink_descp }}</textarea></td>
                                    <td><a href="javascript:void(0);" class="remove_food_btn btn btn-danger"><i class="fa fa-trash"> Remove</i></a></td>
                                  </tr>
                                  @endforeach
                                  <tr>
                                    <td><input type="text" name="food_title_0" class="form-control" placeholder="Title"></td>
                                    <td><input type="text" name="cusine_type_0" class="form-control" placeholder="Cuisine Type"></td>
                                    <td>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_0[]" value="Breakfast">Breakfast</label>
                                      </div>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_0[]" value="Lunch">Lunch</label>
                                      </div>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_0[]" value="Dinner">Dinner</label>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="food_drink_descp_0" placeholder="Description"></textarea></td>
                                    <td><a href="javascript:void(0);" class="btn btn-success" id="add_food_btn"><i class="fa fa-plus"> Add</i></a></td>
                                  </tr>
                                  @else
                                  <tr>
                                    <td><input type="text" name="food_title_0" class="form-control" placeholder="Title"></td>
                                    <td><input type="text" name="cusine_type_0" class="form-control" placeholder="Cuisine Type"></td>
                                    <td>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_0[]" value="Breakfast">Breakfast</label>
                                      </div>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_0[]" value="Lunch">Lunch</label>
                                      </div>
                                      <div class="checkbox">
                                        <label><input type="checkbox" name="meal_served_0[]" value="Dinner">Dinner</label>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="food_drink_descp_0" placeholder="Description"></textarea></td>
                                    <td><a href="javascript:void(0);" class="btn btn-success" id="add_food_btn"><i class="fa fa-plus"> Add</i></a></td>
                                  </tr>
                                  @endif
                                </tbody>
                              </table>
                              <input type="hidden" name="tot_food" id="tot_food" value="@if(isset($key)){{ $key+1 }}@endif">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
          <div id="four" class="tab-pane fade">
            <form action="{{ route('user.hotels.update', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="">
              <input type="hidden" name="form_no" value="4">
              {{ csrf_field() }}
              
              <div class="row">
                <div class="col-sm-12">
                  <input type="submit" class="btn btn-primary" name="update" value="Update">
                </div>
              </div>
            </form>
          </div>
          <div id="five" class="tab-pane fade">
            <form action="{{ route('user.hotels.update', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="">
              <input type="hidden" name="form_no" value="5">
              {{ csrf_field() }}
              <?php for ($i=0; $i < 6 ; $i++) {  ?>
              <div class="row">
                <h3>Guide <?php echo $i+1; ?></h3>
                <?php
                $guide_type = 'guide_'.($i+1);
                $tourguide = getTourGuide($hotels->id, $guide_type);
                ?>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Business Name</label>
                    <input type="text" id="business_name_<?php echo $i+1; ?>" name="business_name_<?php echo $i+1; ?>" class="form-control" value="<?php echo $tourguide['business_name']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Website</label>
                    <input type="text" id="website_<?php echo $i+1; ?>" name="website_<?php echo $i+1; ?>" class="form-control" value="<?php echo $tourguide['website']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" id="email_<?php echo $i+1; ?>" name="email_<?php echo $i+1; ?>" class="form-control" value="<?php echo $tourguide['email']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="text" id="phone_<?php echo $i+1; ?>" name="phone_<?php echo $i+1; ?>" class="form-control" value="<?php echo $tourguide['phone']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Contact Name</label>
                    <input type="text" id="contact_name_<?php echo $i+1; ?>" name="contact_name_<?php echo $i+1; ?>" class="form-control" value="<?php echo $tourguide['contact_name']; ?>">
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="row">
                <div class="col-sm-12">
                  <input type="submit" class="btn btn-primary" name="update" value="Update">
                </div>
              </div>
            </form>
          </div>
          <div id="sixth" class="tab-pane fade">
            <form action="{{ route('user.hotels.update', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="">
              <input type="hidden" name="form_no" value="6">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Hotel Contact Person Name</label>
                    <input type="text" id="contact_person_name" name="contact_person_name" class="form-control" value="{{ $hotels->hotelcontact->contact_person_name }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Hotel Website</label>
                    <input type="text" id="website" name="website" class="form-control" value="{{ $hotels->hotelcontact->website }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Hotel Contact Person Email</label>
                    <input type="text" id="contact_person_email" name="contact_person_email" class="form-control" value="{{ $hotels->hotelcontact->contact_person_email }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ $hotels->hotelcontact->title }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">SKYPE ID</label>
                    <input type="text" id="skype_id" name="skype_id" class="form-control" value="{{ $hotels->hotelcontact->skype_id }}">
                  </div>
                  <div class="form-group">
                    <label class="bmd-label-floating">Hotel Contact Person Phone</label>
                    <input type="text" id="contact_person_phone" name="contact_person_phone" class="form-control" value="{{ $hotels->hotelcontact->contact_person_phone }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Hotel Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ $hotels->hotelcontact->address }}">
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
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <input type="submit" class="btn btn-primary" name="update" value="Update">
                </div>
              </div>
            </form>
          </div>
          <div id="seven" class="tab-pane fade">
            <form action="{{ route('user.hotels.update', ['id' => $hotels->id]) }}" method="POST" enctype="multipart/form-data" id="">
              <input type="hidden" name="form_no" value="7">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Featured Image</label>
                    <div class="file-loading">
                      <input id="featured_image" name="featured_image" type="file" accept=".jpg,.gif,.png">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Gallery Images</label>
                    <div class="file-loading">
                      <input id="gallery_image" name="gallery_image[]" type="file" accept=".jpg,.gif,.png" multiple>
                    </div>
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
</section>
<div class="clearfix"></div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.2/js/fileinput.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
$(function () {
$('.time').datetimepicker({
format: 'LT'
});
});
$('form[id="editHotel"]').validate({
rules: {
curator_rating: {
number: true,
max: 100,
min:0
},
hotels_name: {
required: true
},
region_id: {
required: true
},
country_id: {
required: true
},
state_id: {
required: true
},
town: {
required: true
},
hotels_desc: {
required: true
},
}
});
</script>
<script type="text/javascript">
$('form#editHotel .update_btn').on('click', function() {
var $this = $(this);
$this.button('loading');
$( "#editHotel" ).submit();
setTimeout(function() {
$this.button('reset');
}, 3000);
});
$(document).on('ready', function() {
var gallery_arr = [];
@foreach ($hotels->image_gallery as $ig)
gallery_arr.push("{{ Storage::disk('local')->url($ig->image) }}");
@endforeach
$("#gallery_image").fileinput({
showUpload: false,
overwriteInitial: false,
previewClass: "bg-hotel-gallery",
initialPreview: gallery_arr,
initialPreviewAsData: true,
initialPreviewConfig: [
@foreach ($hotels->image_gallery as $ig)
{caption: "{{$ig->image}}", size: 576237, width: "120px", url: "{{route('user.hotels.del.image')}}", key: "{{$ig->id}}"},
@endforeach
],
});
var featured_image = "{{ Storage::disk('local')->url($hotels->featured_image) }}";
$("#featured_image").fileinput({
showUpload: false,
browseClass: "btn btn-primary btn-block",
showCaption: false,
previewClass: "bg-hotel-feature",
showRemove: false,
initialPreview: [featured_image],
initialPreviewAsData: true,
});
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
var map = new google.maps.Map(document.getElementById('map'), {
center: {lat: -33.8688, lng: 151.2195},
zoom: 13
});
var input = document.getElementById('address');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.bindTo('bounds', map);
// Set the data fields to return when the user selects a place.
autocomplete.setFields(
['address_components', 'geometry', 'icon', 'name']);
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
//console.log(place);
document.getElementById('latitude').value = place.geometry.location.lat();
document.getElementById('longitude').value = place.geometry.location.lng();
for (var i = 0; i < place.address_components.length; i++) {
var addressType = place.address_components[i].types[0];
if (componentForm[addressType]) {
var val = place.address_components[i][componentForm[addressType]];
document.getElementById(addressType).value = val;
//console.log(addressType +' =>>>> '+ val);
//console.log(addressType);
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
<script type="text/javascript">
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
</script>
@endsection