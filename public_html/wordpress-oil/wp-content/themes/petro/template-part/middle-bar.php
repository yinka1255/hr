<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.0.0
 */


$old_bars_module = petro_get_config( 'icon-bars-module', false);


if(is_array($old_bars_module)){

	$middle_layout = array();

	foreach($old_bars_module as $module_name => $is_inable ){

		if($module_name == 'icon-graphic' && $is_inable ){
			$middle_layout['icongraphic'] = esc_html__( 'Icons Info', 'petro' );
		}

		if($module_name == 'social-icons' && $is_inable ){
			$middle_layout['social2'] = esc_html__( 'Social Icons 2 (Deprecated)','petro');
		}


		if($module_name == 'text-icons-bar' && $is_inable ){
			$middle_layout['text'] = esc_html__( 'Custom Text','petro');
		}

	}
}
else{

	$header_layout = petro_get_config( 'header-layout', array());
	$middle_layout = isset($header_layout['middle']) ? $header_layout['middle'] : false;
}


if(! $middle_layout ) return;


if(isset($middle_layout['placebo'])){
	unset($middle_layout['placebo']);
}
elseif(isset($middle_layout['fields'])){
	$middle_layout = $middle_layout['fields'];
}

if(! count($middle_layout) ) return;
?>

<div class="middle-bar-module heading-module logo">
  <?php get_template_part( 'template-part/logo'); ?>
</div>

<?php
$module_available = (bool)count($middle_layout);

?>
<?php foreach ($middle_layout as $layout_name => $layout_label) {	

	$layout_class = array('middle-bar-module','heading-module');
	$responsiv = petro_get_config( $layout_name.'-responsiveness', '');

	if($responsiv!=''){
		array_push( $layout_class, 'hidden-'.$responsiv);
	}

ob_start();
get_template_part( 'template-part/header-section-module', $layout_name);
$module_html = ob_get_clean();

print ($module_html!='') ? "<div class=\"".join(' ',$layout_class)."\">{$module_html}</div>" : '';

} ?>