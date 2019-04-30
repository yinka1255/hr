<?php
/**
 * @package WordPress
 * @subpackage Nuno Page Builder
 * @version 1.0.0
 * @since 1.0.0
 */

defined('ABUILDER_BASENAME') or die();


include_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
include_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');


if (!function_exists('aq_resize')) {
  function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {

    if(!$url OR !($width || $height)) return false;

    //define upload path & dir
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];
    
    //check if $img_url is local
    /* Gray this out because WPML doesn't like it.
    if(strpos( $url, home_url() ) === false) return false;
    */
    
    //define path of image
    $rel_path = str_replace( str_replace( array( 'http://', 'https://' ),"",$upload_url), '', str_replace( array( 'http://', 'https://' ),"",$url));
    $img_path = $upload_dir . $rel_path;
    
    //check if img path exists, and is an image indeed
    if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;
    
    //get image info
    $info = pathinfo($img_path);
    $ext = $info['extension'];
    list($orig_w,$orig_h) = getimagesize($img_path);
    
    $dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
    if(!$dims){
      return $single?$url:array('0'=>$url,'1'=>$orig_w,'2'=>$orig_h);
    }

    $dst_w = $dims[4];
    $dst_h = $dims[5];

    //use this to check if cropped image already exists, so we can return that instead
    $suffix = "{$dst_w}x{$dst_h}";
    $dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

    //if orig size is smaller
    if($width >= $orig_w) {

      if(!$dst_h) :
        //can't resize, so return original url
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
        
      else :
        //else check if cache exists
        if(file_exists($destfilename) && getimagesize($destfilename)) {
          $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        } 
        else {

          $imageEditor=wp_get_image_editor( $img_path );

          if(!is_wp_error($imageEditor)){

              $imageEditor->resize($width, $height, $crop );
              $imageEditor->save($destfilename);

              $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
              $img_url = $upload_url . $resized_rel_path;


          }
          else{
              $img_url = $url;
              $dst_w = $orig_w;
              $dst_h = $orig_h;
          }

        }
        
      endif;
      
    }
    //else check if cache exists
    elseif(file_exists($destfilename) && getimagesize($destfilename)) {
      $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
    } 
    else {

      $imageEditor=wp_get_image_editor( $img_path );

      if(!is_wp_error($imageEditor)){
          $imageEditor->resize($width, $height, $crop );
          $imageEditor->save($destfilename);

          $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
          $img_url = $upload_url . $resized_rel_path;
      }
      else{
          $img_url = $url;
          $dst_w = $orig_w;
          $dst_h = $orig_h;
      }


    }
    
    if(!$single) {
      $image = array (
        '0' => $img_url,
        '1' => $dst_w,
        '2' => $dst_h
      );
      
    } else {
      $image = $img_url;
    }
    
    return $image;
  }
}

if(!function_exists('get_image_size')):
function get_image_size( $image_id,$img_size="thumbnail"){

    global $_wp_additional_image_sizes;

    if(''==$img_size)
        $img_size="thumbnail";

    if(''==$image_id)
        return false;

    if(in_array($img_size, array('thumbnail','thumb','small', 'medium', 'large','full'))){

        if ( $img_size == 'thumb' ||  $img_size == 'small' || $img_size == 'thumbnail' ) {

            $image=wp_get_attachment_image_src($image_id,'thumbnail');
        }
        elseif ( $img_size == 'medium' ) {
            $image=wp_get_attachment_image_src($image_id,'medium');

        }
        elseif ( $img_size == 'large' ) {
            $image=wp_get_attachment_image_src($image_id,'large');
        }else{

            $image=wp_get_attachment_image_src($image_id,'full');

        }

    }
    elseif(!empty($_wp_additional_image_sizes[$img_size]) && is_array($_wp_additional_image_sizes[$img_size])){

        $width=$_wp_additional_image_sizes[$img_size]['width'];
        $height=$_wp_additional_image_sizes[$img_size]['height'];

        $img_url = wp_get_attachment_image_src($image_id,'full',false); 
        $image=aq_resize( $img_url[0],$width, $height, true,false ) ;


    }
    else{

        preg_match_all('/\d+/', $img_size, $thumb_matches);

        if(isset($thumb_matches[0])) {
            $thumb_size = array();
            if(count($thumb_matches[0]) > 1) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][1]; // height
            } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][0]; // height
            } else {
                $thumb_size = false;
            }
        }

        if($thumb_size){

          $img_url = wp_get_attachment_image_src($image_id,'full',false); 
          $image=aq_resize( $img_url[0],$thumb_size[0], $thumb_size[1], true,false ) ;
        }
        else{
          return false;
        }
    }

    return $image;
}
endif;
function get_builder_elements(){

  global $Elements;

  if(!is_object($Elements)){

      $Elements=Elements::getInstance();
  }
  return $Elements->getElements();
}

