<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.6.5
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_youtube_popup extends BuilderElement{

    function preview($atts, $content = null){

      $atts['spy']='none';
      $atts['el_id']=$atts['el_class']=$atts['el_class']=$atts['m_top']=$atts['m_bottom']=$atts['m_left']=$atts['m_right']="";

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'border' => '',
            'border_width'=>'',
            'image'=>'',
            'size'=>'full',
            'url'=>'',
            'button_color'=>'',
            'button_bg_color'=>'',
            'border_color'=>'',
            'border_width'=>'',
            'button_hover_color'=>'',
            'button_hover_bg_color'=>'',
            'border_hover_color'=>'',
            'el_id' => '',
            'el_class'=>'',
            'spy'=>'',
            'scroll_delay'=>300
        ), $atts,'el_youtube_popup' ) );

         wp_enqueue_style('awesomeicon');

        $css_class=array('youtube_popup');

        if(''!=$el_class){
            array_push($css_class, $el_class);
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
        $button_style= $button_hover_style = array();

        if(''!=$button_bg_color){
          $button_style[]="background-color:{$button_bg_color};";
        }

        if(''!=$border_color){
          $button_style[]="border-color:{$border_color};";
        }

        if(''!=$border_width){
          $button_style[] = "border-width:".intval($border_width)."px;";
        }


        if(''!=$button_hover_bg_color){
          $button_hover_style[]="background-color:{$button_hover_bg_color}!important;";
        }

        if(''!=$border_hover_color){
          $button_hover_style[]="border-color:{$border_hover_color}!important;";
        }

        $compile.="<div class=\"action-panel\" ".(count($button_style) ? " style=\"".join(";", $button_style)."\"":"")."><a class=\"popup-youtube\" ".($button_color!='' ? "style=\"color:{$button_color}\" ":"")."href=\"".esc_url($url)."\" target=\"_blank\"><span class=\"fa fa-play fa-3x playvid\"></span></a></div>";
        $compile.="<img class=\"img-responsive\" src=\"".esc_url($image[0])."\" alt=\"".esc_attr($image_alt_text)."\"/>";
        $compile.="</div>";

        if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        if(''!=$button_hover_color){
          add_page_css_style("#$el_id .action-panel:hover a{color:{$button_hover_color}!important;}");
        }

        if(count($button_hover_style)){
          add_page_css_style("#$el_id .action-panel:hover{".join(";",$button_hover_style)."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_youtube_popup',
  array(
    'title'=>esc_html__('Youtube Link','nuno-builder'),
    'icon'=>'fa fa-youtube',
    'color'=>'#cc181e',
    'order'=>22,
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
          'heading' => esc_html__( 'Youtube Link', 'nuno-builder' ),
          'param_name' => 'url',
          'type' => 'textfield',
          'description' => esc_html__( 'The youtube url. Ex: https://www.youtube.com/watch?v=acbdefgh', 'nuno-builder' ),
          ),
        array( 
        'heading' => esc_html__( 'Thumbnail Image', 'nuno-builder' ),
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
          "type" => "heading",
          "heading" => esc_html__('Button', 'nuno-builder'),
          "param_name" => "button",
          'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Color', 'nuno-builder' ),
        'param_name' => 'button_color',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Bakcground Color', 'nuno-builder' ),
        'param_name' => 'button_bg_color',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
        'param_name' => 'border_color',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__('Button Hover', 'nuno-builder'),
          "param_name" => "button_hover",
          'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Color', 'nuno-builder' ),
        'param_name' => 'button_hover_color',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Bakcground Color', 'nuno-builder' ),
        'param_name' => 'button_hover_bg_color',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Buton Style', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
        'param_name' => 'border_hover_color',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Buton Style', 'nuno-builder'),
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
