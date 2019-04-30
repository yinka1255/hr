<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/

	add_action('plugins_loaded', 'gdlr_core_portfolio_add_pb_element');
	if( !function_exists('gdlr_core_portfolio_add_pb_element') ){
		function gdlr_core_portfolio_add_pb_element(){

			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('portfolio', 'gdlr_core_pb_element_portfolio'); 
			}
			
		}
	}
	
	if( !class_exists('gdlr_core_pb_element_portfolio') ){
		class gdlr_core_pb_element_portfolio{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-outdent',
					'title' => esc_html__('Portfolio', 'goodlayers-core-portfolio')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return apply_filters('gdlr_core_portfolio_item_options', array(					
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core-portfolio'),
						'options' => array(

							'category' => array(
								'title' => esc_html__('Category', 'goodlayers-core-portfolio'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('portfolio_category'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'goodlayers-core-portfolio'),
							),
							'tag' => array(
								'title' => esc_html__('Tag', 'goodlayers-core-portfolio'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('portfolio_tag')
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 9,
								'description' => esc_html__('The number of posts showing on the blog item', 'goodlayers-core-portfolio')
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'goodlayers-core-portfolio'), 
									'title' => esc_html__('Title', 'goodlayers-core-portfolio'), 
									'rand' => esc_html__('Random', 'goodlayers-core-portfolio'), 
								)
							),
							'order' => array(
								'title' => esc_html__('Order', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'desc'=>esc_html__('Descending Order', 'goodlayers-core-portfolio'), 
									'asc'=> esc_html__('Ascending Order', 'goodlayers-core-portfolio'), 
								)
							),
							'filterer' => array(
								'title' => esc_html__('Category Filterer', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'none'=>esc_html__('None', 'goodlayers-core-portfolio'), 
									'text'=>esc_html__('Filter Text Style', 'goodlayers-core-portfolio'), 
									'button'=>esc_html__('Filter Button Style', 'goodlayers-core-portfolio'), 
								),
								'description' => esc_html__('Filter is not supported and will be automatically disabled on carousel layout.', 'goodlayers-core-portfolio'),
							),
							'filterer-align' => array(
								'title' => esc_html__('Filterer Alignment', 'goodlayers-core-portfolio'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center',
								'condition' => array('filterer' => array('text', 'button'))
							),
							'pagination' => array(
								'title' => esc_html__('Pagination', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'none'=>esc_html__('None', 'goodlayers-core-portfolio'), 
									'page'=>esc_html__('Page', 'goodlayers-core-portfolio'), 
									'load-more'=>esc_html__('Load More', 'goodlayers-core-portfolio'), 
								),
								'description' => esc_html__('Pagination is not supported and will be automatically disabled on carousel layout.', 'goodlayers-core-portfolio'),
							),
							'pagination-style' => array(
								'title' => esc_html__('Pagination Style', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'goodlayers-core-portfolio'),
									'plain' => esc_html__('Plain', 'goodlayers-core-portfolio'),
									'rectangle' => esc_html__('Rectangle', 'goodlayers-core-portfolio'),
									'rectangle-border' => esc_html__('Rectangle Border', 'goodlayers-core-portfolio'),
									'round' => esc_html__('Round', 'goodlayers-core-portfolio'),
									'round-border' => esc_html__('Round Border', 'goodlayers-core-portfolio'),
									'circle' => esc_html__('Circle', 'goodlayers-core-portfolio'),
									'circle-border' => esc_html__('Circle Border', 'goodlayers-core-portfolio'),
								),
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
							'pagination-align' => array(
								'title' => esc_html__('Pagination Alignment', 'goodlayers-core-portfolio'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'with-default' => true,
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
							
						),
					),
					'settings' => array(
						'title' => esc_html('Portfolio Style', 'goodlayers-core-portfolio'),
						'options' => array(
							'portfolio-style' => array(
								'title' => esc_html__('Portfolio Style', 'goodlayers-core-portfolio'),
								'type' => 'radioimage',
								'options' => array(
									'modern' => plugins_url('', __FILE__) . '/images/modern.png',
									'modern-no-space' => plugins_url('', __FILE__) . '/images/modern-no-space.png',
									'grid' => plugins_url('', __FILE__) . '/images/grid.png',
									'grid-no-space' => plugins_url('', __FILE__) . '/images/grid-no-space.png',
									'modern-desc' => plugins_url('', __FILE__) . '/images/modern-desc.png',
									'modern-desc-no-space' => plugins_url('', __FILE__) . '/images/modern-desc-no-space.png',
									'metro' => plugins_url('', __FILE__) . '/images/metro.png',
									'metro-no-space' => plugins_url('', __FILE__) . '/images/metro-no-space.png',
									'medium' => plugins_url('', __FILE__) . '/images/medium.png',
								),
								'default' => 'modern',
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'portfolio-grid-text-align' => array(
								'title' => esc_html__('Text Align', 'goodlayers-core-portfolio'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'left',
								'condition' => array( 'portfolio-style' => array( 'grid', 'grid-no-space' ) )
							),
							'portfolio-grid-style' => array(
								'title' => esc_html__('Content Style', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'normal' => esc_html__('Normal', 'goodlayers-core-portfolio'),
									'with-frame' => esc_html__('With Frame', 'goodlayers-core-portfolio'),
									'with-bottom-border' => esc_html__('With Bottom Border', 'goodlayers-core-portfolio'),
								),
								'default' => 'normal',
								'condition' => array( 'portfolio-style' => array( 'grid', 'grid-no-space' ) )
							),
							'portfolio-frame-opacity' => array(
								'title' => esc_html__('Frame Opacity', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'default' => '1',
								'description' => esc_html__('Fill the decimal number between 0 to 1', 'goodlayers-core'),
								'condition' => array( 'portfolio-style' => array( 'grid', 'grid-no-space' ), 'portfolio-grid-style' => 'with-frame' )
							),
							'enable-portfolio-tag' => array(
								'title' => esc_html__('Enable Portfolio Tag', 'goodlayers-core-portfolio'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
							),
							'portfolio-medium-size' => array(
								'title' => esc_html__('Thumbnail Size', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'small' => esc_html__('Small', 'goodlayers-core-portfolio'),
									'large' => esc_html__('Large', 'goodlayers-core-portfolio'),
								),
								'condition' => array( 'portfolio-style' => 'medium' )
							),
							'portfolio-medium-style' => array(
								'title' => esc_html__('Thumbnail Style', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'left' => esc_html__('Left', 'goodlayers-core-portfolio'),
									'right' => esc_html__('Right', 'goodlayers-core-portfolio'),
									'switch' => esc_html__('Switch ( Between Left and Right )', 'goodlayers-core-portfolio'),
								),
								'condition' => array( 'portfolio-style' => 'medium' )
							),
							'hover' => array(
								'title' => esc_html__('Hover Style', 'goodlayers-core-portfolio'),
								'type' => 'radioimage',
								'options' => array(
									'title' => plugins_url('', __FILE__) . '/images/hover/title.png',
									'title-icon' => plugins_url('', __FILE__) . '/images/hover/title-icon.png',
									'title-tag' => plugins_url('', __FILE__) . '/images/hover/title-tag.png',
									'icon-title-tag' => plugins_url('', __FILE__) . '/images/hover/icon-title-tag.png',
									'icon' => plugins_url('', __FILE__) . '/images/hover/icon.png',
									'margin-title' => plugins_url('', __FILE__) . '/images/hover/margin-title.png',
									'margin-title-icon' => plugins_url('', __FILE__) . '/images/hover/margin-title-icon.png',
									'margin-title-tag' => plugins_url('', __FILE__) . '/images/hover/margin-title-tag.png',
									'margin-icon-title-tag' => plugins_url('', __FILE__) . '/images/hover/margin-icon-title-tag.png',
									'margin-icon' => plugins_url('', __FILE__) . '/images/hover/margin-icon.png',
									'none' => plugins_url('', __FILE__) . '/images/hover/none.png',
								),
								'default' => 'title-icon',
								'max-width' => '100px',
								'condition' => array( 'portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'metro', 'metro-no-space', 'medium') ),
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'column-size' => array(
								'title' => esc_html__('Column Size', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array( 60=>1, 30=>2, 20=>3, 15=>4, 12=>5 ),
								'default' => 20,
								'condition' => array( 'portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'metro', 'metro-no-space') )
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => 'thumbnail-size'
							),
							'enable-thumbnail-zoom-on-hover' => array(
								'title' => esc_html__('Thumbnail Zoom on Hover', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
							),
							'enable-thumbnail-grayscale-effect' => array(
								'title' => esc_html__('Enable Thumbnail Grayscale Effect', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable',
								'description' => esc_html__('Only works with browser that supports css3 filter ( http://caniuse.com/#feat=css-filters ).', 'goodlayers-core')
							),
							'enable-badge' => array(
								'title' => esc_html__('Enable Badge', 'goodlayers-core-portfolio'),
								'type' => 'checkbox',
								'default' => 'disable',
								'description' => esc_html__('You can enable badge for each portfolio at the page option area.', 'goodlayers-core-portfolio')
							),
							'layout' => array(
								'title' => esc_html__('Layout', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array( 
									'fitrows' => esc_html__('Fit Rows', 'goodlayers-core-portfolio'),
									'carousel' => esc_html__('Carousel', 'goodlayers-core-portfolio'),
									'masonry' => esc_html__('Masonry', 'goodlayers-core-portfolio'),
								),
								'default' => 'fitrows',
								'condition' => array( 'portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium') )
							),
							'carousel-autoslide' => array(
								'title' => esc_html__('Autoslide Carousel', 'goodlayers-core-portfolio'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium'), 'layout' => 'carousel' )
							),
							'carousel-navigation' => array(
								'title' => esc_html__('Carousel Navigation', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'navigation' => esc_html__('Only Navigation', 'goodlayers-core-portfolio'),
									'bullet' => esc_html__('Only Bullet', 'goodlayers-core-portfolio'),
									'both' => esc_html__('Both Navigation and Bullet', 'goodlayers-core-portfolio'),
								),
								'default' => 'navigation',
								'condition' => array( 'portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium'), 'layout' => 'carousel' )
							),
							'excerpt' => array(
								'title' => esc_html__('Excerpt Type', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'specify-number' => esc_html__('Specify Number', 'goodlayers-core-portfolio'),
									'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'goodlayers-core-portfolio'),
									'none' => esc_html__('Disable Exceprt', 'goodlayers-core-portfolio'),
								),
								'default' => 'specify-number',
								'condition' => array( 'portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
							),
							'excerpt-number' => array(
								'title' => esc_html__('Excerpt Number', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'default' => 55,
								'condition' => array( 'portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ), 'excerpt' => 'specify-number' )
							),
						),
					),
					'overlay' => array(
						'title' => esc_html('Overlay Color', 'goodlayers-core-portfolio'),
						'options' => array(
							'overlay-color' => array(
								'title' => esc_html__('Image Overlay Color', 'goodlayers-core-portfolio'),
								'type' => 'colorpicker'
							),
							'overlay-opacity' => array(
								'title' => esc_html__('Image Overlay Opacity', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'description' =>  esc_html__('Fill the number between 0 to 1', 'goodlayers-core-portfolio') . '. ' .
									esc_html__('You need to specify the "Image Overlay Color" to use this option', 'goodlayers-core-portfolio')
							),
						)
					),
					'typography' => array(
						'title' => esc_html('Typography', 'goodlayers-core-portfolio'),
						'options' => array(
							'portfolio-title-font-size' => array(
								'title' => esc_html__('Portfolio Title Font Size', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'portfolio-title-font-weight' => array(
								'title' => esc_html__('Portfolio Title Font Weight', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'goodlayers-core')
							),
							'portfolio-title-letter-spacing' => array(
								'title' => esc_html__('Portfolio Title Letter Spacing', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'portfolio-title-text-transform' => array(
								'title' => esc_html__('Portfolio Title Text Transform', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'uppercase' => esc_html__('Uppercase', 'goodlayers-core-portfolio'),
									'lowercase' => esc_html__('Lowercase', 'goodlayers-core-portfolio'),
									'capitalize' => esc_html__('Capitalize', 'goodlayers-core-portfolio'),
									'none' => esc_html__('None', 'goodlayers-core-portfolio'),
								),
								'default' => 'uppercase'
							),
							'portfolio-hover-title-font-size' => array(
								'title' => esc_html__('Portfolio Hover Title Font Size', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'portfolio-hover-title-font-weight' => array(
								'title' => esc_html__('Portfolio Hover Title Font Weight', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'goodlayers-core')
							),
							'portfolio-hover-title-letter-spacing' => array(
								'title' => esc_html__('Portfolio Hover Title Letter Spacing', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'portfolio-hover-title-text-transform' => array(
								'title' => esc_html__('Portfolio Hover Title Text Transform', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'uppercase' => esc_html__('Uppercase', 'goodlayers-core-portfolio'),
									'lowercase' => esc_html__('Lowercase', 'goodlayers-core-portfolio'),
									'capitalize' => esc_html__('Capitalize', 'goodlayers-core-portfolio'),
									'none' => esc_html__('None', 'goodlayers-core-portfolio'),
								),
								'default' => 'uppercase'
							),
						)
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core-portfolio'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					),
					'item-title' => array(
						'title' => esc_html('Item Title', 'goodlayers-core-portfolio'),
						'options' => array(
							'title-align' => array(
								'title' => esc_html__('Title Align', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'left' => esc_html__('Left', 'goodlayers-core-portfolio'),
									'center' => esc_html__('Center', 'goodlayers-core-portfolio'),
								),
								'default' => 'left',
							),
							'title' => array(
								'title' => esc_html__('Title', 'goodlayers-core-portfolio'),
								'type' => 'text',
							),
							'caption' => array(
								'title' => esc_html__('Caption', 'goodlayers-core-portfolio'),
								'type' => 'textarea',
							),
							'read-more-text' => array(
								'title' => esc_html__('Read More Text', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'default' => esc_html__('Read More', 'goodlayers-core-portfolio'),
								'condition' => array( 'title-align' => 'left' )
							),
							'read-more-link' => array(
								'title' => esc_html__('Read More Link', 'goodlayers-core-portfolio'),
								'type' => 'text',
								'condition' => array( 'title-align' => 'left' )
							),
							'read-more-target' => array(
								'title' => esc_html__('Read More Target', 'goodlayers-core-portfolio'),
								'type' => 'combobox',
								'options' => array(
									'_self' => esc_html__('Current Screen', 'goodlayers-core-portfolio'),
									'_blank' => esc_html__('New Window', 'goodlayers-core-portfolio'),
								),
								'condition' => array( 'title-align' => 'left' )
							),
							'title-size' => array(
								'title' => esc_html__('Title Size', 'goodlayers-core-portfolio'),
								'type' => 'fontslider',
								'default' => '41px'
							),
							'caption-size' => array(
								'title' => esc_html__('Caption Size', 'goodlayers-core-portfolio'),
								'type' => 'fontslider',
								'default' => '16px'
							),
							'read-more-size' => array(
								'title' => esc_html__('Read More Size', 'goodlayers-core-portfolio'),
								'type' => 'fontslider',
								'default' => '14px',
								'condition' => array( 'title-align' => 'left' )
							),
							'title-color' => array(
								'title' => esc_html__('Title Color', 'goodlayers-core-portfolio'),
								'type' => 'colorpicker'
							),
							'caption-color' => array(
								'title' => esc_html__('Caption Color', 'goodlayers-core-portfolio'),
								'type' => 'colorpicker'
							),
							'read-more-color' => array(
								'title' => esc_html__('Read More Color', 'goodlayers-core-portfolio'),
								'type' => 'colorpicker',
								'condition' => array( 'title-align' => 'left' )
							),
							'read-more-divider-color' => array(
								'title' => esc_html__('Read More Divider Color', 'goodlayers-core-portfolio'),
								'type' => 'colorpicker',
								'condition' => array( 'title-align' => 'left' )
							),
						)
					)
				));
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-portfolio-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-portfolio-<?php echo esc_attr($id); ?>').parent()
		.gdlr_core_lightbox().gdlr_core_flexslider().gdlr_core_isotope().gdlr_core_fluid_video();
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
						'category' => '', 'tag' => '', 'num-fetch' => '9', 'thumbnail-size' => 'full', 'orderby' => 'date', 'order' => 'desc', 'pagination' => 'none',
						'portfolio-style' => 'modern', 'hover' => 'title-icon', 'excerpt' => 'specify-number', 'excerpt-number' => 55, 'show-read-more' => 'enable', 'column-size' => 20,
						'show-thumbnail' => 'enable',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				$settings['portfolio-style'] = empty($settings['portfolio-style'])? 'modern': $settings['portfolio-style'];
				$settings['no-space'] = (strpos($settings['portfolio-style'], 'no-space') !== false)? 'yes': 'no';
				$settings['hover-info'] = empty($settings['hover'])? array(): explode('-', $settings['hover']);
				$settings['layout'] = empty($settings['layout'])? 'fitrows': $settings['layout'];
				if( in_array($settings['portfolio-style'], array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space')) ){
					$settings['has-column'] = 'yes';
				}else if( in_array($settings['portfolio-style'], array('metro', 'metro-no-space')) ){
					$settings['has-column'] = 'yes';
					$settings['layout'] = 'masonry';
				}else{
					$settings['has-column'] = 'no';
					$settings['column-size'] = 60;
					if( $settings['layout'] == 'masonry' ){
						$settings['layout'] = 'fitrows';
					}else if( $settings['layout'] == 'carousel' ){
						if( $settings['portfolio-style'] != 'medium' ){
							$settings['layout'] = 'fitrows';
						}
					}
				}

				// start printing item
				$extra_class  = ' gdlr-core-portfolio-item-style-' . $settings['portfolio-style'];
				$extra_class .= (empty($settings['enable-badge']) || $settings['enable-badge'] == 'disable')? '': ' gdlr-core-with-badge';

				$title_settings = $settings;
				if( $settings['no-space'] == 'yes' || $settings['layout'] == 'carousel' ){
					$title_settings['pdlr'] = false;
					$extra_class .= ' gdlr-core-item-pdlr';
				}
				if( $settings['layout'] == 'carousel' ){
					$title_settings['carousel'] = 'enable';
				}

				$ret  = '<div class="gdlr-core-portfolio-item gdlr-core-item-pdb clearfix ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				// print title
				$ret .= gdlr_core_block_item_title($title_settings);
				
				// pring portfolio item
				$portfolio_item = new gdlr_core_portfolio_item($settings);

				$ret .= $portfolio_item->get_content();
				
				$ret .= '</div>'; // gdlr-core-portfolio-item
				
				return $ret;
			}			
			
		} // gdlr_core_pb_element_portfolio
	} // class_exists	