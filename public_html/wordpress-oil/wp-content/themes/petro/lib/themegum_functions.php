<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */
function petro_get_custom_logo( $blog_id = 0 ) {
  $html = '';
  $switched_blog = false;

  if ( is_multisite() && ! empty( $blog_id ) && (int) $blog_id !== get_current_blog_id() ) {
    switch_to_blog( $blog_id );
    $switched_blog = true;
  }

  $custom_logo_id = get_theme_mod( 'custom_logo' );

  // We have a logo. Logo is go.
  if ( $custom_logo_id ) {
    $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
      esc_url( home_url( '/' ) ),
      wp_get_attachment_image( $custom_logo_id, 'full', false, array(
        'class'    => 'custom-logo',
      ) )
    );
  }

  // If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
  elseif ( is_customize_preview() ) {
    $html = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>',
      esc_url( home_url( '/' ) )
    );
  }

  if ( $switched_blog ) {
    restore_current_blog();
  }

  /**
   * Filters the custom logo output.
   *
   * @since 4.5.0
   * @since 4.6.0 Added the `$blog_id` parameter.
   *
   * @param string $html    Custom logo HTML output.
   * @param int    $blog_id ID of the blog to get the custom logo for.
   */
  return apply_filters( 'get_custom_logo', $html, $blog_id );
}

function petro_str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function petro_get_author_blog_url($echo=false){
  $url="<a href=\"".get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )."\">".get_the_author()."</a>";
  if($echo)
    print wp_kses($url,array('a'=>array('href'=>array())));
  return $url;
}


function petro_header_image($mod){

  if(is_customize_preview()) return $mod;

  global $petro_header_image_once_one;

  if(isset($petro_header_image_once_one) && $petro_header_image_once_one) return $petro_header_image_once_one;

  $images= null;

  if(is_front_page()){
    $post_id = get_option('page_on_front');

    if(function_exists('is_shop') && is_shop()){
       $post_id=get_option( 'woocommerce_shop_page_id');
    }

    $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );

    if(($banner_image= isset($petro_page_args['banner_id']) ? absint($petro_page_args['banner_id']): '' )){
        $images = wp_get_attachment_image_src( $banner_image, 'full');
    }

  }
  elseif(is_page()){
    $post_id=get_the_id();

    $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );

    if(($banner_image= isset($petro_page_args['banner_id']) ? absint($petro_page_args['banner_id']): '' )){
        $images = wp_get_attachment_image_src( $banner_image, 'full');
    }

  }
  elseif(is_home()){
     $post_id=get_option( 'page_for_posts');

      $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );

      if(($banner_image= isset($petro_page_args['banner_id']) ? absint($petro_page_args['banner_id']): '' )){
          $images = wp_get_attachment_image_src( $banner_image, 'full');
      }

  }
  elseif(is_category() || is_tag() ){
    $term = get_queried_object();
    if(($category_image=get_metadata('term', $term->term_id, '_thumbnail_id', true))){
        $images = wp_get_attachment_image_src( $category_image, 'full');
    }
  }
  elseif(is_archive()){

    if(function_exists('is_shop') && is_shop()){
      $post_id=get_option( 'woocommerce_shop_page_id');

      $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );

      if(($banner_image= isset($petro_page_args['banner_id']) ? absint($petro_page_args['banner_id']): '' )){
          $images = wp_get_attachment_image_src( $banner_image, 'full');
      }

    } 
  }

  elseif(is_single()){
    $post_type = get_post_type();


    if(function_exists('is_product') && is_product()){

      if(($banner_image = petro_get_config( 'shop_heading_image', false))){

        if($banner_image && isset($banner_image['id']) && $banner_image['id']!=''){
             $images = wp_get_attachment_image_src( $banner_image['id'], 'full');
        }
      }
    }
    elseif($post_type=='post' && petro_get_config( 'blog_featured_image', false)){

        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $images = wp_get_attachment_image_src($thumb_id, 'full', false); 
    }
    elseif(($banner_image = petro_get_config( $post_type.'_featured_image', false))){
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $images = wp_get_attachment_image_src($thumb_id, 'full', false); 
    }elseif(($banner_image = petro_get_config( $post_type.'_heading_image', false))){
        if($banner_image && isset($banner_image['id']) && $banner_image['id']!=''){
             $images = wp_get_attachment_image_src( $banner_image['id'], 'full');
        }
    }
  }
  elseif(is_author()){
/*
 * since 1.0.3
 *
 */
        $author = get_queried_object();

        if($author && ($banner_image=get_user_meta( $author->ID, '_banner_id', true))){
            $images = wp_get_attachment_image_src( $banner_image, 'full');
        }
 }
 elseif(is_search()){

      if(($banner_image = petro_get_config( 'search_heading_image', false))){

        if($banner_image && isset($banner_image['id']) && $banner_image['id']!=''){
             $images = wp_get_attachment_image_src( $banner_image['id'], 'full');
        }
      }
 }


  if(! $images){
    $default_image  = petro_get_config( 'heading_image', false);
    if($default_image && isset($default_image['url']) && $default_image['url']!=''){
      $lapindos_header_image_once_one =  $default_image['url'];
    }
    else{
      $url = get_theme_support( 'custom-header', 'default-image' );
      $lapindos_header_image_once_one =  $url;
    }
  }

  if($images){
    $lapindos_header_image_once_one =  $images[0];
  }else{
    $lapindos_header_image_once_one =  $mod;
  }

  return $lapindos_header_image_once_one;


}


function petro_header_image_tag($html){

  if(is_customize_preview()) return $html;

  $heading_position = petro_get_config('heading_position');

  if($heading_position == 'fixed'){
    $html= '<div class="heading-fixed">'.$html.'</div>';    
  }

  return $html;

}

add_filter( 'get_header_image_tag','petro_header_image_tag');

function petro_config_loader(){

  $front_config=array();

  if(isset( $GLOBALS['front_config']) ){
    $front_config = & $GLOBALS['front_config'];
  }
  else{
    $GLOBALS['front_config']= & $front_config;
  }

  global $petro_config;

  $is_boxed=true;
  $bg_image_id=0;

  if(isset($petro_config['boxed_background_image']) && array_key_exists('id',$petro_config['boxed_background_image']) ){
      $bg_image_id=$petro_config['boxed_background_image']['id'];
  } 

  if( !isset($petro_config['enable_boxed']) || (isset($petro_config['enable_boxed']) && !$petro_config['enable_boxed']) ) 
    $is_boxed=false;

  if(is_front_page()){
    $post_id = get_option('page_on_front');

    if(function_exists('is_shop') && is_shop()){
       $post_id=get_option( 'woocommerce_shop_page_id');
    }
  }
  elseif(is_page()){
    $post_id=get_the_id();
  }
  elseif(is_category() || is_tag() ){

  }
  elseif(is_archive()){

    if(function_exists('is_shop') && is_shop()){
      $post_id=get_option( 'woocommerce_shop_page_id');
    } 
  }
  elseif(is_search()){
    add_filter('petro_use_breadcrumb','__return_false');
  }
  elseif(is_home()){
     $post_id=get_option( 'page_for_posts');
  }
  elseif(is_404()){

  }
  elseif(function_exists('is_product')  && (is_product() || is_product_category())){


  }
  else{
    $post_id=get_the_ID();
  }

  if(isset($post_id) && $post_id){

    $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );

    if(isset($petro_page_args['hide_title']) && (bool)$petro_page_args['hide_title'] ){
      petro_set_config('hide_title' , true);
      petro_set_config('heading_position' , '');
    }

    $footer_type = isset( $petro_config['footer-type']) ? $petro_config['footer-type'] : 'option';

    if($footer_type == 'page' && isset($petro_page_args['page_footer']) && ($page_footer = $petro_page_args['page_footer'] )){

      petro_set_config('footer-page' , $page_footer);
    }
    elseif($footer_type == 'option' && isset($petro_page_args['pre_page_footer']) && ($pre_page_footer = $petro_page_args['pre_page_footer'] ) ){
      petro_set_config('pre-footer-page' , $pre_page_footer);
    }

  }


}

function petro_slides_show($params=array()){

    $args = wp_parse_args($params, 
      array(
        'el_id'=>'slides',
        'class'=>'',
        'play'=>5000,
        'animation'=>'slide',
        'easing'=>'swing',
        'container_width'=>'',
        'container_height'=>'',
        'slide_animation'=>'',
        'slide_speed'=>800,
        'pagination'=>true,
    ));

    $slides = petro_get_config( 'petro-slides',array());

    if(!count($slides)) return;

    $slides_html = array();
    $slide_animation = (isset($args['slide_animation']) && $args['slide_animation'] !='') ? $args['slide_animation'] : '';

    wp_enqueue_script( 'easing' , get_template_directory_uri() . '/js/jquery.easing.1.3.js', array(), '1.3', true );
    wp_enqueue_script( 'superslides' , get_template_directory_uri() . '/js/jquery.superslides.js', array('jquery','easing'), '1.0', true );


    foreach ($slides as $slide) {

      ob_start();

      $title = isset($slide['title']) ? $slide['title'] : '';

      $description = isset($slide['description']) ? $slide['description'] : '';

      $url1 = isset($slide['url']) ? $slide['url'] : '';
      $url2 = isset($slide['url2']) ? $slide['url2'] : '';
      $btn1 = isset($slide['btn']) ? $slide['btn'] : '';
      $btn2 = isset($slide['btn2']) ? $slide['btn2'] : '';
      $image = isset($slide['attachment_id']) ? $slide['attachment_id'] : '';

      $content_align = isset($slide['align']) ? $slide['align'] : '';

      if(function_exists('icl_t')){
        $title= icl_t('petro', sanitize_key( $title ), $title );
        $description= icl_t('petro', sanitize_key( $description ), $description);
        $btn1= icl_t('petro', sanitize_key( $btn1 ), $btn1);
        $btn2= icl_t('petro', sanitize_key( $btn2 ), $btn2);

      }


      if($image){

          $slide_image = wp_get_attachment_image_src($image,'full',false); 

          if($slide_image){

             $alt_image = get_post_meta($image, '_wp_attachment_image_alt', true);

             if(function_exists('icl_t')){
                $alt_image = icl_t('petro', sanitize_key( $alt_image ), $alt_image );
             }

            print '<img src="'.esc_url($slide_image[0]).'" alt="'.esc_attr($alt_image).'" />';

          }
      }
      ?>
<div class="overlay-bg"></div>
<div class="container">
  <div class="wrap-caption <?php print sanitize_html_class($content_align);?> <?php print ($slide_animation !='') ? 'animated-'.sanitize_html_class($slide_animation) : '';?>">
    <?php 

    print ($title!='') ? '<h2 class="caption-heading">'.esc_html($title).'</h2>': '';
    print ($description!='') ? '<p class="excerpt">'.esc_html($description).'</p>': '';
    print ($btn1!='') ? '<a href="'.esc_url($url1).'" class="btn btn-primary">'.esc_html($btn1).'</a>': '';
    print ($btn2!='') ? '<a href="'.esc_url($url2).'" class="btn btn-secondary">'.esc_html($btn2).'</a>': '';
    ?>    
  </div>
</div>
<?php
      $slides_html[]= ob_get_clean();
      
    }


if(!count($slides_html)) return;

$slide_id =  !empty($args['el_id']) ? $args['el_id'] : 'slides';

$slide_width = $slide_height = 'window';

if($args['container_width'] == 'no'){
  $slide_width ='\'#'.$slide_id.'\'';
}

if($args['container_height'] == 'no'){
  $slide_height ='\'#'.$slide_id.'\'';
}



?>
<div id="<?php print esc_attr($slide_id);?>" class="<?php print esc_attr($args['class']);?> petro-slide">
    <ul class="slides-container">
      <li>
    <?php print implode('</li><li>',$slides_html);?>
      </li>
    </ul>
<?php if($args['pagination']):?>
    <nav class="slides-navigation">
      <div class="container">
        <a href="#" class="next">
          <i class="fa fa-chevron-right"></i>
        </a>
        <a href="#" class="prev">
          <i class="fa fa-chevron-left"></i>
        </a>
          </div>
      </nav>    
<?php endif;?>
  </div>
<script type="text/javascript">
  jQuery(document).ready(function($){
    'use strict';
    $('#<?php print esc_js($slide_id);?>').superslides({
      play: <?php print esc_js($args['play']);?>,
      animation_speed: <?php print esc_js($args['slide_speed']);?>,
      inherit_height_from: <?php print $slide_height;?>,
      inherit_width_from: <?php print $slide_width;?>,
      pagination: <?php print ($args['pagination']) ? 'true':'false';?>,
      hashchange: false,
      scrollable: true,
<?php print (isset($args['easing']) && $args['easing']!='' ) ? 'animation_easing:\''. sanitize_html_class($args['easing']).'\',' : '';?>
      animation: '<?php print ($args['animation'] =='fade') ? 'fade':'slide';?>'      
      
    });
  });
</script>
<?php
}


function petro_get_post_blog_id() {
  $post = get_post();

  $post_blog_ID = ! empty( $post ) ? (isset( $post->post_blog_ID ) ? $post->post_blog_ID : $post->ID ) : false;
  return $post_blog_ID;
}

function petro_set_post_blog_id($prefix="", $post_id=null) {
  $post = get_post($post_id);

  if(empty( $post ) || ! is_object($post)) return false;
  $post->post_blog_ID = (!empty($prefix) ? $prefix."_" : "" ).$post->ID;
}


function petro_is_has_image($page_id=null){
  
  if(empty($page_id)){
      $page_id=get_the_ID();
  }

  if(isset( $GLOBALS['front_config']) ){
    $front_config = & $GLOBALS['front_config'];
    if(array_key_exists('has_img_background',$front_config)){
      $return = $front_config['has_img_background'];
    }
    else{
      $return = false;
    }

  }
  else{
    $return = false;
  }

  return apply_filters('petro_is_has_image',$return,$page_id);
}


function petro_get_config($key,$default=null){

  global $petro_config;

  if(isset( $GLOBALS['front_config']) ){
    $front_config = $GLOBALS['front_config'];
    $petro_config=array_merge($front_config,$petro_config);
  }

  if(array_key_exists($key, $petro_config)){

    if(in_array($key, petro_translateable_config())){
      return apply_filters('petro_get_config_maybe_translate',$petro_config[$key],$key);
    }
    return $petro_config[$key];
  }
  return $default;
}

function petro_set_config($key, $value ){
  global $petro_config;

  if(isset( $GLOBALS['front_config']) ){
    $front_config = $GLOBALS['front_config'];
    $petro_config=array_merge($front_config,$petro_config);
  }

  $petro_config[$key] = $value;
}


function petro_get_config_from_pll($string="", $key=''){

  if($key=='') return $string;

  return pll__($string);
}


function petro_pll_register_string($config = array()){

   $translate_vars= petro_translateable_config();

   if(!count($translate_vars)) return;

   foreach ($translate_vars as $key) {

      $string = isset($config[$key]) ? $config[$key] : '';
      pll_register_string( $key, $string, 'petro', true );
   }

}

if(function_exists('pll_register_string')){

  add_action('petro_change_style','petro_pll_register_string');
  add_filter('petro_get_config_maybe_translate','petro_get_config_from_pll',1,2);
}



function petro_get_config_from_icl($string="", $key=''){

  if($key=='') return $string;
  return icl_t('petro', $key , $string);
}


if(function_exists('icl_t')){
  add_filter('petro_get_config_maybe_translate','petro_get_config_from_icl',1,2);
}


function petro_get_post_footer_page($page_id){

  $post_ID=get_the_ID();

  $originalpost = $GLOBALS['post'];

  if($post_ID==$page_id)
    return;

  $post = petro_get_wpml_post($page_id);

  if(!$post)  return;

  $GLOBALS['post']=$post;
  $post_footer_page=do_shortcode($post->post_content);
  $GLOBALS['post']=$originalpost;

  if(class_exists('a_Builder') && has_shortcode($post->post_content, 'el_row')){

      add_action( 'wp_footer', 'a_Builder::load_front_css_style');
  }


  return $post_footer_page;
}

/*wpml page translation */

function petro_get_wpml_post($post_id){

  if(function_exists('pll_get_post_translations')){

    $post_ids = pll_get_post_translations($post_id);
    $current_lang = pll_current_language();

    $post_id = isset($post_ids[$current_lang]) ? $post_ids[$current_lang] : $post_id;
  }
  elseif(defined('ICL_LANGUAGE_CODE')){

    global $wpdb;

     $postid = $wpdb->get_var(
        $wpdb->prepare("SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid=(SELECT trid FROM {$wpdb->prefix}icl_translations WHERE element_id='%d' LIMIT 1) AND element_id!='%d' AND language_code='%s'", $post_id,$post_id,ICL_LANGUAGE_CODE)
     );

    if($postid){
      $post_id = $postid;
    }
  }

  return get_post($post_id);

}



/**
 * sidebar function
 * @since Petro 1.0.0
 */
