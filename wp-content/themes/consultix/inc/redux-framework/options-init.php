<?php
/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 *
 * @package Consultix
 */

// Check if Redux installed.
if ( ! class_exists( 'Redux' ) ) {
	return;
}
// This is your option name where all the Redux data is stored.
$opt_name = 'consultix_theme_option';

/**
 * SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme(); // For use with some settings. Not necessary.
$args  = array(
	// TYPICAL -> Change these values as you need/desire.
	'opt_name'             => $opt_name,
	'disable_tracking'     => true,
	'display_name'         => $theme->get( 'Name' ),
	'display_version'      => esc_html__( 'Powered By: Radiant Admin Options', 'consultix' ),
	'menu_type'            => 'menu',
	'allow_sub_menu'       => true,
	'menu_title'           => esc_html__( 'Theme Options', 'consultix' ),
	'page_title'           => esc_html__( 'Theme Options', 'consultix' ),
	'google_api_key'       => '',
	'google_update_weekly' => false,
	'async_typography'     => true,
	'admin_bar'            => true,
	'admin_bar_icon'       => 'dashicons-hammer',
	'admin_bar_priority'   => 50,
	'global_variable'      => '',
	'dev_mode'             => false,
	'update_notice'        => false,
	'customizer'           => true,
	'page_priority'        => 61,
	'page_parent'          => 'themes.php',
	'page_permissions'     => 'manage_options',
	'menu_icon'            => 'dashicons-hammer',
	'last_tab'             => '',
	'page_icon'            => 'icon-themes',
	'page_slug'            => '_options',
	'save_defaults'        => true,
	'default_show'         => false,
	'default_mark'         => '',
	'footer_credit'        => $theme->get( 'Name' ),
	'show_import_export'   => true,
	'show_options_object'  => false,
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	'output_tag'           => true,
	'database'             => '',
	'use_cdn'              => true,
	'ajax_save'            => true,
	'hints'                => array(
		'icon_position' => 'right',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color' => 'light',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'duration' => '500',
				'event'    => 'mouseleave unfocus',
			),
		),
	),
);
Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */

/*
 *
 * ---> START SECTIONS
 *
 */

/**
 * As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
 */

