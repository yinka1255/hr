<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 * @see /single/content-single-portfolio.php
 */

$post_id = get_the_ID();

$fields = petro_get_portfolio_fields();
$hide_date = petro_get_config('hide_date',0);
$hide_category = petro_get_config('hide_category',0);

?>
<ul class="portfolio-meta-info">
<?php if(!$hide_date):?>
	<li class="meta date-info"><label><?php esc_html_e('date','petro');?>:</label><?php the_date();?></li>
<?php endif;
if(!$hide_category && ($categories = get_the_term_list($post_id, 'tg_postcat','',", "))):?>
	<li class="meta categories-info"><label><?php esc_html_e('categories','petro');?>:</label><?php print ent2ncr($categories);?></li>
<?php endif;
	if(count($fields)){
		foreach($fields as $field_name => $field) {
			$value = get_post_meta( $post_id, '_'.$field_name , true );

			if($value=='' || $field_name=='download') continue;

$field['label'] =  function_exists('icl_t') ? icl_t('petro', sanitize_key($field['label']), $field['label'] ) : $field['label'] ;
			?><li class="meta <?php print sanitize_html_class($field_name);?>"><?php
if($field_name=='url'){
	print '<label>'.$field['label'].':</label><a href="'.esc_url($value).'">'.esc_html($value)."</a>";

}
else{
	print '<label>'.$field['label'].':</label>'.do_shortcode($value);
}
?></li><?php

		}
	}

?>
</ul>