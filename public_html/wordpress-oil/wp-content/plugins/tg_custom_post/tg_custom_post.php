<?php
/*
Plugin Name:    ThemeGUM Custom Post
Plugin URI:     http://www.themegum.com/
Description:    Add custom post type
Version:        2.1.1
Author:         themegum.com
Author URI:     http://www.themegum.com/
Text Domain:    tg_custom_post
Domain Path:    /languages/
*/

class TG_Custom_Post{

    function __construct(){
        add_action('init',array($this,'_init'));
    }

    function _init(){

        load_plugin_textdomain('tg_custom_post', false, dirname(plugin_basename(__FILE__)) . '/languages/');

        $post_type="tg_custom_post";

        $admin      = get_role('administrator');
        $admin-> add_cap( 'tg_post_setting' );


        $post_settings_default=array(
                'labels' => array(
                    'name' => esc_html__('Custom Post', 'tg_custom_post'),
                    'singular_name' => esc_html__('Custom Post', 'tg_custom_post'),
                    'add_new' => esc_html__('Add New', 'tg_custom_post'),
                    'edit_item' => esc_html__('Edit', 'tg_custom_post')
                ),
                'public' => true,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'rewrite' => array(
                    'slug' => 'custom_post',
                    'with_front' => false
                ),
                'has_archive'=>true,
//                'taxonomies'=>array('post_tag'),
                'hierarchical' => true,
                'menu_position' => 5,
                'supports' => array(
                    'title',
                    'comments',
                    'editor',
                    'excerpt',
                    'thumbnail'
                )
        );

        $post_settings=get_option('tg_post_setting');
        add_action( 'save_post', array($this, 'save_field_meta'));

        if(!$post_settings){
            update_option('tg_post_setting',$post_settings_default);

        }else{
            $post_settings=wp_parse_args($post_settings,$post_settings_default);
            $post_settings['labels']['add_new']=$post_settings_default['labels']['add_new'];
        }

        if(wp_verify_nonce(isset($_POST['tg_post_setting'])?$_POST['tg_post_setting']:"",__FILE__)){

             $label_name=(isset($_POST['label_name']))?$_POST['label_name']:esc_html__('Custom Post', 'tg_custom_post');
             $singular_name=(isset($_POST['singular_name']))?$_POST['singular_name']:esc_html__('Custom Post', 'tg_custom_post');
             $rewrite_slug=(isset($_POST['post_slug']))?$_POST['post_slug']:'custom_post';

             $do_update=false;

             if($label_name!=$post_settings['labels']['name'] && ''!=$label_name){
                $post_settings['labels']['name']=$label_name;
                $do_update=true;
             }

             if($singular_name!=$post_settings['labels']['singular_name'] && ''!=$singular_name){
                $post_settings['labels']['singular_name']=$singular_name;
                $do_update=true;
               
             }

             if($rewrite_slug!=$post_settings['rewrite']['slug'] && ''!=$rewrite_slug){
                $post_settings['rewrite']['slug']=$rewrite_slug;
                $do_update=true;
               
             }

             if($do_update){
                 update_option('tg_post_setting',$post_settings);
             }

        }
        register_post_type($post_type, $post_settings);
        register_taxonomy('tg_postcat', $post_type, array('hierarchical' => true, 'label' => sprintf(esc_html__('%s Category', 'tg_custom_post'),ucwords($post_settings['labels']['singular_name'])), 'singular_name' => esc_html__('Category')));

        add_filter("manage_edit-".$post_type."_columns", array($this,'show_post_column'));
        add_action("manage_".$post_type."_posts_custom_column", array($this,"post_custom_columns"));
        add_action('template_redirect', array($this, 'loadTemplate'),100);
        add_action('admin_menu', array($this,'_setup_setting'));

        


        /* wp 4.4 >= */
        if(get_option( 'db_version' ) >= 34370 ) {
            add_action( 'tg_postcat_add_form_fields', array( $this, 'add_category_image'));
            add_action( 'tg_postcat_edit_form', array( $this, 'edit_category_image'),10,2);
            add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
            add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
        }

    }

