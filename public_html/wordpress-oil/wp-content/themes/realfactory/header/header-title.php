<?php
	/* a template for displaying the page title */

	$page_title = '';
	$page_caption = '';
	$breadcrumbs = 'disable';

	$title_style = realfactory_get_option('general', 'default-title-style', 'small');
	$title_align = realfactory_get_option('general', 'default-title-align', 'left');

	// for index page
	if( is_home() ){
		$main_head = true;
		$page_title = esc_html__('Home Page', 'realfactory');

	// for single post
	}else if( is_single() && get_post_type() == 'post' ){


	// for single product
	}else if( is_single() && get_post_type() == 'product' ){

		echo '<div class="realfactory-header-transparent-substitute" ></div>';

	// for pages
	}else if( is_page() || is_single() ){
		$post_option = realfactory_get_post_option(get_the_ID());

		$main_head = true;
		$page_title = get_the_title();
		$page_caption = empty($post_option['page-caption'])? '': $post_option['page-caption'];

		if( !empty($post_option['title-background']) ){
			$title_background = $post_option['title-background'];
		}

		$title_color = empty($post_option['title-color'])? '': $post_option['title-color'];
		$caption_color = empty($post_option['caption-color'])? '': $post_option['caption-color'];
		$background_overlay_color = empty($post_option['title-background-overlay-color'])? '': $post_option['title-background-overlay-color'];
		if( !empty($post_option['title-align']) && $post_option['title-align'] != 'default' ){
			$title_align = $post_option['title-align'];
		}

		if( !empty($post_option['title-style']) && $post_option['title-style'] != 'default' ){
			$title_style = $post_option['title-style'];

			if( $post_option['title-style'] == 'custom' ){
				$title_size = empty($post_option['title-font-size'])? '': $post_option['title-font-size'];
				$title_weight = empty($post_option['title-font-weight'])? '': $post_option['title-font-weight'];
				$title_transform = empty($post_option['title-font-transform'])? '': $post_option['title-font-transform'];
				$title_spacing = empty($post_option['title-spacing'])? array(): $post_option['title-spacing'];
				$title_overlay_opacity = empty($post_option['title-background-overlay-opacity'])? '': $post_option['title-background-overlay-opacity'];
			}
		}

		// breadcrumbs
		if( is_page() ){
			if( empty($post_option['enable-breadcrumbs']) || $post_option['enable-breadcrumbs'] == 'default' ){
				$breadcrumbs = realfactory_get_option('general', 'enable-default-breadcrumbs-on-page', 'disable');
			}else{
				$breadcrumbs = $post_option['enable-breadcrumbs'];
			}
		}else if( is_single() && get_post_type() == 'portfolio' ){
			if( empty($post_option['enable-breadcrumbs']) || $post_option['enable-breadcrumbs'] == 'default' ){
				$breadcrumbs = realfactory_get_option('general', 'enable-default-breadcrumbs-on-portfolio', 'disable');
			}else{
				$breadcrumbs = $post_option['enable-breadcrumbs'];
			}
		}

	// 404 page
	}else if( is_404() ){

	// search page
	}else if( is_search() ){

		if( have_posts() ){
			$page_title = esc_html__('Search Results', 'realfactory');
			$page_caption = get_search_query();
		}else{
			get_template_part('content/archive', 'not-found');
		}

	// archive page
	}else if( is_archive() ){

		$breadcrumbs = realfactory_get_option('general', 'enable-breadcrumbs-on-archive', 'disable');

		if( is_category() || is_tax('portfolio_category') || is_tax('product_cat') ){
			$page_title = esc_html__('Category', 'realfactory');

			if( is_tax('product_cat') && function_exists('woocommerce_breadcrumb') ){
				ob_start();
				woocommerce_breadcrumb();
				$page_caption = ob_get_contents();
				ob_end_clean();
			}else{
				$page_caption = single_cat_title('', false);
			}
		}else if( is_tag() || is_tax('portfolio_tag') || is_tax('product_tag') ){
			$page_title = esc_html__('Tag', 'realfactory');
			
			if( is_tax('product_cat') && function_exists('woocommerce_breadcrumb') ){
				ob_start();
				woocommerce_breadcrumb();
				$page_caption = ob_get_contents();
				ob_end_clean();
			}else{
				$page_caption = single_cat_title('', false);
			}
		}else if( is_day() ){
			$page_title = esc_html__('Day','realfactory');
			$page_caption = get_the_date('F j, Y');
		}else if( is_month() ){
			$page_title = esc_html__('Month','realfactory');
			$page_caption = get_the_date('F Y');
		}else if( is_year() ){
			$page_title = esc_html__('Year','realfactory');
			$page_caption = get_the_date('Y');
		}else if( is_author() ){
			$page_title = esc_html__('By','realfactory');
			
			$author_id = get_query_var('author');
			$author = get_user_by('id', $author_id);
			$page_caption = $author->display_name;					
		}else if( is_post_type_archive('product') ){
			$page_title = esc_html__('Shop', 'realfactory');
			$page_caption = '';
		}else{
			$page_title = get_the_title();
			$page_caption = '';
		}

	}

	if( (empty($post_option['enable-page-title']) || $post_option['enable-page-title'] == 'enable') && (!empty($page_title) || !empty($page_caption)) ){	

		$page_title = apply_filters('realfactory_page_title', $page_title);
		$page_caption = apply_filters('realfactory_page_caption', $page_caption);

		$extra_class  = ' realfactory-style-' . $title_style;
		$extra_class .= ' realfactory-' . $title_align . '-align';

		echo '<div class="realfactory-page-title-wrap ' . esc_attr($extra_class) . '" ' . gdlr_core_esc_style(array(
			'background-image' => empty($title_background)? '': $title_background
		)) . '>';
		echo '<div class="realfactory-header-transparent-substitute" ></div>';
		echo '<div class="realfactory-page-title-overlay" ' . gdlr_core_esc_style(array(
			'opacity' => empty($title_overlay_opacity)? '': $title_overlay_opacity,
			'background-color' => empty($background_overlay_color)? '': $background_overlay_color
		)) . ' ></div>';
		echo '<div class="realfactory-page-title-container realfactory-container" >';
		echo '<div class="realfactory-page-title-content realfactory-item-pdlr" ' . gdlr_core_esc_style(array(
			'padding-top' => empty($title_spacing['padding-top'])? '': $title_spacing['padding-top'],
			'padding-bottom' => empty($title_spacing['padding-bottom'])? '': $title_spacing['padding-bottom']
		)) . ' >';
		if( !empty($page_title) ){
			if( !empty($main_head) ){
				echo '<h1 class="realfactory-page-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['title-size'])? '': $title_size['title-size'],
					'font-weight' => empty($title_weight['title-weight'])? '': $title_weight['title-weight'],
					'text-transform' => (empty($title_transform) || $title_transform == 'default')? '': $title_transform,
					'letter-spacing' => empty($title_size['title-letter-spacing'])? '': $title_size['title-letter-spacing'],
					'color' => empty($title_color)? '': $title_color
				)) . ' >' . $page_title . '</h1>';
			}else{
				echo '<h3 class="realfactory-page-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['title-size'])? '': $title_size['title-size'],
					'font-weight' => empty($title_weight['title-weight'])? '': $title_weight['title-weight'],
					'text-transform' => (empty($title_transform) || $title_transform == 'default')? '': $title_transform,
					'letter-spacing' => empty($title_size['title-letter-spacing'])? '': $title_size['title-letter-spacing'],
					'color' => empty($title_color)? '': $title_color
				)) . ' >' . $page_title . '</h3>';
			}
		}

		if( !empty($page_caption) ){
			echo '<div class="realfactory-page-caption" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['caption-size'])? '': $title_size['caption-size'],
					'font-weight' => empty($title_weight['caption-weight'])? '': $title_weight['caption-weight'],
					'letter-spacing' => empty($title_size['caption-letter-spacing'])? '': $title_size['caption-letter-spacing'],
					'margin-top' => empty($title_spacing['caption-top-margin'])? '': $title_spacing['caption-top-margin'],
					'color' => empty($caption_color)? '': $caption_color
				)) . ' >' . $page_caption . '</div>';
		}
		echo '</div>'; // realfactory-page-title-content
		echo '</div>'; // realfactory-page-title-container
		echo '</div>'; // realfactory-page-title-wrap


		// breadcrumbs
		if( function_exists('bcn_display') && $breadcrumbs == 'enable' ){
			echo '<div class="realfactory-breadcrumbs" >';
			echo '<div class="realfactory-breadcrumbs-container realfactory-container" >';
			echo '<div class="realfactory-breadcrumbs-item realfactory-item-pdlr" >';
       		bcn_display();
       		echo '</div>';
       		echo '</div>';
       		echo '</div>';
    	}

	}
?>