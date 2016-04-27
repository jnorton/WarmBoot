<?php /* CONTENT SINGLE */ ?>
<?php if ( have_posts() ): while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php $post_id = get_the_ID(); ?>
<article>
	<div class="title-block">
		<h1><?php the_title(); ?></h1>
	</div>
	<div class="post-details clearfix">
		<?php
			$display_post_date = get_post_meta($post->ID, 'display_post_date', true);
			if ($display_post_date == true || $display_post_date == "") {
			?>
		<div class="post-date pull-right">
			Published: <?php echo get_the_date( 'F j, Y' ); ?>
			Updated: <?php the_modified_date('F j, Y'); ?>
		</div>
		<?php } ?>
	</div>
	<div class="content-main">
		<div class="entry-attachment">
			<div class="attachment">
				<?php
					/**
					 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
					 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
					 */
					$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
					foreach ( $attachments as $k => $attachment ) :
						if ( $attachment->ID == $post->ID )
							break;
					endforeach;

					$k++;
					// If there is more than 1 attachment in a gallery
					if ( count( $attachments ) > 1 ) :
						if ( isset( $attachments[ $k ] ) ) :
							// get the URL of the next image attachment
							$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
						else :
							// or get the URL of the first image attachment
							$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
						endif;
					else :
						// or, if there's only 1 image, get the URL of the image
						$next_attachment_url = wp_get_attachment_url();
					endif;
					?>
				<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
					echo wp_get_attachment_image( $post->ID, array( 960, 960 ) );
					?></a>
				<?php if ( ! empty( $post->post_excerpt ) ) : ?>
				<div class="entry-caption">
					<?php the_excerpt(); ?>
				</div>
				<?php endif; ?>
			</div>
			<!-- .attachment -->
		</div>
		<!-- .entry-attachment -->
	</div>
</article>
<?php wp_reset_query(); ?>
<?php endwhile; ?>
<?php endif; ?>