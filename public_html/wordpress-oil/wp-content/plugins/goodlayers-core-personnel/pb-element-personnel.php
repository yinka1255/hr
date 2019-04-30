<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	add_action('plugins_loaded', 'gdlr_core_personnel_add_pb_element');
	if( !function_exists('gdlr_core_personnel_add_pb_element') ){
		function gdlr_core_personnel_add_pb_element(){

			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('personnel', 'gdlr_core_pb_element_personnel'); 
			}
			
		}
	}
	
	if( !class_exists('gdlr_core_pb_element_personnel') ){
		class gdlr_core_pb_element_personnel{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-outdent',
					'title' => esc_html__('Personnel', 'goodlayers-core-personnel')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(					
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core-personnel'),
						'options' => array(
							'category' => array(
								'title' => esc_html__('Category', 'goodlayers-core-personnel'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('personnel_category'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'goodlayers-core-personnel'),
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'goodlayers-core-personnel'),
								'type' => 'text',
								'default' => 9,
								'data-input-type' => 'number',
								'description' => esc_html__('The number of posts showing on the personnel item', 'goodlayers-core-personnel')
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'goodlayers-core-personnel'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'goodlayers-core-personnel'), 
									'title' => esc_html__('Title', 'goodlayers-core-personnel'), 
									'rand' => esc_html__('Random', 'goodlayers-core-personnel'), 
								)
							),
							'order' => array(
								'title' => esc_html__('Order', 'goodlayers-core-personnel'),
								'type' => 'combobox',
								'options' => array(
									'desc'=>esc_html__('Descending Order', 'goodlayers-core-personnel'), 
									'asc'=> esc_html__('Ascending Order', 'goodlayers-core-personnel'), 
								)
							),
						),
					),				
					'settings' => array(
						'title' => esc_html('Style', 'goodlayers-core-personnel'),
						'options' => array(
							'text-align' => array(
								'title' => esc_html__('Text Align', 'goodlayers-core-personnel'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'left',
							),
							'personnel-style' => array(
								'title' => esc_html__('Personnel Style', 'goodlayers-core-personnel'),
								'type' => 'radioimage',
								'options' => array(
									'grid' => plugins_url('', __FILE__) . '/images/grid.png',
									'grid-no-space' => plugins_url('', __FILE__) . '/images/grid-no-space.png',
									'grid-with-background' => plugins_url('', __FILE__) . '/images/grid-with-background.png',
									'modern' => plugins_url('', __FILE__) . '/images/modern.png',
									'modern-no-space' => plugins_url('', __FILE__) . '/images/modern-no-space.png',
								),
								'default' => 'blog-full',
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'enable-position' => array(
								'title' => esc_html__('Enable Position', 'goodlayers-core-personnel'),
								'type' => 'checkbox',
								'default' => 'enable',
							),
							'disable-link' => array(
								'title' => esc_html__('Disable Link To Single Personnel', 'goodlayers-core-personnel'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'enable-divider' => array(
								'title' => esc_html__('Enable Divider', 'goodlayers-core-personnel'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array('personnel-style' => array('grid', 'grid-no-space', 'grid-with-background'))
							),
							'enable-excerpt' => array(
								'title' => esc_html__('Enable Excerpt', 'goodlayers-core-personnel'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array('personnel-style' => array('grid', 'grid-no-space', 'grid-with-background'))
							),
							'enable-social-shortcode' => array(
								'title' => esc_html__('Enable Social Shortcode', 'goodlayers-core-personnel'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array('personnel-style' => array('grid', 'grid-no-space', 'grid-with-background'))
							),
							'column-size' => array(
								'title' => esc_html__('Column Size', 'goodlayers-core-personnel'),
								'type' => 'combobox',
								'options' => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5 ),
								'default' => 3,
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'goodlayers-core-personnel'),
								'type' => 'combobox',
								'options' => 'thumbnail-size'
							),
							'enable-thumbnail-opacity-on-hover' => array(
								'title' => esc_html__('Thumbnail Opacity on Hover', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
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
							'carousel' => array(
								'title' => esc_html__('Enable Carousel', 'goodlayers-core-personnel'),
								'type' => 'checkbox',
								'default' => 'disable',
							),
							'carousel-autoslide' => array(
								'title' => esc_html__('Autoslide Carousel', 'goodlayers-core-personnel'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'carousel' => 'enable' )
							),
							'carousel-navigation' => array(
								'title' => esc_html__('Carousel Navigation', 'goodlayers-core-personnel'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'navigation' => esc_html__('Only Navigation', 'goodlayers-core-personnel'),
									'bullet' => esc_html__('Only Bullet', 'goodlayers-core-personnel'),
									'both' => esc_html__('Both Navigation and Bullet', 'goodlayers-core-personnel'),
								),
								'default' => 'navigation',
								'condition' => array( 'carousel' => 'enable' )
							),
						)
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core-personnel'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'goodlayers-core-personnel'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					),
					'item-title' => array(
						'title' => esc_html('Item Title', 'goodlayers-core-personnel'),
						'options' => array(
							'title-align' => array(
								'title' => esc_html__('Title Align', 'goodlayers-core-personnel'),
								'type' => 'combobox',
								'options' => array(
									'left' => esc_html__('Left', 'goodlayers-core-personnel'),
									'center' => esc_html__('Center', 'goodlayers-core-personnel'),
								),
								'default' => 'left',
							),
							'title' => array(
								'title' => esc_html__('Title', 'goodlayers-core-personnel'),
								'type' => 'text',
							),
							'caption' => array(
								'title' => esc_html__('Caption', 'goodlayers-core-personnel'),
								'type' => 'textarea',
							),
							'read-more-text' => array(
								'title' => esc_html__('Read More Text', 'goodlayers-core-personnel'),
								'type' => 'text',
								'default' => esc_html__('Read More', 'goodlayers-core-personnel'),
								'condition' => array( 'title-align' => 'left' )
							),
							'read-more-link' => array(
								'title' => esc_html__('Read More Link', 'goodlayers-core-personnel'),
								'type' => 'text',
								'condition' => array( 'title-align' => 'left' )
							),
							'read-more-target' => array(
								'title' => esc_html__('Read More Target', 'goodlayers-core-personnel'),
								'type' => 'combobox',
								'options' => array(
									'_self' => esc_html__('Current Screen', 'goodlayers-core-personnel'),
									'_blank' => esc_html__('New Window', 'goodlayers-core-personnel'),
								),
								'condition' => array( 'title-align' => 'left' )
							),
							'title-size' => array(
								'title' => esc_html__('Title Size', 'goodlayers-core-personnel'),
								'type' => 'fontslider',
								'default' => '41px'
							),
							'caption-size' => array(
								'title' => esc_html__('Caption Size', 'goodlayers-core-personnel'),
								'type' => 'fontslider',
								'default' => '16px'
							),
							'read-more-size' => array(
								'title' => esc_html__('Read More Size', 'goodlayers-core-personnel'),
								'type' => 'fontslider',
								'default' => '14px',
								'condition' => array( 'title-align' => 'left' )
							),
							'title-color' => array(
								'title' => esc_html__('Title Color', 'goodlayers-core-personnel'),
								'type' => 'colorpicker'
							),
							'caption-color' => array(
								'title' => esc_html__('Caption Color', 'goodlayers-core-personnel'),
								'type' => 'colorpicker'
							),
							'read-more-color' => array(
								'title' => esc_html__('Read More Color', 'goodlayers-core-personnel'),
								'type' => 'colorpicker',
								'condition' => array( 'title-align' => 'left' )
							),
							'read-more-divider-color' => array(
								'title' => esc_html__('Read More Divider Color', 'goodlayers-core-personnel'),
								'type' => 'colorpicker',
								'condition' => array( 'title-align' => 'left' )
							),
						)
					),	
				);
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-personnel-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-personnel-<?php echo esc_attr($id); ?>').parent().gdlr_core_flexslider();
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
						'category' => '', 'num-fetch' => 9, 'thumbnail-size' => 'full', 'orderby' => 'date', 'order' => 'asc',
						'personnel-style' => 'grid', 'column-size' => 3, 'text-align' => 'left', 'carousel' => 'disable',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// default value
				$settings['personnel-style'] = empty($settings['personnel-style'])? 'grid': $settings['personnel-style'];
				$settings['style'] = (strpos($settings['personnel-style'], 'grid') !== false)? 'grid': 'modern';
				$settings['carousel'] = empty($settings['carousel'])? 'disable': $settings['carousel'];
				$settings['disable-link'] = empty($settings['disable-link'])? 'disable': $settings['disable-link'];
				$with_space = !in_array($settings['personnel-style'], array('grid-no-space', 'modern-no-space'));

				// query
				$args = array( 'post_type' => 'personnel', 'suppress_filters' => false );

				if( !empty($settings['category']) ){
					$args['tax_query'] = array(array('terms'=>$settings['category'], 'taxonomy'=>'personnel_category', 'field'=>'slug'));
				}

				$args['posts_per_page'] = $settings['num-fetch'];
				$args['orderby'] = $settings['orderby'];
				$args['order'] = $settings['order'];	

				$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
				$args['paged'] = empty($args['paged'])? 1: $args['paged'];

				$query = new WP_Query( $args );

				// start printing item
				$extra_class  = ' gdlr-core-' . (empty($settings['text-align'])? 'left': $settings['text-align']) . '-align';
				$extra_class .= ' gdlr-core-personnel-item-style-' . $settings['personnel-style'];
				$extra_class .= ' gdlr-core-personnel-style-' . $settings['style'];
				$extra_class .= ($settings['personnel-style'] == 'grid-with-background')? ' gdlr-core-with-background': '';

				$title_settings = $settings;
				if( empty($with_space) || $settings['carousel'] == 'enable' ){
					$title_settings['pdlr'] = false;
					$extra_class .= ' gdlr-core-item-pdlr';
				}

				if( !empty($settings['column-size']) ){
					gdlr_core_set_container_multiplier(1 / intval($settings['column-size']), false);
				}

				$ret  = '<div class="gdlr-core-personnel-item gdlr-core-item-pdb clearfix ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				// print title
				$ret .= gdlr_core_block_item_title($title_settings);
				
				// print grid item
				if( $query->have_posts() ){
					if( $settings['carousel'] == 'disable' ){

						if( $query->have_posts() ){
							$p_column_count = 0;
							$p_column = 60 / intval($settings['column-size']);
							
							while( $query->have_posts() ){ $query->the_post();
								$column_class  = ' gdlr-core-column-' . $p_column;
								$column_class .= ($p_column_count % 60 == 0)? ' gdlr-core-column-first': '';
								$column_class .= empty($with_space)? '': ' gdlr-core-item-pdlr';
								$column_class .= ($settings['style'] == 'modern' && !empty($with_space))? ' gdlr-core-item-mgb': '';

								$ret .= '<div class="gdlr-core-personnel-list-column ' . esc_attr($column_class) . '" >';
								$ret .= self::get_tab_item($settings);
								$ret .= '</div>';

								$p_column_count += $p_column;
							}
							wp_reset_postdata();
						}

					// print carousel item
					}else{

						$slides = array();
						$flex_atts = array(
							'carousel' => true,
							'column' => empty($settings['column-size'])? '3': $settings['column-size'],
							'navigation' => empty($settings['carousel-navigation'])? 'navigation': $settings['carousel-navigation'],
							'nav-parent' => 'gdlr-core-personnel-item',
							'disable-autoslide' => (empty($settings['carousel-autoslide']) || $settings['carousel-autoslide'] == 'enable')? '': true,
						);
						if( empty($with_space) ){
							$flex_atts['mglr'] = false;
						}

						while( $query->have_posts() ){ $query->the_post();
							$slides[] = self::get_tab_item($settings);
						}

						$ret .= gdlr_core_get_flexslider($slides, $flex_atts);
					}
				}else{
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('No personnel found, please create the personnel post to use the item.', 'goodlayers-core-personnel') . '</div>';
				}

				$ret .= '</div>'; // gdlr-core-blog-item
				
				gdlr_core_set_container_multiplier(1, false);

				return $ret;
			}			

			static function get_tab_item( $settings = array() ){ 

				$post_meta = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);

				$ret  = '<div class="gdlr-core-personnel-list clearfix" >';
				$thumbnail_id = get_post_thumbnail_id();
				if( !empty($thumbnail_id) ){
					$thumbnail_size = empty($settings['thumbnail-size'])? 'full': $settings['thumbnail-size'];

					$additional_class  = '';
					if( empty($settings['enable-thumbnail-opacity-on-hover']) || $settings['enable-thumbnail-opacity-on-hover'] == 'enable' ){
						$additional_class .= ' gdlr-core-opacity-on-hover';
					}
					if( empty($settings['enable-thumbnail-zoom-on-hover']) || $settings['enable-thumbnail-zoom-on-hover'] == 'enable' ){
						$additional_class .= ' gdlr-core-zoom-on-hover';
					}
					if( !empty($settings['enable-thumbnail-grayscale-effect']) && $settings['enable-thumbnail-grayscale-effect'] == 'enable' ){
						$additional_class .= ' gdlr-core-grayscale-effect';
					}
					$ret .= '<div class="gdlr-core-personnel-list-image gdlr-core-media-image ' . esc_attr($additional_class) . '" >';
					if( $settings['disable-link'] == 'enable' ){
						$ret .= gdlr_core_get_image($thumbnail_id, $thumbnail_size);
					}else{
						$ret .= '<a href="' . get_permalink() . '" >' . gdlr_core_get_image($thumbnail_id, $thumbnail_size) .  '</a>';
					}
					$ret .= '</div>';
				}

				$ret .= '<div class="gdlr-core-personnel-list-content-wrap" >';

				if( $settings['style'] == 'grid' ){
					$ret .= '<h3 class="gdlr-core-personnel-list-title" >';
					if( $settings['disable-link'] == 'enable' ){
						$ret .= get_the_title();
					}else{
						$ret .= '<a href="' . get_permalink() . '" >' . get_the_title() . '</a>';
					}
					$ret .= '</h3>';
					if( (empty($settings['enable-position']) || $settings['enable-position'] == 'enable') && !empty($post_meta['position']) ){
						$ret .= '<div class="gdlr-core-personnel-list-position gdlr-core-info-font gdlr-core-skin-caption" >' . gdlr_core_text_filter($post_meta['position']) . '</div>';
					}
					if( empty($settings['enable-divider']) || $settings['enable-divider'] == 'enable' ){
						$ret .= '<div class="gdlr-core-personnel-list-divider gdlr-core-skin-divider" ></div>';
					}
					if( (empty($settings['enable-excerpt']) || $settings['enable-excerpt'] == 'enable') && !empty($post_meta['excerpt']) ){
						$ret .= '<div class="gdlr-core-personnel-list-content" >' . gdlr_core_content_filter($post_meta['excerpt']) . '</div>';
					}
					if( (empty($settings['enable-social-shortcode']) || $settings['enable-social-shortcode'] == 'enable') && !empty($post_meta['social-shortcode']) ){
						$ret .= '<div class="gdlr-core-personnel-list-social" >' . gdlr_core_content_filter($post_meta['social-shortcode']) . '</div>';
					}
				}else{
					$ret .= '<div class="gdlr-core-personnel-list-title gdlr-core-title-font" >';
					if( $settings['disable-link'] == 'enable' ){
						$ret .= get_the_title();
					}else{
						$ret .= '<a href="' . get_permalink() . '" >' . get_the_title() . '</a>';
					}
					$ret .= '</div>';
					if( (empty($settings['enable-position']) || $settings['enable-position'] == 'enable') && !empty($post_meta['position']) ){
						$ret .= '<div class="gdlr-core-personnel-list-position gdlr-core-info-font" >' . gdlr_core_text_filter($post_meta['position']) . '</div>';
					}
				}
				$ret .= '</div>'; // gdlr-core-personnel-list-content-wrap

				$ret .= '</div>'; // gdlr-core-personnel-list

				return $ret;
			}
			
		} // gdlr_core_pb_element_personnel
	} // class_exists	