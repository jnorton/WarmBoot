<?php

//---------------------------------------------------------------
// REMOVE CATEGORY BASE
//---------------------------------------------------------------

add_filter('category_link', 'no_category_parents',1000,2);
function no_category_parents($catlink, $category_id) {
    $category = &get_category( $category_id );
    if ( is_wp_error( $category ) )
        return $category;
    $category_nicename = $category->slug;

    $catlink = trailingslashit(get_option( 'home' )) . user_trailingslashit( $category_nicename, 'category' );
    return $catlink;
}

//---------------------------------------------------------------
// REMOVE CATEGORY PARENTS FROM URL
//---------------------------------------------------------------

add_filter('category_rewrite_rules', 'no_category_parents_rewrite_rules');
function no_category_parents_rewrite_rules($category_rewrite) {
    //print_r($category_rewrite); // For Debugging

    $category_rewrite=array();
    $categories=get_categories(array('hide_empty'=>false));
    foreach($categories as $category) {
        $category_nicename = $category->slug;
        $category_rewrite['('.$category_nicename.')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
        $category_rewrite['('.$category_nicename.')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
        $category_rewrite['('.$category_nicename.')/?$'] = 'index.php?category_name=$matches[1]';
    }
    // Redirect support from Old Category Base
    global $wp_rewrite;
    $old_base = $wp_rewrite->get_category_permastruct();
    $old_base = str_replace( '%category%', '(.+)', $old_base );
    $old_base = trim($old_base, '/');
    $category_rewrite[$old_base.'$'] = 'index.php?category_redirect=$matches[1]';

    //print_r($category_rewrite); // For Debugging
    return $category_rewrite;
}

// FLUSH RULES WHEN CREATING, EDITING OR DELETING CATEGORIES - DO NOT UPDATE HTACCESS
add_action( 'delete_category', 'save_taxonomy', 10, 2 );
add_action( 'create_category', 'save_taxonomy', 10, 2 );
add_action( 'edited_category', 'save_taxonomy', 10, 2 );
function save_taxonomy(){
	flush_rewrite_rules( false );
}

//---------------------------------------------------------------
// REMOVE REL ATTRIBUTE FROM CATEGORY LINKS
//---------------------------------------------------------------

add_filter( 'the_category', 'remove_rel' );
function remove_rel( $text ) {
$text = str_replace('rel="category tag"', "", $text);
return $text;
}

?>