<?php
defined('ABSPATH') or die();
/**
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */
?>
<div class="row">
	<div class="col-xs-12">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<p class="content-padding-top"><?php printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'petro' )), admin_url( 'post-new.php' ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
		<p class="content-padding-top"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'petro' ); ?></p>
		<?php else : ?>
		<p class="content-padding-top"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'petro' ); ?></p>
		<?php endif; ?>
	</div>
</div>