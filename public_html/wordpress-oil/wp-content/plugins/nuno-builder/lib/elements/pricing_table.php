<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.1
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_pricetable_item extends BuilderElement {

    function preview($atts, $content = null) {

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'most_popular' => '',
            'layout'=>'1',
            'block_price' => "",
            'block_name' => "",
            'block_subtitle' => "",
            'block_symbol' => "",
            'oddcell_back_color' => '',
            'evencell_back_color' => '',
            'block_link' =>'',
            'get_it_now_caption' =>'',
            'el_id'=>'',
            'el_class' =>'',
            'spy'=>'',
            'scroll_delay'=>300,
            'bg_image' =>'',
            'bg_color' =>'',
            'heading_color' =>'',
            'heading_bg_color' =>'',
            'bottom_color'=>'',
            'bottom_bg_color'=>'',
            'feature_color'=>'',
            'line_style'=>'',
            'line_width'=>'',
            'line_color'=>'',            
        ), $atts ,'pricetable_item') );

        $css_class = array('price-block','layout-'.absint($layout));

       if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if('yes'==$most_popular){
          array_push($css_class, 'popular');
        }

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }


       $content=preg_replace(array('/<\/?p\>/','/<br \/?\>/'),"", trim($content));
       $price_features = @explode("\n", $content);

       $css_style=getElementCssMargin($atts,true);

       if($bg_color!=''){
          $css_style['background-color'] = 'background:'.$bg_color;
       }

       if( ''!=$bg_image && $background_image=wp_get_attachment_image_src( $bg_image, 'full' )){
          $css_style['background-image']="background-image:url(".esc_url($background_image[0]).");";
       }

       $heading_style = $bottom_style = $feature_style = '';

       if($heading_bg_color !=''){
          $heading_style = ' style="background:'.$heading_bg_color.'"';
       }

       if($heading_color !=''){
          $heading_color = ' style="color:'.$heading_color.'"';
       }

       if($bottom_bg_color !=''){
          $bottom_style = ' style="background:'.$bottom_bg_color.'"';
       }

       $compile = '<div id="'.$el_id.'" ';


        if('none'!==$spy && !empty($spy)){
            $compile.=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            get_scroll_spy_script();
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile .='<div class="price-block-inner"'.(count($css_style) ? ' style="'.@implode(";",$css_style).'"' : '').'>';

        if($layout=='1'){
          $compile .= '<div class="price-heading"'.$heading_style.'>'.
                    ($block_name!='' ? '<h3 class="price-name"'.$heading_color.'>'.esc_html($block_name).'</h3>':"");

        $compile .= ($block_subtitle!='' ? '<h4 class="price-description"'.$heading_color.'>'.esc_html($block_subtitle).'</h4>':"").
                    '<p class="price-value"'.$heading_color.'><span class="price-symbol">'.esc_html($block_symbol).'</span>'.esc_html($block_price).'</p>';

        }else{
          $compile .= ($block_name!='' ? '<h3 class="price-name"'.$heading_color.'>'.esc_html($block_name).'</h3>':"");
          $compile .= '<div class="price-heading"'.$heading_style.'>';

          $compile .= '<p class="price-value"'.$heading_color.'><span class="price-symbol">'.esc_html($block_symbol).'</span>'.esc_html($block_price).'</p>'.
          ($block_subtitle!='' ? '<h4 class="price-description"'.$heading_color.'>'.esc_html($block_subtitle).'</h4>':"");

        }


        $compile .= '</div>';
        $compile .= '<ul class="price-features">';

        if(count($price_features)){

          $i= 1;

          $feature_styles = array();
          if($feature_color!=''){
            $feature_styles[] = 'color:'.$feature_color;
          }

          if($line_color!=''){
            $feature_styles[] = 'border-bottom-color:'.$line_color;
          }
          
          if($line_style!=''){
            $feature_styles[] = 'border-bottom-style:'.$line_style;
          }

          if($line_width!=''){
            $feature_styles[] = 'border-bottom-width:'.$line_width;
          }

          if(count($feature_styles)){
            $feature_style = join(';',$feature_styles);
          }

          $price_features = array_filter($price_features, create_function('$value', ' return $value !== \'\';') );

          $count_feature = count($price_features);

          foreach ($price_features as $feature) {

                if($feature=='') continue;

                  $color=($i%2==0)?(($evencell_back_color!='')? $evencell_back_color :""):(($oddcell_back_color!='')? $oddcell_back_color :"");
                  if($count_feature == $i){
                   $compile.='<li style="background-color:'.$color.';color:'.$feature_color.'">'.esc_html($feature).'</li>';
                  }
                  else{
                    $compile.='<li style="background-color:'.$color.';'.$feature_style.'">'.esc_html($feature).'</li>';
                  }

                  $i++;

          }
        }
        $compile .= '</ul>';
        $compile .= '<div class="price-footer"'.$bottom_style.'>';

        if($get_it_now_caption!=''){
          $compile .= do_shortcode('[el_btn url="'.$block_link.'" style="custom-color" text="'.$get_it_now_caption.'" btn_text_color="'.$bottom_color.'" btn_border_color="'.$bottom_color.'"][/el_btn]');
        }

        $compile .= '</div></div></div>';

        return $compile;

    }
} 

