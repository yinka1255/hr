<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder Addon
 * @author      support@themegum.com
 * @since       1.0.3
*/
defined('GUM_BUILDER_BASENAME') or die();

if (class_exists('petro_service') && is_plugin_active('petro_service/petro_service.php')){

   $taxonomy_object = get_taxonomy( 'service_cat');


    class BuilderElement_petro_service extends BuilderElement{

        function preview($atts, $content = null) {

          return $this->render($atts, $content);
        }

        function render($atts, $content = null, $base=''){

            if (!isset($compile)) {$compile='';}

            extract(shortcode_atts(array(
                'el_id'=>'',
                'el_class'=>'',
                'column'=>'',
                'layout'=>'6',
                'desc_length'=>'',
                'size'=>'',
                'grid_m_top'=>'',
                'grid_m_bottom'=>'',
                'grid_m_left'=>'',
                'grid_m_right'=>''
            ), $atts, 'petro_service'));

            $services = get_terms( array('taxonomy'=> 'service_cat', 'hide_empty' => true ) );

            if(!$services || !count($services)) return;


            $css_class=array('petro_service','layout-'.$layout,'col-'.$column,'clearfix');
            $rows = array();

            if(''!=$el_class){
                array_push($css_class, $el_class);
            }

            $column = min( 12, max($column, 1 ));
            $grid = 12 / $column;


            foreach ( $services as $service ) {

                $service_image=get_metadata('term', $service->term_id, '_thumbnail_id', true);
                $service_icon=get_metadata('term', $service->term_id, '_category_icon', true);
                $description = ($desc_length) ? wp_trim_words( $service->description , $desc_length, '') : $service->description;

                $shortcode = '[el_iconbox layout="'.$layout.'" m_top="'.$grid_m_top.'" m_bottom="'.$grid_m_bottom.'" m_left="'.$grid_m_left.'" m_right="'.$grid_m_right.'" size="'.$size.'" image="'.$service_image.'"  icon_type="'.$service_icon.'" iconbox_heading="'.esc_html($service->name).'" link="'.esc_url( get_term_link( $service ) ).'" label_link="'.esc_html__('Read More','nuno-builder-addon').'" target="_self" ]'.$description.'[/el_iconbox]';

                $rows[] = '<div class="el_column col-md-'.$grid.'"><div class="inner-column">'.do_shortcode($shortcode).'</div></div>';

            }


            $css_style=getElementCssMargin($atts);

            if(""!=$css_style){
              add_page_css_style("#$el_id {".$css_style."}");
            }

            if(''==$el_id){
                $el_id="element_".getElementTagID();
            }

            $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            nuno_add_element_margin_style("#$el_id",$atts);

            $compile.='class="'.@implode(" ",$css_class).'">';
            $compile .= '<div class="row el_row column_equal_height"><div class="inner-row">'.implode("", $rows).'</div></div>';
            $compile.='</div>';


            return  $compile;

        }

    }

    add_builder_element('petro_service',
     array( 
        'title' => sprintf( esc_html__( '%s Grid', 'nuno-builder-addon' ), $taxonomy_object->labels->name ),
        'icon'  =>'fa fa-truck',
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
                       )
            ),
            array( 
            'heading' => esc_html__( 'Image Size', 'nuno-builder' ),
            'param_name' => 'size',
            'type' => 'textfield',
            'param_holder_class'=>'small-wide',
            'value'=>"",
            'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'nuno-builder' ),
            'dependency' => array( 'element' => 'layout', 'value' => '7' ) 
            ),
            array( 
              'heading' => esc_html__( 'Description Word Length', 'nuno-builder-addon' ),
              'param_name' => 'desc_length',
              'param_holder_class'=>'small-wide',
              'type' => 'textfield',
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
              'heading' => esc_html__( 'Grid Margin', 'nuno-builder-addon' ),
              'description' => esc_html__( 'Margin each category.', 'nuno-builder-addon' ),
              'param_name' => 'margin_grid',
              'type' => 'heading',
            ),
             array( 
              'heading' => esc_html__( 'Top', 'nuno-builder' ),
              'param_name' => 'grid_m_top',
              'param_holder_class'=>'m_top',
              'type' => 'textfield',
            ),
            array( 
              'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
              'param_name' => 'grid_m_bottom',
              'param_holder_class'=>'m_bottom',
              'type' => 'textfield',
            ),
            array( 
              'heading' => esc_html__( 'Left', 'nuno-builder' ),
              'param_name' => 'grid_m_left',
              'param_holder_class'=>'m_left',
              'type' => 'textfield',
            ),
            array( 
              'heading' => esc_html__( 'Right', 'nuno-builder' ),
              'param_name' => 'grid_m_right',
              'param_holder_class'=>'m_right',
              'type' => 'textfield',
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
            )
     ) );

}
?>
