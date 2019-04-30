<?php
/**
 * Separator Style Addon
 *
 * @package Radiantthemes
 */

if ( class_exists( 'WPBakeryShortCode' ) && ! class_exists( 'Radiantthemes_Style_Pricing_Table' ) ) {

	/**
	 * Class definition.
	 */
	class Radiantthemes_Style_Pricing_Table extends WPBakeryShortCode {
		/**
		 * [__construct description]
		 */
		public function __construct() {
			vc_map(
				array(
					'name'        => esc_html__( 'Pricing Item', 'radiantthemes-addons' ),
					'base'        => 'rt_pricing_table_style',
					'description' => esc_html__( 'Add pricing item with multiple styles.', 'radiantthemes-addons' ),
					'icon'        => plugins_url( 'radiantthemes-addons/pricingtable/icon/PricingTable-Element-Icon.png' ),
					'class'       => 'wpb_rt_vc_extension_blog_style',
					'category'    => esc_html__( 'Radiant Elements', 'radiantthemes-addons' ),
					'controls'    => 'full',
					'params'      => array(
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Pricing Style', 'radiantthemes-addons' ),
							'param_name'  => 'style_variation',
							'value'       => array(
								esc_html__( 'Style One', 'radiantthemes-addons' )   => 'one',
								esc_html__( 'Style Two', 'radiantthemes-addons' )   => 'two',
								esc_html__( 'Style Three', 'radiantthemes-addons' ) => 'three',
								esc_html__( 'Style Four', 'radiantthemes-addons' )  => 'four',
								esc_html__( 'Style Five', 'radiantthemes-addons' )  => 'five',
								esc_html__( 'Style Six', 'radiantthemes-addons' )   => 'six',
							),
							'std'         => 'one',
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'radiantthemes-addons' ),
							'param_name'  => 'title',
							'value'       => esc_html__( 'This is pricing item element', 'radiantthemes-addons' ),
							'admin_label' => true,
						),
						array(
							'type'        => 'textarea_html',
							'heading'     => esc_html__( 'Content', 'radiantthemes-addons' ),
							'param_name'  => 'content',
							'value'       => esc_html__(
								'<ul>
									<li>Free Hand</li>
									<li>Gym Fitness</li>
									<li>Running</li>
							  	</ul>', 'radiantthemes-addons'
							),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Price with Currency', 'radiantthemes-addons' ),
							'param_name'  => 'currency',
							'value'       => '$189',
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Period', 'radiantthemes-addons' ),
							'param_name'  => 'period',
							'value'       => esc_html__( 'Per Month', 'radiantthemes-addons' ),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Button | Title', 'radiantthemes-addons' ),
							'param_name'  => 'button',
							'value'       => esc_html__( 'Sign Up Now!', 'radiantthemes-addons' ),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Button | Link', 'radiantthemes-addons' ),
							'param_name'  => 'button_link',
							'admin_label' => true,

						),
                        array(
							"type"       => "colorpicker",
							"class"      => "",
							"heading"    => esc_html__( "Button color", "radiantthemes" ),
							"param_name" => "button_color",
							"value"      => '#2e56d9',
							'dependency' => array(
									'element' => 'style_variation',
									'value'   => array(
														'four',
														'six',
													),
									),
                            "description" => esc_html__( "Choose button color", "radiantthemes" )
                            ),
                            array(
							"type"       => "colorpicker",
							"class"      => "",
							"heading"    => esc_html__( "Background Color", "radiantthemes" ),
							"param_name" => "background_color",
							"value"      => '#2c3346',
							'dependency' => array(
												'element' => 'style_variation',
												'value'   => array(
																'four',
																'six',
															),
												),
                            "description" => esc_html__( "Choose background color", "radiantthemes" )
                                ),
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Highlight', 'radiantthemes-addons' ),
							'description' => esc_html__( 'If checked, item will be highlight By priority', 'radiantthemes-addons' ),
							'value'       => array(
												esc_html__( 'Yes', 'radiantthemes-addons' ) => 'spotlight',
											),
							'param_name'  => 'highlight',
							'admin_label' => true,

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
					),
				)
			);
			add_shortcode( 'rt_pricing_table_style', array( $this, 'radiantthemes_pricing_table_style_func' ) );
		}

		/**
		 * [radiantthemes_pricing_table_style_func description]
		 *
		 * @param  [type] $atts    description.
		 * @param  [type] $content description.
		 * @param  [type] $tag     description.
		 * @return [type]          [description]
		 */
		public function radiantthemes_pricing_table_style_func( $atts, $content = null, $tag ) {
			$shortcode = shortcode_atts(
				array(
					'style_variation' => 'one',
					'title'           => 'This is pricing item element',
					'currency'        => '189',
					'period'          => 'Per Month',
					'button'          => 'Sign Up Now!',
					'button_link'     => '',
					'highlight'       => '',
                                        'background_color' => '#2c3346',
                                        'button_color'    => '#2e56d9',
					'animation'       => '',
					'extra_class'     => '',
					'extra_id'        => '',
				), $atts
			);

			// Build the animation classes.
			$animation_classes = $this->getCSSAnimation( $shortcode['animation'] );

			wp_register_style(
				'radiantthemes_pricing_table_' . $shortcode['style_variation'] . '',
				plugins_url( 'radiantthemes-addons/pricingtable/css/radiantthemes-pricing-table-element-' . $shortcode['style_variation'] . '.css' )
			);
			wp_enqueue_style( 'radiantthemes_pricing_table_' . $shortcode['style_variation'] . '' );
			?>
			<!-- rt-pricing-table -->
			<?php
                        $random_class = 'rt' . substr( md5( microtime() ), 0, 15 );
			$pricing_table_id = $shortcode['extra_id'] ? 'id="' . $shortcode['extra_id'] . '"' : '';
			$output           = '<!-- rt-pricing-table --><div class="rt-pricing-table element-' . $shortcode['style_variation'] . ' ' . $shortcode['highlight'] . ' ' . $animation_classes . ' '.$random_class.' ' . $shortcode['extra_class'] . '"  ' . $pricing_table_id . ' >';
			require 'template/template-pricing-item-' . $shortcode['style_variation'] . '.php';
			$output .= '</div>' . "\r";
			$output .= '<!-- rt-pricing-table -->' . "\r";
			return $output;
		}
	}
}
