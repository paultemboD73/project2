<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * <?php the_header_image_tag(); 
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Luxury Shop
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses luxury_shop_header_style()
 */
function luxury_shop_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'luxury_shop_custom_header_args', array(
		'default-image'          => '',
		'width'                  => 1200,
		'height'                 => 100,
		'flex-height'            => true,
		'flex-width'             => true,
		'wp-head-callback'       => 'luxury_shop_header_style',
	) ) );

	// Register default headers.
	register_default_headers( array(
		'default-banner' => array(
			'url'           => '%s/images/default-header.png',
			'thumbnail_url' => '%s/images/default-header.png',
			'description'   => esc_html_x( 'Default Banner', 'header image description', 'luxury-shop' ),
		),

	) );
}
add_action( 'after_setup_theme', 'luxury_shop_custom_header_setup' );

function luxury_shop_header_style() {
	$luxury_shop_header_text_color = get_header_textcolor();

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
	 */
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $luxury_shop_header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	// Has the text been hidden?
	if ( ! display_header_text() ) :
		$luxury_shop_custom_css = ".site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}";
	// If the user has set a custom color for the text use that.
	else :
		$luxury_shop_custom_css = ".site-title a,
		.site-description {
			color: #" . esc_attr( $luxury_shop_header_text_color ) . "}";
	endif;
	wp_add_inline_style( 'luxury-shop-style', $luxury_shop_custom_css );
}
add_action( 'wp_enqueue_scripts', 'luxury_shop_header_style' );