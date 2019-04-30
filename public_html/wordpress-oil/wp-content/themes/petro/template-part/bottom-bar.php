<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.0.0
 */


$show_search = petro_get_config('show_search');


if($show_search !=''){

	$bottom_layout = array('mainmenu'     => esc_html__( 'Main Menu','petro'));

	if((bool) $show_search){
		$bottom_layout['search'] = esc_html__( 'Search Bar','petro');
	}

}
else{

	$header_layout = petro_get_config( 'header-layout', array());
	$bottom_layout = isset($header_layout['bottom']) ? $header_layout['bottom'] : false;
}

if(! $bottom_layout ) return;

if(isset($bottom_layout['placebo'])){
	unset($bottom_layout['placebo']);
}
elseif(isset($bottom_layout['fields'])){
	$bottom_layout = $bottom_layout['fields'];
}

if(! count($bottom_layout) ) return;


?>
<?php foreach ($bottom_layout as $layout_name => $layout_label) {	

ob_start();
get_template_part( 'template-part/header-section-module', $layout_name);
$module_html = ob_get_clean();

print ($module_html!='') ? "<div class=\"bottom-bar-module heading-module\">{$module_html}</div>" : '';

} ?>