<?php
/**
 * The template part for displaying default archive
 */

	echo '<div class="realfactory-content-area realfactory-item-pdlr" >';

	while( have_posts() ){ the_post();

		get_template_part('content/content', 'full');
		
	} // while

	the_posts_pagination(array(
		'prev_text'          => esc_html__('Previous page', 'realfactory'),
		'next_text'          => esc_html__('Next page', 'realfactory'),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'realfactory') . ' </span>',
	));

	echo '</div>'; // realfactory-content-area