function petro_sidebar_loader(){


  global $petro_config;

  $sidebar_position = 'default';
  $sidebar='sidebar-widget';


  if(function_exists('is_shop') && is_shop()){

    $post_id=get_option( 'woocommerce_shop_page_id');
    $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );
    $sidebar_position = isset($petro_page_args['sidebar_position']) ? $petro_page_args['sidebar_position'] : 'default';

    if($sidebar_position == 'default'){
      $sidebar_position = isset($petro_config['shop_sidebar_position']) ? $petro_config['shop_sidebar_position'] : 'default';
    }

    $sidebar='shop-sidebar';

  }
  elseif(is_home()){
    $post_id=get_option( 'page_for_posts');
    $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );
    $sidebar_position = isset($petro_page_args['sidebar_position']) ? $petro_page_args['sidebar_position'] : 'default';
  }
  elseif (is_page()){
    $post_id= get_the_ID();


    if(function_exists('is_shop') &&  in_array($post_id , array( get_option( 'woocommerce_checkout_page_id' ) ,get_option( 'woocommerce_cart_page_id' ), get_option( 'woocommerce_myaccount_page_id' ),get_option('woocommerce_registration_page_id')))){
      $sidebar_position = 'nosidebar';
      $sidebar='shop-sidebar';

    }else{
      $petro_page_args = get_post_meta( $post_id, '_petro_page_args', true );
      $sidebar_position = isset($petro_page_args['sidebar_position']) ? $petro_page_args['sidebar_position'] : 'default';
    }

  }
  elseif(is_single()){
    
    $post_type = get_post_type();
    $sidebar_position = isset($petro_config[$post_type.'_sidebar_position']) ? $petro_config[$post_type.'_sidebar_position'] : 'default';

    if($post_type == 'product'){ $sidebar='shop-sidebar'; }
  }
  elseif(is_author()){
    $sidebar_position = isset($petro_config['author_sidebar_position']) ? $petro_config['author_sidebar_position'] : 'default';
  }  
  elseif(is_category() || is_tax()){

    $taxonomy = 'category';
    $term = get_queried_object();

    if($term){
      $taxonomy = $term->taxonomy;
      if($taxonomy == 'product_cat'){ $sidebar='shop-sidebar'; }
    }

    $sidebar_widget_function = 'petro_'.$taxonomy.'_sidebar_name';

    if( is_callable($sidebar_widget_function) ){
      $sidebar = $sidebar_widget_function($sidebar);
      add_filter('petro_sidebar_name', $sidebar_widget_function );
    }


    $sidebar_position = isset($petro_config[$taxonomy.'_sidebar_position']) ? $petro_config[$taxonomy.'_sidebar_position'] : 'default';
  }
  elseif(is_search()){
      $sidebar_position = isset($petro_config['search_sidebar_position']) ? $petro_config['search_sidebar_position'] : 'default';
  }

  if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){
    $sidebar_position = isset($petro_config['sidebar_position']) ? $petro_config['sidebar_position'] : "";

    if($sidebar_position == ''  || !in_array( $sidebar_position, array("nosidebar","left","right"))) $sidebar_position = "left";
  }

  $sidebar = apply_filters('petro_post_type_sidebar', $sidebar);
  $is_active_sidebar = is_active_sidebar( $sidebar );

  if($sidebar == 'portfolio-widget' && !$is_active_sidebar && isset($petro_config['hide_detail']) && (bool) $petro_config['hide_detail']){
    $sidebar_position= 'nosidebar';
  }

  if($sidebar_position!='nosidebar' && ( $sidebar == 'portfolio-widget' || $is_active_sidebar)){

    add_filter('is_themegum_load_sidebar','__return_true');
    $sidebar_grid = isset($petro_config['post_grid']) ? absint($petro_config['post_grid']) : 4; 
    $content_grid = 12 - $sidebar_grid;

    if($sidebar_position=='left'){
        add_filter( 'themegum_sidebar_css_column', 'petro_left_sidebar_'.$sidebar_grid );
        add_filter( 'themegum_content_css_column', 'petro_left_sidebar_content_'.$content_grid );
    }
    else{
        add_filter( 'themegum_sidebar_css_column', 'petro_right_sidebar_'.$sidebar_grid );
        add_filter( 'themegum_content_css_column', 'petro_right_sidebar_content_'.$content_grid );
    }

  }
  else{
    add_filter('is_themegum_load_sidebar','__return_false');
    add_filter('themegum_content_css_column',create_function('',' return "col-md-12";'));
  }

  $petro_config['sidebar_position']= $sidebar_position;
}

add_action('wp_head','petro_sidebar_loader');

function petro_service_cat_sidebar_name($name){
  
  return 'service-widget';

}

function petro_tg_postcat_sidebar_name($name){
  return 'portfolio-widget';
}


function petro_petro_service_sidebar_name($name){

  switch (get_post_type()) {
    case 'petro_service':
      $name = 'service-widget';
      break;
    case 'tg_custom_post':
      $name = 'portfolio-widget';
      break;
    default:
      break;
  }
  return $name;
}

add_filter('petro_post_type_sidebar', 'petro_petro_service_sidebar_name');

function petro_left_sidebar_2(){

  return 'col-sm-6 col-sm-pull-6 col-md-2 col-md-pull-10';
}

function petro_left_sidebar_content_10(){

  return 'col-sm-6 col-sm-push-6 col-md-10 col-md-push-2';
}

function petro_left_sidebar_3(){

  return 'col-sm-6 col-sm-pull-6 col-md-3 col-md-pull-9';
}

function petro_left_sidebar_content_9(){

  return 'col-sm-6 col-sm-push-6 col-md-9 col-md-push-3';
}

function petro_left_sidebar_4(){

  return 'col-sm-6 col-sm-pull-6 col-md-4 col-md-pull-8';
}

function petro_left_sidebar_content_8(){

  return 'col-sm-6 col-sm-push-6 col-md-8 col-md-push-4';
}

function petro_left_sidebar_5(){

  return 'col-sm-6 col-sm-pull-6 col-md-5 col-md-pull-7';
}

function petro_left_sidebar_content_7(){

  return 'col-sm-6 col-sm-push-6 col-md-7 col-md-push-5';
}

function petro_left_sidebar_6(){

  return 'col-sm-6 col-sm-pull-6';
}

function petro_left_sidebar_content_6(){

  return 'col-sm-6 col-sm-push-6';
}

/*
 *
 */

function petro_right_sidebar_2(){
  
  return 'col-sm-6 col-md-2';
}

function petro_right_sidebar_content_10(){

  return 'col-sm-6 col-md-10';
}

function petro_right_sidebar_3(){

  return 'col-sm-6 col-md-3';
}

function petro_right_sidebar_content_9(){

  return 'col-sm-6 col-md-9';
}

function petro_right_sidebar_4(){

  return 'col-sm-6 col-md-4';
}

function petro_right_sidebar_content_8(){

  return 'col-sm-6 col-md-8';
}

function petro_right_sidebar_5(){

  return 'col-sm-6 col-md-5';
}

function petro_right_sidebar_content_7(){

  return 'col-sm-6 col-md-7';
}

function petro_right_sidebar_6(){

  return 'col-sm-6 col-md-6';
}

function petro_right_sidebar_content_6(){

  return 'col-sm-6 col-md-6';
}



/* bottom widget column
 *
 */

function petro_makeBottomWidgetColumn($params){

  if('footer-widget' !=$params[0]['id']) return $params;

  $class="col-sm-4";
  $col=(int)petro_get_config('footer-widget-column',3);


  switch($col){

      case 2:
            $class='col-md-6 col-sm-12 col-xs-12';
        break;
      case 3:
            $class='col-md-4 col-sm-4 col-xs-12';
        break;
      case 4:
            $class='col-lg-3 col-md-3 col-sm-4 col-xs-12';
        break;
      case 1:
      default:
            $class='col-sm-12';
        break;
  }


  $params[0]['before_widget']='<div class="'.esc_attr($class).' col-'.esc_attr($col).'">'.$params[0]['before_widget'];
  $params[0]['after_widget']=$params[0]['after_widget'].'</div>';

  return $params;
}

add_filter( 'dynamic_sidebar_params', 'petro_makeBottomWidgetColumn' );


function petro_BottomWidget($instance, $widget_obj, $args){

    global $wp_registered_sidebars, $register_one;

  if('footer-widget' !=$args['id']) return $instance;

  if(isset($register_one)) return $instance;

    $footerwidget= $wp_registered_sidebars['footer-widget'];

    $class="col-sm-4";
    $col=(int)petro_get_config('footer-widget-column',4);


    switch($col){

        case 2:
              $class='col-md-6 col-sm-12 col-xs-12';
          break;
        case 3:
              $class='col-md-4 col-sm-4 col-xs-12';
          break;
        case 4:
              $class='col-lg-3 col-md-3 col-sm-4 col-xs-12';
          break;
        case 1:
        default:
              $class='col-sm-12';
          break;
    }


    $footerwidget['before_widget'] ='<div class="col '.esc_attr($class).' col-'.esc_attr($col).'">'.$footerwidget['before_widget'];
    $footerwidget['after_widget'] = $footerwidget['after_widget'].'</div>';

    $wp_registered_sidebars['footer-widget'] = $footerwidget;

    $register_one = true;


    return $instance;
}


add_filter( 'widget_display_callback', 'petro_BottomWidget',1,3);
/**
 * main menu walker
 * @since Petro 1.0.0.0
 */

class mainmenu_page_walker extends Walker_Page{

  /**
   * Outputs the beginning of the current element in the tree.
   *
   * @see Walker::start_el()
   * @since 2.1.0
   * @access public
   *
   * @param string  $output       Used to append additional content. Passed by reference.
   * @param WP_Post $page         Page data object.
   * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
   * @param array   $args         Optional. Array of arguments. Default empty array.
   * @param int     $current_page Optional. Page ID. Default 0.
   */
  public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
    if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
      $t = "\t";
      $n = "\n";
    } else {
      $t = '';
      $n = '';
    }
    if ( $depth ) {
      $indent = str_repeat( $t, $depth );
    } else {
      $indent = '';
    }

    $css_class = array( 'page_item', 'page-item-' . $page->ID );

    /**
    * Add caret at dropdown menu
    * @package Petro
    * @since   1.0.0
    */
    $caret  = '';

    if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
      $css_class[] = 'page_item_has_children';
      $caret = '<span class="caret"></span>';
    }

    if ( ! empty( $current_page ) ) {
      $_current_page = get_post( $current_page );
      if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
        $css_class[] = 'current_page_ancestor';
      }
      if ( $page->ID == $current_page ) {
        $css_class[] = 'current_page_item';
      } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
        $css_class[] = 'current_page_parent';
      }
    } elseif ( $page->ID == get_option('page_for_posts') ) {
      $css_class[] = 'current_page_parent';
    }

    /**
     * Filters the list of CSS classes to include with each page item in the list.
     *
     * @since 2.8.0
     *
     * @see wp_list_pages()
     *
     * @param array   $css_class    An array of CSS classes to be applied
     *                              to each list item.
     * @param WP_Post $page         Page data object.
     * @param int     $depth        Depth of page, used for padding.
     * @param array   $args         An array of arguments.
     * @param int     $current_page ID of the current page.
     */
    $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

    if ( '' === $page->post_title ) {
      /* translators: %d: ID of a post */
      $page->post_title = sprintf( __( '#%d (no title)','petro' ), $page->ID );
    }

    $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
    $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

    $title = apply_filters( 'page_menu_item_title', $page->post_title, $page, $args, $depth );

    $output .= $indent . sprintf(
      '<li class="%s"><a href="%s">%s%s%s%s</a>',
      $css_classes,
      get_permalink( $page->ID ),
      $args['link_before'],
      $title,
      $caret,
      $args['link_after']
    );

    if ( ! empty( $args['show_date'] ) ) {
      if ( 'modified' == $args['show_date'] ) {
        $time = $page->post_modified;
      } else {
        $time = $page->post_date;
      }

      $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
      $output .= " " . mysql2date( $date_format, $time );
    }
  }

  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<div class=\"sub-menu-container\"><ul class='sub-menu'>\n";
  }

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul></div>\n";
  }

}

/* main menu walker */
/* make menu dropdown like bootstrap */

class mainmenu_walker extends Walker_Nav_Menu{

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;


    /**
     * Filters the arguments for a single nav menu item.
     *
     * @since 4.4.0
     *
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param WP_Post  $item  Menu item data object.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

    /**
     * Filters the CSS class(es) applied to a menu item's list item element.
     *
     * @since 3.0.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
     * @param WP_Post  $item    The current menu item.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    /**
     * Filters the ID applied to a menu item's list item element.
     *
     * @since 3.0.1
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
     * @param WP_Post  $item    The current menu item.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    /**
     * Filters the HTML attributes applied to a menu item's anchor element.
     *
     * @since 3.6.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     *
     *     @type string $title  Title attribute.
     *     @type string $target Target attribute.
     *     @type string $rel    The rel attribute.
     *     @type string $href   The href attribute.
     * }
     * @param WP_Post  $item  The current menu item.
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }


    $title = apply_filters( 'nav_menu_item_title', $item->title, $item, $args, $depth );

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . $title . $args->link_after;

    /**
    * Add caret at dropdown menu
    * @package Petro
    * @since   1.0.0
    */

    if(in_array('menu-item-has-children', $classes)){
          $item_output .= '<span class="caret"></span>';
    }

    $item_output .= '</a>';
    $item_output .= $args->after;

    /**
     * Filters a menu item's starting output.
     *
     * The menu item's starting output only includes `$args->before`, the opening `<a>`,
     * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
     * no filter for modifying the opening and closing `<li>` for a menu item.
     *
     * @since 3.0.0
     *
     * @param string   $item_output The menu item's starting HTML output.
     * @param WP_Post  $item        Menu item data object.
     * @param int      $depth       Depth of menu item. Used for padding.
     * @param stdClass $args        An object of wp_nav_menu() arguments.
     */
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .="\t$indent<div class=\"sub-menu-container\"><ul class=\"sub-menu\">\n";
  }

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul></div>\n";
  }

}

function petro_get_gallery_ids(){
  global $gallery_ids;
  if(!is_array($gallery_ids)) $gallery_ids= array();
  return array_unique($gallery_ids);
}

function petro_get_video_content($content=""){

  $videos = array();

  $pattern = get_shortcode_regex(array('video'));

  if(preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER )){
    foreach ($matches as $match ) {
      $videos[] = '<div class="flex-video">'.do_shortcode($match[0]).'</div>';
    }
  }


  if(preg_match_all('/https?:\/\/(www.)?(youtube|vimeo)\.com\/(watch\?v=)?([a-zA-Z0-9_-]+)/im',$content,$matches, PREG_SET_ORDER )){
    foreach ($matches as $match ) {
      $videos[] = '<div class="flex-video">'.wp_oembed_get($match[0]).'</div>';
    }

  }

  return $videos;
}

function petro_get_image_from_content($content="", $id=null, $size = 'full') {

  $images = array();

  if($id){
    $images = get_transient('imges-'.$id);
    if($images) return $images;
  }

  if(preg_match_all('/<img.+src=[\'"]([^\'">]+)[\'"](|.+alt=[\'"]([^\'">]+)[\'"]).*>/i', $content, $matches,PREG_SET_ORDER)){

    $images=array();

    foreach($matches as $match){
      $images[] = array('url' => $match[1] ,'alt'=>$match[2]);      
    }
    
  }

  $pattern = get_shortcode_regex(array('gallery'));
  if(preg_match_all("/$pattern/s", $content, $matches, PREG_SET_ORDER)){

    foreach($matches as $matche){

      $attr = shortcode_parse_atts( $matche[3] );
      if(!isset($attr['ids'])) continue;

      $ids = trim($attr['ids']);
      $ims = explode(',', $ids);
      if(count($ims)){
        foreach($ims as $im){
            $thumb_image = wp_get_attachment_image_src($im, $size ,false); 

            if (isset($thumb_image[0])) {
              $image_url = $thumb_image[0];
              $alt_image = get_post_meta($im, '_wp_attachment_image_alt', true);

               if(function_exists('icl_t')){
                  $alt_image = icl_t('petro', sanitize_key( $alt_image ), $alt_image );
               }

              $images[]= array('url'=>$image_url,'alt'=>$alt_image);
            }
        }
      }
    }

  }

  if($id){
    set_transient('imges-'.$id, $images, HOUR_IN_SECONDS);
  }
  return $images;
}

function petro_excerpt_more($excerpt_more=""){

  return " ";
}

function petro_excerpt_length($length=0){

  $exceprt_length = absint(petro_get_config('excerpt_length'));
  $exceprt_length = min($exceprt_length , 1000);

  if($exceprt_length) return $exceprt_length;

  return $length;
}

add_filter('excerpt_length', 'petro_excerpt_length');
add_filter('excerpt_more','petro_excerpt_more');

function petro_get_readmore($echo=false){

  $more = '<a href="'.get_the_permalink().'" class="read-more btn btn-secondary">'.esc_html__('read more','petro').'</a>'; 

  if(!$echo) return $more;

  print wp_kses($more,array('a'=>array('href'=>array(),'class'=>array()),'span'=>array()));
}

/***
   * Output a comment in the HTML5 format.
   *
   * @access protected
   * @since 3.6.0
   *
   * @see wp_list_comments()
   *
   * @param object $comment Comment to display.
   * @param int    $depth   Depth of comment.
   * @param array  $args    An array of arguments.
  */
  
class petro_Walker_Comment extends Walker_Comment{

