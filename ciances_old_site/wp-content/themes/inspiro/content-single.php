<article id="post-<?php the_ID(); ?>" <?php post_class( (has_post_thumbnail() ? ' has-post-cover' : '') ); ?>>
    <div class="entry-cover<?php if ( option::get( 'post_overlay' ) == 'off' ) { echo " no-overlay"; } ?>">
        <?php
            $entryCoverBackground = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'entry-cover' );
            $small_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-small');
            $style = ' data-smallimg="' . $small_image_url[0] . '" data-bigimg="' . $entryCoverBackground[0] . '"';
        ?>
        <?php if ( !empty( $entryCoverBackground ) ) : ?>

            <div class="entry-cover-image" <?php echo $style; ?>></div>

        <?php endif; ?>

        <header class="entry-header">
            <div class="entry-info">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                <div class="entry-meta">
                    <?php if ( option::is_on( 'post_category' ) ) : ?><span class="entry-category"><?php _e( 'in', 'wpzoom' ); ?> <?php the_category( ', ' ); ?></span><?php endif; ?>
                    <?php if ( option::is_on( 'post_date' ) )     : ?><p class="entry-date"><?php _e( 'on', 'wpzoom' ); ?> <?php printf( '<time class="entry-date" datetime="%1$s">%2$s</time> ', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?></p> <?php endif; ?>
                </div>
            </div>
        </header><!-- .entry-header -->
    </div><!-- .entry-cover -->

    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->


    <footer class="entry-footer">

        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'wpzoom' ),
            'after'  => '</div>',
        ) );
        ?>


        <?php if ( option::is_on( 'post_tags' ) ) : ?>

            <?php
            the_tags(
                '<div class="tag_list"><h4 class="section-title">' . __( 'Tags', 'wpzoom' ). '</h4>',
                '<span class="separator">,</span>',
                '</div>'
            );
            ?>

        <?php endif; ?>



        <?php if ( option::is_on( 'post_share' ) ) : ?>

            <div class="share">

                <h4 class="section-title"><?php _e( 'Share', 'wpzoom' ); ?></h4>

                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" title="<?php esc_attr_e( 'Tweet this on Twitter', 'wpzoom' ); ?>" class="twitter"><?php echo esc_html( option::get( 'post_share_label_twitter' ) ); ?></a>

                <a href="https://facebook.com/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" target="_blank" title="<?php esc_attr_e( 'Share this on Facebook', 'wpzoom' ); ?>" class="facebook"><?php echo esc_html( option::get( 'post_share_label_facebook' ) ); ?></a>

                <a href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>" target="_blank" title="<?php esc_attr_e( 'Post this to Google+', 'wpzoom' ); ?>" class="gplus"><?php echo esc_html( option::get( 'post_share_label_gplus' ) ); ?></a>

            </div>

        <?php endif; ?>


        <?php if ( option::is_on( 'post_author' ) ) : ?>

            <div class="post_author">

                <?php echo get_avatar( get_the_author_meta( 'ID' ) , 65 ); ?>

                <span><?php _e( 'Written by', 'wpzoom' ); ?></span>

                <?php the_author_posts_link(); ?>

            </div>

        <?php endif; ?>


        <?php edit_post_link( __( 'Edit', 'wpzoom' ), '<span class="edit-link">', '</span>' ); ?>

    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
