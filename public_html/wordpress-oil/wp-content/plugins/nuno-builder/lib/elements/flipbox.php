<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_flipbox_item_normal extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'image'=>'',
            'bg_color'=>'',
        ), $atts ,'flipbox_item_normal') );


        $css_class=array('flip-item','normal');
        $css_style=getElementCssMargin($atts,true);


        if(""!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){
          $css_style['background-image']="background-image:url(".esc_url($background_image[0]).")";
        }

       if(""!=$bg_color){
          $css_style['background-color'] = "background-color:".$bg_color;
        }

        $el_id="element_".getElementTagID();

        $compile="<div id=\"$el_id\" class=\"".@implode(" ",$css_class)."\">".do_shortcode($content)."</div>";

        if(count($css_style)){
          add_page_css_style("#$el_id {".join(';',$css_style)."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;

    }
} 

class BuilderElement_flipbox_item_flipped extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'image'=>'',
            'bg_color'=>'',
        ), $atts ,'flipbox_item_flipped') );


        $css_class=array('flip-item','flipped');
        $css_style=getElementCssMargin($atts,true);

        $el_id="element_".getElementTagID();

        if(""!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){
          $css_style['background-image']="background-image:url(".esc_url($background_image[0]).")";
        }

        if(""!=$bg_color){
          $css_style['background-color'] = "background-color:".$bg_color;
        }

        $compile="<div id=\"$el_id\" class=\"".@implode(" ",$css_class)."\">".do_shortcode($content)."</div>";

        if(count($css_style)){
          add_page_css_style("#$el_id {".join(';',$css_style)."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;

    }
} 

class BuilderElement_el_flipbox extends BuilderElement {

