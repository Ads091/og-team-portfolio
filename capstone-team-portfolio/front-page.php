<?php get_header(); ?>
<main id="main-content">
  <section class="hero">
    <div class="container hero-grid">
      <div>
        <span class="eyebrow"><?php echo esc_html( ctp_get_option( 'ctp_eyebrow', 'CAPSTONE TEAM PORTFOLIO' ) ); ?></span>
        <h1><?php echo wp_kses_post( str_replace( 'One Innovation.', '<span>One Innovation.</span>', esc_html( ctp_get_option( 'ctp_hero_title', 'Four Minds. One Vision. One Innovation.' ) ) ) ); ?></h1>
        <p class="hero-copy"><?php echo esc_html( ctp_get_option( 'ctp_hero_description', 'Meet the people behind our capstone project. Explore our skills, individual contributions, and collaborative journey.' ) ); ?></p>
        <div class="hero-actions"><a class="button button-primary" href="#team">Meet the Team <span aria-hidden="true">→</span></a><a class="button button-outline" href="#project">Explore Our Project</a></div>
        <div class="hero-note"><strong>04 MEMBERS</strong><span>·</span><span>One collaborative capstone journey</span></div>
      </div>
      <div class="hero-art" aria-hidden="true"><div class="orbit"></div><div class="team-emblem"><strong>04</strong><small>ONE TEAM</small></div><span class="float-tag one">Research</span><span class="float-tag two">Innovation</span><span class="float-tag three">Collaboration</span></div>
    </div>
  </section>

  <section class="section section-white" id="team">
    <div class="container">
      <div class="section-heading"><div><span class="section-kicker">The people behind the project</span><h2>Meet our team.</h2></div><p>Four members bringing together different strengths, ideas, and responsibilities to turn one shared vision into reality.</p></div>
      <div class="member-grid">
        <?php $team = ctp_member_query(); if ( $team->have_posts() ) : while ( $team->have_posts() ) : $team->the_post(); $role = get_post_meta( get_the_ID(), '_ctp_member_role', true ); ?>
          <article class="member-card">
            <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View %s profile', 'capstone-team-portfolio' ), get_the_title() ) ); ?>">
              <div class="member-photo"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } else { ?><div class="member-placeholder"><?php echo esc_html( strtoupper( mb_substr( get_the_title(), 0, 1 ) ) ); ?></div><?php } ?></div>
              <div class="member-info"><h3><?php the_title(); ?></h3><span class="member-role"><?php echo esc_html( $role ?: 'Team Member' ); ?></span><p><?php echo esc_html( get_the_excerpt() ); ?></p><span class="text-link">View profile <span aria-hidden="true">→</span></span></div>
            </a>
          </article>
        <?php endwhile; wp_reset_postdata(); else : ?><div class="empty-team">Add your four members from <strong>Team Members → Add New</strong> in the WordPress dashboard.</div><?php endif; ?>
      </div>
    </div>
  </section>

  <section class="section" id="about">
    <div class="container about-grid">
      <div class="about-panel"><span class="eyebrow">Stronger together</span><div class="big-number">4<span style="font-size:.45em">×</span></div><p>Different perspectives. Complementary skills. A shared commitment to meaningful work.</p></div>
      <div class="about-copy"><span class="section-kicker">Who we are</span><h2>A team built around a shared purpose.</h2><p>We are a group of four capstone researchers and developers working together to identify a real-world need and develop a thoughtful, practical solution. This portfolio documents who we are, what we are building, and how each member contributes.</p><div class="value-list"><div class="value-item"><strong>Collaboration</strong><span>Working as one team</span></div><div class="value-item"><strong>Research</strong><span>Evidence-led decisions</span></div><div class="value-item"><strong>Innovation</strong><span>Purposeful problem-solving</span></div><div class="value-item"><strong>Quality</strong><span>Testing and improvement</span></div></div></div>
    </div>
  </section>

  <section class="section project-section" id="project">
    <div class="container project-grid">
      <div><span class="section-kicker">Our featured work</span><h2><?php echo esc_html( ctp_get_option( 'ctp_project_title', 'Our Capstone Project' ) ); ?></h2><p><?php echo esc_html( ctp_get_option( 'ctp_project_description', 'This is where you can introduce your capstone project, explain the problem it addresses, and describe the solution your team developed.' ) ); ?></p><div class="project-points"><div class="project-point"><b>01</b><span>Problem and objectives</span></div><div class="project-point"><b>02</b><span>Research and methodology</span></div><div class="project-point"><b>03</b><span>System or project features</span></div><div class="project-point"><b>04</b><span>Results and outcomes</span></div></div><div class="hero-actions"><a class="button button-primary" href="<?php echo esc_url( home_url( '/our-capstone-project/' ) ); ?>">View Project Details →</a></div></div>
      <div class="project-visual" aria-hidden="true"><div class="project-window"><div class="window-dots"><i></i><i></i><i></i></div><div class="project-screen"><div><strong>YOUR PROJECT</strong><span>Capstone showcase</span></div></div></div></div>
    </div>
  </section>

  <section class="cta-section"><div class="container"><div class="cta-card"><div><h2>Want to know more about our work?</h2><p>Explore our project details or get in touch with our team.</p></div><a class="button" style="background:#10233d;color:#fff" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact the Team →</a></div></div></section>
</main>
<?php get_footer(); ?>
