<?php
/**
 * The template for displaying the footer
 */
	
	$post_option = realfactory_get_post_option(get_the_ID());
	if( empty($post_option['enable-footer']) || $post_option['enable-footer'] == 'default' ){
		$enable_footer = realfactory_get_option('general', 'enable-footer', 'enable');
	}else{
		$enable_footer = $post_option['enable-footer'];
	}	
	if( empty($post_option['enable-copyright']) || $post_option['enable-copyright'] == 'default' ){
		$enable_copyright = realfactory_get_option('general', 'enable-copyright', 'enable');
	}else{
		$enable_copyright = $post_option['enable-footer'];
	}

	$fixed_footer = realfactory_get_option('general', 'fixed-footer', 'disable');
	echo '</div>'; // realfactory-page-wrapper

	if( $enable_footer == 'enable' || $enable_copyright == 'enable' ){

		if( $fixed_footer == 'enable' ){
			echo '</div>'; // realfactory-body-wrapper

			echo '<footer class="realfactory-fixed-footer" id="realfactory-fixed-footer" >';
		}else{
			echo '<footer>';
		}

		if( $enable_footer == 'enable' ){

			echo '<div class="realfactory-footer-wrapper" >';
			echo '<div class="realfactory-footer-container realfactory-container clearfix" >';
			
			$realfactory_footer_layout = array(
				'footer-1'=>array('realfactory-column-60'),
				'footer-2'=>array('realfactory-column-15', 'realfactory-column-15', 'realfactory-column-15', 'realfactory-column-15'),
				'footer-3'=>array('realfactory-column-15', 'realfactory-column-15', 'realfactory-column-30',),
				'footer-4'=>array('realfactory-column-20', 'realfactory-column-20', 'realfactory-column-20'),
				'footer-5'=>array('realfactory-column-20', 'realfactory-column-40'),
				'footer-6'=>array('realfactory-column-40', 'realfactory-column-20'),
			);
			
			$count = 0;
			$footer_style = realfactory_get_option('general', 'footer-style');
			$footer_style = empty($footer_style)? 'footer-2': $footer_style;
			foreach( $realfactory_footer_layout[$footer_style] as $layout ){ $count++;
				echo '<div class="realfactory-footer-column realfactory-item-pdlr ' . esc_attr($layout) . '" >';
				if( is_active_sidebar('footer-' . $count) ){
					dynamic_sidebar('footer-' . $count); 
				}
				echo '</div>';
			}
			
			echo '</div>'; // realfactory-footer-container
			echo '</div>'; // realfactory-footer-wrapper 

		} // enable footer

		if( $enable_copyright == 'enable' ){
			$copyright_text = realfactory_get_option('general', 'copyright-text');

			if( !empty($copyright_text) ){
				echo '<div class="realfactory-copyright-wrapper" >';
				echo '<div class="realfactory-copyright-container realfactory-container">';
				echo '<div class="realfactory-copyright-text realfactory-item-pdlr">';
				echo gdlr_core_text_filter($copyright_text);
				echo '</div>';
				echo '</div>';
				echo '</div>'; // realfactory-copyright-wrapper
			}
		}

		echo '</footer>';

		if( $fixed_footer == 'disable' ){
			echo '</div>'; // realfactory-body-wrapper
		}
		echo '</div>'; // realfactory-body-outer-wrapper

	// disable footer	
	}else{
		echo '</div>'; // realfactory-body-wrapper
		echo '</div>'; // realfactory-body-outer-wrapper
	}

	$header_style = realfactory_get_option('general', 'header-style', 'plain');
	
	if( $header_style == 'side' || $header_style == 'side-toggle' ){
		echo '</div>'; // realfactory-header-side-nav-content
	}

	$back_to_top = realfactory_get_option('general', 'enable-back-to-top', 'disable');
	if( $back_to_top == 'enable' ){
		echo '<a href="#realfactory-top-anchor" class="realfactory-footer-back-to-top-button" id="realfactory-footer-back-to-top-button"><i class="fa fa-angle-up" ></i></a>';
	}
?>

<?php wp_footer(); ?>

</body>
</html>