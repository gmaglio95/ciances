<?php
/**
 * The front-page template file
 *
 * @package Sensei S2
 * @version 2.2.5
 */

get_header(); ?>

<main>
  <div class="main" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(<?php header_image(); ?>);">
    <div class="content">
      <div class="main-content center fade">
        <?php if (is_home() && display_header_text() ) : ?>
          <h1><?php bloginfo('name'); ?></h1>
          <p><?php bloginfo('description'); ?></p>
        <?php endif; ?>
        <?php if (!is_home() && is_front_page() ) : ?>
          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
          <?php endwhile; ?>
          <?php endif; ?>
        <?php endif; ?>
      </div> <!-- main content -->
    </div> <!-- content -->
  </div> <!-- main -->
</main>

<?php if (!is_home() && is_front_page() ) : ?>
  <article class="fluid">
    <?php get_template_part('template-parts/main'); ?>
  </article>
<?php endif; ?>

<?php if (is_home() ) : ?>
  <div class="content wrapper">
    <div class="canvas"></div>
    <div class="square"></div>
  </div> <!-- content -->

  <article class="spacer">
    <?php get_template_part('template-parts/default'); ?>
  </article>
<?php endif; ?>

<?php get_footer();
