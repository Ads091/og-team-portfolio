<?php get_header(); ?>
<main id="main-content"><section class="page-hero"><div class="container"><span class="eyebrow">CAPSTONE TEAM PORTFOLIO</span><h1><?php echo esc_html( is_home() ? 'Updates & News' : 'Explore our website' ); ?></h1></div></section><section class="page-content"><div class="container"><div class="entry-content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><article <?php post_class(); ?>><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p><a class="text-link" href="<?php the_permalink(); ?>">Read more →</a></article><hr><?php endwhile; the_posts_pagination(); else : ?><p>No content found.</p><?php endif; ?>
</div></div></section></main>
<?php get_footer(); ?>
