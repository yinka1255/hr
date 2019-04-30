<?php
/**
Plugin Name: RadiantThemes Custom Admin Login
Description: Customize Your WordPress Login Screen.
Version:     1.2.0
Author:      RadiantThemes
Author URI:  http://www.radiantthemes.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: radiantthemes-admin-login

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


add_action( 'login_enqueue_scripts', 'radiantthemes_modify_logo' );
add_action( 'login_head', 'radiantthemes_modify_logo' );

/**
 * Modify Login Logo Url
 */
function radiantthemes_home_login_url() {
	$url = esc_url( home_url( '/' ) );
	return $url;
}

/**
 * Modify Login Logo
 */
function radiantthemes_modify_logo() {
	if ( consultix_global_var( 'opt-logo-media', 'url', true ) ) {
		$logo       = esc_url( consultix_global_var( 'opt-logo-media', 'url', true ) );
		$hight      = esc_html( consultix_global_var( 'opt-logo-media', 'height', true ) );
		$logo_style = 'h1 a {background-image: url(' . $logo . ') !important; background-size:auto !important; width: auto !important; height:' . $hight . 'px !important; }';
			wp_enqueue_style(
				'radiantthemes-custom-login',
				plugin_dir_url( __FILE__ ) . 'css/radiantthemes-custom-login.css',
				array(),
				null
			);

		wp_add_inline_style( 'radiantthemes-custom-login', $logo_style );
	} else {
		$logo       = esc_url( get_parent_theme_file_uri( '/images/radiantthemes-logo.png' ) );
		$logo_style = 'h1 a {background-image: url(' . $logo . ') !important; background-size:auto !important; width: auto !important; }';
		wp_enqueue_style(
			'radiantthemes-custom-login',
			plugin_dir_url( __FILE__ ) . 'css/radiantthemes-custom-login.css',
			array(),
			null
		);
		wp_add_inline_style( 'radiantthemes-custom-login', $logo_style );
	}
	add_filter( 'login_headerurl', 'radiantthemes_home_login_url' );
}






/**
 * Activation Hook
 */
function radiantthemes_login() {
	// trigger our function that registers the custom post type.
	radiantthemes_modify_logo();
	radiantthemes_home_login_url();
	// clear the permalinks after the post type has been registered.
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'radiantthemes_login' );


/**
 * Deactivation Hook
 */
function radiantthemes_login_deactivation() {

	// clear the permalinks to remove our post type's rules.
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'radiantthemes_login_deactivation' );