// -> START Basic Fields.
Redux::setSection(
	$opt_name, array(
		'title' => esc_html__( 'General', 'consultix' ),
		'icon'  => 'el el-cog',
		'id'    => 'theme-general',
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Color', 'consultix' ),
		'icon'       => 'el el-brush',
		'id'         => 'color',
		'subsection' => true,
		'fields'     => array(

			// color info.
			array(
				'id'    => 'info_color_scheme',
				'type'  => 'info',
				'title' => esc_html__( 'Color Options', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// Color Scheme.
			array(
				'id'       => 'color_scheme',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Select Theme Color', 'consultix' ),
				'subtitle' => esc_html__( 'You can select/choose from a list of preset theme colors. (Please Note: This will set preset color scheme on your theme. You can replace color(s) from each element settings.)', 'consultix' ),
				'options'  => array(
					'color-scheme-midnight-blue' => array(
						'alt' => esc_html__( 'Midnight Blue', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Midnight-Blue.png' ),
					),
					'color-scheme-yellow'         => array(
						'alt' => esc_html__( 'Yellow', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Yellow.png' ),
					),
					'color-scheme-green'         => array(
						'alt' => esc_html__( 'Green', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Green.png' ),
					),
					'color-scheme-pink'          => array(
						'alt' => esc_html__( 'Pink', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Pink.png' ),
					),
					'color-scheme-red'           => array(
						'alt' => esc_html__( 'Red', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Red.png' ),
					),
					'color-scheme-blue'          => array(
						'alt' => esc_html__( 'Blue', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Blue.png' ),
					),
					'color-scheme-spring-green'  => array(
						'alt' => esc_html__( 'Spring Green', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Spring-Green.png' ),
					),
					'color-scheme-orange'        => array(
						'alt' => esc_html__( 'Orange', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Orange.png' ),
					),
					'color-scheme-chocolate'        => array(
						'alt' => esc_html__( 'Chocolate', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Chocolate.png' ),
					),
					'color-scheme-purple'        => array(
						'alt' => esc_html__( 'Purple', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Purple.png' ),
					),
					'color-scheme-purple'        => array(
						'alt' => esc_html__( 'Light Blue', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Color-Scheme-Light-Blue.png' ),
					),
				),
				'default'  => 'color-scheme-midnight-blue',
			),

			// Radiant Body Background.
			array(
				'id'       => 'radiant_body_background',
				'type'     => 'background',
				'title'    => esc_html__( 'Body Background', 'consultix' ),
				'subtitle' => esc_html__( 'Choose a background for the theme. (Please Note: This option will not work, if you have selected background for a particular section.)', 'consultix' ),
				'default'  => array(
					'background-color'      => '#ffffff',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'inherit',
				),
				'output'   => array(
					'body',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'  => esc_html__( 'Logo and Favicon', 'consultix' ),
		'id'     => 'logo-favicon',
		'icon'   => 'el el-bookmark-empty',
		'subsection' => true,
		'fields' => array(

			// Logo Info.
			array(
				'id'    => 'info-logo-subheader',
				'type'  => 'info',
				'title' => esc_html__( 'LOGO', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// Upload Logo.
			array(
				'id'       => 'opt-logo-media',
				'type'     => 'media',
				'title'    => esc_html__( 'Logo', 'consultix' ),
				'subtitle' => esc_html__( 'You can upload logo on your website.', 'consultix' ),
			),

			// Upload Retina Logo.
			array(
				'id'       => 'opt-retina-logo-media',
				'type'     => 'media',
				'title'    => esc_html__( 'Retina Logo', 'consultix' ),
				'desc'     => esc_html__( 'Retina Logo should be 2x larger than Custom Logo', 'consultix' ),
				'subtitle' => esc_html__( 'Optional', 'consultix' ),
			),

			array(
				'id'    => 'info-icon-subheader',
				'type'  => 'info',
				'title' => esc_html__( 'ICON', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			array(
				'id'       => 'favicon',
				'type'     => 'media',
				'title'    => esc_html__( 'Favicon', 'consultix' ),
				'subtitle' => esc_html__( 'You can upload Favicon on your website. (.ico 32x32 pixels)', 'consultix' ),
				'default'  => array(
					'url' => get_template_directory_uri() . '/images/Consultix-Favicon-Default.ico',
				),
			),

			array(
				'id'    => 'apple-icon',
				'type'  => 'media',
				'title' => esc_html__( 'Apple Touch Icon', 'consultix' ),
				'desc'  => esc_html__( 'apple-touch-icon.png 180x180 pixels', 'consultix' ),
				'default'  => array(
					'url' => get_template_directory_uri() . '/images/Apple-Touch-Icon-180x180-Default.png',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'   => esc_html__( 'Fonts', 'consultix' ),
		'id'      => 'basic-settings',
		'icon'    => 'el el-fontsize',
		'subsection' => true,
		'fields'  => array(
			array(
				'id'             => 'general_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'General', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font of your website.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-style'     => true,
				'all_styles'     => true,
				'output'         => array( 'body' ),
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Open Sans',
					'font-weight' => '400',
					'font-size'   => '16px',
					'color'       => '#3f3f3f',
					'line-height' => '27px',
				),
			),

			array(
				'id'             => 'h1_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'H1', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font for all H1 tags of your website.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'font-weight'    => true,
				'font-style'     => true,
				'line-height'    => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-family'    => true,
				'color'          => true,
				'all_styles'     => false,
				'output'         => array( 'h1' ),
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '30px',
					'color'       => '#00174d',
					'line-height' => '40px',
				),
			),

			array(
				'id'             => 'h2_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'H2', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font for all H2 tags of your website.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'font-weight'    => true,
				'font-style'     => true,
				'line-height'    => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-family'    => true,
				'color'          => true,
				'all_styles'     => false,
				'output'         => array( 'h2' ),
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '26px',
					'color'       => '#00174d',
					'line-height' => '35px',
				),
			),

			array(
				'id'             => 'h3_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'H3', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font for all H3 tags of your website.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'font-weight'    => true,
				'font-style'     => true,
				'line-height'    => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-family'    => true,
				'color'          => true,
				'all_styles'     => false,
				'output'         => array( 'h3' ),
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '23px',
					'color'       => '#00174d',
					'line-height' => '35px',
				),
			),

			array(
				'id'             => 'h4_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'H4', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font for all H4 tags of your website.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'font-weight'    => true,
				'font-style'     => true,
				'line-height'    => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-family'    => true,
				'color'          => true,
				'all_styles'     => false,
				'output'         => array( 'h4' ),
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '22px',
					'color'       => '#00174d',
					'line-height' => '35px',
				),
			),

			array(
				'id'             => 'h5_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'H5', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font for all H5 tags of your website.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'font-weight'    => true,
				'font-style'     => true,
				'line-height'    => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-family'    => true,
				'color'          => true,
				'all_styles'     => false,
				'output'         => array( 'h5' ),
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '20px',
					'color'       => '#00174d',
					'line-height' => '30px',
				),
			),

			array(
				'id'             => 'h6_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'H6', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font for all H6 tags of your website.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'font-weight'    => true,
				'font-style'     => true,
				'line-height'    => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-family'    => true,
				'color'          => true,
				'all_styles'     => false,
				'output'         => array( 'h6' ),
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '14px',
					'color'       => '#00174d',
					'line-height' => '22px',
				),
			),
		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Custom Slug', 'consultix' ),
		'icon'       => 'el el-folder-open',
		'id'    	 => 'custom_slug',
		'subsection' => true,
		'fields'     => array(

			// color info.
			array(
				'id'    => 'info_change_slug',
				'type'  => 'info',
				'title' => esc_html__( 'Change Custom Post Type Slug', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),
			array(
				'id'       => 'change_slug_portfolio',
				'type'     => 'text',
				'title'    => esc_html__( 'Portfolio', 'consultix' ),
				'subtitle' => esc_html__( 'The slug name cannot be the same as a page name. Make sure to regenerate permalinks, after making changes.', 'consultix' ),
				'validate' => 'no_special_chars',
				'default'  => 'portfolio',
			),
			array(
				'id'       => 'change_slug_team',
				'type'     => 'text',
				'title'    => esc_html__( 'Team', 'consultix' ),
				'subtitle' => esc_html__( 'The slug name cannot be the same as a page name. Make sure to regenerate permalinks, after making changes.', 'consultix' ),
				'validate' => 'no_special_chars',
				'default'  => 'team',
			),
			array(
				'id'       => 'change_slug_casestudies',
				'type'     => 'text',
				'title'    => esc_html__( 'Case Study', 'consultix' ),
				'subtitle' => esc_html__( 'The slug name cannot be the same as a page name. Make sure to regenerate permalinks, after making changes.', 'consultix' ),
				'validate' => 'no_special_chars',
				'default'  => 'case-studies',
			),
		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Preloader', 'consultix' ),
		'icon'       => 'el el-hourglass',
		'id'    	 => 'preloader',
		'subsection' => true,
		'fields'     => array(

			// Preloader Info.
			array(
				'id'    => 'info_preloader',
				'type'  => 'info',
				'title' => esc_html__( 'Preloader Options', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// Preloader Switch.
			array(
				'id'       => 'preloader_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Activate Preloader', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if want to activate Preloader or not.', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => false,
			),

			// Preloader Style.
			array(
				'id'       => 'preloader_style',
				'type'     => 'select',
				'title'    => esc_html__( 'Preloader Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select Style of the Preloader. (Powered By: "SpinKit")', 'consultix' ),
				'options'  => array(
					'rotating-plane'  => 'Rotating Plane',
					'double-bounce'   => 'Double Bounce',
					'wave'            => 'Wave',
					'wandering-cubes' => 'Wandering Cubes',
					'pulse'           => 'Pulse',
					'chasing-dots'    => 'Chasing Dots',
					'three-bounce'    => 'Three Bounce',
					'circle'          => 'Circle',
					'cube-grid'       => 'Cube Grid',
					'fading-circle'   => 'Fading Circle',
					'folding-cube'    => 'Folding Cube',
				),
				'default'  => 'wave',
				'required' => array(
					array(
						'preloader_switch',
						'equals',
						true,
					),
				),
			),

			// Preloader Background Color.
			array(
				'id'       => 'preloader_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Preloader Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for the Preloader.', 'consultix' ),
				'default'  => array(
					'color' => '#f8f8f8',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.preloader',
				),
				'required' => array(
					array(
						'preloader_switch',
						'equals',
						true,
					),
				),
			),

			// Preloader Color.
			array(
				'id'       => 'preloader_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Preloader Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a color for the Preloader.', 'consultix' ),
				'default'  => array(
					'color' => '#010101',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.sk-rotating-plane, .sk-double-bounce .sk-child, .sk-wave .sk-rect, .sk-wandering-cubes .sk-cube, .sk-spinner-pulse, .sk-chasing-dots .sk-child, .sk-three-bounce .sk-child, .sk-circle .sk-child:before, .sk-circle .sk-child:before, .sk-cube-grid .sk-cube, .sk-fading-circle .sk-circle:before, .sk-folding-cube .sk-cube:before',
				),
				'required' => array(
					array(
						'preloader_switch',
						'equals',
						true,
					),
				),
			),

			// Preloader Timeout.
			array(
				'id'            => 'preloader_timeout',
				'type'          => 'slider',
				'title'         => esc_html__( 'Preloader Timeout', 'consultix' ),
				'subtitle'      => esc_html__( 'Select preloader timeout after successful page load. Min is 100ms, Max is 3000ms and Default is 500ms.', 'consultix' ),
				'min'           => 100,
				'step'          => 100,
				'max'           => 3000,
				'default'       => 500,
				'display_value' => 'text',
				'required'      => array(
					array(
						'preloader_switch',
						'equals',
						true,
					),
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Scroll To Top', 'consultix' ),
		'icon'       => 'el el-chevron-up',
		'id'    	 => 'scroll_to_top',
		'subsection' => true,
		'fields'     => array(

			// Scroll To Top Info.
			array(
				'id'    => 'info_scroll_to_top',
				'type'  => 'info',
				'title' => esc_html__( 'Scroll To Top Options', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// Scroll To Top Direction.
			array(
				'id'       => 'scroll_to_top_direction',
				'type'     => 'select',
				'title'    => esc_html__( 'Direction', 'consultix' ),
				'subtitle' => esc_html__( 'Select Direction of the Scroll To Top.', 'consultix' ),
				'options'  => array(
					'left'    => 'Left',
					'right'   => 'Right',
				),
				'default'  => 'left',
			),

			// Scroll To Top Background Color.
			array(
				'id'       => 'scroll_to_top_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for the Scroll To Top.', 'consultix' ),
				'output'   => array(
					'background-color' => '.scrollup',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'GDPR Notice', 'consultix' ),
		'icon'       => 'el el-exclamation-sign',
		'id'    	 => 'gdpr_notice',
		'subsection' => true,
		'fields'     => array(

			// GDPR Notice Info.
			array(
				'id'    => 'info_gdpr_notice',
				'type'  => 'info',
				'title' => esc_html__( 'GDPR Notice Options', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// GDPR Notice Switch.
			array(
				'id'       => 'gdpr_notice_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Activate GDPR Notice', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if want to activate GDPR Notice or not.', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => false,
			),

			// GDPR Notice Background Color.
			array(
				'id'       => 'gdpr_notice_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for the GDPR Notice.', 'consultix' ),
				'default'  => array(
					'color' => '#3b4354',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.gdpr-notice',
				),
				'required'      => array(
					array(
						'gdpr_notice_switch',
						'equals',
						true,
					),
				),
			),

			// GDPR Notice Typography.
			array(
				'id'             => 'gdpr_notice_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'GDPR Notice Typography', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font of GDPR Notice.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-style'     => true,
				'all_styles'     => false,
				'output'         => array(
				    '.gdpr-notice p'
				),
				'units'          => 'px',
				'default'        => array(
					'font-weight' => '400',
					'font-size'   => '15px',
					'color'       => '#ffffff',
					'line-height' => '28px',
				),
				'required'      => array(
					array(
						'gdpr_notice_switch',
						'equals',
						true,
					),
				),
			),

			// GDPR Notice Content.
			array(
				'id'       => 'gdpr_notice_content',
				'type'     => 'textarea',
				'title'    => esc_html__( 'GDPR Notice Content', 'consultix' ),
				'subtitle' => esc_html__( 'Enter content to show on GDPR Notice.', 'consultix' ),
				'default'  => "Our website use cookies to improve and personalize your experience and to display advertisements (if any). Our website may also include cookies from third parties like Google Adsense, Google Analytics, YouTube. By using this website, you consent to the use of cookies. We've updated our Privacy Policy, please click on the button beside to check our Privacy Policy.",
				'required'      => array(
					array(
						'gdpr_notice_switch',
						'equals',
						true,
					),
				),
			),

			// GDPR Notice Button Text.
			array(
				'id'       => 'gdpr_notice_button_text',
				'type'     => 'text',
				'title'    => esc_html__( 'GDPR Notice Button Text', 'consultix' ),
				'subtitle' => esc_html__( 'Enter Button Text for GDPR Notice button.', 'consultix' ),
				'default'  => 'Privacy Policy',
				'required'      => array(
					array(
						'gdpr_notice_switch',
						'equals',
						true,
					),
				),
			),

			// GDPR Notice Button Link.
			array(
				'id'       => 'gdpr_notice_button_link',
				'type'     => 'text',
				'title'    => esc_html__( 'GDPR Notice Button Link', 'consultix' ),
				'subtitle' => esc_html__( 'Enter Button Link for GDPR Notice button.', 'consultix' ),
				'default'  => '#',
				'required'      => array(
					array(
						'gdpr_notice_switch',
						'equals',
						true,
					),
				),
			),

			// GDPR Notice Remove Link.
			array(
			    'id'    => 'gdpr_notice_remove_link',
			    'type'  => 'info',
			    'style' => 'warning',
			    'desc'  => wp_kses_post( '<a href="' . esc_url( 'tools.php?page=remove_personal_data' ) . '" target="_blank">Click here</a> to forget a user.' ),
		    ),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title' => esc_html__( 'Header', 'consultix' ),
		'icon'  => 'el el-website',
		'id'    => 'header',
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'General', 'consultix' ),
		'icon'       => 'el el-cog-alt',
		'id'         => 'general',
		'subsection' => true,
		'fields'     => array(

			// Header Style Info.
			array(
				'id'    => 'info_header_style',
				'type'  => 'info',
				'title' => esc_html__( 'Header Style', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// Header Style Options.
			array(
				'id'       => 'header-style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Header Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select Header Style (Header will be changed as per selection || N.B.: Header "Style Nine" and "Style Ten" settings are defferent from all headers. For "Style Nine" and "Style Ten" scroll down and look for their respective settings below.).', 'consultix' ),
				'options'  => array(
					'header-style-default' => array(
						'alt'   => esc_html__( 'Default Style', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Default.png' ),
						'title' => esc_html__( 'Default Style', 'consultix' ),
					),
					'header-style-one'     => array(
						'alt'   => esc_html__( 'Style One', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-One.png' ),
						'title' => esc_html__( 'Style One', 'consultix' ),
					),
					'header-style-two'     => array(
						'alt'   => esc_html__( 'Style Two', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Two.png' ),
						'title' => esc_html__( 'Style Two', 'consultix' ),
					),
					'header-style-three'   => array(
						'alt'   => esc_html__( 'Style Three', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Three.png' ),
						'title' => esc_html__( 'Style Three', 'consultix' ),
					),
					'header-style-four'    => array(
						'alt'   => esc_html__( 'Style Four', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Four.png' ),
						'title' => esc_html__( 'Style Four', 'consultix' ),
					),
					'header-style-five'    => array(
						'alt'   => esc_html__( 'Style Five', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Five.png' ),
						'title' => esc_html__( 'Style Five', 'consultix' ),
					),
					'header-style-six'     => array(
						'alt'   => esc_html__( 'Style Six', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Six.png' ),
						'title' => esc_html__( 'Style Six', 'consultix' ),
					),
					'header-style-seven'   => array(
						'alt'   => esc_html__( 'Style Seven', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Seven.png' ),
						'title' => esc_html__( 'Style Seven', 'consultix' ),
					),
					'header-style-eight'   => array(
						'alt'   => esc_html__( 'Style Eight', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Eight.png' ),
						'title' => esc_html__( 'Style Eight', 'consultix' ),
					),
					'header-style-nine'   => array(
						'alt'   => esc_html__( 'Style Nine', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Nine.png' ),
						'title' => esc_html__( 'Style Nine', 'consultix' ),
					),
					'header-style-ten'   => array(
						'alt'   => esc_html__( 'Style Ten', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Header-Style-Ten.png' ),
						'title' => esc_html__( 'Style Ten', 'consultix' ),
					),
				),
				'default'  => 'header-style-default',
			),

			// Header Top Info.
			array(
				'id'    => 'info_header_top',
				'type'  => 'info',
				'title' => esc_html__( 'Header Top', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-two',
					),
					array(
						'header-style',
						'!=',
						'header-style-three',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
					array(
						'header-style',
						'!=',
						'header-style-seven',
					),
					array(
						'header-style',
						'!=',
						'header-style-eight',
					),
				),
			),

			// Header Top Bar Background Color.
			array(
				'id'       => 'header_top_bar_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Top Bar Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header top bar. (Applicable for Header "Style One", "Style Nine" and "Style Ten")', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-two',
					),
					array(
						'header-style',
						'!=',
						'header-style-three',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
					array(
						'header-style',
						'!=',
						'header-style-seven',
					),
					array(
						'header-style',
						'!=',
						'header-style-eight',
					),
				),
				'default'  => array(
					'color' => '#00174d',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-one .wraper_header_top, .wraper_header.style-three .wraper_header_top',
				),
			),

			// Header Cart Info.
			array(
				'id'    => 'info_cart_main',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Cart Settings', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
				),
			),
			// Choose cart.
			array(
				'id'       => 'header_cart_display',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display Cart Icon', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if you want "cart" icon in header or not.', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
				),
				'default'  => true,
			),
			// Header Main Info.
			array(
				'id'    => 'info_header_main',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Header Main', 'consultix' ),
			),

			// Header Main Background Color.
			array(
				'id'       => 'header_main_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Main Header Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for main header. (Applicable for Header Main section only. You can change any stuff inside with "Custom CSS")', 'consultix' ),
				'default'  => array(
					'color' => '#09276f',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-one .wraper_header_main, .wraper_header.style-two .wraper_header_main, .wraper_header.style-three .wraper_header_main, .wraper_header.style-four, .wraper_header.style-seven .wraper_header_main, .wraper_header.style-eight .wraper_header_main, #hamburger-menu, .wraper_flyout_menu',
				),
			),

			// Header Main Border Bottom Color.
			array(
				'id'       => 'header_main_border_botton_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Main Header Border Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for main header border. (Applicable for Header "Style Two")', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-one',
					),
					array(
						'header-style',
						'!=',
						'header-style-three',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
				),
				'default'  => array(
					'color' => '#ffffff',
					'alpha' => 0.2,
				),
				'output'   => array(
					'border-bottom-color' => '.wraper_header.style-two .wraper_header_main, .wraper_header.style-seven .wraper_header_main, .wraper_header.style-eight .wraper_header_main',
				),
			),

			// Header Menu Typography.
			array(
				'id'             => 'header_menu_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'Menu Typography', 'consultix' ),
				'subtitle'       => esc_html__( 'Typography options for Menu. (Please Note: If you are using Mega Menu for creating menus, then this option will not work. You have to set fonts from Mega Menu Plugin.)', 'consultix' ),
				'google'         => true,
				'font-backup'    => false,
				'subsets'        => false,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'color'          => true,
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Poppins',
					'font-weight' => '400',
					'font-size'   => '16px',
					'color'       => '#ffffff',
					'line-height' => '25px',
				),
				'output'         => array(
					'.wraper_header:not(.style-four):not(.style-five):not(.style-six):not(.style-nine):not(.style-ten) .nav',
				),
				'required'       => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
				),
			),
			// Header Three Top Social Text.
			array(
				'id'       => 'header_three_header_top_social_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Social Icon Text', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Three" only.', 'consultix' ),
				'default'  => esc_html__( 'Follow Us:', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'=',
						'header-style-three',
					),
				),

			),
			// Header Menu Item Hover/Selected Color.
			array(
				'id'       => 'header_menu_hover_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Menu Hover/Selected Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for all menu items. (Please Note: If you are using Mega Menu for creating menus, then this option will not work. You have to set hover/selected color from Mega Menu Plugin.)', 'consultix' ),
				'validate' => 'color',
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
				),
				'output'   => array(
					'.wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li:hover > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li.current-menu-item > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li.current-menu-parent > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li.current-menu-ancestor > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li:hover > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li.current-menu-item > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li.current-menu-parent > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li:hover > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li.current-menu-item > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li.current-menu-parent > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li > ul > li:hover > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li > ul > li.current-menu-item > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li > ul > li.current-menu-parent > a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li > ul > li ul li:hover a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li > ul > li ul li.current-menu-item a, .wraper_header:not(.style-four) .nav > [class*="menu-"] > ul.menu > li > ul > li > ul > li > ul > li ul li.current-menu-parent a',
				),
			),

			// Header Style Three Nav Bar Info.
			array(
				'id'       => 'info_header_nav_bar',
				'type'     => 'info',
				'style'    => 'custom',
				'color'    => '#b9cbe4',
				'class'    => 'radiant-subheader',
				'title'    => esc_html__( 'Header Nav Bar', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'equals',
						'header-style-three',
					),
				),
			),

			// Header Nav Bar Background Color.
			array(
				'id'       => 'header_av_bar_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Nav Bar Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header nav bar', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'equals',
						'header-style-three',
					),
				),
				'default'  => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-three .wraper_header_nav',
				),
			),

			// Header Mobile Menu Info.
			array(
				'id'       => 'header_mobile_info',
				'type'     => 'info',
				'style'    => 'custom',
				'color'    => '#b9cbe4',
				'class'    => 'radiant-subheader',
				'title'    => esc_html__( 'Mobile Menu Settings', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
				),
			),

			// Select Header Mobile Menu Displace.
			array(
				'id'       => 'header_mobile_menu_displace',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Mobile Menu Displace', 'consultix' ),
				'subtitle' => esc_html__( 'Select the Mobile Menu displace for mobile menu', 'consultix' ),
				'options'  => array(
					'true'  => 'Yes',
					'false' => 'No',
				),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
				),
				'default'  => 'true',
			),

			// Header Sticky Info.
			array(
				'id'       => 'header_sticky_info',
				'type'     => 'info',
				'style'    => 'custom',
				'color'    => '#b9cbe4',
				'class'    => 'radiant-subheader',
				'title'    => esc_html__( 'Sticky Settings', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-two',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
					array(
						'header-style',
						'!=',
						'header-style-seven',
					),
					array(
						'header-style',
						'!=',
						'header-style-eight',
					),
				),
			),

			// Choose Header Menu Sticky.
			array(
				'id'       => 'header_sticky_choose',
				'type'     => 'switch',
				'title'    => esc_html__( 'Sticky Header Menu', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if you want the Header Menu to be "Sticky" or not. (Applicable for Header "Style One", "Style Two", "Style Three", "Style Six", "Style Seven" "Style Eight", "Style Nine" and "Style Ten")', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
					array(
						'header-style',
						'!=',
						'header-style-five',
					),
				),
				'default'  => true,
			),

			// Header Search Info.
			array(
				'id'       => 'header_search_info',
				'type'     => 'info',
				'style'    => 'custom',
				'color'    => '#b9cbe4',
				'class'    => 'radiant-subheader',
				'title'    => esc_html__( 'Search Settings', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
				),
			),

			// Choose Search.
			array(
				'id'       => 'header_search_display',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display Search', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if you want "Search" option in header or not.', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-four',
					),
				),
				'default'  => false,
			),

			// Select Search Style.
			array(
				'id'       => 'header_search_style',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Search Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select Style of the "Search".', 'consultix' ),
				'options'  => array(
					'floating-search' => 'Floating Search',
					'flyout-search'   => 'Flyout Search',
				),
				'default'  => 'floating-search',
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-three',
					),
					array(
						'header_search_display',
						'equals',
						true,
					),
				),
			),

			// Choose Search Background Color.
			array(
				'id'       => 'header_search_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Choose Search Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies only for "Flyout Search".', 'consultix' ),
				'required' => array(
					array(
						'header_search_style',
						'equals',
						'flyout-search',
					),
				),
				'default'  => array(
					'color' => '#270d44',
					'alpha' => 0.96,
				),
				'output'   => array(
					'background-color' => '.wraper_flyout_search',
				),
			),

			// Header Contact Information.
			array(
				'id'       => 'info_header_top_bar',
				'type'     => 'info',
				'style'    => 'custom',
				'title'    => esc_html__( 'Header Contact Information', 'consultix' ),
				'color'    => '#b9cbe4',
				'class'    => 'radiant-subheader',
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-two',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
					array(
						'header-style',
						'!=',
						'header-style-seven',
					),
					array(
						'header-style',
						'!=',
						'header-style-eight',
					),
				),
			),

			// Enter Email ID.
			array(
				'id'       => 'top_bar_email',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Email ID', 'consultix' ),
				'default'  => esc_html__( 'info@example.com', 'consultix' ),
				'validate' => 'email',
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-two',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
					array(
						'header-style',
						'!=',
						'header-style-seven',
					),
					array(
						'header-style',
						'!=',
						'header-style-eight',
					),
				),
			),

			// Enter Contact Info.
			array(
				'id' => 'top_bar_contact',
				'type' => 'text',
				'title' => esc_html__( 'Enter Contact Info', 'consultix' ),
				'default' => esc_html__( 'Need Help? Talk to an Expert', 'consultix' ),
				'required' => array(
				 array(
						'header-style',
						'=',
						'header-style-three',
					),
				),
			),

			// Enter Phone Number.
			array(
				'id'       => 'top_bar_phone',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Phone Number', 'consultix' ),
				'default'  => esc_html__( '888-123-4567', 'consultix' ),
				'required' => array(
					array(
						'header-style',
						'!=',
						'header-style-default',
					),
					array(
						'header-style',
						'!=',
						'header-style-two',
					),
					array(
						'header-style',
						'!=',
						'header-style-six',
					),
					array(
						'header-style',
						'!=',
						'header-style-seven',
					),
					array(
						'header-style',
						'!=',
						'header-style-eight',
					),
				),
			),

			/* ============================= */
			// START OF HEADER NINE OPTIONS
			/* ============================= */

			// Header Nine Info.
			array(
				'id'    => 'header_nine_info',
				'type'  => 'info',
				'title' => esc_html__( 'Header Nine Settings', 'consultix' ),
				'class' => 'radiant-subheader enable-toggle',
			),

			// Header Nine Box Shadow.
			array(
				'id'       => 'header_nine_box_shadow',
				'type'     => 'box_shadow',
				'title'    => esc_html__( 'Header Box Shadow', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Nine" only.', 'consultix' ),
				'units'    => array( 'px', 'em' ),
				'opacity'  => true,
				'rgba'     => true,
				'default'  => array(
					'horizontal'   => '0',
					'vertical'     => '0',
					'blur'         => '27px',
					'spread'       => '0',
					'opacity'      => '0.22',
					'shadow-color' => '#050606',
					'shadow-type'  => 'outside',
					'units'        => 'px',
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-nine',
				),
			),

			// Header Nine Header Top Background Color.
			array(
				'id'       => 'header_nine_header_top_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Top Bar Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Nine" only.', 'consultix' ),
				'default'  => array(
					'color' => '#001a57',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-nine .wraper_header_top',
				),
			),

			// Header Nine Header Top Contact Text.
			array(
				'id'       => 'header_nine_header_top_contact_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Contact Text', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Nine" only.', 'consultix' ),
				'default'  => esc_html__( 'Need Help? Talk to an Expert', 'consultix' ),
			),

			// Header Nine Header Top Contact Phone.
			array(
				'id'       => 'header_nine_header_top_contact_phone',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Phone Number', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Nine" only.', 'consultix' ),
				'default'  => esc_html__( '888-123-4567', 'consultix' ),
			),

			// Header Nine Logo.
			array(
				'id'       => 'header_nine_logo',
				'type'     => 'media',
				'title'    => esc_html__( 'Logo', 'consultix' ),
				'subtitle' => esc_html__( 'You can upload logo on your website. (Applies for header "Style Nine" only.)', 'consultix' ),
			),

			// Header Nine Retina Logo.
			array(
				'id'       => 'header_nine_retina_logo',
				'type'     => 'media',
				'title'    => esc_html__( 'Retina Logo', 'consultix' ),
				'subtitle' => esc_html__( 'Retina Logo should be 2x larger than original Logo. (Applies for header "Style Nine" only.)', 'consultix' ),
			),

			// Header Nine Header Main Background Color.
			array(
				'id'       => 'header_nine_header_main_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Main Header Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for main header. (Applies for header "Style Nine" only)', 'consultix' ),
				'default'  => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-nine .wraper_header_main',
				),
			),

			// Header Nine Menu Typography.
			array(
				'id'             => 'header_nine_menu_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'Menu Typography', 'consultix' ),
				'subtitle'       => esc_html__( 'Typography options for Menu. (Applies for header "Style Nine" only)', 'consultix' ),
				'google'         => true,
				'font-backup'    => false,
				'subsets'        => false,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'color'          => true,
				'units'          => 'px',
				'default'        => array(
					'google'         => true,
					'text-transform' => 'uppercase',
					'font-family'    => 'Rubik',
					'font-weight'    => '400',
					'font-size'      => '13px',
					'color'          => '#4d4d4d',
					'line-height'    => '25px',
				),
				'output'         => array(
					'.wraper_header.style-nine .nav',
				),
			),

			// Header Nine Menu Item Hover/Selected Color.
			array(
				'id'       => 'header_nine_menu_hover_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Menu Hover/Selected Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for all menu items. (Applies for header "Style Nine" only)', 'consultix' ),
				'validate' => 'color',
				'default'  => '#08276e',
				'output'   => array(
					'.wraper_header.style-nine .nav > [class*="menu-"] > ul.menu > li:hover > a, .wraper_header.style-nine .nav > [class*="menu-"] > ul.menu > li.current-menu-item > a, .wraper_header.style-nine .nav > [class*="menu-"] > ul.menu > li.current-menu-parent > a, .wraper_header.style-nine .nav > [class*="menu-"] > ul.menu > li.current-menu-ancestor > a',
				),
			),

			// Header Nine Search Display.
			array(
				'id'       => 'header_nine_search_display',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display Search', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if you want "Search" option in header or not. (Applies for header "Style Nine" only)', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => true,
			),

			// Header Nine Search Style.
			array(
				'id'       => 'header_nine_search_style',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Search Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select Style of the "Search". (Applies for header "Style Nine" only)', 'consultix' ),
				'options'  => array(
					'floating-search' => 'Floating Search',
					'flyout-search'   => 'Flyout Search',
				),
				'default'  => 'floating-search',
				'required' => array(
					array(
						'header_nine_search_display',
						'equals',
						true,
					),
				),
			),
			// Header Nine Header Top Social Text.
			array(
				'id'       => 'header_nine_header_top_social_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Social Icon Text', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Nine" only.', 'consultix' ),
				'default'  => esc_html__( 'Follow Us:', 'consultix' ),
			),
			// Header Nine Search Background Color.
			array(
				'id'       => 'header_nine_search_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Choose Search Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies only for "Flyout Search". (Applies for header "Style Nine" only)', 'consultix' ),
				'required' => array(
					array(
						'header_nine_search_style',
						'equals',
						'flyout-search',
					),
				),
				'default'  => array(
					'color' => '#270d44',
					'alpha' => 0.96,
				),
				'output'   => array(
					'background-color' => '.wraper_flyout_search',
				),
			),

			// Header Nine Mobile Menu Displace.
			array(
				'id'       => 'header_nine_mobile_menu_displace',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Mobile Menu Displace', 'consultix' ),
				'subtitle' => esc_html__( 'Select the Mobile Menu displace for mobile menu. (Applies for header "Style Nine" only)', 'consultix' ),
				'options'  => array(
					'true'  => 'Yes',
					'false' => 'No',
				),
				'default'  => 'true',
			),

			// Header Nine Callback Button Display.
			array(
				'id'       => 'header_nine_callback_button_display',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display "Callback" Button', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if the "Callback" button will be displayed or not. (Applies for header "Style Nine" only)', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => false,
			),

			// Header Nine Callback Button Text.
			array(
				'id'       => 'header_nine_callback_button_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Display "Callback" Button Label', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Nine" only.', 'consultix' ),
				'default'  => esc_html__( 'Schedule Callback', 'consultix' ),
				'required' => array(
					array(
						'header_nine_callback_button_display',
						'equals',
						true,
					),
				),
			),

			// Header Nine Callback Button Link.
			array(
				'id'       => 'header_nine_callback_button_link',
				'type'     => 'text',
				'title'    => esc_html__( 'Display "Callback" Button Link', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Nine" only.', 'consultix' ),
				'default'  => esc_url( '#', 'consultix' ),
				'required' => array(
					array(
						'header_nine_callback_button_display',
						'equals',
						true,
					),
				),
			),

			/* ============================= */
			// END OF HEADER NINE OPTIONS
			/* ============================= */

			/* ============================= */
			// START OF HEADER TEN OPTIONS
			/* ============================= */

			// Header Ten Info.
			array(
				'id'    => 'header_ten_info',
				'type'  => 'info',
				'title' => esc_html__( 'Header Ten Settings', 'consultix' ),
				'class' => 'radiant-subheader enable-toggle',
			),

			// Header Ten Header Top Background Color.
			array(
				'id'       => 'header_ten_header_top_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Top Bar Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Ten" only.', 'consultix' ),
				'default'  => array(
					'color' => '#0e0d0d',
					'alpha' => 0.4,
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-ten .wraper_header_top',
				),
			),

			// Header Ten Header Top Contact Email.
			array(
				'id'       => 'header_ten_header_top_contact_email',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Email', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Ten" only.', 'consultix' ),
				'default'  => esc_html__( 'info@example.com', 'consultix' ),
			),

			// Header Ten Header Top Contact Phone.
			array(
				'id'       => 'header_ten_header_top_contact_phone',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Phone Number', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Ten" only.', 'consultix' ),
				'default'  => esc_html__( '888-123-4587', 'consultix' ),
			),

			// Header Ten Header Top Social Text.
			array(
				'id'       => 'header_ten_header_top_social_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Enter Social Icon Text', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for header "Style Ten" only.', 'consultix' ),
				'default'  => esc_html__( 'Stay Connected:', 'consultix' ),
			),

			// Header Ten Header Main Background Color.
			array(
				'id'       => 'header_ten_header_main_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Main Header Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for main header. (Applies for header "Style Ten" only)', 'consultix' ),
				'default'  => array(
					'color' => '#000000',
					'alpha' => 0.01,
				),
				'output'   => array(
					'background-color' => '.wraper_header.style-ten .wraper_header_main',
				),
			),

			// Header Ten Logo.
			array(
				'id'       => 'header_ten_logo',
				'type'     => 'media',
				'title'    => esc_html__( 'Logo', 'consultix' ),
				'subtitle' => esc_html__( 'You can upload logo on your website. (Applies for header "Style Ten" only.)', 'consultix' ),
			),

			// Header Ten Retina Logo.
			array(
				'id'       => 'header_ten_retina_logo',
				'type'     => 'media',
				'title'    => esc_html__( 'Retina Logo', 'consultix' ),
				'subtitle' => esc_html__( 'Retina Logo should be 2x larger than original Logo. (Applies for header "Style Ten" only.)', 'consultix' ),
			),

			// Header Ten Menu Typography.
			array(
				'id'             => 'header_ten_menu_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'Menu Typography', 'consultix' ),
				'subtitle'       => esc_html__( 'Typography options for Menu. (Applies for header "Style Ten" only)', 'consultix' ),
				'google'         => true,
				'font-backup'    => false,
				'subsets'        => false,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'color'          => true,
				'units'          => 'px',
				'default'        => array(
					'google'         => true,
					'text-transform' => 'uppercase',
					'font-family'    => 'Lato',
					'font-weight'    => '700',
					'font-size'      => '15px',
					'color'          => '#ffffff',
					'line-height'    => '25px',
				),
				'output'         => array(
					'.wraper_header.style-ten .nav',
				),
			),

			// Header Ten Menu Item Hover/Selected Color.
			array(
				'id'       => 'header_ten_menu_hover_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Menu Hover/Selected Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies for all menu items. (Applies for header "Style Ten" only)', 'consultix' ),
				'validate' => 'color',
				'default'  => '#ffffff',
				'output'   => array(
					'.wraper_header.style-ten .nav > [class*="menu-"] > ul.menu > li:hover > a, .wraper_header.style-ten .nav > [class*="menu-"] > ul.menu > li.current-menu-item > a, .wraper_header.style-ten .nav > [class*="menu-"] > ul.menu > li.current-menu-parent > a, .wraper_header.style-ten .nav > [class*="menu-"] > ul.menu > li.current-menu-ancestor > a',
				),
			),

			// Header Ten Search Display.
			array(
				'id'       => 'header_ten_search_display',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display Search', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if you want "Search" option in header or not. (Applies for header "Style Ten" only)', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => true,
			),

			// Header Ten Search Style.
			array(
				'id'       => 'header_ten_search_style',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Search Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select Style of the "Search". (Applies for header "Style Ten" only)', 'consultix' ),
				'options'  => array(
					'floating-search' => 'Floating Search',
					'flyout-search'   => 'Flyout Search',
				),
				'default'  => 'floating-search',
				'required' => array(
					array(
						'header_ten_search_display',
						'equals',
						true,
					),
				),
			),

			// Header Ten Search Background Color.
			array(
				'id'       => 'header_ten_search_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Choose Search Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies only for "Flyout Search". (Applies for header "Style Ten" only)', 'consultix' ),
				'required' => array(
					array(
						'header_ten_search_style',
						'equals',
						'flyout-search',
					),
				),
				'default'  => array(
					'color' => '#270d44',
					'alpha' => 0.96,
				),
				'output'   => array(
					'background-color' => '.wraper_flyout_search',
				),
			),

			// Header Ten Mobile Menu Displace.
			array(
				'id'       => 'header_ten_mobile_menu_displace',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Mobile Menu Displace', 'consultix' ),
				'subtitle' => esc_html__( 'Select the Mobile Menu displace for mobile menu. (Applies for header "Style Ten" only)', 'consultix' ),
				'options'  => array(
					'true'  => 'Yes',
					'false' => 'No',
				),
				'default'  => 'true',
			),

			/* ============================= */
			// END OF HEADER TEN OPTIONS
			/* ============================= */

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Short Header', 'consultix' ),
		'icon'       => 'el el-website',
		'id'         => 'inner_page_banner',
		'subsection' => true,
		'fields'     => array(

			// Short Header Style Options.
			array(
				'id'       => 'short-header',
				'type'     => 'image_select',
				//'class' => 'radiant-subheader',
				'title'    => esc_html__( 'Select Short Header', 'consultix' ),
				//'subtitle' => esc_html__( '', 'consultix' ),
				'options'  => array(
					'Banner-With-Breadcrumb'     => array(
						'alt'   => esc_html__( 'Banner-With-Breadcrumb', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/banners/Banner-With-Breadcrumb.png' ),
						'title' => esc_html__( 'Banner & Breadcrumb', 'consultix' ),
					),
					'Banner-only'     => array(
						'alt'   => esc_html__( 'Banner Only', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/banners/Banner-Only.png' ),
						'title' => esc_html__( 'Banner Only', 'consultix' ),
					),
					'breadcrumb-only' => array(
						'alt'   => esc_html__( 'Breadcrumb-Only', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/banners/Breadcrumb-Only.png' ),
						'title' => esc_html__( 'Breadcrumb Only', 'consultix' ),
					),
					'banner-none'   => array(
						'alt'   => esc_html__( 'Banner None', 'consultix' ),
						'img'   => get_parent_theme_file_uri( '/inc/redux-framework/css/img/banners/Banner-None.png' ),
						'title' => esc_html__( 'Banner None', 'consultix' ),
					),

				),
					'default'  => 'Banner-With-Breadcrumb',
			),
			// Inner Page Banner Info.
			array(
				'id'    => 'inner_page_banner_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Inner Page Banner', 'consultix' ),
			),

			// Inner Page Banner Background.
			array(
				'id'       => 'inner_page_banner_background',
				'type'     => 'background',
				'title'    => esc_html__( 'Inner Page Banner Background', 'consultix' ),
				'subtitle' => esc_html__( 'Set Background for Inner Page Banner. (Please Note: This is the default image of Inner Page Banner section. You can change background image on respective pages.)', 'consultix' ),
				'default'  => array(
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'inherit',
				),
				'output'   => array(
					'.wraper_inner_banner',
				),
			),

			// Inner Page Banner Border Bottom.
			array(
				'id'       => 'inner_page_banner_border_bottom',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Inner Page Banner Border Bottom', 'consultix' ),
				'subtitle' => esc_html__( 'Set Border Bottom for Inner Page Banner.', 'consultix' ),
				'default'  => array(
					'color' => '#ffffff',
					'alpha' => 0.1,
				),
				'output'   => array(
					'border-bottom-color' => '.wraper_inner_banner_main',
				),
			),

			// Inner Page Banner Padding.
			array(
				'id'             => 'inner_page_banner_padding',
				'type'           => 'spacing',
				'units'          => array( 'em', 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Inner Page Banner Padding', 'consultix' ),
				'subtitle'       => esc_html__( 'Set padding for inner page banner area.', 'consultix' ),
				'all'            => false,
				'top'            => true,
				'right'          => false,
				'bottom'         => true,
				'left'           => false,
				'default'        => array(
					'padding-top'    => '26px',
					'padding-bottom' => '30px',
					'units'          => 'px',
				),
				'output'         => array(
					'.wraper_inner_banner_main > .container',
				),
			),

			// Inner Page Banner Title Font.
			array(
				'id'             => 'inner_page_banner_title_font',
				'type'           => 'typography',
				'title'          => esc_html__( 'Inner Page Banner Title Font', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font of your inner page banner title.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-style'     => true,
				'all_styles'     => true,
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '700',
					'font-size'   => '45px',
					'color'       => '#ffffff',
					'line-height' => '55px',
				),
				'output'         => array(
					'.inner_banner_main .title',
				),
			),

			// Inner Page Banner Subtitle Font.
			array(
				'id'             => 'inner_page_banner_subtitle_font',
				'type'           => 'typography',
				'title'          => esc_html__( 'Inner Page Banner Subtitle Font', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font of your inner page banner subtitle.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-style'     => true,
				'all_styles'     => true,
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '600',
					'font-size'   => '18px',
					'color'       => '#ffffff',
					'line-height' => '26px',
				),
				'output'         => array(
					'.inner_banner_main .subtitle',
				),
			),

			// Inner Page Banner Alignment.
			array(
				'id'      => 'inner_page_banner_alignment',
				'type'    => 'select',
				'title'   => esc_html__( 'Inner Page Banner Alignment', 'consultix' ),
				'options' => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				),
				'default' => 'left',
			),

			// Breadcrumb Style Info.
			array(
				'id'    => 'breadcrumb_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Breadcrumb', 'consultix' ),
			),

			// Breadcrumb Arrow Style.
			array(
				'id'       => 'breadcrumb_arrow_style',
				'type'     => 'select',
				'title'    => __( 'Breadcrumb Arrow Style', 'consultix' ),
				'subtitle' => __( 'Select an icon for breadcrumb arrow.', 'consultix' ),
				'data'     => 'elusive-icons',
				'default'  => 'el el-chevron-right',
			),

			// Breadcrumb Font.
			array(
				'id'             => 'breadcrumb_font',
				'type'           => 'typography',
				'title'          => esc_html__( 'Inner Page Banner Breadcrumb Font', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font of your Inner Page Banner Breadcrumb.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-style'     => true,
				'all_styles'     => true,
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '16px',
					'color'       => '#ffffff',
					'line-height' => '26px',
				),
				'output'         => array(
					'.inner_banner_breadcrumb #crumbs',
				),
			),

			// Breadcrumb Padding.
			array(
				'id'             => 'breadcrumb_padding',
				'type'           => 'spacing',
				'units'          => array( 'em', 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Breadcrumb Padding', 'consultix' ),
				'subtitle'       => esc_html__( 'Set padding for breadcrumb area.', 'consultix' ),
				'all'            => false,
				'top'            => true,
				'right'          => false,
				'bottom'         => true,
				'left'           => false,
				'default'        => array(
					'padding-top'    => '10px',
					'padding-bottom' => '10px',
					'units'          => 'px',
				),
				'output'         => array(
					'.wraper_inner_banner_breadcrumb > .container',
				),
			),

			// Breadcrumb Alignment.
			array(
				'id'      => 'breadcrumb_alignment',
				'type'    => 'select',
				'title'   => esc_html__( 'Breadcrumb Alignment', 'consultix' ),
				'options' => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				),
				'default' => 'left',
			),

		),
	)
);

/*Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Breadcrumb', 'consultix' ),
		'icon'       => 'el el-resize-horizontal',
		'id'         => 'breadcrumb',
		'subsection' => true,
		'fields'     => array(

			// Breadcrumb Style Info.
			array(
				'id'    => 'breadcrumb_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Breadcrumb', 'consultix' ),
			),

			// Breadcrumb Arrow Style.
			array(
				'id'       => 'breadcrumb_arrow_style',
				'type'     => 'select',
				'title'    => __( 'Breadcrumb Arrow Style', 'consultix' ),
				'subtitle' => __( 'Select an icon for breadcrumb arrow.', 'consultix' ),
				'data'     => 'elusive-icons',
				'default'  => 'el el-chevron-right',
			),

			// Breadcrumb Font.
			array(
				'id'             => 'breadcrumb_font',
				'type'           => 'typography',
				'title'          => esc_html__( 'Inner Page Banner Breadcrumb Font', 'consultix' ),
				'subtitle'       => esc_html__( 'This will be the default font of your Inner Page Banner Breadcrumb.', 'consultix' ),
				'google'         => true,
				'font-backup'    => true,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'font-style'     => true,
				'all_styles'     => true,
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Montserrat',
					'font-weight' => '400',
					'font-size'   => '16px',
					'color'       => '#ffffff',
					'line-height' => '26px',
				),
				'output'         => array(
					'.inner_banner_breadcrumb #crumbs',
				),
			),

			// Breadcrumb Padding.
			array(
				'id'             => 'breadcrumb_padding',
				'type'           => 'spacing',
				'units'          => array( 'em', 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Breadcrumb Padding', 'consultix' ),
				'subtitle'       => esc_html__( 'Set padding for breadcrumb area.', 'consultix' ),
				'all'            => false,
				'top'            => true,
				'right'          => false,
				'bottom'         => true,
				'left'           => false,
				'default'        => array(
					'padding-top'    => '10px',
					'padding-bottom' => '10px',
					'units'          => 'px',
				),
				'output'         => array(
					'.wraper_inner_banner_breadcrumb > .container',
				),
			),

			// Breadcrumb Alignment.
			array(
				'id'      => 'breadcrumb_alignment',
				'type'    => 'select',
				'title'   => esc_html__( 'Breadcrumb Alignment', 'consultix' ),
				'options' => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				),
				'default' => 'left',
			),
		),
	)
);*/

Redux::setSection(
	$opt_name, array(
		'title'  => esc_html__( 'Footer', 'consultix' ),
		'icon'   => 'el el-photo',
		'id'     => 'footer',
		'fields' => array(

			// Footer Style Info.
			array(
				'id'    => 'footer_style_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Footer Style', 'consultix' ),
			),

			// Footer Style Options.
			array(
				'id'       => 'footer-style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Footer Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select footer style', 'consultix' ),
				'options'  => array(
					'footer-style-one' => array(
						'alt' => esc_html__( 'Style One', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-One.png' ),
					),
					'footer-style-two' => array(
						'alt' => esc_html__( 'Style Two', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Two.png' ),
					),
					'footer-style-three' => array(
						'alt' => esc_html__( 'Style Three', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Three.jpg' ),
					),
					'footer-style-four' => array(
						'alt' => esc_html__( 'Style Four', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Four.jpg' ),
					),
					'footer-style-five' => array(
						'alt' => esc_html__( 'Style Five', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Five.png' ),
					),
					'footer-style-six' => array(
						'alt' => esc_html__( 'Style Six', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Six.png' ),
					),
					'footer-style-seven' => array(
						'alt' => esc_html__( 'Style Seven', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Seven.png' ),
					),
					'footer-style-eight' => array(
						'alt' => esc_html__( 'Style Eight', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Eight.png' ),
					),
					'footer-style-nine' => array(
						'alt' => esc_html__( 'Style Nine', 'consultix' ),
						'img' => get_parent_theme_file_uri( '/inc/redux-framework/css/img/Footer-Style-Nine.png' ),
					),
				),
				'default'  => 'footer-style-one',
			),

			// Footer Background.
			array(
				'id'       => 'footer-style-background',
				'type'     => 'background',
				'title'    => esc_html__( 'Footer Background', 'consultix' ),
				'subtitle' => esc_html__( 'Set Background for Footer.', 'consultix' ),
				'default'  => array(
					'background-color' => '#161616',
				),
				'output'   => array(
					'.wraper_footer',
				),
			),

			// Footer Navigation Info.
			array(
				'id'       => 'footer_navigation_info',
				'type'     => 'info',
				'style'    => 'custom',
				'color'    => '#b9cbe4',
				'class'    => 'radiant-subheader',
				'title'    => esc_html__( 'Footer Navigation', 'consultix' ),
				'required' => array(
					array(
						'footer-style',
						'!=',
						'footer-style-one',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-two',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-three',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-six',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-seven',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-eight',
					),
				),
			),

			// Footer Navigation Background Color.
			array(
				'id'       => 'footer_navigation_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for the Footer Navigation.', 'consultix' ),
				'required' => array(
					array(
						'footer-style',
						'!=',
						'footer-style-one',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-two',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-three',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-six',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-seven',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-eight',
					),
				),
				'default'  => array(
					'color' => '#00174d',
					'alpha' => 0.01,
				),
				'output'   => array(
					'background-color' => '.wraper_footer_navigation',
				),
			),

			// Footer Main Info.
			array(
				'id'    => 'footer_main_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Footer Widget Block', 'consultix' ),
			),

			// Footer Main Background Color.
			array(
				'id'       => 'footer_main_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for the Footer Main Section.', 'consultix' ),
				'default'  => array(
					'color' => '#00174d',
					'alpha' => 0.01,
				),
				'output'   => array(
					'background-color' => '.wraper_footer_main',
				),
			),

			// Footer Main Bottom Border.
			array(
				'id'       => 'footer_main_border_bottom',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Border Bottom Color', 'consultix' ),
				'subtitle' => esc_html__( 'Set Border Bottom Color for Footer Main section.', 'consultix' ),
				'default'  => array(
					'color' => '#fff',
					'alpha' => 0.01,
				),
				'output'   => array(
					'border-bottom-color' => '.wraper_footer_main',
				),
			),

			// Footer Menu Info.
			array(
				'id'    => 'footer_copyright_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Footer Copyright Block', 'consultix' ),
			),

			// Footer Copyright Background Color.
			array(
				'id'       => 'footer_copyright_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for the Footer Copyright Background.', 'consultix' ),
				'default'  => array(
					'color' => '#00174d',
					'alpha' => 0.01,
				),
				'output'   => array(
					'background-color' => '.wraper_footer_copyright',
				),
			),

			// Footer Copyright Bar.
			array(
				'id'       => 'footer_copyright_bar',
				'type'     => 'text',
				'title'    => esc_html__( 'Copyright Text', 'consultix' ),
				'subtitle' => esc_html__( 'Enter Copyright Text', 'consultix' ),
				'default'  => esc_html__( 'Consultix 2018', 'consultix' ),
			),

			// Footer Contact Info.
			array(
				'id'    => 'footer_contact_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Footer Contact Section', 'consultix' ),
				'required' => array(
					array(
						'footer-style',
						'!=',
						'footer-style-one',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-two',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-three',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-four',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-five',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-six',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-seven',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-nine',
					),
				),
			),

			// Footer Copyright Bar.
			array(
				'id'       => 'footer_contact_address',
				'type'     => 'text',
				'title'    => esc_html__( 'Address', 'consultix' ),
				'subtitle' => esc_html__( 'Enter Address', 'consultix' ),
				'default'  => esc_html__( '123, XYZ Road, Collins Avn., New York', 'consultix' ),
				'required' => array(
					array(
						'footer-style',
						'!=',
						'footer-style-one',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-two',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-three',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-four',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-five',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-six',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-seven',
					),
					array(
						'footer-style',
						'!=',
						'footer-style-nine',
					),
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title' => esc_html__( 'Elements', 'consultix' ),
		'icon'  => 'el el-braille',
		'id'    => 'elements',
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Scroll Bar', 'consultix' ),
		'id'         => 'scroll_bar',
		'icon'       => 'el el-adjust-alt',
		'subsection' => true,
		'fields'     => array(

			// Display Footer Main Section.
			array(
				'id'       => 'scrollbar_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Active Custom Scrollbar', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if Custom Scrollbar will be activate or not. (Please Note: This will take effect on infinity scroll areas but not for entire website.)', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => false,
			),

			// Scroll Bar Color.
			array(
				'id'       => 'scrollbar_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Scroll Bar Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a color for Scroll Bar.', 'consultix' ),
				'required' => array(
					array(
						'scrollbar_switch',
						'equals',
						true,
					),
				),
				'default'  => array(
					'color' => '#09276f',
					'alpha' => 1,
				),
			),

			// Scroll Bar Width.
			array(
				'id'       => 'scrollbar_width',
				'type'     => 'dimensions',
				'units'    => array( 'em', 'px' ),
				'height'   => false,
				'title'    => esc_html__( 'Scroll Bar Width', 'consultix' ),
				'subtitle' => esc_html__( 'Set width for Scroll Bar.', 'consultix' ),
				'required' => array(
					array(
						'scrollbar_switch',
						'equals',
						true,
					),
				),
				'default'  => array(
					'width' => '7',
					'units' => 'px',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Button', 'consultix' ),
		'icon'       => 'el el-off',
		'id'         => 'button-style',
		'subsection' => true,
		'fields'     => array(

			// Button Padding.
			array(
				'id'             => 'button_padding',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array( 'em', 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Button Padding', 'consultix' ),
				'subtitle'       => esc_html__( 'Allow padding for buttons.', 'consultix' ),
				'default'        => array(
					'padding-top'    => '10px',
					'padding-right'  => '25px',
					'padding-bottom' => '10px',
					'padding-left'   => '25px',
					'units'          => 'px',
				),
				'output'         => array(
					'.rt-button.element-one > .rt-button-main, .radiant-contact-form .form-row input[type=submit], .radiant-contact-form .form-row input[type=button], .radiant-contact-form .form-row button[type=submit], .post.style-two .post-read-more .btn, .post.style-three .entry-main .post-read-more .btn, .woocommerce #respond input#submit, .woocommerce .return-to-shop .button, .woocommerce form .form-row input.button, .widget-area > .widget.widget_price_filter .button, .rt-fancy-text-box.element-one > .holder > .more > a, .rt-fancy-text-box.element-two > .holder > .more > a, .rt-fancy-text-box.element-three > .holder > .more > a, .rt-fancy-text-box.element-four > .holder > .more > a, .team.element-six .team-item > .holder .data .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn',
				),
			),

			// Background Color.
			array(
				'id'       => 'button_background_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for buttons.', 'consultix' ),
				'default'  => array(
					'color' => '#fde428',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.rt-button.element-one > .rt-button-main, .radiant-contact-form .form-row input[type=submit], .radiant-contact-form .form-row input[type=button], .radiant-contact-form .form-row button[type=submit], .post.style-two .post-read-more .btn, .post.style-three .entry-main .post-read-more .btn, .woocommerce #respond input#submit, .woocommerce form .form-row input.button, .woocommerce .return-to-shop .button, .widget-area > .widget.widget_price_filter .button, .rt-fancy-text-box.element-one > .holder > .more > a, .rt-fancy-text-box.element-two > .holder > .more > a, .rt-fancy-text-box.element-three > .holder > .more > a, .rt-fancy-text-box.element-four > .holder > .more > a, .team.element-six .team-item > .holder .data .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn',
				),
			),

			// Hover Background Color.
			array(
				'id'       => 'button_background_color_hover',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Hover Background Color', 'consultix' ),
				'subtitle' => esc_html__( 'Pick a background color for buttons hover.', 'consultix' ),
				'default'  => array(
					'color' => '#09276f',
					'alpha' => 1,
				),
				'output'   => array(
					'background-color' => '.rt-button.element-one[class*="hover-style-"] .rt-button-main > .overlay, .radiant-contact-form .form-row input[type=submit]:hover, .radiant-contact-form .form-row input[type=button]:hover, .radiant-contact-form .form-row button[type=submit]:hover, .post.style-two .post-read-more .btn:hover, .post.style-three .entry-main .post-read-more .btn:hover, .woocommerce #respond input#submit, .woocommerce .return-to-shop .button:hover, .woocommerce form .form-row input.button:hover, .widget-area > .widget.widget_price_filter .button:hover, .rt-fancy-text-box.element-one > .holder > .more > a:hover, .rt-fancy-text-box.element-two > .holder > .more > a:hover, .rt-fancy-text-box.element-three > .holder > .more > a:hover, .rt-fancy-text-box.element-four > .holder > .more > a:hover, .team.element-six .team-item > .holder .data .btn:hover, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn:hover, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn:hover, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn:hover, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn:hover, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn:hover',
				),
			),

			// Border.
			array(
				'id'      => 'button_border',
				'type'    => 'border',
				'title'   => esc_html__( 'Border', 'consultix' ),
				'default' => array(
					'border-top'    => '0px',
					'border-right'  => '0px',
					'border-bottom' => '0px',
					'border-left'   => '0px',
					'border-style'  => 'solid',
					'border-color'  => '#ffffff',
				),
				'output'  => array(
					'.rt-button.element-one > .rt-button-main, .radiant-contact-form .form-row input[type=submit], .radiant-contact-form .form-row input[type=button], .radiant-contact-form .form-row button[type=submit], .post.style-two .post-read-more .btn, .post.style-three .entry-main .post-read-more .btn, .woocommerce #respond input#submit, .woocommerce .return-to-shop .button, .woocommerce form .form-row input.button, .widget-area > .widget.widget_price_filter .button, .rt-fancy-text-box.element-one > .holder > .more > a, .rt-fancy-text-box.element-two > .holder > .more > a, .rt-fancy-text-box.element-three > .holder > .more > a, .rt-fancy-text-box.element-four > .holder > .more > a, .team.element-six .team-item > .holder .data .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn',
				),
			),

			// Hover Border Color.
			array(
				'id'      => 'button_hover_border_color',
				'type'    => 'border',
				'title'   => esc_html__( 'Hover Border Color', 'consultix' ),
				'default' => array(
					'border-top'    => '0px',
					'border-right'  => '0px',
					'border-bottom' => '0px',
					'border-left'   => '0px',
					'border-style'  => 'solid',
					'border-color'  => '#ffffff',
				),
				'output'  => array(
					'.rt-button.element-one > .rt-button-main:hover, .radiant-contact-form .form-row input[type=submit]:hover, .radiant-contact-form .form-row input[type=button]:hover, .radiant-contact-form .form-row button[type=submit]:hover, .post.style-two .post-read-more .btn:hover, .post.style-three .entry-main .post-read-more .btn:hover, .woocommerce #respond input#submit, .woocommerce .return-to-shop .button:hover, .woocommerce form .form-row input.button:hover, .widget-area > .widget.widget_price_filter .button:hover, .rt-fancy-text-box.element-one > .holder > .more > a:hover, .rt-fancy-text-box.element-two > .holder > .more > a:hover, .rt-fancy-text-box.element-three > .holder > .more > a:hover, .rt-fancy-text-box.element-four > .holder > .more > a:hover, .team.element-six .team-item > .holder .data .btn:hover, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn:hover, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn:hover, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn:hover, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn:hover, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn:hover',
				),
			),

			// Border Radius.
			array(
				'id'             => 'border-radius',
				'type'           => 'spacing',
				'mode'           => 'margin',
				'units'          => array( 'em', 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Border Radius', 'consultix' ),
				'subtitle'       => esc_html__( 'Users can change the Border Radius for Buttons.', 'consultix' ),
				'all'            => false,
				'default'        => array(
					'margin-top'    => '0',
					'margin-right'  => '0',
					'margin-bottom' => '0',
					'margin-left'   => '0',
					'units'         => 'px',
				),
			),

			// Box Shadow.
			array(
				'id'      => 'theme_button_box_shadow',
				'type'    => 'box_shadow',
				'title'   => esc_html__( 'Theme Button Box Shadow', 'consultix' ),
				'units'   => array( 'px', 'em', 'rem' ),
				'output'  => array(
					'.rt-button.element-one > .rt-button-main, .radiant-contact-form .form-row input[type=submit], .radiant-contact-form .form-row input[type=button], .radiant-contact-form .form-row button[type=submit], .post.style-two .post-read-more .btn, .post.style-three .entry-main .post-read-more .btn, .woocommerce #respond input#submit, .woocommerce .return-to-shop .button, .woocommerce form .form-row input.button, .widget-area > .widget.widget_price_filter .button, .rt-fancy-text-box.element-one > .holder > .more > a, .rt-fancy-text-box.element-two > .holder > .more > a, .rt-fancy-text-box.element-three > .holder > .more > a, .rt-fancy-text-box.element-four > .holder > .more > a, .team.element-six .team-item > .holder .data .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn',
				),
				'opacity' => true,
				'rgba'    => true,
				'default' => array(
					'horizontal'   => '0',
					'vertical'     => '0',
					'blur'         => '20px',
					'spread'       => '0',
					'opacity'      => '0.15',
					'shadow-color' => '#000000',
					'shadow-type'  => 'outside',
					'units'        => 'px',
				),

			),

			// Button Typography.
			array(
				'id'             => 'button_typography',
				'type'           => 'typography',
				'title'          => esc_html__( 'Button Typography', 'consultix' ),
				'subtitle'       => esc_html__( 'Typography options for buttons. Remember, this will effect all buttons of this theme. (Please Note: This change will effect all theme buttons, including Radiants Buttons, Radiant Contact Form Button, Radiant Fancy Text Box Button.)', 'consultix' ),
				'google'         => true,
				'font-backup'    => false,
				'subsets'        => false,
				'text-align'     => false,
				'text-transform' => true,
				'letter-spacing' => true,
				'units'          => 'px',
				'default'        => array(
					'google'      => true,
					'font-family' => 'Poppins',
					'font-weight' => '400',
					'font-size'   => '16px',
					'color'       => '#09276f',
					'line-height' => '25px',
				),
				'output'         => array(
					'.rt-button.element-one > .rt-button-main, .radiant-contact-form .form-row input[type=submit], .radiant-contact-form .form-row input[type=button], .radiant-contact-form .form-row button[type=submit], .post.style-two .post-read-more .btn, .post.style-three .entry-main .post-read-more .btn, .woocommerce #respond input#submit, .woocommerce .return-to-shop .button, .woocommerce form .form-row input.button, .widget-area > .widget.widget_price_filter .button, .rt-fancy-text-box.element-one > .holder > .more > a, .rt-fancy-text-box.element-two > .holder > .more > a, .rt-fancy-text-box.element-three > .holder > .more > a, .rt-fancy-text-box.element-four > .holder > .more > a, .team.element-six .team-item > .holder .data .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn',
				),
			),

			// Hover Font Color.
			array(
				'id'       => 'button_typography_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Hover Font Color', 'consultix' ),
				'subtitle' => esc_html__( 'Select button hover font color.', 'consultix' ),
				'default'  => '#ffffff',
				'output'   => array(
					'color' => '.rt-button.element-one > .rt-button-main:hover, .radiant-contact-form .form-row input[type=submit]:hover, .radiant-contact-form .form-row input[type=button]:hover, .radiant-contact-form .form-row button[type=submit]:hover, .post.style-two .post-read-more .btn:hover, .post.style-three .entry-main .post-read-more .btn:hover, .woocommerce #respond input#submit, .woocommerce .return-to-shop .button:hover, .woocommerce form .form-row input.button:hover, .widget-area > .widget.widget_price_filter .button:hover, .rt-fancy-text-box.element-one > .holder > .more > a:hover, .rt-fancy-text-box.element-two > .holder > .more > a:hover, .rt-fancy-text-box.element-three > .holder > .more > a:hover, .rt-fancy-text-box.element-four > .holder > .more > a:hover, .team.element-six .team-item > .holder .data .btn:hover, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title .btn:hover, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data .btn:hover, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title .btn:hover, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data .btn:hover, .rt-portfolio-box.element-four .rt-portfolio-box-item > .holder > .pic > .data .btn:hover',
				),
			),

			// Icon Color.
			array(
				'id'       => 'button_typography_icon',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Icon Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies only if Icon is present', 'consultix' ),
				'default'  => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'   => array(
					'color' => '.rt-button.element-one > .rt-button-main i',
				),
			),

			// Hover Icon Color.
			array(
				'id'       => 'button_typography_icon_hover',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Hover Icon Color', 'consultix' ),
				'subtitle' => esc_html__( 'Applies only if Icon is present', 'consultix' ),
				'default'  => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'   => array(
					'color' => '.rt-button.element-one > .rt-button-main:hover i',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Contact Form', 'consultix' ),
		'icon'       => 'el el-tasks',
		'id'         => 'contact_form_style',
		'subsection' => true,
		'fields'     => array(

			// Height For Input Fields.
			array(
				'id'       => 'contact_form_style_input_height',
				'type'     => 'dimensions',
				'units'    => array( 'em', 'px' ),
				'title'    => __( 'Height Option for Input Fields', 'consultix' ),
				'subtitle' => __( 'Users can change height for Input Fields.', 'consultix' ),
				'width'    => false,
				'height'   => true,
				'default'  => array(
					'height' => '45',
					'units'  => 'px',
				),
				'output'   => array(
					'.radiant-contact-form .form-row input[type=text], .radiant-contact-form .form-row input[type=email], .radiant-contact-form .form-row input[type=url], .radiant-contact-form .form-row input[type=tel], .radiant-contact-form .form-row input[type=number], .radiant-contact-form .form-row input[type=password], .radiant-contact-form .form-row input[type=date], .radiant-contact-form .form-row input[type=time], .radiant-contact-form .form-row select',
				),
			),

			// Height For Textarea Fields.
			array(
				'id'       => 'contact_form_style_textarea_height',
				'type'     => 'dimensions',
				'units'    => array( 'em', 'px' ),
				'title'    => __( 'Height Option for Textarea Fields', 'consultix' ),
				'subtitle' => __( 'Users can change height for Textarea Fields.', 'consultix' ),
				'width'    => false,
				'height'   => true,
				'default'  => array(
					'height' => '100',
					'units'  => 'px',
				),
				'output'   => array(
					'.radiant-contact-form .form-row textarea',
				),
			),

			// Padding For Input Fields Focus.
			array(
				'id'             => 'contact_form_style_input_padding_focus',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array( 'em', 'px' ),
				'units_extended' => false,
				'title'          => esc_html__( 'Padding For Input Fields Focus', 'consultix' ),
				'subtitle'       => esc_html__( 'Users can change padding for input fields focus.', 'consultix' ),
				'default'        => array(
					'padding-top'    => '0px',
					'padding-right'  => '0px',
					'padding-bottom' => '0px',
					'padding-left'   => '0px',
					'units'          => 'px',
				),
				'output'         => array(
					'.radiant-contact-form .form-row input[type=text]:focus, .radiant-contact-form .form-row input[type=email]:focus, .radiant-contact-form .form-row input[type=url]:focus, .radiant-contact-form .form-row input[type=tel]:focus, .radiant-contact-form .form-row input[type=number]:focus, .radiant-contact-form .form-row input[type=password]:focus, .radiant-contact-form .form-row input[type=date]:focus, .radiant-contact-form .form-row input[type=time]:focus, .radiant-contact-form .form-row select:focus, .radiant-contact-form .form-row textarea:focus',
				),
			),

			// Box Shadow For Input Fields.
			array(
				'id'       => 'contact_form_style_input_box_shadow',
				'type'     => 'box_shadow',
				'title'    => esc_html__( 'Box Shadow For Input Fields', 'consultix' ),
				'subtitle' => esc_html__( 'Users can change the Box Shadow for input fields.', 'consultix' ),
				'units'    => array( 'px', 'em' ),
				'output'   => array(
					'.radiant-contact-form .form-row input[type=text], .radiant-contact-form .form-row input[type=email], .radiant-contact-form .form-row input[type=url], .radiant-contact-form .form-row input[type=tel], .radiant-contact-form .form-row input[type=number], .radiant-contact-form .form-row input[type=password], .radiant-contact-form .form-row input[type=date], .radiant-contact-form .form-row input[type=time], .radiant-contact-form .form-row select, .radiant-contact-form .form-row textarea',
				),
				'opacity'  => true,
				'rgba'     => true,
				'default'  => array(
					'horizontal'   => '0',
					'vertical'     => '0',
					'blur'         => '20px',
					'spread'       => '0',
					'opacity'      => '0.15',
					'shadow-color' => '#000000',
					'shadow-type'  => 'outside',
					'units'        => 'px',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Accordion', 'consultix' ),
		'icon'       => 'el el-delicious',
		'id'         => 'accordion',
		'subsection' => true,
		'fields'     => array(

			// Accordion Style One Background Color.
			array(
				'id'      => 'element_accordion_style_one_backgroundcolor',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style One Background Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'background-color' => '.rt-accordion.element-one .rt-accordion-item',
				),
			),

			// Accordion Style One Title Font Color.
			array(
				'id'     => 'element_accordion_style_one_title_fontcolor',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style One Font Title Color', 'consultix' ),
				'output' => array(
					'color' => '.rt-accordion.element-one .rt-accordion-item > .rt-accordion-item-title > .rt-accordion-item-title-icon i, .rt-accordion.element-one .rt-accordion-item > .rt-accordion-item-title > .panel-title',
				),
			),

			// Accordion Style Two Icon Background Color.
			array(
				'id'     => 'element_accordion_style_two_icon_backgroundcolor',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style Two Icon Background Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-accordion.element-two .rt-accordion-item > .rt-accordion-item-title > .rt-accordion-item-title-icon > .holder',
					'color'            => '.rt-accordion.element-two .rt-accordion-item.rt-active > .rt-accordion-item-title > .panel-title',
				),
			),

			// Accordion Style Two Icon Active Background Color.
			array(
				'id'     => 'element_accordion_style_two_icon_active_backgroundcolor',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style Two Icon Active Background Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-accordion.element-two .rt-accordion-item.rt-active > .rt-accordion-item-title > .rt-accordion-item-title-icon > .holder',
					'color'            => '.rt-accordion.element-two .rt-accordion-item > .rt-accordion-item-title > .panel-title',
				),
			),

			// Accordion Style Three Title Color.
			array(
				'id'     => 'element_accordion_style_three_title_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style Three Title Color', 'consultix' ),
				'output' => array(
					'color' => '.rt-accordion.element-three .rt-accordion-item > .rt-accordion-item-title > .rt-accordion-item-title-icon > .holder i, .rt-accordion.element-three .rt-accordion-item > .rt-accordion-item-title > .panel-title',
				),
			),

			// Accordion Style Four Active Title Color.
			array(
				'id'     => 'element_accordion_style_four_active_title_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style Four Active Title Color', 'consultix' ),
				'output' => array(
					'color' => '.rt-accordion.element-four .rt-accordion-item.rt-active > .rt-accordion-item-title',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Fancy Text Box', 'consultix' ),
		'icon'       => 'el el-edit',
		'id'         => 'fancy_text_box',
		'subsection' => true,
		'fields'     => array(

			// Fancy Text Box Style Icon & Text Color.
			array(
				'id'     => 'element_fancytextbox_style_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Icon & Text Color', 'consultix' ),
				'output' => array(
					'color' => '.rt-fancy-text-box.element-one > .holder > .title > .icon i, .rt-fancy-text-box.element-one > .holder > .title > .fancy-text-tag, .rt-fancy-text-box.element-one > .holder > .title > .fancy-text-tag > a, .rt-fancy-text-box.element-two > .holder > .icon i, .rt-fancy-text-box.element-two > .holder > .title > .fancy-text-tag, .rt-fancy-text-box.element-two > .holder > .title > .fancy-text-tag > a, .rt-fancy-text-box.element-three > .holder > .title > .fancy-text-tag, .rt-fancy-text-box.element-three > .holder > .title > .fancy-text-tag > a, .rt-fancy-text-box.element-four > .holder > .title > .fancy-text-tag, .rt-fancy-text-box.element-four > .holder > .title > .fancy-text-tag > a',
				),
			),

		),
	)
);


Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Pricing Table', 'consultix' ),
		'icon'       => 'el el-pause',
		'id'         => 'pricing_table',
		'subsection' => true,
		'fields'     => array(

			// Pricing Table Style One Info.
			array(
				'id'    => 'element_pricingtable_style_one_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Pricing Table Style One', 'consultix' ),
			),

			// Pricing Table Style One Theme Color.
			array(
				'id'     => 'element_pricingtable_style_one_theme_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style One Theme Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-pricing-table.element-one > .holder > .data',
				),
			),

			// Pricing Table Style One Theme Alternative Color.
			array(
				'id'     => 'element_pricingtable_style_one_theme_altcolor',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style One Theme Alternative Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-pricing-table.element-one.spotlight > .holder > .data, .rt-pricing-table.element-one > .holder > .data .btn',
					'color'            => '.rt-pricing-table.element-one > .holder > .data .btn, .rt-pricing-table.element-one > .holder > .title h4, .rt-pricing-table.element-one > .holder > .list ul li:before',
				),
			),

			// Pricing Table Style One Data Font Color.
			array(
				'id'      => 'element_pricingtable_style_one_data_font_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style One Data Font Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color'            => '.rt-pricing-table.element-one > .holder > .data h5',
					'background-color' => '.rt-pricing-table.element-one > .holder > .data .btn',
				),
			),

			// Pricing Table Style Two Info.
			array(
				'id'    => 'element_pricingtable_style_two_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Pricing Table Style Two', 'consultix' ),
			),

			// Pricing Table Style Two Theme Color.
			array(
				'id'     => 'element_pricingtable_style_two_theme_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style Two Theme Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-pricing-table.element-two.spotlight > .holder > .title:before, .rt-pricing-table.element-two.spotlight > .holder > .title:after, .rt-pricing-table.element-two > .holder > .title h4:before, .rt-pricing-table.element-two > .holder > .data .btn',
					'color'            => '.rt-pricing-table.element-two > .holder > .title h5',
				),
			),

			// Pricing Table Style Two Theme Alternative Color.
			array(
				'id'     => 'element_pricingtable_style_two_theme_altcolor',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style Two Theme Alternative Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-pricing-table.element-two > .holder > .data .btn',
					'color'            => '.rt-pricing-table.element-two > .holder > .list ul li:before',
				),
			),

			// Pricing Table Style Three Info.
			array(
				'id'    => 'element_pricingtable_style_three_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Pricing Table Style Three', 'consultix' ),
			),

			// Pricing Table Style Three Theme Color.
			array(
				'id'     => 'element_pricingtable_style_three_theme_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Style Three Theme Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-pricing-table.element-three.spotlight > .holder',
					'color'            => '.rt-pricing-table.element-three > .holder > .title h5 strong, .rt-pricing-table.element-three.spotlight > .holder:after, .rt-pricing-table.element-three > .holder > .data .btn-hover',
					'border-color'     => '.rt-pricing-table.element-three > .holder > .list ul li:before, .rt-pricing-table.element-three > .holder > .data .btn',
				),
			),
		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Portfolio', 'consultix' ),
		'icon'       => 'el el-th',
		'id'         => 'portfolio',
		'subsection' => true,
		'fields'     => array(

			// Portfolio Style Info.
			array(
				'id'    => 'element_portfolio_style_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Portfolio', 'consultix' ),
			),

			// Portfolio Style Theme Color.
			array(
				'id'     => 'element_portfolio_style_theme_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Theme Color', 'consultix' ),
				'output' => array(
					'background-color' => '.rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .title, .rt-portfolio-box.element-one .rt-portfolio-box-item > .holder > .data, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .title > .table, .rt-portfolio-box.element-two .rt-portfolio-box-item > .holder > .pic > .data > .table',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Testimonial', 'consultix' ),
		'icon'       => 'el el-quotes',
		'id'         => 'testimonial',
		'subsection' => true,
		'fields'     => array(

			// Testimonial Style One Info.
			array(
				'id'    => 'element_testimonial_style_one_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style One', 'consultix' ),
			),

			// Testimonial Style One Title Color.
			array(
				'id'      => 'element_testimonial_style_one_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style One Title Color', 'consultix' ),
				'default' => array(
					'color' => '#001a57',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-one .testimonial-item > .holder > .title h5',
				),
			),

			// Testimonial Style One Subtitle Color.
			array(
				'id'      => 'element_testimonial_style_one_subtitle_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style One Subtitle Color', 'consultix' ),
				'default' => array(
					'color' => '#0f5c84',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-one .testimonial-item > .holder > .title p',
				),
			),

			// Testimonial Style One Content Background.
			array(
				'id'      => 'element_testimonial_style_one_content_background',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style One Content Background', 'consultix' ),
				'default' => array(
					'color' => '#f2f0ee',
					'alpha' => 1,
				),
				'output'  => array(
					'background-color' => '.testimonial.element-one .testimonial-item > .holder > .data',
					'border-top-color' => '.testimonial.element-one .testimonial-item > .holder > .data:before',
				),
			),

			// Testimonial Style One Content Color.
			array(
				'id'      => 'element_testimonial_style_one_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style One Content Color', 'consultix' ),
				'default' => array(
					'color' => '#222222',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-one .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Two Info.
			array(
				'id'    => 'element_testimonial_style_two_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Two', 'consultix' ),
			),

			// Testimonial Style Two Title Color.
			array(
				'id'      => 'element_testimonial_style_two_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Two Title Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-two .testimonial-item > .holder > .title h5',
				),
			),

			// Testimonial Style Two Content Color.
			array(
				'id'      => 'element_testimonial_style_two_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Two Content Color', 'consultix' ),
				'default' => array(
					'color' => '#d8d4d4',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-two .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Two Social Icon Color.
			array(
				'id'      => 'element_testimonial_style_two_social_icon_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Two Social Icon Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-two .testimonial-item > .holder > .meta ul.social li a i',
				),
			),

			// Testimonial Style Three Info.
			array(
				'id'    => 'element_testimonial_style_three_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Three', 'consultix' ),
			),

			// Testimonial Style Three Title Color.
			array(
				'id'      => 'element_testimonial_style_three_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Three Title Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-three .testimonial-item > .holder > .data h5',
				),
			),

			// Testimonial Style Three Content Color.
			array(
				'id'      => 'element_testimonial_style_three_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Three Content Color', 'consultix' ),
				'default' => array(
					'color' => '#d8d4d4',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-three .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Three Rating Star Color.
			array(
				'id'      => 'element_testimonial_style_three_rating_star_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Three Rating Star Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-three .testimonial-item > .holder > .data ul.rating li i',
				),
			),

			// Testimonial Style Four Info.
			array(
				'id'    => 'element_testimonial_style_four_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Four', 'consultix' ),
			),

			// Testimonial Style Four Title Color.
			array(
				'id'      => 'element_testimonial_style_four_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Four Title Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-four .testimonial-item > .holder > .data h5',
				),
			),

			// Testimonial Style Four Content Background.
			array(
				'id'      => 'element_testimonial_style_four_content_background',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Four Content Background', 'consultix' ),
				'default' => array(
					'color' => '#000000',
					'alpha' => 0.01,
				),
				'output'  => array(
					'background-color' => '.testimonial.element-four .testimonial-item > .holder > .data',
				),
			),

			// Testimonial Style Four Content Color.
			array(
				'id'      => 'element_testimonial_style_four_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Four Content Color', 'consultix' ),
				'default' => array(
					'color' => '#d8d4d4',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-four .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Four Rating Star Color.
			array(
				'id'      => 'element_testimonial_style_four_rating_star_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Four Rating Star Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-four .testimonial-item > .holder > .data ul.rating li i',
				),
			),

			// Testimonial Style Five Info.
			array(
				'id'    => 'element_testimonial_style_five_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Five', 'consultix' ),
			),

			// Testimonial Style Five Title Color.
			array(
				'id'      => 'element_testimonial_style_five_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Five Title Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-five .testimonial-item > .holder > .title h5',
				),
			),

			// Testimonial Style Five Subtitle Color.
			array(
				'id'      => 'element_testimonial_style_five_subtitle_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Five Subtitle Color', 'consultix' ),
				'default' => array(
					'color' => '#d38932',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-five .testimonial-item > .holder > .title p',
				),
			),

			// Testimonial Style Five Content Background.
			array(
				'id'      => 'element_testimonial_style_five_content_background',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Five Content Background', 'consultix' ),
				'default' => array(
					'color' => '#584835',
					'alpha' => 1,
				),
				'output'  => array(
					'background-color' => '.testimonial.element-five .testimonial-item > .holder > .data',
				),
			),

			// Testimonial Style Five Content Color.
			array(
				'id'      => 'element_testimonial_style_five_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Five Content Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-five .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Six Info.
			array(
				'id'    => 'element_testimonial_style_six_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Six', 'consultix' ),
			),

			// Testimonial Style Six Title Color.
			array(
				'id'      => 'element_testimonial_style_six_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Six Title Color', 'consultix' ),
				'default' => array(
					'color' => '#f19f00',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-six .testimonial-item > .holder > .data h5',
				),
			),

			// Testimonial Style Six Content Color.
			array(
				'id'      => 'element_testimonial_style_six_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Six Content Color', 'consultix' ),
				'default' => array(
					'color' => '#222222',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-six .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Seven Info.
			array(
				'id'    => 'element_testimonial_style_seven_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Seven', 'consultix' ),
			),

			// Testimonial Style Seven Title Color.
			array(
				'id'      => 'element_testimonial_style_seven_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Seven Title Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-seven .testimonial-item > .holder > .title h5',
				),
			),

			// Testimonial Style Seven Subtitle Color.
			array(
				'id'      => 'element_testimonial_style_seven_subtitle_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Seven Subtitle Color', 'consultix' ),
				'default' => array(
					'color' => '#fc8e0c',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-seven .testimonial-item > .holder > .title p',
				),
			),

			// Testimonial Style Seven Content Color.
			array(
				'id'      => 'element_testimonial_style_seven_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Seven Content Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-seven .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Seven Rating Star Color.
			array(
				'id'      => 'element_testimonial_style_seven_rating_star_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Seven Rating Star Color', 'consultix' ),
				'default' => array(
					'color' => '#fc8e0c',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-seven .testimonial-item > .holder > .title ul.rating li i',
				),
			),

			// Testimonial Style Eight Info.
			array(
				'id'    => 'element_testimonial_style_eight_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Eight', 'consultix' ),
			),

			// Testimonial Style Eight Title Color.
			array(
				'id'      => 'element_testimonial_style_eight_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Eight Title Color', 'consultix' ),
				'default' => array(
					'color' => '#001a57',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-eight .testimonial-item > .holder > .title h5',
				),
			),

			// Testimonial Style Eight Subtitle Color.
			array(
				'id'      => 'element_testimonial_style_eight_subtitle_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Eight Subtitle Color', 'consultix' ),
				'default' => array(
					'color' => '#0f5c84',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-eight .testimonial-item > .holder > .title p',
				),
			),

			// Testimonial Style Eight Content Background.
			array(
				'id'      => 'element_testimonial_style_eight_content_background',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Eight Content Background', 'consultix' ),
				'default' => array(
					'color' => '#000000',
					'alpha' => 0.04,
				),
				'output'  => array(
					'background-color' => '.testimonial.element-eight .testimonial-item > .holder > .data',
				),
			),

			// Testimonial Style Eight Content Color.
			array(
				'id'      => 'element_testimonial_style_eight_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Eight Content Color', 'consultix' ),
				'default' => array(
					'color' => '#222222',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-eight .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Nine Info.
			array(
				'id'    => 'element_testimonial_style_nine_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Nine', 'consultix' ),
			),

			// Testimonial Style Nine Title Color.
			array(
				'id'      => 'element_testimonial_style_nine_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Nine Title Color', 'consultix' ),
				'default' => array(
					'color' => '#001a57',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-nine .testimonial-item > .holder > .title h5',
				),
			),

			// Testimonial Style Nine Subtitle Color.
			array(
				'id'      => 'element_testimonial_style_nine_subtitle_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Nine Subtitle Color', 'consultix' ),
				'default' => array(
					'color' => '#0f5c84',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-nine .testimonial-item > .holder > .title p',
				),
			),

			// Testimonial Style Nine Content Background.
			array(
				'id'      => 'element_testimonial_style_nine_content_background',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Nine Content Background', 'consultix' ),
				'default' => array(
					'color' => '#000000',
					'alpha' => 0.02,
				),
				'output'  => array(
					'background-color' => '.testimonial.element-nine .testimonial-item > .holder',
				),
			),

			// Testimonial Style Nine Content Color.
			array(
				'id'      => 'element_testimonial_style_nine_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Nine Content Color', 'consultix' ),
				'default' => array(
					'color' => '#222222',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-nine .testimonial-item > .holder > .data blockquote p',
				),
			),

			// Testimonial Style Ten Info.
			array(
				'id'    => 'element_testimonial_style_ten_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Testimonial Style Ten', 'consultix' ),
			),

			// Testimonial Style Ten Title Color.
			array(
				'id'      => 'element_testimonial_style_ten_title_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Ten Title Color', 'consultix' ),
				'default' => array(
					'color' => '#001a57',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-ten .testimonial-item > .holder > .data h5',
				),
			),

			// Testimonial Style Ten Subtitle Color.
			array(
				'id'      => 'element_testimonial_style_ten_subtitle_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Ten Subtitle Color', 'consultix' ),
				'default' => array(
					'color' => '#0f5c84',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-ten .testimonial-item > .holder > .data .role',
				),
			),

			// Testimonial Style Ten Separator Color.
			array(
				'id'      => 'element_testimonial_style_ten_separator_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Ten Separator Color', 'consultix' ),
				'default' => array(
					'color' => '#ffffff',
					'alpha' => 1,
				),
				'output'  => array(
					'background-color' => '.testimonial.element-ten .testimonial-item > .holder > .data blockquote:before',
				),
			),

			// Testimonial Style Ten Content Color.
			array(
				'id'      => 'element_testimonial_style_ten_content_color',
				'type'    => 'color_rgba',
				'title'   => esc_html__( 'Style Ten Content Color', 'consultix' ),
				'default' => array(
					'color' => '#222222',
					'alpha' => 1,
				),
				'output'  => array(
					'color' => '.testimonial.element-ten .testimonial-item > .holder > .data blockquote p',
				),
			),
		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Loan Calculator', 'consultix' ),
		'icon'       => 'el el-align-left',
		'id'         => 'loan_calculator',
		'subsection' => true,
		'fields'     => array(

			// Loan Calculator Style Info.
			array(
				'id'    => 'element_loan_calculator_style_info',
				'type'  => 'info',
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
				'title' => esc_html__( 'Loan Calculator', 'consultix' ),
			),

			// Loan Calculator Style Theme Color.
			array(
				'id'     => 'element_loan_calculator_style_theme_color',
				'type'   => 'color_rgba',
				'title'  => esc_html__( 'Theme Color', 'consultix' ),
				'default'  => array(
					'color' => '#a3abda',
					'alpha' => 1,
				),
				'output' => array(
					'background-color' => '.rt-loan-calculator.element-one > ul.nav-tabs > li.active > a, .rt-loan-calculator.element-one .rt-loan-calculator-form .form-row .form-row-slider .slider .slider-track > .slider-selection',
					'border-color' => '.rt-loan-calculator.element-one > ul.nav-tabs > li.active > a',
					'color' => '.rt-loan-calculator.element-one .rt-loan-calculator-form .result-row .result-row-amount p',
				),
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title' => esc_html__( 'Pages', 'consultix' ),
		'icon'  => 'el el-book',
		'id'    => 'pages-option',
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Error 404', 'consultix' ),
		'icon'       => 'el el-error',
		'id'         => 'error',
		'subsection' => true,
		'fields'     => array(

			// 404 Custom Background Info.
			array(
				'id'    => 'error_custom_background_info',
				'type'  => 'info',
				'title' => esc_html__( 'Custom Background', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// 404 Custom Background Switch.
			array(
				'id'       => 'error_custom_background_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Active 404 Custom Background', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if want a custom background for 404 page.', 'consultix' ),
				'default'  => false,
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => 'off',
			),

			// 404 Custom Background Property.
			array(
				'id'       => 'error_custom_background_property',
				'type'     => 'background',
				'title'    => esc_html__( '404 Page Background', 'consultix' ),
				'subtitle' => esc_html__( 'Set Background for 404 Page.', 'consultix' ),
				'default'  => array(
					'background-color'      => '#0c0c0c',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'inherit',
					'background-position'   => 'center-top',
				),
				'output'   => array(
					'body.error-404-style-one .wraper_error_main, body.error-404-style-two .wraper_error_main',
				),
				'required' => array(
					array(
						'error_custom_background_switch',
						'equals',
						true,
					),
				),
			),

			// 404 Custom Background Style.
			array(
				'id'       => 'error_custom_background_style',
				'type'     => 'select',
				'title'    => esc_html__( 'Select 404 Page Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select the 404 Page Style.', 'consultix' ),
				'options'  => array(
					'style-one' => 'Dark Theme',
					'style-two' => 'Light Theme',
				),
				'default'  => 'style-one',
				'required' => array(
					array(
						'error_custom_background_switch',
						'!=',
						true,
					),
				),
			),

			// 404 Custom Content Info.
			array(
				'id'    => 'error_custom_content_info',
				'type'  => 'info',
				'title' => esc_html__( '404 Content', 'consultix' ),
				'style' => 'custom',
				'color' => '#b9cbe4',
				'class' => 'radiant-subheader',
			),

			// 404 Custom Content Padding.
			array(
				'id'             => 'error_custom_content_padding',
				'type'           => 'spacing',
				'units'          => array( 'em', 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( '404 Content Padding', 'consultix' ),
				'all'            => false,
				'top'            => true,
				'right'          => false,
				'bottom'         => true,
				'left'           => false,
				'default'        => array(
					'padding-top'    => '190px',
					'padding-bottom' => '200px',
					'units'          => 'px',
				),
				'output'         => array(
					'.wraper_error_main > .container',
				),
			),

			// 404 Custom Content Body.
			array(
				'id'       => 'error_custom_content_body',
				'type'     => 'editor',
				'title'    => esc_html__( '404 Page Body', 'consultix' ),
				'subtitle' => esc_html__( 'Enter content to show on 404 page body.', 'consultix' ),
				'args'     => array(
					'teeny' => false,
				),
				'default'  => "<h1><strong>404 ERROR!</strong> PAGE NOT FOUND</h1><h2>We are sorry, the page you want to visit does not exist!</h2>",
			),

		),
	)
);
Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Maintenance Mode', 'consultix' ),
		'icon'       => 'el el-broom',
		'id'         => 'maintenance_mode',
		'subsection' => true,
		'fields'     => array(

			// Maintenance Mode Switch.
			array(
				'id'       => 'maintenance_mode_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Activate Maintenance Mode?', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if want to Activate Maintenance Mode.', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => false,
			),

			// Maintenance Mode Background Property.
			array(
				'id'       => 'maintenance_mode_background_property',
				'type'     => 'background',
				'title'    => esc_html__( 'Page Background', 'consultix' ),
				'subtitle' => esc_html__( 'Set Background for Maintenance Mode Page.', 'consultix' ),
				'default'  => array(
					'background-color'      => '#0c0c0c',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'inherit',
					'background-position'   => 'center-top',
				),
				'output'   => array(
					'body.rt-maintenance-mode',
				),
				'required' => array(
					array(
						'maintenance_mode_switch',
						'equals',
						true,
					),
				),
			),

			// Maintenance Mode Content Body.
			array(
				'id'       => 'maintenance_mode_content_body',
				'type'     => 'editor',
				'title'    => esc_html__( 'Content Body', 'consultix' ),
				'subtitle' => esc_html__( 'Enter content to show on Maintenance Mode page.', 'consultix' ),
				'args'     => array(
					'teeny' => false,
				),
				'default'  => '<h1>Maintenance Mode</h1><h2>Our website is going under maintenance. We will be back very soon!.</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
				'required' => array(
					array(
						'maintenance_mode_switch',
						'equals',
						true,
					),
				),
			),

			// Maintenance Mode Progress Bar Switch.
			array(
				'id'       => 'maintenance_mode_progressbar_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Activate Progress Bar?', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if want to Activate Progress Bar.', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => true,
				'required' => array(
					array(
						'maintenance_mode_switch',
						'equals',
						true,
					),
				),
			),

			// Maintenance Mode Progress Bar Width.
			array(
				'id'            => 'maintenance_mode_progressbar_width',
				'type'          => 'slider',
				'title'         => esc_html__( 'Progress Bar Width', 'consultix' ),
				'subtitle'      => esc_html__( 'Select Progress Bar Width. Min is 0%, Max is 100% and Default is 30%.', 'consultix' ),
				'default'       => 30,
				'min'           => 0,
				'step'          => 10,
				'max'           => 100,
				'display_value' => 'text',
				'required'      => array(
					array(
						'maintenance_mode_switch',
						'equals',
						true,
					),
					array(
						'maintenance_mode_progressbar_switch',
						'equals',
						true,
					),
				),
			),

			// Maintenance Mode Progress Bar Height.
			array(
				'id'       => 'maintenance_mode_progressbar_height',
				'type'     => 'dimensions',
				'units'    => array( 'px' ),
				'title'    => esc_html__( 'Progress Bar Height', 'consultix' ),
				'subtitle' => esc_html__( 'Select Progress Bar Height.', 'consultix' ),
				'width'    => false,
				'height'   => true,
				'default'  => array(
					'height' => '30',
				),
				'required' => array(
					array(
						'maintenance_mode_switch',
						'equals',
						true,
					),
					array(
						'maintenance_mode_progressbar_switch',
						'equals',
						true,
					),
				),
			),
		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Coming Soon', 'consultix' ),
		'icon'       => 'el el-warning-sign',
		'id'         => 'coming_soon',
		'subsection' => true,
		'fields'     => array(

			// Coming Soon Switch.
			array(
				'id'       => 'coming_soon_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Activate Coming Soon', 'consultix' ),
				'subtitle' => esc_html__( 'Choose if want to activate Coming Soon mode.', 'consultix' ),
				'on'       => esc_html__( 'Yes', 'consultix' ),
				'off'      => esc_html__( 'No', 'consultix' ),
				'default'  => false,
			),

			// Coming Soon Custom Background Style.
			array(
				'id'       => 'coming_soon_custom_background_style',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Coming Soon Page Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select the Coming Soon Page Style.', 'consultix' ),
				'options'  => array(
					'style-one' => 'Dark Theme',
					'style-two' => 'Light Theme',
				),
				'default'  => 'style-one',
				'required' => array(
					array(
						'coming_soon_switch',
						'equals',
						true,
					),
				),
			),

			// Coming Soon Background Property.
			array(
				'id'       => 'coming_soon_background_property',
				'type'     => 'background',
				'title'    => esc_html__( 'Page Background', 'consultix' ),
				'subtitle' => esc_html__( 'Set Background for Coming Soon Page.', 'consultix' ),
				'default'  => array(
					'background-color'      => '#0c0c0c',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'inherit',
					'background-position'   => 'center-top',
				),
				'output'   => array(
					'body.rt-coming-soon.coming-soon-style-one, body.rt-coming-soon.coming-soon-style-two',
				),
				'required' => array(
					array(
						'coming_soon_switch',
						'equals',
						true,
					),
				),
			),

			// Coming Soon Content Body.
			array(
				'id'       => 'coming_soon_body',
				'type'     => 'editor',
				'title'    => esc_html__( 'Content Body', 'consultix' ),
				'subtitle' => esc_html__( 'Enter content to show on Coming Soon page.', 'consultix' ),
				'args'     => array(
					'teeny' => false,
				),
				'default'  => '<h1>The Site will be Launching shortly... Perfect and awesome template to present your future product or service. Hooking audience attention is all in the opener.</h1>',
				'required' => array(
					array(
						'coming_soon_switch',
						'equals',
						true,
					),
				),
			),

			// Coming Soon Launch Date-Time.
			array(
				'id'       => 'coming_soon_datetime',
				'type'     => 'text',
				'title'    => esc_html__( 'Launch Date&Time', 'consultix' ),
				'subtitle' => esc_html__( 'Enter Launch Date&Time.', 'consultix' ),
				'default'  => '2018-05-22 12:00',
				'required' => array(
					array(
						'coming_soon_switch',
						'equals',
						true,
					),
				),
			),

		),
	)
);
Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Search', 'consultix' ),
		'icon'       => 'el el-search-alt',
		'id'         => 'search',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'       => 'search_page_banner_image',
				'type'     => 'media',
				'url'      => false,
				'title'    => esc_html__( 'Search Page Banner Image', 'consultix' ),
				'subtitle' => esc_html__( 'Select search page banner image', 'consultix' ),
			),

			array(
				'id'       => 'search_page_banner_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Search Page Title', 'consultix' ),
				'subtitle' => esc_html__( 'Enter search page banner title', 'consultix' ),
				'default'  => 'Search',
			),

		),
	)
);
if ( class_exists( 'Tribe__Events__Main' ) ) {
Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Event', 'consultix' ),
		'icon'       => 'el el-calendar',
		'id'         => 'banner_layout',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'events_banner_details',
				'type'     => 'select',
				'title'    => esc_html__( 'Banner Details', 'consultix' ),
				'subtitle' => esc_html__( 'Select Banner options', 'consultix' ),
				'options'  => array(
					'banner-breadcumbs'    => 'Short Banner With Breadcumbs',
					'banner-only'          => 'Short Banner Only',
					'breadcumbs-only'      => 'Breadcumbs Only',
					'none'                 => 'None',
				),
				'default'  => 'banner-breadcumbs',
			),
			array(
				'id'       => 'event_banner_image',
				'type'     => 'media',
				'url'      => false,
				'title'    => esc_html__( 'Event Banner Image', 'consultix' ),
				'subtitle' => esc_html__( 'Select event banner image', 'consultix' ),
				'required' => array(
					array(
						'events_banner_details',
						'!=',
						'none',
					),
					array(
						'events_banner_details',
						'!=',
						'breadcumbs-only',
					),
				),
			),
			array(
				'id'       => 'event_banner_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Event Title', 'consultix' ),
				'subtitle' => esc_html__( 'Enter event banner title', 'consultix' ),
				'default'  => 'Events',
				'required' => array(
					array(
						'events_banner_details',
						'!=',
						'none',
					),
					array(
						'events_banner_details',
						'!=',
						'breadcumbs-only',
					),
				),
			),
		),
	)
);
}
Redux::setSection(
	$opt_name, array(
		'title' => esc_html__( 'Blog', 'consultix' ),
		'icon'  => 'el el-bullhorn',
		'id'    => 'blog',
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Blog Layout', 'consultix' ),
		'icon'       => 'el el-check-empty',
		'id'         => 'blog_layout',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'       => 'blog-style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Blog Style', 'consultix' ),
				'subtitle' => esc_html__( 'Select blog style', 'consultix' ),
				'options'  => array(
					'default'   => array(
						'alt' => 'Default',
						'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Blog-Style-Default.png',
					),
					'one'   => array(
						'alt' => '3 Column',
						'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Blog-Style-3-Column.png',
					),
					'two'   => array(
						'alt' => '4 Column Masonry',
						'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Blog-Style-4-Column-Masonry.png',
					),
					'three' => array(
						'alt' => 'List',
						'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Blog-Style-List.png',
					),
				),
				'default'  => 'default',
			),

			array(
				'id'       => 'blog-layout',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Blog Layout', 'consultix' ),
				'subtitle' => esc_html__( 'Select blog layout', 'consultix' ),
				'options'  => array(
					'leftsidebar'  => array(
						'alt' => 'Left Sidebar',
						'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Blog-Layout-Left-Sidebar.png',
					),
					'nosidebar'    => array(
						'alt' => 'No Sidebar',
						'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Blog-Layout-No-Sidebar.png',
					),
					'rightsidebar' => array(
						'alt' => 'Right Sidebar',
						'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Blog-Layout-Right-Sidebar.png',
					),
				),
				'default'  => 'rightsidebar',
			),

		),
	)
);

