<?php
/**
 * Homepage-Template
 * Wenn Elementor Pro aktiv ist und ein Template zugewiesen wurde, übernimmt Elementor.
 * Sonst wird diese PHP-Vorlage gerendert.
 */

// Elementor Pro: Theme Builder übernimmt wenn vorhanden
if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('single')) {
    get_header();
    get_footer();
    return;
}

get_header();

// Fallback-Bildquellen (Unsplash) — werden durch Customizer-Bilder ersetzt
$slide_fallbacks = [
    1 => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1600&q=80&auto=format&fit=crop',
    2 => 'https://images.unsplash.com/photo-1559925393-8be0ec4767c8?w=1600&q=80&auto=format&fit=crop',
    3 => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=1600&q=80&auto=format&fit=crop',
];

$slides = [];
for ($i = 1; $i <= 3; $i++) {
    $slides[$i] = [
        'bild'     => herzberg_slide_image($i, $slide_fallbacks[$i]),
        'titel'    => herzberg_get("herzberg_slide{$i}_titel"),
        'sub'      => herzberg_get("herzberg_slide{$i}_sub"),
        'cta_text' => herzberg_get("herzberg_slide{$i}_cta_text"),
        'cta_link' => herzberg_get("herzberg_slide{$i}_cta_link", '#speisekarte'),
    ];
}

// Defaults wenn Customizer noch nicht befüllt
if (!$slides[1]['titel']) $slides[1] = array_merge($slides[1], ['titel' => 'Guten Morgen, Schöneberg.', 'sub' => 'Starte deinen Tag mit frischem Frühstück, duftendem Kaffee und einem Ort, der sich sofort wie zuhause anfühlt.', 'cta_text' => 'Zur Speisekarte →', 'cta_link' => '#speisekarte']);
if (!$slides[2]['titel']) $slides[2] = array_merge($slides[2], ['titel' => 'Frisch. Warm. Täglich.', 'sub' => 'Handgemachte Speisen aus regionalen Zutaten — weil das beste Frühstück das ist, das man mit Zeit genießt.', 'cta_text' => 'Über uns →', 'cta_link' => '#ueber-uns']);
if (!$slides[3]['titel']) $slides[3] = array_merge($slides[3], ['titel' => 'Wo der Tag beginnt.', 'sub' => 'Ein Ort für Morgenrituale, Gespräche und die kleine Auszeit mittendrin — mitten im Herzen von Schöneberg.', 'cta_text' => 'Jetzt reservieren →', 'cta_link' => '#kontakt']);

$about_img = herzberg_about_image(get_template_directory_uri() . '/assets/cafe_innen.jpg');
$about_text1 = herzberg_get('herzberg_about_text1', 'Das Café Herzberg ist mehr als ein Ort zum Frühstücken — es ist ein Zuhause auf Zeit. Seit unserer Eröffnung in Schöneberg empfangen wir jeden Gast so, wie er es verdient: herzlich, entspannt und mit einer Tasse des besten Kaffees im Kiez.');
$about_text2 = herzberg_get('herzberg_about_text2', 'Wir glauben daran, dass der Morgen den Ton für den ganzen Tag setzt. Deshalb verwenden wir nur frische, saisonale Zutaten von lokalen Partnern und backen unser Gebäck täglich frisch.');

// Speisekarte: Kategorien und Gerichte laden
$kategorien = get_terms(['taxonomy' => 'speisekarte_kategorie', 'hide_empty' => false, 'orderby' => 'term_order']);
if (empty($kategorien) || is_wp_error($kategorien)) {
    $kategorien = [];
}
?>

<!-- ── HERO KARUSSELL ─────────────────────────────────────── -->
<section class="hero" aria-label="Hero Karussell">
  <div class="carousel-track" role="region" aria-roledescription="carousel" aria-label="Willkommensbilder">

    <?php foreach ($slides as $i => $slide): ?>
    <div class="carousel-slide <?php echo $i === 1 ? 'active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="Slide <?php echo $i; ?> von 3">
      <img class="slide-bg"
           src="<?php echo esc_url($slide['bild']); ?>"
           alt="<?php echo esc_attr($slide['titel']); ?>"
           <?php echo $i === 1 ? 'loading="eager" fetchpriority="high"' : 'loading="lazy"'; ?>>
      <div class="slide-overlay"></div>
      <div class="slide-content">
        <span class="slide-label">Berlin-Schöneberg</span>
        <h<?php echo $i === 1 ? '1' : '2'; ?> class="slide-title"><?php echo nl2br(esc_html($slide['titel'])); ?></h<?php echo $i === 1 ? '1' : '2'; ?>>
        <p class="slide-sub"><?php echo esc_html($slide['sub']); ?></p>
        <div class="slide-cta">
          <a href="<?php echo esc_url($slide['cta_link']); ?>" class="btn btn-primary"><?php echo esc_html($slide['cta_text']); ?></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

  </div>

  <div class="carousel-dots" role="tablist" aria-label="Karussell-Navigation">
    <?php for ($i = 1; $i <= 3; $i++): ?>
    <button class="carousel-dot <?php echo $i === 1 ? 'active' : ''; ?>" role="tab" aria-selected="<?php echo $i === 1 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $i; ?>"></button>
    <?php endfor; ?>
  </div>
  <div class="carousel-progress" role="presentation"></div>
  <div class="scroll-indicator" aria-hidden="true">
    <div class="scroll-arrow"></div><span>Scroll</span>
  </div>
