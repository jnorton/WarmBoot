<?php

//---------------------------------------------------------------
// CUSTOM POST TYPE CHECK
//---------------------------------------------------------------

function is_custom_post_type( $post_type = NULL )
{
    $custom_post_types = get_post_types( array ( '_builtin' => FALSE ) );

    // there are no custom post types
    if ( empty ( $custom_post_types ) ){
        return FALSE;
    }

    if(in_array( $post_type, $custom_post_types )){
    	return true;
    } else {
    	return false;
    }

}

//---------------------------------------------------------------
// Get the category id from a category name
//---------------------------------------------------------------

function get_category_id( $cat_name )
{
	$term = get_term_by( 'name', $cat_name, 'category' );
	return $term->term_id;
}

//---------------------------------------------------------------
// GET ROOT TERM / PARENT FOR POST
//---------------------------------------------------------------

function get_post_root_term($post_id, $taxonomy = 'category') {
    $cats = wp_get_post_terms($post_id, $taxonomy); // category object
    $top_cat_obj = array();
	$obj_ancestors = array();
    //loop through cats to retrieve parent
    foreach($cats as $cat) {
        if ($cat->parent == 0) {
            $top_cat_obj = $cat;
            break;
        }
    }
    //if post doesn't isn't assigned to the parent category get the category ancestors
    if(empty($top_cat_obj)){
	    $obj_ancestors = get_ancestors($cats[0]->term_id, $taxonomy);
	    $top_ancestor_id = array_pop($obj_ancestors);
	    $top_cat_obj = get_term($top_ancestor_id, $taxonomy);
    }

    return $top_cat_obj;
}

//---------------------------------------------------------------
// Append page slugs to the body class
//---------------------------------------------------------------

add_filter('body_class', 'add_slug_to_body_class');
function add_slug_to_body_class( $classes )
{
	global $post;

	if ( is_home() ) {
		$key = array_search( 'blog', $classes );
		if ($key > -1) {
			unset( $classes[$key] );
		};
	} elseif ( is_page() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	} elseif (is_singular()) {
		$classes[] = sanitize_html_class( $post->post_name );
	};

	return $classes;
}

//---------------------------------------------------------------
// Pass in a path and get back the page ID
//---------------------------------------------------------------

function get_page_id_from_path( $path )
{
	$page = get_page_by_path( $path );
	if ( $page ) {
		return $page->ID;
	} else {
		return null;
	};
}

//---------------------------------------------------------------
// Simple wrapper for native get_template_part()
//---------------------------------------------------------------

function get_template_parts( $parts = array() )
{
	foreach ( $parts as $part ) {
		get_template_part( $part );
	};
}

//---------------------------------------------------------------
// POSTED ON
//---------------------------------------------------------------

if ( ! function_exists( 'warmboot_base_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since Twenty Ten 1.0
	 */
	function warmboot_base_posted_on()
	{

		$blog_display_posted_on = get_theme_mod('blog_display_posted_on');
		if ($blog_display_posted_on == false) {
			return;
		}

		printf( __( '<div class="post-meta"><span class="%1$s">Posted by</span> %2$s <span class="meta-sep">on</span> %3$s</div>', 'warmboot_base' ),
			'meta-prep meta-prep-author',
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'warmboot_base' ), get_the_author() ),
				get_the_author()
			),
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date()
			)
		);
	}
endif;

//---------------------------------------------------------------
// POSTED IN
//---------------------------------------------------------------

