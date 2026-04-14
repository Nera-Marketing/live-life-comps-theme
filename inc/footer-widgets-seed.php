<?php
/**
 * One-time seed: populate footer-1…footer-4 with Custom HTML + Navigation Menu widgets.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

const LIVE_LIFE_PRIZES_FOOTER_WIDGETS_SEED_VERSION = 1;

/**
 * @return bool True if footer-1…footer-4 all have no widgets assigned.
 */
function live_life_prizes_footer_sidebars_all_empty(): bool
{
    $sidebars = wp_get_sidebars_widgets();
    if (!is_array($sidebars)) {
        return true;
    }

    foreach (['footer-1', 'footer-2', 'footer-3', 'footer-4'] as $id) {
        if (!empty($sidebars[$id]) && is_array($sidebars[$id])) {
            return false;
        }
    }

    return true;
}

/**
 * Next numeric instance id for a widget option (e.g. widget_custom_html).
 */
function live_life_prizes_widget_next_instance_id(string $option_name): int
{
    $opt = get_option($option_name, []);
    if (!is_array($opt)) {
        return 1;
    }

    $max = 0;
    foreach (array_keys($opt) as $key) {
        if (is_numeric($key)) {
            $max = max($max, (int) $key);
        }
    }

    return $max + 1;
}

/**
 * Append a custom_html instance and return its full widget id (e.g. custom_html-7).
 */
function live_life_prizes_widget_add_custom_html(string $content, string $title = ''): string
{
    $opt_name = 'widget_custom_html';
    $id = live_life_prizes_widget_next_instance_id($opt_name);
    $widgets = get_option($opt_name, []);
    if (!is_array($widgets)) {
        $widgets = [];
    }

    $widgets[$id] = [
        'title' => $title,
        'content' => $content,
    ];
    $widgets['_multiwidget'] = 1;
    update_option($opt_name, $widgets);

    return 'custom_html-' . $id;
}

/**
 * Append a nav_menu instance and return its full widget id (e.g. nav_menu-4).
 */
function live_life_prizes_widget_add_nav_menu(int $menu_term_id, string $title = ''): string
{
    $opt_name = 'widget_nav_menu';
    $id = live_life_prizes_widget_next_instance_id($opt_name);
    $widgets = get_option($opt_name, []);
    if (!is_array($widgets)) {
        $widgets = [];
    }

    $widgets[$id] = [
        'title' => $title,
        'nav_menu' => $menu_term_id,
    ];
    $widgets['_multiwidget'] = 1;
    update_option($opt_name, $widgets);

    return 'nav_menu-' . $id;
}

/**
 * Assign widget ids to a sidebar (preserves other sidebars).
 *
 * @param string[] $widget_ids
 */
function live_life_prizes_sidebar_set_widgets(string $sidebar_id, array $widget_ids): void
{
    $sidebars = get_option('sidebars_widgets', []);
    if (!is_array($sidebars)) {
        $sidebars = [];
    }

    $sidebars[$sidebar_id] = $widget_ids;
    update_option('sidebars_widgets', $sidebars);
}

/**
 * Seed footer widgets once (empty footers only).
 */
function live_life_prizes_maybe_seed_footer_widgets(): void
{
    if ((int) get_option('live_life_prizes_footer_widgets_seed_version', 0) >= LIVE_LIFE_PRIZES_FOOTER_WIDGETS_SEED_VERSION) {
        return;
    }

    if (!live_life_prizes_footer_sidebars_all_empty()) {
        return;
    }

    if (!function_exists('live_life_prizes_footer_brand_html_string')) {
        return;
    }

    $brand_html = live_life_prizes_footer_brand_html_string();
    if ($brand_html !== '') {
        $w1 = [live_life_prizes_widget_add_custom_html($brand_html, '')];
        live_life_prizes_sidebar_set_widgets('footer-1', $w1);
    }

    $locations = get_nav_menu_locations();
    $primary_id = isset($locations['primary-menu']) ? (int) $locations['primary-menu'] : 0;
    if ($primary_id > 0) {
        $h = '<div class="footer-widget widget_block"><h4 class="wp-block-heading llp-footer-heading">'
            . esc_html__('Discover', 'live-life-prizes')
            . '</h4></div><div class="footer-widget widget_block" aria-hidden="true"><div class="wp-block-spacer" style="height:15px"></div></div>';
        $ids = [
            live_life_prizes_widget_add_custom_html($h, ''),
            live_life_prizes_widget_add_nav_menu($primary_id, ''),
        ];
        live_life_prizes_sidebar_set_widgets('footer-2', $ids);
    }

    $m3 = wp_get_nav_menu_object('footer-menu-3');
    if ($m3 && !is_wp_error($m3)) {
        $tid = (int) $m3->term_id;
        if ($tid > 0) {
            $h = '<div class="footer-widget widget_block"><h4 class="wp-block-heading llp-footer-heading">'
                . esc_html__('Good To Know', 'live-life-prizes')
                . '</h4></div><div class="footer-widget widget_block" aria-hidden="true"><div class="wp-block-spacer" style="height:15px"></div></div>';
            $ids = [
                live_life_prizes_widget_add_custom_html($h, ''),
                live_life_prizes_widget_add_nav_menu($tid, ''),
            ];
            live_life_prizes_sidebar_set_widgets('footer-3', $ids);
        }
    }

    $m4 = wp_get_nav_menu_object('footer-menu-4');
    if ($m4 && !is_wp_error($m4)) {
        $tid = (int) $m4->term_id;
        if ($tid > 0) {
            $items = wp_get_nav_menu_items($tid);
            if (!empty($items)) {
                $h = '<div class="footer-widget widget_block"><h4 class="wp-block-heading llp-footer-heading">'
                    . esc_html__('Legal', 'live-life-prizes')
                    . '</h4></div>';
                $ids = [
                    live_life_prizes_widget_add_custom_html($h, ''),
                    live_life_prizes_widget_add_nav_menu($tid, ''),
                ];
                live_life_prizes_sidebar_set_widgets('footer-4', $ids);
            }
        }
    }

    update_option('live_life_prizes_footer_widgets_seed_version', LIVE_LIFE_PRIZES_FOOTER_WIDGETS_SEED_VERSION);
}

/**
 * Bootstrap hooks for seeding.
 */
function live_life_prizes_footer_widgets_seed_bootstrap(): void
{
    add_action('after_switch_theme', static function (): void {
        if (get_option('stylesheet') !== 'live-life-prizes') {
            return;
        }
        live_life_prizes_maybe_seed_footer_widgets();
    });

    add_action('admin_init', static function (): void {
        if (!current_user_can('edit_theme_options')) {
            return;
        }
        live_life_prizes_maybe_seed_footer_widgets();
    }, 30);
}

live_life_prizes_footer_widgets_seed_bootstrap();
