<?php
defined('ABSPATH') || exit;

function herzberg_setup() {
    load_theme_textdomain('cafe-herzberg', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('custom-logo', ['height' => 100, 'width' => 100, 'flex-width' => true, 'flex-height' => true]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('elementor');
    register_nav_menus(['primary' => 'Hauptnavigation', 'footer' => 'Footer-Navigation']);
}
add_action('after_setup_theme', 'herzberg_setup');

function herzberg_register_elementor_locations($manager) {
    $manager->register_all_core_location();
}
add_action('elementor/theme/register_locations', 'herzberg_register_elementor_locations');

function herzberg_enqueue_assets() {
    $ver = '1.0.1';
    $dir = get_template_directory_uri();
    wp_enqueue_style('herzberg-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;500;600;700&display=swap',
        [], null);
    wp_enqueue_style('herzberg-main', get_stylesheet_uri(), ['herzberg-fonts'], $ver);
    wp_enqueue_script('herzberg-main', $dir . '/assets/js/main.js', [], $ver, true);
}
add_action('wp_enqueue_scripts', 'herzberg_enqueue_assets');

// Custom Post Type: Speisekarte
function herzberg_register_speisekarte_cpt() {
    register_post_type('speisekarte', [
        'labels' => [
            'name'               => 'Speisekarte',
            'singular_name'      => 'Gericht',
            'add_new'            => 'Gericht hinzufügen',
            'add_new_item'       => 'Neues Gericht hinzufügen',
            'edit_item'          => 'Gericht bearbeiten',
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

function herzberg_register_speisekarte_taxonomy() {
    register_taxonomy('speisekarte_kategorie', 'speisekarte', [
        'labels'        => ['name' => 'Kategorien', 'singular_name' => 'Kategorie', 'add_new_item' => 'Neue Kategorie', 'edit_item' => 'Kategorie bearbeiten'],
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'speisekarte-kategorie'],
    ]);
}
add_action('init', 'herzberg_register_speisekarte_taxonomy');

function herzberg_speisekarte_meta_boxes() {
    add_meta_box('herzberg_gericht_details', 'Gericht-Details', 'herzberg_gericht_details_callback', 'speisekarte', 'side', 'high');
}
add_action('add_meta_boxes', 'herzberg_speisekarte_meta_boxes');

function herzberg_gericht_details_callback($post) {
    wp_nonce_field('herzberg_gericht_nonce', 'herzberg_gericht_nonce_field');
    $preis = get_post_meta($post->ID, '_herzberg_preis', true);
    $badge = get_post_meta($post->ID, '_herzberg_badge', true);
    ?>
    <p>
        <label for="herzberg_preis"><strong>Preis (z.B. 9,50 €)</strong></label><br>
        <input type="text" id="herzberg_preis" name="herzberg_preis" value="<?php echo esc_attr($preis); ?>" style="width:100%;margin-top:4px">
    </p>
    <p>
        <label for="herzberg_badge"><strong>Badge (optional)</strong></label><br>
        <select id="herzberg_badge" name="herzberg_badge" style="width:100%;margin-top:4px">
            <option value="">— keins —</option>
            <?php foreach (['Beliebt','Vegetarisch','Vegan möglich','Hausrezept','Täglich frisch','Specialty Coffee','Neu'] as $b): ?>
            <option value="<?php echo esc_attr($b); ?>" <?php selected($badge, $b); ?>><?php echo esc_html($b); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <?php
}

function herzberg_save_gericht_meta($post_id) {
    if (!isset($_POST['herzberg_gericht_nonce_field'])) return;
    if (!wp_verify_nonce($_POST['herzberg_gericht_nonce_field'], 'herzberg_gericht_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['herzberg_preis'])) update_post_meta($post_id, '_herzberg_preis', sanitize_text_field($_POST['herzberg_preis']));
    if (isset($_POST['herzberg_badge'])) update_post_meta($post_id, '_herzberg_badge', sanitize_text_field($_POST['herzberg_badge']));
}
add_action('save_post', 'herzberg_save_gericht_meta');

// Customizer
function herzberg_customizer_settings($wp_customize) {
    $wp_customize->add_panel('herzberg_panel', ['title' => 'Café Herzberg Einstellungen', 'priority' => 30]);

    $wp_customize->add_section('herzberg_info', ['title' => 'Kontakt & Adresse', 'panel' => 'herzberg_panel']);
    foreach ([
        'herzberg_adresse'        => ['Adresse',       'Eisenacher Str. 3a, 10777 Berlin-Schöneberg'],
        'herzberg_telefon'        => ['Telefon',        '030 91568905'],
        'herzberg_email'          => ['E-Mail',         'info@cafe-herzberg.de'],
        'herzberg_oeffnung_woche' => ['Mo – Fr',        '08:00 – 18:00 Uhr'],
        'herzberg_oeffnung_wende' => ['Sa – So',        '09:00 – 17:00 Uhr'],
        'herzberg_instagram'      => ['Instagram-URL',  ''],
        'herzberg_facebook'       => ['Facebook-URL',   ''],
    ] as $id => [$label, $default]) {
        $wp_customize->add_setting($id, ['default' => $default, 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh']);
        $wp_customize->add_control($id, ['label' => $label, 'section' => 'herzberg_info', 'type' => 'text']);
    }

    $wp_customize->add_section('herzberg_hero', ['title' => 'Hero-Karussell (3 Slides)', 'panel' => 'herzberg_panel']);
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("herzberg_slide{$i}_bild", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'absint']);
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "herzberg_slide{$i}_bild", ['label' => "Slide {$i}: Hintergrundbild", 'section' => 'herzberg_hero', 'mime_type' => 'image']));
        $wp_customize->add_setting("herzberg_slide{$i}_titel", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("herzberg_slide{$i}_titel", ['label' => "Slide {$i}: Überschrift", 'section' => 'herzberg_hero', 'type' => 'text']);
        $wp_customize->add_setting("herzberg_slide{$i}_sub", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("herzberg_slide{$i}_sub", ['label' => "Slide {$i}: Untertitel", 'section' => 'herzberg_hero', 'type' => 'textarea']);
        $wp_customize->add_setting("herzberg_slide{$i}_cta_text", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("herzberg_slide{$i}_cta_text", ['label' => "Slide {$i}: Button-Text", 'section' => 'herzberg_hero', 'type' => 'text']);
        $wp_customize->add_setting("herzberg_slide{$i}_cta_link", ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw']);
        $wp_customize->add_control("herzberg_slide{$i}_cta_link", ['label' => "Slide {$i}: Button-Ziel", 'section' => 'herzberg_hero', 'type' => 'text']);
    }

    $wp_customize->add_section('herzberg_about', ['title' => 'Über uns', 'panel' => 'herzberg_panel']);
    $wp_customize->add_setting('herzberg_about_text1', ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('herzberg_about_text1', ['label' => 'Erster Absatz', 'section' => 'herzberg_about', 'type' => 'textarea']);
    $wp_customize->add_setting('herzberg_about_text2', ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('herzberg_about_text2', ['label' => 'Zweiter Absatz', 'section' => 'herzberg_about', 'type' => 'textarea']);
    $wp_customize->add_setting('herzberg_about_bild', ['default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'herzberg_about_bild', ['label' => 'Bild', 'section' => 'herzberg_about', 'mime_type' => 'image']));
}
add_action('customize_register', 'herzberg_customizer_settings');

// Helper Functions
function herzberg_get($key, $fallback = '') {
    $val = get_theme_mod($key, $fallback);
    return $val ?: $fallback;
}

function herzberg_slide_image($index, $fallback_url) {
    $id = get_theme_mod("herzberg_slide{$index}_bild");
    if ($id) { $src = wp_get_attachment_image_url($id, 'full'); return $src ?: $fallback_url; }
    return $fallback_url;
}

function herzberg_about_image($fallback_url) {
    $id = get_theme_mod('herzberg_about_bild');
    if ($id) { $src = wp_get_attachment_image_url($id, 'large'); return $src ?: $fallback_url; }
    return $fallback_url;
}

add_filter('document_title_separator', function() { return '—'; });
add_filter('excerpt_length', function() { return 20; });
