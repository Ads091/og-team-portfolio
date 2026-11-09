<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<footer class="site-footer">
  <div class="container footer-inner">
    <div><strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong><br><?php esc_html_e( 'A capstone team portfolio', 'capstone-team-portfolio' ); ?></div>
    <div>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'capstone-team-portfolio' ); ?></div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
