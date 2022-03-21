<?php
/**
 * The comments template file
 *
 * @package Sensei S2
 * @version 2.2.5
 */

if ( post_password_required() )
   return;
?>

<div class="comments-area fade">
  <?php if ( have_comments() ) : ?>
  <h2><?php esc_html_e('Join the conversation', 'sensei-s2'); ?></h2>
  <p class="uppercase"><i class="fa fa-comment right" aria-hidden="true"></i> <?php comments_number( esc_html__('No comment', 'sensei-s2'), esc_html__('1 Comment', 'sensei-s2'), esc_html__('% Comments', 'sensei-s2') ); ?></p>
  <div class="divider"></div>
  <ol>
    <?php
      wp_list_comments( array(
        'style'       => 'ol',
        'short_ping'  => true,
        'avatar_size' => 74,
      ) );
    ?>
  </ol>

  <?php
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
  ?>
    <nav class="comment-navigation">
      <h3><?php esc_html_e( 'Comment navigation', 'sensei-s2' ); ?></h3>
      <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Prev', 'sensei-s2' ) ); ?></div>
      <div class="nav-next"><?php next_comments_link( esc_html__( 'Next', 'sensei-s2' ) ); ?></div>
    </nav>
  <?php endif; ?>

  <?php if ( ! comments_open() && get_comments_number() ) : ?>
    <h3><?php esc_html_e( 'Comments are closed.' , 'sensei-s2' ); ?></h3>
  <?php endif; ?>

  <div class="divider"></div>
  <?php endif; ?>
  <?php comment_form(); ?>
</div> <!-- comments area -->
