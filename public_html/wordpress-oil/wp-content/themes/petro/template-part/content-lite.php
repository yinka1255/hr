<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content
 *
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

$featured_image = petro_get_post_featured_image_tag($post->ID);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($featured_image!=''){
		print '<a href="'.get_the_permalink($post->ID).'">'.$featured_image.'</a>';
		}else{?>
		<div class="blog-image no-image clearfix"></div>
		<?php }?>
		<div class="post-content clearfix">
			<h2 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
			<?php get_template_part('template-part/post-meta','lite'); ?>
		</div>
		<div class="clearfix"></div>	
</article>