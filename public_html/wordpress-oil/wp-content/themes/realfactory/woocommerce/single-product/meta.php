<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta realfactory-title-font">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><span class="realfactory-head"><?php esc_html_e( 'SKU:', 'realfactory' ); ?></span> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'realfactory' ); ?></span></span>

	<?php endif; ?>

	<?php echo gdlr_core_escape_content($product->get_categories( ', ', '<span class="posted_in"><span class="realfactory-head">' . _n( 'Category:', 'Categories:', $cat_count, 'realfactory' ) . '</span> ', '</span>' )); ?>

	<?php echo gdlr_core_escape_content($product->get_tags( ', ', '<span class="tagged_as"><span class="realfactory-head" >' . _n( 'Tag:', 'Tags:', $tag_count, 'realfactory' ) . '</span> ', '</span>' )); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>

<?php

 	// sharing option
	if( realfactory_get_option('general', 'blog-social-share', 'enable') == 'enable' ){
		if( class_exists('gdlr_core_pb_element_social_share') ){
			echo '<div class="realfactory-woocommerce-social-share" >';
			echo gdlr_core_pb_element_social_share::get_content(array(
				'social-head' => 'none',
				'text-align'=>'left',
				'facebook'=>realfactory_get_option('general', 'blog-social-facebook', 'enable'),
				'linkedin'=>realfactory_get_option('general', 'blog-social-linkedin', 'enable'),
				'google-plus'=>realfactory_get_option('general', 'blog-social-google-plus', 'enable'),
				'pinterest'=>realfactory_get_option('general', 'blog-social-pinterest', 'enable'),
				'stumbleupon'=>realfactory_get_option('general', 'blog-social-stumbleupon', 'enable'),
				'twitter'=>realfactory_get_option('general', 'blog-social-twitter', 'enable'),
				'email'=>realfactory_get_option('general', 'blog-social-email', 'enable'),
				'padding-bottom'=>'0px',
				'no-pdlr'=>true
			));
			echo '</div>';
		}
	}
?>
