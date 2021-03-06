<?php
/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

if ( ! function_exists( 'inspiro_setup' ) ) :
/**
 * Theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function inspiro_setup() {
	/**
	 * This theme styles the visual editor to resemble the theme style.
	 */
	add_editor_style( array( 'css/editor-style.css' ) );

	/**
	 * Register image sizes.
	 */
	add_image_size( 'featured', 2000 );
	add_image_size( 'featured-small', 1000 );
	add_image_size( 'recent-thumbnail', 345, 192, true );
	add_image_size( 'recent-thumbnail-retina', 690, 384, true );
	add_image_size( 'woo-featured', 280, 280, true );
	add_image_size( 'entry-cover', 1800 );
	add_image_size( 'portfolio_item-thumbnail', 600, 400, true );
	add_image_size( 'portfolio_item-masonry', 600 );
	add_image_size( 'portfolio-scroller-widget', 9999, 560 );
	add_image_size( 'loop', option::get( 'thumb_width' ), option::get( 'thumb_height' ), true );

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );

	/**
	 * Register nav menus.
	 */
	register_nav_menus( array(
		'primary' => __( 'Main Menu', 'wpzoom' )
	) );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 *  Add theme support for Custom Background.
	 */
	add_theme_support( 'custom-background' );

	/**
	 * Theme Logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true
	) );

	/**
	 * Run migrate options.
	 */
	migrate_theme_options();

    /**
    * Gutenberg Wide Images
    */
    add_theme_support( 'align-wide' );

    inspiro_load_bb_templates();


}
endif;

add_action( 'after_setup_theme', 'inspiro_setup' );


/* Tell the WPZOOM Framework in which theme we're in
==================================== */

add_theme_support( 'wpz-theme-info', array(
   //Theme Name
   'name' => 'Inspiro'
) );


/*  Add support for Featured Posts Module.
============================================ */

add_theme_support( 'wpz-featured-posts-settings', array(
        array(
            //Unique Id that is used to add the new column in posts list table.
            'id'          => 'wpzoom_is_featured_id',
            //Label that appears in the submenu of post types
            'menu_title'  => __( 'Re-order', 'wpzoom' ),
            //Post type in which this feature will be added.
            'post_type'   => 'slider',
            // Limit the featured post that is show on page.
            'posts_limit' => option::get( 'featured_posts_posts' ),
            // if is true the Featured Posts will be show in this post type.
            'show'        => true
        ),
        array(
            //Unique Id that is used to add the new column in posts list table.
            'id'          => 'wpzoom_is_featured_id',
            //Label that appears in the submenu of post types
            'menu_title'  => __( 'Re-order', 'wpzoom' ),
            //Post type in which this feature will be added.
            'post_type'   => 'portfolio_item',
            // Limit the featured post that is show on page.
            'posts_limit' => option::get( 'portfolio_posts' ),
            // if is true the Featured Posts will be show in this post type.
            'show'        => true
        )
    )
);

/* Multiple demo importer support.
 =================================== */

add_theme_support( 'wpz-multiple-demo-importer',
    array(
        'demos'   => array(
            array(
                'name'      => 'default',
                'id'        => 'inspiro-default',
                'thumbnail' => get_template_directory_uri() . '/functions/assets/image/demo-default.png',
            ),
            array(
                'name'      => 'photography',
                'id'        => 'inspiro-photography',
                'thumbnail' => get_template_directory_uri() . '/functions/assets/image/demo-photo.png',
            ),
            array(
                'name'      => 'agency',
                'id'        => 'inspiro-agency',
                'thumbnail' => get_template_directory_uri() . '/functions/assets/image/demo-agency.png',
            ),
            array(
                'name'      => 'video',
                'id'        => 'inspiro-video',
                'thumbnail' => get_template_directory_uri() . '/functions/assets/image/demo-video.png',
            ),
            array(
                'name'      => 'hotel',
                'id'        => 'inspiro-hotel',
                'thumbnail' => get_template_directory_uri() . '/functions/assets/image/demo-hotel.png',
            ),
        ),
        'default' => 'default'
    )
);

