<?php
/**
 * Adds a Call to Action widget.
 *
 * @package Consultix
 */

/**
 * Class Definition.
 */
class Consultix_Call_To_Action_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			// Base ID of your widget.
			'consultix_call_to_action_widget',
			// Widget name will appear in UI.
			esc_html__( 'Consultix Call to Action', 'consultix' ),
			// Widget description.
			array(
				'description' => esc_html__( 'Call to Action area.', 'consultix' ),
			)
		);
	}

	/**
	 * Creating widget front-end
	 *
	 * @param  [type] $args     description.
	 * @param  [type] $instance description.
	 */
	public function widget( $args, $instance ) {
		// before and after widget arguments are defined by themes.
		echo wp_kses_post( $args['before_widget'] );
		if ( ( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		$call_to_action_title        = $instance['call-to-action-title'];
		$call_to_action_content      = $instance['call-to-action-content'];
		$call_to_action_button_title = $instance['call-to-action-button-title'];
		$call_to_action_button_link  = $instance['call-to-action-button-link'];

		// This is where you run the code and display the output.
		$output = '<h4>' . esc_html( $call_to_action_title ) . '</h4> <p>' . esc_html( $call_to_action_content ) . ' </p><a class="btn" href="' . esc_url( $call_to_action_button_link ) . '">' . esc_html( $call_to_action_button_title ) . ' </a> ';

		echo wp_kses_post( $output );

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Widget Backend.
	 *
	 * @param  [type] $instance description.
	 */
	public function form( $instance ) {
		$call_to_action_title        = ( $instance['call-to-action-title'] ) ? $instance['call-to-action-title'] : '';
		$call_to_action_content      = ( $instance['call-to-action-content'] ) ? $instance['call-to-action-content'] : '';
		$call_to_action_button_title = ( $instance['call-to-action-button-title'] ) ? $instance['call-to-action-button-title'] : '';
		$call_to_action_button_link  = ( $instance['call-to-action-button-link'] ) ? $instance['call-to-action-button-link'] : '';
		// Widget admin form.
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'call-to-action-title' ) ); ?>"><?php esc_html_e( 'Title:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'call-to-action-title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'call-to-action-title' ) ); ?>" type="text" value="<?php echo esc_attr( $call_to_action_title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'call-to-action-content' ) ); ?>"><?php esc_html_e( 'Description:', 'consultix' ); ?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'call-to-action-content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'call-to-action-content' ) ); ?>"><?php echo esc_textarea( $call_to_action_content ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'call-to-action-button-title' ) ); ?>"><?php esc_html_e( 'Button Title:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'call-to-action-button-title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'call-to-action-button-title' ) ); ?>" type="text" value="<?php echo esc_attr( $call_to_action_button_title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'call-to-action-button-link' ) ); ?>"><?php esc_html_e( 'Button Link:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'call-to-action-button-link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'call-to-action-button-link' ) ); ?>" type="text" value="<?php echo esc_attr( $call_to_action_button_link ); ?>" />
		</p>

		<?php
	}

	/**
	 * Updating widget replacing old instances with new.
	 *
	 * @param  [type] $new_instance description.
	 * @param  [type] $old_instance description.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                                = array();
		$instance['call-to-action-title']        = ( ( $new_instance['call-to-action-title'] ) ) ? strip_tags( $new_instance['call-to-action-title'] ) : '';
		$instance['call-to-action-content']      = ( ( $new_instance['call-to-action-content'] ) ) ? strip_tags( $new_instance['call-to-action-content'] ) : '';
		$instance['call-to-action-button-title'] = ( ( $new_instance['call-to-action-button-title'] ) ) ? strip_tags( $new_instance['call-to-action-button-title'] ) : '';
		$instance['call-to-action-button-link']  = ( ( $new_instance['call-to-action-button-link'] ) ) ? strip_tags( $new_instance['call-to-action-button-link'] ) : '';
		return $instance;
	}

}

/**
 * Register and load the widget
 */
function consultix_call_to_action_load_widget() {
	register_widget( 'Consultix_Call_To_Action_Widget' );
}

add_action( 'widgets_init', 'consultix_call_to_action_load_widget' );
