<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */


if(apply_filters('is_themegum_load_sidebar',false)):?>
	<div class="sidebar col-xs-12 <?php print apply_filters('themegum_sidebar_css_column','col-sm-6 col-md-4');?>">
		<div class="widgets-container">
		<?php
			$sidebar= apply_filters('petro_sidebar_name', 'sidebar-widget');
			dynamic_sidebar($sidebar);
		?>
		</div>
	</div>
<?php
endif;
?>