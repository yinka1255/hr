<?php 
	/*	
	*	Goodlayers Function Inclusion File
	*	---------------------------------------------------------------------
	*	This file contains the script to includes necessary function to the theme
	*	---------------------------------------------------------------------
	*/

	// include the shortcode support for the text widget
	add_filter('widget_text', 'do_shortcode');
	add_filter('widget_title', 'do_shortcode');

	// Set the content width based on the theme's design and stylesheet.
	if( !isset($content_width) ){
		$content_width = str_replace('px', '', '1150px'); 
	}

	// Add body class for page builder
	add_filter('body_class', 'realfactory_body_class');
	if( !function_exists('realfactory_body_class') ){
		function realfactory_body_class( $classes ) {
			$classes[] = 'realfactory-body';
			$classes[] = 'realfactory-body-front';

			$layout = realfactory_get_option('general', 'layout', 'full');
			if( $layout == 'boxed' ){
			 	$classes[] = 'realfactory-boxed';

			 	$background = realfactory_get_option('general', 'background-type', 'color');
			 	if( $background == 'image' ){
			 		$classes[] = 'realfactory-background-image';
			 	}else if( $background == 'pattern' ){
			 		$classes[] = 'realfactory-background-pattern';
			 	}

			 	$border = realfactory_get_option('general', 'enable-boxed-border', 'disable');
			 	if( $border == 'enable' ){
			 		$classes[] = 'realfactory-boxed-border';
			 	}
			}else{
				$classes[] = 'realfactory-full';
			}

			$sticky_menu = realfactory_get_option('general', 'enable-main-navigation-sticky', 'enable');
			if( $sticky_menu == 'enable' ){
				$classes[] = ' realfactory-with-sticky-navigation';
				
				$sticky_menu_logo = realfactory_get_option('general', 'enable-logo-on-main-navigation-sticky', 'enable');
				if( $sticky_menu_logo == 'disable' ){
					$classes[] = ' realfactory-sticky-navigation-no-logo';
				}
			}

			return $classes;
		}
	}

	// Set the neccessary function to be used in the theme
	add_action('after_setup_theme', 'realfactory_theme_setup');
	if( !function_exists( 'realfactory_theme_setup' ) ){
		function realfactory_theme_setup(){
			
			// define textdomain for translation
			load_theme_textdomain('realfactory', get_template_directory() . '/languages');

			// add default posts and comments RSS feed links to head.
			add_theme_support('automatic-feed-links');

			// declare that this theme does not use a hard-coded <title> tag in <head>
			add_theme_support('title-tag');

			// tmce editor stylesheet
			add_editor_style('/css/editor-style.css');

			// define menu locations
			register_nav_menus(array(
				'main_menu' => esc_html__('Primary Menu', 'realfactory'),
				'right_menu' => esc_html__('Secondary Menu', 'realfactory'),
				'mobile_menu' => esc_html__('Mobile Menu', 'realfactory'),
			));

			// enable support for post formats / thumbnail
			add_theme_support('post-thumbnails');
			add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio')); // 'status', 'chat'
			
			// switch default core markup
			add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
			
			// add custom image size
			$thumbnail_sizes = realfactory_get_option('plugin', 'thumbnail-sizing');
			if( !empty($thumbnail_sizes) ){
				foreach( $thumbnail_sizes as $thumbnail_size ){
					add_image_size($thumbnail_size['name'], $thumbnail_size['width'], $thumbnail_size['height'], true);
				}
			}

		}
	}

	// turn the page comment off by default
	add_filter( 'wp_insert_post_data', 'realfactory_page_default_comments_off' );
	if( !function_exists('realfactory_page_default_comments_off') ){
		function realfactory_page_default_comments_off( $data ) {
			if( $data['post_type'] == 'page' && $data['post_status'] == 'auto-draft' ) {
				$data['comment_status'] = 0;
			} 

			return $data;
		}
	}	

	// logo displaying
	if( !function_exists('realfactory_get_logo') ){
		function realfactory_get_logo($settings = array()){

			$extra_class  = (isset($settings['padding']) && $settings['padding'] === false)? '': ' realfactory-item-pdlr';
			
			$ret  = '<div class="realfactory-logo ' . esc_attr($extra_class) . '">';
			$ret .= '<div class="realfactory-logo-inner">';
		
			// print logo
			if( !empty($settings['mobile']) ){
				$logo_id = realfactory_get_option('general', 'mobile-logo');
			} 
			if( empty($logo_id) ){
				$logo_id = realfactory_get_option('general', 'logo');
			}

			$ret .= '<a href="' . esc_url(home_url('/')) . '" >';
			if( empty($logo_id) ){
				$ret .= gdlr_core_get_image(get_template_directory_uri() . '/images/logo.png');
			}else{
				$ret .= gdlr_core_get_image($logo_id);
			}
			$ret .= '</a>';

			$ret .= '</div>';
			$ret .= '</div>';

			return $ret;
		}	
	}

	// set anchor color
	add_action('wp_head', 'realfactory_set_anchor_color');
	if( !function_exists('realfactory_set_anchor_color') ){
		function realfactory_set_anchor_color(){
			$post_option = realfactory_get_post_option(get_the_ID());

			$anchor_css = '';
			if( !empty($post_option['bullet-anchor']) ){
				foreach( $post_option['bullet-anchor'] as $anchor ){
					if( !empty($anchor['title']) ){
						$anchor_section = str_replace('#', '', $anchor['title']);

						if( !empty($anchor['anchor-color']) ){
							$anchor_css .= '.realfactory-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a:before{ background-color: ' . esc_html($anchor['anchor-color']) . '; }';
						}
						if( !empty($anchor['anchor-hover-color']) ){
							$anchor_css .= '.realfactory-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a:hover, ';
							$anchor_css .= '.realfactory-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a.current-menu-item{ border-color: ' . esc_html($anchor['anchor-hover-color']) . '; }';
							$anchor_css .= '.realfactory-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a:hover:before, ';
							$anchor_css .= '.realfactory-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a.current-menu-item:before{ background: ' . esc_html($anchor['anchor-hover-color']) . '; }';
						}
					}
				}
			}

			if( !empty($anchor_css) ){
				echo '<style type="text/css" >' . $anchor_css . '</style>';
			}
		}
	}

	// remove id from nav menu item
	add_filter('nav_menu_item_id', 'realfactory_nav_menu_item_id', 10, 4);
	if( !function_exists('realfactory_nav_menu_item_id') ){
		function realfactory_nav_menu_item_id( $id, $item, $args, $depth ){
			return '';
		}
	}

	// add additional script
	add_action('wp_head', 'realfactory_header_script', 99);
	if( !function_exists('realfactory_header_script') ){
		function realfactory_header_script(){
			$header_script = realfactory_get_option('plugin', 'additional-head-script', '');
			if( !empty($header_script) ){
				echo '<script type="text/javascript" >' . $header_script . '</script>';
			}

		}
	}
	add_action('wp_footer', 'realfactory_footer_script');
	if( !function_exists('realfactory_footer_script') ){
		function realfactory_footer_script(){
			$footer_script = realfactory_get_option('plugin', 'additional-script', '');
			if( !empty($footer_script) ){
				echo '<script type="text/javascript" >' . $footer_script . '</script>';
			}

		}
	}

	if( is_admin() ){ add_filter('site_transient_update_themes', 'realfactory_disable_org_update'); }
	if( !function_exists('realfactory_disable_org_update') ){
		function realfactory_disable_org_update( $value ){
			if( !empty($value->response['realfactory']) ){
				unset($value->response['realfactory']);
			}
			return $value;
		}
	}