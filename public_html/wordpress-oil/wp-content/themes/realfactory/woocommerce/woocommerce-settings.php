<?php

	// declare woocommerce support
	add_action('after_setup_theme', 'realfactory_woocommerce_support');
	if( !function_exists( 'realfactory_woocommerce_support' ) ){
		function realfactory_woocommerce_support(){
			add_theme_support( 'woocommerce' );
		}
	}	

	// modify woocommerce wrapper
	remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	add_action('woocommerce_before_main_content', 'realfactory_woocommerce_wrapper_start', 10);
	if( !function_exists( 'realfactory_woocommerce_wrapper_start' ) ){
		function realfactory_woocommerce_wrapper_start(){
			echo '<div class="realfactory-content-container realfactory-container">';
			echo '<div class="realfactory-content-area realfactory-item-pdlr realfactory-sidebar-style-none clearfix" >';
		}
	}

	add_action('woocommerce_after_main_content', 'realfactory_woocomemrce_wrapper_end', 10);
	if( !function_exists( 'realfactory_woocomemrce_wrapper_end' ) ){
		function realfactory_woocomemrce_wrapper_end(){
			echo '</div>'; // realfactory-content-area
			echo '</div>'; // realfactory-content-container
		}
	}

	// remove breadcrumbs on single product
	add_action('wp', 'realfactory_init_woocommerce_hook');
	if( !function_exists( 'realfactory_init_woocommerce_hook' ) ){
		function realfactory_init_woocommerce_hook(){
			if( is_single() && get_post_type() == 'product' ){ 
				add_filter('woocommerce_product_description_heading', 'realfactory_remove_woocommerce_tab_heading');
				add_filter('woocommerce_product_additional_information_heading', 'realfactory_remove_woocommerce_tab_heading');

				remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
				remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
				remove_action('woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10);

				add_action('woocommerce_review_after_comment_text', 'woocommerce_review_display_rating', 10);
			}
		}
	}
	
	if( !function_exists( 'realfactory_remove_woocommerce_tab_heading' ) ){
		function realfactory_remove_woocommerce_tab_heading( $title ){
			return '';
		}
	}

	add_filter('woocommerce_review_gravatar_size', 'realfactory_woocommerce_review_gravatar_size');
	if( !function_exists( 'realfactory_woocommerce_review_gravatar_size' ) ){
		function realfactory_woocommerce_review_gravatar_size( $size ){
			return 120;
		}
	}

	if( !function_exists('realfactory_get_woocommerce_bar') ){
		function realfactory_get_woocommerce_bar(){

			global $woocommerce;
			
			if(!empty($woocommerce)){
				
				echo '<span class="realfactory-top-cart-count">' . $woocommerce->cart->cart_contents_count . '</span>';
				echo '<div class="realfactory-top-cart-hover-area" ></div>';

				echo '<div class="realfactory-top-cart-content-wrap" >';
				echo '<div class="realfactory-top-cart-content" >';
				echo '<div class="realfactory-top-cart-count-wrap" >';
				echo '<span class="head">' . esc_html__('Items : ', 'realfactory') . ' </span>';
				echo '<span class="realfactory-top-cart-count">' . $woocommerce->cart->cart_contents_count . '</span>'; 
				echo '</div>';
				
				echo '<div class="realfactory-top-cart-amount-wrap" >';
				echo '<span class="head">' . esc_html__('Subtotal :', 'realfactory') . ' </span>';
				echo '<span class="realfactory-top-cart-amount">' . $woocommerce->cart->get_cart_total() . '</span>';
				echo '</div>';
				
				echo '<a class="realfactory-top-cart-button" href="' . esc_url($woocommerce->cart->get_cart_url()) . '" >';
				echo esc_html__('View Cart', 'realfactory');
				echo '</a>';

				echo '<a class="realfactory-top-cart-checkout-button" href="' . esc_url($woocommerce->cart->get_checkout_url()) . '" >';
				echo esc_html__('Check Out', 'realfactory');
				echo '</a>';
				echo '</div>';
				echo '</div>';
			}
		}
	}

	add_filter('add_to_cart_fragments', 'gdlr_woocommerce_cart_ajax');
	if( !function_exists('gdlr_woocommerce_cart_ajax') ){
		function gdlr_woocommerce_cart_ajax($fragments){
			global $woocommerce;

			$fragments['span.realfactory-top-cart-count'] = '<span class="realfactory-top-cart-count">' . $woocommerce->cart->cart_contents_count . '</span>'; 
			$fragments['span.realfactory-top-cart-amount'] = '<span class="realfactory-top-cart-amount">' . $woocommerce->cart->get_cart_total() . '</span>';

			return $fragments;
		}
	}	