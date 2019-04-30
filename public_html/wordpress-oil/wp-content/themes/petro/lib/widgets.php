<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

/**
 * widget render
 * @since Petro 1.0.0
*/ 

// tag cloud
function petro_widget_tag_cloud_args($args=array()){

	$args['smallest']=12;
	$args['largest']=12;
	$args['unit']="px";
	$args['number']= isset($args['number']) ? $args['number'] : 10;
	$args['orderby']="rand";

	return $args;
}

add_filter( 'widget_tag_cloud_args','petro_widget_tag_cloud_args');


// calendar widget 
function petro_calendar_widget($content=""){
  $pattern = get_shortcode_regex(array('calendar'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
     
	    $atts = shortcode_parse_atts( $matches[3] );

		$type = \'WP_Widget_Calendar\';
		$args = array(
			\'before_widget\' => \'<div class="widget widget_calendar">\',
			\'after_widget\' => \'</div>\',
			\'before_title\' => \'<div class="h6 widget-title">\',
			\'after_title\' => \'</div>\'
			);

		ob_start();
		the_widget( $type, $atts, $args );
		$content = ob_get_clean();

	    return $content;
    ')
    ,
    $content);

  return $content;
}


// add tag cloud function

function petro_tag_cloud($content=""){

  $pattern = get_shortcode_regex(array('tags'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
      
	    $atts = shortcode_parse_atts( $matches[3] );

		$type = \'WP_Widget_Tag_Cloud\';
		$args = array(
			\'before_widget\' => \'<div class="widget widget_tag_cloud">\',
			\'after_widget\' => \'</div>\',
			\'before_title\' => \'<div class="h6 widget-title">\',
			\'after_title\' => \'</div>\'
			);

		ob_start();
		the_widget( $type, $atts, $args );
		$content = ob_get_clean();

	    return $content;
    '),
    $content);

  return $content;
}

/** petro Optin **/

class petro_Optin extends WP_Widget{

	function __construct() {
		$widget_ops = array('classname' => 'petro_optin', 'description' => esc_html__( "Display optin form from newsletter engine like mailchimp",'petro') );
		parent::__construct('petro_optin', esc_html__('Optin Form','petro'), $widget_ops);

		$this->alt_option_name = 'petro_optin';

	}

	function widget($args, $instance){

		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'petro_optin', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}
		
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : "";
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$layout = array_key_exists('layout',$instance) ?  sanitize_text_field( $instance['layout'] ) : '';
		$show_name = array_key_exists('show_name',$instance) ?  absint( $instance['show_name'] ) : '';
		$before_form = array_key_exists('before_form',$instance) ?   $instance['before_form'] : '';
		$after_form = array_key_exists('after_form',$instance) ?   $instance['after_form'] : '';
		$optin_form = array_key_exists('optin_form',$instance) ?   $instance['optin_form'] : '';


		ob_start();
		
		echo wp_kses_post($before_widget); 
		if ( $title ) echo wp_kses_post($before_title . $title . $after_title);?>
<div class="optin-body">
	<?php print esc_js($before_form);?>

<form class="optin-form <?php print ($layout=='horizontal') ? "form-inline":"";?>" method="post">
  <div class="form-group">
    <input type="email" class="form-control"  name="optin_email" placeholder="<?php esc_html_e( 'enter your email','petro' );?>" />
  </div><?php if($show_name):?><div class="form-group">
    <input type="text" class="form-control"  name="optin_name" placeholder="<?php esc_html_e( 'enter your name','petro' );?>" />
  </div><?php endif;?><div class="form-group">
	  <button type="submit" class="btn optin-submit"><i class="fa fa-envelope"></i></button>
	</div>
	<?php wp_nonce_field( 'petro_optin', 'petro-optin-nonce' ); ?>
</form>
	<?php print esc_js($after_form);?>
	<div class="optin-code">
		<?php print ent2ncr($optin_form);?>
	</div>
</div>
		<?php echo wp_kses_post($after_widget);

		


		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'petro_optin', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

 ?>
<?php
	}

	function form($instance){

		$title  = array_key_exists('title',$instance) ?  esc_attr( $instance['title'] ) : '';
		$layout = array_key_exists('layout',$instance) ?  sanitize_text_field( $instance['layout'] ) : '';
		$show_name = array_key_exists('show_name',$instance) ?  absint( $instance['show_name'] ) : '';
		$before_form = array_key_exists('before_form',$instance) ?   $instance['before_form'] : '';
		$after_form = array_key_exists('after_form',$instance) ?   $instance['after_form'] : '';
		$optin_form = array_key_exists('optin_form',$instance) ?   $instance['optin_form'] : '';


?>
		<p><label for="<?php print esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','petro'); ?></label>
		<input class="widefat" id="<?php print esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'layout' )); ?>"><?php esc_html_e( 'Layout:','petro'); ?></label>
			<select id="<?php print esc_attr($this->get_field_id( 'layout' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'layout' )); ?>" >
					<option value="vertical" <?php selected('vertical',$layout);?>><?php esc_html_e('Vertical','petro');?></option>
					<option value="horizontal" <?php selected('horizontal',$layout);?>><?php esc_html_e('Horizontal','petro');?></option>
			</select>
		</p>		
		<p><input id="<?php print esc_attr($this->get_field_id( 'show_name' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'show_name' )); ?>" type="checkbox" value="1" <?php checked(1,$show_name);?>/> 
		<label for="<?php print esc_attr($this->get_field_id( 'show_name' )); ?>"><?php esc_html_e( 'Show Name','petro'); ?></label>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'before_form' )); ?>"><?php esc_html_e( 'Text before form:','petro'); ?></label>
		<textarea class="widefat" id="<?php print esc_attr($this->get_field_id( 'before_form' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'before_form' )); ?>" rows="5"><?php echo esc_attr($before_form); ?></textarea>
		<?php esc_html_e('Simplae html allowed','petro');?>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'after_form' )); ?>"><?php esc_html_e( 'Text after form:','petro'); ?></label>
		<textarea class="widefat" id="<?php print esc_attr($this->get_field_id( 'after_form' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'after_form' )); ?>" rows="5"><?php echo esc_attr($after_form); ?></textarea>
		<?php esc_html_e('Simplae html allowed','petro');?>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'optin_form' )); ?>"><strong><?php esc_html_e( 'Optin code:','petro'); ?></strong></label>
		<textarea class="widefat" id="<?php print esc_attr($this->get_field_id( 'optin_form' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'optin_form' )); ?>" rows="5"><?php echo esc_attr($optin_form); ?></textarea>
		<?php esc_html_e('Put optin code from your provider, usualy strarting with form tag without javascript code.','petro');?>
		</p>
		
