<?php
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */
defined('ABSPATH') or die();


if ( ! isset( $content_width ) ) $content_width = 2000;

function petro_startup() {


	if((is_child_theme() && !load_theme_textdomain( 'petro', untrailingslashit(get_stylesheet_directory()) . "/languages/")) || !is_child_theme()){
		load_theme_textdomain('petro',untrailingslashit(get_template_directory())."/languages/");
	}

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 150,
		'flex-height' => true,
		'flex-width' => false,
	) );

	add_theme_support( 'woocommerce' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-header', apply_filters( 'petro_custom_header_args', array(
		'default-image'      => get_template_directory_uri().'/images/banner-page.jpeg',
		'width'              => 1500,
		'height'             => 900,
		'flex-height'        => true,
		'video'              => false,
		'wp-head-callback'   => 'petro_header_style',
	) ) );


	register_nav_menus(array(
		'main_navigation' => esc_html__('Top Navigation', 'petro')
	));

	// sidebar widget

	register_sidebar(
		array('name'=> esc_html__( 'Sidebar','petro'),
			'id'	=>'sidebar-widget',
			'description'=> esc_html__('The widget will displayed at left/right off main content.', 'petro'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="h6 widget-title">',
			'after_title' => '</div>'
		)
	);


	register_sidebar(
		array('name'=> esc_html__( 'Slidingbar','petro'),
			'id'	=>'slidingbar-widget',
			'description'=> esc_html__('The widget will displayed at sliding bar (side menu).', 'petro'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="h6 widget-title">',
			'after_title' => '</div>'
		)
	);


	register_sidebar(
		array('name'=> esc_html__( 'Bottom','petro'),
			'id'	=>'footer-widget',
			'description'=> esc_html__('The widget will displayed at bottom area before footer text.', 'petro'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="h6 widget-title">',
			'after_title' => '</div>'
		)
	);

	if(class_exists('TG_Custom_Post')){
		register_sidebar(
			array('name'=> esc_html__( 'Portfolio Page','petro'),
				'id'	=>'portfolio-widget',
				'description'=> esc_html__('The widget will displayed at detail portfolio post.', 'petro'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h6 widget-title">',
				'after_title' => '</div>'
			)
		);

		add_filter('tg_custom_post_metabox_title', create_function('', 'return esc_html__(\'Portfolio Information\',\'petro\');'));

	}

	if(class_exists('petro_service')){
		register_sidebar(
			array('name'=> esc_html__( 'Service Page','petro'),
				'id'	=>'service-widget',
				'description'=> esc_html__('The widget will displayed at detail service post.', 'petro'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h6 widget-title">',
				'after_title' => '</div>'
			)
		);

	}

	if (function_exists('is_shop')) {

		register_sidebar(
			array('name'=> esc_html__('Shop Sidebar Widget Area', 'petro'),
				'id'=>'shop-sidebar',
				'description'=> esc_html__('Sidebar will display on woocommerce page only', 'petro'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h6 widget-title">',
				'after_title' => '</div>'
			));

	}

	add_action( 'wp_enqueue_scripts', 'petro_enqueue_scripts', 9999);
	add_action( 'wp_enqueue_scripts', 'petro_config_loader',1);
	add_action( 'wp_enqueue_scripts', 'petro_custom_script', 9999 );
	add_filter( 'theme_mod_header_image', 'petro_header_image',1);
	add_filter( 'themegum_glyphicon_list', 'petro_awesome_icon_lists' );
	add_action('themegum-glyph-icon-loaded','petro_load_petro_glyph');
} 

add_action('after_setup_theme','petro_startup');

require_once( get_template_directory().'/lib/tgm.php');
require_once( get_template_directory().'/lib/themegum_functions.php');
require_once( get_template_directory().'/lib/options.php');
require_once( get_template_directory().'/lib/widgets.php');
require_once( get_template_directory().'/lib/category_attributes.php');
require_once( get_template_directory().'/lib/themegum_page_attributes.php');

if(function_exists('is_shop')){
  require_once( get_template_directory().'/lib/woocommerce.php'); 
}


if(function_exists('add_builder_element_option')){
	require_once( get_template_directory().'/lib/nuno_elements.php');
}


function petro_enqueue_scripts(){

	petro_load_styles();
	petro_load_scripts();
}

function petro_load_scripts(){

    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'modernizr' , get_template_directory_uri() . '/js/modernizr.custom.js', array(), '1.0', true );
    wp_enqueue_script( 'bootstrap' , get_template_directory_uri() . '/js/bootstrap'.$suffix.'.js', array( 'jquery' ), '3.2.0', true );
    wp_enqueue_script( 'petro-theme-script' , get_template_directory_uri() . '/js/themescript.js', array( 'jquery','bootstrap'), '1.0', true );
    wp_enqueue_script( 'jquery.magnific-popup' , get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery'), '1.0', true );

    if(is_single() || is_page()){
	 	wp_enqueue_script( 'comment-reply' );
    }

}

function petro_load_petro_glyph(){
	wp_enqueue_style( "petro-glyph",get_template_directory_uri() . '/fonts/petro-construction/petro-construction.css', array(), '', 'all' );
}


function petro_load_styles(){

	if(is_admin() || defined('IFRAME_REQUEST')) /* just front loaded */
		return;

	wp_enqueue_style( 'petro-stylesheet', get_template_directory_uri() . '/style.css', array(), '', 'all');
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.5' );	

	$blog_id="";
	if ( is_multisite()){
		$blog_id="-site".get_current_blog_id();
	}

	wp_enqueue_style( "awesomeicon",get_template_directory_uri() . '/fonts/font-awesome/font-awesome.css', array(), '', 'all' );
	petro_load_petro_glyph();
	wp_enqueue_style( "petro-main-style",get_template_directory_uri() . '/css/themestyle.css', array(), '', 'all' );

	if(is_rtl()){
		wp_enqueue_style( "petro-rtl-style",  get_template_directory_uri() . '/css/themestyle-rtl.css', array(), '', 'all' );
	}

	$bodyFont=petro_get_config('body-font');

	if (isset($bodyFont['font-family']) && isset($bodyFont['google']) && $bodyFont['font-family']!='') {
		if (isset($bodyFont['google']) && $bodyFont['google']) {
			$fontfamily = $bodyFont['font-family'];
			$subsets = (!empty($bodyFont['subsets'])) ? $bodyFont['subsets']: '';
			wp_enqueue_style( sanitize_title($fontfamily) , esc_url(petro_slug_font_url($fontfamily,$subsets)));
		}	
	}else{
		wp_enqueue_style( 'Open-Sans-font' , esc_url('//fonts.googleapis.com/css?family=Open+Sans:400,400i, 600,700,800'));
	}

	$headingFont=petro_get_config('heading-font');

	if (isset($headingFont['font-family']) && isset($headingFont['google']) && $headingFont['font-family']!='') {
		if (isset($headingFont['google']) && $headingFont['google']) {
			$fontfamily = $headingFont['font-family'];
			$subsets = (!empty($headingFont['subsets'])) ? $headingFont['subsets']: '';
			wp_enqueue_style( sanitize_title($fontfamily) , esc_url(petro_slug_font_url($fontfamily,$subsets)));
		}	
	}
	
	if(is_child_theme()){
		wp_enqueue_style( 'petro-child-theme-style',get_stylesheet_directory_uri() . '/style.css', array(), '', 'all' );
	}

	wp_enqueue_style( "petro-site-style",get_template_directory_uri() . '/css/style'.$blog_id.'.css', array(), '', 'all' );

}

function petro_slug_font_url($font_family,$subset,$font_weight='300,300italic,400,400italic,700,700italic,800,800italic,900,900italic') {

	$fonts_url = '';
	if ( !empty($font_family )) {
		$font_families = array();
	 
		$font_families[] = $font_family.':'.$font_weight;
		 
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( $subset ),
		);
		 
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	 
	return esc_url_raw( $fonts_url );
} 

function petro_custom_script(){

	$custom_js=petro_get_config('js-code','');

	if(!empty($custom_js)){
		wp_add_inline_script('petro-theme-script', $custom_js);
	}

	if(!get_option( 'css_folder_writeable',true) || petro_get_config('devmode',false)){

		$custom_css = get_theme_mod( 'custom_css' );

		wp_add_inline_style( 'petro-main-style', $custom_css);

	}
}

function petro_awesome_icon_lists($icons){


  $construction_icon_path=get_template_directory()."/fonts/petro-construction/";

  if($constructions_icons = petro_get_glyph_lists($construction_icon_path)){
    $icons = is_array($icons) ? array_merge( $icons, $constructions_icons ) : $constructions_icons;
  }

  $awesome_icon_path=get_template_directory()."/fonts/font-awesome/";

  if($awesome_icons = petro_get_glyph_lists($awesome_icon_path)){
    $icons = is_array($icons) ? array_merge( $icons, $awesome_icons ) : $awesome_icons;
  }

  return array_unique($icons);
}


?>