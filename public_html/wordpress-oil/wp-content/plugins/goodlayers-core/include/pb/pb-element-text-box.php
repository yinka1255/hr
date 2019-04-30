<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('text-box', 'gdlr_core_pb_element_text_box'); 
	
	if( !class_exists('gdlr_core_pb_element_text_box') ){
		class gdlr_core_pb_element_text_box{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-align-justify',
					'title' => esc_html__('Text Box', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'content' => array(
								'title' => esc_html__('Content', 'goodlayers-core'),
								'type' => 'tinymce',
								'default' => esc_html__('Text box item sample content', 'goodlayers-core'),
								'wrapper-class' => 'gdlr-core-fullsize'
							),		
							'text-align' => array(
								'title' => esc_html__('Text Align', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'left'
							)
						)
					),
					'typography' => array(
						'title' => esc_html('Typography', 'goodlayers-core'),
						'options' => array(
							'font-size' => array(
								'title' => esc_html__('Font Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '',
								'description' => esc_html__('Leaving this field blank will display the default font size from theme options', 'goodlayers-core'),
							)
						)
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					)
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-text-box-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-text-box-<?php echo esc_attr($id); ?>').parent().gdlr_core_content_script();
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
						'content' => esc_html__('Text box item sample content', 'goodlayers-core'),
						'text-align' => 'left',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// start printing item
				$extra_class  = 'gdlr-core-' . (empty($settings['text-align'])? 'left': $settings['text-align']) . '-align';
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="gdlr-core-text-box-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				if( !empty($settings['content']) ){
					$ret .= '<div class="gdlr-core-text-box-item-content" ' . gdlr_core_esc_style(array(
						'font-size' => empty($settings['font-size'])? '': $settings['font-size']
					)) . ' >' . gdlr_core_content_filter($settings['content']) . '</div>';
				}
				$ret .= '</div>';
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_text_box
	} // class_exists	