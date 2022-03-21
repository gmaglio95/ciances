<?php
/**
 * The sample page template file
 *
 * @package Sensei S2
 * @version 2.2.5
 */

get_header(); ?>

<main>
  <div class="main main-page" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(<?php header_image(); ?>);">
    <div class="content">
      <div class="main-content center fade">
        <h1><?php the_title(); ?></h1>
      </div> <!-- main content -->
    </div> <!-- content -->
  </div> <!-- main -->
</main>

<section>
  <div class="breadcrumbs">
    <div class="content">
      <p><a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('home', 'sensei-s2'); ?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <?php the_title(); ?></p>
    </div> <!-- content -->
  </div> <!-- breadcrumbs -->
</section>

<article class="spacer">
  <div <?php post_class('page-item'); ?>>
    <div class="content clearfix">
      <div class="col-8 fade">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php if(has_post_thumbnail()) : ?>
          <div class="section-post">
            <?php the_post_thumbnail('large', array( 'alt' => get_the_title(), 'class' => 'responsive' ))?>
          </div>
        <?php endif; ?>
        <?php the_content(); ?>

        <?php comments_template(); ?>

        <?php endwhile; else : ?>
          <div class="spacer center">
            <h2 class="no-match-title"><?php esc_html_e('Sorry, no post matched your criteria.', 'sensei-s2'); ?></h2>
          </div>
        <?php endif; ?>
        <div class="spacer clearer"></div>
      </div> <!-- col-8 -->

      <div class="col-4">
        <?php get_sidebar(); ?>
      </div> <!-- col-4 -->
    </div> <!-- content -->
  </div> <!-- page -->
</article>

<?php get_footer();
