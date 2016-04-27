<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php wp_title(''); echo (isset($page) && $page > 0) ? ' - page '. $page : null; ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<!-- Chrome frame -->
	  	<!--[if lte IE 10 ]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
		<!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
		<!--[if lte IE 10 ]><meta http-equiv="cleartype" content="on" /><![endif]-->

		<!-- non-retina iPhone pre iOS 7 -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/icon57.png" sizes="57x57">
		<!-- non-retina iPad pre iOS 7 -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/icon72.png" sizes="72x72">
		<!-- non-retina iPad iOS 7 -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/icon76.png" sizes="76x76">
		<!-- retina iPhone pre iOS 7 -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/icon114.png" sizes="114x114">
		<!-- retina iPhone iOS 7 -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/icon120.png" sizes="120x120">
		<!-- retina iPad pre iOS 7 -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/icon144.png" sizes="144x144">
		<!-- retina iPad iOS 7 -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/icon152.png" sizes="152x152">
		<!-- Generic Icon -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/style/ui/icons/favicon.ico" />

		<?php
		/* We add some JavaScript to pages with the comment form
				* to support sites with threaded comments (when in use).
				*/
		if ( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		?>

		<?php wp_head(); ?>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    	<!--[if lt IE 9]>
      		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    	<![endif]-->

		<?php //[jn override] custom CSS and Javascript
		if (is_single() || is_page()) {
			if ($css = get_post_meta($post->ID, 'custom_css', true)) {
				echo $css."\n";
			}
			if ($js = get_post_meta($post->ID, 'custom_javascript', true)) {
				echo $js."\n";
			}
		}
		?>
	</head>

	<body <?php body_class(); ?>>