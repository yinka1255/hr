<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	$realfactory_admin_option->add_element(array(
	
		// typography head section
		'title' => esc_html__('Typography', 'realfactory'),
		'slug' => 'rftr_typography',
		'icon' => get_template_directory_uri() . '/include/options/images/typography.png',
		'options' => array(
		
			// starting the subnav
			'font-family' => array(
				'title' => esc_html__('Font Family', 'realfactory'),
				'options' => array(
					'heading-font' => array(
						'title' => esc_html__('Heading Font', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.realfactory-body h1, .realfactory-body h2, .realfactory-body h3, ' . 
							'.realfactory-body h4, .realfactory-body h5, .realfactory-body h6, .realfactory-body .realfactory-title-font,' .
							'.realfactory-body .gdlr-core-title-font{ font-family: #gdlr#; }' . 
							'.woocommerce-breadcrumb, .woocommerce span.onsale, ' .
							'.single-product.woocommerce div.product p.price .woocommerce-Price-amount, .single-product.woocommerce #review_form #respond label{ font-family: #gdlr#; }'
					),
					'navigation-font' => array(
						'title' => esc_html__('Navigation Font', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.realfactory-navigation .sf-menu > li > a, .realfactory-navigation .sf-vertical > li > a, .realfactory-navigation-font{ font-family: #gdlr#; }'
					),	
					'content-font' => array(
						'title' => esc_html__('Content Font', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.realfactory-body, .realfactory-body .gdlr-core-content-font, ' . 
							'.realfactory-body input, .realfactory-body textarea, .realfactory-body button, .realfactory-body select, ' . 
							'.realfactory-body .realfactory-content-font, .gdlr-core-audio .mejs-container *{ font-family: #gdlr#; }'
					),
					'info-font' => array(
						'title' => esc_html__('Info Font', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.realfactory-body .gdlr-core-info-font, .realfactory-body .realfactory-info-font{ font-family: #gdlr#; }'
					),
					'blog-info-font' => array(
						'title' => esc_html__('Blog Info Font', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.realfactory-body .gdlr-core-blog-info-font, .realfactory-body .realfactory-blog-info-font{ font-family: #gdlr#; }'
					),
					'quote-font' => array(
						'title' => esc_html__('Quote Font', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.realfactory-body .gdlr-core-quote-font{ font-family: #gdlr#; }'
					),

					'additional-font' => array(
						'title' => esc_html__('Additional Font', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'customizer' => false,
						'default' => 'Georgia, serif',
						'description' => esc_html__('Additional font you want to include for custom css.', 'realfactory')
					),
					'additional-font2' => array(
						'title' => esc_html__('Additional Font2', 'realfactory'),
						'type' => 'font',
						'data-type' => 'font',
						'customizer' => false,
						'default' => 'Georgia, serif',
						'description' => esc_html__('Additional font you want to include for custom css.', 'realfactory')
					),
					
				) // font-family-options
			), // font-family-nav
			
			'font-size' => array(
				'title' => esc_html__('Font Size', 'realfactory'),
				'options' => array(
				
					'h1-font-size' => array(
						'title' => esc_html__('H1 Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '52px',
						'selector' => '.realfactory-body h1{ font-size: #gdlr#; }' 
					),					
					'h2-font-size' => array(
						'title' => esc_html__('H2 Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '48px',
						'selector' => '.realfactory-body h2, #poststuff .gdlr-core-page-builder-body h2{ font-size: #gdlr#; }' 
					),					
					'h3-font-size' => array(
						'title' => esc_html__('H3 Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '36px',
						'selector' => '.realfactory-body h3{ font-size: #gdlr#; }' 
					),					
					'h4-font-size' => array(
						'title' => esc_html__('H4 Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '28px',
						'selector' => '.realfactory-body h4{ font-size: #gdlr#; }' 
					),					
					'h5-font-size' => array(
						'title' => esc_html__('H5 Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.realfactory-body h5{ font-size: #gdlr#; }' 
					),					
					'h6-font-size' => array(
						'title' => esc_html__('H6 Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '18px',
						'selector' => '.realfactory-body h6{ font-size: #gdlr#; }' 
					),					
					'navigation-font-size' => array(
						'title' => esc_html__('Navigation Font Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '14px',
						'selector' => '.realfactory-navigation .sf-menu > li > a, .realfactory-navigation .sf-vertical > li > a{ font-size: #gdlr#; }' 
					),	
					'navigation-font-weight' => array(
						'title' => esc_html__('Navigation Font Weight', 'realfactory'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '800',
						'selector' => '.realfactory-navigation .sf-menu > li > a{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'realfactory')
					),	
					'navigation-text-transform' => array(
						'title' => esc_html__('Navigation Text Transform', 'realfactory'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'realfactory'),
							'lowercase' => esc_html__('Lowercase', 'realfactory'),
							'capitalize' => esc_html__('Capitalize', 'realfactory'),
							'none' => esc_html__('None', 'realfactory'),
						),
						'default' => 'uppercase',
						'selector' => '.realfactory-navigation .sf-menu > li > a{ text-transform: #gdlr#; }',
					),
					'content-font-size' => array(
						'title' => esc_html__('Content Size', 'realfactory'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.realfactory-body{ font-size: #gdlr#; }' 
					),
					'content-line-height' => array(
						'title' => esc_html__('Content Line Height', 'realfactory'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '1.7',
						'selector' => '.realfactory-body, .realfactory-body p, .realfactory-line-height, .gdlr-core-line-height{ line-height: #gdlr#; }'
					),
					
				) // font-size-options
			), // font-size-nav			
			
			'font-upload' => array(
				'title' => esc_html__('Font Uploader', 'realfactory'),
				'reload-after' => true,
				'customizer' => false,
				'options' => array(
				
					'font-upload' => array(
						'title' => esc_html__('Upload Fonts', 'realfactory'),
						'type' => 'custom',
						'item-type' => 'fontupload',
						'wrapper-class' => 'gdlr-core-fullsize',
					),
					
				) // fontupload-options
			), // fontupload-nav
		
		) // typography-options
		
	), 4);