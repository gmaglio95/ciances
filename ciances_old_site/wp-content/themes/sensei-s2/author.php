<?php
/**
 * The author template file
 *
 * @package Sensei S2
 * @version 2.2.5
 */

get_header(); ?>

<main>
  <div class="main main-page" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(<?php header_image(); ?>);">
    <div class="content">
      <div class="main-content center fade">
        <h1><?php esc_html_e('author: ', 'sensei-s2'); ?><?php the_author(); ?></h1>
      </div> <!-- main content -->
    </div> <!-- content -->
  </div> <!-- main -->
</main>

<section>
  <div class="breadcrumbs">
    <div class="content">
      <p><a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('home', 'sensei-s2'); ?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <?php esc_html_e('author: ', 'sensei-s2'); ?><?php the_author(); ?></p>
    </div> <!-- content -->
  </div> <!-- breadcrumbs -->
</section>

<div class="content wrapper">
  <div class="canvas"></div>
  <div class="square"></div>
</div> <!-- content -->

<article class="spacer">
  <?php get_template_part('template-parts/content'); ?>
</article>

<?php get_footer();
