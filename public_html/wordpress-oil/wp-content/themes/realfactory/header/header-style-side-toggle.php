<?php
	/* a template for displaying the header area */
?>	
<header class="realfactory-header-wrap realfactory-header-style-side-toggle" >
	<?php
		$display_logo = realfactory_get_option('general', 'header-side-toggle-display-logo', 'enable');
		if( $display_logo == 'enable' ){
			echo realfactory_get_logo(array('padding' => false));
		}

		$navigation_class = '';
		if( realfactory_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
			$navigation_class = 'realfactory-navigation-submenu-indicator ';
		}
	?>
	<div class="realfactory-navigation clearfix <?php echo esc_attr($navigation_class); ?>" >
	<?php
		// print main menu
		if( has_nav_menu('main_menu') ){
			realfactory_get_custom_menu(array(
				'container-class' => 'realfactory-main-menu',
				'button-class' => 'realfactory-side-menu-icon',
				'icon-class' => 'fa fa-bars',
				'id' => 'realfactory-main-menu',
				'theme-location' => 'main_menu',
				'type' => realfactory_get_option('general', 'header-side-toggle-menu-type', 'overlay')
			));
		}
	?>
	</div><!-- realfactory-navigation -->
	<?php

		// menu right side
		$enable_search = (realfactory_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
		$enable_cart = (realfactory_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
		if( $enable_search || $enable_cart ){ 
			echo '<div class="realfactory-header-icon realfactory-pos-bottom" >';

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
</header><!-- header -->