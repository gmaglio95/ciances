<?php
/*
Template Name: Portfolio (Clean)
*/

get_header(); ?>

<main id="main" <?php post_class( (has_post_thumbnail() ? ' portfolio-with-post-cover' : '') ); ?> role="main">

    <section class="portfolio-archive">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'portfolio/includes/portfolio-start' ); ?>

            <?php get_template_part( 'portfolio/includes/filter-isotope' ); ?>

        <?php endwhile; // end of the loop. ?>

        <?php
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

        $args = array(
            'post_type'      => 'portfolio_item',
            'posts_per_page' => -1,
            'orderby' =>'menu_order date'
        );

        $wp_query = new WP_Query( $args );

        $col_number = option::get('portfolio_grid_col');
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <div class="inner-wrap portfolio_template_clean">

                <div class="portfolio-grid col_no_<?php echo $col_number; ?> <?php if ( option::is_on( 'portfolio_whitespace' ) ) { ?> portfolio_with_space<?php } ?>">

                    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                        <?php get_template_part( 'portfolio/content-clean' ); ?>

                        <?php endwhile; ?>

                    </div>

                    <?php get_template_part( 'pagination' ); ?>

                <?php else: ?>

                    <?php get_template_part( 'content', 'none' ); ?>

                <?php endif; ?>

            </section><!-- .portfolio-archive -->

        </main><!-- #main -->

<?php get_footer(); ?>