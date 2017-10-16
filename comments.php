<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="comments" id="comments">
  <a name="comments"></a>
  <div class="main">
    <div class="wrapper">
    	<?php
        $comment_args = array(
          'title_reply' => 'Leave a Comment',
          'title_reply_before' => '<h1 id="reply-title" class="comment-reply-title">',
          'title_reply_after' => '</h1>'
        );
        comment_form($comment_args);
      ?>
    </div>
  </div>
  <?php if ( have_comments() ) : ?>
    <div class="secondary single">
      <div class="wrapper">
        <h1>
          <?php
            printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'si-modern' ),
              number_format_i18n( get_comments_number() ) );
          ?>
        </h1>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
          <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'si-modern' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'si-modern' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'si-modern' ) ); ?></div>
          </nav><!-- #comment-nav-above -->
        <?php endif; // Check for comment navigation. ?>
        <?php
          wp_list_comments( array(
            'style'      => 'div',
            'short_ping' => true,
            'avatar_size'=> 34,
            'callback'   => 'customComments'
          ) );
        ?>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
          <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'si-modern' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'si-modern' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'si-modern' ) ); ?></div>
          </nav><!-- #comment-nav-below -->
        <?php endif; // Check for comment navigation. ?>
        <?php if ( ! comments_open() ) : ?>
          <p class="no-comments"><?php _e( 'Comments are closed.', 'si-modern' ); ?></p>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; // have_comments() ?>
</div>