    protected function comment( $comment, $depth, $args ) {
    if ( 'div' == $args['style'] ) {
      $tag = 'div';
      $add_below = 'comment';
    } else {
      $tag = 'li';
      $add_below = 'div-comment';
    }

?>
    <<?php echo esc_attr($tag); ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <?php endif; ?>
    <?php if ( 0 != $args['avatar_size'] && 'pingback' != $comment->comment_type ) :?>
    <div class="author-avatar">
      <?php echo get_avatar( $comment, $args['avatar_size'] );?> 
    </div>
    <?php endif;?>
    <div class="comment-author vcard">
      <?php comment_author_link(); ?>
      <span class="comment-meta">
      <?php
        /* translators: 1: date, 2: time */
        printf( esc_html__( '%1$s at %2$s','petro' ), get_comment_date(),  get_comment_time() ); ?>
      </span>
    </div>
    <?php if ( '0' == $comment->comment_approved ) : ?>
    <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','petro' ) ?></em>
    <br />
    <?php endif; ?>

    <div class=" commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
      </a><?php edit_comment_link( esc_html__( '(Edit)' ,'petro'), '&nbsp;&nbsp;', '' );
      ?>
         
    </div>
    <div class="comment-text">
    <?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <?php
      comment_reply_link( array_merge( $args, array(
        'add_below' => $add_below,
        'depth'     => $depth,
        'max_depth' => $args['max_depth'],
        'before'    => '',
        'after'     => '',
        'reply_text'=> esc_html__('Reply','petro')
      ) ) );
  
      ?>
   
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
  }

  public function start_lvl( &$output, $depth = 0, $args = array() ) {

    $devider = get_option('thread_comments') && $depth && !($depth % 2) ? true : false;

   if($devider){
      $output.='<a href="#" class="comment-collapse">'.esc_html__( 'read more replies ...', 'petro').'</a>';
    }

    switch ( $args['style'] ) {
      case 'div':
        break;
      case 'ol':
        $output .= '<ol class="children">' . "\n";
        break;
      case 'ul':
      default:
        $output .= '<ul class="children">' . "\n";
        break;
    }


    $GLOBALS['comment_depth'] = $depth + 1;
  }


}


function petro_comment_form(){

      $commenter = wp_get_current_commenter();
      $html5=current_theme_supports( 'html5', 'comment-form' );
      $req      = get_option( 'require_name_email' );
      $aria_req = ( $req ? " aria-required='true'" : '' );
      $html_req = ( $req ? " required='required'" : '' );

      $fields   =  array(
        'author' => '<div class="row"><div class="col-lg-6 col-md-12 comment-form-author">' .
                    '<input id="author" class="inputbox form-control" name="author" type="text" placeholder="'.esc_attr__( 'Enter Name','petro' ).'*" value="" size="30"' . ($html5 ? $html_req : $aria_req) . ' /></div>',
        'email'  => '<div class="col-lg-6 col-md-12 comment-form-email">' .
                    '<input id="email" class="inputbox form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . esc_attr__('Enter Email','petro' ) . '*" value="" size="30" aria-describedby="email-notes"' . ($html5 ? $html_req : $aria_req)  . ' /></div>',
        'url'    => '<div class="col-xs-12 comment-form-url">' .
                    '<input id="url" class="inputbox form-control" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . esc_attr__('Enter Website','petro') . '*" value="" size="30" /></div></div>',
      );

    comment_form(
      array(
        'fields'=>$fields,
        'comment_field'        => '<div class="row"><div class="col-xs-12 comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" class="inputbox form-control" '. ($html5 ? $html_req : $aria_req).' placeholder="'.esc_attr__('Enter Your Comment...','petro').'*"></textarea></div></div>',
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="button %3$s" value="%4$s" />',
        'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
        'label_submit'         => esc_html__('post comment','petro'),
        'comment_notes_before' => '<p class="comment-notes"><span id="email-notes"><span class="required">*</span> ' . esc_html__( 'Your email address will not be published.', 'petro' ) . '</span></p>',
        'comment_notes_after'  => '', 
        'title_reply_before'=>'<h3 class="heading">',
        'title_reply_after'=>' :</h3>',
        'cancel_reply_link'    => esc_html__( 'Cancel' ,'petro').' <i class="fa fa-times-circle"></i>',
      )
    );
}


//comment_form_fields

function petro_comment_form_fields($comment_fields){

  $comment = $comment_fields['comment'];
  unset($comment_fields['comment']);

  return array_merge($comment_fields , array('comment'=> $comment));

}

add_filter('comment_form_fields','petro_comment_form_fields');


function petro_get_pagenum_link_from_page($pagenum = 1, $base_url=null, $escape = true ) {
  global $wp_rewrite;

  $pagenum = (int) $pagenum;

  if($base_url){
    $request = remove_query_arg( 'paged' , $base_url );
    $request = preg_replace('|^'. home_url() . '|i', '', $request);
  }
  else{
    $request = remove_query_arg( 'paged');
  }

  $home_root = parse_url(home_url('/'));
  $home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
  $home_root = preg_quote( $home_root, '|' );

  $request = preg_replace('|^'. $home_root . '|i', '', $request);
  $request = preg_replace('|^/+|', '', $request);

  if ( !$wp_rewrite->using_permalinks() || is_admin() ) {
    $base = trailingslashit( home_url() );

    if ( $pagenum > 1 ) {
      $result = add_query_arg( 'paged', $pagenum, $base . $request );
    } else {
      $result = $base . $request;
    }

  } else {

    $qs_regex = '|\?.*?$|';
    preg_match( $qs_regex, $request, $qs_match );

    if ( !empty( $qs_match[0] ) ) {
      $query_string = $qs_match[0];
      $request = preg_replace( $qs_regex, '', $request );
    } else {
      $query_string = '';
    }


    $request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
    $request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
    $request = ltrim($request, '/');


    $base = trailingslashit( home_url('/') );

    if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
      $base .= $wp_rewrite->index . '/';

    if ( $pagenum > 1 ) {
      $request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
    }


    $result = $base . $request . $query_string;
  }

  /**
   * Filters the page number link for the current request.
   *
   * @since 2.5.0
   *
   * @param string $result The page number link.
   */

  $result = apply_filters( 'get_pagenum_link', $result );

  if ( $escape )
    return esc_url( $result );
  else
    return esc_url_raw( $result );
}

function petro_pagination($args=array()) {

  $defaults=array(
    'max_num_pages' => false,
    'before' => "",
    'after' => "",
    'base_url' => "",
    'navigation_type' => petro_get_config('navigation_type','number'),
    'wrapper'=> "<div class=\"pagination %s\" dir=\"ltr\">%s</div>"
    );

  $args=wp_parse_args($args,$defaults);


  if ($args['max_num_pages'] === false) {
    global $wp_query;
    $args['max_num_pages'] = $wp_query -> max_num_pages;
  }

  $links = array();
  $type = $args['navigation_type'];

  $base = str_replace( 999999999, '%#%', esc_url( petro_get_pagenum_link_from_page( 999999999,  $args['base_url'] ) ) );

  $current = max( 1, get_query_var('paged'));
  $next = $current + 1;
  $previous = $current - 1;
  $is_rtl = is_rtl();

  if($type == 'number'){

    $links = paginate_links( array(
      'base' => $base,
      'format' => '?paged=%#%',
      'current' => $current,
      'total' => $args['max_num_pages'],
      'prev_next'   => true,
      'prev_text'   => $is_rtl ? '<span><i class="fa fa-angle-right"></i></span>' : '<span><i class="fa fa-angle-left"></i></span>',
      'next_text'   => $is_rtl ? '<span><i class="fa fa-angle-left"></i>' : '<span><i class="fa fa-angle-right"></i></span>',
      'end_size'    => 0,
      'mid_size'    => 1,
      'before_page_number' => '<span>',
      'after_page_number' => '</span>',
      'type'      => 'array',
    ) );


  }
  else{

    if($previous > 0 ){
      $previous_link = str_replace('%#%', $previous , $base);
      $links[] = '<a class="newest-post btn btn-lg'.($is_rtl ? " rtl":"").'" href="'.esc_url($previous_link).'"><span>'.( $is_rtl ? '<i class="fa fa-angle-right"></i>' : '<i class="fa fa-angle-left"></i>').esc_html__('Newest Post','petro').'</span></a>';
    }

    if( $next <= $args['max_num_pages'] ){
      $next_link = str_replace('%#%', $next , $base);
      $links[] = '<a class="older-post btn btn-lg'.($is_rtl ? " rtl":"").'" href="'.esc_url($next_link).'"><span>'.( $is_rtl ? '<i class="fa fa-angle-left"></i>' : '<i class="fa fa-angle-right"></i>').esc_html__('Older Post','petro').'</span></a>';
    }
  }

  if (count($links)): 
      $pagination_links= $args["before"].join($args["after"].$args["before"],is_rtl()? array_reverse($links) : $links).$args["after"];

      print !empty($args['wrapper']) ? sprintf( $args['wrapper'] , $type , $pagination_links) : 
      sprintf( "<div class=\"%s\">%s</div>" , $type , $pagination_links ); 
  endif;
}


function petro_post_class($classes=array(), $class="", $post_id=0){

  if(is_page()){
     $classes[]='content';

  }
  return $classes;
}

add_filter( 'post_class', 'petro_post_class');


function petro_body_class($classes=array()){

  if(petro_is_has_image()){
    $classes[]='image-bg';
  }

  $logo_position = petro_get_config('logo-position');

  if(!empty($logo_position)){
    $classes[]="logo-".$logo_position;
  }

  if(petro_get_config('slidingbar')){
    $slidingbar_position = petro_get_config('slidingbar-position','right');
    $classes[]="slide-bar-".$slidingbar_position;
  }

  $sidebar_position = petro_get_config('sidebar_position','left');
  $classes[]="sidebar-".$sidebar_position;

  return $classes;
}

add_filter( 'body_class', 'petro_body_class');


/**
 * Breadcrumb
 * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/ 
 * 
 */


function petro_breadcrumbs($args=array()){

  $args=wp_parse_args($args,array(
    'wrap' => '<ol class="breadcrumb">%s</ol>',
    'before'=>'',
    'after' => '',
    'format' => '<li%s>%s</li>',
    'delimiter'=>'',
    'current_class' => 'active',
    'home_text' => esc_html__('Home','petro'), 
    'home_link' => home_url('/')
   ));

   $breadcrumbs=petro_get_breadcrumbs($args);

    if (function_exists('is_shop') && (is_product()||is_cart()||is_checkout()||is_shop()||is_product_category())) {
      // do nothing
      // woocomerce has different breadcrumb method
    } else {
       print $args['before'];
       printf($args['wrap'],join($args['delimiter']."\n",is_rtl()?array_reverse($breadcrumbs):$breadcrumbs));
       print $args['after'];
    }
}

function petro_get_breadcrumbs($breadcrumb_args) {
  global $post;

   $breadcrumbs[]= sprintf($breadcrumb_args['format'],is_front_page()?' class="current"':'','<a href="'.esc_url($breadcrumb_args['home_link']).'" title="'.esc_attr($breadcrumb_args['home_text']).'">'.$breadcrumb_args['home_text'].'</a>');

  if (is_front_page()) {
    // do nothing
  } elseif (is_home()) { // blog page
      petro_get_breadcrumbs_from_menu(get_option('page_for_posts'),$breadcrumbs,$breadcrumb_args);
 
  } elseif (is_singular()) {

        if (is_single()) {

          $post_type=get_post_type();

          if('post'==$post_type){
            petro_get_breadcrumbs_from_menu(get_option('page_for_posts'),$breadcrumbs,$breadcrumb_args,false);
            array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
          }
          else{
            array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
          }

        } else {

            petro_get_breadcrumbs_from_menu($post->ID,$breadcrumbs,$breadcrumb_args);
            if (count($breadcrumbs) < 2 ) {
              array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
            }
        }
  } else {
      $post_id = -1;
        if(is_category()){
          $breadcrumbs[]=sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",single_cat_title(' ',false));
        }
        elseif(is_archive()){
          $breadcrumbs[]=sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",is_tag()||is_tax()?single_tag_title(' ',false):single_month_title( ' ', false ));
        }
        else{
          if (isset($post->ID)) {
            $post_id = $post->ID;
            petro_get_breadcrumbs_from_menu($post_id,$breadcrumbs,$breadcrumb_args);
          }
        }
  }

  return apply_filters('petro_breadcrumbs',$breadcrumbs,$breadcrumb_args);
}


function petro_get_breadcrumbs_from_menu($post_id,&$breadcrumbs,$args,$iscurrent=true) {
  $primary = get_nav_menu_locations();

  if (isset($primary['primary'])) {
    $navs = wp_get_nav_menu_items($primary['primary']);

    foreach ($navs as $nav) {
      if (($nav->object_id)==$post_id) {

        if ($nav->menu_item_parent!=0) {
          //start recursive by menu parent
          petro_get_breadcrumbs_from_menu_by_menuid($nav->menu_item_parent,$breadcrumbs,$args);
        }

        if ($iscurrent) {
          array_push($breadcrumbs, sprintf($args['format']," class=\"".$args['current_class']."\"",$nav->title));
        } else {
          array_push($breadcrumbs, sprintf($args['format'],"", '<a href="'.esc_url($nav->url).'" title="'.esc_attr($nav->title).'">'.$nav->title .'</a>' ));
        }

        break;
      }
    } 
  }  
}

function petro_get_breadcrumbs_from_menu_by_menuid($menu_id,&$breadcrumbs,$args) {
  $primary = get_nav_menu_locations();

  if (isset($primary['primary'])) {
    $navs = wp_get_nav_menu_items($primary['primary']);

    foreach ($navs as $nav) {
      if (($nav->ID)==$menu_id) {

        if ($nav->menu_item_parent!=0) {
          //recursive by menu parent
          petro_get_breadcrumbs_from_menu_by_menuid($nav->menu_item_parent,$breadcrumbs,$args);
        }
        array_push($breadcrumbs, sprintf($args['format'],"",'<a href="'.esc_url($nav->url).'" title="'.esc_attr($nav->title).'">'.$nav->title .'</a>'));

        break;
      }
    } 
  } 
}

/* end breadcrumbs */

function petro_flexivideo($html) {

  if (!is_admin() && !preg_match("/flex\-video/mi", $html)) {
    $html="<div class=\"flex-video widescreen\">".$html."</div>";
  }
  return $html;
}

add_filter('embed_handler_html', 'petro_flexivideo', 90); 
add_filter('oembed_dataparse', 'petro_flexivideo', 90);
add_filter('embed_oembed_html', 'petro_flexivideo', 90);


function petro_link_pages(){
  $args = array(
    'before'           => '<div class="page-pagination" dir="ltr">',
    'after'            => '</div>',
    'link_before'      => '<span class="page-numbers">',
    'link_after'       => '</span>',
    'next_or_number'   => 'number',
    'separator'        => ' ',
    'nextpagelink'     => esc_html__( 'Next page','petro' ),
    'previouspagelink' => esc_html__( 'Previous page','petro' ),
    'pagelink'         => '%',
    'echo'             => 1
  );

  return wp_link_pages($args);
}

function petro_check_update($transient){

    $purchase_number = petro_get_config( 'purchase_number','' );

    if ( empty( $transient->checked ) || empty($purchase_number) || ''== $purchase_number ) {
      return $transient;
    }

    $themename = get_template();
    $theme=wp_get_theme($themename);

    $options = array(
      'timeout' => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
      'body' => array(
        'theme'      => $themename,
        'sn' => $purchase_number,
        'version'      => $theme->get('Version'),
      ),
      'user-agent' => 'WordPress;' . home_url('/')
    );

    $url = 'http://update.themegum.com/themes/update-check/';
    $raw_response = wp_remote_post( $url, $options );

    if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ){
      return $transient;
    }

    $response = json_decode( wp_remote_retrieve_body( $raw_response ), true );

    if ( $response) {

      $transient->response[$themename] = $response;
    }
    return $transient;
}


add_filter( 'pre_set_site_transient_update_themes', 'petro_check_update');


function petro_safe_post_title($the_title){
  $title=esc_html( strip_tags( $the_title ));
  return $title;
}

add_filter( 'the_title', 'petro_safe_post_title');

function petro_get_mainmenu(){


  $toggle_menu ="<li class=\"mobile-menu-heading\"><span class=\"menu-title\">".esc_html__('menu','petro')."</span>".
  "<a class=\"toggle-mobile-menu\" href=\"#\" onclick=\"javascript:;\">
        <span class=\"close-bar\">
          <span></span>
          <span></span>
        </span>
      </a></li>";

  $toggle_menu="";

  $menuParams=array(
    'theme_location' => 'main_navigation',
    'echo' => false,
    'container_class'=>'',
    'container_id'=>'main-menu',
    'menu_class'=>'main-menu navbar-collapse collapse',
    'container'=>'',
    'before' => '',
    'after' => '',
    'fallback_cb'=>false,
    'walker'  => new mainmenu_walker(),
    'items_wrap' => '<ul id="%1$s" class="%2$s">'.$toggle_menu.'%3$s</ul>'
  );


  if($menu=wp_nav_menu($menuParams)){
      return $menu;
  }

  $menuParams['container'] = "ul";
  $menuParams['before'] = $toggle_menu;

  $menuParams['fallback_cb']="wp_page_menu";
  $menuParams['walker']= new mainmenu_page_walker();

  $menu=wp_nav_menu($menuParams);

  if(!$menu || is_wp_error($menu))
    return "";
  return $menu;
}

if(!function_exists('petro_darken')){
  function petro_darken($colourstr, $procent=0) {
    $colourstr = str_replace('#','',$colourstr);
    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = max(0,min(255,$r - ($r*$procent/100)));
    $g = max(0,min(255,$g - ($g*$procent/100)));  
    $b = max(0,min(255,$b - ($b*$procent/100)));

    return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
  }
}