function get_builder_single_element($shortcode=""){

  if(''==$shortcode) return false;

  global $Elements;

  if(!is_object($Elements)){

      $Elements=Elements::getInstance();
  }

  $elements=$Elements->getElements();

  return isset($elements[$shortcode])?$elements[$shortcode]:false;
}

function add_builder_element($shortcode_id,$params){

  global $Elements;
  if(!is_object($Elements)){

      $Elements=Elements::getInstance();
  }
  $Elements->addElement($shortcode_id,$params);
}

function remove_builder_element($shortcode_id){

  global $Elements;
  if(!is_object($Elements)){

      $Elements=Elements::getInstance();
  }
  $Elements->removeElement($shortcode_id);
}

function add_builder_element_render($shortcode_id,$funtionName){
  add_filter('render_'.$shortcode_id.'_shortcode',$funtionName,1,3);
}

function add_builder_element_preview($shortcode_id,$funtionName){

  add_filter('preview_'.$shortcode_id.'_shortcode',$funtionName,1,3);
}

function add_builder_element_option($shortcode_id,$options=array(),$replace=true){

  if($shortcode_id=='')
    return false;

  if(!$element=get_builder_single_element($shortcode_id))
    return false;

  $element->addOption($options,$replace);
}

function add_builder_element_options($shortcode_id,$options=array(),$replace=true){

  if($shortcode_id=='')
    return false;

 if(!$element=get_builder_single_element($shortcode_id))
    return false;
  $element->addOptions($options,$replace);
}

function remove_builder_element_options($shortcode_id,$optionName){

  if($shortcode_id=='')
    return false;

  $element=get_builder_single_element($shortcode_id);

 if(!$element) return false;
  $element->removeOption($optionName);
}

function remove_builder_element_option($shortcode_id,$optionName){

  if($shortcode_id=='')
    return false;

  $element=get_builder_single_element($shortcode_id);

  if(!$element) return false;
  $element->removeOption($optionName);
}

function add_builder_field_type($type,$function_name){

  $classField='BuilderElement_Field_'.$type;

  if(class_exists($classField) || !function_exists($function_name)) return false;
  add_action( $classField,$function_name,1,2);

}

function get_field_dependency_param($option=array()){

  if(!isset($option['dependency']) || ! is_array($option['dependency']))
      return "";

  $param=wp_parse_args($option['dependency'],array('element'=>"",'value'=>'','not_empty'=>false));
  $dependent=$param['element'];
  $dependent_value=$param['value'];
  $not_empty=$param['not_empty'];



  if($dependent=='' || ($dependent_value=='' && !$not_empty))
      return "";

  return " data-dependent=\"".$dependent."\" data-dependvalue=\"".($not_empty?"not_empty":(is_array($dependent_value)?@implode(",",$dependent_value):$dependent_value))."\"";
}

function getElementTagID($prefix=""){

  global $element_id;

  if(!isset($element_id)) {
    $element_id=0;
  }

  $element_id++;

  return $prefix.$element_id;

}

