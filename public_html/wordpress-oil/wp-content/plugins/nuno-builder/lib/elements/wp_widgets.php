<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

/* WordPress widget */

class BuilderElement_wp_search extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wp_search'));


    $class=array('wp_search');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Search', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wp_search',
   array( 
    'title' => "WP ".esc_html__( 'Search', 'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
          'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
          'param_name' => 'spy',
          'class' => '',
          'value' => 
           array(
              'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
              'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
              'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
              'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
              'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
              'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
              'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
              'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
           ),        
          'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
          'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_wp_pages extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wp_pages'));

    $class=array('wp_pages');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }



     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Pages', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title' => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('wp_pages',
   array( 
    'title' => "WP ".esc_html__( 'Pages','nuno-builder'),
    'description' => esc_html__( 'A list of your site&#8217;s Pages.','nuno-builder'),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
        'heading' => esc_html__('Sort by','nuno-builder' ),
        'param_name' => 'sortby',
        'class' => '',
        'value' => array(
          'post_title'  => esc_html__('Page title','nuno-builder'),
          'menu_order'  => esc_html__('Page order','nuno-builder'),
          'ID'  => esc_html__( 'Page ID','nuno-builder' )
          ),
        'type' => 'dropdown'
         ), 
        array( 
        'heading' => esc_html__('Exclude','nuno-builder' ),
        'param_name' => 'exclude',
        'class' => '',
        'value' => '',
        'description'=>esc_html__( 'Page IDs, separated by commas.','nuno-builder' ),
        'type' => 'textfield'
         ), 
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'spy',
        'class' => '',
        'value' => 
         array(
            'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
            'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
            'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
            'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
            'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
            'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
            'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
            'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
         ),        
        'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_wp_menu extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300,
        'nav_menu'=>''

      ), $atts , 'wp_menu'));

    $class=array('wp_menu');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }


     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);
//      $atts['nav_menu'] = 2;

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Nav_Menu_Widget', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title' => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wp_menu',
   array( 
    'title' => "WP ".esc_html__( 'Custom Menu','nuno-builder'),
    'description' => esc_html__( 'Add a custom menu to your sidebar.','nuno-builder'),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
          'heading' => esc_html__( 'Select Menu', 'nuno-builder' ),
          'param_name' => 'nav_menu',
          'class' => '',
          'value' => '',
          'type' => 'menu',
          'default'=>''
         ),         
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'spy',
        'class' => '',
        'value' => 
         array(
            'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
            'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
            'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
            'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
            'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
            'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
            'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
            'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
         ),        
        'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);
