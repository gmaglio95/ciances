<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Sensei S2
 * @version 2.2.5
 */

/** Customizer settings */

/** Add custom logo */
function senseis2_custom_logo_setup() {
  $defaults = array(
  );
  add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'senseis2_custom_logo_setup' );

/** Remove background image customize */
function senseis2_theme_customize_register( $wp_customize ) {
	$wp_customize->remove_section("background_image");
  $wp_customize->remove_section("colors");

}
add_action( "customize_register", "senseis2_theme_customize_register" );
