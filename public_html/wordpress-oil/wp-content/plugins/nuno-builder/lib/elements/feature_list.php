<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.1.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_feature_item extends BuilderElement {

    function render($atts, $content = null, $base = '') {

        extract( shortcode_atts( array(
            'list_style'=>'',
            'bullet'=>'',
            'title'=>'',
            'sub_title'=>'',
            'price'=>'',
            'number'=>'',
            'icon_type'=>'',
            'bullet_image'=>'',
            'spy'=>'none',
            'm_bottom'=>'',
            'scroll_delay'=>300,
        ), $atts , 'el_feature_item') );

     $compile = '<li class="feature"'.($m_bottom!='' ? ' style="margin-bottom: '.absint($m_bottom).'px"': '').'>';

     if($list_style !=''){

       $compile .= '<span class="feature-marker bullet-'.$bullet.'"><span>';

        switch ($list_style) {
          case 'image':

                if($bullet_image!='' && ($image = get_image_size($bullet_image, 'small'))){

                  $image_alt_text = get_post_meta($bullet_image, '_wp_attachment_image_alt', true);
                  $compile .= '<img src="'.esc_url($image[0]).'" alt="'.esc_attr($image_alt_text).'" />';
                }

            break;
          case 'icon':
              $compile .= '<i class="'.$icon_type.'"></i>';
            break;
          default:
              $compile .= $number;
            break;
        }


         $compile .= '</span></span>';

     }


     $compile .= '<span class="feature-name">';


     if($title !=''){
        $compile .= '<span class="feature-title">'.$title.'</span>';
     }

     if($sub_title !=''){
        $compile .= '<span class="feature-subtitle">'.$sub_title.'</span>';
     }

     $compile .= '</span>';

     if($price !=''){
        $compile .= '<span class="feature-price">'.$price.'</span>';
     }

     $compile .= '</li>';

      return $compile;

    }
} 

class BuilderElement_el_feature extends BuilderElement{

