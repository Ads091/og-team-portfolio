<?php get_header(); ?>
<main id="main-content"><section class="page-hero"><div class="container"><span class="eyebrow">MEET THE TEAM</span><h1>Team Member Profile</h1></div></section>
<section class="page-content"><div class="container">
<?php while ( have_posts() ) : the_post(); $role = get_post_meta( get_the_ID(), '_ctp_member_role', true ); $skills = get_post_meta( get_the_ID(), '_ctp_member_skills', true ); ?>
<article class="single-member"><div class="member-photo"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } else { ?><div class="member-placeholder"><?php echo esc_html( strtoupper( mb_substr( get_the_title(), 0, 1 ) ) ); ?></div><?php } ?></div><div><span class="section-kicker"><?php echo esc_html( $role ?: 'Team Member' ); ?></span><h1><?php the_title(); ?></h1><?php if ( $skills ) : ?><p><strong>Skills:</strong> <?php echo esc_html( $skills ); ?></p><?php endif; ?><div class="entry-content"><?php the_content(); ?></div><a class="text-link" href="<?php echo esc_url( home_url( '/#team' ) ); ?>">← Back to our team</a></div></article>
<?php endwhile; ?></div></section></main>
<?php get_footer(); ?>
