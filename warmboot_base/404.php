<?php get_template_parts( array( 'template_parts/global_templates/html-header', 'template_parts/global_templates/header' ) ); ?>

<div id="content" class="row">
	<div class="col-md-9 content-block right-sidebar">
		<div class="content-output">
			<div class="article-listing">
				<?php get_template_part( 'template_parts/content/content-empty', get_post_format() ); ?>
			</div>
		</div>
	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_template_parts( array( 'template_parts/global_templates/footer', 'template_parts/global_templates/html-footer' ) ); ?>