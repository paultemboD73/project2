<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package luxury_shop
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function luxury_shop_body_classes( $classes ) {
  global $luxury_shop_post;
  
    if( !is_page_template( 'template-home.php' ) ){
        $classes[] = 'inner';
        // Adds a class of group-blog to blogs with more than 1 published author.
    }

    if ( is_multi_author() ) {
        $classes[] = 'group-blog ';
    }

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    

    if( luxury_shop_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }    

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_page() ) {
        $classes[] = 'hfeed ';
    }
  
    if( is_404() ||  is_search() ){
        $classes[] = 'full-width';
    }
  
    if( ! is_active_sidebar( 'right-sidebar' ) ) {
        $classes[] = 'full-width'; 
    }

    return $classes;
}
add_filter( 'body_class', 'luxury_shop_body_classes' );

 /**
 * 
 * @link http://www.altafweb.com/2011/12/remove-specific-tag-from-php-string.html
 */
function luxury_shop_strip_single( $tag, $string ){
    $string=preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
    $string=preg_replace('/<\/'.$tag.'>/i', '', $string);
    return $string;
}

if ( ! function_exists( 'luxury_shop_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function luxury_shop_excerpt_more($more) {
  return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'luxury_shop_excerpt_more' );

if( ! function_exists( 'luxury_shop_footer_credit' ) ):
/**
 * Footer Credits
*/
function luxury_shop_footer_credit() {

    // Check if footer copyright is enabled
    $luxury_shop_show_footer_copyright = get_theme_mod( 'luxury_shop_footer_setting', true );

    if ( ! $luxury_shop_show_footer_copyright ) {
        return; 
    }

    $luxury_shop_copyright_text = get_theme_mod('luxury_shop_footer_copyright_text');

    $luxury_shop_text = '<div class="site-info"><div class="container"><span class="copyright">';
    if ($luxury_shop_copyright_text) {
        $luxury_shop_text .= wp_kses_post($luxury_shop_copyright_text); 
    } else {
        $luxury_shop_text .= esc_html__('&copy; ', 'luxury-shop') . date_i18n(esc_html__('Y', 'luxury-shop')); 
        $luxury_shop_text .= ' <a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>' . esc_html__('. All Rights Reserved.', 'luxury-shop');
    }
    $luxury_shop_text .= '</span>';
    $luxury_shop_text .= '<span class="by"> <a href="' . esc_url('https://www.themeignite.com/products/luxury-shop') . '" rel="nofollow" target="_blank">' . LUXURY_SHOP_THEME_NAME . '</a>' . esc_html__(' By ', 'luxury-shop') . '<a href="' . esc_url('https://themeignite.com/') . '" rel="nofollow" target="_blank">' . esc_html__('Themeignite', 'luxury-shop') . '</a>.';
    /* translators: %s: link to WordPress.org */
    $luxury_shop_text .= sprintf(esc_html__(' Powered By %s', 'luxury-shop'), '<a href="' . esc_url(__('https://wordpress.org/', 'luxury-shop')) . '" target="_blank">WordPress</a>.');
    if (function_exists('the_privacy_policy_link')) {
        $luxury_shop_text .= get_the_privacy_policy_link();
    }
    $luxury_shop_text .= '</span></div></div>';
    echo apply_filters('luxury_shop_footer_text', $luxury_shop_text);
}
add_action('luxury_shop_footer', 'luxury_shop_footer_credit');
endif;


/**
 * Is Woocommerce activated
*/
if ( ! function_exists( 'luxury_shop_woocommerce_activated' ) ) {
  function luxury_shop_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
  }
}

