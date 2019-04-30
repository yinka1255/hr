<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_icon extends BuilderElement{

    function preview($atts, $content = null, $base = ''){


        $content = $this->render($atts,$content);
        return $content;

    }

    function render($atts, $content = null, $base="") {

        wp_enqueue_style( 'awesomeicon');

        extract( shortcode_atts( array(
            'el_class'=>'',
            'el_id'=>'',
            'button_link' => '',
            'button_text' => '',
            'icon_type' => '',
            'target' => '_blank',
            'link' => '',
            'align'=>'',
            'icon_size'=>'',
            'icon_color'=>'',
            'borderwidth'=>'',
            'icon_shape'=>'',
            'box_size'=>'',
            'border_radius'=>'',
            'icon_color_hover'=>'',
            'bgcolor_hover'=>'',
            'border_color_hover'=>'',
            'shadow_color_hover'=>'',
            'h_shadow_hover'=>'',
            'v_shadow_hover'=>'',
            'spread_shadow_hover'=>'',
            'blur_shadow_hover'=>'',
            'shadow_color_hover'=>'',
            'shadow_color_hover'=>'',
        ), $atts,'el_icon' ) );

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

       $css_class=array('el-icon', 'icon-shape-'.$icon_shape );

        if(''!=$el_class){
           array_push($css_class, $el_class);
        }

        if(!empty($align)) {
            $css_class[]="align-".$align;
        }

        if(''!=$border_radius && $icon_shape=='rounded'){
          $atts['br_top_right'] = $atts['br_bottom_right'] = $atts['br_bottom_left'] = $atts['br_top_left'] = $border_radius;
        }

        $atts['b_top'] = $atts['b_bottom'] = $atts['b_left'] = $atts['b_right'] = $borderwidth;

        $box_icons_style=getElementCssMargin($atts, true);
        $icons_style=array();


        if($icon_color!=''){
            $box_icons_style['color'] = 'color:'.$icon_color;
        }

        if($icon_size!=''){
           $box_icons_style['font-size'] = 'font-size:'.$icon_size.'px';
        }

        if($box_size!=''){
             $icons_style['width'] = 'width:'.$box_size.'em';
             $icons_style['height'] = 'height:'.$box_size.'em';
             $box_icons_style['line-height'] = 'line-height:'.$box_size.'em';
         }

        $icons_hover_style = array();


       if($icon_color_hover!=''){
            $icons_hover_style[] = 'color:'.$icon_color_hover.'!important';
        }

        if($bgcolor_hover!=''){
           $icons_hover_style[] = 'background-color:'.$bgcolor_hover.'!important';          
        }

        if($border_color_hover!=''){
          $icons_hover_style['border-color']="border-color:".$border_color_hover;
        }

        if($shadow_color_hover!='' && ($h_shadow_hover!='' || $v_shadow_hover!='' || $spread_shadow_hover!='' || $blur_shadow_hover!='')){

          $h_shadow_hover = absint($h_shadow_hover);
          $v_shadow_hover = absint($v_shadow_hover);
          $blur_shadow_hover = absint($blur_shadow_hover);
          $spread_shadow_hover = absint($spread_shadow_hover);

          $icons_hover_style['box-shadow']="box-shadow:".$h_shadow_hover."px ".$v_shadow_hover."px ".$blur_shadow_hover."px ".$spread_shadow_hover."px ".$shadow_color_hover."!important";

        }


       $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";

        if(strlen($link)>0){
          $compile.= "<a target='".$target."' href='".esc_url($link)."'>";
        }

        $compile.= '<span class="icon-wrap"'.(count($box_icons_style) ? 'style="'.join(';',$box_icons_style).'" ':'').'><i class="'.esc_attr($icon_type).'"'.(count($icons_style) ? ' style="'.join(';',$icons_style).'" ':'').'></i>'.($content!='' ? '<span>'.esc_html($content).'</span>':'').'</span>';

        if(strlen($link)>0){

          $compile .="</a>";
        }

        $compile.="</div>";


        if(count($icons_hover_style)){
            add_page_css_style("#".$el_id.":hover .icon-wrap{".join(';', $icons_hover_style)."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

class BuilderElement_el_icongroup extends BuilderElement{

    function render($atts, $content = null, $base="") {

        extract( shortcode_atts( array(
            'el_class'=>'',
            'el_id'=>'',
            'layout'=>'center',
            'icon_size'=>'',
            'box_size'=>'',
            'icon_shape'=>'',
            'box_gap'=>'',
            'icon_color'=>'',
            'border_radius'=>'',
            'icon_bgcolor'=>'',
            'icon_border_color'=>'',
            'icon_border_style'=>'',
            'icon_borderwidth'=>'',
            'icon_h_shadow'=>'',
            'icon_v_shadow'=>'',
            'icon_blur_shadow'=>'',
            'icon_spread_shadow'=>'',
            'icon_shadow_color'=>'',
            'icon_color_hover'=>'',
            'bgcolor_hover'=>'',
            'border_color_hover'=>'',
            'h_shadow_hover'=>'',
            'v_shadow_hover'=>'',
            'blur_shadow_hover'=>'',
            'spread_shadow_hover'=>'',
            'shadow_color_hover'=>'',
            'spy'=>'none',
            'scroll_delay'=>300
        ), $atts,'el_icongroup' ) );

        $content=(empty($content) && !empty($iconbox_text))?$iconbox_text:$content;

        $pattern = get_shortcode_regex(array('el_icon'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
                return "";

         $scollspy="";

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $css_class=array('module-icongroup','group-align-'.$layout);

        if(''!=$el_class){
           array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if('none'!==$spy && !empty($spy)){

            $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}"';

        }


        $general_params = array();
        if($icon_size){ $general_params['icon_size'] = $icon_size;}
        if($box_size){ $general_params['box_size'] = $box_size;}
        if($icon_shape){ $general_params['icon_shape'] = $icon_shape;}
        if($icon_color){ $general_params['icon_color'] = $icon_color;}
        if($icon_bgcolor){ $general_params['bgcolor'] = $icon_bgcolor;}
        if($border_radius){ $general_params['border_radius'] = $border_radius;}
        if($icon_border_color){ $general_params['border_color'] = $icon_border_color;}
        if($icon_border_style){ $general_params['border_style'] = $icon_border_style;}
        if($icon_borderwidth){ $general_params['borderwidth'] = $icon_borderwidth;}

        if($icon_h_shadow){ $general_params['h_shadow'] = $icon_h_shadow;}
        if($icon_v_shadow){ $general_params['v_shadow'] = $icon_v_shadow;}
        if($icon_blur_shadow){ $general_params['blur_shadow'] = $icon_blur_shadow;}
        if($icon_spread_shadow){ $general_params['spread_shadow'] = $icon_spread_shadow;}
        if($icon_shadow_color){ $general_params['shadow_color'] = $icon_shadow_color;}

        if($icon_color_hover){ $general_params['icon_color_hover'] = $icon_color_hover;}
        if($bgcolor_hover){ $general_params['bgcolor_hover'] = $bgcolor_hover;}
        if($border_color_hover){ $general_params['border_color_hover'] = $border_color_hover;}
        if($h_shadow_hover){ $general_params['h_shadow_hover'] = $h_shadow_hover;}
        if($v_shadow_hover){ $general_params['v_shadow_hover'] = $v_shadow_hover;}
        if($blur_shadow_hover){ $general_params['blur_shadow_hover'] = $blur_shadow_hover;}
        if($spread_shadow_hover){ $general_params['spread_shadow_hover'] = $spread_shadow_hover;}
        if($shadow_color_hover){ $general_params['shadow_color_hover'] = $shadow_color_hover;}
        if($box_gap!=''){$general_params['m_left'] = $general_params['m_right'] = absint($box_gap)/2;}

       $output='<div class="icons">';

       $i = 1;
       $num_childs = count($matches);

        foreach ($matches as $list) {

            if($i==1 && isset($general_params['m_left'])){
                $general_params['m_left'] = 0;
            }

            if($i == $num_childs && isset($general_params['m_right'])){
                $general_params['m_right'] = 0;
            }

            $icon_params = array_merge($general_params, shortcode_parse_atts($list[3]));

            $shortcode = '[el_icon  ';

            foreach($icon_params as $k => $v){
              $shortcode.=' '.$k.'="'.$v.'"';
            }

            $shortcode.=']'.$list[5].'[/el_icon]';
            $output.=do_shortcode($shortcode);

            $i++;

        }

       $output .= '</div>';

       $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\" ".$scollspy.">";
        $compile.=$output."</div>";

        if(""!=$css_style){
            add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_icongroup',
  array(
    'title'=> esc_html__( 'Icon Group', 'nuno-builder' ),
    'description' => esc_html__( 'Grouping several icon element.', 'nuno-builder' ),
    'icon'=>'dashicons dashicons-layout',
    'as_parent' => 'el_icon',
    'order'=>10,
    'options'=>array(
                array( 
                    'heading' => esc_html__( 'Icon Size', 'nuno-builder' ),
                    'param_name' => 'icon_size',
                    'class' => 'medium',
                    'type' => 'slider_value',
                    'default' => "",
                    'params'=>array('min'=>10,'max'=>'1000','step'=>1),
                 ),     
                array( 
                    'heading' => esc_html__( 'Box Scale', 'nuno-builder' ),
                    'param_name' => 'box_size',
                    'class' => 'medium',
                    'description' => esc_html__( 'Box size ratio compared with icon size.', 'nuno-builder' ),
                    'type' => 'slider_value',
                    'default' => "",
                    'params'=>array('min'=>1,'max'=>'5','step'=>0.1),
                 ),     
                array( 
                    'heading' => esc_html__( 'Box Gap', 'nuno-builder' ),
                    'param_name' => 'box_gap',
                    'class' => 'medium',
                    'description' => esc_html__( 'Space between each icon in px (pixel).', 'nuno-builder' ),
                    'type' => 'slider_value',
                    'default' => "",
                    'params'=>array('min'=>0,'max'=>'50','step'=>1),
                 ),     
                array( 
                  'heading' => esc_html__( 'Icon Shape', 'nuno-builder' ),
                  'param_name' => 'icon_shape',
                  'type' => 'radio',
                  'value' => array(
                            'default'=>esc_html__('Default','nuno-builder'),
                            'rounded' => esc_html__('Rounded','nuno-builder'),
                            'circle'=>esc_html__('Circle','nuno-builder'),
                            ),
                  ),
                array( 
                  'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
                  'param_name' => 'border_radius',
                  'param_holder_class'=>'small-wide',
                  'type' => 'textfield',
                  "description" => esc_html__("Select radius for border(in px or %).", "nuno-builder"),
                  'dependency' => array( 'element' => 'icon_shape', 'value' => array( 'rounded' ) )       
                ),
                 array( 
                  'heading' => esc_html__( 'Align', 'nuno-builder' ),
                  'param_name' => 'layout',
                  'type' => 'dropdown',
                  'value' => array(
                            'center'=>esc_html__('Centered','nuno-builder'),
                            'left'=>esc_html__('Align Left','nuno-builder'),
                            'right'=>esc_html__('Align Right','nuno-builder'),
                            ),
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

                array( 
                    'heading' => esc_html__( 'Color', 'nuno-builder' ),
                    'param_name' => 'icon_color',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
                    'param_name' => 'icon_bgcolor',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
                    'param_name' => 'icon_border_color',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                 ),
                array( 
                  'heading' => esc_html__( 'Border Style', 'nuno-builder' ),
                  'param_name' => 'icon_border_style',
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
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
                  'param_name' => 'icon_borderwidth',
                  'description' => esc_html__( 'Border width in px.', 'nuno-builder' ),
                  'class'=>'small',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Shadow', 'nuno-builder' ),
                  'param_name' => 'icon-shadow',
                  'type' => 'heading',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
                  'param_name' => 'icon_h_shadow',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
                  'param_name' => 'icon_v_shadow',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Blur', 'nuno-builder' ),
                  'param_name' => 'icon_blur_shadow',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Spread', 'nuno-builder' ),
                  'param_name' => 'icon_spread_shadow',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Shadow Color', 'nuno-builder'),
                  "param_name" => "icon_shadow_color",
                  "description" => esc_html__("Select color for shadow", "nuno-builder"),
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Mouse Hover', 'nuno-builder' ),
                  'param_name' => 'mouse-hover',
                  'type' => 'heading',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                    'heading' => esc_html__( 'Color', 'nuno-builder' ),
                    'param_name' => 'icon_color_hover',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
                    'param_name' => 'bgcolor_hover',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                 ),
                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Border Color', 'nuno-builder'),
                  "param_name" => "border_color_hover",
                  "description" => esc_html__("Select color for border", "nuno-builder"),
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
                  'param_name' => 'h_shadow_hover',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
                  'param_name' => 'v_shadow_hover',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Blur', 'nuno-builder' ),
                  'param_name' => 'blur_shadow_hover',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Shadow Spread', 'nuno-builder' ),
                  'param_name' => 'spread_shadow_hover',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
                ),
                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Shadow Color', 'nuno-builder'),
                  "param_name" => "shadow_color_hover",
                  "description" => esc_html__("Select color for shadow", "nuno-builder"),
                  'group'=>esc_html__('Icon Styles', 'nuno-builder'),
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

add_builder_element('el_icon',
  array(
    'title'=> esc_html__( 'Icon Link', 'nuno-builder' ),
    'description' => esc_html__( 'Icon link', 'nuno-builder' ),
    'color'=>'#3a2d23',
    'icon'=>'dashicons dashicons-format-links',
    'order'=>11,
    'options'=>array(

                array( 
                    'heading' => esc_html__( 'Icon', 'nuno-builder' ),
                    'param_name' => 'icon_type',
                    'class' => '',
                    'value'=>'',
                    'default' => '',
                    'description' => esc_html__( 'Select the icon to be displayed by clicking the icon.', 'nuno-builder' ),
                    'type' => 'icon_picker',
                 ),     
                 array( 
                    'heading' => esc_html__('Text Label','nuno-builder'),
                    'param_name' => 'content',
                    'admin_label'=>true,
                    'class'=>'medium',
                    'default' => '',
                    'description' => esc_html__( 'Leave blank if want just show icon.', 'nuno-builder' ),
                    'type' => 'textfield',
                  ),
                array( 
                    'heading' => esc_html__( 'Icon Size', 'nuno-builder' ),
                    'param_name' => 'icon_size',
                    'class' => '',
                    'type' => 'slider_value',
                    'class'=>'medium',
                    'default' => "",
                    'params'=>array('min'=>10,'max'=>'100','step'=>1),
                 ),     
                array( 
                    'heading' => esc_html__( 'Box Scale', 'nuno-builder' ),
                    'param_name' => 'box_size',
                    'class' => 'medium',
                    'description' => esc_html__( 'Box size ratio compared with icon size.', 'nuno-builder' ),
                    'type' => 'slider_value',
                    'default' => "",
                    'params'=>array('min'=>1,'max'=>'5','step'=>0.1),
                 ),     
                array( 
                  'heading' => esc_html__( 'Align', 'nuno-builder' ),
                  'param_name' => 'align',
                  'type' => 'radio',
                  'value' => array(
                                ''=>esc_html__('Default','nuno-builder'),
                                'left'=>esc_html__('Left','nuno-builder'),
                                'center'=>esc_html__('Center','nuno-builder'),
                                'right'=>esc_html__('Right','nuno-builder'),
                            ),
                  ),
                array( 
                  'heading' => esc_html__( 'Icon Shape', 'nuno-builder' ),
                  'param_name' => 'icon_shape',
                  'type' => 'radio',
                  'value' => array(
                            'default'=>esc_html__('Default','nuno-builder'),
                            'rounded' => esc_html__('Rounded','nuno-builder'),
                            'circle'=>esc_html__('Circle','nuno-builder'),
                            ),
                  ),
                array( 
                  'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
                  'param_name' => 'border_radius',
                  'param_holder_class'=>'small-wide',
                  'type' => 'textfield',
                  "description" => esc_html__("Select radius for border(in px or %).", "nuno-builder"),
                  'dependency' => array( 'element' => 'icon_shape', 'value' => array( 'rounded' ) )       
                ),
                array( 
                    'heading' => esc_html__( 'Link', 'nuno-builder' ),
                    'param_name' => 'link',
                    'class' => '',
                    'value' => '',
                    'type' => 'textfield',
                 ),         
                array( 
                    'heading' => esc_html__( 'Target', 'nuno-builder' ),
                    'param_name' => 'target',
                    'class' => '',
                    'value' => array("_blank" => esc_html__("Blank",'nuno-builder'), "_self" => esc_html__("Self","nuno-builder") ),
                    'description' => esc_html__( 'Link Target', 'nuno-builder' ),
                    'type' => 'dropdown',
                 ),
                array( 
                    'heading' => esc_html__( 'Color', 'nuno-builder' ),
                    'param_name' => 'icon_color',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Styles', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
                    'param_name' => 'bgcolor',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Styles', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
                    'param_name' => 'border_color',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Styles', 'nuno-builder'),
                 ),
                array( 
                  'heading' => esc_html__( 'Border Style', 'nuno-builder' ),
                  'param_name' => 'border_style',
                  'type' => 'dropdown',
                  'value'=>array(
                        '' => esc_html__("Default", 'nuno-builder') ,
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
                  'param_name' => 'borderwidth',
                  'description' => esc_html__( 'Border width in px.', 'nuno-builder' ),
                  'class'=>'small',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Shadow', 'nuno-builder' ),
                  'param_name' => 'icon-shadow',
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
                  'param_name' => 'h_shadow',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
                  'param_name' => 'v_shadow',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Blur', 'nuno-builder' ),
                  'param_name' => 'blur_shadow',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Spread', 'nuno-builder' ),
                  'param_name' => 'spread_shadow',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Shadow Color', 'nuno-builder'),
                  "param_name" => "shadow_color",
                  "description" => esc_html__("Select color for shadow", "nuno-builder"),
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
/* box hover */
                array( 
                    'heading' => esc_html__( 'Color', 'nuno-builder' ),
                    'param_name' => 'icon_color_hover',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
                    'param_name' => 'bgcolor_hover',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                 ),
                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Border Color', 'nuno-builder'),
                  "param_name" => "border_color_hover",
                  "description" => esc_html__("Select color for border", "nuno-builder"),
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Shadow', 'nuno-builder' ),
                  'param_name' => 'box-shadow-hover',
                  'type' => 'heading',
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
                  'param_name' => 'h_shadow_hover',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
                  'param_name' => 'v_shadow_hover',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Blur', 'nuno-builder' ),
                  'param_name' => 'blur_shadow_hover',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Spread', 'nuno-builder' ),
                  'param_name' => 'spread_shadow_hover',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Shadow Color', 'nuno-builder'),
                  "param_name" => "shadow_color_hover",
                  "description" => esc_html__("Select color for shadow", "nuno-builder"),
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
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
    )
);

?>
