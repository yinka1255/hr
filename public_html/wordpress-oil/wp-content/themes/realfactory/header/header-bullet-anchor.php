<?php
	/* a template for displaying the header social network */

	$post_option = realfactory_get_post_option(get_the_ID());
	if( !empty($post_option['bullet-anchor']) ){

		echo '<div class="realfactory-bullet-anchor" id="realfactory-bullet-anchor" >';
		echo '<a class="realfactory-bullet-anchor-link current-menu-item" href="' . get_permalink() . '" ></a>';
		foreach( $post_option['bullet-anchor'] as $anchor ){
			echo '<a class="realfactory-bullet-anchor-link" href="' . esc_url($anchor['title']) . '" ></a>';
		}
		echo '</div>';
	}