jQuery(document).ready(function($){
  'use strict';

  // general setup
  var isSlideLeft = $('body').hasClass('slide-bar-left');

  // Woocommerce

   $('body').on('added_to_cart',function(e, fragments, data){

        var item_count = (fragments['cart_content_count']) ? fragments['cart_content_count'] : 0;
        $('.cart-menu .cart-count').html('<span class="item_count">'+item_count+'</span>');
    });

  // smooth scroll anchor

     var url_test=location.hash;

     if(url_test!=''){
        lets_Scroll($(url_test));
     }


    $("a[href*='#']:not([href='#'])").on("click", function(e) {

        if($(this).closest('.woocommerce-tabs').length || $(this).data('toggle')=='tab' || $(this).data('toggle')=='collapse' || $(this).data('slide')=='next' || $(this).data('slide')=='prev'
          || $(this).is('#cancel-comment-reply-link')  || $(this).is('.comment-reply-link') || $(this).is('.woocommerce-review-link') || $(this).is('.ui-tabs-anchor') 
          || typeof $(this).data('vc-container')=='string' || $(this).closest('.vc_tta-tabs-list').length || $(this).closest('.wpb_accordion_section').length || $(this).closest('.nav-tabs').length){
          return;
        }
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

            var target = $(this.hash);
            if(target.length){
              e.preventDefault();
              lets_Scroll(target);
            }
        }

    });


    function lets_Scroll(target){

           var scroll,navbar=$('#top-bar'),offset=0;
           var ua = window.navigator.userAgent;
           var msie = ua.indexOf("MSIE ");

            var target = target.length ? target : $("[id=" + this.hash.slice(1) + "]");
            scroll = target.offset().top;

            if(navbar.length){
               offset=navbar.outerHeight(true)+parseInt($('html').css('margin-top'));
            }

            if (target.length) {

                if (typeof document.body.style.transitionProperty === 'string' && !msie) {

                    var avail = $(document).height() - $(window).height();

                    if (scroll > avail) {
                        scroll = avail;
                    }


                    $("body").css({
                        "margin-top" : ( $(window).scrollTop() - scroll + offset) + "px",
                        "transition" : "1s ease-in-out"
                    }).data("transitioning", true);

                } else {
                    $("html, body").animate({
                        scrollTop: scroll-offset
                    }, 1000);
                    return;
                }
            }

        $("body").on("transitionend webkitTransitionEnd msTransitionEnd oTransitionEnd", function (e) {
        if (e.target == e.currentTarget && $(this).data("transitioning") === true) {
            $(this).removeAttr("style").data("transitioning", false);
            $("html, body").scrollTop(scroll-offset);
             return;
          }
        });
    } 


  /* =================================
  MAGNIFIC POPUP
  =================================== */

  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,

      fixedContentPos: false
    });


  $('.el_image a.img-lightbox').magnificPopup({
          type: 'image',
          closeOnContentClick: true,
          disableOn: 700,
          closeBtnInside: false,
          fixedContentPos: true,
          mainClass: 'mfp-fade', 
          image: {
            verticalFit: true
          },
          zoom: {
            enabled: true,
            duration: 300 
          }
    });

  /* optin widget */

  if($('.widget.petro_optin').length){

    $('.widget.petro_optin').each(function(){
      var opt = $(this),$form=$('.optin-code form',opt);

            $('.optin-submit',opt).on('click', function(e){

              e.preventDefault();
              var name = $('input[name=optin_name]',opt).val(),email = $('input[name=optin_email]',opt).val();
              var nonce = $('input[name=petro-optin-nonce]',opt).val();

              if(email!='' && nonce!=''){
                   var findName = $form.find("input[name*=name], input[name*=NAME], input[name*=Name]").not("input[type=hidden]").val(name);
                   var findEmail = $form.find("input[name*=email], input[name*=EMAIL], input[type=email], input[name=eMail]").not("input[type=hidden]").val(email);
                   $form.submit();
                }
            });



    });
  }


 /* more comment reply */

  if($('.comment-collapse').length){
    $('.comment-collapse').each(function(){
        var $btn = $(this);
        var $parent = $btn.closest('.comment');
        var $child = $btn.next('.children');

        $btn.on("click", function(e){

            e.preventDefault();

            $btn.css('border','solid 2px red');
            $parent.addClass('expanded-in');
            $child.addClass('collapse-in');

            $(this).remove();

        });
    });
  }
/* main menu */


