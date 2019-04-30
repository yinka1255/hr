<?php
defined('ABSPATH') or die();

function petro_valid_page_attributes(){

  $valid_attrs = array(
      'sidebar_position',
      'banner_id',
      'hide_title',
      'page_footer',
      'pre_page_footer',
      'hide_title_heading'
  );

  return apply_filters( 'petro_valid_page_attributes', $valid_attrs);
}

add_action( 'save_post', 'petro_save_page_attributes' );

function petro_save_page_attributes($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    if(!wp_verify_nonce( isset($_POST['petro_attribute_metabox'])?sanitize_text_field($_POST['petro_attribute_metabox']):"", 'petro_attribute_metabox'))
        return;

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
    }

     if('page'==get_post_type()){

       $old_page_args = (array) get_post_meta( $post_id, '_petro_page_args', true );
       $page_attributes = petro_valid_page_attributes();
       $new_page_args = array();

       if(count($page_attributes)){
          foreach ($page_attributes as $page_attribute) {
            $new_page_args[$page_attribute] = (isset($_POST[$page_attribute]))?sanitize_text_field($_POST[$page_attribute]):'';
          }
       }

       update_post_meta( $post_id, '_petro_page_args', $new_page_args,$old_page_args );
    }
}


function petro_page_atrribute_metabox() {

  remove_meta_box('pageparentdiv', 'page','side');
  add_meta_box('purepageparentdiv',  esc_html__('Page Attributes','petro'), 'petro_page_attributes_meta_box', 'page', 'side', 'core');
}

add_action( 'admin_menu' , 'petro_page_atrribute_metabox');

function petro_page_attributes_meta_box($post) {

  global $petro_config;

  wp_nonce_field( 'petro_attribute_metabox','petro_attribute_metabox');

  $post_type_object = get_post_type_object($post->post_type);
  if ( $post_type_object->hierarchical ) {

    $dropdown_args = array(
      'post_type'        => $post->post_type,
      'exclude_tree'     => $post->ID,
      'selected'         => $post->post_parent,
      'name'             => 'parent_id',
      'show_option_none' => esc_html__('(no parent)','petro'),
      'sort_column'      => 'menu_order, post_title',
      'echo'             => true,
    );

    $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
?>
<p><strong><?php esc_html_e('Parent','petro') ?></strong></p>
<label class="screen-reader-text" for="parent_id"><?php esc_html_e('Parent','petro') ?></label>
<?php wp_dropdown_pages( $dropdown_args ); 
  } 

  if ( 'page' != $post->post_type )
      return true;


  wp_enqueue_media();

  $template = !empty($post->page_template) ? $post->page_template : false;
  $templates = get_page_templates();
  $sidebar_position_options=array('default'=>esc_html__('Default','petro'),'left'=>esc_html__('Left','petro'),'right'=>esc_html__('Right','petro'),'nosidebar'=>esc_html__('No Sidebar','petro'));

  $page_args = get_post_meta( $post->ID, '_petro_page_args', true );

  $banner_image= isset($page_args['banner_id']) ? absint($page_args['banner_id']): '';
  $image_url=get_template_directory_uri()."/lib/placeholder.png";

  if($banner_image){
    $image = wp_get_attachment_image_src( $banner_image, array( 266,266 ));
    if($image)
      $image_url=$image[0];
  }

  $hide_title = isset($page_args['hide_title']) ? absint($page_args['hide_title']): '';
  $hide_title_heading = isset($page_args['hide_title_heading']) ? absint($page_args['hide_title_heading']): '';
  $sidebar_position = isset($page_args['sidebar_position']) ? $page_args['sidebar_position']: '';

  ksort( $templates );
   ?>
<p id="hide_banner_option">
  <input type="checkbox" name="hide_title" id="hide_title" value="1" <?php echo ($hide_title)?'checked="checked"':""?>/> <?php esc_html_e('Disable heading banner','petro') ?>
</p>
<p id="hide_title_option">
  <input type="checkbox" name="hide_title_heading" id="hide_title_heading" value="1" <?php echo ($hide_title_heading)?'checked="checked"':""?>/> <?php esc_html_e('Hide title heading','petro') ?>
</p>
<p><strong><?php esc_html_e('Template','petro') ?></strong></p>
<label class="screen-reader-text" for="page_template"><?php esc_html_e('Page Template','petro'); ?></label><select name="page_template" id="page_template">
<option value='default'><?php esc_html_e('Default Template','petro'); ?></option>
<?php 
$fn = "esc_html__";

if(count($templates)):

foreach (array_keys( $templates ) as $tmpl )
    : if ( $template == $templates[$tmpl] )
      $selected = " selected='selected'";
    else
      $selected = '';
  echo "\n\t<option value='".$templates[$tmpl]."' $selected>".$fn($tmpl,'petro')."</option>";
  endforeach;
  endif;?>
 ?>
</select>
<div id="custommeta">
<p id="sidebar_option">
  <strong><?php esc_html_e('Sidebar Position','petro') ?></strong>&nbsp;
<select name="sidebar_position" id="sidebar_position">
<?php foreach ($sidebar_position_options as $position=>$label) {
  print "<option value='".$position."'".(($sidebar_position == $position)?" selected":"").">".ucwords($label)."</option>";

}?>
</select>
</p>
</div>

<div id="page-banner">
<p>
  <strong><?php esc_html_e('Heading Image','petro') ?></strong>
</p>
   <div id="banner_image"><img class="btn btn-link upload_image_button" src="<?php echo esc_url( $image_url ); ?>" width="200px" height="200px" /></div>
    <div style="line-height: 60px;">
        <input type="hidden" id="banner_image_id" name="banner_id" value="<?php print ($banner_image)? $banner_image:"";?>" />
        <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Change image', 'petro' ); ?></button>
        <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'petro' ); ?></button>
    </div>
