<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

?>

<div class="row">
    <!-- radiantthemes-event-list-item-pic -->
    <a class="radiantthemes-event-list-item-pic col-lg-3 col-md-3 col-sm-12 col-xs-12" style="background-image:url(<?php the_post_thumbnail_url('full'); ?>);" href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark">
        <div class="holder hidden-lg hidden-md visible-sm visible-xs">
            <?php the_post_thumbnail('large'); ?>
        </div>
    </a>
    <!-- radiantthemes-event-list-item-pic -->
    <!-- radiantthemes-event-list-item-data -->
    <div class="radiantthemes-event-list-item-data col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
        <div class="holder">
            <h3><a href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <?php echo tribe_events_get_the_excerpt( null, wp_kses_allowed_html( 'post' ) ); ?>
            <ul class="event-list-meta">
        		<li class="city"><i class="fa fa-map-marker"></i> <?php echo tribe_get_venue(); ?></li>
        		<li class="date"><i class="fa fa-calendar"></i> <?php echo tribe_get_start_date( null, false, 'M' ); ?> <?php echo tribe_get_start_date( null, false, 'd' ); ?>, <?php echo tribe_get_start_date( null, false, 'Y' ); ?></li>
        		<li class="time"><i class="fa fa-clock-o"></i> <?php echo tribe_get_start_date( null, false, 'h:i a' ); ?></li>
            </ul>
        </div>
    </div>
    <!-- radiantthemes-event-list-item-data -->
    <!-- radiantthemes-event-list-item-button -->
    <div class="radiantthemes-event-list-item-button col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="holder">
            <div class="table">
                <div class="table-cell">
                    <a class="btn" href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark">View Event</a>
                </div>
            </div>
        </div>
    </div>
    <!-- radiantthemes-event-list-item-button -->
</div>
