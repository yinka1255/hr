<?php
	/* a template for displaying the header area */

	$header_class = 'realfactory-' . realfactory_get_option('general', 'header-side-align', 'left') . '-align';
?>	
<header class="realfactory-header-wrap realfactory-header-style-side <?php echo esc_attr($header_class); ?>" >
	<?php

		echo realfactory_get_logo(array('padding' => false));

		$navigation_class = '';
		if( realfactory_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
			$navigation_class = 'realfactory-navigation-submenu-indicator ';
		}
	?>
	<div class="realfactory-navigation clearfix realfactory-pos-middle <?php echo esc_attr($navigation_class); ?>" >
	<?php
		// print main menu
		if( has_nav_menu('main_menu') ){
			echo '<div class="realfactory-main-menu" id="realfactory-main-menu" >';
			wp_nav_menu(array(
				'theme_location'=>'main_menu', 
				'container'=> '', 
				'menu_class'=> 'sf-vertical'
			));
			echo '</div>';
		}

		// menu right side
		$enable_search = (realfactory_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
		$enable_cart = (realfactory_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
		if( $enable_search || $enable_cart ){
			echo '<div class="realfactory-main-menu-right-wrap clearfix" >';

			// search icon
			if( $enable_search ){
				echo '<div class="realfactory-main-menu-search" id="realfactory-top-search" >';
				echo '<i class="fa fa-search" ></i>';
				echo '</div>';
				realfactory_get_top_search();
			}

			// cart icon
			if( $enable_cart ){
				echo '<div class="realfactory-main-menu-cart" id="realfactory-main-menu-cart" >';
				echo '<i class="fa fa-shopping-cart" ></i>';
				realfactory_get_woocommerce_bar();
				echo '</div>';
			}

			echo '</div>'; // realfactory-main-menu-right-wrap
		}
	?>
	</div><!-- realfactory-navigation -->
	<?php
		// social network
		$top_bar_social = realfactory_get_option('general', 'enable-top-bar-social', 'enable');
		if( $top_bar_social == 'enable' ){
			echo '<div class="realfactory-header-social realfactory-pos-bottom" >';
			get_template_part('header/header', 'social');
			echo '</div>';
			
			realfactory_set_option('general', 'enable-top-bar-social', 'disable');
		}
	?>
</header><!-- header -->