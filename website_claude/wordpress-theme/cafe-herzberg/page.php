<?php
/**
 * Generisches Seiten-Template — Elementor Pro übernimmt wenn Template gesetzt
 */
if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('single')) {
    return;
}
get_header(); ?>

<div class="container legal-page">
  <?php while (have_posts()): the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <div class="entry-content"><?php the_content(); ?></div>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
