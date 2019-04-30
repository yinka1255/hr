<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.0.0
 */

$quote_menu_label = petro_get_config( 'quote_menu_label' , '');

$quote_menu_link = petro_get_config( 'quote_menu_link' , '');
$quote_menu_link_target = petro_get_config( 'quote_menu_link_target' , 'blank');
?>
<div class="quote-menu collapse">
<a class="btn btn-primary quote-btn" target="_<?php print esc_attr($quote_menu_link_target);?>" href="<?php print esc_url($quote_menu_link);?>"><?php print esc_html($quote_menu_label);?></a>
</div>