add_builder_element('pricetable_item',
 array( 
    'title' => esc_html__( 'Price Item', 'nuno-builder' ),
    'icon'  =>'fa fa-map',
    'color'=>'#b33e6f',
    'order'=>21,
    'show_on_create'=> false,
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
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
        ),
        array( 
        'heading' => esc_html__( 'Style', 'nuno-builder' ),
        'param_name' => 'layout',
        'value' => array('1'=>esc_html__('Layout 1','nuno-builder'),'2'=>esc_html__('Layout 2','nuno-builder')),
        'type' => 'radio',
        'default'=>'1'
         ),
        array( 
        'heading' => esc_html__( 'Most popular', 'nuno-builder' ),
        'param_name' => 'most_popular',
        'value' => array('yes'=>esc_html__('Yes','nuno-builder'),'no'=>esc_html__('No','nuno-builder')),
        'type' => 'radio',
        'default'=>'no'
         ),
        array( 
        'heading' => esc_html__( 'Package Name', 'nuno-builder' ),
        'param_name' => 'block_name',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Package Description', 'nuno-builder' ),
        'param_name' => 'block_subtitle',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Currency Symbol', 'nuno-builder' ),
        'param_name' => 'block_symbol',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Price', 'nuno-builder' ),
        'param_name' => 'block_price',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Package Detail', 'nuno-builder' ),
        'param_name' => 'content',
        'value' => '',
        'description' => esc_html__( 'Type package detail in single line (without breakline/enter). Each breakline is automatically detected as new detail item', 'nuno-builder' ),
        'type' => 'textarea'
         ),
        array( 
        'heading' => esc_html__( 'Button Link', 'nuno-builder' ),
        'param_name' => 'block_link',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Button Text', 'nuno-builder' ),
        'param_name' => 'get_it_now_caption',
        'value' => '',
        'type' => 'textfield'
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
        array( 
          'heading' => esc_html__( 'Background', 'nuno-builder' ),
          'param_name' => 'background',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'bg_image',
          'type' => 'image',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Heading Section', 'nuno-builder' ),
          'param_name' => 'block_heading',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'heading_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'heading_bg_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Features Section', 'nuno-builder' ),
          'param_name' => 'block_features',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'feature_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Line Style', 'nuno-builder' ),
          'param_name' => 'line_style',
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
          'heading' => esc_html__( 'Line Width', 'nuno-builder' ),
          'param_name' => 'line_width',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Line Color', 'nuno-builder' ),
          'param_name' => 'line_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Section', 'nuno-builder' ),
          'param_name' => 'block_bottom',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'bottom_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bottom_bg_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),

        )
 ) );
?>
