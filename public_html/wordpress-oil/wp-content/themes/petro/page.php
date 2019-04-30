<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

get_header();?>
<div <?php post_class();?>>
<?php
while ( have_posts() ) :?>
	<?php the_post();
	the_content();
	petro_link_pages();
endwhile;
?>
<?php 

if(comments_open()):?>
<hr class="bottom-devider bold clearfix"></hr>	
<div class="content-comments clearfix">
<h3 class="heading"><?php comments_number(esc_html__('No Comments','petro'),esc_html__('1 Comment','petro'),esc_html__('% Comments','petro')); ?> :</h3>
<?php comments_template(); ?>
</div>
<?php endif;?>

</div>
<?php
get_footer();
?>