<?php
defined('ABSPATH') or die();
/** @package WordPress
 * @subpackage Petro
 * @since Petro 1.1.0
 */

function petro_wc_body_class( $classes ) {
  $classes = (array) $classes;

  $col="";

  if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) {

    $col=petro_get_config('shop_column',3);
  }
  elseif(is_product()){

    $col=petro_get_config('loop_related_columns',3);
  }

  if($col!='') {
    $classes[] = 'columns-'.$col;
  }

  return array_unique( $classes );
}


function petro_related_products_args($args){

  $col=petro_get_config('loop_related_columns',3);

  if($related_per_page=petro_get_config('loop_related_per_page')){
    $args['posts_per_page']=$related_per_page;  
  }

  $args['columns']=$col;
  return $args;

}

function petro_woocommerce_account_settings($settings=array()){

  if(is_array($settings) && count($settings)){

    $newsettings=array();

    foreach ($settings as $key => $setting) {

      if(isset($setting['id']) && 'woocommerce_enable_myaccount_registration'==$setting['id']){

                array_push($newsettings,
                    array(
                      'title'    => esc_html__( 'Registration page', 'petro' ),
                      'desc'     => sprintf( __( 'Page contents: [%s]', 'woocommerce' ), apply_filters( 'woocommerce_petro_registration_shortcode_tag', 'woocommerce_petro_registration' ) ),
                      'id'       => 'woocommerce_registration_page_id',
                      'type'     => 'single_select_page',
                      'default'  => '',
                      'class'    => 'wc-enhanced-select',
                      'css'      => 'min-width:300px;',
                      'desc_tip' => true,
                    )
                );

                continue;

      }

      array_push($newsettings, $setting);


    }

    return $newsettings;

  }

  return $settings;
}


function petro_woocommerce_order_button_html(){
  $order_button_text  = apply_filters( 'woocommerce_order_button_text', esc_html__( 'Place order', 'petro' ));
  $button_html='<input type="submit" class="button woocommerce-button" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />';
  return $button_html;

}

function petro_woocommerce_product_review_comment_form_args($comment_form=array()){

  $comment_form['class_submit']='btn btn-inline btn-primary';
  return $comment_form;
}

function petro_woocommerce_product_additional_information_tab_title(){

    $tab_title=esc_html__('Specification','petro');

    return $tab_title;
}

function petro_woocommerce_product_additional_information_heading(){

  return esc_html__('Specification','petro');
}

function petro_woocommerce_product_description_heading(){

  return esc_html__('Description','petro');
}


/* hide page title */
add_filter('woocommerce_show_page_title',create_function('','return false;'));



function petro_registration_form($content){

  $pattern = get_shortcode_regex(array('woocommerce_petro_registration'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
      ob_start();
      wc_get_template( \'myaccount/form-registration.php\' );
      $content = ob_get_clean();

      return $content;
    ')
  , 
  $content);


  return $content;

}

function woocommerce_review_order_before_payment_title(){
?>
<h3 id="review_order_payment_heading"><?php esc_html_e('Payment Method','petro');?></h3>
<?php
}

function petro_woocommerce_is_account_page($account_page){

  $page_id = get_the_ID();

  if(! $page_id) return $account_page;

  if($page_id == get_option('woocommerce_registration_page_id')) return true;

  return $account_page;
}

function petro_shop_set_posts_per_page($query) {

  if(  $query->get( 'post_type' ) !='product'  || $query->is_home() || is_home() ) return;

    if ( !$query->is_main_query() || !($posts_per_page = petro_get_config('shop_per_page'))) {
      return;
    }

    $query->set( 'posts_per_page', $posts_per_page );
}

if(function_exists('is_shop')){

add_action( 'pre_get_posts' , 'petro_shop_set_posts_per_page');
add_action( 'woocommerce_review_order_before_payment', 'woocommerce_review_order_before_payment_title');

add_filter( 'woocommerce_product_description_heading', create_function('$heading','return "";'));
add_filter( 'woocommerce_product_additional_information_heading', create_function('$heading','return "";'));
add_filter( 'the_content' , 'petro_registration_form');
add_filter( 'woocommerce_product_description_heading', 'petro_woocommerce_product_description_heading' );
add_filter( 'woocommerce_product_additional_information_heading', 'petro_woocommerce_product_additional_information_heading' );
add_filter( 'woocommerce_product_additional_information_tab_title', 'petro_woocommerce_product_additional_information_tab_title' );
add_filter( 'woocommerce_output_related_products_args', 'petro_related_products_args' );
add_filter( 'body_class', 'petro_wc_body_class' );
add_filter( 'loop_shop_columns',create_function('$column','return max(2, petro_get_config(\'shop_column\',$column));'));
add_filter( 'woocommerce_account_settings','petro_woocommerce_account_settings');
add_filter( 'woocommerce_order_button_html', 'petro_woocommerce_order_button_html');
add_filter( 'woocommerce_product_review_comment_form_args', 'petro_woocommerce_product_review_comment_form_args' );
add_filter( 'woocommerce_is_account_page', 'petro_woocommerce_is_account_page');

}
?>