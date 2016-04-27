<?php

//---------------------------------------------------------------
// IMPORTANT FUNCTION!!! THIS ADDS SUPPORT FOR CUSTOM POST TYPES TO THE MAIN WP_QUERY OBJECT
//---------------------------------------------------------------

add_filter( 'pre_get_posts', 'cpt_get_posts' );
function cpt_get_posts( $query )
{

	//return if we are viewing a page
	if(is_page()){
		return $query;
	}

	if(isset($query->query_vars['post_type'])){
		return $query;
	}

	//affect only main query
	//if ( $query->is_main_query() && !is_admin() && false == $query->query_vars['suppress_filters']) {
	//affect all queries
	if ( !is_admin() && false == isset($query->query_vars['suppress_filters']) ) {

		$args=array(
			'public'   => true
		);
		$output = 'names'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'
		$post_types = get_post_types($args, $output, $operator);

		//important - do not incude pages in listings such as search results or date archives - it looks crap
		if(is_category() || is_tag() || is_search() || is_date() || is_archive() || is_home()){
			if(in_array('page', $post_types)){
				unset($post_types['page']);
			}
		}

		//important - do not set the query if viewing a custom post type archive, not sure why but it bugs out
		if(in_array(get_query_var('post_type'), $post_types)){
			return $query;
		}

		//don't set query on single pages - this preserves the WordPress internal redirector
		//so you don't get permanent URLs like /post/post-title.
		if (!is_single()){
			$query->set( 'post_type', $post_types );
		}

	}
	return $query;
}

?>