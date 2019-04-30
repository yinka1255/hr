<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('stunning-text', 'gdlr_core_pb_element_stunning_text'); 
	
	if( !class_exists('gdlr_core_pb_element_stunning_text') ){
		class gdlr_core_pb_element_stunning_text{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_volume-high_alt',
					'title' => esc_html__('Stunning Text', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'caption' => array(
								'title' => esc_html__('Caption', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Stunning Text Item Caption', 'goodlayers-core'),
							),
							'title' => array(
								'title' => esc_html__('Title', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Stunning Text Item Title', 'goodlayers-core'),
							),
							'content' => array(
								'title' => esc_html__('Content', 'goodlayers-core'),
								'type' => 'tinymce',
								'default' => esc_html__('Stunning text item sample content', 'goodlayers-core'),
								'wrapper-class' => 'gdlr-core-fullsize'
							),			
							'button-text' => array(
								'title' => esc_html__('Button Text', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Learn More', 'goodlayers-core'),
							),
							'button-link' => array(
								'title' => esc_html__('Button Link', 'goodlayers-core'),
								'type' => 'text',
								'default' => '#'
							),
							'button-link-target' => array(
								'title' => esc_html__('Button Link Target', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'_self' => esc_html__('Current Screen', 'goodlayers-core'),
									'_blank' => esc_html__('New Window', 'goodlayers-core'),
								),
								'default' => '_self'
							),
						)
					),
					'style' => array(
						'title' => esc_html('Style', 'goodlayers-core'),
						'options' => array(
							'text-align' => array(
								'title' => esc_html__('Text Align', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center'
							),
							'caption-position' => array(
								'title' => esc_html__('Caption Position', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'above-title' => esc_html__('Above Title', 'goodlayers-core'),
									'below-title' => esc_html__('Below Title', 'goodlayers-core'),
								),
								'default' => 'above-title'
							)
						)
					),
					'typography' => array(
						'title' => esc_html('Typography', 'goodlayers-core'),
						'options' => array(
							'title-size' => array(
								'title' => esc_html__('Title Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '41px'
							),
							'caption-size' => array(
								'title' => esc_html__('Caption Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '16px'
							),
							'content-size' => array(
								'title' => esc_html__('Content Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '16px'
							),
							'link-size' => array(
								'title' => esc_html__('Link Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '15px'
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
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array() ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'caption' => esc_html__('Stunning Text Item Caption', 'goodlayers-core'),
						'title' => esc_html__('Stunning Text Item Title', 'goodlayers-core'),
						'content' => esc_html__('Stunning text item sample content', 'goodlayers-core'),
						'button-text' => esc_html__('Learn More', 'goodlayers-core'),
						'button-link' => '#',

						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// default value
				$settings['text-align'] = empty($settings['text-align'])? 'center': $settings['text-align'];
				$settings['caption-position'] = empty($settings['caption-position'])? 'above-title': $settings['caption-position'];
				$settings['button-link-target'] = empty($settings['button-link-target'])? '_self': $settings['button-link-target'];

				$settings['title-size'] = (empty($settings['title-size']) || $settings['title-size'] == '41px')? '': $settings['title-size'];
				$settings['caption-size'] = (empty($settings['caption-size']) || $settings['caption-size'] == '16px')? '': $settings['caption-size'];
				$settings['content-size'] = (empty($settings['content-size']) || $settings['content-size'] == '16px')? '': $settings['content-size'];
				$settings['link-size'] = (empty($settings['link-size']) || $settings['link-size'] == '15px')? '': $settings['link-size'];
				
				// start printing item
				$extra_class  = ' gdlr-core-' . (empty($settings['text-align'])? 'left': $settings['text-align']) . '-align';
				$extra_class .= ' gdlr-core-stunning-text-caption-' . $settings['caption-position'];
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="gdlr-core-stunning-text-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				if( !empty($settings['caption']) && $settings['caption-position'] == 'above-title' ){
					$ret .= '<div class="gdlr-core-stunning-text-item-caption gdlr-core-info-font gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['caption-size']
					)) . ' >' . gdlr_core_text_filter($settings['caption']) . '</div>';
				}
				if( !empty($settings['title']) ){
					$ret .= '<h3 class="gdlr-core-stunning-text-item-title" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['title-size']
					)) . '>' . gdlr_core_text_filter($settings['title']) . '</h3>';
				}
				if( !empty($settings['caption']) && $settings['caption-position'] == 'below-title' ){
					$ret .= '<div class="gdlr-core-stunning-text-item-caption gdlr-core-info-font gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['caption-size']
					)) . ' >' . gdlr_core_text_filter($settings['caption']) . '</div>';
				}
				if( !empty($settings['content']) ){
					$ret .= '<div class="gdlr-core-stunning-text-item-content" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['content-size']
					)) . ' >' . gdlr_core_content_filter($settings['content']) . '</div>';
				}
				if( !empty($settings['button-text']) && !empty($settings['button-link']) ){
					$ret .= '<a class="gdlr-core-stunning-text-item-link gdlr-core-info-font" href="' . esc_attr($settings['button-text']) . '" ';
					$ret .= 'target="' . esc_attr($settings['button-link-target']) . '" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['link-size']
					)) . ' >' . gdlr_core_text_filter($settings['button-text']) . '</a>';
				}
				$ret .= '</div>';
			
				return $ret;
			}
			
		} // gdlr_core_pb_element_stunning_text
	} // class_exists	