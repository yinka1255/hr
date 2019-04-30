<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	// save the css/js file 
	add_action('gdlr_core_after_save_theme_option', 'realfactory_gdlr_core_after_save_theme_option');
	if( !function_exists('realfactory_gdlr_core_after_save_theme_option') ){
		function realfactory_gdlr_core_after_save_theme_option(){
			if( function_exists('gdlr_core_generate_combine_script') ){
				realfactory_clear_option();

				gdlr_core_generate_combine_script(array(
					'lightbox' => realfactory_gdlr_core_lightbox_type()
				));
			}
		}
	}

	// add the option
	$realfactory_admin_option->add_element(array(
	
		// plugin head section
		'title' => esc_html__('Miscellaneous', 'realfactory'),
		'slug' => 'rftr_plugin',
		'icon' => get_template_directory_uri() . '/include/options/images/plugin.png',
		'options' => array(
		
			// starting the subnav
			'thumbnail-sizing' => array(
				'title' => esc_html__('Thumbnail Sizing', 'realfactory'),
				'customizer' => false,
				'options' => array(
				
					'enable-srcset' => array(
						'title' => esc_html__('Enable Srcset', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('Enable this option will improve the performance by resizing the image based on the screensize. Please be cautious that this will generate multiple images on your server.', 'realfactory')
					),
					'thumbnail-sizing' => array(
						'title' => esc_html__('Add Thumbnail Size', 'realfactory'),
						'type' => 'custom',
						'item-type' => 'thumbnail-sizing',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					
				) // thumbnail-sizing-options
			), // thumbnail-sizing-nav		
			'plugins' => array(
				'title' => esc_html__('Plugins', 'realfactory'),
				'options' => array(

					'lightbox' => array(
						'title' => esc_html__('Lightbox Type', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'ilightbox' => esc_html__('ilightbox', 'realfactory'),
							'strip' => esc_html__('Strip', 'realfactory'),
						)
					),
					'ilightbox-skin' => array(
						'title' => esc_html__('iLightbox Skin', 'realfactory'),
						'type' => 'combobox',
						'options' => array(
							'dark' => esc_html__('Dark', 'realfactory'),
							'light' => esc_html__('Light', 'realfactory'),
							'mac' => esc_html__('Mac', 'realfactory'),
							'metro-black' => esc_html__('Metro Black', 'realfactory'),
							'metro-white' => esc_html__('Metro White', 'realfactory'),
							'parade' => esc_html__('Parade', 'realfactory'),
							'smooth' => esc_html__('Smooth', 'realfactory'),		
						),
						'condition' => array( 'lightbox' => 'ilightbox' )
					),
					'link-to-lightbox' => array(
						'title' => esc_html__('Turn Image Link To Open In Lightbox', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					
				) // plugin-options
			), // plugin-nav		
			'additional-script' => array(
				'title' => esc_html__('Custom Css/Js', 'realfactory'),
				'options' => array(
				
					'additional-css' => array(
						'title' => esc_html__('Additional CSS ( without <style> tag )', 'realfactory'),
						'type' => 'textarea',
						'data-type' => 'text',
						'selector' => '#gdlr#',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'additional-mobile-css' => array(
						'title' => esc_html__('Mobile CSS ( screen below 767px )', 'realfactory'),
						'type' => 'textarea',
						'data-type' => 'text',
						'selector' => '@media only screen and (max-width: 767px){ #gdlr# }',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'additional-head-script' => array(
						'title' => esc_html__('Additional Head Script ( without <script> tag )', 'realfactory'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'descriptin' => esc_html__('Eg. For analytics', 'realfactory')
					),
					'additional-script' => array(
						'title' => esc_html__('Additional Script ( without <script> tag )', 'realfactory'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					
				) // additional-script-options
			), // additional-script-nav	
			'maintenance' => array(
				'title' => esc_html__('Maintenance Mode', 'realfactory'),
				'options' => array(		
					'enable-maintenance' => array(
						'title' => esc_html__('Enable Maintenance / Coming Soon Mode', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),					
					'maintenance-page' => array(
						'title' => esc_html__('Select Maintenance / Coming Soon Page', 'realfactory'),
						'type' => 'combobox',
						'options' => 'post_type',
						'options-data' => 'page'
					),

				) // maintenance-options
			), // maintenance
			'pre-load' => array(
				'title' => esc_html__('Preload', 'realfactory'),
				'options' => array(		
					'enable-preload' => array(
						'title' => esc_html__('Enable Preload', 'realfactory'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'preload-image' => array(
						'title' => esc_html__('Preload Image', 'realfactory'),
						'type' => 'upload',
						'data-type' => 'file', 
						'selector' => '.realfactory-page-preload{ background-image: url(#gdlr#); }',
						'condition' => array( 'enable-preload' => 'enable' ),
						'description' => esc_html__('Upload the image (.gif) you want to use as preload animation. You could search it online at https://www.google.com/search?q=loading+gif as well', 'realfactory')
					),
				)
			),
			'import-export' => array(
				'title' => esc_html__('Import / Export', 'realfactory'),
				'options' => array(

					'export' => array(
						'title' => esc_html__('Export Option', 'realfactory'),
						'type' => 'export',
						'action' => 'gdlr_core_theme_option_export',
						'options' => array(
							'all' => esc_html__('All Options(general/typography/color/miscellaneous) exclude widget, custom template', 'realfactory'),
							'rftr_general' => esc_html__('General Option', 'realfactory'),
							'rftr_typography' => esc_html__('Typography Option', 'realfactory'),
							'rftr_color' => esc_html__('Color Option', 'realfactory'),
							'rftr_plugin' => esc_html__('Miscellaneous', 'realfactory'),
							'widget' => esc_html__('Widget', 'realfactory'),
							'page-builder-template' => esc_html__('Custom Page Builder Template', 'realfactory'),
						),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'import' => array(
						'title' => esc_html__('Import Option', 'realfactory'),
						'type' => 'import',
						'action' => 'gdlr_core_theme_option_import',
						'wrapper-class' => 'gdlr-core-fullsize'
					),

				) // import-options
			), // import-export
			
		
		) // plugin-options
		
	), 8);	