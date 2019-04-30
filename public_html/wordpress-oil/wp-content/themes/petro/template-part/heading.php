<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */



$navigation_class = array('navigation-bar');

if(($layout_mode = petro_get_config('sticky-layout-mode')) ){
  array_push($navigation_class, $layout_mode);
}

if(petro_get_config('sticky_menu',false)){
  array_push($navigation_class, 'sticky');

  if(($stickymobile = petro_get_config('sticky-mobile')) ){
    array_push($navigation_class, 'mobile-sticky');
  }

} 


?>
<?php get_template_part( 'template-part/top-heading'); ?>
<div class="<?php print join(' ', $navigation_class);?>">
  <div class="container">
    <div class="navigation-bar-inner">
<?php


  $regular_logo_id = get_theme_mod( 'custom_logo' );

  if ( $regular_logo_id ) {
    
    printf( '<a href="%1$s" class="regular-logo custom-logo-link" rel="home">%2$s</a>',
      esc_url( home_url( '/' ) ),
      wp_get_attachment_image( $regular_logo_id, 'full', false, array(
        'class'    => '',
      ) )
    );
  }else{

    $blogname = $blogtitle = get_bloginfo('name');
    print '<p class="logo-text custom-logo-link"><a  href="'.esc_url(home_url('/')).'" title="'.esc_attr($blogtitle).'">'.$blogname.'</a></p>';

  }


  $sticky_logo_id = get_theme_mod( 'custom_logo_alt' );
  
  if ( $sticky_logo_id ) {
    
    printf( '<a href="%1$s" class="sticky-logo custom-logo-link" rel="home">%2$s</a>',
      esc_url( home_url( '/' ) ),
      wp_get_attachment_image( $sticky_logo_id, 'full', false, array(
        'class'    => '',
      ) )
    );
  }


?>
<button class="navbar-toggle toggle-main-menu" type="button" onclick="javascript:;" data-toggle="collapse" data-target=".navigation-bar-mobile">
    <span class="menu-bar">
      <span></span>
      <span></span>
      <span></span>
    </span>
  </button>
<?php
if(petro_get_config('sticky_menu',false)){
  get_template_part( 'template-part/sticky-bar'); 
}
?>
    </div>
   <div class="navigation-bar-mobile collapse"></div>
  </div>
</div>
<?php 

$hide_heading = petro_get_config('hide_title',false);


if(!$hide_heading){

  the_custom_header_markup();
} ?>
<?php 

if(!$hide_heading && !petro_get_config('hide_title_heading',false) && petro_get_config('page_title' , true)):

  $section_title="";

  if(is_date()){
      $section_title='<div class="category-label h2">'.esc_html__('Browse by Date','petro').'</div>';
      $section_title.='<div class="category-name">'.get_the_date().'</div>';

  }
  elseif(is_search()){  
      $the_title = petro_get_config('search_heading_title','');
      if($the_title!='') {
          $section_title='<div class="search-name h2">'.$the_title.'</div>';
      }
  }
  elseif(is_home()){

    $section_title =  '<h1 class="h1 page-title">'.esc_html__('Blog','petro').'</h1>';
  }
  elseif(is_archive()){

    $term = get_queried_object();
    if(is_category() || is_tag()){

      if($term->taxonomy=='category'){

         $term_name = apply_filters( 'single_cat_title', $term->name );
         $section_title='<div class="category-label h2">'.esc_html__('Browse by Category','petro').'</div>';
      }
      elseif($term->taxonomy=='post_tag'){

         $term_name = apply_filters( 'single_tag_title', $term->name );
         $section_title='<div class="category-label h2">'.esc_html__('Browse by Tag','petro').'</div>';

      }
    }
    elseif(function_exists('is_shop') && is_shop()){

          $section_title =  '<h1 class="h1 page-title">'.esc_html__('Shop','petro').'</h1>';

    }
    else{

         $term_name = apply_filters( 'single_cat_title', $term->name );

         if(!is_post_type_archive() && $term->taxonomy){

           $taxonomy_object = get_taxonomy( $term->taxonomy);

           $section_title.='<div class="category-name h2">'.$term_name.'</div>';

         }
         else{

          $post_type_object = get_post_type_object( $term_name );
          $post_type_name = $post_type_object->labels->name;

          $section_title='<div class="category-label h1">'.sprintf( esc_html__('Browse by %s','petro'), $post_type_name) .'</div>';

         }

    }

  }
  elseif(is_page() && !petro_get_config('hide_title',false)){

    $section_title =  '<h1 class="h1 page-title">'.get_the_title().'</h1>';
  }
  elseif(is_single()){

    $post_type_object = get_post_type_object( get_post_type() );
    $post_type_name = $post_type_object->labels->name;

    $section_title =  '<h1 class="h1 page-title">'.(function_exists('icl_t') ? icl_t('petro', sanitize_key($post_type_name), $post_type_name ) : $post_type_name ).'</h1>';
  }

?>
  <div class="custom-page-title align-<?php print petro_get_config('heading_align');?>">
    <div class="container">
      <?php print ($section_title!='') ? $section_title:"";


      if(!is_archive() && is_search() && 'header' == petro_get_config( 'search_form_position', 'content')){?>
<div class="search-result-form">
<?php        get_search_form(); ?>
</div>
<?php      }



      if(  apply_filters( 'petro_use_breadcrumb' ,petro_get_config('use_breadcrumb', true))):
        petro_breadcrumbs();
      endif;
      ?>
    </div>
  </div>
  <?php endif;?>