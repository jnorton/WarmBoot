<?php /* CONTENT PAGE */ ?>
<?php if ( have_posts() ): while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php $post_id = get_the_ID(); ?>
<article>
	<div class="title-block">
		<h1><?php the_title(); ?></h1>
	</div>
	<div class="content-main">
		<?php the_content(); ?>
	</div>
</article>
<?php endwhile; ?>
<?php endif; ?>