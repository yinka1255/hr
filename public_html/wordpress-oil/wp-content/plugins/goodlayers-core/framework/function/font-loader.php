<?php
	/*	
	*	Goodlayers Admin Panel
	*	---------------------------------------------------------------------
	*	This file create the class that help you controls the font settings
	*	---------------------------------------------------------------------
	*/	
	
	if( !class_exists('gdlr_core_font_loader') ){	
		class gdlr_core_font_loader{

			private $web_safe_font_list = array(
				'Georgia, serif',
				'"Palatino Linotype", "Book Antiqua", Palatino, serif',
				'"Times New Roman", Times, serif',
				'Helvetica, sans-serif',
				'Arial, Helvetica, sans-serif',
				'"Arial Black", Gadget, sans-serif',
				'"Comic Sans MS", cursive, sans-serif',
				'Impact, Charcoal, sans-serif',
				'"Lucida Sans Unicode", "Lucida Grande", sans-serif',
				'Tahoma, Geneva, sans-serif',
				'"Trebuchet MS", Helvetica, sans-serif',
				'Verdana, Geneva, sans-serif',
				'"Courier New", Courier, monospace',
				'"Lucida Console", Monaco, monospace'
			);
			private $custom_fonts = array();
			
			private $google_font_last_update = 20160109;
			private $google_font_key = array(
				'last-update' => 'gdlr_core_google_font_last_update',
				'list' => 'gdlr_core_google_font_list',
				'link-list' => 'gdlr_core_google_font_link_list',
				'option-list' => 'gdlr_core_google_font_option_list',
				'used-font' => 'gdlr_core_google_font_used',
				'front-end' => 'gdlr_core_google_font_enqueue',
			);
			private $google_fonts = array();
			
			// is an option list
			private $all_option_list;
			
			function __construct(){
				
				// update_option($this->google_font_key['last-update'], 0);
				
				// initiate the google font
				if( get_option($this->google_font_key['last-update'], 0) < $this->google_font_last_update ){
					update_option($this->google_font_key['last-update'], $this->google_font_last_update);
					
					$fs = new gdlr_core_file_system();
					$google_fonts = json_decode($fs->read(GDLR_CORE_LOCAL . '/framework/function/google-font.txt'), true);
					update_option($this->google_font_key['list'], $google_fonts);

					$option_list = '';
					$link_list = array();
					foreach($google_fonts as $font_family => $font_options ){
						$option_list .= '<option value="' . esc_attr($font_family) . '" >' . esc_html($font_family) . '</option>';
						$link_list[$font_family] = $this->get_google_font_link($font_family);
					}
					update_option($this->google_font_key['option-list'], $option_list);
					update_option($this->google_font_key['link-list'], $link_list);
				} 
				
				// initiate custom font
				$this->custom_fonts = apply_filters('gdlr_core_custom_uploaded_font', array());
			}			

			// get option list to use in select box
			function get_option_list( $value ){
				
				if( empty($this->all_option_list) ){
					$this->all_option_list = '';
					if( !empty($this->custom_fonts) ){
						$this->all_option_list .= '<option disabled >' . esc_html__('=== Custom Font ===', 'goodlayers-core') . '</option>';
						foreach($this->custom_fonts as $font_family => $font_options ){
							$this->all_option_list .= '<option value="' . esc_attr($font_family) . '" >' . esc_html($font_family) . '</option>';
						}
					}					
					
					if( !empty($this->web_safe_font_list) ){
						$this->all_option_list .= '<option disabled >' . esc_html__('=== Web Safe Font ===', 'goodlayers-core') . '</option>';
						foreach($this->web_safe_font_list as $font_family ){
							$this->all_option_list .= '<option value="' . esc_attr($font_family) . '" >' . esc_html($font_family) . '</option>';
						}
					}
					
					$google_option_list = $this->get_google_font('option-list');
					if( !empty($google_option_list) ){
						$this->all_option_list .= '<option disabled >' . esc_html__('=== Google Font ===', 'goodlayers-core') . '</option>';
						$this->all_option_list .= $google_option_list;
					}
				}
				
				$keywords = 'value="' . esc_attr($value) . '"';
				return str_replace($keywords, $keywords . 'selected', $this->all_option_list);
			}		
			
			// get all font list to admin panel area
			function get_font_family_css( $font_family ){	
				$this->get_google_font('list');
			
				if( !empty($this->google_fonts['list'][$font_family]) ){
					return "\"{$font_family}\", " . $this->google_fonts['list'][$font_family]['category'];
				}else if( !empty($this->custom_fonts[$font_family]) ){
					return "\"{$font_family}\"";
				}
				
				return $font_family;
			}			

			/////////////////////////
			// custom font section
			/////////////////////////
			
			// get custom font face for css styling
			function get_custom_fontface( $font_family = '' ){	
			
				$ret  = '';
				if( !empty($this->custom_fonts) ){
					if( empty($font_family) ){
						foreach( $this->custom_fonts as $font_name => $font_option ){
							$ret .= '@font-face {' . "\n";
							$ret .= 'font-family: "' . $font_name . '";' . "\n";
							$ret .= 'src: url("' . $font_option['eot'] . '");' . "\n";
							$ret .= 'src: url("' . $font_option['eot'] . '?#iefix") format("embedded-opentype"), ' . "\n";
							$ret .= 'url("' . $font_option['ttf'] . '") format("truetype");' . "\n";
							$ret .= 'font-weight: normal;' . "\r\n";
							$ret .= 'font-style: normal;' . "\r\n";
							$ret .= '}' . "\n";	
						}
					}else if( !empty($this->custom_fonts[$font_family] ) ){
						$ret .= '@font-face {' . "\n";
						$ret .= 'font-family: "' . $font_family . '";' . "\n";
						$ret .= 'src: url("' . $this->custom_fonts[$font_family]['eot'] . '");' . "\n";
						$ret .= 'src: url("' . $this->custom_fonts[$font_family]['eot'] . '?#iefix") format("embedded-opentype"), ' . "\n";
						$ret .= 'url("' . $this->custom_fonts[$font_family]['ttf'] . '") format("truetype");' . "\n";
						$ret .= 'font-weight: normal;' . "\r\n";
						$ret .= 'font-style: normal;' . "\r\n";
						$ret .= '}' . "\n";	
					}
				}
				
				return $ret;
			}			
			
			/////////////////////////
			// google font section
			/////////////////////////

			// get google font from type
			function get_google_font( $type ){
				if( empty($this->google_fonts[$type]) ){
					$this->google_fonts[$type] = get_option($this->google_font_key[$type], array());
				}
				
				return $this->google_fonts[$type];
			}
			
			// return a link to embed google font
			function get_google_font_link( $font_family ){
				$this->get_google_font('list');
				
				if( !empty($font_family) ){
					
					// multiple fonts
					if( is_array($font_family) ){
						$font_style = '';
						$font_subset = array();
						foreach( $font_family as $font_name => $value ){
							if( !empty($this->google_fonts['list'][$font_name]) ){
								$font_style .= empty($font_style)? '': '|';
								$font_style .= str_replace(' ', '+' , $font_name) . ':';
								$font_style .= implode(',', $this->google_fonts['list'][$font_name]['variants']); 
								
								$font_subset = array_merge($font_subset, $this->google_fonts['list'][$font_name]['subsets']);
							}
						}
						if( !empty($font_style) ){
							$font_style .= '&subset=' . implode(',', array_unique($font_subset));
						}
						
					// single font
					}else if( !empty($this->google_fonts['list'][$font_family]) ){
						$font_style  = str_replace(' ', '+' , $font_family) . ':';
						$font_style .= implode(',', $this->google_fonts['list'][$font_family]['variants']) . ':&subset='; 
						$font_style .= implode(',', $this->google_fonts['list'][$font_family]['subsets']);
					}					
					
					if( !empty($font_style) ){
						return 'https://fonts.googleapis.com/css?family=' . $font_style;
					}
				}
				return '';
			}
			
			// google font enqueue for front end
			function google_font_enqueue(){
				$google_front_end = $this->get_google_font('front-end');
				if( !empty($google_front_end) ){
					wp_enqueue_style('gdlr-core-google-font', $google_front_end);
				}
			}			
			function update_used_font($use_lists){
				if( !empty($use_lists) ){
					$font_url = $this->get_google_font_link( $use_lists );
					update_option($this->google_font_key['front-end'], $font_url);
					update_option($this->google_font_key['used-font'], $use_lists);
				}else{
					delete_option($this->google_font_key['front-end']);
				}
			}			
			function set_used_font($use_lists){ // for customize refresh
				if( !empty($use_lists) ){
					$font_url = $this->get_google_font_link( $use_lists );
					$this->google_fonts['front-end'] = $font_url;
				}
			}
			
		} // gdlr_core_font_loader
	} // class_exists
	
	// create a custom page use to display font 
	if( !function_exists('gdlr_core_get_font_display_page') ){
		function gdlr_core_get_font_display_page(){
			return admin_url('?gdlr_core_font_display');
		}
	}
	if( is_admin() ){
		add_action('init', 'gdlr_core_create_font_display_page');
	}	
	if( !function_exists('gdlr_core_create_font_display_page') ){
		function gdlr_core_create_font_display_page(){
			if( isset($_GET['gdlr_core_font_display']) && !empty($_GET['font-family']) ){
				
				$string = esc_html__('Sample Text', 'goodlayers-core');

				global $gdlr_core_font_loader;
				if( empty($gdlr_core_font_loader) ){
					$gdlr_core_font_loader = new gdlr_core_font_loader();
				}				

				$font_url = $gdlr_core_font_loader->get_google_font_link($_GET['font-family']);
?>
<!DOCTYPE html>
<html>
<head><?php 
if( !empty($font_url) ){
	echo '<link type="text/css" rel="stylesheet" href="' . esc_url($font_url) . '" >';
} 
?><style type="text/css"><?php 
	if( empty($font_url) ){ 
		echo gdlr_core_escape_content($gdlr_core_font_loader->get_custom_fontface($_GET['font-family']));
	}
?>html, body, input{ height: 100%; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
body{ margin: 0px; padding: 0px; overflow: hidden; }
input{ width: 100%; padding: 0px 18px; margin: 0px; font-size: 20px; font-weight: bold; text-align: left; color: #3E3E3E; line-height: 60px; border: none; font-family: <?php echo gdlr_core_escape_content($_GET['font-family']); ?>; }
input:focus{ outline: none; box-shadow: none; -moz-box-shadow: none; -webkit-box-shadow: none; }
</style>
</head>
<body>
	<input value="<?php echo esc_attr($string); ?>" />
</body>
</html>
<?php
				exit();
			}
		}	
	}	
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// update google font list
	// to obtain api key, see -> https://developers.google.com/fonts/docs/developer_api
	////////////////////////////////////////////////////////////////////////////////////////////////
	// $file_stream = @fopen(GDLR_CORE_LOCAL . '/framework/function/google-font.txt', 'w');
	// $google_font_data = json_decode(file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCTCFDIsOiwQK9eEo5RO3Q26JTpDQrW2V8'), true);
	// $google_fonts = array();
	// foreach( $google_font_data['items'] as $google_font ){
	// 	$google_fonts[$google_font['family']] = array(
	// 		'subsets' => $google_font['subsets'],
	// 		'variants' => $google_font['variants'],
	// 		'category' => $google_font['category']
	// 	);
	// }
	// fwrite($file_stream, json_encode($google_fonts));
	// fclose($file_stream);
	////////////////////////////////////////////////////////////////////////////////////////////////