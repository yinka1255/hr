<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

if ( is_plugin_active( 'revslider/revslider.php' ) ) {

add_action('init','revslider_element');   

function revslider_element(){

  global $wpdb;
  

  $query="SELECT id, title, alias FROM " . $wpdb->prefix . "revslider_sliders ORDER BY id ASC LIMIT 999";

  $results = $wpdb->get_results($query);


  $slides = array();
  if ( $results ) {
    foreach ( $results as $slider ) {

      $slides[$slider->title] = $slider->alias;
    }
  } else {
    $slides[ esc_html__( 'No sliders found', 'nuno-builder' )] = 0;
  }

  add_builder_element('rev_slider_shortcode', 
    array(
      'title' => esc_html__( 'Revolution Slider', 'nuno-builder' ),
      'description' => esc_html__( 'Place Revolution slider', 'nuno-builder' ),
      "options" => array(
        array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Widget title', 'nuno-builder' ),
          'admin_label' => true,
          'param_name' => 'title',
          'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'nuno-builder' )
        ),
        array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'Revolution Slider', 'nuno-builder' ),
          'param_name' => 'alias',
          'value' => $slides,
          'description' => esc_html__( 'Select your Revolution Slider.', 'nuno-builder' )
        ),
        array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Extra class name', 'nuno-builder' ),
          'param_name' => 'el_class',
          'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nuno-builder' )
        )
      )
    ) 
  );


  function rev_slider_render_shortcode($output,$content,$atts){

    extract( shortcode_atts( array(
      'alias' => '',
      'title'=>'',
      'el_class'=>''
    ), $atts ,'rev_slider'));

    $output="<div class=\"rev_slider_wrapper".(''!=$el_class?" ".$el_class:"")."\">";
    $output.=do_shortcode("[rev_slider alias=\"".$alias."\"]");
    $output.="</div>";

    return $output;
  }


  function rev_slider_preview_shortcode($output,$content,$atts){

    extract( shortcode_atts( array(
      'alias' => '',
      'title'=>'',
      'el_class'=>''
    ), $atts , 'rev_slider'));

    $output= esc_html__( 'Revolution Slider', 'nuno-builder' )."<br/>";
    $output.= esc_html__( 'Slide', 'nuno-builder' )." :".$alias;

    return $output;
  }

  add_builder_element_render('rev_slider_shortcode','rev_slider_render_shortcode');
  add_builder_element_preview('rev_slider_shortcode','rev_slider_preview_shortcode');

} 
}

?>
