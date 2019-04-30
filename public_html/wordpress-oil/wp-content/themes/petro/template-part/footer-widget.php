<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

$footertext = petro_get_config('footer-text','');


$footertext = apply_filters( 'petro_render_footer_text' , $footertext );
$position = petro_get_config('footer-text-position');


if($footertext!=''){
?>
<div class="footer-widget <?php print petro_get_config('widget-layout-mode','');?>">
	<div class="container">
		<div class="row">
<?php
	$text_grid = absint(petro_get_config( 'footer-text-grid' , 3));

	if(is_active_sidebar('footer-widget') && petro_get_config('showwidgetarea',true)){
$widget_grid = $text_grid == 12 ? 12 : 12 - $text_grid;
?>
<div class="col-xs-12 <?php print 'col-md-'.$widget_grid.(($text_grid!=12 && $position!='right') ? ' col-md-push-'.$text_grid:'');?>">
	<div class="row">
<?php dynamic_sidebar('footer-widget');?>
	</div>
</div>
<div class="col-xs-12 <?php print 'col-md-'.$text_grid.(($widget_grid!=12 && $position!='right') ? ' col-md-pull-'.$widget_grid:'');?>">
<?php print wp_kses_post($footertext); ?>
</div>
<?php

	}
	else{
		print wp_kses_post($footertext); 
	}
?>
		</div>
	</div>
</div>
<?php
}
else{
?>
<?php if(petro_get_config('showwidgetarea',true) && is_active_sidebar('footer-widget')):?>
<div class="footer-widget <?php print petro_get_config('widget-layout-mode','');?>">
	<div class="container">
		<div class="row">
	<?php dynamic_sidebar('footer-widget');?>
		</div>
	</div>
</div>
<?php endif;
}
?>