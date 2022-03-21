<?php get_header(); ?>

<?php
$taxonomy_obj = $wp_query->get_queried_object();
$taxonomy_nice_name = $taxonomy_obj->name;
$taxonomy_description = $taxonomy_obj->description;
$portfolio_page = option::get( 'portfolio_url' );
$col_number = option::get('portfolio_grid_col');

?>
<main id="main" role="main"<?php if ( !empty($portfolio_page) && has_post_thumbnail($portfolio_page) ) { echo ' class="portfolio-with-post-cover"'; } ?>>

    <section class="portfolio-archive">

        <div class="portfolio-header-cover">
            <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $portfolio_page ), 'entry-cover' );   ?>
            <?php if ( ! empty( $large_image_url[0] ) ) { ?>
                <div class="portfolio-header-cover-image" style="background-image: url('<?php echo $large_image_url[0] ?>');"></div>
            <?php } ?>

            <div class="portfolio-header-info">
                <div class="entry-info">
                    <h2 class="section-title"><?php echo $taxonomy_nice_name; ?></h2>

                    <div class="entry-header-excerpt"><?php echo $taxonomy_description; ?></div>

                </div>
            </div><!-- .portfolio-header-info -->

        </div><!-- .portfolio-header-cover -->


        <nav class="portfolio-archive-taxonomies">
            <ul>
                <li class="cat-item cat-item-all"><a href="<?php echo get_page_link( option::get( 'portfolio_url' ) ); ?>"><?php _e( 'All', 'wpzoom' ); ?></a></li>

                <?php wp_list_categories( array( 'title_li' => '', 'hierarchical' => true,  'taxonomy' => 'portfolio', 'depth' => 1 ) ); ?>
            </ul>
        </nav>

        <?php if ( $wp_query->have_posts() ) : ?>

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

</main><!-- .site-main -->

<?php
get_footer();
