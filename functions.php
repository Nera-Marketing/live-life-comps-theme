<?php
/**
 * Live Life Prizes — child theme bootstrap
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once get_stylesheet_directory() . '/inc/icons.php';
require_once get_stylesheet_directory() . '/inc/payment-logos-llp.php';
require_once get_stylesheet_directory() . '/inc/social-platform-icons.php';
require_once get_stylesheet_directory() . '/inc/how-it-works-llp.php';
require_once get_stylesheet_directory() . '/inc/acf-how-it-works-llp.php';
require_once get_stylesheet_directory() . '/inc/acf-marquee.php';
require_once get_stylesheet_directory() . '/inc/acf-header.php';
require_once get_stylesheet_directory() . '/inc/acf-woocommerce-filter.php';
require_once get_stylesheet_directory() . '/inc/acf-homepage.php';
require_once get_stylesheet_directory() . '/inc/homepage-acf-source.php';
require_once get_stylesheet_directory() . '/inc/about-us-acf-source.php';
require_once get_stylesheet_directory() . '/inc/acf-faq-page.php';
require_once get_stylesheet_directory() . '/inc/acf-about-us-llp.php';
require_once get_stylesheet_directory() . '/inc/acf-contact-llp.php';
require_once get_stylesheet_directory() . '/inc/contact-llp.php';
require_once get_stylesheet_directory() . '/inc/footer-helpers.php';
require_once get_stylesheet_directory() . '/inc/footer-widgets-seed.php';
require_once get_stylesheet_directory() . '/inc/lfw-winners-data.php';
require_once get_stylesheet_directory() . '/inc/winners-dynamic.php';
require_once get_stylesheet_directory() . '/inc/page-seed.php';

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

/**
 * Rotating earthy palette for product_cat slugs not in live_life_prizes_category_colors().
 * Keeps Alpine filter chips off the parent fallback `#1313ec`.
 *
 * @return string[]
 */
function live_life_prizes_earthy_category_palette(): array
{
    return [
        '#9b5039',
        '#c4704e',
        '#d8b582',
        '#b89a6a',
        '#a87d52',
        '#8b5a3c',
        '#7d6b4e',
        '#c9a87c',
    ];
}

/**
 * Full slug → hex map: fixed brand mappings plus every active product_cat term (stable assignment).
 *
 * @return array<string, string>
 */
function live_life_prizes_category_colors_for_all_terms(): array
{
    $base = live_life_prizes_category_colors();
    $palette = live_life_prizes_earthy_category_palette();
    $terms = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'exclude' => get_option('default_product_cat'),
    ]);
    if (empty($terms) || is_wp_error($terms)) {
        return $base;
    }

    $slugs = [];
    foreach ($terms as $term) {
        $slugs[] = $term->slug;
    }
    sort($slugs, SORT_STRING);

    $missing = [];
    foreach ($slugs as $slug) {
        if (!isset($base[$slug])) {
            $missing[] = $slug;
        }
    }

    $out = $base;
    foreach ($missing as $i => $slug) {
        $out[$slug] = $palette[$i % count($palette)];
    }

    return $out;
}

/**
 * Hex background for blog post category pills (matches competition-card slug→color rules).
 *
 * @param string $slug Post category slug (e.g. `uncategorized`).
 */
function live_life_prizes_post_category_badge_color(string $slug): string
{
    if ($slug === 'uncategorized') {
        return apply_filters('nera_competition_card_fallback_accent', '#9b5039');
    }

    $map = live_life_prizes_category_colors_for_all_terms();
    if (isset($map[$slug])) {
        return $map[$slug];
    }

    $palette = live_life_prizes_earthy_category_palette();
    $n = count($palette);
    if ($n < 1) {
        return apply_filters('nera_competition_card_fallback_accent', '#9b5039');
    }

    return $palette[abs(crc32($slug)) % $n];
}

add_filter('nera_competition_card_category_colors', function (): array {
    return live_life_prizes_category_colors_for_all_terms();
});

