<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Consultix
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'style-three' ); ?>>
	<div class="row">
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 matchHeight">
			<div class="post-thumbnail">
				<img src="<?php echo esc_url( get_parent_theme_file_uri( '/images/no-image-found-360x260.png' ) ); ?>" alt="<?php esc_html_e( 'no image found', 'consultix' ); ?>" width="370" height="190">
				<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
					<div class="placeholder">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
					</div>
				<?php endif; ?>
			</div><!-- .post-thumbnail -->
		</div>
		<?php } ?>
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 matchHeight">
		<?php } else { ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php } ?>
			<div class="table entry-main">
				<div class="table-cell">
					<div class="post-meta">
						<span><i class="fa fa-user-o"></i> <?php echo get_the_author_link(); ?></span>
						<span><i class="fa fa-th-large"></i>
							<?php
							$category_detail = get_the_category( get_the_id() );
							$result          = '';
							foreach ( $category_detail as $item ) :
								$category_link = get_category_link( $item->cat_ID );
								$result       .= '<a href = "' . esc_url( $category_link ) . '">' . $item->name . '</a>, ';
							endforeach;
							$trimmed = rtrim( $result, ', ' );
							echo wp_kses_post( $trimmed );
							?>
						</span>
						<span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span>
					</div><!-- .post-meta -->
					<header class="entry-header">
						<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
					</header><!-- .entry-header -->
					<div class="entry-content">
							<?php echo wp_kses_post( substr( strip_tags( get_the_excerpt() ), 0, 100 ) . '...' ); ?>
					</div><!-- .entry-content -->
					<div class="post-read-more">
						<a class="btn" href="<?php the_permalink(); ?>"><span><?php esc_html_e( 'Read More', 'consultix' ); ?></span></a>
					</div><!-- .post-read-more -->
				</div>
			</div><!-- .entry-main -->
		</div>
	</div>
</article><!-- #post-## -->