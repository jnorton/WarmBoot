<?php /*
YARPP Template: Aside / List
Description: This template returns the related posts as a comma-separated list.
Author: Justin Norton (https://www.jnorton.co.uk)
*/
?>

<?php if (have_posts()){ ?>

<aside id="related-posts">
<section>
<header>
	<h3>If you liked this you may also like:</h3>
</header>

<ul>
<?php
while (have_posts()) : the_post();

				$content = get_the_title();
				//$content = string_limit_words($content, 15);


		$posts[] = '<li><a href="'.get_permalink().'" rel="bookmark">'.$content.'</a></li>';
	endwhile;

echo implode($posts);
?>
</ul>
</section>
</aside>

<?php } ?>


