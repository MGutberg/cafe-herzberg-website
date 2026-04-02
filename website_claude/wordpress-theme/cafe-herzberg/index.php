<?php get_header(); ?>

<div class="container" style="padding-top:120px;padding-bottom:60px">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1><?php the_title(); ?></h1>
      <div><?php the_content(); ?></div>
    </article>
  <?php endwhile; else: ?>
    <p><?php esc_html_e('Kein Inhalt gefunden.', 'cafe-herzberg'); ?></p>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
