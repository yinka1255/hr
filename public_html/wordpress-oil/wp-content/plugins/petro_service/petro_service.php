<?php
/*
Plugin Name:    Service Post
Plugin URI:     http://www.themegum.com/
Description:    Post type service for Petro Theme by TemeGUM
Version:        1.0.3
Author:         themegum.com
Author URI:     http://www.themegum.com/
Text Domain:    petro_service
Domain Path:    /languages/
*/

class petro_service{

    function __construct(){
        add_action('init',array($this,'_init'));
    }

    function _init(){

        load_plugin_textdomain('petro_service', false, dirname(plugin_basename(__FILE__)) . '/languages/');

        $admin      = get_role('administrator');
        $admin-> add_cap( 'petro_setting' );


        $post_settings_default=array(
                'labels' => 
                array(
                    'name' => esc_html__('Services', 'petro_service'),
                    'singular_name' => esc_html__('Service', 'petro_service'),
                    'add_new' => esc_html__('Add New', 'petro_service'),
                    'edit_item' => esc_html__('Edit', 'petro_service'),
                ),
                'description'        => esc_html__( 'Description.', 'petro_service' ),
                'capability_type'    => 'post',
                'query_var'          => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'public' => true,
                'show_in_nav_menus' => true,
                'rewrite' => array(
                    'slug' => 'petro-service',
                    'with_front' => true
                ),
                'has_archive'=>true,
                'hierarchical' => false,
                'menu_position' => 6,
                'supports' => array(
                    'title',
                    'comments',
                    'editor',
                    'excerpt',
                    'thumbnail'
                )
        );


        $post_settings=get_option('petro_post_setting');

        if(!$post_settings){
            update_option('petro_post_setting',$post_settings_default);

        }else{
            $post_settings=wp_parse_args($post_settings,$post_settings_default);
            $post_settings['labels']['add_new']=$post_settings_default['labels']['add_new'];
        }

        if(wp_verify_nonce(isset($_POST['petro_post_setting'])?$_POST['petro_post_setting']:"",__FILE__)){

             $label_name=(isset($_POST['label_name']))?$_POST['label_name']:esc_html__('Custom Post', 'petro_service');
             $singular_name=(isset($_POST['singular_name']))?$_POST['singular_name']:esc_html__('Custom Post', 'petro_service');
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
                 update_option('petro_post_setting',$post_settings);

                 wp_redirect( add_query_arg( array('post_type'=>'petro_service'), admin_url( 'edit.php' )) );
                exit;
             }

        }

        register_post_type( 'petro_service', $post_settings);
        register_taxonomy('service_cat', 'petro_service', array('hierarchical' => true, 'label' => sprintf(esc_html__('%s Category', 'petro_service'),ucwords($post_settings['labels']['singular_name'])), 'singular_name' => esc_html__('Category','petro_service')));

        add_filter("manage_edit-petro_service_columns", array($this,'show_post_column'));
        add_action("manage_petro_service_posts_custom_column", array($this,"post_custom_columns"));
        add_action('template_redirect', array($this, 'loadTemplate'),100);
        add_action('admin_menu', array($this,'_setup_setting'));

