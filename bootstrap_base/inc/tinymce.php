<?php
//---------------------------------------------------------------
// TINYMCE STYLES
//---------------------------------------------------------------

add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

function my_mce_buttons_2( $buttons )
{
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );

function my_mce_before_init( $settings )
{

	$style_formats = array(
		array(
			'inline' => 'span',
			'title' => 'Green',
			'classes' => 'text-primary'
		),
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;

}

function add_editor_styles()
{
	add_editor_style( 'editor-styles.css' );
}
add_action( 'init', 'add_editor_styles' );
?>