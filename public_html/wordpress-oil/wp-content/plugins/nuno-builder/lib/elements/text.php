<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_text extends BuilderElement{

    function preview($atts, $content = null, $base = ''){


        $content = wpautop(preg_replace('/<\/?p\>/', "", $content)."");
        return $content;

    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'scroll_delay'=>'300',
            'letter_spacing'=>'',
            'line_height'=>'',
            'spy'=>''
        ), $atts , 'el_text') );

        $css_class=array('el_text');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="element_".getElementTagID().time().rand(11,99);
        }

        $css_style=getElementCssMargin($atts , true);

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if(!empty($letter_spacing)){
            $letter_spacing=(preg_match('/(px|pt|em)$/', $letter_spacing))?$letter_spacing:$letter_spacing."px";
            $css_style['letter-spacing']="letter-spacing:".$letter_spacing;
        }

        if(!empty($line_height)){
            $line_height=(preg_match('/(px|pt|em)$/', $line_height))?$line_height: absint($line_height);
            $css_style['line_height']="line-height:".$line_height;
        }


       if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            get_scroll_spy_script();
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=do_shortcode($content);
        $compile.="</div>";


        if( count($css_style)){

          add_page_css_style("#$el_id {".join(';',$css_style)."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;

    }
}

class BuilderElement_el_text_html extends BuilderElement_el_text{}

add_builder_element('el_text_html',
  array(
    'title'=>esc_html__('Text Editor','nuno-builder'),
    'icon'=>"dashicons dashicons-edit",
    'color'=>'#46505e',
    'order'=>1,
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
              'heading' => esc_html__( 'Text', 'nuno-builder' ),
              'param_name' => 'content',
              'type' => 'textarea_html',
              'default'=>esc_html__("I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",'nuno-builder')
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
