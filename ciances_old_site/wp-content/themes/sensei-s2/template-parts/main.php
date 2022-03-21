<?php
/**
 * The main template file
 *
 * @package Sensei S2
 * @version 2.2.5
 */

?>

<?php $args=array
  (
    'post_type' => 'post',
    'posts_per_page' => 1,
    'orderby' => 'date',
    'order' => 'DESC',
    'ignore_sticky_posts' => 1,
    'no_found_rows' => true
  );
  $query = new WP_Query($args);
  if ($query -> have_posts()) :
?>
<?php while ($query -> have_posts()) : $query -> the_post(); ?>
  <div class="grid fade">
    <div class="grid-item grid-item1"></div>
    <?php if(has_post_thumbnail()) : ?>
    <?php $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
    <div class="grid-item grid-item2" style="background-image: url(<?php echo esc_url($url); ?>);"></div>
    <?php endif; ?>
    <div class="grid-item grid-item3"></div>
    <div class="grid-content">
      <div class="grid-article">
        <h2><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>
        <a class="button inverse" href="<?php the_permalink(); ?>"><?php esc_html_e('read more', 'sensei-s2'); ?></a>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      </div> <!-- grid article -->
    </div> <!-- grid content -->
  </div> <!-- grid -->
<?php else: ?>
  <div class="spacer center">
    <h2 class="no-match-title"><?php esc_html_e('Sorry, no post matched your criteria.', 'sensei-s2'); ?></h2>
  </div>
  <div class="divider"></div>
<?php endif;
