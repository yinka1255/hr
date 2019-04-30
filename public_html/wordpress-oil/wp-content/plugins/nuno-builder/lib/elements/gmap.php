<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.6.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_map extends BuilderElement{

    function render($atts, $content = null, $base="") {

        extract( shortcode_atts( array(
            'el_class'=>'',
            'el_id'=>'',
            'lat'=>-8.2077372,
            'lang'=>114.385405,
            'zoom'=>15,
            'zoomcontrol'=>true,
            'pancontrol'=>true,
            'streetcontrol'=>true,
            'scrollcontrol'=>true,
            'height'=>'400px',
            'width'=>'',
            'marker'=>'default',
            'api_key'=>'',
            'image_marker'=>'',
        ), $atts,'el_map' ) );

        wp_enqueue_script('gmap',"https://maps.googleapis.com/maps/api/js?key={$api_key}",array('jquery'));

        if(''==$el_id){
            $el_id="element_".getElementTagID();
        }

        $css_class=array('el-map');

        $height=abs((int)$height)."px";
        $width= ($width!='') ? abs((int)$width)."px" : "";

        if(''!=$el_class){
           array_push($css_class, $el_class);
        }

        $mapOptions=array();
        $mapOptions['zoom']='zoom: '.$zoom;
        $markerOption="";

        if($marker!=='default' && $image_marker!=''){

              $imageMarker = wp_get_attachment_image_src(trim($image_marker),'full',false); 
              if(!empty($imageMarker[0])){
                  $image_url=$imageMarker[0];

                  $markerOption='var iconMarker = {url: \''.$image_url.'\'};';
              }
        }

        if(!$zoomcontrol){$mapOptions['zoomControl']='zoomControl:false';}
        if(!$pancontrol){$mapOptions['panControl']='panControl:false';}
        if(!$streetcontrol){$mapOptions['streetViewControl']='streetViewControl:false';}
        if(!$scrollcontrol){$mapOptions['scrollwheel']='scrollwheel:false';}

        $css_style=getElementCssMargin($atts);

        $html='<div id="map-'.$el_id.'" class="google-map" style="height:'.$height.((!empty($width))?";width:".$width."":"").'"></div>';

        $html.='<script type="text/javascript">';
        $html.='jQuery(document).ready(function($) {
                    try {
                        var map,center = new google.maps.LatLng('.$lat.','.$lang.'),
                        mapOptions = {center: center,mapTypeControl: false,'.@implode(',',$mapOptions).'};
                        '.$markerOption.'                        
                        map = new google.maps.Map(document.getElementById(\'map-'.$el_id.'\'),mapOptions);
                        var marker = new google.maps.Marker({
                            position: center,
                            map: map,
                          '.(!empty($markerOption)?"icon: iconMarker":"").'  
                        });
                        
                    } catch ($err) {
                    }
            });</script>';


       $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=$html."</div>";

        if(""!=$css_style){
            add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        return $compile;
    }
}

add_builder_element('el_map', 
  array(
    'title' => esc_html__( 'Google Map', 'nuno-builder' ),
    'description' => esc_html__( 'Place google map', 'nuno-builder' ),
    'icon'=>'fa fa-globe',
    'color'=>'#a379e7',
    'order'=>10,
    "options" => array(
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
                  'heading' => esc_html__( 'Google Map Api Key', 'nuno-builder' ),
                  'description' => wp_kses( __( 'Google Api Key needed at this element for break quota limit. See <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">Obtaining an API key</a>.', 'nuno-builder' ),array('a'=>array('href'=>array()))),
                  'param_name' => 'api_key',
                  'type' => 'textfield',
                ),
              array( 
                'heading' => esc_html__( 'Map Height (required)', 'nuno-builder' ),
                'param_name' => 'height',
                'description' => esc_html__( 'Map height in px.', 'nuno-builder' ),
                'type' => 'textfield',
                'default'=>'500px'
               ),     
              array( 
                'heading' => esc_html__( 'Map Width', 'nuno-builder' ),
                'param_name' => 'width',
                'type' => 'textfield',
                'value'=>'',
               ),     

              array( 
                'heading' => esc_html__( 'Latitude', 'nuno-builder' ),
                'param_name' => 'lat',
                'description' => esc_html__( 'put your latitude coordinate your location, ex: -7.2852292', 'nuno-builder' ),
                'class' => '',
                'admin_label'=>true,
                'value'=>'-8.2077372',
                'type' => 'textfield',
                'default'=>'-8.2077372'
               ),     
              array( 
                'heading' => esc_html__( 'Longitude', 'nuno-builder' ),
                'param_name' => 'lang',
                'description' => esc_html__( 'put your longitude coordinate your location, ex: 112.6809869', 'nuno-builder' ),
                'class' => '',
                'admin_label'=>true,
                'value'=>'114.385405',
                'type' => 'textfield',
                'default'=>'114.385405'
               ),     
              array( 
                'heading' => esc_html__( 'Zoom Level', 'nuno-builder' ),
                'param_name' => 'zoom',
                'param_holder_class'=>'zoom-label',
                'description' => esc_html__( 'zoom level your map, higher value present more detail.', 'nuno-builder' ),
                'class' => '',
                'value'=>array(7,8,9,10,11,12,13,14,15,16,17,18,19,20,21),
                'type' => 'dropdown',
                'default'=>'15'
               ),     
              array( 
                'heading' => esc_html__( 'Zoom Control', 'nuno-builder' ),
                'param_name' => 'zoomcontrol',
                'param_holder_class'=>'zoom-control-label',
                'description' => esc_html__( 'Show/hide zoom control', 'nuno-builder' ),
                'class' => '',
                'value'=>array(1=>esc_html__('Show','nuno-builder'),0=>esc_html__('Hidden','nuno-builder')),
                'type' => 'radio',
                'default'=>'1'
                 ),     
              array( 
                'heading' => esc_html__( 'Pan Control', 'nuno-builder' ),
                'param_name' => 'pancontrol',
                'param_holder_class'=>'pan-control-label',
                'description' => esc_html__( 'Show/hide pan control', 'nuno-builder' ),
                'class' => '',
                'value'=>array(1=>esc_html__('Show','nuno-builder'),0=>esc_html__('Hidden','nuno-builder')),
                'type' => 'radio',
                'default'=>'1'
               ),     
              array( 
                'heading' => esc_html__( 'Street View Control', 'nuno-builder' ),
                'param_name' => 'streetcontrol',
                'description' => esc_html__( 'Show/hide street view control', 'nuno-builder' ),
                'class' => '',
                'value'=>array(1=>esc_html__('Show','nuno-builder'),0=>esc_html__('Hidden','nuno-builder')),
                'type' => 'radio',
                'default'=>'1'
               ),     
              array( 
                'heading' => esc_html__( 'Mouse Scroll Wheel', 'nuno-builder' ),
                'param_name' => 'scrollcontrol',
                'description' => esc_html__( 'Disable/enable mouse scroll to control zoom', 'nuno-builder' ),
                'class' => '',
                'value'=>array(1=>esc_html__('Enable','nuno-builder'),0=>esc_html__('Disable','nuno-builder')),
                'type' => 'radio',
                'default'=>'1'
               ),     
              array( 
                'heading' => esc_html__( 'Map Marker', 'nuno-builder' ),
                'param_name' => 'marker',
                'param_holder_class'=>'map-marker-label',
                'type' => 'radio',
                'value'=>array(
                    'default'=>esc_html__('Default','nuno-builder'),
                    'image'=>esc_html__('Custom Image','nuno-builder'),
                    ),
                'default'=>'default'
                 ),    
              array( 
                'heading' => esc_html__( 'Image Marker', 'nuno-builder' ),
                'param_name' => 'image_marker',
                'class' => '',
                'value' => '',
                'type' => 'image',
                'description'=>esc_html__('Select image as marker your location on the map','nuno-builder'),
                'dependency' => array( 'element' => 'marker', 'value' => array( 'image') )       
               ),

          )
  ) 
);
?>