function add_page_css_style($element="", $css=""){
  global $PageStyles;

  if(! isset($PageStyles) || !is_array($PageStyles)){
    $PageStyles = array();
  }

  if(!empty($element)){
    if(!empty($css)){
      $PageStyles[$element][] = $css;
    }
    else{
      $PageStyles['desktop'][] = $element;
    }
  }
}

function nuno_get_page_styles(){

  global $PageStyles;

  if(isset($PageStyles) &&  is_array($PageStyles)){

      return $PageStyles;
  }

  return array();
}

function nuno_add_element_margin_style($element, $atts, $is_array=false){

  $defaults=array(
          'm_top'=>'',
          'm_bottom'=>'',
          'm_left'=>'',
          'm_right'=>'',
          'p_top'=>'',
          'p_bottom'=>'',
          'p_left'=>'',
          'p_right'=>'',
          'm_xs_top'=>'',
          'm_xs_bottom'=>'',
          'm_xs_left'=>'',
          'm_xs_right'=>'',
          'p_xs_top'=>'',
          'p_xs_bottom'=>'',
          'p_xs_left'=>'',
          'p_xs_right'=>'',
          'm_sm_top'=>'',
          'm_sm_bottom'=>'',
          'm_sm_left'=>'',
          'm_sm_right'=>'',
          'p_sm_top'=>'',
          'p_sm_bottom'=>'',
          'p_sm_left'=>'',
          'p_sm_right'=>'',
          'z_index' =>'',
          'css_overflow' =>'',          
        );

    $args=wp_parse_args($atts,$defaults);
    extract($args);
    $css_style = $css_style_mobile = $css_style_tablet = array();

    if(''!=$z_index){$z_index=(int)$z_index;$css_style['z-index']="z-index:".$z_index;}
    if(''!=$css_overflow && in_array(trim($css_overflow), array('hidden','inherit','visible','auto','unset'))){$css_overflow=trim($css_overflow);$css_style['overflow']="overflow:".$css_overflow;}

    if(''!=$m_top){$m_top=(int)$m_top;$css_style['margin-top']="margin-top:".$m_top."px";}
    if(''!=$m_bottom){$m_bottom=(int)$m_bottom;$css_style['margin-bottom']="margin-bottom:".$m_bottom."px";}
    if(''!=$m_left){$m_left=(int)$m_left;$css_style['margin-left']="margin-left:".$m_left."px";}
    if(''!=$m_right){$m_right=(int)$m_right;$css_style['margin-right']="margin-right:".$m_right."px";}
    if(''!=$p_top){$p_top=(int)$p_top;$css_style['padding-top']="padding-top:".$p_top."px";}
    if(''!=$p_bottom){$p_bottom=(int)$p_bottom;$css_style['padding-bottom']="padding-bottom:".$p_bottom."px";}
    if(''!=$p_left){$p_left=(int)$p_left;$css_style['padding-left']="padding-left:".$p_left."px";}
    if(''!=$p_right){$p_right=(int)$p_right;$css_style['padding-right']="padding-right:".$p_right."px";}

    if(''!=$m_xs_top){$m_xs_top=(int)$m_xs_top;$css_style_mobile['margin-top']="margin-top:".$m_xs_top."px";}
    if(''!=$m_xs_bottom){$m_xs_bottom=(int)$m_xs_bottom;$css_style_mobile['margin-bottom']="margin-bottom:".$m_xs_bottom."px";}
    if(''!=$m_xs_left){$m_xs_left=(int)$m_xs_left;$css_style_mobile['margin-left']="margin-left:".$m_xs_left."px";}
    if(''!=$m_xs_right){$m_xs_right=(int)$m_xs_right;$css_style_mobile['margin-right']="margin-right:".$m_xs_right."px";}
    if(''!=$p_xs_top){$p_xs_top=(int)$p_xs_top;$css_style_mobile['padding-top']="padding-top:".$p_xs_top."px";}
    if(''!=$p_xs_bottom){$p_xs_bottom=(int)$p_xs_bottom;$css_style_mobile['padding-bottom']="padding-bottom:".$p_xs_bottom."px";}
    if(''!=$p_xs_left){$p_xs_left=(int)$p_xs_left;$css_style_mobile['padding-left']="padding-left:".$p_xs_left."px";}
    if(''!=$p_xs_right){$p_xs_right=(int)$p_xs_right;$css_style_mobile['padding-right']="padding-right:".$p_xs_right."px";}

    if(''!=$m_sm_top){$m_sm_top=(int)$m_sm_top;$css_style_tablet['margin-top']="margin-top:".$m_sm_top."px";}
    if(''!=$m_sm_bottom){$m_sm_bottom=(int)$m_sm_bottom;$css_style_tablet['margin-bottom']="margin-bottom:".$m_sm_bottom."px";}
    if(''!=$m_sm_left){$m_sm_left=(int)$m_sm_left;$css_style_tablet['margin-left']="margin-left:".$m_sm_left."px";}
    if(''!=$m_sm_right){$m_sm_right=(int)$m_sm_right;$css_style_tablet['margin-right']="margin-right:".$m_sm_right."px";}
    if(''!=$p_sm_top){$p_sm_top=(int)$p_sm_top;$css_style_tablet['padding-top']="padding-top:".$p_sm_top."px";}
    if(''!=$p_sm_bottom){$p_sm_bottom=(int)$p_sm_bottom;$css_style_tablet['padding-bottom']="padding-bottom:".$p_sm_bottom."px";}
    if(''!=$p_sm_left){$p_sm_left=(int)$p_sm_left;$css_style_tablet['padding-left']="padding-left:".$p_sm_left."px";}
    if(''!=$p_sm_right){$p_sm_right=(int)$p_sm_right;$css_style_tablet['padding-right']="padding-right:".$p_sm_right."px";}

    if($is_array){
      return array('desktop'=> $css_style, 'mobile'=>$css_style_mobile, 'tablet'=> $css_style_tablet );
    }

    if(count($css_style)){
      add_page_css_style($element.'{'.@implode(";",$css_style).'}');
    }

    if(count($css_style_mobile)){
      add_page_css_style( 'mobile', $element.'{'.@implode(";",$css_style_mobile).'}');
    }

    if(count($css_style_tablet)){
      add_page_css_style( 'tablet', $element.'{'.@implode(";",$css_style_tablet).'}');
    }


}

