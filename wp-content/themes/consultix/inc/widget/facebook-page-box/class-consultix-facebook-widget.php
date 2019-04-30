<?php
/**
 * Adds a Facebook widget.
 *
 * @package Consultix
 */

/**
 * Class Definition.
 */
class Consultix_Facebook_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			// Base ID of your widget.
			'consultix_facebook_widget',
			// Widget name will appear in UI.
			esc_html__( 'Consultix Facebook Page Box', 'consultix' ),
			// Widget description.
			array(
				'description' => esc_html__( 'Widget for facebook box.', 'consultix' ),
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
		if ( ( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		$pageurl          = ( $instance['page-url'] ) ? $instance['page-url'] : esc_html__( 'https://www.facebook.com/facebook', 'consultix' );
		$pagetabsevents   = esc_attr( $instance['page-tabs-events'] );
		$pagetabsmessages = esc_attr( $instance['page-tabs-messages'] );
		$width            = ( $instance['width'] ) ? $instance['width'] : esc_html__( '340', 'consultix' );
		$height           = ( $instance['height'] ) ? $instance['height'] : esc_html__( '500', 'consultix' );
		$smallheader      = esc_attr( $instance['small_header'] );
		$acwidth          = esc_attr( $instance['adapt_container_width'] );
		$hidecover        = esc_attr( $instance['hide_cover'] );
		$showfacepile     = esc_attr( $instance['show_facepile'] );

		// This is where you run the code and display the output.
		?>
		<iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo esc_attr( $pageurl ); ?>&tabs=timeline,<?php echo esc_attr( $pagetabsevents ); ?>,<?php echo esc_attr( $pagetabsmessages ); ?>&width=<?php echo esc_attr( $width ); ?>&height=<?php echo esc_attr( $height ); ?>&small_header=<?php echo esc_attr( $smallheader ); ?>&adapt_container_width=<?php echo esc_attr( $acwidth ); ?>&hide_cover=<?php echo esc_attr( $hidecover ); ?>&show_facepile=<?php echo esc_attr( $showfacepile ); ?>" width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>"></iframe>

		<?php

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Widget Backend
	 *
	 * @param  [type] $instance description.
	 */
	public function form( $instance ) {
		$pageurl = ( $instance['page-url'] ) ? $instance['page-url'] : esc_html__( 'https://www.facebook.com/facebook', 'consultix' );
		if ( $instance ) {
			$pagetabsevents   = esc_attr( $instance['page-tabs-events'] );
			$pagetabsmessages = esc_attr( $instance['page-tabs-messages'] );
			$smallheader      = esc_attr( $instance['small_header'] );
			$acwidth          = esc_attr( $instance['adapt_container_width'] );
			$hidecover        = esc_attr( $instance['hide_cover'] );
			$showfacepile     = esc_attr( $instance['show_facepile'] );
		} else {
			$pagetabsevents   = '';
			$pagetabsmessages = '';
			$smallheader      = '';
			$acwidth          = '';
			$hidecover        = '';
			$showfacepile     = '';
		}
		$width  = ( $instance['width'] ) ? $instance['width'] : esc_html__( '340', 'consultix' );
		$height = ( $instance['height'] ) ? $instance['height'] : esc_html__( '500', 'consultix' );
		// Widget admin form.
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'page-url' ) ); ?>"><?php esc_html_e( 'Page URL:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page-url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page-url' ) ); ?>" type="url" value="<?php echo esc_attr( $pageurl ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'page-tabs' ) ); ?>"><?php esc_html_e( 'Tabs to render i.e. events, messages(timeline is default):', 'consultix' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'page-tabs-events' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page-tabs-events' ) ); ?>" type="checkbox" value="events" <?php checked( 'events', $pagetabsevents ); ?> />
			<label><?php esc_html_e( 'Events', 'consultix' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'page-tabs-messages' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page-tabs-messages' ) ); ?>" type="checkbox" value="messages" <?php checked( 'messages', $pagetabsmessages ); ?> />
			<label><?php esc_html_e( 'Messages', 'consultix' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Width:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Height:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>"><?php esc_html_e( 'Use the small header instead:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'small_header' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>" class="widefat">
				<?php
				$options = array( 'true', 'false' );
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $smallheader === $option ? ' selected="selected"' : '', '>', esc_attr( $option ), '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'adapt_container_width' ) ); ?>"><?php esc_html_e( 'Try to fit inside the container width:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'adapt_container_width' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'adapt_container_width' ) ); ?>" class="widefat">
				<?php
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $acwidth === $option ? ' selected="selected"' : '', '>', esc_attr( $option ), '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php esc_html_e( 'Hide cover photo in the header:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" class="widefat">
				<?php
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $hidecover === $option ? ' selected="selected"' : '', '>', esc_attr( $option ), '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_facepile' ) ); ?>"><?php esc_html_e( 'Show profile photos when friends like this:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'show_facepile' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'show_facepile' ) ); ?>" class="widefat">
				<?php
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $showfacepile === $option ? ' selected="selected"' : '', '>', esc_attr( $option ) , '</option>';
				}
				?>
			</select>
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
		$instance                          = array();
		$instance['page-url']              = ( ( $new_instance['page-url'] ) ) ? strip_tags(
			$new_instance['page-url']
		) : '';
		$instance['page-tabs-events']      = ( ( $new_instance['page-tabs-events'] ) ) ? strip_tags(
			$new_instance['page-tabs-events']
		) : '';
		$instance['page-tabs-messages']    = ( ( $new_instance['page-tabs-messages'] ) ) ? strip_tags(
			$new_instance['page-tabs-messages']
		) : '';
		$instance['width']                 = ( ( $new_instance['width'] ) ) ? strip_tags(
			$new_instance['width']
		) : '';
		$instance['height']                = ( ( $new_instance['height'] ) ) ? strip_tags(
			$new_instance['height']
		) : '';
		$instance['small_header']          = ( ( $new_instance['small_header'] ) ) ? strip_tags(
			$new_instance['small_header']
		) : '';
		$instance['adapt_container_width'] = ( ( $new_instance['adapt_container_width'] ) ) ? strip_tags(
			$new_instance['adapt_container_width']
		) : '';
		$instance['hide_cover']            = ( ( $new_instance['hide_cover'] ) ) ? strip_tags(
			$new_instance['hide_cover']
		) : '';
		$instance['show_facepile']         = ( ( $new_instance['show_facepile'] ) ) ? strip_tags(
			$new_instance['show_facepile']
		) : '';

		return $instance;
	}

}
/**
 * Register and load the widget
 */
function consultix_load_widget() {
	register_widget( 'Consultix_Facebook_Widget' );
}
add_action( 'widgets_init', 'consultix_load_widget' );
