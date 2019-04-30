<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('counter', 'gdlr_core_pb_element_counter_item'); 
	
	if( !class_exists('gdlr_core_pb_element_counter_item') ){
		class gdlr_core_pb_element_counter_item{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-circle-o-notch',
					'title' => esc_html__('Counter', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'top-text-type' => array(
								'title' => esc_html__('Top Text Type', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'icon' => esc_html__('Icon', 'goodlayers-core'),
									'text' => esc_html__('Text', 'goodlayers-core'),
								)
							),
							'top-icon' => array(
								'title' => esc_html__('Top Icon', 'goodlayers-core'),
								'type' => 'icons',
								'default' => 'fa fa-cloud',
								'condition' => array(
									'top-text-type' => 'icon'
								),
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'top-text' => array(
								'title' => esc_html__('Top Text', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array(
									'top-text-type' => 'text'
								)
							),
							'prefix' => array(
								'title' => esc_html__('Prefix', 'goodlayers-core'),
								'type' => 'text'
							),
							'start-number' => array(
								'title' => esc_html__('Start Number', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 0
							),
							'end-number' => array(
								'title' => esc_html__('End Number', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 99
							),					
							'animation-time' => array(
								'title' => esc_html__('Number Animation Time', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 4000,
								'description' => esc_html__('Fill the animation time in milli-second', 'goodlayers-core'),
							),
							'suffix' => array(
								'title' => esc_html__('Suffix', 'goodlayers-core'),
								'type' => 'text',
								'default' => '%'
							),
							'divider' => array(
								'title' => esc_html__('Divider', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable'
							),	
							'bottom-text' => array(
								'title' => esc_html__('Bottom Text', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Counter caption', 'goodlayers-core')
							),	
						),
					),
					'typography' => array(
						'title' => esc_html('Typography', 'goodlayers-core'),
						'options' => array(
							'top-icon-size' => array(
								'title' => esc_html__('Top Icon Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '30px'
							),
							'top-text-size' => array(
								'title' => esc_html__('Top Text Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '16px'
							),
							'number-size' => array(
								'title' => esc_html__('Number Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '59px'
							),
							'bottom-text-size' => array(
								'title' => esc_html__('Bottom Text Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '16px'
							),
							'bottom-text-transform' => array(
								'title' => esc_html__('Bottom Text Transform', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'uppercase' => esc_html__('Uppercase', 'goodlayers-core'),
									'lowercase' => esc_html__('Lowercase', 'goodlayers-core'),
									'capitalize' => esc_html__('Capitalize', 'goodlayers-core'),
									'none' => esc_html__('None', 'goodlayers-core'),
								),
								'default' => 'uppercase'
							),
						),
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							),
						),
					)
				);
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-counter-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-counter-<?php echo esc_attr($id); ?>').parent().gdlr_core_counter_item();
});
</script><?php	
				$content .= ob_get_contents();
				ob_end_clean();				
				return $content;
			}		
			
			// get the content from settings
			static function get_content( $settings = array() ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'top-text-type' => 'none', 'top-icon' => 'fa fa-cloud', 'top-text' => '', 'prefix' => '', 'start-number' => 0, 'end-number' => 99, 'suffix' => '%', 'divider' => 'enable', 
						'bottom-text' => esc_html__('Counter caption', 'goodlayers-core'),
						'animation-time' => '4000', 
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// default size
				$settings['top-icon-size'] = (empty($settings['top-icon-size']) || $settings['top-icon-size'] == '30px')? '': $settings['top-icon-size'];
				$settings['top-text-size'] = (empty($settings['top-text-size']) || $settings['top-text-size'] == '16px')? '': $settings['top-text-size'];
				$settings['number-size'] = (empty($settings['number-size']) || $settings['number-size'] == '59px')? '': $settings['number-size'];
				$settings['bottom-text-size'] = (empty($settings['bottom-text-size']) || $settings['bottom-text-size'] == '16px')? '': $settings['bottom-text-size'];

				// start printing item
				$extra_class  = empty($settings['class'])? '': $settings['class'];
				$ret  = '<div class="gdlr-core-counter-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				
				// top text
				if( !empty($settings['top-text-type']) ){
					if( $settings['top-text-type'] == 'text' ){
						$ret .= '<div class="gdlr-core-counter-item-top-text gdlr-core-skin-caption" ' . gdlr_core_esc_style(array('font-size'=>$settings['top-text-size'])) . ' >' . gdlr_core_text_filter($settings['top-text']) . '</div>';
					}else if( $settings['top-text-type'] == 'icon' ){
						$ret .= '<div class="gdlr-core-counter-item-top-icon" ' . gdlr_core_esc_style(array('font-size'=>$settings['top-icon-size'])) . ' ><i class="' . esc_attr($settings['top-icon']) . '" ></i></div>';
					}
				}
				
				// counter
				$ret .= '<div class="gdlr-core-counter-item-number gdlr-core-skin-title" ' . gdlr_core_esc_style(array('font-size'=>$settings['number-size'])) . ' >';
				if( !empty($settings['prefix']) ){
					$ret .= '<span class="gdlr-core-counter-item-prefix">' . gdlr_core_text_filter($settings['prefix']) . '</span>';
				}
				if( isset($settings['end-number']) ){
					$ret .= '<span class="gdlr-core-counter-item-count gdlr-core-js" ';
					$ret .= isset($settings['animation-time'])? 'data-duration="' . esc_attr($settings['animation-time']) . '" ': '';
					$ret .= isset($settings['start-number'])? 'data-counter-start="' . esc_attr($settings['start-number']) . '" ': '';
					$ret .= isset($settings['end-number'])? 'data-counter-end="' . esc_attr($settings['end-number']) . '" ': '';
					$ret .= '>' . gdlr_core_escape_content($settings['start-number']) . '</span>';
				}
				if( !empty($settings['suffix']) ){
					$ret .= '<span class="gdlr-core-counter-item-suffix">' . gdlr_core_escape_content($settings['suffix']) . '</span>';
				}
				$ret .= '</div>'; // gdlr-core-counter-item-number
				
				// divider
				if( !empty($settings['divider']) && $settings['divider'] == 'enable' ){
					$ret .= '<div class="gdlr-core-counter-item-divider gdlr-core-skin-divider"></div>';
				}
				
				// bottom text
				if( !empty($settings['bottom-text']) ){
					$ret .= '<div class="gdlr-core-counter-item-bottom-text gdlr-core-skin-content" ' . gdlr_core_esc_style(array(
						'font-size'=>$settings['bottom-text-size'], 
						'text-transform' => (empty($settings['bottom-text-transform']) || $settings['bottom-text-transform'] == 'uppercase')? '': $settings['bottom-text-transform']
					)) . ' >' . gdlr_core_text_filter($settings['bottom-text']) . '</div>';
				}
				$ret .= '</div>'; // gdlr-core-counter-item
				
				return $ret;
			}			
			
		} // gdlr_core_pb_element_column_service
	} // class_exists	