<?php get_header(); ?>
<main id="main-content">
<?php while ( have_posts() ) : the_post(); $role = get_post_meta( get_the_ID(), '_ctp_member_role', true ); $skills = get_post_meta( get_the_ID(), '_ctp_member_skills', true ); ?>
  <article class="single-member">
    <div class="container">
      <div class="masthead-line"><a href="<?php echo esc_url( home_url( '/#team' ) ); ?>">← <?php esc_html_e( 'The team', 'capstone-team-portfolio' ); ?></a><span class="masthead-rule" aria-hidden="true"></span><span><?php esc_html_e( 'Profile', 'capstone-team-portfolio' ); ?></span></div>
      <div class="single-member-grid">
        <figure class="single-member-visual">
          <div class="member-portrait"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } else { ?><span class="member-placeholder"><?php echo esc_html( strtoupper( mb_substr( get_the_title(), 0, 1 ) ) ); ?></span><?php } ?></div>
          <figcaption><span><?php echo esc_html( ctp_brand_name() ); ?></span><span><?php echo esc_html( gmdate( 'Y' ) ); ?></span></figcaption>
        </figure>
        <div class="single-member-copy">
          <span class="section-kicker"><?php echo esc_html( $role ?: __( 'Team member', 'capstone-team-portfolio' ) ); ?></span>
          <h1><?php the_title(); ?></h1>
          <?php if ( has_excerpt() ) : ?><p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
          <div class="entry-content"><?php the_content(); ?></div>
          <?php if ( $skills ) : ?><div class="profile-skills"><h2><?php esc_html_e( 'Skills & specialization', 'capstone-team-portfolio' ); ?></h2><ul class="skill-tags"><?php foreach ( array_filter( array_map( 'trim', explode( ',', $skills ) ) ) as $skill ) : ?><li><?php echo esc_html( $skill ); ?></li><?php endforeach; ?></ul></div><?php endif; ?>
          <div class="profile-actions"><a class="button button-primary" href="<?php echo esc_url( add_query_arg( 'member', get_the_ID(), ctp_get_contact_page_url() ) . '#contact-form' ); ?>"><?php esc_html_e( 'Contact this member', 'capstone-team-portfolio' ); ?> <span aria-hidden="true">→</span></a><a class="button button-ghost" href="<?php echo esc_url( home_url( '/#team' ) ); ?>"><?php esc_html_e( 'Back to the team', 'capstone-team-portfolio' ); ?></a></div>
        </div>
      </div>
    </div>
  </article>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
