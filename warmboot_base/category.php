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
					<div class="title-block">
						<h1><?php echo single_cat_title( '', false ); ?></h1>
					</div>
					<div class="category-desc">
						<?php $cat_desc = category_description(); ?>
						<?php
							if($cat_desc){
						?>
							<div class="category-desc"><?php echo $cat_desc; ?></div>
						<?php
							}
						?>
					</div>
					<?php if ( have_posts() ): ?>
					<div class="content-main">

					<div class="row">
						<div class="col-md-9">
							<div class="article-listing">
							<?php get_template_part( 'template_parts/content/content-category', get_post_format() ); ?>
							<?php //do_action("wp_paginator_links", "posts"); ?>
							</div>
						</div>
						<div class="col-md-3">
							<?php get_sidebar(); ?>
						</div>
					</div>

					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_template_parts( array( 'template_parts/global_templates/footer', 'template_parts/global_templates/html-footer' ) ); ?>