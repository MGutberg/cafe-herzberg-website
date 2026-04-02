<?php
/**
 * Template Name: Impressum
 */
get_header(); ?>

<div class="container">
  <article class="legal-page">
    <h1>Impressum</h1>

    <h2>Angaben gemäß § 5 TMG</h2>
    <p>
      <strong>Café Herzberg</strong><br>
      <?php echo nl2br(esc_html(herzberg_get('herzberg_adresse', 'Eisenacher Str. 3a, 10777 Berlin-Schöneberg'))); ?>
    </p>

    <h2>Kontakt</h2>
    <p>
      Telefon: <a href="tel:+493091568905"><?php echo esc_html(herzberg_get('herzberg_telefon', '030 91568905')); ?></a><br>
      E-Mail: <a href="mailto:<?php echo esc_attr(herzberg_get('herzberg_email', 'info@cafe-herzberg.de')); ?>"><?php echo esc_html(herzberg_get('herzberg_email', 'info@cafe-herzberg.de')); ?></a>
    </p>

    <h2>Vertreten durch</h2>
    <p>[Name des Inhabers / der Inhaberin]</p>

    <h2>Umsatzsteuer-ID</h2>
    <p>DE [Ihre USt-IdNr. hier eintragen]</p>

    <h2>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
    <p>[Name], <?php echo esc_html(herzberg_get('herzberg_adresse', 'Eisenacher Str. 3a, 10777 Berlin')); ?></p>

    <h2>Streitschlichtung</h2>
    <p>Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit:
      <a href="https://ec.europa.eu/consumers/odr/" target="_blank" rel="noopener noreferrer">https://ec.europa.eu/consumers/odr/</a>.
      Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.
    </p>

    <h2>Haftung für Inhalte</h2>
    <p>Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich.</p>

    <h2>Urheberrecht</h2>
    <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht.</p>

    <?php if (have_posts()): while (have_posts()): the_post(); ?>
      <div class="entry-content" style="margin-top:32px"><?php the_content(); ?></div>
    <?php endwhile; endif; ?>

    <p style="margin-top:40px"><a href="<?php echo esc_url(home_url('/')); ?>" style="color:var(--color-gold);font-weight:600;">← Zurück zur Startseite</a></p>
  </article>
</div>

<?php get_footer(); ?>
