<?php
/**
 * Template Style One Pricing Table
 *
 * @package Radiantthemes
 */

$output .= '<div class="holder">';
$output .= '<div class="title">';
$output .= '<h4>' . $shortcode['title'] . '</h4>';
$output .= '<h5>' . $shortcode['currency'] . '<span>/' . $shortcode['period'] . '</span>';
$output .= '</div>';
$output .= '<div class="list matchHeight"><p>' . $content . '</div>';
$output .= '<div class="data">';
$output .= '<a class="btn" href="' . $shortcode['button_link'] . '">' . $shortcode['button'] . '</a>';
$output .= '</div>';
$output .= '</div>';