function getElementCssMargin($atts,$is_array=false){

  $defaults=array(
          'b_top'=>'',
          'b_bottom'=>'',
          'b_left'=>'',
          'b_right'=>'',
          'border_color'=>'',
          'bgcolor'=>'',
          'bg_color'=>'',
          'color'=>'',
          'font_size'=>'',
          'font_weight'=>'',
          'font_style'=>'',
          'letter_spacing'=>'',
          'line_height'=>'',
          'h_shadow'=>'',
          'v_shadow'=>'',
          'blur_shadow'=>'',
          'spread_shadow'=>'',
          'shadow_color'=>'',
          'border_style'=>'inherit',
          'br_top_right' =>'',
          'br_bottom_right' =>'',
          'br_bottom_left' =>'',
          'br_top_left' =>'',          
        );

  $args=wp_parse_args($atts,$defaults);

  extract($args);
  $css_style=array();

  if(''!=$br_top_right){
    $br_top_right=  strpos($br_top_right, '%') ? $br_top_right : (int)$br_top_right."px";
    $css_style['border-top-right-radius']="border-top-right-radius:".$br_top_right;
  }
  if(''!=$br_bottom_right){
    $br_bottom_right=  strpos($br_bottom_right, '%') ? $br_bottom_right : (int)$br_bottom_right."px";
    $css_style['border-bottom-right-radius']="border-bottom-right-radius:".$br_bottom_right;
  }
  if(''!=$br_bottom_left){
    $br_bottom_left=  strpos($br_bottom_left, '%') ? $br_bottom_left : (int)$br_bottom_left."px";
    $css_style['border-bottom-left-radius']="border-bottom-left-radius:".$br_bottom_left;
  }
  if(''!=$br_top_left){
    $br_top_left=  strpos($br_top_left, '%') ? $br_top_left : (int)$br_top_left."px";
    $css_style['border-top-left-radius']="border-top-left-radius:".$br_top_left;
  }

  if(''!=$font_size && !in_array($font_size, array('custom','default')) ){

     $font_size=(preg_match('/(px|pt|em)$/', $font_size))? $font_size : absint($font_size)."px";
     $css_style['font-size']="font-size:".$font_size;
   
  }

  if(''!=$font_weight){
     $font_weight= in_array($font_weight, array('bold','normal','bolder','lighter') ) ? trim($font_weight): absint($font_weight);
     $css_style['font-weight']="font-weight:".$font_weight;
   
  }

  if(''!=$font_style && in_array($font_style, array('italic','oblique','normal') )){
     $css_style['font-style']="font-style:".trim($font_style);   
  }

  if(''!=$letter_spacing){

     $letter_spacing=(preg_match('/(px|pt|em)$/', $letter_spacing))?$letter_spacing: absint($letter_spacing)."px";
     $css_style['letter-spacing']="letter-spacing:".$letter_spacing;
   
  }

  if(''!=$line_height){

     $line_height=(preg_match('/(px|pt|em|%)$/', $line_height))? $line_height : absint($line_height);
     $css_style['line-height']="line-height:".$line_height;
   
  }

  if(''!=$color ){
      $css_style['color']="color:".$color;
  }

  if(''!=$bg_color && $bgcolor=''){
    $bgcolor = $bg_color;
  }

 if(''!=$bgcolor ){
      $css_style['background-color']="background-color:".$bgcolor;
  }


  if(''!=$border_color && (''!=$b_top || ''!=$b_bottom || ''!=$b_left || ''!=$b_right) ){

      $css_style['border-style']="border-style: solid";
      $css_style['border-color']="border-color:".$border_color;
      $css_style['border-style']="border-style:".($border_style!='' ? $border_style: "inherit");
    
      $b_top=(int)$b_top;
      $b_bottom=(int)$b_bottom;
      $b_left=(int)$b_left;
      $b_right=(int)$b_right;

      $css_style['border-width']="border-width:".$b_top."px ".$b_right."px ".$b_bottom."px ".$b_left."px;";
  }

  if($shadow_color!='' && ($h_shadow!='' || $v_shadow!='' || $blur_shadow!='' || $spread_shadow!='')){

    $h_shadow = absint($h_shadow);
    $v_shadow = absint($v_shadow);
    $blur_shadow = absint($blur_shadow);
    $spread_shadow = absint($spread_shadow);

    $css_style['box-shadow']="box-shadow:".$h_shadow."px ".$v_shadow."px ".$blur_shadow."px ".$spread_shadow."px ".$shadow_color.";";

  }

  return $is_array?$css_style:@implode(";",$css_style);
}

