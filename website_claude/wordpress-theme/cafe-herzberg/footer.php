</main><!-- /#main-content -->

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-inner">

      <div class="footer-logo">
        <?php if (has_custom_logo()): ?>
          <?php the_custom_logo(); ?>
        <?php else: ?>
          <div class="nav-logo-placeholder" style="width:40px;height:40px;">CH</div>
        <?php endif; ?>
        <span class="footer-brand"><?php bloginfo('name'); ?></span>
      </div>

      <nav class="footer-links" aria-label="<?php esc_attr_e('Footer-Navigation', 'cafe-herzberg'); ?>">
        <?php
        wp_nav_menu([
            'theme_location' => 'footer',
            'container'      => false,
            'fallback_cb'    => 'herzberg_footer_fallback_nav',
            'items_wrap'     => '%3$s',
            'depth'          => 1,
        ]);
        ?>
      </nav>

    </div>
    <p class="footer-copy">
      &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> &middot; Berlin-Schöneberg &middot;
      <?php esc_html_e('Alle Rechte vorbehalten', 'cafe-herzberg'); ?>
    </p>
  </div>
</footer>

<!-- ============================================================
     COOKIE BANNER (DSGVO)
     ============================================================ -->
<div class="cookie-banner" id="cookie-banner" role="dialog" aria-live="polite" aria-label="<?php esc_attr_e('Cookie-Einstellungen', 'cafe-herzberg'); ?>">
  <div class="container">
    <div class="cookie-inner">
      <div class="cookie-text">
        <p>
          <?php esc_html_e('Wir verwenden Cookies, um dir das beste Erlebnis auf unserer Website zu bieten. Mehr dazu in unserer', 'cafe-herzberg'); ?>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('datenschutz'))); ?>">
            <?php esc_html_e('Datenschutzerklärung', 'cafe-herzberg'); ?>
          </a>.
        </p>
      </div>
      <div class="cookie-actions">
        <button class="cookie-btn cookie-btn-minimal" id="cookie-minimal">
          <?php esc_html_e('Nur notwendige', 'cafe-herzberg'); ?>
        </button>
        <button class="cookie-btn cookie-btn-accept" id="cookie-accept">
          <?php esc_html_e('Alle akzeptieren', 'cafe-herzberg'); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>

<?php
function herzberg_footer_fallback_nav() {
    $impressum    = get_permalink(get_page_by_path('impressum'));
    $datenschutz  = get_permalink(get_page_by_path('datenschutz'));
    echo '<a href="' . esc_url($impressum)   . '">Impressum</a>';
    echo '<a href="' . esc_url($datenschutz) . '">Datenschutz</a>';
    echo '<a href="#kontakt">Kontakt</a>';
}
