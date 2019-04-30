<?php
	/*	
	*	Goodlayers Page Builder
	*	---------------------------------------------------------------------
	*	File which creates page builder elements
	*	---------------------------------------------------------------------
	*/
	
	if( !class_exists('gdlr_core_page_option') ){
		
		class gdlr_core_page_option{
			
			// creating object
			private $settings = array();
			
			function __construct( $settings = array() ){
				
				$this->settings = wp_parse_args($settings, array(
					'slug' => 'gdlr-core-page-option',
					'post_type' => array('page'),
					'options' => array()
				));	
				
				// create custom meta box
				add_action('add_meta_boxes', array(&$this, 'init_page_option_meta_box'));
				
				// save custom metabox
				foreach( $this->settings['post_type'] as $post_type ){
					add_action('save_post_' . $post_type , array(&$this, 'save_page_option_meta_box'));
				}
				
				// add the script when opening the registered post type
				add_action('admin_enqueue_scripts', array(&$this, 'load_page_option_script') );
				
				// add page builder meta to revision
				gdlr_core_revision::add_field(array(
					'meta_key'=>$this->settings['slug'], 
					'meta_name'=>esc_html__('Page Options', 'goodlayers-core'),
					'callback'=>array(&$this, 'convert_page_option_revision_data')
				));
			}
			
			// function that enqueue page builder script
			function load_page_option_script( $hook ){
				if( $hook == 'post.php' && in_array(get_post_type(), $this->settings['post_type']) ){
					gdlr_core_html_option::include_script(array(
						'style' => 'html-option-small'
					));
				}
			}
			
			// function that creats page builder meta box
			function init_page_option_meta_box(){
				
				foreach( $this->settings['post_type'] as $post_type ){
					add_meta_box($this->settings['slug'], esc_html__('Page Options', 'goodlayers-core'),
						array(&$this, 'create_page_option_meta_box'),
						$post_type, 'normal', 'high' );	
				}
			}
			function create_page_option_meta_box( $post ){
				
				$page_option_value = get_post_meta($post->ID, $this->settings['slug'], true);

				// add nonce field to validate upon saving
				wp_nonce_field('gdlr_core_page_option', 'page_option_security');
				echo '<input type="hidden" class="gdlr-core-page-option-value" name="' . esc_attr($this->settings['slug']). '" value="' . esc_attr(json_encode($page_option_value)) . '" />';
				
				$this->get_option_head();

				echo '<div class="gdlr-core-page-option-content" >';
				$this->get_option_tab($page_option_value);
				echo '</div>';
			}

			// page option head
			function get_option_head(){

				echo '<div class="gdlr-core-page-option-head" >';
				echo '<div class="gdlr-core-page-option-head-title">';
				echo '<i class="fa fa-gears"></i>';
				echo esc_html__('Page Options', 'goodlayers-core');
				echo '</div>'; // gdlr-core-page-option-head-title
				echo '</div>';

			}

			// page option tab
			function get_option_tab($option_value){

				$active = true;
				echo '<div class="gdlr-core-page-option-tab-head" id="gdlr-core-page-option-tab-head" >';
				foreach( $this->settings['options'] as $tab_slug => $tab_options ){
					echo '<div class="gdlr-core-page-option-tab-head-item ' . ($active? 'gdlr-core-active': '') . '" data-tab-slug="' . esc_attr($tab_slug) . '" >';
					echo gdlr_core_escape_content($tab_options['title']);
					echo '</div>'; // gdlr-core-page-option-tab-head-item

					$active = false;
				}
				echo '</div>'; // gdlr-core-page-option-tab-head

				$active = true;
				echo '<div class="gdlr-core-page-option-tab-content" id="gdlr-core-page-option-tab-content" >';
				foreach( $this->settings['options'] as $tab_slug => $tab_options ){
					echo '<div class="gdlr-core-page-option-tab-content-item ' . ($active? 'gdlr-core-active': '') . '" data-tab-slug="' . esc_attr($tab_slug) . '" >';
					foreach( $tab_options['options'] as $option_slug => $option ){
						$option['slug'] = $option_slug;
						if( !empty($option['single']) ){
							$option['value'] = get_post_meta($post->ID, $option_slug, true);
						}else if( isset($option_value[$option_slug]) ){
							$option['value'] = $option_value[$option_slug];
						}
						
						echo gdlr_core_html_option::get_element($option);
					}
					echo '</div>';
					
					$active = false;
				}
				echo '</div>'; // gdlr-core-page-option-tab-content
				
			}
			
			// test save post
			function save_page_option_meta_box( $post_id ){

				// check if nonce is available
				if( !isset($_POST['page_option_security']) ){
					return;
				}

				// vertify that the nonce is vaild
				if( !wp_verify_nonce($_POST['page_option_security'], 'gdlr_core_page_option') ) {
					return;
				}

				// ignore the auto save
				if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
					return;
				}

				// check the user's permissions.
				if( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
					if( !current_user_can('edit_page', $post_id) ){
						return;
					}
				}else{
					if( !current_user_can('edit_post', $post_id) ){
						return;
					}
				}			
				
				// start updating the meta fields
				if( !empty($_POST[$this->settings['slug']]) ){
					$value = json_decode(gdlr_core_process_post_data($_POST[$this->settings['slug']]), true);
					
					foreach( $this->settings['options'] as $option_slug => $option ){
						if( !empty($option['single']) && !empty($value[$option_slug]) ){
							update_post_meta($post_id, $option_slug, $value[$option_slug]);
							unset($value[$option_slug]);
						}
					}
					update_post_meta($post_id, $this->settings['slug'], $value);
				}
				
			}
			
			// convert the data to read able revision format
			function convert_page_option_revision_data( $data ){
				return json_encode($data) . "\n" . '  - convert :) ';
			}

		} // gdlr_core_page_option
		
	} // class_exists