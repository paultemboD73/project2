<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package luxury_shop
 */

?>
<?php get_header(); ?>
<main id="main" class="site-main" role="main">
    <div class="error-holder">
        <?php 
        // Check if custom 404 image is set
        $luxury_shop_image_url = get_theme_mod('luxury_shop_404_page_image', '');
        if ($luxury_shop_image_url) : ?>
            <img src="<?php echo esc_url($luxury_shop_image_url); ?>">
        <?php endif; ?>
        	<h1><?php echo esc_html(get_theme_mod('luxury_shop_404_pagefirst_header', __('404', 'luxury-shop'))); ?></h1>
			<h2><?php echo esc_html(get_theme_mod('luxury_shop_404_page_header', __('Sorry, that page can\'t be found!', 'luxury-shop'))); ?></h2>

        <p class="btn-green mt-3 mb-0">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Homepage', 'luxury-shop'); ?></a>
        </p>
    </div>
</main>

<?php get_footer(); ?>