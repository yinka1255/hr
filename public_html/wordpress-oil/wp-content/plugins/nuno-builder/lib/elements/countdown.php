<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
 * @version     1.3.6
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_countdown extends BuilderElement {
  function preview($atts, $content = null) {

    return $this->render($atts, $content);
  }

  function render($atts, $content = null ,$base=""){

     extract(shortcode_atts(array(

          'year'=>'',
          'month'=>'',
          'date'=>'',
          'time'=>date('H:s',current_time( 'timestamp', 0 )),
          'url'=>'',
          'countdown_type'=>'fixed',
          'countdown_box_color'=>'',
          'countdown_text_color'=>'',
          'countdown_label_color'=>'',
          'border_radius'=>'',
          'border_width'=>'',
          'countdown_box_bgcolor'=>'',
          'el_id'=>'',
          'countdown_box_size'=>'',
          'relative_time'=>0,
          'cookie_lifetime'=>1,
          'countdown_box_shape'=>'',
          'periode_position'=>'',
          'el_class'=>'',
          'debug'=>false,

      ), $atts ,'countdown'));

      if(!stripos($time, ":")){
          $time.=":00";
      }


      if(is_admin()){
          if($time==''){
            $time= date('H:s',current_time( 'timestamp', 360 ));
          }

          if(defined('DOING_AJAX')){
            $countdown_type = 'evergreen';
            $relative_time = 60;            
          }

          $debug= true;
      }

      $message=str_replace(array("\n","\t"),array("",""), do_shortcode($content));
      $current_offset = get_option('gmt_offset');
      $element_id=getElementTagID();

     if($countdown_type=='evergreen'){
          $dateTo = "+".intval($relative_time)." minutes";

          $page_id=get_the_ID();
          $cookie_name='countdown_page'.$page_id."el".$element_id;

          if(isset($_COOKIE[$cookie_name])){
              $timeCurrent=$_COOKIE[$cookie_name];
          }
          else{
              $timeCurrent=time();
              print '<script type="text/javascript">document.cookie="'.$cookie_name.'='.$timeCurrent.'; expires='.date('r',strtotime(intval($cookie_lifetime).' hours')).'; path=/";</script>';
          }
     }
     else{
         $dateTo = "$month $date $year $time";
         $timeCurrent = (!empty($current_offset))?time()+($current_offset*3600):time();
     }



     $timeTo= strtotime( $dateTo );

      $css_class=array('el_countdown');
      if(''!=$el_class){
          array_push($css_class, $el_class);
      }

      if($periode_position!=''){
          array_push($css_class, 'countdown-periode-'.$periode_position);        
      }

      if($countdown_box_shape=='default' || $countdown_box_shape!=''){
          array_push($css_class, 'countdown-shape-'.$countdown_box_shape);
      }


      if($countdown_box_size=='small' || $countdown_box_size=='medium'){
          array_push($css_class, 'countdown-'.$countdown_box_size);
      }

      if(''==$el_id){
          $el_id="element".$element_id.time().rand(11,99);
      }

      $css_style=getElementCssMargin($atts);


     $compile="";

      if($countdown_type=='evergreen'){
           $until=($relative_time * 60) - (time() - $timeCurrent);
      }
      else{
          $until=$timeTo-$timeCurrent;
      }


     if( $until < 1 ){

      if(!empty($url)){

          $compile.='<meta http-equiv="refresh" content="5;URL='.$url.'" />';
      }

      $compile.="<div ";
      if(''!=$el_id){ $compile.="id=\"$el_id\" ";}
      $compile.="class=\"".@implode(" ",$css_class)."\">";
      $compile.='<div id="countdown_'.$el_id.'" class="countdown">'.esc_js($message).'</div></div>';

     }
     else{

      wp_enqueue_style('jquery.countdown',get_abuilder_dir_url()."css/jquery.countdown.css",array(),false);
      wp_enqueue_script('jquery.plugin',get_abuilder_dir_url()."js/jquery.plugin.min.js",array('jquery'));
      wp_enqueue_script('jquery.countdown',get_abuilder_dir_url()."js/jquery.countdown.min.js",array('jquery.plugin'));


      $compile.="<script type=\"text/javascript\">".'jQuery(document).ready(function($) {'.
              '\'use strict\';'.
              '$(\'#countdown_'.$el_id.'\').countdown({until: +'.$until.
                  ((!empty($message) && empty($url))?",expiryText:'".esc_js($message)."'":"").
                  ((!empty($url))?",expiryUrl:'".esc_url($url)."'":"").'});';
      if($debug){
         $compile.='$(\'#countdown_'.$el_id.'\').countdown(\'pause\');';
      }

      $compile.='});</script>';
      $amount_style = '';


         if(!empty($countdown_box_color)){
              $amount_style .= 'border-color: '.$countdown_box_color.';';
          }
 
         if(!empty($countdown_text_color)){
              $amount_style .= 'color: '.$countdown_text_color.';';
          }
 
         if(''!=$border_width){
              $amount_style.="border-width:".intval($border_width)."px;";
         }

         if(''!= $countdown_box_bgcolor){
              $amount_style .= 'background-color: '.$countdown_box_bgcolor.';';
            }

        if(''!=$border_radius && $countdown_box_shape=='rounded'){
          $border_radius = strpos($border_radius, '%') ? intval($border_radius)."%" : intval($border_radius)."px;";
          $amount_style.="border-radius:".$border_radius.";";
        }

     $compile.="<div ";
     if(''!=$el_id){ $compile.="id=\"$el_id\" ";}
     $compile.="class=\"".@implode(" ",$css_class)."\">";

     $compile.='<div id="countdown_'.$el_id.'" class="countdown"></div></div>';

         if(!empty($amount_style)){
              add_page_css_style('#countdown_'.$el_id.' .countdown-amount{'.$amount_style.'}');
          }

          if(!empty($countdown_label_color)){
              add_page_css_style('#countdown_'.$el_id.' .countdown-period{color: '.$countdown_label_color.';}');
          }

      }

     if(count($css_style)){
          add_page_css_style("#$el_id {".$css_style."}");
     }

     nuno_add_element_margin_style("#$el_id",$atts);

     return $compile;

  }

}

