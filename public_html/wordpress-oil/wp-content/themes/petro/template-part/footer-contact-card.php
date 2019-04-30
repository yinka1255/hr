<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

$icon_boxes = petro_get_config('footer_icon_fields');

if(empty($icon_boxes) || (isset($icon_boxes[0]) && $icon_boxes[0]['label']=='' && $icon_boxes[0]['text']=='' )) return;
?>
<div class="footer-contact-card">
	<div class="container">
		<div class="row">
<?php foreach ($icon_boxes as $icon_box) {

$title= isset($icon_box['label']) ?  $icon_box['label'] : '';
$text= isset($icon_box['text']) ?  $icon_box['text'] : '';

if(function_exists('icl_t')){
	$title= icl_t('petro', sanitize_key( $title ), $title );
	$text= icl_t('petro', sanitize_key( $text ), $text );
}

?>
			<div class="col-sm-4 col-md-4">
				<div class="card">
					<?php if(isset($icon_box['icon']) && $icon_box['icon']!='') { print '<div class="icon"><i class="fa '.sanitize_html_class($icon_box['icon']).'"></i></div>';}?>
					<div class="body-content">
						<div class="heading"><?php print esc_html($title);?></div>
						<?php print wp_kses_post($text);?>
					</div>
				</div>
			</div>

<?php		}?>				
		</div>
	</div>
</div>