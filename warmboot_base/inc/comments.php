<?php
//---------------------------------------------------------------
// COMMENTS
//---------------------------------------------------------------

//preprocess comments with nonce field to reduce comment spam
//http://www.9bitstudios.com/2013/04/add-additional-comment-form-validation-in-wordpress/
function warmboot_base_additional_comment_validation($comment_data) {
    if(!isset( $_POST['comment_nonce'] ) || !wp_verify_nonce( $_POST['comment_nonce'], 'nbs_comment_nonce' ))
        exit;
    else
        return $comment_data;
}
add_filter('preprocess_comment', 'warmboot_base_additional_comment_validation');

// loading jquery reply elements on single pages automatically
function warmboot_base_queue_js() { if (!is_admin()) { if ( is_singular() and comments_open() and (get_option('thread_comments') == 1)) wp_enqueue_script( 'comment-reply' ); }
}
// reply on comments script
add_action('wp_print_scripts', 'warmboot_base_queue_js');
/************* COMMENT LAYOUT *********************/

// Comment Layout
function warmboot_base_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix comment">
			<div class="comment-author vcard row-fluid clearfix">
				<div class="avatar span2">
					<?php echo get_avatar($comment, $size='75' ); ?>
				</div>
				<div class="span10 comment-text">


                    <?php if ($comment->comment_approved == '0') : ?>
       					<div class="alert-message success">
          				<p><?php _e('Your comment is awaiting moderation.', 'warmboot_base'); ?></p>
          				</div>
					<?php endif; ?>

                    <?php comment_text() ?>
                    <div class="clearfix">
                    <div class="pull-left">

                    <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a class="comment-time" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ago'; ?> </a></time>
                    </div>

					<div class="pull-right">
					<?php
						$btn_class = "reply";
					?>
					<?php $test = get_comment_reply_link(array_merge( $args, array('reply_text' => '<span class="'.$btn_class.'">Reply</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'login_text' => '<span class="btn btn-mini">Log in to reply</span>')));
					echo $test;
					?>
					</div>
                	</div>
                </div>
			</div>
		</article>

<?php
} // don't remove this bracket!

// Display trackbacks/pings callback function
function list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
        <li id="comment-<?php comment_ID(); ?>"><i class="icon icon-share-alt"></i>&nbsp;<?php comment_author_link(); ?>
<?php

}

// Only display comments in comment count (which isn't currently displayed in wp-bootstrap, but i'm putting this in now so i don't forget to later)
add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}

/**
 * Custom callback for outputting comments
 *
 * @return void
 * @author Keir Whitaker
 */

	function warmboot_base_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
?>
		<?php if ( $comment->comment_approved == '1' ): ?>
		<li>
			<article id="comment-<?php comment_ID(); ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link(); ?></h4>
				<time><a href="#comment-<?php comment_ID(); ?>" pubdate><?php comment_date(); ?> at <?php comment_time() ?></a></time>
				<?php comment_text(); ?>
			</article>
		<?php endif; ?>
		</li>
		<?php
}

?>
