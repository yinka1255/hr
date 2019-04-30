<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content
 *
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.0.9
 */

$featured_image = petro_get_post_featured_image_tag($post->ID);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($featured_image!=''){
		print '<a href="'.get_the_permalink($post->ID).'">'.$featured_image.'</a>';
		}?>
		<h2 class="post-title section-heading"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		<div class="post-content clearfix">
			<div class="content-excerpt clearfix">
			<?php
				the_excerpt();
			?>
			</div>
		</div>
		<div class="clearfix"></div>	
</article>