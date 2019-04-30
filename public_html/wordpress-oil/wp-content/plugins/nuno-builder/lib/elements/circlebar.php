<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.1
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_circle_bar extends BuilderElement{

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'title' =>'',
            'value' =>'',
            'procent'=>'100',
            'unit' =>'',
            'color' =>'',
            'label_color'=>'',
            'unit_color'=>'',
            'height' =>'',
            'track_height'=>'',
            'admin'=> false,
            'label_font_size'=>'',
            'unit_font_size'=>'',
            'value_color'=>'',
            'value_font_size'=>'',
            'bg' =>'', 
            'el_id' => '',
            'linecap'=>'',
            'el_class'=>'',
            'counto'=>''
        ), $atts,'el_circle_bar' ) );

        wp_enqueue_script( 'jquery.appear', get_abuilder_dir_url() . 'js/jquery.appear.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'jquery.counto',get_abuilder_dir_url()."js/jquery.counto.min.js",array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'jquery.chart', get_abuilder_dir_url() . 'js/chart.js', array('jquery.appear','jquery.counto'), '1.3.3', false );

        $css_class=array('el_circle_bar');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $procent = min(100, max(0 , absint($procent)));
        $label_styles = $unit_styles = $values_styles = array();

        if($label_color!=''){
          $label_styles[] = 'color:'.$label_color;
        } 

        if($label_font_size!=''){
          $label_styles[] = "font-size:".absint($label_font_size)."px";
        } 


        if($unit_font_size!=''){
            $unit_styles[]="font-size:".absint($unit_font_size)."px";
        }

        if($unit_color!=''){ $unit_styles[] = 'color:'.$unit_color; } 

        if($value_font_size!=''){
            $values_styles[]="font-size:".absint($value_font_size)."px";
        }

        if($value_color!=''){ $values_styles[] = 'color:'.$value_color; } 


        $compile.="class=\"".@implode(" ",$css_class)."\">";
        
        if($unit!=''){
          $compile.="<span class=\"circle-bar-unit\" ".(count($unit_styles) ? ' style="'.join(';', $unit_styles).'"':'').">".esc_html($unit)."</span>";
        }

        $compile.="<div class=\"circle-bar-outer\" >";

        if($value!=''){
          $compile.="<span class=\"circle-bar-value\" ".(count($values_styles) ? 'style="'.implode(';', $values_styles).'"': '').">".esc_html($value)."</span>";
        }

        $compile.='<div class="circle-bar" data-linecap="'.esc_attr($linecap).'" data-trackwidth="'.esc_attr($track_height).'" data-linewidth="'.esc_attr($height).'" data-bgcolor="'.esc_attr($bg).'" data-color="'.esc_attr($color).'" data-percent="'.esc_attr($procent).'" data-counto="'.esc_attr($counto).'" ></div>';
        $compile.="</div>";
        if($title!=''){
          $compile.="<label class=\"circle-bar-label\" ".(count($label_styles) ? 'style="'.implode(';', $label_styles).'"': '').">".esc_html($title)."</label>";
        }
        $compile.="</div>";

        if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_circle_bar',
  array(
    'title'=>esc_html__('Circle Bar','nuno-builder'),
    'icon'=>'fa fa-circle-o-notch',
    'color'=>'#346362',
    'order'=>10,
    'options'=>array(

        array( 
        'heading' => esc_html__( 'Title/Label', 'nuno-builder' ),
        'param_name' => 'title',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Procent Value', 'nuno-builder' ),
        'param_name' => 'procent',
        'param_holder_class' =>'small-wide',
        'value' => '',
        'description' => esc_html__("Enter value 0 - 100", "nuno-builder"),
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Actual Value', 'nuno-builder' ),
        'param_name' => 'value',
        'param_holder_class' =>'small-wide',
        'value' => '',
        'description' => esc_html__("Enter the actual value", "nuno-builder"),
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Counto Target ID', 'nuno-builder' ),
        'param_name' => 'counto',
        'param_holder_class' =>'small-wide',
        'value' => '',
        'description' => esc_html__("This optional counter. If you have counto element, you can use this element for make trigger to start counting. Enter anchor ID without pound '#' sign", "nuno-builder"),
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Units', 'nuno-builder' ),
        'param_name' => 'unit',
        'value' => '',
        'param_holder_class' =>'small-wide',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Line Cap', 'nuno-builder' ),
        'param_name' => 'linecap',
        'value' => array(
          ''=>esc_html__('Default','nuno-builder'),
          'round'=>esc_html__('Round','nuno-builder'),
          'square'=>esc_html__('Square','nuno-builder'),
          ),
        'type' => 'dropdown',
         ),
        array( 
        'heading' => esc_html__( 'Circle Bar', 'nuno-builder' ),
        'param_name' => 'circle_bar',
        'type' => 'heading',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Bar Wide', 'nuno-builder' ),
        'param_name' => 'height',
        'param_holder_class' =>'small-wide',
        'value' => '',
        'type' => 'textfield',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Bar Background Wide', 'nuno-builder' ),
        'param_name' => 'track_height',
        'param_holder_class' =>'small-wide',
        'value' => '',
        'type' => 'textfield',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Bar Color', 'nuno-builder' ),
        'param_name' => 'color',
        'value' => '',
        'type' => 'colorpicker',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Track Color', 'nuno-builder' ),
        'param_name' => 'bg',
        'value' => '',
        'type' => 'colorpicker',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Label', 'nuno-builder' ),
        'param_name' => 'label_setting',
        'type' => 'heading',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Color', 'nuno-builder' ),
        'param_name' => 'label_color',
        'value' => '',
        'type' => 'colorpicker',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Font Size', 'nuno-builder' ),
        'param_name' => 'label_font_size',
        'param_holder_class' =>'small-wide',
        'default' => "",
        'type' => 'textfield',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Unit', 'nuno-builder' ),
        'param_name' => 'unit_setting',
        'type' => 'heading',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Color', 'nuno-builder' ),
        'param_name' => 'unit_color',
        'value' => '',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => esc_html__( 'Font Size', 'nuno-builder' ),
        'param_name' => 'unit_font_size',
        'param_holder_class' =>'small-wide',
        'default' => "",
        'type' => 'textfield',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Bar Value', 'nuno-builder' ),
        'param_name' => 'bar_value_setting',
        'type' => 'heading',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Color', 'nuno-builder' ),
        'param_name' => 'value_color',
        'value' => '',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => esc_html__( 'Font Size', 'nuno-builder' ),
        'param_name' => 'value_font_size',
        'param_holder_class' =>'small-wide',
        'default' => "",
        'type' => 'textfield',
        'group'=>esc_html__('Styles', 'nuno-builder'),
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
        array( 
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
          'group'=>esc_html__('Advanced', 'nuno-builder'),
        ),
        )    
    )
);
?>
