<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('newsletter', 'gdlr_core_pb_element_newsletter'); 
	
	if( !class_exists('gdlr_core_pb_element_newsletter') ){
		class gdlr_core_pb_element_newsletter{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_documents',
					'title' => esc_html__('Newsletter', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'spacing' => array(
						'title' => esc_html__('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							),					
						)
					),
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings, true);			
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// start printing item
				$extra_class = empty($settings['class'])? '': $settings['class'];
				$ret  = '<div class="gdlr-core-newsletter-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				
				// display
				if( !class_exists('NewsletterSubscription') ){
					$message = esc_html__('Please install and activate the "Newsletter" plugin to show the form.', 'goodlayers-core');
				}else if( $preview ){
					$message = '[newsletter_form]';
				}else{
					$ret .= gdlr_core_get_subscription_form();
				}
				if( !empty($message) ){
					$ret .= '<div class="gdlr-core-external-plugin-message">' . gdlr_core_escape_content($message) . '</div>';
				}
				
				$ret .= '</div>';
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_newsletter
	} // class_exists		

	// from newsletter/subscription/subscription.php
	if( !function_exists('gdlr_core_get_subscription_form') ){
		function gdlr_core_get_subscription_form(){

			$attrs = array();
	        $action = esc_attr(home_url('/') . '?na=s');
	        $options_profile = get_option('newsletter_profile');

	        $newsletter = NewsletterSubscription::instance();

	        $buffer  = $newsletter->get_form_javascript();

	        $buffer .= '<div class="newsletter newsletter-subscription">';
	        $buffer .= '<form class="gdlr-core-newsletter-form clearfix" method="post" action="' . esc_url($action) . '" onsubmit="return newsletter_check(this)">';
	        $buffer .= '<div class="gdlr-core-newsletter-email">';
	        $buffer .= '<input class="newsletter-email" placeholder="' . esc_html__('Your Email Address', 'goodlayers-core') . '" type="email" name="ne" size="30" required />';
	        $buffer .= '</div>';
	        $buffer .= '<div class="gdlr-core-newsletter-submit">';
	       	$buffer .= '<input class="newsletter-submit" type="submit" value="' . $options_profile['subscribe'] . '" />';
	        $buffer .= '</div>';
	        $buffer .= '</table>';
	        $buffer .= '</form>';
	        $buffer .= '</div>';

	        return $buffer;
	    }
    }