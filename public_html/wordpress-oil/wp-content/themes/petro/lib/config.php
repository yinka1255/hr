<?php
defined('ABSPATH') or die();

    global $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once(ABSPATH .'/wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
        require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
        WP_Filesystem();
    }       


    // Internataionalization
    if(is_admin()){
        $locale = get_locale();
        $load=load_textdomain( 'petro', untrailingslashit(get_template_directory()). '/languages/' . $locale . '.mo' );
    }



    $opt_name = redux_opt_name();


    if( ($old_config = get_option( $opt_name)) && isset($old_config['top-bar-layout']) && version_compare(get_option( $opt_name."_version"), '2.0.0', '<' ) ){
/** 
 * migration from old version setinngs 
 * Adding header layout feature
 */

        $header_layout = array();
        $top_bar_layout = $old_config['top-bar-layout'];

        if(is_array($top_bar_layout)){

            $tobar_layout = array_merge($top_bar_layout['left'] , $top_bar_layout['right'] );
            $header_layout['topbar'] = $tobar_layout;
        }


        $old_iconbars_module = $old_config['icon-bars-module'];


        if(is_array($old_iconbars_module)){

            $middle_layout = array();

            foreach($old_iconbars_module as $module_name => $is_inable ){

                if($module_name == 'icon-graphic' && $is_inable ){
                    $middle_layout['icongraphic'] = esc_html__( 'Icons Info', 'petro' );
                }

                if($module_name == 'social-icons' && $is_inable ){
                    $middle_layout['social2'] = esc_html__( 'Social Icons 2 (Deprecated)','petro');
                }


                if($module_name == 'text-icons-bar' && $is_inable ){
                    $middle_layout['text'] = esc_html__( 'Custom Text','petro');
                }

            }

            $header_layout['middle'] = $middle_layout;
        }



        if( isset($old_config['show_search'])  && $old_config['show_search'] !=''){

            $bottom_layout = array('mainmenu'     => esc_html__( 'Main Menu','petro'));

            if((bool) $old_config['show_search'] ){
                $bottom_layout['search'] = esc_html__( 'Search Bar','petro');
            }

            $header_layout['bottom'] = $bottom_layout;

        }

        $old_text_module = $old_config['icon-text-module'];
        
        if( isset($old_config['icon-text-module'])){
            $content = $old_text_module;

            $old_config['text-module'] = $old_config['icon-text-module'];
        }


        $menucolor= isset($old_config['menu-color']) ? array('regular'=> $old_config['menu-color']) :  array('regular'=>'');

        if(isset($old_config['menu-hover-color'])) {
             $menucolor['hover'] = $old_config['menu-hover-color'];
         }

        if(isset($old_config['menu-active-color'])) {
             $menucolor['active'] = $old_config['menu-active-color'];
         }

        if(isset($old_config['sub-menu-color'])){
            $old_config['sub-menu-color']= array('regular' => $old_config['sub-menu-color']);
        }

        $old_config['menu-color'] = $menucolor;
        $old_config['header-layout'] = $header_layout;

         update_option( $opt_name, $old_config );
         update_option( $opt_name."_version", '2.0.0' );

    }


    if( $old_config && isset($old_config['mobile-menu-color']) && version_compare(get_option( $opt_name."_version"), '2.1.3', '<' ) ){
/** 
 * migration from old version setinngs 
 * Adding mobile menu color
 */
        $stickybg= isset($old_config['mobile-background-color']) ? $old_config['mobile-background-color'] :  array('color'=>'','alpha'=>0);
        $old_config['mobile-menu-bg'] = $stickybg;

        update_option( $opt_name, $old_config );
        update_option( $opt_name."_version", '2.1.3' );

    }

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'petro' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'petro' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'petro' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'petro' )
        )
    );


    // Set the help sidebar
    $content = "<p>".esc_html__( 'This is the sidebar content, HTML is allowed.', 'petro' )."</p>";
    $post_types = get_post_types( array( 'public' => true ));

    // -> START Identity
    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Site Identity', 'petro' ),
        'id'               => 'identity',
        'customizer_width' => '400px',
        'customizer'=> false,
        'icon'             => 'el el-cog',
        'fields'           => array(
                array(
                    'id'=>'logo_image',
                    'type' => 'media', 
                    'title' => esc_html__('Image Logo', 'petro'),
                    'subtitle'=>esc_html__('Select image for the logo','petro'),
                    'compiler' => true,
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'=>'logo_image_alt',
                    'type' => 'media', 
                    'title' => esc_html__('Image Logo Alt', 'petro'),
                    'subtitle'=>esc_html__('Alt logo will displayed on sticky menu.','petro'),
                    'compiler' => true,
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'       => 'site-title',
                    'type'     => 'text',
                    'default'  => get_bloginfo('name','raw'),
                    'value'    => get_bloginfo('name','raw'),
                    'title'    => esc_html__( 'Site Title','petro'),
                ),
                array(
                    'id'       => 'site-tagline',
                    'type'     => 'text',
                    'value'    => get_bloginfo( 'description','raw'),
                    'default'  => get_bloginfo( 'description','raw'),
                    'title'    => esc_html__( 'Tagline','petro'),
                ),
                array(
                    'id'=>'show-tagline',
                    'type' => 'switch', 
                    'title' => esc_html__('Show Tagline', 'petro'),
                    'subtitle'=> esc_html__('Show or hide tagline', 'petro'),
                    "default"=> 1,
                    'on' => esc_html__('Yes', 'petro'),
                    'off' => esc_html__('No', 'petro')
                ),  
                array(
                    'id'=>'logo-type',
                    'type' => 'button_set',
                    'title' => esc_html__('Logo Type', 'petro'), 
                    'subtitle'=>esc_html__('Select logo type shown as site name','petro'),
                    'options'=>array(
                        'auto'=>esc_html__('Auto', 'petro'),
                        'image'=>esc_html__('Image Logo', 'petro'),
                        'title'=>esc_html__('Site Title', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'auto'
                ),
                array(
                    'title'            => esc_html__( 'Social Link', 'petro' ),
                    'id'               => 'social_link',
                    'type' => 'section',
                    'indent'   => false,
                    'description'=> esc_html__('Social link data. Field blank will not display.' ,'petro'),
                ),
                array(
                    'id'=>'social_fb',
                    'type' => 'text', 
                    'title' => esc_html__('Facebook Link', 'petro'),
                    'description'=>esc_html__( '( example: https://www.facebook.com/themegum/ )','petro'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_twitter',
                    'type' => 'text', 
                    'title' => esc_html__('Twitter Link', 'petro'),
                    'description'=> esc_html__('( example: https://twitter.com/temegum )' ,'petro'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_gplus',
                    'type' => 'text', 
                    'title' => esc_html__('Google Plus Link', 'petro'),
                    'description'=> esc_html__('( example: https://plus.google.com/u/0/1234567890123456789 )' ,'petro'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_linkedin',
                    'type' => 'text', 
                    'title' => esc_html__('Linkedin Link', 'petro'),
                    'description'=> esc_html__('( example: https://www.linkedin.com/ )' ,'petro'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_pinterest',
                    'type' => 'text', 
                    'title' => esc_html__('Pinterest Link', 'petro'),
                    'description'=> esc_html__('( example: https://id.pinterest.com/temegum/ )' ,'petro'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_instagram',
                    'type' => 'text', 
                    'title' => esc_html__('Instagram Link', 'petro'),
                    'description'=> esc_html__('( example: https://www.instagram.com/themegum_team/ )' ,'petro'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'custom_socials',
                    'type' => 'icon_multi_text',
                    'title' => esc_html__('Custom Social Links', 'petro'),
                    'subtitle'=> wp_kses( __('Add social link with custom icon.','petro'), array('strong'=>array())),
                    'sortable' => true,
                    'fields'=> array(
                        'link' => esc_html__('Link', 'petro'),
                        'label' => esc_html__('Label', 'petro'),
                        ),
                    'default' => array()
                )
             )
    ) );


    // -> START Heading
    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'HEADER', 'petro' ),
        'id'               => 'heading',
        'customizer_width' => '400px',
        'customizer'=> false,
        'icon'             => 'el el-tasks',
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'header-layout-section',
        'subsection' => true,
        'title'    => esc_html__( 'General Layout', 'petro' ),
        'fields'           => array(
                array(
                    'id'         => 'header-presets',
                    'type'       => 'image_select',
                    'presets'    => true,
                    'title'      => esc_html__( 'Header Layout Preset', 'petro' ),
                    'subtitle'   => esc_html__( 'Select pre-define a header layout. Becareful! your last configuration will be lost.', 'petro' ),
                    'default'    => 0,
                    'options'    => array(
                        '1' => array(
                            'alt'     => esc_html__( 'Preset 1','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset1.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo","text":"Custom Text","menu1":"Menu 1","social":"Social Icons"},"middle":{"placebo":"placebo","icongraphic":"Icons Info","button":"Button Link"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"Disabled":{"placebo":"placebo","menu2":"Menu 2","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"icon_align":"right","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"menu-color":{"regular":"","hover":"","active":""},"social_show_label":"0"}'
                        ),
                        '12' => array(
                            'alt'     => esc_html__( 'Preset 12','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset12.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","text":"Custom Text","menu1":"Menu 1","button":"Button Link"},"middle":{"placebo":"placebo","icongraphic":"Icons Info"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"Disabled":{"placebo":"placebo","menu2":"Menu 2","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"icon_align":"right","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"social_show_label":"0","topbar-height":"40","menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '13' => array(
                            'alt'     => esc_html__( 'Preset 13','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset13.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","menu1":"Menu 1","button":"Button Link"},"middle":{"placebo":"placebo","icongraphic":"Icons Info"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"Disabled":{"placebo":"placebo","text":"Custom Text","menu2":"Menu 2","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"1","icon_align":"right","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-height":"40","menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '11' => array(
                            'alt'     => esc_html__( 'Preset 11','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset11.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info (Flat)"},"middle":{"placebo":"placebo","icongraphic":"Icons Info","button":"Button Link","toggle":"Toggle Menu"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"Disabled":{"placebo":"placebo","text":"Custom Text","menu1":"Menu 1","menu2":"Menu 2"}},"icon_align":"right","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"social_show_label":"0","menu-color":{"regular":"","hover":"","active":""},"slidingbar":"1","slidingbar-type":"slidingbar-widget"}'
                        ),
                        '2' => array(
                            'alt'     => esc_html__( 'Preset 2','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset2.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo","menu1":"Menu 1","social":"Social Icons","text":"Custom Text"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"bottom":{"placebo":"placebo","icongraphic":"Icons Info","button":"Button Link"},"Disabled":{"placebo":"placebo","menu2":"Menu 2","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","icon_align":"left","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '3' => array(
                            'alt'     => esc_html__( 'Preset 3','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset3.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo","menu1":"Menu 1","social":"Social Icons","text":"Custom Text"},"middle":{"placebo":"placebo","icongraphic":"Icons Info","search":"Search Bar"},"bottom":{"placebo":"placebo","button":"Button Link","mainmenu":"Main Menu"},"Disabled":{"placebo":"placebo","menu2":"Menu 2","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","icon_align":"right","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '6' => array(
                            'alt'     => esc_html__( 'Preset 6','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset6.png',
                            'presets' => '{"show_top_bar":"0","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo","icongraphic":"Icons Info","social":"Social Icons","search":"Search Bar"},"Disabled":{"placebo":"placebo","menu1":"Menu 1","menu2":"Menu 2","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","icon_align":"left","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"bottom-section-spacing":{"padding-top":"15px","padding-bottom":"15px"},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '7' => array(
                            'alt'     => esc_html__( 'Preset 7','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset7.png',
                            'presets' => '{"show_top_bar":"0","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","social":"Social Icons"},"bottom":{"placebo":"placebo","icongraphic":"Icons Info","search":"Search Bar","button":"Button Link"},"Disabled":{"placebo":"placebo","menu1":"Menu 1","menu2":"Menu 2","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","icon_align":"left","middle-section-spacing":{"padding-top":"0","padding-bottom":""},"bottom-section-spacing":{"padding-top":"15px","padding-bottom":"15px"},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '4' => array(
                            'alt'     => esc_html__( 'Preset 4','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset4.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","menu1":"Menu 1","social":"Social Icons","text":"Custom Text"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","search":"Search Bar","menu2":"Menu 2","icongraphic":"Icons Info","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '15' => array(
                            'alt'     => esc_html__( 'Preset 15','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset15.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","iconflat":"Icon Flat","social":"Social Icons"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","menu1":"Menu 1","text":"Custom Text","search":"Search Bar","menu2":"Menu 2","icongraphic":"Icons Info","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","topbar-section-spacing":{"padding-top":"5px","padding-bottom":"5px"},"middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '16' => array(
                            'alt'     => esc_html__( 'Preset 16','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset16.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","iconflat":"Icon Flat","social":"Social Icons","toggle":"Toggle Menu"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","menu1":"Menu 1","text":"Custom Text","search":"Search Bar","menu2":"Menu 2","icongraphic":"Icons Info","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","topbar-section-spacing":{"padding-top":"5px","padding-bottom":"5px"},"middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"slidingbar":"1","slidingbar-type":"slidingbar-widget","link_color":{"regular":"#ffffff","hover":""},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '14' => array(
                            'alt'     => esc_html__( 'Preset 14','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset14.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","menu1":"Menu 1","text":"Custom Text","social":"Social Icons","button":"Button Link"},"middle":{"placebo":"placebo","mainmenu":"Main Menu"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","search":"Search Bar","menu2":"Menu 2","icongraphic":"Icons Info","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-height":"40","social_show_label":"0","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '5' => array(
                            'alt'     => esc_html__( 'Preset 5','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset5.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","menu1":"Menu 1","icongraphic":"Icons Info","social":"Social Icons","search":"Search Bar"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","menu2":"Menu 2","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '8' => array(
                            'alt'     => esc_html__( 'Preset 8','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset8.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","icongraphic":"Icons Info","menu1":"Menu 1","search":"Search Bar","social":"Social Icons"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","menu2":"Menu 2","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","topbar-height":"80","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"icon_align":"left","menu-color":{"regular":"","hover":"","active":""}}'
                        ),
                        '9' => array(
                            'alt'     => esc_html__( 'Preset 9','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset9.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"middle":{"placebo":"placebo","icongraphic":"Icons Info","social":"Social Icons","search":"Search Bar"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","menu1":"Menu 1","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","menu2":"Menu 2","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","topbar-height":"80","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"icon_align":"right","menu-color":{"regular":"#ffffff","hover":"","active":""}}'
                        ),
                        '10' => array(
                            'alt'     => esc_html__( 'Preset 10','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset10.png',
                            'presets' => '{"show_top_bar":"1","show_bottom_section":"0","header-layout":{"topbar":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar","social":"Social Icons"},"middle":{"placebo":"placebo","button":"Button Link","icongraphic":"Icons Info"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","menu1":"Menu 1","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","menu2":"Menu 2","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","topbar-height":"80","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"icon_align":"right","menu-color":{"regular":"#ffffff","hover":"","active":""}}'
                        ),
                        '17' => array(
                            'alt'     => esc_html__( 'Preset 17','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset17.png',
                            'presets' => '{"show_top_bar":"0","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo"},"middle":{"placebo":"placebo","mainmenu":"Main Menu"},"bottom":{"placebo":"placebo","social":"Social Icons","iconflat":"Icon Flat","search":"Search Bar","toggle":"Toggle Button"},"Disabled":{"placebo":"placebo","button":"Button Link","icongraphic":"Icons Info","menu1":"Menu 1","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","menu2":"Menu 2","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","bottom-section-height":"40","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"bottom-section-spacing":{"padding-top":"0","padding-bottom":"0"},"icon_align":"right","menu-color":{"regular":"#ffffff","hover":"","active":""},"navbar-outer-bgcolor":{"color":"#041e42"},"navbar-inner-background-color":{"color":"#041e42"},"navbar-color":"#ffffff","bottom-layout-indent":""}'
                        ),
                        '18' => array(
                            'alt'     => esc_html__( 'Preset 18','petro'),
                            'img'     => get_template_directory_uri().'/lib/images/preset18.png',
                            'presets' => '{"show_top_bar":"0","show_bottom_section":"1","header-layout":{"topbar":{"placebo":"placebo"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo","social":"Social Icons","iconflat":"Icon Flat","search":"Search Bar","toggle":"Toggle Button"},"Disabled":{"placebo":"placebo","button":"Button Link","icongraphic":"Icons Info","menu1":"Menu 1","text":"Custom Text","text2":"Custom Text 2 (Deprecated)","menu2":"Menu 2","text1":"Custom Text 1 (Deprecated)","social2":"Social Icons 2 (Deprecated)"}},"social_show_label":"0","bottom-section-height":"40","middle-section-spacing":{"padding-top":"0","padding-bottom":"40px"},"bottom-section-spacing":{"padding-top":"0","padding-bottom":"0"},"icon_align":"right","menu-color":{"regular":"#ffffff","hover":"","active":""},"navbar-outer-bgcolor":{"color":"#041e42"},"navbar-inner-background-color":{"color":"#041e42"},"navbar-color":"#ffffff","bottom-layout-indent":""}'
                        ),

                    ),
                ),
                 array(
                    'id'       => 'header-layout',
                    'type'     => 'sorter',
                    'title'    => esc_html__( 'Custom Layout','petro'),
                    'subtitle' => esc_html__( 'Select the module and to section available.','petro'),
                    'full_width' => true,
                    'options'  => array(
                        'topbar'  => array(
                            'title'=> esc_html__('Top Section','petro'),
                            'desc' => esc_html__( 'Drag module from modules box.', 'petro' ),
                            'fields'=>array(
                                'social'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-social.png', 'title'=>esc_html__( 'Social Icons','petro'))
                            )
                        ),
                        'middle' => array(
                            'title'=> esc_html__('Middle Section','petro'),
                            'desc' => esc_html__( 'The logo atomatic displayed at this section.', 'petro' ),
                            'fields'=>array(
                                'icongraphic'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-icongraphic.png', 'title'=>esc_html__( 'Icons Info', 'petro' )),                                
                                'text' => esc_html__( 'Custom Text','petro'),
                            )
                        ),
                        'bottom' => array(
                            'title'=> esc_html__('Bottom Section','petro'),
                            'desc' => esc_html__( 'Drag module from modules box. This section usualy for navigation menu.', 'petro' ),
                            'fields'=>array(
                                'mainmenu'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-menu.png', 'title'=>esc_html__( 'Main Menu','petro')),
                                'search' => array('thumb'=> get_template_directory_uri().'/lib/images/module-search.png', 'title'=>esc_html__( 'Search & Cart','petro')),
                            )
                        ),
                        'modules'   => array(
                            'title'=> esc_html__('Modules Available','petro'),
                            'desc' => esc_html__( 'Select the module by dragging on module name and drop on section box. Deprecated module will remove in next release.', 'petro' ),
                            'fields'=>array(
                                'button'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-button.png', 'title'=>esc_html__( 'Button Link','petro')),
                                'iconflat' => array('thumb'=> get_template_directory_uri().'/lib/images/module-iconflat.png', 'title'=>esc_html__( 'Icons Info (Flat)','petro')),
                                'menu1' => array('thumb'=> get_template_directory_uri().'/lib/images/module-shortmenu.png', 'title'=>esc_html__( 'Short Menu','petro')),
                                'toggle' => array('title'=>esc_html__( 'Side Menu Toggle','petro'), 'thumb'     => get_template_directory_uri().'/lib/images/module-toggle.png'),
                                'menu2'   => esc_html__( 'Menu 2 (Deprecated)','petro'),
                                'text1'   => esc_html__( 'Custom Text 1 (Deprecated)','petro'),
                                'text2'   => esc_html__( 'Custom Text 2 (Deprecated)','petro'),
                                'social2'   => esc_html__( 'Social Icons 2 (Deprecated)','petro'),

                            )
                        ),
                    ),
                ),
        )));





    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'menuicon-header-section',
        'subsection' => true,
        'title'    => esc_html__( 'Icons Info Module', 'petro' ),
        'desc' => esc_html__( 'Configure navigation icon items.', 'petro' ),
        'fields'           => array(
                array(
                    'id'=>'menu_icon_fields',
                    'type' => 'icon_multi_text',
                    'title' => esc_html__('Source Icons', 'petro'),
                    'sortable' => true,
                    'fields'=> array(
                        'label' => esc_html__('Label', 'petro'),
                        'text' => esc_html__('Text', 'petro'),
                        'url' => esc_html__('Link', 'petro'),
                        )
                ),
                array(
                    'id'       => 'icon_align',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Align', 'petro' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'petro' ),
                        'center' => esc_html__( 'Center', 'petro' ),
                        'right' => esc_html__( 'Right', 'petro' ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'       => 'menu_icon_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Icon Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for icon.', 'petro' ),
                    'default'  => '#90dadf',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_icon_label_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'petro' ),
                    'default'  => '#90dadf',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_icon_value_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for text.', 'petro' ),
                    'default'  => '#041e42',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'=>'icongraphic-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'petro'),
                        'xs'=>esc_html__('Hidden since 768px', 'petro'),
                        'mobile'=>esc_html__('Hidden since 480px', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),

        )));



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'menuiconflat-header-section',
        'subsection' => true,
        'title'    => esc_html__( 'Icons Info(flat) Module', 'petro' ),
        'desc' => esc_html__( 'Configure navigation icon items. The icon will showing inline', 'petro' ),
        'fields'           => array(
                array(
                    'id'=>'menu_iconflat_fields',
                    'type' => 'icon_multi_text',
                    'title' => esc_html__('Source Icons', 'petro'),
                    'sortable' => true,
                    'fields'=> array(
                        'label' => esc_html__('Label', 'petro'),
                        'text' => esc_html__('Text', 'petro'),
                        'url' => esc_html__('Link', 'petro'),
                        )
                ),
                array(
                    'id'       => 'iconflat_align',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Align', 'petro' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'petro' ),
                        'center' => esc_html__( 'Center', 'petro' ),
                        'right' => esc_html__( 'Right', 'petro' ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'       => 'menu_iconflat_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Icon Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for icon.', 'petro' ),
                    'default'  => '',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_iconflat_label_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'petro' ),
                    'default'  => '',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_iconflat_value_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for text.', 'petro' ),
                    'default'  => '',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'=>'iconflat-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'petro'),
                        'xs'=>esc_html__('Hidden since 768px', 'petro'),
                        'mobile'=>esc_html__('Hidden since 480px', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
        )));


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'text-module-section',
        'subsection' => true,
        'title'    => esc_html__( 'Custom Text Module','petro'),
        'fields'           => array(
                array(
                    'id'           => 'text-module',
                    'type'         => 'textarea',
                    'title'        => esc_html__( 'Free Content', 'petro' ),
                    'subtitle'     => esc_html__( 'Custom HTML Allowed (wp_kses)', 'petro' ),
                    'desc'         => esc_html__( 'This content just allow simple html content.', 'petro' ),
                    'validate'     => 'html_custom',
                    'default'      => '',
                    'allowed_html' => array(
                        'a'      => array(
                            'href'  => array(),
                            'title' => array(),
                            'target'=>array(),
                            'class' => array()
                        ),
                        'br'     => array(),
                        'em'     => array(),
                        'strong' => array(),
                        'span'   => array(
                            'class' => array()
                        ),
                        'img'    => array(
                            'src' => array(),
                            'class' => array()
                        )
                    ) //see http://codex.wordpress.org/Function_Reference/wp_kses
                ),
                array(
                    'id'=>'text-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'petro'),
                        'xs'=>esc_html__('Hidden since 768px', 'petro'),
                        'mobile'=>esc_html__('Hidden since 480px', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'text-module1-section',
        'subsection' => true,
        'title'    => esc_html__( 'Custom Text 1 (Deprecated)','petro'),
        'fields'           => array(
                array(
                    'id'=>'top-bar-text-1',
                    'type'         => 'textarea',
                    'title' => esc_html__('Custom Text 1 (Deprecated)', 'petro'),
                    'subtitle' => esc_html__('Deprecated. For new installation don\'t use this element.', 'petro'),
                    'default' => '',
                    'validate' => 'html'
                ),
            )
        )
    );



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'text-module2-section',
        'subsection' => true,
        'title'    => esc_html__( 'Custom Text 2 (Deprecated)','petro'),
        'fields'           => array(
                array(
                    'id'=>'top-bar-text-2',
                    'type' => 'textarea',
                    'title' => esc_html__('Custom Text 2 (Deprecated)', 'petro'),
                    'subtitle' => esc_html__('Deprecated. For new installation don\'t use this element.', 'petro'),
                    'default' => '',
                    'validate' => 'html'
                ),
            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'button-section',
        'subsection' => true,
        'title'    => esc_html__( 'Button Link Module','petro'),
        'fields'           => array(
                array(
                    'title'    => esc_html__( 'Label','petro'),
                    'id'       => 'quote_menu_label',
                    'type'     => 'text',
                    'default'  => esc_html__('Get a Quote', 'petro'),
                    'value'    => '',
                ),
                array(
                    'title'    => esc_html__( 'Link','petro'),
                    'id'       => 'quote_menu_link',
                    'type'     => 'text',
                    'default'  => '#',
                    'value'    => '',
                ),
                array(
                    'id'=>'quote_menu_link_target',
                    'type' => 'button_set',
                    'title' => esc_html__('Link Target','petro'),
                    'options'=>array(
                          'self'=>esc_html__("Same frame", 'petro'),
                          'blank'=>esc_html__("New window", 'petro'),
                          'parent'=> esc_html__("Parent frameset", 'petro'),
                          'top'=> esc_html__("Full body of the window", 'petro'),
                        ),
                    'default'=> 'blank',
                    'multi_layout'=>'inline',
                ),
                array(
                    'id'       => 'quote_menu_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Label Color', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for button label.', 'petro' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    )
                ),
                array(
                    'id'       => 'quote_menu_bg_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Button Color', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for button color.', 'petro' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    )
                ),
                array(
                    'id'=>'button-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'petro'),
                        'xs'=>esc_html__('Hidden since 768px', 'petro'),
                        'mobile'=>esc_html__('Hidden since 480px', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),

            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'social-link-section',
        'subsection' => true,
        'title'    => esc_html__( 'Social Icon Module','petro'),
        'fields'           => array(
                array(
                    'id'=>'social_link_target',
                    'type' => 'button_set',
                    'title' => esc_html__('Link Target','petro'),
                    'options'=>array(
                          ''=>esc_html__("None", 'petro'),
                          'self'=>esc_html__("Same frame", 'petro'),
                          'blank'=>esc_html__("New window", 'petro'),
                          'parent'=> esc_html__("Parent frameset", 'petro'),
                          'top'=> esc_html__("Full body of the window", 'petro'),
                        ),
                    'default'=> '',
                    'multi_layout'=>'inline',
                ),

                array(
                    'id'       => 'social_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Color', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for social icon.', 'petro' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    )
                ),
                array(
                    'id'       => 'social_bg_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Background Color', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for background.', 'petro' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    )
                ),
                array(
                    'id'        => 'social_show_label',
                    'title'     => esc_html__('Show Label', 'petro'), 
                    'subtitle'      => esc_html__('Show or hidden social label.','petro'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'petro'),
                    'off' => esc_html__('No', 'petro'),
                    'default'   => 0
                ),
                array(
                    'id'=>'social-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'petro'),
                        'xs'=>esc_html__('Hidden since 768px', 'petro'),
                        'mobile'=>esc_html__('Hidden since 480px', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
            )
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'mainmenu-section',
        'title'    => esc_html__( 'Main Menu Module', 'petro' ),
        'desc' => esc_html__( 'Main menu settings.', 'petro' ),
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'       => 'menu-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Color', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for menu color.', 'petro' ),
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '#222222',
                        'hover'   => '#041e42',
                        'active'   => '#46c2ca',
                    )
                ),
                array(
                    'id'       => 'menu-border',
                    'type'     => 'border',
                    'title'    => esc_html__( 'Border', 'petro' ),
                    'desc'     => esc_html__( 'Border each menu.', 'petro' ),
                    'all'      => false,  
                    'top'      => true,
                    'bottom'   => true,
                    'style'    => true,
                    'color'    => true,
                    'left'     => true,
                    'right'    => true,
                ),
                array(
                    'id'       => 'hover-menu-border',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Hover Menu Border Color', 'petro' ),
                    'desc' => esc_html__( 'Border color when menu hover.', 'petro' ),
                    'default'  => array(
                        'color' => '',
                        'alpha' => '0',
                    ),
                ),
                array(
                    'id'       => 'sub-menu-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Dropdown Menu Color', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for dropdown menu color.', 'petro' ),
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '#ffffff',
                        'hover'   => '#000000',
                        'active'   => '#000000',
                    )
                ),
                array(
                    'id'       => 'dropdown-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Dropdown Background Color', 'petro' ),
                    'desc' => esc_html__( 'Pick a color for dropdown background', 'petro' ),
                    'default'  => array(
                        'color' => '#041e42',
                        'alpha' => '1',
                    ),
                ),
                array(
                    'id'       => 'menu-style-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Mobile Styles', 'petro' ),
                    'subtitle' => esc_html__( 'Menu styles.', 'petro' ),
                    'indent'   => false, 
                ),
                array(
                    'id'       => 'mobile-menu-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Menu Color', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for mobile menu color. This option optional, if no value the menu style inherit from regular style.', 'petro' ),
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '#222222',
                        'hover'   => '#041e42',
                        'active'   => '#46c2ca',
                    )
                ),
                array(
                    'id'       => 'mobile-menu-bg',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Background', 'petro' ),
                    'desc' => esc_html__( 'Background color for mobile menu.', 'petro' ),
                    'default'  => array(
                        'color' => '',
                        'alpha' => '0',
                    ),
                ),


            )
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'menu-module1-section',
        'subsection' => true,
        'title'    => esc_html__('Menu 1 Module', 'petro'),
        'fields'           => array(
                array(
                    'id'=>'top-bar-menu-1',
                    'type' => 'select',
                    'title' => esc_html__('Source Menu', 'petro'), 
                    'data' =>'menu',
                    'subtitle'=>esc_html__('Select menu source','petro'),
                    ),
            )
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'menu-module2-section',
        'subsection' => true,
        'title'    => esc_html__('Menu 2 Module', 'petro'),
        'fields'           => array(
                array(
                    'id'=>'top-bar-menu-2',
                    'type' => 'select',
                    'title' => esc_html__('Source Menu', 'petro'), 
                    'data' =>'menu',
                    'subtitle'=>esc_html__('Select menu source','petro'),
                ),
            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'title'    => esc_html__( 'Top Section Settings', 'petro' ),
        'id'               => 'topbar-header-start',
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'        => 'show_top_bar',
                    'title'     => esc_html__('Active', 'petro'), 
                    'subtitle'      => esc_html__('Enable or disable top header section.','petro'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'petro'),
                    'off' => esc_html__('No', 'petro'),
                    'default'   => 1
                ),
                array(
                    'id'=>'topbar-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'petro'),
                        'wide'=>esc_html__('Wide', 'petro'),
                        'boxed'=>esc_html__('Boxed', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'topbar-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','petro'),
                    'subtitle' => esc_html__( 'Minimum top bar height in px', 'petro' ),
                    'default'       => 40,
                    'min'           => 40,
                    'step'          => 5,
                    'max'           => 300,
                    'display_value' => 'text'
                ),
                array(
                    'id'             => 'topbar-section-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'petro' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'petro' ),
                    'default'        => array(
                        'padding-top'    => '',
                        'padding-bottom' => '',
                    )
                ),
                array(
                    'id'       => 'topbar-radius',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Border Radius','petro'),
                    'desc' => esc_html__( 'Border radius in px', 'petro' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text'
                ),
                array(
                    'id'       => 'topbar-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Text Color', 'petro' ),
                    'default'  => '#ffffff',
                ),
                array(
                    'id'       => 'topbar-bgcolor',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outer Background Color', 'petro' ),
                    'default'  => array(
                        'color' => '#041e42',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'topbar-inner-bgcolor',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background Color', 'petro' ),
                    'default'  => array(
                        'color' => '#000000',
                        'alpha' => '0'
                    ),
                ),
                array(
                    'id'       => 'topbar-border-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Border Bottom', 'petro' ),
                    'default'  => array(
                        'color'  => '',
                        'alpha' => ''
                    )
                ),

                )
            )
        );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'icon-header-start',
        'title'    => esc_html__( 'Middle Section Settings', 'petro' ),
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'=>'middle-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'petro'),
                        'wide'=>esc_html__('Wide', 'petro'),
                        'boxed'=>esc_html__('Boxed', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'middle-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'petro'),
                        'xs'=>esc_html__('Hidden since 768px', 'petro'),
                        'mobile'=>esc_html__('Hidden since 480px', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'iconbar-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outer Background Color', 'petro' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'iconbar-inner-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background Color', 'petro' ),
                    'default'  => array(
                        'color' => '#000000',
                        'alpha' => '0'
                    ),
                ),
                array(
                    'id'       => 'iconbar-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Text Color', 'petro' ),
                    'default'  => '#041e42',

                ),
                array(
                    'id'       => 'middle-section-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','petro'),
                    'subtitle' => esc_html__( 'Minimum middle section height in px', 'petro' ),
                    'default'       => 40,
                    'min'           => 40,
                    'step'          => 5,
                    'max'           => 300,
                    'display_value' => 'text'
                ),
                array(
                    'id'       => 'middle-section-radius',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Border Radius','petro'),
                    'desc' => esc_html__( 'Border radius in px', 'petro' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text'
                ),
                array(
                    'id'             => 'middle-section-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'petro' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'petro' ),
                    'default'        => array(
                        'padding-top'    => '20px',
                        'padding-bottom' => '20px',
                    )
                ),
            )
        )
    );


 ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'navigation-header-start',
        'title'    => esc_html__( 'Bottom Section Settings', 'petro' ),
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'        => 'show_bottom_section',
                    'title'     => esc_html__('Active', 'petro'), 
                    'subtitle'      => esc_html__('Enable or disable bottom header section.','petro'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'petro'),
                    'off' => esc_html__('No', 'petro'),
                    'default'   => 1
                ),
                array(
                    'id'=>'bottom-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'petro'),
                        'wide'=>esc_html__('Wide', 'petro'),
                        'boxed'=>esc_html__('Boxed', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'bottom-layout-indent',
                    'type' => 'button_set',
                    'title' => esc_html__('Hang Down Mode', 'petro'), 
                    'subtitle'=> esc_html__('Half section hang down.', 'petro'),
                    'options'=>array(
                        ''=>esc_html__('No', 'petro'),
                        'half'=>esc_html__('Half of Height', 'petro'),
                        'full'=>esc_html__('Full of Height', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'navbar-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'petro' ),
                    'default'  => '#222222',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'navbar-outer-bgcolor',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outer Background Color', 'petro' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'navbar-inner-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background Color', 'petro' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'navbar-border',
                    'type'     => 'border',
                    'title'    => esc_html__( 'Border', 'petro' ),
                    'desc'     => esc_html__( 'Border the navbar.', 'petro' ),
                    'all'      => false,  
                    'top'      => true,
                    'bottom'   => true,
                    'style'    => true,
                    'color'    => true,
                    'left'     => true,
                    'right'    => true,
                ),
                array(
                    'id'       => 'bottom-section-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','petro'),
                    'desc' => esc_html__( 'Minimum bottom section height in px', 'petro' ),
                    'default'       => 40,
                    'min'           => 40,
                    'step'          => 5,
                    'max'           => 300,
                    'display_value' => 'text'
                ),
                array(
                    'id'       => 'bottom-section-radius',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Border Radius','petro'),
                    'desc' => esc_html__( 'Border radius in px', 'petro' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text'
                ),
                array(
                    'id'             => 'bottom-section-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'petro' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'petro' ),
                    'default'        => array(
                        'padding-top'    => '',
                        'padding-bottom' => '',
                    )
                ),

            )
        )
    );



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'sticky-section',
        'title'    => esc_html__( 'Sticky Top Bar', 'petro' ),
        'desc' => esc_html__( 'Stickybar on header.', 'petro' ),
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'        => 'sticky_menu',
                    'title'     => esc_html__('Activated', 'petro'), 
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'petro'),
                    'off' => esc_html__('No', 'petro'),
                    'default'   => 0
                ),
                array(
                    'id'=>'sticky-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'petro'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'petro'),
                        'wide'=>esc_html__('Wide', 'petro'),
                        'boxed'=>esc_html__('Boxed', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'sticky-mobile',
                    'type' => 'switch',
                    'title' => esc_html__('Sticky for Mobile', 'petro'), 
                    'subtitle'=> esc_html__('Sticky mode on 600px screen.', 'petro'),
                    'on'=> esc_html__('Enable', 'petro'),
                    'off'=> esc_html__('Disable', 'petro'),
                    'default'=> 0
                ),
                array(
                    'id'       => 'sticky-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'petro' ),
                    'default'  => '',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'mobile-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outside Background', 'petro' ),
                    'desc' => esc_html__( 'Background color for outer stickybar.', 'petro' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1',
                    ),
                ),
                array(
                    'id'       => 'mobile-inside-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background', 'petro' ),
                    'desc' => esc_html__( 'Background color for inner stickybar.', 'petro' ),
                    'default'  => array(
                        'color' => '',
                        'alpha' => '0',
                    ),
                ),
                array(
                    'id'             => 'stickybar-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'petro' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'petro' ),
                    'default'        => array(
                        'padding-top'    => '',
                        'padding-bottom' => '',
                    )
                ),
                 array(
                    'id'       => 'sticky-layout',
                    'type'     => 'sorter',
                    'title'    => esc_html__( 'LAYOUT','petro'),
                    'subtitle' => esc_html__( 'Select the module and to section available.','petro'),
                    'full_width' => true,
                    'options'  => array(
                        'active'  => array(
                            'title'=> esc_html__('Modules Selected','petro'),
                            'desc' => esc_html__( 'Drag module from modules box.', 'petro' ),
                            'fields'=>array(
                                'mainmenu'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-menu.png', 'title'=>esc_html__( 'Main Menu','petro'))
                            )
                        ),
                        'modules'   => array(
                            'title'=> esc_html__('Modules Available','petro'),
                            'desc' => esc_html__( 'Select the module by dragging on module name and drop on section box.', 'petro' ),
                            'fields'=>array(
                                'text' => esc_html__( 'Free Text','petro'),
                                'social'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-social.png', 'title'=>esc_html__( 'Social Icons','petro')),
                                'button'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-button.png', 'title'=>esc_html__( 'Button Link','petro')),
                                'icongraphic'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-icongraphic.png', 'title'=>esc_html__( 'Icons Info', 'petro' )),                                
                                'iconflat' => array('thumb'=> get_template_directory_uri().'/lib/images/module-iconflat.png', 'title'=>esc_html__( 'Icons Info (Flat)','petro')),
                                'search' => array('thumb'=> get_template_directory_uri().'/lib/images/module-search.png', 'title'=>esc_html__( 'Search & Cart','petro')),
                                'menu1' => array('thumb'=> get_template_directory_uri().'/lib/images/module-shortmenu.png', 'title'=>esc_html__( 'Short Menu','petro')),
                                'toggle' => array('title'=>esc_html__( 'Side Menu Toggle','petro'), 'thumb'     => get_template_directory_uri().'/lib/images/module-toggle.png'),

                                )
                        ),
                    )
                )


            )
        )
    );

 ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'heading-header-start',
        'title'    => esc_html__( 'Heading', 'petro' ),
        'desc' => esc_html__( 'Page Heading Settings.', 'petro' ),
        'subsection' => true,
        'fields'           => array(

                array(
                    'id'=>'heading_image',
                    'type' => 'media', 
                    'title' => esc_html__('Heading Image', 'petro'),
                    'subtitle'=>esc_html__('Select image using for heading backgound.','petro'),
                    'compiler' => true,
                    'description' => esc_html__('Recomended 1500px wide.','petro'),
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'=>'heading_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Image Position', 'petro'), 
                    'subtitle'=>esc_html__('Select image position','petro'),
                    'desc'=>esc_html__('Default position is relative, image following page scrolling.','petro'),
                    'options'=>array(
                        ''=>esc_html__('Default', 'petro'),
                        'fixed'=>esc_html__('Fixed', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'heading-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','petro'),
                    'subtitle' => esc_html__( 'Minimum height in px.', 'petro' ),
                    'default'       => 350,
                    'min'           => 145,
                    'step'          => 5,
                    'max'           => 600,
                    'display_value' => 'text',
                    'required' => array( 'heading_position', '=', array( 'fixed') ),

                ),
                array(
                    'id'       => 'heading-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Background Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for heading background', 'petro' ),
                    'default'  => array(
                        'color' => '#f9f9f9',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'page-style-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Page Title & Breadcrumb', 'petro' ),
                    'subtitle' => esc_html__( 'Title & breadcrumb configuration.', 'petro' ),
                    'indent'   => false, 
                ),
                array(
                    'id'=>'page_title',
                    'type' => 'switch', 
                    'title' => esc_html__('Page Title', 'petro'),
                    'subtitle'=> esc_html__('Show or hidden page title at heading', 'petro'),
                    "default"=> 1,
                    'on' => esc_html__('Show', 'petro'),
                    'off' => esc_html__('Hidden', 'petro')
                ),  
                array(
                    'id'=>'use_breadcrumb',
                    'type' => 'switch', 
                    'title' => esc_html__('Breadcrumb', 'petro'),
                    'subtitle'=> esc_html__('Show or hidden breadcrumb at heading', 'petro'),
                    "default"=> 1,
                    'on' => esc_html__('Show', 'petro'),
                    'off' => esc_html__('Hidden', 'petro')
                ),  
                array(
                    'id'       => 'heading_align',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Placement', 'petro' ),
                    'subtitle' => esc_html__( 'Page title and breadcrumb alignment.', 'petro' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'petro' ),
                        'center' => esc_html__( 'Center', 'petro' ),
                        'right' => esc_html__( 'Right', 'petro' ),
                    ),
                    'default'  => 'left'
                ),
                array(
                    'title'    => esc_html__( 'Vertical Offset','petro'),
                    'id'       => 'page-title-offset',
                    'type'     => 'text',
                    'default'  => '',
                    'description' => esc_html__('Adjust vertical placement. Default:160px.','petro'),
                    'value'    => '',
                ),
                array(
                    'id'       => 'page-title-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Page Title Color', 'petro' ),
                    'default'  => '#ffffff',
                    'transparent' => false
                ),
                array(
                    'id'       => 'breadcrumb-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Breadcrumb Color', 'petro' ),
                    'default'  => '#ffffff',
                    'transparent' => false
                ),
                array(
                    'id'       => 'breadcrumb-link-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Breadcrumb Link Color', 'petro' ),
                    'default'  => '#ffffff',
                    'transparent' => false
                ),

            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'slidingbar-section-start',
        'title'    => esc_html__( 'Sliding Bar', 'petro' ),
        'desc' => esc_html__( 'Sliding navigation bar.', 'petro' ),
        'icon'  => 'el el-arrow-right',
        'fields' => array(


                array(
                    'id'=>'slidingbar',
                    'type' => 'switch',
                    'title' => esc_html__('Show Sliding Bar', 'petro'), 
                    'subtitle'=>esc_html__('Hide or show slidingbar.','petro'),
                    "default"=> 1,
                    'on' => esc_html__('Show', 'petro'),
                    'off' => esc_html__('Hidden', 'petro')
                ),
                array(
                    'id'=>'slidingbar-type',
                    'type' => 'button_set', 
                    'title' => esc_html__('Content Source', 'petro'),
                    'subtitle'=> esc_html__('Selec the slidingbar content source.', 'petro'),
                    "default"=> 'option',
                    'options'=>array(
                        'slidingbar-widget' => esc_html__('Slidingbar Widget', 'petro'),
                        'sidebar-widget' => esc_html__('Sidebar Widget', 'petro'),
                        'page' => esc_html__('Page', 'petro'),
                    )
                ),  
                array(
                    'id'       => 'slidingbar-page',
                    'type'     => 'select',
                    'data'     => 'pages',
                    'title'    => esc_html__( 'Page Source', 'petro' ),
                    'subtitle' => esc_html__( 'Content will displayed as slidingbar content', 'petro' ),
                    'desc'     => esc_html__( 'Create a page first.', 'petro' ),
                    'required' => array( 'slidingbar-type', '=', array( 'page') )
                ),
                array(
                    'id'=>'slidingbar-position',
                    'type' => 'button_set', 
                    'title' => esc_html__('Sliding Bar Placement', 'petro'),
                    'subtitle'=> esc_html__('The position of slidingbar.', 'petro'),
                    "default"=> 'right',
                    'multi_layout'=>'inline',
                    'options'  => array(
                        'top' => esc_html__('Top', 'petro'),
                        'bottom' => esc_html__('Bottom', 'petro'),
                        'left'     => esc_html__('Left', 'petro'),
                        'right' => esc_html__('Right', 'petro'),
                        ),
                ),  
                array(
                    'id'=>'slidingbar_bg',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Background Color', 'petro'), 
                    'subtitle' => esc_html__('Select color for background slidingbar.', 'petro'),
                    'default' => '#ffffff',
                    'validate' => 'color'
                ),  
                array(
                  'title'    => esc_html__( 'Overlay Darkness', 'petro' ),
                  'subtitle'     => esc_html__( 'Offset content transparency. 0 for no transparency and 20 for maximum ( dark )', 'petro' ),
                  'id'       => 'sliding_overlay',
                  'default'  => '',
                  'type'     => 'text',
                ),
                array(
                    'id'       => 'sliding-button-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Toggle Sliding Button', 'petro' ),
                    'subtitle' => esc_html__( 'Toggle sliding button styles.', 'petro' ),
                    'indent'   => false,
                    'required' => array( 'slidingbar-position', '=', array( 'left','right','bottom') ), 
                ),
                array(
                    'id'=>'show-toggle',
                    'type' => 'switch', 
                    'title' => esc_html__('Show Toggle Button', 'petro'),
                    'subtitle'=> esc_html__('Show or hide toggle button', 'petro'),
                    "default"=> 1,
                    'on' => esc_html__('Yes', 'petro'),
                    'off' => esc_html__('No', 'petro'),
                    'required' => array( 'slidingbar-position', '=', array( 'left','right','bottom') ),
                ),  
                array(
                    'id'         => 'toggle-btn',
                    'type'       => 'image_select',
                    'presets'    => false,
                    'title'      => esc_html__( 'Select Type', 'petro' ),
                    'subtitle'   => esc_html__( 'Select toggle view.', 'petro' ),
                    'default'    => 'fa-sign-in',
                    'options'    => array(
                        'fa-sign-in' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_sign_in.png',
                        ),
                        'fa-sign-out' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_sign_out.png',
                        ),
                        'fa-ellipsis-v' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_ellipsis_v.png',
                        ),
                        'fa-ellipsis-h' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_ellipsis_h.png',
                        ),
                        'fa-navicon' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_navicon.png',
                        ),
                        'fa-th-large' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_th_large.png',
                        ),
                        'fa-power-off' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_power_off.png',
                        ),
                        'fa-gear' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_gear.png',
                        ),
                        'fa-shopping-cart' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_shopping_cart.png',
                        ),
                        'fa-user-o' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_user_o.png',
                        ),
                        'fa-envelope-o' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_envelope_o.png',
                        ),
                        'fa-phone' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_phone.png',
                        ),
                        'fa-toggle-off' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_toggle_off.png',
                        ),
                        'fa-toggle-on' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_toggle_on.png',
                        )

                    ),
                ),
                array(
                  'title'    => esc_html__( 'Toggle Text', 'petro' ),
                  'subtitle'     => esc_html__( 'Add text on toggle button after icon. Leave blank for use icon only.', 'petro' ),
                  'id'       => 'toggle_text',
                  'default'  => '',
                  'type'     => 'text',
                  'required' => array( 'slidingbar-position', '=', array( 'left','right','bottom') ),
                ),
                array(
                    'id'       => 'toggle_btn_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Label Color ( Custom )', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for button label.', 'petro' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'slidingbar-position', '=', array( 'left','right','bottom') ),
                ),
                array(
                    'id'       => 'toggle_btn_bg_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Button Color ( Custom )', 'petro' ),
                    'desc'     => esc_html__( 'Pick a color for button color.', 'petro' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'slidingbar-position', '=', array( 'left','right','bottom') ),
                ),
                array(
                    'id'       => 'sliding-toggle-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Toggle Menu', 'petro' ),
                    'subtitle' => esc_html__( 'Toggle button menu styles.', 'petro' ),
                    'indent'   => false, 
                ),
                array(
                    'id'         => 'toggle-icon',
                    'type'       => 'image_select',
                    'presets'    => false,
                    'title'      => esc_html__( 'Select Type', 'petro' ),
                    'subtitle'   => esc_html__( 'Select toggle view.', 'petro' ),
                    'default'    => 'fa-sign-in',
                    'options'    => array(
                        'fa-sign-in' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_sign_in.png',
                        ),
                        'fa-sign-out' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_sign_out.png',
                        ),
                        'fa-ellipsis-v' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_ellipsis_v.png',
                        ),
                        'fa-ellipsis-h' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_ellipsis_h.png',
                        ),
                        'fa-navicon' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_navicon.png',
                        ),
                        'fa-th-large' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_th_large.png',
                        ),
                        'fa-power-off' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_power_off.png',
                        ),
                        'fa-gear' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_gear.png',
                        ),
                        'fa-shopping-cart' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_shopping_cart.png',
                        ),
                        'fa-user-o' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_user_o.png',
                        ),
                        'fa-envelope-o' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_envelope_o.png',
                        ),
                        'fa-phone' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_phone.png',
                        ),
                        'fa-toggle-off' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_toggle_off.png',
                        ),
                        'fa-toggle-on' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_toggle_on.png',
                        )

                    ),
                ),
                array(
                    'id'       => 'toggle-slide-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Color', 'petro' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                ),
                array(
                  'title'    => esc_html__( 'Font Size', 'petro' ),
                  'subtitle'     => esc_html__( 'Font size the toggle', 'petro' ),
                  'id'       => 'sliding_size',
                  'default'  => '',
                  'type'     => 'text',
                ),


            )
        )
    );



    // style section


    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Style & Color', 'petro' ),
        'id'               => 'style',
        'customizer_width' => '400px',
        'icon'             => 'el el-adjust',
    ) );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'general-style-section-start',
        'type'     => 'section',
        'title'    => esc_html__( 'General Color', 'petro' ),
        'desc' => esc_html__( 'General Style Settings.', 'petro' ),
        'subsection' => true,
        'fields' => array(
                array(
                    'id'=>'textcolor',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Body Text Color', 'petro'), 
                    'subtitle' => esc_html__('Select color for main color', 'petro'),
                    'default' => '#222222',
                    'validate' => 'color'
                    ),  
                array(
                    'id'=>'primary_color',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Primary Color', 'petro'), 
                    'subtitle' => esc_html__('Select color for primary brand', 'petro'),
                    'default' => '#ed1c24',
                    'validate' => 'color'
                    ),  
                array(
                    'id'=>'secondary_color',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Secondary Color', 'petro'), 
                    'subtitle' => esc_html__('Select color for secondary brand', 'petro'),
                    'default' => '#041e42',
                    'validate' => 'color'
                    ),  
                array(
                    'id'=>'third_color',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Third Color', 'petro'), 
                    'subtitle' => esc_html__('Select color for decoration color', 'petro'),
                    'default' => '#46c2ca',
                    'validate' => 'color'
                    ),  
                array(
                    'id'       => 'link-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Link Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a link color', 'petro' ),
                    'default'  => '#666666',
                ),
                array(
                    'id'       => 'link-hover-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Link Hover Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a link hover color', 'petro' ),
                    'default'  => '#ed1c24',
                ),
                array(
                    'id'       => 'line-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Line Color', 'petro' ),
                    'subtitle' => esc_html__( 'Pick a color for line', 'petro' ),
                    'default'  => '#dcdde1',
                ),
                array(
                    'id'       => 'background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Page Background Color', 'petro' ),
                    'subtitle' => esc_html__( 'Background for body area.', 'petro' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'content-background',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Content Background', 'petro' ),
                    'subtitle' => esc_html__( 'Background for content area.', 'petro' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
            )
        )
    );



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'typography-section-start',
        'title'    => esc_html__( 'Font Style', 'petro' ),
        'desc' => esc_html__( 'Font Style Settings.', 'petro' ),
        'subsection' => true,
        'fields' => array(
                array(
                    'id'       => 'body-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Body Font', 'petro' ),
                    'subtitle' => esc_html__( 'Specify the body font properties.', 'petro' ),
                    'font-style'    => false,
                    'font-family' => true,
                    'google' => true,
                    'subsets'  => false,
                    'font-size'=> true,
                    'line-height'   => true,
                    'word-spacing'  => false, 
                    'letter-spacing'=> true,
                    'color'         => false,
                    'font-weight' => false,
                    'text-align'=> false,
                    'preview' => true, 
                    'default'  => array(),
//                    'output'   => array( 'body' ),
                ),
                array(
                    'id'          => 'heading-font',
                    'type'        => 'typography',
                    'title'       => esc_html__( 'Heading Font', 'petro' ),
                    'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'petro' ),
                    'font-style'    => false,
                    'font-weight' => false,
                    'subsets'  => false,
                    'font-size'=> true,
                    'line-height'   => true,
                    'word-spacing'  => false, 
                    'letter-spacing'=> true,
                    'color'         => false, 
                    'text-align'=> false, 
                    'default'     => array()
                ),
            )
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Blog', 'petro' ),
        'id'               => 'sidebarsection',
        'customizer_width' => '400px',
        'customizer'=> false,
        'icon'             => 'el el-pencil',
    ));


    // -> START Blog
    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'blog-layout-start',
        'subsection' => true,
        'title'    => esc_html__( 'Layout', 'petro' ),
        'desc' => esc_html__( 'Blog column  settings.', 'petro' ),
        'fields'           =>array(
            array(
                'id'=>'grid_column',
                'type' => 'button_set',
                'title' => esc_html__('Blog Layout','petro'),
                'subtitle'=>esc_html__('The number of grid columns for default blog','petro'), 
                'options'=>array(
                      1=>esc_html__("1 Columns", 'petro'),
                      2=>esc_html__("2 Columns", 'petro'),
                      3=> esc_html__("3 Columns", 'petro'),
                    ),
                'default'=> 1,
                'multi_layout'=>'inline',
            ),
            array(
                'id'=>'author_grid_column',
                'type' => 'button_set',
                'title' => esc_html__('Author Blog Layout','petro'),
                'subtitle'=>esc_html__('The number of grid columns for author blog','petro'), 
                'options'=>array(
                      1=>esc_html__("1 Columns", 'petro'),
                      2=>esc_html__("2 Columns", 'petro'),
                      3=> esc_html__("3 Columns", 'petro'),
                    ),
                'default'=> 1,
                'multi_layout'=>'inline',
            ),
            array(
                'id'=>'category_grid_column',
                'type' => 'button_set',
                'title' => esc_html__('Category Blog Layout','petro'),
                'subtitle'=>esc_html__('The number of grid columns for category & archive blog','petro'), 
                'options'=>array(
                      1=>esc_html__("1 Columns", 'petro'),
                      2=>esc_html__("2 Columns", 'petro'),
                      3=> esc_html__("3 Columns", 'petro'),
                    ),
                'default'=> 1,
                'multi_layout'=>'inline',
            ),
            array(
                'id'       => 'post-style-section',
                'type'     => 'section',
                'title'    => esc_html__( 'Single Post', 'petro' ),
                'indent'   => false, 
            ),
            array(
                'id'=>'blog_featured_image',
                'type' => 'switch',
                'title' => esc_html__('Featured Image as Heading', 'petro'), 
                'subtitle'=>esc_html__('Using featured image as header image.','petro'),
                "default"=> 0,
                'on' => esc_html__('Yes', 'petro'),
                'off' => esc_html__('No', 'petro')
            ),

            array(
                'id'       => 'blog-layout',
                'type'     => 'sorter',
                'title'    => esc_html__( 'Layout','petro'),
                'subtitle' => esc_html__( 'Drag up/down for reoder the element.','petro'),
                'options'  => array(
                    'active'   => array(
                        'title'=> esc_html__('Used Elements','petro'),
                        'desc' => esc_html__( 'Element will show in detail post.', 'petro' ),
                        'vertical'=> true,
                        'fields'=>array(
                            'image' => esc_html__('Featured Image','petro'),
                            'title' => esc_html__('Post Title','petro'),
                            'meta' => esc_html__('Post Meta','petro'),
                            'content' => esc_html__('Post Content','petro'),
                            'author' => esc_html__('Post Author','petro'),
                        )
                    ),
                    'Disabled'   => array(
                        'title'=> esc_html__('Available Elements','petro'),
                        'desc' => esc_html__( 'Element below not show in detail post.', 'petro' ),
                        'vertical'=> true,
                        'fields'=>array(
                            'tags' => esc_html__('Post Tag','petro'),
                        )
                    ),
                )
            )

            )));

    $sidebar_args= array(
        array(
            'id'            => 'post_grid',
            'type'          => 'select',
            'title'         => esc_html__( 'Sidebar Width', 'petro' ),
            'description'   => esc_html__( '1 grid it\'s mean 8.33% of page width.', 'petro' ),
            'default'       => 4,
            'options'=>array(
                  2=>esc_html__("2 grids ( 16.66%)", 'petro'),
                  3=>esc_html__("3 grids ( 25.00%)", 'petro'),
                  4=> esc_html__("4 grids ( 33.33%)", 'petro'),
                  5=> esc_html__("5 grids ( 41.66%)", 'petro'),
                  6=> esc_html__("6 grids ( 50.00%)", 'petro'),
                ),
        ),
        array(
            'id'=>'sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Sidebar Position', 'petro'), 
            'subtitle'=>esc_html__('Select sidebar position as default','petro'),
            'options'=>array(
                'left'=>esc_html__('Left', 'petro'),
                'right'=>esc_html__('Right', 'petro'),
                'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        ),
        array(
            'id'=>'post_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Post Sidebar Position', 'petro'), 
            'subtitle'=>esc_html__('Select sidebar position for single post','petro'),
            'options'=>array(
                'left'=>esc_html__('Left', 'petro'),
                'right'=>esc_html__('Right', 'petro'),
                'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        ),
        array(
            'id'=>'author_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Author Sidebar Position', 'petro'), 
            'subtitle'=>esc_html__('Select sidebar position for author blog','petro'),
            'options'=>array(
                'left'=>esc_html__('Left', 'petro'),
                'right'=>esc_html__('Right', 'petro'),
                'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        ),
        array(
            'id'=>'category_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Category Sidebar Position', 'petro'), 
            'subtitle'=>esc_html__('Select sidebar position for post category','petro'),
            'options'=>array(
                'left'=>esc_html__('Left', 'petro'),
                'right'=>esc_html__('Right', 'petro'),
                'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        )

    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'sidebar-section-start',
        'title'    => esc_html__( 'Sidebar', 'petro' ),
        'desc' => esc_html__( 'Sidebar Settings.', 'petro' ),
        'subsection' => true,
        'fields'           => $sidebar_args
    ) );

     ThemegumRedux::setSection( $opt_name, array(
        'title' => esc_html__( 'Search Page', 'petro' ),
        'icon'  => 'el el-search',
        'customizer_width' => '400px',
        'id'    =>'search_page',
        'fields'=>array(
                array(
                'id'=>'search_sidebar_position',
                'type' => 'button_set',
                'title' => esc_html__('Sidebar Position', 'petro'), 
                'subtitle'=>esc_html__('Select sidebar position for search page','petro'),
                'options'=>array(
                    'left'=>esc_html__('Left', 'petro'),
                    'right'=>esc_html__('Right', 'petro'),
                    'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                    ),
                'multi_layout'=>'inline',
                'default'=>'left'
                ),
                array(
                    'id'=>'search_form_position',
                    'type' => 'button_set', 
                    'title' => esc_html__('Search Form Placement', 'petro'),
                    'subtitle'=> esc_html__('Search form placement.', 'petro'),
                    "default"=> 'content',
                    'options'=>array(
                          'header'=>esc_html__("Header", 'petro'),
                          'content'=>esc_html__("Content", 'petro'),
                          'hidden'=> esc_html__("Hidden", 'petro'),
                        ),
                    'multi_layout'=>'inline',
                ),  
                array(
                    'id'=>'search_heading_image',
                    'type' => 'media', 
                    'title' => esc_html__('Heading Image', 'petro'),
                    'subtitle'=>esc_html__('Select image using for heading backgound.','petro'),
                    'compiler' => true,
                    'description' => esc_html__('Recomended 1500px wide.','petro'),
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'=>'search_heading_title',
                    'type' => 'text',
                    'title' => esc_html__('Page Title','petro'),
                    'subtitle'=>esc_html__('Page title on search page result.','petro'),
                    'description'=>esc_html__('Leave blank for default title.','petro'),  
                    'default'=> '',
                ),
                array(
                    'id'       => 'search_hide_post_types',
                    'type'     => 'checkbox',
                    'title'    => esc_html__( 'Hidden From Search', 'petro' ),
                    'subtitle' => esc_html__( 'The selected post type will hidden from search result.', 'petro' ),
                    'desc'     => esc_html__( 'Checked for select', 'petro' ),
                    'data'     => 'post_type',
                    'args'    => array(
                        'exclude_from_search'=> false,
                    )
                ),
                array(
                    'id'=>'search-empty-text',
                    'type' => 'editor',
                    'title' => esc_html__('Custom Result Not Found Text', 'petro'), 
                    'subtitle' => esc_html__('Type in the text that will be show on empty search result if no Result Not Found Page selected.','petro'),
                    'default' => '',
                    'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => true),
                ),

            )
    ));


   if (function_exists('is_shop')){
         ThemegumRedux::setSection( $opt_name, array(
            'title' => esc_html__( 'Shop Settings', 'petro' ),
            'icon'  => 'el el-shopping-cart',
            'customizer_width' => '400px',
            'id'    =>'woocommerce',
            'fields'=>array(
                    array(
                    'id'=>'shop_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Shop Sidebar Position', 'petro'), 
                    'subtitle'=>esc_html__('Select sidebar position for shop page','petro'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'petro'),
                        'right'=>esc_html__('Right', 'petro'),
                        'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                    'id'=>'product_cat_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Category Sidebar Position', 'petro'), 
                    'subtitle'=>esc_html__('Select sidebar position for single shop category','petro'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'petro'),
                        'right'=>esc_html__('Right', 'petro'),
                        'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                    'id'=>'product_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Product Sidebar Position', 'petro'), 
                    'subtitle'=>esc_html__('Select sidebar position for single product','petro'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'petro'),
                        'right'=>esc_html__('Right', 'petro'),
                        'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                        'id'=>'shop_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Shop Products show at most','petro'),
                        'subtitle'=>esc_html__('Number of product on shop page.','petro'), 
                        'default'=> get_option('posts_per_page'),
                    ),
                    array(
                        'id'=>'shop_column',
                        'type' => 'select',
                        'title' => esc_html__('Shop Columns','petro'),
                        'subtitle'=>esc_html__('Number of columns on shop and shop category page.','petro'), 
                        'options'=>array(
                              2=>esc_html__("2 Columns", 'petro'),
                              3=> esc_html__("3 Columns", 'petro'),
                              4=> esc_html__("4 Columns", 'petro'),
                              5=> esc_html__("5 Columns", 'petro')
                            ),
                        'default'=> 3,
                    ),
                    array(
                      'title'    => esc_html__( 'Num Related/Upsell Product Show', 'petro' ),
                      'subtitle'     => esc_html__( 'This controls num related/Cross-sell product show', 'petro' ),
                      'id'       => 'loop_related_per_page',
                      'default'  => 3,
                      'type'     => 'slider',
                      'min'           => 1,
                      'step'          => 1,
                      'max'           => 12,
                    ),
                    array(
                    'title'    => esc_html__( 'Related/Upsell Product Display Columns', 'petro' ),
                    'subtitle'     => esc_html__( 'This controls num column related/upsell product display', 'petro' ),
                    'id'       => 'loop_related_columns',
                    'default'  => 3,
                    'type'     => 'select',
                    'options'  => array(
                              1=>esc_html__("1 Column", 'petro'),
                              2=>esc_html__("2 Columns", 'petro'),
                              3=> esc_html__("3 Columns", 'petro'),
                              4=> esc_html__("4 Columns", 'petro'),
                              5=> esc_html__("5 Columns", 'petro')
                    ),
                  ),
                    array(
                        'title'    => esc_html__( 'Cross Sell Display Product', 'petro' ),
                        'subtitle'     => esc_html__( 'This controls num cross sell product display', 'petro' ),
                        'id'       => 'loop_cross_sells_total',
                        'default'  => 3,
                        'type'     => 'slider',
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 12,
                  ),
                    array(
                        'title'    => esc_html__( 'Cross Sell Display Columns', 'petro' ),
                        'subtitle'     => esc_html__( 'This controls num column cross sell display', 'petro' ),
                        'id'       => 'loop_cross_sells_columns',
                        'default'  => 3,
                        'type'     => 'select',
                        'options'  => array(
                              1=>esc_html__("1 Column", 'petro'),
                              2=>esc_html__("2 Columns", 'petro'),
                              3=> esc_html__("3 Columns", 'petro'),
                              4=> esc_html__("4 Columns", 'petro'),
                              5=> esc_html__("5 Columns", 'petro')
                        ),
                  ),
                    array(
                        'id'=>'shop_heading_image',
                        'type' => 'media', 
                        'title' => esc_html__('Product Heading Image ( optional )', 'petro'),
                        'subtitle'=>esc_html__('Select image using for heading backgound.','petro'),
                        'compiler' => true,
                        'description' => esc_html__('Recomended 1500px wide.','petro'),
                        'default'=>array('url'=>''),
                    )



                )
        ));
    }

    if (class_exists('TG_Custom_Post')){
         ThemegumRedux::setSection( $opt_name, array(
            'title' => esc_html__( 'Portfolio', 'petro' ),
            'icon'  => 'el el-book',
            'customizer_width' => '400px',
            'id'    =>'portfolio',
            'fields'=>array(
                    array(
                        'id'=>'portfolio_fields',
                        'type' => 'icon_multi_text',
                        'title' => esc_html__('Portfolio Fields', 'petro'),
                        'subtitle'=> wp_kses( __('Manage the portfolio field. Must have field with name <strong>"url"</strong> for site project or <strong>"download"</strong> for download button link.','petro'), array('strong'=>array())),
                        'sortable' => true,
                        'fields'=> array(
                            'name' => esc_html__('Name', 'petro'),
                            'label' => esc_html__('Label', 'petro'),
                            ),
                        'default' => array('url'=>array('name'=>'url','label'=>esc_html__('Link Project','petro')))
                    ),
                    array(
                        'id'       => 'tg_custom_post-style-section',
                        'type'     => 'section',
                        'title'    => esc_html__( 'Single Page', 'petro' ),
                        'indent'   => false, 
                    ),
                    array(
                    'id'=>'tg_custom_post_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Sidebar Position', 'petro'), 
                    'subtitle'=>esc_html__('Select sidebar position for portfolio widget','petro'),
                    'description'=>esc_html__('Portfolio detail have same place with widget. Since page no sidebar, portfolio detail placed below main content.','petro'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'petro'),
                        'right'=>esc_html__('Right', 'petro'),
                        'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                        'id'=>'tg_custom_post_featured_image',
                        'type' => 'switch',
                        'title' => esc_html__('Featured Image as Heading', 'petro'), 
                        'subtitle'=>esc_html__('Using featured image as header image.','petro'),
                        "default"=> 0,
                        'on' => esc_html__('Yes', 'petro'),
                        'off' => esc_html__('No', 'petro')
                    ),
                    array(
                        'id'=>'tg_custom_post_heading_image',
                        'type' => 'media', 
                        'title' => esc_html__('Heading Image ( optional )', 'petro'),
                        'subtitle'=>esc_html__('Select image using for heading backgound.','petro'),
                        'compiler' => true,
                        'description' => esc_html__('Recomended 1500px wide.','petro'),
                        'default'=>array('url'=>''),
                    ),
                    array(
                    'id'=>'tg_custom_post_image_size',
                    'type' => 'button_set',
                    'title' => esc_html__('Image Size', 'petro'), 
                    'subtitle'=>esc_html__('Image size for detail portfolio','petro'),
                    'description'=>esc_html__('Custom size will generate new image size, maybe need more disk space.','petro'),
                    'options'=>array(
                        'medium'=>esc_html__('Medium', 'petro'),
                        'large'=>esc_html__('Large', 'petro'),
                        'full'=>esc_html__('Full', 'petro'),
                        'custom'=>esc_html__('Custom', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'full'
                    ),
                    array(
                      'title'    => esc_html__( 'Custom Size', 'petro' ),
                      'description'=>esc_html__('Wide x height, ex: 300x400, ','petro'),
                      'subtitle'     => esc_html__( 'Custom image size', 'petro' ),
                      'id'       => 'tg_custom_post_custom_image_size',
                      'default'  => '',
                      'type'     => 'text',
                      'required' => array( 'tg_custom_post_image_size', '=', array( 'custom') ),
                    ),

                    array(
                        'id'=>'tg_custom_post_hide_featured_image',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Featured Image', 'petro'), 
                        'subtitle'=>esc_html__('Hide featured image in portfolio detail.','petro'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'petro'),
                            '1'=>esc_html__('Yes', 'petro'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),
                    array(
                        'id'=>'hide_detail',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Detail', 'petro'), 
                        'subtitle'=>esc_html__('Hide project detail field.','petro'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'petro'),
                            '1'=>esc_html__('Yes', 'petro'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),
                    array(
                        'id'=>'hide_date',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Date', 'petro'), 
                        'subtitle'=>esc_html__('Hide date field.','petro'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'petro'),
                            '1'=>esc_html__('Yes', 'petro'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),
                    array(
                        'id'=>'hide_category',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Category', 'petro'), 
                        'subtitle'=>esc_html__('Hide category field.','petro'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'petro'),
                            '1'=>esc_html__('Yes', 'petro'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),

                    array(
                        'id'=>'hide_empty',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Empty Field', 'petro'), 
                        'subtitle'=>esc_html__('Hide the field if no value.','petro'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'petro'),
                            '1'=>esc_html__('Yes', 'petro'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),
                )
        ));



    }
    if (class_exists('petro_service')){

         ThemegumRedux::setSection( $opt_name, array(
            'title' => ucfirst(esc_html__('service','petro') ),
            'icon'  => 'el el-slideshare',
            'customizer_width' => '400px',
            'id'    =>'petro_service',
            'fields'=>array(
                    array(
                    'id'=>'petro_service_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Sidebar Position', 'petro'), 
                    'subtitle'=>esc_html__('Select sidebar position for widget','petro'),
                    'description'=>esc_html__('Service detail have same place with widget. Since page no sidebar, service detail placed below main content.','petro'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'petro'),
                        'right'=>esc_html__('Right', 'petro'),
                        'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                    'id'=>'service_cat_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Category Sidebar Position', 'petro'), 
                    'subtitle'=>esc_html__('Select sidebar position for widget','petro'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'petro'),
                        'right'=>esc_html__('Right', 'petro'),
                        'nosidebar'=>esc_html__('No Sidebar', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                        'id'=>'service_cat_grid_column',
                        'type' => 'button_set',
                        'title' => esc_html__('Category Blog Layout','petro'),
                        'subtitle'=>esc_html__('The number of grid columns for category & archive','petro'), 
                        'options'=>array(
                              1=>esc_html__("1 Columns", 'petro'),
                              2=>esc_html__("2 Columns", 'petro'),
                              3=> esc_html__("3 Columns", 'petro'),
                            ),
                        'default'=> 1,
                        'multi_layout'=>'inline',
                    ),
                    array(
                        'id'            => 'petro_service_layout',
                        'type'          => 'select',
                        'title'         => esc_html__( 'Category Layout', 'petro' ),
                        'description'   => esc_html__( 'The layout for category feed. Default feed view.', 'petro' ),
                        'default'       => '',
                        'options'=>array(
                              ''=>esc_html__("Feed ( default )", 'petro'),
                              '8'=> esc_html__('Image Top','petro'),
                              '9'=> esc_html__('Image Align Left','petro'),
                              '10'=> esc_html__('Image Align Right','petro'),
                              '1'=> esc_html__('Image Top (Animated)','petro'),
                              '2'=> esc_html__('Image Align Left (Animated)','petro'),
                              '3'=> esc_html__('Image Align Right (Animated)','petro'),
                              '4'=> esc_html__('Image Animated From left','petro'),
                              '5'=> esc_html__('Image Animated From Right','petro'),
                              '6'=> esc_html__('Image Centered with Edges','petro'),
                              '7'=> esc_html__('Large Image Content Animated ','petro')
                            )
                    ),

                    array(
                    'id'=>'petro_service_thumbnail',
                    'type' => 'button_set',
                    'title' => esc_html__('Thumbnail Size', 'petro'), 
                    'subtitle'=>esc_html__('Image size for service feed','petro'),
                    'description'=>esc_html__('Custom size will generate new image size, maybe need more disk space.','petro'),
                    'options'=>array(
                        'thumbnail'=>esc_html__('Thumbnail', 'petro'),
                        'medium'=>esc_html__('Medium', 'petro'),
                        'large'=>esc_html__('Large', 'petro'),
                        'full'=>esc_html__('Full', 'petro'),
                        'custom'=>esc_html__('Custom', 'petro'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'full'
                    ),
                    array(
                      'title'    => esc_html__( 'Custom Size', 'petro' ),
                      'description'=>esc_html__('Wide x height, ex: 300x400, ','petro'),
                      'subtitle'     => esc_html__( 'Custom image size', 'petro' ),
                      'id'       => 'petro_service_custom_image_size',
                      'default'  => '',
                      'type'     => 'text',
                      'required' => array( 'petro_service_thumbnail', '=', array( 'custom') ),
                    ),
                    array(
                        'id'=>'petro_service_word',
                        'type' => 'text',
                        'title' => esc_html__('Description Word Length','petro'),
                        'subtitle'=>esc_html__('Number of word length or the exceprt.','petro'), 
                        'default'=> '',
                    ),
                    array(
                        'id'=>'petro_service_featured_image',
                        'type' => 'switch',
                        'title' => esc_html__('Featured Image as Heading', 'petro'), 
                        'subtitle'=>esc_html__('Using featured image as header image.','petro'),
                        "default"=> 0,
                        'on' => esc_html__('Yes', 'petro'),
                        'off' => esc_html__('No', 'petro')
                    ),
                    array(
                        'id'=>'petro_service_heading_image',
                        'type' => 'media', 
                        'title' => esc_html__('Heading Image ( optional )', 'petro'),
                        'subtitle'=>esc_html__('Select image using for heading backgound.','petro'),
                        'compiler' => true,
                        'description' => esc_html__('Recomended 1500px wide.','petro'),
                        'default'=>array('url'=>''),
                    ),
                    array(
                        'id'=>'petro_service_hide_featured_image',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Featured Image', 'petro'), 
                        'subtitle'=>esc_html__('Hide featured image in service detail.','petro'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'petro'),
                            '1'=>esc_html__('Yes', 'petro'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),


                )
        ));


    }


    ThemegumRedux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Slides', 'petro' ),
        'id'         => 'slides-show',
        'desc'       => esc_html__( 'Slides show.', 'petro' ),
        'fields'     => array(
            array(
                'id'          => 'petro-slides',
                'type'        => 'petro_slides',
                'title'       => esc_html__( 'Slides Options', 'petro' ),
                'subtitle'    => esc_html__( 'Unlimited slides with drag and drop sortings.', 'petro' ),
                'placeholder' => array(
                    'title'       => esc_html__( 'Title text', 'petro' ),
                    'description' => esc_html__( 'Description text', 'petro' ),
                    'url'         => esc_html__( '1st button link!', 'petro' ),
                    'url2'         => esc_html__( '2nd button link!', 'petro' ),
                ),
            ),
        )
    ) );


    ThemegumRedux::setSection( $opt_name, array(
        'title' => esc_html__( 'Footer', 'petro' ),
        'icon'  => 'el el-photo',
        'customizer_width' => '400px',
        'id'    =>'footer'
    ));


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'footer-section-start',
        'title'    => esc_html__( 'Footer Option', 'petro' ),
        'subsection' => true,
        'fields'           => array(
            array(
                'id'=>'footer-type',
                'type' => 'button_set', 
                'title' => esc_html__('Footer Source', 'petro'),
                'subtitle'=> esc_html__('Selec the footer content source.', 'petro'),
                "default"=> 'option',
                'options'=>array(
                    'page' => esc_html__('Page', 'petro'),
                    'option' => esc_html__('Options', 'petro')
                )
            ),  
            array(
                'id'       => 'footer-page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Footer Page (default)', 'petro' ),
                'subtitle' => esc_html__( 'Content will displayed as footer section', 'petro' ),
                'desc'     => esc_html__( 'Create a page first.', 'petro' ),
                'required' => array( 'footer-type', '=', array( 'page') )
            ),
            array(
                'id'       => 'footer-pages',
                'type'     => 'select',
                'data'     => 'pages',
                'multi'    => true,
                'sortable' => true,
                'title'    => esc_html__( 'Footer Template', 'petro' ),
                'subtitle' => esc_html__( 'Footer option will show in each page. You can assigned different footer each page.', 'petro' ),
                'desc'     => esc_html__( 'Create a page first.', 'petro' ),
                'required' => array( 'footer-type', '=', array( 'page') )
            ),
            array(
                'id'       => 'pre-footer-page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Pre Footer Page (default)', 'petro' ),
                'subtitle' => esc_html__( 'Content will displayed before footer section', 'petro' ),
                'desc'     => esc_html__( 'If no page selected, system will display Pre-Footer Text.', 'petro' ),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'pre-footer-pages',
                'type'     => 'select',
                'data'     => 'pages',
                'multi'    => true,
                'sortable' => true,
                'title'    => esc_html__( 'Pre Footer Template', 'petro' ),
                'subtitle' => esc_html__( 'Option will show in each page. You can assigned different pre footer each page.', 'petro' ),
                'desc'     => esc_html__( 'Create a page first.', 'petro' ),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'pre-footer-text',
                'type' => 'editor',
                'title' => esc_html__('Pre-Footer Text', 'petro'), 
                'subtitle' => esc_html__('Type in the text that will be show on side of bottom widget area. You also can using shortcode ex: [tags] for display tag widget.','petro'),
                'default' => '',
                'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'prefooter-bgcolor',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Pree-Footer Area Background Color', 'petro' ),
                'subtitle' => esc_html__( 'Pick a background color for the pree-footer area', 'petro' ),
                'default'  => array('color'=>'#041e42','alpha'=>1),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'prefooter-color',
                'type'     => 'color',
                'transparent' => false,
                'title'    => esc_html__( 'Pree-Footer Area Color', 'petro' ),
                'subtitle' => esc_html__( 'Pick a color for the pree-footer area', 'petro' ),
                'default'  => '#ffffff',
                'required' => array( 'footer-type', '=', array( 'option') )
            )

        )));

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'iconfield-section-start',
        'title'    => esc_html__( 'Icon Boxes Section', 'petro' ),
        'desc' => esc_html__( 'The content will show on before footer widget area.', 'petro' ),
        'subsection' => true,
        'fields'           => array(
            array(
                'id'=>'showcontactcard',
                'type' => 'switch', 
                'title' => esc_html__('Icon Boxes Section', 'petro'),
                'subtitle'=> esc_html__('Show or hidden icon box section', 'petro'),
                "default"=> 1,
                'on' => esc_html__('Show', 'petro'),
                'off' => esc_html__('Hidden', 'petro'),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),  
            array(
                'id'=>'footer_icon_fields',
                'type' => 'icon_multi_text',
                'title' => esc_html__('Icon Boxes', 'petro'),
                'subtitle'=>esc_html__('Manage the navigation icon box on footer. 3 icon boxes each row.','petro'),
                'sortable' => true,
                'fields'=> array(
                    'label' => esc_html__('Title', 'petro'),
                    'text' => esc_html__('Text', 'petro'),
                    ),
                'required' => array( 'footer-type', '=', array( 'option') )
            ))));

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'widget-section-start',
        'title'    => esc_html__( 'Widget Section', 'petro' ),
        'desc' => esc_html__( 'The content will show on bottom of footer area.', 'petro' ),
        'subsection' => true,
        'fields'           => array(
            array(
                'id'=>'showwidgetarea',
                'type' => 'switch', 
                'title' => esc_html__('Widget Area', 'petro'),
                'subtitle'=> esc_html__('Enable or Disable footer', 'petro'),
                "default"=> 1,
                'on' => esc_html__('On', 'petro'),
                'off' => esc_html__('Off', 'petro'),
                'required' => array( 'footer-type', '=', array( 'option') )

            ),  
            array(
                'id'=>'footer-widget-column',
                'type' => 'button_set',
                'title' => esc_html__('Footer Widget Columns', 'petro'), 
                'subtitle'=> wp_kses_post( __('Select number of column for the footer widget <br>You can set the footer widget on Appearance > Widgets > Bottom Widget Area','petro')),
                'options'=>array(1=>esc_html__('One Column', 'petro'),
                    2=>esc_html__('Two Columns', 'petro'),
                    3=>esc_html__('Three Columns', 'petro'),
                    4=>esc_html__('Four Columns', 'petro')
                    ),
                'multi_layout'=>'inline',
                'required' => array( 'footer-type', '=', array( 'option') ),
                'default'=>3,

            ),
            array(
                'id'            => 'footer-text-grid',
                'type'          => 'slider',
                'title'         => esc_html__( 'Footer Text Width', 'petro' ),
                'description'      => esc_html__( '12 grids it\'s mean 100% of page width.', 'petro' ),
                'default'       => 3,
                'min'           => 1,
                'step'          => 1,
                'max'           => 12,
                'display_value' => 'text',

            ),
            array(
                'id'=>'footer-text-position',
                'type' => 'button_set', 
                'title' => esc_html__('Footer Text Position', 'petro'),
                'subtitle'=> esc_html__('The position of text, on left widget area or right widget area.', 'petro'),
                "default"=> 'left',
                'multi_layout'=>'inline',
                'options'  => array(
                    'left'     => esc_html__('Left', 'petro'),
                    'right' => esc_html__('Right', 'petro'),
                    ),
                'required' => array( 'footer-type', '=', array( 'option') )

            ),  
            array(
                'id'=>'footer-text',
                'type' => 'editor',
                'title' => esc_html__('Footer Text', 'petro'), 
                'subtitle' => wp_kses( __('Type in the text that will be show on side of bottom widget area. You also can using shortcode ex: [tags][socials] for display tag widget.','petro'),array('a'=>array('href'=>array(),'target'=>array()))),
                'default' => '',
                'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'bottom-widget-bgcolor',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Bottom Widget Background Color', 'petro' ),
                'subtitle' => esc_html__( 'Pick a background color for the bottom widget area', 'petro' ),
                'default'  => array('color'=>'#041e42','alpha'=>1),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'bottom-widget-color',
                'type'     => 'color',
                'transparent' => false,
                'title'    => esc_html__( 'Bottom Widget Color', 'petro' ),
                'subtitle' => esc_html__( 'Pick a color for the bottom widget area', 'petro' ),
                'default'  => '#ffffff',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'widget-layout-mode',
                'type' => 'button_set',
                'title' => esc_html__('Layout Mode', 'petro'), 
                'subtitle'=> '',
                'options'=>array(
                    ''=>esc_html__('Default', 'petro'),
                    'wide'=>esc_html__('Wide', 'petro'),
                    'boxed'=>esc_html__('Boxed', 'petro'),
                    ),
                'multi_layout'=>'inline',
                'default'=>'',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),

    )));


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'copyright-section-start',
        'title'    => esc_html__( 'Copyright Section', 'petro' ),
        'desc' => esc_html__( 'The content will show on bottom of footer area.', 'petro' ),
        'subsection' => true,
        'fields'           => array(            
            array(
                'id'=>'footer-copyright-text',
                'type' => 'editor',
                'title' => esc_html__('Left Content', 'petro'), 
                'subtitle' => esc_html__('Type in the text that will be show on footer area. You also can using shortcode ex: [tags][socials] for display tag widget.','petro'),
                'default' => '&copy; '.date('Y').' '.sprintf(esc_html__('%s, The Awesome Theme. All right reserved.','petro'),get_template()),
                'editor_options'=>array( 'media_buttons' => false, 'tinymce' => false,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'right-copyright-text',
                'type' => 'editor',
                'title' => esc_html__('Right Content', 'petro'), 
                'subtitle' => esc_html__('Type in the text that will be show on footer area. You also can using shortcode ex: [tags][socials] for display tag widget.','petro'),
                'default' => '',
                'editor_options'=>array( 'media_buttons' => false, 'tinymce' => false,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'            => 'footer-copyright-grid',
                'type'          => 'slider',
                'title'         => esc_html__( 'Left Content Width', 'petro' ),
                'description'      => esc_html__( '12 grids it\'s mean 100% of page width.', 'petro' ),
                'default'       => 12,
                'min'           => 1,
                'step'          => 1,
                'max'           => 12,
                'display_value' => 'text',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'footer-bgcolor',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Footer Background Color', 'petro' ),
                'subtitle' => esc_html__( 'Pick a background color for the footer area', 'petro' ),
                'default'  => array('color'=>'#041e42','alpha'=>1),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'footer-text-color',
                'type'     => 'color',
                'transparent' => false,
                'title'    => esc_html__( 'Footer Text Color', 'petro' ),
                'subtitle' => esc_html__( 'Pick a color for the footer text.', 'petro' ),
                'default'  => '#ffffff',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'copyright-layout-mode',
                'type' => 'button_set',
                'title' => esc_html__('Layout Mode', 'petro'), 
                'subtitle'=> '',
                'options'=>array(
                    ''=>esc_html__('Default', 'petro'),
                    'wide'=>esc_html__('Wide', 'petro'),
                    'boxed'=>esc_html__('Boxed', 'petro'),
                    ),
                'multi_layout'=>'inline',
                'default'=>'',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
        )
    ) );


    ThemegumRedux::setSection( $opt_name, array(
        'title' => esc_html__( 'Advanced', 'petro' ),
        'icon'  => 'el el-wrench',
        'customizer_width' => '400px',
        'id'    =>'advance',
        'fields'=>array(
            array(
                'id'=>'purchase_number',
                'type' => 'password', 
                'title' => esc_html__('Item Purchase Number', 'petro'),
                'description'=>sprintf(esc_html__('purchase number from %s. ex:xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'petro'),"themeforest.net"),
                'default'=>"",
             ),
            array(
                'id'       => '404-page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Custom 404 Page', 'petro' ),
                'subtitle' => esc_html__( 'Select a page as 404 error message', 'petro' ),
            ),
             array(
                'id'=>'js-code',
                'type' => 'ace_editor',
                'title' => esc_html__('Javascript Code', 'petro'), 
                'subtitle' => esc_html__('Put your javascript code here.', 'petro'),
                'mode' => 'javascript',
                'theme' => 'monokai',
                'default' => ""
                ),
            array(
                'id'=>'devmode',
                'type' => 'switch', 
                'title' => esc_html__('Development Mode', 'petro'),
                'subtitle'=> esc_html__('Custom css style and custom style will embed in-page.', 'petro'),
                "default"=> 0,
                'on' => esc_html__('Yes', 'petro'),
                'off' => esc_html__('No', 'petro')
            ),  

        )
    ) );

function petro_translateable_config(){

    return array(
        'footer-text',
        'footer-copyright-text',
        'right-copyright-text',
        'pre-footer-text',
        'icon-text-module',
        'text-module',
        'toggle_text',
        'top-bar-text-1',
        'top-bar-text-2',
        'pre-footer-text',
        'search-empty-text',
        'search_heading_title',
        'quote_menu_label'
    );
}


function petro_custom_variable($options=array()){

    global $wp_filesystem;

    $blog_id="";
    if ( is_multisite()){
        $blog_id="-site".get_current_blog_id();
    }

    if(isset($options['logo_image'])){
        $logo_id = isset($options['logo_image']['id']) ? $options['logo_image']['id'] : '';
        set_theme_mod( 'custom_logo', $logo_id );
    }

    if(isset($options['logo_image_alt'])){
        $logo_alt_id = isset($options['logo_image_alt']['id']) ? $options['logo_image_alt']['id'] : '';
        set_theme_mod( 'custom_logo_alt', $logo_alt_id );
    }

    if(isset($options['heading_image'])){

        $header_image_data =  wp_parse_args($options['heading_image'] , array('id'=>'','url'=>''));
        $header_image_data['attachment_id'] = $header_image_data['id'] ;

        set_theme_mod( 'header_image', esc_url_raw( $header_image_data['url'] ) );
        set_theme_mod( 'header_image_data', (object) $header_image_data );
    }


    /* pre-footer text */

    if(isset($options['pre-footer-page'])){

        $page_id =  absint($options['pre-footer-page']);
        $page = get_post($page_id);
        $footer_text = "";

        if(!empty( $page ) && is_object($page)){
            $footer_text = $page->post_content;

        }

        set_theme_mod( 'footer_content', $footer_text );
    }
  
    $filename = get_template_directory() . '/css/style'.$blog_id.'.css';

    ob_start();

    if(isset($options['site-title'])){
        $sitetitle = isset($options['site-title']) ? $options['site-title'] : '';
        update_option( 'blogname', $sitetitle );
    }

    if(isset($options['site-tagline'])){
        $blogdescription = isset($options['site-tagline']) ? $options['site-tagline'] : '';
        update_option( 'blogdescription', $blogdescription );
    }

    do_action('petro_change_style', $options);
    $cssline= ob_get_clean();

    set_theme_mod( 'custom_css', $cssline );

    if ( !$wp_filesystem->put_contents( $filename, $cssline) ) {
        $error = $wp_filesystem->errors;

        update_option( 'css_folder_writeable', false);

        if('empty_hostname'==$error->get_error_code()){
            $wp_filesystem=new WP_Filesystem_Direct(array());
            if($wp_filesystem){
                if(!$wp_filesystem->put_contents( $filename, $cssline)){
                        $error = $wp_filesystem->errors;
                        return new WP_Error('fs_error', esc_html__('Filesystem error.','petro'), $error);
                }

            }else{
                return new WP_Error('fs_error', esc_html__('Filesystem error.','petro'), $wp_filesystem->errors);
            }


        }else{

            return new WP_Error('fs_error', esc_html__('Filesystem error.','petro'), $error);
        }
    }
    else{
        update_option( 'css_folder_writeable', true);
    }

}

add_action('redux-saved-'.redux_opt_name(), 'petro_custom_variable', 1);

?>