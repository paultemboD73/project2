<?php
/**
 * Trending Products Section
 * 
 * @package luxury_shop
 */

$luxury_shop_classes = get_theme_mod('luxury_shop_classes_setting', false);
$luxury_shop_service_title = get_theme_mod('luxury_shop_service_title');
$luxury_shop_category_name = get_theme_mod('luxury_shop_product_category');
?>

<?php if ($luxury_shop_classes && class_exists('WooCommerce')) : ?>
    <div class="our-products wow zoomInUp" data-wow-duration="2s">
        <div class="container">
            <div class="side-border">
                <?php if ($luxury_shop_service_title) : ?>
                    <h4><?php echo esc_html($luxury_shop_service_title); ?></h4>
                <?php endif; ?>
            </div>
            <?php if ($luxury_shop_category_name && $luxury_shop_category_name !== 'select') : ?>
                <div class="mt-3 owl-carousel">
                    <?php
                    $luxury_shop_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'ignore_sticky_posts' => true,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => $luxury_shop_category_name,
                            ),
                        ),
                    );
                    $luxury_shop_loop = new WP_Query($luxury_shop_args);
                    if ($luxury_shop_loop->have_posts()) :
                        while ($luxury_shop_loop->have_posts()) : $luxury_shop_loop->the_post();
                            global $product; ?>
                            <div class="box">
                                <div class="addcart">
                                    <?php woocommerce_template_loop_add_to_cart(); ?>
                                </div>
                                <div class="product-image-wrapper">
                                    <div class="product-img">
                                        <?php if (has_post_thumbnail()) :
                                            the_post_thumbnail('medium');
                                        else : ?>
                                            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/default1.png'); ?>" alt="<?php esc_attr_e('Default', 'luxury-shop'); ?>">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product-details">
                                    <!-- product category -->
                                    <?php
                                      $luxury_shop_terms = get_the_terms(get_the_ID(), 'product_cat');

                                      if ($luxury_shop_terms && !is_wp_error($luxury_shop_terms)) {
                                          echo '<span class="product-cat">';
                                          $luxury_shop_cats = wp_list_pluck($luxury_shop_terms, 'name');
                                          echo esc_html(implode(', ', $luxury_shop_cats)); 
                                          echo '</span>';
                                      }
                                    ?>
                                    <h6 class="product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h6>
                                    <div class="price">
                                        <?php echo wp_kses_post($product->get_price_html()); ?>
                                    </div>
                                    <?php if (wc_review_ratings_enabled() && $product->get_average_rating()) : ?>
                                        <div class="rating">
                                            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile;
                    else : ?>
                        <p class="no-products"><?php esc_html_e('No products found.', 'luxury-shop'); ?></p>
                    <?php endif;
                    wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <p class="no-products text-center mt-3">
                    <?php esc_html_e('Please select a category in the Customizer.', 'luxury-shop'); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
