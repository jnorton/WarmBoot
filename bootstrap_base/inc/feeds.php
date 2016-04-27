<?php

//---------------------------------------------------------------
// FEED CACHE EXPIRY
//---------------------------------------------------------------

function return_1800( $seconds )
{
  // change the default feed cache recreation period to 30 minutes
  return 1800;
}

add_filter( 'wp_feed_cache_transient_lifetime' , 'return_1800' );

//---------------------------------------------------------------
// CATEGORY ON RSS FEEDS
//---------------------------------------------------------------

function category_in_rss($content)
{
	global $post;
	$content .= render_category();
	return $content;

}
add_filter('the_excerpt_rss', 'category_in_rss');
add_filter('the_content_feed', 'category_in_rss');

//---------------------------------------------------------------
// USE EXCERPTS ON FEEDS
//---------------------------------------------------------------

add_filter('the_content', 'fields_in_feed');
function fields_in_feed($content)
{
	if (is_feed()) {

		$args = array(
			'word_count' => 20,
			'more' => false,
			'ellipsis' => true
		);
		$content = '<div class="excerpt">'.render_excerpt($args).'</div>';

	}
	return $content;
}

//---------------------------------------------------------------
// FEATURED IMAGES ON RSS FEEDS
//---------------------------------------------------------------

add_filter( 'rss2_item', 'bootstrap_base_attached_images' );
function bootstrap_base_attached_images()
{
	global $post;

	$featured_image_id = get_post_thumbnail_id( $post_id );
	$attachment = get_post( $featured_image_id );
	//print_r($attachment);

	if ($attachment) {
		$img_attr = wp_get_attachment_image_src( $attachment->ID, 'featured-image' );
		$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
		if ($alt) {
			$title = $alt;
		} else {
			$title = $attachment->post_title;
		}
?>
            <media:content url="<?php echo $img_attr[0]; ?>" type="<?php echo $attachment->post_mime_type; ?>" medium="image" width="<?php echo $img_attr[1]; ?>" height="<?php echo $img_attr[2]; ?>">
                <media:description type="plain"><![CDATA[<?php echo $title; ?>]]></media:description>
                <media:copyright><?php echo get_the_author(); ?></media:copyright>
            </media:content>
            <media:thumbnail url="<?php echo $img_attr[0]; ?>" width="<?php echo $img_attr[1]; ?>" height="<?php echo $img_attr[2]; ?>">
            </media:thumbnail>
            <?php
	}
}

add_filter( 'rss2_ns', 'bootstrap_base_namespace' );

function bootstrap_base_namespace()
{
	echo 'xmlns:media="http://search.yahoo.com/mrss/"
    xmlns:georss="http://www.georss.org/georss"';
}


?>