if(!function_exists('darken')){
  function darken($colourstr, $procent=0) {
    $colourstr = str_replace('#','',$colourstr);
    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = max(0,min(255,$r - ($r*$procent/100)));
    $g = max(0,min(255,$g - ($g*$procent/100)));  
    $b = max(0,min(255,$b - ($b*$procent/100)));

    return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
  }
}

if(!function_exists('lighten')){

    function lighten($colourstr, $procent=0){

      $colourstr = str_replace('#','',$colourstr);
      $rhex = substr($colourstr,0,2);
      $ghex = substr($colourstr,2,2);
      $bhex = substr($colourstr,4,2);

      $r = hexdec($rhex);
      $g = hexdec($ghex);
      $b = hexdec($bhex);

      $r = max(0,min(255,$r + ($r*$procent/100)));
      $g = max(0,min(255,$g + ($g*$procent/100)));  
      $b = max(0,min(255,$b + ($b*$procent/100)));

      return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
    }

}

if(!function_exists('themegum_exctract_glyph_from_file')){

  function themegum_exctract_glyph_from_file($file="",$pref=""){

    $wp_filesystem=new WP_Filesystem_Direct(array());

    if(!$wp_filesystem->is_file($file) || !$wp_filesystem->exists($file))
        return false;

     if ($buffers=$wp_filesystem->get_contents_array($file)) {
       $icons=array();

      foreach ($buffers as $line => $buffer) {

        if(preg_match("/^(\.".$pref.")([^:\]\"].*?):before/i",$buffer,$out)){

          if($out[2]!==""){
              $icons[$pref.$out[2]]=$pref.$out[2];
          }
        }
      }
      return $icons;

    }else{

      return false;
    }
  }
}
/* /themegum_exctract_glyph_from_file */

