<?php
/**
 * Portfolio Style Addon
 *
 * @package Radiantthemes
 */

if ( class_exists( 'WPBakeryShortCode' ) && ! class_exists( 'Radiantthemes_Style_Portfolio' ) ) {

	/**
	 * Class definition.
	 */
	class Radiantthemes_Style_Portfolio extends WPBakeryShortCode {
		/**
		 * [__construct description]
		 */
		public function __construct() {
			vc_map(
				array(
					'name'        => esc_html__( 'Portfolio', 'radiantthemes-addons' ),
					'base'        => 'rt_portfolio_style',
					'description' => esc_html__( 'Add Portfolio with multiple styles.', 'radiantthemes-addons' ),
					'icon'        => plugins_url( 'radiantthemes-addons/portfolio/icon/Portfolio-Element-Icon.png' ),
					'class'       => 'wpb_rt_vc_extension_portfolio_style',
					'category'    => esc_html__( 'Radiant Elements', 'radiantthemes-addons' ),
					'controls'    => 'full',
					'params'      => array(
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Portfolio Style', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_style_variation',
							'value'      => array(
								esc_html__( 'Style One', 'radiantthemes-addons' )     => 'one',
								esc_html__( 'Style Two', 'radiantthemes-addons' )     => 'two',
								esc_html__( 'Style Three', 'radiantthemes-addons' )   => 'three',
								esc_html__( 'Style Four', 'radiantthemes-addons' )    => 'four',
								esc_html__( 'Style Five', 'radiantthemes-addons' )    => 'five',
								esc_html__( 'Style Six', 'radiantthemes-addons' )     => 'six',
							),
							'std'        => 'one',
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Portfolio Display Filter', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_display_filter',
							'value'      => array(
								esc_html__( 'Yes', 'radiantthemes-addons' ) => 'yes',
								esc_html__( 'No', 'radiantthemes-addons' )  => 'no',
							),
							'std'        => 'yes',
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Portfolio Filter Style', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_filter_style',
							'dependency' => array(
								'element' => 'portfolio_display_filter',
								'value'   => 'yes',
							),
							'value'      => array(
								esc_html__( 'Style One', 'radiantthemes-addons' )   => 'one',
								esc_html__( 'Style Two', 'radiantthemes-addons' )   => 'two',
								esc_html__( 'Style Three', 'radiantthemes-addons' ) => 'three',
								esc_html__( 'Style Four', 'radiantthemes-addons' )  => 'four',
								esc_html__( 'Style Five', 'radiantthemes-addons' )  => 'five',
								esc_html__( 'Style Six', 'radiantthemes-addons' )   => 'six',
								esc_html__( 'Style Seven', 'radiantthemes-addons' ) => 'seven',
							),
							'std'        => 'one',
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Portfolio Filter Align', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_filter_alignment',
							'dependency' => array(
								'element' => 'portfolio_display_filter',
								'value'   => 'yes',
							),
							'value'      => array(
								esc_html__( 'Left', 'radiantthemes-addons' )   => 'left',
								esc_html__( 'Right', 'radiantthemes-addons' )  => 'right',
								esc_html__( 'Center', 'radiantthemes-addons' ) => 'center',
							),
							'std'        => 'center',
						),
						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Portfolio Enable Load More', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_enable_loadmore',
							'value'      => esc_html__( 'No', 'radiantthemes-addons' ),
							'dependency' => array(
								'element' => 'portfolio_display_filter',
								'value'   => 'no',
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Item to show on first load', 'radiantthemes-addons' ),
							'param_name'  => 'portfolio_enable_loadmore_firstitems',
							'description' => esc_html__( 'How many items will display on first load? E.g. 6', 'radiantthemes-addons' ),
							'value'       => '6',
							'dependency'  => array(
								'element' => 'portfolio_enable_loadmore',
								'value'   => 'true',
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Item to show on "Load More" click', 'radiantthemes-addons' ),
							'param_name'  => 'portfolio_enable_loadmore_clickitems',
							'description' => esc_html__( 'How many items will display on "Load More" button click? E.g. 3', 'radiantthemes-addons' ),
							'value'       => '3',
							'dependency' => array(
								'element' => 'portfolio_enable_loadmore',
								'value'   => 'true',
							),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Portfolio Box Align', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_box_alignment',
							'value'      => array(
								esc_html__( 'Left', 'radiantthemes-addons' )   => 'left',
								esc_html__( 'Right', 'radiantthemes-addons' )  => 'right',
								esc_html__( 'Center', 'radiantthemes-addons' ) => 'center',
							),
							'std'        => 'center',
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Portfolio Box Number', 'radiantthemes-addons' ),
							'param_name'  => 'portfolio_box_number',
							'description' => esc_html__( 'Number of Portfolio Box to display in a grid.', 'radiantthemes-addons' ),
							'value'      => array(
								'3',
								'4',
							),
							'std'        => '3',
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Enable Zoom?', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_enable_zoom',
							'value'      => array(
								esc_html__( 'Yes', 'radiantthemes-addons' ) => 'yes',
								esc_html__( 'No', 'radiantthemes-addons' )  => 'no',
							),
							'std'        => 'no',
						),
                        array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Portfolio Enable Title?', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_enable_title',
							'value'      => array(
								esc_html__( 'Yes', 'radiantthemes-addons' ) => 'yes',
								esc_html__( 'No', 'radiantthemes-addons' )  => 'no',
							),
							'std'        => 'no',
						),
                        array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Portfolio Enable excerpt?', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_enable_excerpt',
							'value'      => array(
								esc_html__( 'Yes', 'radiantthemes-addons' ) => 'yes',
								esc_html__( 'No', 'radiantthemes-addons' )  => 'no',
							),
							'std'        => 'no',
						),
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Enable Link Button?', 'radiantthemes-addons' ),
							'description' => esc_html__( 'Button style can be controled from Theme Option > Button.', 'radiantthemes-addons' ),
							'param_name'  => 'portfolio_enable_link_button',
							'value'       => esc_html__( 'Yes', 'radiantthemes-addons' ),
							'dependency'  => array(
								'element' => 'portfolio_enable_zoom',
								'value'   => 'no',
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Link Button Text', 'radiantthemes-addons' ),
							'description' => esc_html__( 'Enter text for link button. E.g. Details', 'radiantthemes-addons' ),
							'param_name'  => 'portfolio_link_button_text',
							'value'       => 'Details',
							'dependency'  => array(
								'element' => 'portfolio_enable_link_button',
								'value'   => 'true',
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Spacing between Portfolio Items', 'radiantthemes-addons' ),
							'param_name'  => 'portfolio_spacing',
							'description' => esc_html__( 'Enter only the spacing value without unit. E.g. 30', 'radiantthemes-addons' ),
							'value'       => '0',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name for the container', 'radiantthemes-addons' ),
							'param_name'  => 'extra_class',
							'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'radiantthemes-addons' ),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Element ID', 'radiantthemes-addons' ),
							'param_name'  => 'extra_id',
							'description' => sprintf( wp_kses_post( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'radiantthemes-addons' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Order By', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_looping_order',
							'value'      => array(
								esc_html__( 'Date', 'radiantthemes-addons' )       => 'date',
								esc_html__( 'ID', 'radiantthemes-addons' )         => 'ID',
								esc_html__( 'Title', 'radiantthemes-addons' )      => 'title',
								esc_html__( 'Modified', 'radiantthemes-addons' )   => 'modified',
								esc_html__( 'Random', 'radiantthemes-addons' )     => 'random',
								esc_html__( 'Menu order', 'radiantthemes-addons' ) => 'menu_order',
							),
							'std'        => 'ID',
							'group'      => 'Looping',
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Sort Order', 'radiantthemes-addons' ),
							'param_name' => 'portfolio_looping_sort',
							'value'      => array(
								esc_html__( 'Ascending', 'radiantthemes-addons' )  => 'ASC',
								esc_html__( 'Descending', 'radiantthemes-addons' ) => 'DESC',
							),
							'std'        => 'DESC',
							'group'      => 'Looping',
						),
					),
				)
			);
			add_shortcode( 'rt_portfolio_style', array( $this, 'radiantthemes_portfolio_style_func' ) );
		}

		/**
		 * [radiantthemes_portfolio_style_func description]
		 *
		 * @param  [type] $atts    [description.
		 * @param  [type] $content [description.
		 * @param  [type] $tag     [description.
		 */
		public function radiantthemes_portfolio_style_func( $atts, $content = null, $tag ) {
			$shortcode = shortcode_atts(
				array(
					'portfolio_style_variation'    => 'one',
					'portfolio_display_filter'     => 'yes',
					'portfolio_filter_style'       => 'one',
					'portfolio_filter_alignment'   => 'center',
					'portfolio_box_alignment'      => 'center',
					'portfolio_box_number'         => '3',
					'portfolio_enable_zoom'        => 'no',
					'portfolio_enable_link_button' => 'true',
					'portfolio_link_button_text'   => 'Details',
					'portfolio_spacing'            => '0',
                    'portfolio_enable_title'       => '',
                    'portfolio_enable_excerpt'     => '',
					'extra_class'                  => '',
					'extra_id'                     => '',
					'portfolio_looping_order'      => 'ID',
					'portfolio_looping_sort'       => 'DESC',
				), $atts
			);

			wp_register_style(
				'fancybox',
				plugins_url( 'radiantthemes-addons/assets/css/jquery.fancybox.min.css' )
			);
			wp_enqueue_style( 'fancybox' );

			wp_register_style(
				'radiantthemes_portfolio_element_filter_style',
				plugins_url( 'radiantthemes-addons/portfolio/css/radiantthemes-portfolio-element-filter-style.css' )
			);
			wp_enqueue_style( 'radiantthemes_portfolio_element_filter_style' );

			wp_register_style(
				'radiantthemes_portfolio_' . $shortcode['portfolio_style_variation'] . '',
				plugins_url( 'radiantthemes-addons/portfolio/css/radiantthemes-portfolio-element-' . $shortcode['portfolio_style_variation'] . '.css' )
			);
			wp_enqueue_style( 'radiantthemes_portfolio_' . $shortcode['portfolio_style_variation'] . '' );

			wp_register_script(
				'isotope',
				plugins_url( 'radiantthemes-addons/assets/js/isotope.pkgd.min.js' ),
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script( 'isotope' );

			wp_register_script(
				'fancybox',
				plugins_url( 'radiantthemes-addons/assets/js/jquery.fancybox.min.js' ),
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script( 'fancybox' );

			wp_register_script(
				'radiantthemes_portfolio_' . $shortcode['portfolio_style_variation'],
				plugins_url( 'radiantthemes-addons/portfolio/js/radiantthemes-portfolio-element-' . $shortcode['portfolio_style_variation'] . '.js' ),
				array( 'jquery', 'isotope', 'fancybox' ),
				false,
				true
			);
			wp_enqueue_script( 'radiantthemes_portfolio_' . $shortcode['portfolio_style_variation'] );

			$hidden_filter = ( 'no' === $shortcode['portfolio_display_filter'] ) ? 'hidden' : '';

			$enable_zoom = ( 'yes' === $shortcode['portfolio_enable_zoom'] ) ? 'has-fancybox' : '';

			$spacing_value = ( $shortcode['portfolio_spacing'] / 2 );

			if ( '3' == $shortcode['portfolio_box_number'] ) {
				$portfolio_item_class = 'col-lg-4 col-md-4 col-sm-2 col-xs-12';
			} elseif ( '4' == $shortcode['portfolio_box_number'] ) {
				$portfolio_item_class = 'col-lg-3 col-md-3 col-sm-2 col-xs-12';
			} else {
				$portfolio_item_class = '';
			}

			require 'template/template-portfolio-style-' . esc_attr( $shortcode['portfolio_style_variation'] ) . '.php';

			return $output;
		}

	}
}
