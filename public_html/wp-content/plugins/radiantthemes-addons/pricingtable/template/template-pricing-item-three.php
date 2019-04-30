<?php
/**
 * Template Style Three Pricing Table
 *
 * @package Radiantthemes
 */

$output .= '<div class="holder">';
$output .= '<div class="title">';
$output .= '<h4>' . $shortcode['title'] . '</h4>';
$output .= '<h5><strong>' . $shortcode['currency'] . '</strong> ' . $shortcode['period'] . '</h5>';
$output .= '</div>';
$output .= '<div class="list"><p>' . $content . '</div>';
$output .= '<div class="data">';
$output .= '<a class="btn" href="' . $shortcode['button_link'] . '">' . $shortcode['button'] . '</a>';
$output .= '<a class="btn-hover" href="' . $shortcode['button_link'] . '"><i class="fa fa-arrow-right"></i></a>';
$output .= '</div>';
$output .= '</div>';
