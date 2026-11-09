<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$ctp_index = isset( $args['index'] ) ? (int) $args['index'] : 0;
$terms = get_the_terms( get_the_ID(), 'ctp_project_category' );
$slugs = ( $terms && ! is_wp_error( $terms ) ) ? wp_list_pluck( $terms, 'slug' ) : array();
$year = get_post_meta( get_the_ID(), '_ctp_project_year', true );
?>
<article class="project-card" data-categories="<?php echo esc_attr( implode( ' ', $slugs ) ); ?>">
  <a class="project-card-link" href="<?php the_permalink(); ?>">
    <div class="project-image">
      <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } else { ?><div class="project-image-placeholder" aria-hidden="true"><span><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span></div><?php } ?>
    </div>
    <div class="project-card-meta">
      <span><?php echo $ctp_index ? esc_html( sprintf( 'No. %02d', $ctp_index ) ) : esc_html( $year ?: get_the_date( 'Y' ) ); ?></span>
      <span><?php if ( $terms && ! is_wp_error( $terms ) ) { echo esc_html( $terms[0]->name ) . ' · '; } echo esc_html( $year ?: get_the_date( 'Y' ) ); ?></span>
    </div>
    <h3><?php the_title(); ?> <span class="project-arrow" aria-hidden="true">↗</span></h3>
    <p><?php echo esc_html( get_the_excerpt() ); ?></p>
  </a>
</article>