add_filter('nera_advanced_filter_category_colors', function (): array {
    return live_life_prizes_category_colors_for_all_terms();
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
    $path = get_stylesheet_directory() . '/assets/css/marquee-banner.css';
    if (!is_readable($path)) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }

    wp_enqueue_style(
        'live-life-prizes-marquee-banner',
        get_stylesheet_directory_uri() . '/assets/css/marquee-banner.css',
        [$dep],
        (string) filemtime($path),
    );
}, 105);

/**
 * How It Works page — style WYSIWYG links inside hero step title/description.
 */
add_action('wp_enqueue_scripts', function (): void {
    if (!is_page_template('page-templates/how-it-works-template.php')) {
        return;
    }

    $path = get_stylesheet_directory() . '/assets/css/how-it-works.css';
    if (!is_readable($path)) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }

    wp_enqueue_style(
        'live-life-prizes-how-it-works',
        get_stylesheet_directory_uri() . '/assets/css/how-it-works.css',
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
 * My Account dashboard welcome subtitle.
 */
add_filter(
    'gettext_nera-competitions-standard',
    static function (string $translation, string $text): string {
        if ($text === 'Ready to win big? Check out our latest competitions!') {
            return 'Life is full of possibilities. Enter now for your chance to win';
        }

        return $translation;
    },
    10,
    2,
);

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

    $path = get_stylesheet_directory() . '/assets/css/account-brand-overrides.css';
    if (!is_readable($path)) {
        return;
    }

    wp_enqueue_style(
        'live-life-prizes-account-brand',
        get_stylesheet_directory_uri() . '/assets/css/account-brand-overrides.css',
        [$dep],
        (string) filemtime($path),
    );
}, 110);

/**
 * Cart / Checkout / My Account hero strips + account shell (earthy tokens).
 */
add_action('wp_enqueue_scripts', function (): void {
    $on_cart = function_exists('is_cart') && is_cart();
    $on_order_received = function_exists('is_order_received_page') && is_order_received_page();
    $on_checkout = function_exists('is_checkout') && is_checkout() && !$on_order_received;
    $on_account = function_exists('is_account_page') && is_account_page();
    if (!$on_cart && !$on_checkout && !$on_account && !$on_order_received) {
        return;
    }

    $path = get_stylesheet_directory() . '/assets/css/woo-hero-earthy-overrides.css';
    if (!is_readable($path)) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }
    $deps = [$dep];
    if ($on_account && wp_style_is('live-life-prizes-account-brand', 'enqueued')) {
        $deps[] = 'live-life-prizes-account-brand';
    }

    wp_enqueue_style(
        'live-life-prizes-woo-hero-earthy',
        get_stylesheet_directory_uri() . '/assets/css/woo-hero-earthy-overrides.css',
        $deps,
        (string) filemtime($path),
    );
}, 115);

/**
 * Footer — UK layout + bronze/dark styling (loads after child Vite tokens).
 */
add_action('wp_enqueue_scripts', function (): void {
    $path = get_stylesheet_directory() . '/assets/css/footer-live-life.css';
    if (!is_readable($path)) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }

    wp_enqueue_style(
        'live-life-prizes-footer',
        get_stylesheet_directory_uri() . '/assets/css/footer-live-life.css',
        [$dep],
        (string) filemtime($path),
    );

    $js_path = get_stylesheet_directory() . '/assets/js/footer-brand-social-align.js';
    if (is_readable($js_path)) {
        wp_enqueue_script(
            'live-life-prizes-footer-social-align',
            get_stylesheet_directory_uri() . '/assets/js/footer-brand-social-align.js',
            [],
            (string) filemtime($js_path),
            true,
        );
    }
}, 119);

/**
 * Checkout: payment methods + wallet balance earthy surfaces (beats parent #fff rules).
 */
