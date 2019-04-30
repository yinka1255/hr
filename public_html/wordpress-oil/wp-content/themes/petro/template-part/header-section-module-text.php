<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.0.0
 */

$old_text_module = petro_get_config( 'icon-text-module' , '');


if($old_text_module!=''){
	$content = $old_text_module;
}
else{

	$content = petro_get_config( 'text-module' , '');

}


if($content!=''):?>
<div class="module-text">
<?php print wp_kses_post($content);?>
</div>
<?php endif;?>
