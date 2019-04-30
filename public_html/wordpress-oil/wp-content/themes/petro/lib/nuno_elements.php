<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

/**
 * nuno builder element
 * @since Petro 1.0.0
*/ 

function petro_load_main_style(){
  wp_enqueue_style( "petro-nuno-style",get_template_directory_uri() . '/css/nuno_blocks.css', array(), '', 'all' );
  wp_enqueue_style( "petro-glyph",get_template_directory_uri() . '/fonts/petro-construction/petro-construction.css', array(), '', 'all' );
}

add_action('themegum-glyph-icon-loaded','petro_load_main_style');

$row_params= array(
  'heading' => esc_html__( 'Row Mode', 'petro' ),
  'param_name' => 'box_mode',
  'type' => 'radio',
  'value'=>array(
        'wide' => esc_html__("Default", 'petro') ,
        'boxed' => esc_html__('Boxed', 'petro') ,
        'expanded' => esc_html__('Expand Background', 'petro') ,
      ),
);

add_builder_element_option( 'el_row',$row_params );

function petro_nuno_row_render($html, $content,$atts){

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
        'spy'=>'',
        'box_mode'=>''
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

          $video_url=wp_get_attachment_url(absint($background_video_webm));
          $videodata=wp_get_attachment_metadata(absint($background_video_webm));

          if(''!=$video_url && $background_type=='video'){

            array_push($css_class,'has-video');

            $videoformat="video/mp4";
            if(is_array($videodata) && $videodata['mime_type']=='video/webm'){
                 $videoformat="video/webm";
            }

            $source_video[]="<source src=\"".esc_url($video_url)."\" type=\"".esc_attr($videoformat)."\" />";
           }
        }

        if(count($source_video)){

          $poster="";

          if($background_poster!='' && $poster_image=wp_get_attachment_image_src( $background_poster, 'full' )){
            if(isset($poster_image[0]) && $poster_image[0]!='') $poster=$poster_image[0];
          }

          $video="<video class=\"video_background\" poster=\"".esc_attr($poster)."\" autoplay loop>\n".@implode("\n", $source_video)."</video>";

        }
    }

    $compile="<div class=\"container-fluid\">";

    if($box_mode=='boxed'){
	    $compile.="<div class=\"container\">";
    }

    array_push($css_class,'row');
    $compile.="<div ";

    if(''!=$el_id){
        $compile.="id=\"$el_id\" ";
    }

   if('none'!==$spy && !empty($spy)){
        $compile.='data-uk-scrollspy="{cls:\''.esc_attr($spy).'\', delay:'.absint($scroll_delay).'}" ';
    }

    $compile.="class=\"".@implode(" ",$css_class)."\"><div class=\"inner-row\">";
    $compile.=$video;
    
    if($box_mode=='expanded'){
	    $compile.="<div class=\"container\"><div class=\"row\">";
    }

    $compile.=do_shortcode($content);


    if($box_mode=='expanded'){
	    $compile.="</div></div>";
    }

    $compile.="</div></div>";

    if($box_mode=='boxed'){
	    $compile.="</div>";
    }

    $compile.="</div>";

    if(''!=$font_color){
      add_page_css_style("#$el_id > .inner-row * {color:$font_color}");
    }

    if(count($css_style)){
      add_page_css_style("#$el_id > .inner-row {".@implode(";",$css_style)."}");
    }

    if(''!=$bg_over_color){
      add_page_css_style("#$el_id > .inner-row:before{background-color:$bg_over_color}");
    }



    if(function_exists('nuno_add_element_margin_style')){
      nuno_add_element_margin_style("#$el_id > .inner-row",$atts);
    }


	return $compile;
}


add_builder_element_render( 'el_row','petro_nuno_row_render');

$row_params= array(
  'heading' => esc_html__( 'Link Target', 'petro' ),
  'param_name' => 'target',
  'type' => 'dropdown',
        'value'=>array(
            '_self' => esc_html__('Self','petro'),
            '_blank'  => esc_html__('Blank','petro'),
            'lightbox'  => esc_html__('Lightbox','petro')
          )
);