    function render($atts, $content = null, $base = '') {
        extract( shortcode_atts( array(
            'el_class'=>'',
            'flip_style'=>'horizontal',
            'box_width' =>'',
            'box_height' =>'',
            'el_id'=>'',
        ), $atts ,'el_flipbox') );

       $pattern = get_shortcode_regex(array('flipbox_item_normal','flipbox_item_flipped'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
            return "";


        $widgetID=getElementTagID("el_flipbox");


        $css_style=getElementCssMargin($atts,true);
        if(''==$el_id){

            $el_id="element_".getElementTagID();
        }

        if(""!=$box_height){
          $css_style['height'] = "height:".absint($box_height)."px";
        }

        if(""!=$box_width){
          $css_style['width'] = "max-width:".absint($box_width)."px";
        }

        $css_class=array('el_flipbox','flip-'.$flip_style);
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }


        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.=" class=\"".@implode(" ",$css_class)."\"><div class=\"flipbox\">".do_shortcode($content).'</div></div>';

        if(count($css_style)){
          add_page_css_style("#$el_id {".join(';',$css_style)."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}


add_builder_element('el_flipbox',
    array( 
    'title' => esc_html__( 'Flip Box', 'nuno-builder' ),
    'icon'=>'fa fa-clone',
    'color'=>'#81d742',
    'order'=>6,
    'as_box'=>array('flipbox_item_normal','flipbox_item_flipped'),
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
          'heading' => esc_html__( 'Box Width', 'nuno-builder' ),
          'param_name' => 'box_width',
          'class'=>'small',
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Box Height', 'nuno-builder' ),
          'param_name' => 'box_height',
          'class'=>'small',
          'type' => 'textfield',
          'description' => esc_html__( 'Box height. required', 'nuno-builder' ),
        ),
        array( 
        'heading' => esc_html__( 'Animation Type', 'nuno-builder' ),
        'param_name' => 'flip_style',
        'class' => '',
        'value' => 
         array(
            'horizontal'       => esc_html__('Flip Horizontal','nuno-builder'),
            'vertical'         => esc_html__('Flip Vertical','nuno-builder'),
         ),        
        'type' => 'dropdown',
         ),     
    )

 ) );

add_builder_element('flipbox_item_normal',
 array( 
    'title' => esc_html__( 'Normal Content', 'nuno-builder' ),
    'as_box_item' => 'el_flipbox',
    'options' => array(
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
          'group'=>esc_html__('Background', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Background', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),

        array( 
          'heading' => esc_html__( 'Padding Tablet', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'nuno-builder' ),
          'param_name' => 'padding_tablet',
          'type' => 'heading',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_sm_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_sm_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_sm_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_sm_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Padding Mobile', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'nuno-builder' ),
          'param_name' => 'padding_mobile',
          'type' => 'heading',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_xs_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_xs_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_xs_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_xs_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),        
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Border Color', 'nuno-builder'),
          "param_name" => "border_color",
          "description" => esc_html__("Select color for border", "nuno-builder"),
          'group'=>esc_html__('Border', 'nuno-builder'),
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
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'type' => 'heading',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'b_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'b_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'b_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'b_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'type' => 'heading',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Right', 'nuno-builder' ),
          'param_name' => 'br_top_right',
          'param_holder_class'=>'br_top',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Right', 'nuno-builder' ),
          'param_name' => 'br_bottom_right',
          'param_holder_class'=>'br_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Left', 'nuno-builder' ),
          'param_name' => 'br_bottom_left',
          'param_holder_class'=>'br_left',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Left', 'nuno-builder' ),
          'param_name' => 'br_top_left',
          'param_holder_class'=>'br_right',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Box Shadow', 'nuno-builder' ),
          'param_name' => 'box-shadow',
          'type' => 'heading',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
          'param_name' => 'h_shadow',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
          'param_name' => 'v_shadow',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Blur', 'nuno-builder' ),
          'param_name' => 'blur_shadow',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Spread', 'nuno-builder' ),
          'param_name' => 'spread_shadow',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Shadow Color', 'nuno-builder'),
          "param_name" => "shadow_color",
          "description" => esc_html__("Select color for shadow", "nuno-builder"),
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),

        )
 ) );

add_builder_element('flipbox_item_flipped',
 array( 
    'title' => esc_html__( 'Flip Content', 'nuno-builder' ),
    'as_box_item' => 'el_flipbox',
    'options' => array(
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
          'group'=>esc_html__('Background', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Background', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),

        array( 
          'heading' => esc_html__( 'Padding Tablet', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'nuno-builder' ),
          'param_name' => 'padding_tablet',
          'type' => 'heading',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_sm_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_sm_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_sm_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_sm_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Padding Mobile', 'nuno-builder' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'nuno-builder' ),
          'param_name' => 'padding_mobile',
          'type' => 'heading',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_xs_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_xs_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_xs_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_xs_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Padding', 'nuno-builder'),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Border Color', 'nuno-builder'),
          "param_name" => "border_color",
          "description" => esc_html__("Select color for border", "nuno-builder"),
          'group'=>esc_html__('Border', 'nuno-builder'),
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
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'type' => 'heading',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'b_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'b_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'b_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'b_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'type' => 'heading',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Right', 'nuno-builder' ),
          'param_name' => 'br_top_right',
          'param_holder_class'=>'br_top',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Right', 'nuno-builder' ),
          'param_name' => 'br_bottom_right',
          'param_holder_class'=>'br_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Left', 'nuno-builder' ),
          'param_name' => 'br_bottom_left',
          'param_holder_class'=>'br_left',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Left', 'nuno-builder' ),
          'param_name' => 'br_top_left',
          'param_holder_class'=>'br_right',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Box Shadow', 'nuno-builder' ),
          'param_name' => 'box-shadow',
          'type' => 'heading',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
          'param_name' => 'h_shadow',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
          'param_name' => 'v_shadow',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Blur', 'nuno-builder' ),
          'param_name' => 'blur_shadow',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Spread', 'nuno-builder' ),
          'param_name' => 'spread_shadow',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Shadow Color', 'nuno-builder'),
          "param_name" => "shadow_color",
          "description" => esc_html__("Select color for shadow", "nuno-builder"),
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        )
 ) );

?>
