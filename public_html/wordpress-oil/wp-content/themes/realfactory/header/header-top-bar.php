<?php
	/* a template for displaying the top bar */

	if( realfactory_get_option('general', 'enable-top-bar', 'enable') == 'enable' ){

		$top_bar_width = realfactory_get_option('general', 'top-bar-width', 'boxed');
		$top_bar_container_class = '';

		if( $top_bar_width == 'boxed' ){
			$top_bar_container_class = 'realfactory-container ';
		}else if( $top_bar_width == 'custom' ){
			$top_bar_container_class = 'realfactory-top-bar-custom-container ';
		}else{
			$top_bar_container_class = 'realfactory-top-bar-full ';
		}
		
		echo '<div class="realfactory-top-bar" >';
		echo '<div class="realfactory-top-bar-background" ></div>';
		echo '<div class="realfactory-top-bar-container clearfix ' . esc_attr($top_bar_container_class) . '" >';

		$language_flag = realfactory_get_wpml_flag();
		$left_text = realfactory_get_option('general', 'top-bar-left-text', '');
		if( !empty($left_text) || !empty($language_flag) ){
			echo '<div class="realfactory-top-bar-left realfactory-item-pdlr">';
			echo gdlr_core_escape_content($language_flag);
			echo gdlr_core_text_filter($left_text);
			echo '</div>';
		}

		$right_text = realfactory_get_option('general', 'top-bar-right-text', '');
		$top_bar_social = realfactory_get_option('general', 'enable-top-bar-social', 'enable');
		if( !empty($right_text) || $top_bar_social == 'enable' ){
			echo '<div class="realfactory-top-bar-right realfactory-item-pdlr">';
			if( !empty($right_text) ){
				echo '<div class="realfactory-top-bar-right-text">';
				echo gdlr_core_text_filter($right_text);
				echo '</div>';
			}

			if( $top_bar_social == 'enable' ){
				echo '<div class="realfactory-top-bar-right-social" >';
				get_template_part('header/header', 'social');
				echo '</div>';	
			}
			echo '</div>';	
		}
		echo '</div>';
		echo '</div>';

	}  // top bar
?>