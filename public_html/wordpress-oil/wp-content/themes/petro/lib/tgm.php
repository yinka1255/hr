<?php
defined('ABSPATH') or die();
require_once (get_template_directory().'/lib/tgm/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'petro_register_required_plugins' );

function petro_register_required_plugins() {

	$plugins = array(
			array(
				'name'     				=> esc_html__( 'WordPress Importer','petro'),
				'slug'     				=> 'wordpress-importer',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'WP Options Importer','petro'),
				'slug'     				=> 'options-importer',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'Nuno Page Builder','petro'),
				'slug'     				=> 'nuno-builder',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'source'                => esc_url('http://store.themegum.com/plugins/nuno-builder.zip')
			),
			array(
				'name'     				=> esc_html__( 'Contact Form 7','petro'),
				'slug'     				=> 'contact-form-7',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'Crelly Slider By Fabio Rinaldi','petro'),
				'slug'     				=> 'crelly-slider',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'WooCommerce','petro'),
				'slug'     				=> 'woocommerce',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'Nuno Page Builder Addon','petro'),
				'slug'     				=> 'nuno-builder-addon',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'source'                => esc_url('http://store.themegum.com/plugins/nuno-builder-addon.zip')
			),
			array(
				'name'     				=> esc_html__( 'WordPress Custom Post by TemeGUM','petro'),
				'slug'     				=> 'tg_custom_post',
				'source'   				=> esc_url('http://store.themegum.com/plugins/tg_custom_post.zip'),
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'Petro Service Post by TemeGUM','petro'),
				'slug'     				=> 'petro_service',
				'source'   				=> esc_url('http://store.themegum.com/plugins/petro_service.zip'),
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
		);



	$config = array(
		'domain'       		=> 'petro',         			
		'default_path' 		=> '',                         	
		'parent_slug' 		=> 'themes.php', 				
		'menu'         		=> 'install-required-plugins', 	
		'has_notices'      	=> true,                       	
		'is_automatic'    	=> false,					   	
		'message' 			=> ''							
	);

	tgmpa( $plugins, $config );

}