

// client_logo_slider
var cc = $('#client_logo_slider');
cc.owlCarousel({
	autoplay:300,
    loop:true,
    nav:true,
	dots:false,
	margin:4,
	//animateOut: 'fadeOut',
    items: 4,
	navText: [ '<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>' ],
	
	responsive : {
    // breakpoint from 0 up
   0:{
            items:3,
            nav:false
        },
    // breakpoint from 480 up
   480:{
            items:3,
            nav:false,	
        },
    // breakpoint from 768 up
    768:{
            items:5,
            nav:false,
        },
		
		992:{
            items:6,
            nav:false,
        }
	
}
});

//Header fixed on scroll
/*$(window).bind("scroll", function(){
    if ($(window).scrollTop() >= 300) {
      $('#headerfixed').addClass('fixed');
    } else {
      $('#headerfixed').removeClass('fixed');
    }
});*/
//Header fixed on scroll
$(window).bind("scroll", function(){ //when the user is scrolling...
    if ($(window).scrollTop() >= 100) { //header hide by scroll
      $('#headerfixed').addClass('overflow');
    } else {
      $('#headerfixed').removeClass('overflow');
    }
    if ($(window).scrollTop() >= 200) { //header is show past 400px
      $('#headerfixed').addClass('fixed');
    } else {
      $('#headerfixed').removeClass('fixed');
    }
});