if ( ! function_exists( 'warmboot_base_posted_in' ) ) :
	/**
	 * Prints HTML with meta information for the current post (category, tags and permalink).
	 *
	 * @since Twenty Ten 1.0
	 */
	function warmboot_base_posted_in()
	{

		$blog_display_posted_in = get_theme_mod('blog_display_posted_in');
		if ($blog_display_posted_in == false) {
			return;
		}

		$blog_tags_icon_class = get_theme_mod('blog_tags_icon_class');
		if ($blog_tags_icon_class == true) {
			$tag = '<i class="'.$blog_tags_icon_class.'"></i> ';
		}

		$blog_bookmark_icon_class = get_theme_mod('blog_bookmark_icon_class');
		if ($blog_bookmark_icon_class == true) {
			$bookmark = '<i class="'.$blog_bookmark_icon_class.'"></i>';
		}

		// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list ) {
			$posted_in = __( '<div class="posted-in">This entry was posted in %1$s and tagged '.$tag.'%2$s. '.$bookmark.'Bookmark this <a href="%3$s" title="%4$s" rel="bookmark">page</a>.</div>', 'warmboot_base' );
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = __( '<div class="posted-in">This entry was posted in %1$s. '.$bookmark.'Bookmark this <a href="%3$s" title="%4$s" rel="bookmark">page</a>.</div>', 'warmboot_base' );
		} else {
			$posted_in = __( '<div class="posted-in">'.$bookmark.'Bookmark this <a href="%3$s" title=" %4$s" rel="bookmark">page</a>.</div>', 'warmboot_base' );
		}
		// Prints the string, replacing the placeholders.
		printf(
			$posted_in,
			get_the_category_list( ', ' ),
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	}
endif;

//---------------------------------------------------------------
// BREADCRUMBS
//---------------------------------------------------------------

/**
 * Builds basic breadcrumbs
 *
 * @param int $cat Category ID
 *
 * @return mixed
 */
