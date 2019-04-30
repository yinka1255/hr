<?php
	/*	
	*	Goodlayers Item
	*/

	if( is_admin() ){ add_filter('gdlr_core_shortcode_list', 'gdlr_core_register_shortcode_list'); }
	if( !function_exists('gdlr_core_register_shortcode_list') ){
		function gdlr_core_register_shortcode_list( $shortcode_list ){
			$shortcode_list = array_merge($shortcode_list, array(
				array(
					'title' => 'Button',
					'value' => '[gdlr_core_button button-text="Learn More" button-link="#" button-link-target="_blank" margin-right="20px" ]'
				),
				array(
					'title' => 'Code',
					'value' => '[gdlr_core_code style="light" ]<br>' . 
						'code content<br>' . 
						'[/gdlr_core_code]'
				),
				array(
					'title' => 'Column',
					'value' => '[gdlr_core_row]<br>' . 
						'[gdlr_core_column size="1/3"]column content 1[/gdlr_core_column]<br>' .
						'[gdlr_core_column size="1/3"]column content 2[/gdlr_core_column]<br>' .
						'[gdlr_core_column size="1/3"]column content 3[/gdlr_core_column]<br>' .
						'[/gdlr_core_row]'
				),
				array(
					'title' => 'Dropcap',
					'value' => '[gdlr_core_dropcap type="circle" color="#ffffff" background="#212121"]S[/gdlr_core_dropcap]'
				),
				array(
					'title' => 'Dropdown Tab',
					'value' => '[gdlr_core_dropdown_tab]<br>' . 
						'[gdlr_core_tab title="TITLE 1" ]CONTENT 1[/gdlr_core_tab]<br>' .
						'[gdlr_core_tab title="TITLE 2" ]CONTENT 2[/gdlr_core_tab]<br>' .
						'[gdlr_core_tab title="TITLE 3" ]CONTENT 3[/gdlr_core_tab]<br>' .
						'[/gdlr_core_dropdown_tab]'
				),
				array(
					'title' => 'Gallery',
					'value' => '[gallery ids="875,874,873,876,877" orderby="rand" source="gdlr-core" style="slider" slider-navigation="bullet" ]'
				),
				array(
					'title' => 'Icon',
					'value' => '[gdlr_core_icon icon="" size="" color="" margin-left="" margin-right="" ]'
				),
				array(
					'title' => 'Port Info',
					'value' => '[gdlr_core_port_info]<br>' .
						'[gdlr_core_tab title="key" ]value[/gdlr_core_tab]<br>' .
						'[gdlr_core_tab title="key" ]value[/gdlr_core_tab]<br>' .
						'[gdlr_core_tab title="key" ]value[/gdlr_core_tab]<br>' .
						'[/gdlr_core_port_info]'
				),
				array(
					'title' => 'Social Network',
					'value' => '[gdlr_core_social_network facebook="#url" email="#url" twitter="#url" ]'
				),
				array(
					'title' => 'Space',
					'value' => '[gdlr_core_space height="30px"]'
				),
				array(
					'title' => 'Tab',
					'value' => '[gdlr_core_tabs]<br>' .
						'[gdlr_core_tab title="title 1"]Tab 1[/gdlr_core_tab]<br>' .
						'[gdlr_core_tab title="title 2"]Tab 2[/gdlr_core_tab]<br>' .
						'[gdlr_core_tab title="title 3"]Tab 3[/gdlr_core_tab]<br>' .
						'[/gdlr_core_tabs]'
				),
				array(
					'title' => 'Title',
					'value' => '[gdlr_core_title title="" caption="" ]'
				),
			));

			return $shortcode_list;
		}
	}