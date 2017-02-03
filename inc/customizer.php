<?php
/*
*  Setting for wordpress customizer
*/

    /*
    * add the custom background
    */
    $defaults = array(
        'wp-head-callback'       => '_custom_background_cb',
    );
    add_theme_support( 'custom-background', $defaults );


    /*
    * Register the customizer settings
    */
    function VdotZero_customize_register( $wp_customize ) {
        
        $theme = wp_get_theme();
        $settings = sanitize_title($theme);
        
      // Do stuff with $wp_customize, the WP_Customize_Manager object.
        $wp_customize->add_section( 'social_links', array(
          'title' => __( 'Social Links' ),
          'description' => __( 'Adding a link to your social networks here, and icons on the page sidebar.' ),
        ) );

        $social_networks = array ('linkedin', 'facebook', 'instagram', 'twitter', 'vimeo', 'youtube', 'stack-overflow', 'github');
        foreach($social_networks as $social_network) {
            $wp_customize->add_setting( $settings.'-sociallinks['.$social_network.']', array(
                'type' => 'option', // or 'option'
                'capability' => 'edit_theme_options',
            ) );
            $wp_customize->add_control( $settings.'-sociallinks['.$social_network.']', array (
                'type' => 'text',
                'priority' => 10,
                'section' => 'social_links',
                //'settings' => $settings.'-sociallinks["linkedin"]',
                'label' => __( $social_network ),
            ) );
        }    
        
        //add the custom logo
        $wp_customize->add_setting( 'site_logo' ); // Add setting for logo uploader
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_logo', array(
            'label'    => __( 'Upload Logo (above text)', 'vdotzero' ),
            'section'  => 'title_tagline',
            'settings' => 'site_logo',
        ) ) );
        
        
        //add the color pickers for sidebar and sidebar links
        $wp_customize->add_setting( 'sidebar_color' );
        
        $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 'sidebar_color', array(
            'label'        => __( 'Sidebar Color', 'vdotzero' ),
            'section'    => 'colors',
            'settings'   => 'sidebar_color',
        ) ) );
        
        $wp_customize->add_setting( 'sidebar_link_color' );
        
        $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 'sidebar_link_color', array(
            'label'        => __( 'Sidebar Link Color', 'vdotzero' ),
            'section'    => 'colors',
            'settings'   => 'sidebar_link_color',
        ) ) );
        
    }
    add_action( 'customize_register', 'VdotZero_customize_register' );

    
    /*****************************/
    /*   Add the Css to the head   */
    /*****************************/

    function mytheme_customize_css(){
        echo '<style type="text/css">
             #sidebar { background-color:' . get_theme_mod("sidebar_color", "#ffffff"). ';}
             #sidebar a { color: ' . get_theme_mod("sidebar_link_color", "#222222"). ';}
         </style>';
    }
   add_action( 'wp_head', 'mytheme_customize_css');

?>