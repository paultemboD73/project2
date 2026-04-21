<?php
/**
 * Banner Tabs Section
 * 
 * @package luxury_shop
 */

$luxury_shop_slider = get_theme_mod('luxury_shop_slider_setting', false);
$luxury_shop_tab_count = get_theme_mod('luxury_shop_number_of_tabs');
$luxury_shop_svg_image = file_get_contents(get_template_directory_uri() . '/images/Star1.svg');

if ($luxury_shop_slider && $luxury_shop_tab_count > 0) :
?>

<div class="banner">
    <div class="luxury-tabs container">
        <div class="image-container">
            <?php if ( get_theme_mod('luxury_shop_video_button_url') != '' ) : ?>         
                <div class="play-circle-wrap">
                    <div class="play-btn">
                        <a id="openModalButton"
                            data-modal-src="<?php echo esc_url(get_theme_mod('luxury_shop_video_button_url')); ?>">
                            <i class="fa-solid fa-play"></i>
                        </a>
                    </div>
                    <div class="circle-text" id="circle-image-text">
                        <p><?php esc_html_e('Luxury+Luxury+Luxury+Luxury+Luxury+', 'luxury-shop'); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span id="closeModalButton" class="close">&times;</span>

                    <div id="videoContainer">
                        <iframe id="videoPlayer" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                    
                </div>
            </div>

        </div>
        <div class="row align-items-end">
            <div class="col-xl-2 col-lg-5 col-md-6 col-12">
                <ul class="luxury-tabs-nav">
                    <?php
                    for ($luxury_shop_i = 1; $luxury_shop_i <= $luxury_shop_tab_count; $luxury_shop_i++) :
                        $luxury_shop_tab_title = get_theme_mod("luxury_shop_tab_title_$luxury_shop_i");
                        $luxury_shop_tab_cat_id = get_theme_mod("luxury_shop_tab_cat_$luxury_shop_i");

                        if (!empty($luxury_shop_tab_title) && !empty($luxury_shop_tab_cat_id)) :
                    ?>
                        <li class="luxury-tab-item">
                            <a href="#luxury-tab-<?php echo esc_attr($luxury_shop_i); ?>">
                                <?php echo esc_html($luxury_shop_tab_title); ?>
                            </a>
                        </li>
                    <?php
                        endif;
                    endfor;
                    ?>
                </ul>
            </div>

            <div class="col-xl-10 col-lg-7 col-md-6 col-12">
                <div class="luxury-tabs-content">
                        <?php
                        for ($luxury_shop_i = 1; $luxury_shop_i <= $luxury_shop_tab_count; $luxury_shop_i++) :

                            $luxury_shop_cat_id = get_theme_mod("luxury_shop_tab_cat_$luxury_shop_i");
                            if (empty($luxury_shop_cat_id)) continue;

                            $luxury_shop_category = get_term($luxury_shop_cat_id, 'product_cat');
                            if (!$luxury_shop_category || is_wp_error($luxury_shop_category)) continue;

                            $luxury_shop_cat_name = $luxury_shop_category->name;
                            $luxury_shop_cat_desc = $luxury_shop_category->description;
                            $luxury_shop_cat_link = get_term_link($luxury_shop_category);

                            $luxury_shop_thumb_id = get_term_meta($luxury_shop_cat_id, 'thumbnail_id', true);
                            $luxury_shop_image_url = wp_get_attachment_url($luxury_shop_thumb_id);
                            if (!$luxury_shop_image_url) {
                                $luxury_shop_image_url = get_template_directory_uri() . '/images/default.png';
                            }
                        ?>

                        <div id="luxury-tab-<?php echo esc_attr($luxury_shop_i); ?>" class="luxury-tab-panel">
                            <div class="row align-items-end">
                                <div class="col-xl-7 col-lg-12 col-12">
                                    <h3 class="luxury-cat-title mb-5">
                                        <?php echo esc_html($luxury_shop_cat_name); ?>
                                    </h3>
                                    <div class="wave wow zoomIn" data-wow-duration="2s">
                                        <div class="star-image-1">
                                            <div class="star-img"><?php echo $luxury_shop_svg_image; ?></div>
                                        </div>
                                        <div class="luxury-tab-image mb-3">
                                            <img src="<?php echo esc_url($luxury_shop_image_url); ?>" alt="<?php echo esc_attr($luxury_shop_cat_name); ?>">
                                        </div>
                                        <div class="wave__container">
                                            <div class="wave__circle"></div>
                                            <div class="wave__circle"></div>
                                            <div class="wave__circle"></div>
                                        </div>
                                        <div class="star-image-2">
                                            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/Star2.png'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-12 col-12">
                                    <div class="luxury-tab-content">
                                        <?php if (!empty($luxury_shop_cat_desc)) : ?>
                                            <p class="luxury-cat-desc">
                                                <?php echo esc_html($luxury_shop_cat_desc); ?>
                                            </p>
                                        <?php endif; ?>
                                        <a href="<?php echo esc_url($luxury_shop_cat_link); ?>" class="luxury-cat-btn">                                           
                                            <?php esc_html_e('Explore More', 'luxury-shop'); ?>
                                            <span class="cart-icon"><i class="fa-solid fa-arrow-up"></i></span>                                           
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endfor; ?>
                </div>
            </div>
        </div>

    </div>
</div>


<?php endif; ?>