Redux::setSection(
	$opt_name, array(
		'title'      => esc_html__( 'Blog Options', 'consultix' ),
		'icon'       => 'el el-ok-sign',
		'id'         => 'blog_options',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'       => 'blog_comment_display',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Comments', 'consultix' ),
				'subtitle' => esc_html__( 'Do you want to enable comments on blog details page?', 'consultix' ),
				'default'  => true,
			),

		),
	)
);

if ( class_exists( 'woocommerce' ) ) {

	Redux::setSection(
		$opt_name, array(
			'title' => esc_html__( 'Shop', 'consultix' ),
			'icon'  => 'el el-shopping-cart',
			'id'    => 'shop',
		)
	);

	Redux::setSection(
		$opt_name, array(
			'title'      => esc_html__( 'Product Listing', 'consultix' ),
			'icon'       => 'el el-list-alt',
			'id'         => 'product_listing',
			'subsection' => true,
			'fields'     => array(

				// Product Listing Layout.
				array(
					'id'       => 'shop-style',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Product Listing Layout', 'consultix' ),
					'subtitle' => esc_html__( 'Select Product Listing Layout', 'consultix' ),
					'options'  => array(
						'shop-one' => array(
							'alt'   => 'Style One',
							'img'   => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Style-One.jpg',
						),
						'shop-two' => array(
							'alt'   => 'Style Two',
							'img'   => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Style-Two.jpg',
						),
					),
					'default'  => 'shop-one',
				),

				// Sidebar.
				array(
					'id'       => 'shop-sidebar',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar.', 'consultix' ),
					'subtitle' => esc_html__( 'Select Sidebar', 'consultix' ),
					'options'  => array(
						'shop-leftsidebar'  => array(
							'alt' => 'Left Sidebar',
							'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Product-Listing-Left-Sidebar.jpg',
						),
						'shop-nosidebar'    => array(
							'alt' => 'No Sidebar',
							'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Product-Listing-No-Sidebar.jpg',
						),
						'shop-rightsidebar' => array(
							'alt' => 'Right Sidebar',
							'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Product-Listing-Right-Sidebar.jpg',
						),
					),
					'default'  => 'shop-nosidebar',
				),

				// Shop Box Style.
				array(
					'id'       => 'shop_box_style',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Shop Box Style', 'consultix' ),
					'subtitle' => esc_html__( 'Select Style of the Shop Box.', 'consultix' ),
					'options'  => array(
						'style-one'  => array(
							'alt' => 'Style One',
							'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Box-Style-One.jpg',
						),
						'style-two' => array(
							'alt' => 'Style Two',
							'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Box-Style-Two.jpg',
						),
						'style-three' => array(
							'alt' => 'Style Three',
							'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Box-Style-Three.jpg',
						),
						'style-four' => array(
							'alt' => 'Style Four',
							'img' => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Box-Style-Four.jpg',
						),
					),
					'default'  => 'style-one',
				),

			),
		)
	);

	Redux::setSection(
		$opt_name, array(
			'title'      => esc_html__( 'Product Details', 'consultix' ),
			'icon'       => 'el el-shopping-cart',
			'id'         => 'product_details',
			'subsection' => true,
			'fields'     => array(

				array(
					'id'       => 'shop-details-sidebar',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar', 'consultix' ),
					'subtitle' => esc_html__( 'Select Sidebar', 'consultix' ),
					'options'  => array(
						'shop-details-leftsidebar'  => array(
							'alt'   => 'Left Sidebar',
							'title' => 'Left Sidebar',
							'img'   => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Details-Layout-Left-Sidebar.jpg',
						),
						'shop-details-nosidebar'    => array(
							'alt'   => 'No Sidebar',
							'title' => 'No Sidebar',
							'img'   => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Details-Layout-No-Sidebar.jpg',
						),
						'shop-details-rightsidebar' => array(
							'alt'   => 'Right Sidebar',
							'title' => 'Right Sidebar',
							'img'   => get_template_directory_uri() . '/inc/redux-framework/css/img/Shop-Details-Layout-Right-Sidebar.jpg',
						),
					),
					'default'  => 'shop-details-nosidebar',
				),

			),
		)
	);

}

