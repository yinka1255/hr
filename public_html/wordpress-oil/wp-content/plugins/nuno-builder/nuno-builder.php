<?php
defined('ABSPATH') or die();
/* 
 * Plugin Name: Nuno Page Builder
 * Plugin URI: http://themegum.com/abuilder
 * Description: Page builder for WordPress by TemeGUM.
 * Version: 2.1.5
 * Author: Atawai
 * Author URI: http://themegum.com
 * Domain Path: /languages/
 * Text Domain: nuno-builder
 */

class a_Builder{

	private $editor = null;
	private $elements = array();


	function __construct() {


        define('ABUILDER_BASENAME',dirname(plugin_basename(__FILE__)));
        define('ABUILDER_DIR',plugin_dir_path(__FILE__));

        load_plugin_textdomain('nuno-builder', false, ABUILDER_BASENAME. '/languages/');

        if(!function_exists('is_plugin_active')){
      		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
      	}

		require_once ( ABUILDER_DIR.'lib/helpers.php');
		require_once ( ABUILDER_DIR.'lib/class-elements.php');

		$wp_filesystem=new WP_Filesystem_Direct(array());

		if($dirlist=$wp_filesystem->dirlist(ABUILDER_DIR."lib/elements")){

		      foreach ($dirlist as $dirname => $dirattr) {
		         if($dirattr['type']=='f' && preg_match("/(\.php)$/", $dirname) ){
		            @require_once(ABUILDER_DIR."lib/elements/".$dirname);
		          }


		      }
		}

		require_once ( ABUILDER_DIR.'lib/class-editor.php');

		add_action('init', array($this,'init'));
	}

	public function init(){

		global $Elements,$PageStyles;

		if(!is_object($Elements))
			$Elements=Elements::getInstance();

		$this->elements=$Elements;
		$elements=get_builder_elements();

		if(! isset($PageStyles)){
			$PageStyles = array();
		}

		$this->register_block_templates();

		add_action( 'admin_init',array($this, 'get_builder'),999);
        add_action( 'wp_enqueue_scripts', array($this,'load_front_css_style' ));
		add_action( 'wp_footer', array($this,'render_page_style'),99999);
		add_action( 'wp_enqueue_scripts',array($this,'load_custom_css'),999);
	    add_action( 'admin_menu', array($this,'register_submenu_page'));
	    add_action( 'network_admin_menu', array( $this, 'register_submenu_page' ) );
	    add_action( 'themegum-glyph-icon-loaded', array($this, 'load_awesomeicon') );
		add_filter( 'the_content',array($this,'removeWPautop'),12); 
		add_filter( 'pre_set_site_transient_update_plugins',array($this,'get_update_plugin'));
		add_filter( 'themegum_glyphicon_list', array( $this, 'install_awesome_icon'));	

		add_action( 'admin_init',array($this, 'block_checking'));

	}

	function install_awesome_icon($icons){

		  $awesome_icon_path=ABUILDER_DIR."font-awesome/";

		  if($awesome_icons = themegum_get_glyph_lists($awesome_icon_path)){
		    $icons= is_array($icons) ?  array_merge( $icons, $awesome_icons ) : $awesome_icons;
		  }

		  return array_unique($icons);
	}

