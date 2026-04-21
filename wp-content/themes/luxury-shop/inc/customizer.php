<?php
/**
 * Luxury Shop Theme Customizer.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package luxury_shop
 */

if( ! function_exists( 'luxury_shop_customize_register' ) ):  
/**
 * Add postMessage support for site title and description for the Theme Customizer.F
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function luxury_shop_customize_register( $wp_customize ) {
    require get_parent_theme_file_path('/inc/controls/changeable-icon.php');
    
    require get_parent_theme_file_path('/inc/controls/sortable-control.php');
    
    //Register the sortable control type.
    $wp_customize->register_control_type( 'Luxury_Shop_Control_Sortable' ); 

    if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
        $wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'luxury-shop' );
    }
	
    /* Option list of all post */	
    $luxury_shop_options_posts = array();
    $luxury_shop_options_posts_obj = get_posts('posts_per_page=-1');
    $luxury_shop_options_posts[''] = esc_html__( 'Choose Post', 'luxury-shop' );
    foreach ( $luxury_shop_options_posts_obj as $luxury_shop_posts ) {
    	$luxury_shop_options_posts[$luxury_shop_posts->ID] = $luxury_shop_posts->post_title;
    }
    
    /* Option list of all categories */
    $luxury_shop_args = array(
	   'type'                     => 'post',
	   'orderby'                  => 'name',
	   'order'                    => 'ASC',
	   'hide_empty'               => 1,
	   'hierarchical'             => 1,
	   'taxonomy'                 => 'category'
    ); 
    $luxury_shop_option_categories = array();
    $luxury_shop_category_lists = get_categories( $luxury_shop_args );
    $luxury_shop_option_categories[''] = esc_html__( 'Choose Category', 'luxury-shop' );
    foreach( $luxury_shop_category_lists as $luxury_shop_category ){
        $luxury_shop_option_categories[$luxury_shop_category->term_id] = $luxury_shop_category->name;
    }
    
    /** Default Settings */    
    $wp_customize->add_panel( 
        'wp_default_panel',
         array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Default Settings', 'luxury-shop' ),
            'description' => esc_html__( 'Default section provided by wordpress customizer.', 'luxury-shop' ),
        ) 
    );
    
    $wp_customize->get_section( 'title_tagline' )->panel                  = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel                         = 'wp_default_panel';
    $wp_customize->get_section( 'header_image' )->panel                   = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel               = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel              = 'wp_default_panel';
    
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
    /** Default Settings Ends */
    
    /** Site Title control */
    $wp_customize->add_setting( 
        'header_site_title', 
        array(
            'default'           => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'header_site_title',
        array(
            'label'       => __( 'Show / Hide Site Title', 'luxury-shop' ),
            'section'     => 'title_tagline',
            'type'        => 'checkbox',
        )
    );

    /** Tagline control */
    $wp_customize->add_setting( 
        'header_tagline', 
        array(
            'default'           => false,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'header_tagline',
        array(
            'label'       => __( 'Show / Hide Tagline', 'luxury-shop' ),
            'section'     => 'title_tagline',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting('logo_width', array(
        'sanitize_callback' => 'absint', 
    ));

    // Add a control for logo width
    $wp_customize->add_control('logo_width', array(
        'label' => __('Logo Width', 'luxury-shop'),
        'section' => 'title_tagline',
        'type' => 'number',
        'input_attrs' => array(
            'min' => '50', 
            'max' => '500', 
            'step' => '5', 
    ),
        'default' => '100', 
    ));

    $wp_customize->add_setting( 'luxury_shop_site_title_size', array(
        'default'           => 30, // Default font size in pixels
        'sanitize_callback' => 'absint', // Sanitize the input as a positive integer
    ) );

    // Add control for site title size
    $wp_customize->add_control( 'luxury_shop_site_title_size', array(
        'type'        => 'number',
        'section'     => 'title_tagline', // You can change this section to your preferred section
        'label'       => __( 'Site Title Font Size (px)', 'luxury-shop' ),
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 1,
        ),
    ) );

    //Global Color
    $wp_customize->add_section(
        'luxury_shop_global_color',
        array(
            'title' => esc_html__( 'Global Color Settings', 'luxury-shop' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_general_settings',
        )
    );

    $wp_customize->add_setting('luxury_shop_primary_color', array(
        'default'           => '#ECAF26',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'luxury_shop_primary_color', array(
        'label'    => __('Theme Primary Color', 'luxury-shop'),
        'section'  => 'luxury_shop_global_color',
        'settings' => 'luxury_shop_primary_color',
    )));    


    /** Home Page Settings */
    $wp_customize->add_panel( 
        'luxury_shop_post_settings',
         array(
            'priority' => 11,
            'capability' => 'edit_theme_options',
            'title' => esc_html__( 'Post & Pages Settings', 'luxury-shop' ),
            'description' => esc_html__( 'Customize Post & Pages Settings', 'luxury-shop' ),
        ) 
    );

    /** Post Layouts */
    
    $wp_customize->add_section(
        'luxury_shop_post_layout_section',
        array(
            'title' => esc_html__( 'Post Layout Settings', 'luxury-shop' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_post_settings',
        )
    );

    $wp_customize->add_setting('luxury_shop_post_layout_setting', array(
        'default'           => 'right-sidebar',
        'sanitize_callback' => 'luxury_shop_sanitize_post_layout',
    ));

    $wp_customize->add_control('luxury_shop_post_layout_setting', array(
        'label'    => __('Post Column Settings', 'luxury-shop'),
        'section'  => 'luxury_shop_post_layout_section',
        'settings' => 'luxury_shop_post_layout_setting',
        'type'     => 'select',
        'choices'  => array(        
            'right-sidebar'   => __('Right Sidebar', 'luxury-shop'),
            'left-sidebar'   => __('Left Sidebar', 'luxury-shop'),
            'one-column'   => __('One Column', 'luxury-shop'),
            'three-column'   => __('Three Columns', 'luxury-shop'),
            'four-column'   => __('Four Columns', 'luxury-shop'),
            'grid-layout'   => __('Grid Layout', 'luxury-shop')
        ),
    ));

     /** Post Layouts Ends */

    /** Blog Content Alignment */
    $wp_customize->add_setting('luxury_shop_blog_layout_option', array(
        'default'           => 'Left',
        'sanitize_callback' => 'luxury_shop_sanitize_choices',
    ));

    $wp_customize->add_control('luxury_shop_blog_layout_option', array(
        'label'    => __('Post Content Alignment', 'luxury-shop'),
        'section'  => 'luxury_shop_post_layout_section',
        'settings' => 'luxury_shop_blog_layout_option',
        'type'     => 'select',
        'choices'  => array(
		   'Left'     => __('Left', 'luxury-shop'),
		   'Center'     => __('Center', 'luxury-shop'),
		   'Right'     => __('Right', 'luxury-shop'),
        ),
    ));
     
    /** Post Settings */
    $wp_customize->add_section(
        'luxury_shop_post_settings',
        array(
            'title' => esc_html__( 'Post Settings', 'luxury-shop' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_post_settings',
        )
    );

    /** Post Heading control */
    $wp_customize->add_setting( 
        'luxury_shop_post_heading_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_post_heading_setting',
        array(
            'label'       => __( 'Show / Hide Post Heading', 'luxury-shop' ),
            'section'     => 'luxury_shop_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Meta control */
    $wp_customize->add_setting( 
        'luxury_shop_post_meta_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_post_meta_setting',
        array(
            'label'       => __( 'Show / Hide Post Meta', 'luxury-shop' ),
            'section'     => 'luxury_shop_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Image control */
    $wp_customize->add_setting( 
        'luxury_shop_post_image_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_post_image_setting',
        array(
            'label'       => __( 'Show / Hide Post Image', 'luxury-shop' ),
            'section'     => 'luxury_shop_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Content control */
    $wp_customize->add_setting( 
        'luxury_shop_post_content_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_post_content_setting',
        array(
            'label'       => __( 'Show / Hide Post Content', 'luxury-shop' ),
            'section'     => 'luxury_shop_post_settings',
            'type'        => 'checkbox',
        )
    );
    /** Post ReadMore control */
     $wp_customize->add_setting( 'luxury_shop_read_more_setting', array(
        'default'           => true,
        'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'luxury_shop_read_more_setting', array(
        'type'        => 'checkbox',
        'section'     => 'luxury_shop_post_settings', 
        'label'       => __( 'Display Read More Button', 'luxury-shop' ),
    ) );

    /** Post Settings Ends */

     /** Single Post Settings */
    $wp_customize->add_section(
        'luxury_shop_single_post_settings',
        array(
            'title' => esc_html__( 'Single Post Settings', 'luxury-shop' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_post_settings',
        )
    );

    /** Single Post Meta control */
    $wp_customize->add_setting( 
        'luxury_shop_single_post_meta_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_single_post_meta_setting',
        array(
            'label'       => __( 'Show / Hide Single Post Meta', 'luxury-shop' ),
            'section'     => 'luxury_shop_single_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Single Post Content control */
    $wp_customize->add_setting( 
        'luxury_shop_single_post_content_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_single_post_content_setting',
        array(
            'label'       => __( 'Show / Hide Single Post Content', 'luxury-shop' ),
            'section'     => 'luxury_shop_single_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Single Post Settings Ends */

         // Typography Settings Section
    $wp_customize->add_section('luxury_shop_typography_settings', array(
        'title'      => esc_html__('Typography Settings', 'luxury-shop'),
        'priority'   => 30,
        'capability' => 'edit_theme_options',
        'panel' => 'luxury_shop_general_settings',
    ));

    // Array of fonts to choose from
    $font_choices = array(
        ''               => __('Select', 'luxury-shop'),
        'Arial'          => 'Arial, sans-serif',
        'Verdana'        => 'Verdana, sans-serif',
        'Helvetica'      => 'Helvetica, sans-serif',
        'Times New Roman'=> '"Times New Roman", serif',
        'Georgia'        => 'Georgia, serif',
        'Courier New'    => '"Courier New", monospace',
        'Trebuchet MS'   => '"Trebuchet MS", sans-serif',
        'Tahoma'         => 'Tahoma, sans-serif',
        'Palatino'       => '"Palatino Linotype", serif',
        'Garamond'       => 'Garamond, serif',
        'Impact'         => 'Impact, sans-serif',
        'Comic Sans MS'  => '"Comic Sans MS", cursive, sans-serif',
        'Lucida Sans'    => '"Lucida Sans Unicode", sans-serif',
        'Arial Black'    => '"Arial Black", sans-serif',
        'Gill Sans'      => '"Gill Sans", sans-serif',
        'Segoe UI'       => '"Segoe UI", sans-serif',
        'Open Sans'      => '"Open Sans", sans-serif',
        'Roboto'         => 'Roboto, sans-serif',
        'Lato'           => 'Lato, sans-serif',
        'Montserrat'     => 'Montserrat, sans-serif',
        'Libre Baskerville' => 'Libre Baskerville',
    );

    // Heading Font Setting
    $wp_customize->add_setting('luxury_shop_heading_font_family', array(
        'default'           => '',
        'sanitize_callback' => 'luxury_shop_sanitize_choicess',
    ));
    $wp_customize->add_control('luxury_shop_heading_font_family', array(
        'type'    => 'select',
        'choices' => $font_choices,
        'label'   => __('Select Font for Heading', 'luxury-shop'),
        'section' => 'luxury_shop_typography_settings',
    ));

    // Body Font Setting
    $wp_customize->add_setting('luxury_shop_body_font_family', array(
        'default'           => '',
        'sanitize_callback' => 'luxury_shop_sanitize_choicess',
    ));
    $wp_customize->add_control('luxury_shop_body_font_family', array(
        'type'    => 'select',
        'choices' => $font_choices,
        'label'   => __('Select Font for Body', 'luxury-shop'),
        'section' => 'luxury_shop_typography_settings',
    ));

    /** Typography Settings Section End */

        /** Home Page Settings */
    $wp_customize->add_panel( 
        'luxury_shop_general_settings',
         array(
            'priority' => 9,
            'capability' => 'edit_theme_options',
            'title' => esc_html__( 'General Settings', 'luxury-shop' ),
            'description' => esc_html__( 'Customize General Settings', 'luxury-shop' ),
        ) 
    );

    /** General Settings */
    $wp_customize->add_section(
        'luxury_shop_general_settings',
        array(
            'title' => esc_html__( 'Loader Settings', 'luxury-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_general_settings',
        )
    );

    /** Preloader control */
    $wp_customize->add_setting( 
        'luxury_shop_header_preloader', 
        array(
            'default' => false,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_header_preloader',
        array(
            'label'       => __( 'Show Preloader', 'luxury-shop' ),
            'section'     => 'luxury_shop_general_settings',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting('luxury_shop_loader_layout_setting', array(
        'default' => 'load',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add control for loader layout
    $wp_customize->add_control('luxury_shop_loader_layout_control', array(
        'label' => __('Preloader Layout', 'luxury-shop'),
        'section' => 'luxury_shop_general_settings',
        'settings' => 'luxury_shop_loader_layout_setting',
        'type' => 'select',
        'choices' => array(
            'load' => __('Preloader 1', 'luxury-shop'),
            'load-one' => __('Preloader 2', 'luxury-shop'),
            'ctn-preloader' => __('Preloader 3', 'luxury-shop'),
        ),
    ));

    /** Header Section Settings */
    $wp_customize->add_section(
        'luxury_shop_header_section_settings',
        array(
            'title' => esc_html__( 'Header Section Settings', 'luxury-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_home_page_settings',
        )
    );

    $wp_customize->add_setting( 
        'luxury_shop_show_hide_search', 
        array(
            'default' => false ,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_show_hide_search',
        array(
            'label'       => __( 'Show Search Feild', 'luxury-shop' ),
            'section'     => 'luxury_shop_header_section_settings',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting( 
        'luxury_shop_show_hide_toggle', 
        array(
            'default' => false ,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_show_hide_toggle',
        array(
            'label'       => __( 'Show Toggle', 'luxury-shop' ),
            'section'     => 'luxury_shop_header_section_settings',
            'type'        => 'checkbox',
        )
    );

    /** Sticky Header control */
    $wp_customize->add_setting( 
        'luxury_shop_sticky_header', 
        array(
            'default' => false,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_sticky_header',
        array(
            'label'       => __( 'Show Sticky Header', 'luxury-shop' ),
            'section'     => 'luxury_shop_header_section_settings',
            'type'        => 'checkbox',
        )
    );

    // Add Setting for Menu Font Weight
    $wp_customize->add_setting( 'luxury_shop_menu_font_weight', array(
        'default'           => '400',
        'sanitize_callback' => 'luxury_shop_sanitize_font_weight',
    ) );

    // Add Control for Menu Font Weight
    $wp_customize->add_control( 'luxury_shop_menu_font_weight', array(
        'label'    => __( 'Menu Font Weight', 'luxury-shop' ),
        'section'  => 'luxury_shop_header_section_settings',
        'type'     => 'select',
        'choices'  => array(
            '100' => __( '100 - Thin', 'luxury-shop' ),
            '200' => __( '200 - Extra Light', 'luxury-shop' ),
            '300' => __( '300 - Light', 'luxury-shop' ),
            '400' => __( '400 - Normal', 'luxury-shop' ),
            '500' => __( '500 - Medium', 'luxury-shop' ),
            '600' => __( '600 - Semi Bold', 'luxury-shop' ),
            '700' => __( '700 - Bold', 'luxury-shop' ),
            '800' => __( '800 - Extra Bold', 'luxury-shop' ),
            '900' => __( '900 - Black', 'luxury-shop' ),
        ),
    ) );

    // Add Setting for Menu Text Transform
    $wp_customize->add_setting( 'luxury_shop_menu_text_transform', array(
        'default'           => 'Capitalize',
        'sanitize_callback' => 'luxury_shop_sanitize_text_transform',
    ) );

    // Add Control for Menu Text Transform
    $wp_customize->add_control( 'luxury_shop_menu_text_transform', array(
        'label'    => __( 'Menu Text Transform', 'luxury-shop' ),
        'section'  => 'luxury_shop_header_section_settings',
        'type'     => 'select',
        'choices'  => array(
            'none'       => __( 'None', 'luxury-shop' ),
            'capitalize' => __( 'Capitalize', 'luxury-shop' ),
            'uppercase'  => __( 'Uppercase', 'luxury-shop' ),
            'lowercase'  => __( 'Lowercase', 'luxury-shop' ),
        ),
    ) );

    $wp_customize->add_setting('luxury_shop_menus_style',array(
        'default' => '',
        'sanitize_callback' => 'luxury_shop_sanitize_choices'
	));
	$wp_customize->add_control('luxury_shop_menus_style',array(
        'type' => 'select',
		'label' => __('Menu Hover Style','luxury-shop'),
		'section' => 'luxury_shop_header_section_settings',
		'choices' => array(
         'None' => __('None','luxury-shop'),
         'Zoom In' => __('Zoom In','luxury-shop'),
      ),
	));

    $wp_customize->add_setting( 
        'luxury_shop_header_settings_upgraded_features',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control(
        'luxury_shop_header_settings_upgraded_features', 
        array(
            'type'=> 'hidden',
            'description' => "
                <div class='notice-pro-features'>
                    <div class='notice-pro-icon'>
                        <i class='fas fa-crown'></i>
                    </div>
                    <div class='notice-pro-content'>
                        <h3>Unlock Premium Features</h3>
                        <p>Enhance your website with advanced layouts, premium sections, and powerful customization tools.</p>
                    </div>
                    <div class='notice-pro-button'>
                        <a target='_blank' href='". esc_url(LUXURY_SHOP_URL) ."' class='notice-upgrade-btn'>
                            Upgrade to Pro<i class='fas fa-rocket'></i>
                        </a>
                    </div>
                </div>
            ",
            'section' => 'luxury_shop_header_section_settings'
        )
    );

    /** Home Page Settings */
    $wp_customize->add_panel( 
        'luxury_shop_home_page_settings',
         array(
            'priority' => 9,
            'capability' => 'edit_theme_options',
            'title' => esc_html__( 'Home Page Settings', 'luxury-shop' ),
            'description' => esc_html__( 'Customize Home Page Settings', 'luxury-shop' ),
        ) 
    );

 /** Slider Section Settings */
    $wp_customize->add_section(
        'luxury_shop_slider_section_settings',
        array(
            'title' => esc_html__( 'Banner Section Settings', 'luxury-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_home_page_settings',
        )
    );

    /** Slider Section control */
    $wp_customize->add_setting( 
        'luxury_shop_slider_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_slider_setting',
        array(
            'label'       => __( 'Show Banner', 'luxury-shop' ),
            'section'     => 'luxury_shop_slider_section_settings',
            'type'        => 'checkbox',
        )
    );

    // Number of Tabs
    $wp_customize->add_setting(
        'luxury_shop_number_of_tabs',
        array(
            'default'           => '',
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control(
        'luxury_shop_number_of_tabs',
        array(
            'label'       => __('Number of Tabs (Max 6)', 'luxury-shop'),
            'description' => __('Add Count and Refresh Page','luxury-shop'),
            'section'     => 'luxury_shop_slider_section_settings',
            'type'        => 'number',
            'input_attrs' => array(
                'min'   => 1,
                'max'   => 6,
                'step'  => 1,
            )
        )
    );

    $luxury_shop_tab_count = get_theme_mod('luxury_shop_number_of_tabs');

    for ($luxury_shop_i = 1; $luxury_shop_i <= $luxury_shop_tab_count; $luxury_shop_i++) {

        // Tab Title
        $wp_customize->add_setting(
            "luxury_shop_tab_title_$luxury_shop_i",
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        $wp_customize->add_control(
            "luxury_shop_tab_title_$luxury_shop_i",
            array(
                /* translators: %s: Tab number */
                'label' => sprintf( __( 'Tab Title %s', 'luxury-shop' ), $luxury_shop_i ),
                'section' => 'luxury_shop_slider_section_settings',
                'type'    => 'text'
            )
        );

        // Category Dropdown
        $luxury_shop_categories = array('' => __('Select Category', 'luxury-shop'));
        $luxury_shop_product_cats = get_terms('product_cat', array('hide_empty' => false));

        foreach ($luxury_shop_product_cats as $luxury_shop_cat) {
            $luxury_shop_categories[$luxury_shop_cat->term_id] = $luxury_shop_cat->name;
        }

        $wp_customize->add_setting(
            "luxury_shop_tab_cat_$luxury_shop_i",
            array(
                'sanitize_callback' => 'absint'
            )
        );

        $wp_customize->add_control(
            "luxury_shop_tab_cat_$luxury_shop_i",
            array(                
                'label' => sprintf(
                /* translators: %s: Tab number */
                    __( 'Select Category for Tab %s', 'luxury-shop' ),
                    $luxury_shop_i
                ),
                'section' => 'luxury_shop_slider_section_settings',
                'type'    => 'select',
                'choices' => $luxury_shop_categories
            )
        );
    }

    $wp_customize->add_setting('luxury_shop_video_button_url',array(
        'default'=> '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('luxury_shop_video_button_url',array(
        'label' => esc_html__('Video Link','luxury-shop'),
        'section'=> 'luxury_shop_slider_section_settings',
        'type'=> 'url'
    ));

    $wp_customize->add_setting( 
        'luxury_shop_slider_settings_upgraded_features',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control(
        'luxury_shop_slider_settings_upgraded_features', 
        array(
            'type'=> 'hidden',
            'description' => "
                <div class='notice-pro-features'>
                    <div class='notice-pro-icon'>
                        <i class='fas fa-crown'></i>
                    </div>
                    <div class='notice-pro-content'>
                        <h3>Unlock Premium Features</h3>
                        <p>Enhance your website with advanced layouts, premium sections, and powerful customization tools.</p>
                    </div>
                    <div class='notice-pro-button'>
                        <a target='_blank' href='". esc_url(LUXURY_SHOP_URL) ."' class='notice-upgrade-btn'>
                            Upgrade to Pro<i class='fas fa-rocket'></i>
                        </a>
                    </div>
                </div>
            ",
            'section' => 'luxury_shop_slider_section_settings'
        )
    );

   /** Product Section Start */

   $wp_customize->add_section(
        'luxury_shop_classes_section_settings',
        array(
            'title' => esc_html__( 'Product Section Settings', 'luxury-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'luxury_shop_home_page_settings',
        )
    );

    $wp_customize->add_setting( 
        'luxury_shop_classes_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_classes_setting',
        array(
            'label'       => __( 'Show Product Section', 'luxury-shop' ),
            'section'     => 'luxury_shop_classes_section_settings',
            'type'        => 'checkbox',
        )
    );

    // Section Title
    $wp_customize->add_setting(
        'luxury_shop_service_title', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',    
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'luxury_shop_service_title', 
        array(
            'label'       => __('Section Title', 'luxury-shop'),
            'section'     => 'luxury_shop_classes_section_settings',
            'settings'    => 'luxury_shop_service_title',
            'type'        => 'text'
        )
    );

    // Default category list
    $luxury_shop_cat_posts = array( 'select' => __( 'Select', 'luxury-shop' ) );

    // Only get WooCommerce product categories if WooCommerce is active
    if ( class_exists( 'WooCommerce' ) ) {
        $luxury_shop_categories = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ) );

        if ( ! is_wp_error( $luxury_shop_categories ) && ! empty( $luxury_shop_categories ) ) {
            foreach ( $luxury_shop_categories as $luxury_shop_category ) {
                if ( isset( $luxury_shop_category->slug, $luxury_shop_category->name ) ) {
                    $luxury_shop_cat_posts[ $luxury_shop_category->slug ] = $luxury_shop_category->name;
                }
            }
        }
    }

    // Add dropdown for selecting one category
    $wp_customize->add_setting(
        'luxury_shop_product_category',
        array(
            'default'           => 'select',
            'sanitize_callback' => 'luxury_shop_sanitize_choices',
        )
    );

    $wp_customize->add_control(
        'luxury_shop_product_category',
        array(
            'type'     => 'select',
            'choices'  => $luxury_shop_cat_posts,
            'label'    => __( 'Select Category to Display Products', 'luxury-shop' ),
            'section'  => 'luxury_shop_classes_section_settings',
        )
    );

    $wp_customize->add_setting( 
        'luxury_shop_classes_settings_upgraded_features',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control(
        'luxury_shop_classes_settings_upgraded_features', 
        array(
            'type'=> 'hidden',
            'description' => "
                <div class='notice-pro-features'>
                    <div class='notice-pro-icon'>
                        <i class='fas fa-crown'></i>
                    </div>
                    <div class='notice-pro-content'>
                        <h3>Unlock Premium Features</h3>
                        <p>Enhance your website with advanced layouts, premium sections, and powerful customization tools.</p>
                    </div>
                    <div class='notice-pro-button'>
                        <a target='_blank' href='". esc_url(LUXURY_SHOP_URL) ."' class='notice-upgrade-btn'>
                            Upgrade to Pro<i class='fas fa-rocket'></i>
                        </a>
                    </div>
                </div>
            ",
            'section' => 'luxury_shop_classes_section_settings'
        )
    );
    /** Product Section End */
    
    /** Home Page Settings Ends */
    
    /** Footer Section */
    $wp_customize->add_section(
        'luxury_shop_footer_section',
        array(
            'title' => __( 'Footer Settings', 'luxury-shop' ),
            'priority' => 70,
            'panel' => 'luxury_shop_home_page_settings',
        )
    );

    /** Footer Widget Columns */
    $wp_customize->add_setting('luxury_shop_footer_widget_areas', array(
        'default'           => 4,
        'sanitize_callback' => 'luxury_shop_sanitize_choices',
    ));

    $wp_customize->add_control('luxury_shop_footer_widget_areas', array(
        'label'    => __('Footer Widget Columns', 'luxury-shop'),
        'section'  => 'luxury_shop_footer_section',
        'settings' => 'luxury_shop_footer_widget_areas',
        'type'     => 'select',
        'choices'  => array(
		   '1'     => __('One', 'luxury-shop'),
		   '2'     => __('Two', 'luxury-shop'),
		   '3'     => __('Three', 'luxury-shop'),
		   '4'     => __('Four', 'luxury-shop')
        ),
    ));

    /** Footer Copyright control */
    $wp_customize->add_setting( 
        'luxury_shop_footer_setting', 
        array(
            'default' => true,
            'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'luxury_shop_footer_setting',
        array(
            'label'       => __( 'Show Footer Copyright', 'luxury-shop' ),
            'section'     => 'luxury_shop_footer_section',
            'type'        => 'checkbox',
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'luxury_shop_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'luxury_shop_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'luxury-shop' ),
            'section' => 'luxury_shop_footer_section',
            'type' => 'text',
        )
    );  
$wp_customize->add_setting('luxury_shop_footer_background_image',
        array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        )
    );


    $wp_customize->add_control(
         new WP_Customize_Cropped_Image_Control($wp_customize, 'luxury_shop_footer_background_image',
            array(
                'label' => esc_html__('Footer Background Image', 'luxury-shop'),
                /* translators: 1: image width in pixels, 2: image height in pixels */
                'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'luxury-shop'), 1024, 800),
                'section' => 'luxury_shop_footer_section',
                'width' => 1024,
                'height' => 800,
                'flex_width' => true,
                'flex_height' => true,
            )
        )
    );

    /** Footer Background Image Attachment */
    $wp_customize->add_setting('luxury_shop_background_attatchment', array(
        'default'           => 'scroll',
        'sanitize_callback' => 'luxury_shop_sanitize_choices',
    ));

    $wp_customize->add_control('luxury_shop_background_attatchment', array(
        'label'    => __('Footer Background Attachment', 'luxury-shop'),
        'section'  => 'luxury_shop_footer_section',
        'settings' => 'luxury_shop_background_attatchment',
        'type'     => 'select',
        'choices'  => array(
            'fixed' => __('fixed','luxury-shop'),
            'scroll' => __('scroll','luxury-shop'),
        ),
    ));

    /* Footer Background Color*/
    $wp_customize->add_setting(
        'luxury_shop_footer_background_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'luxury_shop_footer_background_color',
            array(
                'label' => __('Footer Widget Area Background Color', 'luxury-shop'),
                'section' => 'luxury_shop_footer_section',
                'type' => 'color',
            )
        )
    );

     $wp_customize->add_setting('luxury_shop_scroll_icon',array(
        'default'   => 'fas fa-arrow-up',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new Luxury_Shop_Changeable_Icon(
        $wp_customize,'luxury_shop_scroll_icon',array(
        'label' => __('Scroll Top Icon','luxury-shop'),
        'transport' => 'refresh',
        'section'   => 'luxury_shop_footer_section',
        'type'      => 'icon'
    )));

        /** Scroll to top button shape */
    $wp_customize->add_setting('luxury_shop_scroll_to_top_radius', array(
        'default'           => 'curved-box',
        'sanitize_callback' => 'luxury_shop_sanitize_choices',
    ));

    $wp_customize->add_control('luxury_shop_scroll_to_top_radius', array(
        'label'    => __('Scroll Top Button Shape', 'luxury-shop'),
        'section'  => 'luxury_shop_footer_section',
        'settings' => 'luxury_shop_scroll_to_top_radius',
        'type'     => 'select',
        'choices'  => array(
            'box'        => __( 'Box', 'luxury-shop' ),
            'curved-box' => __( 'Curved Box', 'luxury-shop' ),
            'circle'     => __( 'Circle', 'luxury-shop' ),
        ),
    ));

    $wp_customize->add_setting( 
        'luxury_shop_footer_settings_upgraded_features',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control(
        'luxury_shop_footer_settings_upgraded_features', 
        array(
            'type'=> 'hidden',
            'description' => "
                <div class='notice-pro-features'>
                    <div class='notice-pro-icon'>
                        <i class='fas fa-crown'></i>
                    </div>
                    <div class='notice-pro-content'>
                        <h3>Unlock Premium Features</h3>
                        <p>Enhance your website with advanced layouts, premium sections, and powerful customization tools.</p>
                    </div>
                    <div class='notice-pro-button'>
                        <a target='_blank' href='". esc_url(LUXURY_SHOP_URL) ."' class='notice-upgrade-btn'>
                            Upgrade to Pro<i class='fas fa-rocket'></i>
                        </a>
                    </div>
                </div>
            ",
            'section' => 'luxury_shop_footer_section'
        )
    );

    /** Footer Social Icon */
    $wp_customize->add_section('luxury_shop_footer_social_section', array(
        'title' => __( 'Footer Social Settings', 'luxury-shop' ),
        'panel' => 'luxury_shop_home_page_settings',
    ));

    $wp_customize->add_setting('luxury_shop_enable_footer_icon_section', array(
        'default' => true,
        'sanitize_callback' => 'luxury_shop_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'luxury_shop_enable_footer_icon_section', array(
        'label'       => __( 'Show Footer Icon', 'luxury-shop' ),
        'section'     => 'luxury_shop_footer_social_section',
        'type'        => 'checkbox',
    ));

    // Add setting for Facebook Link
    $wp_customize->add_setting(
        'luxury_shop_footer_facebook_link',
        array(
            'default'           => 'https://www.facebook.com/',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'luxury_shop_footer_facebook_link',
        array(
            'label'           => esc_html__( 'Facebook Link', 'luxury-shop'  ),
            'section'         => 'luxury_shop_footer_social_section',
            'settings'        => 'luxury_shop_footer_facebook_link',
            'type'      => 'url'
        )
    );

    // Add setting for Facebook Icon Changing
    $wp_customize->add_setting(
        'luxury_shop_facebook_icon',
        array(
            'default' => 'fa-brands fa-facebook',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
            
        )
    );	

    $wp_customize->add_control(new Luxury_Shop_Changeable_Icon($wp_customize, 
        'luxury_shop_facebook_icon',
        array(
            'label'   		=> __('Facebook Icon','luxury-shop'),
            'section' 		=> 'luxury_shop_footer_social_section',
            'iconset' => 'fb',
        ))  
    );


    // Add setting for Twitter Link
    $wp_customize->add_setting(
        'luxury_shop_footer_twitter_link',
        array(
            'default'           => 'https://twitter.com/',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'luxury_shop_footer_twitter_link',
        array(
            'label'           => esc_html__( 'Twitter Link', 'luxury-shop'  ),
            'section'         => 'luxury_shop_footer_social_section',
            'settings'        => 'luxury_shop_footer_twitter_link',
            'type'      => 'url'
        )
    );

    // Add setting for Twitter Icon Changing
    $wp_customize->add_setting(
        'luxury_shop_twitter_icon',
        array(
            'default' => 'fa-brands fa-twitter',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
            
        )
    );	

    $wp_customize->add_control(new Luxury_Shop_Changeable_Icon($wp_customize, 
        'luxury_shop_twitter_icon',
        array(
            'label'   		=> __('Twitter Icon','luxury-shop'),
            'section' 		=> 'luxury_shop_footer_social_section',
            'iconset' => 'fb',
        ))  
    );

    // Add setting for Instagram Link
    $wp_customize->add_setting(
        'luxury_shop_footer_instagram_link',
        array(
            'default'           => 'https://www.instagram.com/',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'luxury_shop_footer_instagram_link',
        array(
            'label'           => esc_html__( 'Instagram Link', 'luxury-shop'  ),
            'section'         => 'luxury_shop_footer_social_section',
            'settings'        => 'luxury_shop_footer_instagram_link',
            'type'      => 'url'
        )
    );

    // Add setting for Instagram Icon Changing
    $wp_customize->add_setting(
        'luxury_shop_instagram_icon',
        array(
            'default' => 'fa-brands fa-instagram',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
            
        )
    );	

    $wp_customize->add_control(new Luxury_Shop_Changeable_Icon($wp_customize, 
        'luxury_shop_instagram_icon',
        array(
            'label'   		=> __('Instagram Icon','luxury-shop'),
            'section' 		=> 'luxury_shop_footer_social_section',
            'iconset' => 'fb',
        ))  
    );

    // Add setting for Linkedin Link
    $wp_customize->add_setting(
        'luxury_shop_footer_linkedin_link',
        array(
            'default'           => 'https://in.linkedin.com/',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'luxury_shop_footer_linkedin_link',
        array(
            'label'           => esc_html__( 'Linkedin Link', 'luxury-shop'  ),
            'section'         => 'luxury_shop_footer_social_section',
            'settings'        => 'luxury_shop_footer_linkedin_link',
            'type'      => 'url'
        )
    );

    // Add setting for Linkedin Icon Changing
    $wp_customize->add_setting(
        'luxury_shop_linkedin_icon',
        array(
            'default' => 'fa-brands fa-linkedin',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
            
        )
    );	

    $wp_customize->add_control(new Luxury_Shop_Changeable_Icon($wp_customize, 
        'luxury_shop_linkedin_icon',
        array(
            'label'   		=> __('Linkedin Icon','luxury-shop'),
            'section' 		=> 'luxury_shop_footer_social_section',
            'iconset' => 'fb',
        ))  
    );

    // Add setting for Youtube Link
    $wp_customize->add_setting(
        'luxury_shop_footer_youtube_link',
        array(
            'default'           => 'https://www.youtube.com/',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'luxury_shop_footer_youtube_link',
        array(
            'label'           => esc_html__( 'Youtube Link', 'luxury-shop'  ),
            'section'         => 'luxury_shop_footer_social_section',
            'settings'        => 'luxury_shop_footer_youtube_link',
            'type'      => 'url'
        )
    );

    // Add setting for Youtube Icon Changing
    $wp_customize->add_setting(
        'luxury_shop_youtube_icon',
        array(
            'default' => 'fa-brands fa-youtube',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
            
        )
    );	

    $wp_customize->add_control(new Luxury_Shop_Changeable_Icon($wp_customize, 
        'luxury_shop_youtube_icon',
        array(
            'label'   		=> __('Youtube Icon','luxury-shop'),
            'section' 		=> 'luxury_shop_footer_social_section',
            'iconset' => 'fb',
        ))  
    );

    // 404 PAGE SETTINGS
    $wp_customize->add_section(
        'luxury_shop_404_section',
        array(
            'title' => __( '404 Page Settings', 'luxury-shop' ),
            'priority' => 70,
            'panel' => 'luxury_shop_general_settings',
        )
    );
   
    $wp_customize->add_setting('luxury_shop_404_page_image', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw', // Sanitize as URL
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'luxury_shop_404_page_image', array(
        'label' => __('404 Page Image', 'luxury-shop'),
        'section' => 'luxury_shop_404_section',
        'settings' => 'luxury_shop_404_page_image',
    )));

    $wp_customize->add_setting('luxury_shop_404_pagefirst_header', array(
        'default' => __('404', 'luxury-shop'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
    ));

    $wp_customize->add_control('luxury_shop_404_pagefirst_header', array(
        'type' => 'text',
        'label' => __('404 Page Heading', 'luxury-shop'),
        'section' => 'luxury_shop_404_section',
    ));

    // Setting for 404 page header
    $wp_customize->add_setting('luxury_shop_404_page_header', array(
        'default' => __('Sorry, that page can\'t be found!', 'luxury-shop'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
    ));

    $wp_customize->add_control('luxury_shop_404_page_header', array(
        'type' => 'text',
        'label' => __('404 Page Content', 'luxury-shop'),
        'section' => 'luxury_shop_404_section',
    ));

}
add_action( 'customize_register', 'luxury_shop_customize_register' );
endif;

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function luxury_shop_customize_preview_js() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $luxury_shop_build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $luxury_shop_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'luxury_shop_customizer', get_template_directory_uri() . '/js' . $luxury_shop_build . '/customizer' . $luxury_shop_suffix . '.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'luxury_shop_customize_preview_js' );