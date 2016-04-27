<?php

//---------------------------------------------------------------
// USERS
//---------------------------------------------------------------

function check_fields($errors, $update, $user) {
	global $wpdb;
	$display_name_count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE display_name = %s", $user->display_name) );
	if ($display_name_count > 1) {
	$errors->add('display_name_error',__('Alert! The chosen display name is already in use. Please try a different display name.'));
	}
}
add_filter('user_profile_update_errors', 'check_fields', 10, 3);

?>