<?php /*
YARPP Template: Widget / Panel
Description: This template returns the related posts as a comma-separated list.
Author: Justin Norton (https://www.jnorton.co.uk)
*/
?>

<?php if (have_posts()){ ?>
<div class="panel-body">
	<h3>Related articles</h3>
<?php
while (have_posts()) : the_post();

		$posts[] = '<div class="related clearfix">';
		$content = get_the_title();
		//$content = string_limit_words($content, 15);




		$posts[] = '<h4><a href="'.get_permalink().'" rel="bookmark">'.$content.'</a></h4>';

		$args = array(
				'word_count' => 10,
				'more' => false,
				'ellipsis' => true,
				'more_btn_class' => 'pull-right'

			);
		$posts[] = render_excerpt($args);
		$posts[] = '</div>';
endwhile;

echo implode($posts);
?>


<?php } ?>


