<?php
	/*	
	*	Goodlayers Media File
	*	---------------------------------------------------------------------
	*	This file contains media function in the theme
	*	---------------------------------------------------------------------
	*/
	
	// get icon based on the type specify
	if( !function_exists('gdlr_core_get_icon_class') ){
		function gdlr_core_get_icon_class( $type, $font = 'font-awesome' ){

			if( $font == 'custom' ){

				return $type;

			}else if( $font == 'font-awesome' ){

				switch( $type ){
					case 'link': return 'fa fa-link'; break;
					case 'video': return 'fa fa-film'; break;
					case 'image': return 'fa fa-search'; break;
					default: break;
				}

			}else if( $font == 'elegant-font' ){

				switch( $type ){
					case 'link': return 'icon_link_alt'; break;
					case 'video': return 'icon_film'; break;
					case 'image': return 'icon_zoom-in_alt'; break;
					default: break;
				}

			}
		} // gdlr_core_get_icon_class
	} // function_exists

	// get animation option
	if( !function_exists('gdlr_core_get_animation_option') ){
		function gdlr_core_get_animation_option(){
			return array( 
				'none' => esc_html__('None', 'goodlayers-core'),
				'fadeIn' => esc_html__('Fade In', 'goodlayers-core'),
				'fadeInDown' => esc_html__('Fade In Down', 'goodlayers-core'),
				'fadeInUp' => esc_html__('Fade In Up', 'goodlayers-core'),
				'fadeInLeft' => esc_html__('Fade In Left', 'goodlayers-core'),
				'fadeInRight' => esc_html__('Fade In Right', 'goodlayers-core'),
				'bounce' => esc_html__('Bounce', 'goodlayers-core'),
				'pulse' => esc_html__('Pulse', 'goodlayers-core'),
				'rubberBand' => esc_html__('Rubber Band', 'goodlayers-core'),
				'shake' => esc_html__('Shake', 'goodlayers-core'),
				'swing' => esc_html__('Swing', 'goodlayers-core'),
			);
		}
	}
	if( !function_exists('gdlr_core_get_animation_atts') ){
		function gdlr_core_get_animation_atts( $settings ){

			$settings = wp_parse_args($settings, array(
				'location' => '0.8',
				'duration' => '600ms'
			));
		
			$ret  = '';
			
			if( !empty($settings['animation']) && $settings['animation'] != 'none' ){
				$ret .= 'data-gdlr-animation="' . esc_attr($settings['animation']) . '" ';
				$ret .= 'data-gdlr-animation-duration="' . esc_attr($settings['duration']) . '" ';
				$ret .= 'data-gdlr-animation-offset="' . esc_attr($settings['location']) . '" ';
			}
			return $ret;
		}
	}
	
	// get lightbox attribute
	if( !function_exists('gdlr_core_get_lightbox_atts') ){
		function gdlr_core_get_lightbox_atts( $atts ){

			$ret = '';
			$lightbox_type = apply_filters('gdlr_core_lightbox_type', 'strip');
			
			// strip lightbox
			if( $lightbox_type == 'strip' ){

				$ret .= ' class="strip ' . (empty($atts['class'])? '': $atts['class']) . '"';
				$ret .= empty($atts['url'])? '': ' href="' . esc_url($atts['url']) . '"';
				$ret .= empty($atts['caption'])? '': ' data-strip-caption="' . esc_attr($atts['caption']) . '"';
				$ret .= empty($atts['group'])? '': ' data-strip-group="' . esc_attr($atts['group']) . '"';

			// ilightbox
			}else if( strpos($lightbox_type, 'ilightbox') !== false ){

				// change video to embed link
				if(!empty($atts['type']) && $atts['type'] == 'video'){

					$video_url = $atts['url'];
					if( strpos($video_url, 'youtube') !== false || strpos($video_url, 'youtu.be') !== false ){
						if( strpos($video_url, 'youtube') !== false ){
							preg_match('#[?&]v=([^&]+)(&.+)?#', $video_url, $id);
						}else{
							preg_match('#youtu.be\/([^?&]+)#', $video_url, $id);
						}
						$id[2] = empty($id[2])? '': $id[2];
						$video_url = '//www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $id[2];

					// vimeo link
					}else if( strpos($video_url, 'vimeo') !== false ){
						preg_match('#https?:\/\/vimeo.com\/(\d+)#', $video_url, $id);
						$video_url = '//player.vimeo.com/video/' . $id[1] . '?title=0&byline=0&portrait=0';
					}
					$atts['url'] = $video_url;
				}

				$ret .= ' class="gdlr-core-ilightbox gdlr-core-js ' . (empty($atts['class'])? '': $atts['class']) . '"';
				$ret .= empty($atts['url'])? '': ' href="' . esc_url($atts['url']) . '"';
				$ret .= empty($atts['caption'])? '': ' data-caption="' . esc_attr($atts['caption']) . '"';
				$ret .= empty($atts['group'])? '': ' data-ilightbox-group="' . esc_attr($atts['group']) . '"';
				$ret .= (!empty($atts['type']) && $atts['type'] == 'video')? ' data-type="iframe" data-options="width: 1280, height: 720"': '';

			}

			return $ret;

		}
	}

	// get image from image id/url
	if( !function_exists('gdlr_core_get_image_url') ){
		function gdlr_core_get_image_url( $image, $size = 'gdlr-core-full', $placeholder = true){
			if( is_numeric($image) ){
				$image_src = wp_get_attachment_image_src($image, $size);
				if( !empty($image_src) ) return $image_src[0];
			}else if( !empty($image) ){
				return $image;
			}

			if( is_admin() && $placeholder ){
				return GDLR_CORE_URL . '/include/images/goodlayers.png';
			}
		}
	}

	if( !function_exists('gdlr_core_get_image') ){
		function gdlr_core_get_image( $image, $size = 'full', $settings = array() ){

			$ret = '';
			$full_image_url = '';
			$placeholder = isset($settings['placeholder'])? $settings['placeholder']: true;

			// get_image section
			if( is_numeric($image) ){
				$alt_text = get_post_meta($image , '_wp_attachment_image_alt', true);	
				$image_src = wp_get_attachment_image_src($image, $size);	
				$full_image_url = gdlr_core_get_image_url($image, NULL, $placeholder);

				if( !empty($image_src) ){
					$img_srcset = gdlr_core_get_image_srcset($image, $image_src);

					if( empty($img_srcset) ){
						$ret .= '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_attr($alt_text) . '" width="' . esc_attr($image_src[1]) .'" height="' . esc_attr($image_src[2]) . '" />';
					}else{
						$ret .= '<img ' . $img_srcset . ' alt="' . esc_attr($alt_text) . '" />';
					}
				}else if( is_admin() ){
					return '<img src="' . esc_url($full_image_url) . '" alt="" />';
				}else{
					return;
				}
			}else if( !empty($image) ){
				$full_image_url = $image;
				$ret .= '<img src="' . esc_url($image) . '" alt="" />';
			}else{
				if( is_admin() ){
					return '<img src="' . esc_url(gdlr_core_get_image_url('', NULL, $placeholder)) . '" alt="" />';
				}else{
					return;
				}
			}

			$image_overlay_atts = array(
				'background'=>empty($settings['image-overlay-background'])? '': $settings['image-overlay-background'],
				'border-radius'=>empty($settings['image-overlay-radius'])? '': $settings['image-overlay-radius'],
				'content'=>empty($settings['image-overlay-content'])? '': $settings['image-overlay-content'],
				'overlay-class'=>empty($settings['image-overlay-class'])? '': $settings['image-overlay-class'],
				'icon'=>empty($settings['image-overlay-icon'])? '': $settings['image-overlay-icon'],
				'icon-type'=>empty($settings['image-overlay-icon-type'])? '': $settings['image-overlay-icon-type'],
				'icon-size'=>empty($settings['image-overlay-icon-size'])? '': $settings['image-overlay-icon-size'],
				'icon-color'=>empty($settings['image-overlay-icon-color'])? '': $settings['image-overlay-icon-color'],
			); 

			// apply link
			if( !empty($settings['link']) ){

				$image_overlay = '';
				if( !empty($settings['image-overlay']) ){
					if( empty($image_overlay_atts['icon']) ){
						$image_overlay_atts['icon'] = 'link';
					}
					$image_overlay = gdlr_core_get_image_overlay($image_overlay_atts);
				}	
				$ret  = '<a href="' . esc_url($settings['link']) . '" ' . 
					(empty($settings['link-target'])? '': 'target="' . esc_attr($settings['link-target']) . '"') . ' >' . $ret . $image_overlay . '</a>';

			// apply lightbox
			}else if( !empty($settings['lightbox']) ){

				$lightbox_atts = array(
					'group' => empty($settings['lightbox-group'])? '': $settings['lightbox-group'],
				);

				if( $settings['lightbox'] === true ){
					$lightbox_atts['url'] = $full_image_url;
					$lightbox_atts['caption'] = gdlr_core_get_image_info($image, 'caption');

				}else if( $settings['lightbox'] == 'video' ){
					$lightbox_atts['url'] = empty($settings['lightbox-video'])? '': $settings['lightbox-video'];
					$lightbox_atts['type'] = 'video';

				}else if( $settings['lightbox'] == 'image' ){
					if( is_numeric($settings['lightbox-image']) ){
						$lb_image_url = gdlr_core_get_image_url($settings['lightbox-image']);
						$lb_image_caption = gdlr_core_get_image_info($settings['lightbox-image'], 'caption');
					}else{
						$lb_image_url = $settings['lightbox-image'];
						$lb_image_caption = '';
					}
					$lightbox_atts['url'] = $lb_image_url;
					$lightbox_atts['caption'] = $lb_image_caption;
				}

				$image_overlay = '';
				if( !empty($settings['image-overlay']) ){
					if( empty($image_overlay_atts['icon']) ){
						$image_icon = ($settings['lightbox'] === true)? 'image': $settings['lightbox'];
						$image_overlay_atts['icon'] = $image_icon;
					}
					$image_overlay = gdlr_core_get_image_overlay($image_overlay_atts);
				}		
				$ret = '<a ' . gdlr_core_get_lightbox_atts($lightbox_atts) . '>' . $ret . $image_overlay . '</a>';

			}else{

				if( !empty($image_overlay_atts['content']) ){
					$ret .= gdlr_core_get_image_overlay($image_overlay_atts);
				}
			}

			return $ret;
		}
	}
	if( !function_exists('gdlr_core_image_group_id') ){
		function gdlr_core_image_group_id(){
			global $gdlr_core_image_group;

			$gdlr_core_image_group = empty($gdlr_core_image_group)? 1: $gdlr_core_image_group + 1;
			return 'gdlr-core-img-group-' . $gdlr_core_image_group;
		}
	}
	if( !function_exists('gdlr_core_get_image_info') ){
		function gdlr_core_get_image_info($image_id, $type = '') {
			if( !is_numeric($image_id) ) return '';

			$ret = '';
			$image = get_post($image_id);

			if( !empty($image) ){
				$ret = array(
					'caption' => $image->post_excerpt,
					'description' => $image->post_content,
					'title' => $image->post_title
				);
				
				if( !empty($type) ) return $ret[$type];
			}

			return $ret;
		}
	}

	if( !function_exists('gdlr_core_get_image_overlay') ){
		function gdlr_core_get_image_overlay( $settings = array() ){

			$extra_class = empty($settings['overlay-class'])? '': $settings['overlay-class'];
			$ret  = '<span class="gdlr-core-image-overlay ' . esc_attr($extra_class) . '" ' . gdlr_core_esc_style(array(
				'background' => empty($settings['background'])? '': $settings['background'],
				'border-radius' => empty($settings['border-radius'])? '': $settings['border-radius']
			)) . ' >';

			if( !empty($settings['content']) ){
				$ret .= '<span class="gdlr-core-image-overlay-content" >' . $settings['content'] . '</span>';
			}else if( !empty($settings['icon']) ){
				$settings['icon-type'] = empty($settings['icon-type'])? 'font-awesome': $settings['icon-type'];

				$icon_class  = gdlr_core_get_icon_class($settings['icon'], $settings['icon-type']);
				$icon_class .= empty($settings['icon-size'])? ' gdlr-core-size-22': ' ' . $settings['icon-size'];

				$ret .= '<i class="gdlr-core-image-overlay-icon ' . esc_attr($icon_class) . '" ' . gdlr_core_esc_style(array(
					'color' => empty($settings['icon-color'])? '': $settings['icon-color'],
				)) . ' ></i>';
			}
			$ret .= '</span>';

			return $ret;
		}
	}

	// get flexslider slides
	if( !function_exists('gdlr_core_get_flexslider') ){
		function gdlr_core_get_flexslider( $slides = array(), $atts = array() ){
			
			$extra_class = empty($atts['additional-class'])? '': $atts['additional-class'];

			$ret  = '<div class="gdlr-core-flexslider flexslider gdlr-core-js-2 ' . esc_attr($extra_class) . '" ';
			$ret .= empty($atts['carousel'])? 'data-type="slider" ': 'data-type="carousel" ';
			$ret .= empty($atts['column'])? '': 'data-column="' . esc_attr($atts['column']) . '" ';
			$ret .= empty($atts['pausetime'])? '': 'data-pausetime="' . esc_attr($atts['pausetime']) . '" ';
			$ret .= empty($atts['slidespeed'])? '': 'data-slidespeed="' . esc_attr($atts['slidespeed']) . '" ';
			$ret .= empty($atts['effect'])? '': 'data-effect="' . esc_attr($atts['effect']) . '" ';
			$ret .= empty($atts['navigation'])? '': 'data-nav="' . esc_attr($atts['navigation']) . '" ';
			$ret .= empty($atts['nav-parent'])? '': 'data-nav-parent="' . esc_attr($atts['nav-parent']) . '" ';
			$ret .= empty($atts['vcenter-nav'])? '': 'data-vcenter-nav="1" ';
			$ret .= empty($atts['with-thumbnail'])? '': 'data-thumbnail="1" ';
			$ret .= empty($atts['disable-autoslide'])? '': 'data-disable-autoslide="1" ';
			$ret .= ' >';

			$ret .= empty($atts['pre-content'])? '': $atts['pre-content'];

			$ret .= '<ul class="slides" >';
			foreach( $slides as $slide ){
				$ret .= '<li ' . ((!empty($atts['carousel']) && (!isset($atts['mglr']) || $atts['mglr'] === true))? ' class="gdlr-core-item-mglr" ': '') . ' >';
				$ret .= $slide;
				$ret .= '</li>';
			}
			$ret .= '</ul>';

			$ret .= '</div>'; // flexslider
			return $ret;
		}
	}
	
	// get audio from url 
	if( !function_exists('gdlr_core_get_audio') ){
		function gdlr_core_get_audio( $audio ){

			if( empty($audio) ) return '';

			$ret  = '<div class="gdlr-core-audio">';
			if( preg_match('#^\[audio\s.+\[/audio\]#', $audio, $match) ){
				$ret .= do_shortcode($audio);
			}else{
				$ret .= wp_audio_shortcode(array('src'=>$audio));
			}
			$ret .= '</div>';

			return $ret;
		}
	}

	// get video from url
	if( !function_exists('gdlr_core_get_video') ){
		function gdlr_core_get_video( $video, $size = 'full', $atts = array() ){
			
			$size = gdlr_core_get_video_size($size);
			
			// video shortcode
			if( preg_match('#^\[video\s.+\[/video\]#', $video, $match) ){ 
				return do_shortcode($match[0]);
				
			// embed shortcode
			}else if( preg_match('#^\[embed.+\[/embed\]#', $video, $match) ){ 
				global $wp_embed; 
				return $wp_embed->run_shortcode($match[0]);
				
			// youtube link
			}else if( strpos($video, 'youtube') !== false || strpos($video, 'youtu.be') !== false ){
				if( strpos($video, 'youtube') !== false ){
					preg_match('#[?&]v=([^&]+)(&.+)?#', $video, $id);
				}else{
					preg_match('#youtu.be\/([^?&]+)#', $video, $id);
				}
				$id[2] = empty($id[2])? '': $id[2];
				$url = '//www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $id[2];
				if( !empty($atts['background']) ){
					$url = add_query_arg(array(
						'autoplay' => 1,
						'controls' => 0,
						'showinfo' => 0,
						'rel' => 0,
						'enablejsapi' => 1,
						'loop' => 1,
						'playlist' => $id[1]
					), $url);
				}
				
				return '<iframe src="' . esc_url($url) . '" width="' . esc_attr($size['width']) . '" height="' . esc_attr($size['height']) . '" data-player-type="youtube" allowfullscreen ></iframe>';

			// vimeo link
			}else if( strpos($video, 'vimeo') !== false ){
				preg_match('#https?:\/\/vimeo.com\/(\d+)#', $video, $id);
				$url = '//player.vimeo.com/video/' . $id[1] . '?title=0&byline=0&portrait=0';
				if( !empty($atts['background']) ){
					$url = add_query_arg(array(
						'autopause' => 0,
						'autoplay' => 1,
						'loop' => 1,
						'api' => 1,
						'background' => 1
					), $url);
				}
				
				return '<iframe src="' . esc_url($url) . '" width="' . esc_attr($size['width']) . '" height="' . esc_attr($size['height']) . '" data-player-type="vimeo" allowfullscreen ></iframe>';
			
			// another link
			}else if(preg_match('#^https?://\S+#', $video, $match)){ 	
				$path_parts = pathinfo($match[0]);
				if( !empty($path_parts['extension']) ){
					return wp_video_shortcode( array( 'width' => $size['width'], 'height' => $size['height'], 'src' => $match[0]) );
				}else{
					global $wp_embed;
					return $wp_embed->run_shortcode('[embed width="' . $size['width'] . '" height="' . $size['height'] . '" ]' . $match[0] . '[/embed]');
				}				
			}
			
		}
	}	
	
	// item title
	if( !function_exists('gdlr_core_block_item_title') ){
		function gdlr_core_block_item_title( $settings ){

			$settings['title-size'] = (empty($settings['title-size']) || $settings['title-size'] == '41px')? '': $settings['title-size'];
			$settings['caption-size'] = (empty($settings['caption-size']) || $settings['caption-size'] == '16px')? '': $settings['caption-size'];
			$settings['read-more-size'] = (empty($settings['read-more-size']) || $settings['read-more-size'] == '14px')? '': $settings['read-more-size'];

			$ret = '';

			if( !empty($settings['title']) || !empty($settings['caption']) ){ 

				$title_align = empty($settings['title-align'])? 'left': $settings['title-align'];
				$extra_class  = ' gdlr-core-' . $title_align . '-align';
				$extra_class .= (!isset($settings['pdlr']) || $settings['pdlr'] == true)? ' gdlr-core-item-mglr': '';

				$ret .= '<div class="gdlr-core-block-item-title-wrap ' . esc_attr($extra_class) . '" >';
				if( $title_align == 'left' && !empty($settings['caption']) ){
					$ret .= '<div class="gdlr-core-block-item-caption gdlr-core-info-font gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['caption-size'],
						'color' => empty($settings['caption-color'])? '': $settings['caption-color']
					)) . ' >' . gdlr_core_text_filter($settings['caption']) . '</div>';
				}
				if( !empty($settings['title']) ){
					$ret .= '<div class="gdlr-core-block-item-title-inner" >';
					$ret .= '<h3 class="gdlr-core-block-item-title" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['title-size'],
						'text-transform' => (empty($settings['title-text-transform']) || $settings['title-text-transform'] == 'uppercase')? '': $settings['title-text-transform'],
						'letter-spacing' => empty($settings['title-letter-spacing'])? '': $settings['title-letter-spacing'],
						'color' => empty($settings['title-color'])? '': $settings['title-color']
					)) . ' >';
					$ret .= gdlr_core_text_filter($settings['title']);
					$ret .= '</h3>';

					if ( $title_align == 'left' && !empty($settings['read-more-text']) && !empty($settings['read-more-link']) ){
						$ret .= '<span class="gdlr-core-separator" ' . gdlr_core_esc_style(array(
							'border-color' => empty($settings['read-more-divider-color'])? '': $settings['read-more-divider-color']
						)) . ' ></span>';
						$ret .= '<a class="gdlr-core-block-item-read-more" href="' . esc_url($settings['read-more-link']) . '" ';
						$ret .= empty($settings['read-more-target'])? '': 'target="' . esc_attr($settings['read-more-target']) . '" ';
						$ret .= gdlr_core_esc_style(array(
							'font-size' => $settings['read-more-size'],
							'color' => empty($settings['read-more-color'])? '': $settings['read-more-color']
						));
						$ret .= ' >' . gdlr_core_text_filter($settings['read-more-text']) . '</a>';
					}

					$ret .= '</div>'; // gdlr-core-block-item-title-inner
				}
				if( $title_align == 'center' && !empty($settings['caption']) ){
					$ret .= '<div class="gdlr-core-block-item-caption gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['caption-size'],
						'color' => empty($settings['caption-color'])? '': $settings['caption-color']
					)) . ' >' . gdlr_core_text_filter($settings['caption']) . '</div>';
				}

				if( !empty($settings['carousel']) && $settings['carousel'] != 'disable' ){
					$ret .= '<div class="gdlr-core-flexslider-nav gdlr-core-round-style gdlr-core-absolute-center gdlr-core-right" ></div>';
				}
				$ret .= '</div>';

			}else if( !empty($settings['carousel']) && $settings['carousel'] != 'disable' ){

				$enable_carousel = apply_filters('gdlr_core_block_item_title_only_carousel', 'enable');
				if( $enable_carousel == 'enable' ){
					$extra_class = (!isset($settings['pdlr']) || $settings['pdlr'] == true)? ' gdlr-core-item-mglr': '';

					$ret .= '<div class="gdlr-core-block-item-title-nav ' . esc_attr($extra_class) . '" >';
					$ret .= '<div class="gdlr-core-flexslider-nav gdlr-core-plain-style gdlr-core-block-center" ></div>';
					$ret .= '</div>';
				}
			} 

			return $ret;
		}
	}