if(! function_exists('themegum_get_glyph_lists')):
function themegum_get_glyph_lists($path){

  $wp_filesystem=new WP_Filesystem_Direct(array());

  $icons=array();
  if($dirlist=$wp_filesystem->dirlist($path)){
    foreach ($dirlist as $dirname => $dirattr) {

       if($dirattr['type']=='d'){
          if($dirfont=$wp_filesystem->dirlist($path.$dirname)){
            foreach ($dirfont as $filename => $fileattr) {
              if(preg_match("/(\.css)$/", $filename)){
                if($icon=themegum_exctract_glyph_from_file($path.$dirname."/".$filename)){

                  $icons=@array_merge($icon,$icons);
                }
                break;
              }
             
            }
          }
        }
        elseif($dirattr['type']=='f' && preg_match("/(\.css)$/", $dirname)){

          if($icon=themegum_exctract_glyph_from_file($path.$dirname)){
              $icons=@array_merge($icon,$icons);
          }

      }

    }
  }
  return $icons;
}
endif;
/* /themegum_get_glyph_lists */

if(! function_exists('themegum_glyphicon_list')):
function themegum_glyphicon_list(){
  $icons = array();
  return apply_filters('themegum_glyphicon_list',$icons);
}

endif;
/* /themegum_glyphicon_list */

function get_abuilder_dir_url(){
  return plugins_url( '/nuno-builder/');
}

if(! function_exists('is_assoc_array')){
  function is_assoc_array(array $array){

    $keys = array_keys($array);
    return array_keys($keys) !== $keys;
  }
}

function get_scroll_spy_script(){

  wp_enqueue_script( 'uilkit', get_abuilder_dir_url() . 'js/uilkit.js', array(), '1.0', true );
  wp_enqueue_script( 'ScrollSpy',get_abuilder_dir_url()."js/scrollspy.js",array( 'uilkit' ), '1.0', true );

}

