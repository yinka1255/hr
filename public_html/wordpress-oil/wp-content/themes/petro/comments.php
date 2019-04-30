<?php
defined('ABSPATH') or die();
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => false,
					'avatar_size' => 52,
					'walker'	=> new petro_Walker_Comment()
				) );
			?>
		</ol>
<?php
$is_rtl = is_rtl();
$pagination=paginate_comments_links( array(
	'type'=>'array',
	'echo'=>false,
	'prev_text'   => $is_rtl ? '<span>'.esc_html__('Previous Page','petro').'<i class="fa fa-angle-right"></i></span>' : '<span><i class="fa fa-angle-left"></i>'.esc_html__('Previous Page','petro').'</span>',
	'next_text'   => $is_rtl ? '<span><i class="fa fa-angle-left"></i>'.esc_html__('Next Page','petro').'</span>' : '<span>'.esc_html__('Next Page','petro').'<i class="fa fa-angle-right"></i></span>',
) );

if(!empty($pagination) && is_array($pagination)){?>		
		<div class="row">
			<div class="pagination number col-xs-12" dir="ltr">
				<ul><li>
<?php


	print join("</li>\n<li>",is_rtl()?array_reverse($pagination):$pagination);

?>				</li>
			</ul>
			</div>
		</div>
	<?php }

	endif; 
	if(comments_open()): ?>
	<div class="itemCommentsForm">
		<?php petro_comment_form(); ?>
	</div>
	<?php endif;?>
</div>