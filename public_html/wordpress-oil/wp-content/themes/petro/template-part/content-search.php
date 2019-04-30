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

$post_type_object=get_post_type_object(get_post_type());
$label = $post_type_object->labels->singular_name;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="post-content clearfix">
			<div class="bot-p20 blog-post-type h5"><?php print esc_html($label);?></div>
			<h2 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
			<div class="content-excerpt clearfix">
			<?php
				the_excerpt();
			?>
			</div>
		</div>
		<div class="clearfix"></div>	
</article>