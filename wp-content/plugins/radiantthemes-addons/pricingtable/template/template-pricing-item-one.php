<?php
/**
 * Template Style One Pricing Table
 *
 * @package Radiantthemes
 */

$output .= '<div class="holder">';
$output .= '<div class="title">';
$output .= '<h4>' . $shortcode['title'] . '</h4>';
$output .= '</div>';
$output .= '<div class="list matchHeight"><p>' . $content . '</div>';
$output .= '<div class="data">';
$output .= '<h5><strong>' . $shortcode['currency'] . '</strong>' . $shortcode['period'] . '</h5>';
$output .= '<a class="btn" href="' . $shortcode['button_link'] . '">' . $shortcode['button'] . '<i class="fa fa-arrow-right"></i></a>';
$output .= '</div>';
$output .= '</div>';
