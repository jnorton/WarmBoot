<?php
/* Category Content */
?>
<?php $post_counter = 1; ?>
<?php while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php $post_id = get_the_ID(); ?>
<?php
$classes = array();

if ($post_counter == 1) {
	$classes[] = 'headline-post';
} elseif ($post_counter == $the_query->post_count) {
	$classes[] = 'last-post';
} else {
	$classes[] = 'standard-post';
}

if ( has_post_thumbnail()) {
	$classes[] = "has-thumb";
	$classes[] = "clearfix";
}

$classes[] = "row";

$css_class = ' class="'.implode(" ", $classes).'"';

?>
<article<?php echo $css_class; ?>>
	<?php
if ( has_post_thumbnail()) {
?>
	<div class="thumb col-xs-12 col-sm-4 col-md-4">
		<a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark">
		<?php
	the_post_thumbnail('featured-thumb', array('class' => 'img-responsive'));
?>
		</a>
	</div>
	<?php
}
?>
<?php
if ( has_post_thumbnail()) {
?>
	<div class="excerpt col-xs-12 col-sm-8 col-md-8">
			<?php
} else {
?>
	<div class="excerpt col-xs-12 col-sm-12 col-md-12">
		<?php
}
?>

	<h2><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<?php
$args = array(
	'word_count' => 50,
	'more' => false,
	'ellipsis' => true
);
echo render_excerpt($args);
?>
	</div>
</article>
<?php $post_counter++; ?>
<?php endwhile; ?>
<?php //do_action("wp_paginator_links", "posts", $the_query); ?>
<?php wp_reset_postdata(); ?>