/* This theme uses a Static Page as front page.
================================================= */

add_theme_support( 'zoom-front-page-type', array(
    'type' => 'static_page'
) );

/* Portfolio Module @ ZOOM Framework.
======================================= */

add_theme_support( 'zoom-portfolio' );

if ( ! function_exists( 'inspiro_filter_portfolio' ) ) :
    /**
     * Set posts_per_page limit if is portfolio taxonomy.
     *
     * @param $query
     *
     * @return mixed
     */
    function inspiro_filter_portfolio( $query ) {
        if ( $query->is_main_query() && $query->is_tax( 'portfolio' ) ) {
            $query->set( 'posts_per_page', option::get( 'portfolio_posts' ) );
        }

        return $query;
    }
endif;

add_action( 'pre_get_posts', 'inspiro_filter_portfolio' );

/* Flush rewrite rules for custom post types.
=============================================== */

add_action( 'after_switch_theme', 'flush_rewrite_rules' );

/* Slider Metabox for Portfolio @ ZOOM Framework.
=================================================== */

add_theme_support( 'zoom-post-slider', array(
    'portfolio_item' => array(
        'video' => false
    )
) );

if ( ! function_exists( 'inspiro_get_slide_image' ) ) :
    /**
     * Get image with caption, description for slider.
     */
    function inspiro_get_slide_image( $slide ) {
        if ( $slide['slideType'] !== 'image' ) {
            return;
        }

        if ( is_numeric( $slide['imageId'] ) ) {
            $image           = wp_get_attachment_image_src( $slide['imageId'], 'featured' );
            $large_image_url = $image[0];

            $image           = wp_get_attachment_image_src( $slide['imageId'], 'featured-small' );
            $small_image_url = $image[0];
        } else {
            $small_image_url = $large_image_url = $slide['imageId'];
        }

        $caption = '';
        if ( isset( $slide['caption'] ) ) {
            $caption = trim( $slide['caption'] );
        }

        $description = '';
        if ( isset( $slide['description'] ) ) {
            $description = trim( $slide['description'] );
        }

        return array(
            'small_image_url' => $small_image_url,
            'large_image_url' => $large_image_url,
            'caption'         => $caption,
            'description'     => $description,
        );
    }
endif;

/*  Recommended Plugins.
========================== */

if ( ! function_exists( 'zoom_register_theme_required_plugins_callback' ) ) :
    function zoom_register_theme_required_plugins_callback( $plugins ) {

        $plugins = array_merge( array(

            array(
                'name'     => 'Jetpack',
                'slug'     => 'jetpack',
                'required' => false,
            ),

            array(
                'name'     => 'Beaver Builder',
                'slug'     => 'beaver-builder-lite-version',
                'required' => true,
            ),

            array(
                'name'     => 'WPZOOM Addons for Beaver Builder',
                'slug'     => 'wpzoom-addons-for-beaver-builder',
                'required' => true,
            ),

            array(
                'name'     => 'Instagram Widget by WPZOOM',
                'slug'     => 'instagram-widget-by-wpzoom',
                'required' => false,
            ),

            array(
                'name'     => 'Category Order and Taxonomy Terms Order',
                'slug'     => 'taxonomy-terms-order',
                'required' => false,
            )

        ), $plugins );

        return $plugins;
    }
endif;

add_filter( 'zoom_register_theme_required_plugins', 'zoom_register_theme_required_plugins_callback' );

if ( ! function_exists( 'is_blog' ) ) :
    /**
     * Verify if is blog.
     *
     * @return bool
     */
    function is_blog() {
        global $post;
        $posttype = get_post_type( $post );

        return ( ( $posttype == 'post' ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() || is_author() ) ) ? true : false;
    }
endif;
/**
 * Fix blog link on current page parent.
 *
 * @param $classes
 * @param $item
 * @param $args
 *
 * @return mixed
 */
