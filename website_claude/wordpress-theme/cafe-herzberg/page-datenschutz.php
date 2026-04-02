<?php
/**
 * Template Name: Datenschutz
 */
get_header(); ?>

<div class="container">
  <article class="legal-page">
    <h1>Datenschutzerklärung</h1>

    <h2>1. Datenschutz auf einen Blick</h2>
    <p>Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren personenbezogenen Daten passiert, wenn Sie diese Website besuchen.</p>

    <h2>2. Verantwortliche Stelle</h2>
    <p>
      Café Herzberg<br>
      <?php echo nl2br(esc_html(herzberg_get('herzberg_adresse', 'Eisenacher Str. 3a, 10777 Berlin-Schöneberg'))); ?><br>
      Telefon: <?php echo esc_html(herzberg_get('herzberg_telefon', '030 91568905')); ?><br>
      E-Mail: <a href="mailto:<?php echo esc_attr(herzberg_get('herzberg_email', 'info@cafe-herzberg.de')); ?>"><?php echo esc_html(herzberg_get('herzberg_email', 'info@cafe-herzberg.de')); ?></a>
    </p>

    <h2>3. Datenerfassung auf dieser Website</h2>
    <h3 style="font-size:1rem;margin:20px 0 8px;font-family:var(--font-sans)">Cookies</h3>
    <p>Diese Website verwendet technisch notwendige Cookies. Ihre Einwilligungsentscheidung wird in <code>localStorage</code> gespeichert und verlässt Ihr Gerät nicht.</p>

    <h3 style="font-size:1rem;margin:20px 0 8px;font-family:var(--font-sans)">Server-Log-Dateien</h3>
    <p>Der Hosting-Anbieter erhebt automatisch Server-Log-Daten (IP-Adresse, Browser, Betriebssystem, Uhrzeit). Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO.</p>

    <h2>4. Google Maps</h2>
    <p>Diese Website nutzt Google Maps. Anbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland. Bei Nutzung kann Ihre IP-Adresse an Google-Server übertragen werden. Mehr Infos: <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">policies.google.com/privacy</a>.</p>

    <h2>5. Google Fonts</h2>
    <p>Diese Seite nutzt Google Fonts zur einheitlichen Schriftdarstellung. Ihr Browser stellt dabei eine Verbindung zu Google-Servern her. Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO.</p>

    <h2>6. Ihre Rechte</h2>
    <p>Sie haben das Recht auf Auskunft (Art. 15), Berichtigung (Art. 16), Löschung (Art. 17), Einschränkung (Art. 18) und Widerspruch (Art. 21) gemäß DSGVO. Wenden Sie sich dazu an uns über die oben genannten Kontaktdaten.</p>

    <?php if (have_posts()): while (have_posts()): the_post(); ?>
      <div class="entry-content" style="margin-top:32px"><?php the_content(); ?></div>
    <?php endwhile; endif; ?>

    <p style="margin-top:40px"><a href="<?php echo esc_url(home_url('/')); ?>" style="color:var(--color-gold);font-weight:600;">← Zurück zur Startseite</a></p>
  </article>
</div>

<?php get_footer(); ?>
