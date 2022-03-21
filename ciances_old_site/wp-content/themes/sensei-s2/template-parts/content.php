<?php
/**
 * The content template file
 *
 * @package Sensei S2
 * @version 2.2.5
 */

?>

<div <?php post_class('page-item page-blog'); ?>>
  <div class="content clearfix fade">
      <div class="flex-column">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="column">
          <?php if (has_post_thumbnail()) : ?>
          <div class="card-img responsive">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('large', array( 'alt' => get_the_title() ))?>
            </a>
          </div> <!-- img -->
          <?php endif; ?>
          <div class="card">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php if (!is_search()) : ?>
            <time><i class="fa fa-clock-o right"></i> <a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
            <?php endif; ?>
              <div class="small-divider"></div>
            <?php the_content(); ?>
          </div> <!-- card -->
        </div> <!-- column -->
        <?php endwhile; ?>
      </div> <!-- flex column -->
      <div class="center fade">
        <?php
          the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => __( 'Prev', 'sensei-s2' ),
            'next_text' => __( 'Next', 'sensei-s2' ),
          ) );
        ?>
      </div>
      <?php else : ?>
        <div class="spacer center">
          <h2 class="no-match-title"><?php esc_html_e('Sorry, no post matched your criteria.', 'sensei-s2'); ?></h2>
          <?php get_search_form(); ?>
        </div>
      <?php endif; ?>
  </div> <!-- content -->
</div> <!-- page -->
