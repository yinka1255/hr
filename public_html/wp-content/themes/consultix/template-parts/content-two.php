<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Consultix
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'style-two' ); ?>>
	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail">
			<img src="<?php echo esc_url( get_parent_theme_file_uri( '/images/no-image-found-260x200.png' ) ); ?>" alt="<?php esc_html_e( 'no image found', 'consultix' ); ?>" width="370" height="190">
			<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
				<a class="placeholder" href="<?php the_permalink(); ?>" style="background-image:url(<?php the_post_thumbnail_url( 'full' ); ?>);"></a>
			<?php endif; ?>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>
	<div class="entry-main matchHeight">
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header><!-- .entry-header -->
		<div class="post-meta">
			<span><i class="fa fa-user-o"></i> <?php echo get_the_author_link(); ?></span>
			<span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span>
		</div><!-- .post-meta -->
		<div class="entry-content">
				<?php echo wp_kses_post( substr( strip_tags( get_the_excerpt() ), 0, 100 ) . '...' ); ?>
		</div><!-- .entry-content -->
	</div><!-- .entry-main -->
	<div class="post-read-more">
		<a class="btn" href="<?php the_permalink(); ?>"><span><?php esc_html_e( 'Read More', 'consultix' ); ?></span></a>
	</div><!-- .post-read-more -->
</article><!-- #post-## -->