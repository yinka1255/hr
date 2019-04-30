<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

/**
 * category attributes
 * @since Petro 1.0.0
*/ 

if(!function_exists('petro_exctract_glyph_from_file')){

  function petro_exctract_glyph_from_file($file="",$pref=""){

    $wp_filesystem=new WP_Filesystem_Direct(array());

    if(!$wp_filesystem->is_file($file) || !$wp_filesystem->exists($file))
        return false;

     if ($buffers=$wp_filesystem->get_contents_array($file)) {
       $icons=array();

      foreach ($buffers as $line => $buffer) {

        if(preg_match("/^(\.".$pref.")([^:\]\"].*?):before/i",$buffer,$out)){

          if($out[2]!==""){
              $icons[$pref.$out[2]]=$pref.$out[2];
          }
        }
      }
      return $icons;

    }else{

      return false;
    }
  }
}


function petro_get_glyph_lists($path){

  $wp_filesystem=new WP_Filesystem_Direct(array());

  $icons=array();
  if($dirlist=$wp_filesystem->dirlist($path)){
    foreach ($dirlist as $dirname => $dirattr) {

       if($dirattr['type']=='d'){
          if($dirfont=$wp_filesystem->dirlist($path.$dirname)){
            foreach ($dirfont as $filename => $fileattr) {
              if(preg_match("/(\.css)$/", $filename)){
                if($icon=petro_exctract_glyph_from_file($path.$dirname."/".$filename)){

                  $icons=@array_merge($icon,$icons);
                }
                break;
              }
             
            }
          }
        }
        elseif($dirattr['type']=='f' && preg_match("/(\.css)$/", $dirname)){

          if($icon=petro_exctract_glyph_from_file($path.$dirname)){
              $icons=@array_merge($icon,$icons);
          }

      }

    }
  }
  return $icons;
}


function petro_add_category_image($taxonomy){
    wp_enqueue_media();

    $dummy_image=get_template_directory_uri()."/lib/placeholder.png";

    $tax = get_taxonomy($taxonomy);
    $tax_name = $tax->labels->singular_name;


?>
    <div class="form-field">
        <label for="category_image"><?php printf(esc_html__( '%s Image', 'petro' ),$tax_name); ?></label>
        <div id="category_image"><img class="btn btn-link upload_image_button" src="<?php echo esc_url( $dummy_image ); ?>" width="60px" height="60px" /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="category_image_id" name="category_image_id" />
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'petro' ); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'petro' ); ?></button>
        </div>
      <div class="clear"></div>
    </div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    'use strict';

    if ( ! $( '#category_image_id' ).val() ) {
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

            $( '#category_image_id' ).val( attachment.id );
            $( '#category_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
            $( '.remove_image_button' ).show();
        });

        // Finally, open the modal.
        file_frame.open();
    });
});

</script>

<?php
}

function petro_edit_category_image($tag, $taxonomy){
    wp_enqueue_media();

    $category_image=get_metadata('term', $tag->term_id, '_thumbnail_id', true);
    $image_url=get_template_directory_uri()."/lib/placeholder.png";

    if($category_image){
      $image = wp_get_attachment_image_src( $category_image, array( 266,266 ));
      if($image)
        $image_url=$image[0];
    }

    $tax = get_taxonomy($taxonomy);
    $tax_name = $tax->labels->singular_name;
?>
<table class="form-table">
    <tbody><tr class="form-field form-required term-name-wrap">
      <th scope="row"><label for="category_image"><?php printf(esc_html__( '%s Image', 'petro' ),$tax_name); ?></label></th>
      <td>
        <div id="category_image"><img class="btn btn-link upload_image_button" src="<?php echo esc_url( $image_url ); ?>" width="200px"  /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="category_image_id" name="category_image_id" value="<?php print ($category_image)? $category_image:"";?>"/>
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'petro' ); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'petro' ); ?></button>
        </div>
      </td>
    </tr>
    </tbody>
</table>
<script type="text/javascript">
jQuery(document).ready(function($) {
    'use strict';

    if ( ! $( '#category_image_id' ).val() ) {
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

            $( '#category_image_id' ).val( attachment.id );
            $( '#category_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
            $( '.remove_image_button' ).show();
        });

        // Finally, open the modal.
        file_frame.open();
    });
});

</script>

<?php
}

function petro_save_category_image($term_id,$tt_id="",$taxonomy=""){

    if($taxonomy=='category' || $taxonomy=='post_tag'){

       $old = get_metadata( 'term', $term_id, '_thumbnail_id', true );
       $new = (isset($_POST['category_image_id']))?absint($_POST['category_image_id']):'';
       $updated=update_metadata('term', $term_id, '_thumbnail_id', $new,$old );
    }
}

function petro_save_service_params($term_id,$tt_id="",$taxonomy=""){

    if($taxonomy=='service_cat'){

       $old = get_metadata( 'term', $term_id, '_category_icon', true );
       $new = (isset($_POST['category_icon']))? sanitize_html_class(trim($_POST['category_icon'])):'';
       $updated=update_metadata('term', $term_id, '_category_icon', $new,$old );

    }
}


