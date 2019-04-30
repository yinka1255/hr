<?php
defined('ABUILDER_BASENAME') or die();

class ABuilder_Editor {

  var $posttypes = array();


  function __construct() {

  }

  function render(){

    $settings = apply_filters('abuilder_settings',get_option('abuilder_settings',array('page')));
    if(empty($settings)) $settings=array();

    foreach ($settings as $posttype) {
      add_meta_box( 'abuilder', esc_html__( 'Nuno Page Builder', 'nuno-builder' ), array($this,'render_page_metabox'), $posttype, 'advanced', 'high' );
    }
    
    $this->posttypes = $settings;

    add_action( 'save_post', array($this,'save_custom_css'));


    add_filter( 'use_block_editor_for_post', array( $this, 'use_block_editor_for_post'),999, 2 );
    add_filter( 'gutenberg_can_edit_post_type', array( $this, 'gutenberg_can_edit_post_type' ), 999, 2 );


  }


  function gutenberg_can_edit_post_type($can, $edit_post_type){

    $settings = $this->posttypes;

    if(!count($settings)) return $can;

    if( in_array($edit_post_type, $settings)) return false;
  }



  function use_block_editor_for_post($used, $post){

    $settings = $this->posttypes;

    if(!count($settings)) return $used;

    if( in_array($post->post_type, $settings)) return false;

    return $used;
  }

  function save_custom_css($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    $builder_settings = apply_filters('abuilder_settings',get_option('abuilder_settings',array('page')));
    if(!wp_verify_nonce( isset($_POST['abuilder_save_custom_css'])?$_POST['abuilder_save_custom_css']:"", 'abuilder_save_custom_css') || !in_array(get_post_type(),$builder_settings))
        return;

     $old = get_post_meta( $post_id, '_abuilder_custom_css', true );
     $new = (isset($_POST['builder_custom_css']))?$_POST['builder_custom_css']:'';
     update_post_meta( $post_id, '_abuilder_custom_css', $new,$old );
  }

