<?php
defined('ABSPATH') or die();
/* 
 * Plugin Name: Nuno Page Builder Addon
 * Plugin URI: http://themegum.com/
 * Description: Nuno Page Builder addon for WP themes by TemeGUM.
 * Version: 1.0.6
 * Author: temegum
 * Author URI: http://themegum.com
 * Domain Path: /languages/
 * Text Domain: nuno-builder-addon
 */

class Gum_Nuno_Builder_Addon{

	function __construct() {

        define('GUM_BUILDER_BASENAME',dirname(plugin_basename(__FILE__)));
        define('GUM_BUILDER_DIR',plugin_dir_path(__FILE__));
        define('GUM_BUILDER_URL', plugins_url( '/nuno-builder-addon/'));


        load_plugin_textdomain('nuno-builder-addon', false, GUM_BUILDER_BASENAME. '/languages/');

        if(!function_exists('is_plugin_active')){
      		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
      	}


      	if(is_plugin_active('nuno-builder/nuno-builder.php')){
                   
      			add_action('init', array($this,'init'),999);
      	}
      	else{
      			add_action( 'admin_notices', array( $this, 'deactive_notice'), 10 );
	      		$this->deactive();
      	}

	}

	public function init(){

    $wp_filesystem=new WP_Filesystem_Direct(array());

    if($dirlist=$wp_filesystem->dirlist(GUM_BUILDER_DIR."elements")){

          foreach ($dirlist as $dirname => $dirattr) {
             if($dirattr['type']=='f' && preg_match("/(\.php)$/", $dirname) ){
                require_once(GUM_BUILDER_DIR."elements/".$dirname);
              }


          }
    }


    wp_enqueue_style( 'gum-nuno-style', GUM_BUILDER_URL. '/css/style.css');


	}

	function deactive_notice(){

		echo "<div class='error'>" .  esc_html__( 'Nuno Page Builder Addon deactivated. The plugin need Nuno Page Builder plugin, please install Nuno Builder plugin first.' ,'gum-nuno-builder-addon'). "</div>";

	}

	function deactive(){
		deactivate_plugins( array('nuno-builder-addon/nuno-builder-addon.php'), true, is_network_admin() );
	}

}

$Nuno_Builder_Addon= new Gum_Nuno_Builder_Addon();