add_builder_element_option( 'el_image',$row_params );

function petro_nuno_el_image($html, $content,$atts){

       extract( shortcode_atts( array(
            'border_color' => '',
            'border' => '',
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

        if(''!=$el_class){
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

         if(function_exists('icl_t')){
            $image_alt_text = icl_t('petro', sanitize_key( $image_alt_text ), $image_alt_text );
         }


        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
            if(function_exists('get_scroll_spy_script')){ get_scroll_spy_script(); }
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";

        if($target=='lightbox'){

          $org_image = wp_get_attachment_image_src($image_id,'full',false); 

          $image_url = ($org_image) ? $org_image[0] : $image[0];

          $link='<a href="'.esc_url($image_url).'" class="img-lightbox">';
          $link_end= "</a>";

        }
        else{

          $link=($url!='')?"<a href=\"".esc_url($url)."\" target=\"".$target."\">":"";
          $link_end=($url!='')?"</a>":"";

        }

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
          $image_css_style[]="border-width:".intval($border_width)."px;";
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

        if(function_exists('nuno_add_element_margin_style')){
          nuno_add_element_margin_style("#$el_id",$atts);
        }

        return $compile;
}

add_builder_element_render( 'el_image','petro_nuno_el_image');

function petro_nuno_carousel_navigation_btn( $navs=array() , $styles=array()){

  $navs = array(
    "<span class=\"btn-owl prev fa fa-chevron-left\" ".(count($styles)? ' style="'.join(';', $styles ).'"': "")."></span>",
    "<span class=\"btn-owl next fa fa-chevron-right\" ".(count($styles)? ' style="'.join(';', $styles ).'"': "")."></span>"
    );

  return $navs;

}

add_filter( 'nuno_carousel_navigation_btn','petro_nuno_carousel_navigation_btn',1,2);


$button_params = array(
          'heading' => esc_html__( 'Button Skin Color', 'petro' ),
          'param_name' => 'style',
          'type' => 'dropdown',
          'value' => array(
                      'default'=>esc_html__('Default','petro'),
                      'default-ghost'=>esc_html__('Outline','petro'),
                      'primary'=>esc_html__('Primary Color','petro'),
                      'primary-ghost'=>esc_html__('Primary Color(Outline)','petro'),
                      'secondary'=>esc_html__('Secondary Color','petro'),
                      'secondary-ghost'=>esc_html__('Secondary Color(Outline)','petro'),
                      'success'=>esc_html__('Success Color','petro'),
                      'success-ghost'=>esc_html__('Success Color(Outline)','petro'),
                      'info'=>esc_html__('Info Color','petro'),
                      'info-ghost'=>esc_html__('Info Color(Outline)','petro'),
                      'danger'=>esc_html__('Danger Color','petro'),
                      'danger-ghost'=>esc_html__('Danger Color(Outline)','petro'),
                      'warning'=>esc_html__('Warning Color','petro'),
                      'warning-ghost'=>esc_html__('Warning Color(Outline)','petro'),
                      'custom-color'=>esc_html__('Custom Color','petro')
                    ),
);

add_builder_element_option( 'el_btn',$button_params);


function petro_el_timeline_item($html, $content,$atts){

       extract( shortcode_atts( array(
          'title'=>'',
          'sub_title'=>'',
          'position'=>'left',
          'spy'=>'',
          'image'=>'',
          'size'=>'',
          'scroll_delay'=>300
      ), $atts ,'el_timeline_item') );

      $html='<div class="single-timeline-item leaf-position-'.sanitize_html_class($position).'"';

        if('none'!==$spy && !empty($spy)){
            $html.=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }

        $html.='>';

        $thumb_image=get_image_size($image,$size);

        if($thumb_image){
            $image_alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);

           if(function_exists('icl_t')){
              $image_alt_text = icl_t('petro', sanitize_key( $image_alt_text ), $image_alt_text );
           }

            $html.='<div class="thumb"><div class="box"><img class="img-responsive" src="'.esc_url($thumb_image[0]).'" alt="'.esc_attr($image_alt_text).'"/></div></div>';
        }



         $html.='<div class="text-holder"><h5 class="date">'.$sub_title.'</h5><h3>'.$title.'</h3>'.$content.'</div></div>';

        return $html;
}

function petro_team_custom($html, $content,$atts){

       wp_enqueue_style('awesomeicon');


        extract(shortcode_atts(array(
            'title' => '',
            'sub_title' => '',
            'text' => '',
            'layout_type'=>'default',
            'image_url'=>'',
            'facebook'=>'',
            'twitter'=>'',
            'gplus'=>'',
            'pinterest'=>'',
            'linkedin'=>'',
            'website'=>'',
            'email'=>'',
            'social_link'=>'show',
            'spy'=>'none',
            'scroll_delay'=>300,
            'el_id'=>'',
            'el_class'=>'',
            'titlecolor'=>'',
            'separator_color'=>'',
            'subtitlecolor'=>'',
            'icon_color'=>'',
            'icon_hover_color'=>'',
            'size'=>'full',
            'image_style'=>'',
            'border'=>'',
            'border_style'=>'solid',
            'border_width'=>'',
            'border_radius'=>'',                
            'icon_size'=>'',
            'phone'=>'',
            'content_align'=>'left'                
        ), $atts, 'team_custom'));

        $scollspy = $social_lists = $image_css_style = $image_src = $icon_style =  $alt_image = "";

        if('none'!==$spy && !empty($spy)){
            $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';

        }

        if($social_link=='show' && $layout_type!='petro-lite'){

            if(""!=$icon_color){
              $icon_style .= 'color:'.$icon_color.';';
            }

            if(""!= $icon_hover_color){
              add_page_css_style("#$el_id .profile-scocial a:hover i {color:".$icon_hover_color." !important;}");
            }

           if($icon_size!=''){
              $icon_style .= 'font-size:'.$icon_size.'px;';
            }

            if($icon_style !=''){
              $icon_style = ' style="'.$icon_style.'"';
            }

          $social_lists="<ul class=\"profile-scocial\">".
              (($facebook)?"<li><a href=\"".esc_url($facebook)."\" target=\"_blank\"><i class=\"fa fa-facebook\" ".$icon_style."></i></a></li>":"").
              (($twitter)?"<li><a href=\"".esc_url($twitter)."\" target=\"_blank\"><i class=\"fa fa-twitter\" ".$icon_style."></i></a></li>":"").
              (($gplus)?"<li><a href=\"".esc_url($gplus)."\" target=\"_blank\"><i class=\"fa fa-google-plus\" ".$icon_style."></i></a></li>":"").
              (($linkedin)?"<li><a href=\"".esc_url($linkedin)."\" target=\"_blank\"><i class=\"fa fa-linkedin\" ".$icon_style."></i></a></li>":"").
              (($pinterest)?"<li><a href=\"".esc_url($pinterest)."\" target=\"_blank\"><i class=\"fa fa-pinterest\" ".$icon_style."></i></a></li>":"").
              (($website)?"<li><a href=\"".esc_url($website)."\" target=\"_blank\"><i class=\"fa fa-globe\" ".$icon_style."></i></a></li>":"").
              (($email)?"<li><a href=mailto:".esc_url($email)." target=\"_blank\"><i class=\"fa fa-envelope\" ".$icon_style."></i></a></li>":"").
              "</ul>";
        }

          if(''!=$border){
            $image_css_style= ($border_style!='') ? "border-style:{$border_style};" : "border-style: solid;";
            $image_css_style.="border-color:{$border};";
          }

          if(''!=$border_width){
            $image_css_style.="border-width:".intval($border_width)."px;";
          }

          if(''!=$border_radius && $image_style=='rounded'){
            $border_radius = strpos($border_radius, '%') ? intval($border_radius)."%" : intval($border_radius)."px;";
            $image_css_style.="border-radius:".$border_radius.";";
          }

          if($image=get_image_size($image_url,$size)){
              $image_src=$image[0];

              $alt_image = get_post_meta(absint($image_url), '_wp_attachment_image_alt', true);

               if(function_exists('icl_t')){
                  $alt_image = icl_t('petro', sanitize_key( $alt_image ), $alt_image );
               }


          }

        $custom_team="";

        switch ($layout_type) {
          case 'thumb-left':
          case 'thumb-right':


            if($image_src!=''){
              $custom_team.='<div class="profile-image"><img src="'.esc_url($image_src) .'" class="img-responsive" style="'.$image_css_style.'" alt="'.esc_attr($alt_image).'"/></div>';
            }

            $custom_team.='<div class="profile-content"><h3 class="profile-heading">'.$title.'</h3><hr/><h4 class="profile-subheading">'.$sub_title.'</h4>
            '.(!empty($text)?'<div class="text">'.$text.'</div>':"");

            if(!empty($phone)) {
              $custom_team.= '<div class="phone"><span class="fa fa-phone"></span>'.$phone.'</div>';
            }

            $custom_team.= $social_lists.'</div>';
            break;

          case 'petro-lite':


            $custom_team='<div class="profile">
                    <figure>';

            if( $image_src != ''){        
                $custom_team.='<div class="top-image">
                            <img style="'.$image_css_style.'" src="'.esc_url($image_src) .'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>
                        </div>';
            }

            $custom_team .='<figcaption>';
            if($title !=''){
               $custom_team .='<span class="profile-heading">'.$title.'</span>';
            }



             $custom_team.= '
                        </figcaption>
                    </figure>
                </div>';


            break;
          case 'petro':
            if($image_src!=''){
              $custom_team.='<div class="profile-image"><div class="profile-thumb" style="background-image:url('.esc_url($image_src) .');'.$image_css_style.'" >'.$social_lists.'</div></div>';
            }

            $custom_team.='<div class="profile-content"><h3 class="profile-heading">'.$title.'</h3><h4 class="profile-subheading">'.$sub_title.'</h4>';

            if(!empty($text)) {
              $custom_team.= '<div class="text">'.$text.'</div>';
            }

            if(!empty($phone)) {
              $custom_team.= '<div class="phone"><span class="fa fa-phone"></span>'.$phone.'</div>';
            }

            $custom_team.='</div>';


            break;
            default:

            $custom_team='<div class="profile">
                    <figure>';

            if( $image_src != ''){        
                $custom_team.='<div class="top-image">
                            <img style="'.$image_css_style.'" src="'.esc_url($image_src) .'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>
                        </div>';
            }

            $custom_team .='<figcaption>';
            if($title !=''){
               $custom_team .='<h3><span class="profile-heading">'.$title.'</span></h3><hr/>';
            }

            if($sub_title !=''){
               $custom_team .='<h4 class="profile-subheading">'.$sub_title.'</h4>';
            }

            if($text!=''){
              $custom_team .='<p>'.$text.'</p>';
            }



            if(!empty($phone)) {
              $custom_team.= '<div class="phone"><span class="fa fa-phone"></span>'.$phone.'</div>';
            }

             $custom_team.= $social_lists;

            $custom_team.= '</figcaption>
                    </figure>
                </div>';

                break;
        }

        $css_class=array('team_custom',$layout_type,"style-".$image_style,'content-align-'.$content_align,'clearfix');

    if(''!=$el_class){
        array_push($css_class, $el_class);
    }

    $css_style=getElementCssMargin($atts);

    if(''==$el_id){
        $el_id="element_".getElementTagID();
    }


    $html="<div ";
      if(''!=$el_id){
          $html.="id=\"$el_id\" ";
      }

    if(""!=$css_style){
      add_page_css_style("#$el_id {".$css_style."}");
    }

    nuno_add_element_margin_style("#$el_id",$atts);

    if(""!=$titlecolor){
      add_page_css_style("#$el_id .profile-heading {color:".$titlecolor."}");
    }

    if(""!=$separator_color){
      add_page_css_style("#$el_id hr:after {background-color:".$separator_color."}");
    }

    if(""!=$subtitlecolor){
      add_page_css_style("#$el_id .profile-subheading {color:".$subtitlecolor." !important;}");
    }


    $html.='class="'.@implode(" ",$css_class).'" '.$scollspy.'>';
    $html.=$custom_team;
    $html.='</div>';


    return  $html;

}

add_builder_element_render( 'team_custom','petro_team_custom');



add_builder_element_option( 'team_custom', 
    array( 
        'heading' => esc_html__( 'Layout', 'petro' ),
        'param_name' => 'layout_type',
        'default' => 'default',
        'value'=>array(
          'default'=> esc_html__('Default','petro'),
          'thumb-left'=> esc_html__('Image Left','petro'),
          'thumb-right'=> esc_html__('Image Right','petro'),
          'petro'=> esc_html__('Petro','petro'),
          'petro-lite'=> esc_html__('Petro Lite ( show and main title )','petro')
          ),
        'type' => 'dropdown',
        ), true
    );

add_builder_element_option( 'team_custom', 
    array( 
        'heading' => esc_html__( 'Phone Number', 'petro' ),
        'param_name' => 'phone',
        'default' => '',
        'class'=>'medium',
        'value'=>'',
        'type' => 'textfield',
        ), true
    );


function petro_section_header($html, $content,$atts){

        extract(shortcode_atts(array(
            'main_heading' => '',
            'text_align'=>'center',
            'color'=>'',
            'layout'=>'',
            'el_id'=>'',
            'el_class'=>'',
            'font_weight'=>'',
            'font_style'=>'',
            'font_size'=>'default',
            'custom_font_size'=>'',
            'separator_color'=>'',
            'spy'=>'',
            'tag'=>'h2',
            'text_transform'=>'',
            'letter_spacing'=>'',
            'scroll_delay'=>300,
            'ico_background'=>''
        ), $atts,'section_header'));

        $css_class=array('section-head',$text_align);
        if($layout!=''){
          array_push($css_class, 'layout-'. sanitize_html_class($layout));
        }
        $heading_style=array();


        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element-".getElementTagID();
        }

        if('default'!==$font_size){
          array_push($css_class," size-".$font_size);
        }

        $html="<div ";
        if(''!=$el_id){
              $html.="id=\"$el_id\" ";
        }

        if('none'!==$spy && !empty($spy)){
            $html.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }


        if(!empty($color)){
            $heading_style['color']="color:".$color;
        }

        if(!empty($font_weight) && $font_weight!='default'){
            $heading_style['font-weight']="font-weight:".$font_weight;
        }

        if(!empty($font_style) && $font_style!='default'){
            $heading_style['font-style']="font-style:".$font_style;
        }

        if(!empty($custom_font_size) && $font_size=='custom'){
            $custom_font_size=(preg_match('/(px|pt|em)$/', $custom_font_size))?$custom_font_size:$custom_font_size."px";
            $heading_style['font-size']="font-size:".$custom_font_size;
        }

        if(!empty($text_transform)){
            $heading_style['text-transform']="text-transform:".$text_transform;
        }

        if(!empty($letter_spacing)){
            $letter_spacing=(preg_match('/(px|pt|em)$/', $letter_spacing))?$letter_spacing:$letter_spacing."px";
            $heading_style['letter-spacing']="letter-spacing:".$letter_spacing;
        }

        if($tag=='') $tag= 'h2';


        $html.='class="'.@implode(" ",$css_class).'"><div>'.
                  ((!empty($main_heading))?'<'.$tag.(count($heading_style)?" style=\"".@implode(";",$heading_style)."\"":"").' class="section-main-title">'.$main_heading.'</'.$tag.'>':'');
        if($ico_background !='' && $layout=='ico'){

          $html.='<span class="ico-background '.sanitize_html_class($ico_background).'"></span>';

        }

        $html.='</div></div>';  

        if(""!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);
        
        return $html;

}

add_builder_element_render( 'section_header','petro_section_header');

add_builder_element_option( 'section_header', 
    array( 
        'heading' => esc_html__( 'Layout', 'petro' ),
        'param_name' => 'layout',
        'default' => '',
        'value'=>array(
          ''=> esc_html__('Default','petro'),
          'petro'=> esc_html__('Petro Border','petro'),
          'ico'=> esc_html__('Ico Background','petro'),
          ),
        'type' => 'dropdown',
        ), true
    );


add_builder_element_option( 'section_header', 
    array( 
        'heading' => esc_html__( 'Ico Background', 'petro' ),
        'param_name' => 'ico_background',
        'default' => '',
        'value'=>'',
        'type' => 'icon_picker',
        'dependency' => array( 'element' => 'layout', 'value' => array( 'ico') )   
        ), true
    );

/**
 * SLides show
 *
 */

class BuilderElement_petro_slides extends BuilderElement {

    function render($atts, $content = null, $base = ''){

        extract(shortcode_atts(array(
            'el_id'=>'',
            'el_class'=>'',
            'container_width'=>'',
            'container_height'=>'',
            'width_desktop'=>'',
            'width_tablet'=>'',
            'width_mobile'=>'',
            'height_desktop'=>'',
            'height_tablet'=>'',
            'height_mobile'=>'',
        ), $atts,'petro_slides'));


        $atts['class'] = $el_class;

        if(''==$el_id){
            $el_id="element-".getElementTagID();
            $atts['el_id'] = $el_id;
        }

        $desktop_size = $tablet_size = $mobile_size = array();

        ob_start();

        petro_slides_show($atts);

        $compile = ob_get_clean();

        nuno_add_element_margin_style("#$el_id",$atts);

        if($container_height =='no' && $height_desktop!=''){
          $height_desktop = strpos($height_desktop, '%') ? $height_desktop : (int)$height_desktop."px";
          $desktop_size['height'] = 'height:'.$height_desktop;

        } 

        if($container_width=='no' && $width_desktop!=''){
          $width_desktop = strpos($width_desktop, '%') ? $width_desktop : (int)$width_desktop."px";
          $desktop_size['width'] = 'width:'.$width_desktop.'!important';
          $desktop_size['margin-left'] = 'margin-left:auto';
          $desktop_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($desktop_size)){
              add_page_css_style("#$el_id".'{'.@implode(";",$desktop_size).'}');
        }

        if($container_height =='no' &&  $height_tablet!=''){
          $height_tablet = strpos($height_tablet, '%') ? $height_tablet : (int)$height_tablet."px";
          $tablet_size['height'] = 'height:'.$height_tablet.'!important';

        } 

        if($container_width=='no' && $width_tablet!=''){
          $width_tablet = strpos($width_tablet, '%') ? $width_tablet : (int)$width_tablet."px";
          $tablet_size['width'] = 'width:'.$width_tablet.'!important';
          $tablet_size['margin-left'] = 'margin-left:auto';
          $tablet_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($tablet_size)){
              add_page_css_style('tablet',"#$el_id".'{'.@implode(";",$tablet_size).'}');
        }

        if($container_height =='no' &&  $height_mobile!=''){
          $height_mobile = strpos($height_mobile, '%') ? $height_mobile : (int)$height_mobile."px";
          $mobile_size['height'] = 'height:'.$height_mobile;

        } 

        if($container_width=='no' && $width_mobile!=''){
          $width_mobile = strpos($width_mobile, '%') ? $width_mobile : (int)$width_mobile."px";
          $mobile_size['width'] = 'width:'.$width_mobile;
          $mobile_size['margin-left'] = 'margin-left:auto';
          $mobile_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($mobile_size)){
              add_page_css_style('tablet',"#$el_id".'{'.@implode(";",$mobile_size).'}');
        }
         
        return $compile;
    }
}

add_builder_element('petro_slides',
  array(
    'title'=>esc_html__('Petro Slides Show','petro'),
    'icon'=>'fa fa-film',
    'color'=>'#041e42',
    'order'=>30,
    'options'=>array(
        array( 
          'heading' => esc_html__( 'Extra css Class', 'petro' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'petro' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "petro"),
        ),
        array( 
          'heading' => esc_html__( 'Background Animation', 'petro' ),
          'param_name' => 'animation',
          'type' => 'radio',
          'description'=> esc_html__('Select animation the slider.','petro'),
          'value'=>array(
              'slide' => esc_html__('Slide','petro'),
              'fade' => esc_html__('Fade','petro'),
              ),
          'default'=>'slide'
        ),
        array( 
          'heading' => esc_html__( 'Animation Easing', 'petro' ),
          'param_name' => 'easing',
          'type' => 'radio',
          'description'=> esc_html__('Select animation easing the slider.','petro'),
          'value'=>array(
              'linear' => esc_html__('Linear','petro'),
              'swing' => esc_html__('Swing','petro'),
              ),
          'default'=>'swing'
        ),
        array( 
          'heading' => esc_html__( 'Content Animation', 'petro' ),
          'param_name' => 'slide_animation',
          'type' => 'radio',
          'description'=> esc_html__('Select animation for slide content.','petro'),
          'value'=>array(
              '' => esc_html__('None','petro'),
              'fromTop' => esc_html__('From Top','petro'),
              'fromBottom' => esc_html__('From Bottom','petro'),
              'scale' => esc_html__('Scale','petro'),
              'fade' => esc_html__('Fade','petro'),
              'fadeScale' => esc_html__('Scale and Fade','petro'),
              ),
          'default'=>''
        ),
        array( 
          'heading' => esc_html__( 'Slide Speed', 'petro' ),
          'param_name' => 'slide_speed',
          "description" => esc_html__("Slide speed in milisecond.", "petro"),
          'type' => 'textfield',
        ),
         array( 
          'heading' => esc_html__( 'Slide Interval', 'petro' ),
          'param_name' => 'play',
          'description'=> esc_html__('Milliseconds before progressing to next slide automatically.','petro'),
          'type' => 'textfield',
        ),        array( 
          'heading' => esc_html__( 'Show Pagination', 'petro' ),
          'param_name' => 'pagination',
          'type' => 'radio',
          'value'=>array(
              '1' => esc_html__('Yes','petro'),
              '0' => esc_html__('No','petro')
              ),
        ),
        array( 
          'heading' => esc_html__( 'Width', 'petro' ),
          'param_name' => 'container_width',
          'default' =>'yes',
          'value'=>array(
              'yes' => esc_html__('Full Screen','petro'),
              'no' => esc_html__('Custom','petro')
              ),
          'description' => esc_html__( 'Slide container full width. If select no, you mus define as well. ', 'petro' ),
          'type' => 'radio',
        ),
        array( 
          'heading' => esc_html__( 'Desktop', 'petro' ),
          'description' => esc_html__( 'This optional for large screen from 992px.', 'petro' ),
          'param_name' => 'width_desktop',
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Tablet', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'petro' ),
          'param_name' => 'width_tablet',
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Mobile', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'petro' ),
          'param_name' => 'width_mobile',
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),

        array( 
          'heading' => esc_html__( 'Height', 'petro' ),
          'param_name' => 'container_height',
          'value'=>array(
              'yes' => esc_html__('Full Screen','petro'),
              'no' => esc_html__('Custom','petro')
              ),
          'default' =>'yes',
          'description' => esc_html__( 'Slide container full height. If select no, you mus define as well. ', 'petro' ),
          'type' => 'radio',
        ),
        array( 
          'heading' => esc_html__( 'Desktop', 'petro' ),
          'description' => esc_html__( 'This optional for large screen from 992px.', 'petro' ),
          'param_name' => 'height_desktop',
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Tablet', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'petro' ),
          'param_name' => 'height_tablet',
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Mobile', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'petro' ),
          'param_name' => 'height_mobile',
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),

         array( 
          'heading' => esc_html__( 'Top', 'petro' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'petro' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'petro' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'petro' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Mobile', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'petro' ),
          'param_name' => 'margin_mobile',
          'type' => 'heading',
          'group'=>esc_html__('Margin', 'petro'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'petro' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'petro' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'petro' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'petro' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Tablet', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'petro' ),
          'param_name' => 'margin_tablet',
          'type' => 'heading',
          'group'=>esc_html__('Margin', 'petro'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'petro' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'petro' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'petro' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'petro' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),

        )    
    )
);

class BuilderElement_petro_post extends BuilderElement{

    function preview($atts, $content = null) {

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base=''){

        if (!isset($compile)) {$compile='';}

        extract(shortcode_atts(array(
            'posts_per_page'=> get_option('posts_per_page'),
            'el_id'=>'',
            'el_class'=>'',
            'size'=>'medium',
            'column'=>12,
            'excerpt_length'=>'',
        ), $atts, 'petro_post'));

        $query_params= array(
          'posts_per_page' => $posts_per_page,
          'no_found_rows' => true,
          'post_status' => 'publish',
          'post_type'=>'post',
          'ignore_sticky_posts' => true
        );

        $lite = absint($column) > 1 ? '-lite':'';

        $grid_css= array('grid-column',"col-xs-12");
        $lg = 12 / $column;
        $grid_css[] = "col-lg-".$lg;
        if($lg < 12 ) $grid_css[] = 'col-md-6';
        $grid_class = join(' ',array_unique($grid_css));

        $query = new WP_Query($query_params);

        if (is_wp_error($query) || !$query->have_posts()) {

          return '';
        }

        $rows  = array();

        while ( $query->have_posts() ) : 

          $query->the_post();
          $post_id = get_the_ID();

          ob_start();

          $post_format= get_post_format();
          get_template_part( 'template-part/content'.$lite, $post_format ); 

          $rows[] = ob_get_clean();
        endwhile;
        wp_reset_postdata();

        $css_class=array('petro_post','post-lists','blog-col-'.sanitize_html_class($column),'clearfix');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }


        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if(""!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        $compile.='class="'.@implode(" ",$css_class).'">';


        $compile .= '<div class="'.esc_attr($grid_class).'">'.join('</div><div class="'.esc_attr($grid_class).'">',$rows).'</div>';
        $compile.='</div>';


        return  $compile;

    }

}

add_builder_element('petro_post',
 array( 
    'title' => esc_html__( 'Latest Posts', 'petro' ),
    'icon'  =>'fa fa-newspaper-o',
    'color' =>'#041e42',
    'order'=>33,
    'class' => '',
    'options' => array(
          array( 
          'heading' => esc_html__( 'Extra css Class', 'petro' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'petro' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "petro"),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'petro' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'petro' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'petro' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'petro' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Mobile', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 480px.', 'petro' ),
          'param_name' => 'margin_mobile',
          'type' => 'heading',
          'group'=>esc_html__('Margin', 'petro'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'petro' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'petro' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'petro' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'petro' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Margin Tablet', 'petro' ),
          'description' => esc_html__( 'This optional for screen up to 992px.', 'petro' ),
          'param_name' => 'margin_tablet',
          'type' => 'heading',
          'group'=>esc_html__('Margin', 'petro'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'petro' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'petro' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'petro' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'petro' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'petro'),
        ),
        array( 
        'heading' => esc_html__('Number of posts to show:','petro' ),
        'param_name' => 'posts_per_page',
        'class' => 'small',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Number of Columns', 'petro' ),
          'param_name' => 'column',
          'description' => esc_html__( 'Number of columns on screen larger than 1200px screen resolution', 'petro' ),
          'class' => '',
          'value'=>array(
              '1' => esc_html__('One Column','petro'),
              '2' => esc_html__('Two Columns','petro'),
              '3' => esc_html__('Three Columns','petro'),
              '4' => esc_html__('Four Columns','petro'),
              ),
          'type' => 'dropdown',
         ),     
        array( 
          'heading' => esc_html__( 'Image Size', 'petro' ),
          'param_name' => 'size',
          'type' => 'textfield',
          'value'=>"",
          'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'petro' ),
          ),
        array( 
          'heading' => esc_html__('Post excerpt length','petro' ),
          'param_name' => 'excerpt_length',
          'class' => 'small',
          'value' => '',
          'type' => 'textfield',
          'description' => esc_html__( 'Num words post content displayed.', 'petro' ),
         ), 

        )
 ) );
?>