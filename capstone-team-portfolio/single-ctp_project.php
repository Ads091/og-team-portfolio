<?php get_header(); ?>
<main id="main-content">
<?php while ( have_posts() ) : the_post(); $year = get_post_meta( get_the_ID(), '_ctp_project_year', true ); $external_url = get_post_meta( get_the_ID(), '_ctp_project_url', true ); $terms = get_the_terms( get_the_ID(), 'ctp_project_category' ); ?>
  <article class="single-project">
    <div class="container">
      <div class="masthead-line"><a href="<?php echo esc_url( get_post_type_archive_link( 'ctp_project' ) ); ?>">← <?php esc_html_e( 'All projects', 'capstone-team-portfolio' ); ?></a><span class="masthead-rule" aria-hidden="true"></span><span><?php esc_html_e( 'Case study', 'capstone-team-portfolio' ); ?></span></div>
      <header class="single-project-heading">
        <h1><?php the_title(); ?></h1>
        <dl class="project-facts">
          <div><dt><?php esc_html_e( 'Year', 'capstone-team-portfolio' ); ?></dt><dd><?php echo esc_html( $year ?: get_the_date( 'Y' ) ); ?></dd></div>
          <?php if ( $terms && ! is_wp_error( $terms ) ) : ?><div><dt><?php esc_html_e( 'Category', 'capstone-team-portfolio' ); ?></dt><dd><?php echo esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) ); ?></dd></div><?php endif; ?>
          <?php if ( $external_url ) : ?><div><dt><?php esc_html_e( 'Link', 'capstone-team-portfolio' ); ?></dt><dd><a href="<?php echo esc_url( $external_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit project', 'capstone-team-portfolio' ); ?> ↗</a></dd></div><?php endif; ?>
        </dl>
        <?php if ( has_excerpt() ) : ?><p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
      </header>
      <?php if ( has_post_thumbnail() ) : ?><div class="single-project-image"><?php the_post_thumbnail( 'full' ); ?></div><?php endif; ?>
      <div class="entry-content"><?php the_content(); ?></div>
      <div class="single-project-footer"><?php if ( $external_url ) : ?><a class="button button-primary" href="<?php echo esc_url( $external_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit project', 'capstone-team-portfolio' ); ?> <span aria-hidden="true">↗</span></a><?php endif; ?><a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'ctp_project' ) ); ?>">← <?php esc_html_e( 'Back to all projects', 'capstone-team-portfolio' ); ?></a></div>
    </div>
  </article>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