</section>

<!-- ── ÜBER UNS ──────────────────────────────────────────── -->
<section id="ueber-uns" class="section">
  <div class="container">
    <div class="about-grid">
      <div class="about-image">
        <img src="<?php echo esc_url($about_img); ?>" alt="Café Herzberg Innenansicht" loading="lazy" width="600" height="480">
        <div class="about-badge" aria-label="Seit 2015 in Schöneberg">Seit<br>2015<br>dabei</div>
      </div>
      <div class="about-content">
        <div>
          <span class="section-label">Über uns</span>
          <h2>Ein Café mit Herz<br>mitten in Schöneberg</h2>
          <div class="gold-divider" style="margin:16px 0 0;"></div>
        </div>
        <p><?php echo wp_kses_post($about_text1); ?></p>
        <p><?php echo wp_kses_post($about_text2); ?></p>
        <div class="about-features">
          <div class="about-feature"><div class="about-feature-icon" aria-hidden="true">☕</div><span class="about-feature-text">Specialty Coffee</span></div>
          <div class="about-feature"><div class="about-feature-icon" aria-hidden="true">🌿</div><span class="about-feature-text">Regionale Zutaten</span></div>
          <div class="about-feature"><div class="about-feature-icon" aria-hidden="true">🥐</div><span class="about-feature-text">Täglich frisch gebacken</span></div>
          <div class="about-feature"><div class="about-feature-icon" aria-hidden="true">🐾</div><span class="about-feature-text">Hundefreundlich</span></div>
        </div>
        <a href="#speisekarte" class="btn btn-primary">Unsere Speisekarte →</a>
      </div>
    </div>
  </div>
</section>

<!-- ── SPEISEKARTE ───────────────────────────────────────── -->
<section id="speisekarte" class="section" style="background:var(--color-surface)">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Speisekarte</span>
      <h2>Was wir anbieten</h2>
      <div class="gold-divider"></div>
      <p style="margin-top:16px">Frisch zubereitet, täglich wechselnd — Genuss ohne Kompromisse.</p>
    </div>

    <?php if (!empty($kategorien)): ?>

    <div class="menu-tabs" role="tablist" aria-label="Speisekarte-Kategorien">
      <?php foreach ($kategorien as $k => $kat): ?>
      <button class="menu-tab <?php echo $k === 0 ? 'active' : ''; ?>"
              data-tab="<?php echo esc_attr($kat->slug); ?>"
              role="tab"
              aria-selected="<?php echo $k === 0 ? 'true' : 'false'; ?>"
              aria-controls="menu-<?php echo esc_attr($kat->slug); ?>">
        <?php echo esc_html($kat->name); ?>
      </button>
      <?php endforeach; ?>
    </div>

    <?php foreach ($kategorien as $k => $kat):
        $gerichte = get_posts(['post_type' => 'speisekarte', 'posts_per_page' => -1, 'tax_query' => [['taxonomy' => 'speisekarte_kategorie', 'field' => 'slug', 'terms' => $kat->slug]], 'orderby' => 'menu_order', 'order' => 'ASC']);
    ?>
    <div class="menu-panel <?php echo $k === 0 ? 'active' : ''; ?>" id="menu-<?php echo esc_attr($kat->slug); ?>" role="tabpanel">
      <?php if ($gerichte): foreach ($gerichte as $gericht):
          $preis = get_post_meta($gericht->ID, '_herzberg_preis', true);
          $badge = get_post_meta($gericht->ID, '_herzberg_badge', true);
      ?>
      <div class="menu-card">
        <div class="menu-card-header">
          <span class="menu-card-name"><?php echo esc_html($gericht->post_title); ?></span>
          <?php if ($preis): ?><span class="menu-card-price"><?php echo esc_html($preis); ?></span><?php endif; ?>
        </div>
        <?php if ($gericht->post_content): ?>
        <p class="menu-card-desc"><?php echo esc_html(wp_strip_all_tags($gericht->post_content)); ?></p>
        <?php endif; ?>
        <?php if ($badge): ?><span class="menu-badge"><?php echo esc_html($badge); ?></span><?php endif; ?>
      </div>
      <?php endforeach; else: ?>
      <p style="color:var(--color-muted);grid-column:1/-1">Noch keine Gerichte in dieser Kategorie.</p>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <?php else: ?>
    <!-- Fallback: statische Beispieldaten wenn keine Kategorien angelegt -->
    <p style="text-align:center;color:var(--color-muted)">
      Speisekarte wird gerade aktualisiert — schau bald wieder vorbei!<br>
      <small>(Gerichte können im WordPress-Admin unter "Speisekarte" hinzugefügt werden.)</small>
    </p>
    <?php endif; ?>

  </div>
