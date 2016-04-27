<?php get_template_parts( array( 'template_parts/global_templates/html-header', 'template_parts/global_templates/header' ) ); ?>

<div class="container">
	<div id="content" class="row">
			<div class="col-md-9 content-block right-sidebar">
				<div class="content-output">
					<div class="article-listing">
					<?php if ( have_posts() ): ?>
					<?php get_template_part( 'template_parts/content/content', get_post_format() ); ?>
					<?php //do_action("wp_paginator_links", "posts"); ?>
					<?php endif; ?>
					</div>
				</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_template_parts( array( 'template_parts/global_templates/footer', 'template_parts/global_templates/html-footer' ) ); ?>