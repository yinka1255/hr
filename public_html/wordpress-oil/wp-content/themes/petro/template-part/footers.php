<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.1.0
 */

//footer-type

if( ($type = petro_get_config('footer-type','option')) && $type =='page' && ($page_id = petro_get_config('footer-page')) ){
	$footer_html = petro_get_post_footer_page($page_id);

	print '<div class="footer-text no-padding">'.$footer_html.'</div>';
}
else{?>

<?php get_template_part( 'template-part/footer-text'); ?>
<?php if(petro_get_config('showcontactcard',true)):?>
		<?php get_template_part( 'template-part/footer-contact-card'); ?>
<?php endif;?>
<?php get_template_part( 'template-part/footer-widget'); ?>
<?php get_template_part( 'template-part/footer-copyright'); ?>
<?php 
}?>