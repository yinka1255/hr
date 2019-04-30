<?php
/**
 * Day View Loop
 * This file sets up the structure for the day loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/loop.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php

global $more, $post, $wp_query;
$more = false;
$current_timeslot = null;

?>

<!-- radiantthemes-event-day -->
<div class="radiantthemes-event-day">
    <div class="row">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        		<!-- radiantthemes-event-day-item -->
        		<div id="post-<?php the_ID(); ?>" class="radiantthemes-event-day-item matchHeight <?php tribe_events_event_classes(); ?>">
        			<?php
        			$event_type = tribe( 'tec.featured_events' )->is_featured( $post->ID ) ? 'featured' : 'event';
        
        			/**
        			 * Filters the event type used when selecting a template to render
        			 *
        			 * @param $event_type
        			 */
        			$event_type = apply_filters( 'tribe_events_day_view_event_type', $event_type );
        			tribe_get_template_part( 'day/single', $event_type );
        			?>
        		</div>
        		<!-- radiantthemes-event-day-item -->
    		</div>
        <?php endwhile; ?>
    </div>
</div>
<!-- radiantthemes-event-day -->
