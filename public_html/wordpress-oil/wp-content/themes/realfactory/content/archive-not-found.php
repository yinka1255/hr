<?php
/**
 * The template for displaying archive not found
 */

	echo '<div class="realfactory-not-found-wrap" id="realfactory-full-no-header-wrap" >';
	echo '<div class="realfactory-not-found-background" ></div>';
	echo '<div class="realfactory-not-found-container realfactory-container">';

	echo '<div class="realfactory-not-found-content realfactory-item-pdlr">';
	echo '<h1 class="realfactory-not-found-head" >' . esc_html__('Not Found', 'realfactory') . '</h1>';
	echo '<div class="realfactory-not-found-caption" >' . esc_html__('Nothing matched your search criteria. Please try again with different keywords.', 'realfactory') . '</div>';

	echo '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">';
	echo '<input type="text" class="search-field realfactory-title-font" placeholder="' . esc_html__('Type Keywords...', 'realfactory') . '" value="" name="s">';
	echo '<div class="realfactory-top-search-submit"><i class="fa fa-search" ></i></div>';
	echo '<input type="submit" class="search-submit" value="Search">';
	echo '</form>';
	echo '<div class="realfactory-not-found-back-to-home" ><a href="' . esc_url(home_url('/')) . '" >' . esc_html__('Or Back To Homepage', 'realfactory') . '</a></div>';
	echo '</div>'; // realfactory-not-found-content

	echo '</div>'; // realfactory-not-found-container
	echo '</div>'; // realfactory-not-found-wrap