if ( ! function_exists( 'fix_blog_link_on_cpt' ) ) :
    function fix_blog_link_on_cpt( $classes, $item, $args ) {
        if ( ! is_blog() ) {
            $blog_page_id = intval( get_option( 'page_for_posts' ) );
            if ( $blog_page_id != 0 && $item->object_id == $blog_page_id ) {
                unset( $classes[ array_search( 'current_page_parent', $classes ) ] );
            }
        }

        return $classes;
    }
endif;

add_filter( 'nav_menu_css_class', 'fix_blog_link_on_cpt', 10, 3 );

/*  WooCommerce Support.
========================== */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

}

/*  WooCommerce Extra Features
 *
 * Change number of related products on product page.
 * ==================================================== */

if ( ! function_exists( 'inspiro_wc_menu_cartitem' ) ) :
    /**
     * Generates list item for WooCommerce cart to be used in nav menu.
     */
    function inspiro_wc_menu_cartitem() {
        global $woocommerce;

        if ( ! current_theme_supports( 'woocommerce' ) ) {
            return;
        }
        if ( ! option::is_on( 'cart_icon' ) ) {
            return;
        }

        $class = 'menu-item ';

        if ( is_cart() || is_checkout() ) {
            $class .= 'current-menu-item';
        }

        return '<li class="' . $class . '"><a href="' . wc_get_cart_url() . '" title="' . esc_attr__( 'View your shopping cart', 'wpzoom' ) . '" class="cart-button">' . '<span>' . sprintf( _n( '%d item &ndash; ', '%d items &ndash; ', $woocommerce->cart->get_cart_contents_count(), 'wpzoom' ), $woocommerce->cart->get_cart_contents_count() ) . $woocommerce->cart->get_cart_total() . '</span></a></li>';
    }
endif;

if ( ! function_exists( 'inspiro_add_to_cart_fragment' ) ) :

    function inspiro_add_to_cart_fragment( $fragments ) {
        global $woocommerce;

        ob_start();

        ?>
        <a class="cart-button" href="<?php echo wc_get_cart_url(); ?>"
           title="<?php _e( 'View your shopping cart', 'wpzoom' ); ?>"><?php echo sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'wpzoom' ), $woocommerce->cart->cart_contents_count ); ?> &ndash; <?php echo $woocommerce->cart->get_cart_total(); ?></a>
        <?php

        $fragments['a.cart-button'] = ob_get_clean();

        return $fragments;

    }

endif;

add_filter( 'add_to_cart_fragments', 'inspiro_add_to_cart_fragment' );

if ( ! function_exists( 'woo_related_products_limit' ) ) :
    function woo_related_products_limit() {
        global $product;

        $args = array(
            'post_type'           => 'product',
            'no_found_rows'       => 1,
            'posts_per_page'      => 4,
            'ignore_sticky_posts' => 1,
            'post__not_in'        => array( $product->id )
        );

        return $args;
    }

endif;

add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );

/*  Add Support for Shortcodes in Excerpt.
============================================ */

add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );

add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

/*  Custom Excerpt Length.
============================ */

if ( ! function_exists( 'new_excerpt_length' ) ) :
    /**
     * Set excerpt length.
     *
     * @param $length
     *
     * @return int
     */
    function new_excerpt_length( $length ) {
        return (int) option::get( "excerpt_length" ) ? (int) option::get( "excerpt_length" ) : 50;
    }
endif;

add_filter( 'excerpt_length', 'new_excerpt_length' );

/* Enable Excerpts for Pages.
=============================== */

if ( ! function_exists( 'wpzoom_excerpts_to_pages' ) ) :
    /**
     * Add excerpt page support.
     */
    function wpzoom_excerpts_to_pages() {
        add_post_type_support( 'page', 'excerpt' );
    }
endif;

add_action( 'init', 'wpzoom_excerpts_to_pages' );


/* Exclude specific images from being used in Jetpack's Lazy Load
=========================================== */

add_filter( 'jetpack_lazy_images_blacklisted_classes', 'inspiro_exclude_custom_classes_from_lazy_load', 999, 1 );