<?php


	}


}

/** Social Widget **/
class petro_Social extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'petro_widget_social', 'description' => esc_html__( "Display social icon link.",'petro') );
		parent::__construct('petro_social', esc_html__('Petro Social Icon','petro'), $widget_ops);
		$this->alt_option_name = 'petro_social';
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','petro' ); ?></label>
		<input class="widefat" id="<?php echo sanitize_title($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><?php esc_html_e( 'Social link define on Appearance > Theme Options > Social Link','petro'); ?></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}



	public function widget( $args, $instance ) {


		extract($args);
		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = $this->id;
		
	    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$widget_id = $args['widget_id'];
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';


	    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] :"";
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		echo wp_kses_post($before_widget);
		if ( $title ) {
			echo wp_kses_post($before_title . $title . $after_title);
		}


		echo petro_get_sociallinks(array('show_label'=>false));
  
        echo wp_kses_post($after_widget);
	}
}



add_filter( 'widget_text' ,'petro_calendar_widget');
add_filter( 'widget_text' ,'petro_tag_cloud');
add_filter( 'widget_text' ,'petro_column_tag');
add_filter( 'widget_text', 'do_shortcode' );

function petro_widget_title_empty($title='', $instance=array() ){

	if(isset($instance['title']) && $instance['title']=='') return '';

	return $title;
}

add_filter( 'widget_title', 'petro_widget_title_empty',999,2);

// image caption

function petro_shortcode_atts_caption($atts){

	$atts['caption'] = "<span class=\"caption-wrapper\">".$atts['caption']."</span>";
	return $atts;
}

add_filter('shortcode_atts_caption','petro_shortcode_atts_caption');


function petro_register_widgets(){
	 register_widget('petro_Social');
	 register_widget('petro_Optin');
}

// widget init
add_action('widgets_init', 'petro_register_widgets',1);

?>
