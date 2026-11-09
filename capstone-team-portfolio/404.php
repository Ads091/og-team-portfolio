<?php get_header(); ?>
<main id="main-content"><section class="page-hero"><div class="container"><span class="eyebrow">404 ERROR</span><h1>Page not found.</h1><p><?php esc_html_e( 'The page you are looking for may have moved or may no longer exist.', 'capstone-team-portfolio' ); ?></p><a class="button button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Return home</a></div></section></main>
<?php get_footer(); ?>