add_action('wp_enqueue_scripts', function (): void {
    if (!function_exists('is_checkout') || !is_checkout()) {
        return;
    }
    if (function_exists('is_order_received_page') && is_order_received_page()) {
        return;
    }

    $path = get_stylesheet_directory() . '/assets/css/checkout-wallet-earthy-overrides.css';
    if (!is_readable($path)) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }

    wp_enqueue_style(
        'live-life-prizes-checkout-wallet-earthy',
        get_stylesheet_directory_uri() . '/assets/css/checkout-wallet-earthy-overrides.css',
        [$dep],
        (string) filemtime($path),
    );
}, 118);

/**
 * Order received: lty-result-screens overlays (draw / win / no-win) — earthy brand tokens.
 */
add_action('wp_enqueue_scripts', function (): void {
    if (!function_exists('is_order_received_page') || !is_order_received_page()) {
        return;
    }

    $path = get_stylesheet_directory() . '/assets/css/result-screens-brand-overrides.css';
    if (!is_readable($path)) {
        return;
    }

    $dep = live_life_prizes_get_last_child_vite_css_handle();
    if ($dep === null) {
        $dep = live_life_prizes_parent_style_dependency();
    }

    wp_enqueue_style(
        'live-life-prizes-result-screens-brand',
        get_stylesheet_directory_uri() . '/assets/css/result-screens-brand-overrides.css',
        [$dep, 'lty-result-screens'],
        (string) filemtime($path),
    );
}, 120);

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

/**
 * My Account wallet badge: replace parent footer script (no inline indigo gradient).
 * Appearance is fully controlled by .wallet-balance-badge in assets/css/account-brand-overrides.css.
 */
add_action('init', function (): void {
    remove_action('wp_footer', 'nera_add_wallet_balance_script', 10);
}, 20);

function live_life_prizes_wallet_balance_badge_script(): void
{
    if (!function_exists('is_account_page') || !is_account_page() || !is_user_logged_in()) {
        return;
    }

    if (
        !function_exists('woo_wallet')
        || !is_object(woo_wallet())
        || !is_object(woo_wallet()->wallet)
    ) {
        return;
    }

    $user_id = get_current_user_id();
    $balance = (float) woo_wallet()->wallet->get_wallet_balance($user_id, 'edit');
    if ($balance <= 0) {
        return;
    }

    $currency_symbol = html_entity_decode(get_woocommerce_currency_symbol(), ENT_QUOTES, 'UTF-8');
    $formatted_balance = number_format($balance, 2);
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var walletMenuItem = document.querySelector('.woocommerce-MyAccount-navigation-link--woo-wallet a');
  if (walletMenuItem && !walletMenuItem.querySelector('.wallet-balance-badge')) {
    var badge = document.createElement('span');
    badge.className = 'wallet-balance-badge';
    badge.textContent = <?php echo wp_json_encode($currency_symbol . $formatted_balance); ?>;
    badge.style.cssText = 'display:inline-flex;align-items:center;justify-content:center;padding:2px 8px;margin-left:8px;border-radius:12px;font-size:11px;font-weight:700;vertical-align:middle;';
    walletMenuItem.appendChild(badge);
  }
});
</script>
    <?php
}
add_action('wp_footer', 'live_life_prizes_wallet_balance_badge_script', 25);

/**
 * Disable parent theme virtual route /competition-website-by-nera-marketing/ (Live Life Prizes only).
 */
add_action(
    'after_setup_theme',
    static function (): void {
        if (!function_exists('nera_register_attribution_route')) {
            return;
        }

        remove_action('init', 'nera_register_attribution_route');
        remove_action('init', 'nera_maybe_flush_attribution_rewrites', 20);
        remove_filter('query_vars', 'nera_register_attribution_query_var');
        remove_filter('template_include', 'nera_maybe_load_attribution_template', 99);
        remove_filter('pre_get_document_title', 'nera_attribution_document_title');
    },
    100,
);

/**
 * Rebuild rewrite rules once so the removed attribution slug does not keep matching from the DB cache.
 */
add_action(
    'init',
    static function (): void {
        if (get_option('live_life_prizes_attribution_route_disabled_flush_v1')) {
            return;
        }

        flush_rewrite_rules(false);
        update_option('live_life_prizes_attribution_route_disabled_flush_v1', 1, true);
    },
    99,
);
