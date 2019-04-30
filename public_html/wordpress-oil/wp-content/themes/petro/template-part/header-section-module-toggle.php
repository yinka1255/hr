<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.1.0
 */
$toggle = petro_get_config('toggle-icon','');
?>
<span class="slide-bar"><?php print ($toggle!='') ? '<i class="'.sanitize_html_class($toggle).'"></i>' : 'X';?></span>
