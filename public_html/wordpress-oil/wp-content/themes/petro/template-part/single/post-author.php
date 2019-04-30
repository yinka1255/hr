<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Petro
 * @since Petro 1.0.0
 */

$author_description = get_the_author_meta('description');

if(empty($author_description)) return;
?>
<div class="author-profile">
	<?php print get_avatar( get_the_author_meta( 'ID' ), 200 ,'','',array('class'=>'author-profile-image'));?>
    <div class="itemAuthorDetails">
      <div class="itemAuthorName h5">
      	<?php printf( wp_kses(__('author: %s','petro' ),array('a'=>array('href'=>array()))),petro_get_author_blog_url(false));?>
      </div>
      <div>
      	<?php print wp_kses_post($author_description);?>
      </div>
    </div>
</div>
<div class="clearfix"></div>