<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Consultix
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- wraper_error_main -->
		<div class="wraper_error_main">
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<!-- error_main -->
						<div class="error_main">
							<?php
							if ( consultix_global_var( 'error_custom_content_body', '', false ) ) {
									echo wp_kses_post( consultix_global_var( 'error_custom_content_body', '', false ) );
							} else {
							?>
							<div class="text-center">
								<h1>
									<strong>
										<?php esc_html_e( '404 ERROR!', 'consultix' ); ?>
									</strong>
									<?php esc_html_e( 'PAGE NOT FOUND', 'consultix' ); ?>
								</h1>
								<h2>
									<?php esc_html_e( 'We are sorry, the page you want to visit does not exist!', 'consultix' ); ?>
								</h2>
								<div class="clearfix"></div>
                                <a class="btn default" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php esc_html_e( 'Goto Home Page', 'consultix' ); ?></span></a>
							</div>
							<?php } ?>
						</div>
						<!-- error_main -->
					</div>
				</div>
				<!-- row -->
			</div>
		</div>
		<!-- wraper_error_main -->
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
