</main>

<!-- Cookie Banner -->
<div class="cookie-banner" id="cookie-banner" role="dialog" aria-live="polite" aria-label="Cookie-Einstellungen">
  <div class="container">
    <div class="cookie-inner">
      <div class="cookie-text">
        <p>Wir verwenden Cookies, um dir das beste Erlebnis auf unserer Website zu bieten. Mehr dazu in unserer <a href="<?php echo esc_url(get_permalink(get_page_by_path('datenschutz'))); ?>">Datenschutzerklärung</a>.</p>
      </div>
      <div class="cookie-actions">
        <button class="cookie-btn cookie-btn-minimal" id="cookie-minimal">Nur notwendige</button>
        <button class="cookie-btn cookie-btn-accept"  id="cookie-accept">Alle akzeptieren</button>
      </div>
    </div>
  </div>
</div>

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-inner">
      <div class="footer-logo">
        <?php if (has_custom_logo()):
            $logo_id = get_theme_mod('custom_logo');
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="Café Herzberg" width="40" height="40">
        <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Café Herzberg" width="40" height="40">
        <?php endif; ?>
        <span class="footer-brand">Café Herzberg</span>
      </div>
      <nav class="footer-links" aria-label="Footer-Navigation">
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('impressum'))); ?>">Impressum</a>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('datenschutz'))); ?>">Datenschutz</a>
        <a href="<?php echo esc_url(home_url('/#kontakt')); ?>">Kontakt</a>
      </nav>
    </div>
    <p class="footer-copy">
      &copy; <?php echo date('Y'); ?> Café Herzberg · Berlin-Schöneberg · Alle Rechte vorbehalten
    </p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
