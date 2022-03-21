<?php
/**
 * The header for our theme
 *
 * @package Sensei S2
 * @version 2.2.5
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset');?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="header">
  <div class="header">
    <div class="content" <?php if ( is_user_logged_in() ) : echo 'style="padding-top: 32px;"'; endif; ?>>
      <nav>
        <?php $custom_logo_id = get_theme_mod( 'custom_logo' ); ?>
        <?php $logo = wp_get_attachment_image_src( $custom_logo_id , 'large' ); ?>
        <?php if ( has_custom_logo() ) : ?>
        <a href="<?php echo esc_url(home_url()); ?>" title="<?php bloginfo('name'); ?>" class="brand">
          <img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php bloginfo('name'); ?>">
        </a>
        <?php else : ?>
        <span class="brand"></span>
        <?php endif; ?>
        <?php if ( has_nav_menu( 'main-menu' ) ) : ?>
          <div class="menu">
            <div class="navbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </div>

            <?php wp_nav_menu(array(
              'menu' => 'main-menu',
              'theme_location' => 'main-menu',
              'menu_class' => 'nav',
              'container' => false,
              'menu_id' => false,
              'depth' => 2,
            ));
            ?>
          </div> <!-- menu -->
        <?php endif ?>
      </nav>
    </div> <!-- content -->
  </div> <!-- header -->
</header>
