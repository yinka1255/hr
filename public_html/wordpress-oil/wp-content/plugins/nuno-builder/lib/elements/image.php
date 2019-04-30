<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_image extends BuilderElement{

    function preview($atts, $content = null){

      $atts['size']='thumbnail';
      $atts['el_id']=$atts['el_class']=$atts['el_class']=$atts['m_top']=$atts['m_bottom']=$atts['m_left']=$atts['m_right']="";

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'border_color' => '',
            'border_style'=>'solid',
            'border_width'=>'',
            'border_radius'=>'',
            'align'=>'',
            'image'=>'',
            'size'=>'full',
            'url'=>'',
            'target'=>'',
            'el_id' => '',
            'el_class'=>'',
            'image_style'=>'',
            'hover'=>'',
            'hover_color'=>'',
            'background_color'=>'',
            'hover_opacity'=>'',
            'hover_scale'=>'',
            'spy'=>'',
            'p_top' =>'',
            'p_bottom' =>'',
            'p_left' =>'',
            'p_right' =>'',
            'scroll_delay'=>300
        ), $atts,'el_image' ) );

        $css_class=array('el_image');

        if(''!= $el_class){
            array_push($css_class, $el_class);
        }

        if(isset($atts['p_top'])){
          unset($atts['p_top']);
        }

        if(isset($atts['p_bottom'])){
          unset($atts['p_bottom']);
        }

        if(isset($atts['p_left'])){
          unset($atts['p_left']);
        }

        if(isset($atts['p_right'])){
          unset($atts['p_right']);
        }

        if(''!= $hover){
          array_push($css_class, 'hover');
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $image_id = $image;

        if(!$image=get_image_size($image,$size))
            return "";

        $image_alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            get_scroll_spy_script();
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";

        $link=($url!='')?"<a href=\"".esc_url($url)."\" target=\"".$target."\">":"";
        $link_end=($url!='')?"</a>":"";

        $image_css_style =  $img_style = array();
        $img_radius = '';

        if(isset($atts['color'])){
            $border_color = trim($atts['color']);
        }


        if(''!=$border_color){
          $image_css_style[]= ($border_style!='') ? "border-style:{$border_style}" : "border-style: solid";
          $image_css_style[]="border-color:{$border_color}";
        }

        if(''!=$border_width){
          $image_css_style[]="border-width:".intval($border_width)."px";
        }

        if($p_top !=''){
          $image_css_style[]="padding-top:".absint($p_top)."px";
        }

        if($p_bottom !=''){
          $image_css_style[]="padding-bottom:".absint($p_bottom)."px";
        }

        if($p_left !=''){
          $image_css_style[]="padding-left:".absint($p_left)."px";
        }

        if($p_right !=''){
          $image_css_style[]="padding-right:".absint($p_right)."px";
        }
        
        if($image_style=='rounded' && ''!= $border_radius){
          $border_radius = strpos($border_radius, '%') ? intval($border_radius)."%" : intval($border_radius)."px";
          $image_css_style[]= "border-radius:".$border_radius;

          $padding = min(100, max($p_right, $p_left, $p_bottom, $p_top));
          $img_radius = "calc(".$border_radius." - ".intval($padding)."px)";

          $img_style[] = "border-radius:".$img_radius;
        }

        if($background_color !=''){
          $image_css_style[]="background-color:".$background_color;

        }

        if($hover_color!=''){
            $img_style[] = "background-color:".$hover_color;
        }


        $compile.="<div class=\"img-wrap image-align-".$align.(''!=$image_style?" style-".$image_style:"")."\" ".(count($image_css_style)  ? "style=\"".join(';',$image_css_style)."\"":"").">";
        $compile.=$link."<div class=\"inner-wrap\" ".(count($img_style) ? 'style="'.join(';',$img_style).'" ':"")."><img  class=\"img-responsive\" ".($img_radius !='' ? 'style="border-radius:'.$img_radius.'"': '')." src=\"".esc_url($image[0])."\" alt=\"".esc_attr($image_alt_text)."\"/></div>".$link_end;
        $compile.="</div>";
        $compile.="</div>";


        if($hover!=''){


          if($hover_opacity!=''){
              add_page_css_style("#$el_id.hover:hover .img-wrap img{opacity:".$hover_opacity."}");
          }

          if($hover_scale!=''){
              add_page_css_style("#$el_id.hover:hover .img-wrap img{-webkit-transform: scale(".$hover_scale.");-ms-transform: scale(".$hover_scale.");transform: scale(".$hover_scale.");}");
          }

        }

        if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_image',
  array(
    'title'=>esc_html__('Image','nuno-builder'),
    'icon'=>'fa fa-photo',
    'color'=>'#85909d',
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
        'heading' => esc_html__( 'Image', 'nuno-builder' ),
        'param_name' => 'image',
        'type' => 'image'
         ),
        array( 
        'heading' => esc_html__( 'Image Align', 'nuno-builder' ),
        'param_name' => 'align',
        'type' => 'dropdown',
        'value'=>array(
            'left'  => esc_html__('Align Left','nuno-builder'),
            'right' => esc_html__('Align Right','nuno-builder'),
            'center'  => esc_html__('Align Center','nuno-builder'),
            )

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
          'heading' => esc_html__( 'Backround Color', 'nuno-builder' ),
          'param_name' => 'background_color',
          'type' => 'colorpicker',
          'value'=>""
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__('Border', 'nuno-builder'),
          "param_name" => "border",
        ),
        array( 
        'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
        'param_name' => 'border_color',
        'type' => 'colorpicker',
        'value'=>""
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
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          "description" => esc_html__("Select radius for border(in px or %).", "nuno-builder"),
          'dependency' => array( 'element' => 'image_style', 'value' => array( 'rounded') )       
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__('Padding', 'nuno-builder'),
          "param_name" => "padding",
        ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__('On Hover', 'nuno-builder'),
          "param_name" => "hover_heading",
        ),
        array( 
          'heading' => esc_html__( 'Hover Effect', 'nuno-builder' ),
          'param_name' => 'hover',
          'type' => 'radio',
          'value'=>array(
              '' => esc_html__('Disable','nuno-builder'),
              '1'  => esc_html__('Enable','nuno-builder')
            )
        ),
        array( 
          'heading' => esc_html__( 'Overlay Color', 'nuno-builder' ),
          'param_name' => 'hover_color',
          'type' => 'colorpicker',
          'value'=>""
        ),
        array( 
            'heading' => esc_html__( 'Image Opacity', 'nuno-builder' ),
            'param_name' => 'hover_opacity',
            'class' => 'medium',
            'type' => 'slider_value',
            'default' => "1",
            'params'=>array('min'=>0,'max'=>1,'step'=>0.1),
         ),     
        array( 
            'heading' => esc_html__( 'Image Scale', 'nuno-builder' ),
            'param_name' => 'hover_scale',
            'class' => 'medium',
            'type' => 'slider_value',
            'default' => "",
            'params'=>array('min'=>1,'max'=>2,'step'=>0.1),
         ),     
        array(
          "type" => "heading",
          "heading" => esc_html__('Link', 'nuno-builder'),
          "param_name" => "link",
        ),
        array( 
          'heading' => esc_html__( 'Image Link', 'nuno-builder' ),
          'param_name' => 'url',
          'type' => 'textfield',
          ),
        array( 
          'heading' => esc_html__( 'Link Target', 'nuno-builder' ),
          'param_name' => 'target',
          'type' => 'dropdown',
          'value'=>array(
              '_self' => esc_html__('Self','nuno-builder'),
              '_blank'  => esc_html__('Blank','nuno-builder')
            )
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
        )    
    )
);
?>
