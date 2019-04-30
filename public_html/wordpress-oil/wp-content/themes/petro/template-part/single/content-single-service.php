<?php
defined('ABSPATH') or die();
/**
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">
		<?php 
if(!petro_get_config('petro_service_hide_featured_image',false)):		
	print petro_get_post_featured_image_tag($post->ID);
endif;
?>
		<h2 class="section-heading"><?php the_title();?></h2>
		<div class="content-full clearfix">	
		<?php 
		the_content();
		petro_link_pages();
		?>
		</div>
	</div>
</article>
