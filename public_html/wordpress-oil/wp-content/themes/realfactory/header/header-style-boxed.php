<?php
	/* a template for displaying the header area */

	// header container
	$header_width = realfactory_get_option('general', 'header-width', 'boxed');
	
	if( $header_width == 'boxed' ){
		$header_container_class = ' realfactory-container';
	}else if( $header_width == 'custom' ){
		$header_container_class = ' realfactory-header-custom-container';
	}else{
		$header_container_class = ' realfactory-header-full';
	}

	$header_style = realfactory_get_option('general', 'header-boxed-style', 'menu-right');
	$header_wrap_class  = ' realfactory-style-' . $header_style;
	$header_wrap_class .= ' realfactory-sticky-navigation realfactory-style-slide';
?>	
<header class="realfactory-header-wrap realfactory-header-style-boxed <?php echo esc_attr($header_wrap_class); ?>" >
	<div class="realfactory-header-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<div class="realfactory-header-container-inner clearfix">	

			<div class="realfactory-header-background  realfactory-item-mglr" ></div>
			<div class="realfactory-header-container-item clearfix">
				<?php

					if( $header_style == 'splitted-menu' ){
						add_filter('realfactory_center_menu_item', 'realfactory_get_logo');
					}else{
						echo realfactory_get_logo();
					}

					$navigation_class = '';
					if( realfactory_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
						$navigation_class = 'realfactory-navigation-submenu-indicator ';
					}
				?>
				<div class="realfactory-navigation realfactory-item-pdlr clearfix <?php echo esc_attr($navigation_class); ?>" >
				<?php
					// print main menu
					if( has_nav_menu('main_menu') ){
						echo '<div class="realfactory-main-menu" id="realfactory-main-menu" >';
						wp_nav_menu(array(
							'theme_location'=>'main_menu', 
							'container'=> '', 
							'menu_class'=> 'sf-menu',
							'walker' => new realfactory_menu_walker()
						));
						$slide_bar = realfactory_get_option('general', 'navigation-slide-bar', 'enable');
						if( $slide_bar == 'enable' ){
							echo '<div class="realfactory-navigation-slide-bar" id="realfactory-navigation-slide-bar" ></div>';
						}
						echo '</div>';
					}

					// menu right side
					$menu_right_class = '';
					if( $header_style == 'center-menu' || $header_style == 'splitted-menu' ){
						$menu_right_class = ' realfactory-item-mglr realfactory-navigation-top realfactory-navigation-right';
					}

					$enable_search = (realfactory_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
					$enable_cart = (realfactory_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
					$enable_right_button = (realfactory_get_option('general', 'enable-main-navigation-right-button', 'disable') == 'enable')? true: false;
					if( has_nav_menu('right_menu') || $enable_search || $enable_cart ){
						echo '<div class="realfactory-main-menu-right-wrap clearfix ' . esc_attr($menu_right_class) . '" >';

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

						// menu right button
						if( $enable_right_button ){
							$button_link = realfactory_get_option('general', 'main-navigation-right-button-link', '');
							$button_link_target = realfactory_get_option('general', 'main-navigation-right-button-link-target', '_self');
							echo '<a class="realfactory-main-menu-right-button" href="' . esc_url($button_link) . '" target="' . esc_attr($button_link_target) . '" >';
							echo realfactory_get_option('general', 'main-navigation-right-button-text', '');
							echo '</a>';
						}

						// print right menu
						if( has_nav_menu('right_menu') && $header_style != 'splitted-menu' ){
							realfactory_get_custom_menu(array(
								'container-class' => 'realfactory-main-menu-right',
								'button-class' => 'realfactory-right-menu-button realfactory-top-menu-button',
								'icon-class' => 'fa fa-bars',
								'id' => 'realfactory-right-menu',
								'theme-location' => 'right_menu',
								'type' => realfactory_get_option('general', 'right-menu-type', 'right')
							));
						}

						echo '</div>'; // realfactory-main-menu-right-wrap

						if( has_nav_menu('right_menu') && $header_style == 'splitted-menu' ){
							echo '<div class="realfactory-main-menu-left-wrap clearfix realfactory-item-pdlr realfactory-navigation-top realfactory-navigation-left" >';
							realfactory_get_custom_menu(array(
								'container-class' => 'realfactory-main-menu-right',
								'button-class' => 'realfactory-right-menu-button realfactory-top-menu-button',
								'icon-class' => 'fa fa-bars',
								'id' => 'realfactory-right-menu',
								'theme-location' => 'right_menu',
								'type' => realfactory_get_option('general', 'right-menu-type', 'right')
							));
							echo '</div>';
						}
					}
				?>
				</div><!-- realfactory-navigation -->

			</div><!-- realfactory-header-container-inner -->
		</div><!-- realfactory-header-container-item -->
	</div><!-- realfactory-header-container -->
</header><!-- header -->