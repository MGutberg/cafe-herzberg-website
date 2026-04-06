<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#2B2B2B">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="visually-hidden focusable" style="position:absolute;top:-40px;left:0;background:var(--color-gold);color:#fff;padding:8px 16px;z-index:9999;border-radius:0 0 8px 0;transition:top .2s;font-weight:600;">Zum Inhalt springen</a>
<style>.visually-hidden.focusable:focus{top:0}</style>

<header class="site-header" role="banner">
  <div class="container">
    <nav class="nav-inner" aria-label="Hauptnavigation">

      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="Café Herzberg — Startseite">
        <?php if (has_custom_logo()):
            $logo_id = get_theme_mod('custom_logo');
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="Café Herzberg Logo" width="52" height="52">
        <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Café Herzberg Logo" width="52" height="52">
        <?php endif; ?>
        <div class="nav-logo-text">
          <span class="nav-logo-name">Café Herzberg</span>
          <span class="nav-logo-claim">breakfast &amp; more</span>
        </div>
      </a>

      <ul class="nav-links" role="list">
        <li><a href="<?php echo esc_url(home_url('/#ueber-uns')); ?>">Über uns</a></li>
        <li><a href="<?php echo esc_url(home_url('/#speisekarte')); ?>">Speisekarte</a></li>
        <li><a href="<?php echo esc_url(home_url('/#galerie')); ?>">Galerie</a></li>
        <li><a href="<?php echo esc_url(home_url('/#kontakt')); ?>">Kontakt</a></li>
      </ul>

      <div class="nav-cta">
        <a href="<?php echo esc_url(home_url('/#kontakt')); ?>" class="btn btn-primary">Reservieren</a>
      </div>

      <button class="nav-hamburger" aria-label="Menü öffnen" aria-expanded="false" aria-controls="mobile-menu">
        <span></span><span></span><span></span>
      </button>

    </nav>
  </div>
</header>

<nav class="nav-mobile" id="mobile-menu" aria-label="Mobilnavigation" aria-hidden="true">
  <button class="nav-mobile-close" aria-label="Menü schließen">✕</button>
  <a href="<?php echo esc_url(home_url('/#ueber-uns')); ?>">Über uns</a>
  <a href="<?php echo esc_url(home_url('/#speisekarte')); ?>">Speisekarte</a>
  <a href="<?php echo esc_url(home_url('/#galerie')); ?>">Galerie</a>
  <a href="<?php echo esc_url(home_url('/#kontakt')); ?>">Kontakt</a>
  <a href="<?php echo esc_url(home_url('/#kontakt')); ?>" class="btn btn-primary" style="margin-top:8px">Reservieren</a>
</nav>

<main id="main-content">
