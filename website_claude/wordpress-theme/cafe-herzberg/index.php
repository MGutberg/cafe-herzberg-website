<?php get_header(); ?>
<div class="container" style="padding-top:120px;padding-bottom:80px;">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
  <h1><?php the_title(); ?></h1>
  <div><?php the_content(); ?></div>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
