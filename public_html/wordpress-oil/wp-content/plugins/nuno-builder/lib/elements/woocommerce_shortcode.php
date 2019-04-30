<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       2.0.4
*/
defined('ABUILDER_BASENAME') or die();

if (is_plugin_active('woocommerce/woocommerce.php')){

/* WooCommerce Shortcode */

add_builder_element('recent_products',
   array( 
    'title' => esc_html__( 'Recent Products', 'nuno-builder' ),
    'icon'  => 'dashicons woo-admin-generic',
    'color' =>'#f17dad',
    'order'=>50,
    'options' => array(  
        array( 
          'heading' => esc_html__('Num Product','nuno-builder' ),
          'param_name' => 'per_page',
          'admin_label' => true,
          'class' => 'small',
          'description' => esc_html__('Num product to show','nuno-builder' ),
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
        'heading' => esc_html__( 'Columns', 'nuno-builder' ),
        'param_name' => 'columns',
        'admin_label' => true,
        'description' => esc_html__( 'Number of product column', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            '1' => esc_html__('One Column','nuno-builder'),
            '2' => esc_html__('Two Columns','nuno-builder'),
            '3' => esc_html__('Three Columns','nuno-builder'),
            '4' => esc_html__('Four Columns','nuno-builder'),
            '5' => esc_html__('Five Columns','nuno-builder'),
            '6' => esc_html__('Six Columns','nuno-builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
          'heading' => esc_html__( 'Order By', 'nuno-builder' ),
          'param_name' => 'orderby',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'date'=>esc_html__('Date','nuno-builder') ,
            'name'=>esc_html__('Name','nuno-builder') ,
            'modified'=>esc_html__('Modified','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'date'
         ),         
        array( 
          'heading' => esc_html__( 'Order', 'nuno-builder' ),
          'param_name' => 'order',
          'class' => '',
          'value' => array(
            ''=>esc_html__('Default','nuno-builder') ,
            'desc'=>esc_html__('Descending','nuno-builder') ,
            'asc'=>esc_html__('Ascending','nuno-builder') ) ,
          'type' => 'dropdown',
          'default'=>'center'
         ),         
       )
     )
);

/*
class BuilderElement_wc_products extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wc_products'));


    $class=array('wc_products');

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

      the_widget( 'WC_Widget_Products', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wc_products',
   array( 
    'title' => esc_html__( 'Woo products', 'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'order'=>101,
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
          'heading' => esc_html__( 'Number of products to show', 'woocommerce' ),
          'param_name'=>'number',
          'type' => 'slider_value',
          'default' => 5,
          'params'=>array('min'=>1,'max'=>100,'step'=>1),
        ),
        array(
          'type'  => 'dropdown',
          'param_name'=>'show',
          'default'   => '',
          'heading' => esc_html__( 'Show', 'woocommerce' ),
          'value' => array(
            ''         => esc_html__( 'All products', 'woocommerce' ),
            'featured' => esc_html__( 'Featured products', 'woocommerce' ),
            'onsale'   => esc_html__( 'On-sale products', 'woocommerce' ),
          ),
        ),
        array(
          'type'  => 'dropdown',
          'param_name'=>'orderby',
          'default'   => 'date',
          'heading' => esc_html__( 'Order by', 'woocommerce' ),
          'value' => array(
            'date'   => esc_html__( 'Date', 'woocommerce' ),
            'price'  => esc_html__( 'Price', 'woocommerce' ),
            'rand'   => esc_html__( 'Random', 'woocommerce' ),
            'sales'  => esc_html__( 'Sales', 'woocommerce' ),
          ),
        ),
        array(
          'type'  => 'dropdown',
          'param_name'=>'order',
          'default'   => 'desc',
          'heading' => _x( 'Order', 'Sorting order', 'woocommerce' ),
          'value' => array(
            'asc'  => esc_html__( 'ASC', 'woocommerce' ),
            'desc' => esc_html__( 'DESC', 'woocommerce' ),
          ),
        ),
        array(
          'type'  => 'check',
          'param_name'=>'hide_free',
          'default'   => 0,
          'heading' => esc_html__( 'Hide free products', 'woocommerce' ),
        ),
        array(
          'type'  => 'check',
          'param_name'=>'show_hidden',
          'default'   => 0,
          'heading' => esc_html__( 'Show hidden products', 'woocommerce' ),
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

class BuilderElement_wc_recent_reviews extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wc_recent_reviews'));


    $class=array('wc_recent_reviews');

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

      the_widget( 'WC_Widget_Recent_Reviews', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wc_recent_reviews',
   array( 
    'title' => esc_html__( 'Woo recent reviews', 'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'order'=>102,
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
          'heading' => esc_html__( 'Number of products to show', 'woocommerce' ),
          'param_name'=>'number',
          'type' => 'slider_value',
          'default' => 5,
          'params'=>array('min'=>1,'max'=>100,'step'=>1),
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

class BuilderElement_wc_recently_viewed extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wc_recently_viewed'));


    $class=array('wc_recently_viewed');

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

      the_widget( 'WC_Widget_Recently_Viewed', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('wc_recently_viewed',
   array( 
    'title' => esc_html__( 'Woo viewed products', 'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'order'=>103,
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
          'heading' => esc_html__( 'Number of products to show', 'woocommerce' ),
          'param_name'=>'number',
          'type' => 'slider_value',
          'default' => 5,
          'params'=>array('min'=>1,'max'=>100,'step'=>1),
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

class BuilderElement_wc_cart extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wc_cart'));


    $class=array('wc_cart');

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

      the_widget( 'WC_Widget_Cart', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_builder_element('wc_cart',
   array( 
    'title' => esc_html__( 'Woo cart', 'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'order'=>104,
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
          'type'  => 'check',
          'param_name'=>'hide_if_empty',
          'default'   => 0,
          'heading' => esc_html__( 'Hide if cart is empty', 'woocommerce' ),
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

class BuilderElement_wc_search extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wc_search'));


    $class=array('wc_search');

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

      the_widget( 'WC_Widget_Product_Search', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wc_search',
   array( 
    'title' => esc_html__( 'Woo Product Search', 'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'order'=>105,
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

class BuilderElement_wc_product_categories extends BuilderElement {


    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wc_product_categories'));


    $class=array('wc_product_categories');

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

      the_widget( 'WC_Widget_Product_Categories', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_builder_element('wc_product_categories',
   array( 
    'title' => esc_html__( 'Woo product categories', 'nuno-builder' ),
    'icon'  => 'dashicons dashicons-wordpress-alt',
    'order'=>106,
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
          'type'  => 'dropdown',
          'param_name'=>'orderby',
          'default'   => '',
          'heading' => esc_html__( 'Order by', 'woocommerce' ),
          'value' => array(
            'order' => esc_html__( 'Category order', 'woocommerce' ),
            'name'  => esc_html__( 'Name', 'woocommerce' ),
          ),
        ),
        array(
          'type'  => 'check',
          'param_name'=>'dropdown',
          'default'   => 0,
          'heading' => esc_html__( 'Show as dropdown', 'woocommerce' ),
        ),
        array(
          'type'  => 'check',
          'param_name'=>'count',
          'default'   => 0,
          'heading' => esc_html__( 'Show product counts', 'woocommerce' ),
        ),
        array(
          'type'  => 'check',
          'param_name'=>'hierarchical',
          'default'   => 1,
          'heading' => esc_html__( 'Show hierarchy', 'woocommerce' ),
        ),
        array(
          'type'  => 'check',
          'param_name'=>'show_children_only',
          'default'   => 0,
          'heading' => esc_html__( 'Only show children of the current category', 'woocommerce' ),
        ),
        array(
          'type'  => 'check',
          'param_name'=>'hide_empty',
          'default'   => 0,
          'heading' => esc_html__( 'Hide empty categories', 'woocommerce' ),
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
*/

}
?>
