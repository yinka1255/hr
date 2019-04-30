<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_row extends BuilderElement{

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'image'=>'',
            'font_color'=>'',
            'background_style'=>'',
            'background_video'=>'',
            'background_video_webm'=>'',
            'background_type' =>'image',
            'background_poster'=>'',
            'bg_color'=>'',
            'bg_over_color'=>'',
            'scroll_delay'=>300,
            'equal_height'=>0,
            'justify_content'=>'default',
            'spy'=>''
        ), $atts, 'el_row' ) );

        $css_class=array('el_row');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if($justify_content!='' && $justify_content!='default'){
            array_push($css_class, 'content-align_'.sanitize_html_class($justify_content));
        }

        if(''==$el_id){
            $el_id="element_".getElementTagID().time().rand(11,99);
        }

        $css_style=getElementCssMargin($atts,true);

        if((bool) $equal_height){
            array_push($css_class, 'column_equal_height');
          }

        $video="";

        if(''!=$bg_color){$css_style['background-color']="background-color:$bg_color";}
        if($background_type=='image' && ''!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){

              $css_style['background-image']="background-image:url(".esc_url($background_image[0]).")!important;";

              switch($background_style){
                  case'cover':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
                      break;
                  case'no-repeat':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
                      break;
                  case'repeat':
                      $css_style['background-position']="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
                      break;
                  case'contain':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
                      break;
                  case 'fixed':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
                      break;
              }

        }
        elseif($background_type=='video' && ($background_video!='' || $background_video_webm!='')){

            $source_video=array();

            if($background_video!=''){

              $video_url=wp_get_attachment_url(intval($background_video));
              $videodata=wp_get_attachment_metadata(intval($background_video));

              if(''!=$video_url && $background_type=='video'){

                array_push($css_class,'has-video');

                $videoformat="video/mp4";
                if(is_array($videodata) && $videodata['mime_type']=='video/webm'){
                     $videoformat="video/webm";
                }

                $source_video[]="<source src=\"".esc_url($video_url)."\" type=\"".$videoformat."\" />";
               }
            }

            if($background_video_webm!=''){

              $video_url=wp_get_attachment_url(intval($background_video_webm));
              $videodata=wp_get_attachment_metadata(intval($background_video_webm));

              if(''!=$video_url && $background_type=='video'){

                array_push($css_class,'has-video');

                $videoformat="video/mp4";
                if(is_array($videodata) && $videodata['mime_type']=='video/webm'){
                     $videoformat="video/webm";
                }

                $source_video[]="<source src=\"".esc_url($video_url)."\" type=\"".$videoformat."\" />";
               }
            }

            if(count($source_video)){

              $poster="";

              if($background_poster!='' && $poster_image=wp_get_attachment_image_src( $background_poster, 'full' )){
                if(isset($poster_image[0]) && $poster_image[0]!='') $poster=$poster_image[0];
              }

              $video="<video class=\"video_background\" poster=\"".$poster."\" autoplay loop>\n".@implode("\n", $source_video)."</video>";

            }
        }

        $compile="";

        array_push($css_class,'row');
        $compile.="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

       if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            get_scroll_spy_script();
        }

        $compile.="class=\"".@implode(" ",$css_class)."\"><div class=\"inner-row\">";
        $compile.=$video.do_shortcode($content);
        $compile.="</div></div>";

        if(''!=$font_color){
          add_page_css_style("#$el_id > .inner-row * {color:$font_color}");
        }

        if(''!=$bg_over_color){
          add_page_css_style("#$el_id > .inner-row:before{background-color:$bg_over_color}");
        }

        if(count($css_style)){

          add_page_css_style("#$el_id > .inner-row {".@implode(";",$css_style)."}");
        }

        nuno_add_element_margin_style("#$el_id > .inner-row",$atts);

        return $compile;

    }
}

class BuilderElement_el_inner_row extends BuilderElement{

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'image'=>'',
            'background_style'=>'',
            'bg_color'=>'',
            'bg_over_color'=>'',
            'font_color'=>'',
            'equal_height'=>0,
            'justify_content'=>'default'), $atts,'el_inner_row' ) );

        $css_class=array('row','el_row');
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }



        if($justify_content!='' && $justify_content!='default'){
            array_push($css_class, 'content-align_'.sanitize_html_class($justify_content));
        }


        if((bool) $equal_height){
            array_push($css_class, 'column_equal_height');
        }

        if(''==$el_id){
            $el_id="element_".getElementTagID().time().rand(11,99);
        }

        $css_style=getElementCssMargin($atts,true);

        if(''!=$bg_color){$css_style['background-color']="background-color:$bg_color";}
        if(''!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){

              $css_style['background-image']="background-image:url(".esc_url($background_image[0]).")!important;";

              switch($background_style){
                  case'cover':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
                      break;
                  case'no-repeat':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
                      break;
                  case'repeat':
                      $css_style['background-position']="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
                      break;
                  case'contain':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
                      break;
                  case 'fixed':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
                      break;
              }

        }

        $compile="";
        $compile.="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }
        $compile.="class=\"".@implode(" ",$css_class)."\"><div class=\"inner-row\">";
        $compile.=do_shortcode($content);
        $compile.="</div></div>";

        if(''!=$font_color){
          add_page_css_style("#$el_id > .inner-row * {color:$font_color}");
        }

        if(''!=$bg_over_color){
          add_page_css_style("#$el_id > .inner-row:before{background-color:$bg_over_color}");
        }

        if(count($css_style)){
          add_page_css_style("#$el_id > .inner-row {".@implode(";",$css_style)."}");
        }

        nuno_add_element_margin_style("#$el_id > .inner-row",$atts);

        return $compile;
  }
}

