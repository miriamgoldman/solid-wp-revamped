<?php
/**
 * The template for displaying Comments.
 *
 * @package WordPress
 * @subpackage EWF
 *
 */
	global $post;
?>

			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', EWF_SETUP_THEME_DOMAIN ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
		
	<div class="hr"></div>
	<h4><?php echo __('Comments', EWF_SETUP_THEME_DOMAIN).' ('.get_comments_number().')'; ?></h4>
	<br/>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', EWF_SETUP_THEME_DOMAIN ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', EWF_SETUP_THEME_DOMAIN ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="all-comments">
				<?php
					wp_list_comments( array( 'callback' => 'ewf_comments' ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', EWF_SETUP_THEME_DOMAIN ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', EWF_SETUP_THEME_DOMAIN ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php echo __( 'Comments are closed.', EWF_SETUP_THEME_DOMAIN ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php 	if ( comments_open() ) : ?>
<div class="hr"></div>
<h4><?php _e('Leave a Comment', EWF_SETUP_THEME_DOMAIN); ?></h4>

<form id="comment-form" class="fixed" method="post" action="<?php echo site_url(); ?>/wp-comments-post.php" >
	<fieldset>
		<p>
			<label for="author"><?php _e('Your name', EWF_SETUP_THEME_DOMAIN); ?>: <span class="required">*</span></label><br />
			<input name="author" id="author" class="text" value=""  type="text" />
		</p><p>
			<label for="email"><?php _e('Your Email Adress', EWF_SETUP_THEME_DOMAIN); ?>: <span class="required">*</span></label><br />
			<input type="text"  name="email" class="text" id="email" value="" />
		</p><p>
			<label for="comment"><?php _e('Message', EWF_SETUP_THEME_DOMAIN); ?>: <span class="required">*</span></label><br />
			<textarea name="comment" id="comment" rows="3" cols="25"></textarea>
		</p><p>
			<input type="hidden" name="url" id="url" value="" />
			<input type="submit" name="submit" value="<?php _e('Send!',EWF_SETUP_THEME_DOMAIN); ?>" />
		</p>
		
		<input name="comment_post_ID" value="<?php echo $post->ID ?>" type="hidden" />
	</fieldset>
</form>

<?php endif; // end ?>
</div>