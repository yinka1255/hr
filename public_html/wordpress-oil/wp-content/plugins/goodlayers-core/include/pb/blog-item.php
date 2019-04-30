<?php
	/*	
	*	Goodlayers Blog Item
	*/
	
	if( !class_exists('gdlr_core_blog_item') ){
		class gdlr_core_blog_item{
			
			var $settings = '';
			
			// init the variable
			function __construct( $settings = array() ){
				
				$this->settings = wp_parse_args($settings, array(
					'category' => '', 
					'tag' => '', 
					'num-fetch' => '9', 
					'layout' => 'fitrows',
					'prepend-sticky' => 'disable', 
					'show-thumbnail' => 'enable', 
					'thumbnail-size' => 'full', 
					'orderby' => 'date', 
					'order' => 'desc',
					'blog-style' => 'blog-full', 
					'has-column' => 'no',
					'no-space' => 'no',
					'excerpt' => 'specify-number', 
					'excerpt-number' => 55, 
					'column-size' => 20,
					'item-size' => 'small',
					'show-read-more' => 'enable',
					'meta-option' => array( 'date', 'author', 'category' ),
					'pagination' => 'none'
				));
			}
			
			// get the content of the blog item
			function get_content(){
				
				if( !empty($this->settings['column-size']) ){
					gdlr_core_set_container_multiplier(intval($this->settings['column-size']) / 60, false);
				}

				$ret = '';
				if( empty($this->settings['query']) ){
					$query = $this->get_blog_query();
				}else{
					$query = $this->settings['query'];
				}
				
				// carousel style
				if( $this->settings['layout'] == 'carousel' ){
					$slides = array();
					$column_no = 60 / intval($this->settings['column-size']);

					$flex_atts = array(
						'carousel' => true,
						'column' => $column_no,
						'navigation' => empty($this->settings['carousel-navigation'])? 'navigation': $this->settings['carousel-navigation'],
						'nav-parent' => 'gdlr-core-blog-item',
						'disable-autoslide' => (empty($this->settings['carousel-autoslide']) || $this->settings['carousel-autoslide'] == 'enable')? '': true,
						'mglr' => ($this->settings['no-space'] == 'yes'? false: true)
					);

					$blog_style = new gdlr_core_blog_style();
					while($query->have_posts()){ $query->the_post();
						$slides[] = $blog_style->get_content( $this->settings );
					} // while

					$ret .= gdlr_core_get_flexslider($slides, $flex_atts);

				// fitrows style
				}else{
					
					$ret .= '<div class="gdlr-core-blog-item-holder gdlr-core-js-2 clearfix" data-layout="' . $this->settings['layout'] . '" >';
					$ret .= $this->get_blog_grid_content($query);
					$ret .= '</div>';

					// pagination
					if( $this->settings['pagination'] != 'none' ){
						$extra_class = '';
						if( $this->settings['no-space'] == 'no' ){
							$extra_class = 'gdlr-core-item-pdlr';
						}

						if( $this->settings['pagination'] == 'page' ){
							$ret .= gdlr_core_get_pagination($query->max_num_pages, $this->settings, $extra_class);
						}else if( $this->settings['pagination'] == 'load-more' ){
							// mediaelement for blog ajax
							wp_enqueue_style('wp-mediaelement');
							wp_enqueue_script('wp-mediaelement');
							
							$paged = empty($query->query['paged'])? 2: intval($query->query['paged']) + 1;
							$ret .= gdlr_core_get_ajax_load_more('post', $this->settings, $paged, $query->max_num_pages, 'gdlr-core-blog-item-holder', $extra_class);
						}
					}
				}
				wp_reset_postdata();

				gdlr_core_set_container_multiplier(1, false);

				return $ret;
			}

			// get content of non carousel blog item
			function get_blog_grid_content( $query ){

				$ret = '';
				$column_sum = 0;
				$blog_style = new gdlr_core_blog_style();
				while($query->have_posts()){ $query->the_post();

					$args = $this->settings;

					if( $this->settings['has-column'] == 'yes' ){
						$additional_class  = ($this->settings['no-space'] == 'yes')? '': ' gdlr-core-item-pdlr';
						$additional_class .= in_array($this->settings['blog-style'], array('blog-image', 'blog-metro'))? ' gdlr-core-item-mgb': '';
						if( in_array($this->settings['blog-style'], array('blog-metro', 'blog-metro-no-space')) ){
							$blog_info = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);
							
							if( empty($blog_info['metro-column-size']) || $blog_info['metro-column-size'] == 'default' ){
								if( !empty($this->settings['column-size']) ){
									$additional_class .= ' gdlr-core-column-' . $this->settings['column-size'];	
								}
							}else{
								$additional_class .= ' gdlr-core-column-' . $blog_info['metro-column-size'];
							}

							if( !empty($blog_info['metro-thumbnail-size']) && $blog_info['metro-thumbnail-size'] != 'default' ){
								$args['thumbnail-size'] = $blog_info['metro-thumbnail-size'];
							}
							
						}else if( !empty($this->settings['column-size']) ){
							$additional_class .= empty($this->settings['column-size'])? '': ' gdlr-core-column-' . $this->settings['column-size'];
						}

						if( $column_sum == 0 || $column_sum + intval($this->settings['column-size']) > 60 ){
							$column_sum = intval($this->settings['column-size']);
							$additional_class .= ' gdlr-core-column-first';
						}else{
							$column_sum += intval($this->settings['column-size']);
						}

						$ret .= '<div class="gdlr-core-item-list ' . esc_attr($additional_class) . '" >';
					}

					$ret .= $blog_style->get_content($args);

					if( $this->settings['has-column'] == 'yes' ){
						$ret .= '</div>';
					}
				} // while

				return $ret;
			}
			
			// query the post
			function get_blog_query(){
				
				$args = array( 'post_type' => 'post', 'post_status' => 'publish', 'suppress_filters' => false );
				
				// category - tag selection
				if( !empty($this->settings['category']) || !empty($this->settings['tag']) ){
					$args['tax_query'] = array('relation' => 'OR');
					
					if( !empty($this->settings['category']) ){
						array_push($args['tax_query'], array('terms'=>$this->settings['category'], 'taxonomy'=>'category', 'field'=>'slug'));
					}
					if( !empty($this->settings['tag']) ){
						array_push($args['tax_query'], array('terms'=>$this->settings['tag'], 'taxonomy'=>'post_tag', 'field'=>'slug'));
					}
				}

				// pagination
				if( $this->settings['pagination'] != 'none' ){
					if( empty($this->settings['paged']) ){
						$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
						$args['paged'] = empty($args['paged'])? 1: $args['paged'];
					}else{
						$args['paged'] = $this->settings['paged'];
					}
					$this->settings['paged'] = $args['paged'];
				}else if( !empty($this->settings['offset']) ){
					$args['offset'] = intval($this->settings['offset']);
				}
		

				// sticky post section
				if( !empty($this->settings['prepend-sticky']) && $this->settings['prepend-sticky'] == 'enable' ){
					if( empty($args['paged']) || $args['paged'] <= 1 ){
						$args['post__not_in'] = get_option('sticky_posts', '');

						$sticky_args = $args;
						$sticky_args['post__in'] = $args['post__not_in'];
						if( !empty($sticky_args['post__in']) ){
							$sticky_query = new WP_Query($sticky_args);	
						}
					}
				}else{
					$args['ignore_sticky_posts'] = 1;
				}
				
				// variable
				$args['posts_per_page'] = $this->settings['num-fetch'];
				$args['orderby'] = $this->settings['orderby'];
				$args['order'] = $this->settings['order'];
				
				$query = new WP_Query( $args );

				// merge query
				if( !empty($sticky_query) ){
					$query->posts = array_merge($sticky_query->posts, $query->posts);
					$query->post_count = $sticky_query->post_count + $query->post_count;
				}

				return $query;
			}
			
		} // gdlr_core_blog_item
	} // class_exists
	
	add_action('wp_ajax_gdlr_core_post_ajax', 'gdlr_core_post_ajax');
	add_action('wp_ajax_nopriv_gdlr_core_post_ajax', 'gdlr_core_post_ajax');
	if( !function_exists('gdlr_core_post_ajax') ){
		function gdlr_core_post_ajax(){

			if( !empty($_POST['settings']) ){

				$settings = $_POST['settings'];
				if( !empty($_POST['option']) ){	
					$settings[$_POST['option']['name']] = $_POST['option']['value'];
				}

				$blog_item = new gdlr_core_blog_item($settings);
				$query = $blog_item->get_blog_query();	

				$ret = array(
					'status'=> 'success',
					'content'=> $blog_item->get_blog_grid_content($query)
				);
				if( !empty($settings['pagination']) && $settings['pagination'] != 'none' ){
					if( $settings['pagination'] == 'load-more' ){
						$paged = empty($query->query['paged'])? 2: intval($query->query['paged']) + 1;
						$extra_class = ($settings['no-space'] == 'yes')? '': 'gdlr-core-item-pdlr';

						$ret['load_more'] = gdlr_core_get_ajax_load_more('post', $settings, $paged, $query->max_num_pages, 'gdlr-core-blog-item-holder', $extra_class);
						$ret['load_more'] = empty($ret['load_more'])? 'none': $ret['load_more'];
					}
				} 

				die(json_encode($ret));
			}else{
				die(json_encode(array(
					'status'=> 'failed',
					'message'=> esc_html__('Settings variable is not defined.', 'goodlayers-core')
				)));
			}

		} // gdlr_core_post_load_more
	} // function_exists
	
	
	
	
	
	
	
	
	
	
	
	
	
	