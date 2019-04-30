<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder Addon
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('GUM_BUILDER_BASENAME') or die();

function gum_el_iconbox_element_render($html,$content, $atts){

        wp_enqueue_style( 'awesomeicon');

        extract( shortcode_atts( array(
            'el_class'=>'',
            'el_id'=>'',
            'iconbox_heading' => '',
            'decoration'=>'',
            'decoration_color'=>'',
            'layout'=>'',
            'content_align'=>'',
            'icon_position'=>'',
            'size'=>'full',
            'color_heading'=>'',
            'icon_type' => '',
            'target' => '_blank',
            'iconbox_text'=>'',
            'image'=>'',
            'link' => '',
            'label_link' =>'',
            'spy'=>'none',
            'icon_size'=>'',
            'icon_color'=>'',
            'icon_shape'=>'',
            'icon_bgcolor'=>'',
            'icon_bordercolor'=>'',
            'icon_border_style'=>'',
            'icon_borderwidth'=>'',        
            'icon_width'=>'',
            'icon_height'=>'',
            'font_weight'=>'',
            'bg_color'=>'',
            'color_heading_hover'=>'',
            'icon_color_hover'=>'',
            'icon_bgcolor_hover'=>'',
            'bg_color_hover'=>'',
            'border_color_hover'=>'',
            'h_shadow_hover'=>'',
            'v_shadow_hover'=>'',
            'blur_shadow_hover'=>'',
            'spread_shadow_hover'=>'',
            'shadow_color_hover'=>'',
            'scroll_delay'=>300
        ), $atts,'el_iconbox' ) );

        $content=(empty($content) && !empty($iconbox_text))?$iconbox_text:$content;

         $scollspy="";

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $css_class=array('module-iconboxes','style-'.$layout);

        if($content_align!=''){
          array_push($css_class, 'content-align-'.sanitize_html_class($content_align));
        }

        if($layout == '8' && $icon_position!=''){
          array_push($css_class, 'icon-align-'.sanitize_html_class($icon_position));
        }

        if(''!=$el_class){
           array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts, true);

        if($bg_color!=''){
          $css_style[]='background-color:'.sanitize_hex_color($bg_color);
        }

        if('none'!==$spy && !empty($spy)){
            $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}"';
            if(function_exists('get_scroll_spy_script')) get_scroll_spy_script();
        }

        $icons_style = $icons_hover_style = $heading_style = $hover_box = array();

        if($icon_color!=''){
            $icons_style[] = 'color:'.$icon_color.';';
        }

        if($icon_size!=''){
           $icons_style[] = 'font-size:'.$icon_size.'px;';
        }

        if($icon_width!=''){
           $icons_style[] = 'width:'.absint($icon_width).'px;';
        }

        if($icon_height!=''){
           $icons_style[] = 'height:'.absint($icon_height).'px;';
        }

        if($icon_bgcolor!=''){
           $icons_style[] = 'background:'.$icon_bgcolor;          
        }

        if($icon_shape == 'circle'){
           $icons_style[] = 'border-radius: 50%';                    
        }

        if($icon_bordercolor!=''){
           $icons_style[] = 'border-color:'.$icon_bordercolor;          
        }

        if($icon_border_style!=''){
           $icons_style[] = 'border-style:'.$icon_border_style;          
        }

        if($icon_borderwidth!=''){
           $icons_style[] = 'border-width:'.absint($icon_borderwidth).'px';          
        }

       if(!empty($color_heading)){
            $heading_style['color']="color:".$color_heading;
        }


        if(!empty($font_weight) && $font_weight!='default'){
            $heading_style['font-weight']="font-weight:".$font_weight;
        }

        $output='<div class="iconboxes-wrap" '. $scollspy.'>';

        if($layout=='6'){
            $output.='<div class="line-top"></div>';
        }

        if($layout=='7'){

            $thumb_image=get_image_size($image,$size);

            if($thumb_image){
                $image_alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);

                $output.='<div class="media"><img class="img-responsive" src="'.esc_url($thumb_image[0]).'" alt="'.esc_attr($image_alt_text).'"/></div>';
            }

            $output.='<div class="icon-body">';
        }

  
        $output.='<span class="box">'.((strlen($link)>0) ?"<a target='".$target."' href='".esc_url($link)."'>":"").'<i '.(count($icons_style)? ' style="'.join(';',$icons_style).'"':"").' class="'.esc_attr($icon_type).'">&nbsp;</i>'.((strlen($link)>0) ?"</a>":"").'</span>';
        $output.='<div class="text-wrap">';
        
        if($iconbox_heading!=''){
            $output.='<h4 class="box-heading'.(absint($decoration) ? " decoration":"").'" '.(count($heading_style)? 'style="'.join(';',$heading_style).'"':'').'>'.$iconbox_heading.'</h4>';
            if(absint($decoration) && $decoration_color!=''){
              add_page_css_style("#$el_id .box-heading:after{background-color:".$decoration_color.";}");
            }
        }
        
        $output.='<div class="iconboxes-text">'.((!empty($content))?do_shortcode($content):"");

        if($label_link!='' && strlen($link)>0 ){
            $output.= '<a target="'.$target.'" href="'.esc_url($link).'" class="more-link">'.esc_html($label_link).'</a>';
        }

        $output.='</div></div>';
        if($layout=='6'){
            $output.='<div class="line-bottom"></div>';
        }

        if($layout=='7'){
  
          $output .='</div>';

        }

        $output .='</div>';


       $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=$output."</div>";

       if($icon_color_hover!=''){
            $icons_hover_style[] = 'color:'.$icon_color_hover.'!important';
        }

        if($icon_bgcolor_hover!=''){
           $icons_hover_style[] = 'background-color:'.$icon_bgcolor_hover.'!important';          
        }

        if($border_color_hover!=''){
          $hover_box['border-color']="border-color:".$border_color_hover;
        }

        if($bg_color_hover!=''){
          $hover_box['background-color']="background-color:".$bg_color_hover;
          
          add_page_css_style("#$el_id:hover .iconboxes-wrap{background-color:".$bg_color_hover."}");

        }

        if($shadow_color_hover!='' && ($h_shadow_hover!='' || $v_shadow_hover!='' || $spread_shadow_hover!='' || $blur_shadow_hover!='')){

          $h_shadow_hover = absint($h_shadow_hover);
          $v_shadow_hover = absint($v_shadow_hover);
          $blur_shadow_hover = absint($blur_shadow_hover);
          $spread_shadow_hover = absint($spread_shadow_hover);

          $hover_box['box-shadow']="box-shadow:".$h_shadow_hover."px ".$v_shadow_hover."px ".$blur_shadow_hover."px ".$spread_shadow_hover."px ".$shadow_color_hover.";";

        }

        if($color_heading_hover!=''){
            add_page_css_style("#$el_id:hover .box-heading{color:".$color_heading_hover."!important;}");
        }

        if(count($icons_hover_style)){
            add_page_css_style("#$el_id:hover .box i{".join(';',$icons_hover_style).";}");
        }


        if(count($css_style)){

            add_page_css_style("#$el_id {".join(';',$css_style).";}");
        }

        if(count($hover_box)){
          add_page_css_style("#$el_id:hover {".join(';',$hover_box).";}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;

}


add_builder_element_render('el_iconbox','gum_el_iconbox_element_render');

add_builder_element_preview('el_iconbox' ,'gum_el_iconbox_element_render');


add_builder_element_option('el_iconbox',array(
                 'heading' => esc_html__( 'Layout', 'nuno-builder' ),
                  'param_name' => 'layout',
                  'type' => 'dropdown',
                  'value' => array(
                            '8'=>esc_html__('Icon Top','nuno-builder'),
                            '9'=>esc_html__('Icon Align Left','nuno-builder'),
                            '10'=>esc_html__('Icon Align Right','nuno-builder'),
                            '1'=>esc_html__('Icon Top (Animated)','nuno-builder'),
                            '2'=>esc_html__('Icon Align Left (Animated)','nuno-builder'),
                            '3'=>esc_html__('Icon Align Right (Animated)','nuno-builder'),
                            '4'=>esc_html__('Icon Animated From left','nuno-builder-addon'),
                            '5'=>esc_html__('Icon Animated From Right','nuno-builder-addon'),
                            '6'=>esc_html__('Icon Centered with Edges','nuno-builder-addon'),
                            '7'=>esc_html__('Icon Animated with Image','nuno-builder-addon'),
                            '11'=>esc_html__('Icon with content slide-up','nuno-builder'),
                           )
            ),true);


add_builder_element_option('el_iconbox',
            array(
                 'heading' => esc_html__( 'Image', 'nuno-builder-addon' ),
                  'param_name' => 'image',
                  'type' => 'image',
                  'dependency' => array( 'element' => 'layout', 'value' => array( '7') )
            ),'layout');

add_builder_element_option('el_iconbox',
            array(
                 'heading' => esc_html__( 'Icon Position', 'nuno-builder-addon' ),
                  'param_name' => 'icon_position',
                  'type' => 'dropdown',
                  'value' => array(
                            ''=>esc_html__('Default','nuno-builder'),
                            'left'=>esc_html__('Left','nuno-builder'),
                            'center'=>esc_html__('Center','nuno-builder'),
                            'right'=>esc_html__('Right','nuno-builder'),
                            ),
                  'dependency' => array( 'element' => 'layout', 'value' => array( '8') )
            ),'layout');

add_builder_element_option('el_iconbox',
            array( 
              'heading' => esc_html__( 'Image Size', 'nuno-builder' ),
              'param_name' => 'size',
              'type' => 'textfield',
              'value'=>"",
              'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'nuno-builder' ),
              'dependency' => array( 'element' => 'layout', 'value' => array( '7') )
            ),'image');

add_builder_element_option('el_iconbox',
            array( 
              'heading' => esc_html__( 'Use Decoration', 'nuno-builder-addon' ),
              'param_name' => 'decoration',
              'type' => 'radio',
              'default' => '0',
              'value' => array(
                '1' => esc_html__('Yes','nuno-builder'),
                '0' => esc_html__('No','nuno-builder')
                ),
              'group'=>esc_html__('Styles', 'nuno-builder'),
              'description' => esc_html__( 'Show coloring line after heading.', 'nuno-builder-addon' ),
            ),'font_weight');

add_builder_element_option('el_iconbox',
            array( 
              'heading' => esc_html__( 'Decoration color', 'nuno-builder-addon' ),
              'param_name' => 'decoration_color',
              'type' => 'colorpicker',
              'default' => '',
              'value' => '',
              'group'=>esc_html__('Styles', 'nuno-builder'),
              'description' => esc_html__( 'Decoration line color.', 'nuno-builder-addon' ),
              'dependency' => array( 'element' => 'decoration', 'value' => array( '1') )
            ),'decoration');
?>
