<?php get_header(); $categories = get_terms( array( 'taxonomy' => 'ctp_project_category', 'hide_empty' => true ) ); ?>
<main id="main-content">
  <section class="page-hero"><div class="container"><span class="section-kicker"><b>—</b><?php esc_html_e( 'The work / Portfolio', 'capstone-team-portfolio' ); ?></span><h1><?php esc_html_e( 'Projects', 'capstone-team-portfolio' ); ?> <em><?php esc_html_e( '& ideas.', 'capstone-team-portfolio' ); ?></em></h1><p><?php esc_html_e( 'Explore the projects, research, and solutions developed by our team.', 'capstone-team-portfolio' ); ?></p></div></section>
  <section class="section projects-section archive-projects"><div class="container">
    <div class="project-toolbar"><div class="project-filters" role="group" aria-label="<?php esc_attr_e( 'Filter projects by category', 'capstone-team-portfolio' ); ?>"><button class="project-filter is-active" type="button" data-filter="all" aria-pressed="true"><?php esc_html_e( 'All', 'capstone-team-portfolio' ); ?></button><?php if ( ! is_wp_error( $categories ) && $categories ) : foreach ( $categories as $category ) : ?><button class="project-filter" type="button" data-filter="<?php echo esc_attr( $category->slug ); ?>" aria-pressed="false"><?php echo esc_html( $category->name ); ?></button><?php endforeach; endif; ?></div></div>
    <?php if ( have_posts() ) : ?>
      <div class="project-grid-cards"><?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/project-card' ); endwhile; ?></div>
      <?php the_posts_pagination(); ?>
    <?php else : ?>
      <div class="empty-state"><span class="section-kicker"><?php esc_html_e( 'Coming soon', 'capstone-team-portfolio' ); ?></span><h3><?php esc_html_e( 'No projects published yet.', 'capstone-team-portfolio' ); ?></h3><p><?php esc_html_e( 'Published projects will appear here.', 'capstone-team-portfolio' ); ?></p></div>
    <?php endif; ?>
  </div></section>
</main>
<?php get_footer(); ?>