if( ! function_exists( 'luxury_shop_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function luxury_shop_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $luxury_shop_commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $luxury_shop_aria_req = ( $req ? " aria-required='true'" : '' );
    $luxury_shop_required = ( $req ? " required" : '' );
    $luxury_shop_author   = ( $req ? __( 'Name*', 'luxury-shop' ) : __( 'Name', 'luxury-shop' ) );
    $luxury_shop_email    = ( $req ? __( 'Email*', 'luxury-shop' ) : __( 'Email', 'luxury-shop' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'luxury-shop' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $luxury_shop_author ) . '" type="text" value="' . esc_attr( $luxury_shop_commenter['comment_author'] ) . '" size="30"' . $luxury_shop_aria_req . $luxury_shop_required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'luxury-shop' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $luxury_shop_email ) . '" type="text" value="' . esc_attr(  $luxury_shop_commenter['comment_author_email'] ) . '" size="30"' . $luxury_shop_aria_req . $luxury_shop_required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'luxury-shop' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'luxury-shop' ) . '" type="text" value="' . esc_attr( $luxury_shop_commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'luxury_shop_change_comment_form_default_fields' );

if( ! function_exists( 'luxury_shop_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function luxury_shop_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'luxury-shop' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'luxury-shop' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'luxury_shop_change_comment_form_defaults' );

if( ! function_exists( 'luxury_shop_escape_text_tags' ) ) :
/**
 * Remove new line tags from string
 *
 * @param $text
 * @return string
 */
function luxury_shop_escape_text_tags( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
    /**
     * Triggered after the opening <body> tag.
    */
    do_action( 'wp_body_open' );
}
endif;

if ( ! function_exists( 'luxury_shop_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function luxury_shop_get_fallback_svg( $luxury_shop_post_thumbnail ) {
    if( ! $luxury_shop_post_thumbnail ){
        return;
    }
    
    $luxury_shop_image_size = luxury_shop_get_image_sizes( $luxury_shop_post_thumbnail );
     
    if( $luxury_shop_image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $luxury_shop_image_size['width'] ); ?> <?php echo esc_attr( $luxury_shop_image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $luxury_shop_image_size['width'] ); ?>" height="<?php echo esc_attr( $luxury_shop_image_size['height'] ); ?>" style="fill:#dedddd;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

function luxury_shop_enqueue_google_fonts() {

    require get_template_directory() . '/inc/wptt-webfont-loader.php';

    wp_enqueue_style(
        'google-fonts-rubik',
        luxury_shop_wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap' ),
        array(),
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'luxury_shop_enqueue_google_fonts' );


if( ! function_exists( 'luxury_shop_site_branding' ) ) :
/**
 * Site Branding
*/
function luxury_shop_site_branding(){
    $luxury_shop_logo_site_title = get_theme_mod( 'header_site_title', 1 );
    $luxury_shop_tagline = get_theme_mod( 'header_tagline', false );
    $luxury_shop_logo_width = get_theme_mod('logo_width', 100); // Retrieve the logo width setting

    ?>
    <div class="site-branding" style="max-width: <?php echo esc_attr(get_theme_mod('logo_width', '-1'))?>px;">
        <?php 
        // Check if custom logo is set and display it
        if (function_exists('has_custom_logo') && has_custom_logo()) {
            the_custom_logo();
        }
        if ($luxury_shop_logo_site_title):
             if (is_front_page()): ?>
            <h1 class="site-title" style="font-size: <?php echo esc_attr(get_theme_mod('luxury_shop_site_title_size', '30')); ?>px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
          </h1>
            <?php else: ?>
                <p class="site-title" itemprop="name">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                </p>
            <?php endif; ?>
        <?php endif; 
    
        if ($luxury_shop_tagline) :
            $luxury_shop_description = get_bloginfo('description', 'display');
            if ($luxury_shop_description || is_customize_preview()) :
        ?>
                <p class="site-description" itemprop="description"><?php echo $luxury_shop_description; ?></p>
            <?php endif;
        endif;
        ?>
    </div>
    <?php
}
endif;
if( ! function_exists( 'luxury_shop_navigation' ) ) :
    /**
     * Site Navigation
    */
    function luxury_shop_navigation(){
        ?>
        <nav class="main-navigation" id="site-navigation" role="navigation">
            <?php 
            wp_nav_menu( array( 
                'theme_location' => 'primary', 
                'menu_id' => 'primary-menu' 
            ) ); 
            ?>
        </nav>
        <?php
    }
endif;

if( ! function_exists( 'luxury_shop_header' ) ) :
    /**
     * Header Start
    */
    function luxury_shop_header(){
        $luxury_shop_header_image = get_header_image();
        $luxury_shop_sticky_header = get_theme_mod('luxury_shop_sticky_header');?>
            <div id="page-site-header" class="main-header">
                <header id="masthead" class="site-header header-inner" role="banner">
                    <div class="theme-menu head_bg" <?php echo $luxury_shop_header_image != '' ? 'style="background-image: url(' . esc_url( $luxury_shop_header_image ) . '); background-repeat: no-repeat; background-size: 100% 100%"': ""; ?> data-sticky="<?php echo esc_attr( $luxury_shop_sticky_header ); ?>">
                        <div class="container">
                            <div class="row header_bg">
                                <div class="col-xl-2 col-lg-3 col-md-4 align-self-center">
                                    <?php luxury_shop_site_branding(); ?>
                                </div>
                                <div class="col-xl-8 col-lg-6 col-md-2 align-self-center">
                                    <?php luxury_shop_navigation(); ?> 
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-4 align-self-center text-md-end text-center my-2 header-icons">
                                    <span class="header-info">
                                        <?php if ( get_theme_mod( 'luxury_shop_show_hide_search', false ) ) : ?>
                                            <div class="search-info">
                                                <div class="search-body">
                                                    <button type="button" class="search-show">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                                <div class="searchform-inner">
                                                    <?php get_search_form(); ?>
                                                    <button type="button" class="close" aria-label="<?php esc_attr_e( 'Close', 'luxury-shop' ); ?>">
                                                        <span aria-hidden="true">X</span>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </span>
                                    <span>
                                        <?php 
                                        if (defined('YITH_WCWL') && class_exists('YITH_WCWL_Wishlists')) {?>
                                        <a class="wishlist-btn" href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>">
                                            <i class="fa-regular fa-heart"></i>
                                        </a>
                                        <?php }?>
                                    </span>
                                    <div>
                                        <?php if (class_exists('woocommerce')) { ?>
                                            <span class="cart-count">
                                                <a class="cart-customlocation" href="<?php if (function_exists('wc_get_cart_url')) { echo esc_url(wc_get_cart_url()); } ?>" title="<?php esc_attr_e('View Shopping Cart', 'luxury-shop'); ?>">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </a>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if ( get_theme_mod( 'luxury_shop_show_hide_toggle', false ) ) : ?>
                                            <span class="offcanvas-div d-flex">
                                                <button type="button" data-bs-toggle="offcanvas" data-bs-target="#demo">
                                                    <i class="fas fa-bars"></i>
                                                </button>
                                                <div class="offcanvas offcanvas-end" id="demo">
                                                    <div class="offcanvas-header"> 
                                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                                    </div>
                                                    <div id="secondary" class="offcanvas-body">
                                                        <?php dynamic_sidebar( 'header-sidebar' ); ?>
                                                    </div>
                                                </div>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>               
                </header>
            </div>
        <?php
    }
endif;
add_action( 'luxury_shop_header', 'luxury_shop_header', 20 );