Redux::setSection(
	$opt_name, array(
		'title'   => esc_html__( 'Social Icons', 'consultix' ),
		'icon'    => 'el el-globe',
		'id'      => 'social_icons',
		'submenu' => false,
		'fields'  => array(

			// Open social links in new window.
			array(
				'id'      => 'social-icon-target',
				'type'    => 'switch',
				'title'   => esc_html__( 'Open links in new window', 'consultix' ),
				'desc'    => esc_html__( 'Open social links in new window', 'consultix' ),
				'default' => true,
			),

			// Google +.
			array(
				'id'      => 'social-icon-googleplus',
				'type'    => 'text',
				'title'   => esc_html__( 'Google +', 'consultix' ),
				'desc'    => esc_html__( 'Link to the profile page', 'consultix' ),
				'default' => 'https://plus.google.com',
			),

			// Facebook.
			array(
				'id'      => 'social-icon-facebook',
				'type'    => 'text',
				'title'   => esc_html__( 'Facebook', 'consultix' ),
				'desc'    => esc_html__( 'Link to the profile page', 'consultix' ),
				'default' => 'https://facebook.com',
			),

			// Twitter.
			array(
				'id'      => 'social-icon-twitter',
				'type'    => 'text',
				'title'   => esc_html__( 'Twitter', 'consultix' ),
				'desc'    => esc_html__( 'Link to the profile page', 'consultix' ),
				'default' => 'https://twitter.com',
			),

			// Vimeo.
			array(
				'id'      => 'social-icon-vimeo',
				'type'    => 'text',
				'title'   => esc_html__( 'Vimeo', 'consultix' ),
				'desc'    => esc_html__( 'Link to the profile page', 'consultix' ),
				'default' => 'https://vimeo.com',
			),

			// YouTube.
			array(
				'id'    => 'social-icon-youtube',
				'type'  => 'text',
				'title' => esc_html__( 'YouTube', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Flickr.
			array(
				'id'    => 'social-icon-flickr',
				'type'  => 'text',
				'title' => esc_html__( 'Flickr', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// LinkedIn.
			array(
				'id'    => 'social-icon-linkedin',
				'type'  => 'text',
				'title' => esc_html__( 'LinkedIn', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Pinterest.
			array(
				'id'    => 'social-icon-pinterest',
				'type'  => 'text',
				'title' => esc_html__( 'Pinterest', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Xing.
			array(
				'id'    => 'social-icon-xing',
				'type'  => 'text',
				'title' => esc_html__( 'Xing', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Viadeo.
			array(
				'id'    => 'social-icon-viadeo',
				'type'  => 'text',
				'title' => esc_html__( 'Viadeo', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Vkontakte.
			array(
				'id'    => 'social-icon-vkontakte',
				'type'  => 'text',
				'title' => esc_html__( 'Vkontakte', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Tripadvisor.
			array(
				'id'    => 'social-icon-tripadvisor',
				'type'  => 'text',
				'title' => esc_html__( 'Tripadvisor', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Tumblr.
			array(
				'id'    => 'social-icon-tumblr',
				'type'  => 'text',
				'title' => esc_html__( 'Tumblr', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Behance.
			array(
				'id'    => 'social-icon-behance',
				'type'  => 'text',
				'title' => esc_html__( 'Behance', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Instagram.
			array(
				'id'    => 'social-icon-instagram',
				'type'  => 'text',
				'title' => esc_html__( 'Instagram', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Dribbble.
			array(
				'id'    => 'social-icon-dribbble',
				'type'  => 'text',
				'title' => esc_html__( 'Dribbble', 'consultix' ),
				'desc'  => esc_html__( 'Link to the profile page', 'consultix' ),
			),

			// Skype.
			array(
				'id'    => 'social-icon-skype',
				'type'  => 'text',
				'title' => esc_html__( 'Skype', 'consultix' ),
				'desc'  => wp_kses_post( 'Skype login. You can use <strong>callto:</strong> or <strong>skype:</strong> prefix' ),
			),

		),
	)
);
