<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

$num_comment = get_comments_number();

$comment_msg= $num_comment ? sprintf( _n('%d comment','%d comments',$num_comment,'petro'), $num_comment) : esc_html__('no comment','petro');
?>
<ul class="post-meta-info">
	<?php if(($date_post = get_the_date())):?>
	<li class="meta date-info"><i class="fa fa-clock-o"></i><?php print ent2ncr($date_post);?></li>
	<?php endif;?>
	<li class="meta comment-info"><i class="fa fa-comment-o"></i><?php print ent2ncr($comment_msg);?></li>
</ul>