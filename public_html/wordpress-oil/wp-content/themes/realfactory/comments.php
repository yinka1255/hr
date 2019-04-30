<?php
/**
 * The template for displaying comments
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="realfactory-comments-area">
<?php 
	// print comment response
	if( have_comments() ){

		// comment head
		echo '<div class="realfactory-comments-title" >';
		$comment_number = get_comments_number();
		if( $comment_number > 1 ){
			printf(esc_html__('%s Responses', 'realfactory'), number_format_i18n($comment_number));
		}else{ 
			printf(esc_html__('%s Response', 'realfactory'), number_format_i18n($comment_number));
		}
		echo '</div>'; // realfactory-comments-title
		
		the_comments_navigation();
		echo '<ol class="comment-list">';
		wp_list_comments(array(
			'style'       => 'ol',
			'short_ping'  => true,
			'avatar_size' => 90,
			'callback' 	  => 'realfactory_comment_list'
		));
		echo '</ol>';
		the_comments_navigation();

	} 

	// print comment form
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');	
	
	$args = array(
		'id_form'           => 'commentform',
		'id_submit'         => 'submit',
		'title_reply'       => esc_html__('Leave a Reply', 'realfactory'),
		'title_reply_to'    => esc_html__('Leave a Reply to %s', 'realfactory'),
		'cancel_reply_link' => esc_html__('Cancel Reply', 'realfactory'),
		'label_submit'      => esc_html__('Post Comment', 'realfactory'),
		'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title realfactory-content-font">',
		'title_reply_after'  => '</h4>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',

		'must_log_in' => '<p class="must-log-in">' .
			sprintf( wp_kses(__('You must be <a href="%s">logged in</a> to post a comment.', 'realfactory'), array('a'=>array('href'=>array(),'title'=>array()))),
			wp_login_url(apply_filters( 'the_permalink', get_permalink())) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' .
			sprintf( wp_kses(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'realfactory'), array('a'=>array('href'=>array(),'title'=>array()))),
			admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink( ))) ) . '</p>',

		'fields' => apply_filters('comment_form_default_fields', array(
			'author' =>
				'<div class="comment-form-head"><div class="realfactory-comment-form-author" >' .
				'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
				'" placeholder="' . esc_attr(esc_html__('Name*', 'realfactory')) . '" size="30"' . $aria_req . ' /></div>',
			'email' => 
				'<div class="realfactory-comment-form-email" ><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" placeholder="' . esc_attr(esc_html__('Email*', 'realfactory')) . '" size="30"' . $aria_req . ' /></div>',
			'url' =>
				'<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) .
				'" placeholder="' . esc_attr(esc_html__('Website', 'realfactory')) . '" size="30" /><div class="clear"></div></div>'
		)),
		'comment_field' =>  '<div class="comment-form-comment">' .
			'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_attr(esc_html__('Comment*', 'realfactory')) . '" ></textarea></div>'
		
	);
	comment_form($args); 

?>
</div><!-- realfactory-comments-area -->