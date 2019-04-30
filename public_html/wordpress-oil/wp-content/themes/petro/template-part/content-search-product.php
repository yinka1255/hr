<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content
 *
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.1.7
 */

$featured_image = petro_get_post_featured_image_tag($post->ID,'woocommerce_thumbnail');

$post_type_object=get_post_type_object(get_post_type());
$label = $post_type_object->labels->singular_name;

?>
<div class="row">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($featured_image!=''){?>
	<div class="col-sm-4 col-md-4 "><?php
		 woocommerce_template_loop_product_link_open();
		print $featured_image;
		woocommerce_template_loop_product_link_close();
		?></div><div class="col-sm-8 col-md-8"><?php
		}
		else{
		?>
<div class="col-sm-12 col-md-12">
<?php		}?>
		<div class="post-content">
			<div class="blog-post-type h5"><?php print esc_html($label);?></div>
			<h2 class="post-title"><a href="<?php the_permalink($post->ID);?>"><?php the_title();?></a></h2>
			<?php 
			woocommerce_template_loop_rating();
			woocommerce_template_loop_price(); ?>
			<div class="content-excerpt clearfix">
			<?php
				the_excerpt();
			?>
			</div>
			<?php 
			woocommerce_template_loop_add_to_cart();
			?>
		</div>
	</div>
	<div class="clearfix"></div>	
</article>
</div>