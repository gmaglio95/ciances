<?php
/**
 * Sensei S2 Theme functions and definitions
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Sensei S2
 * @version 2.2.5
 */

/** Content width */
if ( ! isset( $content_width ) ) $content_width = 1170;

/** Setup Theme */
if(! function_exists('senseis2_setup_theme') ) {
  function senseis2_setup_theme() {

  /** Add support titles */
  add_theme_support("title-tag");

  /** Add theme feed links */
  add_theme_support( 'automatic-feed-links' );

  /** Enable featured image */
  add_theme_support("post-thumbnails");

  /** Add support HTML5 */
  add_theme_support('html5');

  /** Add editor style **/
  add_editor_style();

  /** Add background Image */
  $args = array(
  	'width'         => 1440,
  	'height'        => 960,
  	'default-image' => get_template_directory_uri() . '/img/example.jpg',
  );
  add_theme_support( 'custom-header', $args );

  /** Add custom background */
  $args = array(
  	'default-color' => 'ffffff',
  );
  add_theme_support( 'custom-background', $args );

  /** Create custom menus */
  register_nav_menus(array(
    'main-menu' => esc_html__('Header','sensei-s2'),
  ));

  /** Load theme languages */
  load_theme_textdomain( 'sensei-s2', get_template_directory().'/languages');
  }

  /** Register support for Gutenberg wide images in writy */
  add_theme_support('align-wide');
}
add_action('after_setup_theme', 'senseis2_setup_theme');

/** Register Sidebars */
if(! function_exists('senseis2_sidebars') ) {
  function senseis2_sidebars(){
    register_sidebar(array(
      'name' => esc_html__('Primary','sensei-s2'),
      'id' => 'primary',
      'description' => esc_html__('Main Sidebar','sensei-s2'),
      'before_title' => '<h3>' ,
      'after_title' => '</h3>',
      'before_widget' => '<div class="widget fade %2$s">',
      'after_widget' => '</div>',
      )
    );
	register_sidebar(array(
    	'name' => esc_html__('Footer 1','sensei-s2'),
    	'id' => 'footer-left',
    	'description' => esc_html__('Footer credits','sensei-s2'),
      'before_title' => '<h3>' ,
      'after_title' => '</h3>',
      'before_widget' => '<div class="widget %2$s">',
      'after_widget' => '</div>',
    	)
    );
  register_sidebar(array(
      'name' => esc_html__('Footer 2','sensei-s2'),
      'id' => 'footer-right',
      'description' => esc_html__('Footer credits','sensei-s2'),
      'before_title' => '<h3>' ,
      'after_title' => '</h3>',
      'before_widget' => '<div class="widget %2$s">',
      'after_widget' => '</div>',
      )
    );
  }
}
add_action('widgets_init','senseis2_sidebars');

if(! function_exists('senseis2_scripts') ) {
  function senseis2_scripts(){
    /** Include css files */
    wp_enqueue_style('senseis2-font', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700');
    wp_enqueue_style('senseis2-font-awesome-css', get_template_directory_uri() .'/css/font-awesome.css', false, '4.7.0');
    wp_enqueue_style('senseis2-animate-css', get_template_directory_uri() .'/css/animate.css', false);
    wp_enqueue_style('senseis2-style-default-css', get_stylesheet_uri(), false, '1.0');

    /** Include javascript files */
    wp_register_script('senseis2-viewportchecker-js', get_template_directory_uri() .'/js/viewportchecker.js', array('jquery'), null, true );
    wp_enqueue_script('senseis2-viewportchecker-js');
    wp_enqueue_script('senseis2-custom-js', get_template_directory_uri() .'/js/custom.js', array('jquery', 'senseis2-viewportchecker-js'), null, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
   		wp_enqueue_script( 'comment-reply' );
   	}
  }
}
add_action('wp_enqueue_scripts', 'senseis2_scripts');

/** Excerpt lenght */
function senseis2_wpdocs_custom_excerpt_length($length) {
  return 20;
}
add_filter('excerpt_length', 'senseis2_wpdocs_custom_excerpt_length', 999);

function senseis2_wpdocs_excerpt_more($more) {
  return '...';
}
add_filter('excerpt_more', 'senseis2_wpdocs_excerpt_more');

/** Form */
function senseis2_my_search_form( $form ) {
  $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url( '/' )) . '" >
  <input type="search" value="' . get_search_query() . '" name="s" placeholder="' .esc_attr__( 'Search...', 'sensei-s2' ). '">
	<button type="submit"><i class="fa fa-search"></i></button>
  </form>';
  return $form;
}
add_filter( 'get_search_form', 'senseis2_my_search_form' );

/** Customizer settings */
require get_template_directory() . '/inc/customizer.php';
