<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();


class BuilderElement_el_btn extends BuilderElement {

    function preview($atts, $content = null) {

      $atts['url']="";

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = '') {

    extract( shortcode_atts( array(
      'url' => '',
      'target' => '',
      'icon_type'=>'',
      'size' => '',
      'style' => 'default',
      'skin' => '',
      'el_class'=>'',
      'text'=>'',
      'el_id'=>'',
      'align'=>'',
      'shape'=>'',
      'btn_text_color'=>'',
      'btn_bg_color'=>'',
      'btn_border_color'=>'',
      'btn_hover_text_color'=>'',
      'btn_hover_bg_color'=>'',
      'btn_hover_border_color'=>'',
      'btn_border_size'=>'',
      'btn_border_style'=>'',      
      'custom_radius'=>'',
      'letter_spacing'=>'',      
    ), $atts ,'el_btn'));

    $result="";
    $content= ($text=='' && $content!='') ? esc_html($content):$text;

    if($icon_type!=''){
      $content = '<i class="btn-ico '.$icon_type.'"></i>'.($content!='' ? '<span>'.$content.'</span>' : '');
    }

    $btn_class=array('btn');
    $css_class=array('el-btn');

    if(''!=$el_class){
        array_push($css_class, $el_class);
    }

     $css_style=getElementCssMargin($atts, true);

     if(''==$el_id){
            $el_id="element_".getElementTagID().time().rand(11,99);
     }

    if(!empty($shape)){
      $btn_class[]="shape-".trim($shape);

      if($shape == 'custom'  && $custom_radius!=''){
        $custom_radius=  strpos($custom_radius, '%') ? $custom_radius : (int)$custom_radius."px";
        add_page_css_style("#$el_id .btn.shape-custom{ border-radius:".$custom_radius."}");
      }
    }


    if($style =='custom-color' && (!empty($btn_text_color) || !empty($btn_bg_color) || !empty($btn_border_color) 
      || !empty($btn_hover_text_color) || !empty($btn_hover_bg_color) || !empty($btn_hover_border_color)
        )){

        $btn_style = $btn_hover_style = array();
        if(!empty($btn_text_color)){
          $btn_style['color'] = 'color:'.$btn_text_color;
        }

        if(!empty($btn_bg_color)){
          $btn_style['background-color'] = 'background-color:'.$btn_bg_color;
        }

        if(!empty($btn_border_color)){
          $btn_style['border-color'] = 'border-color:'.$btn_border_color;
        }

        if($btn_border_size!=''){
          $btn_style['border-width'] = 'border-width:'.((int)$btn_border_size)."px";
        }

        if(!empty($btn_border_style)){
          $btn_style['border-style'] = 'border-style:'.$btn_border_style;
        }


        if(count($btn_style)){
         add_page_css_style("#$el_id a.btn{".join(';',$btn_style)."}");
        }

        if(!empty($btn_hover_text_color)){
          $btn_hover_style['color'] = 'color:'.$btn_hover_text_color;
        }

        if(!empty($btn_hover_bg_color)){
          $btn_hover_style['background-color'] = 'background-color:'.$btn_hover_bg_color;
        }

        if(!empty($btn_hover_border_color)){
          $btn_hover_style['border-color'] = 'border-color:'.$btn_hover_border_color;
        }

        if(count($btn_hover_style)){
         add_page_css_style("#$el_id a:hover{".join(';',$btn_hover_style)."}");
        }

    }



    if(!empty($size)) $btn_class[]=$size;
    if(!empty($style)) $btn_class[]="btn-skin-".$style;
    if(!empty($align)) $css_class[]="align-".$align;

    $compile="<div ";

    if(''!=$el_id){
        $compile.="id=\"$el_id\" ";
    }

    if(!empty($letter_spacing)){
        $letter_spacing=(preg_match('/(px|pt|em)$/', $letter_spacing))?$letter_spacing:$letter_spacing."px";
        $css_style['letter-spacing']="letter-spacing:".$letter_spacing;
    }


    if(count($css_style)){
      add_page_css_style("#$el_id {".join('',$css_style)."}");
    }

    nuno_add_element_margin_style("#$el_id",$atts);
    
    $compile.="class=\"".@implode(" ",$css_class)."\">";
    $compile.= '<a '.(!empty($url)?"href=\"".esc_url($url)."\" ":"").'class="'.@implode(" ",$btn_class).'" target="'.esc_attr($target).'">'.$content.'</a>';
    $compile.='</div>';

    return $compile;

    }
}

