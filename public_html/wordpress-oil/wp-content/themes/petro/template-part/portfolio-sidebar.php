<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 * @see /single/content-single-portfolio.php
 */

$hide_empty = petro_get_config('hide_empty',0);
$hide_date = petro_get_config('hide_date',0);
$hide_category = petro_get_config('hide_category',0);
$hide_detail = petro_get_config('hide_detail',0);

if(!$hide_detail):

$post_type_object = get_post_type_object( get_post_type() );
$post_type_name = $post_type_object->labels->singular_name;

$singular_name =  function_exists('icl_t') ? icl_t('petro', sanitize_key($post_type_name), $post_type_name ) : $post_type_name ;

?>
<div class="widget project-infos">
	<div class="h6 widget-title"><?php printf( esc_html__('%s details','petro'), $singular_name);?></div>
<?php	get_template_part( 'template-part/portfolio-meta-info'); ?>
<?php
$previous_post_link = get_previous_post_link( '%link', sprintf( esc_html__('previous %s','petro'), $singular_name), false, '', 'tg_postcat' ) ;
$next_post_link = get_next_post_link( '%link', sprintf( esc_html__('next %s','petro'), $singular_name), false, '', 'tg_postcat' ) ;
?>
</div>
<?php if($previous_post_link!='' || $next_post_link!=''):?>
<div class="widget widget_categories">
	<ul class="category-nav">
		<?php if($previous_post_link!=''){ print '<li>'.$previous_post_link.'</li>'; } ?>
		<?php if($next_post_link!=''){ print '<li>'.$next_post_link.'</li>'; } ?>
	</ul>
</div>
<?php endif;
endif;
?>
<?php

if(petro_get_config('tg_custom_post_sidebar_position',true) !== 'nosidebar'):
	dynamic_sidebar('portfolio-widget');
endif;
?>