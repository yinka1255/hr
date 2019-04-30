<?php
/**
 * Fancy Text Box Template Style Three
 *
 * @package Radiantthemes
 */

$output .= '<div class="holder matchHeight ' . esc_attr( $fancy_css ) . '">';
$output .= '<div class="title">';
$output .= '<div class="pic">';
$img     = wp_get_attachment_image_src( $shortcode['image_url'], 'large' );
$output .= '<img src="' . $img[0] . '" alt="' . esc_attr( $shortcode['title'] ) . '" width="' . $img[2] . '" height="' . $img[1] . '"/>';
$output .= '</div>';

if ( strlen( $url['url'] ) > 0 ) {
		$output .= '<' . $shortcode['fancy_tag'] . ' ' . $class . ' ' . $style . ' ><a  href="' . esc_attr( $url['url'] ) . '" ' . $rel . ' title="' . esc_attr( $url['title'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . esc_attr( $shortcode['title'] ) . '</a></' . $shortcode['fancy_tag'] . '>';

} else {
	$output .= '<' . $shortcode['fancy_tag'] . ' ' . $class . ' ' . $style . ' >' . esc_attr( $shortcode['title'] ) . '</' . $shortcode['fancy_tag'] . '>';
}
$output .= '</div>';
$output .= '<div class="clearfix"></div>';
$output .= '<div class="data">';
$output .= '<p>' . wp_kses_post( $shortcode['fancy_content'] ) . '</p>';
$output .= '</div>';
if ( $shortcode['add_button'] ) {
	$output .= '<div class="more">';
	if ( strlen( $url['url'] ) > 0 ) {
		$output .= '<a class="btn" href="' . esc_attr( $url['url'] ) . '" ' . $rel . ' title="' . esc_attr( $url['title'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">';
	}
	$output .= esc_attr( $shortcode['button_title'] );
	if ( strlen( $url['url'] ) > 0 ) {
		$output .= '</a>';
	}
	$output .= '</div>';
}
$output .= '</div>';