function petro_edit_service_params($tag, $taxonomy){

    $category_icon=get_metadata('term', $tag->term_id, '_category_icon', true);


    wp_enqueue_style( "awesomeicon",get_template_directory_uri() . '/fonts/font-awesome/font-awesome.css', array(), '', 'all' );
    wp_enqueue_style( "petro-glyph",get_template_directory_uri() . '/fonts/petro-construction/petro-construction.css', array(), '', 'all' );
    wp_enqueue_script('icon_picker',get_template_directory_uri().'/lib/icon_picker/icon_picker.js',array('jquery'));
    wp_localize_script( 'icon_picker', 'picker_i18nLocale', array(
      'search_icon'=> esc_html__('Search Icon','petro'),
    ) );

    wp_enqueue_style('icon-picker',get_template_directory_uri().'/lib/icon_picker/icon_picker.css','');

    $tax = get_taxonomy($taxonomy);
    $tax_name = $tax->labels->singular_name;

    $icons= petro_glyphicon_list();
?>
<table class="form-table">
    <tbody>
            <tr class="form-field form-required term-name-wrap">
      <th scope="row"><label for="category_icon"><?php printf(esc_html__( '%s Icon', 'petro' ), $tax_name); ?></label></th>
      <td style="position: relative;"><span class="icon-selection-preview"><i class="<?php print esc_attr($category_icon);?>"></i></span>
            <input type="text" size="20" id="category_icon" name="category_icon" value="<?php print esc_attr($category_icon);?>" /><br/>
      <a id="add_icon_selection" href="#" class="icon_selection_button"><?php esc_html_e('Change Icon','petro');?></a></td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
        jQuery(document).ready(function($){
            'use strict';
            
            var options={
                icons:new Array('<?php print @implode("','",$icons);?>'),
                inline: true,
                onUpdate:function(e){
                  var par=this.closest('.form-table'),fieldinput=par.find('[name=category_icon]'),
                  preview=par.find('.icon-selection-preview i');
                  fieldinput.val(e);
                  preview.removeClass().addClass(e);
                }
            };

            $("#add_icon_selection").iconPicker(options);
        });
</script>
<?php
}

function petro_add_service_params($taxonomy){


    wp_enqueue_style( "awesomeicon",get_template_directory_uri() . '/fonts/font-awesome/font-awesome.css', array(), '', 'all' );
    wp_enqueue_style( "petro-glyph",get_template_directory_uri() . '/fonts/petro-construction/petro-construction.css', array(), '', 'all' );
    wp_enqueue_script('icon_picker',get_template_directory_uri().'/lib/icon_picker/icon_picker.js',array('jquery'));
    wp_localize_script( 'icon_picker', 'picker_i18nLocale', array(
      'search_icon'=> esc_html__('Search Icon','petro'),
    ) );

    wp_enqueue_style('icon-picker',get_template_directory_uri().'/lib/icon_picker/icon_picker.css','');

    $tax = get_taxonomy($taxonomy);
    $tax_name = $tax->labels->singular_name;

    $icons= petro_glyphicon_list();
?>
<div class="form-field" style="position: relative;">
    <label for="category_icon"><?php printf(esc_html__( '%s Icon', 'petro' ), $tax_name); ?></label>
    <span class="icon-selection-preview"><i class=""></i></span>
     <input type="text" id="category_icon" name="category_icon" />
     <a id="add_icon_selection" href="#" class="icon_selection_button"><?php esc_html_e('Change Icon','petro');?></a>
  <div class="clear"></div>
</div>
<script type="text/javascript">
        jQuery(document).ready(function($){
            'use strict';
            var options={
                icons:new Array('<?php print @implode("','",$icons);?>'),
                inline: true,
                onUpdate:function(e){
                  var par=this.closest('.form-field'),fieldinput=par.find('[name=category_icon]'),
                  preview=par.find('.icon-selection-preview i');
                  fieldinput.val(e);
                  preview.removeClass().addClass(e);
                }
            };

            $("#add_icon_selection").iconPicker(options);
        });
</script>
<?php
}



/* wp 4.4 >= */
if(get_option( 'db_version' ) >= 34370 ) {
    add_action( 'category_add_form_fields', 'petro_add_category_image');
    add_action( 'category_edit_form', 'petro_edit_category_image',10,2);
    add_action( 'edit_term', 'petro_save_category_image' , 10, 3 );
    add_action( 'created_term', 'petro_save_category_image' , 10, 3 );

    add_action( 'post_tag_add_form_fields', 'petro_add_category_image');
    add_action( 'post_tag_edit_form', 'petro_edit_category_image',10,2);
    add_action( 'edit_term', 'petro_save_category_image' , 10, 3 );
    add_action( 'created_term', 'petro_save_category_image' , 10, 3 );


    add_action( 'service_cat_add_form_fields', 'petro_add_service_params');
    add_action( 'service_cat_edit_form', 'petro_edit_service_params',10,2);
    add_action( 'edit_term', 'petro_save_service_params', 10, 3 );
    add_action( 'created_term', 'petro_save_service_params', 10, 3 );
}
