<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments and the comment form.
 **/
 
?>
<div id="comments" class="comment-box">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'twentyfifteen' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h2>

		

		<div class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'div',
					'short_ping'  => true,
					'avatar_size' => 56,
                    'max_depth' => 2
				) );
               
			?>
		</div><!-- .comment-list -->

		

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>

	<?php //coment form
        $comment_args = array(
            comment_field => '<div class="form-group"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" class="form-control" aria-required="true" rows="4"></textarea></div>',
            class_submit => 'btn btn-default',
            fields =>  array(
                'author' => '<div class="form-group""><label for="author">' 
                    . __( 'Name', 'domainreference' ) .
                    '</label> ' 
                    .( $req ? '<span class="required">*</span>' : '' ) .
                    '<input id="author" name="author" type="text" value="'. esc_attr( $commenter['comment_author'] ) .'" class="form-control"' . $aria_req . ' /></div>',
                'email' => '<div class="form-group"><label for="email">'. __( 'Email', 'domainreference' ) .'</label> '
                    .( $req ? '<span class="required">*</span>' : '' ) .
                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" class="form-control"'. $aria_req . ' /></div>',
                'url' => '<div class="form-group"><label for="url">'. __( 'Website', 'domainreference' ) .'</label>' .
                    '<input id="url" name="url" type="text" value="'. esc_attr( $commenter['comment_author_url'] ) .
    '" class="form-control" /></div>',
            )
        );
        comment_form( $comment_args ); 
    ?>

</div><!-- .comments-area -->


