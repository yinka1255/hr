jQuery(document).ready(function(){
	jQuery(".rt-image-slider.element-one.owl-carousel").each(function(){
        jQuery(this).owlCarousel({
            nav: true,
            dots: false,
            loop: true,
            autoplay: true,
            autoplayTimeout: 6000,
            items: 1,
        });
        jQuery(this).find(".fancybox").fancybox({
            animationEffect: "zoom-in-out",
            animationDuration: 500,
            zoomOpacity: "auto",
        });
	});
});