class BuilderElement_el_inner_row_1 extends BuilderElement_el_inner_row{}
class BuilderElement_el_inner_row_2 extends BuilderElement_el_inner_row{}
class BuilderElement_el_inner_row_3 extends BuilderElement_el_inner_row{}

class BuilderElement_el_column extends BuilderElement{

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'column'=>12,
            'title'=>'',
            'el_id' => '',
            'el_class'=>'',
            'image'=>'',
            'background_style'=>'',
            'bg_color'=>'',
            'bg_over_color'=>'',
            'font_color'=>'',
            'justify_content'=>'default',
            'align_items'=>'',
        ), $atts,'el_column' ) );

        $css_class=array('el_column');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if($justify_content!='' && $justify_content!='default'){
            array_push($css_class, 'self-align_'.sanitize_html_class($justify_content));
        }

        if(''!=$align_items){
            array_push($css_class, 'align-'.$align_items);
        }


        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $css_style=getElementCssMargin($atts,true);

        if(''!=$bg_color){$css_style['background-color']="background-color:$bg_color";}
        if(''!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){

              $css_style['background-image']="background-image:url(".esc_url($background_image[0]).")!important;";

               switch($background_style){
                  case'cover':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
                      break;
                  case'no-repeat':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
                      break;
                  case'repeat':
                      $css_style['background-position']="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
                      break;
                  case'contain':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
                      break;
                  case 'fixed':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
                      break;
              }

        }

        $css_column=(in_array($column,array(1,2,3,4,5,6,7,8,9,10,11,12)))?"col-md-".min($column,12):"column_custom_".$column;
        array_push($css_class,$css_column);

       
        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }
        $compile.="class=\"".@implode(" ",$css_class)."\"><div class=\"inner-column\">";
        $compile.=do_shortcode($content);
        $compile.="</div></div>";

        if(''!=$font_color){
          add_page_css_style("#$el_id * {color:$font_color}");
        }

        if(''!=$bg_over_color){
          add_page_css_style("#$el_id > .inner-column:before{background-color:$bg_over_color}");
        }

        if(count($css_style)){
          add_page_css_style("#$el_id > .inner-column{".@implode(";",$css_style)."}");
        }
        
        nuno_add_element_margin_style("#$el_id > .inner-column",$atts);

        return $compile;

    }
}

class BuilderElement_el_inner_column extends BuilderElement_el_column{}
class BuilderElement_el_inner_column_1 extends BuilderElement_el_column{}
class BuilderElement_el_inner_column_2 extends BuilderElement_el_column{}
class BuilderElement_el_inner_column_3 extends BuilderElement_el_column{}


