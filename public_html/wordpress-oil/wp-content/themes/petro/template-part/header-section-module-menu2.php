<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */


$menu_id = petro_get_config('top-bar-menu-2','');

if($menu_id=='' && $menu_id < 1) return;

$menuParams=array(
'menu' => $menu_id,
'echo' => false,
'container_class'=>'',
'container_id'=>'top-bar-menu-2',
'menu_class'=>'top-bar-menu',
'container'=>'',
'before' => '',
'after' => '',
'fallback_cb'=>false,
'walker'  => new mainmenu_walker(),
'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
);

  $menu2=wp_nav_menu($menuParams);

  if(!$menu2 || is_wp_error($menu2))
    return "";
	
print '<div class="module-menu">'.$menu2.'</div>';

?>
