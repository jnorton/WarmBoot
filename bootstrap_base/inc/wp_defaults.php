<?php

//---------------------------------------------------------------
// REMOVE WP GENERATOR
//---------------------------------------------------------------

remove_action('wp_head', 'wp_generator');

//---------------------------------------------------------------
// PLUGIN OVERRIDES
//---------------------------------------------------------------

//YOAST SEO
//Remove admin posts filter columns
//add_filter( 'wpseo_use_page_analysis', '__return_false' );

//---------------------------------------------------------------
// POST REVISIONS
//---------------------------------------------------------------

/**
 * Set the post revisions unless the constant was set in wp-config.php
 */
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 5);

//---------------------------------------------------------------
// FOOTER LINKS
//---------------------------------------------------------------

add_filter( 'admin_footer_text', 'my_admin_footer_text' );
function my_admin_footer_text( $default_text )
{
	return '<span id="footer-thankyou">Website developed by <a href="http://www.jnorton.co.uk">Justin Norton</a><span> | Powered by <a href="http://www.wordpress.org">WordPress</a>';
}

//---------------------------------------------------------------
// Lock theme selection to user ID 1 (main admin)
//---------------------------------------------------------------

add_action( 'admin_init', 'lock_themes' );
function lock_themes()
{
	global $submenu, $userdata;
	if ( $userdata->ID != 1 ) {
		unset( $submenu['themes.php'][5] );
		unset( $submenu['themes.php'][15] );

		if ($_GET['access_error']) {
			add_action('admin_notices', 'page_access_admin_notice');
		}

		$restricted_access = array(
			'/wp-admin/themes.php'
		);

		if (in_array($_SERVER['REQUEST_URI'], $restricted_access)) {
			wp_redirect(get_option('siteurl') . '/wp-admin/index.php?access_error=true');
			exit;
		}

	}
}

function page_access_admin_notice()
{
	echo '<div id="permissions-warning" class="error fade"><p><strong>'.__("Unfortunately you don't have permission to access this page.").'</strong></p></div>';
}

//---------------------------------------------------------------
// PLUGIN OVERRIDES
//---------------------------------------------------------------

//YOAST SEO
//Remove admin posts filter columns
//add_filter( 'wpseo_use_page_analysis', '__return_false' );

//---------------------------------------------------------------
// CUSTOM ADMIN LOGIN HEADER LOGO
//---------------------------------------------------------------

add_action('login_head',  'custom_login_logo');
function custom_login_logo()
{
	echo '<style type="text/css">body.login{ background: #fff; } #login{ padding: 40px 0 0; } .login h1{ margin-bottom: 20px;} .login h1 a {  background-image:url(' . get_template_directory_uri() . '/style/ui/icons/logos/logo.png)  !important; background-size:268px 52px; padding-bottom: 0; } </style>';
}

// CUSTOM ADMIN LOGIN LOGO LINK
add_filter('login_headerurl', 'login_url');
function login_url()
{
	return site_url();
}

//---------------------------------------------------------------
// EXCERPTS
//---------------------------------------------------------------

function new_excerpt_more($more)
{
	global $post;
	$text = "Read more &raquo;";
	return '<a href="'. get_permalink($post->ID) . '">'.$text.'</a>';
}
//add_filter('excerpt_more', 'new_excerpt_more');

function custom_excerpt_length( $length )
{
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

?>