    function save_field_meta($post_id){

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        if(!wp_verify_nonce( isset($_POST['custom_field_meta_box'])?sanitize_text_field($_POST['custom_field_meta_box']):"", 'custom_field_meta_box'))
            return;

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
        }

         if('tg_custom_post'==get_post_type()){

            $fields = apply_filters( 'tg_custom_post_fields', array() );

           if(count($fields)){
              foreach ($fields as $field_name => $field) {

                $old_value = get_post_meta( $post_id, '_'.$field_name, true );
                $input_name = sanitize_text_field($field_name);
                $new_value = (isset($_POST[$input_name])) ? $_POST[$input_name]:'';

                update_post_meta( $post_id, '_'.$field_name, $new_value,$old_value );
              }
           }

           
        }
    }



    function custom_field_meta_box($post){

        wp_nonce_field( 'custom_field_meta_box','custom_field_meta_box');
        $fields = apply_filters( 'tg_custom_post_fields', array() );

        if(count($fields)):

        foreach ($fields as $field_name => $field) {

            $value = get_post_meta($post->ID,'_'.$field_name,true); 
?>
<p><label><?php print esc_html($field['label']);?></label><input type="text" name="<?php print sanitize_text_field($field_name);?>" value="<?php print esc_attr($value);?>" /></p>
<?php        } 

        else:
?>
<p><?php esc_html_e( 'this post type no custom field.','tg_custom_post');?></p>
<?php
        endif;

    }

    function _setup_setting(){

        wp_enqueue_style( 'tg-custom-post-admin' , plugin_dir_url(__FILE__). 'css/admin_style.css', array(), '', 'all' );

        $title = apply_filters('tg_custom_post_metabox_title',esc_html__('Custom Fields','tg_custom_post'));

        add_meta_box('tgumpostmeta',  $title, array($this, 'custom_field_meta_box'), 'tg_custom_post', 'normal', 'core');
        add_submenu_page( 'edit.php?post_type=tg_custom_post', esc_html__('Custom Post Settings', 'tg_custom_post'), esc_html__('Settings', 'tg_custom_post'),'tg_post_setting','post-setting', array($this,'custom_post_setting'));
    }

    function custom_post_setting(){


        $post_settings=get_option('tg_post_setting');

        $args = array( 'page' => 'post-setting');
        $url = add_query_arg( $args, admin_url( 'admin.php' ));

        $post_name=$post_settings['labels']['name'];
        $singular_name=$post_settings['labels']['singular_name'];
        $slug=$post_settings['rewrite']['slug'];
?>
<div class="setting-panel">
<h2><?php printf(esc_html__('%s Settings', 'tg_custom_post'),ucwords($post_name));?></h2>
<form method="post" action="<?php print esc_url($url);?>">
<?php wp_nonce_field( __FILE__,'tg_post_setting');?>
<input name="option_page" value="reading" type="hidden" />
<input name="action" value="update" type="hidden" />
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="label_name"><?php esc_html_e('Label Name','tg_custom_post');?></label></th>
<td>
<input name="label_name" id="label_name" max-length="50" value="<?php print $post_name;?>" class="" type="text" /></td>
</tr>
<tr>
<th scope="row"><label for="singular_name"><?php esc_html_e('Singular Name','tg_custom_post');?></label></th>
<td>
<input name="singular_name" id="singular_name" max-length="50" value="<?php print $singular_name;?>" class="" type="text" /></td>
</tr>
<tr>
<th scope="row"><label for="post_slug"><?php esc_html_e('Rewrite Slug','tg_custom_post');?></label></th>
<td>
<input name="post_slug" id="post_slug" max-length="50" value="<?php print $slug;?>" class="" type="text" /></td>
</tr>
</tbody></table>

<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php esc_html_e('Save Changes','tg_custom_post');?>" type="submit" /></p></form>
</div>
<?php
    }
    function show_post_column($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "image" => esc_html__("Image", 'tg_custom_post'),
            "title" => esc_html__("Title", 'tg_custom_post'),
            "author" => esc_html__("Author", 'tg_custom_post'),
            "category" => esc_html__("Categories", 'tg_custom_post'),
            "date" => esc_html__("Date", 'tg_custom_post'));
        return $columns;
    }

    function post_custom_columns($column)

    {

        global $post;
        switch ($column) {
            case "category":
                echo get_the_term_list($post->ID, 'tg_postcat', '', ', ', '');
                break;
            case "image":
                $attachment_id=get_the_post_thumbnail($post->ID,'thumbnail');
                print ($attachment_id)?$attachment_id:"";
                break;
        }
    }


    function loadTemplate(){

        global $post;

        if(!isset($post))
            return true;

        $standard_type=$post->post_type;
        $templateName=false;


        if(is_single() && $standard_type == 'tg_custom_post') {
           $templateName='tg_post';
        }
        else{
            return true;
        }

        $slug = $post->post_name;

        if ( $templateName ) {
            $template = locate_template( array("{$slug}.php", "{$templateName}.php","tg_custom_post/{$templateName}.php","templates/{$templateName}.php" ),false );
        }

        // Get default slug-name.php
        if ( ! $template && $templateName && file_exists( plugin_dir_path(__FILE__). "/templates/{$templateName}.php" ) ) {

            $template = plugin_dir_path(__FILE__). "templates/{$templateName}.php";
        }

        // Allow 3rd party plugin filter template file from their plugin
        $template = apply_filters( 'tg_custom_post_get_template_part', $template,$templateName );

        if ( $template ) {

            load_template( $template, false );
            exit;
        }

    }

    function add_category_image($taxonomy){
        wp_enqueue_media();

        $dummy_image=plugin_dir_url(__FILE__)."images/placeholder.png";

    ?>
        <div class="form-field">
            <label for="category_image"><?php esc_html_e( 'Category Image', 'tg_custom_post' ); ?></label>
            <div id="category_image"><img src="<?php echo esc_url( $dummy_image ); ?>" width="60px" height="60px" /></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="category_image_id" name="category_image_id" />
                <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'tg_custom_post' ); ?></button>
                <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'tg_custom_post' ); ?></button>
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
                title: '<?php esc_html_e( "Choose an image", "tg_custom_post" ); ?>',
                button: {
                    text: '<?php esc_html_e( "Use image", "tg_custom_post" ); ?>'
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
    function edit_category_image($tag, $taxonomy){
        wp_enqueue_media();

        $category_image=get_metadata('term', $tag->term_id, '_thumbnail_id', true);

        $image_url=plugin_dir_url(__FILE__)."images/placeholder.png";

        if($category_image){
          $image = wp_get_attachment_image_src( $category_image, array( 266,266 ));
          if($image)
            $image_url=$image[0];
        }

    ?>

<table class="form-table">
    <tbody><tr class="form-field form-required term-name-wrap">
      <th scope="row"><label for="category_image"><?php esc_html_e( 'Category Image', 'tg_custom_post' ); ?></label></th>
      <td>
        <div id="category_image"><img class="btn btn-link upload_image_button" src="<?php echo esc_url( $image_url ); ?>" width="200px"  /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="category_image_id" name="category_image_id" value="<?php print ($category_image)? $category_image:"";?>"/>
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'tg_custom_post' ); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'tg_custom_post' ); ?></button>
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
                title: '<?php esc_html_e( "Choose an image", "tg_custom_post" ); ?>',
                button: {
                    text: '<?php esc_html_e( "Use image", "tg_custom_post" ); ?>'
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

    function save_category_fields($term_id,$tt_id="",$taxonomy=""){

        if($taxonomy=='category' || $taxonomy=='tg_postcat'){

           $old = get_metadata( 'term', $term_id, '_thumbnail_id', true );
           $new = (isset($_POST['category_image_id']))?intVal($_POST['category_image_id']):'';
           $updated=update_metadata('term', $term_id, '_thumbnail_id', $new,$old );
        }
    }

}

$TG_Custom_Post=new TG_Custom_Post();