function basic_breadcrumbs($sep = "/")
{
	global $post, $wp_query;

	$parent = null;

	/**
	 * Specified category
	 */
	if (is_single()) {
		$category = get_the_category($post->ID);
		if (!empty($category)) {
			$cat = $category[0];
		} else {
			$cat = null;
		}
	} elseif (is_category()) {
		$cat = get_term_by( 'slug', get_query_var('category_name'), 'category' );
	} elseif (is_tag()) {
		$cat = get_term_by( 'slug', get_query_var('tag'), 'post_tag' );
	} elseif (is_archive()) {
		$cat = null;
	}

	if (isset($cat) && $cat->parent != 0) {
		$parent = get_category($cat->parent);
	}

	$bcrumb_custom_post_types = unserialize(constant('BREADCRUMB_POST_TYPES'));

	// Now build up the breadcrumbs
	$output = '<li>';
	$output .= '<a href="/">Home</a> <span class="divider">'.$sep.'</span> ';
/**
	 * Post TYPE
	 */
	if(isset($bcrumb_custom_post_types) && in_array(get_query_var('post_type'), $bcrumb_custom_post_types)) {

	if($post->post_parent == 0){
		$permalink = get_site_url();
		$output .= '<a href="' . $permalink . '">' . ucwords(str_replace("-", " ", get_query_var('post_type'))) . '</a>';
	} else {
		$permalink = get_permalink( $post->post_parent );
		$output .= '<a href="' . $permalink . '">' . get_the_title($post->post_parent) . '</a>';
	}

	}
	elseif (is_category()) {
		if ($parent) {
			$output .= '<a href="' . get_category_link($parent->term_id) . '">' . $parent->name . '</a> <span class="divider">'.$sep.'</span> ';
		}
		$output .= ucfirst($cat->name);
	}
	/**
	 * Displaying on an archive page
	 */
	elseif (is_tag()) {
		if ($parent) {
			$output .= '<a href="' . get_category_link($parent->term_id) . '">' . $parent->name . '</a> <span class="divider">'.$sep.'</span> ';
		}
		$output .= ucfirst($cat->name);
	}
	/**
	 * Displaying on an archive page
	 */
	elseif (is_author(get_the_author())) {
		$output .= "Articles by ";
		$login = get_query_var('author_name');
		$author = get_userdatabylogin($login);
		$author_name = $author->nickname;
		$output .= ucfirst($author_name);
	}
	/**
	 * Displaying on an archive page
	 */
	elseif (is_archive()) {

		if ($parent) {
			$output .= '<a href="' . get_category_link($parent->term_id) . '">' . $parent->name . '</a> <span class="divider">'.$sep.'</span> ';
		}
		if (is_date()) {
			if ( is_day() ) :
				$output .= 'Articles from '.get_the_date( 'jS F Y' );
			elseif ( is_month() ) :
				$output .= 'Articles from '.get_the_date( 'F Y' );
			elseif ( is_year() ) :
				$output .= 'Articles from '.get_the_date( 'Y' );
			else :
				$output .= 'Articles';
			endif;
		} else {
			if (is_custom_post_type($post->post_type)) {
				$output .=  post_type_archive_title('', false);
			}
		}
	}
	/**
	 * Attachment media
	 */
	elseif (is_attachment()) {
		$output .= '<a href="' . get_permalink($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>';
		//$output .= get_the_title();
	}
	/**
	 * Post or Page
	 */
	elseif (is_single()) {
		if (isset($parent)) {
			$output .= '<a href="' . get_category_link($parent->term_id) . '">' . $parent->name . '</a>';
		}
		if (isset($cat)) {
			if($parent){
				$output .= ' <span class="divider">'.$sep.'</span> ';
			}
			$output .= '<a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a>';
		}
		//$output .= get_the_title();
	}

	/**
	 * Post or Page
	 */
	elseif (is_page()) {

		$output .= get_the_title();

	}
	/**
	 * Displaying on an archive page
	 */
	elseif (is_search()) {
		$output .= 'Search results for "'.get_search_query().'"';
	}

	$output .= '</li>';

	return $output;
}

//---------------------------------------------------------------
// EXCERPT HANDLING AND FORMATTING
//---------------------------------------------------------------
function render_excerpt($args)
{
	global $post;
	$content = false;
	$word_count = false;
	$more = false;
	$ellipsis = false;
	$subheading = false;
	extract($args);

	if(trim($post->post_excerpt) != '' && $excerpt == true){
		$excerpt = $post->post_excerpt;
		if ($ellipsis == true) {
		$ellipsis = "&hellip;";
		} else {
			$ellipsis = "";
		}
		if ($more == true) {
			$output = '<p>'.$excerpt.'<span>'.$ellipsis.'</span>'.'</p>'.'<div class="read-more"><a href="'. get_permalink($post->ID) . '" class="'.$more_btn_class.'">Read more</a></div>';
		} else {
			$output = trim(apply_filters('the_excerpt', $excerpt)).'<span>'.$ellipsis.'</span>';
		}
		return $output;
	} else {
		$content = strip_shortcodes($post->post_content);
		$output = string_limit_words($content, $word_count, $more, $ellipsis, $args);
		return $output;
	}
}

function string_limit_words($string, $word_limit, $more = false, $ellipsis = false, $args)
{

	global $post;
	extract($args);

	$words = explode(' ', strip_tags($string), ($word_limit + 1));

	if (count($words) == 1) {
		return $string;
	}

	array_pop($words);
	$text = implode(' ', $words);

	if ($ellipsis == true) {
		$ellipsis = "&hellip;";
	} else {
		$ellipsis = "";
	}

	if ($more == true) {
		$text = '<p>'.$text.'<span>'.$ellipsis.'</span>'.'</p>'.'<div class="read-more clearfix"><a href="'. get_permalink($post->ID) . '" class="'.$more_btn_class.'">Read more</a></div>';
	} else {
		$text = '<p>'.$text.'<span>'.$ellipsis.'</span>'.'</p>';
	}

	return $text;

}

//---------------------------------------------------------------
// IMAGES
//---------------------------------------------------------------

//Our custom caption shortcode function is based on the WordPress Core version with a small change
function custom_img_caption_shortcode( $a , $attr, $content = null)
{

	extract(shortcode_atts(array(
				'id'    => '',
				'align' => '',
				'width' => '',
				'caption' => ''
			), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	$caption = html_entity_decode( $caption );  //Here's our new line to decode the html tags

	$output = '<div class="thumbnail '.$align.'" style="width: '.$width.'px">'. do_shortcode( $content ) . '<div class="caption">' . $caption . '</div></div>';

	return $output;
}
//Add the filter to override the standard shortcode
//add_filter( 'img_caption_shortcode', 'custom_img_caption_shortcode', 10, 3 );

function add_thumbnail_css_to_media_uploader( $form_fields, $post )
{

	if ( substr($post->post_mime_type, 0, 5) != 'image' ) {
		return $form_fields;
	}

	$thumbnail_css = (bool) get_post_meta($post->ID, 'thumbnail_css', true);
	$checked = ($thumbnail_css) ? 'checked' : '';

	$form_fields["thumbnail_css"]["label"] = __("Display border around image");
	$form_fields["thumbnail_css"]["input"] = "html";
	$form_fields["thumbnail_css"]["html"] = "<input type='checkbox' value='1' name='attachments[{$post->ID}][thumbnail_css]' id='attachments[{$post->ID}][thumbnail_css]' $checked />";

	return $form_fields;
}
//add_filter( 'attachment_fields_to_edit', 'add_thumbnail_css_to_media_uploader', null, 2 );

/**
 * Save our new "Copyright" field
 *
 * @param object $post
 * @param object $attachment
 *
 * @return array
 */
function add_thumbnail_css_to_media_uploader_save( $post, $attachment )
{

	$thumbnail_css = (isset($attachment['thumbnail_css'])) ? '1' : '0';

	update_post_meta( $post['ID'], 'thumbnail_css', $thumbnail_css );
	return $post;
}
//add_filter( 'attachment_fields_to_save', 'add_thumbnail_css_to_media_uploader_save', null, 2 );

/**
 * Display our new "Copyright" field
 *
 * @param int $attachment_id
 *
 * @return array
 */
function get_thumbnail_css_thumbnail_css( $attachment_id = null )
{
	$attachment_id = ( empty( $attachment_id ) ) ? get_post_thumbnail_id() : (int) $attachment_id;

	if ( $attachment_id )
		return get_post_meta( $attachment_id, 'thumbnail_css', true );

}

//---------------------------------------------------------------
// AUTO FANCYBOX CLASSES TO IMAGE LINKS
//---------------------------------------------------------------

add_filter('the_content', 'add_fancybox_class');
function add_fancybox_class($content)
{
	global $post;
	$pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a class="fancybox" $1href=$2$3.$4$5 $6>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

//---------------------------------------------------------------
// IMAGE QUALITY
//---------------------------------------------------------------

add_filter('wp_editor_set_quality', function($quality)
	{return 100;});

//---------------------------------------------------------------
// CUSTOM FUNCTION TO RETURN IMAGE CAPTION/S
//---------------------------------------------------------------

function the_post_thumbnail_caption()
{
	global $post;

	$thumbnail_id    = get_post_thumbnail_id($post->ID);
	$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

	if ($thumbnail_image && isset($thumbnail_image[0])) {
		return $thumbnail_image[0]->post_excerpt;
	}
}

//---------------------------------------------------------------
// SCRIPTS AND STYLES
//---------------------------------------------------------------

if ( !function_exists( 'script_enqueuer' ) ) {
	function script_enqueuer()
	{

		//STYLES

		//Boostrap
		wp_register_style( 'bootstrap', get_template_directory_uri().'/style/bootstrap/css/bootstrap.min.css', array(), null );
		wp_enqueue_style( 'bootstrap' );
		wp_register_style( 'bootstrap_ie10_fix', get_template_directory_uri().'/style/bootstrap/ie10-viewport-bug-workaround.css', array(), null );
		wp_enqueue_style( 'bootstrap_ie10_fix' );

		//SCRIPTS

		//Boostrap
		wp_register_script( 'bootstrap', get_template_directory_uri().'/style/bootstrap/js/bootstrap.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'bootstrap' );
		wp_register_script( 'bootstrap_ie10_fix', get_template_directory_uri().'/style/bootstrap/ie10-viewport-bug-workaround.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'bootstrap_ie10_fix' );
		wp_register_script( 'android_select_fix', get_template_directory_uri().'/style/bootstrap/ie10-viewport-bug-workaround.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'android_select_fix' );

	}
}

add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

?>