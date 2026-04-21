<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package luxury_shop
 */
$luxury_shop_heading_setting  = get_theme_mod( 'luxury_shop_post_heading_setting' , true );
$luxury_shop_meta_setting  = get_theme_mod( 'luxury_shop_post_meta_setting' , true );
$luxury_shop_image_setting  = get_theme_mod( 'luxury_shop_post_image_setting' , true );
$luxury_shop_content_setting  = get_theme_mod( 'luxury_shop_post_content_setting' , true );
$luxury_shop_read_more_setting = get_theme_mod( 'luxury_shop_read_more_setting' , true );
$luxury_shop_read_more_text = get_theme_mod( 'luxury_shop_read_more_text', __( 'Read More', 'luxury-shop' ) );
?>

<div class="col-lg-4 col-md-6">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		  if ( $luxury_shop_heading_setting ){ 
			if ( is_single() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		  }

		if ( 'post' === get_post_type() ) : ?>
		<?php
		if ( $luxury_shop_meta_setting ){ ?>
			<div class="entry-meta">
				<?php luxury_shop_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	<?php if ( $luxury_shop_image_setting ) { ?>
			<?php echo (!is_single()) 
				? '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail wow fadeInUp" data-wow-delay="0.2s">'
				: '<div class="post-thumbnail wow fadeInUp" data-wow-delay="0.2s">';
			?>

			<?php if ( has_post_thumbnail() ) {
				// Load thumbnail depending on sidebar
				if ( is_active_sidebar( 'right-sidebar' ) ) {
					the_post_thumbnail( 'luxury-shop-with-sidebar', array( 'itemprop' => 'image' ) );
				} else {
					the_post_thumbnail( 'luxury-shop-without-sidebar', array( 'itemprop' => 'image' ) );
				}
			} else {
				// Load default image
				$luxury_shop_default_img_url = get_template_directory_uri() . '/images/default-header.png'; 
				$luxury_shop_image_class = is_active_sidebar( 'right-sidebar' ) ? 'luxury-shop-with-sidebar' : 'luxury-shop-without-sidebar';
				echo '<img src="' . esc_url( $luxury_shop_default_img_url ) . '" class="' . esc_attr( $luxury_shop_image_class ) . '" alt="' . esc_attr__( 'Default Image', 'luxury-shop' ) . '" itemprop="image" />';
			} ?>

		<?php echo ( ! is_single() ) ? '</a>' : '</div>'; ?>
	<?php } ?>
    <?php
	if ( $luxury_shop_content_setting ){ ?>
		<div class="entry-content" itemprop="text">
			<?php
			if( is_single()){
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'luxury-shop' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
				}else{
				the_excerpt();
				}
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'luxury-shop' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
    <?php } ?>
    <?php if ( !is_single() && $luxury_shop_read_more_setting ) { ?>
        <div class="read-more-button">
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more-button"><?php echo esc_html( $luxury_shop_read_more_text ); ?></a>
        </div>
    <?php } ?>
</article><!-- #post-## -->
</div>