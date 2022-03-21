<?php
/*
Template Name: Portfolio (Infinite Scroll)
*/

get_header(); ?>

<main id="main" <?php post_class( (has_post_thumbnail() ? ' portfolio-with-post-cover' : '') ); ?> role="main">

    <section class="portfolio-archive">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'portfolio/includes/portfolio-start' ); ?>

            <?php get_template_part( 'portfolio/includes/filter' ); ?>

        <?php endwhile; // end of the loop. ?>

        <?php
         $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

         $args = array(
             'post_type'      => 'portfolio_item',
             'paged'          => $paged,
             'posts_per_page' => option::get( 'portfolio_posts' ),
             'orderby' =>'menu_order date'
         );

         $wp_query = new WP_Query( $args );

         $col_number = option::get('portfolio_grid_col');
         ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <script type="text/javascript">
                var wpz_currPage = <?php echo $paged; ?>,
                    wpz_maxPages = <?php echo $wp_query->max_num_pages; ?>,
                    wpz_pagingURL = '<?php echo add_query_arg( array('paged' => '%page%'), get_permalink()); ?>';

            </script>

            <div class="portfolio-grid col_no_<?php echo $col_number; ?> <?php if ( option::is_on( 'portfolio_whitespace' ) ) { ?> portfolio_with_space<?php } ?>">

                <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                    <?php get_template_part( 'portfolio/content' ); ?>

                <?php endwhile; ?>

            </div>

            <?php get_template_part( 'pagination' ); ?>

        <?php else: ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

    </section><!-- .portfolio-archive -->

</main><!-- #main -->

<?php get_footer(); ?>