<?php

//---------------------------------------------------------------
// DEBUG
//---------------------------------------------------------------

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//---------------------------------------------------------------
// THEME SETUP
//---------------------------------------------------------------

//Default WordPress settings
add_action( 'after_setup_theme', 'warmboot_base_theme_setup' );
if ( !function_exists('warmboot_base_theme_setup') ) {

	function warmboot_base_theme_setup()
	{

		//---------------------------------------------------------------
		// INCLUDES
		//---------------------------------------------------------------

		//core functionality
		require_once get_template_directory()."/inc/wp_defaults.php"; //wordpress core defaults and customisations
		require_once get_template_directory()."/inc/category_defaults.php"; //wordpress core category customisations
		require_once get_template_directory()."/inc/theme_helpers.php"; //styles, scripts and helpers
		require_once get_template_directory()."/inc/comments.php"; //comment settings
		require_once get_template_directory()."/inc/menus.php"; //custom menus
		require_once get_template_directory()."/inc/users.php"; //wordpress users functionality
		require_once get_template_directory()."/inc/feeds.php"; //feeds for rss and others
		require_once get_template_directory()."/inc/cpt_defaults.php"; //custom post type defaults

		//extra functionality
		require_once get_template_directory()."/inc/sidebars.php"; //support post type

		// First we check to see if our default theme settings have been applied.
		$the_theme_status = get_option( 'theme_setup_status' );

		// If the theme has not yet been used we want to run our default settings.
		if ( $the_theme_status !== '1' ) {

			// Setup Default WordPress settings
			$core_settings = array(
				//admin
				'avatar_default' => 'mystery',
				'avatar_rating' => 'G',
				'default_role' => 'editor',
				//comments
				'comment_moderation' => 0,
				'comments_per_page' => 20,
				'default_pingback_flag'=>0,
				'default_comment_status'=>0,
				'default_ping_status'=>0,
				'comment_registration'=>1,
				'comment_moderation'=>1,
				'comment_whitelist'=>0,
				//users
				'users_can_register' => 0,
				'show_avatars' => 1,
				//posts
				'posts_per_page' => 10,
				//'show_on_front' => 'posts',
				'timezone_string' => 'Europe/London',
				//media
				'thumbnail_size_w' => 320,
				'thumbnail_size_h' => 180,
				'thumbnail_crop' => 1,
				'medium_size_w' => 480,
				'medium_size_h' => 270,
				'large_size_w' => 640,
				'large_size_h' => 360,
				'embed_size_w' => 640,
				'embed_size_h' => 360,
				'embed_autourls' => 1,
			);
			foreach ( $core_settings as $k => $v ) {
				update_option( $k, $v );
			}

			// Delete dummy post, page and comment.
			//wp_delete_post( 1, true );
			//wp_delete_post( 2, true );
			//wp_delete_comment( 1 );

			// Once done, we register our setting to make sure we don't duplicate everytime we activate.
			update_option( 'theme_setup_status', '1' );

			// Lets let the admin know whats going on.
			$msg = '
            <div class="error">
                <p>The ' . get_option( 'current_theme' ) . ' theme is now activated.</p>
            </div>';
			add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
		}
		// Else if we are re-activing the theme
		elseif ( $the_theme_status === '1' and isset( $_GET['activated'] ) ) {
			$msg = '
            <div class="updated">
                <p>The ' . get_option( 'current_theme' ) . ' theme was successfully re-activated.</p>
            </div>';
			add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
		}
	}

}
?>