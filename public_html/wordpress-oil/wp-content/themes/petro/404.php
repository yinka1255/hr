<?php
/**
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.1.4
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php

$error_text = '';

if(($page_id =  petro_get_config('404-page'))){
        $page_404 = petro_get_wpml_post( absint($page_id) );

        if(!empty( $page_404 ) && is_object($page_404)){
            $error_text = do_shortcode($page_404->post_content);
        }
}

remove_action('wp_head','petro_sidebar_loader');

?>
<?php wp_head();?>
</head>
<body <?php body_class();?>>
<?php 

if (!empty($error_text)) {
	print $error_text;
}
else{?>
<div class="container">
	<div class="error404-content">
		<h2 class="title-404"><?php esc_html_e( '404 PAGE','petro' );?></h2>
		<h3 class="subtitle-404"><?php esc_html_e( 'Sorry! The page  you\'re looking not found','petro' );?></h3>
		<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'petro' ); ?></p>
		<a href="<?php print esc_url( home_url( '/') );?>" class="btn btn-secondary"><?php esc_html_e( 'BACK TO HOME','petro');?></a>
	</div>					
</div>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>