if(!function_exists('petro_lighten')){

    function petro_lighten($colourstr, $procent=0){

      $colourstr = str_replace('#','',$colourstr);
      $rhex = substr($colourstr,0,2);
      $ghex = substr($colourstr,2,2);
      $bhex = substr($colourstr,4,2);

      $r = hexdec($rhex);
      $g = hexdec($ghex);
      $b = hexdec($bhex);

      $r = max(0,min(255,$r + ($r*$procent/100)));
      $g = max(0,min(255,$g + ($g*$procent/100)));  
      $b = max(0,min(255,$b + ($b*$procent/100)));

      return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
    }

}

if(!function_exists('petro_hex_to_rgb')){
  function petro_hex_to_rgb($colourstr) {
    $colourstr = str_replace('#','',$colourstr);
    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = max(0,min(255,$r));
    $g = max(0,min(255,$g));  
    $b = max(0,min(255,$b));

    return  array($r,$g,$b);
  }
}

/* body text color */
function petro_change_text_color($config=array()){

  $color= isset($config['textcolor']) ? trim($config['textcolor']) :  "";

  if(empty($color) || '#222222'== strtolower($color)) return;
  ?>
body,
.text-color,
.page-pagination .page-numbers,
.widget.widget_categories > ul > li > a,
.btn-default .badge,
a.btn-default .badge,
.wp-caption-text a,
.single-tg_custom_post .portfolio-meta-info .meta,
.single-petro_service .portfolio-meta-info .meta,
.single-tg_custom_post .portfolio-meta-info .meta a,
.single-petro_service .portfolio-meta-info .meta a,
.el-btn .btn.btn-skin-default-ghost,
.el_progress_bar .progress-bar-outer .progress-bar-value,
.el_progress_bar .progress-bar-outer .progress-bar-unit,
.gum_portfolio .portfolio-filter li,
.gum_portfolio .portfolio-filter li a
{
  color: <?php print sanitize_hex_color($color);?>;
}

.comment-respond .comment-form input::-moz-placeholder,
.comment-respond .comment-form textarea::-moz-placeholder,
.comment-respond .comment-form .button::-moz-placeholder,
.comment-respond .comment-form input:-ms-input-placeholder,
.comment-respond .comment-form textarea:-ms-input-placeholder,
.comment-respond .comment-form .button:-ms-input-placeholder,
.comment-respond .comment-form input::-webkit-input-placeholder,
.comment-respond .comment-form textarea::-webkit-input-placeholder,
.comment-respond .comment-form .button::-webkit-input-placeholder,
.social-icons .search-form .search-field::-moz-placeholder,
.social-icons .search-form .search-field:-ms-input-placeholder,
.social-icons .search-form .search-field::-webkit-input-placeholder {
  color: <?php print sanitize_hex_color($color);?>;
}


.background-text,
.close-bar span,
.pagination li .older-post:hover,
.pagination li .newest-post:hover,
.pagination li .older-post:focus,
.pagination li .newest-post:focus,
.btn-default,
a.btn-default,
.btn-default.disabled:hover,
a.btn-default.disabled:hover,
.btn-default[disabled]:hover,
a.btn-default[disabled]:hover,
fieldset[disabled] .btn-default:hover,
fieldset[disabled] a.btn-default:hover,
.btn-default.disabled:focus,
a.btn-default.disabled:focus,
.btn-default[disabled]:focus,
a.btn-default[disabled]:focus,
fieldset[disabled] .btn-default:focus,
fieldset[disabled] a.btn-default:focus,
.btn-default.disabled.focus,
a.btn-default.disabled.focus,
.btn-default[disabled].focus,
a.btn-default[disabled].focus,
fieldset[disabled] .btn-default.focus,
fieldset[disabled] a.btn-default.focus,
.el-btn .btn.btn-skin-default,
.el-btn .btn.btn-skin-default-ghost:hover,
.el-btn .btn.btn-skin-default-ghost:focus{
  background-color: <?php print sanitize_hex_color($color);?>;
}

.border-text,
.close-bar,
.btn-default,
a.btn-default,
.btn-default.disabled:hover,
a.btn-default.disabled:hover,
.btn-default[disabled]:hover,
a.btn-default[disabled]:hover,
fieldset[disabled] .btn-default:hover,
fieldset[disabled] a.btn-default:hover,
.btn-default.disabled:focus,
a.btn-default.disabled:focus,
.btn-default[disabled]:focus,
a.btn-default[disabled]:focus,
fieldset[disabled] .btn-default:focus,
fieldset[disabled] a.btn-default:focus,
.btn-default.disabled.focus,
a.btn-default.disabled.focus,
.btn-default[disabled].focus,
a.btn-default[disabled].focus,
fieldset[disabled] .btn-default.focus,
fieldset[disabled] a.btn-default.focus,
.el-btn .btn.btn-skin-default,
.el-btn .btn.btn-skin-default-ghost{
  border-color: <?php print sanitize_hex_color($color);?>;
}

blockquote{
  color: <?php print petro_lighten($color,27.5);?>;
}

<?php
}

add_action( 'petro_change_style', 'petro_change_text_color');