if ( ! function_exists( 'inspiro_exclude_custom_classes_from_lazy_load' ) ) :

    function inspiro_exclude_custom_classes_from_lazy_load( $classes ) {
        $classes[] = 'size-portfolio_item-thumbnail';
        $classes[] = 'size-portfolio_item-masonry';
        $classes[] = 'attachment-portfolio-scroller-widget';
        return $classes;
    }
endif;

/* Add body class if main sidebar exists.
=========================================== */

if ( ! function_exists( 'inspiro_body_classes_sidebar' ) ) :
    /**
     * Insert class is sidebar exists.
     *
     * @param $classes
     *
     * @return array
     */
    function inspiro_body_classes_sidebar( $classes ) {
        if ( is_active_sidebar( 'sidebar' ) ) {
            $classes[] = 'inspiro--with-page-nav';
        }

        return $classes;
    }
endif;

add_filter( 'body_class', 'inspiro_body_classes_sidebar' );

/*  Maximum width for images in posts.
======================================== */

if ( ! isset( $content_width ) ) {
    $content_width = 930;
}


if ( ! function_exists( 'inspiro_content_width' ) ) :
    /**
     * Change $content_width for full screen templates.
     */
    function inspiro_content_width() {
        if ( is_page_template( 'page-templates/template-full.php' ) || is_page_template( 'page-templates/template-full_dark.php' ) ) {
            global $content_width;
            $content_width = 4000;
        }
    }
endif;

add_action( 'template_redirect', 'inspiro_content_width' );

/* Changing "content_width" parameter for Vimeo videos.
========================================================= */

if ( ! function_exists( 'inspiro_vimeo_embed_defaults' ) ) :
    /**
     * Changing "content_width" parameter for Vimeo videos.
     *
     * @param $args
     * @param $url
     *
     * @return mixed
     */
    function inspiro_vimeo_embed_defaults( $args, $url ) {
        $wp_oembed = _wp_oembed_get_object();

        $provider = $wp_oembed->get_provider( $url, array( 'discover' => false ) );

        if ( is_admin() &&
             wp_doing_ajax() &&
             isset( $_POST['action'] ) &&
             $_POST['action'] === 'attach_remote_video_thumb' &&
             ! empty( $provider ) &&
             ( strpos( $provider, 'vimeo' ) !== false )
        ) {
            $args['width'] = 1280;
        }

        return $args;
    }
endif;

add_filter( 'embed_defaults', 'inspiro_vimeo_embed_defaults', 10, 2 );

/* Make the Gallery Widget (Jetpack) wider.
============================================= */

if ( ! function_exists( 'gallery_widget_content_width_callback' ) ) :
    /**
     * Set Jetpack gallery widget width.
     *
     * @param $width
     *
     * @return int
     */
    function gallery_widget_content_width_callback( $width ) {
        return 1215;
    }
endif;

add_filter( 'gallery_widget_content_width', 'gallery_widget_content_width_callback' );

/* Returns true if there is a chance that current post has cover.
=================================================================== */

if ( ! function_exists( 'inspiro_maybeWithCover' ) ) :
    function inspiro_maybeWithCover() {
        global $paged;

        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product() ) {
            return false;
        }

        if ( option::is_on( 'featured_posts_show' ) && is_front_page() && isset( $paged ) && $paged < 2 ) {
            return true;
        }

        if ( ! is_single() && ! is_page() ) {
            return false;
        }

        return has_post_thumbnail( get_queried_object_id() );
    }
endif;

/* Comments Custom Template.
============================== */

