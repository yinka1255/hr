<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.2
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_counto extends BuilderElement{

    function preview($atts, $content = null){

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'number' =>'',
            'trigger' =>'appear',          
            'border' => '',
            'border_style'=>'solid',
            'border_width'=>'',
            'border_radius'=>'',
            'box_width'=>'',
            'box_height'=>'',
            'color'=>'',
            'font_weight'=>'',
            'font_style'=>'',
            'font_size'=>'default',
            'custom_font_size'=>'',
            'el_id' => '',
            'el_class'=>'',
        ), $atts,'el_counto' ) );

        wp_enqueue_script( 'jquery.appear', get_abuilder_dir_url() . 'js/jquery.appear.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'jquery.counto',get_abuilder_dir_url()."js/jquery.counto.min.js",array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'jquery.chart', get_abuilder_dir_url() . 'js/chart.js', array('jquery.appear','jquery.counto'), '1.3.3', false );

        $css_class=array('el_counto');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if('default'!==$font_size){
          array_push($css_class," font-size-".$font_size);
        }


        $css_style = $box_style =  array();

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }


        if(''!=$border){
          $css_style[] = ($border_style!='') ? "border-style:{$border_style}" : "border-style: solid";
          $css_style[] = "border-color:{$border}";
        }

        if(''!=$box_width){
           $css_style[]= "width:".absint($box_width)."px";
        }


        if(''!=$box_height){
           $css_style[]= "height:".absint($box_height)."px";
        }


        if(''!=$border_width){
          $css_style[]= "border-width:".absint($border_width)."px";
        }

        if(''!=$border_radius){
          $border_radius = strpos($border_radius, '%') ? absint($border_radius)."%" : absint($border_radius)."px;";
          $css_style[] = "border-radius:".$border_radius."";
        }

        if(!empty($color)){
            $css_style['color']="color:".$color;
        }

        if(!empty($font_weight) && $font_weight!='default'){
            $css_style['font-weight']="font-weight:".$font_weight;
        }

        if(!empty($font_style) && $font_style!='default'){
            $css_style['font-style']="font-style:".$font_style;
        }

        if(!empty($custom_font_size) && $font_size=='custom'){
            $custom_font_size=(preg_match('/(px|pt)$/', $custom_font_size))?$custom_font_size:$custom_font_size."px";
            $css_style['font-size']="font-size:".$custom_font_size;
        }

        $compile="<div ";

        if(''!=$el_id){
            $compile.=" id=\"$el_id\" ";
        }

        $compile.=" class=\"".@implode(" ",$css_class)."\" ".(count($css_style) ? 'style="'.implode(';', $css_style).'"': '').">";
        $compile.= '<span class="counto" data-trigger="'.esc_attr($trigger).'" >'.absint($number)."</span></div>";

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_counto',
  array(
    'title'=>esc_html__('Count Number','nuno-builder'),
    'icon'=>'fa fa-barcode',
    'color'=>'#b4bc8f',
    'order'=>3,
    'options'=>array(
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
          'heading' => esc_html__( 'Margin', 'nuno-builder' ),
          'param_name' => 'margin',
          'type' => 'heading',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Padding', 'nuno-builder' ),
          'param_name' => 'padding',
          'type' => 'heading',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),

        array( 
          'heading' => esc_html__( 'Margin Tablet', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'nuno-builder' ),
          'param_name' => 'margin_tablet',
          'type' => 'heading',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Padding Tablet', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'nuno-builder' ),
          'param_name' => 'padding_tablet',
          'type' => 'heading',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_sm_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_sm_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_sm_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_sm_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Mobile', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'nuno-builder' ),
          'param_name' => 'margin_mobile',
          'type' => 'heading',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Padding Mobile', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'nuno-builder' ),
          'param_name' => 'padding_mobile',
          'type' => 'heading',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_xs_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_xs_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_xs_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_xs_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin & Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Count Number', 'nuno-builder' ),
          'param_name' => 'number',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
        ),
        array( 
        'heading' => esc_html__( 'Event Trigger', 'nuno-builder' ),
        'param_name' => 'trigger',
        'type' => 'dropdown',
        'value'=>array(
            'appear'  => esc_html__('Appear Element','nuno-builder'),
            'external' => esc_html__('None','nuno-builder'),
            )

        ),

        array( 
        'heading' => esc_html__( 'Font Size', 'nuno-builder' ),
        'param_name' => 'font_size',
        'default' => "default",
        'value'=>array(
              'xlarge'  => esc_html__('Extra Large','nuno-builder'),
              'large' => esc_html__('Large','nuno-builder'),
              'default' => esc_html__('Default','nuno-builder'),
              'small' => esc_html__('Small','nuno-builder'),
              'exsmall' => esc_html__('Extra small','nuno-builder'),
              'custom'  => esc_html__( 'Custom Size', 'nuno-builder' )
              ),
        'type' => 'dropdown',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Custom Font Size', 'nuno-builder' ),
        'param_name' => 'custom_font_size',
        'value' => '',
        'type' => 'textfield',
        'param_holder_class'=>'small-wide',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        'dependency' => array( 'element' => 'font_size', 'value' => array( 'custom') )       
         ),         
        array( 
        'heading' => esc_html__( 'Font Style', 'nuno-builder' ),
        'param_name' => 'font_style',
        'default' => "default",
        'value'=>array(
              'italic'  => esc_html__('Italic','nuno-builder'),
              'oblique' => esc_html__('Oblique','nuno-builder'),
              'default' => esc_html__('Default','nuno-builder'),
              'normal'  => esc_html__('Normal','nuno-builder'),
              ),
        'type' => 'dropdown',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Font Weight', 'nuno-builder' ),
        'param_name' => 'font_weight',
        'default' => "default",
        'value'=>array(
              'bold'  => esc_html__('Bold','nuno-builder'),
              'bolder'  => esc_html__('Bolder','nuno-builder'),
              'normal'  => esc_html__('Normal','nuno-builder'),
              'lighter' => esc_html__('lighter','nuno-builder'),
              '100'=>'100',
              '200'=>'200',
              '300'=>'300',
              '400'=>'400',
              '500'=>'500',
              '600'=>'600',
              '700'=>'700',
              '800'=>'800',
              '900'=>'900',
              'default' => esc_html__('Default','nuno-builder'),
              ),
        'type' => 'dropdown',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
         array( 
        'heading' => esc_html__( 'Text Color', 'nuno-builder' ),
        'param_name' => 'color',
        'value' => '',
        'type' => 'colorpicker',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),

        array(
          "type" => "heading",
          "heading" => esc_html__('Box Size', 'nuno-builder'),
          "param_name" => "box_size",
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Box Width (Optional)', 'nuno-builder' ),
          'param_name' => 'box_width',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          "description" => esc_html__("Select counto box width in px.", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),          
        ),
        array( 
          'heading' => esc_html__( 'Box Height (Optional)', 'nuno-builder' ),
          'param_name' => 'box_height',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          "description" => esc_html__("Select counto box height in px.", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),          
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__('Border', 'nuno-builder'),
          "param_name" => "border_color",
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
        'param_name' => 'border',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
       array( 
          'heading' => esc_html__( 'Border Style', 'nuno-builder' ),
          'param_name' => 'border_style',
          'type' => 'dropdown',
          'value'=>array(
                'solid' => esc_html__("Solid", 'nuno-builder') ,
                'dotted' => esc_html__('Dotted', 'nuno-builder') ,
                'dashed' => esc_html__('Dashed', 'nuno-builder') ,
                'double'  => esc_html__('Double', 'nuno-builder') ,
                'groove'  => esc_html__("Groove", 'nuno-builder') ,
                'outset'  => esc_html__("Outset", 'nuno-builder') ,
                'ridge'  => esc_html__("Ridge", 'nuno-builder') ,
                'inherit'  => esc_html__("Inherit", 'nuno-builder') ,
              ),
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),          
        ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          "description" => esc_html__("Select radius for border(in px or %).", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        )    
    )
);
?>