	function get_update_plugin($transient){

	    if ( empty( $transient->checked ) || ! get_option('abuilder_update_permission') ) {
	      return $transient;
	    }


	    $plugin_file = plugin_basename(__FILE__);
    	$plugin_root = WP_PLUGIN_DIR;

		$plugin_data = get_file_data( "$plugin_root/$plugin_file", 
		array(
			'Name' => 'Plugin Name',
			'PluginURI' => 'Plugin URI',
			'Version' => 'Version',
			'Description' => 'Description',
			'Author' => 'Author',
			'AuthorURI' => 'Author URI',
			'TextDomain' => 'Text Domain',
			'DomainPath' => 'Domain Path',
			'Network' => 'Network',
			'_sitewide' => 'Site Wide Only',
			'SN'=>'Purchase Number'
		), 'plugin' );


	    $version= $plugin_data['Version'];
	    $slug= $plugin_file;


		$post_option = array(
			'timeout' => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
			'body' => array(
				'plugin'      => $slug,
				'version'      => $version,
				'style'      => get_template(),
			),
			'user-agent' => 'WordPress; ' . get_bloginfo( 'url' )
		);

		$url = $http_url = 'http://update.themegum.com/plugin/update-check/';

		if ( $ssl = wp_http_supports( array( 'ssl' ) ) )
			$url = set_url_scheme( $url, 'https' );
	
		$raw_response = wp_remote_post( $url, $post_option );
		
		if ( $ssl && is_wp_error( $raw_response ) ) {
			$raw_response = wp_remote_post( $http_url, $post_option );
		}

		if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) )
			return $transient;

		$response = json_decode( wp_remote_retrieve_body( $raw_response ), true );

		if($response){
	
	      $obj = new stdClass();
	      $obj->slug = $response['slug'];
	      $obj->new_version = $response['new_version'];
	      $obj->url = $response['url'];
	      $obj->package = $response['package'];
	      $obj->name = $response['name'];
	      $transient->response[$plugin_file] = $obj;
		}

		return $transient;
	}


	function render_page_style(){

		global $PageStyles;

		if(empty($PageStyles)) return;

	      if($PageStyles && count($PageStyles)){
	        print "<style type=\"text/css\">";
	        print isset($PageStyles['desktop']) && count($PageStyles['desktop']) ? join("\n",$PageStyles['desktop']): "";

	        if(isset($PageStyles['tablet']) && count($PageStyles['tablet'])){
	          print "\n@media (max-width: 992px) {\n";
	          print join("\n",$PageStyles['tablet']);
	          print "\n}\n";
	        }

	        if(isset($PageStyles['mobile']) && count($PageStyles['mobile'])){
	          print "\n@media (max-width: 480px) {\n";
	          print join("\n",$PageStyles['mobile']);
	          print "\n}\n";
	        }

	        print "</style>";
	      }
	}

    function register_submenu_page(){

		    add_menu_page(
		          esc_html__( 'Nuno Page Builder', 'nuno-builder' ),
		          esc_html__( 'Nuno Builder', 'nuno-builder' ),
		          'manage_options',
		          'nuno-builder',
		          array( $this, 'builder_setting_page' ),
		          get_abuilder_dir_url()."lib/images/brand-logo-small.png",
		          50
		      );

    }

    function save_setting(){


    	if(wp_verify_nonce( isset($_POST['a_builder-setting'])?$_POST['a_builder-setting']:"", 'a_builder-setting')){

         	$builderposttype=(isset($_POST['builderposttype']))?$_POST['builderposttype']:'';
            update_option('abuilder_settings',$builderposttype);

            update_option('abuilder_update_permission', (isset($_POST['update_permission']))?$_POST['update_permission']:'' );
	    }

    }

    function builder_setting_page(){

    $this->save_setting();


    $builder_settings=get_option('abuilder_settings',array('page'));
    if(empty($builder_settings)) $builder_settings=array();

    $args = array( 'page' => 'nuno-builder');

    $url = add_query_arg( $args, admin_url( 'admin.php' ));

	$post_types = get_post_types( array('public' => true ) );
	$post_types_list = array();
	foreach ( $post_types as $post_type ) {

		if ( in_array($post_type,
			apply_filters('abuilder_skip_post_types',array('revision','nav_menu_item','attachment','wpcf7_contact_form',
				'shop_coupon','shop_order','product_variation','shop_order_refund','shop_webhook','nuno-block','nuno-element'))))
			continue;

			$label = ucfirst( $post_type );
			$post_types_list[$post_type] = $label;
	}
?>
<div class="builder-panel">
<h2><?php printf( esc_html__('%s Settings', 'nuno-builder'), esc_html__( 'Nuno Page Builder', 'nuno-builder' ));?></h2>
<form method="post" action="<?php print esc_url($url);?>">
<?php wp_nonce_field( 'a_builder-setting','a_builder-setting');?>
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="post-type"><?php esc_html_e('Post types','nuno-builder');?></label></th>
<td>
<?php foreach ($post_types_list as $post_type => $label) {
	$post_type_object=get_post_type_object($post_type);
	$label = $post_type_object->labels->singular_name;
?>
<input name="builderposttype[]" type="checkbox" value="<?php print $post_type;?>" <?php print in_array($post_type,$builder_settings)?"checked=\"checked\"":"";?> /> <?php print $label;?><br/>
<?php } ?>
<p class="description"><?php esc_html_e('Select the post type where a builder activated.','nuno-builder');?></p>
</td>
</tr>
<tr>
<th scope="row"><label for="post-type"><?php esc_html_e('Keep Update','nuno-builder');?></label></th>
<td>
<input name="update_permission" type="checkbox" value="1" <?php print ( get_option('abuilder_update_permission') ) ? "checked=\"checked\"":"";?> /> <?php esc_html_e('Yes, please','nuno-builder');?><br/>
<p class="description"><strong><?php esc_html_e('By turn on update notification you are AGREE to sending following data ( theme name, plugin version and site url ) to themegum server.','nuno-builder');?></strong></p>
</td>
</tr>

</tbody></table>


<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes','nuno-builder' );?>" type="submit"></p></form>
</div>
<?php
    }

	function load_custom_css(){
		if ( ! is_singular() ) return;
		$page_id = get_the_ID();
		if ( $page_id ) {
			$custom_css = get_post_meta( $page_id, '_abuilder_custom_css', true );
			if ( ! empty( $custom_css ) ) {
				wp_add_inline_style( 'builder-style', $custom_css);
			}
		}
	}
	
    static function load_front_css_style(){


        wp_register_script( 'uilkit', get_abuilder_dir_url() . 'js/uilkit.js', array(), '1.0', true );
        wp_register_script( 'ScrollSpy',get_abuilder_dir_url()."js/scrollspy.js",array( 'uilkit' ), '1.0', true );
        wp_register_script( 'owl.carousel', get_abuilder_dir_url() . 'js/owl.carousel.min.js', array('jquery'), '2.2.1', false );

        wp_enqueue_style( 'builder-style',get_abuilder_dir_url()."css/abuilder_style.css",array());

        wp_register_style( 'animate', get_abuilder_dir_url()."css/animate.css",array());
	  	wp_register_style( 'awesomeicon', get_abuilder_dir_url(). '/font-awesome/font-awesome.css');        
        wp_register_style( 'owl.carousel',get_abuilder_dir_url()."css/owl.carousel.css",array());
		wp_enqueue_style( 'scroll-spy',get_abuilder_dir_url()."css/scroll_spy.css",array('scroll-spy-ie'));
		wp_enqueue_style( 'scroll-spy-ie', get_abuilder_dir_url(). '/css/scroll_spy_ie9.css', array());

		wp_style_add_data( 'scroll-spy-ie', 'conditional', 'IE 9' );

    }

	function load_awesomeicon(){
	  	wp_enqueue_style( 'awesomeicon');
	}

	public function getElements(){

		return $this->elements;
	} 

	public function prepareElement(){

		
	} 

	public function get_builder(){

		$editor = new ABuilder_Editor();
		$this->editor=$editor;
		$this->editor->render();
		add_action('wp_ajax_builder_get_setting',array($this,'get_module_builder'));
		add_action('wp_ajax_builder_save_setting',array($this,'get_save_builder'));
		add_action('wp_ajax_builder_add_shortcode',array($this,'get_add_shortcode'));
		add_action('wp_ajax_builder_load_block',array($this,'get_block_template'));
		add_action('wp_ajax_builder_load_element',array($this,'get_element_template'));

	}

	public function get_save_builder(){


		if ( ! isset( $_POST['_abuilder_nonce'] ) || ! check_ajax_referer( '_abuilder_ajax', '_abuilder_nonce', false ) ) { 
			die(0);
		}

		$tag=(isset($_POST['tag']) && ''!=$_POST['tag'])?$_POST['tag']:false;
		$shortcode_settings=(isset($_POST['shortcode']))?$_POST['shortcode']:"";

		parse_str($shortcode_settings, $shortcode_settings);

		$elements=get_builder_elements();

		if(!isset($elements[$tag]))
			die(0);

		$shortcode=$elements[$tag];
		$shortcode_string=$shortcode->getShortcodeString($shortcode_settings);

		$shortcode_tag=$shortcode->extractShortcodeString($shortcode_string);

		$output="<div class=\"shorcode_tag\">";
		$output.="[".$shortcode_tag[2].$shortcode_tag[3]."]";
		$output.="</div>";
		$output.="<div class=\"shorcode_content\">";
		$output.=$shortcode_tag[5];
		$output.="</div>";
		$output.="<div class=\"shorcode_preview\">";
		$output.=$shortcode->preview_admin();
		$output.="</div>";

		print $output;


		die();
	}

	public function get_block_template(){


		if ( ! isset( $_POST['_abuilder_nonce'] ) || ! check_ajax_referer( '_abuilder_ajax', '_abuilder_nonce', false ) ) { 
			die(0);
		}


	    $category_name=(isset($_POST['category']) && ''!=$_POST['category']) ? $_POST['category']: "";

        $category_name=(isset($_POST['category']) && ''!=$_POST['category']) ? sanitize_text_field($_POST['category']): "";
        $search_key=(isset($_POST['search']) && ''!=$_POST['search']) ? sanitize_text_field($_POST['search']): "";

        $paged = get_query_var('paged');

        if(!$paged ){
          $paged = isset($_GET['paged']) && ''!=$_GET['paged'] ? absint($_GET['paged']): 1;
        }

	    $queryargs = array(
	        'post_type' => 'nuno-block',
	        'post_status'=>'publish',
	        'no_found_rows' => false,
	        'posts_per_page'=> 10,
	        'paged'=> $paged
	      );

        if($search_key!=''){
          add_filter( 'posts_where', 'nuno_builder_filter_block_name', 10, 2 );
        }
        elseif($category_name !=''){

          $queryargs['meta_query'] = array(
              'relation' => 'AND',
              array(
                'key' => '_nuno_block_cat',
                'value'    => $category_name,
                'compare' => 'LIKE'
              ));
        }


	    $nuno_blocks=array();
        $form  = '';
	    $query = new WP_Query( $queryargs );  


	    if ( $query->have_posts() ) :

	      foreach($query->posts as $block){

	        if(strlen($block->post_content) < 10) continue;


	        $nuno_blocks[$block->ID]="<div class=\"".join( ' ', get_post_class( "block-option",$block->ID ) )."\" data-option=\"".$block->ID."\">".
	        do_shortcode($block->post_content).'<textarea class="content-tag render-tag">'.$block->post_content.'</textarea><div class="block-name">'.$block->post_title.'</div><a href="#" class="select_block_button button">'.esc_html__('add section','nuno-builder').'</a></div>';
	      }
	    endif;

        $all_row =  $query->found_posts;
        $total_pages = $query->max_num_pages;

        wp_reset_postdata();
        remove_filter( 'posts_where', 'nuno_builder_filter_block_name');


	       ob_start();

        if(count($nuno_blocks)){
          $form.=implode("",$nuno_blocks);

          $this->load_block_styles();

          $pagination = nuno_builder_block_pagination(array(
            'total_pages'=> $total_pages,
            'total_items'=> $all_row,
            'current_page'=> $paged,
          ),false);

          if($pagination!=''){
            print '<div class="block-paginations">'.$pagination.'</div>';
          }

        }
        else{

          print '<div class="block-nofound">';
          print esc_html__('No section found.','nuno-builder');
          print ' <a href="'.admin_url("import.php?import=wordpress").'">'.esc_html__('Import Data','nuno-builder').'</a>';
          print '</div>';

        }


        $form.= ob_get_clean();

        print $form;

	die();

	}


  public function get_element_template(){



		if ( ! isset( $_POST['_abuilder_nonce'] ) || ! check_ajax_referer( '_abuilder_ajax', '_abuilder_nonce', false ) ) { 
			die(0);
		}

        $category_name=(isset($_POST['category']) && ''!=$_POST['category']) ? sanitize_text_field($_POST['category']): "";
        $search_key=(isset($_POST['search']) && ''!=$_POST['search']) ? sanitize_text_field($_POST['search']): "";

        $paged = get_query_var('paged');

        if(!$paged ){
          $paged = isset($_GET['paged']) && ''!=$_GET['paged'] ? absint($_GET['paged']): 1;
        }

        $queryargs = array(
            'post_type' => 'nuno-element',
            'post_status'=>'publish',
            'no_found_rows' => false,
            'posts_per_page'=> 30,
            'paged'=> $paged
          );

        if($search_key!=''){
          add_filter( 'posts_where', 'nuno_builder_filter_block_name', 10, 2 );
        }
        elseif($category_name !=''){

          $queryargs['meta_query'] = array(
              'relation' => 'AND',
              array(
                'key' => '_nuno_block_cat',
                'value'    => $category_name,
                'compare' => 'LIKE'
              ));
        }

        $nuno_elements=array();
        $form  = '';
        $query = new WP_Query( $queryargs );  


        if ( $query->have_posts() ) {

          foreach($query->posts as $block){

            if(strlen($block->post_content) < 10) continue;


            $nuno_elements[$block->ID]="<div class=\"".join( ' ', get_post_class( "block-option",$block->ID ) )."\" data-option=\"".$block->ID."\"><div class=\"element-wrapper\">".
            do_shortcode($block->post_content).'<textarea class="content-tag render-tag">'.$block->post_content.'</textarea><a href="#" class="select_block_button button">'.esc_html__('add this','nuno-builder').'</a></div></div>';
          }
        }

        $all_row =  $query->found_posts;
        $total_pages = $query->max_num_pages;

        wp_reset_postdata();
        remove_filter( 'posts_where', 'nuno_builder_filter_block_name');
        ob_start();

        if(count($nuno_elements)){
          $form.=implode("",$nuno_elements);

          $this->load_block_styles();

          $pagination = nuno_builder_block_pagination(array(
            'total_pages'=> $total_pages,
            'total_items'=> $all_row,
            'current_page'=> $paged,
          ),false);

          if($pagination!=''){
            print '<div class="block-paginations">'.$pagination.'</div>';
          }
        }
        else{

          print '<div class="block-nofound">';
          print esc_html__('No element found.','nuno-builder');
          print ' <a href="'.admin_url("import.php?import=wordpress").'">'.esc_html__('Import Data','nuno-builder').'</a>';
          print '</div>';


        }

        $form.= ob_get_clean();
        print $form;

        die();    
  }
	public function get_add_shortcode(){


		if ( ! isset( $_POST['_abuilder_nonce'] ) || ! check_ajax_referer( '_abuilder_ajax', '_abuilder_nonce', false ) ) { 
			die(0);
		}

		$shortcode=(isset($_POST['shortcode']))?$_POST['shortcode']:"";
		$content=$shortcode;

		$elements=get_builder_elements();

		foreach ($elements as $tag => $element) {
	       $regexshortcodes=$element->getRegex();
	       $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );

	    }

	    if($content==$shortcode){
	      $content='[el_text_html]'.$shortcode.'[/el_text_html]';
	      foreach ($elements as $tag => $element) {
	         $regexshortcodes=$element->getRegex();
	         $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );
	      }

	    }
	    print $content;

		die();

	}

	public function get_module_builder(){

		if ( ! isset( $_POST['_abuilder_nonce'] ) || ! check_ajax_referer( '_abuilder_ajax', '_abuilder_nonce', false ) ) { 
			die(0);
		}


		$tag=(isset($_POST['tag']) && ''!=$_POST['tag'])?$_POST['tag']:false;
		$shortcode_string=(isset($_POST['shortcode']))?$_POST['shortcode']:"";


		$elements=get_builder_elements();

		if(!isset($elements[$tag]))
			die(0);

	
		$shortcode=$elements[$tag];

		$shortcode->setShortcodeString($shortcode_string);


		$shortcode->getSettingForm(true);
		die();

	}

	public function removeWPautop( $content) {

		if ( $content ) {

			$s = array(
				'/' . preg_quote( '</div>', '/' ) . '[\s\n\f]*' . preg_quote( '</p>', '/' ) . '/i',
				'/' . preg_quote( '<p>', '/' ) . '[\s\n\f]*' . preg_quote( '<div ', '/' ) . '/i',
				'/' . preg_quote( '<p>', '/' ) . '[\s\n\f]*' . preg_quote( '<section ', '/' ) . '/i',
				'/' . preg_quote( '</section>', '/' ) . '[\s\n\f]*' . preg_quote( '</p>', '/' ) . '/i'
			);
			$r = array( "</div>", "<div ", "<section ", "</section>" );
			$content = preg_replace( $s, $r, $content );


		}

		return $content;
	}

	function register_block_templates(){

          $section_settings=array(
          'labels' => array(
              'name' => ucwords(esc_html__('nuno sections', 'nuno-builder')),
              'singular_name' => ucwords(esc_html__('nuno sections', 'nuno-builder')),
              'add_new' => ucwords(esc_html__('add new section', 'nuno-builder')),
              'edit_item' => ucwords(esc_html__('edit section', 'nuno-builder')),
              'view_item' => ucwords(esc_html__('view section', 'nuno-builder'))
          ),
          'args' => array(
            'taxonomies' => array('nuno_block_cat')
          ),
          'public' => true,
          'show_ui' => false,
          'show_in_nav_menus' => false,
          'show_in_menu'=>'nuno-builder',
          'exclude_from_search'=>true,
          'rewrite' => array(
              'slug' => 'nuno-block',
              'with_front' => false
          ),
          'has_archive'=>false,
          'hierarchical' => true,
          'supports' => array(
              'title',
              'editor'
          ),
          '_edit_link'=>'post.php?post=%d'
           );

         register_post_type('nuno-block', $section_settings);

         register_taxonomy('nuno_block_cat', 'nuno-block',array(
          'labels'=>array(
              'name' => ucwords(esc_html__('section categories', 'nuno-builder')),
              'singular_name' => ucwords(esc_html__('category', 'nuno-builder')),
              'add_new_item'=>ucwords(esc_html__('add new category', 'nuno-builder')),
              'edit_item' => ucwords(esc_html__('edit category', 'nuno-builder')),
              'view_item' => ucwords(esc_html__('view category', 'nuno-builder'))
            ),
          'hierarchical' => true,
          'show_in_nav_menus' => false,
          'show_in_menu'=> 'nuno-builder',
          'show_ui'=>true,
          'singular_name' => esc_html__('Section Category','nuno-builder')
          ));


          $element_settings=array(
          'labels' => array(
              'name' => ucwords(esc_html__('nuno elements', 'nuno-builder')),
              'singular_name' => ucwords(esc_html__('nuno elements', 'nuno-builder')),
              'add_new' => ucwords(esc_html__('add new element', 'nuno-builder')),
              'edit_item' => ucwords(esc_html__('edit element', 'nuno-builder')),
              'view_item' => ucwords(esc_html__('view element', 'nuno-builder'))
          ),
          'public' => true,
          'show_ui' => false,
          'show_in_nav_menus' => false,
          'show_in_menu'=>'nuno-builder',
          'exclude_from_search'=>true,
          'rewrite' => array(
              'slug' => 'nuno-element',
              'with_front' => false
          ),
          'has_archive'=>false,
          'hierarchical' => true,
          'supports' => array(
              'title',
              'editor'
          ),
          '_edit_link'=>'post.php?post=%d'
           );

         register_post_type('nuno-element', $element_settings);

	}

    function load_block_styles(){

      $styles=nuno_get_page_styles();

      if($styles && count($styles)){
        print "<style type=\"text/css\">";
        print isset($styles['desktop']) && count($styles['desktop']) ? join("\n",$styles['desktop']): "";

        if(isset($styles['tablet']) && count($styles['tablet'])){
          print "\n@media (max-width: 992px) {\n";
          print join("\n",$styles['tablet']);
          print "\n}\n";
        }

        if(isset($styles['mobile']) && count($styles['mobile'])){
          print "\n@media (max-width: 480px) {\n";
          print join("\n",$styles['mobile']);
          print "\n}\n";
        }


        print "</style>";
      }
    }

    function block_checking(){

    	$migration = get_option('abuilder_migration');

    	if(taxonomy_exists('nuno_block_cat') && !$migration){

    		if($this->migration_section_taxonomy()){
    			update_option('abuilder_migration','1');
    		}

    	}

		require_once ( ABUILDER_DIR.'lib/parsers.php');

		$post_exists = ABSPATH . 'wp-admin/includes/post.php';
		if ( !file_exists( 'post_exists' ) )
			require_once $post_exists;

    	$was_checking = get_option('abuilder_ready');


    	if($was_checking=='1') return;
    	$current = get_site_transient( 'abuilder_last_checking' );

		if ( isset( $current->last_checked ) && 24 * HOUR_IN_SECONDS > ( time() - $current->last_checked ) )
			return;

        $query_params= array(
          'posts_per_page' => -1,
          'no_found_rows' => true,
          'post_status' => 'publish',
          'post_type'=>'nuno-block',
          'ignore_sticky_posts' => true
        );

        $query = new WP_Query($query_params);

        if($query->have_posts()) {

        	update_option('abuilder_ready','1');
        	wp_reset_postdata();
        	return;
        }

        $wp_filesystem=new WP_Filesystem_Direct(array());

        $blocks_file = ABUILDER_DIR."dummy-data/starter_data.xml";


        if( ! $wp_filesystem->is_file($blocks_file)) return;


       $import = $this->import( $blocks_file );

        if( !$import || is_wp_error($import)){
        	update_option('abuilder_ready','');
        }
        else{
        	update_option('abuilder_ready','1');
        }

		$new_update = new stdClass;
		$new_update->last_checked = time();
		set_site_transient( 'abuilder_last_checking', $new_update );

    }

    function migration_section_taxonomy(){


        $query_params= array(
          'posts_per_page' => -1,
          'no_found_rows' => true,
          'post_status' => 'publish',
          'post_type'=>'nuno-block',
          'ignore_sticky_posts' => true
        );

        $proccessed = false;

        $query = new WP_Query($query_params);

        if($query->have_posts()) {


	      foreach($query->posts as $section){
				

				$section_id = $section->ID;

				if(! get_post_meta( $section_id, '_nuno_block_cat')){

					$categories = get_the_terms($section, 'nuno_block_cat' );
					$new_categories = array();

					if($categories && !is_wp_error($categories) && count($categories)){

						foreach ($categories as $category) {
							array_push($new_categories, $category->slug);
						}

					}

					update_post_meta( $section_id, '_nuno_block_cat', join(',', array_unique($new_categories) ) );

				}
	      }

	      $proccessed = true;

        }

        wp_reset_postdata();

    	return $proccessed;
    }

	function import( $file ) {

		$parser = new Nuno_WXR_Parser();
		return $parser->parse( $file );

	}



}

$mybuider= new a_Builder();