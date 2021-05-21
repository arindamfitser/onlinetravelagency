@extends('frontend.layouts.app')
@section('content')
<section class="banner_slider_sec hometop_gap"></section>
<section class="img_box_sec">
  <div class="container">
    <div class="image_sec_heading">
      <h2>Contact us</h2>
    </div>
    <div class="visit_img_area_main">        
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="contact_left">
          <h2>Contact Information</h2>
          <ul>
            <?php if(get_option('address')!=''){?> 
              <li> <i class="fa fa-map-marker" aria-hidden="true"></i>
                <h3>Address:</h3>
                <p><?php echo get_option('address');?></p>
              </li>
            <?php } ?>
            <?php if(get_option('phone')!=''){?> 
              <li> <i class="fa fa-phone" aria-hidden="true"></i>
                <h3>Phone:</h3>
                <p><?php echo get_option('phone');?></p>
              </li>
          <?php } ?>
          <?php if(get_option('email')!=''){?> 
              <li> <i class="fa fa-envelope" aria-hidden="true"></i>
                <h3>Email:</h3>
                <p><?php echo get_option('email');?></p>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="map_area">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1693.5591003781904!2d115.89160772229238!3d-31.903385670870367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2a32b078d89ce6bb%3A0x670ce7a8e15ab5f8!2s44A+Gummery+St%2C+Bedford+WA+6052%2C+Australia!5e0!3m2!1sen!2sin!4v1519650451240" width="" height="" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="contact_right_contact">
          <h2>Get In Touch</h2>
          <div class="row clearfix">
            <form id="contact_form" name="contact_form">
            {{ csrf_field() }}
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="first_name" id="first_name" placeholder="First Name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="last_name" id="last_name" placeholder="Last Name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="email" name="email" placeholder="Email">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="contact" name="contact" placeholder="Phone No.">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <input type="text" id="subject" name="subject" placeholder="Subject">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <textarea id="message" name="message" placeholder="Message..." rows="5"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <span id="msg"></span>
                <button type="submit" class="send_btn">
                <span class="loadSpin" id="loadSpinContact"><i class="fa fa-spinner fa-spin"></i></span>Send Message</button>
                <span id="msg"></span>
              </div>
            </form>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')

<script type="text/javascript">
 $(document).ready(function(){
     $('.loadSpin').css('display', 'none');
  });
jQuery.validator.addMethod("phoneno", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && 
        phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
       }, "<br />Please specify a valid phone number");

    $('form[id="contact_form"]').validate({
        rules: {
           
            first_name: 'required',
            last_name: 'required',
            "contact":
            {   
                required:true,
                phoneno:true
            },
            
            email: {
             required: true,
             email: true,
            }, 
            subject: 'required',
            message: 'required',
            

        },
        messages: {
           
            first_name: 'This first name is required!',
            last_name: 'This east name is required!',
            contact: 'Please specify a valid phone number!',
            email: {
                required: "Please enter your Email!",
                email: "This is not a valid email!",
            },
            subject:'Please enter contact subject!',
            messages: 'Please enter your messages!',
            
        },
        submitHandler: function() {
            $('#loadSpinContact').show();
            $.ajax({
                type:'POST',
                url:"{{route('ajax.send.contact')}}",
                dataType: 'json',
                data:$('#contact_form').serialize(),
                success:function(data){
                        if(data.status=1) {
                             $('#msg').html('<span class="success">Your message is successfully send.. thank you for contact us .</span>')
                           }
                        setTimeout(function() {
                             $('#loadSpinContact').hide();
                             $('#msg').html('')
                        }, 2000);
                    }
                });
        }
       });
</script>

@endsection

       
