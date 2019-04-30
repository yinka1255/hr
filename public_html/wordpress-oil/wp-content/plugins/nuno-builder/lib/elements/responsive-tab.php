<?php
/**
 * @package     WordPress
 * @subpackage  Nuno Page Builder
 * @author      support@themegum.com
 * @since       1.0.0
*/
defined('ABUILDER_BASENAME') or die();

class BuilderElement_responsivetab_item extends BuilderElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'title'=>'',
            'active'=>false,
            'id'=>'tabid_'
        ), $atts ,'responsivetab_item') );


        $compile='<li>
                        <a href="#'.$id.'">'.$title.'</a>
                  </li>';

        return $compile;

    }
} 

class BuilderElement_responsivetab extends BuilderElement {

    function render($atts, $content = null, $base = '') {


        if(!has_shortcode($content,'responsivetab_item'))
            return "";

        $pattern = get_shortcode_regex(array('responsivetab_item'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
                return "";

        wp_enqueue_script( 'bootstrap' , get_abuilder_dir_url().'js/bootstrap.js', array( 'jquery' ), '3.0', false );
        wp_enqueue_script( 'bootstrap-responsivetab', get_abuilder_dir_url() . 'js/responsive-tabs.js', array(), '1.0', false );
        wp_enqueue_style('bootstrap-tabs',get_abuilder_dir_url()."css/bootstrap_vertical_tab.css",array());


        extract( shortcode_atts( array(
            'spy'=>'none',
            'scroll_delay'=>300,
            'el_id'=>'',
            'el_class'=>'',
            'desktop_screen'=>'',
            'medium_screen'=>'',
            'small_screen'=>'',
            'xsmall_screen'=>'',

        ), $atts ,'responsivetab_item' ) );

        $scrollspy="";

        $spydly=$scroll_delay;

        if('none'!==$spy && !empty($spy)){
                    $scrollspy=' data-uk-scrollspy="{cls:\''.$spy.'\',delay:'.intval($spydly).'}"';
                    get_scroll_spy_script();
        }

        $cn_list=array();
        $cn_preview=array();
        $cn_accordeon=array();

        $tabid=getElementTagID();
        $itemnumber=0;


        foreach ($matches as $slideitem) {

            $slideitem[3].=($itemnumber==0)?" active=\"1\"":"";
            $slideitem[3].=" id=\"tabid_".$tabid.'_'.$itemnumber."\"";

            $cn_item=do_shortcode("[responsivetab_item ".$slideitem[3]."]".$slideitem[5]."[/responsivetab_item]");

            $cn_preview_item='<div id="tabid_'.$tabid.'_'.$itemnumber.'" class="tab-pane'.(($itemnumber==0)?" in active":"").'">'.do_shortcode($slideitem[5]).'</div>';

            array_push($cn_list, $cn_item);
            array_push($cn_preview, $cn_preview_item);

            $itemnumber++;

        }


        $css_class=array('responsive_tab');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getElementCssMargin($atts);

        if(''==$el_id && ""!=$css_style){
            $el_id="element_".getElementTagID();

        }

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if(''!=$css_style){

          add_page_css_style("#$el_id {".$css_style."}");
    
        }

        nuno_add_element_margin_style("#$el_id",$atts);

        $compile.="class=\"".@implode(" ",$css_class)."\"".$scrollspy.">";


        $compile.='<ul id="tabid_'.$tabid.'" class="nav nav-tabs responsive">'.@implode("\n",$cn_list).'
          </ul>'."\n".'<div class="tab-content responsive">
                    '.@implode("\n",$cn_preview).'</div>'."\n";
            
        $compile.='</div>';

        if($desktop_screen=='accordeon'){
          array_push($cn_accordeon,"'lg'");
        }

        if($medium_screen=='accordeon'){
          array_push($cn_accordeon,"'md'");
        }

        if($small_screen=='accordeon'){
          array_push($cn_accordeon,"'sm'");
        }

        if($xsmall_screen=='accordeon'){
          array_push($cn_accordeon,"'xs'");
        }
$compile.='<script type="text/javascript">
jQuery(document).ready(function($){
  $( \'#tabid_'.$tabid.' a\' ).click( function ( e ) {
        e.preventDefault();
        $( this ).tab( \'show\' );
  } );';

if(count($cn_accordeon)){
$compile.='fakewaffle.responsiveTabs( $( \'#tabid_'.$tabid.'\' ),['.@implode(',', $cn_accordeon).'] );';
}
$compile.='});
</script>';

  
        return $compile;
    }

}

add_builder_element('responsivetab',
 array( 
    'title' => esc_html__( 'Responsive Tab', 'nuno-builder' ),
    'icon'  =>'dashicons dashicons-index-card',
    'color'=>'#745b46',
    'as_parent' => 'responsivetab_item',
    'child_list'=>'vertical',
    'order'=>8,
    'options' => array(
        array( 
        'heading' => esc_html__( 'Module Title', 'nuno-builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => esc_html__( 'Responsive Tab', 'nuno-builder' ),
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
        'heading' => esc_html__( 'Large Screen', 'nuno-builder' ),
        'param_name' => 'desktop_screen',
        'description' => esc_html__( 'screen width more than 992px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => esc_html__('Tab','nuno-builder') ,
            'accordeon' => esc_html__('Accordion','nuno-builder') ,
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Medium Screen', 'nuno-builder' ),
        'param_name' => 'medium_screen',
        'description' => esc_html__( 'screen width between 992px and 768px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => esc_html__('Tab','nuno-builder') ,
            'accordeon' => esc_html__('Accordion','nuno-builder') ,
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Tablet Screen', 'nuno-builder' ),
        'param_name' => 'small_screen',
        'description' => esc_html__( 'screen width between 768px and 480px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => esc_html__('Tab','nuno-builder') ,
            'accordeon' => esc_html__('Accordion','nuno-builder') ,
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => esc_html__( 'Mobile Screen', 'nuno-builder' ),
        'param_name' => 'xsmall_screen',
        'description' => esc_html__( 'screen width below 480px', 'nuno-builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => esc_html__('Tab','nuno-builder') ,
            'accordeon' => esc_html__('Accordion','nuno-builder') ,
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

add_builder_element('responsivetab_item',
 array( 
    'title' => esc_html__( 'Tab Item', 'nuno-builder' ),
    'as_child' => 'responsivetab',
    'color' => '#726e4b',
    'is_dropable' => true,
    'options' => array(
        array( 
        'heading' => esc_html__( 'Title', 'nuno-builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => '',
        'type' => 'textfield'
         ),
        )
 ) );


?>
