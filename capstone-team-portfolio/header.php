<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?>>
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
    <a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
      <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
        <span class="brand-mark">4</span>
        <span class="brand-text"><strong><?php echo esc_html( get_bloginfo( 'name' ) ?: 'THE TEAM' ); ?></strong><small>Capstone portfolio</small></span>
      <?php endif; ?>
    </a>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">Menu</button>
    <nav class="primary-nav" id="primary-menu" aria-label="<?php esc_attr_e( 'Primary navigation', 'capstone-team-portfolio' ); ?>">
      <?php
      if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => '', 'fallback_cb' => false ) );
      } else {
          echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li><li><a href="' . esc_url( home_url( '/#team' ) ) . '">Our Team</a></li><li><a href="' . esc_url( home_url( '/#about' ) ) . '">About</a></li><li><a href="' . esc_url( home_url( '/#project' ) ) . '">Project</a></li><li><a class="nav-cta" href="' . esc_url( home_url( '/contact/' ) ) . '">Contact</a></li></ul>';
      }
      ?>
    </nav>
  </div>
</header>