  function render_page_metabox($post){


   wp_enqueue_script( 'jquery-ui-core' );
   wp_enqueue_script( 'jquery-ui-sortable' );
   wp_enqueue_script( 'jquery-ui-draggable' );
   wp_enqueue_script( 'jquery-ui-droppable' );
   wp_enqueue_script( 'jquery-ui-resizable' );

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('iris');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('page-editor',get_abuilder_dir_url().'lib/js/editor.js',array('jquery','media-views', 'media-editor'));
    wp_enqueue_script('page-editor-custom',get_abuilder_dir_url().'lib/js/backend.js',array('page-editor'));
    wp_enqueue_script('icon_picker',get_abuilder_dir_url().'lib/js/icon_picker.js',array('jquery'));


    wp_enqueue_script('jquery.plugin',get_abuilder_dir_url()."js/jquery.plugin.min.js",array('jquery'));
    wp_enqueue_script('jquery.countdown',get_abuilder_dir_url()."js/jquery.countdown.min.js",array('jquery.plugin'));


    wp_enqueue_script( 'jquery.appear', get_abuilder_dir_url() . 'js/jquery.appear.min.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'jquery.counto',get_abuilder_dir_url()."js/jquery.counto.min.js",array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'jquery.chart', get_abuilder_dir_url() . 'js/chart.js', array('jquery.appear','jquery.counto'), '1.3.3', false );


    wp_localize_script( 'icon_picker', 'picker_i18nLocale', array(
      'search_icon'=> esc_html__('Search Icon','nuno-builder'),
    ) );

    wp_enqueue_style('jquery.countdown',get_abuilder_dir_url()."css/jquery.countdown.css",array(),false);
    wp_enqueue_style('page-editor',get_abuilder_dir_url().'lib/css/editor.css','');
    wp_enqueue_style('icon-picker',get_abuilder_dir_url().'lib/css/icon_picker.css','');
    wp_enqueue_style('awesome-font-builder',get_abuilder_dir_url().'lib/css/font-pointer.css','');
    wp_enqueue_style('jquery-ui-resizable',get_abuilder_dir_url().'lib/css/jquery-ui-resizable.css','');


    wp_localize_script( 'page-editor', 'iab', array(
      'move_this_element' => esc_html__('Move this element','nuno-builder'),
      'edit_title_panel'=>esc_html__('Edit','nuno-builder'),
      'close'=>esc_html__('Close','nuno-builder'),
      'save'=>esc_html__('Save','nuno-builder'),
      'cancel'=>esc_html__('Cancel','nuno-builder'),
      'select_image'=>esc_html__('Select Image','nuno-builder'),
      'insert_image'=>esc_html__('Insert Image','nuno-builder'),
      'custom_css_title'=>esc_html__('Custom CSS','nuno-builder'),
      'show_shortcode_title'=>esc_html__('Element Shortcode','nuno-builder'),
      'add_shortcode_title'=>esc_html__('Add Shortcode','nuno-builder'),
      'are_you_sure_delete_confirmation'=>esc_html__('Are you sure delete this element','nuno-builder'),
      'are_you_sure_delete_column_confirmation'=>esc_html__('Are you sure delete this column','nuno-builder'),
      'column_canot_delete'=>esc_html__('This column can\'t delete','nuno-builder'),
      'custom_column_placeholder'=>esc_html__('4 4 4 Total=12','nuno-builder'),
      'insert_video'=>esc_html__('Insert Video','nuno-builder'),
      'block_library_title'=>esc_html__('Section Library','nuno-builder'),
      'element_library_title'=>esc_html__('Element Library','nuno-builder'),
      'select_video'=>esc_html__('Select Video','nuno-builder'),
      'click_to_toggle'=>esc_html__('Click to toggle row','nuno-builder'),
      'row'=>esc_html__('Row','nuno-builder'),
      'nuno_editor'=>esc_html__('Nuno Builder','nuno-builder'),
      'classic_editor'=>esc_html__('Classic Editor','nuno-builder'),
      'search_placehold'=> esc_html__('Enter key then press enter', 'nuno-builder'),
      'invalid_nonce'=>esc_html__('Invalid nonce verification, please refresh','nuno-builder'),
    ) );

    do_action('themegum-glyph-icon-loaded');
   
    $elements=get_builder_elements();
    $elements=apply_filters('allowed_element_in_post',$elements);

    $custom_css =  get_post_meta($post->ID, '_abuilder_custom_css', true);
    $elements_color_style = array();

    wp_nonce_field( 'abuilder_save_custom_css','abuilder_save_custom_css');
    wp_nonce_field( '_abuilder_ajax', '_abuilder_nonce' );
    
    ?>
    <div id="abuilder_wrap" style="display:none">
    <textarea id="abuilder_css_field" style="display:none" name="builder_custom_css"><?php print htmlspecialchars($custom_css);?></textarea>
    <div class="element-builders">
      <ul class="builder-main-panel clearfix">
        <li class="brand"><img src="<?php print get_abuilder_dir_url().'lib/images/brand-logo.png';?>" /></li>
        <li class="brand-name"><?php esc_html_e( 'Drag & Drop Element','nuno-builder');?></li>
        <li class="page-update"><a id="abuilder_update" class="btn button button-primary" href="#"><span><?php esc_html_e('update','nuno-builder');?></span></a></li>
        <li class="css-edit"><a id="abuilder_css_edit" class="fa fa-codepen" href="#"><span>CSS</span></a></li>
        <li class="zoom-action"><a id="abuilder_zoom_btn" href="#" class="zoom-in-out"><span class="top-in"></span><span class="bottom-in"></span></a></li>
      </ul>

       <div class="element-builder element-row element-el_row" data-tag="el_row" data-column="12">
           <div class="element-holder dragger"><i class="fa fa-align-justify"></i><?php esc_html_e('Row','nuno-builder');?></div>
           <div class="element-toolbar">
            <div class="toolbar-panel-left">
              <div class="element-holder"><i title="<?php esc_attr_e('Move this row','nuno-builder');?>" class="fa fa-arrows"></i></div>
              <div class="toolbar row-selection">
                <div class="select-column">
                  <div title="<?php esc_attr_e('Change column','nuno-builder');?>" class="fa fa-columns"></div>
                </div>
                <ul class="option-column-group">
                  <li class="option-column"><a href="#" class="column_1" data-column="12"><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_2" data-column="6 6"><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_3" data-column="4 4 4"><span></span><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_4" data-column="3 3 3 3"><span></span><span></span><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_6" data-column="2 2 2 2 2 2"><span></span><span></span><span></span><span></span><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_custom"><?php esc_html_e('Custom','nuno-builder');?></a></li>
                </ul>
              </div>
            </div>
            <ul class="toolbar-panel-right">
              <li class="toolbar element-up"><a title="<?php esc_attr_e('Move up this row','nuno-builder');?>" href="#"><div class="fa fa-arrow-up"></div></a></li>
              <li class="toolbar element-down"><a title="<?php esc_attr_e('Move down this row','nuno-builder');?>" href="#"><div class="fa fa-arrow-down"></div></a></li>
              <li class="toolbar element-setting" data-title="<?php esc_attr_e('Row','nuno-builder');?>"><a title="<?php esc_attr_e('Edit this row','nuno-builder');?>" href="#"><div class="fa fa-cog"></div></a></li>
              <li class="toolbar element-copy"><a title="<?php esc_attr_e('Copy this row','nuno-builder');?>" href="#"><div class="fa fa-copy"></div></a></li>
              <li class="toolbar element-delete"><a title="<?php esc_attr_e('Delete this row','nuno-builder');?>" href="#"><div class="fa fa-times-circle"></div></a></li>
            </ul>
          </div>
          <div class="inside_row">
            <div class="open-tag render-tag">[el_row]</div>
            <div class="column-container">
              <div class="element-builder element-column element-el_column col-12" data-column="12" data-tag="el_column">
                <div class="element-panel">
                  <div class="toolbar element-setting" data-title="<?php esc_attr_e('Column','nuno-builder');?>"><a title="<?php esc_attr_e('Edit this column','nuno-builder');?>" href="#"><div class="fa fa-cogs"></div></a></div>
                  <div class="toolbar element-addshortcode"><a title="<?php esc_attr_e('Add element to this column','nuno-builder');?>" href="#"><div class="fa fa-plus-circle"></div></a></div>
                  <div class="toolbar element-delete-column"><a title="<?php esc_attr_e('Delete this column','nuno-builder');?>" href="#"><div class="fa fa-trash"></div></a></div>
                </div>
                <div class="open-tag render-tag">[el_column]</div>
                <div class="element-content dropable-element"></div>
                <div class="close-tag render-tag">[/el_column]</div>
              </div>
            </div>
          <div class="close-tag render-tag">[/el_row]</div>
        </div>
      </div>
      <?php 
      if(count($elements)):

      foreach ($elements as $tag => $element) {

          if(in_array($tag,array('el_row','el_column','el_inner_row','el_inner_column','el_inner_row_1','el_inner_column_1','el_inner_row_2','el_inner_column_2','el_inner_row_3','el_inner_column_3')))
            continue;

          $settings=$element->getSettings();

          $elements_color_style[$tag] = '.element-builders .element-builder.element-'.$tag.' .element-holder i,.editor-worksheet .element-builder.element-'.$tag.' > .element-panel{background:'.$settings['color'].'}';
          $element_options=$element->getConfigs();

          if($settings['as_box']){?>

      <div class="element-builder element-container element-box element-<?php print $tag;print ($settings['show_on_create'])?" show-create":"";?>" data-tag="<?php print $tag;?>">
        <div class="element-panel">
        <div class="element-holder dragger"><i class="<?php print $settings['icon']!=''?$settings['icon']:'fa fa-file';?>"></i><?php print $settings['title'];?></div>
         <div class="element-holder-label"><?php print $settings['title'];?></div>
         <div class="element-toolbar">
            <div class="toolbar element-setting" data-title="<?php print $settings['title'];?>"><a title="<?php esc_attr_e('Edit this element','nuno-builder');?>" href="#"><div class="fa fa-pencil"></div></a></div>
            <div class="toolbar element-shortcode"><a title="<?php esc_attr_e('Show this shortcode','nuno-builder');?>" href="#"><div class="fa fa-code"></div></a></div>
            <div class="toolbar element-copy"><a title="<?php esc_attr_e('Copy this element','nuno-builder');?>"  href="#"><div class="fa fa-copy"></div></a></div>
            <div class="toolbar element-delete"><a title="<?php esc_attr_e('Delete this element','nuno-builder');?>"  href="#"><div class="fa fa-times-circle"></div></a></div>
         </div>
        </div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>

        <?php if(is_array($settings['as_box'])):

              foreach($settings['as_box'] as $child){

                if(isset($elements[$child])){

                $childElement=$elements[$child];
                $childSettings=$childElement->getSettings();
                ?>
                <div class="element-builder element-box-item element-<?php print $child;?>" data-tag="<?php print $child;?>">
                  <div class="element-toolbar element-panel">
                    <div class="toolbar element-setting" data-title="<?php print esc_attr($childSettings['title']);?>"><a title="<?php esc_attr_e('Edit this element','nuno-builder');?>" href="#"><div class="fa fa-pencil"></div></a></div>
                    <div class="element-holder-label"><?php print $childSettings['title'];?></div>
                  </div>
                  <div class="open-tag render-tag">[<?php print $child;?>]</div>
                  <div class="element-content dropable-element"></div>
                  <div class="close-tag render-tag">[/<?php print $child;?>]</div>
                </div>
<?php 
                }
              }
          ?>
            <?php else:

             if(isset($elements[$settings['as_box']])){
                 $childElement=$elements[$settings['as_box']];
                 $childSettings=$childElement->getSettings();
                ?>
                <div class="element-builder element-box-item element-<?php print $settings['as_box'];?>" data-tag="<?php print $settings['as_box'];?>">
                  <div class="element-panel element-panel">
                    <div class="toolbar element-setting" data-title="<?php print esc_attr($childSettings['title']);?>"><a title="<?php esc_attr_e('Edit this element','nuno-builder');?>" href="#"><div class="fa fa-pencil"></div></a></div>
                    <div class="element-holder-label"><?php print $childSettings['title'];?></div>
                  </div>
                  <div class="open-tag render-tag">[<?php print $settings['as_box'];?>]</div>
                  <div class="element-content dropable-element"></div>
                  <div class="close-tag render-tag">[/<?php print $settings['as_box'];?>]</div>
                </div>
<?php
                }
            ?>

          <?php endif;?>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>


          <?php }
          elseif($settings['is_container']){?>
      <div class="element-builder element-container element-<?php print $tag;print ($settings['show_on_create'])?" show-create":"";?>" data-tag="<?php print $tag;?>">
        <div class="element-panel">
        <div class="element-holder dragger"><i class="<?php print $settings['icon']!=''?$settings['icon']:'fa fa-file';?>"></i><?php print $settings['title'];?></div>
         <div class="element-holder-label"><?php print $settings['title'];?></div>
         <div class="element-toolbar">
            <div class="toolbar element-setting" data-title="<?php print $settings['title'];?>"><a title="<?php esc_attr_e('Edit this element','nuno-builder');?>" href="#"><div class="fa fa-pencil"></div></a></div>
            <div class="toolbar element-shortcode"><a title="<?php esc_attr_e('Show this shortcode','nuno-builder');?>" href="#"><div class="fa fa-code"></div></a></div>
            <div class="toolbar element-copy"><a title="<?php esc_attr_e('Copy this element','nuno-builder');?>"  href="#"><div class="fa fa-copy"></div></a></div>
            <div class="toolbar element-delete"><a title="<?php esc_attr_e('Delete this element','nuno-builder');?>"  href="#"><div class="fa fa-times-circle"></div></a></div>
         </div>
        </div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
         <div class="element-content dropable-element"></div>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>

          <?php
          }
          elseif($settings['as_parent'] && ''!=$settings['as_parent']){
            ?>
      <div class="element-builder element-parent element-<?php print $tag;print ($settings['show_on_create'])?" show-create":""; print isset($settings['child_list']) ? " child-list-".$settings['child_list'] : "";?>" data-child="<?php print (is_array($settings['as_parent']))?@implode(",",$settings['as_parent']):$settings['as_parent'];?>" data-tag="<?php print $tag;?>">
        <div class="element-panel">
        <div class="element-holder dragger"><i class="<?php print $settings['icon']!=''?$settings['icon']:'fa fa-file';?>"></i><?php print $settings['title'];?></div>
        <div class="element-holder-label"><?php print $settings['title'];?></div>
        <div class="children-toolbar">
          <?php if(is_array($settings['as_parent'])):

              foreach($settings['as_parent'] as $child){

                if(isset($elements[$child])){

                  $childElement=$elements[$child];
                  $childSettings=$childElement->getSettings();

                  print '<div class="toolbar"><a title="'.sprintf( esc_html__('Add %s','nuno-builder'),$childSettings['title']).'"  href="#" data-child="'.$child.'"><div class="fa fa-plus-circle"></div> '.$childSettings['title'].'</a></div>';

                }
              }
          ?>
            <?php else:

             if(isset($elements[$settings['as_parent']])){

                  $childElement=$elements[$settings['as_parent']];
                  $childSettings=$childElement->getSettings();
                  print '<div class="toolbar"><a title="'.sprintf( esc_html__('Add %s','nuno-builder'),$childSettings['title']).'"  href="#" data-child="'.$settings['as_parent'].'"><div class="fa fa-plus-circle"></div> '.$childSettings['title'].'</a></div>';
                }
            ?>

          <?php endif;?>
         </div>
         <div class="element-toolbar">
          <div class="toolbar element-setting" data-title="<?php print $settings['title'];?>"><a title="<?php esc_attr_e('Edit this element','nuno-builder');?>" href="#"><div class="fa fa-pencil"></div></a></div>
          <div class="toolbar element-shortcode"><a title="<?php esc_attr_e('Show this shortcode','nuno-builder');?>" href="#"><div class="fa fa-code"></div></a></div>
          <div class="toolbar element-copy"><a title="<?php esc_attr_e('Copy this element','nuno-builder');?>" href="#"><div class="fa fa-copy"></div></a></div>
          <div class="toolbar element-delete"><a title="<?php esc_attr_e('Delete this element','nuno-builder');?>" href="#"><div class="fa fa-times-circle"></div></a></div>
        </div>
      </div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
        <div class="element-content dropable-element"></div>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>

      <?php
          }
          elseif($settings['as_child'] && ''!=$settings['as_child']){
        ?>

      <div style="display:none" class="element-builder element-child element-<?php print $tag; print ($settings['show_on_create'])?" show-create":"";?>" data-parent="<?php print $settings['as_child'];?>" data-tag="<?php print $tag;?>">
        <div class="element-toolbar element-panel">
          <div class="element-holder"><i title="<?php esc_attr_e('Move this element','nuno-builder');?>" class="fa fa-arrows"></i></div>
          <div class="element-holder-label"><?php print $settings['title'];?></div>
          <div class="toolbar element-setting" data-title="<?php print esc_attr($settings['title']);?>"><a title="<?php esc_attr_e('Edit this element','nuno-builder');?>" href="#"><div class="fa fa-pencil"></div></a></div>
          <div class="toolbar element-copy"><a title="<?php esc_attr_e('Copy this element','nuno-builder');?>" href="#"><div class="fa fa-copy"></div></a></div>
          <div class="toolbar element-delete"><a title="<?php esc_attr_e('Delete this element','nuno-builder');?>" href="#"><div class="fa fa-times-circle"></div></a></div>
        </div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
<?php if($settings['is_dropable']):?>
        <div class="element-content dropable-element"><?php print isset($element_options['content']) ? $element_options['content']:"";?></div>
<?php else:?>
        <textarea class="content-tag render-tag"><?php print isset($element_options['content']) ? $element_options['content']:"";?></textarea>
<?php endif;?>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>
     <?php
      }
      elseif($settings['as_box_item']){

      }
      else{

      ?>
      <div class="element-builder element-frebase element-<?php print $tag; print ($settings['show_on_create'])?" show-create":""; ?>" data-tag="<?php print $tag;?>">
          <div class="element-panel">
          <div class="element-holder dragger"><i class="<?php print $settings['icon']!=''?$settings['icon']:'fa fa-file';?>"></i><?php print $settings['title'];?></div>
            <div class="element-holder-label"><?php print $settings['title'];?></div>
            <div class="element-toolbar">
              <div class="toolbar element-setting" data-title="<?php print esc_attr($settings['title']);?>"><a title="<?php esc_attr_e('Edit this element','nuno-builder');?>" href="#"><div class="fa fa-pencil"></div></a></div>
              <div class="toolbar element-shortcode"><a title="<?php esc_attr_e('Show this shortcode','nuno-builder');?>" href="#"><div class="fa fa-code"></div></a></div>
              <div class="toolbar element-copy"><a title="<?php esc_attr_e('Copy this element','nuno-builder');?>" href="#"><div class="fa fa-copy"></div></a></div>
              <div class="toolbar element-delete"><a title="<?php esc_attr_e('Delete this element','nuno-builder');?>" href="#"><div class="fa fa-times-circle"></div></a></div>
            </div>
          </div>
        <div class="element-preview"><?php print $element->preview_admin();?></div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
        <textarea class="content-tag render-tag"><?php print isset($element_options['content']) ? $element_options['content']:"";?></textarea>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>
        <?php }
        }

    ?>
    <?php endif;?>
    </div>
    <?php 
    $content=$post->post_content;

    foreach ($elements as $tag => $element) {
       $regexshortcodes=$element->getRegex();
       $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );

    }

    if($content==$post->post_content){

      $content='[el_row][el_column column="12"]'.($content!=''?'[el_text_html]'.$content.'[/el_text_html]':'').'[/el_column][/el_row]';

      foreach ($elements as $tag => $element) {
         $regexshortcodes=$element->getRegex();
         $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );
      }

    }

