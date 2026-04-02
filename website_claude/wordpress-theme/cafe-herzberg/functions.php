<?php
/**
 * Café Herzberg — functions.php
 * Theme-Setup, Customizer, Custom Post Type Speisekarte, Elementor Pro Support
 */

defined('ABSPATH') || exit;

/* ============================================================
   1. THEME SETUP
   ============================================================ */
function herzberg_setup() {
    load_theme_textdomain('cafe-herzberg', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 100,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    add_theme_support('customize-selective-refresh-widgets');

    // Elementor Pro: Theme Builder (Header/Footer/Single)
    add_theme_support('elementor');

    register_nav_menus([
        'primary' => __('Hauptnavigation', 'cafe-herzberg'),
        'footer'  => __('Footer-Navigation', 'cafe-herzberg'),
    ]);
}
add_action('after_setup_theme', 'herzberg_setup');

/* ============================================================
   2. ELEMENTOR PRO — LOCATION SUPPORT
   ============================================================ */
function herzberg_register_elementor_locations($manager) {
    $manager->register_all_core_location();
}
add_action('elementor/theme/register_locations', 'herzberg_register_elementor_locations');

/* ============================================================
   3. SCRIPTS & STYLES
   ============================================================ */
function herzberg_enqueue_assets() {
    $ver = '1.0.0';
    $dir = get_template_directory_uri();

    // Google Fonts
    wp_enqueue_style(
        'herzberg-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;500;600;700&display=swap',
        [],
        null
    );

    // Main CSS
    wp_enqueue_style('herzberg-main', $dir . '/assets/css/main.css', ['herzberg-fonts'], $ver);

    // Main JS (defer)
    wp_enqueue_script('herzberg-main', $dir . '/assets/js/main.js', [], $ver, true);
}
add_action('wp_enqueue_scripts', 'herzberg_enqueue_assets');

/* ============================================================
   4. CUSTOM POST TYPE: SPEISEKARTE
   ============================================================ */
function herzberg_register_speisekarte_cpt() {
    register_post_type('speisekarte', [
        'labels' => [
            'name'               => 'Speisekarte',
            'singular_name'      => 'Gericht',
            'add_new'            => 'Gericht hinzufügen',
            'add_new_item'       => 'Neues Gericht hinzufügen',
            'edit_item'          => 'Gericht bearbeiten',
            'new_item'           => 'Neues Gericht',
            'view_item'          => 'Gericht ansehen',
            'search_items'       => 'Gerichte suchen',
            'not_found'          => 'Keine Gerichte gefunden',
            'not_found_in_trash' => 'Keine Gerichte im Papierkorb',
            'menu_name'          => 'Speisekarte',
        ],
        'public'       => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-food',
        'supports'     => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'speisekarte'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'herzberg_register_speisekarte_cpt');

// Taxonomie: Speisekarte-Kategorien
function herzberg_register_speisekarte_taxonomy() {
    register_taxonomy('speisekarte_kategorie', 'speisekarte', [
        'labels' => [
            'name'          => 'Kategorien',
            'singular_name' => 'Kategorie',
            'add_new_item'  => 'Neue Kategorie hinzufügen',
            'edit_item'     => 'Kategorie bearbeiten',
        ],
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'speisekarte-kategorie'],
    ]);
}
add_action('init', 'herzberg_register_speisekarte_taxonomy');

// Meta-Box: Preis & Badge
function herzberg_speisekarte_meta_boxes() {
    add_meta_box(
        'herzberg_gericht_details',
        'Gericht-Details',
        'herzberg_gericht_details_callback',
        'speisekarte',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'herzberg_speisekarte_meta_boxes');

function herzberg_gericht_details_callback($post) {
    wp_nonce_field('herzberg_gericht_nonce', 'herzberg_gericht_nonce_field');
    $preis = get_post_meta($post->ID, '_herzberg_preis', true);
    $badge = get_post_meta($post->ID, '_herzberg_badge', true);
    ?>
    <p>
        <label for="herzberg_preis"><strong>Preis (z.B. 9,50 €)</strong></label><br>
        <input type="text" id="herzberg_preis" name="herzberg_preis"
               value="<?php echo esc_attr($preis); ?>"
               style="width:100%;margin-top:4px">
    </p>
    <p>
        <label for="herzberg_badge"><strong>Badge (optional)</strong></label><br>
        <select id="herzberg_badge" name="herzberg_badge" style="width:100%;margin-top:4px">
            <option value="">— keins —</option>
            <?php
            $badges = ['Beliebt','Vegetarisch','Vegan möglich','Hausrezept','Täglich frisch','Specialty Coffee','Neu'];
            foreach ($badges as $b) {
                echo '<option value="' . esc_attr($b) . '"' . selected($badge, $b, false) . '>' . esc_html($b) . '</option>';
            }
            ?>
        </select>
    </p>
    <?php
}

function herzberg_save_gericht_meta($post_id) {
    if (!isset($_POST['herzberg_gericht_nonce_field'])) return;
    if (!wp_verify_nonce($_POST['herzberg_gericht_nonce_field'], 'herzberg_gericht_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['herzberg_preis'])) {
        update_post_meta($post_id, '_herzberg_preis', sanitize_text_field($_POST['herzberg_preis']));
    }
    if (isset($_POST['herzberg_badge'])) {
        update_post_meta($post_id, '_herzberg_badge', sanitize_text_field($_POST['herzberg_badge']));
    }
}
add_action('save_post', 'herzberg_save_gericht_meta');

/* ============================================================
   5. WORDPRESS CUSTOMIZER
   ============================================================ */
function herzberg_customizer_settings($wp_customize) {

    // ── Panel: Café Herzberg ────────────────────────────────
    $wp_customize->add_panel('herzberg_panel', [
        'title'    => 'Café Herzberg Einstellungen',
        'priority' => 30,
    ]);

    /* --- Sektion: Café-Infos --- */
    $wp_customize->add_section('herzberg_info', [
        'title' => 'Kontakt & Adresse',
        'panel' => 'herzberg_panel',
    ]);

    $info_fields = [
        'herzberg_adresse'      => ['label' => 'Adresse',       'default' => 'Eisenacher Str. 3a, 10777 Berlin-Schöneberg'],
        'herzberg_telefon'      => ['label' => 'Telefon',       'default' => '030 91568905'],
        'herzberg_email'        => ['label' => 'E-Mail',        'default' => 'info@cafe-herzberg.de'],
        'herzberg_oeffnung_woche' => ['label' => 'Mo – Fr',     'default' => '08:00 – 18:00 Uhr'],
        'herzberg_oeffnung_wende' => ['label' => 'Sa – So',     'default' => '09:00 – 17:00 Uhr'],
        'herzberg_instagram'    => ['label' => 'Instagram-URL', 'default' => ''],
        'herzberg_facebook'     => ['label' => 'Facebook-URL',  'default' => ''],
    ];

    foreach ($info_fields as $id => $args) {
        $wp_customize->add_setting($id, [
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control($id, [
            'label'   => $args['label'],
            'section' => 'herzberg_info',
            'type'    => 'text',
        ]);
    }

    /* --- Sektion: Hero-Karussell --- */
    $wp_customize->add_section('herzberg_hero', [
        'title' => 'Hero-Karussell (3 Slides)',
        'panel' => 'herzberg_panel',
    ]);

    for ($i = 1; $i <= 3; $i++) {
        // Bild
        $wp_customize->add_setting("herzberg_slide{$i}_bild", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'absint']);
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "herzberg_slide{$i}_bild", [
            'label'     => "Slide {$i}: Hintergrundbild",
            'section'   => 'herzberg_hero',
            'mime_type' => 'image',
        ]));
        // Titel
        $wp_customize->add_setting("herzberg_slide{$i}_titel", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("herzberg_slide{$i}_titel", ['label' => "Slide {$i}: Überschrift", 'section' => 'herzberg_hero', 'type' => 'text']);
        // Untertitel
        $wp_customize->add_setting("herzberg_slide{$i}_sub", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("herzberg_slide{$i}_sub", ['label' => "Slide {$i}: Untertitel", 'section' => 'herzberg_hero', 'type' => 'textarea']);
        // CTA Text
        $wp_customize->add_setting("herzberg_slide{$i}_cta_text", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("herzberg_slide{$i}_cta_text", ['label' => "Slide {$i}: Button-Text", 'section' => 'herzberg_hero', 'type' => 'text']);
        // CTA Link
        $wp_customize->add_setting("herzberg_slide{$i}_cta_link", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw']);
        $wp_customize->add_control("herzberg_slide{$i}_cta_link", ['label' => "Slide {$i}: Button-Ziel (URL oder #anchor)", 'section' => 'herzberg_hero', 'type' => 'text']);
    }

    /* --- Sektion: Über uns --- */
    $wp_customize->add_section('herzberg_about', [
        'title' => 'Über uns',
        'panel' => 'herzberg_panel',
    ]);

    $wp_customize->add_setting('herzberg_about_text1', ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('herzberg_about_text1', ['label' => 'Erster Absatz', 'section' => 'herzberg_about', 'type' => 'textarea']);

    $wp_customize->add_setting('herzberg_about_text2', ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('herzberg_about_text2', ['label' => 'Zweiter Absatz', 'section' => 'herzberg_about', 'type' => 'textarea']);

    $wp_customize->add_setting('herzberg_about_bild', ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'herzberg_about_bild', [
        'label'     => 'Bild',
        'section'   => 'herzberg_about',
        'mime_type' => 'image',
    ]));
}
add_action('customize_register', 'herzberg_customizer_settings');

/* ============================================================
   6. HELPER FUNCTIONS
   ============================================================ */

/** Gibt Customizer-Wert mit Fallback zurück */
function herzberg_get($key, $fallback = '') {
    $val = get_theme_mod($key, $fallback);
    return $val ?: $fallback;
}

/** Gibt Slide-Bild-URL zurück (Customizer → Unsplash-Fallback) */
function herzberg_slide_image($index, $fallback_url) {
    $id = get_theme_mod("herzberg_slide{$index}_bild");
    if ($id) {
        $src = wp_get_attachment_image_url($id, 'full');
        return $src ?: $fallback_url;
    }
    return $fallback_url;
}

/** Gibt About-Bild-URL zurück */
function herzberg_about_image($fallback_url) {
    $id = get_theme_mod('herzberg_about_bild');
    if ($id) {
        $src = wp_get_attachment_image_url($id, 'large');
        return $src ?: $fallback_url;
    }
    return $fallback_url;
}

/* ============================================================
   7. DOCUMENT TITLE
   ============================================================ */
add_filter('document_title_separator', function() { return '—'; });

/* ============================================================
   8. EXCERPT LENGTH
   ============================================================ */
add_filter('excerpt_length', function() { return 20; });
