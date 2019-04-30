<?php
/**
 * The search result template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.1.7
 */
get_header();

if ( have_posts() ) : 
?>
<?php
if( 'content' == petro_get_config( 'search_form_position', 'content')){
?>
<div class="search-result-form top-m40">
<?php get_search_form(); ?>
</div>
<div class="clearfix"></div>
<?php 
      }
?>
<h2 class="top-m40"><?php printf( esc_html__('Search result for %s','petro'),'<span>"'.get_search_query().'"</span>');?></h2>
<div class="bottom-devider"></div>
<div id="post-lists" class="post-lists blog-col-1 clearfix">
<?php
while ( have_posts() ) :
?>
<div class="grid-column col-xs-12">
<?php

the_post();
$post_format= get_post_format();

get_template_part( 'template-part/content-search',  'post'==get_post_type()? $post_format : get_post_type() );

?>
<div class="bottom-devider"></div>
</div>
<?php
endwhile;
?>
</div>
<div class="clearfix"></div>
<?php 
$args=array("before"=>"<li>","after"=>"</li>","wrapper"=>"<div class=\"pagination %s\" dir=\"ltr\"><ul>%s</ul></div>",'navigation_type'=>'number');
petro_pagination($args);
 ?>
<?php else:?>
<div class="col-xs-12">
	<div class="search-404 bot-p80">
<?php 

$error_text=petro_get_config('search-empty-text','');

if($error_text!=''){
	print do_shortcode($error_text);
}
else{?>
		<h2 class="top-m0" ><?php esc_html_e( 'Nothing Found','petro' );?></h2>
		<h4><?php esc_html_e( 'Sorry, but nothing matched your search terms.','petro' );?></h4>		
		<p><?php esc_html_e( 'Please try again with some different keywords.', 'petro' ); ?></p>
<?php }
 
		if( 'content' == petro_get_config( 'search_form_position', 'content')){?>
		<div class="search-result-form">
<?php
			get_search_form(); ?>
		</div>
<?php		}
		?>
	</div>					
</div>	
<?php endif;?>
<?php
get_footer();
?>