if ( ! function_exists( 'wpzoom_comment' ) ) :
    function wpzoom_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case '' :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>">
                    <div class="comment-author vcard">
                        <?php echo get_avatar( $comment, 50 ); ?>
                        <?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>

                        <div class="comment-meta commentmetadata"><a
                                href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                                <?php printf( __( '%s @ %s', 'wpzoom' ), get_comment_date(), get_comment_time() ); ?></a>
                            <?php comment_reply_link( array_merge( $args, array(
                                'depth'      => $depth,
                                'max_depth'  => $args['max_depth'],
                                'reply_text' => __( 'Reply', 'wpzoom' ),
                                'before'     => '&nbsp;??&nbsp;&nbsp;'
                            ) ) ); ?>
                            <?php edit_comment_link( __( 'Edit', 'wpzoom' ), '&nbsp;??&nbsp;&nbsp;' ); ?>

                        </div>
                        <!-- .comment-meta .commentmetadata -->

                    </div>
                    <!-- .comment-author .vcard -->
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wpzoom' ); ?></em>
                        <br/>
                    <?php endif; ?>

                    <div class="comment-body"><?php comment_text(); ?></div>

                </div><!-- #comment-##  -->

                <?php
                break;
            case 'pingback'  :
            case 'trackback' :
                ?>
                <li class="post pingback">
                <p><?php _e( 'Pingback:', 'wpzoom' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'wpzoom' ), ' ' ); ?></p>
                <?php
                break;
        endswitch;
    }
endif;


/* Register custom shortcodes.
================================ */

if ( ! function_exists( 'wpz_shortcode_fullscreen' ) ) :
    function wpz_shortcode_fullscreen( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'title' => __( 'Fullscreen Image', 'wpzoom' ),
        ), $atts ) );

        return '<div class="fullimg">' . do_shortcode( $content ) . '</div>' . "\n";
    }
endif;

add_shortcode( 'fullscreen', 'wpz_shortcode_fullscreen' );

if ( ! function_exists( 'add_fullscreen_buttons' ) ) :

    function add_fullscreen_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }

        if ( get_user_option( 'rich_editing' ) == 'true' ) {
            add_filter( 'mce_external_plugins', 'add_fullscreen_tinymce_plugin' );
            add_filter( 'mce_buttons', 'register_fullscreen_buttons' );
        }
    }
endif;

add_action( 'init', 'add_fullscreen_buttons' );

if ( ! function_exists( 'register_fullscreen_buttons' ) ) :
    function register_fullscreen_buttons( $buttons ) {
        array_push( $buttons, "|", "fullscreen" );

        return $buttons;
    }
endif;

if ( ! function_exists( 'add_fullscreen_tinymce_plugin' ) ) :
    function add_fullscreen_tinymce_plugin( $plugin_array ) {
        $plugin_array['fullscreen_btn'] = get_template_directory_uri() . '/functions/assets/js/fullscreen_buttons.js';

        return $plugin_array;
    }
endif;

if ( ! function_exists( 'fullscreen_refresh_mce' ) ) :
    function fullscreen_refresh_mce( $ver ) {
        $ver += 3;

        return $ver;
    }
endif;

add_filter( 'tiny_mce_version', 'fullscreen_refresh_mce' );

/* Disable Unyson shortcodes with the same name as in ZOOM Framework.
======================================================================= */

if ( ! function_exists( '_filter_theme_disable_default_shortcodes' ) ) :
    function _filter_theme_disable_default_shortcodes( $to_disable ) {
        $to_disable[] = 'tabs';
        $to_disable[] = 'button';

        return $to_disable;
    }
endif;

add_filter( 'fw_ext_shortcodes_disable_shortcodes', '_filter_theme_disable_default_shortcodes' );

if ( ! function_exists( 'fw_get_category_term_list' ) ) :
    /**
     * Function that return an array of categories by post_type.
     *
     * @return array - array of available categories
     */
    function fw_get_category_term_list( $post_type = 'post' ) {

        $args   = array(
            'hide_empty' => true,
            'taxonomy'   => 'category'
        );

        if ( $post_type === 'portfolio' ) {
            $args   = array(
                'hide_empty' => true,
                'taxonomy'   => 'portfolio'
            );
        } elseif ( $post_type === 'product' ) {
            $args   = array(
                'hide_empty' => true,
                'taxonomy'   => 'product_cat'
            );
        }

        $terms  = get_terms( $args );
        $result = wp_list_pluck( $terms, 'name', 'term_id' );

        return array( 0 => esc_html__( 'All Categories', 'fw' ) ) + $result;
    }
endif;

/**
 * Show custom logo or blog title and description.
 *
 */
