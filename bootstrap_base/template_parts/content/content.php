<?php
	/* Category Content */
	?>

<?php $post_counter = 1; ?>
<?php while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php $post_id = get_the_ID(); ?>
<?php
	$classes = array();
	if($post_counter == 1){
		$classes[] = 'headline-post';
	} elseif($post_counter == $wp_query->post_count) {
		$classes[] = 'last-post';
	} else {
		$classes[] = 'standard-post';
	}
	if ( has_post_thumbnail()) {
			$classes[] = "has-thumb";
			$classes[] = "clearfix";
	}
    $css_class = ' class="'.implode(" ",$classes).'"';
?>

<article<?php echo $css_class; ?>>
	<?php
		if ( has_post_thumbnail()) {
		?>
		<div class="thumb">
			<a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark">
			<?php
				$img = get_the_post_thumbnail($post_id, 'listing-thumb');
				$img_id = get_post_thumbnail_id( $post_id );
				echo responsive_images($img, $img_id);
				?>
			</a>
		</div>
		<?php
			}
			?>
		<h2><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<div class="excerpt">
			<?php
				$args = array(
					'word_count' => 28,
					'more' => false,
					'ellipsis' => true
				);
				echo render_excerpt($args);
			?>
		</div>
</article>
<?php $post_counter++; ?>
<?php endwhile; ?>

