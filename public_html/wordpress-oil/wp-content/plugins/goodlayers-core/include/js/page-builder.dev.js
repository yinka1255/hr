/* start page builder */
(function($){
	"use strict";

	// Detect Mobile Device
	var gdlr_core_mobile = false;
	if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/BlackBerry/i) ||
		navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/Windows Phone/i) ){ 
		gdlr_core_mobile = true; 
	}else{ 
		gdlr_core_mobile = false; 
	}

	// Detect Screen
	var gdlr_core_display = 'desktop';
	if( typeof(window.matchMedia) == 'function' ){
		$(window).on('resize themename-set-display', function(){
			if( window.matchMedia('(max-width: 419px)').matches ){
				gdlr_core_display = 'mobile-portrait';
			}else if( window.matchMedia('(max-width: 767px)').matches ){
				gdlr_core_display = 'mobile-landscape'
			}else if( window.matchMedia('(max-width: 959px)').matches ){
				gdlr_core_display = 'tablet'
			}else{
				gdlr_core_display = 'desktop';
			}
		});
		$(window).trigger('themename-set-display');
	}else{
		$(window).on('resize themename-set-display', function(){
			if( $(window).innerWidth() <= 419 ){
				gdlr_core_display = 'mobile-portrait';
			}else if( $(window).innerWidth() <= 767 ){
				gdlr_core_display = 'mobile-landscape'
			}else if( $(window).innerWidth() <= 959 ){
				gdlr_core_display = 'tablet'
			}else{
				gdlr_core_display = 'desktop';
			}
		});
		$(window).trigger('themename-set-display');
	}
	
	// script for normal content
	$.fn.gdlr_core_content_script = function( filter_elem, document_ready ){

		$(this).gdlr_core_fluid_video( filter_elem );

		// audio
		if( !document_ready && typeof($.fn.mediaelementplayer) == 'function' ){
			var wpme_settings = {};
			if( typeof(_wpmejsSettings) !== 'undefined' ){ 
				wpme_settings.pluginPath = _wpmejsSettings.pluginPath; 
			}
			$(this).find('audio').mediaelementplayer(wpme_settings);
		}		

		return $(this);
	}
	
	// responsive video
	$.fn.gdlr_core_fluid_video = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('iframe[src*="youtube"], iframe[src*="vimeo"]');
		}else{
			var elem = filter_elem.filter('iframe[src*="youtube"], iframe[src*="vimeo"]');
		}
		
		elem.each(function(){

			// ignore if inside slider
			if( $(this).closest('.ls-container, .master-slider').length <= 0 ){ 
				if( ($(this).is('embed') && $(this).parent('object').length) || $(this).parent('.gdlr-core-fluid-video-wrapper').length ){ return; } 
				if( !$(this).attr('id') ){ $(this).attr('id', 'gdlr-video-' + Math.floor(Math.random()*999999)); }			
			
				var ratio = $(this).height() / $(this).width();
				$(this).removeAttr('height').removeAttr('width');
				
				try{
					$(this).wrap('<div class="gdlr-core-fluid-video-wrapper"></div>').parent().css('padding-top', (ratio * 100)+"%");
					$(this).attr('src', $(this).attr('src'));
				}catch(e){}
			}
		});	

		return $(this);
	}

	// ajax mejs
	$.fn.gdlr_core_mejs_ajax = function(){
		if( typeof($.fn.mediaelementplayer) == 'function' ){

			var wpme_settings = {};
			if( typeof(_wpmejsSettings) !== 'undefined' ){ wpme_settings.pluginPath = _wpmejsSettings.pluginPath; }
			$(this).find('audio, video').mediaelementplayer(wpme_settings);

		}
	}

	// counter item
	$.fn.gdlr_core_counter_item = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-counter-item-count[data-counter-start][data-counter-end]');
		}else{
			var elem = filter_elem.filter('.gdlr-core-counter-item-count[data-counter-start][data-counter-end]');
		}
		
		elem.each(function(){
			var counter_item = $(this);
			var start_num = parseInt($(this).attr('data-counter-start'));
			var end_num = parseInt($(this).attr('data-counter-end'));
			var duration_time = ($(this).attr('data-duration'))? parseInt($(this).attr('data-duration')): 4000;
			
			if( (gdlr_core_display == 'mobile-landscape' || gdlr_core_display == 'mobile-portrait') || $(window).scrollTop() + $(window).height() > counter_item.offset().top ){
				$({ counter_num: start_num }).animate({ counter_num: end_num }, { duration: duration_time, easing: 'easeOutExpo', 
					step: function(){
						counter_item.html( Math.ceil(this.counter_num) );
					}
				});
			}else{
				$(window).scroll(function( e ){
					if( $(this).scrollTop() + $(window).height() > counter_item.offset().top ){
						$({ counter_num: start_num }).animate({ counter_num: end_num }, { duration: duration_time,  easing: 'easeOutExpo', 
							step: function(){
								counter_item.html( Math.ceil(this.counter_num) );
							}
						});
						
						$(this).unbind('scroll', e.handleObj.handler, e);
					}
				});
			}
		});
	}

	// typed animation item
	$.fn.gdlr_core_typed_animation = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-type-animation-item-animated[data-animation-text]');
		}else{
			var elem = filter_elem.filter('.gdlr-core-type-animation-item-animated[data-animation-text]');
		}
		
		elem.each(function(){

			var animation_text = JSON.parse($(this).attr('data-animation-text'));
			
			if( typeof($.fn.typed) == 'function' && animation_text && animation_text.length > 0 ){
				$(this).typed({
					strings: animation_text,
					typeSpeed: 50,
					loop: true
				});
			}
		});
	}

	// countdown item
	$.fn.gdlr_core_countdown_item = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-countdown-wrap');
		}else{
			var elem = filter_elem.filter('.gdlr-core-countdown-wrap');
		}
		
		elem.each(function(){
			var day_field = $(this).find('.gdlr-core-day');
			var day = parseInt(day_field.text());
			
			var hrs_field = $(this).find('.gdlr-core-hrs');
			var hrs = parseInt(hrs_field.text());
			
			var min_field = $(this).find('.gdlr-core-min');
			var min = parseInt(min_field.text());
			
			var sec_field = $(this).find('.gdlr-core-sec');
			var sec = parseInt(sec_field.text());
			
			var i = setInterval(function(){
				if( sec > 0 ){
					sec--;			
				}else{
					sec = 59;
					if( min > 0 ){
						min--;
					}else{
						min = 59;
						if( hrs > 0 ){
							hrs--;
						}else{
							hrs = 24;
							if( day > 0 ){
								day--;
							}else{
								day = 0;
								hrs = 0;
								min = 0;
								sec = 0;
								clearInterval(i);
							}
							day_field.text(day);
						}
						hrs_field.text(hrs);
					}
					min_field.text(min);
				}
				sec_field.text(sec);	
			}, 1000);
		});
	}

	// accordion
	$.fn.gdlr_core_accordion = function( filter_elem ){
	
		if( typeof(filter_elem) == 'undefined' ){
			var elem_title = $(this).find('.gdlr-core-accordion-item-title');
			var elem_icon = $(this).find('.gdlr-core-accordion-item-icon');
		}else{
			var elem_title = filter_elem.filter('.gdlr-core-accordion-item-title');
			var elem_icon = filter_elem.filter('.gdlr-core-accordion-item-icon');
		}	
		
		elem_title.click(function(){
			$(this).siblings('.gdlr-core-accordion-item-content').slideDown(200);
			
			$(this).closest('.gdlr-core-accordion-item-tab').addClass('gdlr-core-active')
				.siblings('.gdlr-core-active').removeClass('gdlr-core-active')
				.find('.gdlr-core-accordion-item-content').css({display: 'block'}).slideUp(200);
		});
		elem_icon.click(function(){
			$(this).siblings('.gdlr-core-accordion-item-content-wrapper').children('.gdlr-core-accordion-item-content').slideDown(200);
			
			$(this).closest('.gdlr-core-accordion-item-tab').addClass('gdlr-core-active')
				.siblings('.gdlr-core-active').removeClass('gdlr-core-active')
				.find('.gdlr-core-accordion-item-content').css({display: 'block'}).slideUp(200);
		});
	}

	// toggle_box
	$.fn.gdlr_core_toggle_box = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem_title = $(this).find('.gdlr-core-toggle-box-item-title');
			var elem_icon = $(this).find('.gdlr-core-toggle-box-item-icon');
		}else{
			var elem_title = filter_elem.filter('.gdlr-core-toggle-box-item-title');
			var elem_icon = filter_elem.filter('.gdlr-core-toggle-box-item-icon');
		}		
		
		elem_title.click(function(){
			var toggle_parent = $(this).closest('.gdlr-core-toggle-box-item-tab');
			if( toggle_parent.hasClass('gdlr-core-active') ){
				
				toggle_parent.removeClass('gdlr-core-active');
				$(this).siblings('.gdlr-core-toggle-box-item-content').css({display: 'block'}).slideUp(200);
				
			}else{

				toggle_parent.addClass('gdlr-core-active');
				$(this).siblings('.gdlr-core-toggle-box-item-content').css({display: 'none'}).slideDown(200);
			}
		});
		elem_icon.click(function(){
			var toggle_parent = $(this).closest('.gdlr-core-toggle-box-item-tab');
			if( toggle_parent.hasClass('gdlr-core-active') ){
				toggle_parent.removeClass('gdlr-core-active');
				$(this).siblings('.gdlr-core-toggle-box-item-content-wrapper').children('.gdlr-core-toggle-box-item-content').css({display: 'block'}).slideUp(200);
				
			}else{
				toggle_parent.addClass('gdlr-core-active');
				$(this).siblings('.gdlr-core-toggle-box-item-content-wrapper').children('.gdlr-core-toggle-box-item-content').css({display: 'none'}).slideDown(200);
			}
		});
	}	

	// alert box
	$.fn.gdlr_core_alert_box_item = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-alert-box-remove');
		}else{
			var elem = filter_elem.filter('.gdlr-core-alert-box-remove');
		}
		
		elem.click(function(){ 
			$(this).closest('.gdlr-core-alert-box-item').slideUp(400, 'easeOutQuart', function(){
				$(this).remove();
			});
		});
	}

	// parallax background
	$.fn.gdlr_core_parallax_background = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-parallax');
		}else{
			var elem = filter_elem.filter('.gdlr-core-parallax');
		}	
		
		elem.each(function(){ 
			new gdlr_core_parallax($(this)); 
		});

		return $(this);
	}
	
	var gdlr_core_parallax = function(t){
		
		this.wrapper_bg = t;
		this.wrapper = t.parent(); // background-wrap
		
		this.parallax_speed = parseFloat(t.attr('data-parallax-speed'));

		this.init();
	}
	gdlr_core_parallax.prototype = {
		
		init: function(){
			
			var t = this;
			
			// set background height
			t.set_extra_height();
			$(window).on('load resize', function(){ 
				t.set_extra_height($(this)); 
				if( t.parallax_speed != 0 ){
					t.set_background_position(t);
				}
			});
			
			// scroll event
			if( t.parallax_speed != 0 ){
				$(window).on('load scroll', function(){ 
					t.set_background_position(t);
				});
			}
			
			// script for muting the vimeo/youtube player
			if( gdlr_core_mobile ){
				t.wrapper_bg.children('[data-background-type="video"]').remove();
				
				if( t.wrapper_bg.attr('data-video-fallback') ){
					t.wrapper_bg.css('background-image', 'url(' + t.wrapper_bg.attr('data-video-fallback') + ')')
				}
			}else{
				t.wrapper_bg.children('[data-background-type="video"]').each(function(){
					$(this).find('iframe').each(function(){
						if( $(this).attr('data-player-type') == 'vimeo' ){
							var player = $f($(this)[0]);
							
							player.addEvent('ready', function() {
								player.api('setVolume', 0);
							});
						}else if( $(this).attr('data-player-type') == 'youtube' ){

							// assign the script
							if( $('body').children('#gdlr-core-youtube-api').length == 0 ){
								$('body').append('<script type="text/javascript" src="https://www.youtube.com/iframe_api" id="gdlr-core-youtube-api" ></script>');
							}
							
							// store to global variable
							if( typeof(window.gdlr_core_ytb) == 'undefined' ){
								window.gdlr_core_ytb = [$(this)[0]];
							}else{
								window.gdlr_core_ytb.push($(this)[0]);
							}
							
							// script loading action
							window.onYouTubeIframeAPIReady = function(){
								for( var key in window.gdlr_core_ytb ){
									new YT.Player(gdlr_core_ytb[key],{
										events: { 
											'onReady': function(e){
												e.target.mute();
											}
										}						
									});
								}
							}
						}
					});
				});
			} // else gdlr_core_mobile
			
		}, // init
		
		set_extra_height: function(){
			
			var t = this;
			
			var new_height = t.wrapper.outerHeight();
			if( gdlr_core_display == 'mobile-landscape' || gdlr_core_display == 'mobile-portrait' ){
				t.wrapper_bg.css({'transform': ''});
			}else{
				if( t.parallax_speed > 0){
					new_height += (($(window).height() - t.wrapper.outerHeight()) * t.parallax_speed);
				}else if( t.parallax_speed < 0){
					new_height += (($(window).height() + t.wrapper.outerHeight()) * Math.abs(t.parallax_speed));
				}
			}
			t.wrapper_bg.css({height: new_height});
			
			// set video height
			var ratio = parseInt(gdlr_core_pbf.video.width) / parseInt(gdlr_core_pbf.video.height);
			t.wrapper_bg.children('[data-background-type="video"]').each(function(){
				if( (t.wrapper_bg.width() / t.wrapper_bg.height()) > ratio ){
					var v_height = t.wrapper_bg.width() / ratio;
					var v_margin = (t.wrapper_bg.height() - v_height) / 2;
					$(this).css({width: t.wrapper_bg.width(), height: v_height, 'margin-left': 0, 'margin-top': v_margin});
				}else{
					var v_width = t.wrapper_bg.height() * ratio;
					var v_margin = (t.wrapper_bg.width() - v_width) / 2;
					$(this).css({width: v_width, height: t.wrapper_bg.height(), 'margin-left': v_margin, 'margin-top': 0});
				}
			});
			
		}, // set_extra_height
		
		set_background_position: function( t ){

			if( gdlr_core_display == 'mobile-landscape' || gdlr_core_display == 'mobile-portrait' ) return;
			
			var wrapper_top = t.wrapper.offset().top;
			var scroll_pos = $(window).scrollTop();

			if( scroll_pos + $(window).height() > wrapper_top && 
				scroll_pos < wrapper_top + t.wrapper.outerHeight() ){
				
				if( t.parallax_speed > 0 ){
					t.wrapper_bg.css({'transform': 'translate(0px, ' + (($(window).scrollTop() - wrapper_top) * t.parallax_speed) + 'px)'});
				}else if( t.parallax_speed < 0 ){
					t.wrapper_bg.css({'transform': 'translate(0px, ' + (($(window).scrollTop() + $(window).height() - wrapper_top) * t.parallax_speed) + 'px)'});
				}
			}
		}
	}; // gdlr_core_parallax
	
	// ux animation
	var gdlr_core_ux = function( container, filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			this.elem = container.find('[data-gdlr-animation]');
		}else{
			this.elem = filter_elem.filter('[data-gdlr-animation]');
			this.preload = filter_elem.filter('.gdlr-core-page-preload');
		}
		
		this.ux_items = [];
		this.ux_item_length = 0;
		
		this.init();
		
	} // gdlr_core_ux
	gdlr_core_ux.prototype = {
		
		init: function(){
			
			var t = this;
			
			t.ux_item_length = t.elem.each(function(){
				var ux_item = $(this);
				var ux_item_offset = 0.8;
				if( $(this).attr('data-gdlr-animation-offset') ){
					ux_item_offset = parseFloat($(this).attr('data-gdlr-animation-offset'));
				}
				
				// check item at the first time the page is loaded
				if( (gdlr_core_display == 'mobile-landscape' || gdlr_core_display == 'mobile-portrait') || $(window).scrollTop() + $(window).height() > ux_item.offset().top ){
					t.ux_items.push(ux_item);
					
				// check the item on scroll event
				}else{
					$(window).scroll(function(e){
						if( $(window).scrollTop() + ($(window).height() * ux_item_offset) > ux_item.offset().top ){
							t.ux_items.push(ux_item);
							$(window).unbind('scroll', e.handleObj.handler, e);
						} 
					});
				}
			}).length;
			
			if( typeof(t.preload) != 'undefined' && t.preload.length ){
				$(window).load(function(){
					var preload_time = t.preload.attr('data-animation-time');
					if( !preload_time ){ preload_time = 0; }
					
					setTimeout(function(){
						t.animate();
					}, preload_time);
				});
			}else{
				t.animate();
			}
			
		},
		
		animate: function(){
			
			var t = this;
			
			// run the ux in order with delay
			var ux_interval = setInterval(function(){ 
				
				while( t.ux_items.length > 0 ){

					// animate the ux item
					var ux_animate = t.ux_items.shift();
					var animation_duration = '600ms';
					if( ux_animate.attr('data-gdlr-animation-duration') ){
						animation_duration = ux_animate.attr('data-gdlr-animation-duration');
					}

					ux_animate.css({ 'animation-duration':  animation_duration });
					ux_animate.addClass(ux_animate.attr('data-gdlr-animation'));
					
					// remove selector
					setTimeout(function(){
						ux_animate.css({ 'animation-duration':  '' })
							.removeClass(ux_animate.attr('data-gdlr-animation'))
							.removeAttr('data-gdlr-animation');
					}, parseInt(animation_duration));	
						
					t.ux_item_length--;

					// if item is inside the screen break while loop
					if(	$(window).scrollTop() < ux_animate.offset().top + ux_animate.outerHeight() ){
						break;
					}
				}
				
				if( t.ux_item_length <= 0 ){
					clearInterval(ux_interval);
				}
			}, 200);
			
		}
		
	}; // gdlr_core_ux.prototype
	$.fn.gdlr_core_ux = function( filter_elem ){
		new gdlr_core_ux( $(this), filter_elem );
		
		return $(this);
	}
	
	// skill bar
	$.fn.gdlr_core_skill_bar = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-skill-bar-filled');
		}else{
			var elem = filter_elem.filter('.gdlr-core-skill-bar-filled');
		}	
		
		elem.each(function(){
			var t = $(this);
			
			if( (gdlr_core_display == 'mobile-landscape' || gdlr_core_display == 'mobile-portrait') || $(window).scrollTop() + $(window).height() > t.offset().top ){
				t.animate({width: parseInt(t.attr('data-width')) + '%'}, {duration: 1200, easing: 'easeOutQuart'});	
			}else{
				$(window).scroll(function(e){
					if( $(window).scrollTop() + $(window).height() > t.offset().top ){
						t.animate({width: parseInt(t.attr('data-width')) + '%'}, {duration: 1200, easing: 'easeOutQuart'});
						$(window).unbind('scroll', e.handleObj.handler, e);
					} 
				});
			}
		});
	}
	
	// divider width
	$.fn.gdlr_core_divider = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-divider-item-with-icon-inner');
		}else{
			var elem = filter_elem.filter('.gdlr-core-divider-item-with-icon-inner');
		}
	
		elem.each(function(){
			var divider_elem = $(this);
			var icon_width = divider_elem.children('i, img').outerWidth();
			var divider_width = (divider_elem.width() - icon_width) / 2;
			$(this).children('.gdlr-core-divider-line').css({ width: divider_width }).each(function(){
				$(this).css('margin-top', -$(this).outerHeight()/2);
			});

			$(window).resize(function(){
				icon_width = divider_elem.children('i, img').outerWidth();
				divider_width = (divider_elem.width() - icon_width) / 2;
				divider_elem.children('.gdlr-core-divider-line').css({ width: divider_width }).each(function(){
					$(this).css('margin-top', -$(this).outerHeight()/2);
				});
			});
		});
		
	}	

	window.gdlr_core_sidebar_wrapper = function( container, filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			this.elem = container.find('.gdlr-core-page-builder-wrapper-sidebar-container, .gdlr-core-pbf-sidebar-container');
		}else{
			this.elem = filter_elem.filter('.gdlr-core-page-builder-wrapper-sidebar-container, .gdlr-core-pbf-sidebar-container');
		}

		this.init();

	}
	gdlr_core_sidebar_wrapper.prototype = {

		init: function(){

			var t = this;

			t.set_height();
			$(window).on('load resize', function(){ t.set_height(); });
		},

		set_height: function(){

			var t = this;
			
			t.elem.each(function(){
				if( gdlr_core_display == 'mobile-landscape' || gdlr_core_display == 'mobile-portrait' ) return;

				var sidebar_elem = $(this).find('.gdlr-core-pbf-sidebar-padding');
				var max_height = 0;

				// determine max height
				sidebar_elem.css('min-height', '').each(function(){
					if( $(this).outerHeight() > max_height ){
						max_height = $(this).outerHeight();
					}
				});

				// set the height
				sidebar_elem.css('min-height', max_height);

			});
			
		}

	};

	// title divider width
	$.fn.gdlr_core_title_divider = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-title-item-title-wrap.gdlr-core-with-divider');
		}else{
			var elem = filter_elem.filter('.gdlr-core-title-item-title-wrap.gdlr-core-with-divider');
		}
	
		elem.each(function(){
			var t = $(this);
			var title_width = t.children('.gdlr-core-title-item-title').outerWidth(true);
			var divider_num = t.children('.gdlr-core-title-item-divider').length;
			divider_num = (divider_num)? divider_num: 1;
			
			var divider_width = (t.width() - title_width) / divider_num;
	
			// for right divider with link text
			if( divider_num == 1 ){
				var right_pos = t.children('.gdlr-core-title-item-link').outerWidth() + 20;
				t.children('.gdlr-core-title-item-divider').css({ width: (divider_width - right_pos), right: right_pos });
			}else{
				t.children('.gdlr-core-title-item-divider').css({ width: divider_width });
			}

			$(window).resize(function(){
				title_width = t.children('.gdlr-core-title-item-title').outerWidth(true);
				divider_width = (t.width() - title_width) / divider_num;

				// for right divider with link text
				if( divider_num == 1 ){
					right_pos = t.children('.gdlr-core-title-item-link').outerWidth() + 20;
					t.children('.gdlr-core-title-item-divider').css({ width: (divider_width - right_pos), right: right_pos });
				}else{
					t.children('.gdlr-core-title-item-divider').css({ width: divider_width });
				}
			});
		});

		if( typeof(filter_elem) == 'undefined' ){
			var elem2 = $(this).find('.gdlr-core-title-item-title-wrap.gdlr-core-with-link-text');
		}else{
			var elem2 = filter_elem.filter('.gdlr-core-title-item-title-wrap.gdlr-core-with-link-text');
		}
		elem2.each(function(){
			var t = $(this);
			var title_width = t.children('.gdlr-core-title-item-title').outerWidth(true);
			var right_pos = t.children('.gdlr-core-title-item-link').outerWidth();

			if( t.width() < title_width + right_pos ){
				t.children('.gdlr-core-title-item-link').addClass('gdlr-core-overflow');
			}else{
				t.children('.gdlr-core-title-item-link').removeClass('gdlr-core-overflow');
			}

			$(window).resize(function(){
				if( t.width() < title_width + right_pos ){
					t.children('.gdlr-core-title-item-link').addClass('gdlr-core-overflow');
				}else{
					t.children('.gdlr-core-title-item-link').removeClass('gdlr-core-overflow');
				}
			});

		});
		
	}

	$.fn.gdlr_core_flipbox = function( filter_elem ){
		if(typeof($.fn.flip) == 'function'){
			
			if( typeof(filter_elem) == 'undefined' ){
				var elem = $(this).find('.gdlr-core-flipbox');
			}else{
				var elem = filter_elem.filter('.gdlr-core-flipbox');
			}			
			
			elem.each(function(){
				$(this).flip({
					axis: 'y',
					trigger: 'hover',
					autoSize: false,
					front: '.gdlr-core-flipbox-front',
					back: '.gdlr-core-flipbox-back'
				});
				
				$(this).addClass('gdlr-core-after-init');
			});
		}

		return $(this);
	}
	
	// pie chart
	function gdlr_core_skill_circle_height(t){
		t.children('.gdlr-core-skill-circle-content').each(function(){
			$(this).css({'margin-top': -$(this).outerHeight()/2});
		});
		t.css({'max-width': t.parent().width(), 'max-height': t.parent().width()});	
	}
	$.fn.gdlr_core_pie_chart = function(){
		if(typeof($.fn.easyPieChart) == 'function'){
			$(this).easyPieChart({
				animate: parseInt($(this).attr('data-duration')),
				lineWidth: parseInt($(this).attr('data-line-width')),
				size: parseInt($(this).attr('data-width')),
				barColor: $(this).attr('data-filled-color'),
				trackColor: $(this).attr('data-filled-background'),
				scaleColor: false,
				lineCap: 'square'
			});
		}
	}
	$.fn.gdlr_core_skill_circle = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-skill-circle');
		}else{
			var elem = filter_elem.filter('.gdlr-core-skill-circle');
		}		
		
		elem.each(function(){
			var t = $(this);

			// for responsive
			gdlr_core_skill_circle_height(t);
			$(window).resize(function(){ gdlr_core_skill_circle_height(t); });
			
			// scroll action
			if( $(window).scrollTop() + $(window).height() > t.offset().top ){
				t.gdlr_core_pie_chart();
			}else{
				$(window).scroll(function(e){
					if( $(window).scrollTop() + $(window).height() > t.offset().top ){
						t.gdlr_core_pie_chart();
						$(window).unbind('scroll', e.handleObj.handler, e);
					} 
				});
			}
		});
	}
	
	// tab
	$.fn.gdlr_core_tab = function( filter_elem ){
		
		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-tab-item');
		}else{
			var elem = filter_elem.filter('.gdlr-core-tab-item');
		}		
		
		elem.each(function(){
			
			// click action
			$(this).find('.gdlr-core-tab-item-title').click(function(){
				if( $(this).hasClass('gdlr-core-active') ) return;
				
				var tab_id = $(this).attr('data-tab-id');
				
				$(this).addClass('gdlr-core-active').siblings().removeClass('gdlr-core-active');
				$(this).parent().siblings('.gdlr-core-tab-item-content-wrap')
					.children('[data-tab-id="' + tab_id + '"]').fadeIn(200)
					.siblings().hide();
			});
			
			// hover action
			if( $(this).is('.gdlr-core-tab-style2-horizontal, .gdlr-core-tab-style2-vertical') ){
				var horizontal = $(this).is('.gdlr-core-tab-style2-horizontal');
				var hover_line = $(this).find('.gdlr-core-tab-item-title-line');
				var hover_line_w = 0;
				var hover_line_l = 0;
				
				// initiate
				$(this).children('.gdlr-core-tab-item-title-wrap').children('.gdlr-core-active').each(function(){
					if( horizontal ){
						hover_line_w = $(this).outerWidth();
						hover_line_l = $(this).position().left;
						hover_line.css({ width: hover_line_w, left: hover_line_l });
					}else{
						hover_line_w = $(this).outerHeight();
						hover_line_l = $(this).position().top;
						hover_line.css({ height: hover_line_w, top: hover_line_l });
					}
				});
				$(window).resize(function(){
					$(this).children('.gdlr-core-tab-item-title-wrap').children('.gdlr-core-active').each(function(){
						if( horizontal ){
							hover_line_w = $(this).outerWidth();
							hover_line_l = $(this).position().left;
							hover_line.css({ width: hover_line_w, left: hover_line_l });
						}else{
							hover_line_w = $(this).outerHeight();
							hover_line_l = $(this).position().top;
							hover_line.css({ height: hover_line_w, top: hover_line_l });
						}
					});
				});
				
				// animate
				$(this).children('.gdlr-core-tab-item-title-wrap').children('.gdlr-core-tab-item-title').hover(function(){
					if( horizontal ){
						hover_line.animate({ width: $(this).outerWidth(), left: $(this).position().left }, { duration: 300, easing: 'easeOutQuart', queue: false });
					}else{
						hover_line.animate({ height: $(this).outerHeight(), top: $(this).position().top }, { duration: 300, easing: 'easeOutQuart', queue: false });
					}
				}, function(){
					if( horizontal ){
						hover_line.animate({ width: hover_line_w, left: hover_line_l }, { duration: 300, easing: 'easeOutQuart', queue: false });
					}else{
						hover_line.animate({ height: hover_line_w, top: hover_line_l }, { duration: 300, easing: 'easeOutQuart', queue: false });
					}
				});
				
				// click
				$(this).children('.gdlr-core-tab-item-title-wrap').children('.gdlr-core-tab-item-title').click(function(){
					if( horizontal ){
						hover_line_w = $(this).outerWidth();
						hover_line_l = $(this).position().left;
						hover_line.css({ width: hover_line_w, left: hover_line_l });
					}else{
						hover_line_w = $(this).outerHeight();
						hover_line_l = $(this).position().top;
						hover_line.css({ height: hover_line_w, top: hover_line_l });
					}
				});
			}
		});
	} // gdlr_core_tab
	
	$.fn.gdlr_core_sly = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-sly-slider');
		}else{
			var elem = filter_elem.filter('.gdlr-core-sly-slider');
		}	
	
		elem.addClass('gdlr-core-after-init').each(function(){
			var sly_slider = $(this);

			sly_slider.sly({
				horizontal: 1,
				itemNav: 'basic',
				smart: 1,
				activateOn: 'click',
				mouseDragging: 1,
				touchDragging: 1,
				releaseSwing: 1,
				startAt: 0,
				scrollBy: 1,
				speed: 1000,
				elasticBounds: 1,
				easing: 'easeOutQuart',
				dragHandle: 1,
				dynamicHandle: 1,
				clickBar: 1,
				scrollBar: $(this).siblings('.gdlr-core-sly-scroll')
			});
			$(window).resize(function(){ sly_slider.sly('reload'); });
		});

		return $(this);

	} // gdlr-core_sly

	$.fn.gdlr_core_flexslider = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-flexslider');
		}else{
			var elem = filter_elem.filter('.gdlr-core-flexslider');
		}	
	
		elem.each(function(){

			var flex_attr = {
				useCSS: false,
				animation: 'fade',
				animationLoop: true,
				prevText: '<i class="arrow_carrot-left"></i>',
				nextText: '<i class="arrow_carrot-right"></i>'
			};

			if( $(this).find('.gdlr-core-flexslider').length > 0 ){ 
				$(this).children('ul.slides').addClass('parent-slides');
				flex_attr.selector = '.parent-slides > li'
			}

			// variable settings
			if( $(this).attr('data-disable-autoslide') ){
				flex_attr.slideshow = false;
			}
			if( $(this).attr('data-pausetime') ){
				flex_attr.slideshowSpeed = parseInt($(this).attr('data-pausetime'));
			}
			if( $(this).attr('data-slidespeed') ){
				flex_attr.animationSpeed = parseInt($(this).attr('data-slidespeed'));
			}else{
				flex_attr.animationSpeed = 500;
			}

			// for carousel
			if( $(this).attr('data-type') == 'carousel' ){
				flex_attr.move = 1;
				flex_attr.animation = 'slide';

				// determine the spaces
				var column_num = parseInt($(this).attr('data-column'));
				flex_attr.itemMargin = 2 * parseInt($(this).children('ul.slides').children('li:first-child').css('margin-right'));
				flex_attr.itemWidth = ($(this).width() / column_num) - (flex_attr.itemMargin);

				flex_attr.minItems = column_num;
				flex_attr.maxItems = column_num;

			}else if( $(this).attr('data-effect') ){
				if( $(this).attr('data-effect') == 'kenburn' ){
					flex_attr.animation = 'fade';
				}else{
					flex_attr.animation = $(this).attr('data-effect');
				}
			}

			// for navigation
			if( !$(this).attr('data-nav') || $(this).attr('data-nav') == 'both' || $(this).attr('data-nav') == 'navigation' || $(this).attr('data-nav') == 'navigation-outer' ){
				if( $(this).attr('data-nav-parent') ){
					$(this).closest('.' + $(this).attr('data-nav-parent')).each(function(){
						var flex_nav = $('<ul class="flex-direction-nav">\
										<li class="flex-nav-prev"><a class="flex-prev" href="#"><i class="arrow_carrot-left"></i></a></li>\
										<li class="flex-nav-next"><a class="flex-next" href="#"><i class="arrow_carrot-right"></i></a></li>\
									</ul>');

						var flex_nav_position = $(this).find('.gdlr-core-flexslider-nav');
						if( flex_nav_position.length ){
							flex_nav_position.append(flex_nav);
							flex_attr.customDirectionNav = flex_nav.find('.flex-prev, .flex-next');
						}
					});
				}
			}else{
				flex_attr.directionNav = false;
			}
			if( $(this).attr('data-nav') == 'both' || $(this).attr('data-nav') == 'bullet' ){
				flex_attr.controlNav = true;
			}else{
				flex_attr.controlNav = false;
			}

			// for thumbnail 
			if( $(this).attr('data-thumbnail') ){
				var thumbnail_slide = $(this).siblings('.gdlr-core-sly-slider');

				flex_attr.manualControls = thumbnail_slide.find('ul.slides li')
				flex_attr.controlNav = true;
			}

			// center the navigation
			if( $(this).attr('data-vcenter-nav') ){
				flex_attr.start = function(slider){
					if( slider.directionNav ){
						$(window).resize(function(){
							slider.directionNav.each(function(){
								var margin = -(slider.height() + $(this).outerHeight()) / 2;
								$(this).css('margin-top', margin);
							});
						});
						$(window).trigger('resize');
					}
					slider.slides.filter('.flex-active-slide').addClass('gdlr-core-active').siblings().removeClass('gdlr-core-active');
				};
			}else{
				flex_attr.start = function(slider){
					if( typeof(slider.slides) != 'undefined' ){
						$(window).trigger('resize');
						slider.slides.filter('.flex-active-slide').addClass('gdlr-core-active').siblings().removeClass('gdlr-core-active');
					}
				}
			}

			// add the action for class
			flex_attr.after = function(slider){
				slider.slides.filter('.flex-active-slide').addClass('gdlr-core-active').siblings().removeClass('gdlr-core-active');
			}

			$(this).flexslider(flex_attr);
		});

		return $(this);

	} // gdlr-core-flexslier

	$.fn.gdlr_core_isotope = function( filter_elem ){

		if(typeof($.fn.isotope) == 'function'){

			if( typeof(filter_elem) == 'undefined' ){
				var elem = $(this).find('[data-layout="masonry"]');
			}else{
				var elem = filter_elem.filter('[data-layout="masonry"]');
			}		
		
			elem.each(function(){

				var t = $(this);
				var columnSize = t.width() / 60;
				
				t.isotope({
					itemSelector: '.gdlr-core-item-list',
					layoutMode: 'masonry',
					masonry:{
						columnWidth: columnSize
					}
				});

				t.children('.gdlr-core-item-list').gdlr_core_animate_list_item();

				// resize event
				$(window).resize(function(){
					
					columnSize = t.width() / 60;
					
					t.isotope({
						masonry:{
							columnWidth: columnSize
						}
					});
				});	
			});

		}

		return $(this);

	} // gdlr-core-isotope
	$.fn.gdlr_core_animate_list_item = function(){

		var ux_items = $(this).get();

		// run the ux in order with delay
		var ux_interval = setInterval(function(){ 
			
			if( ux_items.length > 0 ){
				// animate the ux item
				var ux_animate = $(ux_items.shift());
				var animation_duration = '600ms';

				ux_animate.css({ 'animation-duration':  animation_duration });
				ux_animate.addClass('gdlr-core-animate').css('webkit-animation-duration');
				
				// remove selector
				setTimeout(function(){
					ux_animate.css({ 'animation-duration':  '' })
						.addClass('gdlr-core-animate-end').removeClass('gdlr-core-animate gdlr-core-animate-init');
				}, parseInt(animation_duration));	
					
			}else{
				clearInterval(ux_interval);
			}
		}, 200);

	}

	$.fn.gdlr_core_lightbox = function( filter_elem ){
		
		// lightbox
		if( typeof($.iLightBox) == 'function' ){

			if( typeof(filter_elem) == 'undefined' ){
				var ilightbox = $(this).find('.gdlr-core-ilightbox');
			}else{
				var ilightbox = filter_elem.filter('.gdlr-core-ilightbox');
			}		
		
			var ilightbox_atts = {};
			var ilightbox_groups = [];

			if( typeof(gdlr_core_pbf.ilightbox_skin) != 'undefined' ){
				ilightbox_atts['skin'] = gdlr_core_pbf.ilightbox_skin;
			}

			ilightbox.each(function(){
				if( $(this).attr('data-ilightbox-group') ){
					if( ilightbox_groups.indexOf($(this).attr('data-ilightbox-group')) == -1 ){
						ilightbox_groups.push($(this).attr('data-ilightbox-group'));
					}
				}else{
					$(this).iLightBox(ilightbox_atts);
				}
			});

			for( var key in ilightbox_groups ){
				$(this).find('.gdlr-core-ilightbox[data-ilightbox-group="' + ilightbox_groups[key] + '"]').iLightBox(ilightbox_atts);
			}
		}
		
		if( typeof(filter_elem) == 'undefined' ){
			var center_overlay = $(this).find('.gdlr-core-image-overlay-center, .gdlr-core-image-overlay-center-icon');
		}else{
			var center_overlay = filter_elem.filter('.gdlr-core-image-overlay-center, .gdlr-core-image-overlay-center-icon');
		}		
	
		center_overlay.each(function(){
			
			// for portfolio overlay content style
			if( $(this).hasClass('gdlr-core-image-overlay-center') ){
				var overlay_content = $(this).children('.gdlr-core-image-overlay-content');
				var wrap_height = $(this).outerHeight() - (2 * parseInt(overlay_content.css('bottom')));
				
				var overlay_icon = overlay_content.children('.gdlr-core-portfolio-icon-wrap');
				var icon_margin = (wrap_height - (overlay_content.outerHeight() - parseInt(overlay_icon.css('margin-bottom')))) / 2;
				if( icon_margin > 20 ){
					overlay_icon.css('margin-bottom', icon_margin);
				}
				
			// normal centering
			}else{
				$(this).children('.gdlr-core-image-overlay-content').each(function(){
					$(this).css({ 'margin-top': -( $(this).outerHeight() / 2 ) });
				});
			}
			
		});
		$(window).resize(function(){
			center_overlay.each(function(){
				// for portfolio style
				if( $(this).hasClass('gdlr-core-image-overlay-center') ){
					var overlay_content = $(this).children('.gdlr-core-image-overlay-content');
					var wrap_height = $(this).outerHeight() - (2 * parseInt(overlay_content.css('bottom')));
					
					var overlay_icon = overlay_content.children('.gdlr-core-portfolio-icon-wrap');
					var icon_margin = (wrap_height - (overlay_content.outerHeight() - parseInt(overlay_icon.css('margin-bottom')))) / 2;
					if( icon_margin > 20 ){
						overlay_icon.css('margin-bottom', icon_margin);
					}
					
				// normal centering
				}else{
					$(this).children('.gdlr-core-image-overlay-content').each(function(){
						$(this).css({ 'margin-top': -( $(this).outerHeight() / 2 ) });
					});
				}
			});
		});

		return $(this);
	}

	$.fn.gdlr_core_set_image_height = function(){

		var all_image = $(this).find('img');

		all_image.each(function(){
			var img_width = $(this).attr('width');
			var img_height = $(this).attr('height');

			if( img_width && img_height ){
				$(this).height((img_height * $(this).width()) / img_width);
			}else{
				return;
			}
		});
		$(window).resize(function(e){
			all_image.css('height', '');
			$(window).unbind('resize', e.handleObj.handler, e);
		});

		return $(this);
	} // gdlr_core_set_image_height

	// to set full height wrapper / column
	window.gdlr_core_set_full_height = function( container, filter_elem ){
		if( typeof(filter_elem) == 'undefined' ){
			this.elements = container.find('.gdlr-core-wrapper-full-height, .gdlr-core-column-full-height');
		}else{
			this.elements = filter_elem.filter('.gdlr-core-wrapper-full-height, .gdlr-core-column-full-height');
		}

		if( this.elements.length ){
			this.init();
		}
	}
	gdlr_core_set_full_height.prototype = {

		init: function(){

			var t = this;

			t.resize();
			$(window).on('load resize', function(){ t.resize(); });
		},

		resize: function(){

			this.elements.each(function(){
				var offset = $(this).attr('data-decrease-height')? parseInt($(this).attr('data-decrease-height')): 0;

				$(this).css('min-height', $(window).height() - offset);

				if( $(this).hasClass('gdlr-core-full-height-center') ){
					$(this).children('.gdlr-core-full-height-pre-spaces').remove();

					var pre_space = ($(this).height() - $(this).children('.gdlr-core-full-height-content').outerHeight(true)) / 2;
					if( pre_space > 0 ){
						$(this).prepend($('<div class="gdlr-core-full-height-pre-spaces" ></div>').height(pre_space));
					}
				}
			});

		}
	};

	// sync height among items
	window.gdlr_core_sync_height = function( container, filter_elem ){

		if( typeof(window.gdlr_core_sync_height_elem) != 'undefined' ){
			window.gdlr_core_sync_height_elem.reinit();
			return;
		}
		window.gdlr_core_sync_height_elem = this;

		if( typeof(filter_elem) == 'undefined' ){
			this.elements = container.find('[data-sync-height]');
		}else{
			this.elements = filter_elem.filter('[data-sync-height]');
		}
		
		this.elements_group = [];

		this.container = container;

		this.init();
	} 
	gdlr_core_sync_height.prototype = {

		init: function(){

			var t = this;
			t.group_elements();	
			t.set_height();

			$(window).on('load resize', function(){ t.set_height(); });
		},

		reinit: function(){
			
			this.elements = this.container.find('[data-sync-height]');
			this.group_elements();
			this.set_height();

		},	

		group_elements: function(){

			var t = this;
			
			// do flipbox first
			t.elements.filter('.gdlr-core-flipbox-front').each(function(){
				if( t.elements_group.indexOf($(this).attr('data-sync-height')) == -1 ){
					t.elements_group.push($(this).attr('data-sync-height'));
				}
			});
			
			// do the rest elements
			t.elements.each(function(){
				if( t.elements_group.indexOf($(this).attr('data-sync-height')) == -1 ){
					t.elements_group.push($(this).attr('data-sync-height'));
				}
			});
		},

		set_height: function(){

			var t = this;

			// revert to default value
			t.elements.css('height', 'auto').children('.gdlr-core-sync-height-pre-spaces').remove();

			var sync_element = t.elements;
			if( gdlr_core_display == 'mobile-landscape' || gdlr_core_display == 'mobile-portrait' ){
				sync_element = sync_element.filter('.gdlr-core-flipbox-front, .gdlr-core-flipbox-back');
			}

			// setting the height by each group
			for( var key in t.elements_group ){
				var max_height = 0;

				// determine max height
				sync_element.filter('[data-sync-height="' + t.elements_group[key] + '"]').each(function(){
					if( $(this).outerHeight() > max_height ){
						max_height = $(this).outerHeight();
					}
				});

				// set the height
				sync_element.filter('[data-sync-height="' + t.elements_group[key] + '"]').css('height', max_height).each(function(){
					
					// flipbox
					if( $(this).hasClass('gdlr-core-flipbox-front') ){
						$(this).parent().css('height', max_height);
					}

					// center the content if selected
					if( $(this).is('[data-sync-height-center]') ){
						var children_content = $(this).children('.gdlr-core-sync-height-content');
						if( children_content.length == 0 ){
							children_content = $(this).children();
						}

						var padding_top = (max_height - children_content.outerHeight()) / 2;
						padding_top -= (parseInt($(this).css('padding-top')) + parseInt($(this).css('border-top-width')));

						if( padding_top > 0 ){
							$(this).prepend($('<div class="gdlr-core-sync-height-pre-spaces" ></div>').css('padding-top', padding_top));
						}
					}

				});
			}

		}

	}; // gdlr_core_sync_height.prototype

	$.fn.gdlr_core_ajax = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('[data-ajax]');
		}else{
			var elem = filter_elem.filter('[data-ajax]');
		}

		elem.each(function(){

			var ajax_section = $(this);

			$(this).on('click', 'a', function(){
				if( $(this).hasClass('gdlr-core-active') ){
					return;
				}
				$(this).addClass('gdlr-core-active').siblings().removeClass('gdlr-core-active');

				var name = $(this).attr('data-ajax-name');
				var value = $(this).attr('data-ajax-value');
				var now_loading = $('<div class="gdlr-core-now-loading" ></div>').hide();

				$.ajax({
					type: 'POST',
					url: gdlr_core_pbf.ajax_url,
					data: { 
						'action': ajax_section.attr('data-ajax'), 
						'settings': ajax_section.data('settings'), 
						'option': {'name':name, 'value':value} 
					},
					dataType: 'json',
					beforeSend: function(jqXHR, settings){
						// before send action
						if( ajax_section.attr('data-target-action') == 'replace' ){
							ajax_section.siblings('.' + ajax_section.attr('data-target')).animate({opacity: 0}, 150);
						}

						// for portfolio item
						if( ajax_section.attr('data-target') == 'gdlr-core-portfolio-item-holder' && 
							ajax_section.attr('data-target-action') == 'replace' ){

							now_loading.insertBefore( ajax_section.siblings('.gdlr-core-portfolio-item-holder') );
							now_loading.fadeIn(200);
						}
					},
					error: function(jqXHR, textStatus, errorThrown){
						console.log(jqXHR, textStatus, errorThrown);
					},
					success: function(data){
						
						if( data.status == 'success' ){
							if( data.content && ajax_section.attr('data-target') ){ 
								if( ajax_section.attr('data-target-action') == 'append' ){
									var content = $(data.content);
									ajax_section.siblings('.' + ajax_section.attr('data-target')).each(function(){

										$(this).append(content);
										content.gdlr_core_lightbox().gdlr_core_flexslider().gdlr_core_content_script().gdlr_core_set_image_height();

										if( $(this).attr('data-layout') == 'masonry' && typeof($.fn.isotope) == 'function' ){
											var addItems = $(this).isotope('addItems', content);
											$(this).isotope('layoutItems', addItems, true);
										}else{
											content.addClass('gdlr-core-animate-init');
										}
										content.gdlr_core_animate_list_item();
									});

									if( data.load_more ){
										if( data.load_more != 'none' ){
											var load_more = $(data.load_more);
											ajax_section.parent().append(load_more);
											load_more.gdlr_core_ajax(load_more);
											load_more.css('display', 'none').slideDown(100);

											ajax_section.remove();
										}else{
											ajax_section.slideUp(100, function(){ $(this).remove(); });
										}
									}
									
								}else if( ajax_section.attr('data-target-action') == 'replace' ){
									var content = $(data.content);
									ajax_section.siblings('.' + ajax_section.attr('data-target')).each(function(){
										var fix_height = false;
										var current_height = $(this).height();
										$(this).empty().append(content);
										content.gdlr_core_lightbox().gdlr_core_flexslider().gdlr_core_fluid_video().gdlr_core_set_image_height();

										if( $(this).attr('data-layout') == 'masonry' && typeof($.fn.isotope) == 'function' ){
											$(this).isotope('destroy');
											$(this).parent().gdlr_core_isotope();
											fix_height = true;
										}else{
											content.addClass('gdlr-core-animate-init');
											content.gdlr_core_animate_list_item();
										}

										var new_height = $(this).height();
										$(this).css({height:current_height, opacity:1}).animate({'height':new_height}, {'duration':400, 'easing':'easeOutExpo', 'complete': function(){
											if( !fix_height ){ $(this).css('height',''); }
										}});
									});

									// pagination
									if( data.pagination ){
										ajax_section.siblings('.gdlr-core-pagination').slideUp(100, function(){ $(this).remove(); });

										if( data.pagination != 'none' ){
											var pagination = $(data.pagination);
											ajax_section.parent().append(pagination);
											pagination.gdlr_core_ajax(pagination);
											pagination.css('display', 'none').slideDown(100);
										}
									}

									// load more button
									if( data.load_more ){
										ajax_section.siblings('.gdlr-core-load-more-wrap').slideUp(100, function(){ $(this).remove(); });
										
										if( data.load_more != 'none' ){
											var load_more = $(data.load_more);
											ajax_section.parent().append(load_more);
											load_more.gdlr_core_ajax(load_more);
											load_more.css('display', 'none').slideDown(100);
										}
									}

								}
							}

							now_loading.fadeOut(200, function(){ $(this).remove(); });
						}else{
							console.log(data);
						}
					}
				});	

				return false;
			});

		});	

	} // gdlr_core_ajax

	$.fn.gdlr_core_dropdown_tab = function( filter_elem ){

		if( typeof(filter_elem) == 'undefined' ){
			var elem = $(this).find('.gdlr-core-dropdown-tab');
		}else{
			var elem = filter_elem.filter('.gdlr-core-dropdown-tab');
		}	
	
		elem.each(function(){
			var tab_title = $(this).children('.gdlr-core-dropdown-tab-title');
			var tab_title_text = tab_title.children('.gdlr-core-head');
			var tab_dropdown = tab_title.children('.gdlr-core-dropdown-tab-head-wrap');
			var tab_content = $(this).children('.gdlr-core-dropdown-tab-content-wrap');

			// dropdown
			tab_title.click(function(){
				if( $(this).hasClass('gdlr-core-active') ){
					$(this).removeClass('gdlr-core-active');
					tab_dropdown.hide();
				}else{
					$(this).addClass('gdlr-core-active');
					tab_dropdown.slideDown(200);
				}
			});
			tab_dropdown.children().click(function(){
				tab_title_text.html($(this).html());
				$(this).addClass('gdlr-core-active').siblings().removeClass('gdlr-core-active');

				var content_active = tab_content.children('[data-index="' + $(this).attr('data-index') + '"]');
				content_active.fadeIn(200).addClass('gdlr-core-active');
				content_active.siblings().hide().removeClass('gdlr-core-active');
			});

		});

	} // gdlr_core_dropdown_tab

	if( !gdlr_core_pbf.admin ){
		
		$(document).ready(function(){
			
			$('body').each(function(){
				
				// turns image link to open in lightbox
				if( $(this).hasClass('gdlr-core-link-to-lightbox') ){
					var image_link = $(this).find('a[href$=".jpg"], a[href$=".png"], a[href$=".gif"]')
						.not('.gdlr-core-ilightbox, .strip, [data-rel]')
						.addClass('strip gdlr-core-ilightbox');
					$(this).gdlr_core_lightbox( image_link );
				}

				var gdlr_core_js = $(this).find('.gdlr-core-js, iframe[src*="youtube"], iframe[src*="vimeo"]');
				
				// video resizing
				$(this).gdlr_core_content_script( gdlr_core_js, true );
				
				// counter item
				$(this).gdlr_core_counter_item( gdlr_core_js );	
				
				// type animation item
				$(this).gdlr_core_typed_animation( gdlr_core_js );	

				// countdown item
				$(this).gdlr_core_countdown_item( gdlr_core_js );		

				// alert box item
				$(this).gdlr_core_alert_box_item( gdlr_core_js );
				
				// accordion item
				$(this).gdlr_core_accordion( gdlr_core_js );
				
				// toggle box item
				$(this).gdlr_core_toggle_box( gdlr_core_js );
				
				// divider
				$(this).gdlr_core_divider( gdlr_core_js );
				
				// flipbox
				$(this).gdlr_core_flipbox( gdlr_core_js );
				
				// skill circle
				$(this).gdlr_core_skill_circle( gdlr_core_js );
				
				// skill bar
				$(this).gdlr_core_skill_bar( gdlr_core_js );
				
				// tab
				$(this).gdlr_core_tab( gdlr_core_js );

				// dropdown tab
				$(this).gdlr_core_dropdown_tab( gdlr_core_js );
				
				// lightbox
				$(this).gdlr_core_lightbox( gdlr_core_js );

				// ajax action
				$(this).gdlr_core_ajax( gdlr_core_js );
				
				// ux animation
				// $(this).gdlr_core_ux( gdlr_core_js );
				new gdlr_core_ux( $(this), gdlr_core_js );

				// set height
				new gdlr_core_set_full_height( $(this), gdlr_core_js );

				// sidebar wrapper height
				new gdlr_core_sidebar_wrapper( $(this), gdlr_core_js );

				// sync height
				new gdlr_core_sync_height( $(this), gdlr_core_js );
				
				// background parallax
				$(this).gdlr_core_parallax_background( gdlr_core_js );

			});
			
		}); // document.ready

		$(window).load(function(){
			
			$('body').each(function(){

				var gdlr_core_js = $(this).find('.gdlr-core-js-2');
			
				// title divider
				$(this).gdlr_core_title_divider( gdlr_core_js );

				// flexslider
				$(this).gdlr_core_flexslider( gdlr_core_js );

				// sly slider
				$(this).gdlr_core_sly( gdlr_core_js );

				// isotope
				$(this).gdlr_core_isotope( gdlr_core_js );

			});

		}); // window.load

	}

})(jQuery);