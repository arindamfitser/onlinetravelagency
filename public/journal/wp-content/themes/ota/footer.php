<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>


<footer>
		<div class="container">
				<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="sosal-box2"> <a href="#"><i aria-hidden="true" class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a> </div>
								<div class="footernav">
                                <?php wp_nav_menu( array(
                                        'theme_location' => 'secondary',
                                        'items_wrap'     => '<ul>%3$s</ul>'
                                     ) );
                                    ?>
										
								</div>
								<p>By continuing your use of this site you accept the use of cookies in order to provide statistical analysis </p>
								<p>&copy; 2018 <a href="<?php base_url();?>">Luxury Fishing.</a> All rights reserved. Website Developed by<a href="https://www.fitser.com/" rel="nofollow" title="Fitser" target="_blank"> Fitser.</a></p>
						</div>
				</div>
		</div>
</footer>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script> 
<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --> 
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script> 
<!--<script type="text/javascript" src="js/stellarnav.min.js"></script> --> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/webslidemenu.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/wow.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/theme.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/t-datepicker.js"></script> 
<!-- Gallery Load More and top script Script--> 
<script>
	
$(function () {
    $(".experience_box_load").slice(0, 6).show();
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".experience_box_load:hidden").slice(0, 2).slideDown();
        if ($(".experience_box_load:hidden").length == 0) {
            $("#load").fadeOut('slow');
        }
        $(".navigation_sec").animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
});
	
	</script>
	
	<script>
	
$(function () {
    $(".inspiration_box_load").slice(0, 6).show();
    $("#loadMore_insp").on('click', function (e) {
        e.preventDefault();
        $(".inspiration_box_load:hidden").slice(0, 2).slideDown();
        if ($(".inspiration_box_load:hidden").length == 0) {
            $("#load").fadeOut('slow');
        }
        $(".navigation_sec").animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
});
	
	</script>

<!-- sript for mobile search --> 
<script>
$(document).ready(function(){
    $("#search_toggle_open").click(function(){
        $("#mobile_search_area_toggle").toggle(300);
				$(".navigation_sec").addClass("nav_toggle_bg");
    });
	    $("#wsnavtoggle").click(function(){
        $("#mobile_search_area_toggle").hide(300);
				$(".navigation_sec").removeClass("nav_toggle_bg");
    });	
	
		$("#search_toggle_open").click(function(){
			
	});
	
});
</script> 
<!--<script>
 $(document).ready(function(){
    $('.t-datepicker').tDatePicker({
    });
  });
</script>--> 
<script type="text/javascript">
		
	</script> 
<!-- stiky_menu --> 

<script>
	   wow = new WOW(
	   {
	   animateClass: 'animated',
	   offset:       200
	   }
	   );
	   wow.init();
  </script> 
<script>
//script to create sticky header 
jQuery(function(){
    createSticky(jQuery("#sticky-wrap"));
});

function createSticky(sticky) {
    if (typeof sticky != "undefined") {

        var pos = sticky.offset().top ,
            win = jQuery(window);

        win.on("scroll", function() {

            if( win.scrollTop() > pos ) {
                sticky.addClass("stickyhead");
            } else {
                sticky.removeClass("stickyhead");
            }           
        });         
    }
}
</script> 
<script>
/*$('#banner_carousel').carousel({
  interval: 7000,
  pause: false
})	*/



$(document).ready(function() {
  //carousel options
  $('#banner_carousel').carousel({
		pause: true, 
    interval: 19000,
  });
});
</script> 
<script>
//IMAGE CAROUSEL
var cd = $('#collect1, #collect2, #collect3');
cd.owlCarousel({
	loop: false,
	nav: true,
	dots: false,
	items:1,
	autoplay: 2000,
    smartSpeed: 1000,
});
</script> 
<script>
//TESTIMONIALS
var cd = $('#testiMonial');
cd.owlCarousel({
	loop: true,
	nav: false,
	dots: true,
	items:1,
	autoplay: true,
    smartSpeed: 1000,
});
</script> 

<!-- range datepicker --> 
<script>
 $(document).ready(function(){
    // Call global the function
    var date = new Date();
    var currentDate = new Date();
    var tomorrows =   date.setDate(date.getDate() + 1);

    if(localStorage.getItem('t_start')){
      var std=localStorage.getItem('t_start');
    }else{
      var std = currentDate;
    }
    if(localStorage.getItem('t_end')){
      var etd = localStorage.getItem('t_end');
    }else{
      var etd = tomorrows;
    }
    
    $('.t-datepicker').tDatePicker({
       dateCheckIn: std,
       dateCheckOut: etd
    });

  });
</script> 

<!-- adult_quntitt_button --> 
<script>
  $(document).ready(function(){

    //var quantitiy=0;
    $('.quantity-right-plus').click(function(e){

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
        if(quantity<=5){
          var quan = (quantity+1);
          $('#quantity').val((quan)+' Adults');
          $('#quantity_cart').val((quan)+' Adults'); 
           localStorage.setItem('quantity_adults', quan);
        }
        


            // Increment

          });

    $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity1 = parseInt($('#quantity').val());
        
        // If is not undefined

            // Increment
            if(quantity1>1){
              var quan1 = (quantity1-1);
              $('#quantity').val((quan1)+' Adults');
              $('#quantity_cart').val((quan1)+' Adults');
              localStorage.setItem('quantity_adults', quan1);
            }
          });
    
  }); 
