<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_carousel extends BuilderElement {

    function render($atts, $content = null, $base = '') {
        extract( shortcode_atts( array(
            'el_class'=>'',
            'el_id'=>'',
            'spy'=>'none',
            'scroll_delay'=>300,
            'pagination' => 1,
            'speed'=>800,
            'column'=>1,
            'desktop_column'=>1,
            'small_column'=>1,
            'tablet_column'=>1,
            'mobile_column'=>1,
            'pagination_type'=>'bullet',
            'pagination_image'=>null,
            'pagination_icon'=>null,
            'pagination_color'=>'',
            'pagination_size'=>'',
            'pagination_position'=>'',
            'bullet_position'=>'',
            'autoplay'=>0,
            'loop'=>0,
            'center'=>0,
            'center_scale'=>'',
            'center_opacity'=>'',            
            'item_margin'=>'',
            'item_bg_color'=>'',
            'item_padding_h'=>'',
            'item_padding_v'=>'',            
            'interval'=>1000,
            'animation_out'=>'',
            'animation_in'=>'',
            'animation_center'=>'', 
            'off_m_top'=>'',
            'off_m_bottom'=>'',
            'off_m_left'=>'',
            'off_m_right'=>'',

        ), $atts ,'carousel') );

       $pattern = get_shortcode_regex();

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
            return "";

        wp_enqueue_style('owl.carousel');
        wp_enqueue_style('animate');
        wp_enqueue_script('owl.carousel');

        $widgetID=getElementTagID("carousel");

        $spydly=0;
        $i=0;
        $paginationthumb = $slide_styles = $pagination_styles = $pagination_offset = $slides = array();

        $css_style=getElementCssMargin($atts);
        if(''==$el_id){

            $el_id="element_".getElementTagID();
        }

        $css_class=array('owl-carousel-container','center-animate-'.$animation_center,'pagination-type-'.$pagination_type);
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }



        if(""!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        if($item_bg_color !=''){
          $slide_styles['background-color'] = "background-color:".$item_bg_color;
        }

        if($item_padding_h !=''){
          $item_padding_h = (int) $item_padding_h;

          $slide_styles['padding-left'] = 'padding-left:'.$item_padding_h."px";
          $slide_styles['padding-right'] = 'padding-right:'.$item_padding_h."px";

        }

        if($item_padding_v !=''){
          $item_padding_v = (int) $item_padding_v;

          $slide_styles['padding-top'] = 'padding-top:'.$item_padding_v."px";
          $slide_styles['padding-bottom'] = 'padding-bottom:'.$item_padding_v."px";

        }


        if($center){
          if($center_scale!=''){

            $center_scale = max(0, min( $center_scale, 1 ));
            $slide_styles['scale'] ='transform:scale('.floatval($center_scale).')';
            $slide_styles['webkit-scale'] ='-webkit-transform:scale('.floatval($center_scale).')';

          }

          if($center_opacity!=''){

            $center_opacity = max(0, min( $center_opacity, 1 ));
            $slide_styles['opacity'] ='opacity:'.floatval($center_opacity).'';

          }

        }


        if(count($slide_styles)){
          add_page_css_style("#$el_id .owl-item{".join(';', $slide_styles )."}");
        }


        if($pagination_image){
            $pagination_thumb=@explode(',',$pagination_image);
        }
        if($pagination_icon){
            $pagination_icons=@explode(',',$pagination_icon);
        }



        foreach ($matches as $key => $matche) {


             $scollspy="";

            if('none'!==$spy && !empty($spy) && $i < $column){

                $spydly=$spydly+(int)$scroll_delay;
                $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
            }

            $slides[] = '<div class="owl-slide"'.$scollspy.'>'.do_shortcode($matche[0]).'</div>';
            $i++;

            if($pagination_type!=='bullet' && $pagination_type!=='navigation' && $pagination){

                 $thumb="";
                if($pagination_type=='image' && !empty($pagination_thumb[$key])){

                    if(!empty($pagination_thumb[$key])){

                        $image = wp_get_attachment_image_src($pagination_thumb[$key]); 

                        $thumb="<img src=\"".$image[0]."\" alt=\"\" />";

                    }
                }
                else{
                    $thumb="<span class=\"default-owl-page\">".($key+1)."</span>";

                }

                $paginationthumb[$key]="<span class=\"owl-page\">".$thumb."</span>";
            }
        }


         if($pagination && $pagination_type!='navigation' && $bullet_position!=''){
            if($bullet_position!=''){
              array_push($css_class, 'pagination-'.sanitize_html_class($bullet_position));
            }
         }

        if($pagination && $pagination_type=='bullet'){

            if($pagination_color!='' || $pagination_size!=''){

              if($pagination_color !=''){
                $pagination_styles['background-color'] = 'background-color:'.$pagination_color;
              }

              if($pagination_size !=''){
                $pagination_styles['width'] = 'width:'.absint($pagination_size).'px';
                $pagination_styles['height'] = 'height:'.absint($pagination_size).'px';
              }

              add_page_css_style("#$widgetID .owl-page span,#$widgetID .owl-dot span{".join(';', $pagination_styles )."}");
            }

        }

        if($off_m_top!=''){
          $pagination_offset[] = 'margin-top:'.floatval($off_m_top).'px';
        }

        if($off_m_bottom!=''){
          $pagination_offset[] = 'margin-bottom:'.floatval($off_m_bottom).'px';
        }
        if($off_m_left!=''){
          $pagination_offset[] = 'margin-left:'.floatval($off_m_left).'px';
        }
        if($off_m_right!=''){
          $pagination_offset[] = 'margin-right:'.floatval($off_m_right).'px';
        }

        if(count($pagination_offset)){
          add_page_css_style("#$el_id .owl-custom-pagination,#$el_id .owl-pagination{".join(';',$pagination_offset)."}");
        }


        if($pagination && $pagination_type=='navigation'){

            if($pagination_position!=''){
              array_push($css_class, 'pagination-'.sanitize_html_class($pagination_position));
            }

            if($pagination_color !=''){
              $pagination_styles['color'] = 'color:'.$pagination_color.'!important';
            }

            if($pagination_size !=''){
              $pagination_styles['font-size'] = 'font-size:'.absint($pagination_size).'px';
            }

            $paginationthumb=apply_filters("nuno_carousel_navigation_btn",array("<span class=\"btn-owl prev\"".(count($pagination_styles)? ' style="'.join(';', $pagination_styles ).'"': "").">".esc_html__('Prev','nuno-builder')."</span>","<span class=\"btn-owl next\"".(count($pagination_styles)? ' style="'.join(';', $pagination_styles ).'"': "").">".esc_html__('Next','nuno-builder')."</span>"));
        }


        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.=" class=\"".@implode(" ",$css_class)."\">";

        $top = preg_match('/(top)/', $bullet_position) || preg_match('/(top)/', $pagination_position);

        if(count($paginationthumb) && $top ){

            $compile.='<div class="owl-custom-pagination '.sanitize_html_class($pagination_type).'">'.@implode(' ',$paginationthumb).'</div>';
        }

        $compile.='<div class="owl-carousel" id="'.$widgetID.'">'.join('', $slides).'</div>';

        if(count($paginationthumb) && !$top){
            $compile.='<div class="owl-custom-pagination '.sanitize_html_class($pagination_type).'">'.@implode(' ',$paginationthumb).'</div>';
        }


        $compile.='</div>';

        $script='<script type="text/javascript">'."\n".'jQuery(document).ready(function($) {
            \'use strict\';'."\n".'
            var '.$widgetID.' = $("#'.$widgetID.'");
            try{
           '.$widgetID.'.owlCarousel({
              responsiveClass:true,
                responsive : {
                    0 : {items : '.$mobile_column.'},
                    600 : {items : '.$tablet_column.'},
                    768 : {items : '.$small_column.'},
                    1024 : {items : '.$desktop_column.'},
                    1200 : {items : '.$column.'}
                },
                loop: '.($loop ? 'true':'false').',
                center: '.($center ? 'true':'false').',
                margin: '.absint($item_margin).',
                dots  : '.(($pagination && $pagination_type=='bullet')?"true":"false").",".($autoplay?'autoplay:true,':'')."
                smartSpeed  : ".$speed.",autoplayTimeout  : ".$interval.",rewindSpeed  : ".$speed.",";

if($animation_in!=''){
            $script.='animateIn:\''.sanitize_html_class($animation_in).'\',';
}

if($animation_out!=''){
            $script.='animateOut:\''.sanitize_html_class($animation_out).'\',';
}

      if(count($paginationthumb) && $pagination_type!=='bullet' && $pagination_type!=='navigation'){
                $script.='nav:false,dots:false,';

                $script.='onInitialized:function(el){
                  var $base= $(el.target),btn,currentBtn=1;
                  var carousel_container = $base.closest(\'.owl-carousel-container\');
                  btn=el.item.count;
                  currentBtn=el.item.index;

                  $(\'.owl-custom-pagination .owl-page\', carousel_container).each(function(i,el){

                          if(i >= btn ){$(el).hide();}  else{ $(el).show();}

                          if(i === currentBtn - 1 ){
                            $(this).closest(\'.owl-custom-pagination\').find(\'.owl-page\').removeClass(\'active\');
                            $(this).addClass(\'active\');
                          }

                          $(el).click(function(){

                              $(\'.owl-custom-pagination .owl-page\', carousel_container).removeClass(\'active\');
                              $(this).addClass(\'active\');
                             $base.trigger(\'to.owl.carousel\', i);
                          });
                     });
                },
                onChanged :function(el){

                  var $base=$(el.target),btn,currentBtn=1;
                  var carousel_container = $base.closest(\'.owl-carousel-container\');
                  btn=el.item.count;
                  currentBtn=el.item.index;


                  $(\'.owl-custom-pagination .owl-page\', carousel_container).each(function(i,el){

                          if(i >= btn ){$(el).hide();}  else{ $(el).show();}

                          if(i === currentBtn - 1 ){
                            $(this).closest(\'.owl-custom-pagination\').find(\'.owl-page\').removeClass(\'active\');
                            $(this).addClass(\'active\');
                          }

                          $(el).click(function(){
                              $(\'.owl-custom-pagination .owl-page\', carousel_container).removeClass(\'active\');
                              $(this).addClass(\'active\');
                              $base.addClass(\'next_owl_carousel\');
                          });
                     });

                }';

                $script.='});';

}
else if(count($paginationthumb) && $pagination_type=='navigation'){
                $script.='dots:false});';

                $script.=' var '.$widgetID.'_container = '.$widgetID.'.closest(\'.owl-carousel-container\');
                  $(\'.owl-custom-pagination .next\','.$widgetID.'_container).click(function(){ 
                    '.$widgetID.'.trigger(\'next.owl.carousel\');
                  });
                  $(\'.owl-custom-pagination .prev\','.$widgetID.'_container).click(function(){
                    '.$widgetID.'.trigger(\'prev.owl.carousel\');
                  });';

}

if($pagination_type=='bullet'){
                $script.='});';


}

         $script.='}
            catch(err){}
        });</script>';



        return $compile.$script;
    }
}


add_builder_element('carousel',
    array( 
    'title' => esc_html__( 'Carousel', 'nuno-builder' ),
    'icon'=>'dashicons dashicons-image-flip-horizontal',
    'color'=>'#968474',
    'order'=>6,
    'is_container'=>true,
    'options' => array(
        array( 
        'heading' => esc_html__( 'Module Title', 'nuno-builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'type' => 'textfield'
         ),
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
        'heading' => esc_html__( 'Slide Speed', 'nuno-builder' ),
        'param_name' => 'speed',
        'class' => '',
        'default' => '800',
        'description' => esc_html__( 'Slide speed (in millisecond). The lower value the faster slides', 'nuno-builder' ),
        'type' => 'textfield'
         ),         
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Cell Background Color', 'nuno-builder'),
          "param_name" => "item_bg_color",
          "description" => esc_html__("Select color for item background", "nuno-builder"),
        ),
        array( 
          'heading' => esc_html__( 'Cell Padding Horizontal', 'nuno-builder' ),
          'param_name' => 'item_padding_h',
          'class'=>'small',
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Cell Padding Vertical', 'nuno-builder' ),
          'param_name' => 'item_padding_v',
          'class'=>'small',
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Item Horizontal Gap', 'nuno-builder' ),
          'param_name' => 'item_margin',
          'class'=>'small',
          "description" => esc_html__("Space between each item", "nuno-builder"),
          'type' => 'textfield',
        ),

        array( 
          'heading' => esc_html__( 'Autoplay', 'nuno-builder' ),
          'param_name' => 'autoplay',
          'description' => esc_html__( 'Set Autoplay', 'nuno-builder' ),
          'class' => '',
          'default'=>'0',
          'value'=>array(
              '1' => esc_html__('Yes','nuno-builder'),
              '0' => esc_html__('No','nuno-builder')
              ),
          'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Slide Interval', 'nuno-builder' ),
        'param_name' => 'interval',
        'class' => '',
        'default' => '1000',
        'description' => esc_html__( 'Slide Interval (in millisecond)', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'autoplay', 'value' => array( '1') )       
         ),         

        array( 
          'heading' => esc_html__( 'Infinity Loop', 'nuno-builder' ),
          'param_name' => 'loop',
          'description' => esc_html__( 'Infinity loop. Duplicate last and first items to get loop illusion.', 'nuno-builder' ),
          'class' => '',
          'default'=>'0',
          'value'=>array(
              '1' => esc_html__('Yes','nuno-builder'),
              '0' => esc_html__('No','nuno-builder')
              ),
          'type' => 'radio',
         ),     
        array( 
          'heading' => esc_html__( 'Center Item', 'nuno-builder' ),
          'param_name' => 'center',
          'description' => esc_html__( 'Center item. Works well with even an odd number of items.', 'nuno-builder' ),
          'class' => '',
          'default'=>'0',
          'value'=>array(
              '1' => esc_html__('Yes','nuno-builder'),
              '0' => esc_html__('No','nuno-builder')
              ),
          'type' => 'radio',
         ),     
        array( 
        'heading' => esc_html__( 'Center Item Scale', 'nuno-builder' ),
        'param_name' => 'center_scale',
        'param_holder_class' => 'half',
        'class'=>'small',
        'default' => '',
        'description' => esc_html__( 'The center item size bigger from regular slide. Enter value 0.1 - 1.0', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'center', 'value' => '1' )       
         ),     
        array( 
        'heading' => esc_html__( 'Regular Item Opacity', 'nuno-builder' ),
        'param_name' => 'center_opacity',
        'param_holder_class' => 'half',
        'class'=>'small',
        'default' => '',
        'description' => esc_html__( 'The regular slide item will blur. Enter value 0.1 - 1.0', 'nuno-builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'center', 'value' => '1' )       
         ),     


        array( 
          'heading' => esc_html__( 'Slide Animation', 'nuno-builder' ),
          'param_name' => 'animation',
          'description' => esc_html__( 'Animate functions work only with one item and only in browsers that support perspective property.', 'nuno-builder' ),
          'type' => 'subheading',
        ),

        array( 
        'heading' => esc_html__( 'Slide In', 'nuno-builder' ),
        'param_name' => 'animation_in',
        'description' => esc_html__( 'Animation while slide in.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            '' => esc_html__('Default','nuno-builder'),
            'zoomIn' => esc_html__('zoomIn','nuno-builder'),
            'zoomInUp' => esc_html__('zoomInUp','nuno-builder'),
            'zoomInDown' => esc_html__('zoomInDown','nuno-builder'),
            'zoomInLeft' => esc_html__('zoomInLeft','nuno-builder'),
            'zoomInRight' => esc_html__('zoomInRight','nuno-builder'),
            'rollIn' => esc_html__('rollIn','nuno-builder'),
            'slideInUp' => esc_html__('slideInUp','nuno-builder'),
            'slideInDown' => esc_html__('slideInDown','nuno-builder'),
            'slideInLeft' => esc_html__('slideInLeft','nuno-builder'),
            'slideInRight' => esc_html__('slideInRight','nuno-builder'),
            'rotateIn' => esc_html__('rotateIn','nuno-builder'),
            'rotateInDownLeft' => esc_html__('rotateInDownLeft','nuno-builder'),
            'rotateInDownRight' => esc_html__('rotateInDownRight','nuno-builder'),
            'rotateInUpLeft' => esc_html__('rotateInUpLeft','nuno-builder'),
            'rotateInUpRight' => esc_html__('rotateInUpRight','nuno-builder'),
            'lightSpeedIn' => esc_html__('lightSpeedIn','nuno-builder'),
            'flipInX' => esc_html__('flipInX','nuno-builder'),
            'flipInY' => esc_html__('flipInY','nuno-builder'),

            'fadeIn' => esc_html__('fadeIn','nuno-builder'),
            'fadeInDown' => esc_html__('fadeInDown','nuno-builder'),
            'fadeInDownBig' => esc_html__('fadeInDownBig','nuno-builder'),
            'fadeInLeft' => esc_html__('fadeInLeft','nuno-builder'),
            'fadeInLeftBig' => esc_html__('fadeInLeftBig','nuno-builder'),
            'fadeInRight' => esc_html__('fadeInRight','nuno-builder'),
            'fadeInRightBig' => esc_html__('fadeInRightBig','nuno-builder'),
            'fadeInUp' => esc_html__('fadeInUp','nuno-builder'),
            'fadeInUpBig' => esc_html__('fadeInUpBig','nuno-builder'),
            'bounceIn' => esc_html__('bounceIn','nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     

        array( 
        'heading' => esc_html__( 'Slide Out', 'nuno-builder' ),
        'param_name' => 'animation_out',
        'description' => esc_html__( 'Animation while slide out', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            '' => esc_html__('Default','nuno-builder'),
            'zoomOut' => esc_html__('zoomOut','nuno-builder'),
            'zoomOutUp' => esc_html__('zoomOutUp','nuno-builder'),
            'zoomOutDown' => esc_html__('zoomOutDown','nuno-builder'),
            'zoomOutLeft' => esc_html__('zoomOutLeft','nuno-builder'),
            'zoomOutRight' => esc_html__('zoomOutRight','nuno-builder'),
            'rollOut' => esc_html__('rollOut','nuno-builder'),
            'slideOutDown' => esc_html__('slideOutDown','nuno-builder'),
            'slideOutUp' => esc_html__('slideOutUp','nuno-builder'),
            'slideOutRight' => esc_html__('slideOutRight','nuno-builder'),
            'slideOutLeft' => esc_html__('slideOutLeft','nuno-builder'),
            'rotateOut' => esc_html__('rotateOut','nuno-builder'),
            'rotateOutDownLeft' => esc_html__('rotateOutDownLeft','nuno-builder'),
            'rotateOutDownRight' => esc_html__('rotateOutDownRight','nuno-builder'),
            'rotateOutUpLeft' => esc_html__('rotateOutUpLeft','nuno-builder'),
            'rotateOutUpRight' => esc_html__('rotateOutUpRight','nuno-builder'),
            'lightSpeedOut' => esc_html__('lightSpeedOut','nuno-builder'),
            'flipOutX' => esc_html__('flipOutX','nuno-builder'),
            'flipOutY' => esc_html__('flipOutY','nuno-builder'),

            'fadeOut' => esc_html__('fadeOut','nuno-builder'),
            'fadeOutDown' => esc_html__('fadeOutDown','nuno-builder'),
            'fadeOutDownBig' => esc_html__('fadeOutDownBig','nuno-builder'),
            'fadeOutLeft' => esc_html__('fadeOutLeft','nuno-builder'),
            'fadeOutLeftBig' => esc_html__('fadeOutLeftBig','nuno-builder'),
            'fadeOutRight' => esc_html__('fadeOutRight','nuno-builder'),
            'fadeOutRightBig' => esc_html__('fadeOutRightBig','nuno-builder'),
            'fadeOutUp' => esc_html__('fadeOutUp','nuno-builder'),
            'fadeOutUpBig' => esc_html__('fadeOutUpBig','nuno-builder'),
            'bounceOut' => esc_html__('bounceOut','nuno-builder'),
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Center Slide', 'nuno-builder' ),
        'param_name' => 'animation_center',
        'description' => esc_html__( 'Animation for center slide in.', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            '' => esc_html__('Default','nuno-builder'),
            'pulse' => esc_html__('Pulse','nuno-builder'),
            'rubberBand' => esc_html__('rubberBand','nuno-builder'),
            'swing' => esc_html__('swing','nuno-builder'),
            'tada' => esc_html__('tada','nuno-builder'),
            'wobble' => esc_html__('wobble','nuno-builder'),
            'bounce' => esc_html__('bounce','nuno-builder'),
            'zoomIn' => esc_html__('zoomIn','nuno-builder'),
            'zoomInUp' => esc_html__('zoomInUp','nuno-builder'),
            'zoomInDown' => esc_html__('zoomInDown','nuno-builder'),
            'zoomInLeft' => esc_html__('zoomInLeft','nuno-builder'),
            'zoomInRight' => esc_html__('zoomInRight','nuno-builder'),
            'rollIn' => esc_html__('rollIn','nuno-builder'),
            'slideInUp' => esc_html__('slideInUp','nuno-builder'),
            'slideInDown' => esc_html__('slideInDown','nuno-builder'),
            'slideInLeft' => esc_html__('slideInLeft','nuno-builder'),
            'slideInRight' => esc_html__('slideInRight','nuno-builder'),
            'rotateIn' => esc_html__('rotateIn','nuno-builder'),
            'rotateInDownLeft' => esc_html__('rotateInDownLeft','nuno-builder'),
            'rotateInDownRight' => esc_html__('rotateInDownRight','nuno-builder'),
            'rotateInUpLeft' => esc_html__('rotateInUpLeft','nuno-builder'),
            'rotateInUpRight' => esc_html__('rotateInUpRight','nuno-builder'),
            'lightSpeedIn' => esc_html__('lightSpeedIn','nuno-builder'),
            'flipInX' => esc_html__('flipInX','nuno-builder'),
            'flipInY' => esc_html__('flipInY','nuno-builder'),
            'fadeIn' => esc_html__('fadeIn','nuno-builder'),
            'fadeInDown' => esc_html__('fadeInDown','nuno-builder'),
            'fadeInDownBig' => esc_html__('fadeInDownBig','nuno-builder'),
            'fadeInLeft' => esc_html__('fadeInLeft','nuno-builder'),
            'fadeInLeftBig' => esc_html__('fadeInLeftBig','nuno-builder'),
            'fadeInRight' => esc_html__('fadeInRight','nuno-builder'),
            'fadeInRightBig' => esc_html__('fadeInRightBig','nuno-builder'),
            'fadeInUp' => esc_html__('fadeInUp','nuno-builder'),
            'fadeInUpBig' => esc_html__('fadeInUpBig','nuno-builder'),
            'bounceIn' => esc_html__('bounceIn','nuno-builder'),
            ),
        'type' => 'dropdown',
        'dependency' => array( 'element' => 'center', 'value' => '1' )
         ),   
        array( 
        'heading' => esc_html__( 'Pagination', 'nuno-builder' ),
        'param_name' => 'pagination',
        'description' => esc_html__( 'Pagination Setting', 'nuno-builder' ),
        'class' => '',
        'default'=>'1',
        'value'=>array(
            '1' => esc_html__('Show','nuno-builder'),
            '0' => esc_html__('Hidden','nuno-builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Pagination Type', 'nuno-builder' ),
        'param_name' => 'pagination_type',
        'class' => '',
        'default'=>'bullet',
        'value'=>array(
            'bullet'  => esc_html__('Standard','nuno-builder'),
            'image' => esc_html__('Custom Image','nuno-builder'),
            'navigation'  => esc_html__('Navigation Button','nuno-builder') 
            ),
        'type' => 'dropdown',
        'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )       
         ),     
        array( 
        'heading' => esc_html__( 'Color', 'nuno-builder' ),
        'param_name' => 'pagination_color',
        'value' => '',
        'type' => 'colorpicker',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet','navigation') )       
         ),
        array( 
        'heading' => esc_html__( 'Pagination Preview', 'nuno-builder' ),
        'param_name' => 'pagination_to_preview',
        'value' => '',
        'type' => 'carousel_preview',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet') )       
         ),
        array( 
        'heading' => esc_html__( 'Size', 'nuno-builder' ),
        'param_name' => 'pagination_size',
        'params' => array('min'=>12,'max'=>50,'step'=>1),
        'type' => 'slider_value',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet','navigation') )       
         ),
        array( 
        'heading' => esc_html__( 'Pagination Image', 'nuno-builder' ),
        'param_name' => 'pagination_image',
        'class' => '',
        'value' => '',
        'type' => 'images',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'image') )       
         ),

        array( 
        'heading' => esc_html__( 'Pagination Placement', 'nuno-builder' ),
        'param_name' => 'pagination_position',
        'description' => esc_html__( 'Navigation Position', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'side' => esc_html__('Both side','nuno-builder'),
            'bottom' => esc_html__('Bottom','nuno-builder'),
            'top' => esc_html__('Top','nuno-builder'),
            ),
        'type' => 'radio',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'navigation') )   
         ),    
        array( 
        'heading' => esc_html__( 'Pagination Placement', 'nuno-builder' ),
        'param_name' => 'bullet_position',
        'description' => esc_html__( 'Navigation Placement', 'nuno-builder' ),
        'class' => '',
        'default'=>'',
        'value'=>array(
            'top-left' => esc_html__('Top Left','nuno-builder'),
            'top-center' => esc_html__('Top Center','nuno-builder'),
            'top-right' => esc_html__('Top Right','nuno-builder'),
            'bottom-right' => esc_html__('Bottom Right','nuno-builder'),
            'bottom-center' => esc_html__('Bottom Center','nuno-builder'),
            'bottom-left' => esc_html__('Bottom Left','nuno-builder'),
            ),
        'type' => 'radio',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet', 'image') )   
         ),     

        array( 
          'heading' => esc_html__( 'Pagination Offset Margin', 'nuno-builder' ),
          'param_name' => 'margin_offset',
          'description' => esc_html__( 'Change the margin to adjust pagination position', 'nuno-builder' ),
          'type' => 'subheading',
          'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )    
        ),
         array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'off_m_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )    
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'off_m_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )    
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'off_m_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )    
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'off_m_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )    
        ),

        array( 
        'heading' => esc_html__( 'Number of Columns', 'nuno-builder' ),
        'param_name' => 'column',
        'description' => esc_html__( 'Number of columns on screen larger than 1200px screen resolution', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            '1' => esc_html__('One Column','nuno-builder'),
            '2' => esc_html__('Two Columns','nuno-builder'),
            '3' => esc_html__('Three Columns','nuno-builder'),
            '4' => esc_html__('Four Columns','nuno-builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Desktop Column', 'nuno-builder' ),
        'param_name' => 'desktop_column',
        'description' => esc_html__( 'items between 1200px and 1023px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            '1' => esc_html__('One Column','nuno-builder'),
            '2' => esc_html__('Two Columns','nuno-builder'),
            '3' => esc_html__('Three Columns','nuno-builder'),
            '4' => esc_html__('Four Columns','nuno-builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Desktop Small Column', 'nuno-builder' ),
        'param_name' => 'small_column',
        'description' => esc_html__( 'items between 1024px and 768px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            '1' => esc_html__('One Column','nuno-builder'),
            '2' => esc_html__('Two Columns','nuno-builder'),
            '3' => esc_html__('Three Columns','nuno-builder'),
            '4' => esc_html__('Four Columns','nuno-builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Tablet Column', 'nuno-builder' ),
        'param_name' => 'tablet_column',
        'description' => esc_html__( 'items between 768px and 600px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            '1' => esc_html__('One Column','nuno-builder'),
            '2' => esc_html__('Two Columns','nuno-builder'),
            '3' => esc_html__('Three Columns','nuno-builder'),
            '4' => esc_html__('Four Columns','nuno-builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Mobile Column', 'nuno-builder' ),
        'param_name' => 'mobile_column',
        'description' => esc_html__( 'items below 600px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            '1' => esc_html__('One Column','nuno-builder'),
            '2' => esc_html__('Two Columns','nuno-builder'),
            '3' => esc_html__('Three Columns','nuno-builder'),
            '4' => esc_html__('Four Columns','nuno-builder')
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
    )

 ) );


?>