add_builder_element('countdown',
     array( 
    'title' => esc_html__( 'Countdown Timer', 'nuno-builder' ),
    'icon' =>'dashicons dashicons-clock',
    'color' =>'#f8b127',
    'order'=>20,
    'options' => array(
      array( 
        'heading' => esc_html__( 'Countdown Type', 'nuno-builder' ),
        'param_name' => 'countdown_type',
        'admin_label'=>false,
        'value' => array('fixed'=>esc_html__('Fixed Date','nuno-builder'),'evergreen'=>esc_html__('Evergreen','nuno-builder')),
        'default' => "fixed",
        'type' => 'radio',
         ),
         array( 
        'heading' => esc_html__( 'Relative Time (minutes)','nuno-builder' ),
        'param_name' => 'relative_time',
        'description' => esc_html__( 'Relative time from 1st page visit in minutes', 'nuno-builder' ),
        'class' => '',
        'default'=>0,
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'evergreen')
         ),     
         array( 
        'heading' => esc_html__( 'Cookie Lifetime (Hours)','nuno-builder' ),
        'param_name' => 'cookie_lifetime',
        'description' => esc_html__( 'How long cookie store 1st page visit', 'nuno-builder' ),
        'class' => '',
        'default'=>1,
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'evergreen')
         ),     
         array( 
        'heading' => esc_html__( 'Time','nuno-builder' ),
        'param_name' => 'time',
        'description' => sprintf(esc_html__( 'Time format hour:minute. example: %s', 'nuno-builder' ),date('H:s',current_time( 'timestamp', 0 ))),
        'class' => '',
        'default'=>date('H:s',current_time( 'timestamp', 0 )),
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
         array( 
        'heading' => esc_html__( 'Day','nuno-builder'),
        'param_name' => 'date',
        'description' => sprintf(esc_html__( 'Fill with the day of the event. example: %s', 'nuno-builder' ),date('d',current_time( 'timestamp', 0 ))),
        'class' => '',
        'default'=>date('d',current_time( 'timestamp', 0 )),
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
         array( 
        'heading' => esc_html__( 'Month','nuno-builder' ),
        'param_name' => 'month',
        'description' => esc_html__( 'Choose the month of the event', 'nuno-builder' ),
        'class' => '',
        'default'=>date('F',current_time( 'timestamp', 0 )),
        'value'=>array(
            'January'   => esc_html__( 'January', 'nuno-builder'),
            'February'  => esc_html__( 'February', 'nuno-builder'),
            'March'     => esc_html__( 'March', 'nuno-builder'),
            'April'     => esc_html__( 'April', 'nuno-builder'),
            'May'       => esc_html__( 'May', 'nuno-builder'),
            'June'      => esc_html__( 'June', 'nuno-builder'),
            'July'      => esc_html__( 'July', 'nuno-builder'),
            'August'    => esc_html__( 'August', 'nuno-builder'),
            'September' => esc_html__( 'September', 'nuno-builder'),
            'October'   => esc_html__( 'October', 'nuno-builder'),
            'November'  => esc_html__( 'November', 'nuno-builder'),
            'December'  => esc_html__( 'December', 'nuno-builder')
            ),
        'type' => 'dropdown',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
         array( 
        'heading' => esc_html__( 'Year','nuno-builder' ),
        'param_name' => 'year',
        'description' => sprintf(esc_html__( 'Fill with the year of the event. example: %d', 'nuno-builder' ),date('Y',current_time( 'timestamp', 0 ))),
        'class' => '',
        'default'=>date('Y',current_time( 'timestamp', 0 )),
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
        array( 
        'heading' => esc_html__( 'On Complete Countdown Message', 'nuno-builder' ),
        'param_name' => 'content',
        'value' => '',
        'description' => esc_html__( 'The content will show after countdown expired. Simple html allowed', 'nuno-builder' ),
        'type' => 'textarea_html'
         ),
        array( 
        'heading' => esc_html__( 'Redirect Url after countdown is completed', 'nuno-builder' ),
        'param_name' => 'url',
        'description' => esc_html__( 'If countdown expired, the page will be redirected to this url', 'nuno-builder' ),
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Debug Mode', 'nuno-builder' ),
        'param_name' => 'debug',
        'value' => array(
          '0'=>esc_html__('Disable','nuno-builder'),
          '1'=>esc_html__('Enable','nuno-builder'),
          ),
        'default' => "0",
        'description' => esc_html__( 'If debug mode enable, the countdown will pause counting.', 'nuno-builder' ),
        'type' => 'radio',
         ),
        array( 
        'heading' => esc_html__( 'Color', 'nuno-builder' ),
        'type' => 'heading',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Counter Color', 'nuno-builder' ),
        'param_name' => 'countdown_text_color',
        'param_holder_class'=>'countdown-text-color',
        'value' => "",
        'default' => "",
        'group'=>esc_html__('Styles', 'nuno-builder'),
        'type' => 'colorpicker',
         ),
        array( 
        'heading' => esc_html__( 'Periode Color', 'nuno-builder' ),
        'param_name' => 'countdown_label_color',
        'param_holder_class'=>'countdown-label-color',
        'value' => "",
        'default' => "",
        'group'=>esc_html__('Styles', 'nuno-builder'),
        'type' => 'colorpicker',
         ),

        array( 
        'heading' => esc_html__( 'Box', 'nuno-builder' ),
        'type' => 'heading',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Size', 'nuno-builder' ),
        'param_name' => 'countdown_box_size',
        'value' => array(
          'default'=>esc_html__('Default','nuno-builder'),
          'medium'=>esc_html__('Medium','nuno-builder'),
          'small'=>esc_html__('Small','nuno-builder'),
          ),
        'default' => "default",
        'type' => 'radio',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Shape', 'nuno-builder' ),
        'param_name' => 'countdown_box_shape',
        'value' => array(
          'default'=>esc_html__('Default','nuno-builder'),
          'circle'=>esc_html__('Circle','nuno-builder'),
          'rounded'=>esc_html__('Round','nuno-builder'),
          ),
        'default' => "default",
        'type' => 'radio',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Periode Position', 'nuno-builder' ),
        'param_name' => 'periode_position',
        'value' => array(
          'outside'=>esc_html__('Default','nuno-builder'),
          'inside'=>esc_html__('Inside box','nuno-builder'),
          ),
        'default' => "outside",
        'type' => 'radio',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          "description" => esc_html__("Select radius for border(in px or %).", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),
          'dependency' => array( 'element' => 'countdown_box_shape', 'value' => array( 'rounded' ) )       
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'param_holder_class'=>'small-wide',
          "description" => esc_html__("Border width in pixel.", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),
          'type' => 'textfield',
        ),
        array( 
        'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
        'param_name' => 'countdown_box_color',
        'param_holder_class'=>'countdown-box-color',
        'value' => "",
        'default' => "",
        'type' => 'colorpicker',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'countdown_box_bgcolor',
          'param_holder_class'=>'countdown-box-color',
          'value' => "",
          'default' => "",
          'group'=>esc_html__('Styles', 'nuno-builder'),
          'type' => 'colorpicker',
         ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),

        array( 
          'heading' => esc_html__( 'Margin Tablet', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'nuno-builder' ),
          'param_name' => 'margin_tablet',
          'type' => 'heading',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Mobile', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'nuno-builder' ),
          'param_name' => 'margin_mobile',
          'type' => 'heading',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          'group'=>esc_html__('Advanced', 'nuno-builder'),
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
          'group'=>esc_html__('Advanced', 'nuno-builder'),
        ),
    )

 ) );
?>
