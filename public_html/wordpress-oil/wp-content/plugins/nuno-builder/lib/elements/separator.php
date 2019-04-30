<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.1
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_el_separator extends BuilderElement{

    function preview($atts, $content = null, $base = ''){


        $content = $this->render($atts);
        return $content;

    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'separator' => '5',
            'separatorcolor' => 'none',
            'backgroundcolor' => 'none',
            'height'=>'',
            'num_wave'=>1,
            'height_wave'=>100,
            'control_point'=>0,
            'el_id' => '',
            'el_class'=>'',
        ), $atts , 'el_separator') );

        $css_class=array('el_separator');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="element_".getElementTagID().time().rand(11,99);
        }

        $css_style=getElementCssMargin($atts);

        $height = absint($height);

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\"";

       switch ($separator) {
          case 1:
          default:
            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="smallTriangleColorUp2">
                            <path d="M0 50 L46 50 L50 0 L54 50 L101 50 L101 101 L0 101 Z" fill="'.$separatorcolor.'" stroke="none" />
                            <path d="M0 50 L46 50 L50 0 L54 50 L101 50 L101 -1 L0 -1 Z" fill="'.$backgroundcolor.'" stroke="none" />
                        </svg>';
            break;
          case 2:
            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="smallTriangleColorDown2">
                            <path d="M0 50 L46 50 L50 100 L54 50 L100 50 L100 -1 L0 -1 Z" fill="'.$separatorcolor.'" stroke="none"/>
                            <path d="M0 50 L46 50 L50 100 L54 50 L100 50 L100 101 L0 101 Z" fill="'.$backgroundcolor.'" stroke="none"/>
                        </svg>';
            break;
          case 3:
            $compile .= 
                    ' style="height: '.$height.'px; position: relative; text-align: center;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" style="position: absolute; top: 0; left: 0;">
                            <path d="M0 -1 L100 -1 L100 101 Z" fill="'.$separatorcolor.'" stroke="none"/>
                            <path d="M0 -1 L100 101 L0 101 Z" fill="'.$backgroundcolor.'" stroke="none"/>
                        </svg>';
            break;
          case 4:
            $compile .= 
                    ' style="height: '.$height.'px; position: relative; text-align: center;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 -1 L100 -1 L0 101 Z" fill="'.$separatorcolor.'" stroke="none"/>
                            <path d="M0 101 L100 -1 L100 101 Z" fill="'.$backgroundcolor.'" stroke="none"/>
                        </svg>';
            break;
          case 5:
            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleDown">
                            <path d="M-1 -1 L50 101 L101 -1 Z" fill="'.$separatorcolor.'" stroke="none"/>
                            <path d="M-1 -1 L50 101 L101 -1 L101 101 L-1 101 Z" fill="'.$backgroundcolor.'" stroke="none"/>
                        </svg>';
            break;
          case 6:
            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleUp">
                            <path d="M-1 100 L50 0 L101 100 Z" fill="'.$separatorcolor.'" stroke="none"/>
                            <path d="M-1 -1 L-1 100 L50 -1 L100 100 L101 -1 Z" fill="'.$backgroundcolor.'" stroke="none"/>
                        </svg>';
            break;
          case 7:

              $num_wave= min(1000,max($num_wave , 1));
              $height_wave=min(100,max(intval($height_wave) , 0));
              $wave_width= 100 / $num_wave;
              $half_wave=$wave_width /2;
              $hop= ($num_wave * 2) - 1;
              $path="";

              for($i=1; $i < $hop + 1 ; $i++){

                  $xmove=$half_wave*$i;
                  $ymove= $i%2==1 ? 0 : $height_wave  ;
                  $path.="L".$xmove." ".$ymove;

              }



            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleUp">
                            <path d="M0 '.$height_wave.' '.$path.' L100 '.$height_wave.' L100 101 L0 101 Z" fill="'.$separatorcolor.'" stroke="none"/> 
                            <path d="M0 0 L0 '.$height_wave.' '.$path.' L100 '.$height_wave.' L100 0 Z" fill="'.$backgroundcolor.'" stroke="none"/>
                        </svg>';
            break;
          case 8:

              $num_wave= min(1000,max($num_wave , 1));
              $height_wave=min(100,max(intval($height_wave) , 0));
              $wave_width= 100 / $num_wave;
              $half_wave=$wave_width /2;
              $hop= ($num_wave * 2) - 1;
              $path="";

              for($i=1; $i < $hop + 1 ; $i++){

                  $xmove=$half_wave*$i;
                  $ymove= $i%2==1 ? 100 : (100  - $height_wave) ;
                  $path.="L".$xmove." ".$ymove;

              }

            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleUp">
                            <path d="M0 0 L0 '.(100-$height_wave).' '.$path.' L100 '.(100-$height_wave).' L100 0 Z" fill="'.$separatorcolor.'" stroke="none"/> 
                            <path d="M0 '.(100-$height_wave).' '.$path.' L100 '.(100-$height_wave).' L100 100 L0 100 Z" fill="'.$backgroundcolor.'" stroke="none"/> 
                        </svg>';
            break;
          case 9:

              $num_wave= min(1000,max($num_wave , 1));
              $height_wave=min(100,max(intval($height_wave) , 0));
              $wave_width= 100 / $num_wave;
              $half_wave=$wave_width /2;
              $hop= $num_wave;
              $path="";

              $control_point=min(100,max($control_point , -100));

              for($i=0; $i < $hop ; $i++){

                  $xmove=$wave_width*$i;
                  $stroke=$xmove + $half_wave;
                  $ymove= $i%2==1 ? 0 : $height_wave  ;
                  $path.="C".$xmove." ".$height_wave.",".$stroke." ".$control_point.",".($xmove+$wave_width)." ".$height_wave;

              }



            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleUp">
                            <path d="M0 '.$height_wave.' '.$path.' L100 '.$height_wave.' L100 100 L0 100 Z" fill="'.$separatorcolor.'" stroke="none"/> 
                            <path d="M0 0 L0 '.$height_wave.' '.$path.' L100 '.$height_wave.' L100 0 Z" fill="'.$backgroundcolor.'" stroke="none"/> 
                        </svg>';
            break;
          case 10:

              $num_wave= min(1000,max($num_wave , 1));
              $height_wave=min(100,max(intval($height_wave) , 0));
              $wave_width= 100 / $num_wave;
              $half_wave=$wave_width /2;
              $hop=  $num_wave;
              $path="";
              $control_point=min(100,max($control_point , -100));

              if($control_point < 0){
                  $control_point=100 + abs($control_point);
              }

              if(empty($control_point))$control_point=100;

              for($i=0; $i < $hop ; $i++){

                  $xmove=$wave_width*$i;
                  $stroke=$xmove + $half_wave;
                  $ymove= $i%2==1 ? 0 : $height_wave  ;
                  $path.="C".$xmove." ".(100-$height_wave).",".$stroke." ".$control_point.",".($xmove+$wave_width)." ".(100-$height_wave);

              }


            $compile .= 
                    ' style="height: '.$height.'px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleUp">
                            <path d="M0 0 L0 '.(100-$height_wave).' '.$path.' L100 '.(100-$height_wave).' L100 0 Z" fill="'.$separatorcolor.'" stroke="none"/> 
                            <path d="M0 '.(100-$height_wave).' '.$path.' L100 '.(100-$height_wave).' L100 100 L0 100 Z" fill="'.$backgroundcolor.'" stroke="'.$backgroundcolor.'"/> 
                        </svg>';
            break;

        }

        $compile.="</div>";


        if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
        }

        nuno_add_element_margin_style("#$el_id",$atts);
        
        return $compile;

    }
}