    ?>
     <div class="editor-container">
      
        <div class="editor-worksheet" style="display:none">
          <?php print $content;?>
        </div>

        <ul class="page_bottom_toolbar">
          <li>
          <a class="add-page-shortcode button button-primary" title="<?php esc_attr_e('Add shortcode to this page','nuno-builder');?>" href="#"><i class="fa fa-clipboard"></i><?php esc_attr_e('paste shortcode','nuno-builder');?></a>
        </li><li><a class="custom_template_button button button-primary" title="" href="#"><i class="fa fa-database"></i><?php esc_attr_e('add section','nuno-builder');?></a></li>
        </ul>
      </div>
<?php

  $categories = nuno_builder_section_categories();

  if ( !empty( $categories ) ):

?>
<div  id="template_category_options" style="display:none">
<div class="template-category-container">
<ul>
<?php 

    echo '<li class="template-option"><a href="#" data-slug="" class="select-category">'.esc_html__('All','nuno-builder')."</a></li>";

  foreach ( $categories as $slug => $category ) {

    echo '<li class="template-option"><a href="#" data-slug="'.$slug.'" class="select-category">'.$category."</a></li>";
  }


?>
</ul>
</div>
</div>
<?php endif;?>
   </div>
    <?php

    if(count($elements_color_style)){
      wp_add_inline_style( 'page-editor', implode('', $elements_color_style));
    }
  }

}

?>
