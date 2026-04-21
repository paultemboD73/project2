<?php
/**
 * Help Panel.
 *
 * @package luxury_shop
 */

$luxury_shop_import_done = get_option( 'luxury_shop_demo_import_done' );
$luxury_shop_button_text = $luxury_shop_import_done
	? __( 'View Site', 'luxury-shop' )
	: __( 'Start Demo Import', 'luxury-shop' );
$luxury_shop_button_link = $luxury_shop_import_done
	? home_url( '/' )
	: admin_url( 'themes.php?page=luxuryshop-wizard' );
?>
<div id="help-panel" class="panel-left visible">
    <div class="panel-aside active">
        <div class="demo-content">
            <div class="demo-info">
                <h4><?php esc_html_e( 'DEMO CONTENT IMPORTER', 'luxury-shop' ); ?></h4>
                <p><?php esc_html_e('The Demo Content Importer helps you quickly set up your website to look exactly like the theme demo. Instead of building pages from scratch, you can import pre-designed layouts, pages, menus, images, and basic settings in just a few clicks.','luxury-shop'); ?></p>
                <a class="button button-primary first-color" style="text-transform: capitalize" href="<?php echo esc_url( $luxury_shop_button_link ); ?>" title="<?php echo esc_attr( $luxury_shop_button_text ); ?>"
                    <?php echo $luxury_shop_import_done ? 'target="_blank"' : ''; ?>>
                    <?php echo esc_html( $luxury_shop_button_text ); ?>
                </a>
            </div>
            <div class="demo-img">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri()) .'/screenshot.png'; ?>" alt="<?php echo esc_attr( 'screenshot', 'luxury-shop'); ?>"/>
            </div>
        </div>
    </div>

    <div class="panel-aside" >
        <h4><?php esc_html_e( 'USEFUL LINKS', 'luxury-shop' ); ?></h4>
        <p><?php esc_html_e( 'Find everything you need to set up, customize, and manage your website with ease. These helpful resources are designed to guide you at every step, from installation to advanced customization.', 'luxury-shop' ); ?></p>
        <div class="useful-links">
            <a class="button button-primary second-color" href="<?php echo esc_url( LUXURY_SHOP_DEMO_URL ); ?>" title="<?php esc_attr_e( 'Live Demo', 'luxury-shop' ); ?>" target="_blank">
                <?php esc_html_e( 'Live Demo', 'luxury-shop' ); ?>
            </a>
            <a class="button button-primary first-color" href="<?php echo esc_url( LUXURY_SHOP_FREE_DOC_URL ); ?>" title="<?php esc_attr_e( 'Documentation', 'luxury-shop' ); ?>" target="_blank">
                <?php esc_html_e( 'Documentation', 'luxury-shop' ); ?>
            </a>
            <a class="button button-primary second-color" href="<?php echo esc_url( LUXURY_SHOP_URL ); ?>" title="<?php esc_attr_e( 'Get Premium', 'luxury-shop' ); ?>" target="_blank">
                <?php esc_html_e( 'Get Premium', 'luxury-shop' ); ?>
            </a>
            <a class="button button-primary first-color" href="<?php echo esc_url( LUXURY_SHOP_BUNDLE_URL ); ?>" title="<?php esc_attr_e( 'Get Bundle - 60+ Themes', 'luxury-shop' ); ?>" target="_blank">
                <?php esc_html_e( 'Get Bundle - 60+ Themes', 'luxury-shop' ); ?>
            </a>
        </div>
    </div>

    <div class="panel-aside" >
        <h4><?php esc_html_e( 'REVIEW', 'luxury-shop' ); ?></h4>
        <p><?php esc_html_e( 'If you have a moment, please consider leaving a rating and short review. It only takes a minute, and your support means a lot to us.', 'luxury-shop' ); ?></p>
        <a class="button button-primary first-color" href="<?php echo esc_url( LUXURY_SHOP_REVIEW_URL ); ?>" title="<?php esc_attr_e( 'Visit the Review', 'luxury-shop' ); ?>" target="_blank">
            <?php esc_html_e( 'Leave a Review', 'luxury-shop' ); ?>
        </a>
    </div>
    
    <div class="panel-aside">
        <h4><?php esc_html_e( 'CONTACT SUPPORT', 'luxury-shop' ); ?></h4>
        <p>
            <?php esc_html_e( 'Thank you for choosing Luxury Shop! We appreciate your interest in our theme and are here to assist you with any support you may need.', 'luxury-shop' ); ?></p>
        <a class="button button-primary first-color" href="<?php echo esc_url( LUXURY_SHOP_SUPPORT_URL ); ?>" title="<?php esc_attr_e( 'Visit the Support', 'luxury-shop' ); ?>" target="_blank">
            <?php esc_html_e( 'Contact Support', 'luxury-shop' ); ?>
        </a>
    </div>
</div>