if ( ! function_exists( 'inspiro_custom_logo' ) ) :
    function inspiro_custom_logo() {
        //In future must remove it is for backward compatibility.
        if ( get_theme_mod( 'logo' ) ) {
            set_theme_mod( 'custom_logo', zoom_get_attachment_id_from_url( get_theme_mod( 'logo' ) ) );
            remove_theme_mod( 'logo' );
        }

        has_custom_logo() ? the_zoom_custom_logo() : printf( '<h1><a href="%s" title="%s">%s</a></h1>', home_url(), get_bloginfo( 'description' ), get_bloginfo( 'name' ) );
    }
endif;



/**
 *
 * Register Beaver Builder Templates in our theme
 *
 */
function inspiro_load_bb_templates() {

    if ( ! class_exists( 'FLBuilder' ) || ! method_exists( 'FLBuilder', 'register_templates' ) ) {
        return;
    }

    FLBuilder::register_templates( get_template_directory() . '/functions/bb-templates/default.dat' );
    FLBuilder::register_templates( get_template_directory() . '/functions/bb-templates/agency.dat' );
    FLBuilder::register_templates( get_template_directory() . '/functions/bb-templates/hotel.dat' );
    FLBuilder::register_templates( get_template_directory() . '/functions/bb-templates/video.dat' );
    FLBuilder::register_templates( get_template_directory() . '/functions/bb-templates/about.dat' );
    FLBuilder::register_templates( get_template_directory() . '/functions/bb-templates/services.dat' );
}


/**
 *
 * Old Customizer backward compatibility.
 * Migrate Theme Options to Customizer.
 *
 */