        /* wp 4.4 >= */
        if(get_option( 'db_version' ) >= 34370 ) {
            add_action( 'service_cat_add_form_fields', array( $this, 'add_category_image'));
            add_action( 'service_cat_edit_form', array( $this, 'edit_category_image'),10,2);
            add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
            add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
        }

    }



    function show_post_column($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => esc_html__("Title", 'petro_service'),
            "author" => esc_html__("Author", 'petro_service'),
            "category" => esc_html__("Categories", 'petro_service'),
            "date" => esc_html__("Date", 'petro_service'));
        return $columns;
    }

    function post_custom_columns($column)

    {

        global $post;
        switch ($column) {
            case "category":
                echo get_the_term_list($post->ID, 'service_cat', '', ', ', '');
                break;
        }
    }


    function loadTemplate(){

        global $post;

        if(!isset($post))
            return true;

        $standard_type=$post->post_type;
        $templateName=false;


        if(is_single() && $standard_type == 'petro_service') {
           $templateName='petro_service';
        }
        else{
            return true;
        }

        $slug = $post->post_name;

        if ( $templateName ) {
            $template = locate_template( array("{$slug}.php", "{$templateName}.php","petro_service/{$templateName}.php","templates/{$templateName}.php" ),false );
        }

        // Get default slug-name.php
        if ( ! $template && $templateName && file_exists( plugin_dir_path(__FILE__). "/templates/{$templateName}.php" ) ) {

            $template = plugin_dir_path(__FILE__). "templates/{$templateName}.php";
        }

        // Allow 3rd party plugin filter template file from their plugin
        $template = apply_filters( 'petro_service_get_template_part', $template,$templateName );

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
            <label for="category_image"><?php esc_html_e( 'Category Image', 'petro_service' ); ?></label>
            <div id="category_image"><img src="<?php echo esc_url( $dummy_image ); ?>" width="60px" height="60px" /></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="category_image_id" name="category_image_id" />
                <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'petro_service' ); ?></button>
                <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'petro_service' ); ?></button>
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
                title: '<?php esc_html_e( "Choose an image", "petro_service" ); ?>',
                button: {
                    text: '<?php esc_html_e( "Use image", "petro_service" ); ?>'
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

        $image_url= plugin_dir_url(__FILE__)."images/placeholder.png";

        if($category_image){
          $image = wp_get_attachment_image_src( $category_image, array( 266,266 ));
          if($image)
            $image_url=$image[0];
        }
        
    ?>

<table class="form-table">
    <tbody><tr class="form-field form-required term-name-wrap">
      <th scope="row"><label for="category_image"><?php esc_html_e( 'Category Image', 'petro_service' ); ?></label></th>
      <td>
        <div id="category_image"><img class="btn btn-link upload_image_button" src="<?php echo esc_url( $image_url ); ?>" width="200px"  /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="category_image_id" name="category_image_id" value="<?php print ($category_image)? $category_image:"";?>"/>
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'petro_service' ); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'petro_service' ); ?></button>
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
                title: '<?php esc_html_e( "Choose an image", "petro_service" ); ?>',
                button: {
                    text: '<?php esc_html_e( "Use image", "petro_service" ); ?>'
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

        if($taxonomy=='service_cat'){

           $old = get_metadata( 'term', $term_id, '_thumbnail_id', true );
           $new = (isset($_POST['category_image_id']))?intVal($_POST['category_image_id']):'';
           $updated=update_metadata('term', $term_id, '_thumbnail_id', $new,$old );
        }
    }

    function _setup_setting(){

        add_submenu_page( 'edit.php?post_type=petro_service', esc_html__('Post Settings', 'petro_service'), esc_html__('Settings', 'petro_service'),'petro_setting','petro-post-setting', array($this,'custom_post_setting'));
    }

    function custom_post_setting(){


        $post_settings=get_option('petro_post_setting');

        $args = array( 'page' => 'petro-post-setting');
        $url = add_query_arg( $args, admin_url( 'admin.php' ));

        $post_name=isset($post_settings['labels']['name']) ?  $post_settings['labels']['name'] : esc_html__('Services', 'petro_service');
        $singular_name=isset($post_settings['labels']['singular_name']) ? $post_settings['labels']['singular_name'] : esc_html__('Service', 'petro_service');
        $slug=isset($post_settings['rewrite']['slug']) ? $post_settings['rewrite']['slug'] : 'petro-service';


?>
<div class="setting-panel">
<h2><?php printf(esc_html__('%s Settings', 'petro_service'),ucwords($post_name));?></h2>
<form method="post" action="<?php print esc_url($url);?>">
<?php wp_nonce_field( __FILE__,'petro_post_setting');?>
<input name="option_page" value="reading" type="hidden" />
<input name="action" value="update" type="hidden" />
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="label_name"><?php esc_html_e('Label Name','petro_service');?></label></th>
<td>
<input name="label_name" id="label_name" max-length="50" value="<?php print esc_attr($post_name);?>" class="" type="text" /></td>
</tr>
<tr>
<th scope="row"><label for="singular_name"><?php esc_html_e('Singular Name','petro_service');?></label></th>
<td>
<input name="singular_name" id="singular_name" max-length="50" value="<?php print esc_attr($singular_name);?>" class="" type="text" /></td>
</tr>
<tr>
<th scope="row"><label for="post_slug"><?php esc_html_e('Rewrite Slug','petro_service');?></label></th>
<td>
<input name="post_slug" id="post_slug" max-length="50" value="<?php print esc_attr($slug);?>" class="" type="text" /></td>
</tr>
</tbody></table>
<p><?php esc_html_e('After change setting, please upate the permalink setting also. Just need re-save permalink.','petro_service');?></p>
<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php esc_html_e('Save Changes','petro_service');?>" type="submit" /></p></form>
</div>
<?php
    }


}

$petro_service=new petro_service();