    function preview($atts, $content = null, $base = ''){


        $content = $this->render($atts);
        return $content;

    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'list_style'=>'',
            'vertical_padding'=>'',
            'bullet_style'=>'',
            'list_size'=>'',
            'font_size'=>'',
            'icon_size'=>'',
            'sub_font_size'=>'',
            'icon_color'=>'',
            'color_heading'=>'',
            'color_sub_heading'=>'',
            'border_radius'=>'',
            'border_size'=>'',
            'border_color'=>'',
            'bg_color'=>'',                                    
            'el_id'=>'',
            'el_class'=>'',
            'spy'=>'none',
            'scroll_delay'=>300,
        ), $atts , 'el_feature') );

        $css_class=array('el_features','list-'.$list_style);

        $pattern = get_shortcode_regex(array('el_feature_item'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
                return "";


        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="element-".getElementTagID();
        }

        $css_style=getElementCssMargin($atts);
        $bullet_styles = $title_styles = $sub_title_styles = $price_styles = $shadows = array();

        if(isset($atts['b_h_shadow'])){
          $shadows['h_shadow'] = $atts['b_h_shadow'];
        }

        if(isset($atts['b_v_shadow'])){
          $shadows['v_shadow'] = $atts['b_v_shadow'];
        }

        if(isset($atts['b_blur_shadow'])){
          $shadows['blur_shadow'] = $atts['b_blur_shadow'];
        }

        if(isset($atts['b_spread_shadow'])){
          $shadows['spread_shadow'] = $atts['b_spread_shadow'];
        }

        if(isset($atts['b_shadow_color'])){
          $shadows['shadow_color'] = $atts['b_shadow_color'];
        }

        $bullet_styles = getElementCssMargin($shadows, true);

        if($list_size != ''){
          $width = absint($list_size).'px';
          $bullet_styles['width'] = 'width:'.$width; 
          $bullet_styles['height'] = 'height:'.$width; 
        }
   
        if($icon_size != ''){
          $icon_size = absint($icon_size).'px';
          $bullet_styles['font-size'] = 'font-size:'.$icon_size; 
        }

        if($icon_color != ''){
          $bullet_styles['color'] = 'color:'.sanitize_hex_color($icon_color); 
        }


        if($font_size != ''){
          $font_size = absint($font_size).'px';
          $title_styles['font-size'] = 'font-size:'.$font_size; 
          $price_styles['font-size'] = 'font-size:'.$font_size; 
        }

        if($sub_font_size != ''){
          $sub_font_size = absint($sub_font_size).'px';
          $sub_title_styles['font-size'] = 'font-size:'.$sub_font_size; 
        }

        if($color_heading != ''){
          $title_styles['color'] = 'color:'.sanitize_hex_color($color_heading); 
        }

        if($color_sub_heading != ''){
          $sub_title_styles['color'] = 'color:'.sanitize_hex_color($color_sub_heading); 
          add_page_css_style("#$el_id .feature-title:after{background-color:".sanitize_hex_color($color_sub_heading)."}");

        }

        if($bullet_style !=''){

          if($bg_color !=''){
            $bullet_styles['background-color'] = 'background-color:'.sanitize_hex_color($bg_color); 
          }

          if($border_color !=''){
            $bullet_styles['border-color'] = 'border-color:'.sanitize_hex_color($border_color); 
          }

          if($border_size !=''){
            $bullet_styles['border-width'] = 'border-width:'.absint($border_size).'px'; 
          }

          if($bullet_style =='rounded' && !empty($border_radius)){
            $bullet_styles['border-radius'] = 'border-radius:'.absint($border_radius).'px'; 
          }
        }



        $compile="<ul ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\" dir=\"ltr\">";

        $i = 1;
        $spacer = (!empty($vertical_padding)) ? 'm_bottom="'.$vertical_padding.'"': '';

        foreach ($matches as $list) {

           $shortcode = '[el_feature_item '.$spacer.' bullet="'.$bullet_style.'" number="'.$i.'" list_style="'.$list_style.'" '.$list[3].'][/el_feature_item]';
           $compile.=do_shortcode($shortcode);

           $i++;
        }

        $compile.="</ul>";

   
        if(""!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        if(count($bullet_styles)){
          add_page_css_style("#$el_id .feature-marker{".join(';', $bullet_styles )."}");
        }

        if(count($title_styles)){
          add_page_css_style("#$el_id .feature-title, #$el_id .feature-price{".join(';', $title_styles )."}");
        }

        if(count($sub_title_styles)){
          add_page_css_style("#$el_id .feature-subtitle{".join(';', $sub_title_styles )."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;

    }
}

add_builder_element('el_feature',
  array(
    'title'=>esc_html__('Features List','nuno-builder'),
    'icon'=>"dashicons dashicons-list-view",
    'as_parent'=>'el_feature_item',
    'child_list'=>'vertical',
    'color'=>'#EA9571',
    'order'=>22,
    'options'=>array(
           array( 
            'heading' => esc_html__( 'Bullet Style', 'nuno-builder' ),
            'param_name' => 'list_style',
            'value'=>array(
                ''  => esc_html__('Normal','nuno-builder'),
                'number'  => esc_html__('Number','nuno-builder'),
                'icon' => esc_html__('Use Icon','nuno-builder'),
                'image' => esc_html__('Use Image','nuno-builder'),
                ),
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
                'heading' => esc_html__( 'Bullet', 'nuno-builder' ),
                'param_name' => 'tab_style',
                'type' => 'heading',
             ), 
            array( 
              'heading' => esc_html__( 'Box Size', 'nuno-builder' ),
              'param_name' => 'list_size',
              'type' => 'textfield',
              'class'=>'small',
              'default' => "",
              'description' => esc_html__( 'Bullet box size in px.', 'nuno-builder' ),
             ),     
            array( 
                'heading' => esc_html__( 'Icon Color', 'nuno-builder' ),
                'param_name' => 'icon_color',
                'value' => '',
                'type' => 'colorpicker',
             ),
            array( 
              'heading' => esc_html__( 'Font Size', 'nuno-builder' ),
              'param_name' => 'icon_size',
              'type' => 'textfield',
              'class'=>'small',
              'default' => "",
              'description' => esc_html__( 'Bullet font size in px.', 'nuno-builder' ),
             ),     
             array( 
              'heading' => esc_html__( 'Style', 'nuno-builder' ),
              'param_name' => 'bullet_style',
              'type' => 'dropdown',
              'value' => array(
                        ''=>esc_html__('Default','nuno-builder'),
                        'rounded'=>esc_html__('Rounded','nuno-builder'),
                        'circle'=>esc_html__('Circle','nuno-builder'),
                        'square'=>esc_html__('Square','nuno-builder'),
                        ),
            ),
            array( 
              'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
              'param_name' => 'border_radius',
              'type' => 'slider_value',
              'class'=>'medium',
              'params' => array('min'=>1,'max'=>200,'step'=>1),
              'dependency' => array( 'element' => 'bullet_style', 'value' => array('rounded') )
            ),
            array( 
              'heading' => esc_html__( 'Border Size', 'nuno-builder' ),
              'param_name' => 'border_size',
              'params' => array('min'=>0,'max'=>10,'step'=>1),
              'type' => 'slider_value',
              'class'=>'medium',
              "description" => esc_html__("Adjust border width.", "nuno-builder"),
              'dependency' => array( 'element' => 'bullet_style', 'not_empty' => true ),
            ),
            array( 
              'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
              'param_name' => 'border_color',
              'class' => 'small',
              'type' => 'colorpicker',
              "description" => esc_html__("Pick a color for bullet border color.", "nuno-builder"),
              'dependency' => array( 'element' => 'bullet_style', 'not_empty' => true ),
            ),
            array( 
              'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
              'param_name' => 'bg_color',
              'class' => 'small',
              'type' => 'colorpicker',
              "description" => esc_html__("Pick a color for bullet background color.", "nuno-builder"),
              'dependency' => array( 'element' => 'bullet_style', 'not_empty' => true ),
            ),
            array( 
              'heading' => esc_html__( 'Box Shadow', 'nuno-builder' ),
              'param_name' => 'box-shadow',
              'type' => 'heading',
            ),
            array( 
              'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
              'param_name' => 'b_h_shadow',
              'param_holder_class'=>'p_top',
              'type' => 'textfield',
            ),
            array( 
              'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
              'param_name' => 'b_v_shadow',
              'param_holder_class'=>'p_bottom',
              'type' => 'textfield',
            ),
            array( 
              'heading' => esc_html__( 'Blur', 'nuno-builder' ),
              'param_name' => 'b_blur_shadow',
              'param_holder_class'=>'p_left',
              'type' => 'textfield',
            ),
            array( 
              'heading' => esc_html__( 'Spread', 'nuno-builder' ),
              'param_name' => 'b_spread_shadow',
              'param_holder_class'=>'p_right',
              'type' => 'textfield',
            ),
            array(
              "type" => "colorpicker",
              "heading" => esc_html__('Shadow Color', 'nuno-builder'),
              "param_name" => "b_shadow_color",
              "description" => esc_html__("Select color for shadow", "nuno-builder"),
            ),
            array( 
                'heading' => esc_html__( 'Feature/Menu Style', 'nuno-builder' ),
                'param_name' => 'item_styles',
                'type' => 'heading',
             ), 

            array( 
              'heading' => esc_html__( 'Feature Gap', 'nuno-builder' ),
              'param_name' => 'vertical_padding',
              'param_holder_class'=>'small-wide',
              'default' => "",
              'type' => 'textfield',
              "description" => esc_html__("Vertical space between each feature ( in px ).", "nuno-builder"),
             ),
            array( 
              'heading' => esc_html__( 'Title Font Size', 'nuno-builder' ),
              'param_name' => 'font_size',
              'type' => 'slider_value',
              'class'=>'medium',
              'default' => "",
              'params'=>array('min'=>10,'max'=>200,'step'=>1),
              'description' => esc_html__( 'Title font size in px.', 'nuno-builder' ),
               ),     
            array( 
              'heading' => esc_html__( 'Sub Title Font Size', 'nuno-builder' ),
              'param_name' => 'sub_font_size',
              'type' => 'slider_value',
              'class'=>'medium',
              'default' => "",
              'params'=>array('min'=>10,'max'=>200,'step'=>1),
              'description' => esc_html__( 'Title font size in px.', 'nuno-builder' ),
             ),     
            array( 
                'heading' => esc_html__( 'Title Color', 'nuno-builder' ),
                'param_name' => 'color_heading',
                'class' => '',
                'value' => '',
                'type' => 'colorpicker',
             ), 
            array( 
                'heading' => esc_html__( 'Sub Title Color', 'nuno-builder' ),
                'param_name' => 'color_sub_heading',
                'value' => '',
                'type' => 'colorpicker',
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
              'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
              'param_name' => 'el_class',
              'type' => 'textfield',
              'value'=>"",
              'group'=>esc_html__('Advanced', 'nuno-builder'),
              ),
            array( 
              'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
              'param_name' => 'el_id',
              'type' => 'textfield',
              "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
              'group'=>esc_html__('Advanced', 'nuno-builder'),
            ),
            array( 
              'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
              'param_name' => 'z_index',
              'type' => 'textfield',
              "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
              'group'=>esc_html__('Advanced', 'nuno-builder'),
            ),
       )
    )
);

add_builder_element('el_feature_item',
 array( 
    'title' => esc_html__( 'Feature', 'nuno-builder' ),
    'as_child' => 'el_list',
    'color'=>'#13747D',
    'options' => array(
        array( 
          'heading' => esc_html__( '1st Title', 'nuno-builder' ),
          'param_name' => 'title',
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ),
        array( 
          'heading' => esc_html__( '2nd Title', 'nuno-builder' ),
          'param_name' => 'sub_title',
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ),
        array( 
          'heading' => esc_html__( 'Icon', 'nuno-builder' ),
          'param_name' => 'icon_type',
          'class' => '',
          'default' =>'',
          'value'=>'',
          'description' => esc_html__( 'Icon will display if bullet style "Use Icon" .', 'nuno-builder' ),
          'type' => 'icon_picker',
         ),
        array( 
          'heading' => esc_html__( 'Image', 'nuno-builder' ),
          'param_name' => 'bullet_image',
          'description' => esc_html__( 'Image will display if bullet style "Use Image" .', 'nuno-builder' ),
          'type' => 'image',
        ),              
        array( 
          'heading' => esc_html__( 'Price', 'nuno-builder' ),
          'param_name' => 'price',
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ),
    )
   ) 
 );
?>