class BuilderElement_widget_archive extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'widget_archive'));


    $class=array('widget_archive');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Archives', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title' => $before_title) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('widget_archive',
   array( 
    'title' => "WP ".esc_html__('Archives','nuno-builder'),
    'description' => esc_html__( "A monthly archive of your site&#8217;s Posts.",'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
        'heading' => esc_html__('Display as dropdown','nuno-builder' ),
        'param_name' => 'dropdown',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => esc_html__('Show post counts','nuno-builder' ),
        'param_name' => 'count',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'spy',
        'class' => '',
        'value' => 
         array(
            'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
            'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
            'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
            'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
            'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
            'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
            'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
            'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
         ),        
        'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_widget_meta extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'widget_meta'));


    $class=array('widget_meta');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Meta', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title' => $before_title) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('widget_meta',
   array( 
    'title' => "WP ".esc_html__('Meta','nuno-builder'),
    'description' => esc_html__( "Login, RSS, &amp; WordPress.org links.",'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'spy',
        'class' => '',
        'value' => 
         array(
            'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
            'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
            'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
            'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
            'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
            'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
            'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
            'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
         ),        
        'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_widget_calendar extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'widget_calendar'));


    $class=array('widget_calendar');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Calendar', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title' => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('widget_calendar',
   array( 
    'title' => "WP ".esc_html__('Calendar','nuno-builder'),
    'description' => esc_html__( "A calendar of your site&#8217;s Posts.",'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
          'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
          'param_name' => 'spy',
          'class' => '',
          'value' => 
           array(
              'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
              'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
              'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
              'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
              'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
              'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
              'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
              'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
           ),        
          'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
          'type' => 'dropdown',
         ),     
        array( 
          'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
          'param_name' => 'scroll_delay',
          'class' => '',
          'default' => '300',
          'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
          'type' => 'textfield',
          'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_wp_categories extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'count'=>'',
        'title_align'=>'',
        'hierarchical'=>'',
        'dropdown'=>'',
        'scroll_delay'=>300

      ), $atts , 'widget_categories'));


    $class=array('widget_categories');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Categories', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title' => $before_title) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('wp_categories',
   array( 
    'title' => "WP ".esc_html__( 'Categories','nuno-builder'),
    'description' => esc_html__( 'A list or dropdown of categories.','nuno-builder'),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
      array( 
        'heading' => esc_html__('Display as dropdown','nuno-builder' ),
        'param_name' => 'dropdown',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => esc_html__('Show post counts','nuno-builder' ),
        'param_name' => 'count',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => esc_html__('Show hierarchy','nuno-builder' ),
        'param_name' => 'hierarchical',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'spy',
        'class' => '',
        'value' => 
         array(
            'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
            'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
            'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
            'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
            'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
            'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
            'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
            'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
         ),        
        'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_wp_recent_post extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'title_align'=>'',
        'number'=>'',
        'show_date'=>'',
        'scroll_delay'=>300

      ), $atts , 'widget_recent_posts'));


    $class=array('widget_recent_posts');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Recent_Posts', $atts, array('widget_id'=>"widget-".$el_id , 'before_title' => $before_title) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wp_recent_post',
   array( 
    'title' => "WP ".esc_html__( 'Recent Posts','nuno-builder'),
    'description' => esc_html__( 'Your site&#8217;s most recent Posts.','nuno-builder'),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
        'heading' => esc_html__('Number of posts to show:','nuno-builder' ),
        'param_name' => 'number',
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => esc_html__('Display post date?','nuno-builder' ),
        'param_name' => 'show_date',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'spy',
        'class' => '',
        'value' => 
         array(
            'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
            'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
            'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
            'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
            'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
            'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
            'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
            'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
         ),        
        'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_wp_recent_comment extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'title_align'=>'',
        'number'=>'',
        'scroll_delay'=>300

      ), $atts , 'widget_recent_comments'));


    $class=array('widget_recent_comments');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Recent_Comments', $atts, array('widget_id'=>"widget-".$el_id, 'before_title' => $before_title) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('wp_recent_comment',
   array( 
    'title' => "WP ".esc_html__( 'Recent Comments','nuno-builder'),
    'description' => esc_html__( 'Your site&#8217;s most recent comments.','nuno-builder'),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
        'heading' => esc_html__('Number of comments to show:','nuno-builder' ),
        'param_name' => 'number',
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'spy',
        'class' => '',
        'value' => 
         array(
            'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
            'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
            'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
            'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
            'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
            'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
            'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
            'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
         ),        
        'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);

class BuilderElement_wp_tag_cloud extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'title_align'=>'',
        'taxonomy'=>'',
        'scroll_delay'=>300

      ), $atts , 'tag_cloud'));


    $class=array('tag_cloud');

     if('' != $title_align){
        $before_title = '<h2 class="widgettitle widget-title-'.$title_align.'">';
     }
     else{
        $before_title = '<h2 class="widgettitle">';
     }

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getElementCssMargin($atts);

     if(''==$el_id){
            $el_id="element_".getElementTagID();
     }
     
     if(''!=$css_style){
           add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
         get_scroll_spy_script();
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Tag_Cloud', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title' => $before_title) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wp_tag_cloud',
   array( 
    'title' => "WP ".esc_html__( 'Tag Cloud','nuno-builder'),
    'description' => esc_html__( 'A cloud of your most used tags.','nuno-builder'),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'color' =>'#f17dad',
    'options' => array(  
        array( 
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
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
          'heading' => esc_html__('Title','nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'nuno-builder' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'center'=>esc_html__('Center','nuno-builder') ,
            'left'=>esc_html__('Left','nuno-builder') ,
            'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
          'heading' => esc_html__('Taxonomy:','nuno-builder' ),
          'param_name' => 'taxonomy',
          'class' => '',
          'value' => '',
          'type' => 'taxonomy'
         ), 
        array( 
          'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
          'param_name' => 'spy',
          'class' => '',
          'value' => 
           array(
              'none'                      => esc_html__('Scroll Spy not activated','nuno-builder'),
              'uk-animation-fade'         => esc_html__('The element fades in','nuno-builder'),
              'uk-animation-scale-up'     => esc_html__('The element scales up','nuno-builder'),
              'uk-animation-scale-down'   => esc_html__('The element scales down','nuno-builder'),
              'uk-animation-slide-top'    => esc_html__('The element slides in from the top','nuno-builder'),
              'uk-animation-slide-bottom' => esc_html__('The element slides in from the bottom','nuno-builder'),
              'uk-animation-slide-left'   => esc_html__('The element slides in from the left','nuno-builder'),
              'uk-animation-slide-right'  => esc_html__('The element slides in from the right.','nuno-builder'),
           ),        
          'description' => esc_html__( 'Scroll spy effects', 'nuno-builder' ),
          'type' => 'dropdown',
         ),     
        array( 
          'heading' => esc_html__( 'Animation Delay', 'nuno-builder' ),
          'param_name' => 'scroll_delay',
          'class' => '',
          'default' => '300',
          'description' => esc_html__( 'The number of delay the animation effect of the icon. in milisecond', 'nuno-builder' ),
          'type' => 'textfield',
          'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
       )
     )
);
?>
