jQuery(document).ready(function($){
  'use strict';

  if($('.gum_portfolio').length){

    $('.gum_portfolio').each(function(){

      var $filter = $(this).find('.portfolio-filter');
      var $container = $(this).find('.portfolio-content');


      $container.imagesLoaded({background:true},function(){

          try{

            $container.isotope({
              filter: '*',
              selector: '.portfolio'
            });

            if($filter.length){

              $('li',$filter).click(function(e){

                e.preventDefault();
                var link = $(this);
                var selector = link.data('selector');

                $('li',$filter).removeClass('active');
                link.addClass('active');

                if(selector!='*') selector = '.'+selector;

                $container.isotope({
                    filter: selector,
                    selector: '.portfolio',
                    animationOptions: {
                      duration: 500,
                      animationEngine : "jquery"
                    }
                  });
              });
            }
          }
          catch(err){}

      });

    });
  }
});