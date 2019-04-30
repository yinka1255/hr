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
	<div class="post-content bot-p40">
		<?php 

if(!petro_get_config('tg_custom_post_hide_featured_image',false)):		

//		hide_featured_image
if( ($image_size = petro_get_config('tg_custom_post_image_size','full')) && $image_size=='custom'){

	$custom_image_size = petro_get_config('tg_custom_post_custom_image_size');

	if(preg_match('/\d+/', $custom_image_size)){
		$image_size = 'portfolio_image';
	}

}

		print petro_get_post_featured_image_tag($post->ID, $image_size);
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