add_builder_element('el_row',
  array(
    'title'=>esc_html__('Row','nuno-builder'),
    'icon'=>'dashicons dashicons-editor-justify',
    'color'=>'#1c1c1e',
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
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
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
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Right', 'nuno-builder' ),
          'param_name' => 'br_bottom_right',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Left', 'nuno-builder' ),
          'param_name' => 'br_bottom_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Border', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Left', 'nuno-builder' ),
          'param_name' => 'br_top_left',
          'param_holder_class'=>'p_right',
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
          'heading' => esc_html__( 'Column Equal Height', 'nuno-builder' ),
          'param_name' => 'equal_height',
          'value' => array('1'=>esc_html__( 'Yes', 'nuno-builder' ),'0'=>esc_html__( 'No', 'nuno-builder' )),
          'type' => 'radio',
          'default'=>'0'
        ),
      array( 
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder')),
          'type' => 'radio',
          'default'=>'default',
          'dependency' => array( 'element' => 'equal_height', 'value' => '1' )   
        ),
      array( 
          'heading' => esc_html__( 'Background Type', 'nuno-builder' ),
          'param_name' => 'background_type',
          'value' => array('image'=>esc_html__( 'Image', 'nuno-builder' ),'video'=>esc_html__( 'Video', 'nuno-builder' )),
          'type' => 'radio',
          'default'=>'image'
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
          'dependency' => array( 'element' => 'background_type', 'value' => array('image') )   
        ),
        array( 
          'heading' => esc_html__( 'Background Video (mp4)', 'nuno-builder' ),
          'param_name' => 'background_video',
          'type' => 'video',
          'params'=>array('mime_type'=>'video/mp4'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
        ),
       array( 
          'heading' => esc_html__( 'Background Video (webm)', 'nuno-builder' ),
          'param_name' => 'background_video_webm',
          'type' => 'video',
          'params'=>array('mime_type'=>'video/webm'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
       ),
       array( 
          'heading' => esc_html__( 'Image Thumb/Poster', 'nuno-builder' ),
          'param_name' => 'background_poster',
          'type' => 'image',
          'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
       ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder') ,
                'contain' => esc_html__('Contain', 'nuno-builder') ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder') ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder') ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder') ,
              ),
          'dependency' => array( 'element' => 'background_type', 'value' => array('image') )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker'
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
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


add_builder_element('el_inner_row',
  array(
    'title'=>esc_html__('Row','nuno-builder'),
    'color'=>'#0a3648',
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
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
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
        ),        array(
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
          'heading' => esc_html__( 'Column Equal Height', 'nuno-builder' ),
          'param_name' => 'equal_height',
          'value' => array('1'=>esc_html__( 'Yes', 'nuno-builder' ),'0'=>esc_html__( 'No', 'nuno-builder' )),
          'type' => 'radio',
          'default'=>'0'
        ),
      array( 
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder')),
          'type' => 'radio',
          'default'=>'default',
          'dependency' => array( 'element' => 'equal_height', 'value' => '1' )   
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
      )
    )
);

add_builder_element('el_inner_row_1',
  array(
    'title'=>esc_html__('Row','nuno-builder'),
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
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
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
        ),        array(
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
          'heading' => esc_html__( 'Column Equal Height', 'nuno-builder' ),
          'param_name' => 'equal_height',
          'value' => array('1'=>esc_html__( 'Yes', 'nuno-builder' ),'0'=>esc_html__( 'No', 'nuno-builder' )),
          'type' => 'radio',
          'default'=>'0'
        ),
      array( 
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder')),
          'type' => 'radio',
          'default'=>'default',
          'dependency' => array( 'element' => 'equal_height', 'value' => '1' )   
        ),        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),

       )
    )
);

add_builder_element('el_inner_row_2',
  array(
    'title'=>esc_html__('Row','nuno-builder'),
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
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
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
        ),        array(
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
          'heading' => esc_html__( 'Column Equal Height', 'nuno-builder' ),
          'param_name' => 'equal_height',
          'value' => array('1'=>esc_html__( 'Yes', 'nuno-builder' ),'0'=>esc_html__( 'No', 'nuno-builder' )),
          'type' => 'radio',
          'default'=>'0'
        ),
      array( 
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder')),
          'type' => 'radio',
          'default'=>'default',
          'dependency' => array( 'element' => 'equal_height', 'value' => '1' )   
        ),        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
       )
    )
);

add_builder_element('el_inner_row_3',
  array(
    'title'=>esc_html__('Row','nuno-builder'),
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
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
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
        ),        array(
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
          'heading' => esc_html__( 'Column Equal Height', 'nuno-builder' ),
          'param_name' => 'equal_height',
          'value' => array('1'=>esc_html__( 'Yes', 'nuno-builder' ),'0'=>esc_html__( 'No', 'nuno-builder' )),
          'type' => 'radio',
          'default'=>'0'
        ),
      array( 
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder')),
          'type' => 'radio',
          'default'=>'default',
          'dependency' => array( 'element' => 'equal_height', 'value' => '1' )   
        ),        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
       )
    )
);

