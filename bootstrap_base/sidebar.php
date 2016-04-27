<?php
/**
 * The Sidebar containing the main widget area.
 */

?>
	<aside id="meta" class="aside">
		<?php 
			$post_type = get_post_type( $post );
			if ( is_post_type_archive('blog') || $post_type == 'blog' ) {
				dynamic_sidebar('blog-side-bar');
			} elseif( is_post_type_archive('learn') || $post_type == 'learn' || is_tax('support-topics') ) {
				dynamic_sidebar('learn-side-bar');
			} elseif ( is_post_type_archive('products') || $post_type == 'products' || is_tax('product-category') || is_tax('product-tags')) {
				dynamic_sidebar('products-side-bar');
			} elseif ( is_tag() || is_category() ) {
				dynamic_sidebar('default-side-bar');
			}
		?>
		<?php  ?>
	</aside>