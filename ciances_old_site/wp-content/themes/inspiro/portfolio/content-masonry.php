<?php

$post_thumbnail = get_the_post_thumbnail_url(get_the_ID());
$video_background_popup_url = get_post_meta(get_the_ID(), 'wpzoom_portfolio_video_popup_url', true);
$background_popup_url = !empty($video_background_popup_url) ? $video_background_popup_url : $post_thumbnail;
$video_background_popup_url_mp4 = get_post_meta(get_the_ID(), 'wpzoom_portfolio_video_popup_url_mp4', true);
$video_background_popup_url_webm = get_post_meta(get_the_ID(), 'wpzoom_portfolio_video_popup_url_webm', true);
$video_background_popup_video_type = get_post_meta(get_the_ID(), 'wpzoom_portfolio_popup_video_type', true);
$popup_video_type = !empty($video_background_popup_video_type) ? $video_background_popup_video_type : 'external_hosted';
$video_background_mp4 = get_post_meta(get_the_ID(), 'wpzoom_portfolio_video_background_mp4', true);
$video_background_webm = get_post_meta(get_the_ID(), 'wpzoom_portfolio_video_background_webm', true);
$is_video_popup = $video_background_popup_url_mp4 || $video_background_popup_url_webm;
$is_video_background_source = $video_background_mp4 || $video_background_webm;
$is_video_background = option::is_on('enable_portfolio_background_video') && $is_video_background_source;
$show_lightbox_image_caption = (int) option::is_on( 'lightbox_title_caption' );

$final_background_src = !empty($video_background_mp4) ? $video_background_mp4 : $video_background_webm;
$popup_final_external_src = !empty($video_background_popup_url_mp4) ? $video_background_popup_url_mp4 : $video_background_popup_url_webm;

$articleClass = ( ! has_post_thumbnail() && !$is_video_background) ? 'no-thumbnail ' : '';

$portfolios = wp_get_post_terms( get_the_ID(), 'portfolio' );

if ( is_array( $portfolios ) ) {
    foreach ( $portfolios as $portfolio ) {
        $articleClass .= ' portfolio_' . $portfolio->term_id . '_item ';
    }
}

if ( $is_video_background ) {
    $filetype             = wp_check_filetype( $final_background_src );
    $video_atts           = array(
        'loop',
        'muted',
        //'preload="auto"',
        'poster="' . esc_attr( get_the_post_thumbnail_url( get_the_ID(), 'portfolio_item-masonry' ) ) . '"'
    );
    $video_atts           = implode( ' ', $video_atts );
    $is_video_popup_class = $is_video_background ? ' is-portfolio-gallery-video-background' : '';
    $articleClass .= $is_video_popup_class;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $articleClass ); ?>>

    <?php if (option::is_on('lightbox_enable') ) { ?>

        <div class="entry-thumbnail-popover">
            <div class="entry-thumbnail-popover-content lightbox_popup_insp popover-content--animated"
                 data-show-caption="<?php echo $show_lightbox_image_caption ?>">
                <!-- start lightbox -->
                <?php if ( $popup_video_type === 'self_hosted' && $is_video_popup ): ?>
                    <div id="zoom-popup-<?php echo $post->ID ?>" class="mfp-hide"
                         data-src="<?php echo $popup_final_external_src ?>">
                        <div class="mfp-iframe-scaler">
                            <?php
                            echo wp_video_shortcode(
                                array(
                                    'src'  => $popup_final_external_src,
                                    'preload' => 'none',
                                    //'autoplay' => 'on'
                                ) );
                            ?>
                            <?php if ( $show_lightbox_image_caption ): ?>
                                <div class="mfp-bottom-bar">
                                    <div class="mfp-title">
                                        <a href="<?php echo esc_url( get_permalink() ); ?>"
                                           title="<?php echo esc_attr( get_the_title() ); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="#zoom-popup-<?php echo $post->ID ?>"
                       class="mfp-inline portfolio-popup-video"></a>
                <?php elseif ( ! empty( $video_background_popup_url ) ): ?><a
                       class="mfp-iframe portfolio-popup-video"
                       href="<?php echo $video_background_popup_url ?>"></a>
               <?php else: ?>
                   <?php if(has_post_thumbnail() && !option::is_on('lightbox_video_only') ): ?>
                        <a class="mfp-image portfolio-popup-video popup_image_insp"
                           href="<?php echo $post_thumbnail ?>"></a>
                        <?php endif; ?>
                <?php endif; ?>

                <h3 class="portfolio_item-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h3>

            </div>
        </div>

        <?php if ( $is_video_background ): ?>
            <video class="portfolio-gallery-video-background" <?php echo $video_atts ?>
                   style=" width:100%; height:auto;vertical-align: middle; display:block;">
                <source src="<?php echo $final_background_src ?>" type="<?php echo $filetype['type'] ?>">
            </video>

            <?php the_post_thumbnail( 'portfolio_item-masonry' ); ?>

        <?php elseif ( has_post_thumbnail() ): ?>

            <?php the_post_thumbnail( 'portfolio_item-masonry' ); ?>

        <?php else: ?>

            <img width="600" height="400"
                 src="<?php echo get_template_directory_uri() . '/images/portfolio_item-placeholder.gif'; ?>">

        <?php endif; ?>

    <?php } else { ?>

        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">

            <div class="entry-thumbnail-popover">
                <div class="entry-thumbnail-popover-content popover-content--animated">
                    <?php the_title( '<h3 class="portfolio_item-title">', '</h3>' ); ?>

                    <?php if ( option::is_on( 'portfolio_excerpt' ) ) : ?>
                        <?php the_excerpt(); ?>
                    <?php endif; ?>

                    <?php if ( option::is_on( 'portfolio_btn' ) ) : ?>
                        <span class="btn"><?php _e( 'Read More', 'wpzoom' ); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ( $is_video_background ): ?>
                <video class="portfolio-gallery-video-background" <?php echo $video_atts ?>
                       style=" width:100%; height:auto;vertical-align: middle; display:block;">
                    <source src="<?php echo $final_background_src ?>" type="<?php echo $filetype['type'] ?>">
                </video>

            <?php elseif ( has_post_thumbnail() ): ?>

                <?php the_post_thumbnail( 'portfolio_item-masonry' ); ?>

            <?php else: ?>

                <img width="600" height="400"
                     src="<?php echo get_template_directory_uri() . '/images/portfolio_item-placeholder.gif'; ?>">

            <?php endif; ?>

        </a>

    <?php } ?>

</article>