</script> 

<!-- adult_quntitt_button --> 
<script>
$(document).ready(function(){

var quantitiy=0;
   $('.quantity-right-plus').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_mobile').val());
        
        // If is not undefined
            
            $('#quantity_mobile').val(quantity + 1);

          
            // Increment
        
    });

     $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_mobile').val());
        
        // If is not undefined
      
            // Increment
            if(quantity>0){
            $('#quantity_mobile').val(quantity - 1);
            }
    });
    
});	
</script> 

<script>
$(document).ready(function(){

var quantitiy=0;
   $('.quantity-right-plus-child').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_child').val());
        
        // If is not undefined
            
            $('#quantity_child').val(quantity + 1);

          
            // Increment
        
    });

     $('.quantity-left-minus-child').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_child').val());
        
        // If is not undefined
      
            // Increment
            if(quantity>0){
            $('#quantity_child').val(quantity - 1);
            }
    });
    
});	
</script> 

<script>
$(document).ready(function(){

var quantitiy=0;
   $('.quantity-right-plus-child').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_child_mobile').val());
        
        // If is not undefined
            
            $('#quantity_child_mobile').val(quantity + 1);

          
            // Increment
        
    });

     $('.quantity-left-minus-child').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_child_mobile').val());
        
        // If is not undefined
      
            // Increment
            if(quantity>0){
            $('#quantity_child_mobile').val(quantity - 1);
            }
    });
    
});	
jQuery.validator.addMethod("notEqual", function(value, element, param) {
    return this.optional(element) || value != param;
  }, "Please specify a different (non-default) value");

  $('form[id="desk_search"]').validate({
    ignore: "",
    rules: {
      keywords: 'required',
      t_start: { notEqual: "null" },
      t_end: { notEqual: "null" },
      quantity: 'required',
    },
    messages: {
      keywords: 'This keyword is required',
      t_start: 'Enter start date ',
      t_end: 'Enter end date ',
      quantity: 'Please specify a valid phone number',

    },
    submitHandler: function(e) {
      localStorage.setItem('keywords', $('#keywords').val());
      localStorage.setItem('t_start', $('#t_start').val());
      localStorage.setItem('t_end', $('#t_end').val());
      localStorage.setItem('quantity_adults', $('#quantity').val());
      localStorage.setItem('quantity_child', $('#quantity_child').val());
      e.preventDefault();
    }
  });
  // Shorthand for $( document ).ready()
  $(function() {
   $('#keywords').val( localStorage.getItem('keywords'));
   if(localStorage.getItem('quantity_adults')){
    $('#quantity').val( localStorage.getItem('quantity_adults'));
  }else{
    $('#quantity').val('2 Adults');
  }

  if(localStorage.getItem('quantity_child')){
    $('#quantity_child').val( localStorage.getItem('quantity_child'));
  }else{
    $('#quantity_child').val('0 Child');
  }
 });
</script> 

<?php wp_footer(); ?>

</body>
</html>
	

	