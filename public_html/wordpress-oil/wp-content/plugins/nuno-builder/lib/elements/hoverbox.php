<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.4
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_background_item extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'image'=>'',
            'bg_color'=>'',
            'hover_style'=>'',
            'position'=>'',
        ), $atts ,'background_item') );


        $css_class=array('hover-content','background','effect-'.$hover_style,'position-'.$position);
        $css_style=getElementCssMargin($atts,true);
        $bg_style = array();

        if(""!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){
          $bg_style['background-image']="background-image:url(".esc_url($background_image[0]).")";
        }

       if(""!=$bg_color){
          $bg_style['background-color'] = "background-color:".$bg_color;
        }

        $el_id="element_".getElementTagID();

        $compile="<div id=\"$el_id\" class=\"".@implode(" ",$css_class)."\"><div class=\"background-image\" ".(count($bg_style) ? 'style="'.join(';',$bg_style).'"':'')."></div><div class=\"hover-box-inner\">".do_shortcode($content)."</div></div>";

        nuno_add_element_margin_style("#$el_id .hover-box-inner",$atts);

        return $compile;

    }
} 

class BuilderElement_hover_item extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'bg_color'=>'',
            'hover_style'=>'',
            'position'=>'',
        ), $atts ,'hover_item') );

        $el_id="element_".getElementTagID();

        if($hover_style == 'overlay'){
          add_page_css_style("#$el_id:hover{background-color:".$bg_color."}");
          $bg_color = '';
        }


        $css_class=array('hover-content','foreground','effect-'.$hover_style,'position-'.$position);

        $compile="<div id=\"$el_id\" class=\"".@implode(" ",$css_class)."\" ".(""!=$bg_color ? ' style="background-color:'.$bg_color.'"' : '')."><div class=\"hover-box-inner\">".do_shortcode($content)."</div></div>";


      nuno_add_element_margin_style("#$el_id  .hover-box-inner",$atts);

        return $compile;

    }
} 

class BuilderElement_el_hover_box extends BuilderElement {

    function render($atts, $content = null, $base = '') {
        extract( shortcode_atts( array(
            'el_class'=>'',
            'box_width' =>'',
            'box_height' =>'',
            'el_id'=>'',
        ), $atts ,'el_hover_box') );

       $pattern = get_shortcode_regex(array('background_item','hover_item'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
            return "";

        $css_style=getElementCssMargin($atts,true);
        if(''==$el_id){

            $el_id="element_".getElementTagID();
        }

        if(""!=$box_height){
          $css_style['height'] = "min-height:".absint($box_height)."px";
        }

        if(""!=$box_width){
          $css_style['width'] = "max-width:".absint($box_width)."px";
        }

        $css_class=array('el_hover_box');
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }


        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.=" class=\"".@implode(" ",$css_class)."\">".do_shortcode($content).'</div>';

        if(count($css_style)){
          add_page_css_style("#$el_id {".join(';',$css_style)."}");
        }

      nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}


add_builder_element('el_hover_box',
    array( 
    'title' => esc_html__( 'Hover Box', 'nuno-builder' ),
    'icon'=>'fa fa-newspaper-o',
    'color'=>'#43db92',
    'order'=>7,
    'as_box'=>array('background_item','hover_item'),
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
          "type" => "colorpicker",
          "heading" => esc_html__('Border Color', 'nuno-builder'),
          "param_name" => "border_color",
          "description" => esc_html__("Select color for border", "nuno-builder"),
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
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
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'type' => 'heading',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'b_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'b_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'b_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'b_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'type' => 'heading',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Right', 'nuno-builder' ),
          'param_name' => 'br_top_right',
          'param_holder_class'=>'br_top',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Right', 'nuno-builder' ),
          'param_name' => 'br_bottom_right',
          'param_holder_class'=>'br_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Left', 'nuno-builder' ),
          'param_name' => 'br_bottom_left',
          'param_holder_class'=>'br_left',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Left', 'nuno-builder' ),
          'param_name' => 'br_top_left',
          'param_holder_class'=>'br_right',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Box Shadow', 'nuno-builder' ),
          'param_name' => 'box-shadow',
          'type' => 'heading',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
          'param_name' => 'h_shadow',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
          'param_name' => 'v_shadow',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Blur', 'nuno-builder' ),
          'param_name' => 'blur_shadow',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Spread', 'nuno-builder' ),
          'param_name' => 'spread_shadow',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Shadow Color', 'nuno-builder'),
          "param_name" => "shadow_color",
          "description" => esc_html__("Select color for shadow", "nuno-builder"),
          'group'=>esc_html__('Box Shape', 'nuno-builder'),
        ),

    )

 ) );

