<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.1.4
 */

$from_page = false;

if(($page_id =  petro_get_config('pre-footer-page'))){

	$footertext = petro_get_post_footer_page($page_id);
	$from_page = true;

}
else{

	$footertext = petro_get_config('pre-footer-text','');
	$footertext = apply_filters( 'petro_render_footer_text' , $footertext );
	$footertext = ($footertext!='') ? '<div class="container"><div class="row">'.$footertext.'</div></div>' : '';

}

if($footertext!=''){
?>
<div class="footer-text <?php print $from_page ? "no-padding":"";?>">
<?php
		print do_shortcode($footertext); 
?>
</div>
<?php
}

?>