<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_team_custom extends BuilderElement{

    function preview($atts, $content = null) {

      if(isset($atts['size'])){ $atts['size']='medium'; }
      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base=''){

           wp_enqueue_style('awesomeicon');

            if (!isset($compile)) {$compile='';}

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
                'fit_row'=>'',
                'bg_color'=>'',
                'content_align'=>'left'                
            ), $atts, 'team_custom'));

            $scollspy = $social_lists = $image_css_style = $image_src = $icon_style =  "";

            if('none'!==$spy && !empty($spy)){
                $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
                get_scroll_spy_script();
            }

            if($social_link=='show'){

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
                  (($facebook)?"<li><a href=\"".esc_url($facebook)."\" target=\"_blank\"><i class=\"fa fa-facebook-square\" ".$icon_style."></i></a></li>":"").
                  (($twitter)?"<li><a href=\"".esc_url($twitter)."\" target=\"_blank\"><i class=\"fa fa-twitter-square\" ".$icon_style."></i></a></li>":"").
                  (($gplus)?"<li><a href=\"".esc_url($gplus)."\" target=\"_blank\"><i class=\"fa fa-google-plus-square\" ".$icon_style."></i></a></li>":"").
                  (($linkedin)?"<li><a href=\"".esc_url($linkedin)."\" target=\"_blank\"><i class=\"fa fa-linkedin-square\" ".$icon_style."></i></a></li>":"").
                  (($pinterest)?"<li><a href=\"".esc_url($pinterest)."\" target=\"_blank\"><i class=\"fa fa-pinterest-square\" ".$icon_style."></i></a></li>":"").
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
              }

            if('thumb-left'==$layout_type || 'thumb-right'==$layout_type){


                $custom_team="";

                if($image_src!=''){
                  $custom_team.='<div class="profile-image"><img src="'.esc_url($image_src) .'" class="img-responsive" style="'.$image_css_style.'" alt=""/></div>';
                }

                $custom_team.='<div class="profile-content"><h3 class="profile-heading">'.$title.'</h3><hr/><h4 class="profile-subheading">'.$sub_title.'</h4>
                '.(!empty($text)?'<div class="text">'.$text.'</div>':"").('show'==$social_link?$social_lists:"").'
                </div>';

            }
            else{

            $custom_team='<div class="profile">
                    <figure>';

            if( $image_src != ''){        
                $custom_team.='<div class="top-image">
                            <img style="'.$image_css_style.'" src="'.esc_url($image_src) .'" class="img-responsive" alt=""/>
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

             $custom_team.= $social_lists.'<div class="figcap"></div>
                        </figcaption>
                    </figure>
                </div>';


            }

        $css_class=array('team_custom',$layout_type,"style-".$image_style,'content-align-'.$content_align,'clearfix');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if($fit_row!=''){
          array_push($css_class, 'fit-row');
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

        if(""!=$titlecolor){
          add_page_css_style("#$el_id .profile-heading {color:".$titlecolor."}");
        }

        if(""!=$separator_color){
          add_page_css_style("#$el_id hr:after {background-color:".$separator_color."}");
        }

        if(""!=$subtitlecolor){
          add_page_css_style("#$el_id .profile-subheading {color:".$subtitlecolor." !important;}");
        }


        $compile.='class="'.@implode(" ",$css_class).'" '.$scollspy.'>';
        $compile.=$custom_team;
        $compile.='</div>';


        return  $compile;

    }

}

