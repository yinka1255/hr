jQuery(window).load(function(){
    setTimeout(function(){
        jQuery(".rt-case-study-box.element-four.isotope").each(function(){
            var $RTCaseStudyBoxElementFour = jQuery(this).isotope({
                layoutMode: 'masonry',
            });
            jQuery(this).parent().children(".rt-case-study-box-filter > button:last-child").addClass("current-menu-item");
            jQuery(this).parent().children(".rt-case-study-box-filter").on( 'click', 'button', function(){
                jQuery(this).parent().find("button").removeClass("current-menu-item");
                jQuery(this).attr("class","current-menu-item");
                $RTCaseStudyBoxElementFour.isotope({
                    filter: jQuery(this).attr("data-filter"),
                });
            });
            if ( jQuery(this).hasClass("has-fancybox") ) {
                jQuery(this).find(".fancybox").fancybox({
                    animationEffect: "zoom-in-out",
                    animationDuration: 500,
                    zoomOpacity: "auto",
                });
            }
        });
    }, 1000);
});