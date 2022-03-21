<?php return array(


/* Theme Admin Menu */
"menu" => array(
    array("id"    => "1",
          "name"  => "General"),

    array("id"    => "2",
          "name"  => "Homepage"),
),

/* Theme Admin Options */
"id1" => array(
    array(
        "type" => "preheader",
        "name" => __( 'Theme Settings', 'wpzoom' )
    ),

    array(
        "name" => __( "Custom Feed URL", 'wpzoom' ),
        "desc" => __("Example: <strong>http://feeds.feedburner.com/wpzoom</strong>", 'wpzoom' ),
        "id"   => "misc_feedburner",
        "std"  => "",
        "type" => "text"
    ),

    array(
        "name" => __( "Display WooCommerce Cart Button in the Header?", 'wpzoom' ),
        "id"   => "cart_icon",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "type" => "preheader",
        "name" => "Layouts",
    ),

    array(
        "name"    => __( "Shop Page (WooCommerce)", 'wpzoom' ),
        "desc"    => __( "Select the layout for Shop page", 'wpzoom' ),
        "id"      => "layout_shop",
        "options" => array(
            'side-left'  => 'Sidebar on the left',
            'full'       => 'Full Width',
            'side-right' => 'Sidebar on the right',
        ),
        "std"     => "side-right",
        "type"    => "select-layout",
    ),

    array(
        "name"    => __( "Single Product Page (WooCommerce)", 'wpzoom' ),
        "desc"    => __( "Select the layout for products page in shop", 'wpzoom' ),
        "id"      => "layout_product",
        "options" => array(
            'side-left'  => 'Sidebar on the left',
            'full'       => 'Full Width',
            'side-right' => 'Sidebar on the right',
        ),
        "std"     => "side-right",
        "type"    => "select-layout",
    ),

    array(
        "type" => "preheader",
        "name" => __( "Blog Posts Options", 'wpzoom' )
    ),

    array(
        "name"    => __( "Posts Layout", 'wpzoom' ),
        "desc"    => __( "Select if you want to show the posts on the Blog page in a traditional blog layout or in 3 columns", 'wpzoom' ),
        "id"      => "post_view_blog",
        "options" => array(
            'big-image' => 'Blog',
            '3-columns' => '3 Columns'
        ),
        "std"     => "big-image",
        "type"    => "select-layout"
    ),


    array(
        "name"    => __( "Content", 'wpzoom' ),
        "desc"    => __("Number of posts displayed on homepage can be changed <a href=\"options-reading.php\" target=\"_blank\">here</a>.", 'wpzoom' ),
        "id"      => "display_content",
        "options" => array(
            'Excerpt',
            'Full Content',
            'None'
        ),
        "std"     => "Excerpt",
        "type"    => "select"
    ),

    array(
        "name" => __( "Excerpt length", 'wpzoom' ),
        "desc" => __( "Default: <strong>50</strong> (words)", 'wpzoom' ),
        "id"   => "excerpt_length",
        "std"  => "50",
        "type" => "text"
    ),

    array(
        "type" => "startsub",
        "name" => "Featured Image"
    ),

    array(
        "name" => __( "Display Featured Image at the Top", 'wpzoom' ),
        "desc" => __( "The width/height options below don't work when showing posts in <strong>3 columns</strong>.", 'wpzoom' ),
        "id"   => "index_thumb",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Featured Image Width (in pixels)", 'wpzoom' ),
        "desc" => "Default: <strong>950</strong> (pixels).<br/><br/>You'll have to run the <a href=\"http://wordpress.org/extend/plugins/regenerate-thumbnails/\" target=\"_blank\">Regenerate Thumbnails</a> plugin each time you modify width or height (<a href=\"http://www.wpzoom.com/tutorial/fixing-stretched-images/\" target=\"_blank\">view how</a>).",
        "id"   => "thumb_width",
        "std"  => "950",
        "type" => "text"
    ),

    array(
        "name" => __( "Featured Image Height (in pixels)", 'wpzoom' ),
        "desc" => __( "Default: <strong>320</strong> (pixels)", 'wpzoom' ),
        "id"   => "thumb_height",
        "std"  => "320",
        "type" => "text"
    ),

    array(
        "type" => "endsub"
    ),


    array(
        "name" => __( "Display Category", 'wpzoom' ),
        "id"   => "display_category",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Display Author", 'wpzoom' ),
        "id"   => "display_author",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Display Date/Time", 'wpzoom' ),
        "desc" => __( "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.", 'wpzoom' ),
        "id"   => "display_date",
        "std"  => "on",
        "type" => "checkbox"
    ),


    array(
        "name" => __( "Display Comments Count", 'wpzoom' ),
        "id"   => "display_comments",
        "std"  => "on",
        "type" => "checkbox"
    ),


    array(
        "type" => "preheader",
        "name" => __( "Single Posts Options", 'wpzoom' ),
    ),

    array(
        "name" => __( "Enable Dark Overlay in the Header?", 'wpzoom' ),
        "id"   => "post_overlay",
        "std"  => "on",
        "type" => "checkbox"
    ),


    array(
        "name" => __( "Display Category", 'wpzoom' ),
        "id"   => "post_category",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Display Date/Time", 'wpzoom' ),
        "desc" => __( "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.", 'wpzoom' ),
        "id"   => "post_date",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Display Tags", 'wpzoom' ),
        "id"   => "post_tags",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Display Author", 'wpzoom' ),
        "desc" => __( "You can edit your profile on this <a href='profile.php' target='_blank'>page</a>.", 'wpzoom' ),
        "id"   => "post_author",
        "std"  => "on",
        "type" => "checkbox"
    ),


    array(
        "type" => "startsub",
        "name" => __( "Share Buttons", 'wpzoom' ),
    ),

    array(
        "name" => __( "Display Share Buttons", 'wpzoom' ),
        "id"   => "post_share",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Twitter Button Label", 'wpzoom' ),
        "desc" => __( "Default: <strong>Share on Twitter</strong>", 'wpzoom' ),
        "id"   => "post_share_label_twitter",
        "std"  => "Share on Twitter",
        "type" => "text"
    ),

    array(
        "name" => __( "Facebook Button Label", 'wpzoom' ),
        "desc" => __( "Default: <strong>Share on Facebook</strong>", 'wpzoom' ),
        "id"   => "post_share_label_facebook",
        "std"  => "Share on Facebook",
        "type" => "text"
    ),

    array(
        "name" => __( "Google+ Button Label", 'wpzoom' ),
        "desc" => __( "Default: <strong>Share on Google+</strong>", 'wpzoom' ),
        "id"   => "post_share_label_gplus",
        "std"  => "Share on Google+",
        "type" => "text"
    ),

    array( "type" => "endsub" ),


    array(
        "name" => __( "Display Comments", 'wpzoom' ),
        "id"   => "post_comments",
        "std"  => "on",
        "type" => "checkbox"
    ),


    array(
        "name" => __( "Display Previous Post Banner", 'wpzoom' ),
        "id"   => "post_nextprev",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "type" => "preheader",
        "name" => __( "Single Pages Options", 'wpzoom' ),
    ),
    array(
        "name" => __( "Enable Dark Overlay in the Header?", 'wpzoom' ),
        "id"   => "page_overlay",
        "std"  => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => __( "Enable comments for static pages", 'wpzoom' ),
        "id"   => "comments_page",
        "std"  => "off",
        "type" => "checkbox"
    ),

),


"id2" => array(

    array("type"  => "preheader",
          "name"  => "Homepage Slideshow"),

    array("name"  => "THIS SECTION HAS BEEN MOVED IN THE CUSTOMIZER",
          "desc"  => "Go to <a href=\"customize.php\">Theme Customizer</a> &rarr; <strong>Homepage Slider</strong>",
          "id"    => "theme_style",
          "std"   => "Default",
          "type"  => "paragraph"),
),

"portfolio" => array(
   array(
       "type" => "preheader",
       "name" => "Portfolio Page"
   ),

   array(
       "name" => "Portfolio Page",
       "desc" => "Choose the page to which should link <em>All</em> button.",
       "id" => "portfolio_url",
       "std" => "",
       "type" => "select-page"
   ),

   array("name"  => "Number of Columns",
         "desc"  => "Select the number of columns with portfolio posts.",
         "id"    => "portfolio_grid_col",
         "options" => array('2', '3', '4'),
         "std"   => "3",
         "type"  => "select"
    ),

   array(
       "name" => "Posts per Page in Paginated templates",
       "desc" => "Default: <strong>9</strong>",
       "id" => "portfolio_posts",
       "std" => "9",
       "type" => "text"
   ),

   array(
       "name" => "Add Margins between Posts",
       "id" => "portfolio_whitespace",
       "std" => "off",
       "type" => "checkbox"
   ),

   array("type" => "startsub",
          "name" => "Lightbox Options"),

        array(
            "name" => "Enable Lightbox",
            "desc" => "By enabling this option, each portfolio post will display a lightbox icon in Portfolio page that will display a video or a large image.",
            "id" => "lightbox_enable",
            "std" => "on",
            "type" => "checkbox"
        ),

        array(
            "name" => "Use Lightbox only for Videos",
            "desc" => "Enabling this option will disable the lightbox feature on posts without videos",
            "id"   => "lightbox_video_only",
            "std"  => "off",
            "type" => "checkbox"
        ),

        array(
            "name" => "Show Lightbox Caption",
            "desc" => "By enabling this option, a clickable caption with the title of the post will appear in the lightbox.",
            "id"   => "lightbox_title_caption",
            "std"  => "off",
            "type" => "checkbox"
        ),

   array("type"  => "endsub"),

    array("type" => "startsub",
          "name" => "Background Video"),
    array(
        "name" => "Enable Background Video",
        "desc" => "By enabling this option, each portfolio post that have video will display a background video in Portfolio page that will be played on hover.",
        "id" => "enable_portfolio_background_video",
        "std" => "on",
        "type" => "checkbox"
    ),
    array("type"  => "endsub"),

   array(
       "name" => "Display Portfolio Posts Excerpt",
       "desc" => "Not visible when Lightbox is enabled",
       "id" => "portfolio_excerpt",
       "std" => "on",
       "type" => "checkbox"
   ),


   array(
       "name" => "Display Read More button",
       "id" => "portfolio_btn",
       "desc" => "Not visible when Lightbox is enabled",
       "std" => "on",
       "type" => "checkbox"
   ),




   array(
       "type" => "preheader",
       "name" => "Single Portfolio Posts"
   ),


   array(
       "desc" => sprintf('Here you can change the options for individual Portfolio post pages. '),
       "type" => "paragraph",
       "id" => "portfolio_sect_desc",
   ),

   array("name"  => "Enable Dark Overlay in the Header?",
         "id"    => "portfolio_post_overlay",
         "std"   => "on",
         "type"  => "checkbox"),

   array("name"  => "Fullscreen Header",
         "id"    => "portfolio_post_fullheader",
         "desc"  => "Unchecking this option will set a fixed height to the header image at the top.",
         "std"   => "on",
         "type"  => "checkbox"),

   array("name"  => "Enable Video Lightbox",
         "id"    => "portfolio_post_lightbox",
         "std"   => "on",
         "type"  => "checkbox"),

   array(
       "name" => "Display Category",
       "id" => "portfolio_category",
       "std" => "on",
       "type" => "checkbox"
   ),

   array(
       "name" => "Display Date/Time",
       "desc" => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
       "id" => "portfolio_date",
       "std" => "on",
       "type" => "checkbox"
   ),

   array(
       "name" => "Display Author",
       "desc" => "You can edit your profile on this <a href='profile.php' target='_blank'>page</a>.",
       "id" => "portfolio_author",
       "std" => "on",
       "type" => "checkbox"
   ),


   array("type" => "startsub",
          "name" => "Share Buttons"),

     array("name"  => "Display Share Buttons",
           "id"    => "portfolio_share",
           "std"   => "on",
           "type"  => "checkbox"),

     array("name"  => "Twitter Button Label",
           "desc"  => "Default: <strong>Share on Twitter</strong>",
           "id"    => "portfolio_share_label_twitter",
           "std"   => "Share on Twitter",
           "type"  => "text"),

     array("name"  => "Facebook Button Label",
           "desc"  => "Default: <strong>Share on Facebook</strong>",
           "id"    => "portfolio_share_label_facebook",
           "std"   => "Share on Facebook",
           "type"  => "text"),

     array("name"  => "Google+ Button Label",
           "desc"  => "Default: <strong>Share on Google+</strong>",
           "id"    => "portfolio_share_label_gplus",
           "std"   => "Share on Google+",
           "type"  => "text"),

   array("type"  => "endsub"),



   array(
       "name" => "Display Comments",
       "id" => "portfolio_comments",
       "std" => "on",
       "type" => "checkbox"
   ),

   array(
       "name" => "Display Previous Post Banner",
       "id" => "portfolio_nextprev",
       "std" => "on",
       "type" => "checkbox"
   ),
)

/* end return */);