add_builder_element('el_column',
  array(
    'title'=>esc_html__('Column','nuno-builder'),
    'color'=>'#74747c',
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
          "description" => esc_html__("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
        ),
         array( 
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
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
        ),        array(
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
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder'),'top'=>esc_html('Top','nuno-builder')),
          'type' => 'radio',
          'description'=>esc_html('Just work if parent row in equal height mode.','nuno-builder'),
          'default'=>'default',
        ),
        array( 
            'heading' => esc_html__( 'Content Align', 'nuno-builder' ),
            'param_name' => 'align_items',
            'value' => array(''=>esc_html__( 'Default', 'nuno-builder' ),'left'=>esc_html('Left','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'right'=>esc_html('Right','nuno-builder')),
            'type' => 'radio',
            'default'=>'',
          ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
        )
    )
);

add_builder_element('el_inner_column',
  array(
    'title'=>esc_html__('Column','nuno-builder'),
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
          "description" => esc_html__("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
        ),
         array( 
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
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
        array( 
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder'),'top'=>esc_html('Top','nuno-builder')),
          'type' => 'radio',
          'description'=>esc_html('Just work if parent row in equal height mode.','nuno-builder'),
          'default'=>'default',
        ),
        array( 
            'heading' => esc_html__( 'Content Align', 'nuno-builder' ),
            'param_name' => 'align_items',
            'value' => array(''=>esc_html__( 'Default', 'nuno-builder' ),'left'=>esc_html('Left','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'right'=>esc_html('Right','nuno-builder')),
            'type' => 'radio',
            'default'=>'',
          ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
       )
    )
);

add_builder_element('el_inner_column_1',
  array(
    'title'=>esc_html__('Column','nuno-builder'),
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
          "description" => esc_html__("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
        ),
         array( 
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
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
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder'),'top'=>esc_html('Top','nuno-builder')),
          'type' => 'radio',
          'description'=>esc_html('Just work if parent row in equal height mode.','nuno-builder'),
          'default'=>'default',
        ),
        array( 
            'heading' => esc_html__( 'Content Align', 'nuno-builder' ),
            'param_name' => 'align_items',
            'value' => array(''=>esc_html__( 'Default', 'nuno-builder' ),'left'=>esc_html('Left','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'right'=>esc_html('Right','nuno-builder')),
            'type' => 'radio',
            'default'=>'',
          ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
       )
    )
);


add_builder_element('el_inner_column_2',
  array(
    'title'=>esc_html__('Column','nuno-builder'),
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
          "description" => esc_html__("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
        ),
         array( 
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
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
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder'),'top'=>esc_html('Top','nuno-builder')),
          'type' => 'radio',
          'default'=>'default',
          'description'=>esc_html('Just work if parent row in equal height mode.','nuno-builder'),
        ),
        array( 
            'heading' => esc_html__( 'Content Align', 'nuno-builder' ),
            'param_name' => 'align_items',
            'value' => array(''=>esc_html__( 'Default', 'nuno-builder' ),'left'=>esc_html('Left','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'right'=>esc_html('Right','nuno-builder')),
            'type' => 'radio',
            'default'=>'',
          ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
       )
    )
);


add_builder_element('el_inner_column_3',
  array(
    'title'=>esc_html__('Column','nuno-builder'),
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
          "description" => esc_html__("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
        ),
         array( 
        'heading' => esc_html__( 'Overflow','nuno-builder' ),
        'param_name' => 'css_overflow',
        'description' => esc_html__( 'Overflow css properties.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'default'   => esc_html__( 'Default', 'nuno-builder'),
            'hidden'  => esc_html__( 'Hidden', 'nuno-builder'),
            'visible'     => esc_html__( 'Visible', 'nuno-builder'),
            'inherit'     => esc_html__( 'Inherit', 'nuno-builder'),
            'auto'       => esc_html__( 'Auto', 'nuno-builder'),
            'unset'      => esc_html__( 'Unset', 'nuno-builder'),
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
          'heading' => esc_html__( 'Content Distribution', 'nuno-builder' ),
          'param_name' => 'justify_content',
          'value' => array('default'=>esc_html__( 'Default', 'nuno-builder' ),'justify'=>esc_html('Justify','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'bottom'=>esc_html('Bottom','nuno-builder'),'top'=>esc_html('Top','nuno-builder')),
          'type' => 'radio',
          'default'=>'default',
          'description'=>esc_html('Just work if parent row in equal height mode.','nuno-builder'),
        ),
        array( 
            'heading' => esc_html__( 'Content Align', 'nuno-builder' ),
            'param_name' => 'align_items',
            'value' => array(''=>esc_html__( 'Default', 'nuno-builder' ),'left'=>esc_html('Left','nuno-builder'),'center'=>esc_html__( 'Center', 'nuno-builder' ),'right'=>esc_html('Right','nuno-builder')),
            'type' => 'radio',
            'default'=>'',
          ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Font Color', 'nuno-builder'),
          "param_name" => "font_color",
          "description" => esc_html__("Select font color", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Background Image', 'nuno-builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => esc_html__( 'Background Image Style', 'nuno-builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => esc_html__("Cover", 'nuno-builder')  ,
                'contain' => esc_html__('Contain', 'nuno-builder')  ,
                'no-repeat' => esc_html__('No Repeat', 'nuno-builder')  ,
                'repeat'  => esc_html__('Repeat', 'nuno-builder')  ,
               'fixed'  => esc_html__("Fixed", 'nuno-builder')  ,
              ),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        array( 
          'heading' => esc_html__( 'Overlay Background Color', 'nuno-builder' ),
          'param_name' => 'bg_over_color',
          'type' => 'colorpicker',
          'description' => esc_html__( 'The background color over image background.', 'nuno-builder' ),
        ),
       )
    )
);
?>
