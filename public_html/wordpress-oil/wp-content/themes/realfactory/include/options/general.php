<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	// add custom css for theme option
	add_filter('gdlr_core_theme_option_top_file_write', 'realfactory_gdlr_core_theme_option_top_file_write', 10, 2);
	if( !function_exists('realfactory_gdlr_core_theme_option_top_file_write') ){
		function realfactory_gdlr_core_theme_option_top_file_write( $css, $option_slug ){
			if( $option_slug != 'goodlayers_main_menu' ) return;

			ob_start();
?>
.realfactory-body h1, .realfactory-body h2, .realfactory-body h3, .realfactory-body h4, .realfactory-body h5, .realfactory-body h6{ margin-top: 0px; margin-bottom: 20px; line-height: 1.2; font-weight: 700; }
#poststuff .gdlr-core-page-builder-body h2{ padding: 0px; margin-bottom: 20px; line-height: 1.2; font-weight: 700; }
#poststuff .gdlr-core-page-builder-body h1{ padding: 0px; font-weight: 700; }

/* custom style for specific theme */
.gdlr-core-accordion-style-box-icon .gdlr-core-accordion-item-title{ font-size: 17px; font-weight: 500; letter-spacing: 0px; text-transform: none; }
.gdlr-core-button{ text-transform: none; letter-spacing: 0.5px; }
.gdlr-core-blog-date-wrapper{ margin-top: 0px; border-right-width: 3px; padding-bottom: 18px; padding-right: 25px; width: 63px; }
.gdlr-core-blog-date-wrapper .gdlr-core-blog-date-day{ letter-spacing: 1px; margin-top: 0px; }
.gdlr-core-blog-info-wrapper .gdlr-core-blog-info{ font-size: 14px; text-transform: none; font-weight: 500; letter-spacing: 0px; }
.gdlr-core-blog-list .gdlr-core-blog-title{ margin-bottom: 0px; margin-top: 10px; font-size: 15px; font-weight: 500; letter-spacing: 0px; }
.gdlr-core-blog-list .gdlr-core-blog-list-frame{ padding: 26px 30px 27px; }
.gdlr-core-blog-full{ margin-bottom: 55px; }
.gdlr-core-blog-full .gdlr-core-excerpt-read-more{ margin-top: 25px; }
.gdlr-core-blog-full .gdlr-core-blog-title{ font-size: 32px; margin-bottom: 0px; }
.gdlr-core-blog-full .gdlr-core-blog-info-wrapper{ margin-bottom: 10px; }
.gdlr-core-blog-full .gdlr-core-blog-info-wrapper .gdlr-core-blog-info{ font-size: 15px; }
.gdlr-core-style-blog-full-with-frame .gdlr-core-blog-full-frame{ padding: 50px 50px 25px; }
.gdlr-core-blog-grid .gdlr-core-blog-title{ font-size: 24px; }
.gdlr-core-blog-grid .gdlr-core-blog-info-wrapper{ padding-top: 0px; border: 0px; margin-bottom: 10px; }
.gdlr-core-blog-grid .gdlr-core-excerpt-read-more{ display: inline-block; }
.gdlr-core-blog-grid .gdlr-core-blog-content{ margin-bottom: 20px; }
.gdlr-core-excerpt-read-more i{ margin-left: 15px; }
.gdlr-core-excerpt-read-more{ font-size: 16px; font-weight: 500; display: inline-block; margin-top: 24px; }
.gdlr-core-testimonial-item .gdlr-core-testimonial-content{ font-style: normal; }
.gdlr-core-testimonial-style-center .gdlr-core-testimonial-quote{ display: none; }
.gdlr-core-flexslider .flex-control-nav{ margin-top: 20px; }
.gdlr-core-flexslider[data-nav-parent="gdlr-core-portfolio-item"]{ position: static; }
.gdlr-core-flexslider[data-nav-parent="gdlr-core-portfolio-item"] .flex-direction-nav li{ margin-top: -30px; }
.gdlr-core-flexslider[data-nav-parent="gdlr-core-portfolio-item"] .flex-direction-nav li a{ border-radius: 0px; padding: 16px 14px; }
.gdlr-core-flexslider[data-nav-parent="gdlr-core-portfolio-item"] .flex-direction-nav li a i{ font-size: 28px; width: 28px; }
.gdlr-core-flexslider[data-nav-parent="gdlr-core-portfolio-item"] .flex-direction-nav .flex-nav-prev{ left: 0px; }
.gdlr-core-flexslider[data-nav-parent="gdlr-core-portfolio-item"] .flex-direction-nav .flex-nav-next{ right: 0px; }
.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-title{ font-size: 16px; letter-spacing: 1px; font-weight: 400; }
.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-info{ font-size: 14px; font-style: normal; }
.gdlr-core-portfolio-thumbnail.gdlr-core-style-title-tag .gdlr-core-portfolio-info{ margin-top: 12px; }
.gdlr-core-portfolio-thumbnail.gdlr-core-style-title-icon .gdlr-core-portfolio-title{ margin-bottom: 20px; }
.gdlr-core-portfolio-thumbnail.gdlr-core-style-icon-title-tag .gdlr-core-portfolio-title{ margin-top: 20px; }
.gdlr-core-portfolio-thumbnail.gdlr-core-style-margin-icon-title-tag .gdlr-core-portfolio-title{ margin-top: 20px; }
.gdlr-core-portfolio-medium .gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-info{ font-size: 14px; }
.gdlr-core-portfolio-grid .gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-info{ font-size: 14px; font-style: normal; }
.gdlr-core-portfolio-slider-widget-wrap{ padding-top: 0; margin-top: -10px; }
.gdlr-core-recent-portfolio-widget{ max-width: 80px; margin-right: 15px; margin-bottom: 15px; }
.gdlr-core-title-item.gdlr-core-left-align .gdlr-core-title-item-link:after{ font-family: "fontAwesome"; margin-left: 10px; content: "\f178"; vertical-align: middle; }
.gdlr-core-dropdown-tab .gdlr-core-dropdown-tab-title{ padding: 7px 13px 7px 17px; margin-top: -4px; }
.gdlr-core-product-item.woocommerce .gdlr-core-product-thumbnail-info i{ font-size: 13px; margin-right: 7px; }
.gdlr-core-product-item.woocommerce .gdlr-core-product-thumbnail-info > a{ font-size: 12px; }
span.gdlr-core-counter-item-suffix{ font-weight: 700; }
span.gdlr-core-counter-item-count{ font-weight: 700; }
<?php
			$css .= ob_get_contents();
			ob_end_clean(); 

			return $css;
		}
	}
	add_filter('gdlr_core_theme_option_bottom_file_write', 'realfactory_gdlr_core_theme_option_bottom_file_write', 10, 2);
	if( !function_exists('realfactory_gdlr_core_theme_option_bottom_file_write') ){
		function realfactory_gdlr_core_theme_option_bottom_file_write( $css, $option_slug ){
			if( $option_slug != 'goodlayers_main_menu' ) return;

			$general = get_option('rftr_general');

			if( !empty($general['item-padding']) ){
				$padding = intval(str_replace('px', '', $general['item-padding']));
				$padding2x = 2 * $padding;
				if( !empty($padding2x) && is_numeric($padding2x) ){
					$css .= '.realfactory-item-mgb, .gdlr-core-item-mgb{ margin-bottom: ' . $padding2x . 'px; }';
					$css .= '.realfactory-sidebar-left .realfactory-sidebar-area{ padding-right: ' . ($padding2x + 10) . 'px; }';
					$css .= '.realfactory-sidebar-right .realfactory-sidebar-area{ padding-left: ' . ($padding2x + 10) . 'px }';
				}
				$css .= '.realfactory-sidebar-left .realfactory-sidebar-area{ margin-right: ' . ($padding + 10) . 'px; }';
				$css .= '.realfactory-sidebar-right .realfactory-sidebar-area{ margin-left: ' . ($padding + 10) . 'px; }';
			}
			
			return $css;
		}
	}

	$realfactory_admin_option->add_element(array(
	
		// general head section
		'title' => esc_html__('General', 'realfactory'),
		'slug' => 'rftr_general',
		'icon' => get_template_directory_uri() . '/include/options/images/general.png',
		'options' => array(
		
			'layout' => array(
				'title' => esc_html__('Layout', 'realfactory'),
				'options' => array(
					
					'layout' => array(
						'title' => esc_html__('Layout', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'full' => esc_html__('Full', 'realfactory'),
							'boxed' => esc_html__('Boxed', 'realfactory'),
						)
					),
					'boxed-layout-top-margin' => array(
						'title' => esc_html__('Box Layout Top/Bottom Margin', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '150',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => 'body.realfactory-boxed .realfactory-body-wrapper{ margin-top: #gdlr#; margin-bottom: #gdlr#; }',
						'condition' => array( 'layout' => 'boxed' ) 
					),
					'body-margin' => array(
						'title' => esc_html__('Body Magin ( Frame Spaces )', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.realfactory-body-wrapper.realfactory-with-frame, body.realfactory-full .realfactory-fixed-footer{ margin: #gdlr#; }',
						'condition' => array( 'layout' => 'full' ),
						'description' => esc_html__('This value will be automatically omitted for side header style.', 'realfactory'),
					),
					'background-type' => array(
						'title' => esc_html__('Background Type', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'color' => esc_html__('Color', 'realfactory'),
							'image' => esc_html__('Image', 'realfactory'),
							'pattern' => esc_html__('Pattern', 'realfactory'),
						),
						'condition' => array( 'layout' => 'boxed' )
					),
					'background-image' => array(
						'title' => esc_html__('Background Image', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file', 
						'selector' => 'body.realfactory-boxed.realfactory-background-image .realfactory-body-background{ background-image: url(#gdlr#); }',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'image' )
					),
					'background-pattern' => array(
						'title' => esc_html__('Background Type', 'realfactory'),
						'type' => 'radioimage',
						'data-type' => 'text',
						'options' => 'pattern', 
						'selector' => 'body.realfactory-boxed.realfactory-background-pattern .realfactory-body-outer-wrapper{ background-image: url(' . GDLR_CORE_URL . '/include/images/pattern/#gdlr#.png); }',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'pattern' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'enable-boxed-border' => array(
						'title' => esc_html__('Enable Boxed Border', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'pattern' ),
					),
					'item-padding' => array(
						'title' => esc_html__('Item Left/Right Spaces', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '40',
						'data-type' => 'pixel',
						'default' => '15px',
						'description' => 'Space between each page items',
						'selector' => '.realfactory-item-pdlr, .gdlr-core-item-pdlr{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.realfactory-item-rvpdlr, .gdlr-core-item-rvpdlr{ margin-left: -#gdlr#; margin-right: -#gdlr#; }' .
							'.gdlr-core-metro-rvpdlr{ margin-top: -#gdlr#; margin-right: -#gdlr#; margin-bottom: -#gdlr#; margin-left: -#gdlr#; }' .
							'.realfactory-item-mglr, .gdlr-core-item-mglr, .realfactory-navigation .sf-menu > .realfactory-mega-menu .sf-mega{ margin-left: #gdlr#; margin-right: #gdlr#; }'
					),
					'container-width' => array(
						'title' => esc_html__('Container Width', 'realfactory'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '1180px',
						'selector' => '.realfactory-container, .gdlr-core-container, body.realfactory-boxed .realfactory-body-wrapper, ' . 
							'body.realfactory-boxed .realfactory-fixed-footer .realfactory-footer-wrapper, body.realfactory-boxed .realfactory-fixed-footer .realfactory-copyright-wrapper{ max-width: #gdlr#; }' 
					),
					'container-padding' => array(
						'title' => esc_html__('Container Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.realfactory-body-front .gdlr-core-container, .realfactory-body-front .realfactory-container{ padding-left: #gdlr#; padding-right: #gdlr#; }'  . 
							'.realfactory-body-front .realfactory-container .realfactory-container, .realfactory-body-front .realfactory-container .gdlr-core-container, '.
							'.realfactory-body-front .gdlr-core-container .gdlr-core-container{ padding-left: 0px; padding-right: 0px; }'
					),
					'sidebar-width' => array(
						'title' => esc_html__('Sidebar Width', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'30' => '50%', '20' => '33.33%', '15' => '25%', '12' => '20%', '10' => '16.67%'
						),
						'default' => 20,
					),
					'both-sidebar-width' => array(
						'title' => esc_html__('Both Sidebar Width', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'30' => '50%', '20' => '33.33%', '15' => '25%', '12' => '20%', '10' => '16.67%'
						),
						'default' => 15,
					),
					
				) // header-options
			), // header-nav	

			'top-bar' => array(
				'title' => esc_html__('Top Bar', 'realfactory'),
				'options' => array(

					'enable-top-bar' => array(
						'title' => esc_html__('Enable Top Bar', 'realfactory'),
						'type' => 'checkbox',
					),
					'enable-top-bar-on-mobile' => array(
						'title' => esc_html__('Enable Top Bar On Mobile', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'top-bar-width' => array(
						'title' => esc_html__('Top Bar Width', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'realfactory'),
							'full' => esc_html__('Full', 'realfactory'),
							'custom' => esc_html__('Custom', 'realfactory'),
						),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-width-pixel' => array(
						'title' => esc_html__('Top Bar Width Pixel', 'realfactory'),
						'type' => 'text',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'custom' ),
						'selector' => '.realfactory-top-bar-container.realfactory-top-bar-custom-container{ max-width: #gdlr#; }'
					),
					'top-bar-full-side-padding' => array(
						'title' => esc_html__('Top Bar Full ( Left/Right ) Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.realfactory-top-bar-container.realfactory-top-bar-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'full' )
					),
					'top-bar-left-text' => array(
						'title' => esc_html__('Top Bar Left Text', 'realfactory'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-right-text' => array(
						'title' => esc_html__('Top Bar Right Text', 'realfactory'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-top-padding' => array(
						'title' => esc_html__('Top Bar Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
 						'default' => '10px',
						'selector' => '.realfactory-top-bar{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-padding' => array(
						'title' => esc_html__('Top Bar Bottom Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '10px',
						'selector' => '.realfactory-top-bar{ padding-bottom: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-text-size' => array(
						'title' => esc_html__('Top Bar Text Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.realfactory-top-bar{ font-size: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-border' => array(
						'title' => esc_html__('Top Bar Bottom Border', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.realfactory-top-bar{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),

				)
			), // top bar

			'top-bar-social' => array(
				'title' => esc_html__('Top Bar Social', 'realfactory'),
				'options' => array(
					'enable-top-bar-social' => array(
						'title' => esc_html__('Enable Top Bar Social', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'top-bar-social-delicious' => array(
						'title' => esc_html__('Top Bar Social Delicious Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-email' => array(
						'title' => esc_html__('Top Bar Social Email Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-deviantart' => array(
						'title' => esc_html__('Top Bar Social Deviantart Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-digg' => array(
						'title' => esc_html__('Top Bar Social Digg Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-facebook' => array(
						'title' => esc_html__('Top Bar Social Facebook Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-flickr' => array(
						'title' => esc_html__('Top Bar Social Flickr Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-google-plus' => array(
						'title' => esc_html__('Top Bar Social Google Plus Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-lastfm' => array(
						'title' => esc_html__('Top Bar Social Lastfm Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-linkedin' => array(
						'title' => esc_html__('Top Bar Social Linkedin Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-pinterest' => array(
						'title' => esc_html__('Top Bar Social Pinterest Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-rss' => array(
						'title' => esc_html__('Top Bar Social RSS Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-skype' => array(
						'title' => esc_html__('Top Bar Social Skype Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-stumbleupon' => array(
						'title' => esc_html__('Top Bar Social Stumbleupon Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-tumblr' => array(
						'title' => esc_html__('Top Bar Social Tumblr Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-twitter' => array(
						'title' => esc_html__('Top Bar Social Twitter Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-vimeo' => array(
						'title' => esc_html__('Top Bar Social Vimeo Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-youtube' => array(
						'title' => esc_html__('Top Bar Social Youtube Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-instagram' => array(
						'title' => esc_html__('Top Bar Social Instagram Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-snapchat' => array(
						'title' => esc_html__('Top Bar Social Snapchat Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),

				)
			),			

			'header' => array(
				'title' => esc_html__('Header', 'realfactory'),
				'options' => array(

					'header-style' => array(
						'title' => esc_html__('Header Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'plain' => esc_html__('Plain', 'realfactory'),
							'bar' => esc_html__('Bar', 'realfactory'),
							'boxed' => esc_html__('Boxed', 'realfactory'),
							'side' => esc_html__('Side Menu', 'realfactory'),
							'side-toggle' => esc_html__('Side Menu Toggle', 'realfactory'),
						),
						'default' => 'plain',
					),
					'header-plain-style' => array(
						'title' => esc_html__('Header Plain Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'menu-right' => get_template_directory_uri() . '/images/header/plain-menu-right.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/plain-center-logo.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/plain-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/plain-splitted-menu.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'plain' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-plain-bottom-border' => array(
						'title' => esc_html__('Plain Header Bottom Border', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.realfactory-header-style-plain{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain') )
					),
					'header-bar-navigation-align' => array(
						'title' => esc_html__('Header Bar Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/bar-left.jpg',
							'center' => get_template_directory_uri() . '/images/header/bar-center.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/bar-center-logo.jpg',
						),
						'default' => 'center',
						'condition' => array( 'header-style' => 'bar' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-background-style' => array(
						'title' => esc_html__('Header/Navigation Background Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'solid' => esc_html__('Solid', 'realfactory'),
							'transparent' => esc_html__('Transparent', 'realfactory'),
						),
						'default' => 'solid',
						'condition' => array( 'header-style' => array('plain', 'bar') )
					),
					'top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'plain', 'header-background-style' => 'transparent' ),
						'selector' => '.realfactory-header-background-transparent .realfactory-top-bar-background{ opacity: #gdlr#; }'
					),
					'header-background-opacity' => array(
						'title' => esc_html__('Header Background Opacity', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'plain', 'header-background-style' => 'transparent' ),
						'selector' => '.realfactory-header-background-transparent .realfactory-header-background{ opacity: #gdlr#; }'
					),
					'navigation-background-opacity' => array(
						'title' => esc_html__('Navigation Background Opacity', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'bar', 'header-background-style' => 'transparent' ),
						'selector' => '.realfactory-navigation-bar-wrap.realfactory-style-transparent .realfactory-navigation-background{ opacity: #gdlr#; }'
					),
					'header-boxed-style' => array(
						'title' => esc_html__('Header Boxed Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'menu-right' => get_template_directory_uri() . '/images/header/boxed-menu-right.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/boxed-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/boxed-splitted-menu.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'boxed' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'boxed-top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '0',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.realfactory-header-boxed-wrap .realfactory-top-bar-background{ opacity: #gdlr#; }'
					),
					'boxed-top-bar-background-extend' => array(
						'title' => esc_html__('Top Bar Background Extend ( Bottom )', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.realfactory-header-boxed-wrap .realfactory-top-bar-background{ margin-bottom: -#gdlr#; }'
					),
					'boxed-header-top-margin' => array(
						'title' => esc_html__('Header Top Margin', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.realfactory-header-style-boxed{ margin-top: #gdlr#; }'
					),
					'header-side-style' => array(
						'title' => esc_html__('Header Side Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'top-left' => get_template_directory_uri() . '/images/header/side-top-left.jpg',
							'middle-left' => get_template_directory_uri() . '/images/header/side-middle-left.jpg',
							'top-right' => get_template_directory_uri() . '/images/header/side-top-right.jpg',
							'middle-right' => get_template_directory_uri() . '/images/header/side-middle-right.jpg',
						),
						'default' => 'top-left',
						'condition' => array( 'header-style' => 'side' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-align' => array(
						'title' => esc_html__('Header Side Text Align', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left',
						'condition' => array( 'header-style' => 'side' )
					),
					'header-side-toggle-style' => array(
						'title' => esc_html__('Header Side Toggle Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/side-toggle-left.jpg',
							'right' => get_template_directory_uri() . '/images/header/side-toggle-right.jpg',
						),
						'default' => 'left',
						'condition' => array( 'header-style' => 'side-toggle' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-toggle-menu-type' => array(
						'title' => esc_html__('Header Side Toggle Menu Type', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'realfactory'),
							'right' => esc_html__('Right Slide Menu', 'realfactory'),
							'overlay' => esc_html__('Overlay Menu', 'realfactory'),
						),
						'default' => 'overlay',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-side-toggle-display-logo' => array(
						'title' => esc_html__('Display Logo', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-width' => array(
						'title' => esc_html__('Header Width', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'realfactory'),
							'full' => esc_html__('Full', 'realfactory'),
							'custom' => esc_html__('Custom', 'realfactory'),
						),
						'condition' => array('header-style'=> array('plain', 'bar', 'boxed'))
					),
					'header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'realfactory'),
						'type' => 'text',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array('header-style'=> array('plain', 'bar', 'boxed'), 'header-width' => 'custom'),
						'selector' => '.realfactory-header-container.realfactory-header-custom-container{ max-width: #gdlr#; }'
					),
					'header-full-side-padding' => array(
						'title' => esc_html__('Header Full ( Left/Right ) Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.realfactory-header-container.realfactory-header-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array('header-style'=> array('plain', 'bar', 'boxed'), 'header-width'=>'full')
					),
					'boxed-header-frame-radius' => array(
						'title' => esc_html__('Header Frame Radius', 'realfactory'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '3px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.realfactory-header-boxed-wrap .realfactory-header-background{ border-radius: #gdlr#; -moz-border-radius: #gdlr#; -webkit-border-radius: #gdlr#; }'
					),
					'boxed-header-content-padding' => array(
						'title' => esc_html__('Header Content ( Left/Right ) Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '30px',
						'selector' => '.realfactory-header-style-boxed .realfactory-header-container-item{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.realfactory-navigation-right{ right: #gdlr#; } .realfactory-navigation-left{ left: #gdlr#; }',
						'condition' => array( 'header-style' => 'boxed' )
					),
					'navigation-text-top-margin' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'plain', 'header-plain-style' => 'splitted-menu' ),
						'selector' => '.realfactory-header-style-plain.realfactory-style-splitted-menu .realfactory-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.realfactory-header-style-plain.realfactory-style-splitted-menu .realfactory-main-menu-left-wrap,' .
							'.realfactory-header-style-plain.realfactory-style-splitted-menu .realfactory-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-top-margin-boxed' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed', 'header-boxed-style' => 'splitted-menu' ),
						'selector' => '.realfactory-header-style-boxed.realfactory-style-splitted-menu .realfactory-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.realfactory-header-style-boxed.realfactory-style-splitted-menu .realfactory-main-menu-left-wrap,' .
							'.realfactory-header-style-boxed.realfactory-style-splitted-menu .realfactory-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-side-spacing' => array(
						'title' => esc_html__('Navigation Text Side ( Left / Right ) Spaces', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '30',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.realfactory-navigation .sf-menu > li{ padding-left: #gdlr#; padding-right: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'boxed') )
					),
					'navigation-slide-bar' => array(
						'title' => esc_html__('Navigation Slide Bar', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'header-style' => array('plain', 'bar', 'boxed') )
					),
					'side-header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '600',
						'default' => '340px',
						'condition' => array('header-style' => array('side', 'side-toggle')),
						'selector' => '.realfactory-header-side-nav{ width: #gdlr#; }' . 
							'.realfactory-header-side-content.realfactory-style-left{ margin-left: #gdlr#; }' .
							'.realfactory-header-side-content.realfactory-style-right{ margin-right: #gdlr#; }'
					),
					'side-header-side-padding' => array(
						'title' => esc_html__('Header Side Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '70px',
						'condition' => array('header-style' => 'side'),
						'selector' => '.realfactory-header-side-nav.realfactory-style-side{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.realfactory-header-side-nav.realfactory-style-left .sf-vertical > li > ul.sub-menu{ padding-left: #gdlr#; }' .
							'.realfactory-header-side-nav.realfactory-style-right .sf-vertical > li > ul.sub-menu{ padding-right: #gdlr#; }'
					),
					'navigation-text-top-spacing' => array(
						'title' => esc_html__('Navigation Text Top / Bottom Spaces', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '40',
						'data-type' => 'pixel',
						'default' => '16px',
						'selector' => ' .realfactory-navigation .sf-vertical > li{ padding-top: #gdlr#; padding-bottom: #gdlr#; }',
						'condition' => array( 'header-style' => array('side') )
					),

				)
			), // header
			
			'header-bar-right-text' => array(
				'title' => esc_html__('Header Bar Right Text', 'realfactory'),
				'options' => array(

					'logo-right-box1-icon' => array(
						'title' => esc_html__('Header Right Box 1 Icon', 'realfactory'),
						'type' => 'text',
						'description' => esc_html__('Only for header bar style.', 'realfactory') . 
							esc_html__('You can choose the icon from these following links. ', 'realfactory') . 
							'(<a href="http://support.goodlayers.com/document/icon-font-awesomes/">Font Awesome</a>, ' . 
							'<a href="http://support.goodlayers.com/document/icon-elegant-icons/">Elegant Icons</a>)'
					),
					'logo-right-box1-title' => array(
						'title' => esc_html__('Header Right Box 1 Title', 'realfactory'),
						'type' => 'text'
					),
					'logo-right-box1-caption' => array(
						'title' => esc_html__('Header Right Box 1 Caption', 'realfactory'),
						'type' => 'text'
					),
					'logo-right-box2-icon' => array(
						'title' => esc_html__('Header Right Box 2 Icon', 'realfactory'),
						'type' => 'text',
						'description' => esc_html__('You can choose the icon from these following links. ', 'realfactory') . 
							'(<a href="http://support.goodlayers.com/document/icon-font-awesomes/">Font Awesome</a>, ' . 
							'<a href="http://support.goodlayers.com/document/icon-elegant-icons/">Elegant Icons</a>)'
					),
					'logo-right-box2-title' => array(
						'title' => esc_html__('Header Right Box 2 Title', 'realfactory'),
						'type' => 'text'
					),
					'logo-right-box2-caption' => array(
						'title' => esc_html__('Header Right Box 2 Caption', 'realfactory'),
						'type' => 'text'
					),
					'logo-right-box3-icon' => array(
						'title' => esc_html__('Header Right Box 3 Icon', 'realfactory'),
						'type' => 'text',
						'description' => esc_html__('You can choose the icon from these following links. ', 'realfactory') . 
							'(<a href="http://support.goodlayers.com/document/icon-font-awesomes/">Font Awesome</a>, ' . 
							'<a href="http://support.goodlayers.com/document/icon-elegant-icons/">Elegant Icons</a>)'
					),
					'logo-right-box3-title' => array(
						'title' => esc_html__('Header Right Box 3 Title', 'realfactory'),
						'type' => 'text'
					),
					'logo-right-box3-caption' => array(
						'title' => esc_html__('Header Right Box 3 Caption', 'realfactory'),
						'type' => 'text'
					),
					'logo-right-text-top-padding' => array(
						'title' => esc_html__('Header Right Text Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '30px',
						'selector' => '.realfactory-header-style-bar .realfactory-logo-right-text{ padding-top: #gdlr#; }'
					),
					'enable-header-right-button' => array(
						'title' => esc_html__('Header Right Button', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
					),
					'header-right-button-text' => array(
						'title' => esc_html__('Header Right Button Text', 'realfactory'),
						'type' => 'text',
						'default' => esc_html__('Get A Quote', 'realfactory'),
						'condition' => array( 'enable-header-right-button' => 'enable' ) 
					),
					'header-right-button-link' => array(
						'title' => esc_html__('Header Right Button Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-header-right-button' => 'enable' ) 
					),
					'header-right-button-link-target' => array(
						'title' => esc_html__('Header Right Button Link Target', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'realfactory'),
							'_blank' => esc_html__('New Window', 'realfactory'),
						),
						'condition' => array( 'enable-header-right-button' => 'enable' ) 
					),					

				)
			),

			'logo' => array(
				'title' => esc_html__('Logo', 'realfactory'),
				'options' => array(
					'logo' => array(
						'title' => esc_html__('Logo', 'realfactory'),
						'type' => 'upload'
					),
					'mobile-logo' => array(
						'title' => esc_html__('Mobile Logo', 'realfactory'),
						'type' => 'upload',
						'description' => esc_html__('Leave this option blank to use the same logo.', 'realfactory'),
					),
					'logo-top-padding' => array(
						'title' => esc_html__('Logo Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.realfactory-logo{ padding-top: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'realfactory'),
					),
					'logo-bottom-padding' => array(
						'title' => esc_html__('Logo Bottom Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.realfactory-logo{ padding-bottom: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'realfactory'),
					),
					'logo-left-padding' => array(
						'title' => esc_html__('Logo Left Padding', 'realfactory'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.realfactory-logo.realfactory-item-pdlr{ padding-left: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'realfactory'),
					),
					'max-logo-width' => array(
						'title' => esc_html__('Max Logo Width', 'realfactory'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '200px',
						'selector' => '.realfactory-logo-inner{ max-width: #gdlr#; }'
					),
				
				)
			),
			'navigation' => array(
				'title' => esc_html__('Navigation', 'realfactory'),
				'options' => array(
					'main-navigation-top-padding' => array(
						'title' => esc_html__('Main Navigation Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '25px',
						'selector' => '.realfactory-navigation{ padding-top: #gdlr#; }' . 
							'.realfactory-navigation-top{ top: #gdlr#; }'
					),
					'main-navigation-bottom-padding' => array(
						'title' => esc_html__('Main Navigation Bottom Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.realfactory-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }'
					),
					'main-navigation-right-padding' => array(
						'title' => esc_html__('Main Navigation Right Padding', 'realfactory'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.realfactory-navigation.realfactory-item-pdlr{ padding-right: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'realfactory'),
					),
					'enable-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Fixed Navigation Bar', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'enable-logo-on-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Logo on Fixed Navigation Bar', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' )
					),
					'enable-main-navigation-submenu-indicator' => array(
						'title' => esc_html__('Enable Main Navigation Submenu Indicator', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
					),
					'enable-main-navigation-search' => array(
						'title' => esc_html__('Enable Main Navigation Search', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'enable-main-navigation-cart' => array(
						'title' => esc_html__('Enable Main Navigation Cart ( Woocommerce )', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'description' => esc_html__('The icon only shows if the woocommerce plugin is activated', 'realfactory')
					),
					'enable-main-navigation-right-button' => array(
						'title' => esc_html__('Enable Main Navigation Right Button', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('This option will be ignored on header side style', 'realfactory')
					),
					'main-navigation-right-button-text' => array(
						'title' => esc_html__('Main Navigation Right Button Text', 'realfactory'),
						'type' => 'text',
						'default' => esc_html__('Buy Now', 'realfactory'),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link' => array(
						'title' => esc_html__('Main Navigation Right Button Link', 'realfactory'),
						'type' => 'text',
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-target' => array(
						'title' => esc_html__('Main Navigation Right Button Link Target', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'realfactory'),
							'_blank' => esc_html__('New Window', 'realfactory'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'right-menu-type' => array(
						'title' => esc_html__('Secondary/Mobile Menu Type', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'realfactory'),
							'right' => esc_html__('Right Slide Menu', 'realfactory'),
							'overlay' => esc_html__('Overlay Menu', 'realfactory'),
						),
						'default' => 'right'
					),
					'right-menu-style' => array(
						'title' => esc_html__('Secondary/Mobile Menu Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'hamburger-with-border' => esc_html__('Hamburger With Border', 'realfactory'),
							'hamburger' => esc_html__('Hamburger', 'realfactory'),
						),
						'default' => 'hamburger-with-border'
					),
					
				) // logo-options
			), // logo-navigation			
			
			'title-style' => array(
				'title' => esc_html__('Page Title Style', 'realfactory'),
				'options' => array(

					'default-title-style' => array(
						'title' => esc_html__('Default Page Title Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'realfactory'),
							'medium' => esc_html__('Medium', 'realfactory'),
							'large' => esc_html__('Large', 'realfactory'),
							'custom' => esc_html__('Custom', 'realfactory'),
						),
						'default' => 'small'
					),
					'default-title-align' => array(
						'title' => esc_html__('Default Page Title Alignment', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left'
					),
					'default-title-top-padding' => array(
						'title' => esc_html__('Default Page Title Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '350',
						'default' => '93px',
						'selector' => '.realfactory-page-title-wrap.realfactory-style-custom .realfactory-page-title-content{ padding-top: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-bottom-padding' => array(
						'title' => esc_html__('Default Page Title Bottom Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '350',
						'default' => '87px',
						'selector' => '.realfactory-page-title-wrap.realfactory-style-custom .realfactory-page-title-content{ padding-bottom: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-page-caption-top-margin' => array(
						'title' => esc_html__('Default Page Caption Top Margin', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '13px',						
						'selector' => '.realfactory-page-title-wrap.realfactory-style-custom .realfactory-page-caption{ margin-top: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-font-transform' => array(
						'title' => esc_html__('Default Page Title Font Transform', 'realfactory'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'default' => esc_html__('Default', 'realfactory'),
							'none' => esc_html__('None', 'realfactory'),
							'uppercase' => esc_html__('Uppercase', 'realfactory'),
							'lowercase' => esc_html__('Lowercase', 'realfactory'),
							'capitalize' => esc_html__('Capitalize', 'realfactory'),
						),
						'default' => 'default',
						'selector' => '.realfactory-page-title-wrap .realfactory-page-title{ text-transform: #gdlr#; }'
					),
					'default-title-font-size' => array(
						'title' => esc_html__('Default Page Title Font Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '37px',
						'selector' => '.realfactory-page-title-wrap.realfactory-style-custom .realfactory-page-title{ font-size: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-font-weight' => array(
						'title' => esc_html__('Default Page Title Font Weight', 'realfactory'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.realfactory-page-title-wrap .realfactory-page-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (700).', 'realfactory')					
					),
					'default-title-letter-spacing' => array(
						'title' => esc_html__('Default Page Title Letter Spacing', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '20',
						'default' => '0px',
						'selector' => '.realfactory-page-title-wrap.realfactory-style-custom .realfactory-page-title{ letter-spacing: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-caption-font-size' => array(
						'title' => esc_html__('Default Page Caption Font Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '16px',
						'selector' => '.realfactory-page-title-wrap.realfactory-style-custom .realfactory-page-caption{ font-size: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-caption-font-weight' => array(
						'title' => esc_html__('Default Page Title Font Weight', 'realfactory'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.realfactory-page-title-wrap .realfactory-page-caption{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (400).', 'realfactory')					
					),
					'default-caption-letter-spacing' => array(
						'title' => esc_html__('Default Page Caption Letter Spacing', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '20',
						'default' => '0px',
						'selector' => '.realfactory-page-title-wrap.realfactory-style-custom .realfactory-page-caption{ letter-spacing: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-background-overlay-opacity' => array(
						'title' => esc_html__('Default Page Title Background Overlay Opacity', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '80',
						'selector' => '.realfactory-page-title-wrap .realfactory-page-title-overlay{ opacity: #gdlr#; }'
					),
					'enable-default-breadcrumbs-on-page' => array(
						'title' => esc_html__('Enable Default Breadcrumbs on Page', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('You need to install the "Breadcrumb NavXT" plugin before using this option.', 'realfactory')
					),
					'enable-default-breadcrumbs-on-portfolio' => array(
						'title' => esc_html__('Enable Default Breadcrumbs on Portfolio', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('You need to install the "Breadcrumb NavXT" plugin before using this option.', 'realfactory')
					),
				) 
			), // title style

			'title-background' => array(
				'title' => esc_html__('Page Title Background', 'realfactory'),
				'options' => array(

					'default-title-background' => array(
						'title' => esc_html__('Default Page Title Background', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.realfactory-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-portfolio-title-background' => array(
						'title' => esc_html__('Default Portfolio Title Background', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-portfolio .realfactory-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-personnel-title-background' => array(
						'title' => esc_html__('Default Personnel Title Background', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-personnel .realfactory-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-search-title-background' => array(
						'title' => esc_html__('Default Search Title Background', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.search .realfactory-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-archive-title-background' => array(
						'title' => esc_html__('Default Archive Title Background', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.archive .realfactory-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-404-background' => array(
						'title' => esc_html__('Default 404 Background', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.realfactory-not-found-wrap .realfactory-not-found-background{ background-image: url(#gdlr#); }'
					),
					'default-404-background-opacity' => array(
						'title' => esc_html__('Default 404 Background Opacity', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '27',
						'selector' => '.realfactory-not-found-wrap .realfactory-not-found-background{ opacity: #gdlr#; }'
					),

				) 
			), // title background

			'blog-title-style' => array(
				'title' => esc_html__('Blog Title Style', 'realfactory'),
				'options' => array(

					'default-blog-title-style' => array(
						'title' => esc_html__('Default Blog Title Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'realfactory'),
							'large' => esc_html__('Large', 'realfactory'),
							'custom' => esc_html__('Custom', 'realfactory'),
							'inside-content' => esc_html__('Inside Content', 'realfactory'),
							'none' => esc_html__('None', 'realfactory'),
						),
						'default' => 'small'
					),
					'default-blog-title-top-padding' => array(
						'title' => esc_html__('Default Blog Title Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '400',
						'default' => '93px',
						'selector' => '.realfactory-blog-title-wrap.realfactory-style-custom .realfactory-blog-title-content{ padding-top: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => 'custom' )
					),
					'default-blog-title-bottom-padding' => array(
						'title' => esc_html__('Default Blog Title Bottom Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '400',
						'default' => '87px',
						'selector' => '.realfactory-blog-title-wrap.realfactory-style-custom .realfactory-blog-title-content{ padding-bottom: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => 'custom' )
					),
					'default-blog-feature-image' => array(
						'title' => esc_html__('Default Blog Feature Image Location', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'content' => esc_html__('Inside Content', 'realfactory'),
							'title-background' => esc_html__('Title Background', 'realfactory'),
							'none' => esc_html__('None', 'realfactory'),
						),
						'default' => 'content',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),
					'default-blog-title-background-image' => array(
						'title' => esc_html__('Default Blog Title Background Image', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.realfactory-blog-title-wrap{ background-image: url(#gdlr#); }',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),
					'default-blog-title-background-overlay-opacity' => array(
						'title' => esc_html__('Default Blog Title Background Overlay Opacity', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '80',
						'selector' => '.realfactory-blog-title-wrap .realfactory-blog-title-overlay{ opacity: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),
					'enable-default-breadcrumbs-on-post' => array(
						'title' => esc_html__('Enable Default Breadcrumbs on Post', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'description' => esc_html__('You need to install the "Breadcrumb NavXT" plugin before using this option.', 'realfactory')
					),

				) 
			), // post title style			

			'blog-style' => array(
				'title' => esc_html__('Blog Style', 'realfactory'),
				'options' => array(
					'blog-sidebar' => array(
						'title' => esc_html__('Single Blog Sidebar ( Default )', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'blog-sidebar-left' => array(
						'title' => esc_html__('Single Blog Sidebar Left ( Default )', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'blog-sidebar'=>array('left', 'both') )
					),
					'blog-sidebar-right' => array(
						'title' => esc_html__('Single Blog Sidebar Right ( Default )', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'blog-sidebar'=>array('right', 'both') )
					),
					'blog-max-content-width' => array(
						'title' => esc_html__('Single Blog Max Content Width ( No sidebar layout )', 'realfactory'),
						'type' => 'text',
						'data-type' => 'text',
						'data-input-type' => 'pixel',
						'default' => '900px',
						'selector' => 'body.single-post .realfactory-sidebar-style-none, body.blog .realfactory-sidebar-style-none{ max-width: #gdlr#; }'
					),
					'blog-thumbnail-size' => array(
						'title' => esc_html__('Single Blog Thumbnail Size', 'realfactory'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
					'blog-date-feature' => array(
						'title' => esc_html__('Enable Blog Date Feature', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'meta-option' => array(
						'title' => esc_html__('Meta Option', 'realfactory'),
						'type' => 'multi-combobox',
						'options' => array( 
							'date' => esc_html__('Date', 'realfactory'),
							'author' => esc_html__('Author', 'realfactory'),
							'category' => esc_html__('Category', 'realfactory'),
							'tag' => esc_html__('Tag', 'realfactory'),
							'comment' => esc_html__('Comment', 'realfactory'),
							'comment-number' => esc_html__('Comment Number', 'realfactory'),
						),
						'default' => array('author', 'category', 'tag', 'comment-number')
					),
					'blog-author' => array(
						'title' => esc_html__('Enable Single Blog Author', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-navigation' => array(
						'title' => esc_html__('Enable Single Blog Navigation', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'pagination-style' => array(
						'title' => esc_html__('Pagination Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'plain' => esc_html__('Plain', 'realfactory'),
							'rectangle' => esc_html__('Rectangle', 'realfactory'),
							'rectangle-border' => esc_html__('Rectangle Border', 'realfactory'),
							'round' => esc_html__('Round', 'realfactory'),
							'round-border' => esc_html__('Round Border', 'realfactory'),
							'circle' => esc_html__('Circle', 'realfactory'),
							'circle-border' => esc_html__('Circle Border', 'realfactory'),
						),
						'default' => 'round'
					),
					'pagination-align' => array(
						'title' => esc_html__('Pagination Alignment', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'right'
					),
				) // blog-style-options
			), // blog-style-nav

			'blog-social-share' => array(
				'title' => esc_html__('Blog Social Share', 'realfactory'),
				'options' => array(
					'blog-social-share' => array(
						'title' => esc_html__('Enable Single Blog Share', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-social-share-count' => array(
						'title' => esc_html__('Enable Single Blog Share Count', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-social-facebook' => array(
						'title' => esc_html__('Facebook', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-linkedin' => array(
						'title' => esc_html__('Linkedin', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),			
					'blog-social-google-plus' => array(
						'title' => esc_html__('Google Plus', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-pinterest' => array(
						'title' => esc_html__('Pinterest', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-stumbleupon' => array(
						'title' => esc_html__('Stumbleupon', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),			
					'blog-social-twitter' => array(
						'title' => esc_html__('Twitter', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-email' => array(
						'title' => esc_html__('Email', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
				) // blog-style-options
			), // blog-style-nav
			
			'search-archive' => array(
				'title' => esc_html__('Search/Archive', 'realfactory'),
				'options' => array(
					'enable-breadcrumbs-on-archive' => array(
						'title' => esc_html__('Enable Breadcrumbs on Archive', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('You need to install the "Breadcrumb NavXT" plugin before using this option.', 'realfactory')
					),
					'archive-blog-sidebar' => array(
						'title' => esc_html__('Archive Blog Sidebar', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'right',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-blog-sidebar-left' => array(
						'title' => esc_html__('Archive Blog Sidebar Left', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-blog-sidebar'=>array('left', 'both') )
					),
					'archive-blog-sidebar-right' => array(
						'title' => esc_html__('Archive Blog Sidebar Right', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-blog-sidebar'=>array('right', 'both') )
					),
					'archive-blog-style' => array(
						'title' => esc_html__('Archive Blog Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'blog-full' => GDLR_CORE_URL . '/include/images/blog-style/blog-full.png',
							'blog-full-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-full-with-frame.png',
							'blog-column' => GDLR_CORE_URL . '/include/images/blog-style/blog-column.png',
							'blog-column-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-with-frame.png',
							'blog-column-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-no-space.png',
							'blog-image' => GDLR_CORE_URL . '/include/images/blog-style/blog-image.png',
							'blog-image-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-image-no-space.png',
							'blog-left-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-left-thumbnail.png',
							'blog-right-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-right-thumbnail.png',
						),
						'default' => 'blog-full',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-blog-full-alignment' => array(
						'title' => esc_html__('Archive Blog Full Alignment', 'realfactory'),
						'type' => 'combobox',
						'default' => 'enable',
						'options' => array(
							'left' => esc_html__('Left', 'realfactory'),
							'center' => esc_html__('Center', 'realfactory'),
						),
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame') )
					),
					'archive-thumbnail-size' => array(
						'title' => esc_html__('Archive Thumbnail Size', 'realfactory'),
						'type' => 'combobox',
						'options' => 'thumbnail-size'
					),
					'archive-show-thumbnail' => array(
						'title' => esc_html__('Archive Show Thumbnail', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-column-size' => array(
						'title' => esc_html__('Archive Column Size', 'realfactory'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
						'default' => 20,
						'condition' => array( 'archive-blog-style' => array('blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space') )
					),
					'archive-excerpt' => array(
						'title' => esc_html__('Archive Excerpt Type', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'specify-number' => esc_html__('Specify Number', 'realfactory'),
							'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'realfactory'),
						),
						'default' => 'specify-number',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail'))
					),
					'archive-excerpt-number' => array(
						'title' => esc_html__('Archive Excerpt Number', 'realfactory'),
						'type' => 'text',
						'default' => 55,
						'data-input-type' => 'number',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail'), 'archive-excerpt' => 'specify-number')
					),
					'archive-date-feature' => array(
						'title' => esc_html__('Enable Blog Date Feature', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-meta-option' => array(
						'title' => esc_html__('Archive Meta Option', 'realfactory'),
						'type' => 'multi-combobox',
						'options' => array( 
							'date' => esc_html__('Date', 'realfactory'),
							'author' => esc_html__('Author', 'realfactory'),
							'category' => esc_html__('Category', 'realfactory'),
							'tag' => esc_html__('Tag', 'realfactory'),
							'comment' => esc_html__('Comment', 'realfactory'),
							'comment-number' => esc_html__('Comment Number', 'realfactory'),
						),
						'default' => array('date', 'author', 'category')
					),
					'archive-show-read-more' => array(
						'title' => esc_html__('Archive Show Read More Button', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail'),)
					),
				)
			),

			'woocommerce-style' => array(
				'title' => esc_html__('Woocommerce Style', 'realfactory'),
				'options' => array(

					'woocommerce-archive-sidebar' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'right',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'woocommerce-archive-sidebar-left' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar Left', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'woocommerce-archive-sidebar'=>array('left', 'both') )
					),
					'woocommerce-archive-sidebar-right' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar Right', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'woocommerce-archive-sidebar'=>array('right', 'both') )
					),
					'woocommerce-archive-column-size' => array(
						'title' => esc_html__('Woocommerce Archive Column Size', 'realfactory'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15
					),
					'woocommerce-archive-thumbnail' => array(
						'title' => esc_html__('Woocommerce Archive Thumbnail Size', 'realfactory'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
					'woocommerce-related-product-column-size' => array(
						'title' => esc_html__('Woocommerce Related Product Column Size', 'realfactory'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15
					),
					'woocommerce-related-product-num-fetch' => array(
						'title' => esc_html__('Woocommerce Related Product Num Fetch', 'realfactory'),
						'type' => 'text',
						'default' => 4,
						'data-input-type' => 'number'
					),
					'woocommerce-related-product-thumbnail' => array(
						'title' => esc_html__('Woocommerce Related Product Thumbnail Size', 'realfactory'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
				)
			),

			'portfolio-style' => array(
				'title' => esc_html__('Portfolio Style', 'realfactory'),
				'options' => array(
					'portfolio-slug' => array(
						'title' => esc_html__('Portfolio Slug (Permalink)', 'realfactory'),
						'type' => 'text',
						'default' => 'portfolio',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'realfactory')
					),
					'portfolio-category-slug' => array(
						'title' => esc_html__('Portfolio Category Slug (Permalink)', 'realfactory'),
						'type' => 'text',
						'default' => 'portfolio_category',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'realfactory')
					),
					'portfolio-tag-slug' => array(
						'title' => esc_html__('Portfolio Tag Slug (Permalink)', 'realfactory'),
						'type' => 'text',
						'default' => 'portfolio_tag',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'realfactory')
					),
					'enable-single-portfolio-navigation' => array(
						'title' => esc_html__('Enable Single Portfolio Navigation', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'portfolio-icon-hover-link' => array(
						'title' => esc_html__('Portfolio Hover Icon (Link)', 'infinite'),
						'type' => 'radioimage',
						'options' => 'hover-icon-link',
						'default' => 'icon_link_alt'
					),
					'portfolio-icon-hover-video' => array(
						'title' => esc_html__('Portfolio Hover Icon (Video)', 'infinite'),
						'type' => 'radioimage',
						'options' => 'hover-icon-video',
						'default' => 'icon_film'
					),
					'portfolio-icon-hover-image' => array(
						'title' => esc_html__('Portfolio Hover Icon (Image)', 'infinite'),
						'type' => 'radioimage',
						'options' => 'hover-icon-image',
						'default' => 'icon_zoom-in_alt'
					),
					'portfolio-icon-hover-size' => array(
						'title' => esc_html__('Portfolio Hover Icon Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-icon{ font-size: #gdlr#; }' 
					),
					'enable-related-portfolio' => array(
						'title' => esc_html__('Enable Related Portfolio', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'related-portfolio-style' => array(
						'title' => esc_html__('Related Portfolio Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'grid' => esc_html__('Grid', 'realfactory'),
							'modern' => esc_html__('Modern', 'realfactory'),
						),
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-column-size' => array(
						'title' => esc_html__('Related Portfolio Column Size', 'realfactory'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15,
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-num-fetch' => array(
						'title' => esc_html__('Related Portfolio Num Fetch', 'realfactory'),
						'type' => 'text',
						'default' => 4,
						'data-input-type' => 'number',
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-thumbnail-size' => array(
						'title' => esc_html__('Related Portfolio Thumbnail Size', 'realfactory'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'condition' => array('enable-related-portfolio'=>'enable'),
						'default' => 'medium'
					),
					'related-portfolio-num-excerpt' => array(
						'title' => esc_html__('Related Portfolio Num Excerpt', 'realfactory'),
						'type' => 'text',
						'default' => 20,
						'data-input-type' => 'number',
						'condition' => array('enable-related-portfolio'=>'enable', 'related-portfolio-style'=>'grid')
					),
				)
			),

			'portfolio-archive' => array(
				'title' => esc_html__('Portfolio Archive', 'realfactory'),
				'options' => array(
					
					'archive-portfolio-sidebar' => array(
						'title' => esc_html__('Archive Portfolio Sidebar', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-sidebar-left' => array(
						'title' => esc_html__('Archive Portfolio Sidebar Left', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-portfolio-sidebar'=>array('left', 'both') )
					),
					'archive-portfolio-sidebar-right' => array(
						'title' => esc_html__('Archive Portfolio Sidebar Right', 'realfactory'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-portfolio-sidebar'=>array('right', 'both') )
					),
					'archive-portfolio-style' => array(
						'title' => esc_html__('Archive Portfolio Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'modern' => get_template_directory_uri() . '/include/options/images/portfolio/modern.png',
							'modern-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/modern-no-space.png',
							'grid' => get_template_directory_uri() . '/include/options/images/portfolio/grid.png',
							'grid-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/grid-no-space.png',
							'modern-desc' => get_template_directory_uri() . '/include/options/images/portfolio/modern-desc.png',
							'modern-desc-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/modern-desc-no-space.png',
							'medium' => get_template_directory_uri() . '/include/options/images/portfolio/medium.png',
						),
						'default' => 'medium',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-thumbnail-size' => array(
						'title' => esc_html__('Archive Portfolio Thumbnail Size', 'realfactory'),
						'type' => 'combobox',
						'options' => 'thumbnail-size'
					),
					'archive-portfolio-grid-text-align' => array(
						'title' => esc_html__('Archive Portfolio Grid Text Align', 'realfactory'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space' ) )
					),
					'archive-portfolio-grid-style' => array(
						'title' => esc_html__('Archive Portfolio Grid Content Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'normal' => esc_html__('Normal', 'realfactory'),
							'with-frame' => esc_html__('With Frame', 'realfactory'),
							'with-bottom-border' => esc_html__('With Bottom Border', 'realfactory'),
						),
						'default' => 'normal',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space' ) )
					),
					'archive-enable-portfolio-tag' => array(
						'title' => esc_html__('Archive Enable Portfolio Tag', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
					),
					'archive-portfolio-medium-size' => array(
						'title' => esc_html__('Archive Portfolio Medium Thumbnail Size', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'realfactory'),
							'large' => esc_html__('Large', 'realfactory'),
						),
						'condition' => array( 'archive-portfolio-style' => 'medium' )
					),
					'archive-portfolio-medium-style' => array(
						'title' => esc_html__('Archive Portfolio Medium Thumbnail Style', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left', 'realfactory'),
							'right' => esc_html__('Right', 'realfactory'),
							'switch' => esc_html__('Switch ( Between Left and Right )', 'realfactory'),
						),
						'default' => 'switch',
						'condition' => array( 'archive-portfolio-style' => 'medium' )
					),
					'archive-portfolio-hover' => array(
						'title' => esc_html__('Archive Portfolio Hover Style', 'realfactory'),
						'type' => 'radioimage',
						'options' => array(
							'title' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title.png',
							'title-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title-icon.png',
							'title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title-tag.png',
							'icon-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/icon-title-tag.png',
							'icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/icon.png',
							'margin-title' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title.png',
							'margin-title-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title-icon.png',
							'margin-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title-tag.png',
							'margin-icon-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-icon-title-tag.png',
							'margin-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-icon.png',
							'none' => get_template_directory_uri() . '/include/options/images/portfolio/hover/none.png',
						),
						'default' => 'icon',
						'max-width' => '100px',
						'condition' => array( 'archive-portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'medium') ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-column-size' => array(
						'title' => esc_html__('Archive Portfolio Column Size', 'realfactory'),
						'type' => 'combobox',
						'options' => array( 60=>1, 30=>2, 20=>3, 15=>4, 12=>5 ),
						'default' => 20,
						'condition' => array( 'archive-portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space') )
					),
					'archive-portfolio-excerpt' => array(
						'title' => esc_html__('Archive Portfolio Excerpt Type', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'specify-number' => esc_html__('Specify Number', 'realfactory'),
							'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'realfactory'),
							'none' => esc_html__('Disable Exceprt', 'realfactory'),
						),
						'default' => 'specify-number',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
					),
					'archive-portfolio-excerpt-number' => array(
						'title' => esc_html__('Archive Portfolio Excerpt Number', 'realfactory'),
						'type' => 'text',
						'default' => 55,
						'data-input-type' => 'number',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ), 'archive-portfolio-excerpt' => 'specify-number' )
					),

				)
			),

			'personnel-style' => array(
				'title' => esc_html__('Personnel Style', 'realfactory'),
				'options' => array(
					'personnel-slug' => array(
						'title' => esc_html__('Personnel Slug (Permalink)', 'realfactory'),
						'type' => 'text',
						'default' => 'personnel',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'realfactory')
					),
					'personnel-category-slug' => array(
						'title' => esc_html__('Personnel Category Slug (Permalink)', 'realfactory'),
						'type' => 'text',
						'default' => 'personnel_category',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'realfactory')
					),
				)
			),

			'footer' => array(
				'title' => esc_html__('Footer/Copyright', 'realfactory'),
				'options' => array(

					'fixed-footer' => array(
						'title' => esc_html__('Fixed Footer', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'enable-footer' => array(
						'title' => esc_html__('Enable Footer', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'footer-top-padding' => array(
						'title' => esc_html__('Footer Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '70px',
						'selector' => '.realfactory-footer-wrapper{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-bottom-padding' => array(
						'title' => esc_html__('Footer Bottom Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '50px',
						'selector' => '.realfactory-footer-wrapper{ padding-bottom: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-style' => array(
						'title' => esc_html__('Footer Style', 'realfactory'),
						'type' => 'radioimage',
						'wrapper-class' => 'gdlr-core-fullsize',
						'options' => array(
							'footer-1' => get_template_directory_uri() . '/include/options/images/footer-style1.png',
							'footer-2' => get_template_directory_uri() . '/include/options/images/footer-style2.png',
							'footer-3' => get_template_directory_uri() . '/include/options/images/footer-style3.png',
							'footer-4' => get_template_directory_uri() . '/include/options/images/footer-style4.png',
							'footer-5' => get_template_directory_uri() . '/include/options/images/footer-style5.png',
							'footer-6' => get_template_directory_uri() . '/include/options/images/footer-style6.png',
						),
						'default' => 'footer-2',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'enable-copyright' => array(
						'title' => esc_html__('Enable Copyright', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'copyright-top-padding' => array(
						'title' => esc_html__('Footer Top Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '38px',
						'selector' => '.realfactory-copyright-text{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'copyright-bottom-padding' => array(
						'title' => esc_html__('Footer Bottom Padding', 'realfactory'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '38px',
						'selector' => '.realfactory-copyright-text{ padding-bottom: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'copyright-text' => array(
						'title' => esc_html__('Copyright Text', 'realfactory'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'condition' => array( 'enable-copyright' => 'enable' )
					),
					'enable-back-to-top' => array(
						'title' => esc_html__('Enable Back To Top Button', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
				) // footer-options
			), // footer-nav	
		
		) // general-options
		
	), 2);