<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.1
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_progress_bar extends BuilderElement{

    function preview($atts, $content = null){

      $atts['admin']= true;

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'title' =>'',
            'icon_type'=>'',
            'value' =>'',
            'procent'=>'100',
            'unit' =>'',
            'color' =>'',
            'label_color'=>'',
            'unit_color'=>'',
            'label_font_size'=>'',
            'unit_font_size'=>'',
            'value_color'=>'',
            'value_font_size'=>'',
            'height' =>'',
            'tip_style'=>'',
            'border_radius'=>'',
            'admin'=> false,
            'bg' =>'', 
            'el_id' => '',
            'el_class'=>'',
            'counto'=>''
        ), $atts,'el_progress_bar' ) );

        wp_enqueue_style( 'awesomeicon');
        wp_enqueue_script( 'jquery.appear', get_abuilder_dir_url() . 'js/jquery.appear.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'jquery.counto',get_abuilder_dir_url()."js/jquery.counto.min.js",array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'jquery.chart', get_abuilder_dir_url() . 'js/chart.js', array('jquery.appear','jquery.counto'), '1.3.3', false );


        $css_class=array('el_progress_bar');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if($tip_style !=''){ array_push($css_class, 'cap-style-'.$tip_style); }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }


        $procent = min(100, max(0 , absint($procent)));
        $bar_styles = $active_bar_styles = $label_styles = $unit_styles = $values_styles = array();

        if($color!=''){
          $active_bar_styles[] = 'background-color:'.$color;
        } 

        if($admin){
          $active_bar_styles[] = 'width:'.$procent.'%';
          $values_styles[] = 'left:'.esc_attr($procent).'%';
        } 

        if($bg!=''){
          $bar_styles[] = 'background-color:'.$bg;
        } 

        if($height!=''){
          $bar_styles[] = 'height:'.absint($height)."px";

            if($tip_style=='circle'){
              $bar_styles[] = 'border-radius:'.absint($height)."px";
              $active_bar_styles[] = 'border-radius:'.absint($height)."px";   
            }
            elseif($tip_style=='rounded' && $border_radius!=''){
              $radius =    strpos($border_radius, '%') ? intval($border_radius)."%" : intval($border_radius)."px;";

              $bar_styles[] = 'border-radius:'.$radius;
              $active_bar_styles[] = 'border-radius:'.$radius;   

            }
        } 


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




        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";

        if($title!='' || $icon_type!=''){
          $compile.="<label class=\"progress-bar-label\" ".(count($label_styles) ? 'style="'.implode(';', $label_styles).'"': '').">";
          
          if($icon_type!=''){
            $compile .= '<i class="btn-ico '.$icon_type.'"></i>';
          }

          if($title!=''){
            $compile.= esc_html($title);
          }

          $compile.="</label>";
        }
        
        if($unit!=''){
          $compile.="<span class=\"progress-bar-unit\" ".(count($unit_styles) ? ' style="'.join(';', $unit_styles).'"':'').">".esc_html($unit)."</span>";
        }

        $compile.="<div class=\"progress-bar-outer\" ".(count($bar_styles) ? 'style="'.implode(';', $bar_styles).'"': '').">";

        if($value!=''){
          $compile.="<span class=\"progress-bar-value\" ".(count($values_styles) ? 'style="'.implode(';', $values_styles).'"': '').">".esc_html($value)."</span>";
        }

        $compile.='<div class="progress-bar" data-percent="'.esc_attr($procent).'" data-counto="'.esc_attr($counto).'" '.(count($active_bar_styles) ? 'style="'.implode(';', $active_bar_styles).'"': '').'></div>';
        $compile.="</div>";
        $compile.="</div>";

        if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_progress_bar',
  array(
    'title'=>esc_html__('Progress Bar','nuno-builder'),
    'icon'=>'fa fa-tasks',
    'color'=>'#7a6f65',
    'order'=>9,
    'options'=>array(

        array( 
        'heading' => esc_html__( 'Title/Label', 'nuno-builder' ),
        'param_name' => 'title',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Use Icon', 'nuno-builder' ),
        'param_name' => 'icon_type',
        'class' => '',
        'default' =>'',
        'value'=>'',
        'description' => esc_html__( 'Select the icon to be displayed by clicking the icon.', 'nuno-builder' ),
        'type' => 'icon_picker',
         ),           array( 
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
        'heading' => esc_html__( 'Units', 'nuno-builder' ),
        'param_name' => 'unit',
        'value' => '',
        'param_holder_class' =>'small-wide',
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
        'heading' => esc_html__( 'Progress Bar', 'nuno-builder' ),
        'param_name' => 'progress_bar',
        'type' => 'heading',
        'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Bar Height', 'nuno-builder' ),
        'param_name' => 'height',
        'param_holder_class' =>'small-wide',
        'value' => '',
        'type' => 'textfield',
        'group'=>esc_html__('Styles', 'nuno-builder'),
         ),
        array( 
        'heading' => esc_html__( 'Cap Style', 'nuno-builder' ),
        'param_name' => 'tip_style',
        'type' => 'dropdown',
        'value' => array(
                  ''=>esc_html__('Square','nuno-builder'),
                  'circle'=>esc_html__('Circle','nuno-builder'),
                  'rounded'=>esc_html__('Rounded','nuno-builder'),
                  ),
        'group'=>esc_html__('Styles', 'nuno-builder')
        ),
        array( 
          'heading' => esc_html__( 'Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          "description" => esc_html__("Select custom radius for cap. Leave blank for default value.", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),
          'dependency' => array( 'element' => 'tip_style', 'value' => array( 'rounded' ) )       
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
        'heading' => esc_html__( 'Font Size', 'nuno-builder' ),
        'param_name' => 'label_font_size',
        'param_holder_class' =>'small-wide',
        'default' => "",
        'type' => 'textfield',
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
