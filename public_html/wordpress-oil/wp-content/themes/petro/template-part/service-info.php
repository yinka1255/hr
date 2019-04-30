<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 * @see /single/content-single-service.php
 */

$post_id = get_the_ID();


$args=array(
	'post_type'=>'petro_service',
	'posts_per_page' => -1,
	'no_found_rows' => true,
	'post_status' => 'publish',
	'post__not_in'=> array($post_id),
	'ignore_sticky_posts' => true
);

$query = new WP_Query($args);

if ($query->have_posts()) :?>
<div class="widget widget_categories">
	<ul class="category-nav">
<?php
		

	while ( $query->have_posts() ) : 
		$query->the_post();
		ob_start();
		$detail_link = get_the_permalink();
	?>
<li><a href="<?php print esc_url($detail_link);?>"><?php print the_title();?></a></li>
<?php
	endwhile; 
wp_reset_postdata();?>
	</ul>
</div>
<?php
endif; 

if(petro_get_config('petro_service_sidebar_position',true) !== 'nosidebar'):
	dynamic_sidebar('service-widget');
endif;
?>