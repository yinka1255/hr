<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

$top_bar_layout = petro_get_config( 'top-bar-layout',false);

if(is_array($top_bar_layout)){

	if(isset($top_bar_layout['left']['placebo'])){
		unset($top_bar_layout['left']['placebo']);
	}

	if(isset($top_bar_layout['right']['placebo'])){
		unset($top_bar_layout['right']['placebo']);
	}

	$tobar_layout = array_merge($top_bar_layout['left'] , $top_bar_layout['right'] );

}
else{

	$header_layout = petro_get_config( 'header-layout', array());
	$tobar_layout = isset($header_layout['topbar']) ? $header_layout['topbar'] : false;
}

if(!$tobar_layout ) return;

if(isset($tobar_layout['placebo'])){
	unset($tobar_layout['placebo']);
}
elseif(isset($tobar_layout['fields'])){
	$tobar_layout = $tobar_layout['fields'];
}

if(! count($tobar_layout) ) return;

$modules_html = array();
?>
<?php
foreach ($tobar_layout as $layout_name => $layout_label) {	

$layout_class = array('top-bar-module','heading-module');
$responsiv = petro_get_config( $layout_name.'-responsiveness', '');

if($responsiv!=''){
	array_push( $layout_class, 'hidden-'.$responsiv);
}

ob_start();
get_template_part( 'template-part/header-section-module', $layout_name);
$module_html = ob_get_clean();

	if($module_html!=''){
	 $modules_html[] =  "<div class=\"".join(' ', $layout_class)."\">{$module_html}</div>";
	}
} 
if(count($modules_html)):
?><div class="top-bar <?php print petro_get_config('topbar-layout-mode','');?>">
	<div class="container">
		<div class="top-bar-inner">
<?php print join("", $modules_html);?>
		</div>
	</div>
</div><?php  endif; ?>