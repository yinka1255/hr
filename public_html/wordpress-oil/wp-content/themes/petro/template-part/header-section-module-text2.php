<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

$content = petro_get_config( 'top-bar-text-2','');

if($content!=''):?>
<div class="module-text1">
<?php print wp_kses_post($content);?>
</div>
<?php endif;?>