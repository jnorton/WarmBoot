<?php

//---------------------------------------------------------------
// SIDEBARS
//---------------------------------------------------------------

// Register the sidebars for the admin panel.
if ( function_exists('register_sidebar') ) {

	register_sidebar(array(
			'name'              => 'Default Sidebar',
			'id'                => 'default-side-bar',
			'before_widget'   	=> '<div id="%1$s" class="panel panel-default %2$s">',
			'after_widget'    	=> '</div></div>',
			'before_title'      => '<div class="panel-heading"><h3 class="panel-title">',
			'after_title'       => '</h3></div><div class="panel-body">',
		));

}


?>