function nuno_builder_block_pagination($args=array(), $echo = true){

    $defaults = array(
      'total_pages'=>0,
      'total_items'=>0,
      'current_page'=>1,
    );

    extract(wp_parse_args($args, $defaults));

    $disable_first = $disable_last = $disable_prev = $disable_next = false;

    if ( $current_page == 1 ) {
      $disable_first = true;
      $disable_prev = true;
    }
    if ( $current_page == 2 ) {
      $disable_first = true;
    }
    if ( $current_page == $total_pages ) {
      $disable_last = true;
      $disable_next = true;
    }
    if ( $current_page == $total_pages - 1 ) {
      $disable_last = true;
    }

    $removable_query_args = wp_removable_query_args();
    $current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
    $current_url = remove_query_arg( $removable_query_args, $current_url );

    $page_links = array();

    $output = '<span class="displaying-num">' . sprintf( _n( '%s item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';

    if ( $disable_first ) {
      $page_links[] = '<span class="navspan" aria-hidden="true">&laquo;</span>';
    } else {
      $page_links[] = sprintf( "<a class='first-page' href='%s' data-page='1'><span aria-hidden='true'>%s</span></a>",esc_url( remove_query_arg( 'paged', $current_url ) ),'&laquo;');
    }

    if ( $disable_prev ) {
      $page_links[] = '<span class="navspan" aria-hidden="true">&lsaquo;</span>';
    } else {
      $page_links[] = sprintf( "<a class='prev-page' href='%s' data-page='%d'><span aria-hidden='true'>%s</span></a>",
        esc_url( add_query_arg( 'paged', max( 1, $current_page-1 ), $current_url ) ),
        max( 1, $current_page-1 ), '&lsaquo;');
    }

    $html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
    $page_links[] = sprintf( _x( '%1$s of %2$s', 'paging' ), $current_page, $html_total_pages );

    if ( $disable_next ) {
      $page_links[] = '<span class="navspan" aria-hidden="true">&rsaquo;</span>';
    } else {
      $page_links[] = sprintf( "<a class='next-page' href='%s' data-page='%d'><span aria-hidden='true'>%s</span></a>",
        esc_url( add_query_arg( 'paged', min( $total_pages, $current_page+1 ), $current_url ) ),
        min( $total_pages, $current_page+1 ), '&rsaquo;');
    }

    if ( $disable_last ) {
      $page_links[] = '<span class="navspan" aria-hidden="true">&raquo;</span>';
    } else {
      $page_links[] = sprintf( "<a class='last-page' href='%s' data-page='%d'><span aria-hidden='true'>%s</span></a>",
        esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
        $total_pages, '&raquo;');
    }

    $output .= "\n<span class=\"pagination\">" . join( "\n", $page_links ) . '</span>';

    if($echo) {
      print $output;
    }
    else{
      return $output;
    }  

}

function nuno_builder_filter_block_name($where, &$wp_query){

   global $wpdb;

   $search_title=(isset($_POST['search']) && ''!=$_POST['search']) ? sanitize_text_field($_POST['search']): "";

    if ( $search_title !='' ){
      $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_title ) ) . '%\'';
    }
    
    return $where;
}


function nuno_builder_section_categories(){

  $categories = array(
      'testimonial'=> esc_html__('Testimonial','nuno-builder'),
      'team'=> esc_html__('Team','nuno-builder'),
      'social'=> esc_html__('Social','nuno-builder'),
      'separator'=> esc_html__('Separator','nuno-builder'),
      'progress-bar'=> esc_html__('Progress Bar','nuno-builder'),
      'pricing-table'=> esc_html__('Pricing Table','nuno-builder'),
      'opt-in-form'=> esc_html__('Opt-In Form','nuno-builder'),
      'icon-group'=> esc_html__('Icon Group','nuno-builder'),
      'iconboxes'=> esc_html__('Icon Box','nuno-builder'),
      'imageboxes'=> esc_html__('Image Box','nuno-builder'),
      'hover-box'=> esc_html__('Hover Box','nuno-builder'),
      'flip-box'=> esc_html__('Flip Box','nuno-builder'),
      'features'=> esc_html__('Features','nuno-builder'),
      'countdown'=> esc_html__('Countdown','nuno-builder'),
      'contact-form'=> esc_html__('Contact Form','nuno-builder'),
      'circle-bar'=> esc_html__('Circle Bar','nuno-builder'),
      'call-to-action'=> esc_html__('Call To Action','nuno-builder'),
      'accordion'=> esc_html__('Tab/Accordion','nuno-builder'),
      'button'=> esc_html__('Button','nuno-builder'),
  );

  return apply_filters( 'nuno_builder_section_categories', $categories);
}

?>
