<?php get_header(); ?>
<main id="main-content">
  <section class="page-hero"><div class="container"><span class="section-kicker"><b>—</b><?php esc_html_e( 'Let’s connect', 'capstone-team-portfolio' ); ?></span><h1><?php esc_html_e( 'Start a', 'capstone-team-portfolio' ); ?> <em><?php esc_html_e( 'conversation.', 'capstone-team-portfolio' ); ?></em></h1><p><?php esc_html_e( 'Choose whether to contact the entire team or reach out to an individual member.', 'capstone-team-portfolio' ); ?></p></div></section>
  <section class="page-content contact-page-content"><div class="container contact-layout">
    <aside class="contact-intro">
      <h2><?php esc_html_e( 'We’d love to hear from you.', 'capstone-team-portfolio' ); ?></h2>
      <p><?php esc_html_e( 'Tell us a little about what you have in mind. Your message will be delivered to the team inbox or routed privately to the member you select.', 'capstone-team-portfolio' ); ?></p>
      <dl class="contact-assurances">
        <div><dt><?php esc_html_e( 'Private by design', 'capstone-team-portfolio' ); ?></dt><dd><?php esc_html_e( 'Member email addresses are never shown to visitors.', 'capstone-team-portfolio' ); ?></dd></div>
        <div><dt><?php esc_html_e( 'Direct to the right person', 'capstone-team-portfolio' ); ?></dt><dd><?php esc_html_e( 'If a member has no contact email saved, your message goes to the team inbox.', 'capstone-team-portfolio' ); ?></dd></div>
      </dl>
    </aside>
    <div class="contact-form-panel">
      <span class="section-kicker"><?php esc_html_e( 'Your message', 'capstone-team-portfolio' ); ?></span>
      <?php while ( have_posts() ) : the_post(); $contact_content = trim( get_the_content() ); $contact_plain = trim( wp_strip_all_tags( $contact_content ) ); if ( $contact_plain && 'Add your team’s official contact information here.' !== $contact_plain ) : ?><div class="contact-page-content-text entry-content"><?php the_content(); ?></div><?php endif; endwhile; echo ctp_render_contact_form(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in renderer. ?>
    </div>
  </div></section>
</main>
<?php get_footer(); ?>
