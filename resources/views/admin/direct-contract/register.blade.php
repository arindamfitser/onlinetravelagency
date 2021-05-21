
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('backend/assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('backend/assets/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Register Hotel : OTA</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="{{asset('backend/assets/css/material-login.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/jquery.loading.css')}}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
</head>
<style>
.red{
    color : red;
}
</style>
<body class="">
    <div class="wrapper ">
        <div class="main-panel">
            <div class="content@">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title text-center">Register Hotel</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form-horizontal" id="registerDirContractHotel">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel Name <span class="red">*</span></label>
                                                    <input type="text" class="form-control requiredCheck" name="hotel_name" data-check="Hotel Name" value="{{ $details->hotel_name }}" autofocus>
                                                    <input type="hidden" name="invitation_id" value="{{ $details->id }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel Email <span class="red">*</span></label>
                                                    <input type="text" name="hotel_email" value="{{ $details->contact_email }}" data-check="Hotel Email" class="form-control requiredCheck" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel Phone <span class="red">*</span></label>
                                                    <input type="text" name="hotel_phone" value="{{ $details->contact_phone }}" data-check="Hotel Phone" class="form-control requiredCheck" onkeypress="return isNumber(this.event)" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel Address <span class="red">*</span></label>
                                                    <input type="text" name="hotel_address" value="{{ $details->address }}" data-check="Hotel Address" class="form-control requiredCheck" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel Country <span class="red">*</span></label>
                                                    <select id="country_id" class="form-control requiredCheck" data-check="Hotel Country" name="hotel_country" onchange="getState(this.value);">
                                                        <?php @countryOption($details->country); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel State <span class="red">*</span></label>
                                                    <select id="state_id" class="form-control requiredCheck" data-check="Hotel State" name="hotel_state">
                                                        <?php @stateOption($details->state); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel City <span class="red">*</span></label>
                                                    <input type="text" name="hotel_city" value="{{ $details->city }}" class="form-control requiredCheck" data-check="Hotel City" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hotel Description <span class="red">*</span></label>
                                                    <textarea class="form-control requiredCheck" data-check="Hotel Description" name="hotel_description" rows="10" autofocus></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Additional Information</label>
                                                    <textarea class="form-control" name="addition_info" rows="5" autofocus></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Service Amenities</label>
                                                    <textarea class="form-control" name="amenities" rows="5" autofocus></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Spa Available?</label>
                                                    <input type="checkbox"  style="width:100px; height:13px;" class="checkIfChecked" data-val-id="spa_available" autofocus>
                                                    <input type="hidden" name="spa_available" id="spa_available" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Beach Available?</label>
                                                    <input type="checkbox"  style="width:100px; height:13px;" class="checkIfChecked" data-val-id="beach_available" autofocus>
                                                    <input type="hidden" name="beach_available" id="beach_available" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Fine Dining Available?</label>
                                                    <input type="checkbox"  style="width:100px; height:13px;" class="checkIfChecked" data-val-id="fine_dining_available" autofocus>
                                                    <input type="hidden" name="fine_dining_available" id="fine_dining_available" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Pool Available?</label>
                                                    <input type="checkbox"  style="width:100px; height:13px;" class="checkIfChecked" data-val-id="pool_available" autofocus>
                                                    <input type="hidden" name="pool_available" id="pool_available" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Diving Available?</label>
                                                    <input type="checkbox"  style="width:100px; height:13px;" class="checkIfChecked" data-val-id="diving_available" autofocus>
                                                    <input type="hidden" name="diving_available" id="diving_available" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Water Sports Available?</label>
                                                    <input type="checkbox"  style="width:100px; height:13px;" class="checkIfChecked" data-val-id="water_sports_available" autofocus>
                                                    <input type="hidden" name="water_sports_available" id="water_sports_available" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary ">Register</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright">
                        &copy;
                        <script>
                          document.write(new Date().getFullYear())
                        </script>, Design & Developed by
                        <a href="https://www.fitser.com" target="_blank">Fitser </a> 
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{asset('backend/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/assets/js/core/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/assets/js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/plugins/bootstrap-notify.js')}}"></script>
    <script src="{{asset('backend/assets/js/material-dashboard.min.js?v=2.1.0')}}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.loading.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/common-function.js') }}"></script>
    <script src="{{ asset('backend/assets/js/posts.js') }}"></script>
    <script type="text/javascript">
    $(document).on("click", ".checkIfChecked", function () {
    	if($(this).prop('checked') == true){
    		$('#' + $(this).attr('data-val-id')).val('1');
    	}else if($(this).prop('checked') == false){
    		$('#' + $(this).attr('data-val-id')).val('0');
    	}
    });
    $("#registerDirContractHotel").on('submit', function(e){
    	e.preventDefault();
        let flag            = commonFormChecking(true);
        if (flag) {
        	let formData    = new FormData(this);
    		$.ajax({
    			type        : "POST",
    			url         : "{{ route('register.new.direct.contract.hotel') }}",
    			data        : formData,
    			cache       : false,
    			contentType : false,
    			processData : false,
    			dataType    : "JSON",
    			beforeSend  : function () {
    				$("#registerDirContractHotel").loading();
    			},
    			success     : function (res) {
    				$("#registerDirContractHotel").loading("stop");
    				swalAlert(res.message, res.swal, 5000);
    				if(res.success){
    					$('#registerDirContractHotel input, #registerDirContractHotel select, , #registerDirContractHotel textarea').each(function(){
    					    $(this).val('');
                        });
                        window.top.close();
    				}
    			},
    		});
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
    </script>
</body>
</html>
