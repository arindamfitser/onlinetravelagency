$(document).ready(function () {

	$(window).load(function () {
		// The slider being synced must be initialized first
		$('.carousel').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 113,
			itemMargin: 2,
			directionNav: false,
			direction: "vertical",
			asNavFor: '#slider'
		});

		$('#slider').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			sync: "#carousel"
		});
	});




});
