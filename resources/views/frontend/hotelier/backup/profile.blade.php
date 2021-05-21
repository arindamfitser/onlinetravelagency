@extends('frontend.layouts.app')
@section('content')
<!--Banner sec-->
<?php $user = auth('web')->user();   ?>
 <section class="profile dashboard hometop_gap">
    @include('frontend.layouts.hotelier_sidenav')
      <div class="dashboard_content">
         
        <h1>My profile</h1>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                	<div class="update_profile">
                 <h2 class="control-label">Update profile</h2>
                <div id="head_msg"></div>
               <form id="update_profile" name="update_profile" method="post" action="">
               <input type="hidden" value="{{$user->id}}" name="user_id">
               {{ csrf_field() }}
                <div class="col-md-6 col-lg-6">
                   <div class="form-group">
                      <label class="control-label">First Name<sup style="color:red">*</sup></label>
							         <div class="input-group">
								        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								        <input type="text" name ="first_name" id="first_name" class="form-control" value="{{$user->first_name}}" />
							       </div>
						      </div>
                </div>

                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
							     <label class="control-label">Last Name<sup style="color:red">*</sup></label>
							     <div class="input-group">
								    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								      <input type="text" name ="last_name" id="last_name" class="form-control" value="{{$user->last_name}}" />
							     </div>
                   </div>
                </div>

                 <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label">Email<sup style="color:red">*</sup></label>
                       <div class="input-group">
                         <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                         <input type="email" name="email" id="email" class="form-control" disabled="disabled" value="{{$user->email}}" />
                      </div>
                    </div>
                  </div>

                 <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label">Mobile</label>
                       <div class="input-group">
                         <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                         <input type="text"  name="mobile_number" id="mobile_number" class="form-control" value="{{$user->mobile_number}}" />
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6 col-lg-6">
                   <div class="form-group">
                      <label class="control-label">Address<sup style="color:red">*</sup></label>
                       <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name ="address" id="address" class="form-control" value="{{$user->address}}" />
                     </div>
                  </div>
                </div>

                 <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                   <label class="control-label">Select Country</label>
                      <select class="form-control">
                        <?php countryOption($user->country_code);?>
                      </select>
                    </div>
                 </div>

                 <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="control-label">Date Of Birth<sup style="color:red">*</sup></label>
                          <div class="input-group date">
                                  <span class="input-group-addon">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                                <input name="dob" id="dob" class="form-control" type="text" value="{{$user->dob}}" />
                               
                            </div>
                        </div>
                  </div>

                  <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="control-label">Gender</label>
                          <div class="input-group">
                            <input type="radio" value="male" name ="gender" id="gender" {{ $user->gender === "male" ? "checked" : " " }} /> Male
                            <input type="radio" value="female" name ="gender" id="gender" {{ $user->gender === "female" ? "checked" : " " }} /> Female
                         </div>
                        </div>
                  </div>
                <div class="col-md-12 col-lg-12">
                  <button type="submit" class="btn btn-primary btn-lg" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Updating now ">Update now</button>
                </div>
                </form>
			       </div>
            </div>
            <div class="col-md-12 col-lg-12">
              <div class="change-password">
                <h2 class="control-label">Change password</h2>
                <div id="change_pass_msg"></div>
                 <div class="form-group">
                    <p class="c-form__instruction">Your password must have at least eight characters and feature one special character, one capital letter, one number and one lower-case letter.</p>
                  </div>

                 <form id="change_password" name="change_password" method="post">
                  <input type="hidden" value="{{$user->id}}" name="user_id">
                  {{ csrf_field() }}
                  <div class="col-md-6 col-lg-6">
                   <div class="form-group">
                      <label class="control-label">New password<sup style="color:red">*</sup></label>
                       <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name ="password" id="password" class="form-control" />
                     </div>
                  </div>
                </div>

                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                   <label class="control-label">Confirm password<sup style="color:red">*</sup></label>
                   <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                      <input type="password" name ="confirm_password" id="confirm_password" class="form-control" />
                   </div>
                   </div>
                </div>
                 <div class="col-md-12 col-lg-12">
                    <button type="submit" class="btn btn-primary btn-lg" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Updating now ">Change now</button>
                 </div>
                </form>
              </div> 
            </div>
             </div>
      </div>		 
   </section>
<div class="clearfix"></div>

@endsection

@section('script')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /**
 * Custom validator for contains at least one lower-case letter
 */
  jQuery.validator.addMethod("atLeastOneLowercaseLetter", function (value, element) {
      return this.optional(element) || /[a-z]+/.test(value);
  }, "Must have at least one lowercase letter");
   
  /**
   * Custom validator for contains at least one upper-case letter.
   */
  
  jQuery.validator.addMethod("atLeastOneUppercaseLetter", function (value, element) {
      return this.optional(element) || /[A-Z]+/.test(value);
  }, "Must have at least one uppercase letter");
   
  /**
   * Custom validator for contains at least one number.
   */
  jQuery.validator.addMethod("atLeastOneNumber", function (value, element) {
      return this.optional(element) || /[0-9]+/.test(value);
  }, "Must have at least one number");
   
  /**
   * Custom validator for contains at least one symbol.
   */
  $.validator.addMethod("atLeastOneSymbol", function (value, element) {
    return this.optional(element) || /[!@#$%^&*()]+/.test(value);
  }, "Must have at least one symbol");
  
  jQuery.validator.addMethod("phoneno", function(phone_number, element) {
          phone_number = phone_number.replace(/\s+/g, "");
          return this.optional(element) || phone_number.length > 9 && 
          phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, "<br />Please specify a valid phone number");
    $('form[id="update_profile"]').validate({
      rules: {
        first_name: 'required',
        last_name: 'required',
        "mobile_number":
          {  required:true,
             phoneno:true
          },
        address: 'required',
        dob: 'required', 
      },
      messages: {
        first_name: 'This First name is required',
        last_name: 'This Last name is required',
        mobile_number: 'Please specify a valid phone number',
        address: 'This Address is required',
        dob: 'This DOB  is required',
      },
      submitHandler: function() {
        //e.preventDefault();
        var $this = $("form#update_profile .btn");
        $this.button('loading');
         $.ajax({
           type:'POST',
           url:"{{route('ajax.profile.update')}}",
           data:$('#update_profile').serialize(),
           success:function(data){
              //alert(data.success);
              setTimeout(function() {
                $('#head_msg').html(data);
                 $this.button('reset');
             }, 2000);
           }

        });
      }
  });

$('form[id="change_password"]').validate({
      rules: {
        password: {
              required: true,
              atLeastOneLowercaseLetter: true,
              atLeastOneUppercaseLetter: true,
              atLeastOneNumber: true,
              atLeastOneSymbol: true,
              minlength: 8,
              maxlength: 40
        },
         confirm_password: {
          equalTo: "#password"
        }
      }, 
      messages: {
         password: {
              minlength: 'Password must be at least 8 characters long' 
        },
        confirm_password: {
              equalTo: ' Please enter the same password again. '
        }

      },
      submitHandler: function() {
        //e.preventDefault();
        var $this = $("form#change_password .btn");
        $this.button('loading');
        $('#change_pass_msg').html('');
        $.ajax({
           type:'POST',
           url:"{{route('ajax.profile.changepass')}}",
           data:$('#change_password').serialize(),
           success:function(data){
              //alert(data.success);
              setTimeout(function() {
                $('#change_pass_msg').html(data);
                 $this.button('reset');
             }, 2000);

           }
        });
      }
  });
    
</script>
  
@endsection

