<?php
	/*	
	*	Goodlayers Utility Files
	*	---------------------------------------------------------------------
	*	This file contains the function that helps doing things
	*	---------------------------------------------------------------------
	*/
	
	// include utility function for uses 
	// make sure to call this function inside wp_enqueue_script action
	if( !function_exists('gdlr_core_include_utility_script') ){
		function gdlr_core_include_utility_script(){
			
			if( is_admin() ){
				wp_enqueue_style('google-Montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700');
			}
		
			wp_enqueue_style('font-awesome', GDLR_CORE_URL . '/plugins/font-awesome/css/font-awesome.min.css');
			wp_enqueue_style('font-elegant', GDLR_CORE_URL . '/plugins/elegant-font/style.css');
						
			wp_enqueue_style('gdlr-core-utility', GDLR_CORE_URL . '/framework/css/utility.css');
			
			wp_enqueue_script('gdlr-core-utility', GDLR_CORE_URL . '/framework/js/utility.js', array('jquery'), false, true);
			wp_localize_script('gdlr-core-utility', 'gdlr_utility', array(
				'confirm_head' => esc_html__('Just to confirm', 'goodlayers-core'),
				'confirm_text' => esc_html__('Are you sure to do this ?', 'goodlayers-core'),
				'confirm_sub' => esc_html__('* Please noted that this could not be undone.', 'goodlayers-core'),
				'confirm_yes' => esc_html__('Yes', 'goodlayers-core'),
				'confirm_no' => esc_html__('No', 'goodlayers-core'),
			));
			
		}
	}	
	
	// change any string to valid html id
	if( !function_exists('gdlr_core_string_to_slug') ){
		function gdlr_core_string_to_slug( $string ){
			// lower case everything
			$string = strtolower($string);
			
			// amke alphanumeric (removes all other characters)
			$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
			
			// clean up multiple dashes or whitespaces
			$string = preg_replace("/[\s-_]+/", " ", $string);
			
			// remove space at the front and back
			$string = trim($string);
			
			// convert whitespaces and underscore to dash
			$string = preg_replace("/[\s_]/", "-", $string);
    
			return $string;
		}
	}
	
	// get all thumbnail name
	if( !function_exists('gdlr_core_get_thumbnail_list') ){
		function gdlr_core_get_thumbnail_list(){
			$ret = array();
			
			$thumbnails = get_intermediate_image_sizes();
			$ret['full'] = esc_html__('full size', 'goodlayers-core');
			foreach( $thumbnails as $thumbnail ) {
				if( !empty($GLOBALS['_wp_additional_image_sizes'][$thumbnail]) ){
					$width = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['width'];
					$height = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['height'];
				}else{
					$width = get_option($thumbnail . '_size_w', '');
					$height = get_option($thumbnail . '_size_h', '');
				}
				$ret[$thumbnail] = $thumbnail . ' ' . $width . '-' . $height;
			}
			return $ret;
		}
	}
	if( !function_exists('gdlr_core_get_video_size') ){
		function gdlr_core_get_video_size( $size = '' ){

			if( empty($size) || $size == 'full' ){
				return array( 'width'=>640, 'height'=>360 );
			}
			
			if( is_array($size) && $size['width'] == '100%' || $size['height'] == '100%' ){
				return array( 'width'=>640, 'height'=>360 );
			}
			
			if( !empty($GLOBALS['_wp_additional_image_sizes'][$size]) ){
				$width = $GLOBALS['_wp_additional_image_sizes'][$size]['width'];
				$height = $GLOBALS['_wp_additional_image_sizes'][$size]['height'];
				if( !empty($width) && !empty($height) ){
					return array( 'width'=>$width, 'height'=>$height );
				}
			}

			return array( 'width'=>640, 'height'=>360 );
		}
	}
	
	// gdlr esc size
	if( !function_exists('gdlr_core_esc_style') ){
		function gdlr_core_esc_style($atts, $wrap = true){
			if( empty($atts) ) return '';

			$att_style = '';
			foreach($atts as $key => $value){
				if( empty($value) ) continue;
				
				switch($key){
					
					case 'border-radius': 
						$att_style .= "border-radius: {$value};";
						$att_style .= "-moz-border-radius: {$value};";
						$att_style .= "-webkit-border-radius: {$value};";
						break;
					
					case 'gradient': 
						if( is_array($value) && sizeOf($value) > 1 ){
							$att_style .= "background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-moz-background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-o-background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-webkit-background: linear-gradient({$value[0]}, {$value[1]});";
						}
						break;
					
					case 'background':
					case 'background-color':
						if( is_array($value) ){
							$rgba_value = gdlr_core_format_datatype($value[0], 'rgba');
							$att_style .= "{$key}: rgba({$rgba_value}, {$value[1]});";
						}else{
							$att_style .= "{$key}: {$value};";
						}
						break;

					case 'background-image':
						if( is_numeric($value) ){
							$image_url = gdlr_core_get_image_url($value);
							if( !empty($image_url) ){
								$att_style .= "background-image: url({$image_url});";
							}
						}else{
							$att_style .= "background-image: url({$value});";
						}
						break;
					
					case 'padding':
					case 'margin':
					case 'border-width':
						if( is_array($value) ){
							if( !empty($value['top']) && !empty($value['right']) && !empty($value['bottom']) && !empty($value['left']) ){
								$att_style .= "{$key}: {$value['top']} {$value['right']} {$value['bottom']} {$value['left']};";
							}else{
								foreach($value as $pos => $val){
									if( $pos != 'settings' && (!empty($val) || $val === '0') ){
										if( $key == 'border-width' ){
											$att_style .= "border-{$pos}-width: {$val};";
										}else{
											$att_style .= "{$key}-{$pos}: {$val};";
										}
									}
								}
							}
						}else{
							$att_style .= "{$key}: {$value};";
						}
						break;
					
					default: 
						$value = is_array($value)? ((empty($value[0]) || $value[0] === '0')? '': $value[0]): $value;
						$att_style .= "{$key}: {$value};";
				}
			}
			
			if( !empty($att_style) ){
				if( $wrap ){
					return 'style="' . esc_attr($att_style) . '" ';
				}
				return $att_style;
			}
			return '';
		}
	}
	
	// process data sent from the post variable
	if( !function_exists('gdlr_core_process_post_data') ){
		function gdlr_core_process_post_data( $post ){
			return stripslashes_deep($post);
		}
	}		
	
	// format data to specific type
	if( !function_exists('gdlr_core_format_datatype') ){
		function gdlr_core_format_datatype( $value, $data_type ){
			if( $data_type == 'color' ){
				return (strpos($value, '#') === false)? '#' . $value: $value; 
			}else if( $data_type == 'rgba' ){
				$value = str_replace('#', '', $value);
				if(strlen($value) == 3) {
					$r = hexdec(substr($value,0,1) . substr($value,0,1));
					$g = hexdec(substr($value,1,1) . substr($value,1,1));
					$b = hexdec(substr($value,2,1) . substr($value,2,1));
				}else{
					$r = hexdec(substr($value,0,2));
					$g = hexdec(substr($value,2,2));
					$b = hexdec(substr($value,4,2));
				}
				return $r . ', ' . $g . ', ' . $b;
			}else if( $data_type == 'text' ){
				return trim($value);
			}else if( $data_type == 'pixel' ){
				return (is_numeric($value))? $value . 'px': $value;
			}else if( $data_type == 'file' ){
				if(is_numeric($value)){
					$image_src = wp_get_attachment_image_src($value, 'full');	
					return (!empty($image_src))? $image_src[0]: false;
				}else{
					return $value;
				}
			}else if( $data_type == 'font'){
				return trim($value);
			}else if( $data_type == 'percent' ){
				return (is_numeric($value))? $value . '%': $value;
			}else if( $data_type == 'opacity' ){
				return (intval($value) / 100);
			} 
		}
	}	
	
	// retrieve all categories from each post type
	if( !function_exists('gdlr_core_get_taxonomies') ){	
		function gdlr_core_get_taxonomies(){

			$taxonomy = get_taxonomies();
			unset($taxonomy['nav_menu']);
			unset($taxonomy['link_category']);
			unset($taxonomy['post_format']);

			return $taxonomy;

		}
	}

	// retrieve all categories from each post type
	if( !function_exists('gdlr_core_get_term_list') ){	
		function gdlr_core_get_term_list( $taxonomy, $cat = '', $with_all = false ){
			$term_atts = array(
				'taxonomy'=>$taxonomy, 
				'hide_empty'=>0,
				'number'=>99
			);
			if( !empty($cat) ){
				if( is_array($cat) ){
					$term_atts['slug'] = $cat;
				}else{
					$term_atts['parent'] = $cat;
				}
			}
			$term_list = get_categories($term_atts);

			$ret = array();
			if( !empty($with_all) ){
				$ret[$cat] = esc_html__('All', 'goodlayers-core'); 
			}

			if( !empty($term_list) ){
				foreach( $term_list as $term ){
					if( !empty($term->slug) && !empty($term->name) ){
						$ret[$term->slug] = $term->name;
					}
				}
			}

			return $ret;
		}	
	}
	
	// retrieve all posts from each post type
	if( !function_exists('gdlr_core_get_post_list') ){	
		function gdlr_core_get_post_list( $post_type ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>99));

			$ret = array();
			if( !empty($post_list) ){
				foreach( $post_list as $post ){
					$ret[$post->ID] = $post->post_title;
				}
			}
				
			return $ret;
		}	
	}

	// page builder content/text filer to execute the shortcode	
	if( !function_exists('gdlr_core_content_filter') ){
		add_filter( 'gdlr_core_the_content', 'wptexturize'        ); add_filter( 'gdlr_core_the_content', 'convert_smilies'    );
		add_filter( 'gdlr_core_the_content', 'convert_chars'      ); add_filter( 'gdlr_core_the_content', 'wpautop'            );
		add_filter( 'gdlr_core_the_content', 'shortcode_unautop'  ); add_filter( 'gdlr_core_the_content', 'prepend_attachment' );	
		add_filter( 'gdlr_core_the_content', 'gdlr_core_do_shortcode', 11   );
		function gdlr_core_content_filter( $content, $main_content = false ){
			if($main_content) return str_replace( ']]>', ']]&gt;', apply_filters('the_content', $content) );
			
			$content = preg_replace_callback( '|(https?://[^\s"<]+)|im', 'gdlr_core_content_oembed', $content );
			
			return apply_filters('gdlr_core_the_content', $content);
		}		
	}
	if( !function_exists('gdlr_core_content_oembed') ){
		function gdlr_core_content_oembed( $link ){

			if( preg_match('/youtube|youtu\.be|vimeo/', $link[1]) ){
				$html = wp_oembed_get($link[1]);
				
				if( $html ) return $html;
			}
			return $link[1];
		}
	}
	if( !function_exists('gdlr_core_text_filter') ){
		add_filter('gdlr_core_text_filter', 'do_shortcode', 11);
		function gdlr_core_text_filter( $text ){
			return apply_filters('gdlr_core_text_filter', $text);
		}
	}		

	// only apply goodlayers shortcode in admin
	if( !function_exists('gdlr_core_do_shortcode') ){
		function gdlr_core_do_shortcode( $content ){

			if( !is_admin() ){
				return do_shortcode($content);
			}else{
				global $shortcode_tags, $gdlr_core_shortcode_tags;

				if( empty($gdlr_core_shortcode_tags) ){
					$gdlr_core_shortcode_tags = array();
					foreach( $shortcode_tags as $tag => $function ){
						if( strpos($tag, 'gdlr_core') !== false ){
							$gdlr_core_shortcode_tags[$tag] = $function;
						}
					}
				}

				$orig_shortcode_tags = $shortcode_tags;
				$shortcode_tags = $gdlr_core_shortcode_tags;

				$content = do_shortcode($content);

				$shortcode_tags = $orig_shortcode_tags;

				return $content;
			}
		}
	}	
	
	// escape content with html
	if( !function_exists('gdlr_core_escape_content') ){
		function gdlr_core_escape_content( $content ){
			return apply_filters('gdlr_core_escape_content', $content);
		}
	}	
	
	// allow specific upload file format
	add_filter('upload_mimes', 'gdlr_core_custom_upload_mimes');
	if( !function_exists('gdlr_core_custom_upload_mimes') ){
		function gdlr_core_custom_upload_mimes( $existing_mimes = array() ){
			$existing_mimes['ttf'] = 'application/x-font-ttf';
			$existing_mimes['otf'] = 'application/x-font-opentyp'; 
			$existing_mimes['eot'] = 'application/vnd.ms-fontobject'; 
			$existing_mimes['woff'] = 'application/font-woff'; 
			$existing_mimes['svg'] = 'image/svg+xml'; 

			return $existing_mimes;
		}
	}

	// change the object to string
	if( !function_exists('gdlr_core_debug_object') ){
		function gdlr_core_debug_object( $object ){

			ob_start();
			print_r($object);
			$ret = ob_get_contents() . '<br><br>';
			ob_end_clean();

			return $ret;
		}
	}

	// create pagination link
	if( !function_exists('gdlr_core_get_pagination') ){	
		function gdlr_core_get_pagination($max_num_page, $settings = array(), $extra_class = '', $style = ''){
			if( $max_num_page <= 1 ) return '';
		
			$big = 999999999; // need an unlikely integer

			if( empty($settings['pagination-style']) || $settings['pagination-style'] == 'default' ){
				$style = apply_filters('gdlr_core_pagination_style', 'round');
			}else{
				$style = $settings['pagination-style'];
			}
			if( empty($settings['pagination-align']) || $settings['pagination-align'] == 'default' ){
				$align = apply_filters('gdlr_core_pagination_align', 'right');
			}else{
				$align = $settings['pagination-align'];
			}

			$with_border = (strpos($style, '-border') !== false);
			$style = str_replace('-border', '', $style);
			$current_page = empty($settings['paged']) ? 1: $settings['paged'];

			$pagination_class  = ' gdlr-core-style-' .  $style;
			$pagination_class .= ' gdlr-core-' .  $align . '-align';
			$pagination_class .= empty($with_border)? '': ' gdlr-core-with-border';
			$pagination_class .= empty($extra_class)? '': ' ' . $extra_class;
		
			return '<div class="gdlr-core-pagination ' . esc_attr($pagination_class) . '">' . paginate_links(array(
				'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
				'format' => '?paged=%#%',
				'current' => max(1, $current_page),
				'total' => $max_num_page,
				'prev_text'=> '',
				'next_text'=> ''
			)) . '</div>';
		}	
	}		
	if( !function_exists('gdlr_core_get_ajax_pagination') ){	
		function gdlr_core_get_ajax_pagination($post_type, $settings, $max_num_page, $target, $extra_class = ''){
			if( $max_num_page <= 1 ) return '';
			
			if( empty($settings['pagination-style']) || $settings['pagination-style'] == 'default' ){
				$style = apply_filters('gdlr_core_pagination_style', 'round');
			}else{
				$style = $settings['pagination-style'];
			}
			if( empty($settings['pagination-align']) || $settings['pagination-align'] == 'default' ){
				$align = apply_filters('gdlr_core_pagination_align', 'right');
			}else{
				$align = $settings['pagination-align'];
			}
			$with_border = (strpos($style, '-border') !== false);
			$style = str_replace('-border', '', $style);
			$current_page = empty($settings['paged']) ? 1: $settings['paged'];

			$pagination_class  = ' gdlr-core-style-' .  $style;
			$pagination_class .= ' gdlr-core-' .  $align . '-align';
			$pagination_class .= empty($with_border)? '': ' gdlr-core-with-border';
			$pagination_class .= empty($extra_class)? '': ' ' . $extra_class;

			$ret  = '<div class="gdlr-core-pagination gdlr-core-js ' . esc_attr($pagination_class) . '" ';
			$ret .= 'data-ajax="gdlr_core_' . esc_attr($post_type) . '_ajax" ';
			$ret .= 'data-settings="' . esc_attr(json_encode($settings)) . '" ';
			$ret .= 'data-target="' . esc_attr($target) . '" ';
			$ret .= 'data-target-action="replace" ';
			$ret .= '>';
			for($i=1; $i<=$max_num_page; $i++){
				if( $i == $current_page ){
					$ret .= '<a class="page-numbers gdlr-core-active" data-ajax-name="paged" data-ajax-value="' . $i . '" >' . $i . '</a> ';
				}else{
					$ret .= '<a class="page-numbers" data-ajax-name="paged" data-ajax-value="' . $i . '" >' . $i . '</a> ';
				}
			}
			$ret .= '</div>';

			return $ret;
		}	
	}
	if( !function_exists('gdlr_core_get_ajax_load_more') ){	
		function gdlr_core_get_ajax_load_more($post_type, $settings, $paged, $max_num_page, $target, $extra_class){

			$ret  = '';
			if( $paged <= $max_num_page ){
				$ret  = '<div class="gdlr-core-load-more-wrap gdlr-core-js gdlr-core-center-align ' . esc_attr($extra_class) . '" ';
				$ret .= 'data-ajax="gdlr_core_' . esc_attr($post_type) . '_ajax" ';
				$ret .= 'data-settings="' . esc_attr(json_encode($settings)) . '" ';
				$ret .= 'data-target="' . esc_attr($target) . '" ';
				$ret .= 'data-target-action="append" ';
				$ret .= '>';
				if( $paged <= $max_num_page ){
					$ret .= '<a href="#" class="gdlr-core-load-more gdlr-core-button-color" data-ajax-name="paged" data-ajax-value="' . esc_attr($paged) . '" >';
					$ret .= esc_html__('Load More', 'goodlayers-core');
					$ret .= '</a>';
				}
				$ret .= '</div>';
			}

			return $ret;
		}
	}
	if( !function_exists('gdlr_core_get_ajax_filterer') ){	
		function gdlr_core_get_ajax_filterer($post_type, $taxonomy, $settings, $target, $extra_class){

			$ret  = '<div class="gdlr-core-filterer-wrap gdlr-core-js ' . esc_attr($extra_class) . '" ';
			$ret .= 'data-ajax="gdlr_core_' . esc_attr($post_type) . '_ajax" ';
			$ret .= 'data-settings="' . esc_attr(json_encode($settings)) . '" ';
			$ret .= 'data-target="' . esc_attr($target) . '" ';
			$ret .= 'data-target-action="replace" ';
			$ret .= ' >';

			// for all
			if( empty($settings['category']) ){

				$ret .= '<a href="#" class="gdlr-core-filterer gdlr-core-button-color gdlr-core-active" >' . esc_html__('All', 'goodlayers-core') . '</a>';
				$filters = gdlr_core_get_term_list($taxonomy);

			// parent category
			}else if( sizeof($settings['category']) == 1 ){

				$term = get_term_by('slug', $settings['category'][0], $taxonomy);
				$ret .= '<a href="#" class="gdlr-core-filterer gdlr-core-button-color gdlr-core-active" >' . gdlr_core_escape_content($term->name) . '</a>';
				$filters = gdlr_core_get_term_list($taxonomy, $term->term_id);

			// multiple category select
			}else{

				$ret .= '<a href="#" class="gdlr-core-filterer gdlr-core-button-color gdlr-core-active" >' . esc_html__('All', 'goodlayers-core') . '</a>';
				$filters = gdlr_core_get_term_list($taxonomy, $settings['category']);
				
			}

			foreach( $filters as $slug => $name ){
				$ret .= '<a href="#" class="gdlr-core-filterer gdlr-core-button-color" data-ajax-name="category" data-ajax-value="' . esc_attr($slug) . '" >';
				$ret .= gdlr_core_escape_content($name);
				$ret .= '</a>';
			}

			$ret .= '</div>'; // gdlr-core-filterer-wrap

			return $ret;
		}
	}

	// for preparing srcset
	if( !function_exists('gdlr_core_set_container') ){
		function gdlr_core_set_container( $container = true ){
			global $content_width, $gdlr_core_container, $gdlr_core_container_multiplier, $gdlr_core_item_multiplier;

			if( empty($container) ){
				$gdlr_core_container = 2560;
			}else if( $container === true ){
				$gdlr_core_container = $content_width;
			}else{
				$gdlr_core_container = $container;
			}
			$gdlr_core_content_width = $gdlr_core_container;
			$gdlr_core_container_multiplier = $gdlr_core_item_multiplier = 1;
		}
	}
	// main is column
	if( !function_exists('gdlr_core_set_container_multiplier') ){
		function gdlr_core_set_container_multiplier( $multiplier, $main = true ){
			global $gdlr_core_container, $gdlr_core_container_multiplier, $gdlr_core_item_multiplier;

			if( empty($gdlr_core_container) ){
				gdlr_core_set_container();
			}

			if( $main ){
				$gdlr_core_container_multiplier = $multiplier;
			}else{
				$gdlr_core_item_multiplier = $multiplier;
			}
		}
	}
	if( !function_exists('gdlr_core_get_image_srcset') ){
		function gdlr_core_get_image_srcset( $image_id, $image ){
			
			$enable_srcset = apply_filters('gdlr_core_enable_srcset', true);
			if( !$enable_srcset ) return;
			
			if( empty($image) || empty($image[0]) || empty($image[1]) || empty($image[2]) ) return;
			
			$srcset = '';
			
			// crop image
			$smallest_image = $image;
			$cropped_sizes = array(400, 600, 800);
			foreach( $cropped_sizes as $cropped_size ){
				if( $image[1] > $cropped_size + 100 ){
					$new_height = intval($cropped_size * intval($image[2]) / intval($image[1]));
					$cropped_image = gdlr_core_get_cropped_image( $image_id, $cropped_size, $new_height, false);
					
					if( !empty($cropped_image) ){
						$srcset .= empty($srcset)? '': ', ';
						$srcset .= $cropped_image . ' ' . $cropped_size . 'w';
						$smallest_image = array($cropped_image, $cropped_size, $new_height);
					}
				}
			}			
	
			if( !empty($srcset) ){
				// $ret  = ' src="' . esc_url($image[0]) . '" width="' . esc_attr($image[1]) . '" height="' . esc_attr($image[2]) . '" ';
				$ret  = ' src="' . esc_url($smallest_image[0]) . '" width="' . esc_attr($image[1]) . '" height="' . esc_attr($image[2]) . '" ';
				$ret .= ' srcset="' . esc_attr($srcset) . ', ' . esc_attr($image[0]) . ' ' . esc_attr($image[1]) . 'w" ';
				
				// get screen size for query
				global $content_width, $gdlr_core_container, $gdlr_core_container_multiplier, $gdlr_core_item_multiplier;
				if( empty($gdlr_core_container) ){ gdlr_core_set_container(); }
				$column_size = intval(100 * $gdlr_core_container_multiplier * $gdlr_core_item_multiplier);
				$content_size = intval($gdlr_core_container * $gdlr_core_container_multiplier * $gdlr_core_item_multiplier);
				
				$sizes = '(max-width: 767px) 100vw';
				if( $gdlr_core_container >= 2560 ){
					$sizes .= ', ' . $column_size . 'vw';
				}else{
					$sizes .= ', (max-width: ' . $gdlr_core_container . 'px) ' . $column_size . 'vw';
					$sizes .= ', ' . $content_size . 'px';
				}
				
				$ret .= ' sizes="' . esc_attr($sizes) . '" ';
				return $ret;
			}

			return '';
		}
	}

	if( !function_exists('gdlr_core_get_cropped_image') ){
		function gdlr_core_get_cropped_image( $attachment_id = 0, $width, $height, $html = true ){
			if( empty($attachment_id) ){
				return;
			}

			$original_path = get_attached_file($attachment_id);
			$orig_info = pathinfo($original_path);
			$dir = $orig_info['dirname'];
			$ext = $orig_info['extension'];	

			$suffix = "{$width}x{$height}";
			$name = wp_basename($original_path, ".{$ext}");
			$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";

			$attachment = wp_get_attachment_image_src($attachment_id, 'full');
			$destfileurl = str_replace($name, $name . '-' . $suffix, $attachment[0]);

			if( !file_exists($destfilename) ){

				// get attachment for resize && check if it's resizable
				$attachment_thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail');
				if( $attachment[1] == $attachment_thumbnail[1] && $attachment[2] == $attachment_thumbnail[2] ){
					return;
				}
			
				// crop an image
				$cropped_image = wp_get_image_editor($original_path);
				if( !is_wp_error($cropped_image) ) {
					$cropped_image->resize($width, $height, true);
					$cropped_image->save($destfilename);

					if( !$html ){
						return $destfileurl;
					}else{
						$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
						return '<img src="' . esc_url($destfileurl) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" alt="' . (empty($alt_text)? '': $alt_text) . '" >';
					}
				}
			}else{
				if( !$html ){
						return $destfileurl;
				}else{
					$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
					return '<img src="' . esc_url($destfileurl) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" alt="' . (empty($alt_text)? '': $alt_text) . '" >';
				}
			}

		} // gdlr_core_get_cropped_image
	} // function_exists

	add_action('wp_footer', 'gdlr_core_inline_style');
	if( !function_exists('gdlr_core_inline_style') ){
		function gdlr_core_inline_style(){
			global $gdlr_core_inline_style;

			if( !empty($gdlr_core_inline_style) ){
				echo '<style type="text/css" scoped >'. $gdlr_core_inline_style . '</style>';
			}
		}
	}
	if( !function_exists('gdlr_core_add_inline_style') ){
		function gdlr_core_add_inline_style( $css ){
			global $gdlr_core_inline_style;

			$gdlr_core_inline_style  = empty($gdlr_core_inline_style)? '': $gdlr_core_inline_style;
			$gdlr_core_inline_style .= $css;
		}
	}