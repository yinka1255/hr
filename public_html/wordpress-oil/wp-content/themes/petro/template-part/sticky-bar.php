<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.1.0
 */

$sticky_layout = petro_get_config( 'sticky-layout', array());
$modules = isset($sticky_layout['active']) ? $sticky_layout['active'] : array( "placebo" => "placebo", "mainmenu"=> esc_html__( 'Main Menu','petro'));


if(isset($modules['placebo'])){
	unset($modules['placebo']);
}
elseif(isset($modules['fields'])){
	$modules = $modules['fields'];
}

$module_available = (bool)count($modules);

?>
<?php

if( $module_available ){

?>
<?php foreach ($modules as $layout_name => $layout_label) {	

	ob_start();
	get_template_part( 'template-part/header-section-module', $layout_name);
	$module_html = ob_get_clean();

	print ($module_html!='') ? "<div class=\"heading-module\">{$module_html}</div>" : '';

	} 
}
?>