<?php
	/* a template for displaying the header area */

	// header container
	$body_layout = realfactory_get_option('general', 'layout', 'full');
	$body_margin = realfactory_get_option('general', 'body-margin', '0px');
	$header_width = realfactory_get_option('general', 'header-width', 'boxed');
	$header_style = realfactory_get_option('general', 'header-bar-navigation-align', 'center');
	$header_background_style = realfactory_get_option('general', 'header-background-style', 'solid');

	$header_wrap_class = '';
	if( $header_style == 'center-logo' ){
		$header_wrap_class .= ' realfactory-style-center';
	}else{
		$header_wrap_class .= ' realfactory-style-left';
	}

	$header_container_class = '';
	if( $header_width == 'boxed' ){
		$header_container_class .= ' realfactory-container';
	}else if( $header_width == 'custom' ){
		$header_container_class .= ' realfactory-header-custom-container';
	}else{
		$header_container_class .= ' realfactory-header-full';
	}

	$navigation_wrap_class  = ' realfactory-style-' . $header_background_style;
	$navigation_wrap_class .= ' realfactory-sticky-navigation realfactory-sticky-navigation-height';
	if( $header_style == 'center' || $header_style == 'center-logo' ){
		$navigation_wrap_class .= ' realfactory-style-center';
	}else{
		$navigation_wrap_class .= ' realfactory-style-left';
	}
	if( $body_layout == 'boxed' || $body_margin != '0px' ){
		$navigation_wrap_class .= ' realfactory-style-slide';
	}else{
		$navigation_wrap_class .= '  realfactory-style-fixed';
	}
	if( $header_background_style == 'transparent' ){
		$navigation_wrap_class .= ' realfactory-without-placeholder';
	}

?>	
<header class="realfactory-header-wrap realfactory-header-style-bar realfactory-header-background <?php echo esc_attr($header_wrap_class); ?>" >
	<div class="realfactory-header-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<div class="realfactory-header-container-inner">
		<?php
			echo realfactory_get_logo();

			// logo right section
			$logo_right = '';
			for( $i = 1; $i <= 3; $i++ ){
				$logo_right_icon = realfactory_get_option('general', 'logo-right-box' . $i . '-icon', '');
				$logo_right_title = realfactory_get_option('general', 'logo-right-box' . $i . '-title', '');
				$logo_right_caption = realfactory_get_option('general', 'logo-right-box' . $i . '-caption', '');

				if( !empty($logo_right_icon) || !empty($logo_right_title) || !empty($logo_right_caption) ){
					$logo_right .= '<div class="realfactory-logo-right-block" >';
					if( !empty($logo_right_icon) ){
						$logo_right .= '<i class="realfactory-logo-right-block-icon ' . esc_attr($logo_right_icon) . '" ></i>';
					}
					$logo_right .= '<div class="realfactory-logo-right-block-content" >';
					if( !empty($logo_right_title) ){
						$logo_right .= '<div class="realfactory-logo-right-block-title realfactory-title-font" >' . gdlr_core_escape_content($logo_right_title) . '</div>';
					}
					if( !empty($logo_right_caption) ){
						$logo_right .= '<div class="realfactory-logo-right-block-caption realfactory-title-font" >' . gdlr_core_escape_content($logo_right_caption) . '</div>';
					}
					$logo_right .= '</div>'; // block-content
					$logo_right .= '</div>'; // block
				}
			}

			// header right button
			$enable_right_button = (realfactory_get_option('general', 'enable-header-right-button', 'disable') == 'enable')? true: false;
			if( $enable_right_button ){
				$button_link = realfactory_get_option('general', 'header-right-button-link', '');
				$button_link_target = realfactory_get_option('general', 'header-right-button-link-target', '_self');
				
				$logo_right .= '<a class="realfactory-header-right-button" href="' . esc_url($button_link) . '" target="' . esc_attr($button_link_target) . '" >';
				$logo_right .= realfactory_get_option('general', 'header-right-button-text', '');
				$logo_right .= '</a>';
			}

			if( !empty($logo_right) ){
				echo '<div class="realfactory-logo-right-text realfactory-item-pdlr" >';
				echo gdlr_core_escape_content($logo_right);
				echo '</div>';
			}
		?>
		</div>
	</div>
</header><!-- header -->
<div class="realfactory-navigation-bar-wrap <?php echo esc_attr($navigation_wrap_class); ?>" >
	<div class="realfactory-navigation-background" ></div>
	<div class="realfactory-navigation-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<?php
			$navigation_class = '';
			if( realfactory_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
				$navigation_class .= 'realfactory-navigation-submenu-indicator ';
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
			if( $header_style == 'center' || $header_style == 'center-logo' ){
				$menu_right_class = ' realfactory-item-mglr realfactory-navigation-top';
			}

			// menu right side
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
				if( has_nav_menu('right_menu') ){
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
			}
		?>
		</div><!-- realfactory-navigation -->

	</div><!-- realfactory-header-container -->
</div><!-- realfactory-navigation-bar-wrap -->