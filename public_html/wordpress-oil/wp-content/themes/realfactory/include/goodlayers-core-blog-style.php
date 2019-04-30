<?php 
	/*	
	*	Goodlayers Core Plugin Filter
	*	---------------------------------------------------------------------
	*	This file contains the script to includes necessary function
	* 	for compatibility with goodlayers core plugin
	*	---------------------------------------------------------------------
	*/

	add_filter('gdlr_core_blog_style_content', 'realfactory_gdlr_core_blog_style_content', 10, 3);
	if( !function_exists('realfactory_gdlr_core_blog_style_content') ){
		function realfactory_gdlr_core_blog_style_content($ret, $args, $blog_style){
			
			if( $args['blog-style'] == 'blog-list' || $args['blog-style'] == 'blog-list-center' ){

				$with_frame = ( !empty($args['blog-list-with-frame']) && $args['blog-list-with-frame'] == 'enable' );
				$additional_class = ($args['blog-style'] == 'blog-list-center')? ' gdlr-core-center-align': '';
				$additional_class = ($with_frame)? ' gdlr-core-blog-list-with-frame': '';
				
				$ret  = '<div class="gdlr-core-item-list gdlr-core-blog-list gdlr-core-item-pdlr ' . esc_attr($additional_class) . '" >';
				$ret .= $with_frame? '<div class="gdlr-core-blog-list-frame gdlr-core-skin-e-background">': '';
				$ret .= $blog_style->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true,
					'icon' => false,
					'separator' => '/'
				));
				$ret .= $blog_style->blog_title($args);
				$ret .= $with_frame? '</div>': '';
				$ret .= '</div>'; // gdlr-core-blog-list
				
				return $ret;

			}else if( $args['blog-style'] == 'blog-full' || $args['blog-style'] == 'blog-full-with-frame' ){

				$post_format = get_post_format();
				if( in_array($post_format, array('aside', 'quote', 'link')) ){
					$args['extra-class']  = ' gdlr-core-blog-full gdlr-core-large';
					$args['extra-class'] .= (!empty($args['layout']) && $args['layout'] == 'carousel')? '': ' gdlr-core-item-pdlr';

					return $blog_style->blog_format( $args, $post_format );
				}

				$additional_class  = (!empty($args['layout']) && $args['layout'] == 'carousel')? '': ' gdlr-core-item-pdlr';
				$additional_class .= (!empty($args['blog-full-alignment']))? ' gdlr-core-style-' . $args['blog-full-alignment']: '';

				$ret  = '<div class="gdlr-core-item-list gdlr-core-blog-full ' . esc_attr($additional_class) . '" >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $blog_style->blog_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size'],
						'post-format' => $post_format,
						'post-format-thumbnail' => false,
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					)); 
				}
				
				$ret .= ($args['blog-style'] == 'blog-full-with-frame')? '<div class="gdlr-core-blog-full-frame gdlr-core-skin-e-background">': '';
				$ret .= '<div class="gdlr-core-blog-full-head clearfix">';
				$ret .= $blog_style->blog_date($args);
				
				$ret .= '<div class="gdlr-core-blog-full-head-right">';
				$ret .= $blog_style->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
				$ret .= $blog_style->blog_title( $args );
				$ret .= '</div>'; // gdlr-core-blog-full-head-right
				$ret .= '</div>'; // gdlr-core-blog-full-head
				
				$ret .= $blog_style->get_blog_excerpt($args);
				
				$ret .= ($args['blog-style'] == 'blog-full-with-frame')? '</div>': '';
				$ret .= '</div>'; // gdlr-core-blog-full

				return $ret;
			}else if( $args['blog-style'] == 'blog-column' || $args['blog-style'] == 'blog-column-no-space' || $args['blog-style'] == 'blog-column-with-frame' ){

				$post_format = get_post_format();
				if( in_array($post_format, array('aside', 'quote', 'link')) ){
					$args['extra-class']  = ' gdlr-core-blog-grid gdlr-core-small';
					
					return $blog_style->blog_format( $args, $post_format );
				}

				$additional_class  = ($args['blog-style'] == 'blog-column-with-frame')? ' gdlr-core-blog-grid-with-frame gdlr-core-item-mgb': '';

				$ret  = '<div class="gdlr-core-blog-grid ' . esc_attr($additional_class) . '" >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $blog_style->blog_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size'],
						'post-format' => $post_format,
						'post-format-gallery' => 'slider',
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					));
				}
				
				if( $args['blog-style'] == 'blog-column-with-frame' ){
					$ret .= '<div class="gdlr-core-blog-grid-frame gdlr-core-skin-e-background">';
				}else{
					$ret .= '<div class="gdlr-core-blog-grid-content-wrap">';
				}
				$ret .= $blog_style->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
				
				$ret .= $blog_style->blog_title($args);
				$ret .= $blog_style->get_blog_excerpt($args);
				$ret .= '</div>'; // gdlr-core-blog-grid-content-wrap
				$ret .= '</div>'; // gdlr-core-blog-grid
				
				return $ret;

			}

			return false;
		}
	}

	// edit blog item options
	add_filter('gdlr_core_blog_item_options', 'realfactory_gdlr_core_blog_item_options');
	if( !function_exists('realfactory_gdlr_core_blog_item_options') ){
		function realfactory_gdlr_core_blog_item_options( $options ){

			if( !empty($options['settings']['options']['show-read-more']['condition']) ){
				$options['settings']['options']['show-read-more']['condition'] = array( 'blog-style' => array(
					'blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-column', 'blog-column-no-space', 'blog-column-with-frame'
				));
			}

			return $options;

		}
	}

	// change the read more button
	add_filter('gdlr_core_blog_read_more', 'realfactory_gdlr_core_blog_read_more');
	if( !function_exists('realfactory_gdlr_core_blog_read_more') ){
		function realfactory_gdlr_core_blog_read_more( $options ){
			return '<a class="gdlr-core-excerpt-read-more" href="' . get_permalink() . '" >' . esc_html__('Continue Reading', 'realfactory') . '<i class="fa fa-long-arrow-right"></i></a>';
		}	
	}