</div>


<?php 
if(isset( $petro_config['footer-type'] ) && $petro_config['footer-type']=='page'):
$footer_pages  = isset($petro_config['footer-pages']) ? $petro_config['footer-pages'] : array();
$footer_pages = array_map('absint',(array)$footer_pages);

$page_footer= isset($page_args['page_footer']) ? absint($page_args['page_footer']): '';


?>
<div id="page-footer">
<p><strong><?php esc_html_e('Footer Option','petro') ?></strong></p>
<p><?php esc_html_e( 'The option footer must defined in theme option first.','petro'); ?></p>
<select name="page_footer" id="page_footer">
<option value=''><?php esc_html_e('Default Footer','petro'); ?></option>
<?php 

if(count($footer_pages)):

$args = array(
      'post_type'    => 'page',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'include'=> $footer_pages
);

$pages = get_pages( $args );

if(count($pages)):

foreach ( $pages as $page ) {

  echo "\n\t<option value='".$page->ID."' ".selected($page->ID,$page_footer).">".$page->post_title."</option>";
}


endif;

endif;?>
 ?>
</select>
</div>
<?php elseif (isset( $petro_config['footer-type'] ) && $petro_config['footer-type']=='option'): 

$pre_footer_pages  = isset($petro_config['pre-footer-pages']) ? $petro_config['pre-footer-pages'] : array();
$pre_footer_pages = array_map('absint',(array)$pre_footer_pages);

$pre_footer= isset($page_args['pre_page_footer']) ? absint($page_args['pre_page_footer']): '';

?>
<div id="page-footer">
<p><strong><?php esc_html_e('Pre Footer Option','petro') ?></strong></p>
<p><?php esc_html_e( 'The option pre footer must defined in theme option first.','petro'); ?></p>
<select name="pre_page_footer" id="page_footer">
<option value=''><?php esc_html_e('Default Pre Footer','petro'); ?></option>
<?php 

if(count($pre_footer_pages)):

$args = array(
      'post_type'    => 'page',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'include'=> $pre_footer_pages
);

$pages = get_pages( $args );

  if(count($pages)):

  foreach ( $pages as $page ) {

    echo "\n\t<option value='".$page->ID."' ".selected($page->ID,$pre_footer).">".$page->post_title."</option>";
  }


  endif;

endif;?>
 ?>
</select>
</div>
<?php endif;?>

<p><strong><?php esc_html_e('Order','petro'); ?></strong></p>
<p><label class="screen-reader-text" for="menu_order"><?php esc_html_e('Order','petro'); ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order); ?>" /></p>
<p><?php esc_html_e( 'Need help? Use the Help tab in the upper right of your screen.','petro'); ?></p>

<script type="text/javascript">
jQuery(document).ready(function($) {
  'use strict'; 

  var $select = $('select#page_template'), $sidebar_option = $('#custommeta'), $banner_options = $('#page-banner'),$page_footer = $('#page-footer');

  $select.live('change',function(){
    var this_value = $(this).val();

    switch ( this_value ) {
      case 'blank_page.php':
            $sidebar_option.fadeOut('slow');
            $banner_options.fadeOut('slow');
            if($page_footer.length) $page_footer.fadeOut('slow');
        break;
      case 'editor_page.php':
            $sidebar_option.fadeOut('slow');
            $banner_options.fadeIn('slow');
            if($page_footer.length) $page_footer.fadeIn('slow');
        break;
      default:
            $sidebar_option.fadeIn('slow');
            $banner_options.fadeIn('slow');
            if($page_footer.length) $page_footer.fadeIn('slow');
    }

  });

  $select.trigger('change');


    if ( ! $( '#banner_image_id' ).val() ) {
        $( '.remove_image_button' ).hide();
    }

    var file_frame;

    $( document ).on( 'click', '.upload_image_button', function( event ) {

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.downloadable_file = wp.media({
            title: '<?php print esc_js( esc_html__( "Choose an image", "petro" )); ?>',
            button: {
                text: '<?php print esc_js( esc_html__( "Use image", "petro" )); ?>'
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get( 'selection' ).first().toJSON();

            $( '#banner_image_id' ).val( attachment.id );
            $( '#banner_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
            $( '.remove_image_button' ).show();
        });

        // Finally, open the modal.
        file_frame.open();
    });

    $('.remove_image_button').on( 'click', function(event){
      event.preventDefault();
      $( '#banner_image_id' ).val('');
      $( '#banner_image img').attr('src','<?php print get_template_directory_uri()."/lib/placeholder.png";?>');

    })



});
</script>
<?php  
}
?>