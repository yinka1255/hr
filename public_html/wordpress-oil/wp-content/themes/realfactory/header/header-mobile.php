<?php
	// mobile menu template
	
	echo '<div class="realfactory-mobile-header-wrap" >';

	// top bar
	$top_bar = realfactory_get_option('general', 'enable-top-bar-on-mobile', 'disable');
	if( $top_bar == 'enable' ){
		get_template_part('header/header', 'top-bar');
	}

	// header
	echo '<div class="realfactory-mobile-header realfactory-header-background realfactory-style-slide" id="realfactory-mobile-header" >';
	echo '<div class="realfactory-mobile-header-container realfactory-container" >';
	echo realfactory_get_logo(array('mobile' => true));

	echo '<div class="realfactory-mobile-menu-right" >';

	// search icon
	$enable_search = (realfactory_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
	if( $enable_search ){
		echo '<div class="realfactory-main-menu-search" id="realfactory-mobile-top-search" >';
		echo '<i class="fa fa-search" ></i>';
		echo '</div>';
		realfactory_get_top_search();
	}

	// cart icon
	$enable_cart = (realfactory_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
	if( $enable_cart ){
		echo '<div class="realfactory-main-menu-cart" id="realfactory-mobile-menu-cart" >';
		echo '<i class="fa fa-shopping-cart" ></i>';
		realfactory_get_woocommerce_bar();
		echo '</div>';
	}

	// mobile menu
	if( has_nav_menu('mobile_menu') ){
		realfactory_get_custom_menu(array(
			'type' => realfactory_get_option('general', 'right-menu-type', 'right'),
			'container-class' => 'realfactory-mobile-menu',
			'button-class' => 'realfactory-mobile-menu-button',
			'icon-class' => 'fa fa-bars',
			'id' => 'realfactory-mobile-menu',
			'theme-location' => 'mobile_menu'
		));
	}
	echo '</div>'; // realfactory-mobile-menu-right
	echo '</div>'; // realfactory-mobile-header-container
	echo '</div>'; // realfactory-mobile-header

	echo '</div>'; // realfactory-mobile-header-wrap