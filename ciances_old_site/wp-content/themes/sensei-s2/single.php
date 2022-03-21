<?php
/**
 * The single post template file
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
        <div class="entry-meta">
          <p><time><i class="fa fa-clock-o right"></i> <a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a></time> <span class="author"><i class="fa fa-user right"></i> <?php the_author_posts_link(); ?></span></p>
        </div> <!-- entry meta -->
        <?php the_content(); ?>

        <?php wp_link_pages(); ?>

        <div class="taxonomy clearfix">
          <div class="col-6">
            <div class="category">
              <i class="fa fa-folder right"></i>
                <?php the_category(', '); ?>
            </div> <!--category -->
          </div>
          <div class="col-6">
            <div class="tags">
              <?php the_tags('<i class="fa fa-tag right"></i> ',', '); ?>
            </div> <!-- tag -->
          </div>
        </div> <!-- taxonomy -->

        <div class="spacer"></div>
        <div class="wrapper">
          <div class="square square-comments"></div>
        </div> <!-- content -->

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
