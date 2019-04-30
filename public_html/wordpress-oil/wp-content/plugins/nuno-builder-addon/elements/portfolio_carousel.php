<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.1
*/
defined('GUM_BUILDER_BASENAME') or die();

if(is_plugin_active('tg_custom_post/tg_custom_post.php')){

  class BuilderElement_portfolio_carousel extends BuilderElement {

      function render($atts, $content = null, $base = '') {
          extract( shortcode_atts( array(
              'pagination' => 1,
              'navigation_position'=>'',
              'layout'=>'fade',
              'posts_per_page'=> -1,
              'speed'=>800,
              'column'=>1,
              'desktop_column'=>1,
              'small_column'=>1,
              'tablet_column'=>1,
              'mobile_column'=>1,
              'pagination_type'=>'bullet',
              'pagination_color'=>'',
              'pagination_size'=>'',
              'autoplay'=>0,
              'loop'=>0,
              'item_margin'=>'',
              'layout'=>'',
              'size'=>'',
              'el_class'=>'',
              'el_id'=>'',
              'interval'=>1000,
              'animation_out'=>'',
              'animation_in'=>'',
          ), $atts ,'portfolio_carousel') );

          $query_params= array(
            'posts_per_page' => $posts_per_page,
            'no_found_rows' => true,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
            'post_type'=>'tg_custom_post'
          );

          $query = new WP_Query($query_params);

          if (is_wp_error($query) || !$query->have_posts()) {
            return '';
          }

          wp_enqueue_style('owl.carousel');
          wp_enqueue_style('animate');
          wp_enqueue_script('owl.carousel');

          $widgetID=getElementTagID("carousel");

          $spydly=0;
          $i=0;
          $paginationthumb = $rows  = array();

          if(!isset($atts['item_margin'])) $item_margin = 10;


          $css_style=getElementCssMargin($atts);
          if(''==$el_id){

              $el_id="element_".getElementTagID();
          }

          $css_class=array('portfolio-carousel','owl-carousel-container','layout-'.$layout);

          if(''!=$el_class){
              array_push($css_class, $el_class);
          }




      $compile="<div ";
      if(''!=$el_id){
          $compile.="id=\"$el_id\" ";
      }

      $compile.=" class=\"".@implode(" ",$css_class)."\">";

      if(""!=$css_style){
        add_page_css_style("#$el_id {".$css_style."}");
      }

      nuno_add_element_margin_style("#$el_id",$atts);


          $compile.='<div class="owl-carousel portfolio-content" id="'.$widgetID.'">';


              while ( $query->have_posts() ) : 

                $query->the_post();
                $post_id = get_the_ID();

                $thumb_id = get_post_thumbnail_id($post_id);

                $thumb_url=$image_url=null;
                $alt_image="";

                if($image=get_image_size($thumb_id,$size)){
                        $thumb_url=$image[0];
                 }

                if (isset($thumb_image[0])) {
                  $thumb_url = $thumb_image[0];
                  $alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                }

                $full_image = wp_get_attachment_image_src($thumb_id,'full',false); 

                if (isset($full_image[0])) {
                  $image_url = $full_image[0];
                }

                $terms=get_the_terms($post_id,'tg_postcat')?array_values(get_the_terms($post_id,'tg_postcat')):false;
                $cat_name=array();

                if($terms):

                foreach($terms as $term){
                  array_push($cat_name,$term->name);
                }

                endif;
                ob_start();?><div class="portfolio">
<?php if($layout=='slide'):

$excerpt = strip_shortcodes(get_the_excerpt());
$excerpt = wp_trim_words($excerpt, 20);
?>
    <div class="wrap-inner">
    <div class="portfolio-image clearfix">
      <img src="<?php print esc_url($thumb_url);?>"  alt="<?php print esc_attr($alt_image);?>"/>
    </div>
      <div class="image-overlay">
          <div class="image-overlay-container">
              <div class="portfolio-info">
                <h3 class="portfolio-title">
                  <?php the_title();?>
                </h3>
                <div class="portfolio-excerpt"><?php print $excerpt;?></div>
                <a class="read-more-portfolio" href="<?php the_permalink();?>"><?php esc_html_e('read more','nuno-builder-addon');?></a>
              </div>

            </div>
      </div>
    </div>
<?php else:?><a href="<?php the_permalink();?>">
    <div class="portfolio-image clearfix">
      <img src="<?php print esc_url($thumb_url);?>"  alt="<?php print esc_attr($alt_image);?>"/>
    </div>
      <div class="image-overlay">
          <div class="image-overlay-container">
              <div class="portfolio-info">
                <h3 class="portfolio-title">
                  <?php the_title();?>
                </h3>
                <?php if(isset($cat_name[0])):?>
                <div class="portfolio-term"><?php print esc_html($cat_name[0]);?></div>
              <?php endif;?>
              </div>

            </div>
      </div>
    </a><?php endif;?>
    </div><?php 

                $row = ob_get_clean();
                array_push($rows, $row);

              endwhile;
              wp_reset_postdata();

              $compile.= implode("", $rows).'</div>';

          if($pagination && $pagination_type=='bullet' && ($pagination_color!='' || $pagination_size!='')){

              $compile.="<style type=\"text/css\">#$widgetID .owl-page span,#$widgetID .owl-dot span{".($pagination_color!=''?"background-color:$pagination_color;border-color:$pagination_color":"").($pagination_size!=''?";width:".$pagination_size."px;height:".$pagination_size."px;border-radius:50%":"")."}</style>";
          }

          if($pagination && $pagination_type=='navigation'){

              $paginationthumb=apply_filters("nuno_carousel_navigation_btn",array("<span class=\"btn-owl prev\">".esc_html__('Prev','nuno-builder')."</span>","<span class=\"btn-owl next\">".esc_html__('Next','nuno-builder')."</span>"));
          }

          if(count($paginationthumb)){

              $compile.='<div class="owl-custom-pagination '.sanitize_html_class($pagination_type).($navigation_position!='' ? ' position-'.$navigation_position:'' ).'">'.@implode(' ',$paginationthumb).'</div>';
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
                margin: '.absint($item_margin).',
                dots  : '.(($pagination && $pagination_type=='bullet')?"true":"false").",".($autoplay?'autoPlay:true,':'')."
                smartSpeed  : ".$speed.",autoplayTimeout  : ".$interval.",rewindSpeed  : ".$speed.",";

    if($animation_in!=''){
                $script.='animateIn:\''.sanitize_html_class($animation_in).'\',';
    }

    if($animation_out!=''){
                $script.='animateOut:\''.sanitize_html_class($animation_out).'\',';
    }

    if($pagination_type=='navigation'){

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


  add_builder_element('portfolio_carousel',
      array( 
      'title' => esc_html__( 'Portfolio Carousel', 'nuno-builder-addon' ),
      'icon'=>'fa fa-ellipsis-h',
      'color'=>'#333333',
      'order'=>34,
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
            'heading' => esc_html__( 'Grid Layout', 'nuno-builder-addon' ),
            'param_name' => 'layout',
            'admin_label' => true,
            'default' => 'fade',
            'value'=>array(
              'fade'=> esc_html__('Fade In-Out','nuno-builder'),
              'slide'=> esc_html__('Slide Up','nuno-builder'),
              ),
            'type' => 'radio',
            ),
            array( 
            'heading' => esc_html__( 'Image Size', 'nuno-builder' ),
            'param_name' => 'size',
            'admin_label' => true,
            'type' => 'textfield',
            'value'=>"",
            'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'nuno-builder' )

            ),
            array( 
            'heading' => esc_html__('Number of posts to show:','nuno-builder-addon' ),
            'param_name' => 'posts_per_page',
            'class' => 'small',
            'value' => '',
            'type' => 'textfield'
             ),           array( 
          'heading' => esc_html__( 'Slide Speed', 'nuno-builder' ),
          'param_name' => 'speed',
          'class' => '',
          'default' => '800',
          'description' => esc_html__( 'Slide speed (in millisecond). The lower value the faster slides', 'nuno-builder' ),
          'type' => 'textfield'
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
            'heading' => esc_html__( 'Item Horizontal Gap', 'nuno-builder' ),
            'param_name' => 'item_margin',
            'class'=>'small',
            "description" => esc_html__("Space between each item", "nuno-builder"),
            'type' => 'textfield',
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
              'navigation'  => esc_html__('Navigation Button','nuno-builder') 
              ),
          'type' => 'dropdown',
          'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )       
           ),     
          array( 
          'heading' => esc_html__( 'Navigation Position', 'nuno-builder-addon' ),
          'param_name' => 'navigation_position',
          'class' => '',
          'default'=>'',
          'value'=>array(
              ''  => esc_html__('Default','nuno-builder-addon'),
              'top'  => esc_html__('Top','nuno-builder-addon'),
              'bottom'  => esc_html__('Bottom','nuno-builder-addon') 
              ),
          'type' => 'dropdown',
          'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'navigation') )       
           ),     
          array( 
          'heading' => esc_html__( 'Color', 'nuno-builder' ),
          'param_name' => 'pagination_color',
          'value' => '',
          'type' => 'colorpicker',
          'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet') )       
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
          'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet') )       
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
              '4' => esc_html__('Four Columns','nuno-builder'),
              '5' => esc_html__('Five Columns','nuno-builder'),
              '6' => esc_html__('Six Columns','nuno-builder')
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
      )

   ) );

}
?>
