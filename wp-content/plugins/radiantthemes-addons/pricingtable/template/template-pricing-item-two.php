<?php
/**
 * Template Style Two Pricing Table
 *
 * @package Radiantthemes
 */

$output .= '<div class="holder">';
$output .= '<div class="title">';
$output .= '<h4>' . $shortcode['title'] . '</h4>';
$output .= '<h5>' . $shortcode['currency'] . ' ' . $shortcode['period'] . '</h5>';
$output .= '</div>';
$output .= '<div class="list matchHeight"><p>' . $content . '</div>';
$output .= '<div class="data">';
$output .= '<a class="btn" href="' . $shortcode['button_link'] . '">' . $shortcode['button'] . '<i class="fa fa-arrow-right"></i></a>';
$output .= '</div>';
$output .= '</div>';
