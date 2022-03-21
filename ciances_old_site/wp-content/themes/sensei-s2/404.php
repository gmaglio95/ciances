<?php
/**
 * The 404 template file
 *
 * @package Sensei S2
 * @version 2.2.5
 */

get_header(); ?>

<main>
  <div class="main main-page" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(<?php header_image(); ?>);">
    <div class="content">
      <div class="main-content center fade">
        <h1><?php esc_html_e( '404 page not found', 'sensei-s2'); ?></h1>
      </div> <!-- main content -->
    </div> <!-- content -->
  </div> <!-- main -->
</main>

<section>
  <div class="breadcrumbs">
    <div class="content">
      <p><a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('home', 'sensei-s2'); ?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <?php esc_html_e( '404 Page not found', 'sensei-s2'); ?></p>
    </div> <!-- content -->
  </div> <!-- breadcrumbs -->
</section>

<div class="content wrapper">
  <div class="square square-error"></div>
</div> <!-- content -->

<section class="spacer">
  <div <?php post_class('page-item page-error'); ?>>
    <div class="content clearfix">
      <div class="col-8 fade">
        <h2><?php esc_html_e( 'Page not found', 'sensei-s2'); ?></h2>
        <p><?php esc_html_e( 'The page you are looking for is not here. It has either been moved or never existed. Please go to homepage and start from there instead.', 'sensei-s2'); ?>'</p>
        <a href="<?php echo esc_url(home_url()); ?>" class="button inverse"><?php esc_html_e( 'homepage', 'sensei-s2'); ?> <i class="fa fa-caret-right" aria-hidden="true"></i></a>
        <div class="spacer"></div>
      </div> <!-- col-8 -->

      <div class="col-4">
        <?php get_sidebar(); ?>
      </div> <!-- col-4 -->
    </div> <!-- content -->
  </div> <!-- page -->
</section>

<?php get_footer();
