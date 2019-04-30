<?php
/**
 * The main template file
 */

	get_header();

	echo '<div class="realfactory-content-container realfactory-container">';
	echo '<div class="realfactory-sidebar-style-none" >'; // for max width

	get_template_part('content/archive', 'default');

	echo '</div>'; // realfactory-content-area
	echo '</div>'; // realfactory-content-container

	get_footer(); 
