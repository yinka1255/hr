<?php
/**
 * The template for displaying all single posts and attachments
 */

get_header(); 
	
	// print header title
	if( get_post_type() == 'post' ){
		get_template_part('header/header', 'title-blog');
	}


	while( have_posts() ){ the_post();

		$post_option = realfactory_get_post_option(get_the_ID());

		if( empty($post_option['sidebar']) || $post_option['sidebar'] == 'default' ){
			$sidebar_type = realfactory_get_option('general', 'blog-sidebar', 'none');
			$sidebar_left = realfactory_get_option('general', 'blog-sidebar-left');
			$sidebar_right = realfactory_get_option('general', 'blog-sidebar-right');
		}else{
			$sidebar_type = empty($post_option['sidebar'])? 'none': $post_option['sidebar'];
			$sidebar_left = empty($post_option['sidebar-left'])? '': $post_option['sidebar-left'];
			$sidebar_right = empty($post_option['sidebar-right'])? '': $post_option['sidebar-right'];
		}

		// solely page builder
		if( !empty($post_option['show-content']) && $post_option['show-content'] == 'disable' ){
			do_action('gdlr_core_print_page_builder');
		} 

		echo '<div class="realfactory-content-container realfactory-container">';
		echo '<div class="' . realfactory_get_sidebar_wrap_class($sidebar_type) . '" >';

		// sidebar content
		echo '<div class="' . realfactory_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
		echo '<div class="realfactory-content-wrap realfactory-item-pdlr clearfix" >';

		// single content
		if( empty($post_option['show-content']) || $post_option['show-content'] == 'enable' ){
	
			echo '<div class="realfactory-content-area" >';
			if( in_array(get_post_format(), array('aside', 'quote', 'link')) ){
				get_template_part('content/content', get_post_format());
			}else{
				get_template_part('content/content', 'single');
			}
			echo '</div>';

			if( !post_password_required() ){
				if( $sidebar_type != 'none' ){
					do_action('gdlr_core_print_page_builder');
				}else{
					ob_start();
					do_action('gdlr_core_print_page_builder');
					$pb_content = ob_get_contents();
					ob_end_clean();

					if( !empty($pb_content) ){
						echo '</div>'; // realfactory-content-area
						echo '</div>'; // realfactory_get_sidebar_class
						echo '</div>'; // realfactory_get_sidebar_wrap_class
						echo '</div>'; // realfactory_content_container
						echo gdlr_core_escape_content($pb_content);
						echo '<div class="realfactory-bottom-page-builder-container realfactory-container" >'; // realfactory-content-area
						echo '<div class="realfactory-bottom-page-builder-sidebar-wrap realfactory-sidebar-style-none" >'; // realfactory_get_sidebar_class
						echo '<div class="realfactory-bottom-page-builder-sidebar-class" >'; // realfactory_get_sidebar_wrap_class
						echo '<div class="realfactory-bottom-page-builder-content realfactory-item-pdlr" >'; // realfactory_content_container
					}
				}
			}
		}

		// social share
		if( realfactory_get_option('general', 'blog-social-share', 'enable') == 'enable' ){
			if( class_exists('gdlr_core_pb_element_social_share') ){
				$share_count = (realfactory_get_option('general', 'blog-social-share-count', 'enable') == 'enable')? 'counter': 'none';

				echo '<div class="realfactory-single-social-share realfactory-item-rvpdlr" >';
				echo gdlr_core_pb_element_social_share::get_content(array(
					'social-head' => $share_count,
					'layout'=>'left-text', 
					'text-align'=>'left',
					'facebook'=>realfactory_get_option('general', 'blog-social-facebook', 'enable'),
					'linkedin'=>realfactory_get_option('general', 'blog-social-linkedin', 'enable'),
					'google-plus'=>realfactory_get_option('general', 'blog-social-google-plus', 'enable'),
					'pinterest'=>realfactory_get_option('general', 'blog-social-pinterest', 'enable'),
					'stumbleupon'=>realfactory_get_option('general', 'blog-social-stumbleupon', 'enable'),
					'twitter'=>realfactory_get_option('general', 'blog-social-twitter', 'enable'),
					'email'=>realfactory_get_option('general', 'blog-social-email', 'enable'),
					'padding-bottom'=>'0px'
				));
				echo '</div>';
			}
		}

		// author section
		if( realfactory_get_option('general', 'blog-author', 'enable') == 'enable' ){
			echo '<div class="clear"></div>';
			echo '<div class="realfactory-single-author" >';
			echo '<div class="realfactory-single-author-avartar realfactory-media-image">' . get_avatar(get_the_author_meta('ID'), 90) . '</div>';
			
			echo '<div class="realfactory-single-author-head-wrap" >';
			echo '<div class="realfactory-single-author-caption realfactory-info-font" >' . esc_html__('About the author', 'realfactory') . '</div>';
			echo '<h4 class="realfactory-single-author-title">';
			the_author_posts_link();
			echo '</h4>';
			echo '</div>'; // realfactory-single-author-head-wrap

			$author_desc = get_the_author_meta('description');
			if( !empty($author_desc) ){
				echo '<div class="realfactory-single-author-description" >' . gdlr_core_text_filter($author_desc) . '</div>';
			}
			echo '</div>'; // realfactory-single-author
		}

		// prev - next post navigation
		if( realfactory_get_option('general', 'blog-navigation', 'enable') == 'enable' ){
			$prev_post = get_previous_post_link(
				'<span class="realfactory-single-nav realfactory-single-nav-left">%link</span>',
				'<i class="arrow_left" ></i><span class="realfactory-text" >' . esc_html__( 'Prev', 'realfactory' ) . '</span>'
			);
			$next_post = get_next_post_link(
				'<span class="realfactory-single-nav realfactory-single-nav-right">%link</span>',
				'<span class="realfactory-text" >' . esc_html__( 'Next', 'realfactory' ) . '</span><i class="arrow_right" ></i>'
			);
			if( !empty($prev_post) || !empty($next_post) ){
				echo '<div class="realfactory-single-nav-area clearfix" >' . $prev_post . $next_post . '</div>';
			}
		}

		// comments template
		if( comments_open() || get_comments_number() ){
			comments_template();
		}

		echo '</div>'; // realfactory-content-area
		echo '</div>'; // realfactory-get-sidebar-class

		// sidebar left
		if( $sidebar_type == 'left' || $sidebar_type == 'both' ){
			echo realfactory_get_sidebar($sidebar_type, 'left', $sidebar_left);
		}

		// sidebar right
		if( $sidebar_type == 'right' || $sidebar_type == 'both' ){
			echo realfactory_get_sidebar($sidebar_type, 'right', $sidebar_right);
		}

		echo '</div>'; // realfactory-get-sidebar-wrap-class
	 	echo '</div>'; // realfactory-content-container

	} // while

	get_footer(); 
?>