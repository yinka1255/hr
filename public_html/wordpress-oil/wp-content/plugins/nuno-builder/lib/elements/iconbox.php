<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_iconbox extends BuilderElement{

    function preview($atts, $content = null, $base = ''){

        $content = $this->render($atts,$content);
        return $content;
    }

    function render($atts, $content = null, $base="") {

        wp_enqueue_style( 'awesomeicon');

        extract( shortcode_atts( array(
            'el_class'=>'',
            'el_id'=>'',
            'iconbox_heading' => '',
            'layout'=>'',
            'content_align'=>'',
            'text_align'=>'',
            'color_heading'=>'',
            'heading_align'=>'',
            'icon_type' => '',
            'target' => '_blank',
            'iconbox_text'=>'',
            'link' => '',
            'label_link'=>'',
            'spy'=>'none',
            'icon_size'=>'',
            'icon_color'=>'',
            'icon_shape'=>'',
            'icon_bgcolor'=>'',
            'icon_width'=>'',
            'icon_height'=>'',
            'font_weight'=>'',
            'bg_color'=>'',
            'color_heading_hover'=>'',
            'icon_color_hover'=>'',
            'icon_bgcolor_hover'=>'',
            'bg_color_hover'=>'',
            'border_color_hover'=>'',
            'h_shadow_hover'=>'',
            'v_shadow_hover'=>'',
            'blur_shadow_hover'=>'',
            'spread_shadow_hover'=>'',
            'shadow_color_hover'=>'',
            'fit_row'=>'',
            'scroll_delay'=>300
        ), $atts,'el_iconbox' ) );

        $content=(empty($content) && !empty($iconbox_text))?$iconbox_text:$content;


         $scollspy="";

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $css_class=array('module-iconboxes','style-'.$layout);

        if($content_align!=''){
          array_push($css_class, 'content-align-'.sanitize_html_class($content_align));
        }

        if($heading_align!=''){
          array_push($css_class, 'heading-align-'.sanitize_html_class($heading_align));
        }

        if($text_align!=''){
          array_push($css_class, 'text-align-'.sanitize_html_class($text_align));
        }

        if($fit_row!=''){
          array_push($css_class, 'fit-row');
        }

        if(''!=$el_class){
           array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts, true);

        if($bg_color!=''){
          $css_style[]='background-color:'.$bg_color;
        }

        if('none'!==$spy && !empty($spy)){

            $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}"';
            get_scroll_spy_script();
        }

        $icons_style= $icons_hover_style = $heading_style = $hover_box = array();

        if($icon_color!=''){
            $icons_style[] = 'color:'.$icon_color.';';
        }

        if($icon_size!=''){
           $icons_style[] = 'font-size:'.$icon_size.'px;';
        }

        if($icon_width!=''){
           $icons_style[] = 'width:'.absint($icon_width).'px;';
        }

        if($icon_height!=''){
           $icons_style[] = 'height:'.absint($icon_height).'px;';
        }

        if($icon_bgcolor!=''){
           $icons_style[] = 'background:'.$icon_bgcolor;          
        }

        if($icon_shape == 'circle'){
           $icons_style[] = 'border-radius: 50%';                    
        }

        if(!empty($color_heading)){
            $heading_style['color']="color:".$color_heading;
        }


        if(!empty($font_weight) && $font_weight!='default'){
            $heading_style['font-weight']="font-weight:".$font_weight;
        }


        $output='<div class="iconboxes-wrap" '. $scollspy.'>';
        $output.='<span class="box">'.((strlen($link)>0) ?"<a target='".$target."' href='".esc_url($link)."'>":"").'<i '.(count($icons_style)? ' style="'.join(';',$icons_style).'"':"").' class="'.esc_attr($icon_type).'">&nbsp;</i>'.((strlen($link)>0) ?"</a>":"").'</span>';
        $output.='<div class="text-wrap">';
        
        if($iconbox_heading!=''){
            $output.='<h4 class="box-heading" '.(count($heading_style)? 'style="'.join(';',$heading_style).'"':'').'>'.$iconbox_heading.'</h4>';
        }
        
        $output.='<div class="iconboxes-text">'.((!empty($content))?do_shortcode($content):"");

        if($label_link!='' && strlen($link)>0 ){
            $output.= '<a target="'.$target.'" href="'.esc_url($link).'" class="more-link">'.esc_html($label_link).'</a>';
        }

        $output.='</div></div></div>';


       $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=$output."</div>";

       if($icon_color_hover!=''){
            $icons_hover_style[] = 'color:'.$icon_color_hover.'!important';
        }

        if($icon_bgcolor_hover!=''){
           $icons_hover_style[] = 'background-color:'.$icon_bgcolor_hover.'!important';          
        }

        if($border_color_hover!=''){
          $hover_box['border-color']="border-color:".$border_color_hover;
        }

        if($bg_color_hover!=''){
          $hover_box['background-color']="background-color:".$bg_color_hover;
        }

        if($shadow_color_hover!='' && ($h_shadow_hover!='' || $v_shadow_hover!='' || $spread_shadow_hover!='' || $blur_shadow_hover!='')){

          $h_shadow_hover = absint($h_shadow_hover);
          $v_shadow_hover = absint($v_shadow_hover);
          $blur_shadow_hover = absint($blur_shadow_hover);
          $spread_shadow_hover = absint($spread_shadow_hover);

          $hover_box['box-shadow']="box-shadow:".$h_shadow_hover."px ".$v_shadow_hover."px ".$blur_shadow_hover."px ".$spread_shadow_hover."px ".$shadow_color_hover.";";

        }

        if($color_heading_hover!=''){
            add_page_css_style("#$el_id:hover .box-heading{color:".$color_heading_hover."!important;}");
        }

        if(count($icons_hover_style)){
            add_page_css_style("#$el_id:hover .box i{".join(';',$icons_hover_style).";}");
        }

        if(count($css_style)){
            add_page_css_style("#$el_id {".join(';',$css_style).";}");
        }

        if(count($hover_box)){
          add_page_css_style("#$el_id:hover {".join(';',$hover_box).";}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_iconbox',
  array(
    'title'=> esc_html__( 'Icon Box', 'nuno-builder' ),
    'description' => esc_html__( 'Icon box and description here', 'nuno-builder' ),
    'icon'=>'dashicons dashicons-exerpt-view',
    'color'=>'#574434',
    'order'=>9,
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
                  'heading' => esc_html__( 'Layout', 'nuno-builder' ),
                  'param_name' => 'layout',
                  'type' => 'dropdown',
                  'value' => array(
                            '1'=>esc_html__('Icon Top','nuno-builder'),
                            '2'=>esc_html__('Icon Align Left','nuno-builder'),
                            '3'=>esc_html__('Icon Align Right','nuno-builder'),
                            ),
                ),
                array( 
                  'heading' => esc_html__( 'Align', 'nuno-builder' ),
                  'param_name' => 'content_align',
                  'type' => 'radio',
                  'value' => array(
                            ''=>esc_html__('Default','nuno-builder'),
                            'center'=>esc_html__('Center','nuno-builder'),
                            'left'=>esc_html__('Left','nuno-builder'),
                            'right'=>esc_html__('Right','nuno-builder'),
                            ),
                ),        
                array( 
                    'heading' => esc_html__( 'Icon', 'nuno-builder' ),
                    'param_name' => 'icon_type',
                    'class' => '',
                    'default' =>'',
                    'value'=>'',
                    'description' => esc_html__( 'Select the icon to be displayed by clicking the icon.', 'nuno-builder' ),
                    'type' => 'icon_picker',
                 ),     
                array( 
                    'heading' => esc_html__( 'Icon Size', 'nuno-builder' ),
                    'param_name' => 'icon_size',
                    'class' => '',
                    'type' => 'slider_value',
                    'default' => "",
                    'params'=>array('min'=>10,'max'=>'100','step'=>1),
                 ),     
                array( 
                  'heading' => esc_html__( 'Box Width', 'nuno-builder' ),
                  'param_name' => 'icon_width',
                  'param_holder_class'=>'m_right',
                  'type' => 'textfield',
                ),
                array( 
                  'heading' => esc_html__( 'Box Height', 'nuno-builder' ),
                  'param_name' => 'icon_height',
                  'param_holder_class'=>'m_right',
                  'type' => 'textfield',
                ),
                array( 
                  'heading' => esc_html__( 'Box Shape', 'nuno-builder' ),
                  'param_name' => 'icon_shape',
                  'type' => 'radio',
                  'value' => array(
                            'default'=>esc_html__('Default','nuno-builder'),
                            'square'=>esc_html__('Square','nuno-builder'),
                            'circle'=>esc_html__('Rounded','nuno-builder'),
                            ),
                ),
                array( 
                    'heading' => esc_html__( 'Heading', 'nuno-builder' ),
                    'param_name' => 'iconbox_heading',
                    'class' => '',
                    'value' => '',
                    'type' => 'textfield',
                 ),         
                array( 
                  'heading' => esc_html__( 'Heading Align', 'nuno-builder' ),
                  'param_name' => 'heading_align',
                  'type' => 'radio',
                  'value' => array(
                            ''=>esc_html__('Default','nuno-builder'),
                            'center'=>esc_html__('Center','nuno-builder'),
                            'left'=>esc_html__('Left','nuno-builder'),
                            'right'=>esc_html__('Right','nuno-builder'),
                            ),
                ),        
                array( 
                    'heading' => esc_html__( 'Text', 'nuno-builder' ),
                    'param_name' => 'content',
                    'class' => '',
                    'value' => '',
                    'default'=>esc_html__("I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'nuno-builder'),
                    'type' => 'textarea_html'
                 ),
                array( 
                  'heading' => esc_html__( 'Text Align', 'nuno-builder' ),
                  'param_name' => 'text_align',
                  'type' => 'radio',
                  'value' => array(
                            ''=>esc_html__('Default','nuno-builder'),
                            'center'=>esc_html__('Center','nuno-builder'),
                            'left'=>esc_html__('Left','nuno-builder'),
                            'right'=>esc_html__('Right','nuno-builder'),
                            'justify'=>esc_html__('Justify','nuno-builder'),
                            ),
                ),        
                array( 
                    'heading' => esc_html__( 'Link', 'nuno-builder' ),
                    'param_name' => 'link',
                    'class' => '',
                    'value' => '',
                    'type' => 'textfield',
                 ),         
                array( 
                    'heading' => esc_html__( 'Text Link', 'nuno-builder' ),
                    'param_name' => 'label_link',
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
                'heading' => esc_html__( 'Heading Font Weight', 'nuno-builder' ),
                'param_name' => 'font_weight',
                'default' => "default",
                'value'=>array(
                      'default' => esc_html__('Default','nuno-builder'),
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
                      ),
                'group'=>esc_html__('Styles', 'nuno-builder'),
                'type' => 'dropdown'
                 ),
                array( 
                    'heading' => esc_html__( 'Heading Color', 'nuno-builder' ),
                    'param_name' => 'color_heading',
                    'class' => '',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Styles', 'nuno-builder'),
                 ), 
                array( 
                    'heading' => esc_html__( 'Icon Color', 'nuno-builder' ),
                    'param_name' => 'icon_color',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Styles', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Icon Background Color', 'nuno-builder' ),
                    'param_name' => 'icon_bgcolor',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Styles', 'nuno-builder'),
                 ),
                array( 
                  'heading' => esc_html__( 'Box', 'nuno-builder' ),
                  'description' => esc_html__( 'Box style.', 'nuno-builder' ),
                  'param_name' => 'box_style',
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Box Height', 'nuno-builder' ),
                  'param_name' => 'fit_row',
                  'value' => array(''=>esc_html__('Default','nuno-builder'),'1'=>esc_html__('Fit row','nuno-builder')),
                  'type' => 'radio',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                  'default'=>''
                 ),
                array( 
                  'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
                  'param_name' => 'bg_color',
                  'type' => 'colorpicker',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Padding', 'nuno-builder' ),
                  'param_name' => 'padding',
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                 ), 
                array( 
                  'heading' => esc_html__( 'Top', 'nuno-builder' ),
                  'param_name' => 'p_top',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
                  'param_name' => 'p_bottom',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Left', 'nuno-builder' ),
                  'param_name' => 'p_left',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Right', 'nuno-builder' ),
                  'param_name' => 'p_right',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Padding Mobile', 'nuno-builder' ),
                  'description' => esc_html__( 'This optional for screen up to 480px.', 'nuno-builder' ),
                  'param_name' => 'padding_mobile',
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Top', 'nuno-builder' ),
                  'param_name' => 'p_xs_top',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
                  'param_name' => 'p_xs_bottom',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Left', 'nuno-builder' ),
                  'param_name' => 'p_xs_left',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Right', 'nuno-builder' ),
                  'param_name' => 'p_xs_right',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Padding Tablet', 'nuno-builder' ),
                  'description' => esc_html__( 'This optional for screen up to 992px.', 'nuno-builder' ),
                  'param_name' => 'padding_tablet',
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Top', 'nuno-builder' ),
                  'param_name' => 'p_sm_top',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
                  'param_name' => 'p_sm_bottom',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Left', 'nuno-builder' ),
                  'param_name' => 'p_sm_left',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Right', 'nuno-builder' ),
                  'param_name' => 'p_sm_right',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                    'heading' => esc_html__( 'Border', 'nuno-builder' ),
                    'param_name' => 'border',
                    'type' => 'heading',
                    'group'=>esc_html__('Styles', 'nuno-builder'),
                 ), 

                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Border Color', 'nuno-builder'),
                  "param_name" => "border_color",
                  "description" => esc_html__("Select color for border", "nuno-builder"),
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
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Top', 'nuno-builder' ),
                  'param_name' => 'b_top',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
                  'param_name' => 'b_bottom',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Left', 'nuno-builder' ),
                  'param_name' => 'b_left',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Right', 'nuno-builder' ),
                  'param_name' => 'b_right',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
                  'param_name' => 'border_radius',
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Top Right', 'nuno-builder' ),
                  'param_name' => 'br_top_right',
                  'param_holder_class'=>'p_top',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Bottom Right', 'nuno-builder' ),
                  'param_name' => 'br_bottom_right',
                  'param_holder_class'=>'p_bottom',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Bottom Left', 'nuno-builder' ),
                  'param_name' => 'br_bottom_left',
                  'param_holder_class'=>'p_left',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Top Left', 'nuno-builder' ),
                  'param_name' => 'br_top_left',
                  'param_holder_class'=>'p_right',
                  'type' => 'textfield',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Box Shadow', 'nuno-builder' ),
                  'param_name' => 'box-shadow',
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
                    'heading' => esc_html__( 'Heading Color', 'nuno-builder' ),
                    'param_name' => 'color_heading_hover',
                    'class' => '',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                 ), 
                array( 
                    'heading' => esc_html__( 'Icon Color', 'nuno-builder' ),
                    'param_name' => 'icon_color_hover',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                 ),
                array( 
                    'heading' => esc_html__( 'Icon Background Color', 'nuno-builder' ),
                    'param_name' => 'icon_bgcolor_hover',
                    'value' => '',
                    'type' => 'colorpicker',
                    'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                 ),
                array( 
                  'heading' => esc_html__( 'Box', 'nuno-builder' ),
                  'description' => esc_html__( 'Box style.', 'nuno-builder' ),
                  'param_name' => 'box_style',
                  'type' => 'heading',
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
                  'param_name' => 'bg_color_hover',
                  'type' => 'colorpicker',
                  'group'=>esc_html__('Mouse Hover', 'nuno-builder'),
                ),
                array( 
                    'heading' => esc_html__( 'Border', 'nuno-builder' ),
                    'param_name' => 'border',
                    'type' => 'heading',
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
                  'heading' => esc_html__( 'Box Shadow', 'nuno-builder' ),
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

             )
    )
);

?>