/* top section header */
function petro_change_topbar_color($config=array()){

  $color= isset($config['topbar-bgcolor']) ? $config['topbar-bgcolor'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#041e42' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.top-heading .top-bar,
.top-bar,
.top-bar .top-bar-module .module-menu .sub-menu-container
{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['topbar-inner-bgcolor']) ? $config['topbar-inner-bgcolor'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#000000' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='0')){?>
.top-bar .module-menu .sub-menu-container,
.top-bar .top-bar-inner{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['topbar-color']) ? $config['topbar-color'] : "";


  if(!empty($color) && strtolower($color) !=='#ffffff' ){?>
.top-bar,
.top-bar a,
.top-bar .module-menu .menu-item,
.top-bar .module-menu .menu-item > a,
.top-bar .module-menu > .menu-item > a,
.top-bar .icon-graphic > li .info-title,
.top-bar .icon-graphic > li .info-label
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $color= isset($config['topbar-border-color']) ? $config['topbar-border-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";


  if(!empty($bgcolor['color']) ){?>
.top-bar
{
  border-bottom: solid 1px <?php print $bgcolor_rgba;?>;
}
<?php
  }

  $spacing= isset($config['topbar-section-spacing']) ? $config['topbar-section-spacing'] :  array();


  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  ?>
  .top-bar .top-bar-inner{
  <?php   if($padding_top!='') {?>
        padding-top: <?php print absint($padding_top);?>px;
  <?php }
    if($padding_bottom!='') {?>
        padding-bottom: <?php print absint($padding_bottom);?>px;
  <?php }?>
  }
<?php


  $height= isset($config['topbar-height']) ? trim($config['topbar-height']) :  "";

  if(!empty($height) && 40 != absint($height) ) {
  ?>
  .top-bar .top-bar-inner{
        min-height: <?php print absint($height);?>px;
  }
<?php
  }

  $radius= isset($config['topbar-radius']) ? trim($config['topbar-radius']) :  "";

  if(!empty($radius) && 0 != absint($radius) ) {
  ?>
  .top-bar .top-bar-inner{
        border-radius: <?php print absint($radius);?>px;
  }
<?php
  }


}

add_action( 'petro_change_style', 'petro_change_topbar_color');


/* middle section color */
function petro_change_middle_section_color($config=array()){

  $color= isset($config['iconbar-background-color']) ? $config['iconbar-background-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.top-heading .middle-section-header,
.bottom-section-header,
.middle-section-header{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['iconbar-inner-background-color']) ? $config['iconbar-inner-background-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#000000' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='0')  ){?>
.middle-section-header .module-menu .sub-menu-container,
.middle-section-header .middle-section-inner{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}


  $color= isset($config['iconbar-color']) ? trim($config['iconbar-color']) :  "";

  if(!empty($color) && '#041e42' != strtolower($color)) {
  ?>

.middle-section-header,
.middle-section-header a,
.middle-section-header .logo-text,
.middle-section-header .logo-text a,
.middle-section-header .icon-graphic > li .info-title,
.middle-section-header .icon-graphic > li .info-label,
.middle-section-header .module-menu .menu-item,
.middle-section-header .module-menu .menu-item > a,
.middle-section-header .module-menu > .menu-item > a
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $height= isset($config['middle-section-height']) ? trim($config['middle-section-height']) :  "";

  if(!empty($height) && 40 != absint($height) ) {
  ?>
@media (min-width: 769px){
  .middle-section-header .middle-section-inner{
        min-height: <?php print absint($height);?>px;
  }
}
<?php
  }

  $spacing= isset($config['middle-section-spacing']) ? $config['middle-section-spacing'] :  array();

  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  ?>
  .middle-section-header .middle-section-inner{
  <?php   if($padding_top!='' && 20 != $padding_top ) {?>
        padding-top: <?php print absint($padding_top);?>px;
  <?php }
    if($padding_bottom!='' && 20 != $padding_bottom ) {?>
        padding-bottom: <?php print absint($padding_bottom);?>px;
  <?php }?>
  }
<?php

  $radius= isset($config['middle-section-radius']) ? trim($config['middle-section-radius']) :  "";

  if($radius!='' && 0 != absint($radius) ) {
  ?>
  .middle-section-header .middle-section-inner{
        border-radius: <?php print absint($radius);?>px;
  }
<?php
  }

}

add_action( 'petro_change_style', 'petro_change_middle_section_color');


/* bottom section header */

function petro_change_bottom_section_color($config=array()){


  $color= isset($config['navbar-outer-bgcolor']) ? $config['navbar-outer-bgcolor'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.bottom-section-header{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['navbar-inner-background-color']) ? $config['navbar-inner-background-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.bottom-section-header .bottom-section-inner{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color = isset($config['navbar-color']) ? trim($config['navbar-color']) :  "";

  if(!empty($color) && '#222222' != strtolower($color)) {
  ?>
.bottom-section-header,
.bottom-section-header a,
.bottom-section-header .logo-text,
.bottom-section-header .logo-text a,
.bottom-section-header .icon-graphic > li .info-title,
.bottom-section-header .icon-graphic > li .info-label,
.bottom-section-header .module-menu .menu-item,
.bottom-section-header .module-menu .menu-item > a,
.bottom-section-header .module-menu > .menu-item > a
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $navbar_border = isset($config['navbar-border']) ? $config['navbar-border'] : '';
  $navbar_styles = array();

  if(is_array($navbar_border) && count($navbar_border)){
    foreach($navbar_border as $property => $val){
      $navbar_styles[$property] = esc_attr($property).":".esc_attr($val);
    }

  }

  if(isset($config['bottom-border-color'])){

    $bgcolor = wp_parse_args( $config['bottom-border-color'],array('color'=>'','alpha'=>'','rgba'=>''));
    $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
    $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

     if(!empty($bgcolor['color']) && ('#cccccc' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){
      $navbar_styles['border-top'] = 'border-top:solid 1px '.$bgcolor_rgba;
     }

  }

  $radius= isset($config['bottom-section-radius']) ? trim($config['bottom-section-radius']) :  "";

  if(!empty($radius) && 0 != absint($radius) ) {
    $navbar_styles['border-radius'] = 'border-radius:'.absint($radius)."px";
  }


  $spacing= isset($config['bottom-section-spacing']) ? $config['bottom-section-spacing'] :  array();

  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  if(!empty($padding_top) && 0 != $padding_top ) {
    $navbar_styles['padding-top'] = 'padding-top:'.absint($padding_top)."px";
  }

  if(!empty($padding_bottom) && 0 != $padding_bottom ) {
    $navbar_styles['padding-bottom'] = 'padding-bottom:'.absint($padding_bottom)."px";
  }


  $height= isset($config['bottom-section-height']) ? trim($config['bottom-section-height']) :  "";

  if(!empty($height) && 40 != absint($height) ) {
     $navbar_styles['min-height'] = 'min-height:'.absint($height)."px";
  }

if(count($navbar_styles)){?>
.bottom-section-header .bottom-section-inner{
  <?php print join(';', $navbar_styles);?>;
}
<?php
  }

}

add_action( 'petro_change_style', 'petro_change_bottom_section_color');

/*
 * change icons color
 */

function petro_infoicons_change_color($config=array()){


  $color = isset($config['menu_icon_color']) ? trim($config['menu_icon_color']) :  "";

  if(!empty($color) && '#90dadf' != strtolower($color)) {
  ?>
.icon-graphic > li > a,
.icon-graphic > li > i,
.heading-module .icon-graphic > li > a,
.heading-module .icon-graphic > li > i  {
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $color = isset($config['menu_icon_label_color']) ? trim($config['menu_icon_label_color']) :  "";

  if(!empty($color) && '#90dadf' != strtolower($color)) {
  ?>
.icon-graphic > li .info-title,
.bottom-section-header .heading-module .icon-graphic > li .info-title,
.top-bar .heading-module .icon-graphic > li .info-title{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $color = isset($config['menu_icon_value_color']) ? trim($config['menu_icon_value_color']) :  "";

  if(!empty($color) && '#041e42' != strtolower($color)) {
  ?>
.icon-graphic > li .info-label,
.heading-module .icon-graphic > li .info-label,
.middle-section-header .heading-module .icon-graphic > li .info-label,
.bottom-section-header .heading-module .icon-graphic > li .info-label,
.top-bar .heading-module .icon-graphic > li .info-label{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }


  $color = isset($config['menu_iconflat_color']) ? trim($config['menu_iconflat_color']) :  "";

  if($color!='') {
  ?>
.iconflat-graphic > li > i, .iconflat-graphic > li > a{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }


  $color = isset($config['menu_iconflat_label_color']) ? trim($config['menu_iconflat_label_color']) :  "";

  if($color!='') {
  ?>
.iconflat-graphic > li .info-title{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

 $color = isset($config['menu_iconflat_value_color']) ? trim($config['menu_iconflat_value_color']) :  "";

  if($color!='') {
  ?>
.iconflat-graphic > li .info-label{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

}


add_action( 'petro_change_style', 'petro_infoicons_change_color');

/*
 * change button link color
 */

function petro_button_link_change_color($config=array()){


  $color = isset($config['quote_menu_color']) ? $config['quote_menu_color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));


  if(isset($color['regular']) && !empty($color['regular'])) {
  ?>
.top-heading .quote-btn{
  color: <?php print sanitize_hex_color($color['regular']);?>;
}
<?php
  }

  if(isset($color['hover']) && !empty($color['hover'])) {
  ?>
.top-heading .quote-btn:hover,
.top-heading .quote-btn:focus{
  color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

  $color = isset($config['quote_menu_bg_color']) ? $config['quote_menu_bg_color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));

  if(isset($color['regular']) && !empty($color['regular'])) {
  ?>
.top-heading .quote-btn{
  background-color: <?php print sanitize_hex_color($color['regular']);?>;
}
.top-heading .quote-btn{
  border-color: <?php print sanitize_hex_color($color['regular']);?>;
}
<?php
  }

  if(isset($color['hover']) && !empty($color['hover'])) {
  ?>
.top-heading .quote-btn:hover,
.top-heading .quote-btn:focus{
  background-color: <?php print sanitize_hex_color($color['hover']);?>;
}
.top-heading .quote-btn:hover,
.top-heading .quote-btn:focus{
  border-color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

}


add_action( 'petro_change_style', 'petro_button_link_change_color');

/*
 * change social link color
 */

function petro_social_link_change_color($config=array()){


  $color = isset($config['social_color']) ? $config['social_color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));


  if(isset($color['regular']) && !empty($color['regular'])) {
  ?>
.module-social-icon .social-item{
  color: <?php print sanitize_hex_color($color['regular']);?>;
}
<?php
  }

  if(isset($color['hover']) && !empty($color['hover'])) {
  ?>
.module-social-icon .social-item:hover,
.module-social-icon .social-item:focus{
  color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

  $color = isset($config['social_bg_color']) ? $config['social_bg_color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));

  if(isset($color['regular']) && !empty($color['regular'])) {
  ?>
.module-social-icon .social-item{
  background-color: <?php print sanitize_hex_color($color['regular']);?>;
}
<?php
  }

  if(isset($color['hover']) && !empty($color['hover'])) {
  ?>
.module-social-icon .social-item:hover,
.module-social-icon .social-item:focus{
  background-color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

}


add_action( 'petro_change_style', 'petro_social_link_change_color');


function petro_change_mainmenu_color($config=array()){


  $menucolor= isset($config['menu-color']) ? $config['menu-color'] : array();
  $color = wp_parse_args($menucolor,array('regular'=>'','hover'=>'','active'=>''));

  $menu_styles = $menu_hover_styles = array();

  if(isset($color['regular']) && !empty($color['regular']) && $color['regular'] != '#222222') {
        $menu_styles['color'] = 'color:'.sanitize_hex_color($color['regular']);
  }

  $menuborder =  isset($config['menu-border']) ? $config['menu-border']: '';

  if(is_array($menuborder) && count($menuborder)){

    foreach($menuborder as $property => $val){
        $menu_styles[$property] = esc_attr($property).":".esc_attr($val);
    }
  }


  if(count($menu_styles)) {
?>
  .main-menu > .page_item > a,
  .main-menu > .menu-item > a{
    <?php print join(';', $menu_styles); ?>;
}
<?php
  }

  if(isset($color['hover']) && !empty($color['hover']) && $color['hover'] != '#041e42') {
    $menu_hover_styles['color'] = 'color:'.sanitize_hex_color($color['hover']);
  }

  $menuhoverborder= isset($config['hover-menu-border']) ? $config['hover-menu-border'] :  '';

  $brcolor = wp_parse_args($menuhoverborder,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($brcolor['rgba']) ? $brcolor['rgba'] : "";
  $brcolor_hex = !empty($brcolor['color']) ? $brcolor['color'] : "";

   if($brcolor['color']!='' && '' != strtolower($brcolor_hex)){
    $menu_hover_styles['border-color'] = 'border-color:'.$bgcolor_rgba;
   }


if(count($menu_hover_styles)) {
?>
.main-menu .page_item:hover > a,
.main-menu .menu-item:hover > a
{
  <?php print join(';', $menu_hover_styles); ?>;
}
<?php

  }  

  if(isset($color['active']) && !empty($color['active']) && $color['active'] != '#46c2ca' ) {?>
.main-menu .page_item.current-menu-item > a,
.main-menu .menu-item.current-menu-item > a,
.main-menu .page_item.current-menu-parent > a,
.main-menu .menu-item.current-menu-parent > a,
.main-menu .page_item.current_page_item > a,
.main-menu .menu-item.current_page_item > a,
.main-menu .page_item.current_page_parent > a,
.main-menu .menu-item.current_page_parent > a{
  color: <?php print sanitize_hex_color($color['active']);?>;
}
<?php
  } 

  $menucolor= isset($config['sub-menu-color']) ? $config['sub-menu-color'] :  array();
  $color = wp_parse_args($menucolor,array('regular'=>'','hover'=>'', 'active'=>''));


  if(isset($color['regular']) && !empty($color['regular']) && $color['regular'] != '#ffffff') {?>
.main-menu .sub-menu-container .page_item > a,
.main-menu .sub-menu-container .menu-item > a{
  color: <?php print sanitize_hex_color($color['regular']);?>;
}
 <?php }

  if(isset($color['hover']) && !empty($color['hover']) ) {
  ?>
.main-menu .sub-menu .page_item:hover > a,
.main-menu .sub-menu .menu-item:hover > a,
.main-menu .sub-menu .page_item:focus > a,
.main-menu .sub-menu .menu-item:focus > a {
  color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

  if(isset($color['active']) && !empty($color['active']) ) {?>
.main-menu .sub-menu .page_item.current_page_item > a,
.main-menu .sub-menu .menu-item.current_page_item > a,
.main-menu .sub-menu .page_item.current_page_parent > a,
.main-menu .sub-menu .menu-item.current_page_parent > a {
 color: <?php print sanitize_hex_color($color['active']);?>;
}
  <?php 
  }


  $dropcolor= isset($config['dropdown-background-color']) ? $config['dropdown-background-color'] :  '';

  $bgcolor = wp_parse_args($dropcolor,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && '#041e42' != strtolower($bgcolor_hex)){?>
.main-menu .sub-menu-container,
.heading-module .search-form.nav .dropdown-menu{
  background-color: <?php print $bgcolor_rgba;?>;
}

<?php 
  }


  $color = isset($config['sticky-color']) ? trim($config['sticky-color']) :  "";

  if($color!='' && '#222222' != strtolower($color)) {
  ?>
.navigation-bar.affix,
.navigation-bar.affix a,
.navigation-bar.affix .logo-text,
.navigation-bar.affix .logo-text a,
.navigation-bar.affix .icon-graphic > li .info-title,
.navigation-bar.affix .icon-graphic > li .info-label,
.navigation-bar.affix .module-menu .menu-item,
.navigation-bar.affix .module-menu .menu-item > a,
.navigation-bar.affix .module-menu > .menu-item > a
{
  color: <?php print sanitize_hex_color($color);?>;
}

.navigation-bar.affix .toggle-main-menu .menu-bar span{
  background-color: <?php print sanitize_hex_color($color);?>;  
}

<?php
  }

  $color= isset($config['mobile-background-color']) ? $config['mobile-background-color'] :  array();

  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor['color']!='' && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.navigation-bar.affix{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }

  $color= isset($config['mobile-inside-background-color']) ? $config['mobile-inside-background-color'] :  array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor['color']!='' && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.navigation-bar.affix .navigation-bar-inner{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }


  $menucolor= isset($config['mobile-menu-color']) ? $config['mobile-menu-color'] :  array();
  $color = wp_parse_args($menucolor,array('regular'=>'','hover'=>'', 'active'=>''));
?>
@media (max-width: 768px){
<?php
  if(isset($color['regular']) && !empty($color['regular']) && $color['regular'] != '') {?>

.navigation-bar,
.navigation-bar a,
.navigation-bar .logo-text,
.navigation-bar .logo-text a,
.navigation-bar .icon-graphic > li .info-title,
.navigation-bar .icon-graphic > li .info-label,
.main-menu > .page_item > a,
.main-menu > .menu-item > a,
.main-menu .sub-menu .menu-item > a,
.main-menu .sub-menu .page_item > a,
.navigation-bar.affix,
.navigation-bar.affix a,
.navigation-bar.affix .logo-text,
.navigation-bar.affix .logo-text a,
.navigation-bar.affix .icon-graphic > li .info-title,
.navigation-bar.affix .icon-graphic > li .info-label,
.navigation-bar.affix .module-menu .menu-item,
.navigation-bar.affix .module-menu .menu-item > a,
.navigation-bar.affix .module-menu > .menu-item > a

{
  color: <?php print sanitize_hex_color($color['regular']);?>;
}
 <?php 
}

  if(isset($color['hover']) && !empty($color['hover']) && $color['hover']!='') {
  ?>
.main-menu .page_item:hover > a,
.main-menu .menu-item:hover > a,
.main-menu .sub-menu .page_item:hover > a,
.main-menu .sub-menu .menu-item:hover > a,
.main-menu .sub-menu .page_item:focus > a,
.main-menu .sub-menu .menu-item:focus > a{
  color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

  if(isset($color['active']) && !empty($color['active']) && $color['active'] !='') {?>
.main-menu .sub-menu .menu-item.current_page_parent > a,
.main-menu .sub-menu .page_item.current_page_item > a,
.main-menu .sub-menu .menu-item.current_page_item > a,
.main-menu .sub-menu .page_item.current_page_parent > a,
.main-menu .sub-menu .menu-item.current_page_parent > a  {
    color: <?php print sanitize_hex_color($color['active']);?>;
}

  <?php 
  }


  $color= isset($config['mobile-menu-bg']) ? $config['mobile-menu-bg'] :  array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor['color']!='' && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.navigation-bar .navigation-bar-mobile,
.navigation-bar-mobile .main-menu .sub-menu,
.navigation-bar-mobile .main-menu .sub-menu .page_item,
.navigation-bar-mobile .main-menu .sub-menu .menu-item
{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }?>
}
<?php
  $spacing= isset($config['stickybar-spacing']) ? $config['stickybar-spacing'] :  array();
  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  ?>
  .navigation-bar .navigation-bar-inner,
  .navigation-bar.affix .navigation-bar-inner{
  <?php   if($padding_top!='') {?>
        padding-top: <?php print absint($padding_top);?>px;
  <?php }
    if($padding_bottom!='' ) {?>
        padding-bottom: <?php print absint($padding_bottom);?>px;
  <?php }?>
  }
<?php


}

add_action( 'petro_change_style', 'petro_change_mainmenu_color');


/* brand color */
function petro_change_primary_color($config=array()){

  $color= isset($config['primary_color']) ? trim($config['primary_color']) :  "";

  if(empty($color) || '#ed1c24'== strtolower($color)) return;?>

.text-primary,
.primary-color,
.color-primary,
pre,
.widget.widget_calendar #wp-calendar td a:hover,
.widget.widget_calendar table td a:hover,
.widget.widget_calendar #wp-calendar #prev:hover a,
.widget.widget_calendar table #prev:hover a,
.widget.widget_calendar #wp-calendar #next:hover a,
.widget.widget_calendar table #next:hover a,
.widget.widget_calendar a:hover,
.widget.widget_calendar a:focus,
.widget.widget_recent_entries > ul > li > a:hover,
.widget.widget_recent_entries > ul > li > a:focus,
.footer-widget .widget.widget_nav_menu ul li.menu-item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.menu-item > a:focus,
.btn-primary .badge,
a.btn-primary .badge,
.el-btn .btn.btn-skin-primary-ghost,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:hover,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:focus,
.team_custom .phone > span,
.gum_portfolio .portfolio-filter li > a:hover,
.gum_portfolio .portfolio-filter li > a:focus,
.gum_portfolio .portfolio-filter li.active a
{
  color: <?php print sanitize_hex_color($color);?>;
}

.background-primary,
.comment-respond .comment-form .form-submit .button,
#toTop,
.post-lists.blog-col-2 article .post-content:before,
.post-lists.blog-col-3 article .post-content:before,
.post-lists.blog-col-4 article .post-content:before,
.tagcloud a:hover,
.tagcloud a:focus,
.widget.petro_optin .optin-submit:hover,
.widget.petro_optin .optin-submit:focus,
.footer-widget .widget.petro_optin .optin-submit,
.btn-primary,
a.btn-primary,
.btn-primary.disabled:hover,
a.btn-primary.disabled:hover,
.btn-primary[disabled]:hover,
a.btn-primary[disabled]:hover,
fieldset[disabled] .btn-primary:hover,
fieldset[disabled] a.btn-primary:hover,
.btn-primary.disabled:focus,
a.btn-primary.disabled:focus,
.btn-primary[disabled]:focus,
a.btn-primary[disabled]:focus,
fieldset[disabled] .btn-primary:focus,
fieldset[disabled] a.btn-primary:focus,
.btn-primary.disabled.focus,
a.btn-primary.disabled.focus,
.btn-primary[disabled].focus,
a.btn-primary[disabled].focus,
fieldset[disabled] .btn-primary.focus,
fieldset[disabled] a.btn-primary.focus,
.btn-secondary:hover,
a.btn-secondary:hover,
.btn-secondary:focus,
a.btn-secondary:focus,
.el-btn .btn.btn-skin-primary,
.el-btn .btn.btn-skin-primary-ghost:hover,
.el-btn .btn.btn-skin-primary-ghost:focus,
.el-btn .btn.btn-skin-secondary:hover,
.el-btn .btn.btn-skin-secondary:focus,
.woocommerce #respond input#submit:hover,
input.woocommerce-button:hover,
input.woocommerce-Button:hover,
button.single_add_to_cart_button:hover,
.single_add_to_cart_button:hover,
.add_to_cart_button:hover,
.button.add_to_cart_button:hover,
.button.product_type_external:hover,
button.button.alt:hover,
a.woocommerce-button:hover,
a.woocommerce-Button:hover,
.woocommerce-button:hover,
.woocommerce-Button:hover,
.button.wc-backward:hover,
.wc-backward:hover,
.woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce #respond input#submit.button:hover,
input.woocommerce-button.button:hover,
input.woocommerce-Button.button:hover,
button.single_add_to_cart_button.button:hover,
.single_add_to_cart_button.button:hover,
.add_to_cart_button.button:hover,
.button.add_to_cart_button.button:hover,
.button.product_type_external.button:hover,
button.button.alt.button:hover,
a.woocommerce-button.button:hover,
a.woocommerce-Button.button:hover,
.woocommerce-button.button:hover,
.woocommerce-Button.button:hover,
.button.wc-backward.button:hover,
.wc-backward.button:hover,
.woocommerce-button[disabled].button:hover,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:hover,
.woocommerce-button[disabled]:disabled.button:hover,
.woocommerce #respond input#submit:focus,
input.woocommerce-button:focus,
input.woocommerce-Button:focus,
button.single_add_to_cart_button:focus,
.single_add_to_cart_button:focus,
.add_to_cart_button:focus,
.button.add_to_cart_button:focus,
.button.product_type_external:focus,
button.button.alt:focus,
a.woocommerce-button:focus,
a.woocommerce-Button:focus,
.woocommerce-button:focus,
.woocommerce-Button:focus,
.button.wc-backward:focus,
.wc-backward:focus,
.woocommerce .wc-proceed-to-checkout a.checkout-button:focus,
.woocommerce #respond input#submit.button:focus,
input.woocommerce-button.button:focus,
input.woocommerce-Button.button:focus,
button.single_add_to_cart_button.button:focus,
.single_add_to_cart_button.button:focus,
.add_to_cart_button.button:focus,
.button.add_to_cart_button.button:focus,
.button.product_type_external.button:focus,
button.button.alt.button:focus,
a.woocommerce-button.button:focus,
a.woocommerce-Button.button:focus,
.woocommerce-button.button:focus,
.woocommerce-Button.button:focus,
.button.wc-backward.button:focus,
.wc-backward.button:focus,
.woocommerce-button[disabled].button:focus,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:focus,
.woocommerce-button[disabled]:disabled.button:focus,
.el_progress_bar .progress-bar-outer .progress-bar,
.price-block.layout-2 .price-footer .btn:hover,
.price-block.layout-2 .price-footer .btn:focus,
.youtube_popup .action-panel:hover,
.youtube_popup .action-panel:focus{
  background-color: <?php print sanitize_hex_color($color);?>;
}

.woocommerce.widget_shopping_cart .wc-forward:hover,
.woocommerce.widget_shopping_cart .button.wc-forward:hover,
.woocommerce-button[disabled]:hover, .woocommerce-button[disabled]:disabled:hover,
.woocommerce-button[disabled]:focus, .woocommerce-button[disabled]:disabled:focus{
  background-color: <?php print sanitize_hex_color($color);?>!important;
}

.border-primary,
.widget.widget_categories > ul > li:hover,
.widget.widget_categories > ul > li:focus,
.widget.widget_categories > ul > li.active,
.tagcloud a:hover,
.tagcloud a:focus,
.btn-primary,
a.btn-primary,
.btn-primary.disabled:hover,
a.btn-primary.disabled:hover,
.btn-primary[disabled]:hover,
a.btn-primary[disabled]:hover,
fieldset[disabled] .btn-primary:hover,
fieldset[disabled] a.btn-primary:hover,
.btn-primary.disabled:focus,
a.btn-primary.disabled:focus,
.btn-primary[disabled]:focus,
a.btn-primary[disabled]:focus,
fieldset[disabled] .btn-primary:focus,
fieldset[disabled] a.btn-primary:focus,
.btn-primary.disabled.focus,
a.btn-primary.disabled.focus,
.btn-primary[disabled].focus,
a.btn-primary[disabled].focus,
fieldset[disabled] .btn-primary.focus,
fieldset[disabled] a.btn-primary.focus,
.btn-secondary:hover,
a.btn-secondary:hover,
.btn-secondary:focus,
a.btn-secondary:focus,
.el-btn .btn.btn-skin-primary,
.el-btn .btn.btn-skin-primary-ghost,
.el-btn .btn.btn-skin-secondary:hover,
.el-btn .btn.btn-skin-secondary:focus,
.woocommerce #respond input#submit:hover,
input.woocommerce-button:hover,
input.woocommerce-Button:hover,
button.single_add_to_cart_button:hover,
.single_add_to_cart_button:hover,
.add_to_cart_button:hover,
.button.add_to_cart_button:hover,
.button.product_type_external:hover,
button.button.alt:hover,
a.woocommerce-button:hover,
a.woocommerce-Button:hover,
.woocommerce-button:hover,
.woocommerce-Button:hover,
.button.wc-backward:hover,
.wc-backward:hover,
.woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce #respond input#submit.button:hover,
input.woocommerce-button.button:hover,
input.woocommerce-Button.button:hover,
button.single_add_to_cart_button.button:hover,
.single_add_to_cart_button.button:hover,
.add_to_cart_button.button:hover,
.button.add_to_cart_button.button:hover,
.button.product_type_external.button:hover,
button.button.alt.button:hover,
a.woocommerce-button.button:hover,
a.woocommerce-Button.button:hover,
.woocommerce-button.button:hover,
.woocommerce-Button.button:hover,
.button.wc-backward.button:hover,
.wc-backward.button:hover,
.woocommerce-button[disabled].button:hover,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:hover,
.woocommerce-button[disabled]:disabled.button:hover,
.woocommerce #respond input#submit:focus,
input.woocommerce-button:focus,
input.woocommerce-Button:focus,
button.single_add_to_cart_button:focus,
.single_add_to_cart_button:focus,
.add_to_cart_button:focus,
.button.add_to_cart_button:focus,
.button.product_type_external:focus,
button.button.alt:focus,
a.woocommerce-button:focus,
a.woocommerce-Button:focus,
.woocommerce-button:focus,
.woocommerce-Button:focus,
.button.wc-backward:focus,
.wc-backward:focus,
.woocommerce .wc-proceed-to-checkout a.checkout-button:focus,
.woocommerce #respond input#submit.button:focus,
input.woocommerce-button.button:focus,
input.woocommerce-Button.button:focus,
button.single_add_to_cart_button.button:focus,
.single_add_to_cart_button.button:focus,
.add_to_cart_button.button:focus,
.button.add_to_cart_button.button:focus,
.button.product_type_external.button:focus,
button.button.alt.button:focus,
a.woocommerce-button.button:focus,
a.woocommerce-Button.button:focus,
.woocommerce-button.button:focus,
.woocommerce-Button.button:focus,
.button.wc-backward.button:focus,
.wc-backward.button:focus,
.woocommerce-button[disabled].button:focus,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:focus,
.woocommerce-button[disabled]:disabled.button:focus,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:hover,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:focus{
  border-color: <?php print sanitize_hex_color($color);?>;
}

.woocommerce.widget_shopping_cart .wc-forward:hover,
.woocommerce.widget_shopping_cart .button.wc-forward:hover,
.woocommerce-button[disabled]:hover, .woocommerce-button[disabled]:disabled:hover,
.woocommerce-button[disabled]:focus, .woocommerce-button[disabled]:disabled:focus{
  border-color: <?php print sanitize_hex_color($color);?>!important;
}

.footer-widget .widget .widget-title:before,
.footer-widget .widget .widgettitle:before,
.section-heading:before,
.single-tg_custom_post .post-content h2:before,
.single-petro_service .post-content h2:before,
.team_custom hr:after,
.section-head.layout-petro:before{
  border-top-color: <?php print sanitize_hex_color($color);?>;
}
<?php
}

add_action( 'petro_change_style', 'petro_change_primary_color');


/* secondary color */

function petro_change_secondary_color($config=array()){

  $color= isset($config['secondary_color']) ? trim($config['secondary_color']) :  "";

  if($color=='' || '#041e42'== strtolower($color)) return;

  ?>

.text-secondary,
.secondary-color,
.color-secondary,
.section-heading,
.comment-respond .comment-notes,
.content-comments .heading,
.content-comments .comment-list .comment-body .comment-author,
.content-comments .comment-list .comment-body .comment-author a,
.owl-carousel-container .owl-custom-pagination.navigation,
.el-timeline .single-timeline-item .text-holder .date,
.post-title,
.post-title a,
.author-profile .itemAuthorName a,
.pagination li .older-post .badge,
.pagination li .newest-post .badge,
.widget .widget-title,
.widget .widgettitle,
.widget .post-date,
.widget ul > li a,
.widget.widget_calendar #wp-calendar td a,
.widget.widget_calendar table td a,
.widget.widget_calendar thead th,
.widget.widget_nav_menu ul .menu-item:hover > a,
.widget.widget_pages ul .menu-item:hover > a,
.widget.widget_nav_menu .menu .menu-item:hover > a,
.widget.widget_pages .menu .menu-item:hover > a,
.widget.widget_nav_menu ul .page_item:hover > a,
.widget.widget_pages ul .page_item:hover > a,
.widget.widget_nav_menu .menu .page_item:hover > a,
.widget.widget_pages .menu .page_item:hover > a,
.footer-contact-card .card .body-content .heading,
ul.checklist li:before,
ul.checkbox li:before,
.btn-secondary .badge,
a.btn-secondary .badge,
.wp-caption-text,
.single-tg_custom_post .post-content h2,
.single-petro_service .post-content h2,
.el-btn .btn.btn-skin-secondary-ghost,
.module-iconboxes .more-link,
.module-iconboxes.style-7:hover .box-heading,
.responsive_tab .panel-title .accordion-toggle[aria-expanded=true],
.el_progress_bar .progress-bar-label,
.team_custom.petro .profile-scocial a,
.team_custom.petro:hover,
.team_custom.petro:focus,
.team_custom.petro:hover .profile-subheading,
.team_custom.petro:focus .profile-subheading,
.price-block .price-footer .btn:hover,
.price-block .price-footer .btn:focus,
.woocommerce.single-product .product_title,
.woocommerce.single-product div.product .price,
.woocommerce.single-product div.product p.price,
.woocommerce.single-product div.product span.price,
.woocommerce.single-product div.product div.images,
.woocommerce.single-product h2 {
  color: <?php print sanitize_hex_color($color);?>;
}

input::-moz-placeholder,
textarea::-moz-placeholder,
.button::-moz-placeholder,
input:-ms-input-placeholder,
textarea:-ms-input-placeholder,
.button:-ms-input-placeholder,
input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder,
.button::-webkit-input-placeholder{
  color: <?php print sanitize_hex_color($color);?>;
}

.responsive_tab .panel-title .accordion-toggle[aria-expanded=true]:hover,
.responsive_tab .nav-tabs li.active > a,
.responsive_tab .nav-tabs li.active > a:focus{
 color: <?php print sanitize_hex_color($color);?>!important; 
}
.background-secondary,
.comment-respond .comment-form .form-submit .button:hover,
.comment-respond .comment-form .form-submit .button:focus,
.post-lists article .blog-image,
.page-pagination .page-numbers.current,
.page-pagination .page-numbers:hover,
.page-pagination .page-numbers:focus,
.page-pagination > .page-numbers,
.pagination li .page-numbers.current,
.pagination li .page-numbers:hover,
.pagination li .page-numbers:focus,
.pagination li .older-post,
.pagination li .newest-post,
.pagination li .older-post.disabled:hover,
.pagination li .newest-post.disabled:hover,
.pagination li .older-post[disabled]:hover,
.pagination li .newest-post[disabled]:hover,
fieldset[disabled] .pagination li .older-post:hover,
fieldset[disabled] .pagination li .newest-post:hover,
.pagination li .older-post.disabled:focus,
.pagination li .newest-post.disabled:focus,
.pagination li .older-post[disabled]:focus,
.pagination li .newest-post[disabled]:focus,
fieldset[disabled] .pagination li .older-post:focus,
fieldset[disabled] .pagination li .newest-post:focus,
.pagination li .older-post.disabled.focus,
.pagination li .newest-post.disabled.focus,
.pagination li .older-post[disabled].focus,
.pagination li .newest-post[disabled].focus,
fieldset[disabled] .pagination li .older-post.focus,
fieldset[disabled] .pagination li .newest-post.focus,
.widget ul > li:before,
.widget.widget_calendar #wp-calendar #today,
.widget.widget_calendar table #today,
.widget.petro_widget_social .social-item i,
.widget.petro_optin .optin-submit,
.btn-default:hover,
a.btn-default:hover,
.btn-default:focus,
a.btn-default:focus,
.btn-primary:hover,
a.btn-primary:hover,
.btn-primary:focus,
a.btn-primary:focus,
.btn-secondary,
a.btn-secondary,
.btn-secondary.disabled:hover,
a.btn-secondary.disabled:hover,
.btn-secondary[disabled]:hover,
a.btn-secondary[disabled]:hover,
fieldset[disabled] .btn-secondary:hover,
fieldset[disabled] a.btn-secondary:hover,
.btn-secondary.disabled:focus,
a.btn-secondary.disabled:focus,
.btn-secondary[disabled]:focus,
a.btn-secondary[disabled]:focus,
fieldset[disabled] .btn-secondary:focus,
fieldset[disabled] a.btn-secondary:focus,
.btn-secondary.disabled.focus,
a.btn-secondary.disabled.focus,
.btn-secondary[disabled].focus,
a.btn-secondary[disabled].focus,
fieldset[disabled] .btn-secondary.focus,
fieldset[disabled] a.btn-secondary.focus,
.wp-caption-text .caption-wrapper:before,
.wp-caption-text .caption-wrapper:after,
.el-btn .btn.btn-skin-default:hover,
.el-btn .btn.btn-skin-default:focus,
.el-btn .btn.btn-skin-primary:hover,
.el-btn .btn.btn-skin-primary:focus,
.el-btn .btn.btn-skin-secondary,
.el-btn .btn.btn-skin-secondary-ghost:hover,
.el-btn .btn.btn-skin-secondary-ghost:focus,
.woocommerce #respond input#submit,
input.woocommerce-button,
input.woocommerce-Button,
button.single_add_to_cart_button,
.single_add_to_cart_button,
.add_to_cart_button,
.button.add_to_cart_button,
.button.product_type_external,
button.button.alt,
a.woocommerce-button,
a.woocommerce-Button,
.woocommerce-button,
.woocommerce-Button,
.button.wc-backward,
.wc-backward,
.woocommerce-button[disabled],
.woocommerce .wc-proceed-to-checkout a.checkout-button,
.woocommerce-button[disabled]:disabled,
.woocommerce #respond input#submit.button,
input.woocommerce-button.button,
input.woocommerce-Button.button,
button.single_add_to_cart_button.button,
.single_add_to_cart_button.button,
.add_to_cart_button.button,
.button.add_to_cart_button.button,
.button.product_type_external.button,
button.button.alt.button,
a.woocommerce-button.button,
a.woocommerce-Button.button,
.woocommerce-button.button,
.woocommerce-Button.button,
.button.wc-backward.button,
.wc-backward.button,
.woocommerce-button[disabled].button,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button,
.woocommerce-button[disabled]:disabled.button,
.woocommerce.widget_shopping_cart .wc-forward,
.woocommerce.widget_shopping_cart .button.wc-forward,
.woocommerce.single-product .woocommerce-tabs ul.tabs.wc-tabs li.active,
.owl-carousel-container .owl-controls .owl-pagination .owl-page:hover > span,
.owl-carousel-container .owl-controls .owl-pagination .owl-page:focus > span,
.owl-carousel-container .owl-controls .owl-pagination .owl-page.active > span,
.owl-carousel-container .owl-dots .owl-page:hover > span,
.owl-carousel-container .owl-dots .owl-dot:hover > span,
.owl-carousel-container .owl-dots .owl-page:focus > span,
.owl-carousel-container .owl-dots .owl-dot:focus > span,
.owl-carousel-container .owl-dots .owl-page.active > span,
.owl-carousel-container .owl-dots .owl-dot.active > span,
.module-iconboxes.style-6 .line-top:before,
.module-iconboxes.style-6 .line-bottom:before,
.module-iconboxes.style-6 .line-top:after,
.module-iconboxes.style-6 .line-bottom:after,
.module-iconboxes.style-7 .iconboxes-wrap,
.module-iconboxes.style-7 .icon-body .box,
.responsive_tab .panel.panel-default .panel-heading,
.responsive_tab .nav-tabs li > a,
.responsive_tab .nav-tabs li:hover > a,
.team_custom .profile figure .top-image:before,
.team_custom .profile-scocial a,
.team_custom.petro,
.gum_portfolio .portfolio-content .portfolio .portfolio-image,
.price-block .price-heading,
.price-block .price-footer,
.price-block.layout-2 .price-footer .btn,
.heading-module .search-form .navbar-form,
.youtube_popup .action-panel  {
  background-color: <?php print sanitize_hex_color($color);?>;
}

.border-secondary,
.btn-default:hover,
a.btn-default:hover,
.btn-default:focus,
a.btn-default:focus,
.btn-primary:hover,
a.btn-primary:hover,
.btn-primary:focus,
a.btn-primary:focus,
.btn-secondary,
a.btn-secondary,
.btn-secondary.disabled:hover,
a.btn-secondary.disabled:hover,
.btn-secondary[disabled]:hover,
a.btn-secondary[disabled]:hover,
fieldset[disabled] .btn-secondary:hover,
fieldset[disabled] a.btn-secondary:hover,
.btn-secondary.disabled:focus,
a.btn-secondary.disabled:focus,
.btn-secondary[disabled]:focus,
a.btn-secondary[disabled]:focus,
fieldset[disabled] .btn-secondary:focus,
fieldset[disabled] a.btn-secondary:focus,
.btn-secondary.disabled.focus,
a.btn-secondary.disabled.focus,
.btn-secondary[disabled].focus,
a.btn-secondary[disabled].focus,
fieldset[disabled] .btn-secondary.focus,
fieldset[disabled] a.btn-secondary.focus,
.el-btn .btn.btn-skin-default:hover,
.el-btn .btn.btn-skin-default:focus,
.el-btn .btn.btn-skin-primary:hover,
.el-btn .btn.btn-skin-primary:focus,
.el-btn .btn.btn-skin-secondary,
.el-btn .btn.btn-skin-secondary-ghost,
.woocommerce #respond input#submit,
input.woocommerce-button,
input.woocommerce-Button,
button.single_add_to_cart_button,
.single_add_to_cart_button,
.add_to_cart_button,
.button.add_to_cart_button,
.button.product_type_external,
button.button.alt,
a.woocommerce-button,
a.woocommerce-Button,
.woocommerce-button,
.woocommerce-Button,
.button.wc-backward,
.wc-backward,
.woocommerce-button[disabled],
.woocommerce .wc-proceed-to-checkout a.checkout-button,
.woocommerce-button[disabled]:disabled,
.woocommerce #respond input#submit.button,
.woocommerce.widget_shopping_cart .wc-forward,
.woocommerce.widget_shopping_cart .button.wc-forward,
input.woocommerce-button.button,
input.woocommerce-Button.button,
button.single_add_to_cart_button.button,
.single_add_to_cart_button.button,
.add_to_cart_button.button,
.button.add_to_cart_button.button,
.button.product_type_external.button,
button.button.alt.button,
a.woocommerce-button.button,
a.woocommerce-Button.button,
.woocommerce-button.button,
.woocommerce-Button.button,
.button.wc-backward.button,
.wc-backward.button,
.woocommerce-button[disabled].button,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button,
.woocommerce-button[disabled]:disabled.button,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl
{
  border-color: <?php print sanitize_hex_color($color);?>;
}
.woocommerce-info,
.woocommerce-message{
  border-top-color: <?php print sanitize_hex_color($color);?>;  
}

.team_custom.petro{
  border-bottom-color: <?php print sanitize_hex_color($color);?>;
}

<?php
}

add_action( 'petro_change_style', 'petro_change_secondary_color');

function petro_change_third_color($config=array()){

  $color= isset($config['third_color']) ? trim($config['third_color']) :  "";

  if(empty($color) || '#46c2ca'== strtolower($color)) return;

  ?>
.text-third,
.color-third,
.social-icons .search-btn:hover,
.post-meta-info dd > i,
.widget.widget_recent_entries > ul > li .post-date,
.footer-widget a:hover,
.footer-widget a:focus,
.footer-widget .widget ul > li a:hover,
.footer-widget .widget ul > li a:focus,
.footer-widget .widget.widget_recent_entries ul > li > a:hover,
.footer-widget .widget.widget_recent_entries ul > li > a:focus,
.footer-widget .widget.widget_recent_entries ul > li .post-date,
.footer-widget .widget.widget_nav_menu ul li.menu-item > a,
.footer-widget .widget.widget_calendar #wp-calendar thead th,
.footer-widget .widget.widget_calendar table thead th,
.footer-widget .widget.widget_calendar #wp-calendar td a,
.footer-widget .widget.widget_calendar table td a,
ul.bull li:before,
ul.circle li:before,
.btn-info .badge,
a.btn-info .badge,
.petro-slide .slides-navigation a:hover,
.petro-slide .slides-navigation a:focus,
.module-iconboxes .box i,
.module-iconboxes.style-7 .box-heading,
.team_custom .profile-subheading,
.team_custom.petro .profile-scocial a:hover,
.team_custom.petro .profile-scocial a:focus,
.price-block.popular .price-footer .btn:hover,
.section-head.layout-ico .ico-background,
.price-block.popular .price-footer .btn:focus  {
  color: <?php print sanitize_hex_color($color);?>;
}

.responsive_tab .panel-heading:hover,
.responsive_tab .panel-heading:hover a,
.responsive_tab .nav-tabs li:hover > a {
  color: <?php print sanitize_hex_color($color);?> !important;
}

.background-third,
.widget.petro_widget_social .social-item:hover i,
.widget.petro_widget_social .social-item:focus i,
.footer-contact-card .card:hover,
.footer-widget .widget.petro_widget_social .social-item:hover i,
.footer-widget .widget.petro_widget_social .social-item:focus i,
.footer-widget .widget.petro_optin .optin-submit:hover,
.footer-widget .widget.petro_optin .optin-submit:focus,
.footer-copyright .widget.petro_widget_social .social-item:hover i,
.footer-copyright .widget.petro_widget_social .social-item:focus i,
.btn-info,
a.btn-info,
.btn-info.disabled:hover,
a.btn-info.disabled:hover,
.btn-info[disabled]:hover,
a.btn-info[disabled]:hover,
fieldset[disabled] .btn-info:hover,
fieldset[disabled] a.btn-info:hover,
.btn-info.disabled:focus,
a.btn-info.disabled:focus,
.btn-info[disabled]:focus,
a.btn-info[disabled]:focus,
fieldset[disabled] .btn-info:focus,
fieldset[disabled] a.btn-info:focus,
.btn-info.disabled.focus,
a.btn-info.disabled.focus,
.btn-info[disabled].focus,
a.btn-info[disabled].focus,
fieldset[disabled] .btn-info.focus,
fieldset[disabled] a.btn-info.focus,
.module-iconboxes:not(.style-8):not(.style-9):not(.style-10):hover,
.module-iconboxes.style-7:hover,
.module-iconboxes.style-7:hover .box,
.module-iconboxes.style-7:hover .iconboxes-wrap,
.team_custom .profile-scocial a:hover,
.team_custom.petro-lite .profile figure figcaption .profile-heading,
.team_custom.petro:hover,
.team_custom.petro:focus,
.price-block.popular .price-heading,
.price-block.popular .price-footer{
  background-color: <?php print sanitize_hex_color($color);?>;
}

.widget.widget_categories > ul > li{
  background-color: <?php print petro_lighten($color,40);?>;
}

.border-third,
.btn-info,
a.btn-info,
.btn-info.disabled:hover,
a.btn-info.disabled:hover,
.btn-info[disabled]:hover,
a.btn-info[disabled]:hover,
fieldset[disabled] .btn-info:hover,
fieldset[disabled] a.btn-info:hover,
.btn-info.disabled:focus,
a.btn-info.disabled:focus,
.btn-info[disabled]:focus,
a.btn-info[disabled]:focus,
fieldset[disabled] .btn-info:focus,
fieldset[disabled] a.btn-info:focus,
.btn-info.disabled.focus,
a.btn-info.disabled.focus,
.btn-info[disabled].focus,
a.btn-info[disabled].focus,
fieldset[disabled] .btn-info.focus,
fieldset[disabled] a.btn-info.focus,
.petro-slide .slides-navigation a:hover,
.petro-slide .slides-navigation a:focus,
.gum_portfolio .portfolio-content .portfolio .image-overlay-container
{
  border-color: <?php print sanitize_hex_color($color);?>;
}

.team_custom.petro:hover,
.team_custom.petro:focus{
  border-bottom-color: <?php print sanitize_hex_color($color);?>;  
}

blockquote{
  border-left-color: <?php print sanitize_hex_color($color);?>;  
}
<?php
}

add_action( 'petro_change_style', 'petro_change_third_color');

/* link color */
function petro_change_link_color($config=array()){

  $color= isset($config['link-color']) ? trim($config['link-color']) :  "";

  if(empty($color) || '#666666'== strtolower($color)) return;
  ?>
.link-color,
.page-pagination .page-numbers,
.pagination li .page-numbers,
.pagination li .page-numbers:visited,
.pagination li .page-numbers:active,
.lb-details .lb-title,
a,
.btn-link{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
}

add_action( 'petro_change_style', 'petro_change_link_color');

/* link hover color */
function petro_change_link_hover_color($config=array()){

  $color= isset($config['link-hover-color']) ? trim($config['link-hover-color']) :  "";

  if(empty($color) || '#ed1c24'== strtolower($color)) return;
  ?>
a:hover,
.btn-link:hover
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
}

add_action( 'petro_change_style', 'petro_change_link_hover_color');


/* Line Color */
function petro_change_line_color($config=array()){

  $color= isset($config['line-color']) ? trim($config['line-color']) :  "";

  if(empty($color) || '#dcdde1'== strtolower($color)) return;
  ?>
.line-color{
  color: <?php print sanitize_hex_color($color);?>;  
}

.border-line,
.pagination li .older-post,
.pagination li .newest-post,
.pagination li .older-post.disabled:hover,
.pagination li .newest-post.disabled:hover,
.pagination li .older-post[disabled]:hover,
.pagination li .newest-post[disabled]:hover,
fieldset[disabled] .pagination li .older-post:hover,
fieldset[disabled] .pagination li .newest-post:hover,
.pagination li .older-post.disabled:focus,
.pagination li .newest-post.disabled:focus,
.pagination li .older-post[disabled]:focus,
.pagination li .newest-post[disabled]:focus,
fieldset[disabled] .pagination li .older-post:focus,
fieldset[disabled] .pagination li .newest-post:focus,
.pagination li .older-post.disabled.focus,
.pagination li .newest-post.disabled.focus,
.pagination li .older-post[disabled].focus,
.pagination li .newest-post[disabled].focus,
fieldset[disabled] .pagination li .older-post.focus,
fieldset[disabled] .pagination li .newest-post.focus,
.widget select,
.widget select option,
.widget .tagcloud a,
.footer-contact-card .card,
pre,
input,
textarea,
.button,
table td,
table th,
.module-iconboxes .iconboxes-wrap,
.team_custom.petro,
.price-block {
  border-color: <?php print sanitize_hex_color($color);?>;  
}

.section-heading,
.single-tg_custom_post .post-content h2,
.single-petro_service .post-content h2,
.section-head.layout-petro{
  border-top-color: <?php print sanitize_hex_color($color);?>; 
}
.top-bar-menu .sub-menu .menu-item,
.main-menu .sub-menu .page_item,
.main-menu .sub-menu .menu-item,
.post-lists.blog-col-2 article,
.post-lists.blog-col-3 article,
.post-lists.blog-col-4 article,
.widget.widget_nav_menu ul .menu-item > a,
.widget.widget_pages ul .menu-item > a,
.widget.widget_nav_menu .menu .menu-item > a,
.widget.widget_pages .menu .menu-item > a,
.widget.widget_nav_menu ul .page_item > a,
.widget.widget_pages ul .page_item > a,
.widget.widget_nav_menu .menu .page_item > a,
.widget.widget_pages .menu .page_item > a,
.wp-caption-text .caption-wrapper,
.top-bar-menu .sub-menu .menu-item{
  border-bottom-color: <?php print sanitize_hex_color($color);?>;    
}

.line-background,
.post-lists.blog-col-2 article .blog-image.no-image,
.post-lists.blog-col-3 article .blog-image.no-image,
.post-lists.blog-col-4 article .blog-image.no-image,
.owl-carousel-container .owl-controls .owl-pagination .owl-page > span,
.el-timeline .year:after,
.el-timeline .single-timeline-item:after,
.responsive_tab .panel-title .accordion-toggle[aria-expanded=true],
.responsive_tab .panel-body,
.responsive_tab .tab-pane,
.el_progress_bar .progress-bar-outer{
    background-color: <?php print sanitize_hex_color($color);?>;
}

.responsive_tab .nav-tabs li.active > a,
.responsive_tab .nav-tabs li.active > a:focus {
  background-color: <?php print sanitize_hex_color($color);?> !important;
}

<?php
}

add_action( 'petro_change_style', 'petro_change_line_color');

/*  heading color */
function petro_change_heading_color($config=array()){

  $color= isset($config['heading-background-color']) ? $config['heading-background-color'] :  array();

  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "transparent";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor_rgba) && ('#f9f9f9' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '1' )) {
  ?>
.page-heading,
.page-heading .top-heading{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }

  $color = isset($config['page-title-color']) ? trim($config['page-title-color']) :  "";

  if(!empty($color) && '#ffffff' != strtolower($color)) {
  ?>
.page-heading,
.page-heading .custom-page-title .page-title,
.page-heading .custom-page-title .category-label,
.page-heading .custom-page-title .search-name{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }
  $breadcrumb_color= isset($config['breadcrumb-color']) ? trim($config['breadcrumb-color']) :  "";
  $breadcrumb_link_color= isset($config['breadcrumb-link-color']) ? trim($config['breadcrumb-link-color']) :  "";

  if($breadcrumb_color !='' && '#ffffff'!= strtolower($breadcrumb_color)) {
?>
  .page-heading .breadcrumb > li{
    color: <?php print sanitize_hex_color($breadcrumb_color);?>;
  }
<?php
  }

  if($breadcrumb_link_color !='' && '#ffffff'!= strtolower($breadcrumb_link_color)) {
?>
  .page-heading .breadcrumb > li a{
    color: <?php print sanitize_hex_color($breadcrumb_link_color);?>;
  }
<?php
  }

}

add_action( 'petro_change_style', 'petro_change_heading_color');


/* background color */
function petro_background_change_bgcolor($config=array()){

  $bg_bgcolor= isset($config['background-color']) ? $config['background-color'] :  "";
  $bg_bgcolor = wp_parse_args($bg_bgcolor,array('color'=>'','alpha'=>'','rgba'=>''));

  $content_bgcolor_rgba = !empty($bg_bgcolor['rgba']) ? $bg_bgcolor['rgba'] : "";
  $content_bgcolor_hex = !empty($bg_bgcolor['color']) ? $bg_bgcolor['color'] : "transparent";

  if(!empty($content_bgcolor_rgba) && ('#ffffff' != strtolower($content_bgcolor_hex) || $bg_bgcolor['alpha']!='1')):
  
  ?>
  body,
  .icon-bar,
  .main-content{
    background-color: <?php print $content_bgcolor_rgba;?>;
  }
<?php
  endif;

  $bg_bgcolor= isset($config['content-background']) ? $config['content-background'] :  "";

  $bg_bgcolor = wp_parse_args($bg_bgcolor,array('color'=>'','alpha'=>'','rgba'=>''));

  $content_bgcolor_rgba = !empty($bg_bgcolor['rgba']) ? $bg_bgcolor['rgba'] : "";
  $content_bgcolor_hex = !empty($bg_bgcolor['color']) ? $bg_bgcolor['color'] : "";

  if($content_bgcolor_hex!='' && !empty($content_bgcolor_rgba) && ('#ffffff' != strtolower($content_bgcolor_hex) || $bg_bgcolor['alpha']!='1')):?>
  .main-content > .container,
  .main-content.overlap > .container,
  .footer-contact-card > .container,
  .form-control{
    background-color: <?php print $content_bgcolor_rgba;?>;
  }

  blockquote{
    background-color: <?php print petro_darken($content_bgcolor_hex,5);?>;
  }
<?php
  endif;  
}

add_action( 'petro_change_style', 'petro_background_change_bgcolor');


// widget area bottom-widget-bgcolor
function petro_widgetarea_change_color($config=array()){

  $bg_color= isset($config['bottom-widget-bgcolor']) ? $config['bottom-widget-bgcolor'] :  array();
  $color= isset($config['bottom-widget-color']) ? trim($config['bottom-widget-color']) : "";

  if(!empty($color) && '#ffffff'!= strtolower($color)):?>
.footer-widget,
.footer-widget a,
.footer-widget .widget ul > li a,
.footer-widget .widget.widget_recent_entries ul > li > a,
.footer-widget .widget.petro_widget_social .social-item i,
.footer-widget .widget.widget_calendar #wp-calendar #today,
.footer-widget .widget.widget_calendar table #today,
.footer-widget .widget.widget_calendar #wp-calendar #today a,
.footer-widget .widget.widget_calendar table #today a,
.footer-widget .widget.widget_calendar #wp-calendar caption,
.footer-widget .widget.widget_calendar table caption,
.footer-widget .widget .widget-title,
.footer-widget .widget .widgettitle,
.footer-widget .widget.widget_nav_menu ul li.menu-item > a
{
  color: <?php print sanitize_hex_color($color);?>;
}

.footer-widget input, .footer-widget textarea, .footer-widget .button,
.footer-widget .widget .form-control,
.footer-widget .widget select,
.footer-widget .widget .tagcloud a,

.footer-widget .widget.widget_nav_menu ul .menu-item > a, 
.footer-widget .widget.widget_pages ul .menu-item > a,
.footer-widget .widget.widget_nav_menu .menu .menu-item > a,
.footer-widget .widget.widget_pages .menu .menu-item > a,
.footer-widget .widget.widget_nav_menu ul .page_item > a,
.footer-widget .widget.widget_pages ul .page_item > a,
.footer-widget .widget.widget_nav_menu .menu .page_item > a,
.footer-widget .widget.widget_pages .menu .page_item > a,

.footer-widget .widget.widget_calendar #wp-calendar #today,
.footer-widget .widget.widget_calendar table #today{
  border-color: <?php print sanitize_hex_color($color);?>;
}

.footer-widget .widget ul > li::before {
  background-color: <?php print sanitize_hex_color($color);?>;  
}
<?php
  endif;

  $bgcolor = wp_parse_args($bg_color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor_rgba) && ('#041e42' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '1')):?>
  .footer-widget,
  .footer-contact-card,
  .footer-widget .widget.widget_calendar #wp-calendar #today,
  .footer-widget .widget.widget_calendar table #today{
    background-color: <?php print $bgcolor_rgba;?>;
  }

  .footer-widget hr{
    border-top-color: <?php print petro_lighten($bgcolor_hex, 10);?>;
  } 

  .footer-widget .widget.widget_categories > ul > li,
  .footer-widget .widget.widget_product_categories > ul > li,
  .footer-widget .widget.petro_widget_social .social-item i{
    background-color: <?php print petro_lighten($bgcolor_hex, 20);?>;
  }

  .footer-widget .widget-title, .footer-widget .widgettitle{
    border-top-color: <?php print petro_lighten($bgcolor_hex, 10);?>;
  }
<?php endif;
}

add_action( 'petro_change_style', 'petro_widgetarea_change_color');


// pree footer

function petro_pree_footer_change_color($config=array()){

  $bg_color= isset($config['prefooter-bgcolor']) ? $config['prefooter-bgcolor'] :  array();
  $color= isset($config['prefooter-color']) ? trim($config['prefooter-color']) : "";

  if(!empty($color) && '#ffffff'!= strtolower($color)):?>
.footer-text, .footer-text a{
  color: <?php print sanitize_hex_color($color);?>;
}

.footer-text .widget .tagcloud a{
  border-color: <?php print sanitize_hex_color($color);?>;
}
<?php
  endif;

  $bgcolor = wp_parse_args($bg_color,array('color'=>'','alpha'=>'','rgba'=>''));
  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#041e42' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '1')):?>
  .footer-text{
    background-color: <?php print $bgcolor_rgba;?>;
  }

  .footer-text .widget.trainer_widget_social .social-item i{
    background-color: <?php print petro_lighten($bgcolor_hex, 20);?>;
  }

  .footer-text,
  .footer-text hr{
    border-top-color: <?php print petro_lighten($bgcolor_hex, 10);?>;
  } 

  <?php endif;
}


add_action( 'petro_change_style', 'petro_pree_footer_change_color');

// footer copyright

function petro_footer_change_color($config=array()){

  $bg_color= isset($config['footer-bgcolor']) ? $config['footer-bgcolor'] :  array();
  $color= isset($config['footer-text-color']) ? trim($config['footer-text-color']) : "";

  if(!empty($color) && '#ffffff'!= strtolower($color)):?>
.footer-copyright, .footer-copyright a,
.footer-copyright .widget.petro_widget_social .social-item i {
  color: <?php print sanitize_hex_color($color);?>;
}

.footer-copyright .widget .tagcloud a{
  border-color: <?php print sanitize_hex_color($color);?>;
}
<?php
  endif;

  $bgcolor = wp_parse_args($bg_color,array('color'=>'','alpha'=>'','rgba'=>''));
  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#041e42' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '1')):?>
  .footer-copyright{
    background-color: <?php print $bgcolor_rgba;?>;
  }

  .footer-copyright .widget.petro_widget_social .social-item i{
    background-color: <?php print petro_lighten($bgcolor_hex, 20);?>;
  }

  .footer-copyright,
  .footer-copyright hr{
    border-top-color: <?php print petro_lighten($bgcolor_hex, 10);?>;
  } 

  <?php endif;
}


add_action( 'petro_change_style', 'petro_footer_change_color');

// slidingbar

function petro_slidingbar_style($config=array()){

  $bg_color= isset($config['slidingbar_bg']) ? $config['slidingbar_bg'] :  array();

  if($bg_color!='' && '#ffffff'!= strtolower($bg_color)):?>
.slide-sidebar-container{
  background-color: <?php print sanitize_hex_color($bg_color);?>;
}

<?php
  endif;

  $overlay = isset($config['sliding_overlay']) ? $config['sliding_overlay'] :  '';

  if($overlay!=''){?>
.slide-sidebar-overlay{background: rgba(0, 0, 0, <?php print absint($overlay)/20;?>);}
<?php
  }

  $toggle_styles = array();


  $color = isset($config['toggle-slide-color']) ? $config['toggle-slide-color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));
  $size= isset($config['sliding_size']) ? trim($config['sliding_size']) : "";

  if($color['regular']!=''){
    $toggle_styles['color'] = 'color:'.sanitize_hex_color($color['regular']);
  }

  if($size!=''){
    $toggle_styles['size'] = 'font-size:'.absint($size)."px";
  }

  if(count($toggle_styles)){?>
.heading-module .slide-bar{<?php print join(';', $toggle_styles); ?>;}
<?php }

  if($color['hover']!=''){?>
.heading-module .slide-bar:hover{ color:<?php print sanitize_hex_color($color['hover']);?>}
<?php  }

    $btn_styles = $hover_btn_styles =array();

    $color = isset($config['toggle_btn_color']) ? $config['toggle_btn_color'] : array();
    $color = wp_parse_args($color,array('regular'=>'','hover'=>''));

    if($color['regular']!=''){
      $btn_styles['color'] = 'color:'.sanitize_hex_color($color['regular']);
    }

    if($color['hover']!=''){
      $hover_btn_styles['color'] = 'color:'.sanitize_hex_color($color['hover']);
    }

    $bg_color = isset($config['toggle_btn_bg_color']) ? $config['toggle_btn_bg_color'] : array();
    $bg_color = wp_parse_args($bg_color,array('regular'=>'','hover'=>''));

    if($bg_color['regular']!=''){
      $btn_styles['border-color'] = 'border-color:'.sanitize_hex_color($bg_color['regular']);
      $btn_styles['background-color'] = 'background-color:'.sanitize_hex_color($bg_color['regular']);
    }

    if($bg_color['hover']!=''){
      $hover_btn_styles['background-color'] = 'background-color:'.sanitize_hex_color($bg_color['hover']).'!important';
      $hover_btn_styles['border-color'] = 'border-color:'.sanitize_hex_color($bg_color['hover']).'!important';
    }

    if(count($btn_styles)){?>
.slide-toggle .slide-toggle-inner{<?php print join(';', $btn_styles); ?>;}
<?php }

    if(count($hover_btn_styles)){?>
.slide-toggle .slide-toggle-inner:hover,.slide-toggle .slide-toggle-inner:focus{<?php print join(';', $hover_btn_styles); ?>;}
<?php }

}


add_action( 'petro_change_style', 'petro_slidingbar_style');
/* body font family */
function petro_body_font_family($config=array()){

  $font_family= isset($config['body-font']['font-family']) ? $config['body-font']['font-family'] :  "";
  $font_size= isset($config['body-font']['font-size']) ? intval($config['body-font']['font-size']) :  "";
  $line_height= isset($config['body-font']['line-height']) ? intval($config['body-font']['line-height']) :  "";
  $letter_spacing= isset($config['body-font']['letter-spacing']) ? trim($config['body-font']['letter-spacing']) :  "";

  $style = "";

  if(!empty($font_family) && !preg_match('/open san/i', $font_family ) ) {
    print 'body,.body-font{font-family: '.$font_family.';}';
  }
  if($font_size) {
    $style .= 'font-size: '.$font_size.'px;';
  }
  if(!empty($letter_spacing) && $letter_spacing!='px' && $letter_spacing!='pt') {
    $style .= 'letter-spacing: '.$letter_spacing.';';
  }

  if(!empty($line_height)):
    if(!$font_size) $font_size = 14;

    $line_height = $line_height / $font_size;
    $style .= 'line-height: '.round($line_height,2).';';

  endif;

  if($style !=''){
    print 'body{'.esc_js($style).'}';
  }

}

add_action( 'petro_change_style', 'petro_body_font_family');

/* heading font family */
function petro_heading_font_family($config=array()){

  $font_family= isset($config['heading-font']['font-family']) ? $config['heading-font']['font-family'] :  "";

  $font_size= isset($config['heading-font']['font-size']) ? absint($config['heading-font']['font-size']) :  '';
  $line_height= isset($config['heading-font']['line-height']) ? absint($config['heading-font']['line-height']) :  "";
  $letter_spacing= isset($config['heading-font']['letter-spacing']) ? trim($config['heading-font']['letter-spacing']) :  "";

  $style="";

  if(!empty($font_family) && !preg_match('/open san/i', $font_family ) ) {?>
h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6,
.heading-font,
.content-comments .comment-list .comment-body .comment-author,
.widget .widget-title,
.widget .widgettitle,
.single-tg_custom_post .portfolio-meta-info .meta label,
.single-petro_service .portfolio-meta-info .meta label,
.section-head.font-same-heading,
.el_counto.font-same-heading,
.section-head.font-same-heading h1,
.el_counto.font-same-heading h1,
.section-head.font-same-heading h2,
.el_counto.font-same-heading h2,
.section-head.font-same-heading h3,
.el_counto.font-same-heading h3,
.section-head.font-same-heading h4,
.el_counto.font-same-heading h4,
.section-head.font-same-heading h5,
.el_counto.font-same-heading h5,
.section-head.font-same-heading h6,
.el_counto.font-same-heading h6,
.section-head.font-same-heading .h1,
.el_counto.font-same-heading .h1,
.section-head.font-same-heading .h2,
.el_counto.font-same-heading .h2,
.section-head.font-same-heading .h3,
.el_counto.font-same-heading .h3,
.section-head.font-same-heading .h4,
.el_counto.font-same-heading .h4,
.section-head.font-same-heading .h5,
.el_counto.font-same-heading .h5,
.section-head.font-same-heading .h6,
.el_counto.font-same-heading .h6,
.section-head.font-same-heading .section-main-title,
.el_counto.font-same-heading .section-main-title {font-family: <?php print $font_family;?>}
<?php  }

  if(!empty($letter_spacing) && $letter_spacing!='px' && $letter_spacing!='pt') {
    $style.= 'letter-spacing: '.$letter_spacing.';';
  }

  if(!empty($line_height)):

    if(!$font_size) $font_size = 48;
    $line_height = $line_height / $font_size;
    $style .= 'line-height: '.round($line_height,2).';';
  endif;


  if($style !=''){
    print 'h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6 {'.esc_js($style).'}';
  }

  if($font_size && $font_size !=48){
    print 'h1,.h1{ font-size:'.$font_size.'px;}';

    $h2= $font_size * 0.6667;
    print 'h2,.h2{ font-size:'.round($h2,2).'px;}';

    $h3= $font_size * 0.5833;
    $h3 = max($h3,$font_size); 
    print 'h3,.h3{ font-size:'.round($h3,2).'px;}';

    $h4= $font_size * 0.5;
    $h4 = max($h4,$font_size); 
    print 'h4,.h4{ font-size:'.round($h4,2).'px;}';

    $h5= $font_size * 0.375;
    $h5 = max($h5,$font_size); 
    print 'h5,.h5{ font-size:'.round($h5,2).'px;}';

    $h6 = $font_size * 0.3333;
    $h6 = max($h6,$font_size); 
    print 'h6,.h6{ font-size:'.round($h6,2).'px;}';
  }

}


add_action( 'petro_change_style', 'petro_heading_font_family');

function petro_heading_module_order($config=array()){

  $ordering = isset($config['icon-bars-module']) ? (array)$config['icon-bars-module'] : array();
  if(!count($ordering)) return;

  $i = 0;
  $logo_first = false;
  $logo_latest = false;

  foreach ($ordering as $key => $value) {

    if($i==0 && $key == 'logo' ){
      $logo_first = true;
    }

    print '.'.sanitize_html_class($key).'{order: '.$i.';}';
    $i++;

   if($i == 4 && $key == 'logo' ){
      $logo_latest = true;
    }

  }

  if($logo_latest){
    print '.icon-bar #logo{padding-left: 30px;padding-right: 0;}';
  }
  elseif(!$logo_first){
    print '.icon-bar #logo{padding-left: 30px;padding-right: 30px;}';
  }


}

add_action( 'petro_change_style', 'petro_heading_module_order');

// gallery style
add_filter('use_default_gallery_style','__return_false');


/*
 * soundcloud embed
 * parameter https://developers.soundcloud.com/docs/widget
 */

function petro_soundcloud_code($atts){

  $atts = wp_parse_args($atts, array(
    'url'=>'',
    'params'=>'',
    'width'=>'',
    'height'=>'166'
    ));

  if(empty($atts['url'])) return;

  $content ='<div class="soundcloud-media"><iframe src="https://w.soundcloud.com/player/?url='.esc_url($atts['url']).'&'.$atts['params'].'&download=false&color=transparent"  height="'.$atts['height'].'"></iframe></div>';
  return $content;
}

function petro_soundcloud_tag($content){

  $pattern = get_shortcode_regex(array('soundcloud'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
    $atts = shortcode_parse_atts( $matches[3] );
    return petro_soundcloud_code($atts);
')
  , 
  $content);


  return $content;
}

function petro_make_html_row($atts, $content=''){

  extract( wp_parse_args($atts,array(
    'class'=>'',
    ))
  );

  $html = '<div class="row'.
  (!empty($class)?" ".$class:"").
  '">'.$content.'</div>';

  return $html;
}

function petro_make_html_column($atts, $content=''){

  extract( wp_parse_args($atts,array(
    'width'=>'12',
    'class'=>'',
    'mobile'=>'12',
    ))
  );

  $width= min(12, max($width, 0));
  $mobile= min(12, max($mobile, 0));

  $html = '<div class="col-lg-'.intval($width).
  (!empty($class)?" ".$class:"").
  (!empty($mobile)?" col-xs-".$mobile:"").
  '">'.$content.'</div>';

  return $html;

}

function petro_socials($content){

  $pattern = get_shortcode_regex(array('socials'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '

      $atts[\'show_label\'] = false;

      $type = \'petro_Social\';
      $args = array(
        \'before_widget\' => \'<div class="widget petro_widget_social">\',
        \'after_widget\' => \'</div>\',
        \'before_title\' => \'<div class="h6 widget-title">\',
        \'after_title\' => \'</div>\'
        );

      ob_start();
      the_widget( $type, $atts, $args );
      $content = ob_get_clean();

      return $content;


  ')
  , 
  $content);


  return $content;



}


function petro_column_tag($content){

  $pattern = get_shortcode_regex(array('column'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', 
    '
      $atts = shortcode_parse_atts( $matches[3] );
      return petro_make_html_column($atts,$matches[5]);
  ')
  , 
  $content);

  $pattern = get_shortcode_regex(array('row'));

  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '$atts = shortcode_parse_atts( $matches[3] );return petro_make_html_row($atts,$matches[5]);')
  , 
  $content);

  return $content;

}

add_filter( 'petro_render_footer_text' , 'petro_calendar_widget');
add_filter( 'petro_render_footer_text' , 'petro_socials');
add_filter( 'petro_render_footer_text' , 'petro_column_tag');
add_filter( 'petro_render_footer_text' , 'do_shortcode');
add_filter( 'petro_render_footer_text' , 'petro_tag_cloud');
add_filter( 'petro_render_footer_text' , 'wpautop');

add_filter( 'the_content' , 'petro_soundcloud_tag',1);
add_filter( 'the_content' , 'petro_column_tag',1);


function petro_check_theme_switches(){

      global $wp_post_types;

     if ( $stylesheet = get_option( 'theme_switched' ) ) {

            $mods = get_option( "theme_mods_$stylesheet" );
            $custom_logo_id = isset($mods['custom_logo']) ? $mods['custom_logo'] : "";

            set_theme_mod( 'custom_logo', $custom_logo_id );

            $header_image = isset($mods['header_image_data']) ? $mods['header_image_data'] : "";
            set_theme_mod( 'header_image_data' , $header_image);

     }

     if( !is_admin() && ($exclude_post_types = petro_get_config('search_hide_post_types')) && count($exclude_post_types) ){

        foreach ($exclude_post_types as $post_type => $exclude) {

          if( array_key_exists($post_type, $wp_post_types) && (bool)$exclude ){
            $wp_post_types[$post_type]->exclude_from_search = true;
          }
        }
     }

}


// get logo from previous theme
add_action( 'init','petro_check_theme_switches');

// register image size
add_action( 'init','petro_add_image_size');

function petro_get_post_featured_image_tag($post_id=null, $size='full'){

  if(! $post_id) $post_id = get_the_ID();

  $thumb_id = get_post_thumbnail_id($post_id);
  $image="";

  $thumb_image = wp_get_attachment_image_src($thumb_id, $size, false); 

  if(isset($thumb_image[0])) {
    $image_url = $thumb_image[0];
    $alt_image = get_post_meta(absint($thumb_id), '_wp_attachment_image_alt', true);

     if(function_exists('icl_t')){
        $alt_image = icl_t('petro', sanitize_key( $alt_image ), $alt_image );
     }


    $image='<div class="blog-image clearfix"><img class="img-responsive" src="'.esc_url($image_url).'" alt="'.esc_attr($alt_image).'" /></div>';
  }

  return $image;

}

function petro_glyphicon_list(){
  $icons = array();

  return apply_filters('themegum_glyphicon_list',$icons);
}


function petro_get_sociallinks($args=array()){

    $social_fb = petro_get_config('social_fb');
    $social_twitter = petro_get_config('social_twitter');
    $social_gplus = petro_get_config('social_gplus');
    $social_linkedin = petro_get_config('social_linkedin');
    $social_pinterest = petro_get_config('social_pinterest');
    $social_instagram = petro_get_config('social_instagram');

    $default_args= array('array'=>false,'show_label'=>true,'target'=>'');

    $args = wp_parse_args($args, $default_args);

    $rows=array();

  if(!empty($social_fb)){
    $rows['facebook'] = array( 
      'label' => esc_html__( 'facebook','petro'),
      'link' => $social_fb,
      'icon' => 'fa-facebook',
      );
  }

 if(!empty($social_gplus)){
    $rows['google'] = array( 
      'label' => esc_html__( 'google +','petro'),
      'link' => $social_gplus,
      'icon' => 'fa-google',
      );
  }

 if(!empty($social_twitter)){
    $rows['twitter'] = array( 
      'label' => esc_html__( 'twitter','petro'),
      'link' => $social_twitter,
      'icon' => 'fa-twitter',
      );
  }

 if(!empty($social_instagram)){
    $rows['instagram'] = array( 
      'label' => esc_html__( 'instagram','petro'),
      'link' => $social_instagram,
      'icon' => 'fa-instagram',
      );
  }

  if(!empty($social_pinterest)){
    $rows['pinterest'] = array( 
      'label' => esc_html__( 'pinterest','petro'),
      'link' => $social_pinterest,
      'icon' => 'fa-pinterest',
      );
   }


  if(!empty($social_linkedin)){
    $rows['linkedin'] = array( 
      'label' => esc_html__( 'linkedin','petro'),
      'link' => $social_linkedin,
      'icon' => 'fa-linkedin',
      );
   }


  $custom_socials=petro_get_config('custom_socials');

  if(is_array($custom_socials) && count($custom_socials)){

    foreach ($custom_socials as $custom_social) {

      if(isset($custom_social['icon']) && !empty($custom_social['icon'])) {

        if(function_exists('icl_t')){
          $custom_social['label'] = icl_t('petro', sanitize_key( $custom_social['label'] ), $custom_social['label'] );
        }

        $rows[ sanitize_key($custom_social['label'])] = $custom_social;
      }
    }
  }


   if($args['array']) return apply_filters('petro_social_icon_list', $rows);;

   $html = "";

   if(count($rows)){
     $html = '<ul class="social-icon-lists">';
     foreach($rows as $row){

        $html .= '<li class="social-item"><a href="'.esc_url($row['link']).'"'.($args['target']!='' ? ' target="'.$args['target'].'"' : '').'><i class="fa '.esc_attr($row['icon']).'"></i>'.($args['show_label'] ? '<span>'.$row['label'].'</span>': '' ).'</a></li>';
     }
     $html .= '</ul>';
   }

   $html = apply_filters('petro_social_icon_list_html', $html, $rows);

   return $html;
}


add_filter( 'woocommerce_add_to_cart_fragments', 'petro_woocommerce_header_add_to_cart_fragment' );

function petro_woocommerce_header_add_to_cart_fragment( $fragments ) {
  $fragments['cart_content_count'] = WC()->cart->get_cart_contents_count();
  return $fragments;
}

function petro_registration_url(){

 if( ($registration_page_id = get_option('woocommerce_registration_page_id'))){
   return get_the_permalink($registration_page_id);
 }

 return wp_registration_url();

}



function petro_get_portfolio_fields($fields=array()){

  $portfolio_fields=petro_get_config('portfolio_fields');

  if(!$portfolio_fields || !is_array($portfolio_fields))
    return $fields;

  $new_fields=array();

  foreach ($portfolio_fields as $k=>$field) {

    if(empty($field['name']))
      continue;

     $metaname=sanitize_key($field['name']);
     $new_fields[$metaname]=$field;


  }
  return $new_fields;
}

add_filter('tg_custom_post_fields','petro_get_portfolio_fields');


/* since 2.0.11 */
function petro_get_service_grid($service, $args=array()){

        extract( wp_parse_args( $args, array(
            'layout'=>'',
            'word_length'=>'',
            'size'=>'full',
            'image'=>'',
        )));

$featured_image = get_post_thumbnail_id($service->ID);

if($size=='custom') $size = 'service_thumbnail';

$thumb_image=get_image_size($featured_image,$size);
$image = '';

if($thumb_image){

  $image_alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);
  $image = '<img class="img-responsive" src="'.esc_url($thumb_image[0]).'" alt="'.esc_attr($image_alt_text).'"/>';

}

$description = ($word_length) ? wp_trim_words( get_the_excerpt() , $word_length, '') : get_the_excerpt();

?>
<div class="petro-services module-iconboxes style-<?php print absint($layout);?>">
<div class="iconboxes-wrap">
<?php
  if($layout=='6'){?>
     <div class="line-top"></div>
<?php  } ?>
<?php
        if($layout=='7'){
?>
 <div class="media"><?php print $image;?></div>
 <div class="icon-body">
<?php
}
?><span class="box"><?php if($layout!='7'):?><a  href="<?php the_permalink();?>"><?php print $image;?></a><?php endif;?></span><div class="text-wrap">
 <h4 class="box-heading  decoration"><?php the_title();?></h4>
<div class="iconboxes-text"><?php print $description;?>
<a  href="<?php the_permalink();?>" class="more-link"><?php esc_html_e('read more','petro');?></a>
</div></div>
<?php
        if($layout=='6'){
?>
<div class="line-bottom"></div>
<?php
        }
?>
<?php
if($layout=='7'){
?>  
 </div>
<?php    } ?>
</div>
</div>
<?php
}


function petro_add_image_size(){

  if( class_exists('TG_Custom_Post') && ($image_size = petro_get_config('tg_custom_post_image_size','full')) && $image_size=='custom'){

    $custom_image_size = petro_get_config('tg_custom_post_custom_image_size');

    if(preg_match_all('/\d+/', $custom_image_size, $matches)){

       $width = $height = 0;


      if(count($matches[0]) > 1) {
          $width = $matches[0][0]; 
          $height = $matches[0][1]; 
      } elseif(count($matches[0]) > 0 && count($matches[0]) < 2) {
          $width = $matches[0][0]; 
          $height = $matches[0][0]; 
      }

      if($width && $height){

       add_image_size( 'portfolio_image', $width, $height, 0 );    

      }


    }

  }

  if (class_exists('petro_service') && ($image_size = petro_get_config('petro_service_thumbnail','full')) && $image_size=='custom'){

    $custom_image_size = petro_get_config('petro_service_custom_image_size');

    if(preg_match_all('/\d+/', $custom_image_size, $matches)){

       $width = $height = 0;

      if(count($matches[0]) > 1) {
          $width = $matches[0][0]; 
          $height = $matches[0][1]; 
      } elseif(count($matches[0]) > 0 && count($matches[0]) < 2) {
          $width = $matches[0][0]; 
          $height = $matches[0][0]; 
      }

      if($width && $height){

       add_image_size( 'service_thumbnail', $width, $height, 0 );    

      }


    }

  }

}


function petro_header_style() {

  $banner_height = petro_get_config('heading-height','');
  $page_title_off = petro_get_config('page-title-offset','');
?>
<style type="text/css">
@media (min-width: 992px) {
<?php if($banner_height !=''):?>
  .page-heading.fixed,
  .page-heading .wp-custom-header{
    min-height:  <?php print absint($banner_height);?>px;
  }
  .page-heading .wp-custom-header{
    height: <?php print absint($banner_height);?>px;
  }
<?php endif;?>
<?php if($page_title_off !=''):?>
  .page-heading .wp-custom-header + .custom-page-title{
    bottom: <?php print absint($page_title_off);?>px;
  }
<?php endif;?>
}
</style>
<?php 
}

?>