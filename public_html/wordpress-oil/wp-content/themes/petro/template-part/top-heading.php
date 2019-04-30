<?php
defined('ABSPATH') or die();
/**
 *
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

?>
<div  class="top-heading ">
<?php
if(petro_get_config('show_top_bar',true)){
	get_template_part( 'template-part/top-bar'); 
}

$responsiveness = petro_get_config( 'middle-responsiveness', 'xs');
$widemode = petro_get_config('middle-layout-mode','');

$middle_class = array('middle-section-header');


if($responsiveness!=''){
	array_push( $middle_class, 'hidden-'.$responsiveness);
}

if($widemode!=''){
	array_push( $middle_class, $widemode);
}

?>
<div class="<?php print join(' ',$middle_class);?>">
<div class="container">
	<div class="middle-section-inner"><?php get_template_part( 'template-part/middle-bar'); ?></div>
</div>
</div>

<?php if(petro_get_config('show_bottom_section',true)):
$hangdown = petro_get_config('bottom-layout-indent', 'half');
?>
<div class="bottom-section-header <?php print ($hangdown!='') ? 'hang-down-'.$hangdown.' ':''; print petro_get_config('bottom-layout-mode','');?>">
<div class="container">
	<div class="bottom-section-inner"><?php get_template_part( 'template-part/bottom-bar'); ?></div>  
</div>
</div>
<?php endif;?>
</div>