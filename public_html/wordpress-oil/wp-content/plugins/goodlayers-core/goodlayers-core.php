<?php
	/*
	Plugin Name: Goodlayers Core
	Plugin URI: 
	Description: A core plugin for Goodlayers GEN3 Theme ( This plugin might not fully functioned on another theme )
	Version: 1.1.0
	Author: Goodlayers
	Author URI: http://www.goodlayers.com
	License: 
	*/
	
	// define necessary variable for the site.
	define('GDLR_CORE_URL', plugins_url('', __FILE__));
	define('GDLR_CORE_LOCAL', dirname(__FILE__));
	
	$gdlr_core_item_pdb = '30px';
	
	///////////////////////////////
	// include core system file
	///////////////////////////////
	include_once(GDLR_CORE_LOCAL . '/framework/function/file-system.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/media.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/utility.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/sidebar-generator.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/skin-settings.php');

	// load only in admin pages
	if( is_admin() ){
		include_once(GDLR_CORE_LOCAL . '/framework/function/admin-menu.php');
		gdlr_core_admin_menu::init();

		include_once(GDLR_CORE_LOCAL . '/framework/function/getting-start.php');
		include_once(GDLR_CORE_LOCAL . '/framework/importer/parsers.php');
		include_once(GDLR_CORE_LOCAL . '/framework/importer/importer.php');

		include_once(GDLR_CORE_LOCAL . '/framework/function/revision.php'); 
		include_once(GDLR_CORE_LOCAL . '/framework/function/page-option.php');
		
		include_once(GDLR_CORE_LOCAL . '/framework/function/html-option.php');
		add_filter('wp_ajax_gdlr_get_gallery_options', 'gdlr_core_html_option::get_gallery_options');

		include_once(GDLR_CORE_LOCAL . '/template/prebuilt-block.php');

		// plugin script/style
		include_once(GDLR_CORE_LOCAL . '/plugins/combine/combine.php');
	}
	
	// for page builder
	include_once(GDLR_CORE_LOCAL . '/framework/function/page-builder.php'); 
	include_once(GDLR_CORE_LOCAL . '/framework/function/page-builder-options.php'); 
	include_once(GDLR_CORE_LOCAL . '/framework/function/page-builder-wrapper.php'); 
	include_once(GDLR_CORE_LOCAL . '/framework/function/page-builder-element.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/page-builder-template.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/page-builder-custom-template.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/framework2-compatibility.php');
	
	include_once(GDLR_CORE_LOCAL . '/include/pb-wrapper/pb-wrapper-background.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb-wrapper/pb-wrapper-sidebar.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb-wrapper/pb-wrapper-column.php'); 

	include_once(GDLR_CORE_LOCAL . '/include/pb/blog-item.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/blog-style.php');

	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-accordion.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-audio.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-blockquote.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-button.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-alert-box.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-blog.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-call-to-action.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-code.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-column-service.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-columnize.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-countdown.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-counter.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-divider.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-feature-box.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-flipbox.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-gallery.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-icon.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-icon-list.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-image.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-opening-hours.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-port-info.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-post-slider.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-price-table.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-promo-box.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-skill-bar.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-skill-circle.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-social-network.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-social-share.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-space.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-stunning-text.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-tab.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-text-box.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-text-script.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-testimonial.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-title.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-toggle-box.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-type-animation.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-video.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb/pb-element-widget.php');

	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/product-item.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/product-style.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/pb-element-product.php'); 

	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/pb-element-contact-form-7.php');
	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/pb-element-layer-slider.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/pb-element-newsletter.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/pb-element-master-slider.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/pb-element-revolution-slider.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/pb-plugins/pb-element-wp-google-map-plugin.php'); 

	include_once(GDLR_CORE_LOCAL . '/include/element/dropcap.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/element/dropdown-tab.php'); 

	/* include shortcode bar */
	include_once(GDLR_CORE_LOCAL . '/framework/function/shortcode-list.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/element/shortcode-list.php'); 

	/* include widget */
	include_once(GDLR_CORE_LOCAL . '/framework/function/widget-util.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/widget/recent-post-widget.php'); 
	include_once(GDLR_CORE_LOCAL . '/include/widget/post-slider-widget.php'); 
	 
	// init the font loader object
	include_once(GDLR_CORE_LOCAL . '/framework/function/font-loader.php');
	if( !is_admin() ){ 
		add_action('wp_enqueue_scripts', 'gdlr_core_enqueue_google_font'); 
		if( !function_exists('gdlr_core_enqueue_google_font') ){
			function gdlr_core_enqueue_google_font() {
				global $gdlr_core_font_loader;
				if( empty($gdlr_core_font_loader) ){
					$gdlr_core_font_loader = new gdlr_core_font_loader();
				}
				$gdlr_core_font_loader->google_font_enqueue();
			}
		}
	}
	
	// for customizer
	include_once(GDLR_CORE_LOCAL . '/framework/function/theme-option.php');
	include_once(GDLR_CORE_LOCAL . '/framework/function/customizer.php');
	
	// menu edit class
	include_once(GDLR_CORE_LOCAL . '/framework/function/navigation-menu.php');
	
	// init the ajax variable for wpml compatibility
	add_action('plugins_loaded', 'init_goodlayers_core_system', 1);
	if( !function_exists('init_goodlayers_core_system') ){
		function init_goodlayers_core_system(){
			global $sitepress;
			if( !empty($sitepress) ){
				define('GDLR_CORE_AJAX_URL', admin_url('admin-ajax.php?lang=' . $sitepress->get_current_language()));
			}else{
				define('GDLR_CORE_AJAX_URL', admin_url('admin-ajax.php'));
			}
		}
	}
	
	// create the page builder
	add_action('after_setup_theme', 'gdlr_init_goodlayers_core_elements');
	if( !function_exists('gdlr_init_goodlayers_core_elements') ){
		function gdlr_init_goodlayers_core_elements(){
			
			if( is_admin() ){
				$revision_num = 5;
				new gdlr_core_revision($revision_num);			
			}
			
			new gdlr_core_page_builder();
		}
	}
	
	// enqueue necessay style for front end
	if( !is_admin() ){ add_action('wp_enqueue_scripts', 'gdlr_core_front_script'); }
	if( !function_exists('gdlr_core_front_script') ){
		function gdlr_core_front_script( $admin = false ){

			// enqueue selected script
			wp_enqueue_style('gdlr-core-plugin', GDLR_CORE_URL . '/plugins/combine/style.css');
			wp_enqueue_script('gdlr-core-plugin', GDLR_CORE_URL . '/plugins/combine/script.js', array('jquery'), false, true);

			// enqueue main goodlayers script
			$gdlr_core_pbf = array( 
				'admin' => $admin,
				'video' => array('width' => '640', 'height' => '360'),
				'ajax_url' => GDLR_CORE_AJAX_URL
			);

			$lightbox = apply_filters('gdlr_core_lightbox_type', 'ilightbox-dark');
			if( strpos($lightbox, 'ilightbox-') !== false ){
				$gdlr_core_pbf['ilightbox_skin'] = str_replace('ilightbox-', '', $lightbox);
			}
			wp_enqueue_style('gdlr-core-page-builder', GDLR_CORE_URL . '/include/css/page-builder.css');
			wp_enqueue_script('gdlr-core-page-builder', GDLR_CORE_URL . '/include/js/page-builder.js', array('jquery'), false, true);
			wp_localize_script('gdlr-core-page-builder', 'gdlr_core_pbf', $gdlr_core_pbf);

		}
	}
	if( !function_exists('gdlr_core_generate_combine_script') ){
		function gdlr_core_generate_combine_script( $script_included ){
			
			$script_included = wp_parse_args($script_included, array(
				'include' => 'flexslider',
				'lightbox' => 'ilightbox-dark'
			));

			$fs = new gdlr_core_file_system();

			$style = gdlr_core_get_combine_plugin_style($script_included);
			$fs->write(GDLR_CORE_LOCAL . '/plugins/combine/style.css', $style);

			$script = gdlr_core_get_combine_plugin_script($script_included);
			$fs->write(GDLR_CORE_LOCAL . '/plugins/combine/script.js', $script);

		}
	}	

	// add body class for page builder
	add_filter('body_class', 'gdlr_core_body_class');
	if( !function_exists('gdlr_core_body_class') ){
		function gdlr_core_body_class( $classes ) {
			$classes[] = 'gdlr-core-body';
			return $classes;
		}
	}

	add_action('plugins_loaded', 'gdlr_core_load_textdomain');
	if( !function_exists('gdlr_core_load_textdomain') ){
		function gdlr_core_load_textdomain() {
		  load_plugin_textdomain('goodlayers-core', false, plugin_basename(dirname(__FILE__)) . '/languages'); 
		}
	}