if ( ! function_exists( 'migrate_theme_options' ) ) :
    function migrate_theme_options() {

        $prefix = option::$prefix;

        if ( get_theme_mod( 'font-family-site-body' ) ) {
            set_theme_mod( 'body-font-family', get_theme_mod( 'font-family-site-body' ) );
            remove_theme_mod( 'font-family-site-body' );
        }

        if ( get_theme_mod( 'font-family-site-title' ) ) {
            set_theme_mod( 'title-font-family', get_theme_mod( 'font-family-site-title' ) );
            remove_theme_mod( 'font-family-site-title' );
        }

        if ( get_theme_mod( 'font-family-nav' ) ) {
            set_theme_mod( 'mainmenu-font-family', get_theme_mod( 'font-family-nav' ) );
            remove_theme_mod( 'font-family-nav' );
        }

        if ( get_theme_mod( 'font-family-slider-title' ) ) {
            set_theme_mod( 'slider-title-font-family', get_theme_mod( 'font-family-slider-title' ) );
            remove_theme_mod( 'font-family-slider-title' );
        }

        if ( get_theme_mod( 'font-family-slider-description' ) ) {
            set_theme_mod( 'slider-text-font-family', get_theme_mod( 'font-family-slider-description' ) );
            remove_theme_mod( 'font-family-slider-description' );
        }

        if ( get_theme_mod( 'font-family-slider-slider' ) ) {
            set_theme_mod( 'slider-button-font-family', get_theme_mod( 'font-family-slider-slider' ) );
            remove_theme_mod( 'font-family-slider-slider' );
        }

        if ( get_theme_mod( 'font-family-widgets-homepage' ) ) {
            set_theme_mod( 'home-widget-full-font-family', get_theme_mod( 'font-family-widgets-homepage' ) );
            remove_theme_mod( 'font-family-widgets-homepage' );
        }

        if ( get_theme_mod( 'font-family-widgets-others' ) ) {
            set_theme_mod( 'widget-title-font-family', get_theme_mod( 'font-family-widgets-others' ) );
            remove_theme_mod( 'font-family-widgets-others' );
        }

        if ( get_theme_mod( 'font-family-post-title' ) ) {
            set_theme_mod( 'blog-title-font-family', get_theme_mod( 'font-family-post-title' ) );
            remove_theme_mod( 'font-family-post-title' );
        }

        if ( get_theme_mod( 'font-family-single-post-title' ) ) {
            set_theme_mod( 'post-title-font-family', get_theme_mod( 'font-family-single-post-title' ) );
            remove_theme_mod( 'font-family-single-post-title' );
        }

        if ( get_theme_mod( 'font-family-page-title' ) ) {
            set_theme_mod( 'page-title-font-family', get_theme_mod( 'font-family-page-title' ) );
            remove_theme_mod( 'font-family-page-title' );
        }

        if ( get_theme_mod( 'font-family-page-title-image' ) ) {
            set_theme_mod( 'page-title-image-font-family', get_theme_mod( 'font-family-page-title-image' ) );
            remove_theme_mod( 'font-family-page-title-image' );
        }

        if ( get_theme_mod( 'font-family-portfolio-title' ) ) {
            set_theme_mod( 'portfolio-title-font-family', get_theme_mod( 'font-family-portfolio-title' ) );
            remove_theme_mod( 'font-family-portfolio-title' );
        }

        /**
         * Homepage Slider.
         */

        // Define defaults if option value is null
        $slider_show     = option::get( 'featured_posts_show' ) != '' ? option::get( 'featured_posts_show' ) : 'on';
        $slider_autoplay = option::get( 'slideshow_auto' ) != '' ? option::get( 'slideshow_auto' ) : 'off';
        $slider_speed    = option::get( 'slideshow_speed' ) != '' ? option::get( 'slideshow_speed' ) : '3000';
        $slider_title    = option::get( 'slideshow_title' ) != '' ? option::get( 'slideshow_title' ) : 'on';
        $slider_excerpt  = option::get( 'slideshow_excerpt' ) != '' ? option::get( 'slideshow_excerpt' ) : 'on';
        $slider_arrows   = option::get( 'slideshow_arrows' ) != '' ? option::get( 'slideshow_arrows' ) : 'on';
        $slider_overlay  = option::get( 'slideshow_overlay' ) != '' ? option::get( 'slideshow_overlay' ) : 'on';
        $slider_effect   = option::get( 'slideshow_effect' ) != '' ? strtolower( option::get( 'slideshow_effect' ) ) : 'slide';
        $slider_posts    = option::get( 'featured_posts_posts' ) != '' ? option::get( 'featured_posts_posts' ) : '5';

        if ( get_option( $prefix . 'featured_posts_show' ) ) {
            set_theme_mod( 'featured_posts_show', $slider_show );
            delete_option( $prefix . 'featured_posts_show' );
        }

        if ( get_option( $prefix . 'slideshow_auto' ) ) {
            set_theme_mod( 'slideshow_auto', $slider_autoplay );
            delete_option( $prefix . 'slideshow_auto' );
        }

        if ( get_option( $prefix . 'slideshow_speed' ) ) {
            set_theme_mod( 'slideshow_speed', $slider_speed );
            delete_option( $prefix . 'slideshow_speed' );
        }

        if ( get_option( $prefix . 'slideshow_title' ) ) {
            set_theme_mod( 'slideshow_title', $slider_title );
            delete_option( $prefix . 'slideshow_title' );
        }

        if ( get_option( $prefix . 'slideshow_excerpt' ) ) {
            set_theme_mod( 'slideshow_excerpt', $slider_excerpt );
            delete_option( $prefix . 'slideshow_excerpt' );
        }

        if ( get_option( $prefix . 'slideshow_arrows' ) ) {
            set_theme_mod( 'slideshow_arrows', $slider_arrows );
            delete_option( $prefix . 'slideshow_arrows' );
        }

        if ( get_option( $prefix . 'slideshow_overlay' ) ) {
            set_theme_mod( 'slideshow_overlay', $slider_overlay );
            delete_option( $prefix . 'slideshow_overlay' );
        }

        if ( get_option( $prefix . 'slideshow_effect' ) ) {
            set_theme_mod( 'slideshow_effect', $slider_effect );
            delete_option( $prefix . 'slideshow_effect' );
        }

        if ( get_option( $prefix . 'featured_posts_posts' ) ) {
            set_theme_mod( 'featured_posts_posts', $slider_posts );
            delete_option( $prefix . 'featured_posts_posts' );
        }

    }
endif;

/* Enqueue scripts and styles for the front end.
================================================== */

