<?php
/**
 * The template part for displaying blog archive
 */

	global $wp_query;

	$settings = array(
		'query' => $wp_query,
		'blog-style' => realfactory_get_option('general', 'archive-blog-style', 'blog-full'),
		'blog-full-alignment' => realfactory_get_option('general', 'archive-blog-full-alignment', 'left'),
		'thumbnail-size' => realfactory_get_option('general', 'archive-thumbnail-size', 'full'),
		'show-thumbnail' => realfactory_get_option('general', 'archive-show-thumbnail', 'enable'),
		'column-size' => realfactory_get_option('general', 'archive-column-size', 20),
		'excerpt' => realfactory_get_option('general', 'archive-excerpt', 'specify-number'),
		'excerpt-number' => realfactory_get_option('general', 'archive-excerpt-number', 55),
		'blog-date-feature' => realfactory_get_option('general', 'archive-date-feature', 'enable'),
		'meta-option' => realfactory_get_option('general', 'archive-meta-option', array()),
		'show-read-more' => realfactory_get_option('general', 'archive-show-read-more', 'enable'),

		'paged' => (get_query_var('paged'))? get_query_var('paged') : 1,
		'pagination' => 'page',
		'pagination-style' => realfactory_get_option('general', 'pagination-style', 'round'),
		'pagination-align' => realfactory_get_option('general', 'pagination-align', 'right'),

	);

	echo '<div class="realfactory-content-area" >';
	if( is_category() ){
		$tax_description = category_description();
		if( !empty($tax_description) ){
			echo '<div class="realfactory-archive-taxonomy-description realfactory-item-pdlr" >' . $tax_description . '</div>';
		}
	}else if( is_tag() ){
		$tax_description = term_description(NULL, 'post_tag');
		if( !empty($tax_description) ){
			echo '<div class="realfactory-archive-taxonomy-description realfactory-item-pdlr" >' . $tax_description . '</div>';
		}
	}

	echo gdlr_core_pb_element_blog::get_content($settings);
	echo '</div>'; // realfactory-content-area