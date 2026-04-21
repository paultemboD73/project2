<?php 
// getting page format
$format = get_post_format();
?>
<aside id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 0;">
	
	<?php get_template_part( 'template-parts/entry/media/entry-media', $format ); ?>

	<div class="post-content">								
		<?php get_template_part( 'template-parts/entry/content', 'elementor'); ?>
	</div>
</aside>