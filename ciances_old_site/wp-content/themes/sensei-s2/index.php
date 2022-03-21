<?php
/**
 * This is the most generic template file in a WordPress theme
 *
 * @package Sensei S2
 * @version 2.2.5
 */

get_header(); ?>

<main>
  <div class="main main-page" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(<?php header_image(); ?>);">
    <div class="content">
      <div class="main-content center fade">
        <?php if (is_category()) { ?>
        <h1><?php esc_html_e('Category: ', 'sensei-s2'); ?><?php single_cat_title(); ?></h1>
        <?php } elseif (is_tag()) { ?>
        <h1><?php esc_html_e('Tag: ', 'sensei-s2'); ?><?php single_tag_title(); ?></h1>
        <?php } elseif (is_month()) { ?>
        <h1><?php esc_html_e('Archive: ', 'sensei-s2'); ?><?php single_month_title(); ?></h1>
        <?php } elseif (is_author()) { ?>
        <h1><?php esc_html_e('author: ', 'sensei-s2'); ?><?php the_author(); ?></h1>
        <?php } elseif (is_search()) { ?>
        <h1><?php esc_html_e( 'Results for: ', 'sensei-s2'); ?><?php echo get_search_query(); ?></h1>
        <?php } else { ?>
        <h1><?php bloginfo('name'); ?></h1>
        <?php } ?>
      </div> <!-- main content -->
    </div> <!-- content -->
  </div> <!-- main -->
</main>

<section class="center fade">
  <div class="divider"></div>
  <h2 class="no-match-title"><?php bloginfo('description'); ?></h2>
</section>

<div class="content wrapper">
  <div class="canvas"></div>
  <div class="square"></div>
</div> <!-- content -->

<article class="spacer">
  <?php get_template_part('template-parts/default'); ?>
</article>

<?php get_footer();
