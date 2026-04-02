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

<a href="#main-content" class="skip-link"><?php esc_html_e('Zum Inhalt springen', 'cafe-herzberg'); ?></a>

<header class="site-header" id="site-header" role="banner">
  <div class="container">
    <nav class="nav-inner" aria-label="<?php esc_attr_e('Hauptnavigation', 'cafe-herzberg'); ?>">

      <!-- Logo -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="<?php esc_attr_e('Café Herzberg — Startseite', 'cafe-herzberg'); ?>">
        <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            echo '<div class="nav-logo-placeholder">CH</div>';
        }
        ?>
        <div class="nav-logo-text">
          <span class="nav-logo-name"><?php bloginfo('name'); ?></span>
          <span class="nav-logo-claim">breakfast &amp; more</span>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => 'ul',
          'menu_class'     => 'nav-links',
          'fallback_cb'    => 'herzberg_fallback_nav',
          'depth'          => 1,
          'items_wrap'     => '<ul role="list" class="nav-links">%3$s</ul>',
      ]);
      ?>

      <!-- CTA Button -->
      <div class="nav-cta">
        <a href="#kontakt" class="btn btn-primary"><?php esc_html_e('Reservieren', 'cafe-herzberg'); ?></a>
      </div>

      <!-- Hamburger -->
      <button class="nav-hamburger" aria-label="<?php esc_attr_e('Menü öffnen', 'cafe-herzberg'); ?>" aria-expanded="false" aria-controls="mobile-menu">
        <span></span><span></span><span></span>
      </button>

    </nav>
  </div>
</header>

<!-- Mobile Menu -->
<nav class="nav-mobile" id="mobile-menu" aria-label="<?php esc_attr_e('Mobilnavigation', 'cafe-herzberg'); ?>" aria-hidden="true">
  <button class="nav-mobile-close" aria-label="<?php esc_attr_e('Menü schließen', 'cafe-herzberg'); ?>">✕</button>
  <a href="#ueber-uns"><?php esc_html_e('Über uns', 'cafe-herzberg'); ?></a>
  <a href="#speisekarte"><?php esc_html_e('Speisekarte', 'cafe-herzberg'); ?></a>
  <a href="#galerie"><?php esc_html_e('Galerie', 'cafe-herzberg'); ?></a>
  <a href="#kontakt"><?php esc_html_e('Kontakt', 'cafe-herzberg'); ?></a>
  <a href="#kontakt" class="btn btn-primary" style="margin-top:8px"><?php esc_html_e('Reservieren', 'cafe-herzberg'); ?></a>
</nav>

<main id="main-content">
<?php

/** Fallback-Navigation wenn kein Menü gesetzt */
function herzberg_fallback_nav() {
    echo '<ul role="list" class="nav-links">';
    echo '<li><a href="#ueber-uns">Über uns</a></li>';
    echo '<li><a href="#speisekarte">Speisekarte</a></li>';
    echo '<li><a href="#galerie">Galerie</a></li>';
    echo '<li><a href="#kontakt">Kontakt</a></li>';
    echo '</ul>';
}