if($('.top-heading .module-main-menu').length){

  /* updated since 2.1.0 */

  var menu_friends = $('.top-heading .module-main-menu').closest('.container').find('.heading-module');
  var mobile_bar = $('.navigation-bar-mobile');

  menu_friends.each(function(e){
    var child = $(this).clone();

    if(child.hasClass('logo')) {
      return;
    }

    child.removeClass('top-bar-module').removeClass('bottom-bar-module').removeClass('middle-bar-module');

    var child_alt = child.clone();

    if(child.find('.module-main-menu').length){

      $('.menu-item.menu-item-has-children > a,'+
          '.page_item.page_item_has_children > a',
      child_alt).each(function(i, e){

          var $menu_item = $(this),$parent = $menu_item.closest('li');
          var $child = $menu_item.find('> .sub-menu-container');

          $menu_item.unbind('click').click(function(e){

            e.preventDefault();

            if($parent.hasClass('menu-expand')){
              var url = $menu_item.attr('href');
              if(url!='' && url!='#') {
                  return window.location = url; 
              }
              
              $parent.removeClass('menu-expand');
          
            }
            else{
              $parent.addClass('menu-expand');
            }
          });

        });   
      
    }

    mobile_bar.append(child_alt);
  
  });

  }

/* widget menu and pages */

if($(
    '.widget_pages .menu-item.menu-item-has-children > a,'+
    '.widget_nav_menu .menu-item.menu-item-has-children > a,'+
    '.widget_pages .page_item.page_item_has_children > a,'+
    '.widget_nav_menu .page_item.page_item_has_children > a'
    ).length){
        $(
          '.widget_pages .menu-item.menu-item-has-children > a,'+
          '.widget_nav_menu .menu-item.menu-item-has-children > a,'+
          '.widget_pages .page_item.page_item_has_children > a,'+
          '.widget_nav_menu .page_item.page_item_has_children > a'
          ).each(function(i, e){
          var $menu_item = $(this), $toggle= $menu_item.find('> .toggle-dropdown');
          var $child = $menu_item.find('> .sub-menu-container'), $back_btn= $child.find('> .expand-menu');

          $menu_item.unbind('click').on('click', function(e){

            var m_width = $(this).width();
            var x_coor = e.clientX;
            var x_offset = $(this).offset().left;
            var gap = x_offset + m_width - x_coor;

            if(gap > 25 ) return;
            e.preventDefault();
            $(this).closest('.menu-item-has-children,.page_item_has_children').toggleClass('menu-expand');
          });

        });

     }


 // slide sidebar toggle

 if($('.slide-sidebar-container').length){

  if($('#wpadminbar').length){
    $('.slide-sidebar-container').css('top',$('#wpadminbar').outerHeight());
  }

  $('.slide-bar').each(function(){
    var slidebtn = $(this);

      slidebtn.unbind('click').on('click', function(e){
        e.preventDefault();
         $('body').toggleClass('slide-bar-in');
         if(isSlideLeft){
          if($('body').hasClass('slide-bar-in')){
            slidebtn.removeClass('right');
          }
          else{
            slidebtn.addClass('right');
          }

         }else{
          if($('body').hasClass('slide-bar-in')){
            slidebtn.addClass('right');
          }
          else{
            slidebtn.removeClass('right');
          }

         }
     });
  });



   $('.slide-sidebar-overlay').unbind('click').on('click', function(e){
      e.preventDefault();
      $('body').removeClass('slide-bar-in');
   });
  }


 $(window).resize(function(){
  //  collapse-in

    var winWide = $(window).width();

    if( winWide <= 768){
      $('body').addClass('mobile');
  
    }
    else{

      $('body').removeClass('mobile');
    }


  /**
   * scroll to top
   */

    if($("#toTop").length){
     $(window).scroll(function () {

        var winHeight = $(window).height();

        if($('#wpadminbar').length){
          winHeight -= $('#wpadminbar').outerHeight();
        }

        if ($(this).scrollTop() > winHeight) {
          $("#toTop").fadeIn();
        } else {
          $("#toTop").fadeOut();
        }
      });

     $("#toTop").on('click', function () {
        $("body,html").animate({
          scrollTop: 0
        },
        800);
     });
    }

    if($('.page-heading .navigation-bar.sticky').length) {
      var tbar = $('.page-heading .navigation-bar');

      if(tbar.hasClass('mobile-sticky') || $(window).width() > 600 ){

        var theight = tbar.outerHeight(true);
        var sticky_offset = $('.sticky_offset').length ? $('.sticky_offset') : $('.page-heading');

         tbar.affix({
          offset: {
            top:function(){
              var offsetTop =  2 + sticky_offset.outerHeight(true) - theight;

              return (this.top = offsetTop);
            }
          }
        });


      }


    }

   });


   // top bar search

   $('.icon-bar-inner .search-btn').on('click', function(e){
      e.preventDefault();

       var parent = $(this).closest('.icon-bar-inner');
       parent.toggleClass('search-open');

        $('body').on('click', function(event){
              if (!$(event.target).is(".search-btn, .icon-bar-inner .search-form *")){
                parent.removeClass('search-open');
              }
        });

   });

    $('[data-toggle="popover"]').popover();

    $('.popover-dismiss').popover({
      trigger: 'focus'
    });



  $(window).resize();
  $(window).scroll();
});