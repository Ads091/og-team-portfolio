<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?> data-theme="dark">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'capstone-team-portfolio' ); ?></a>
<header class="site-header">
  <div class="container header-inner">
    <a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( ctp_brand_name() ); ?>">
      <?php if ( has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <span class="brand-mark"><img class="brand-logo" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/cg-monogram.png' ) ); ?>" alt="" width="44" height="44"></span>
      <?php endif; ?>
      <span class="brand-text"><strong><?php echo esc_html( ctp_brand_name() ); ?></strong></span>
    </a>
    <nav class="primary-nav" id="primary-menu" aria-label="<?php esc_attr_e( 'Primary navigation', 'capstone-team-portfolio' ); ?>">
      <?php
      if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => '', 'fallback_cb' => false ) );
      } else {
          echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'capstone-team-portfolio' ) . '</a></li><li><a href="' . esc_url( home_url( '/#team' ) ) . '">' . esc_html__( 'Our Team', 'capstone-team-portfolio' ) . '</a></li><li><a href="' . esc_url( home_url( '/#about' ) ) . '">' . esc_html__( 'About', 'capstone-team-portfolio' ) . '</a></li><li><a href="' . esc_url( home_url( '/projects/' ) ) . '">' . esc_html__( 'Projects', 'capstone-team-portfolio' ) . '</a></li><li><a class="nav-cta" href="' . esc_url( ctp_get_contact_page_url() ) . '">' . esc_html__( 'Contact', 'capstone-team-portfolio' ) . '</a></li></ul>';
      }
      ?>
    </nav>
    <div class="header-tools">
      <button class="theme-toggle" type="button" data-theme-toggle aria-label="<?php esc_attr_e( 'Switch to light mode', 'capstone-team-portfolio' ); ?>" title="<?php esc_attr_e( 'Toggle light and dark mode', 'capstone-team-portfolio' ); ?>"><span class="theme-toggle-icon" aria-hidden="true"></span><span class="theme-toggle-label"><?php esc_html_e( 'Light', 'capstone-team-portfolio' ); ?></span></button>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu"><span class="menu-toggle-lines" aria-hidden="true"></span><span class="screen-reader-text"><?php esc_html_e( 'Toggle navigation', 'capstone-team-portfolio' ); ?></span></button>
    </div>
  </div>
</header>
