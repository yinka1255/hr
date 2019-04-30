<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       2.0.3
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_imbox extends BuilderElement{

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
            'heading_align'=>'',
            'color_heading'=>'',
            'image' => '',
            'image_style'=>'',
            'size'=>'',
            'target' => '_blank',
            'iconbox_text'=>'',
            'link' => '',
            'label_link'=>'',
            'spy'=>'none',
            'font_weight'=>'',
            'bg_color'=>'',
            'scroll_delay'=>300
        ), $atts,'el_imbox' ) );

        $content=(empty($content) && !empty($iconbox_text))?$iconbox_text:$content;


        $image_id = $image;
        $scollspy = $image_alt_text = "";

        if(($image=get_image_size($image,$size))){

          $image_alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        }



        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $css_class=array('module-img-box','style-'.$layout,'shape-'.$image_style);

        if($content_align!=''){
          array_push($css_class, 'content-align-'.sanitize_html_class($content_align));
        }

        if($heading_align!=''){
          array_push($css_class, 'heading-align-'.sanitize_html_class($heading_align));
        }

        if($text_align!=''){
          array_push($css_class, 'text-align-'.sanitize_html_class($text_align));
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

        $heading_style = array();

        if(!empty($color_heading)){
            $heading_style['color']="color:".$color_heading;
        }

        if(!empty($font_weight) && $font_weight!='default'){
            $heading_style['font-weight']="font-weight:".$font_weight;
        }

        $output='<div class="boxes-wrap">';

        if($image){
          $output.='<span class="box">'.((strlen($link)>0) ?"<a target='".$target."' href='".esc_url($link)."'>":"").'<img src="'.esc_url($image[0]).'" class="img-responsive" alt="'.esc_attr($image_alt_text).'" />'.((strlen($link)>0) ?"</a>":"").'</span>';
        }

        $output.='<div class="text-wrap">';
        
        if($iconbox_heading!=''){
            $output.='<h4 class="box-heading" '.(count($heading_style)? 'style="'.join(';',$heading_style).'"':'').'>'.$iconbox_heading.'</h4>';
        }
        
        $output.='<div class="text">'.((!empty($content))?do_shortcode($content):"");

        if($label_link!='' && strlen($link)>0 ){
            $output.= '<a target="'.$target.'" href="'.esc_url($link).'" class="more-link">'.esc_html($label_link).'</a>';
        }

        $output.='</div></div></div>';

       $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\" ".$scollspy.">";
        $compile.=$output."</div>";

        if(count($css_style)){
            add_page_css_style("#$el_id {".join(';',$css_style).";}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_imbox',
  array(
    'title'=> esc_html__( 'Image Box', 'nuno-builder' ),
    'description' => esc_html__( 'Image box and description here', 'nuno-builder' ),
    'icon'=>'fa fa-id-card-o',
    'color'=>'#0d6d65',
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
                'heading' => esc_html__( 'Image', 'nuno-builder' ),
                'param_name' => 'image',
                'type' => 'image'
                 ),
                array( 
                'heading' => esc_html__( 'Image Size', 'nuno-builder' ),
                'param_name' => 'size',
                'type' => 'textfield',
                'value'=>"",
                'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'nuno-builder' )

                ),
                array( 
                'heading' => esc_html__( 'Image Style', 'nuno-builder' ),
                'param_name' => 'image_style',
                'type' => 'dropdown',
                'value'=>array(
                    'default'  => esc_html__('Default','nuno-builder'),
                    'rounded' => esc_html__('Rounded','nuno-builder'),
                    'circle'  => esc_html__('Circle','nuno-builder'),
                    )
                ),
                 array( 
                  'heading' => esc_html__( 'Layout', 'nuno-builder' ),
                  'param_name' => 'layout',
                  'type' => 'dropdown',
                  'value' => array(
                            '1'=>esc_html__('Image Top','nuno-builder'),
                            '2'=>esc_html__('Image on Left','nuno-builder'),
                            '3'=>esc_html__('Image on Right','nuno-builder'),
                            ),
                ),
                 array( 
                  'heading' => esc_html__( 'Align', 'nuno-builder' ),
                  'param_name' => 'content_align',
                  'type' => 'dropdown',
                  'value' => array(
                            ''=>esc_html__('Default','nuno-builder'),
                            'center'=>esc_html__('Center','nuno-builder'),
                            'left'=>esc_html__('Left','nuno-builder'),
                            'right'=>esc_html__('Right','nuno-builder'),
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
                  "type" => "heading",
                  "heading" => esc_html__('Read More', 'nuno-builder'),
                  "param_name" => "link_heading",
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
                  "type" => "heading",
                  "heading" => esc_html__('Animation', 'nuno-builder'),
                  "param_name" => "animation",
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
                  'heading' => esc_html__( 'Box Styles', 'nuno-builder' ),
                  'param_name' => 'box',
                  'type' => 'heading',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Box Background Color', 'nuno-builder' ),
                  'param_name' => 'bg_color',
                  'type' => 'colorpicker',
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array(
                  "type" => "colorpicker",
                  "heading" => esc_html__('Box Border Color', 'nuno-builder'),
                  "param_name" => "border_color",
                  "description" => esc_html__("Select color for border", "nuno-builder"),
                  'group'=>esc_html__('Styles', 'nuno-builder'),
                ),
                array( 
                  'heading' => esc_html__( 'Box Border Style', 'nuno-builder' ),
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
                  'heading' => esc_html__( 'Box Border Width', 'nuno-builder' ),
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
                  'heading' => esc_html__( 'Box Border Radius', 'nuno-builder' ),
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
                  'heading' => esc_html__( 'Box Box Shadow', 'nuno-builder' ),
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
                ),                array( 
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

             )
    )
);

?>
