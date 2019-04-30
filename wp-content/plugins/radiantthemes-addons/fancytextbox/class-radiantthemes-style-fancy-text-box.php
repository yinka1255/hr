<?php
/**
 * Fancy Text Box Style Addon
 *
 * @package Radiantthemes
 */

if ( class_exists( 'WPBakeryShortCode' ) && ! class_exists( 'RadiantThemes_Style_Fancy_Text_Box' ) ) {

	/**
	 * Class definition.
	 */
	class RadiantThemes_Style_Fancy_Text_Box extends WPBakeryShortCode {
		/**
		 * [__construct description]
		 */
		public function __construct() {
			vc_map(
				array(
					'name'        => esc_html__( 'Fancy Text Box', 'radiantthemes-addons' ),
					'base'        => 'rt_fancy_text_box_style',
					'description' => esc_html__( 'Add Fancy Text Box with multiple styles.', 'radiantthemes-addons' ),
					'icon'        => plugins_url( 'radiantthemes-addons/fancytextbox/icon/FancyTextBox-Element-Icon.png' ),
					'class'       => 'wpb_rt_vc_extension_team_style',
					'category'    => esc_html__( 'Radiant Elements', 'radiantthemes-addons' ),
					'controls'    => 'full',
					'params'      => array(
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Fancy Text Box Style', 'radiantthemes-addons' ),
							'param_name'  => 'style_variation',
							'value'       => array(
								esc_html__( 'Style One (With Icon)', 'radiantthemes-addons' )    => 'one',
								esc_html__( 'Style Two (With Icon)', 'radiantthemes-addons' )    => 'two',
								esc_html__( 'Style Three (With Image)', 'radiantthemes-addons' ) => 'three',
								esc_html__( 'Style Four (With Image)', 'radiantthemes-addons' )  => 'four',
							),
							'std'         => 'one',
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Fancy Text Box Title', 'radiantthemes-addons' ),
							'value'       => esc_html__( 'I am a Fancy Text Box', 'radiantthemes-addons' ),
							'param_name'  => 'title',
							'admin_label' => true,
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Element tag', 'radiantthemes-addons' ),
							'description'      => esc_html__( 'Select element tag.', 'radiantthemes-addons' ),
							'edit_field_class' => 'vc_col-xs-4 vc_column',
							'value'            => array(
								'h1'  => 'h1',
								'h2'  => 'h2',
								'h3'  => 'h3',
								'h4'  => 'h4',
								'h5'  => 'h5',
								'h6'  => 'h6',
								'p'   => 'p',
								'div' => 'div',
							),
							'param_name'       => 'fancy_tag',
							'std'              => 'h4',
						),
						array(
							'type'             => 'textfield',
							'heading'          => esc_html__( 'Font Size', 'radiantthemes-addons' ),
							'description'      => esc_html__( 'Enter font size.', 'radiantthemes-addons' ),
							'edit_field_class' => 'vc_col-xs-4 vc_column',
							'value'            => esc_html__( '24', 'radiantthemes-addons' ),
							'param_name'       => 'fancy_font_size',
						),
						array(
							'type'             => 'textfield',
							'heading'          => esc_html__( 'Line Height', 'radiantthemes-addons' ),
							'description'      => esc_html__( 'Enter line height.', 'radiantthemes-addons' ),
							'edit_field_class' => 'vc_col-xs-4 vc_column',
							'value'            => esc_html__( '35', 'radiantthemes-addons' ),
							'param_name'       => 'fancy_line_height',
						),
						array(
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Fancy Text Box Content', 'radiantthemes-addons' ),
							'value'      => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do.', 'radiantthemes-addons' ),
							'param_name' => 'fancy_content',
						),
						array(
							'type'       => 'attach_image',
							'heading'    => esc_html__( 'Add Image', 'radiantthemes-addons' ),
							'param_name' => 'image_url',
							'dependency' => array(
								'element' => 'style_variation',
								'value'   => array(
										 'three',
								 		'four',
								),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Icon library', 'radiantthemes-addons' ),
							'value'       => array(
								esc_html__( 'Font Awesome', 'radiantthemes-addons' ) => 'fontawesome',
								esc_html__( 'Open Iconic', 'radiantthemes-addons' )  => 'openiconic',
								esc_html__( 'Typicons', 'radiantthemes-addons' )     => 'typicons',
								esc_html__( 'Entypo', 'radiantthemes-addons' )       => 'entypo',
								esc_html__( 'Linecons', 'radiantthemes-addons' )     => 'linecons',
								esc_html__( 'Mono Social', 'radiantthemes-addons' )  => 'monosocial',
								esc_html__( 'Material', 'radiantthemes-addons' )     => 'material',
							),
							// 'admin_label' => true,
							'param_name'  => 'type',
							'description' => esc_html__( 'Select icon library.', 'radiantthemes-addons' ),
							'dependency'  => array(
								'element' => 'style_variation',
								'value'   => array(
									'one',
									'two',
								),
							),
						),
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'radiantthemes-addons' ),
							'param_name'  => 'icon_fontawesome',
							'value'       => 'fa fa-adjust',
							// default value to backend editor admin_label.
							'settings'    => array(
								'emptyIcon'    => false,
								// default true, display an "EMPTY" icon?
								'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display, we use (big number) to display all icons in single page.
							),
							'dependency'  => array(
								'element' => 'type',
								'value'   => 'fontawesome',
							),
							'description' => esc_html__( 'Select icon from library.', 'radiantthemes-addons' ),

						),
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'radiantthemes-addons' ),
							'param_name'  => 'icon_openiconic',
							'value'       => 'vc-oi vc-oi-dial',
							// default value to backend editor admin_label.
							'settings'    => array(
								'emptyIcon'    => false,
								// default true, display an "EMPTY" icon?
								'type'         => 'openiconic',
								'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display.
							),
							'dependency'  => array(
								'element' => 'type',
								'value'   => 'openiconic',
							),
							'description' => esc_html__( 'Select icon from library.', 'radiantthemes-addons' ),
						),
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'radiantthemes-addons' ),
							'param_name'  => 'icon_typicons',
							'value'       => 'typcn typcn-adjust-brightness',
							// default value to backend editor admin_label.
							'settings'    => array(
								'emptyIcon'    => false,
								// default true, display an "EMPTY" icon?
								'type'         => 'typicons',
								'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display.
							),
							'dependency'  => array(
								'element' => 'type',
								'value'   => 'typicons',
							),
							'description' => esc_html__( 'Select icon from library.', 'radiantthemes-addons' ),
						),
						array(
							'type'       => 'iconpicker',
							'heading'    => esc_html__( 'Icon', 'radiantthemes-addons' ),
							'param_name' => 'icon_entypo',
							'value'      => 'entypo-icon entypo-icon-note',
							// default value to backend editor admin_label.
							'settings'   => array(
								'emptyIcon'    => false,
								// default true, display an "EMPTY" icon?
								'type'         => 'entypo',
								'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display.
							),
							'dependency' => array(
								'element' => 'type',
								'value'   => 'entypo',
							),
						),
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'radiantthemes-addons' ),
							'param_name'  => 'icon_linecons',
							'value'       => 'vc_li vc_li-heart',
							// default value to backend editor admin_label.
							'settings'    => array(
								'emptyIcon'    => false,
								// default true, display an "EMPTY" icon?
								'type'         => 'linecons',
								'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display.
							),
							'dependency'  => array(
								'element' => 'type',
								'value'   => 'linecons',
							),
							'description' => esc_html__( 'Select icon from library.', 'radiantthemes-addons' ),
						),
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'radiantthemes-addons' ),
							'param_name'  => 'icon_monosocial',
							'value'       => 'vc-mono vc-mono-fivehundredpx',
							// default value to backend editor admin_label.
							'settings'    => array(
								'emptyIcon'    => false,
								// default true, display an "EMPTY" icon?
								'type'         => 'monosocial',
								'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display.
							),
							'dependency'  => array(
								'element' => 'type',
								'value'   => 'monosocial',
							),
							'description' => esc_html__( 'Select icon from library.', 'radiantthemes-addons' ),
						),
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'radiantthemes-addons' ),
							'param_name'  => 'icon_material',
							'value'       => 'vc-material vc-material-cake',
							// default value to backend editor admin_label.
							'settings'    => array(
								'emptyIcon'    => false,
								// default true, display an "EMPTY" icon?
								'type'         => 'material',
								'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display.
							),
							'dependency'  => array(
								'element' => 'type',
								'value'   => 'material',
							),
							'description' => esc_html__( 'Select icon from library.', 'radiantthemes-addons' ),
						),

						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Alignment', 'radiantthemes-addons' ),
							'param_name'  => 'align',
							'description' => esc_html__( 'Select fancy box icon alignment.', 'radiantthemes-addons' ),
							'value'       => array(
								esc_html__( 'Left', 'radiantthemes-addons' )   => 'left',
								esc_html__( 'Right', 'radiantthemes-addons' )  => 'right',
								esc_html__( 'Center', 'radiantthemes-addons' ) => 'center',
							),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Enable Box Shadow?', 'radiantthemes-addons' ),
							'param_name' => 'add_shadow',
							'value'      => array(
								esc_html__( 'No', 'radiantthemes-addons' )            => 'none',
								esc_html__( 'Yes', 'radiantthemes-addons' )           => 'yes',
								esc_html__( 'Only on Hover', 'radiantthemes-addons' ) => 'hover',
							),
						),
						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Do You want Button?', 'radiantthemes-addons' ),
							'param_name' => 'add_button',
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Button Text', 'radiantthemes-addons' ),
							'value'      => esc_html__( 'Text on Button', 'radiantthemes-addons' ),
							'param_name' => 'button_title',
							'dependency' => array(
								'element' => 'add_button',
								'value'   => 'true',
							),
						),
						array(
							'type'        => 'vc_link',
							'heading'     => esc_html__( 'URL (Link)', 'radiantthemes-addons' ),
							'param_name'  => 'button_link',
							'description' => esc_html__( 'Add link', 'radiantthemes-addons' ),
						),
						array(
							'type'        => 'animation_style',
							'heading'     => esc_html__( 'Animation Style', 'radiantthemes-addons' ),
							'param_name'  => 'animation',
							'description' => esc_html__( 'Choose your animation style', 'radiantthemes-addons' ),
							'admin_label' => false,
							'weight'      => 0,

						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name for the container', 'radiantthemes-addons' ),
							'param_name'  => 'extra_class',
							'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'radiantthemes-addons' ),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Element ID', 'radiantthemes-addons' ),
							'param_name'  => 'extra_id',
							'description' => sprintf( wp_kses_post( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'radiantthemes-addons' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
							'admin_label' => true,
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'CSS', 'radiantthemes-addons' ),
							'param_name' => 'fancytextbox_css',
							'group'      => esc_html__( 'Fancy Text Box Design', 'radiantthemes-addons' ),
						),
					),
				)
			);
			add_shortcode( 'rt_fancy_text_box_style', array( $this, 'radiantthemes_fancy_text_box_style_func' ) );
		}

		/**
		 * [radiantthemes_fancy_text_box_style_func description]
		 *
		 * @param  [type] $atts    [description.
		 * @param  [type] $content [description.
		 * @param  [type] $tag     [description.
		 * @return [type]          [description]
		 */
		public function radiantthemes_fancy_text_box_style_func( $atts, $content = null, $tag ) {
			$shortcode = shortcode_atts(
				array(
					'style_variation'   => 'one',
					'title'             => esc_html__( 'I am Fancy Text Box', 'radiantthemes-addons' ),
					'fancy_content'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do.', 'radiantthemes-addons' ),
					'add_shadow'        => 'none',
					'add_button'        => '',
					'button_title'      => 'Text on Button',
					'fancy_tag'         => 'h4',
					'fancy_font_size'   => '24',
					'fancy_line_height' => '35',
					'button_link'       => '',
					'image_url'         => '',
					'align'             => 'left',
					'icon_fontawesome'  => 'fa fa-adjust',
					'icon_openiconic'   => '',
					'icon_typicons'     => '',
					'icon_entypo'       => '',
					'icon_linecons'     => '',
					'icon_monosocial'   => '',
					'icon_material'     => '',
					'type'              => 'icon_fontawesome',
					'animation'         => '',
					'extra_class'       => '',
					'extra_id'          => '',
					'fancytextbox_css'  => '',
				), $atts
			);

			$styles = array();

			// Build the animation classes.
			$animation_classes = $this->getCSSAnimation( $shortcode['animation'] );

			$fancy_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $shortcode['fancytextbox_css'], ' ' ), $atts );
			wp_register_style(
				'radiantthemes_fancytextbox_' . $shortcode['style_variation'],
				plugins_url( 'radiantthemes-addons/fancytextbox/css/radiantthemes-fancy-text-box-element-' . $shortcode['style_variation'] . '.css' )
			);
			wp_enqueue_style( 'radiantthemes_fancytextbox_' . $shortcode['style_variation'] );

			// allowed metrics: http://www.w3schools.com/cssref/css_units.asp.
			$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';

			if ( ! empty( $shortcode['fancy_font_size'] ) ) {
				$shortcode['fancy_font_size'] = preg_replace( '/\s+/', '', $shortcode['fancy_font_size'] );

				$regexr_font_size             = preg_match( $pattern, $shortcode['fancy_font_size'], $matches );
				$shortcode['fancy_font_size'] = isset( $matches[1] ) ? (float) $matches[1] : (float) $shortcode['fancy_font_size'];
				$unit                         = isset( $matches[2] ) ? $matches[2] : 'px';
				$shortcode['fancy_font_size'] = $shortcode['fancy_font_size'] . $unit;

				$styles[] = 'font-size: ' . $shortcode['fancy_font_size'];
			}

			if ( ! empty( $shortcode['fancy_line_height'] ) ) {
				$shortcode['fancy_line_height'] = preg_replace( '/\s+/', '', $shortcode['fancy_line_height'] );

				$regexr_line_height             = preg_match( $pattern, $shortcode['fancy_line_height'], $matches );
				$shortcode['fancy_line_height'] = isset( $matches[1] ) ? (float) $matches[1] : (float) $shortcode['fancy_line_height'];
				$unit                           = isset( $matches[2] ) ? $matches[2] : 'px';
				$shortcode['fancy_line_height'] = $shortcode['fancy_line_height'] . $unit;

				$styles[] = 'line-height: ' . $shortcode['fancy_line_height'];
			}

			$url = vc_build_link( $shortcode['button_link'] );
			$rel = '';
			if ( ! empty( $url['rel'] ) ) {
				$rel = ' rel="' . esc_attr( $url['rel'] ) . '"';
			}
			// Enqueue needed icon font.
			vc_icon_element_fonts_enqueue( $shortcode['type'] );

			$icon_class = isset( $shortcode{'icon_' . $shortcode['type']} ) ? esc_attr( $shortcode{'icon_' . $shortcode['type']} ) : 'fa fa-adjust';

			$icon_class = isset( $shortcode['icon_fontawesome'] ) ? esc_attr( $shortcode['icon_fontawesome'] ) : 'fa fa-adjust';
			if ( 'openiconic' === $shortcode['type'] ) {
				$icon_class = isset( $shortcode['openiconic'] ) ? esc_attr( $shortcode['openiconic'] ) : 'vc-oi vc-oi-dial';
			} elseif ( 'typicons' === $shortcode['type'] ) {
				$icon_class = isset( $shortcode['typicons'] ) ? esc_attr( $shortcode['typicons'] ) : 'typcn typcn-adjust-brightness';
			} elseif ( 'entypo' === $shortcode['type'] ) {
				$icon_class = isset( $shortcode['entypo'] ) ? esc_attr( $shortcode['entypo'] ) : 'entypo-icon entypo-icon-note';
			} elseif ( 'linecons' === $shortcode['type'] ) {
				$icon_class = isset( $shortcode['linecons'] ) ? esc_attr( $shortcode['linecons'] ) : 'vc_li vc_li-heart';
			} elseif ( 'monosocial' === $shortcode['type'] ) {
				$icon_class = isset( $shortcode['monosocial'] ) ? esc_attr( $shortcode['monosocial'] ) : 'vc-mono vc-mono-fivehundredpx';
			} elseif ( 'material' === $shortcode['type'] ) {
				$icon_class = isset( $shortcode['material'] ) ? esc_attr( $shortcode['material'] ) : 'vc-material vc-material-cake';
			}

			if ( ! empty( $styles ) ) {
				$style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
			} else {
				$style = '';
			}

			$class = 'class="fancy-text-tag" ';

			$ourstory_id = $shortcode['extra_id'] ? 'id="' . esc_attr( $shortcode['extra_id'] ) . '"' : '';

			if ( 'yes' === $shortcode['add_shadow'] ) {
				$shadow = $shortcode['add_shadow'] ? 'hover-active-on' : '';
			} elseif ( 'hover' === $shortcode['add_shadow'] ) {
				$shadow = $shortcode['add_shadow'] ? 'hover-active' : '';
			} elseif ( 'none' === $shortcode['add_shadow'] ) {
				$shadow = '';
			} else {
				$shadow = '';
			}

			$output  = "\r" . '<!-- fancy-text-box -->' . "\r";
			$output .= '<div class="rt-fancy-text-box element-' . $shortcode['style_variation'] . ' ' . $shadow;
			$output .= ' ' . $animation_classes . ' ' . $shortcode['extra_class'] . '"  ' . $ourstory_id;
			$output .= ' data-fancy-text-box-align="' . esc_attr( $shortcode['align'] ) . '">';

			require 'template/template-fancy-text-box-' . $shortcode['style_variation'] . '.php';

			$output .= '</div>' . "\r";
			$output .= '<!-- fancy-text-box -->' . "\r";
			return $output;
		}
	}
}
