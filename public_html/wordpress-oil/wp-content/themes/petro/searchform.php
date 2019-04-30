<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */
?>
<form role="search" method="get" class="search-form" action="<?php print esc_url( home_url( '/' ) );?>">
	<div class="search">
		<input type="search" class="search-field" placeholder="<?php print esc_attr_x( 'Type and hit enter', 'label','petro' );?>" value="<?php print get_search_query();?>" name="s" title="<?php print esc_attr_x( 'Search for:', 'label', 'petro' );?>" /><i class="search-ico fa fa-search"></i>
	</div>
</form>