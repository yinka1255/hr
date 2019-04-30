<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Consultix
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'style-one' ); ?>>
	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail">
			<img src="<?php echo esc_url( get_parent_theme_file_uri( '/images/no-image-found-360x250.png' ) ); ?>" alt="<?php esc_html_e( 'no image found', 'consultix' ); ?>" width="370" height="190">
			<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
				<div class="placeholder">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
				</div>
			<?php endif; ?>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>
	<div class="entry-main matchHeight">
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php echo wp_kses_post( substr( strip_tags( get_the_excerpt() ), 0, 100 ) . '...' ); ?>
		</div><!-- .entry-content -->
	</div><!-- .entry-main -->
	<div class="post-meta">
		<span><i class="fa fa-user-o"></i> <?php echo get_the_author_link(); ?></span>
		<span><i class="fa fa-comments-o"></i> <?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></span>
	</div><!-- .post-meta -->
</article><!-- #post-## -->
