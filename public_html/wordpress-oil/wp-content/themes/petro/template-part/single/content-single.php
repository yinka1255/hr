<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content
 *
 * Used for  single post.
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">
		<?php 
$blog_layout = petro_get_config( 'blog-layout', array());
$layout = isset($blog_layout['active']) ? $blog_layout['active'] : array('image','title','meta','content','author');

if(isset($layout['placebo'])){
	unset($layout['placebo']);
}
elseif(isset($layout['fields'])){
	$layout = $layout['fields'];
}

if(count($layout)){
	foreach ($layout as $layout_name => $layout_label) {	
		get_template_part( 'template-part/single/post', $layout_name);
	}
}

if(get_comments_number()):
?>
<div class="content-comments clearfix">
<h3 class="heading"><?php comments_number(esc_html__('No Comments','petro'),esc_html__('1 Comment','petro'),esc_html__('% Comments','petro')); ?> :</h3>
<?php comments_template(); ?>
</div>
<?php else:?>
<div class="content-comments clearfix">
<?php comments_template(); ?>
</div>
<?php endif;?>
	</div>
</article>
