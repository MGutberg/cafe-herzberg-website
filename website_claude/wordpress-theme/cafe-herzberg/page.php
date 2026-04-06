<?php get_header(); ?>
<div class="container" style="padding-top:120px;padding-bottom:80px;">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
  <article class="legal-page">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
  </article>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
