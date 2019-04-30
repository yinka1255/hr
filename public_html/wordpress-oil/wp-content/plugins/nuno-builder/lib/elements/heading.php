<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_section_header extends BuilderElement {

    function preview($atts, $content = null, $base = ''){

      $atts['font_size']=(isset($atts['font_size']) && $atts['font_size']!='custom')?$atts['font_size']:"default";

      wp_enqueue_style( 'builder-style',get_abuilder_dir_url()."css/abuilder_style.css",array());

      return $this->render($atts, $content);

    }

    function render($atts, $content = null, $base = ''){

        extract(shortcode_atts(array(
            'main_heading' => '',
            'text_align'=>'center',
            'color'=>'',
            'layout'=>'',
            'el_id'=>'',
            'el_class'=>'',
            'font_weight'=>'',
            'font_style'=>'',
            'font_size'=>'default',
            'custom_font_size'=>'',
            'separator_color'=>'',
            'spy'=>'',
            'tag'=>'h2',
            'text_transform'=>'',
            'letter_spacing'=>'',
            'line_height'=>'',
            'scroll_delay'=>300,
        ), $atts,'section_header'));

        $css_class=array('section-head',$text_align);
        if($layout!=''){
          array_push($css_class, 'layout-'. sanitize_html_class($layout));
        }
        $heading_style=array();


        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element-".getElementTagID();
        }

        if('default'!==$font_size){
          array_push($css_class," size-".$font_size);
        }

        $compile="<div ";
        if(''!=$el_id){
              $compile.="id=\"$el_id\" ";
        }

        if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            get_scroll_spy_script();
        }


        if(!empty($color)){
            $heading_style['color']="color:".$color;
        }

        if(!empty($font_weight) && $font_weight!='default'){
            $heading_style['font-weight']="font-weight:".$font_weight;
        }

        if(!empty($font_style) && $font_style!='default'){
            $heading_style['font-style']="font-style:".$font_style;
        }

        if(!empty($custom_font_size) && $font_size=='custom'){
            $custom_font_size=(preg_match('/(px|pt|em)$/', $custom_font_size))?$custom_font_size:$custom_font_size."px";
            $heading_style['font-size']="font-size:".$custom_font_size;
        }

        if(!empty($text_transform)){
            $heading_style['text-transform']="text-transform:".$text_transform;
        }

        if(!empty($letter_spacing)){
            $letter_spacing=(preg_match('/(px|pt|em)$/', $letter_spacing))?$letter_spacing:$letter_spacing."px";
            $heading_style['letter-spacing']="letter-spacing:".$letter_spacing;
        }

        if(!empty($line_height)){
            $line_height=(preg_match('/(px|pt|em)$/', $line_height))?$line_height: absint($line_height);
            $heading_style['line_height']="line-height:".$line_height;
        }

        if($tag=='') $tag= 'h2';


        $compile.='class="'.@implode(" ",$css_class).'"><div>'.
                  ((!empty($main_heading))?'<'.$tag.(count($heading_style)?" style=\"".@implode(";",$heading_style)."\"":"").' class="section-main-title">'.$main_heading.'</'.$tag.'>':'').
          '</div></div>';  

        if(""!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);
        
        return $compile;
    }
}

add_builder_element('section_header',
 array( 
    'title' => esc_html__( 'Section Heading', 'nuno-builder' ),
    'base' => 'section_header',
    'icon'=>'dashicons dashicons-editor-textcolor',
    'color'=>'#5d6b7d',
    'order'=>2,
    'class' => '',
    'options' => array(  
        array( 
        'heading' => esc_html__( 'Text Heading', 'nuno-builder' ),
        'param_name' => 'main_heading',
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ),         
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
          'heading' => esc_html__( 'Layout', 'nuno-builder' ),
          'param_name' => 'layout',
          'type' => 'dropdown',
          'value' => apply_filters( 'section_header_layout' ,array(
                    ''=>esc_html__('Default','nuno-builder')
                    ))
        ),
        array( 
          'heading' => esc_html__( 'Text Alignment', 'nuno-builder' ),
          'param_name' => 'text_align',
          'class' => '',
          'value' => array('center'=>esc_html__('Center','nuno-builder') ,'left'=>esc_html__('Left','nuno-builder') ,'right'=>esc_html__('Right','nuno-builder') ),
          'type' => 'dropdown',
          'default'=>'center'
         ),         
        array( 
        'heading' => esc_html__( 'Text Transform', 'nuno-builder' ),
        'param_name' => 'text_transform',
        'default' => "",
        'value'=>array(
              ''  => esc_html__('None','nuno-builder'),
              'uppercase' => esc_html__('Uppercase','nuno-builder'),
              'lowercase' => esc_html__('Lowercase','nuno-builder'),
              'capitalize'  => esc_html__('Capitalize','nuno-builder'),
              'full-width'  => esc_html__('Full Width','nuno-builder'),
              ),
        'type' => 'dropdown'
         ),
        array( 
        'heading' => esc_html__( 'Tag', 'nuno-builder' ),
        'param_name' => 'tag',
        'default' => "default",
        'value'=>array(
              '' => esc_html__('Default','nuno-builder'),
              'h1'  => 'H1',
              'h2'  => 'H2',
              'h3'  => 'H3',
              'h4'  => 'H4',
              'h5'  => 'H5',
              'h6'  => 'H6',
              'div' => 'DIV',
              ),
        'type' => 'dropdown'
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
        'type' => 'dropdown'
         ),
        array( 
        'heading' => esc_html__( 'Custom Font Size', 'nuno-builder' ),
        'param_name' => 'custom_font_size',
        'value' => '',
        'type' => 'textfield',
        'description' => esc_html__( 'The font size. in px,pt,em.', 'nuno-builder' ),
        'dependency' => array( 'element' => 'font_size', 'value' => array( 'custom') )       
         ),         
        array( 
          'heading' => esc_html__( 'Letter Spacing', 'nuno-builder' ),
          'param_name' => 'letter_spacing',
          'class'=>'small',
          'type' => 'textfield',
          'description' => esc_html__( 'The spacing each character. in px,pt,em.', 'nuno-builder' ),
        ),
        array( 
          'heading' => esc_html__( 'Line Height', 'nuno-builder' ),
          'param_name' => 'line_height',
          'class'=>'small',
          'type' => 'textfield',
          'description' => esc_html__( 'The line height in px,pt,em or float number.', 'nuno-builder' ),
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
        'type' => 'dropdown'
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
        'type' => 'dropdown'
         ),
         array( 
        'heading' => esc_html__( 'Font Color', 'nuno-builder' ),
        'param_name' => 'color',
        'value' => '',
        'type' => 'colorpicker'
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