</section>

<!-- ── GALERIE ───────────────────────────────────────────── -->
<section id="galerie" class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Galerie</span>
      <h2>Einblicke ins Herzberg</h2>
      <div class="gold-divider"></div>
    </div>
    <div class="gallery-grid">
      <?php
      $gallery_images = [
          ['https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=900&q=80&auto=format&fit=crop', 'Gemütliche Café-Atmosphäre'],
          ['https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&q=80&auto=format&fit=crop', 'Frühstücksteller'],
          ['https://images.unsplash.com/photo-1511920170033-f8396924c348?w=600&q=80&auto=format&fit=crop', 'Latte Art'],
          ['https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=900&q=80&auto=format&fit=crop', 'Frisch gebackener Kuchen'],
          ['https://images.unsplash.com/photo-1453614512568-c4024d13c247?w=600&q=80&auto=format&fit=crop', 'Café-Interieur'],
      ];
      foreach ($gallery_images as $img): ?>
      <div class="gallery-item" tabindex="0" role="button" aria-label="<?php echo esc_attr($img[1]); ?> öffnen">
        <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($img[1]); ?>" loading="lazy">
        <div class="gallery-overlay"><span class="gallery-overlay-icon" aria-hidden="true">⊕</span></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Bild-Vollansicht">
  <button class="lightbox-close" id="lightbox-close" aria-label="Schließen">✕</button>
  <img id="lightbox-img" src="" alt="">
</div>

<!-- ── KONTAKT ───────────────────────────────────────────── -->
<section id="kontakt" class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Kontakt</span>
      <h2>Besucht uns</h2>
      <div class="gold-divider"></div>
    </div>
    <div class="contact-grid">
      <div class="contact-info">
        <div class="contact-block">
          <h4>Adresse</h4>
          <p><?php echo nl2br(esc_html(herzberg_get('herzberg_adresse', 'Eisenacher Str. 3a, 10777 Berlin-Schöneberg'))); ?></p>
        </div>
        <div class="contact-block">
          <h4>Öffnungszeiten</h4>
          <div class="hours-grid">
            <span class="hours-day">Mo – Fr</span>
            <span><?php echo esc_html(herzberg_get('herzberg_oeffnung_woche', '08:00 – 18:00 Uhr')); ?></span>
            <span class="hours-day">Sa – So</span>
            <span><?php echo esc_html(herzberg_get('herzberg_oeffnung_wende', '09:00 – 17:00 Uhr')); ?></span>
          </div>
        </div>
        <div class="contact-block">
          <h4>Telefon</h4>
          <?php $tel = herzberg_get('herzberg_telefon', '030 91568905'); ?>
          <a href="tel:+49<?php echo esc_attr(preg_replace('/[^0-9]/', '', ltrim($tel, '0'))); ?>"><?php echo esc_html($tel); ?></a>
        </div>
        <div class="contact-block">
          <h4>E-Mail</h4>
          <?php $email = herzberg_get('herzberg_email', 'info@cafe-herzberg.de'); ?>
          <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
        </div>
        <?php $tel_raw = preg_replace('/[^0-9]/', '', herzberg_get('herzberg_telefon', '030 91568905')); ?>
        <a href="tel:+49<?php echo esc_attr(ltrim($tel_raw, '0')); ?>" class="btn btn-primary">Jetzt anrufen</a>
      </div>
      <div class="map-wrapper">
        <?php $adresse = urlencode(herzberg_get('herzberg_adresse', 'Eisenacher Str. 3a, 10777 Berlin')); ?>
        <iframe
          src="https://maps.google.com/maps?q=<?php echo $adresse; ?>&t=&z=16&ie=UTF8&iwloc=&output=embed"
          loading="lazy"
          allowfullscreen
          referrerpolicy="no-referrer-when-downgrade"
          title="<?php esc_attr_e('Standort Café Herzberg', 'cafe-herzberg'); ?>">
        </iframe>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
