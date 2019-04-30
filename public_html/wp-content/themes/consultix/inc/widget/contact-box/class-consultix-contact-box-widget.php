<?php
/**
 * Adds a Contact widget.
 *
 * @package Consultix
 */

/**
 * Class Definition.
 */
class Consultix_Contact_Box_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			// Base ID of your widget.
			'consultix_contact_box_widget',
			// Widget name will appear in UI.
			esc_html__( 'Consultix Contact Box', 'consultix' ),
			// Widget description.
			array(
				'description' => esc_html__( 'Contact box for footer area.', 'consultix' ),
			)
		);
	}

	/**
	 * Creating widget front-end.
	 *
	 * @param  [type] $args     description.
	 * @param  [type] $instance description.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		// before and after widget arguments are defined by themes.
		echo wp_kses_post( $args['before_widget'] );
		/*if ( ( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		} */       
		$addressdata  = ( $instance['addressdata'] ) ? $instance['addressdata'] : esc_html__( '123 6th St. Melbourne, FL 32904', 'consultix' );
		$phonenumber  = ( $instance['phonenumber'] ) ? $instance['phonenumber'] : esc_html__( 'Phone: (888) 123-4567', 'consultix' );
		$emailid      = ( $instance['emailid'] ) ? $instance['emailid'] : esc_html__( 'Email: info@example.com', 'consultix' );

		// This is where you run the code and display the output.
		
		$output = '<ul class="contact">
							<li class="address">
								' . esc_html( $addressdata ) .
		'</li>
							<li class="phone">
								' . esc_html( $phonenumber ) .
		'</li>
							<li class="email">
								' . esc_html( $emailid ) .
		'</li>

						</ul>';

		echo wp_kses_post( $output );

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Widget Backend
	 *
	 * @param  [type] $instance description.
	 */
	public function form( $instance ) {
	    
		$addressdata  = ( $instance['addressdata'] ) ? $instance['addressdata'] : esc_html__( '123 6th St. Melbourne, FL 32904', 'consultix' );
		$phonenumber  = ( $instance['phonenumber'] ) ? $instance['phonenumber'] : esc_html__( 'Phone: (888) 123-4567', 'consultix' );
		$emailid      = ( $instance['emailid'] ) ? $instance['emailid'] : esc_html__( 'Email: info@example.com', 'consultix' );

		// Widget admin form.
		?>		

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'addressdata' ) ); ?>"><?php esc_html_e( 'Address:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'addressdata' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'addressdata' ) ); ?>" type="text" value="<?php echo esc_attr( $addressdata ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phonenumber' ) ); ?>"><?php esc_html_e( 'Phone Number:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phonenumber' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phonenumber' ) ); ?>" type="text" value="<?php echo esc_attr( $phonenumber ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'emailid' ) ); ?>"><?php esc_html_e( 'Email ID:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'emailid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'emailid' ) ); ?>" type="text" value="<?php echo esc_attr( $emailid ); ?>" />
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
		$instance                 = array();
		
		$instance['addressdata']  = ( ( $new_instance['addressdata'] ) ) ? strip_tags(
			$new_instance['addressdata']
		) : '';
		$instance['phonenumber']  = ( ( $new_instance['phonenumber'] ) ) ? strip_tags(
			$new_instance['phonenumber']
		) : '';
		$instance['emailid']      = ( ( $new_instance['emailid'] ) ) ? strip_tags(
			$new_instance['emailid']
		) : '';
		return $instance;
	}

}

/**
 * [consultix_contact_box_load_widget description]
 */
function consultix_contact_box_load_widget() {
	register_widget( 'Consultix_Contact_Box_Widget' );
}
add_action( 'widgets_init', 'consultix_contact_box_load_widget' );
