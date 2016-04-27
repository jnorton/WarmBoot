<?php

//---------------------------------------------------------------
// SCRIPTS AND STYLES
//---------------------------------------------------------------

if ( !function_exists( 'child_theme_script_enqueuer' ) ) {
	function child_theme_script_enqueuer()
	{
		//JS

		wp_register_script( 'site', get_stylesheet_directory_uri().'/style/ui/site/js/site-1.0.0.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'site' );

		//FONT AWESOME
		wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), null );
		wp_enqueue_style( 'font-awesome' );

		//Site CSS
		wp_register_style( 'site', get_stylesheet_directory_uri().'/style/ui/site/css/site-1.0.0.css', array(), null );
		wp_enqueue_style( 'site' );
		wp_register_style( 'media_queries', get_stylesheet_directory_uri().'/style/ui/site/css/media_queries-1.0.0.css', array(), null );
		wp_enqueue_style( 'media_queries' );

	}
}

add_action( 'wp_enqueue_scripts', 'child_theme_script_enqueuer' );

?>