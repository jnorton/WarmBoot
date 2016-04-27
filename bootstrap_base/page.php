<?php get_template_parts( array( 'template_parts/global_templates/html-header', 'template_parts/global_templates/header' ) ); ?>

<div id="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( function_exists('yoast_breadcrumb') ) { ?>
				<div class="breadcrumbs">
					<ul class="breadcrumb">
						<?php yoast_breadcrumb(); ?>
					</ul>
				</div>
				<?php } ?>
				<div class="content-output">
					<div class="article-listing">
					<?php get_template_part( 'template_parts/content/content-page', get_post_format() ); ?>
					<?php //do_action("wp_paginator_links", "page"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_template_parts( array( 'template_parts/global_templates/footer', 'template_parts/global_templates/html-footer' ) ); ?>