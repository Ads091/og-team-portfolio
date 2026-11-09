<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<footer class="site-footer">
  <div class="container">
    <div class="footer-top">
      <p class="footer-tagline"><?php esc_html_e( 'A team built around one shared vision.', 'capstone-team-portfolio' ); ?></p>
      <nav class="footer-links" aria-label="<?php esc_attr_e( 'Footer navigation', 'capstone-team-portfolio' ); ?>">
        <a href="<?php echo esc_url( home_url( '/#team' ) ); ?>"><?php esc_html_e( 'Our Team', 'capstone-team-portfolio' ); ?></a>
        <a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'capstone-team-portfolio' ); ?></a>
        <a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'Projects', 'capstone-team-portfolio' ); ?></a>
        <a href="<?php echo esc_url( ctp_get_contact_page_url() ); ?>"><?php esc_html_e( 'Contact', 'capstone-team-portfolio' ); ?></a>
      </nav>
    </div>
    <p class="footer-wordmark" aria-hidden="true"><?php echo esc_html( ctp_brand_name() ); ?></p>
    <div class="footer-bottom"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( ctp_brand_name() ); ?>. <?php esc_html_e( 'All rights reserved.', 'capstone-team-portfolio' ); ?></span><span><?php esc_html_e( 'Designed with purpose. Built together.', 'capstone-team-portfolio' ); ?></span></div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