if ( ! function_exists( 'inspiro_scripts' ) ) :
    function inspiro_scripts() {
        // Load our main stylesheet.
        $data = inspiro_customizer_data();

        if ( '' !== $google_request = zoom_get_google_font_uri($data) ) {
            wp_enqueue_style( 'inspiro-google-fonts', $google_request, WPZOOM::$themeVersion );
        }
        wp_enqueue_style( 'inspiro-style', get_stylesheet_uri(), array(), WPZOOM::$themeVersion );

        wp_enqueue_style( 'media-queries', get_template_directory_uri() . '/css/media-queries.css', array(), WPZOOM::$themeVersion );

        $color_scheme = get_theme_mod('color-palettes', zoom_customizer_get_default_option_value('color-palettes', $data));
        wp_enqueue_style('inspiro-style-color-' . $color_scheme, get_template_directory_uri() . '/styles/' . $color_scheme . '.css', array(), WPZOOM::$themeVersion);

        wp_enqueue_style( 'inspiro-google-font-default', '//fonts.googleapis.com/css?family=Libre+Franklin:100,100i,200,200i,300,300i,400,400i,600,600i,700,700i|Montserrat:500,700&subset=latin,latin-ext,cyrillic' );

        wp_enqueue_style( 'dashicons' );

        wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'imagesLoaded', get_template_directory_uri() . '/js/imagesLoaded.min.js', array(), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'flickity', get_template_directory_uri() . '/js/flickity.pkgd.min.js', array(), WPZOOM::$themeVersion, true );

        wp_enqueue_style( 'magnificPopup', get_template_directory_uri() . '/css/magnific-popup.css', array(), WPZOOM::$themeVersion );

        wp_enqueue_style( 'formstone-background', get_template_directory_uri() . '/css/background.css', array(), WPZOOM::$themeVersion );

        wp_enqueue_script( 'magnificPopup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array(), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'masonry' );

        wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'headroom', get_template_directory_uri() . '/js/headroom.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'search_button', get_template_directory_uri() . '/js/search_button.js', array(), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'jquery.parallax', get_template_directory_uri() . '/js/jquery.parallax.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

        // Enqueue Isotope when Portfolio Isotope template is used.
        // if ( is_page_template( 'portfolio/archive-isotope.php' )  || is_page_template( 'portfolio/archive-clean.php' )) {
            wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array('wp-util'), WPZOOM::$themeVersion, true );
        // }

        $themeJsOptions = array_merge( option::getJsOptions(), option::getCustomizerJsOptions() );

        wp_enqueue_script( 'inspiro-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

        wp_localize_script( 'inspiro-script', 'zoomOptions', $themeJsOptions );

        if (
            is_page_template( 'page-templates/homepage-builder-bb.php' ) ||
            is_page_template( 'page-templates/template-home-widgets.php' ) ||
            is_page_template( 'page-templates/homepage-builder.php' ) ||
            is_front_page()

        ) {
            // Vimeo API
            wp_enqueue_script( 'vimeo_iframe_api', 'https://player.vimeo.com/api/player.js', array( 'jquery' ), false, true );
        }
    }
endif;

add_action( 'wp_enqueue_scripts', 'inspiro_scripts' );


/* Enqueue Formstone-related scripts (video background)
================================================== */

if ( ! function_exists( 'inspiro_video_scripts' ) ) :
    function inspiro_video_scripts() {

        wp_enqueue_script( 'formstone-core', get_template_directory_uri() . '/js/formstone/core.js', array(
            'jquery',
            'underscore'
        ), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'formstone-transition', get_template_directory_uri() . '/js/formstone/transition.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

        wp_enqueue_script( 'formstone-background', get_template_directory_uri() . '/js/formstone/background.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    }
endif;

add_action( 'wp_enqueue_scripts', 'inspiro_video_scripts', 100 );

if ( ! function_exists( 'array_to_data_atts' ) ) :
    function array_to_data_atts( $in ) {
        $result = '';
        foreach ( $in as $key => $value ) {
            $result .= " " . $key . '="' . $value . '" ';
        }

        return $result;
    }
endif;
