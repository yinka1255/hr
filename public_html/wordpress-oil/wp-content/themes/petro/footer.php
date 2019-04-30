<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

?>

			</div>
			<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
<?php get_template_part( 'template-part/footers'); ?>
</div>
<?php 

if(petro_get_config('slidingbar') && apply_filters('petro_show_slidingbar', petro_get_config('slidingbar') )):
 get_template_part( 'template-part/slidesidebar' );
endif; ?>

<div id="toTop"><span></span></div>
<?php wp_footer(); ?>
</body>
</html>