add_builder_element('el_btn',
  array(
    'title'=> esc_html__('Button','nuno-builder'),
    'icon'=>'dashicons dashicons-megaphone',
    'color'=>'#f8b127',
    'order'=>5,
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
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
        ),
         array( 
          'heading' => esc_html__( 'Margin Top', 'nuno-builder' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Bottom', 'nuno-builder' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Left', 'nuno-builder' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Right', 'nuno-builder' ),
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
          'heading' => esc_html__('Button Text','nuno-builder'),
          'param_name' => 'text',
          'description' => esc_html__( 'Leave black if only use the icon.', 'nuno-builder' ),
          'admin_label'=>true,
          'type' => 'textfield',
        ),
        array( 
            'heading' => esc_html__( 'Use Icon', 'nuno-builder' ),
            'param_name' => 'icon_type',
            'class' => '',
            'default' =>'',
            'value'=>'',
            'description' => esc_html__( 'Select the icon to be displayed by clicking the icon.', 'nuno-builder' ),
            'type' => 'icon_picker',
         ),     
        array( 
          'heading' => esc_html__( 'Button URL', 'nuno-builder' ),
          'param_name' => 'url',
          'type' => 'textfield',
        ),
         array( 
          'heading' => esc_html__( 'Button Size', 'nuno-builder' ),
          'param_name' => 'size',
          'type' => 'dropdown',
          'value' => array(
                    'btn-lg'=>esc_html__('Large','nuno-builder'),
                    'btn-default'=>esc_html__('Default','nuno-builder'),
                    'btn-sm'=>esc_html__('Small','nuno-builder'),
                    'btn-xs'=>esc_html__('Extra small','nuno-builder')
                    ),
        ),
         array( 
          'heading' => esc_html__( 'Button Shape', 'nuno-builder' ),
          'param_name' => 'shape',
          'type' => 'radio',
          'value' => array(
                    'default'=>esc_html__('Default','nuno-builder'),
                    'square'=>esc_html__('Square','nuno-builder'),
                    'rounded'=>esc_html__('Rounded','nuno-builder'),
                    'custom'=>esc_html__('Custom','nuno-builder')
                    ),
        ),
        array( 
          'heading' => esc_html__( 'Letter Spacing', 'nuno-builder' ),
          'param_name' => 'letter_spacing',
          'class'=>'small',
          'type' => 'textfield',
          'description' => esc_html__( 'The spacing each character. in px,pt,em.', 'nuno-builder' ),
        ),
        array( 
          'heading' => esc_html__( 'Button Radius', 'nuno-builder' ),
          'param_name' => 'custom_radius',
          'class' => 'small',
          'type' => 'textfield',
          "description" => esc_html__("Type radius in pixel/procent.", "nuno-builder"),
          'dependency' => array( 'element' => 'shape', 'value' => array('custom') )   
        ),
        array( 
          'heading' => esc_html__( 'Button Skin Color', 'nuno-builder' ),
          'param_name' => 'style',
          'type' => 'dropdown',
          'value' => array(
                    'default'=>esc_html__('Default','nuno-builder'),
                    'custom-color'=>esc_html__('Custom Color','nuno-builder')
                    ),
        ),
        array( 
          'heading' => esc_html__( 'Text Color', 'nuno-builder' ),
          'param_name' => 'btn_text_color',
          'class' => 'small',
          'type' => 'colorpicker',
          "description" => esc_html__("Pick a color for button text color.", "nuno-builder"),
          'dependency' => array( 'element' => 'style', 'value' => array('custom-color') )   
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'btn_bg_color',
          'class' => 'small',
          'type' => 'colorpicker',
          "description" => esc_html__("Pick a color for button background color.", "nuno-builder"),
          'dependency' => array( 'element' => 'style', 'value' => array('custom-color') )   
        ),
        array( 
          'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
          'param_name' => 'btn_border_color',
          'class' => 'small',
          'type' => 'colorpicker',
          "description" => esc_html__("Pick a color for button border color.", "nuno-builder"),
          'dependency' => array( 'element' => 'style', 'value' => array('custom-color') )   
        ),
        array( 
          'heading' => esc_html__( 'Border Size', 'nuno-builder' ),
          'param_name' => 'btn_border_size',
          'class' => 'medium',
          'params' => array('min'=>0,'max'=>10,'step'=>1),
          'type' => 'slider_value',
          "description" => esc_html__("Adjust border width.", "nuno-builder"),
          'dependency' => array( 'element' => 'style', 'value' => array('custom-color') )   
        ),
        array( 
          'heading' => esc_html__( 'Border Style', 'nuno-builder' ),
          'param_name' => 'btn_border_style',
          'type' => 'dropdown',
          'value' => array(
                      ''=>esc_html__('Default','nuno-builder'),
                      'solid'=>esc_html__('Solid','nuno-builder'),
                      'dotted'=>esc_html__('Dotted','nuno-builder'),
                      'double'=>esc_html__('Double','nuno-builder'),
                      'dashed'=>esc_html__('Dashed','nuno-builder'),
                    ),
        ),
        array( 
          'heading' => esc_html__( 'Shadow', 'nuno-builder' ),
          'param_name' => 'btn-shadow',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
          'param_name' => 'b_h_shadow',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
          'param_name' => 'b_v_shadow',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Blur', 'nuno-builder' ),
          'param_name' => 'b_blur_shadow',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Spread', 'nuno-builder' ),
          'param_name' => 'b_spread_shadow',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Shadow Color', 'nuno-builder'),
          "param_name" => "b_shadow_color",
          "description" => esc_html__("Select color for shadow", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Hover Text Color', 'nuno-builder' ),
          'param_name' => 'btn_hover_text_color',
          'class' => 'small',
          'type' => 'colorpicker',
          "description" => esc_html__("Pick a color for button hover text color.", "nuno-builder"),
          'dependency' => array( 'element' => 'style', 'value' => array('custom-color') )   
        ),
        array( 
          'heading' => esc_html__( 'Hover Background Color', 'nuno-builder' ),
          'param_name' => 'btn_hover_bg_color',
          'class' => 'small',
          'type' => 'colorpicker',
          "description" => esc_html__("Pick a color for button hover background color.", "nuno-builder"),
          'dependency' => array( 'element' => 'style', 'value' => array('custom-color') )   
        ),
        array( 
          'heading' => esc_html__( 'Hover Border Color', 'nuno-builder' ),
          'param_name' => 'btn_hover_border_color',
          'class' => 'small',
          'type' => 'colorpicker',
          "description" => esc_html__("Pick a color for button hover border color.", "nuno-builder"),
          'dependency' => array( 'element' => 'style', 'value' => array('custom-color') )   
        ),
         array( 
          'heading' => esc_html__( 'Button Align', 'nuno-builder' ),
          'param_name' => 'align',
          'type' => 'dropdown',
          'value' => array(
                    'default'=>esc_html__('Default','nuno-builder'),
                    'left'=>esc_html__('Left','nuno-builder'),
                    'center'=>esc_html__('Center','nuno-builder'),
                    'right'=>esc_html__('Right','nuno-builder'),
                    'wide'=>esc_html__('Wide','nuno-builder'),
                    ),
        ),
        array( 
          'heading' => esc_html__( 'Button Target', 'nuno-builder' ),
          'param_name' => 'target',
          'type' => 'dropdown',
          'value'=>array(
              '_self'=>esc_html__('Self','nuno-builder'),
              '_blank'=>esc_html__('Blank','nuno-builder')
            )
        ),
        )
    )
);
?>
