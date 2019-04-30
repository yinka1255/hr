<?php
/**
 * Day View Single Event
 * This file contains one event in the day view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/day/single-event.php
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

?>

<!-- radiantthemes-event-day-item-pic -->
<div class="radiantthemes-event-day-item-pic">
    <img src="<?php echo get_template_directory_uri(); ?>/images/blank/blank-image-100x60.jpg" alt="<?php echo esc_attr__( 'blank image', 'consultix' ); ?>" width="100" height="60">
    <div class="holder" style="background-image:url(<?php the_post_thumbnail_url('full'); ?>);"></div>
    <div class="overlay">
        <div class="table">
            <div class="table-cell">
                <a class="btn" href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark"><?php esc_html_e( 'View Event', 'consultix' ) ?></a>
            </div>
        </div>
    </div>
</div>
<!-- radiantthemes-event-day-item-pic -->
<!-- radiantthemes-event-day-item-data -->
<div class="radiantthemes-event-day-item-data">
    <h3><a href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
    <ul class="event-list-meta">
		<li class="city"><i class="fa fa-map-marker"></i> <?php echo tribe_get_venue(); ?></li>
		<li class="date"><i class="fa fa-clock-o"></i> <?php echo tribe_get_start_date( null, false, 'M' ); ?> <?php echo tribe_get_start_date( null, false, 'd' ); ?>, <?php echo tribe_get_start_date( null, false, 'Y' ); ?></li>
    </ul>
</div>
<!-- radiantthemes-event-day-item-data -->