add_builder_element('background_item',
 array( 
    'title' => esc_html__( 'Background Content', 'nuno-builder' ),
    'as_box_item' => 'el_hover_box',
    'options' => array(
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
        'heading' => esc_html__( 'Content Position', 'nuno-builder' ),
        'param_name' => 'position',
        'class' => '',
        'value' => 
         array(
            'top'       => esc_html__('Top','nuno-builder'),
            'middle'       => esc_html__('Middle','nuno-builder'),
            'bottom'       => esc_html__('Bottom','nuno-builder'),
         ),        
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Hover Effect', 'nuno-builder' ),
        'param_name' => 'hover_style',
        'class' => '',
        'value' => 
         array(
            ''       => esc_html__('None','nuno-builder'),
            'zoom-in'       => esc_html__('Zoom in','nuno-builder'),
            'zoom-out'       => esc_html__('Zoom out','nuno-builder'),
            'fade-out'       => esc_html__('Fade out','nuno-builder'),
            'to-left'       => esc_html__('To the left','nuno-builder'),
            'to-right'         => esc_html__('To the right','nuno-builder'),
            'up'       => esc_html__('Slide up','nuno-builder'),
            'down'         => esc_html__('Slide down','nuno-builder'),
            'bg-zoom-in'       => esc_html__('Background zoom in','nuno-builder'),
            'bg-zoom-out'       => esc_html__('Background zoom out','nuno-builder'),
         ),        
        'type' => 'dropdown',
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
        )
        )
 ) );

add_builder_element('hover_item',
 array( 
    'title' => esc_html__( 'Foreground Content', 'nuno-builder' ),
    'as_box_item' => 'el_hover_box',
    'options' => array(
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
          "description" => esc_html__("Overlay between back content with hover content", "nuno-builder"),          
        ),
        array( 
        'heading' => esc_html__( 'Content Position', 'nuno-builder' ),
        'param_name' => 'position',
        'class' => '',
        'value' => 
         array(
            'top'       => esc_html__('Top','nuno-builder'),
            'middle'       => esc_html__('Middle','nuno-builder'),
            'bottom'       => esc_html__('Bottom','nuno-builder'),
         ),        
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Hover Effect', 'nuno-builder' ),
        'param_name' => 'hover_style',
        'class' => '',
        'value' => 
         array(
            ''       => esc_html__('None','nuno-builder'),
            'overlay'       => esc_html__('Color overlay','nuno-builder'),
            'zoom-in'       => esc_html__('Zoom in','nuno-builder'),
            'zoom-out'       => esc_html__('Zoom out','nuno-builder'),
            'fade-in'       => esc_html__('Fade in','nuno-builder'),
            'from-left'       => esc_html__('From left','nuno-builder'),
            'from-right'         => esc_html__('From the right','nuno-builder'),
            'from-top'       => esc_html__('From the top','nuno-builder'),
            'from-bottom'         => esc_html__('From the bottom','nuno-builder'),
            'scale-up'         => esc_html__('Scale up','nuno-builder'),
            'scale-down'         => esc_html__('Scale down','nuno-builder'),
         ),        
        'type' => 'dropdown',
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
        )
 ) );

?>
