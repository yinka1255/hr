<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.6.6
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_proggressline_item extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'title'=>'',
            'color'=>'',
            'bg_color'=>'',
            'border_color'=>'',
            'border_style'=>'',
            'border_width'=>'',
            'line_color'=>'',
            'line_style'=>'',
            'line_width'=>'',
            'color_hover'=>'',
            'bg_color_hover'=>'',
            'border_color_hover'=>'',
            'line_color_hover'=>'',
            'spy'=>'',
            'scroll_delay'=>300
        ), $atts ,'el_proggressline_item') );

      $el_id="element_".getElementTagID();

      $box_styles = $line_styles = $box_hover_styles = $line_hover_styles = array();


      if($color!=''){
        $box_styles['color'] = 'color:'.$color;
      }

      if($bg_color!=''){
        $box_styles['background-color'] = 'background-color:'.$bg_color;
      }

      if($border_color!=''){
        $box_styles['border-color'] = 'border-color:'.$border_color;
      }

      if($border_width!=''){
        $box_styles['border-width'] = 'border-width:'.absint($border_width).'px';
      }

      if($border_style!=''){
        $box_styles['border-style'] = 'border-style:'.$border_style;
      }

      if($color_hover!=''){
        $box_hover_styles['color'] = 'color:'.$color_hover;
      }

      if($bg_color_hover!=''){
        $box_hover_styles['background-color'] = 'background-color:'.$bg_color_hover;
      }

      if($border_color_hover!=''){
        $box_hover_styles['border-color'] = 'border-color:'.$border_color_hover;
      }


      if($line_color!=''){
        $line_styles['color'] = 'border-top-color:'.$line_color;
      }

      if($line_style!=''){
        $line_styles['border-style'] = 'border-top-style:'.$line_style;
      }

      if($line_width!=''){
        $line_styles['border-width'] = 'border-top-width:'.absint($line_width).'px';
      }

      $compile='<li id="'.$el_id.'" class="proggressline-item"';

        if('none'!==$spy && !empty($spy)){
            $compile.=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }

        $compile.='>
   <div class="time-title"><span><span '.(count($box_styles) ? 'style="'.implode(';', $box_styles).'"':'').'>'.$title.'</span></span></div>
   <div class="text-placeholder">'.do_shortcode($content).'</div></li>';

        if(count($border_color_hover)){
          add_page_css_style("#$el_id:hover .time-title > span > span{".implode(';', $box_hover_styles )."}");
        }

        if(count($line_styles)){
          add_page_css_style("#$el_id .time-title > span:after{".implode(';', $line_styles )."}");
        }

      if($line_color!=''){
        add_page_css_style("#$el_id:hover .time-title > span:after{border-top-color:".$line_color_hover.";}");

      }
        return $compile;

    }
} 

class BuilderElement_el_proggressline extends BuilderElement{

    function preview($atts, $content = null){

      $atts['el_id']=$atts['el_class']=$atts['el_class']=$atts['m_top']=$atts['m_bottom']=$atts['m_left']=$atts['m_right']="";

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = ''){


        if(!has_shortcode($content, 'el_proggressline_item'))
            return "";

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'spy'=>'',
            'scroll_delay'=>300
        ), $atts,'soul_timeline' ) );

        $css_class=array('el-proggressline');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

       $pattern = get_shortcode_regex(array('el_proggressline_item'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
                return "";


        $compile="<ul ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }


        if('none'!==$spy && !empty($spy)){
            get_scroll_spy_script();
        }


        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $scroll_delay= (int)$scroll_delay;;
        $delay = $scroll_delay;




        foreach ($matches as $item) {

            $code = '['.$item[2].' spy="'.$spy.'" scroll_delay="'.$delay.'" '.$item[3].']'.$item[5].'[/'.$item[2].']';
            $compile.=do_shortcode($code);

            $delay += $scroll_delay;

        }

        $compile.="</ul>";

        if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}


add_builder_element('el_proggressline',
  array(
    'title'=>esc_html__('Progress Line','nuno-builder'),
    'icon'=>'fa fa-random',
    'color'=>'#333333',
    'child_list'=>'horizontal',
    'as_parent' => array('el_proggressline_item'),
    'order'=>31,
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


add_builder_element('el_proggressline_item',
 array( 
    'title' => esc_html__( 'Progress Item', 'nuno-builder' ),
    'as_child' => 'el_proggressline',
    'color' => '#726e4b',
    'is_dropable'=>true,
    'options' => array(
        array( 
          'heading' => esc_html__( 'Title', 'nuno-builder' ),
          'param_name' => 'title',
          'admin_label' => true,
          'value' => '',
          'type' => 'textfield'
         ),
        array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Border Color', 'nuno-builder'),
          "param_name" => "border_color",
          "description" => esc_html__("Select color for border", "nuno-builder"),
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
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'type' => 'textfield',
          'class' => 'medium',
        ),
        array( 
          'heading' => esc_html__( 'Line', 'nuno-builder' ),
          'param_name' => 'line',
          'type' => 'heading',
        ),

        array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'line_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Line Style', 'nuno-builder' ),
          'param_name' => 'line_style',
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
        ),
        array( 
          'heading' => esc_html__( 'Line Thickness', 'nuno-builder' ),
          'param_name' => 'line_width',
          'type' => 'textfield',
          'class' => 'medium',
        ),


        array( 
          'heading' => esc_html__( 'Title', 'nuno-builder' ),
          'param_name' => 'box_title',
          'type' => 'heading',
          'group'=>esc_html__('Mouse Hover', 'soul-nuno-builder-addon'),
        ),
        array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'color_hover',
          'type' => 'colorpicker',
          'group'=>esc_html__('Mouse Hover', 'soul-nuno-builder-addon'),
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color_hover',
          'type' => 'colorpicker',
          'group'=>esc_html__('Mouse Hover', 'soul-nuno-builder-addon'),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Border Color', 'nuno-builder'),
          "param_name" => "border_color_hover",
          "description" => esc_html__("Select color for border", "nuno-builder"),
          'group'=>esc_html__('Mouse Hover', 'soul-nuno-builder-addon'),
        ),
        array( 
          'heading' => esc_html__( 'Line', 'nuno-builder' ),
          'param_name' => 'line_hover',
          'type' => 'heading',
          'group'=>esc_html__('Mouse Hover', 'soul-nuno-builder-addon'),
        ),

        array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'line_color_hover',
          'type' => 'colorpicker',
          'group'=>esc_html__('Mouse Hover', 'soul-nuno-builder-addon'),
        ),
        )
 ) );

?>
