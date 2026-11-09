<?php get_header(); ?>
<main id="main-content">
  <section class="page-hero"><div class="container"><span class="section-kicker"><b>—</b><?php echo esc_html( ctp_brand_name() ); ?></span><h1><?php the_title(); ?></h1></div></section>
  <section class="page-content"><div class="container"><div class="entry-content"><?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?></div></div></section>
</main>
<?php get_footer(); ?>
