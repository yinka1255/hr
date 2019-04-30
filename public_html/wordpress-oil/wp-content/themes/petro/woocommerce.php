<?php
defined('ABSPATH') or die();
/**
 * The woocommerce file
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0
 */
get_header();?>
			<div <?php post_class();?>>
			<?php
			woocommerce_content();
			?>
			</div>
<?php get_footer('shop'); ?>