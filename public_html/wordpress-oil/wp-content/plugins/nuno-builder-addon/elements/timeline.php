<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder Addon
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('GUM_BUILDER_BASENAME') or die();

class BuilderElement_el_timeline_item extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'title'=>'',
            'sub_title'=>'',
            'position'=>'left',
            'spy'=>'',
            'image'=>'',
            'size'=>'',
            'scroll_delay'=>300
        ), $atts ,'el_timeline_item') );

      $compile='<div class="single-timeline-item leaf-position-'.sanitize_html_class($position).'"';

        if('none'!==$spy && !empty($spy)){
            $compile.=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            if(function_exists('get_scroll_spy_script')) get_scroll_spy_script();
        }

        $compile.='>';

        $thumb_image=get_image_size($image,$size);

        if($thumb_image){
            $image_alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);

            $compile.='<div class="thumb"><div class="box"><img class="img-responsive" src="'.esc_url($thumb_image[0]).'" alt="'.esc_attr($image_alt_text).'"/></div></div>';
        }



         $compile.='<div class="text-holder"><h5 class="date">'.$sub_title.'</h5><h3>'.$title.'</h3>'.$content.'</div></div>';

        return $compile;

    }
} 

class BuilderElement_el_timeline_separator extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'title'=>'',
            'spy'=>'',
            'scroll_delay'=>300
        ), $atts ,'el_timeline_separator') );


      $compile='<div class="year"';

        if('none'!==$spy && !empty($spy)){
            $compile.=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            if(function_exists('get_scroll_spy_script')) get_scroll_spy_script();
        }


        $compile.='><h3>'.$title.'</h3></div> ';

        return $compile;

    }
} 

class BuilderElement_el_timeline extends BuilderElement{

    function preview($atts, $content = null){

      $atts['el_id']=$atts['el_class']=$atts['el_class']=$atts['m_top']=$atts['m_bottom']=$atts['m_left']=$atts['m_right']="";

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = ''){


        if(!has_shortcode($content, 'el_timeline_item'))
            return "";

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'spy'=>'',
            'scroll_delay'=>300
        ), $atts,'el_timeline' ) );

        $css_class=array('el-timeline');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

       $pattern = get_shortcode_regex(array('el_timeline_item','el_timeline_separator'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
                return "";


        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }


        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $scroll_delay= (int)$scroll_delay;;
        $delay = $scroll_delay;




        foreach ($matches as $item) {

            $code = '['.$item[2].' spy="'.$spy.'" scroll_delay="'.$delay.'" '.$item[3].']'.$item[5].'[/'.$item[2].']';
            $compile.=do_shortcode($code);

            $delay += $scroll_delay;

        }

        $compile.="</div>";

        if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_timeline',
  array(
    'title'=>esc_html__('Timeline','nuno-builder-addon'),
    'icon'=>'fa fa-ellipsis-v',
    'color'=>'#333333',
    'child_list'=>'vertical',
    'as_parent' => array('el_timeline_item','el_timeline_separator'),
    'order'=>30,
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

add_builder_element('el_timeline_item',
 array( 
    'title' => esc_html__( 'Timeline Item', 'nuno-builder-addon' ),
    'as_child' => 'el_timeline',
    'color' => '#726e4b',
    'options' => array(
/*        array( 
        'heading' => esc_html__( 'Leaf Position', 'nuno-builder-addon' ),
        'param_name' => 'position',
        'value' => array('left'=>esc_html__('Left','nuno-builder-addon'),'right'=>esc_html__('Right','nuno-builder-addon')),
        'type' => 'radio',
        'default'=>'no'
         ),
*/
        array( 
          'heading' => esc_html__( 'Title', 'nuno-builder-addon' ),
          'param_name' => 'title',
          'admin_label' => true,
          'value' => '',
          'type' => 'textfield'
         ),
        array( 
          'heading' => esc_html__( 'Date Title', 'nuno-builder-addon' ),
          'param_name' => 'sub_title',
          'admin_label' => true,
          'value' => '',
          'type' => 'textfield'
         ),
          array(
           'heading' => esc_html__( 'Image', 'nuno-builder-addon' ),
            'param_name' => 'image',
            'type' => 'image',
          ),
          array( 
            'heading' => esc_html__( 'Image Size', 'nuno-builder' ),
            'param_name' => 'size',
            'type' => 'textfield',
            'value'=>"",
            'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'nuno-builder' ),
            ),
          array( 
          'heading' => esc_html__( 'Content', 'nuno-builder-addon' ),
          'param_name' => 'content',
          'class' => '',
          'value' => '',
          'default'=>esc_html__("I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'nuno-builder-addon'),
          'type' => 'textarea_html'
         ),         

        )
 ) );

add_builder_element('el_timeline_separator',
 array( 
    'title' => esc_html__( 'Separator', 'nuno-builder-addon' ),
    'as_child' => 'el_timeline',
    'color' => '#726e4b',
    'options' => array(
        array( 
          'heading' => esc_html__( 'Text', 'nuno-builder-addon' ),
          'param_name' => 'title',
          'admin_label' => true,
          'value' => '',
          'type' => 'textfield'
         ),
        )
 ) );

?>
