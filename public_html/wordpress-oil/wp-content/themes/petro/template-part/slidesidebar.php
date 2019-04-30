<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 2.1.0
 */

$slidingbar_type = petro_get_config('slidingbar-type');

ob_start();

switch( $slidingbar_type ){
	case 'sidebar-widget':
		dynamic_sidebar('sidebar-widget');
		break;
	case 'page':

	$page_id = petro_get_config('slidingbar-page');
	$slide_html = petro_get_post_footer_page($page_id);

	print ($slide_html) ? $slide_html : '';
		break;
	default:
		dynamic_sidebar('slidingbar-widget');
	break;
}

$slidebar_content = ob_get_clean();

if($slidebar_content=='') return;

?>
<div class="slide-sidebar-overlay"></div>
	<?php 

	if(petro_get_config('show-toggle') && 'top'!= petro_get_config('slidingbar-position') ){

		$toggle_ico = petro_get_config('toggle-btn','fa-gear');
		$toggle_label= '<i class="'.$toggle_ico.'"></i>';

		$toggle_text = petro_get_config('toggle_text','');
		if($toggle_text!=''){
			$toggle_label.= '<span>'.esc_html($toggle_text).'</span>';
		}

		print '<div class="slide-bar slide-toggle"><div class="btn  btn-secondary slide-toggle-inner">'.$toggle_label.'</div></div>';

	}
	

?>
<div class="slide-sidebar-container">
	<div class="slide-sidebar-wrap clearfix">
		<?php 
			print wp_kses_post( $slidebar_content ) ;
		?>
	</div>
</div>