add_builder_element('el_separator',
  array(
    'title'=>esc_html__('Section Separator','nuno-builder'),
    'icon'=>"dashicons dashicons-editor-insertmore",
    'color'=>'#7c5813',
    'order'=>11,
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
            'heading' => esc_html__( 'Separator Type', 'nuno-builder' ),
            'param_name' => 'separator',
            'class' => '',
            'param_holder_class'=>'section-heading-style',
            'type' => 'select_layout',
             'value'=>array(
                '1'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_1.jpg" alt="'.esc_attr__('Type 1','nuno-builder').'" />',
                '2'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_2.jpg" alt="'.esc_attr__('Type 2','nuno-builder').'"/>',
                '3'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_3.jpg" alt="'.esc_attr__('Type 3','nuno-builder').'"/>',
                '4'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_4.jpg" alt="'.esc_attr__('Type 4','nuno-builder').'"/>',
                '5'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_5.jpg" alt="'.esc_attr__('Type 5','nuno-builder').'"/>',
                '6'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_6.jpg" alt="'.esc_attr__('Type 6','nuno-builder').'"/>',
                '7'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_7.jpg" alt="'.esc_attr__('Type 7','nuno-builder').'"/>',
                '8'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_8.jpg" alt="'.esc_attr__('Type 8','nuno-builder').'"/>',
                '9'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_9.jpg" alt="'.esc_attr__('Type 9','nuno-builder').'"/>',
                '10'  => '<img src="'.get_abuilder_dir_url().'lib/images/separator_10.jpg" alt="'.esc_attr__('Type 10','nuno-builder').'"/>'
                )
             ),
             array( 
              'heading' => esc_html__( 'Num Wave', 'nuno-builder' ),
              'param_name' => 'num_wave',
              'param_holder_class'=>'small-width',
              'type' => 'textfield',
              'dependency' => array( 'element' => 'separator', 'value' => array( '7','8','9','10') )  
            ),
             array( 
              'heading' => esc_html__( 'Height Wave', 'nuno-builder' ),
              'param_name' => 'height_wave',
              'param_holder_class'=>'small-width',
              'type' => 'textfield',
              "description" => esc_html__("Enter value 0 - 100", "nuno-builder"),
              'dependency' => array( 'element' => 'separator', 'value' => array( '7','8','9','10') )  
            ),
             array( 
              'heading' => esc_html__( 'Control Point', 'nuno-builder' ),
              'param_name' => 'control_point',
              'param_holder_class'=>'small-width',
              'type' => 'textfield',
              "description" => esc_html__("Enter value -100 to 100", "nuno-builder"),
              'dependency' => array( 'element' => 'separator', 'value' => array( '9','10') )  
            ),
             array( 
              'heading' => esc_html__( 'Separator Height', 'nuno-builder' ),
              'param_name' => 'height',
              'default'=>'60',
              'param_holder_class'=>'small-width',
              'type' => 'textfield',
            ),
            array( 
            'heading' => esc_html__( 'Separator Color', 'nuno-builder' ),
            'param_name' => 'separatorcolor',
            'value' => '',
            'default'=>'#cccccc',
            'type' => 'colorpicker',
             ),
             array( 
            'heading' => esc_html__( 'Background Color', 'nuno-builder' ),
            'param_name' => 'backgroundcolor',
            'value' => '',
            'type' => 'colorpicker'
             )
       )
    )
);

?>
