<?php /* CONTENT SINGLE */ ?>
<?php if ( have_posts() ): while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php $post_id = get_the_ID(); ?>
<article>
	<div class="title-block">
		<h1><?php the_title(); ?></h1>
	</div>
	<?php
		if ( has_post_thumbnail()) {
		?>
	<div class="thumb">
		<?php
			the_post_thumbnail('resp-large', array('class' => 'img-responsive'));
			?>
	</div>
	<?php
		}
		?>
	<div class="content-main">
		<?php the_content(); ?>
	</div>
	<?php //do_action("wp_paginator_links", "single"); ?>
</article>
<?php wp_reset_query(); ?>
<?php comments_template( '', true ); ?>
<?php endwhile; ?>
<?php endif; ?>