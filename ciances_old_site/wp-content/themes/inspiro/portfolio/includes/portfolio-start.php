    <div class="portfolio-header-cover">
        <?php $entryCoverBackground = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'entry-cover' ); ?>
        <?php if ( !empty( $entryCoverBackground ) ) : ?>

            <div class="portfolio-header-cover-image" style="background-image: url('<?php echo $entryCoverBackground[0] ?>');"></div>

        <?php endif; ?>

        <div class="portfolio-header-info">
            <div class="entry-info">
                <?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

                <div class="entry-header-excerpt"><?php the_content(); ?></div>

            </div>
        </div><!-- .portfolio-header-info -->

    </div><!-- .portfolio-header-cover -->