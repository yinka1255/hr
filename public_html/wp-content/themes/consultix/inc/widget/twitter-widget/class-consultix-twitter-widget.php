<?php
/**
 * Adds a Twitter widget.
 *
 * @package Consultix
 */

/**
 * Class Definition.
 */
class Consultix_Twitter_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			// Base ID of your widget.
			'consultix_twitter_widget',
			// Widget name will appear in UI.
			esc_html__( 'Consultix Twitter Widget', 'consultix' ),
			// Widget description.
			array(
				'description' => esc_html__( 'Widget for twitter box.', 'consultix' ),
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
		$username    = ( $instance['username'] ) ? $instance['username'] : esc_html__( 'twitter', 'consultix' );
		$maxtweets   = ( $instance['maxtweets'] ) ? $instance['maxtweets'] : esc_html__( '5', 'consultix' );
		$enablelinks = esc_attr( $instance['enablelinks'] );
		$showuser    = esc_attr( $instance['showuser'] );
		$showtime    = esc_attr( $instance['showtime'] );
		$showimages  = esc_attr( $instance['showimages'] );
		// This is where you run the code and display the output.
		?>
		<?php $random_id = substr( md5( microtime() ), 0, 40 ); ?>
		<div id="<?php echo esc_attr( $random_id ); ?>" class="rt-twitter-box" data-twitter-box-username="<?php echo esc_attr( $username ); ?>" data-twitter-box-maxtweets="<?php echo esc_attr( $maxtweets ); ?>" data-twitter-box-enablelinks="<?php echo esc_attr( $enablelinks ); ?>" data-twitter-box-showuser="<?php echo esc_attr( $showuser ); ?>" data-twitter-box-showtime="<?php echo esc_attr( $showtime ); ?>" data-twitter-box-showimages="<?php echo esc_attr( $showimages ); ?>">
		</div>

		<?php

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Widget Backend
	 *
	 * @param  [type] $instance description.
	 */
	public function form( $instance ) {
		$username  = ( $instance['username'] ) ? $instance['username'] : esc_html__( 'twitter', 'consultix' );
		$maxtweets = ( $instance['maxtweets'] ) ? $instance['maxtweets'] : esc_html__( '5', 'consultix' );
		if ( $instance ) {
			$enablelinks = esc_attr( $instance['enablelinks'] );
			$showuser    = esc_attr( $instance['showuser'] );
			$showtime    = esc_attr( $instance['showtime'] );
			$showimages  = esc_attr( $instance['showimages'] );
		} else {
			$enablelinks = '';
			$showuser    = '';
			$showtime    = '';
			$showimages  = '';
		}
		// Widget admin form.
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'maxtweets' ) ); ?>"><?php esc_html_e( 'No. of Maximum Tweets:', 'consultix' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'maxtweets' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'maxtweets' ) ); ?>" type="number" value="<?php echo esc_attr( $maxtweets ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'enablelinks' ) ); ?>"><?php esc_html_e( 'Enable Links:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'enablelinks' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'enablelinks' ) ); ?>" class="widefat">
				<?php
				$options = array( 'true', 'false' );
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $enablelinks === $option ? ' selected="selected"' : '', '>', esc_attr( $option ), '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'showuser' ) ); ?>"><?php esc_html_e( 'Show User:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'showuser' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'showuser' ) ); ?>" class="widefat">
				<?php
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $showuser === $option ? ' selected="selected"' : '', '>', esc_attr( $option ), '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'showtime' ) ); ?>"><?php esc_html_e( 'Show Time:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'showtime' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'showtime' ) ); ?>" class="widefat">
				<?php
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $showtime === $option ? ' selected="selected"' : '', '>', esc_attr( $option ), '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'showimages' ) ); ?>"><?php esc_html_e( 'Show Images:', 'consultix' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'showimages' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'showimages' ) ); ?>" class="widefat">
				<?php
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option ) . '" id="' . esc_attr( $option ) . '"', $showimages === $option ? ' selected="selected"' : '', '>', esc_attr( $option ), '</option>';
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
		$instance                = array();
		$instance['username']    = ( ( $new_instance['username'] ) ) ? strip_tags(
			$new_instance['username']
		) : '';
		$instance['maxtweets']   = ( ( $new_instance['maxtweets'] ) ) ? strip_tags(
			$new_instance['maxtweets']
		) : '';
		$instance['enablelinks'] = ( ( $new_instance['enablelinks'] ) ) ? strip_tags(
			$new_instance['enablelinks']
		) : '';
		$instance['showuser']    = ( ( $new_instance['showuser'] ) ) ? strip_tags(
			$new_instance['showuser']
		) : '';
		$instance['showtime']    = ( ( $new_instance['showtime'] ) ) ? strip_tags(
			$new_instance['showtime']
		) : '';
		$instance['showimages']  = ( ( $new_instance['showimages'] ) ) ? strip_tags(
			$new_instance['showimages']
		) : '';

		return $instance;
	}

}
/**
 * Register and load the widget
 */
function consultix_twitter_load_widget() {
	register_widget( 'Consultix_Twitter_Widget' );
}
add_action( 'widgets_init', 'consultix_twitter_load_widget' );
