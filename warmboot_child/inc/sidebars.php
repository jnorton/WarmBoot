<?php

//---------------------------------------------------------------
// SIDEBARS
//---------------------------------------------------------------

// Register the sidebars for the admin panel.
if ( function_exists('register_sidebar') ) {

	register_sidebar(array(
			'name'              => 'Footer Sidebar Left',
			'id'                => 'footer_sidebar_left',
			'before_widget'   	=> '<div id="%1$s" class="%2$s">',
			'after_widget'    	=> '</div>',
			'before_title'      => '',
			'after_title'       => '',
	));

	register_sidebar(array(
			'name'              => 'Footer Sidebar Middle',
			'id'                => 'footer_sidebar_middle',
			'before_widget'   	=> '<div id="%1$s" class="%2$s">',
			'after_widget'    	=> '</div>',
			'before_title'      => '',
			'after_title'       => '',
	));

	register_sidebar(array(
			'name'              => 'Footer Sidebar Right',
			'id'                => 'footer_sidebar_right',
			'before_widget'   	=> '<div id="%1$s" class="%2$s">',
			'after_widget'    	=> '</div>',
			'before_title'      => '',
			'after_title'       => '',
	));

}


?>