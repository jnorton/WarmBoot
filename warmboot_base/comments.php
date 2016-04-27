<?php
/*
The comments page for bootstrap_base
*/

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
    die ('Please do not load this page directly. Thanks!');
  }

?>
<?php if ( comments_open() ) : ?>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'bootstrap_base' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

<h1 class="uppercase red custom-typeface">Comments</h1>
<section id="respond" class="respond-form">
	<div class="clearfix">
	<div class="pull-left">
	<h2 class="uppercase red custom-typeface">
		<span class="invisible new-comment">
		<?php comment_form_title('Add new comment', 'Leave a reply' ); ?>
		</span>
		<span class="invisible new-reply">
		<?php _e('Leave a reply'); ?>
		</span>
	</h2>
	</div>
	<div class="pull-right">
	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link( __('<span class="btn btn-small">Cancel Reply</span>',"bootstrap_base") ); ?></p>
	</div>
	</div>
	</div>
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="help">
  		<p><?php _e("You must","bootstrap_base"); ?> <a class="btn btn-small" href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e("log in","bootstrap_base"); ?></a> or <a class="btn btn-small" href="/sign-up"><?php _e("Sign up","bootstrap_base"); ?></a> <?php _e("to post a comment","bootstrap_base"); ?>.</p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form-vertical" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

		<div class="clearfix">
		<div class="input">
			<label class="control-label hidden" for="comment"><?php _e("Add new comment","bootstrap_base"); ?></label>
			<textarea cols="45" rows="6" name="comment" id="comment" tabindex="4"></textarea>
		</div>
	</div>

	<div class="comments-logged-in-as pull-left">
		<a href="<?php echo wp_logout_url(get_permalink()); ?>" class="inline" title="<?php _e("Log out of this account","bootstrap_base"); ?>"><?php _e("<span class='btn btn-small'>Log out</a>","bootstrap_base"); ?></a>
	</div>
	<?php else : ?>

	<div id="comment-form-elements" class="clearfix">

			<div class="control-group">
			  <label class="control-label" for="author"><?php _e("Name","bootstrap_base"); ?> <?php if ($req) echo "(required)"; ?></label>
			  <div class="controls">
			  <div class="input-prepend">
			  	<?php
					$icon = '<span class="add-on"><i class="icon-envelope"></i></span>';
				?>
			  	<?php echo $icon; ?><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e("Your Name","bootstrap_base"); ?>" tabindex="1" <?php if ($req) echo "required"; ?> />
			  	</div>
			  </div>
		  	</div>

			<div class="control-group">
			  <label class="control-label" for="email"><?php _e("Email","bootstrap_base"); ?> <?php if ($req) echo "(required)"; ?></label>
			  <div class="controls">
			  <div class="input-prepend">
			  	<?php
					$icon = '<span class="add-on"><i class="icon-envelope"></i></span>';
				?>
			  	<?php echo $icon; ?><input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e("Your Email Address","bootstrap_base"); ?>" tabindex="2" <?php if ($req) echo "required"; ?> />
			  	<span class="help-inline">(<?php _e("will not be published","bootstrap_base"); ?>)</span>
			  </div>
			  </div>
		  	</div>

	</div>

		<div class="clearfix">
		<div class="input">
			<label class="control-label" for="comment"><?php _e("Comment","bootstrap_base"); ?></label>
			<textarea cols="45" rows="6" name="comment" id="comment" tabindex="4" required="required"></textarea>
		</div>
	</div>

	<?php endif; ?>

	<div class="submit-comment textright">
		<?php wp_nonce_field('nbs_comment_nonce', 'comment_nonce'); ?>
	  <button class="btn btn-small btn-info" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e("Submit Comment","bootstrap_base"); ?>">Post</button>
	  <?php comment_id_fields(); ?>
	</div>


	<?php
		//comment_form();
		do_action('comment_form', $post->ID);

	?>

	</form>

	<?php endif; // If registration required and not logged in ?>
</section>

<?php if ( have_comments() ) : ?>

	<h2 id="comment-count"><?php
				printf( _n( 'Showing 1 comment', 'Showing %1$s comments', get_comments_number(), 'bootstrap_base' ),
					number_format_i18n( get_comments_number() ) );
			?></h2>

	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=bootstrap_base_comments'); ?>
	</ol>


	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>

	<?php //do_action("wp_paginator_links", "comments"); ?>

  	<?php endif; // check for comment navigation ?>

  		<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'bootstrap_base' ); ?></p>
	<?php endif; ?>

</div>
<?php endif; // if you delete this the sky will fall on your head ?>