add_builder_element('team_custom',
 array( 
    'title' => esc_html__( 'Custom Team', 'nuno-builder' ),
    'icon'  =>'dashicons dashicons-id',
    'color' =>'#7c5813',
    'order'=>19,
    'class' => '',
    'options' => array(
        array( 
        'heading' => esc_html__( 'Layout', 'nuno-builder' ),
        'param_name' => 'layout_type',
        'default' => 'default',
        'value'=>array(
          'default'=> esc_html__('Default','nuno-builder'),
          'thumb-left'=> esc_html__('Image Left','nuno-builder'),
          'thumb-right'=> esc_html__('Image Right','nuno-builder')
          ),
        'type' => 'radio',
        ),
        array( 
          'heading' => esc_html__( 'Content Align', 'nuno-builder' ),
          'param_name' => 'content_align',
          'default' => 'left',
          'value'=>array(
            'left'=> esc_html__('Left','nuno-builder'),
            'center'=> esc_html__('Center','nuno-builder'),
            'right'=> esc_html__('Right','nuno-builder')
            ),
          'type' => 'radio',
        ),
        array( 
        'heading' => esc_html__( 'Main Title', 'nuno-builder' ),
        'param_name' => 'title',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Sub Title', 'nuno-builder' ),
        'param_name' => 'sub_title',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => esc_html__( 'Description', 'nuno-builder' ),
        'param_name' => 'text',
        'value' => '',
        'type' => 'textarea'
         ),
        array( 
        'heading' => esc_html__( 'Image', 'nuno-builder' ),
        'param_name' => 'image_url',
        'class' => '',
        'value' => '',
        'type' => 'image'
         ),
        array( 
        'heading' => esc_html__( 'Image Style', 'nuno-builder' ),
        'param_name' => 'image_style',
        'type' => 'dropdown',
        'value'=>array(
            'default'  => esc_html__('Default','nuno-builder'),
            'rounded' => esc_html__('Rounded','nuno-builder'),
            'circle'  => esc_html__('Circle','nuno-builder'),
            ),
        ),
        array( 
        'heading' => esc_html__( 'Image Source Size', 'nuno-builder' ),
        'param_name' => 'size',
        'type' => 'textfield',
        'value'=>"",
        'description' => esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'nuno-builder' )
        ),
         array( 
        'heading' => esc_html__( 'Title Color', 'nuno-builder' ),
        'param_name' => 'titlecolor',
        'value' => '',
        'type' => 'colorpicker'
         ),
         array( 
        'heading' => esc_html__( 'Sub Title Color', 'nuno-builder' ),
        'param_name' => 'subtitlecolor',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => esc_html__( 'Separator Color', 'nuno-builder' ),
        'param_name' => 'separator_color',
        'value' => '',
        'type' => 'colorpicker',
         ),
        array( 
        'heading' => esc_html__( 'Social Link', 'nuno-builder' ),
        'param_name' => 'social_link',
        'value'=>array('show'=> esc_html__('Show','nuno-builder'),'hide'=> esc_html__('Hidden','nuno-builder')),
        'type' => 'dropdown'
         ),
        array( 
        'heading' => esc_html__( 'Icon Color', 'nuno-builder' ),
        'param_name' => 'icon_color',
        'value' => '',
        'type' => 'colorpicker',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => esc_html__( 'Icon Hover Color', 'nuno-builder' ),
        'param_name' => 'icon_hover_color',
        'value' => '',
        'type' => 'colorpicker',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => esc_html__( 'Icon Size', 'nuno-builder' ),
        'param_name' => 'icon_size',
        'class' => '',
        'type' => 'slider_value',
        'default' => "",
        'params'=>array('min'=>10,'max'=>'100','step'=>1),
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),     
        array( 
        'heading' => 'Facebook',
        'param_name' => 'facebook',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Twitter',
        'param_name' => 'twitter',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Google Plus',
        'param_name' => 'gplus',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Pinterest',
        'param_name' => 'pinterest',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Linkedin',
        'param_name' => 'linkedin',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => esc_html__('Website','nuno-builder'),
        'param_name' => 'website',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => esc_html__('Email','nuno-builder'),
        'param_name' => 'email',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
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
          "type" => "heading",
          "heading" => esc_html__('Image Style', 'nuno-builder'),
          "param_name" => "image_style",
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
        'heading' => esc_html__( 'Border Color', 'nuno-builder' ),
        'param_name' => 'border',
        'type' => 'colorpicker',
        'value'=>"",
        'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
       array( 
          'heading' => esc_html__( 'Border Style', 'nuno-builder' ),
          'param_name' => 'border_style',
          'type' => 'dropdown',
          'value'=>array(
                '' => esc_html__("Default", 'nuno-builder') ,
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
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'param_holder_class'=>'small-wide',
          'type' => 'textfield',
          "description" => esc_html__("Select radius for border(in px or %).", "nuno-builder"),
          'dependency' => array( 'element' => 'image_style', 'value' => array( 'rounded' ) ),
          'group'=>esc_html__('Styles', 'nuno-builder'),       
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__('Box', 'nuno-builder'),
          "param_name" => "box_style",
          'description' => esc_html__( 'Box style.', 'nuno-builder' ),
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Box Height', 'nuno-builder' ),
          'param_name' => 'fit_row',
          'value' => array(''=>esc_html__('Default','nuno-builder'),'1'=>esc_html__('Fit row','nuno-builder')),
          'type' => 'radio',
          'group'=>esc_html__('Styles', 'nuno-builder'),
          'default'=>''
         ),
        array( 
          'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
            'heading' => esc_html__( 'Border', 'nuno-builder' ),
            'param_name' => 'border',
            'type' => 'heading',
            'group'=>esc_html__('Styles', 'nuno-builder'),
         ), 
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Border Color', 'nuno-builder'),
          "param_name" => "border_color",
          "description" => esc_html__("Select color for border", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),
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
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Width', 'nuno-builder' ),
          'param_name' => 'border_width',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'nuno-builder' ),
          'param_name' => 'b_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'nuno-builder' ),
          'param_name' => 'b_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'nuno-builder' ),
          'param_name' => 'b_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'nuno-builder' ),
          'param_name' => 'b_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Border Radius', 'nuno-builder' ),
          'param_name' => 'border_radius',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Right', 'nuno-builder' ),
          'param_name' => 'br_top_right',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Right', 'nuno-builder' ),
          'param_name' => 'br_bottom_right',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom Left', 'nuno-builder' ),
          'param_name' => 'br_bottom_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Top Left', 'nuno-builder' ),
          'param_name' => 'br_top_left',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Box Shadow', 'nuno-builder' ),
          'param_name' => 'box-shadow',
          'type' => 'heading',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Horizontal Shadow', 'nuno-builder' ),
          'param_name' => 'h_shadow',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Vertical Shadow', 'nuno-builder' ),
          'param_name' => 'v_shadow',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Blur', 'nuno-builder' ),
          'param_name' => 'blur_shadow',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Spread', 'nuno-builder' ),
          'param_name' => 'spread_shadow',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
          'group'=>esc_html__('Styles', 'nuno-builder'),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__('Shadow Color', 'nuno-builder'),
          "param_name" => "shadow_color",
          "description" => esc_html__("Select color for shadow", "nuno-builder"),
          'group'=>esc_html__('Styles', 'nuno-builder'),
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
          'heading' => esc_html__( 'Extra css Class', 'nuno-builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          'group'=>esc_html__('Advanced', 'nuno-builder'),
          ),
        array( 
          'heading' => esc_html__( 'Anchor ID', 'nuno-builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => esc_html__("Enter anchor ID without pound '#' sign", "nuno-builder"),
          'group'=>esc_html__('Advanced', 'nuno-builder'),
        ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'nuno-builder' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => esc_html__("Enter z-index for adjust z position", "nuno-builder"),
          'group'=>esc_html__('Advanced', 'nuno-builder'),
        ),

        )
 ) );

?>
