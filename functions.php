<?php
/**
 * Live Life Prizes — child theme bootstrap
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once get_stylesheet_directory() . '/inc/acf-marquee.php';

/**
 * Last registered parent production Vite CSS handle (nera-vite-css-0, nera-vite-css-1, …).
 */
function live_life_prizes_get_parent_vite_css_handle(): ?string
{
    global $wp_styles;
    if (!$wp_styles instanceof WP_Styles) {
        return null;
    }

    $max_index = -1;
    foreach (array_keys($wp_styles->registered) as $handle) {
        if (preg_match('/^nera-vite-css-(\d+)$/', (string) $handle, $m)) {
            $max_index = max($max_index, (int) $m[1]);
        }
    }

    if ($max_index < 0) {
        return null;
    }

    return 'nera-vite-css-' . $max_index;
}

/**
 * Dependency handle: parent Vite CSS after registration, else child style.css chain via nera-style.
 */
function live_life_prizes_parent_style_dependency(): string
{
    return live_life_prizes_get_parent_vite_css_handle() ?? 'nera-style';
}

/**
 * Category slug → hex for competition cards and advanced filter (single source).
 *
 * @return array<string, string>
 */
function live_life_prizes_category_colors(): array
{
    return [
        'cars' => '#c4704e',
        'cash' => '#d8b582',
        'luxury' => '#9b5039',
        'electronics' => '#b89a6a',
        'travel' => '#c9a87c',
        'tech' => '#a87d52',
        'gadgets' => '#8b5a3c',
        'watches' => '#e0c9a0',
        'lifestyle' => '#7d6b4e',
    ];
}

add_filter('nera_competition_card_category_colors', function (): array {
    return live_life_prizes_category_colors();
});

add_filter('nera_advanced_filter_category_colors', function (): array {
    return live_life_prizes_category_colors();
});

add_filter('nera_competition_card_fallback_accent', function (): string {
    return '#9b5039';
});

/**
 * Google fonts used by child @theme (--font-heading, --font-body).
 */
add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_style(
        'live-life-prizes-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400;1,500&display=swap',
        [],
        null,
    );
}, 15);

/**
 * Marquee banner animation (parent Tailwind bundle does not include marquee keyframes).
 */
add_action('wp_enqueue_scripts', function (): void {
    $path = get_stylesheet_directory() . '/marquee-banner.css';
    if (!is_readable($path)) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }

    wp_enqueue_style(
        'live-life-prizes-marquee-banner',
        get_stylesheet_directory_uri() . '/marquee-banner.css',
        [$dep],
        (string) filemtime($path),
    );
}, 105);

/**
 * Last child Vite CSS handle from manifest (for dependent stylesheets).
 */
function live_life_prizes_get_last_child_vite_css_handle(): ?string
{
    $manifest_path = get_stylesheet_directory() . '/frontend/dist/.vite/manifest.json';
    if (!is_readable($manifest_path)) {
        return null;
    }

    $json = file_get_contents($manifest_path);
    if ($json === false) {
        return null;
    }

    $manifest = json_decode($json, true);
    if (!is_array($manifest)) {
        return null;
    }

    $entry = null;
    foreach ($manifest as $key => $chunk) {
        if (!is_array($chunk) || empty($chunk['isEntry'])) {
            continue;
        }
        if (($chunk['src'] ?? '') === 'src/main.js' || $key === 'src/main.js') {
            $entry = $chunk;
            break;
        }
    }

    if ($entry === null) {
        foreach ($manifest as $chunk) {
            if (is_array($chunk) && !empty($chunk['isEntry']) && isset($chunk['file']) && str_ends_with((string) $chunk['file'], '.js')) {
                $src = (string) ($chunk['src'] ?? '');
                if ($src === 'src/main.js' || str_ends_with($src, '/main.js')) {
                    $entry = $chunk;
                    break;
                }
            }
        }
    }

    if ($entry === null || empty($entry['css']) || !is_array($entry['css'])) {
        return null;
    }

    $count = count($entry['css']);

    return 'live-life-prizes-vite-css-' . ($count - 1);
}

/**
 * My Account + wallet badge: override parent wp_head indigo / white chrome.
 */
add_action('wp_enqueue_scripts', function (): void {
    if (!function_exists('is_account_page') || !is_account_page()) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }

    $path = get_stylesheet_directory() . '/account-brand-overrides.css';
    if (!is_readable($path)) {
        return;
    }

    wp_enqueue_style(
        'live-life-prizes-account-brand',
        get_stylesheet_directory_uri() . '/account-brand-overrides.css',
        [$dep],
        (string) filemtime($path),
    );
}, 110);

/**
 * Enqueue child Vite build (CSS + JS) from manifest, after parent Tailwind bundle.
 */
add_action('wp_enqueue_scripts', function (): void {
    $manifest_path = get_stylesheet_directory() . '/frontend/dist/.vite/manifest.json';
    if (!is_readable($manifest_path)) {
        return;
    }

    $json = file_get_contents($manifest_path);
    if ($json === false) {
        return;
    }

    $manifest = json_decode($json, true);
    if (!is_array($manifest)) {
        return;
    }

    $entry = null;
    foreach ($manifest as $key => $chunk) {
        if (!is_array($chunk) || empty($chunk['isEntry'])) {
            continue;
        }
        if (($chunk['src'] ?? '') === 'src/main.js' || $key === 'src/main.js') {
            $entry = $chunk;
            break;
        }
    }

    if ($entry === null) {
        foreach ($manifest as $key => $chunk) {
            if (is_array($chunk) && !empty($chunk['isEntry']) && isset($chunk['file']) && str_ends_with((string) $chunk['file'], '.js')) {
                $src = (string) ($chunk['src'] ?? '');
                if ($src === 'src/main.js' || str_ends_with($src, '/main.js')) {
                    $entry = $chunk;
                    break;
                }
            }
        }
    }

    if ($entry === null || empty($entry['file'])) {
        return;
    }

    $dist_uri = get_stylesheet_directory_uri() . '/frontend/dist';
    $dist_path = get_stylesheet_directory() . '/frontend/dist';
    $ver = is_readable($dist_path . '/' . $entry['file'])
        ? (string) filemtime($dist_path . '/' . $entry['file'])
        : (string) wp_get_theme()->get('Version');

    $parent_dep = live_life_prizes_parent_style_dependency();
    $prev_style_dep = $parent_dep;

    if (!empty($entry['css']) && is_array($entry['css'])) {
        foreach ($entry['css'] as $index => $css_rel) {
            $css_rel = (string) $css_rel;
            if ($css_rel === '') {
                continue;
            }
            $handle = 'live-life-prizes-vite-css-' . (int) $index;
            wp_enqueue_style(
                $handle,
                $dist_uri . '/' . $css_rel,
                [$prev_style_dep],
                $ver,
            );
            $prev_style_dep = $handle;
        }
    }

    // Script $deps must be script handles only — not styles. Load after parent Vite bundle when present.
    $script_deps = [];
    if (wp_script_is('nera-vite-main', 'registered')) {
        $script_deps[] = 'nera-vite-main';
    }

    wp_enqueue_script(
        'live-life-prizes-main',
        $dist_uri . '/' . $entry['file'],
        $script_deps,
        $ver,
        true,
    );
}, 100);
