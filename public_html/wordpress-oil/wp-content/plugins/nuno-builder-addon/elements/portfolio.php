<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder Addon
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('GUM_BUILDER_BASENAME') or die();

if(is_plugin_active('tg_custom_post/tg_custom_post.php')){


    class BuilderElement_gum_portfolio extends BuilderElement{

        function preview($atts, $content = null) {

          return $this->render($atts, $content);
        }

        function render($atts, $content = null, $base=''){

            if (!isset($compile)) {$compile='';}

            extract(shortcode_atts(array(
                'show_filter' => '1',
                'el_id'=>'',
                'el_class'=>'',
                'size'=>'medium',
                'column'=>'',
                'gutter'=>'',
                'layout'=>'fade',
                'posts_per_page'=> -1
            ), $atts, 'gum_portfolio'));


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

            wp_enqueue_script( 'isotope', GUM_BUILDER_URL . 'js/isotope.pkgd.min.js', array('jquery'), '2.0.0', false );
            wp_enqueue_script( 'imagesloaded', GUM_BUILDER_URL . 'js/imagesloaded.pkgd.js', array(), '4.1.1', false );
            wp_enqueue_script( 'gum-nuno-addon', GUM_BUILDER_URL . 'js/gum-nuno-addon.js', array('jquery'), '1.0.0', false );

            $rows = $filters = array();

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
                $filters['all']="<li class=\"active\" data-selector=\"*\"><a href=\"#\">". esc_html__('Show All','nuno-builder-addon')."</a></li>";
                $cat_slug=array();
                $cat_name=array();

                if($terms):

                foreach($terms as $term){
                  array_push($cat_slug,$term->slug);
                  array_push($cat_name,$term->name);
                  $filters[$term->slug]="<li data-selector=\"".$term->slug."\"><a href=\"#\">".$term->name."</a></li>";
                }

                endif;

                ob_start();?><div class="portfolio active <?php print implode(" ",$cat_slug);?>">
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

            $css_class=array('gum_portfolio','layout-'.$layout,'col-'.$column,'clearfix');

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

            if($gutter!=''){
                $margin = absint($gutter);
                if( $margin ) $margin = floor($margin / 2);

                add_page_css_style("#$el_id .portfolio-content .portfolio{padding-left:".$margin."px; padding-right:".$margin."px; padding-bottom:".$margin."px;}");
                add_page_css_style("#$el_id .portfolio-content{margin-left:-".$margin."px; margin-right:-".$margin."px;}");

                
            }

            nuno_add_element_margin_style("#$el_id",$atts);

            $compile.='class="'.@implode(" ",$css_class).'">';

            if((bool)$show_filter && count($filters)){
              $compile .='<ul class="portfolio-filter">'.implode("",$filters).'</ul>';
            }

            $compile .= '<div class="portfolio-content">'.implode("", $rows).'</div>';
            $compile.='</div>';


            return  $compile;

        }

    }

    add_builder_element('gum_portfolio',
     array( 
        'title' => esc_html__( 'Portfolio Grid', 'nuno-builder-addon' ),
        'icon'  =>'fa fa-th-large',
        'color' =>'#333333',
        'order'=>33,
        'class' => '',
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
            'default' => 'fade',
            'value'=>array(
              'fade'=> esc_html__('Fade In-Out','nuno-builder'),
              'slide'=> esc_html__('Slide Up','nuno-builder'),
              ),
            'type' => 'radio',
            ),
            array( 
            'heading' => esc_html__( 'Show Filter', 'nuno-builder-addon' ),
            'param_name' => 'show_filter',
            'default' => '1',
            'value'=>array(
              '1'=> esc_html__('Show','nuno-builder'),
              '0'=> esc_html__('Hide','nuno-builder'),
              ),
            'type' => 'radio',
            ),
            array( 
            'heading' => esc_html__('Number of posts to show:','nuno-builder-addon' ),
            'param_name' => 'posts_per_page',
            'class' => 'small',
            'value' => '',
            'type' => 'textfield'
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
              'heading' => esc_html__( 'Gutter Gap', 'nuno-builder-addon' ),
              'param_name' => 'gutter',
              'type' => 'textfield',
              'description'=> esc_html__('Space between items in px.','nuno-builder-addon')
            ),
            array( 
            'heading' => esc_html__( 'Image Size', 'nuno-builder' ),
            'param_name' => 'size',
            'type' => 'textfield',
            'value'=>"",
            'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'nuno-builder' )

            ),
            )
     ) );

}
?>
