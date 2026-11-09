<?php
get_header();
$stats = ctp_get_portfolio_stats();
$team = ctp_member_query();
$all_skills = ctp_get_all_skills();
$project_categories = get_terms( array( 'taxonomy' => 'ctp_project_category', 'hide_empty' => true ) );
$projects = new WP_Query( array( 'post_type' => 'ctp_project', 'post_status' => 'publish', 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC' ) );
?>
<main id="main-content">
  <section class="hero" id="home">
    <div class="container">
      <div class="masthead-line">
        <span><?php echo esc_html( ctp_hero_eyebrow() ); ?></span>
        <span class="masthead-rule" aria-hidden="true"></span>
        <span><?php echo esc_html( sprintf( __( 'Edition %s', 'capstone-team-portfolio' ), gmdate( 'Y' ) ) ); ?></span>
      </div>
      <h1 class="hero-title"><?php echo ctp_hero_title_html(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?></h1>
      <div class="hero-lower">
        <div class="hero-intro">
          <p class="hero-copy"><?php echo esc_html( ctp_get_option( 'ctp_hero_description', 'Meet the people behind our capstone project. Explore our skills, individual contributions, and collaborative journey.' ) ); ?></p>
          <div class="hero-actions">
            <a class="button button-primary" href="#team"><?php esc_html_e( 'Meet the team', 'capstone-team-portfolio' ); ?><span aria-hidden="true">→</span></a>
            <a class="button button-ghost" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'See the work', 'capstone-team-portfolio' ); ?></a>
          </div>
        </div>
        <figure class="hero-plate">
          <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/cg-monogram.png' ) ); ?>" alt="<?php esc_attr_e( 'CG team monogram', 'capstone-team-portfolio' ); ?>" width="320" height="320">
          <figcaption><span>Fig. 01</span><span><?php esc_html_e( 'The team mark', 'capstone-team-portfolio' ); ?></span></figcaption>
        </figure>
      </div>
    </div>
  </section>

  <?php if ( $all_skills ) : ?>
  <section class="skill-ticker" aria-label="<?php esc_attr_e( 'Skills across the team', 'capstone-team-portfolio' ); ?>">
    <div class="skill-ticker-track">
      <?php for ( $pass = 0; $pass < 2; $pass++ ) : ?>
        <ul <?php echo $pass ? 'aria-hidden="true"' : ''; ?>>
          <?php foreach ( $all_skills as $skill ) : ?><li><?php echo esc_html( $skill ); ?></li><?php endforeach; ?>
        </ul>
      <?php endfor; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="stats-section" aria-label="<?php esc_attr_e( 'Portfolio statistics', 'capstone-team-portfolio' ); ?>">
    <div class="container stats-grid">
      <div class="stat-item"><span class="stat-label"><?php esc_html_e( 'Team members', 'capstone-team-portfolio' ); ?></span><strong class="stat-number" data-counter="<?php echo esc_attr( $stats['members'] ); ?>"><?php echo esc_html( number_format_i18n( $stats['members'] ) ); ?></strong></div>
      <div class="stat-item"><span class="stat-label"><?php esc_html_e( 'Published projects', 'capstone-team-portfolio' ); ?></span><strong class="stat-number" data-counter="<?php echo esc_attr( $stats['projects'] ); ?>"><?php echo esc_html( number_format_i18n( $stats['projects'] ) ); ?></strong></div>
      <div class="stat-item"><span class="stat-label"><?php esc_html_e( 'Skills represented', 'capstone-team-portfolio' ); ?></span><strong class="stat-number" data-counter="<?php echo esc_attr( $stats['skills'] ); ?>"><?php echo esc_html( number_format_i18n( $stats['skills'] ) ); ?></strong></div>
      <p class="stat-note"><?php esc_html_e( 'Different strengths, one collective vision.', 'capstone-team-portfolio' ); ?></p>
    </div>
  </section>

  <section class="section team-section" id="team">
    <div class="container">
      <header class="section-heading">
        <span class="section-kicker"><b>01</b><?php esc_html_e( 'The people', 'capstone-team-portfolio' ); ?></span>
        <h2><?php esc_html_e( 'Meet the minds behind the work.', 'capstone-team-portfolio' ); ?></h2>
        <p><?php esc_html_e( 'A team of curious thinkers and dedicated contributors, bringing different skills together to create something meaningful.', 'capstone-team-portfolio' ); ?></p>
      </header>
      <?php if ( $team->have_posts() ) : ?>
        <ol class="member-list">
        <?php while ( $team->have_posts() ) : $team->the_post(); $role = get_post_meta( get_the_ID(), '_ctp_member_role', true ); $skills = get_post_meta( get_the_ID(), '_ctp_member_skills', true ); ?>
          <li class="member-row">
            <a class="member-row-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View %s profile', 'capstone-team-portfolio' ), get_the_title() ) ); ?>">
              <span class="member-index"><?php echo esc_html( sprintf( '%02d', $team->current_post + 1 ) ); ?></span>
              <span class="member-photo"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); } else { ?><span class="member-placeholder"><?php echo esc_html( strtoupper( mb_substr( get_the_title(), 0, 1 ) ) ); ?></span><?php } ?></span>
              <span class="member-main">
                <span class="member-role"><?php echo esc_html( $role ?: __( 'Team member', 'capstone-team-portfolio' ) ); ?></span>
                <span class="member-name"><?php the_title(); ?></span>
                <span class="member-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></span>
              </span>
              <?php if ( $skills ) : ?><span class="member-skills"><?php foreach ( array_slice( array_filter( array_map( 'trim', explode( ',', $skills ) ) ), 0, 3 ) as $skill ) : ?><span><?php echo esc_html( $skill ); ?></span><?php endforeach; ?></span><?php else : ?><span class="member-skills"></span><?php endif; ?>
              <span class="member-arrow" aria-hidden="true">→</span>
            </a>
          </li>
        <?php endwhile; wp_reset_postdata(); ?>
        </ol>
      <?php else : ?>
        <div class="empty-state"><span class="section-kicker"><?php esc_html_e( 'Nothing here yet', 'capstone-team-portfolio' ); ?></span><h3><?php esc_html_e( 'Your team story starts here.', 'capstone-team-portfolio' ); ?></h3><p><?php esc_html_e( 'Add team members from Team Members in your WordPress dashboard to display them here.', 'capstone-team-portfolio' ); ?></p></div>
      <?php endif; ?>
    </div>
  </section>

  <section class="section about-section" id="about">
    <div class="container about-grid">
      <div class="about-aside">
        <span class="section-kicker"><b>02</b><?php esc_html_e( 'Who we are', 'capstone-team-portfolio' ); ?></span>
        <blockquote class="about-quote"><p><?php esc_html_e( 'The best work happens when different perspectives move toward one purpose.', 'capstone-team-portfolio' ); ?></p><cite><?php esc_html_e( 'Our shared mindset', 'capstone-team-portfolio' ); ?></cite></blockquote>
      </div>
      <div class="about-copy">
        <h2><?php esc_html_e( 'Different strengths. A shared ambition.', 'capstone-team-portfolio' ); ?></h2>
        <p class="lede"><?php esc_html_e( 'We are a collaborative capstone team focused on thoughtful research, practical problem-solving, and purposeful innovation. This space brings together our people, our process, and the work we are proud to share.', 'capstone-team-portfolio' ); ?></p>
        <dl class="value-list">
          <div class="value-item"><dt><span>i.</span><?php esc_html_e( 'Collaboration', 'capstone-team-portfolio' ); ?></dt><dd><?php esc_html_e( 'Better ideas through teamwork.', 'capstone-team-portfolio' ); ?></dd></div>
          <div class="value-item"><dt><span>ii.</span><?php esc_html_e( 'Research', 'capstone-team-portfolio' ); ?></dt><dd><?php esc_html_e( 'Decisions grounded in evidence.', 'capstone-team-portfolio' ); ?></dd></div>
          <div class="value-item"><dt><span>iii.</span><?php esc_html_e( 'Innovation', 'capstone-team-portfolio' ); ?></dt><dd><?php esc_html_e( 'Solutions with a clear purpose.', 'capstone-team-portfolio' ); ?></dd></div>
          <div class="value-item"><dt><span>iv.</span><?php esc_html_e( 'Quality', 'capstone-team-portfolio' ); ?></dt><dd><?php esc_html_e( 'Care in every detail.', 'capstone-team-portfolio' ); ?></dd></div>
        </dl>
      </div>
    </div>
  </section>

  <section class="section projects-section" id="projects">
    <div class="container">
      <header class="section-heading">
        <span class="section-kicker"><b>03</b><?php esc_html_e( 'Selected work', 'capstone-team-portfolio' ); ?></span>
        <h2><?php echo esc_html( ctp_get_option( 'ctp_project_title', 'Ideas made tangible.' ) ); ?></h2>
        <p><?php echo esc_html( ctp_get_option( 'ctp_project_description', 'Explore the research, process, and solutions created by our team.' ) ); ?></p>
      </header>
      <?php if ( $projects->have_posts() ) : ?>
        <div class="project-toolbar">
          <div class="project-filters" role="group" aria-label="<?php esc_attr_e( 'Filter projects by category', 'capstone-team-portfolio' ); ?>"><button class="project-filter is-active" type="button" data-filter="all" aria-pressed="true"><?php esc_html_e( 'All', 'capstone-team-portfolio' ); ?></button><?php if ( ! is_wp_error( $project_categories ) && $project_categories ) : foreach ( $project_categories as $category ) : ?><button class="project-filter" type="button" data-filter="<?php echo esc_attr( $category->slug ); ?>" aria-pressed="false"><?php echo esc_html( $category->name ); ?></button><?php endforeach; endif; ?></div>
          <a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'ctp_project' ) ); ?>"><?php esc_html_e( 'All projects', 'capstone-team-portfolio' ); ?> <span aria-hidden="true">→</span></a>
        </div>
        <div class="project-grid-cards">
          <?php while ( $projects->have_posts() ) : $projects->the_post(); get_template_part( 'template-parts/project-card', null, array( 'index' => $projects->current_post + 1 ) ); endwhile; wp_reset_postdata(); ?>
        </div>
      <?php else : ?>
        <div class="empty-state"><span class="section-kicker"><?php esc_html_e( 'Coming soon', 'capstone-team-portfolio' ); ?></span><h3><?php esc_html_e( 'The next idea starts here.', 'capstone-team-portfolio' ); ?></h3><p><?php esc_html_e( 'Your projects will appear here when you publish them under Projects in the WordPress dashboard.', 'capstone-team-portfolio' ); ?></p></div>
      <?php endif; ?>
    </div>
  </section>

  <section class="cta-section">
    <div class="container cta-inner">
      <span class="section-kicker"><b>04</b><?php esc_html_e( 'Start a conversation', 'capstone-team-portfolio' ); ?></span>
      <a class="cta-link" href="<?php echo esc_url( ctp_get_contact_page_url() ); ?>"><span><?php esc_html_e( 'Have an idea worth sharing?', 'capstone-team-portfolio' ); ?></span> <em><?php esc_html_e( 'Let’s talk', 'capstone-team-portfolio' ); ?> <span aria-hidden="true">→</span></em></a>
      <p><?php esc_html_e( 'Reach out to the whole team or connect directly with one of our members.', 'capstone-team-portfolio' ); ?></p>
    </div>
  </section>
</main>
<?php get_footer(); ?>
