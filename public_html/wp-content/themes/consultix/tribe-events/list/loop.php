<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php
global $post;
global $more;
$more = false;
?>

<!-- radiantthemes-event-list -->
<div class="radiantthemes-event-list">
	<?php while ( have_posts() ) : the_post(); ?>
		<!-- Month / Year Headers -->
		<?php tribe_events_list_the_date_headers(); ?>
		<?php
		$post_parent = '';
		if ( $post->post_parent ) {
			$post_parent = ' data-parent-post-id="' . absint( $post->post_parent ) . '"';
		}
		?>
		<!-- radiantthemes-event-list-item -->
		<div id="post-<?php the_ID() ?>" class="radiantthemes-event-list-item <?php tribe_events_event_classes() ?>" <?php echo esc_attr( $post_parent ); ?>>
			<?php
			$event_type = tribe( 'tec.featured_events' )->is_featured( $post->ID ) ? 'featured' : 'event';
			/**
			 * Filters the event type used when selecting a template to render
			 *
			 * @param $event_type
			 */
			$event_type = apply_filters( 'tribe_events_list_view_event_type', $event_type );
			tribe_get_template_part( 'list/single', $event_type );
			?>
		</div>
		<!-- radiantthemes-event-list-item -->
	<?php endwhile; ?>
</div>
<!-- radiantthemes-event-list -->
