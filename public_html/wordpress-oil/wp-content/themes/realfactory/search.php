<?php
/**
 * The main template file
 */

	get_header();

	if( have_posts() ){

		$sidebar_type = realfactory_get_option('general', 'archive-blog-sidebar', 'none');
		$sidebar_left = realfactory_get_option('general', 'archive-blog-sidebar-left');
		$sidebar_right = realfactory_get_option('general', 'archive-blog-sidebar-right');

		echo '<div class="realfactory-content-container realfactory-container">';
		echo '<div class="' . realfactory_get_sidebar_wrap_class($sidebar_type) . '" >';

		// sidebar content
		echo '<div class="' . realfactory_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
		
		if( class_exists('gdlr_core_pb_element_blog')  ){

			get_template_part('content/archive', 'blog');

		}else{

			get_template_part('content/archive', 'default');
			
		}

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
	 	
	 }

	get_footer(); 
?>