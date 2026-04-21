<?php
if ( have_posts() ) : 
	while ( have_posts() ) : the_post(); ?>
		<div id="section_elementor" class="elementor_content" style="margin:0; padding:0;">
			<div class="container-fluid p-0">
				<div class="row">
					<?php get_template_part( 'template-parts/entry/layout', 'elementor' ); ?>
				</div>	
			</div>
		</div><!-- .elementor_content -->
      <?php endwhile;
endif; 
?>